<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class BaseController
 * @package AppBundle\Controller
 */
class BaseController extends Controller
{
    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|object
     */
    public function getEm()
    {
        return $this->getDoctrine()->getManager();
    }
}