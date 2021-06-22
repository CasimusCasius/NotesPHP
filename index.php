<?php

declare(strict_types=1);

namespace App;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");
require_once("src/Request.php");

use App\Exception\AppException;
use App\Exception\ConfigException;
use App\Exception\StorageException;
use App\Exception\NotFoundException;
use Throwable;

$configuration = require_once("config/config.php");

$request = new Request($_GET,$_POST);

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
catch (Throwable $e)
{
    echo "<h1>Wystąpił błąd Aplikacji</h1>";
    dump($e);
}
