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
    public function __invoke(): void
    {
        $requestBody = json_decode(file_get_contents('php://input'), true);

        $request = ValidationService::validate($requestBody);

        if ($request->failed()) {
            echo json_encode(['errors' => $request->getErrors()]);
            die();
        }

        try {
            $user = $this->userRepository->getUser($request->getAttributes());
        } catch (Exception $e) {
            echo json_encode(['errors' => sprintf('Login failed. Error: %s', $e->getMessage())]);
            die();
        }

        $token = $this->tokenService->generate();

        $dto = $this->buildResponseDto($user, $token);
        $this->storeToSession($dto);

        echo json_encode($dto);
    }

    private function buildResponseDto(array $user, string $token): LoginResponseDto
    {
        $dto           = new LoginResponseDto();
        $dto->userName = sprintf('%s %s', $user['first_name'], $user['last_name']);
        $dto->email    = $user['email'];
        $dto->token    = $token;

        return $dto;
    }

    private function storeToSession(LoginResponseDto $dto): void
    {
        Session::put('user', $dto->userName);
        Session::put('email', $dto->email);
        Session::put('token', $dto->token);
    }
}
