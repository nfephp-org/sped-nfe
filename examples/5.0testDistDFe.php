<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapCurl;

//tanto o config.json como o certificado.pfx podem estar
//armazenados em uma base de dados, então não é necessário 
///trabalhar com arquivos, este script abaixo serve apenas como 
//exemplo durante a fase de desenvolvimento e testes.
$arr = [
    "atualizacao" => "2017-02-20 09:11:21",
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
$configJson = json_encode($arr);
$pfxcontent = file_get_contents('fixtures/expired_certificate.pfx');

$tools = new Tools($configJson, Certificate::readPfx($pfxcontent, 'associacao'));
$tools->model('55');

//sempre que ativar a contingência pela primeira vez essa informação deverá ser 
//gravada na base de dados ou em um arquivo para uso posterior, até que a mesma seja 
//desativada pelo usuário, essa informação não é persistida automaticamente e depende 
//de ser gravada pelo ERP
$contingencia = $tools->contingency->deactivate();

//e se necessário carregada novamente quando a classe for instanciada
$tools->contingency->load($contingencia);

//executa a busca por documentos
$response = $tools->sefazDistDFe(
    'AN',
    $arr['cnpj'],
    0,
    0
);

echo "<pre>";
print_r($response);
echo "</pre>";
