<?php

namespace Uts\HotelBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Uts\HotelBundle\Entity;

class SearchRequest extends EntityRepository
{
    public function isCompleteRequest(Entity\SearchRequest $objSearchRequest)
    {
        return $this->findOneBy(
            array(
                'city' => $objSearchRequest->getCity(),
                'checkIn' => $objSearchRequest->getCheckIn(),
                'checkOut' => $objSearchRequest->getCheckOut(),
                'adults' => $objSearchRequest->getAdults(),
                'status' => Entity\SearchRequest::STATUS_COMPLETE
            )
        );
    }
}