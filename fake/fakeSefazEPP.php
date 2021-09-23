<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;
use NFePHP\NFe\Common\FakePretty;

try {

    $arr = [
        "atualizacao" => "2016-11-03 18:01:21",
        "tpAmb"       => 2,
        "razaosocial" => "SUA RAZAO SOCIAL LTDA",
        "cnpj"        => "99999999999999",
        "siglaUF"     => "SP",
        "schemes"     => "PL_009_V4",
        "versao"      => '4.00',
        "tokenIBPT"   => "AAAAAAA",
        "CSC"         => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
        "CSCid"       => "000001",
        "proxyConf"   => [
            "proxyIp"   => "",
            "proxyPort" => "",
            "proxyUser" => "",
            "proxyPass" => ""
        ]
    ];
    $configJson = json_encode($arr);
    $soap = new SoapFake();
    $soap->disableCertValidation(true);

    $content = file_get_contents('expired_certificate.pfx');
    $tools = new Tools($configJson, Certificate::readPfx($content, 'associacao'));
    $tools->model('55');
    $tools->setVerAplic('5.1.34');
    $tools->loadSoapClass($soap);
    
    $chave = "35345678901234567890123456789012345678901234";
    $nProt = '1234567890';
    $itens = [
        [1, 111],
        [2, 222],
        [3, 333]
    ];
    $tipo = 1;
    $nSeqEvento = 1;
    $response = $tools->sefazEPP($chave, $nProt, $itens, $tipo, $nSeqEvento);

    echo FakePretty::prettyPrint($response);
    
} catch (\Exception $e) {
    echo $e->getMessage();
}