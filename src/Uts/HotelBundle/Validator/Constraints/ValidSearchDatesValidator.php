<?php

namespace Uts\HotelBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Uts\HotelBundle\Entity\SearchRequest;

class ValidSearchDatesValidator extends ConstraintValidator {

    public function validate($value, Constraint $constraint)
    {
        /** @var $value SearchRequest */
        /** @var $constraint ValidSearchDates */
        if ($value->getCheckIn() === null || $value->getCheckOut() === null) {
            return;
        }
        $today = new \DateTime(); $today->setTime(0, 0 ,0);
        if ($value->getCheckIn() < $today) {
            $this->context->addViolation($constraint->invalidCheckInDateMessage);
        }

        if ($value->getCheckOut() <= $value->getCheckIn()) {
            $this->context->addViolation($constraint->invalidCheckOutDateMessage);
        }
    }

} 