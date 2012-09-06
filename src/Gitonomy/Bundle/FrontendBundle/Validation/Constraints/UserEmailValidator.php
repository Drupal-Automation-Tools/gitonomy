<?php

/**
 * This file is part of Gitonomy.
 *
 * (c) Alexandre Salomé <alexandre.salome@gmail.com>
 * (c) Julien DIDIER <genzo.wm@gmail.com>
 *
 * This source file is subject to the GPL license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Gitonomy\Bundle\FrontendBundle\Validation\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Doctrine\Bundle\DoctrineBundle\Registry;

class UserEmailValidator extends ConstraintValidator
{
    /**
     * @var Symfony\Bundle\DoctrineBundle\Registry
     */
    protected $doctrineRegistry;

    public function __construct(Registry $doctrineRegistry)
    {
        $this->doctrineRegistry = $doctrineRegistry;
    }

    public function validate($value, Constraint $constraint)
    {
        if (false === $value || (empty($value) && '0' != $value)) {
            $this->context->addViolation($constraint->message);

            return;
        }

        $email = $value->getEmail();
        $email = $this->doctrineRegistry->getRepository('GitonomyCoreBundle:Email')->findByEmail($email);

        if (null === $email) {
            $this->setMessage($constraint->message);
        }
    }
}
