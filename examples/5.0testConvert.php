<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Convert;

try {
    $txt = file_get_contents('fixtures/NFe_55_400_1.txt');
    $conv = new Convert();
    $xml = $conv->toXml($txt);
    $resp = $xml[0];
    header('Content-type: text/xml; charset=UTF-8');
    echo $resp;
} catch (\Exception $e) {
    echo str_replace("\n", "<br/>", $e->getMessage());
}
     