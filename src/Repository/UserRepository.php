<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\DatabaseServiceInterface;
use Exception;

class UserRepository
{
    private DatabaseServiceInterface $databaseService;

    public function __construct(DatabaseServiceInterface $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    /**
     * @throws Exception
     */
    public function getUser(array $data): array
    {
        $params = [
            'email' => $data["email"],
        ];

        $query     = 'SELECT * FROM users WHERE email=:email';
        $statement = $this->databaseService->getPreparedStatement($query, $params);
        $user      = $statement->fetch();

        $this->checkCredentials($data, $user);

        return $user;
    }

    /**
     * @throws Exception
     */
    private function checkCredentials(array $data, $user): void
    {
        if (!$user) {
            throw new Exception(sprintf('%s email is not matching any account.', $data['email']));
        }

        if (!password_verify($data['password'], $user['password'])) {
            throw new Exception(sprintf('%s password is not a valid password.', $data['password']));
        }
    }
}
