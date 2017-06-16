<?php

namespace AppBundle\Controller;

use AppBundle\Controller\BaseController;
use AppBundle\Entity\Post;
use AppBundle\Form\PostType;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Annotation\Rest;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use AppBundle\Entity\User;

/**
 * @Route("api/post")
 */
class RestController extends BaseController
{
    /**
     * @Route("/", name="api_main")
     * @Method("GET")
     * @Rest
     */
    public function showAction()
    {
        return $this->getEm()->getRepository('AppBundle:Post')->findAll();
    }

    /**
     * @Route("/", name="api_register")
     * @Method("POST")
     * @Rest
     */
    public function registerAction(Request $request, $user = null)
    {
        $newUser = new User();
        $form = $this->createForm(UserType::class, $newUser);
        $form->submit($user);
        if (!$form->isValid()) {
            throw new BadRequestHttpException();
        }
        $encoder = $this->get('security.password_encoder');
        $password = $encoder->encodePassword($newUser, $newUser->getPlainPassword());
        $newUser->setPassword($password);
        $newUser->setRole('ROLE_USER');
        $this->getEm()->getRepository('AppBundle:User')->save($newUser);

        return $newUser;
    }

}