<?php

declare(strict_types=1);

namespace App\Service;

use PDO;
use PDOStatement;

class DatabaseService implements DatabaseServiceInterface
{
    private PDO $connection;

    public function __construct()
    {
        $dsn = $_ENV['DATABASE_URL'];
        $this->connection = new PDO($dsn);
    }

    public function getPreparedStatement(string $query, array $params = []): bool|PDOStatement
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);

        return $statement;
    }
}