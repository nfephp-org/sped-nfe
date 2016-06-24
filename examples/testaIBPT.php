<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../config/config.json');
$nfe->setModelo('55');
$ncm = '22030000';
$exTarif = '0';
$siglaUF = 'GO';

$resp = $nfe->getImpostosIBPT($ncm, $exTarif, $siglaUF);

print_r($resp);
