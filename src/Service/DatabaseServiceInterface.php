<?php

declare(strict_types=1);

namespace App\Service;

use PDOStatement;

interface DatabaseServiceInterface
{
    public function getPreparedStatement(string $query, array $params): bool|PDOStatement;
}