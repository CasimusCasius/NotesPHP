<?php 
declare (strict_types=1); 
namespace Notes;


require_once("src/utils/debug.php"); // jest wymagane tylko raz
// include_once("src/utils/debug.php") //nie jest wymagany, załącz tylko raz

$test = ['test','test1','test2'];
debug($test);
