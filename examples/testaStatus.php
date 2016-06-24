<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../config/config.json');
//$nfe->ativaContingencia('GO','Contingência Ativada pela SEFAZ GO desde 08/10/2010 18:00:00','');
//$nfe->desativaContingencia();
$nfe->setModelo('55');

$aResposta = array();
$siglaUF = 'GO';
$tpAmb = '2';
$retorno = $nfe->sefazStatus($siglaUF, $tpAmb, $aResposta);
echo '<br><br><pre>';
echo htmlspecialchars($nfe->soapDebug);
echo '</pre><br><br><pre>';
print_r($aResposta);
echo "</pre><br>";