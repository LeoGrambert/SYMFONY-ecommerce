<?php
/**
 * User: leo
 * Date: 15/02/17
 * Time: 12:58
 */

namespace LG\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class LimitTicketsValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* todo write the condition : SI 1000 billets ont déjà été vendus pour la journée voulue ALORS ... */
        if(true/* ...($value) >= 1000 */)
        {
            $this->context->addViolation($constraint->message);
        }
    }
}