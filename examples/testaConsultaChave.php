<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$nfe->setModelo('55');

$chave = '52160500067985000172550010000000101000000100';
$tpAmb = '2';
$aResposta = array();
$xml = $nfe->sefazConsultaChave($chave, $tpAmb, $aResposta);
echo '<br><br><pre>';
echo htmlspecialchars($nfe->soapDebug);
echo '</pre><br><pre>';
print_r($aResposta);
echo "<pre><br>";
