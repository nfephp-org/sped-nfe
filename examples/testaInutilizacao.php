<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$nfe->setModelo('55');

$aResposta = array();
$nSerie = 1;
$nIni = 8;
$nFin = 8;
$xJust = 'teste de inutilização de notas fiscais em homologacao';
$tpAmb = '2';
$xml = $nfe->sefazInutiliza($nSerie, $nIni, $nFin, $xJust, $tpAmb, $aResposta);
echo '<br><br><PRE>';
echo htmlspecialchars($nfe->soapDebug);
echo '</PRE><BR>';
print_r($aResposta);
echo "<br>";
