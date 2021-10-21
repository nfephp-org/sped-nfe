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
    $std->cProd = '00341';
    $std->cEAN = 'SEM GTIN';
    $std->cEANTrib = 'SEM GTIN';
    $std->xProd = 'Produto com serviço';
    $std->NCM = '96081000';
    $std->CFOP = '5933';
    $std->uCom = 'JG';
    $std->uTrib = 'JG';
    $std->cBarra = NULL;
    $std->cBarraTrib = NULL;
    $std->qCom = '1';
    $std->qTrib = '1';
    $std->vUnCom = '200';
    $std->vUnTrib = '200';
    $std->vProd = '200';
    $std->vDesc = NULL;
    $std->vOutro = NULL;
    $std->vSeg = NULL;
    $std->vFrete = NULL;
    $std->cBenef = NULL;
    $std->xPed = NULL;
    $std->nItemPed = NULL;
    $std->indTot = 1;
    $make->tagprod($std);
    
    //PIS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->CST = '99';
    $std->vBC = 200;
    $std->pPIS = 0.65;
    $std->vPIS = 13;
    $pis = $make->tagPIS($std);
    
    //COFINS
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->CST = '99';
    $std->vBC = 200;
    $std->pCOFINS = 3;
    $std->vCOFINS = 60;
    $make->tagCOFINS($std);

    // Monta a tag de impostos mas não adiciona no xml
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->vBC = 2.0;
    $std->vAliq = 8.0;
    $std->vISSQN = 0.16;
    $std->cMunFG = 1300029;
    $std->cMun = 1300029;
    $std->cPais = '1058';
    $std->cListServ = '01.01';
    $std->indISS = 1;
    $std->indIncentivo = 2;
    // Adiciona a tag de imposto ISSQN no xml
    $make->tagISSQN($std);

    //Imposto
    $std = new stdClass();
    $std->item = 1; //item da NFe
    $std->vTotTrib = 0;
    $make->tagimposto($std);

    // Item 2
    //prod OBRIGATÓRIA
    $std = new \stdClass();
    $std->item = 2; //item da NFe
    $std->cProd = '00065';
    $std->cEAN = 'SEM GTIN';
    $std->cEANTrib = 'SEM GTIN';
    $std->xProd = 'Coca Cola Lata 350 ml';
    $std->NCM = '22021000';
    $std->CFOP = '5101';
    $std->uCom = 'LAT';
    $std->uTrib = 'LAT';
    $std->cBarra = NULL;
    $std->cBarraTrib = NULL;
    $std->qCom = '1';
    $std->qTrib = '1';
    $std->vUnCom = '10.00';
    $std->vUnTrib = '10.00';
    $std->vProd = '10.00';
    $std->vDesc = NULL;
    $std->vOutro = NULL;
    $std->vSeg = NULL;
    $std->vFrete = NULL;
    $std->cBenef = NULL;
    $std->xPed = NULL;
    $std->nItemPed = NULL;
    $std->indTot = 1;
    // Como aqui se trata de um produto comum, não precisa passar a tag do imposto para a tag prod
    $prod = $make->tagprod($std);

    //Imposto
    $std = new stdClass();
    $std->item = 2; //item da NFe
    $std->vTotTrib = 0;
    $make->tagimposto($std);

    $std = new stdClass();
    $std->item = 2; //item da NFe
    $std->orig = '0';
    $std->CST = '00';
    $std->vICMS = 1.8;
    $std->pICMS = 18.0;
    $std->vBC = 10.00;
    $std->modBC = '3';
    $std->pFCP = NULL;
    $std->vFCP = NULL;
    $std->vBCFCP = NULL;
    $std->pRedBC = 0.0;
    $make->tagICMS($std);

    //PIS
    $std = new stdClass();
    $std->item = 2; //item da NFe
    $std->CST = '65';
    $std->vBC = 10;
    $std->pPIS = 0.65;
    $std->vPIS = 0.65;
    $pis = $make->tagPIS($std);

    //COFINS
    $std = new stdClass();
    $std->item = 2; //item da NFe
    $std->CST = '99';
    $std->vBC = 10;
    $std->pCOFINS = 3;
    $std->vCOFINS = 3;
    $make->tagCOFINS($std);

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
    $std->indPag = '0';
    $std->xPag = NULL;
    $std->tPag = '01';
    $std->vPag = 2.01;
    $detpag = $make->tagdetpag($std);

    $std = new stdClass();
    $std->CNPJ = '99999999999999'; //CNPJ da pessoa jurídica responsável pelo sistema utilizado na emissão do documento fiscal eletrônico
    $std->xContato = 'Fulano de Tal'; //Nome da pessoa a ser contatada
    $std->email = 'fulano@soft.com.br'; //E-mail da pessoa jurídica a ser contatada
    $std->fone = '1155551122'; //Telefone da pessoa jurídica/física a ser contatada
    //$std->CSRT = 'G8063VRTNDMO886SFNK5LDUDEI24XJ22YIPO'; //Código de Segurança do Responsável Técnico
    //$std->idCSRT = '01'; //Identificador do CSRT
    $make->taginfRespTec($std);
    
    $std = new \stdClass();
    $make->tagICMSTot($std);
    
    $std = new \stdClass();
    $std->dCompet = '2010-09-12';
    $std->cRegTrib = 6;
    $make->tagISSQNTot($std);
    $make->tagISSQNTot($std);

    $make->monta();
    $xml = $make->getXML();

    $xml = $tools->signNFe($xml);

    header('Content-Type: application/xml; charset=utf-8');
    echo $xml;
} catch (\Exception $e) {
    echo $e->getMessage();
}
