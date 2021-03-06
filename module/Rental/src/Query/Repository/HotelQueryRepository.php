<?php

namespace Rental\Query\Repository;

use Doctrine\ORM\EntityRepository;

class HotelQueryRepository extends EntityRepository
{
    public function findAll(): array
    {
        $queryBuilder = $this->createQueryBuilder('h')
            ->addSelect('r')
            ->leftJoin('h.rooms', 'r');

        return $queryBuilder->getQuery()->getArrayResult();
    }
}
