<?php

namespace AppBundle\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use SensioLabs\Security\SecurityChecker;
use Symfony\Component\Routing\RouterInterface;
use Go\Lang\Annotation\Before;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Application security aspect.
 */
class SecurityAspect implements Aspect
{

    /**
     * @var AuthorizationCheckerInterface
     */
    protected $checker;

    /**
     * SecurityAspect constructor.
     * @param SecurityChecker $checker
     */
    public function __construct(AuthorizationCheckerInterface $checker)
    {
        $this->checker = $checker;
    }

    /**
     *
     * @param MethodInvocation $invocation
     * @Before("@execution(AppBundle\Annotation\Security\IsAuthenticatedFully)")
     */
    public function checkAuthentication(MethodInvocation $invocation)
    {
        if (!$this->checker->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw new AccessDeniedException();
        }
    }


}