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

    $std = new \stdClass();
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->tpAutor = 1; //1-emitente 2-destinatário 3-transportador indica quem está incluindo ou removendo atores
    //$std->verAplic = '1.2.3'; //opcional se inicado anteriormente - versão da aplicação que está gerando o evento
    $std->nSeqEvento = 1; //numero sequencial do evento, incrementar ao incluir outros ou remover
    $std->tpAutorizacao = 1; //0-não autorizo ou 1-autorizo
    $std->CNPJ = '12345678901234';
    $std->CPF = null;
    
    $response = $tools->sefazAtorInteressado($std);

    echo FakePretty::prettyPrint($response);
    
} catch (\Exception $e) {
    echo $e->getMessage();
}