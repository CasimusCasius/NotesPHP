<?php

declare(strict_types=1);

namespace App;

use App\Exception\ConfigException;
use App\Exception\NotFoundException;

require_once("View.php");
require_once("Database.php");
require_once("src/Exception/ConfigException.php");

class Controller
{
    private const DEFAULT_ACTION = 'list';
    private static array $configuration = [];

    private Database $database;
    private array $request;
    private View $view;

    public static function initConfiguration(array $configuration): void
    {
        self::$configuration = $configuration;
    }

    public function __construct(array $request)
    {
        if (empty(self::$configuration['db']))
        {
            throw new ConfigException("Configuration error", 600);
        }

        $this->database = new Database(self::$configuration['db']);

        $this->request = $request;
        $this->view = new View();
    }

    public function run(): void
    {
        switch ($this->action())
        {
            case 'create':
                $page = 'create';
                
                $note = $this->getRequestPost();
                if (!empty($note))
                {
                    $this->database->createNote(
                        [
                            'title' => $note['title'],
                            'description' => $note['description']
                        ]
                    );

                    header('Location: /?before=created'); //do strony głównej
                }
                break;
            case 'show':
                $page = 'show';
                $data = $this->getRequestGet();
                $noteId=(int) ($data['id'] ?? null);

                if(!$noteId)
                {
                    header('Location: /?error=missingNoteId');
                    exit;
                }
                try
                {
                $note = $this->database->getNote($noteId);
                }
                catch (NotFoundException $e)
                {
                    header('Location: /?error=noteNotFound');
                    exit;
                }
                $viewParams= ['note'=> $note];
                break;
            default:
                $page = 'list';
                $data = $this->getRequestGet();

                $notes=$this->database->getNotes();

                $viewParams = [
                    'notes' => $this->database->getNotes(),
                    'before' => $data['before'] ?? null,
                    'error' => $data['error'] ?? null
                ];
                
                break;
        }
        $this->view->render($page, $viewParams ?? []);
    }

    private function getRequestPost(): array
    {
        return $this->request['post'] ?? [];
    }

    private function getRequestGet(): array
    {
        return $this->request['get'] ?? [];
    }

    private function action(): string
    {
        $data = $this->getRequestGet();
        return $data['action'] ?? self::DEFAULT_ACTION;
    }
}
