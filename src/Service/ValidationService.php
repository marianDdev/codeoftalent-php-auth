<?php

declare(strict_types=1);

namespace App\Service;

class ValidationService implements ValidationServiceInterface
{
    private array $errors = [];

    private array $attributes;

    public function __construct(array $attributes)
    {
        if (!Validator::email($attributes['email'])) {
            $this->errors['email'] = 'Please provide a valid email address.';
        }

        if (!Validator::string($attributes['password'])) {
            $this->errors['password'] = 'Please provide a valid password.';
        }

        $this->attributes = $attributes;
    }

    public static function validate($attributes): static
    {
        return new static($attributes);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
