<?php

namespace Uts\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="country")
 * @ORM\Entity
 */
class Country
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer")
     * var int
     */
    protected $id;

    /**
     * @ORM\Column(name="name",type="string",length=255)
     * @var string
     */
    protected $name;

    /**
     * Get nameRu
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get _id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return Country
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
     * @return Country
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
