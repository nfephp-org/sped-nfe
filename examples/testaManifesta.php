<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$nfe->setModelo('55');

//210200 – Confirmação da Operação
//210210 – Ciência da Operação
//210220 – Desconhecimento da Operação
//210240 – Operação não Realizada ===> é obritatoria uma justificativa para esse caso
$chave = '35150158716523000119550010000000071000000076';
$tpAmb = '2';
$xJust = '';
$tpEvento = '210210'; //ciencia da operação
$aResposta = array();
$xml = $nfe->sefazManifesta($chave, $tpAmb, $xJust = '', $tpEvento = '', $aResposta);
echo '<br><br><PRE>';
echo htmlspecialchars($nfe->soapDebug);
echo '</PRE><BR>';
print_r($aResposta);
echo "<br>";
