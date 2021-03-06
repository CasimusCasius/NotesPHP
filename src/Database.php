<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use PDO;
use PDOException;
use Throwable;

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
        $this->conn = new PDO($dsn, $config['user'], $config['password'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]); 
    }

    public function getNote(int $id) :array
    {
        try{
        $query = "SELECT id, title, description, created  FROM notes WHERE id = {$id}";
        $result=$this->conn->query($query);
        $note=$result->fetch(PDO::FETCH_ASSOC);
        
        }
        catch (Throwable $e)
        {
            throw new StorageException("Nie udało się pobrać notatki",400);
        }
        if (!$note)
        {
            throw new NotFoundException("Rekord $id nie znaleziony");
        }
        return $note;
    }

    public function getNotes() : array
    {
        try{
        $query = 'SELECT id, title, created  FROM notes';
        $result=$this->conn->query($query);
        $notes=$result->fetchAll(PDO::FETCH_ASSOC);
        return $notes;
        }
        catch (Throwable $e)
        {
            throw new StorageException("Nie udało się pobrać danych o notatkach",400);
        }
    }

    public function createNote(array $data) :void
    {
        try
        {
            $title = $this->conn->quote($data['title']);
            $description  = $this->conn->quote($data['description']);
            $created = $this->conn->quote(date('Y-m-d H-i-s'));

            $query = "INSERT INTO notes (title,description,created) VALUES ({$title},{$description},{$created})";
            
            
        }
        catch(Throwable $e)
        {
            throw new StorageException('Nie udalo sie utworzyc nowej notatki',400,$e);
            
            exit ('STOP');
        }
       
    }

    public function editNote(int $id, array $data): void
    {

        
        try
        {
            $title = $this->conn->quote($data['title']);
            $description  = $this->conn->quote($data['description']);
            $query = "UPDATE notes SET title = $title, description = $description Where id=$id";
            $this->conn->exec($query);

        }
        catch(Throwable $e)
        {
            throw new StorageException('Nie udalo sie edytować notatki',400,$e);
            
            exit ('STOP');
        }
    }

    public function deleteNote(int $id): void
    {
       try
        {
            $query = "DELETE FROM notes WHERE id=$id";
            $this->conn->exec($query);
        }
        catch(Throwable $e)
        {
            throw new StorageException('Nie udalo sie usunąć notatki',400,$e);
            
            exit ('STOP');
        }
    }
}