<?php

namespace Uts\HotelBundle\Repository;

use \Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Uts\HotelBundle\Entity\Meal;
use Doctrine\ORM\Mapping;
use Doctrine\ORM\EntityManager;

class SearchResult extends EntityRepository
{
    public function createQueryForPagination($requestId)
    {
        $qb = $this->createQueryBuilder('self');
        $qb
            ->join('self.hotel', 'hotel')
            ->leftJoin('self.meal', 'meal')
            ->addSelect('hotel')
            ->addSelect('meal')
            ->andWhere('self.request = ?0')
            ->setParameters(array($requestId))
        ;
        return $qb->getQuery();
    }

    private $hotelsByPrice = '
        SELECT
            h.name,
            h.id,
            h.city_id,
            MIN(sr.price) min_price
        FROM hotel h,
            search_result sr
        WHERE h.id = sr.hotel_id AND sr.request_id = :request_id
        GROUP BY h.id
        ORDER BY price
    ';

    private $discountedPrice = '
        COALESCE(
            (SELECT
              MIN(sr.price - IF(so.discountType = \'m\', sr.price * so.discountValue / 100, so.discountValue / c.rate))
            FROM special_offer so, currency c
            WHERE hotels_by_price.id = so.hotel_id
              AND c.code = sr.currency
            ) ,
            (SELECT
              MIN(sr.price - IF(so.discountType = \'m\', sr.price * so.discountValue / 100, so.discountValue / c.rate))
            FROM special_offer so, currency c
            WHERE hotels_by_price.city_id = so.city_id
              AND so.hotel_id IS NULL
              AND c.code = sr.currency
            ) ,
            (SELECT
              MIN(sr.price - IF(so.discountType = \'m\', sr.price * so.discountValue / 100, so.discountValue / c.rate))
            FROM special_offer so, currency c, city c1
            WHERE hotels_by_price.city_id = c1.id
              AND c1.country_id = so.country_id
              AND so.hotel_id IS NULL
              AND so.city_id IS NULL
              AND c.code = sr.currency
            )
        )
    ';

    private $queryForPagination;

    public function __construct(EntityManager $em, Mapping\ClassMetadata $class)
    {
        $this->queryForPagination = '
            SELECT
              hotels_by_price.name hotelName,
              hotels_by_price.min_price minPrice,
              sr.roomName,
              sr.price,
              sr.currency,
              sr.hotel_id hotelId,
              IF(m.id NOT IN (:mealUnknown, :mealWithout), m.name, \'\') mealName,
              (SELECT COUNT(*) FROM (' . $this->hotelsByPrice . ') counter) hotelsCount,
               ' . $this->discountedPrice . ' discountedPrice
            FROM (' . $this->hotelsByPrice . ') hotels_by_price,
                 search_result sr, meal m
            WHERE hotels_by_price.id = sr.hotel_id AND sr.request_id = :request_id AND sr.meal_id = m.id
            ORDER BY hotels_by_price.min_price, hotels_by_price.name, sr.price
        ';

        parent::__construct($em, $class);
    }

    public function createNewQueryForPagination($requestId, $offset, $limit)
    {
        $em = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('hotelId', 'hotelId');
        $rsm->addScalarResult('hotelName', 'hotelName');
        $rsm->addScalarResult('minPrice', 'minPrice');
        $rsm->addScalarResult('roomName', 'roomName');
        $rsm->addScalarResult('price', 'price');
        $rsm->addScalarResult('currency', 'currency');
        $rsm->addScalarResult('mealName', 'mealName');
        $rsm->addScalarResult('hotelsCount', 'hotelsCount');
        $rsm->addScalarResult('discountedPrice', 'discountedPrice');

        $pageQuery = $this->queryForPagination . ' LIMIT :limit OFFSET :offset';
        $query = $em->createNativeQuery($pageQuery, $rsm)->setParameters(
            array(
                "request_id" => $requestId,
                "limit" => $limit,
                "offset" => $offset,
                "mealUnknown" => Meal::MEAL_UNKNOWN,
                "mealWithout" => Meal::MEAL_WITHOUT
            )
        );
        return $query->getResult();
    }

    public function getTotalCountForPagination($requestId)
    {
        $em = $this->getEntityManager();
        $rsm = new ResultSetMapping();
        $rsm->addScalarResult('recordsCount', 'recordsCount');

        $totalCountQuery = 'SELECT COUNT(*) recordsCount FROM (' . $this->queryForPagination . ') counter';
        $query = $em->createNativeQuery($totalCountQuery, $rsm)->setParameters(
            array(
                "request_id" => $requestId,
                "mealUnknown" => Meal::MEAL_UNKNOWN,
                "mealWithout" => Meal::MEAL_WITHOUT
            )
        );
        return $query->getResult()[0]['recordsCount'];
    }
}