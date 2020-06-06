<?php

error_reporting(E_ERROR);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use NFePHP\NFe\Tools;
use NFePHP\NFe\Make;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapFake;

$arr = [
    "atualizacao" => "2017-02-20 09:11:21",
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
$pfxcontent = file_get_contents('fixtures/expired_certificate.pfx');



$tools = new Tools($configJson, Certificate::readPfx($pfxcontent, 'associacao'));
//$tools->disableCertValidation(true); //tem que desabilitar
$tools->model('65');

try {

    $make = new Make();


    //infNFe OBRIGATÓRIA
    $std = new \stdClass();
    $std->Id = '';
    $std->versao = '4.00';
    $infNFe = $make->taginfNFe($std);

    //ide OBRIGATÓRIA
    $std = new \stdClass();
    $std->cUF = 14;
    $std->cNF = '03701267';
    $std->natOp = 'VENDA CONSUMIDOR';
    $std->mod = 65;
    $std->serie = 1;
    $std->nNF = 100;
    $std->dhEmi = (new \DateTime())->format('Y-m-d\TH:i:sP');
    $std->dhSaiEnt = null;
    $std->tpNF = 1;
    $std->idDest = 1;
    $std->cMunFG = 1400100;
    $std->tpImp = 1;
    $std->tpEmis = 1;
    $std->cDV = 2;
    $std->tpAmb = 2;
    $std->finNFe = 1;
    $std->indFinal = 1;
    $std->indPres = 1;
    $std->procEmi = 3;
    $std->verProc = '4.13';
    $std->dhCont = null;
    $std->xJust = null;
    $ide = $make->tagIde($std);

    //emit OBRIGATÓRIA
    $std = new \stdClass();
    $std->xNome = 'SUA RAZAO SOCIAL LTDA';
    $std->xFant = 'RAZAO';
    $std->IE = '111111111';
    $std->IEST = null;
    //$std->IM = '95095870';
    $std->CNAE = '4642701';
    $std->CRT = 1;
    $std->CNPJ = '99999999999999';
    //$std->CPF = '12345678901'; //NÃO PASSE TAGS QUE NÃO EXISTEM NO CASO
    $emit = $make->tagemit($std);

    //enderEmit OBRIGATÓRIA
    $std = new \stdClass();
    $std->xLgr = 'Avenida Getúlio Vargas';
    $std->nro = '5022';
    $std->xCpl = 'LOJA 42';
    $std->xBairro = 'CENTRO';
    $std->cMun = 1400100;
    $std->xMun = 'BOA VISTA';
    $std->UF = 'RR';
    $std->CEP = '69301030';
    $std->cPais = 1058;
    $std->xPais = 'Brasil';
    $std->fone = '55555555';
    $ret = $make->tagenderemit($std);

    //dest OPCIONAL
    $std = new \stdClass();
    $std->xNome = 'Eu Ltda';
    $std->CNPJ = '01234123456789';
    //$std->CPF = '12345678901';
    //$std->idEstrangeiro = 'AB1234';
    $std->indIEDest = 9;
    //$std->IE = '';
    //$std->ISUF = '12345679';
    //$std->IM = 'XYZ6543212';
    $std->email = 'seila@seila.com.br';
    $dest = $make->tagdest($std);

    //enderDest OPCIONAL
    $std = new \stdClass();
    $std->xLgr = 'Avenida Sebastião Diniz';
    $std->nro = '458';
    $std->xCpl = null;
    $std->xBairro = 'CENTRO';
    $std->cMun = 1400100;
    $std->xMun = 'Boa Vista';
    $std->UF = 'RR';
    $std->CEP = '69301088';
    $std->cPais = 1058;
    $std->xPais = 'Brasil';
    $std->fone = '1111111111';
    $ret = $make->tagenderdest($std);


    //prod OBRIGATÓRIA
    $std = new \stdClass();
    $std->item = 1;
    $std->cProd = '1111';
    $std->cEAN = "SEM GTIN";
    $std->xProd = 'CAMISETA REGATA GG';
    $std->NCM = 61052000;
    //$std->cBenef = 'ab222222';
    $std->EXTIPI = '';
    $std->CFOP = 5101;
    $std->uCom = 'UNID';
    $std->qCom = 1;
    $std->vUnCom = 100.00;
    $std->vProd = 100.00;
    $std->cEANTrib = "SEM GTIN"; //'6361425485451';
    $std->uTrib = 'UNID';
    $std->qTrib = 1;
    $std->vUnTrib = 100.00;
    //$std->vFrete = 0.00;
    //$std->vSeg = 0;
    //$std->vDesc = 0;
    //$std->vOutro = 0;
    $std->indTot = 1;
    //$std->xPed = '12345';
    //$std->nItemPed = 1;
    //$std->nFCI = '12345678-1234-1234-1234-123456789012';
    $prod = $make->tagprod($std);

    $tag = new \stdClass();
    $tag->item = 1;
    $tag->infAdProd = 'DE POLIESTER 100%';
    $make->taginfAdProd($tag);

    //Imposto 
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->vTotTrib = 25.00;
    $make->tagimposto($std);

    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->orig = 0;
    $std->CSOSN = '102';
    $std->pCredSN = 0.00;
    $std->vCredICMSSN = 0.00;
    $std->modBCST = null;
    $std->pMVAST = null;
    $std->pRedBCST = null;
    $std->vBCST = null;
    $std->pICMSST = null;
    $std->vICMSST = null;
    $std->vBCFCPST = null; //incluso no layout 4.00
    $std->pFCPST = null; //incluso no layout 4.00
    $std->vFCPST = null; //incluso no layout 4.00
    $std->vBCSTRet = null;
    $std->pST = null;
    $std->vICMSSTRet = null;
    $std->vBCFCPSTRet = null; //incluso no layout 4.00
    $std->pFCPSTRet = null; //incluso no layout 4.00
    $std->vFCPSTRet = null; //incluso no layout 4.00
    $std->modBC = null;
    $std->vBC = null;
    $std->pRedBC = null;
    $std->pICMS = null;
    $std->vICMS = null;
    $std->pRedBCEfet = null;
    $std->vBCEfet = null;
    $std->pICMSEfet = null;
    $std->vICMSEfet = null;
    $std->vICMSSubstituto = null;
    $make->tagICMSSN($std);

    //PIS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->CST = '99';
    //$std->vBC = 1200;
    //$std->pPIS = 0;
    $std->vPIS = 0.00;
    $std->qBCProd = 0;
    $std->vAliqProd = 0;
    $pis = $make->tagPIS($std);

    //COFINS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->CST = '99';
    $std->vBC = null;
    $std->pCOFINS = null;
    $std->vCOFINS = 0.00;
    $std->qBCProd = 0;
    $std->vAliqProd = 0;
    $make->tagCOFINS($std);

    //icmstot OBRIGATÓRIA
    $std = new \stdClass();
    //$std->vBC = 100;
    //$std->vICMS = 0;
    //$std->vICMSDeson = 0;
    //$std->vFCPUFDest = 0;
    //$std->vICMSUFDest = 0;
    //$std->vICMSUFRemet = 0;
    //$std->vFCP = 0;
    //$std->vBCST = 0;
    //$std->vST = 0;
    //$std->vFCPST = 0;
    //$std->vFCPSTRet = 0.23;
    //$std->vProd = 2000;
    //$std->vFrete = 100;
    //$std->vSeg = null;
    //$std->vDesc = null;
    //$std->vII = 12;
    //$std->vIPI = 23;
    //$std->vIPIDevol = 9;
    //$std->vPIS = 6;
    //$std->vCOFINS = 25;
    //$std->vOutro = null;
    //$std->vNF = 2345.83;
    //$std->vTotTrib = 798.12;
    $icmstot = $make->tagicmstot($std);

    //transp OBRIGATÓRIA
    $std = new \stdClass();
    $std->modFrete = 0;
    $transp = $make->tagtransp($std);


    //pag OBRIGATÓRIA
    $std = new \stdClass();
    $std->vTroco = 0;
    $pag = $make->tagpag($std);

    //detPag OBRIGATÓRIA
    $std = new \stdClass();
    $std->indPag = 1;
    $std->tPag = '01';
    $std->vPag = 100.00;
    $detpag = $make->tagdetpag($std);

    //infadic
    $std = new \stdClass();
    $std->infAdFisco = '';
    $std->infCpl = '';
    $info = $make->taginfadic($std);

    $std = new stdClass();
    $std->CNPJ = '99999999999999'; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
    $std->xContato = 'Fulano de Tal'; //Nome da pessoa a ser contatada
    $std->email = 'fulano@soft.com.br'; //E-mail da pessoa jurídica a ser contatada
    $std->fone = '1155551122'; //Telefone da pessoa jurídica/física a ser contatada
    //$std->CSRT = 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO'; //Código de Segurança do Responsável Técnico
    //$std->idCSRT = '01'; //Identificador do CSRT
    $make->taginfRespTec($std);

    $make->monta();
    $xml = $make->getXML();
    

    $xml = $tools->signNFe($xml);
    
    header('Content-Type: application/xml; charset=utf-8');
    echo $xml;
    
} catch (\Exception $e) {
    echo $e->getMessage();
}    



