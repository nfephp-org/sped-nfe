<?php

error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;
use NFePHP\NFe\Common\FakePretty;
use NFePHP\NFe\Factories\Contingency;

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
    
    $contingency = new Contingency();

    $acronym = 'SP';
    $motive = 'SEFAZ fora do AR';
    $type = 'EPEC';

    $status = $contingency->activate($acronym, $motive, $type);

    $content = file_get_contents('expired_certificate.pfx');
    $tools = new Tools($configJson, Certificate::readPfx($content, 'associacao'));
    $tools->model('55');
    $tools->setVerAplic('5.1.34');
    $tools->loadSoapClass($soap);
    $tools->contingency = $contingency;

    $xml = file_get_contents(__DIR__ . "/nfe.xml");
    $response = $tools->sefazEPEC($xml);
    file_put_contents(__DIR__. '/nfe_epec.xml', $xml);
    echo FakePretty::prettyPrint($response);
    
} catch (\Exception $e) {
    echo $e->getMessage();
}