<?php

namespace Uts\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Результат поиска отелей
 *
 * @ORM\Entity(repositoryClass="Uts\HotelBundle\Repository\SearchResult")
 * @ORM\Table(name="search_result")
 */
class SearchResult
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="SearchRequest")
     * @var
     */
    private $request;

    /**
     * @ORM\ManyToOne(targetEntity="Hotel")
     * @var Hotel
     */
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity="Meal")
     * @var Meal
     */
    private $meal;

    /**
     * @ORM\Column(type="decimal",scale=2,precision=10)
     * @var string
     */
    private $price;

    /**
     * @ORM\Column(length=3)
     * @var string
     */
    private $currency;

    /**
     * @ORM\Column(length=255)
     * @var string
     */
    private $roomName;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return SearchResult
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set currency
     *
     * @param string $currency
     * @return SearchResult
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;

        return $this;
    }

    /**
     * Get currency
     *
     * @return string 
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set roomName
     *
     * @param string $roomName
     * @return SearchResult
     */
    public function setRoomName($roomName)
    {
        $this->roomName = $roomName;

        return $this;
    }

    /**
     * Get roomName
     *
     * @return string 
     */
    public function getRoomName()
    {
        return $this->roomName;
    }

    /**
     * Set request
     *
     * @param \Uts\HotelBundle\Entity\SearchRequest $request
     * @return SearchResult
     */
    public function setRequest(SearchRequest $request = null)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get request
     *
     * @return \Uts\HotelBundle\Entity\SearchRequest 
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Set hotel
     *
     * @param \Uts\HotelBundle\Entity\Hotel $hotel
     * @return SearchResult
     */
    public function setHotel(Hotel $hotel = null)
    {
        $this->hotel = $hotel;

        return $this;
    }

    /**
     * Get hotel
     *
     * @return \Uts\HotelBundle\Entity\Hotel 
     */
    public function getHotel()
    {
        return $this->hotel;
    }

    /**
     * Set meal
     *
     * @param \Uts\HotelBundle\Entity\Meal $meal
     * @return SearchResult
     */
    public function setMeal(Meal $meal = null)
    {
        $this->meal = $meal;

        return $this;
    }

    /**
     * Get meal
     *
     * @return \Uts\HotelBundle\Entity\Meal
     */
    public function getMeal()
    {
        return $this->meal;
    }

    public function getMealName()
    {
        return $this->meal &&
            !in_array($this->meal->getId(), array(Meal::MEAL_UNKNOWN, Meal::MEAL_WITHOUT)) ?
            $this->meal->getName() : '';
    }
}
