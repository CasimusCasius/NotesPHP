<?php 
declare (strict_types=1); // deklarowanie zmiennych obowiązkowe
error_reporting(E_ALL); // pokaż wszystkie błędy
ini_set('display_errors','1'); // pokaż wszystkie błędy

function debug($data): void
{
    echo '<div style="display: inline-block; padding: 0 5px; border: 2px solid grey; background: lightgray">
    <pre>';
        print_r($data);
echo "</pre></div></br>";
}