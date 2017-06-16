<?php

namespace AppBundle\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use JMS\Serializer\Serializer;

use Go\Lang\Annotation\Around;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RestActionAspect
 * @package AppBundle\Aspect
 */
class RestActionAspect implements Aspect
{
    /**
     * @var Serializer
     */
    private $serializer;

    /**
     * RestActionAspect constructor.
     * @param Serializer $serializer
     */
    public function __construct(Serializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     *
     * @param MethodInvocation $invocation
     * @Around("@execution(AppBundle\Annotation\Rest)", order=2)
     * @return Response
     */
    public function serializer(MethodInvocation $invocation)
    {   echo("ser");
        $args = $invocation->getArguments();
        if (count($args) > 0) {
            $invocation->setArguments([$args[0], json_decode($args[0]->getContent(), true)]);
        }
        return new Response($this->serializer->serialize($invocation->proceed(), 'json'));
    }
}