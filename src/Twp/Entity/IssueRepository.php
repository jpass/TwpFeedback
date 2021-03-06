<?php

namespace Twp\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * IssueRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class IssueRepository extends EntityRepository
{
    public function getTop($firstResult = 0, $maxResult = 5)
    {
        $v = $this->createQueryBuilder('i')
                ->select('i, COUNT(au.id) AS cusers')
                ->leftJoin('i.affectedUsers', 'au')
                ->groupBy('i.id')
                ->orderBy('cusers', 'desc')
                ->setFirstResult($firstResult)
                ->setMaxResults($maxResult)
                ->getQuery()->execute();
        return array_map(function($v){ return $v[0]; }, $v);
    }
    
    public function findOneWthComments($id)
    {
        return $this->createQueryBuilder('i')
                ->select('i, c')
                ->leftJoin('i.comments', 'c')
                ->where('i.id = :id')
                ->setParameter('id', $id)
                ->getQuery()->getOneOrNullResult();
    }
}
