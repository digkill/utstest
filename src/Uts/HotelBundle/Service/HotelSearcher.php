<?php

namespace Uts\HotelBundle\Service;

use Doctrine\ORM\EntityManager;
use Uts\HotelBundle\Entity\Meal;
use Uts\HotelBundle\Entity\SearchRequest;
use Uts\HotelBundle\Entity\SearchResult;

class HotelSearcher
{
    private $wsdl;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \SoapClient
     */
    private $soapClient;

    public function __construct(EntityManager $em, $wsdl)
    {
        $this->wsdl = $wsdl;
        $this->em = $em;
    }

    /**
     * @return \SoapClient
     */
    private function getSoapClient()
    {
        if(!$this->soapClient){
            $this->soapClient = new \SoapClient(
                $this->wsdl,
                array(
                    'features' => SOAP_SINGLE_ELEMENT_ARRAYS,
                )
            );
        }
        return $this->soapClient;
    }

    /**
     * @param SearchRequest $objSearchRequest
     * @return SearchResult[]
     */
    public function search(SearchRequest $objSearchRequest)
    {
        $request = new \StdClass();
        $request->cityId = $objSearchRequest->getCity()->getId();
        $request->checkIn = $objSearchRequest->getCheckIn()->format('Y-m-d');
        $diff = $objSearchRequest->getCheckIn()->diff($objSearchRequest->getCheckOut());
        $request->duration = $diff->days;
        $room = new \StdClass();
        $room->roomNumber = 1;
        $room->adults = $objSearchRequest->getAdults();
        $request->roomsByPax = array($room);
        $response = $this->getSoapClient()->__soapCall('search', array($request));

        $hotelIds = array();
        $mealIds = array();
        foreach($response->item as $item){
            $hotelIds[$item->hotelId] = true;
            $mealIds[$item->mealId] = true;
        }
        unset($item);
        
        $hotels = array();
        foreach($this->em->getRepository('UtsHotelBundle:Hotel')->findBy(array('id' => array_keys($hotelIds))) as $objHotel){
            $hotels[$objHotel->getId()] = $objHotel;
        }

        $meals = array(Meal::MEAL_UNKNOWN => true);
        foreach($this->em->getRepository('UtsHotelBundle:Meal')->findBy(array('id' => array_keys($mealIds))) as $objMeal){
            $meals[$objMeal->getId()] = $objMeal;
        }

        $results = array();
        foreach($response->item as $item){
            if(!isset($hotels[$item->hotelId]) ||
                empty($item->rooms->item) ||
                count($item->rooms->item) != 1 ||
                $item->rooms->item[0]->roomNumber != 1
            ){
                /*
                 * Отсеиваем нестандартные варианты -
                 * не знаем такой отель или номеров неадекватное количество
                 * (мы то больше одного сейчас не просим)
                 */
                continue;
            }

            $objResult = new SearchResult();
            $objResult->setHotel($hotels[$item->hotelId]);
            $objResult->setCurrency($item->currency);
            $objResult->setPrice($item->price);
            $objResult->setRoomName($item->rooms->item[0]->roomName);
            $objResult->setRequest($objSearchRequest);
            $objResult->setMeal(isset($meals[$item->mealId]) ? $meals[$item->mealId] : $meals[Meal::MEAL_UNKNOWN]);
            $results[] = $objResult;
        }

        return $results;
    }
}