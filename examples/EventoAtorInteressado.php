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
    $std->chNFe = '42200714403043000122550010000056591412970518'; //chave de 44 digitos da nota do fornecedor
    $std->tpAutor = 1; //1-emitente 2-destinatário 3-transportador indica quem está incluindo ou removendo atores
    $std->verAplic = '1.2.3'; //versão da aplicação que está gerando o evento
    $std->nSeqEvento = 1; //numero sequencial do evento, incrementar ao incluir outros ou remover
    $std->tpAutorizacao = 1; //0-não autorizo ou 1-autorizo
    $std->CNPJ = '12345678901234';
    $std->CPF = null;
    
    $response = $tools->sefazAtorInteressado($std);
    
    $fake = NFePHP\NFe\Common\FakePretty::prettyPrint($response);
    //header('Content-type: text/plain; charset=UTF-8');
    echo $fake;
    
} catch (\Exception $e) {
    echo $e->getMessage();
}