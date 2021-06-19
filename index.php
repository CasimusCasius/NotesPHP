<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use App\Exception\ConfigException;
use App\Exception\StorageException;
use Throwable;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");


$configuration = require_once("config/config.php");

$request = [
'get' =>  $_GET,
'post' => $_POST
];

try 
{     
    Controller::initConfiguration($configuration);
    (new Controller($request))->run();
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

catch (AppException $e)
{
    echo "<h1>Wystąpił błąd Aplikacji</h1>";
    echo "<h3>".$e->getMessage()."</h3>";
}
catch (Throwable $e)
{
    echo "<h1>Wystąpił błąd Aplikacji</h1>";
    dump($e);
}
