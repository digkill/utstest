<?php

namespace Uts\HotelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/** @Annotation */
class ValidSearchDates extends Constraint {

    public $invalidCheckInDateMessage = 'Указана некорректная дата заезда';

    public $invalidCheckOutDateMessage = 'Указана некорректная дата выезда';

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

} 