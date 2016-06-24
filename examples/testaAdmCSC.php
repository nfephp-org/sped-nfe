<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../config/config.json');
$nfe->setModelo('65');

/* Operações de administração CSC (indOp):

01 – Consulta
02 – Solicitação
03 – Revogação

*/

$indOp = '1';
$tpAmb = '2';
$raizCNPJ = ''; // Deixe vazio para utilizar o CNPJ do Certificado
$idCsc = '';
$codigoCsc = '';
$saveXml = true; // Salva o resultado em XML na pasta csc

$aResposta = array();
$xml = $nfe->sefazManutencaoCsc($indOp, $tpAmb, $raizCNPJ, $idCsc, $codigoCsc, $saveXml, $aResposta);
echo '<br><br><PRE>';
echo htmlspecialchars($nfe->soapDebug);
echo '</PRE><BR><PRE>';
print_r($aResposta);
echo "</PRE><br>";
