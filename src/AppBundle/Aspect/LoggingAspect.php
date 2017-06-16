<?php

namespace AppBundle\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\After;
use Psr\Log\LoggerInterface;

/**
 * Application logging aspect.
 */
class LoggingAspect implements Aspect
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggingAspect constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     *
     * @param MethodInvocation $invocation
     * @Before("@execution(AppBundle\Annotation\Logable)")
     */
    public function beforeMethod(MethodInvocation $invocation)
    {

        $class = $this->getClass($invocation);
        $this->logger->info("Executing Before " . $class . '->' . $invocation->getMethod()->name, $invocation->getArguments());
    }

    /**
     *
     * @param MethodInvocation $invocation
     * @After("@execution(AppBundle\Annotation\Logable)")
     */
    public function afterMethod(MethodInvocation $invocation)
    {
        $class = $this->getClass($invocation);
        $this->logger->info("Executing Afters" . $class . '->' . $invocation->getMethod()->name, $invocation->getArguments());
    }

    /**
     * @param MethodInvocation $invocation
     * @return object|string
     */
    private function getClass(MethodInvocation $invocation)
    {
        $obj = $invocation->getThis();
        $class = $obj === (object)$obj ? get_class($obj) : $obj;
        return $class;
    }
}
