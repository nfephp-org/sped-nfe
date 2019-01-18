<?php

$json = file_get_contents('fixtures/txtstructure400.json');
$lines = json_decode($json, true);

foreach($lines as $lin) {
    echo $lin.'<br>';
}
