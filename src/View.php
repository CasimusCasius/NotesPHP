<?php

declare(strict_types=1);

namespace Notes;

class View
{
    public function render(string $page): void
    {
        include_once("templates/pages/layout.php");
        if ($page === "createNote")
        {
            include_once("templates/pages/createNote.php");
        }
        else
        {
            include_once("templates/pages/list.php");
        }
    }
}
