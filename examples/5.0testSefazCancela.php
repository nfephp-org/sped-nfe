<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;
use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Common\Complements;

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

try {
    $tools = new Tools($configJson, Certificate::readPfx($content, 'associacao'));
    $tools->model('55');
    
    $chave = '35170399999999999999550010000000301000000300';
    $xJust = 'Desistencia do comprador no momento da retirada';
    $nProt = '135170001136476';
    $response = $tools->sefazCancela($chave, $xJust, $nProt);
    
    //você pode padronizar os dados de retorno atraves da classe abaixo
    //de forma a facilitar a extração dos dados do XML
    //NOTA: mas lembre-se que esse XML muitas vezes será necessário, 
    //      quando houver a necessidade de protocolos
    $stdCl = new Standardize($response);
    //nesse caso $std irá conter uma representação em stdClass do XML retornado
    $std = $stdCl->toStd();
    //nesse caso o $arr irá conter uma representação em array do XML retornado
    $arr = $stdCl->toArray();
    //nesse caso o $json irá conter uma representação em JSON do XML retornado
    $json = $stdCl->toJson();
    
    //verifique se o evento foi processado
    if ($std->cStat != 128) {
        //houve alguma falha e o evento não foi processado
        //TRATAR
    } else {
        $cStat = $std->retEvento->infEvento->cStat;
        if ($cStat == '101' || $cStat == '135' || $cStat == '155' ) {
            //SUCESSO PROTOCOLAR A SOLICITAÇÂO ANTES DE GUARDAR
            $xml = Complements::toAuthorize($tools->lastRequest, $response);
            //grave o XML protocolado e prossiga com outras tarefas de seu aplicativo
        } else {
            //houve alguma falha no evento 
            //TRATAR
        }
    }    
} catch (\Exception $e) {
    echo $e->getMessage();
    //TRATAR
}