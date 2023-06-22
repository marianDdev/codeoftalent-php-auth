<?php

declare(strict_types=1);

namespace App\Service;

use PDOStatement;

interface DatabaseServiceInterface
{
    public function prepareStatement(string $query, array $params): bool|PDOStatement;
}