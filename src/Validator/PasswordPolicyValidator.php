<?php

namespace Hl\PasswordPolicies\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordPolicyValidator extends ConstraintValidator
{
    private array $policies;

    public function __construct(array $policies)
    {
        $this->policies = $policies;
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof PasswordPolicy) {
            return;
        }

        $policy = $this->policies[$constraint->policy] ?? null;

        if (!$policy) {
            return;
        }

        if (!is_string($value)) {
            return;
        }

        if (strlen($value) < ($policy['minimumLength'] ?? 8)) {
            $this->context->buildViolation($constraint->message)->addViolation();
            return;
        }

        $checks = [
            'digitCharacter' => '/\d/',
            'lowerCaseCharacter' => '/[a-z]/',
            'upperCaseCharacter' => '/[A-Z]/',
            'specialCharacter' => '/[^a-zA-Z\d]/',
        ];

        $matchCount = 0;
        foreach ($checks as $key => $pattern) {
            if (preg_match($pattern, $value)) {
                $matchCount++;
            }
        }

        if ($matchCount < ($policy['charakterVariance'] ?? 3)) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}