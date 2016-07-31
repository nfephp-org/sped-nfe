<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$tools = new Tools('../config/config.json');
$aResposta = array();

$xmlnfe = file_get_contents('../local/41160709942747000133550010000005041768326514-NFe.xml');

$chave = '41160709942747000133550010000005041768326514';
$tpAmb = '2';
$aResposta = array();
$prot = $tools->sefazConsultaChave($chave, $tpAmb, $aResposta);

$saveFile = false;
$retorno = $tools->addProtocolo($xmlnfe, $prot, $saveFile);
file_put_contents('../local/41160709942747000133550010000005041768326514-protNFe.xml', $retorno);
echo '<br><br><pre>';
echo htmlspecialchars($retorno);
echo "</pre><br>";
