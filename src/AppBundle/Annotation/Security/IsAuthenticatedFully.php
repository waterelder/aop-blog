<?php

namespace AppBundle\Annotation\Security;

use Doctrine\Common\Annotations\Annotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class IsAuthenticatedFully extends Annotation
{

}