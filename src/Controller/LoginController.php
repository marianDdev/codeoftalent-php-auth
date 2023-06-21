<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\LoginResponseDto;
use App\Repository\UserRepository;
use App\Service\TokenServiceInterface;
use App\Service\ValidationService;
use App\Session;
use Exception;

class LoginController
{
    private UserRepository        $userRepository;
    private TokenServiceInterface $tokenService;

    public function __construct(
        UserRepository        $userRepository,
        TokenServiceInterface $tokenService,
    ) {
        $this->userRepository = $userRepository;
        $this->tokenService   = $tokenService;
    }

    /**
     * @throws Exception
     */
    public function __invoke(): string
    {
        $attributes = $_REQUEST;
        $validated  = ValidationService::validate($attributes);

        if (!empty($validated->getErrors())) {
            return json_encode($validated->getErrors());
        }

        try {
            $user = $this->userRepository->getUser($validated->getAttributes());
        } catch (Exception $e) {
            return json_encode(sprintf('Login failed. Error: %s', $e->getMessage()));
        }

        $token = $this->tokenService->generate();

        $dto = $this->buildResponseDto($user, $token);
        $this->storeToSession($dto);

        return json_encode($dto);
    }

    private function buildResponseDto(array $user, string $token): LoginResponseDto
    {
        $dto                = new LoginResponseDto();
        $dto->userName      = sprintf('%s %s', $user['first_name'], $user['last_name']);
        $dto->email         = $user['email'];
        $dto->authorization = [
            'token' => $token,
            'type'  => 'bearer',
        ];

        return $dto;
    }

    private function storeToSession(LoginResponseDto $dto): void
    {
        Session::put('user', $dto->userName);
        Session::put('email', $dto->email);
        Session::put('token', $dto->authorization);
    }
}
