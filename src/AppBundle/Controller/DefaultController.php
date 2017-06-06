<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Annotation\Logable;

class DefaultController extends BaseController
{

    /**
     * @Route("/", name="main")
     * @return Response
     * @Logable
     */
    public function showAction(Request $request)
    {
        $posts = $this->getEm()->getRepository('AppBundle:Post')->findAll();
        return $this->render('default/index.html.twig', array('posts' => $posts));
    }
}