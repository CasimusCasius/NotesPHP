<?php

declare(strict_types=1);

namespace App;

require_once("Exception/StorageException.php");

use App\Exception\ConfigException;
use App\Exception\StorageException;
use PDO;
use PDOException;

class Database
{

    private PDO $conn;
    public function __construct(array $config)
    {
        try
        {
            $this->validateConfig($config);
            $this->createConnection($config);
        }
        catch (PDOException $e)
        {
            throw new StorageException('Connection error', 404);
            exit('e');
        }
    }

    private function validateConfig(array $config): void
    {
        if (
            empty($config['database'])
            || empty($config['host'])
            || empty($config['user'])
            || empty($config['password'])
        )
        {
            throw new ConfigException("Storage configuration error");
        }
    }

    private function createConnection(array $config) :void
    {
        $dsn = "mysql:dbname={$config['database']};host={$config['host']}";
        $this->conn = new PDO($dsn, $config['user'], $config['password']);
        dump($this->conn);
    }
}