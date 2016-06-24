<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$nfe->setModelo('55');

$chNFe = '35150458716523000119550010000000131000000139';
$tpAmb = '2';
$cnpj = '58716523000119';
$aResposta = array();

$resp = $nfe->sefazDownload($chNFe, $tpAmb, $cnpj, $aResposta);
echo '<br><br><PRE>';
echo htmlspecialchars($nfe->soapDebug);
echo '</PRE><BR>';
print_r($aResposta);
echo "<br>";
