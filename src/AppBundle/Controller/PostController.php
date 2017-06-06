<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Form\CommentType;
use AppBundle\Form\PostType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use AppBundle\Annotation\Security\IsAuthenticatedFully;

/**
 * @Route("/post")
 */
class PostController extends BaseController
{
    /**
     * @Route("/{id}",  requirements={"id": "\d+"}, name="show_post")
     * @return Response
     */
    public function showPost($id)
    {
        $post = $this->getEm()->getRepository('AppBundle:Post')->findOneById(['id' => $id]);
        if (!$post) {
            throw new NotFoundHttpException();
        }
        $next = $this->getEm()->getRepository('AppBundle:Post')->getNext($post->getId());
        $prev = $this->getEm()->getRepository('AppBundle:Post')->getPrev($post->getId());

        return $this->render('default/show_post.html.twig', ['post' => $post, 'next' => $next, 'prev' => $prev]);

    }


    /**
     * @Route("/comment/{id}/new", name="comment_new")
     * @Method("POST")
     * @IsAuthenticatedFully
     */
    public function commentNewAction(Request $request, Post $post)
    {
        $comment = new Comment();
        $comment->setAuthor($this->getUser());
        $comment->setPost($post);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();
        }

        return $this->redirectToRoute('show_post', ['id' => $post->getId()]);
    }

    /**
     * @param Post $post
     *
     * @return Response
     */
    public function commentFormAction(Post $post)
    {
        $form = $this->createForm(CommentType::class);

        return $this->render('form/_comment_form.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/new", name="post_new")
     * @Method({"GET", "POST"})
     * @IsAuthenticatedFully
     *
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $post->setAuthor($this->getUser());
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();
            return $this->redirectToRoute('show_post', ['id' => $post->getId()]);
        }

        return $this->render('default/create_post.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
        ]);
    }
}