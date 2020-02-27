<?php

namespace houssemBundle\Repository;

use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

/**
 * reactRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class reactRepository extends \Doctrine\ORM\EntityRepository
{
    public function findbyreact($id)
    {
        $Query=$this->getEntityManager()->createQuery(
            "SELECT COUNT(c.id) as nb
             FROM houssemBundle:react as c
             WHERE c.idblog = $id
             AND c.reaction IS NOT NULL
             "

        );


      return $Query->getSingleResult();
    }

    public function findbyreacts($id)
    {
        $Query=$this->getEntityManager()->createQuery(
            "SELECT c.reaction
             FROM houssemBundle:react as c
             WHERE c.idblog = $id"
        )->setMaxResults(1) ;

        return $Query->getArrayResult();
    }
    public function findbyreaction($id)
    {
        $Query=$this->getEntityManager()->createQuery(
            "SELECT c.reaction as re
             FROM houssemBundle:react as c
             WHERE c.idblog = $id
             GROUP BY c.reaction
             "

        );


        return $Query->getArrayResult();
    }

    public function findbycomment($id)
    {
        $Query=$this->getEntityManager()->createQuery(
            "SELECT c.comment , c.user, c.id
             FROM houssemBundle:react as c
             WHERE c.idblog = $id
             AND c.comment IS NOT NULL
             "

        );


        return $Query->getArrayResult();
    }


}
