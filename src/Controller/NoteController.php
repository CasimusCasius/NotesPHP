<?php

declare(strict_types=1);

namespace App\Controller;

use App\Exception\NotFoundException;
use app\Controller\AbstractController;


class NoteController extends AbstractController
{
    public function createAction(): void
    {
        if ($this->request->hasPost())
        {
            $this->database->createNote(
                [
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ]
            );
            $this->redirect('/',['before'=>'created']); //do strony głównej
        }
        $this->view->render('create');
    }
    public function showAction() :void
    {
        
        $this->view->render(
            'show',
            ['note'=> $this->getNote()]
        );
    }

    public function listAction() :void
    {
            $notes=$this->database->getNotes();
            $viewParams = [
                'notes' => $this->database->getNotes(),
                'before' => $this->request->getParam('before'),
                'error' => $this->request->getParam('error')
            ];
        $this->view->render('list',$viewParams);
    }

    public function editAction() :void
    {
        if ($this->request->isPost())
        {
            $noteId =(int) $this->request->postParam('id');
            $noteData=
                [
                    'title' => $this->request->postParam('title'),
                    'description' => $this->request->postParam('description')
                ];
            $this->database->editNote($noteId,$noteData); 
            $this->redirect('/', ['before'=>'edited']); 
        }
        
            $this->view->render(
                'edit',
                ['note'=>$this->getNote()]
            );
        
    }

    public function deleteAction() :void
    {
        if ($this->request->isPost())
        {
            $noteId = (int) $this->request->postParam('id');
            $this->database->deleteNote($noteId);
            $this->redirect('/', ['before'=>'deleted']); 
        }
       $this->view->render(
                'delete',
                ['note'=>$this->getNote()]
            );
        
    }

    final private function getNote(): array
    {
        $noteId=(int) ($this->request->getParam('id'));

        if(!$noteId)
        {
            $this->redirect('/',['error'=>'missingNoteId']);
        }
        try
        {
         $note = $this->database->getNote($noteId);
        }
        catch (NotFoundException $e)
        {
            $this->redirect('/',['error'=>'noteNotFound']);
        }
        return $note;
    }
}
