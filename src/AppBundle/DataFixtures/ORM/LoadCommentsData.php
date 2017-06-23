<?php

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Comment;
use AppBundle\Entity\UserGroup;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Serializer\Tests\Fixtures\GroupDummyParent;

class LoadCommentsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager.
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $firstComment = new Comment();
        $firstComment->setAuthor($this->getReference('second-user'));
        $firstComment->setPost($this->getReference('first-post'));
        $firstComment->setContent('КГ/АМ');

        $secondComment = new Comment();
        $secondComment->setAuthor($this->getReference('first-user'));
        $secondComment->setPost($this->getReference('second-post'));
        $secondComment->setContent('Not bad');

        $manager->persist($firstComment);
        $manager->persist($secondComment);

        $manager->flush();
    }

    /**
     * Get the order of this fixture.
     *
     * @return int
     */
    public function getOrder()
    {
        return 3;
    }
}
