<?php

namespace Uts\HotelBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * City
 *
 * @ORM\Table(name="currency")
 * @ORM\Entity
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\Column(length=3)
     * var string
     */
    protected $code;

    /**
     * @ORM\Column(type="float")
     * @var float
     */
    protected $rate;


    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get rate
     * @return float
     */
    public function getRate()
    {
        return $this->rate;
    }

    public function __toString()
    {
        return $this->getCode();
    }
}
