<?php

namespace AppBundle\Aspect;

use Doctrine\ORM\EntityManager;
use Go\Aop\Aspect;
use Go\Lang\Annotation\After;
use Go\Lang\Annotation\Around;
use Go\Aop\Intercept\MethodInvocation;

class DoctrineFlushAspect implements Aspect
{
    /**
     * @var bool
     */
    private $isNeedFlush = false;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * DoctrineFlushAspect constructor.
     * @param EntityManager $em
     */
    public function __construct($em)
    {
        $this->em = $em;
    }


    /**
     *
     * @param MethodInvocation $invocation
     * @After("execution(public AppBundle\Repository\*Repository->save(*))")
     */
    public function detectPersist(MethodInvocation $invocation)
    {
        $this->isNeedFlush = true;
    }


    /**
     *
     * @param MethodInvocation $invocation
     * @After("execution(public AppBundle\Repository\*Repository->flush(*))")
     */
    public function detectFlush(MethodInvocation $invocation)
    {
        $this->isNeedFlush = false;
    }


    /**
     *
     * @param MethodInvocation $invocation
     * @Around("execution(public AppBundle\Controller\*->*Action(*))", order = 1)
     * @return mixed
     */
    public function commitTransaction(MethodInvocation $invocation)
    {
        $data = $invocation->proceed();
        if ($this->isNeedFlush) {
            $this->em->flush();
        }
        return $data;
    }

}