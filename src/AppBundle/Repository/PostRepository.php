<?php

namespace AppBundle\Repository;

use AppBundle\Entity\Post;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;

/**
 * Class PostRepository
 * @package AppBundle\Repository
 */
class PostRepository extends AOPDrivenRepository
{
    /**
     * @return ArrayCollection|array
     */
    public function findAll()
    {
        return $this->findBy([], ['publishedAt' => 'DESC']);
    }

    /**
     * @param integer $id
     * @return Post
     */
    public function getNext($id)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.id > :id')
            ->setMaxResults(1)
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param integer $id
     * @return Post
     */
    public function getPrev($id)
    {
        return $this->createQueryBuilder('p')
            ->select('p')
            ->where('p.id < :id')
            ->orderBy('p.id', 'DESC')
            ->setMaxResults(1)
            ->setParameter(':id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }
}