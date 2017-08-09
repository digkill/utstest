<?php

namespace Uts\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Uts\HotelBundle\Validator\Constraints as UtsHotelAssert;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SearchRequest
 * @package Uts\HotelBundle\Entity
 *
 * @ORM\Entity(repositoryClass="Uts\HotelBundle\Repository\SearchRequest")
 * @ORM\Table(name="search_request")
 * @UtsHotelAssert\ValidSearchDates
 */class SearchRequest
{
    const STATUS_NEW = 0;
    const STATUS_COMPLETE = 1;
    const STATUS_OLD = 2;
    const STATUS_ERROR = 3;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue()
     * 
     * @var int
     */
    private $id;

    /**
     * @Assert\NotNull(message="Не указан город", groups={"search"})
     * @ORM\ManyToOne(targetEntity="City")
     * @var City
     */
    private $city;

    /**
     * @Assert\Date(message="Не указана дата заезда", groups={"search"})
     * @Assert\NotNull(message="Не указана дата заезда", groups={"search"})
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $checkIn;

    /**
     * @Assert\Date(message="Не указана дата выезда", groups={"search"})
     * @Assert\NotNull(message="Не указана дата выезда", groups={"search"})
     * @ORM\Column(type="date")
     * @var \DateTime
     */
    private $checkOut;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $adults = 1;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(type="integer")
     * @var int
     */
    private $status = self::STATUS_NEW;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }

    /**
     * Get Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set checkIn
     *
     * @param \DateTime $checkIn
     * @return SearchRequest
     */
    public function setCheckIn($checkIn)
    {
        $this->checkIn = $checkIn;

        return $this;
    }

    /**
     * Get checkIn
     *
     * @return \DateTime 
     */
    public function getCheckIn()
    {
        return $this->checkIn;
    }

    /**
     * Set checkOut
     *
     * @param \DateTime $checkOut
     * @return SearchRequest
     */
    public function setCheckOut($checkOut)
    {
        $this->checkOut = $checkOut;

        return $this;
    }

    /**
     * Get checkOut
     *
     * @return \DateTime 
     */
    public function getCheckOut()
    {
        return $this->checkOut;
    }

    /**
     * Set adults
     *
     * @param integer $adults
     * @return SearchRequest
     */
    public function setAdults($adults)
    {
        $this->adults = $adults;

        return $this;
    }

    /**
     * Get adults
     *
     * @return integer 
     */
    public function getAdults()
    {
        return $this->adults;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set city
     *
     * @param \Uts\HotelBundle\Entity\City $city
     * @return SearchRequest
     */
    public function setCity(City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Uts\HotelBundle\Entity\City 
     */
    public function getCity()
    {
        return $this->city;
    }

    public function markAsComplete()
    {
        $this->status = self::STATUS_COMPLETE;
    }

    public function markAsOld()
    {
        $this->status = self::STATUS_OLD;
    }

    public function markAsError()
    {
        $this->status = self::STATUS_ERROR;
    }

    public function isNew()
    {
        return $this->status == self::STATUS_NEW;
    }

    public function isComplete()
    {
        return $this->status == self::STATUS_COMPLETE;
    }

    public function isOld()
    {
        return $this->status == self::STATUS_OLD;
    }

    public function isError()
    {
        return $this->status == self::STATUS_ERROR;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return SearchRequest
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return SearchRequest
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }
}
