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
    //$std->verAplic = '1.2.3'; //opcional se declarado anteriormente - versão da aplicação que está gerando o evento
    $std->nSeqEvento = 1;
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->imagem = 'kakakakakakakakak'; // aqui pode ser colocada uma imagem ou uma string que fará parte do hash
    $std->latitude = null;
    $std->longitude = null;
    $std->data_tentativa = '2021-04-25T10:34:13-03:00'; //data de recebimento
    $std->tentativas = 3;
    $std->tipo_motivo = 1;
        //1 – Recebedor não encontrado
        //2 – Recusa do recebedor
        //3 – Endereço inexistente
        //4 – Outros (exige informar justificativa)
    $std->justificativa = null;
    $std->cancelar = false; //permite cancelar um registro de insucesso de entrega se for true

    $response = $tools->sefazInsucessoEntrega($std);

    echo FakePretty::prettyPrint($response);

} catch (\Exception $e) {
    echo $e->getMessage();
}
