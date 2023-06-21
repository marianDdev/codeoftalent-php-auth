<?php

declare(strict_types=1);

namespace App\Service;

interface ValidationServiceInterface
{
    public static function validate($attributes);

    public function getErrors(): array;

    public function getAttributes(): array;
}