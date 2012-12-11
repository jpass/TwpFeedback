<?php

namespace Twp\Entity;

use Doctrine\ORM\EntityRepository;

class IdeaRepository extends EntityRepository
{
    public function getTop($firstResult = 0, $maxResult = 5)
    {
        return $this->createQueryBuilder('i')
                ->leftJoin('i.votes', 'v')
                ->groupBy('v.id')
                ->orderBy('v.id')
                ->setFirstResult($firstResult)
                ->setMaxResults($maxResult)
                ->getQuery()->execute();
    }
}