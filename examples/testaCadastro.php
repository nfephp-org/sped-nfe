<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$nfe->setModelo('55');

$aResposta = array();
$siglaUF = $nfe->aConfig['siglaUF'];
$tpAmb = '2';
$cnpj = $nfe->aConfig['cnpj']; // Consulta por CNPJ ou IE ou CPF
$iest = '';
$cpf = '';
$retorno = $nfe->sefazCadastro($siglaUF, $tpAmb, $cnpj, $iest, $cpf, $aResposta);
echo '<br><br><pre>';
echo htmlspecialchars($nfe->soapDebug);
echo '</pre><br><pre>';
print_r($aResposta);
echo "</pre><br>";
