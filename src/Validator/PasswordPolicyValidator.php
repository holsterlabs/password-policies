<?php

namespace Hl\PasswordPolicies\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordPolicyValidator extends ConstraintValidator
{
    private array $policies;

    private array $validators = [
        'digitCharacterRequired' => '/\d/',
        'lowerCaseCharacterRequired' => '/[a-z]/',
        'upperCaseCharacterRequired' => '/[A-Z]/',
        'specialCharacterRequired' => '/[^a-zA-Z\d]/',
    ];

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
            $this->context
                ->buildViolation('password_policy.minimumLength')
                ->setParameter('length', $policy['minimumLength'] ?? 8)
                ->addViolation();
            return;
        }

        $matchCount = 0;

        foreach ($policy['options'] as $validator => $minLength) {
            if (preg_match_all($this->validators[$validator], $value) >= $minLength) {
                $matchCount++;
            }
        }

        $charakterVariance = (count($policy['options']) < $policy['charakterVariance']) ?
            count($policy['options']) : $policy['charakterVariance'];

        if ($matchCount < ($charakterVariance)) {
            $this->context
                ->buildViolation('password_policy.message')
                ->setParameter('count', $charakterVariance)
                ->addViolation();

            foreach ($policy['options'] as $validator => $minLength) {
                $this->context
                    ->buildViolation('password_policy.validators.' . $validator)
                    ->setParameter('count', $minLength)
                    ->addViolation();
            }
        }
    }
}
