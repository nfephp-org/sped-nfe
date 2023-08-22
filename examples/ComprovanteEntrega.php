<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;

//tanto o config.json como o certificado.pfx podem estar
//armazenados em uma base de dados, então não é necessário
///trabalhar com arquivos, este script abaixo serve apenas como
//exemplo durante a fase de desenvolvimento e testes.
$arr = [
    "atualizacao" => "2016-11-03 18:01:21",
    "tpAmb" => 2,
    "razaosocial" => "SUA RAZAO SOCIAL LTDA",
    "cnpj" => "99999999999999",
    "siglaUF" => "SP",
    "schemes" => "PL_009_V4",
    "versao" => '4.00',
    "tokenIBPT" => "AAAAAAA",
    "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
    "CSCid" => "000001",
    "proxyConf" => [
        "proxyIp" => "",
        "proxyPort" => "",
        "proxyUser" => "",
        "proxyPass" => ""
    ]
];
//monta o config.json
$configJson = json_encode($arr);

//carrega o conteudo do certificado.
$content = file_get_contents('fixtures/expired_certificate.pfx');

try {
    //intancia a classe tools
    $tools = new Tools($configJson, Certificate::readPfx($content, 'associacao'));
    //seta o modelo para 55
    $tools->model('55');

    $soap = new SoapFake();
    $soap->disableCertValidation();
    $tools->loadSoapClass($soap);

    $std = new \stdClass();
    $std->chNFe = '12345678901234567890123456789012345678901234'; //chave de 44 digitos da nota do fornecedor
    $std->imagem = 'kakakakakakakakak'; // aqui pode ser colocada uma imagem ou uma string que fará parte do hash
    $std->nSeqEvento = 1;
    $std->verAplic = '1.2.3'; //versão da aplicação que está gerando o evento
    $std->data_recebimento = '2021-04-25T10:34:13-03:00'; //data de recebimento
    $std->documento_recebedor = '12345678901'; //numero do documento do recebedor
    $std->nome_recebedor = 'Jose da Silva';
    //$std->latitude = -23.61849;
    //$std->longitude = -46.60987;
    $std->cancelar = false;

    $response = $tools->sefazComprovanteEntrega($std);

    $fake = NFePHP\NFe\Common\FakePretty::prettyPrint($response);
    //header('Content-type: text/plain; charset=UTF-8');
    echo $fake;

} catch (\Exception $e) {
    echo $e->getMessage();
}
