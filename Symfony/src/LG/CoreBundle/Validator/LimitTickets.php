<?php
/**
 * User: leo
 * Date: 15/02/17
 * Time: 12:55
 */

namespace LG\CoreBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Class LimitTickets
 * @package LG\CoreBundle\Validator
 * @Annotation
 */
class LimitTickets extends Constraint
{
    public $message = "Vous ne pouvez pas commander de billets pour cette date. Plus de 1000 billets ont déjà été vendus.";
    
    public function validatedBy()
    {
        return 'lg_core_bundle_limittickets';
    }
}