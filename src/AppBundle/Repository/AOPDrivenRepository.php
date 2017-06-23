<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class AOPDrivenRepository
 * @package AppBundle\Repository
 */
class AOPDrivenRepository extends EntityRepository
{
    /**
     * AOP wrapper for "persist" operation
     * @param mixed $entity
     */
    public function save($entity)
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     *  AOP wrapper for "flush" operation
     */
    public function flush()
    {
        $this->getEntityManager()->flush();
    }
}