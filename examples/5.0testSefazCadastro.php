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
$content = file_get_contents('expired_certificate.pfx');

$tools = new Tools($configJson, Certificate::readPfx($content, 'associacao'));

//Somente para modelo 55, o modelo 65 evidentemente não possue 
//esse tipo de serviço
$tools->model('55');

//coloque a UF e escolha entre 
//CNPJ
//IE
//CPF
//pelo menos um dos três deverá ser indicado
//essa busca não funciona se não houver a disponibilidade do serviço na SEFAZ
$uf = 'SP';
$cnpj = '07003293000100';
$iest = '';
$cpf = '';
$response = $tools->sefazCadastro($uf, $cnpj, $iest, $cpf);

header('Content-type: text/xml; charset=UTF-8');
echo $response;

