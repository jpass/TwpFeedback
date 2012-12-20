<?php

namespace Twp\Entity;

use Doctrine\ORM\EntityRepository;

class IdeaRepository extends EntityRepository
{
    public function getTop($firstResult = 0, $maxResult = 5)
    {
        $v = $this->createQueryBuilder('i')
                ->select('i, COUNT(v.id) AS cvotes')
                ->leftJoin('i.votes', 'v')
                ->groupBy('i.id')
                ->orderBy('cvotes', 'desc')
                ->setFirstResult($firstResult)
                ->setMaxResults($maxResult)
                ->getQuery()->execute();
        return array_map(function($v){ return $v[0]; }, $v);
    }
    
    public function findOneWithComments($id)
    {
        return $this->createQueryBuilder('i')
                ->select('i, c')
                ->leftJoin('i.comments', 'c')
                ->where('i.id = :id')
                ->setParameter('id', $id)
                ->getQuery()->getOneOrNullResult();
    }
}