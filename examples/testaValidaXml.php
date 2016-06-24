<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$nfe->setModelo('55');

$chave = '52160500067985000172550010000000101000000100';
$tpAmb = '2';
$xml = "/var/www/nfe/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Linux
//$xml = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/assinadas/{$chave}-nfe.xml"; // Ambiente Windows

if (! $nfe->validarXml($xml) || sizeof($nfeTools->errors)) {
    echo "<h3>Eita !?! Tem bicho na linha .... </h3>";    
    foreach ($nfe->errors as $erro) {
        if (is_array($erro)) { 
            foreach ($erro as $err) {
                echo "$err <br>";
            }
        } else {
            echo "$erro <br>";
        }
    }
    exit;
}
echo "NFe Valida !";
