<?php

namespace Hl\PasswordPolicies\Validator;

use Attribute;
use Symfony\Component\Validator\Constraint;

#[Attribute(Attribute::TARGET_PROPERTY | Attribute::TARGET_METHOD)]
class PasswordPolicy extends Constraint
{
    public string $message = 'This password does not meet the requirements.';

    public function __construct(
        public string $policy = 'default',
        array $groups = null,
        mixed $payload = null
    ) {
        parent::__construct([], $groups, $payload);
    }
}