<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$aResposta = array();

$pathNFefile = '/var/www/nfe/homologacao/enviadas/aprovadas/201501/35150158716523000119550010000000071000000076-protNFe.xml';
$pathProtfile = '/var/www/nfe/homologacao/temporarias/201501/35150158716523000119550010000000071000000076-CancNFe-retEnvEvento.xml';
$saveFile = true;
$retorno = $nfe->addCancelamento($pathNFefile, $pathProtfile, $saveFile);
echo '<br><br><PRE>';
echo htmlspecialchars($retorno);
echo '</PRE><BR>';
echo "<br>";
