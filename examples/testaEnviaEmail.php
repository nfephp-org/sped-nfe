<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

//NOTA: o envio de email com o DANFE somente funciona para modelo 55
//      o modelo 65 nunca requer o envio do DANFCE por email

use NFePHP\NFe\Tools;

$nfe = new Tools('../config/config.json');
$nfe->setModelo('55');

$chave = '52160500067985000172550010000000101000000100';
$pathXml = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/enviadas/aprovadas/201605/{$chave}-protNFe.xml";
$pathPdf = "D:/xampp/htdocs/GIT-nfephp-org/nfephp/xmls/NF-e/homologacao/pdf/201605/{$chave}-danfe.pdf";

$aMails = array('nfe@chinnonsantos.com'); //se for um array vazio a classe Mail irá pegar os emails do xml
$templateFile = ''; //se vazio usará o template padrão da mensagem
$comPdf = true; //se true, anexa a DANFE no e-mail
try {
    $nfe->enviaMail($pathXml, $aMails, $templateFile, $comPdf, $pathPdf);
    echo "DANFE enviada com sucesso!!!";
} catch (NFePHP\Common\Exception\RuntimeException $e) {
    echo $e->getMessage();
}