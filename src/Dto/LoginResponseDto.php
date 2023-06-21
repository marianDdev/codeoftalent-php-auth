<?php

declare(strict_types=1);

namespace App\Dto;

class LoginResponseDto
{
    public string $userName;

    public string $email;

    public array $authorization;
}