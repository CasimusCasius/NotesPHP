<?php 
declare (strict_types=1);

$test =  ['test', 'test1', 'test2'];

function debug($data): void
{
echo '<div style="display: inline-block; padding: 0 5px; border: 2px solid grey; background: lightgray">
    <pre>';
        print_r($data);
echo "</pre></div>";
}

debug($test);
