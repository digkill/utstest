<?php

namespace Uts\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpecialOffer
 *
 * @ORM\Table(name="special_offer")
 * @ORM\Entity
 */
class SpecialOffer
{
    const DISCOUNT_TYPE_ABSOLUTE = 'a';
    const DISCOUNT_TYPE_MULTIPLIER = 'm';

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(length=150,nullable=true)
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="Hotel"),
     * @var Hotel
     */
    protected $hotel;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @var City
     */
    protected $city;

    /**
     * @ORM\ManyToOne(targetEntity="Country")
     * @var Country
     */
    protected $country;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $isActive = true;


    /**
     * @ORM\Column(length=1)
     * @var string
     */
    protected $discountType = self::DISCOUNT_TYPE_MULTIPLIER;

    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    protected $discountValue = 0;

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
     * Set name
     *
     * @param string $name
     * @return SpecialOffer
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     * @return SpecialOffer
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean 
     */
    public function getIsActive()
    {
        return $this->isActive;
    }

    /**
     * Set discountType
     *
     * @param string $discountType
     * @return SpecialOffer
     */
    public function setDiscountType($discountType)
    {
        $this->discountType = $discountType;

        return $this;
    }

    /**
     * Get discountType
     *
     * @return string 
     */
    public function getDiscountType()
    {
        return $this->discountType;
    }

    /**
     * Set discountValue
     *
     * @param integer $discountValue
     * @return SpecialOffer
     */
    public function setDiscountValue($discountValue)
    {
        $this->discountValue = $discountValue;

        return $this;
    }

    /**
     * Get discountValue
     *
     * @return integer 
     */
    public function getDiscountValue()
    {
        return $this->discountValue;
    }

    /**
     * Set hotel
     *
     * @param \Uts\HotelBundle\Entity\Hotel $hotel
     * @return SpecialOffer
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
     * Set city
     *
     * @param \Uts\HotelBundle\Entity\City $city
     * @return SpecialOffer
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

    /**
     * Set country
     *
     * @param \Uts\HotelBundle\Entity\Country $country
     * @return SpecialOffer
     */
    public function setCountry(Country $country = null)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return \Uts\HotelBundle\Entity\Country 
     */
    public function getCountry()
    {
        return $this->country;
    }
}
