<?php
/**
 * Created by PhpStorm.
 * User: lex
 * Date: 19.04.17
 * Time: 15:00.
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\User;

use AppBundle\Enum\UserState;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUsersData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Sets the container.
     *
     * @param ContainerInterface|null $container A ContainerInterface instance or null
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('user@user.ru');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'user');
        $user->setPassword($password);
        $user->setRole('ROLE_USER');
        $user->setName('First User');

        $manager->persist($user);

        $secondUser = new User();
        $secondUser->setEmail('user@user2.ru');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($secondUser, 'user2');
        $secondUser->setPassword($password);
        $secondUser->setRole('ROLE_USER');
        $secondUser->setName('Second User');

        $manager->persist($secondUser);

        $manager->flush();

        $this->addReference('first-user', $user);
        $this->addReference('second-user', $secondUser);
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 1;
    }
}
