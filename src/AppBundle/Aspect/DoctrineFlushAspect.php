<?php

namespace AppBundle\Aspect;

use Doctrine\ORM\EntityManager;
use Go\Aop\Aspect;
use Go\Lang\Annotation\After;
use Go\Aop\Intercept\MethodInvocation;
///Not working!Не цепляется за EntityManager
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
     * @After("execution(public Doctrine\ORM\EntityManager->persist(*))")
     */
    public function detectPersist(MethodInvocation $invocation)
    {
        $this->isNeedFlush = true;
    }


    /**
     *
     * @param MethodInvocation $invocation
     * @After("execution(public Doctrine\ORM\EntityManager->flush(*))")
     */
    public function detectFlush(MethodInvocation $invocation)
    {
        $this->isNeedFlush = false;
    }


    /**
     *
     * @param MethodInvocation $invocation
     * @After("execution(public AppBundle\Controller\*->*Action(*))")
     */
    public function commitTransaction(MethodInvocation $invocation)
    {

        if ($this->isNeedFlush) {
            $this->em->flush();
        }
    }

}