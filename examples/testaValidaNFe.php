<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\ToolsNFe;

$nfe = new ToolsNFe('../config/config.json');
$nfe->setModelo('55');

$chave = '52160500067985000172550010000000101000000100';
//$pathXml = '/var/www/nfephp/xmls/NF-e/homologacao/enviadas/aprovadas/201605/{$chave}-protNFe.xml';
$pathXml = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/enviadas/aprovadas/201605/{$chave}-protNFe.xml";
$aResposta = array();

if (! $nfe->verificaValidade($pathXml, $aResposta)) {
    echo "<h1>NFe INVÁLIDA!!</h1>";
} else {
    echo "<h1>NFe Válida.</h1>";
}
echo '<br><br><pre>';
echo htmlspecialchars($nfe->soapDebug);
echo '</pre><br><pre>';
print_r($aResposta);
echo "</pre><br>";
