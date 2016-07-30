<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Convert;

$convert = new Convert();

$txtfile = '../tests/fixtures/NFe.txt';

$aNFe = $convert->txt2xml($txtfile);

header("Content-Type:text/xml");
echo $aNFe[0];
