<?php

namespace Uts\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="hotel")
 * @ORM\Entity
 */
class Hotel
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer")
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(name="name",type="string",length=255)
     * @var string
     */
    protected $name;

    /**
     * @ORM\ManyToOne(targetEntity="City")
     * @var City
     */
    protected $city;

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
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get city
     *
     * @return City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Get Country
     *
     * @return null|Country
     */
    public function getCountry()
    {
        return $this->city ? $this->city->getCountry() : null;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Hotel
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Hotel
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set city
     *
     * @param \Uts\HotelBundle\Entity\City $city
     * @return Hotel
     */
    public function setCity(\Uts\HotelBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
