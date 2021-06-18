<?php

declare(strict_types=1);

namespace Notes;

require_once("src/utils/debug.php"); // jest wymagane tylko raz
// include_once("src/utils/debug.php") //nie jest wymagany, załącz tylko raz
require_once("src/View.php");

const DEAFULT_ACTION = 'list';


$action = htmlentities($_GET['action'] ?? DEAFULT_ACTION);

$view = new View();
$view->render($action);


