<?php

declare(strict_types=1);

namespace App;

use App\Exception\NotFoundException;

require_once("AbstractController.php");

class NoteController extends AbstractController
{
    public function createAction()
    {
        if ($this->request->hasPost())
        {
            $this->database->createNote(
                [
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ]
            );
            header('Location: /?before=created'); //do strony głównej
        }
        $this->view->render('create');
    }
    public function showAction() 
    {
        $noteId=(int) ($this->request->getParam('id'));

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
        $this->view->render('show',['note'=> $note]);
    }

    public function listAction()
    {
            $notes=$this->database->getNotes();
            $viewParams = [
                'notes' => $this->database->getNotes(),
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error')
            ];
        $this->view->render('list',$viewParams);
    }
}