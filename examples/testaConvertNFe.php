<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\ConvertNFe;

$convert = new ConvertNFe();

$txtfile = 'xml/NOTAFISCAL310.txt';

$aNFe = $convert->txt2xml($txtfile);

header("Content-Type:text/xml");
echo $aNFe[0];
