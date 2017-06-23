<?php

namespace AppBundle\Repository;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserRepository
 * @package AppBundle\Repository
 */
class UserRepository extends AOPDrivenRepository implements UserProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByUsername($email)
    {
        return $this->findOneBy(array(
            'email' => $email,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $class === 'AppBundle\Entity\User';
    }
}