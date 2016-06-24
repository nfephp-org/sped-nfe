<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../config/config.json');
$nfe->setModelo('55');

$aResposta = array();
$chave = '35150158716523000119550010000000071000000076';
$nProt = '135150000408219';
$tpAmb = '2';
$xJust = 'Teste de cancelamento em ambiente de homologação';
$retorno = $nfe->sefazCancela($chave, $tpAmb, $xJust, $nProt, $aResposta);
echo '<br><br><PRE>';
echo htmlspecialchars($nfe->soapDebug);
echo '</PRE><BR>';
print_r($aResposta);
echo "<br>";
