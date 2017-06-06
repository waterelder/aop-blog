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
        $this->logger->info($invocation, $invocation->getArguments());
    }

    /**
     *
     * @param MethodInvocation $invocation
     * @After("@execution(AppBundle\Annotation\Logable)")
     */
    public function afterMethod(MethodInvocation $invocation)
    {
        $this->logger->info($invocation, $invocation->getArguments());
    }
}
