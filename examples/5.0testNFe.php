<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../bootstrap.php';

use stdClass;
use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Tag;
use NFePHP\NFe\NFe;

//========================
//Montagem do XML
//========================
$nfe = new NFe('4.0');
//cada uma das TAG's deve ser adicionada na classe Make
//a ordem de adição não é importante
//o metodo de adição identifica cada classe e carrega em 
//suas propriedades internas para posterior construção do XML

//========================
//TAG <ide> [1 - 1] pai <infNFe>
//========================
$ide = new stdClass();
$ide->cUF = 23;
$ide->cNF = '10';//se não for passado será usado o numero da nota nNF
$ide->natOp = 'Venda de Produto';
$ide->indPag = 0;
$ide->mod = 55;
$ide->serie = 1;
$ide->nNF = 10;
$ide->dhEmi = new \DateTime();
$ide->dhSaiEnt = new \DateTime();//Não informar este campo para a NFC-e.
$ide->tpNF = 1;
$ide->idDest = 1;
$ide->cMunFG = 2304400;
$ide->tpImp = 1;
$ide->tpAmb = 2;
$ide->finNFe = 1;
$ide->indFinal = 0;
$ide->indPres = 9;
$ide->procEmi = 0;
$ide->verProc = '5.0.0';
$ide->cDV = 0;//não é importante será recalculado de qualquer forma
//se estiver em contingência setar os parametros
$contingency = new Contingency();
$ide->contingency = $contingency;
$ideClass = Tag::ide($ide);
die;
//adicionando <ide>
$nfe->add($ideClass);

//========================
//TAG <emit> [1 - 1] pai <infNFe>
//========================
$emit = new stdClass();
$emit->cnpj = '07278138000104';
$emit->cpf = ''; // Utilizado para CPF na nota
$emit->xNome = 'HIPERFERRO COMERCIAL DE ACOS LTDA';
$emit->xFant = 'HIPERFERRO';
$emit->ie = '060128933';
$emit->iest = '';
$emit->im = '';
$emit->cnae = '4744001';
$emit->crt = '3';
$emitClass = Tag::emit($emit);

//========================
//TAG <enderEmit> [1 - 1] pai <emit>
//SubClasse pertencente a Emit::class
//========================
$ender = new stdClass();
$ender->xLgr = 'Washington Soares';
$ender->nro = '8402';
$ender->xCpl = 'Qd. 38 Lt. 4,5 e 34';
$ender->xBairro = 'Messejana';
$ender->cMun = '2304400';
$ender->xMun = 'Fortaleza';
$ender->uf = 'CE';
$ender->cep = '60841032';
$ender->cPais = '1058';
$ender->xPais = 'Brasil';
$ender->fone = '32742488';
$enderEmitClass = Tag::enderEmit($ender);
//adicionando <enderEmit> à <emit>
$emitClass->enderEmit = $enderEmitClass;
//adicionando <emit>
//adicione a classe nfe apenas as tag matrizes
//que tem como pai a tag <infNFe>
$nfe->add($emitClass);

//========================
//TAG <dest> [0 - 1] pai <infNFe>
//========================
$dest = new stdClass();
$dest->cnpj = '00822602000124';
$dest->cpf = ''; // Utilizado para CPF na nota
$dest->idEstrangeiro = '';
$dest->xNome = 'Plotag Sistemas e Suprimentos Ltda';
$dest->indIEDest = 1;
$dest->ie = '114489114119';
$dest->ISUF = '';
$dest->IM = '';
$dest->email = '';
$destClass = Tag::dest($dest);

//========================
//TAG <enderDest>
//========================
$ender = new stdClass();
$ender->xLgr = 'Rua Solon';
$ender->nro = '558';
$ender->xCpl = '';
$ender->xBairro = 'Bom Retiro';
$ender->cMun = '3550308';
$ender->xMun = 'Sao Paulo';
$ender->uf = 'SP';
$ender->cep = '01127010';
$ender->cPais = '1058';
$ender->xPais = 'Brasil';
$ender->fone = '1123587604';
$enderDestClass = Tag::enderDest($ender);
//adicionando <dest>
$nfe->add($destClass);
//adicionando <enderDest>
$nfe->add($enderDestClass);

//========================
//TAG <refNFe>
//========================
$ref = new stdClass();
$ref->refNFe[] = '29161211351930000106550010000000151000000151';
$ref->refNFe[] = '35161211351930000106550010000000151000000151';
$ref->refNFe[] = '42161211351930000106550010000000151000000151';
$ref->refNFe[] = '11161211351930000106550010000000151000000151';
$ref->refNFe[] = '31161211351930000106550010000000151000000151';
$refNFeClass = Tag::refNFe($ref);
//adicionando <refNFe>
$nfe->add($refNFeClass);

//========================
//TAG <refCTe>
//========================
$ref = new stdClass();
$ref->refCTe[] = '29161211351930000106550010000000151000000151';
$ref->refCTe[] = '35161211351930000106550010000000151000000151';
$ref->refCTe[] = '42161211351930000106550010000000151000000151';
$ref->refCTe[] = '11161211351930000106550010000000151000000151';
$ref->refCTe[] = '31161211351930000106550010000000151000000151';
$refCTeClass = Tag::refCTe($ref);
//adicionando <refCTe>
$nfe->add($refCTeClass);

//========================
//TAG <refNF>
//========================
$ref = new stdClass();
$ref->cUF = 35;
$ref->aamm = 1612;
$ref->cnpj = '00822602000124';
$ref->mod = 1;
$ref->serie = 0;
$ref->nNF = 12345678; 
$refNFClass[] = Tag::refNF($ref);

$ref = new stdClass();
$ref->cUF = 35;
$ref->aamm = 1612;
$ref->cnpj = '00822602000124';
$ref->mod = 1;
$ref->serie = 0;
$ref->nNF = 12345679; 
$refNFClass[] = Tag::refNF($ref);
//adicionando <refNF>
foreach($refNFClass as $refNF) {
    $nfe->add($refNF);
}

//========================
//TAG <refNFP>
//========================
$ref = new stdClass();
$ref->cUF = 35;
$ref->aamm = 1610;
$ref->cnpj = '99999999000191';
$ref->cpf = '00378912411';
$ref->ie = '11110000000011';
$ref->mod = 1;
$ref->serie = 0;
$ref->nNF = 555; 
$refNFPClass[] = Tag::refNFP($ref);

$ref = new stdClass();
$ref->cUF = 35;
$ref->aamm = 1611;
$ref->cnpj = '99999999000191';
$ref->cpf = '00378912411';
$ref->ie = '11110000000011';
$ref->mod = 1;
$ref->serie = 0;
$ref->nNF = 666; 
$refNFPClass[] = Tag::refNFP($ref);
//adicionando <refNFP>
foreach($refNFPClass as $refNFP) {
    $nfe->add($refNFP);
}

//========================
//TAG <refECF>
//========================
$ref = new stdClass();
$ref->mod = '2A';
$ref->nECF = 111;
$ref->nCOO = 191;
$refECFClass[] = Tag::refECF($ref);

$ref = new stdClass();
$ref->mod = '2D';
$ref->nECF = 222;
$ref->nCOO = 234;
$refECFClass[] = Tag::refECF($ref);
//adicionando <refECF>
foreach($refECFClass as $refECF) {
    $nfe->add($refECF);
}

//========================
//TAG <retirada>
//========================
$ender = new stdClass();
$ender->cnpj = '00822602000124';
$ender->cpf = '';
$ender->xLgr = 'Rua Solon';
$ender->nro = '777';
$ender->xCpl = '';
$ender->xBairro = 'Bom Retiro';
$ender->cMun = '3550308';
$ender->xMun = 'Sao Paulo';
$ender->uf = 'SP';
$retiradaClass = Tag::retirada($ender);
//adicionando <retirada>
$nfe->add($retiradaClass);

//========================
//TAG <entrega>
//========================
$ender = new stdClass();
$ender->cnpj = '00822602000124';
$ender->cpf = '';
$ender->xLgr = 'Rua Solon';
$ender->nro = '111';
$ender->xCpl = '';
$ender->xBairro = 'Bom Retiro';
$ender->cMun = '3550308';
$ender->xMun = 'Sao Paulo';
$ender->uf = 'SP';
$entregaClass = Tag::entrega($ender);
//adicionando <entrega>
$nfe->add($entregaClass);

//========================
//TAG <autXML>
//========================
$aut = new stdClass();
$aut->cnpj = '00822602000124';
$aut->cpf = '';
$autXMLClass[] = Tag::autXML($aut);

$aut = new stdClass();
$aut->cnpj = '';
$aut->cpf = '00245611177';
$autXMLClass[] = Tag::autXML($aut);
//adicionando <autXML>
foreach($autXMLClass as $autXML) {
    $nfe->add($autXML);
}

//========================
//TAG <transp> [1 - 1] pai <infNFe>
//========================
$transp = new stdClass();

//========================
//TAG <transporta> [0 - 1] pai <transp>
//========================
$transporta = new stdClass();

//========================
//TAG <retTransp> [0 - 1] pai <transp>
//========================
$ret = new stdClass();

//========================
//TAG <veicTransp> [0 - 1] pai <transp>
//========================
$veic = new stdClass();

//========================
//TAG <reboque> [0 - 5] pai <transp>
//========================
$reboque = new stdClass();

//========================
//TAG <vol> [0 - 5000] pai <transp>
//========================
$vol = new stdClass();
$vol->qVol = 10;
$vol->esp = 'CX';
$vol->marca = 'BRAND';
$vol->nVol = '1234567';
$vol->pesoL = 2000;
$vol->pesoB = 2200;
$volClass[] = Tag::vol($vol);
//========================
//TAG <lacres> [0 - 5000] pai <vol>
//========================
$lacresClass = [];
for ($x=1; $x<1000; $x++) {
    $lacre = new stdClass();
    $lacre->nLacre = $x;
    $lacreClass[] = Tag::lacres($lacre);
}
//adicionando <lacres> ao <vol>
$volClass[0]->lacres = $lacresClass;
//adicionando <vol>
foreach ($volClass as $vol) {
    $nfe->add($vol);
}

//========================
//TAG <fat> [0 - 1] pai <cobr>
//mas considerar <infNFe>,
//pois <cobr> é criado quando necessário
//========================
$fat = new stdClass();
$fat->nFat = '123';
$fat->vOrig = 2000;
$fat->vDesc = 50;
$fat->vLiq = 1950;
$fatClass = Tag::fat($fat);
//adicionando <fat>
$nfe->add($fatClass);

//========================
//TAG <dup> [0 - 120] pai <cobr>
//mas considerar <infNFe>,
//pois <cobr> é criado quando necessário
//========================
$dup = new stdClass();
$dup->nDup = '1234/1';
$dup->dVenc = '2016-12-10';
$dup->vDup = 1000;
$dupClass[] = Tag::dup($dup);

$dup = new stdClass();
$dup->nDup = '1234/2';
$dup->dVenc = '2017-01-10';
$dup->vDup = 950;
$dupClass[] = Tag::dup($dup);
//adicionando <dup>
foreach($dupClass as $dup) {
    $nfe->add($dup);
} 

//========================
//TAG <pag> [0 - 100] pai <infNFe>
//========================
$pag = new stdClass();
$pag->tPag = 2;
$pag->vPag = 200;
$pagClass[] = Tag::pag($pag);

$pag = new stdClass();
$pag->tPag = 3;
$pag->vPag = 9999;
$pagClass[] = Tag::pag($pag);

//========================
//TAG <card> [0 - 1] pai <pag>
//========================
$card = new stdClass();
$card->cnpj = '12345678901234';
$card->tBand = 'SEILA';
$card->cAut = 'A2342-1232';
$cardClass = Tag::card($card);
//adicionando <card> à <pag>
//<card> somente para tPag = 3 ou 4
$pagClass[1]->card = $cardClass;

//adicionando <pag>
foreach($pagClass as $pag) {
    $nfe->add($pag);
}

//========================
//TAG <infAdic> [0 - 1] pai <infNFe>
//========================
$inf = new stdClass();
$inf->infAdFisco = 'TESTE INFADFISCO';
$inf->infCpl = 'TESTE INFCPL';
$infAdicClass = Tag::infAdic($inf);
//adicionando <infAdic>
$nfe->add($infAdicClass);

//========================
//TAG <obsCont>  [0 - 10] pai <infAdic>
//========================
$obs = new stdClass();
$obs->xCampo = 'email';
$obs->xTexto = 'teste@teste.com.br';
$obsContClass[] = Tag::obsCont($obs);

$obs = new stdClass();
$obs->xCampo = 'email';
$obs->xTexto = 'teste2@teste.com.br';
$obsContClass[] = Tag::obsCont($obs);

$obs = new stdClass();
$obs->xCampo = 'email';
$obs->xTexto = 'teste3@teste.com.br';
$obsContClass[] = Tag::obsCont($obs);
//adicionando <obsCont>
foreach($obsContClass as $obs) {
    $nfe->add($obs);
}

//========================
//TAG <obsFisco>   [0 - 10] pai <infAdic>
//========================
$obs = new stdClass();
$obs->xCampo = 'email';
$obs->xTexto = 'teste@teste.com.br';
$obsFiscoClass[] = Tag::obsFisco($obs);

$obs = new stdClass();
$obs->xCampo = 'email';
$obs->xTexto = 'teste2@teste.com.br';
$obsFiscoClass[] = Tag::obsFisco($obs);

$obs = new stdClass();
$obs->xCampo = 'email';
$obs->xTexto = 'teste3@teste.com.br';
$obsFiscoClass[] = Tag::obsFisco($obs);
//adicionando <obsFisco>
foreach($obsFiscoClass as $obs) {
    $nfe->add($obs);
}            

//========================
//TAG <procRef>   [0 - 100] pai <infAdic>
//========================
$obs = new stdClass();
$obs->nProc = '12345678901234567890';
$obs->indProc = 0;
$procRefClass[] = Tag::procRef($obs);

$obs = new stdClass();
$obs->nProc = 'ABCDEFGHIJKLMNOPQRSTUVXYWZ';
$obs->indProc = 2;
$procRefClass[] = Tag::procRef($obs);
//adicionando <procRef>
foreach($procRefClass as $obs) {
    $nfe->add($obs);
}            

//========================
//TAG <exporta> [0 - 1] pai <infNFe>
//========================
$exporta = new stdClass();
$exporta->ufSaidaPais = 'SP';
$exporta->xLocExporta = 'Santos';
$exporta->xLocDespacho = 'Recinto alfandegario 111';
$exportaClass = Tag::exporta($exporta);
//adicionando <exporta>
$nfe->add($exportaClass);

//========================
//TAG <compra> [0 - 1] pai <infAdic>
//========================
$compra = new stdClass();
$compra->xNEmp = '123456789';
$compra->xPed = 'PED 1234';
$compra->xCont = 'CT 909090';
$compraClass = Tag::compra($compra);
//adicionando <compra>
$nfe->add($compraClass);

//========================
//TAG <cana> [0 - 1] pai <infAdic>
//========================
$cana = new stdClass();
$cana->safra = '2017';
$cana->ref = '01/2017';
$cana->qTotMes = 78451.45;
$cana->qTotAnt = 10.50;
$cana->qTotGer = 78461.95;
$cana->vFor = 80788.20;
$cana->vTotDed = 0; //será recalculado com os dados da tag <deduc>, se houver
$cana->vLiqFor = 80788.20;//será recalculado como (vFor-vTotDed)
$canaClass = Tag::cana($cana);
//adicionando <cana>
$nfe->add($canaClass);

//========================
//TAG <forDia> [0 - 31] pai <cana>
//========================
$dia = new stdClass();
$dia->dia = 1;
$dia->qtde = 10111.1;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 2;
$dia->qtde = 2222.22;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 3;
$dia->qtde = 3333.33;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 4;
$dia->qtde = 4444.44;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 5;
$dia->qtde = 5555.55;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 6;
$dia->qtde = 6666.66;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 7;
$dia->qtde = 77777.77;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 8;
$dia->qtde = 88888.88;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 9;
$dia->qtde = 99999.99;
$forDiaClass[] = Tag::forDia($dia);

$dia = new stdClass();
$dia->dia = 10;
$dia->qtde = 101010.10;
$forDiaClass[] = Tag::forDia($dia);
//adicionando <forDia>
foreach($forDiaClass as $dia) {
    $nfe->add($dia);
}

//========================
//TAG <deduc> [0 - 10] pai <cana>
//========================
$deduc = new stdClass();
$deduc->xDed = 'Teste de Deducao 1';
$deduc->vDed = 10000.00;
$deducClass[] = Tag::deduc($deduc);

$deduc = new stdClass();
$deduc->xDed = 'Teste de Deducao 2';
$deduc->vDed = 3.00;
$deducClass[] = Tag::deduc($deduc);
//adicionando <deduc>
foreach($deducClass as $ded) {
    $nfe->add($ded);
}

//o método build faz a construção com base nas tags inclusas
$nfe->build();

//o método __toString() irá retornar o XML da classe Make
header('Content-type: text/xml; charset=UTF-8');
echo "{$nfe}";