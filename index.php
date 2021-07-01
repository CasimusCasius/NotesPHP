<?php

declare(strict_types=1); 


spl_autoload_register(function(string $classNamespace) {
    $path = str_replace(['\\','App'],['/',''],$classNamespace);
    $path="src$path.php";
    require_once($path);
});


use App\Request;
use App\Controller\AbstractController;
use App\Controller\NoteController;
use App\Exception\AppException;
use App\Exception\ConfigException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;


require_once("src/Utils/debug.php");
$configuration = require_once("config/config.php");

$request = new Request($_GET,$_POST,$_SERVER);

try 
{     
    AbstractController::initConfiguration($configuration);
    (new NoteController($request))->run();
}
catch (StorageException $e)
{
    echo "<h1>Wystąpił błąd Aplikacji</h1>";
    echo "<h3>".$e->getMessage()."</h3>";
}
catch (ConfigException $e)
{
    echo "<h1>Wystąpił błąd Aplikacji</h1>";
    echo "Problem z Konfiguracją. Skontaktuj się z Administratorem";
}
catch (NotFoundException $e)
{
    echo "<h1>Wystąpił błąd Zapytania</h1>";
    echo "<h3>".$e->getMessage()."</h3>";
}
catch (AppException $e)
{
    echo "<h1>Wystąpił błąd Aplikacji</h1>";
    echo "<h3>".$e->getMessage()."</h3>";
}
catch (\Throwable $e)
{
    echo "<h1>Wystąpił błąd Aplikacji</h1>";
    dump($e);
}
