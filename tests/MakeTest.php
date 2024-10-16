<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Make;
use PHPUnit\Framework\TestCase;

class MakeTest extends TestCase
{
    /**
     * @var Make
     */
    protected $make;

    public function testTaginfNFe()
    {
        $std = new \stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';

        $infNFe = $this->make->taginfNFe($std);

        $this->assertInstanceOf(\DOMElement::class, $infNFe);
        $this->assertEquals('NFe' . $std->Id, $infNFe->getAttribute('Id'));
        $this->assertEquals($std->versao, $infNFe->getAttribute('versao'));
        $this->assertEmpty($infNFe->getAttribute('pk_nItem'));
    }

    public function testTaginfNFeComPkNItem()
    {
        $std = new \stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $std->pk_nItem = '1';

        $infNFe = $this->make->taginfNFe($std);

        $this->assertInstanceOf(\DOMElement::class, $infNFe);
        $this->assertEquals('NFe' . $std->Id, $infNFe->getAttribute('Id'));
        $this->assertEquals($std->versao, $infNFe->getAttribute('versao'));
        $this->assertEquals($std->pk_nItem, $infNFe->getAttribute('pk_nItem'));
    }

    public function testTaginfNFeSemChaveDeAcesso()
    {
        $std = new \stdClass();
        $std->versao = '4.00';

        $infNFe = $this->make->taginfNFe($std);

        $this->assertInstanceOf(\DOMElement::class, $infNFe);
        $this->assertEquals('NFe', $infNFe->getAttribute('Id'));
        $this->assertEmpty($this->make->getChave());
        $this->assertEquals($std->versao, $infNFe->getAttribute('versao'));
    }

    public function testTagideVersaoQuantroPontoZeroModeloCinquentaECinco()
    {
        $std = new \stdClass();
        $std->versao = '4.00';
        $this->make->taginfNFe($std);

        $std = new \stdClass();
        $std->cUF = '50';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->indPag = '0';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2018-06-23T17:45:49-03:00';
        $std->dhSaiEnt = '2018-06-23T17:45:49-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '5002704';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '2';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';

        $ide = $this->make->tagide($std);

        $this->assertEquals($std->cUF, $ide->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->assertEquals($std->cNF, $ide->getElementsByTagName('cNF')->item(0)->nodeValue);
        $this->assertEquals($std->natOp, $ide->getElementsByTagName('natOp')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('indPag')->item(0));
        $this->assertEquals($std->mod, $ide->getElementsByTagName('mod')->item(0)->nodeValue);
        $this->assertEquals($std->serie, $ide->getElementsByTagName('serie')->item(0)->nodeValue);
        $this->assertEquals($std->nNF, $ide->getElementsByTagName('nNF')->item(0)->nodeValue);
        $this->assertEquals($std->dhEmi, $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue);
        $this->assertEquals($std->dhSaiEnt, $ide->getElementsByTagName('dhSaiEnt')->item(0)->nodeValue);
        $this->assertEquals($std->tpNF, $ide->getElementsByTagName('tpNF')->item(0)->nodeValue);
        $this->assertEquals($std->idDest, $ide->getElementsByTagName('idDest')->item(0)->nodeValue);
        $this->assertEquals($std->cMunFG, $ide->getElementsByTagName('cMunFG')->item(0)->nodeValue);
        $this->assertEquals($std->cDV, $ide->getElementsByTagName('cDV')->item(0)->nodeValue);
        $this->assertEquals($std->tpAmb, $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue);
        $this->assertEquals($std->finNFe, $ide->getElementsByTagName('finNFe')->item(0)->nodeValue);
        $this->assertEquals($std->indFinal, $ide->getElementsByTagName('indFinal')->item(0)->nodeValue);
        $this->assertEquals($std->indPres, $ide->getElementsByTagName('indPres')->item(0)->nodeValue);
        $this->assertEquals($std->procEmi, $ide->getElementsByTagName('procEmi')->item(0)->nodeValue);
        $this->assertEquals($std->verProc, $ide->getElementsByTagName('verProc')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('dhCont')->item(0));
        $this->assertEmpty($ide->getElementsByTagName('xJust')->item(0));
    }

    public function testTagideVersaoQuatroPontoZeroCamposObrigatoriosModeloCinquentaECinco()
    {
        $std = new \stdClass();
        $std->versao = '4.00';

        $this->make->taginfNFe($std);
        $std = new \stdClass();
        $std->cUF = '';
        $std->cNF = '78888888';
        $std->natOp = '';
        $std->mod = '';
        $std->serie = '';
        $std->nNF = '';
        $std->dhEmi = '';
        $std->tpNF = '';
        $std->idDest = '';
        $std->cMunFG = '';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '';
        $std->tpAmb = '';
        $std->finNFe = '';
        $std->indFinal = '';
        $std->indPres = '';
        $std->procEmi = '';
        $std->verProc = '';

        $ide = $this->make->tagide($std);

        $this->assertEmpty($ide->getElementsByTagName('cUF')->item(0)->nodeValue);
        //$this->assertStringContainsString('cUF', $this->make->dom->errors[0]);
        $this->assertEquals('78888888', $ide->getElementsByTagName('cNF')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('natOp')->item(0)->nodeValue);
        //$this->assertStringContainsString('natOp', $this->make->dom->errors[1]);
        //$this->assertStringContainsString('mod', $this->make->dom->errors[2]);
        //$this->assertStringContainsString('serie', $this->make->dom->errors[3]);
        //$this->assertStringContainsString('nNF', $this->make->dom->errors[4]);
        //$this->assertStringContainsString('dhEmi', $this->make->dom->errors[5]);
        //$this->assertStringContainsString('tpNF', $this->make->dom->errors[6]);
        //$this->assertStringContainsString('idDest', $this->make->dom->errors[7]);
        //$this->assertStringContainsString('cMunFG', $this->make->dom->errors[8]);
        $this->assertEquals('0', $ide->getElementsByTagName('cDV')->item(0)->nodeValue);
        //$this->assertStringContainsString('tpAmb', $this->make->dom->errors[9]);
        //$this->assertStringContainsString('finNFe', $this->make->dom->errors[10]);
        //$this->assertStringContainsString('indFinal', $this->make->dom->errors[11]);
        //$this->assertStringContainsString('indPres', $this->make->dom->errors[12]);
        //$this->assertStringContainsString('procEmi', $this->make->dom->errors[13]);
        //$this->assertStringContainsString('verProc', $this->make->dom->errors[14]);
    }

    public function testTagideVersaoQuantroPontoZeroModeloCinquentaECincoEmContigencia()
    {
        $std = new \stdClass();
        $std->versao = '4.00';

        $this->make->taginfNFe($std);

        $std = new \stdClass();
        $std->dhCont = '2018-06-26T17:45:49-03:00';
        $std->xJust = 'SEFAZ INDISPONIVEL';

        $ide = $this->make->tagide($std);

        $this->assertEquals($std->dhCont, $ide->getElementsByTagName('dhCont')->item(0)->nodeValue);
        $this->assertEquals($std->xJust, $ide->getElementsByTagName('xJust')->item(0)->nodeValue);
    }

    public function testTagideVersaoQuantroPontoZeroModeloSessentaECinco()
    {
        $std = new \stdClass();
        $std->versao = '4.00';

        $this->make->taginfNFe($std);

        $std = new \stdClass();
        $std->cUF = '50';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->indPag = '1';
        $std->mod = '65';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2018-06-23T17:45:49-03:00';
        $std->dhSaiEnt = null;
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '5002704';
        $std->tpImp = '4';
        $std->tpEmis = '1';
        $std->cDV = '2';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '4';
        $std->procEmi = '0';
        $std->verProc = '5.0';

        $ide = $this->make->tagide($std);

        $this->assertEquals($std->cUF, $ide->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->assertEquals($std->cNF, $ide->getElementsByTagName('cNF')->item(0)->nodeValue);
        $this->assertEquals($std->natOp, $ide->getElementsByTagName('natOp')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('indPag')->item(0));
        $this->assertEquals($std->mod, $ide->getElementsByTagName('mod')->item(0)->nodeValue);
        $this->assertEquals($std->serie, $ide->getElementsByTagName('serie')->item(0)->nodeValue);
        $this->assertEquals($std->nNF, $ide->getElementsByTagName('nNF')->item(0)->nodeValue);
        $this->assertEquals($std->dhEmi, $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('dhSaiEnt')->item(0));
        $this->assertEquals($std->tpNF, $ide->getElementsByTagName('tpNF')->item(0)->nodeValue);
        $this->assertEquals($std->idDest, $ide->getElementsByTagName('idDest')->item(0)->nodeValue);
        $this->assertEquals($std->cMunFG, $ide->getElementsByTagName('cMunFG')->item(0)->nodeValue);
        $this->assertEquals($std->cDV, $ide->getElementsByTagName('cDV')->item(0)->nodeValue);
        $this->assertEquals($std->tpAmb, $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue);
        $this->assertEquals($std->finNFe, $ide->getElementsByTagName('finNFe')->item(0)->nodeValue);
        $this->assertEquals($std->indFinal, $ide->getElementsByTagName('indFinal')->item(0)->nodeValue);
        $this->assertEquals($std->indPres, $ide->getElementsByTagName('indPres')->item(0)->nodeValue);
        $this->assertEquals($std->procEmi, $ide->getElementsByTagName('procEmi')->item(0)->nodeValue);
        $this->assertEquals($std->verProc, $ide->getElementsByTagName('verProc')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('dhCont')->item(0));
        $this->assertEmpty($ide->getElementsByTagName('xJust')->item(0));
    }

    public function test_tagrefNFe(): void
    {
        $std = new \stdClass();
        $std->refNFe = '35150271780456000160550010000253101000253101';
        $refNFe = $this->make->tagrefNFe($std);

        $this->assertEquals($std->refNFe, $refNFe->nodeValue);
        $this->assertEquals('refNFe', $refNFe->nodeName);
    }

    public function test_tagrefNF(): void
    {
        $std = new \stdClass();
        $std->cUF = 35;
        $std->AAMM = 1412;
        $std->CNPJ = '52297850000105';
        $std->mod = '01';
        $std->serie = 3;
        $std->nNF = 587878;
        $refNF = $this->make->tagrefNF($std);

        $this->assertEquals($std->cUF, $refNF->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->assertEquals($std->AAMM, $refNF->getElementsByTagName('AAMM')->item(0)->nodeValue);
        $this->assertEquals($std->CNPJ, $refNF->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals($std->mod, $refNF->getElementsByTagName('mod')->item(0)->nodeValue);
        $this->assertEquals($std->serie, $refNF->getElementsByTagName('serie')->item(0)->nodeValue);
        $this->assertEquals($std->nNF, $refNF->getElementsByTagName('nNF')->item(0)->nodeValue);

        $this->assertEquals('refNF', $refNF->nodeName);
    }

    public function test_tagrefNFP(): void
    {
        $std = new \stdClass();
        $std->cUF = 35;
        $std->AAMM = 1502;
        $std->CNPJ = '00940734000150';
        $std->IE = 'ISENTO';
        $std->mod = '04';
        $std->serie = 0;
        $std->nNF = 5578;

        $refNFP = $this->make->tagrefNFP($std);
        $this->assertEquals('refNFP', $refNFP->nodeName);

        $this->assertEquals($std->cUF, $refNFP->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->assertEquals($std->AAMM, $refNFP->getElementsByTagName('AAMM')->item(0)->nodeValue);
        $this->assertEquals($std->CNPJ, $refNFP->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals($std->IE, $refNFP->getElementsByTagName('IE')->item(0)->nodeValue);
        $this->assertEquals($std->mod, $refNFP->getElementsByTagName('mod')->item(0)->nodeValue);
        $this->assertEquals($std->serie, $refNFP->getElementsByTagName('serie')->item(0)->nodeValue);
        $this->assertEquals($std->nNF, $refNFP->getElementsByTagName('nNF')->item(0)->nodeValue);

        //Com CPF
        unset($std->CNPJ);
        $std->CPF = '08456452009';
        $refNFP = $this->make->tagrefNFP($std);

        $this->assertEquals($std->CPF, $refNFP->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function test_tagrefCTe(): void
    {
        $std = new \stdClass();
        $std->refCTe = '35150268252816000146570010000016161002008472';

        $refCTe = $this->make->tagrefCTe($std);
        $this->assertEquals('refCTe', $refCTe->nodeName);
        $this->assertEquals($std->refCTe, $refCTe->nodeValue);
    }

    public function test_tagrefECF(): void
    {
        $std = new \stdClass();
        $std->mod = '2C';
        $std->nECF = 788;
        $std->nCOO = 114;

        $refECF = $this->make->tagrefECF($std);
        $this->assertEquals('refECF', $refECF->nodeName);
        $this->assertEquals($std->mod, $refECF->getElementsByTagName('mod')->item(0)->nodeValue);
        $this->assertEquals($std->nECF, $refECF->getElementsByTagName('nECF')->item(0)->nodeValue);
        $this->assertEquals($std->nCOO, $refECF->getElementsByTagName('nCOO')->item(0)->nodeValue);
    }

    public function test_tagretirada(): void
    {
        $std = new \stdClass();
        $std->CNPJ = '12345678901234';

        $std->IE = '12345678901';
        $std->xNome = 'Beltrano e Cia Ltda';
        $std->xLgr = 'Rua Um';
        $std->nro = '123';
        $std->xCpl = 'sobreloja';
        $std->xBairro = 'centro';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CEP = '01023000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = '1122225544';
        $std->email = 'contato@beltrano.com.br';

        $tag = $this->make->tagretirada($std);

        $this->assertEquals('retirada', $tag->nodeName);
        $this->assertEquals($std->CNPJ, $tag->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals($std->IE, $tag->getElementsByTagName('IE')->item(0)->nodeValue);
        $this->assertEquals($std->xNome, $tag->getElementsByTagName('xNome')->item(0)->nodeValue);
        $this->assertEquals($std->xLgr, $tag->getElementsByTagName('xLgr')->item(0)->nodeValue);
        $this->assertEquals($std->nro, $tag->getElementsByTagName('nro')->item(0)->nodeValue);
        $this->assertEquals($std->xCpl, $tag->getElementsByTagName('xCpl')->item(0)->nodeValue);
        $this->assertEquals($std->xBairro, $tag->getElementsByTagName('xBairro')->item(0)->nodeValue);
        $this->assertEquals($std->cMun, $tag->getElementsByTagName('cMun')->item(0)->nodeValue);
        $this->assertEquals($std->xMun, $tag->getElementsByTagName('xMun')->item(0)->nodeValue);
        $this->assertEquals($std->UF, $tag->getElementsByTagName('UF')->item(0)->nodeValue);
        $this->assertEquals($std->CEP, $tag->getElementsByTagName('CEP')->item(0)->nodeValue);
        $this->assertEquals($std->cPais, $tag->getElementsByTagName('cPais')->item(0)->nodeValue);
        $this->assertEquals($std->xPais, $tag->getElementsByTagName('xPais')->item(0)->nodeValue);
        $this->assertEquals($std->fone, $tag->getElementsByTagName('fone')->item(0)->nodeValue);
        $this->assertEquals($std->email, $tag->getElementsByTagName('email')->item(0)->nodeValue);

        $std->CPF = '06563904092';
        $tag = $this->make->tagretirada($std);
        $this->assertEquals($std->CPF, $tag->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function test_tagentrega(): void
    {
        $std = new \stdClass();
        $std->CNPJ = '12345678901234';

        $std->IE = '12345678901';
        $std->xNome = 'Beltrano e Cia Ltda';
        $std->xLgr = 'Rua Um';
        $std->nro = '123';
        $std->xCpl = 'sobreloja';
        $std->xBairro = 'centro';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CEP = '01023000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = '1122225544';
        $std->email = 'contato@beltrano.com.br';

        $tag = $this->make->tagentrega($std);

        $this->assertEquals('entrega', $tag->nodeName);
        $this->assertEquals($std->CNPJ, $tag->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals($std->IE, $tag->getElementsByTagName('IE')->item(0)->nodeValue);
        $this->assertEquals($std->xNome, $tag->getElementsByTagName('xNome')->item(0)->nodeValue);
        $this->assertEquals($std->xLgr, $tag->getElementsByTagName('xLgr')->item(0)->nodeValue);
        $this->assertEquals($std->nro, $tag->getElementsByTagName('nro')->item(0)->nodeValue);
        $this->assertEquals($std->xCpl, $tag->getElementsByTagName('xCpl')->item(0)->nodeValue);
        $this->assertEquals($std->xBairro, $tag->getElementsByTagName('xBairro')->item(0)->nodeValue);
        $this->assertEquals($std->cMun, $tag->getElementsByTagName('cMun')->item(0)->nodeValue);
        $this->assertEquals($std->xMun, $tag->getElementsByTagName('xMun')->item(0)->nodeValue);
        $this->assertEquals($std->UF, $tag->getElementsByTagName('UF')->item(0)->nodeValue);
        $this->assertEquals($std->CEP, $tag->getElementsByTagName('CEP')->item(0)->nodeValue);
        $this->assertEquals($std->cPais, $tag->getElementsByTagName('cPais')->item(0)->nodeValue);
        $this->assertEquals($std->xPais, $tag->getElementsByTagName('xPais')->item(0)->nodeValue);
        $this->assertEquals($std->fone, $tag->getElementsByTagName('fone')->item(0)->nodeValue);
        $this->assertEquals($std->email, $tag->getElementsByTagName('email')->item(0)->nodeValue);

        $std->CPF = '06563904092';
        $tag = $this->make->tagentrega($std);
        $this->assertEquals($std->CPF, $tag->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function test_tagautXML(): void
    {
        $std = new \stdClass();
        $std->CNPJ = '12345678901234';
        $tag = $this->make->tagautXML($std);

        $this->assertEquals('autXML', $tag->nodeName);
        $this->assertEquals($std->CNPJ, $tag->getElementsByTagName('CNPJ')->item(0)->nodeValue);

        $std = new \stdClass();
        $std->CPF = '06563904092';
        $tag = $this->make->tagautXML($std);
        $this->assertEquals($std->CPF, $tag->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function test_taginfAdProd(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->infAdProd = 'informacao adicional do item';
        $tag = $this->make->taginfAdProd($std);

        $this->assertEquals('infAdProd', $tag->nodeName);
        $this->assertEquals($std->infAdProd, $tag->nodeValue);
    }

    public function test_tagCreditoPresumidoProd(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->cCredPresumido = '2222211234';
        $std->pCredPresumido = '4.0000';
        $std->vCredPresumido = '4.00';

        $tag = $this->make->tagCreditoPresumidoProd($std);

        $this->assertEquals('gCred', $tag->nodeName);
        $this->assertEquals($std->cCredPresumido, $tag->getElementsByTagName('cCredPresumido')->item(0)->nodeValue);
        $this->assertEquals($std->pCredPresumido, $tag->getElementsByTagName('pCredPresumido')->item(0)->nodeValue);
        $this->assertEquals($std->vCredPresumido, $tag->getElementsByTagName('vCredPresumido')->item(0)->nodeValue);
    }

    public function test_tagprodObsCont(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->xCampo = 'abc';
        $std->xTexto = '123';

        $tag = $this->make->tagprodObsCont($std);

        $this->assertEquals('obsItem', $tag->nodeName);
        $this->assertEquals($std->xCampo, $tag->getElementsByTagName('xCampo')->item(0)->nodeValue);
        $this->assertEquals($std->xTexto, $tag->getElementsByTagName('xTexto')->item(0)->nodeValue);
    }

    public function test_tagveicProd(): void
    {
        $std = new \stdClass();
        $std->item = '';
        $std->tpOp = 1;
        $std->chassi = '9BGRX4470AG745440';
        $std->cCor = '121';
        $std->xCor = 'PRATA';
        $std->pot = '0078';
        $std->cilin = '1000';
        $std->pesoL = '000008900';
        $std->pesoB = '000008900';
        $std->nSerie = 'AAA123456';
        $std->tpComb = '16';
        $std->nMotor = 'BBB123456';
        $std->CMT = '460.0000';
        $std->dist = '2443';
        $std->anoMod = 2010;
        $std->anoFab = 2011;
        $std->tpPint = 'M';
        $std->tpVeic = '06';
        $std->espVeic = 1;
        $std->VIN = 'N';
        $std->condVeic = 1;
        $std->cMod = '123456';
        $std->cCorDENATRAN = '10';
        $std->lota = 5;
        $std->tpRest = 0;

        $tag = $this->make->tagveicProd($std);

        $this->assertEquals('veicProd', $tag->nodeName);
        $this->assertEquals($std->tpOp, $tag->getElementsByTagName('tpOp')->item(0)->nodeValue);
        $this->assertEquals($std->chassi, $tag->getElementsByTagName('chassi')->item(0)->nodeValue);
        $this->assertEquals($std->cCor, $tag->getElementsByTagName('cCor')->item(0)->nodeValue);
        $this->assertEquals($std->xCor, $tag->getElementsByTagName('xCor')->item(0)->nodeValue);
        $this->assertEquals($std->pot, $tag->getElementsByTagName('pot')->item(0)->nodeValue);
        $this->assertEquals($std->cilin, $tag->getElementsByTagName('cilin')->item(0)->nodeValue);
        $this->assertEquals($std->pesoL, $tag->getElementsByTagName('pesoL')->item(0)->nodeValue);
        $this->assertEquals($std->pesoB, $tag->getElementsByTagName('pesoB')->item(0)->nodeValue);
        $this->assertEquals($std->nSerie, $tag->getElementsByTagName('nSerie')->item(0)->nodeValue);
        $this->assertEquals($std->tpComb, $tag->getElementsByTagName('tpComb')->item(0)->nodeValue);
        $this->assertEquals($std->nMotor, $tag->getElementsByTagName('nMotor')->item(0)->nodeValue);
        $this->assertEquals($std->CMT, $tag->getElementsByTagName('CMT')->item(0)->nodeValue);
        $this->assertEquals($std->dist, $tag->getElementsByTagName('dist')->item(0)->nodeValue);
        $this->assertEquals($std->anoMod, $tag->getElementsByTagName('anoMod')->item(0)->nodeValue);
        $this->assertEquals($std->anoFab, $tag->getElementsByTagName('anoFab')->item(0)->nodeValue);
        $this->assertEquals($std->tpPint, $tag->getElementsByTagName('tpPint')->item(0)->nodeValue);
        $this->assertEquals($std->tpVeic, $tag->getElementsByTagName('tpVeic')->item(0)->nodeValue);
        $this->assertEquals($std->espVeic, $tag->getElementsByTagName('espVeic')->item(0)->nodeValue);
        $this->assertEquals($std->VIN, $tag->getElementsByTagName('VIN')->item(0)->nodeValue);
        $this->assertEquals($std->condVeic, $tag->getElementsByTagName('condVeic')->item(0)->nodeValue);
        $this->assertEquals($std->cMod, $tag->getElementsByTagName('cMod')->item(0)->nodeValue);
        $this->assertEquals($std->cCorDENATRAN, $tag->getElementsByTagName('cCorDENATRAN')->item(0)->nodeValue);
        $this->assertEquals($std->lota, $tag->getElementsByTagName('lota')->item(0)->nodeValue);
        $this->assertEquals($std->tpRest, $tag->getElementsByTagName('tpRest')->item(0)->nodeValue);
    }

    public function test_tagmed(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->cProdANVISA = '1234567890123';
        $std->xMotivoIsencao = 'RDC 238';
        $std->vPMC = 102.22;

        $tag = $this->make->tagmed($std);
        $this->assertEquals('med', $tag->nodeName);
        $this->assertEquals($std->cProdANVISA, $tag->getElementsByTagName('cProdANVISA')->item(0)->nodeValue);
        $this->assertEquals($std->xMotivoIsencao, $tag->getElementsByTagName('xMotivoIsencao')->item(0)->nodeValue);
        $this->assertEquals($std->vPMC, $tag->getElementsByTagName('vPMC')->item(0)->nodeValue);
    }

    public function test_tagarma(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->nAR = 0;
        $std->tpArma = 0;
        $std->nSerie = '1234567890';
        $std->nCano = '987654321';
        $std->descr = 'Fuzil AK-47';

        $tag = $this->make->tagarma($std);
        $this->assertEquals('arma', $tag->nodeName);
        $this->assertEquals($std->tpArma, $tag->getElementsByTagName('tpArma')->item(0)->nodeValue);
        $this->assertEquals($std->nSerie, $tag->getElementsByTagName('nSerie')->item(0)->nodeValue);
        $this->assertEquals($std->nCano, $tag->getElementsByTagName('nCano')->item(0)->nodeValue);
        $this->assertEquals($std->descr, $tag->getElementsByTagName('descr')->item(0)->nodeValue);
    }

    public function test_tagcomb(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->cProdANP = '012345678';
        $std->descANP = 'Gasolina C Comum';
        $std->pGLP = '90.0000';
        $std->pGNn = '10.0000';
        $std->pGNi = '25.0000';
        $std->vPart = '12.50';
        $std->CODIF = '45346546';
        $std->qTemp = '123.0000';
        $std->UFCons = 'RS';
        $std->qBCProd = '12.5000';
        $std->vAliqProd = '1.0000';
        $std->vCIDE = '0.13';

        $tag = $this->make->tagcomb($std);
        $this->assertEquals('comb', $tag->nodeName);
        $this->assertEquals($std->cProdANP, $tag->getElementsByTagName('cProdANP')->item(0)->nodeValue);
        $this->assertEquals($std->descANP, $tag->getElementsByTagName('descANP')->item(0)->nodeValue);
        $this->assertEquals($std->pGLP, $tag->getElementsByTagName('pGLP')->item(0)->nodeValue);
        $this->assertEquals($std->pGNn, $tag->getElementsByTagName('pGNn')->item(0)->nodeValue);
        $this->assertEquals($std->pGNi, $tag->getElementsByTagName('pGNi')->item(0)->nodeValue);
        $this->assertEquals($std->vPart, $tag->getElementsByTagName('vPart')->item(0)->nodeValue);
        $this->assertEquals($std->CODIF, $tag->getElementsByTagName('CODIF')->item(0)->nodeValue);
        $this->assertEquals($std->qTemp, $tag->getElementsByTagName('qTemp')->item(0)->nodeValue);
        $this->assertEquals($std->UFCons, $tag->getElementsByTagName('UFCons')->item(0)->nodeValue);
        $CIDE = $tag->getElementsByTagName('CIDE')->item(0);

        $this->assertEquals($std->qBCProd, $CIDE->getElementsByTagName('qBCProd')->item(0)->nodeValue);
        $this->assertEquals($std->vAliqProd, $CIDE->getElementsByTagName('vAliqProd')->item(0)->nodeValue);
        $this->assertEquals($std->vCIDE, $CIDE->getElementsByTagName('vCIDE')->item(0)->nodeValue);
    }

    public function test_tagencerrante(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->nBico = 1;
        $std->nBomba = 2;
        $std->nTanque = 3;
        $std->vEncIni = '100.000';
        $std->vEncFin = '200.000';

        $tag = $this->make->tagencerrante($std);
        $this->assertEquals('encerrante', $tag->nodeName);
        $this->assertEquals($std->nBico, $tag->getElementsByTagName('nBico')->item(0)->nodeValue);
        $this->assertEquals($std->nBomba, $tag->getElementsByTagName('nBomba')->item(0)->nodeValue);
        $this->assertEquals($std->nTanque, $tag->getElementsByTagName('nTanque')->item(0)->nodeValue);
        $this->assertEquals($std->vEncIni, $tag->getElementsByTagName('vEncIni')->item(0)->nodeValue);
        $this->assertEquals($std->vEncFin, $tag->getElementsByTagName('vEncFin')->item(0)->nodeValue);
    }

    public function test_tagorigComb(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->indImport = 1;
        $std->cUFOrig = '11';
        $std->pOrig = '200.0000';

        $tag = $this->make->tagorigComb($std);
        $this->assertEquals('origComb', $tag->nodeName);
        $this->assertEquals($std->indImport, $tag->getElementsByTagName('indImport')->item(0)->nodeValue);
        $this->assertEquals($std->cUFOrig, $tag->getElementsByTagName('cUFOrig')->item(0)->nodeValue);
        $this->assertEquals($std->pOrig, $tag->getElementsByTagName('pOrig')->item(0)->nodeValue);
    }

    public function test_tagICMS_CST_00(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '3';
        $std->vBC = '200.00';
        $std->pICMS = '18.0000';
        $std->vICMS = '36.00';
        $std->pFCP = '1.0000';
        $std->vFCP = '2.00';

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_02(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '02';
        $std->qBCMono = '200.0000';
        $std->adRemICMS = '25.0000';
        $std->vICMSMono = '50.00';

        $this->validarCriacaoTag($std);
    }
    public function test_tagICMS_CST_15(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '15';
        $std->qBCMono = '200.0000';
        $std->adRemICMS = '25.0000';
        $std->vICMSMono = '50.00';
        $std->qBCMonoReten = '100.0000';
        $std->adRemICMSReten = '20.0000';
        $std->vICMSMonoReten = '20.00';
        $std->pRedAdRem = '1.00';
        $std->motRedAdRem = '1';

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_20(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '20';
        $std->modBC = '3';
        $std->pRedBC = '5.0000';
        $std->vBC = '180.00';
        $std->pICMS = '18.0000';
        $std->vICMS = '32.40';
        $std->vBCFCP = '200.00';
        $std->pFCP = '1.0000';
        $std->vFCP = '2.00';
        $std->vICMSDeson = '3.60';
        $std->motDesICMS = 9;

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_30(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '30';
        $std->modBCST = '4';
        $std->pMVAST = '30.0000';
        $std->pRedBCST = '1.0000';
        $std->vBCST = '1.00';
        $std->pICMSST = '1.0000';
        $std->vICMSST = '1.00';
        $std->vBCFCPST = '1.00';
        $std->pFCPST = '1.0000';
        $std->vFCPST = '1.00';
        $std->vICMSDeson = '3.60';
        $std->motDesICMS = 9;
        $std->indDeduzDeson = '0';

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_40(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '40';
        $std->vICMSDeson = '3.60';
        $std->motDesICMS = 9;
        $std->indDeduzDeson = '0';

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_41(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '41';
        $std->vICMSDeson = '3.60';
        $std->motDesICMS = 9;
        $std->indDeduzDeson = '0';

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_50(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '50';
        $std->vICMSDeson = '3.60';
        $std->motDesICMS = 9;
        $std->indDeduzDeson = '0';

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_51(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '51';
        $std->modBC = 3;
        $std->pRedBC = 10;
        $std->vBC = 100;
        $std->pICMS = 17;
        $std->vICMSOp = 17;
        $std->pDif = 1;
        $std->vICMSDif = 1;
        $std->vICMS = 17;
        $std->vBCFCP = 100;
        $std->pFCP = 2;
        $std->vFCP = 2;

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_53(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '53';
        $std->qBCMono = 200;
        $std->adRemICMS = 17;
        $std->vICMSMonoOp = 34;
        $std->pDif = 1;
        $std->vICMSMonoDif = 2;
        $std->vICMSMono = 2;

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_60(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '60';
        $std->vBCSTRet = 100;
        $std->pST = 12;
        $std->vICMSSubstituto = 12;
        $std->vICMSSTRet = 40;
        $std->vBCFCPSTRet = 50;
        $std->pFCPSTRet = 10;
        $std->vFCPSTRet = 15;
        $std->pRedBCEfet = 14;
        $std->vBCEfet = 100;
        $std->pICMSEfet = 10;
        $std->vICMSEfet = 10;

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_61(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '61';
        $std->qBCMonoRet = 300;
        $std->adRemICMSRet = 2;
        $std->vICMSMonoRet = 6;

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_70(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '70';
        $std->modBC = 3;
        $std->pRedBC = 10;
        $std->vBC = 200;
        $std->pICMS = 10;
        $std->vICMS = 20;
        $std->vBCFCP = 200;
        $std->pFCP = 2;
        $std->vFCP = 4;
        $std->modBCST = 4;
        $std->pMVAST = 30;
        $std->pRedBCST = 0;
        $std->vBCST = 60;
        $std->pICMSST = 10;
        $std->vICMSST = 20;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;
        $std->vICMSDeson = 10;
        $std->motDesICMS = 9;

        $this->validarCriacaoTag($std);
    }

    public function test_tagICMS_CST_90(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '90';
        $std->modBC = 3;
        $std->pRedBC = 10;
        $std->vBC = 200;
        $std->pICMS = 10;
        $std->vICMS = 20;
        $std->vBCFCP = 200;
        $std->pFCP = 2;
        $std->vFCP = 4;
        $std->modBCST = 4;
        $std->pMVAST = 30;
        $std->pRedBCST = 0;
        $std->vBCST = 60;
        $std->pICMSST = 10;
        $std->vICMSST = 20;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;
        $std->vICMSDeson = 10;
        $std->motDesICMS = 9;

        $this->validarCriacaoTag($std);
    }

    private function validarCriacaoTag(\stdClass $icms, string $tagName = 'ICMS'): void
    {
        $attributos = get_object_vars($icms);
        $tag = $this->make->tagICMS($icms);
        $this->assertEquals($tagName, $tag->nodeName);
        unset($attributos['item']);
        foreach ($attributos as $attributo => $valor) {
            $element = $tag->getElementsByTagName($attributo)->item(0);
            $this->assertEquals($icms->{$attributo}, $element->nodeValue, "Campo {$attributo} possui valor incorreto!");
        }
    }

    public function test_tagDI(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->nDI = 456;
        $std->dDI = '2024-03-01';
        $std->xLocDesemb = 'Porto';
        $std->UFDesemb = 'SP';
        $std->dDesemb = '2024-03-02';
        $std->tpViaTransp = 1;
        $std->vAFRMM = 150.45;
        $std->tpIntermedio = 1;
        $std->CNPJ = '08489068000198';
        //$std->CPF = ;
        $std->UFTerceiro = 'RS';
        $std->cExportador = '123';

        $element = $this->make->tagDI($std);
        $this->validarCriacaoTag2($std, $element, 'DI');

        unset($std->CNPJ);
        $std->CPF = '10318797062';
        $element = $this->make->tagDI($std);
        $this->validarCriacaoTag2($std, $element, 'DI');
    }

    public function test_tagadi(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->nDI = 1;
        $std->dDI = '2024-03-01';
        $std->xLocDesemb = 'Porto';
        $std->UFDesemb = 'SP';
        $std->dDesemb = '2024-03-02';
        $std->tpViaTransp = 1;
        $std->vAFRMM = 150.45;
        $std->tpIntermedio = 1;
        $std->CNPJ = '08489068000198';
        $std->UFTerceiro = 'RS';
        $std->cExportador = '123';
        $this->make->tagDI($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->nDI = 1;
        $std->nAdicao = 1;
        $std->nSeqAdic = 1;
        $std->cFabricante = 'abc123';
        $std->vDescDI = 12.48;
        $std->nDraw = 11111111111;

        $element = $this->make->tagadi($std);
        $this->validarCriacaoTag2($std, $element, 'adi', ['item', 'nDI']);
    }

    public function test_tagdetExport(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->nDraw = 123;

        $element = $this->make->tagdetExport($std);
        $this->validarCriacaoTag2($std, $element, 'detExport');
    }

    public function test_tagdetExportInd(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->nDraw = 123;
        $this->make->tagdetExport($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->nRE = 123;
        $std->chNFe = '12345678901234567890123456789012345678901234';
        $std->qExport = 45.1;

        $element = $this->make->tagdetExportInd($std);
        $this->validarCriacaoTag2($std, $element, 'exportInd');
    }

    public function test_tagRastro(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->nLote = 1;
        $std->qLote = 1;
        $std->dFab = '2024-01-01';
        $std->dVal = '2024-01-01';
        $std->cAgreg = 1234;

        $element = $this->make->tagRastro($std);
        $this->validarCriacaoTag2($std, $element, 'rastro');
    }

    public function test_tagICMSUFDest(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBCUFDest = 1;
        $std->vBCFCPUFDest = 1;
        $std->pFCPUFDest = 1;
        $std->pICMSUFDest = 1;
        $std->pICMSInter = 1;
        $std->pICMSInterPart = 1;
        $std->vFCPUFDest = 1;
        $std->vICMSUFDest = 1;
        $std->vICMSUFRemet = 1;

        $element = $this->make->tagICMSUFDest($std);
        $this->validarCriacaoTag2($std, $element, 'ICMSUFDest');
    }

    public function test_tagII(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 100;
        $std->vDespAdu = 1;
        $std->vII = 1;
        $std->vIOF = 1;

        $element = $this->make->tagII($std);
        $this->validarCriacaoTag2($std, $element, 'II');
    }

    public function test_tagISSQN(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->cProd = '1111';
        $std->cEAN = "SEM GTIN";
        $std->xProd = 'CAMISETA REGATA GG';
        $std->NCM = 61052000;
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
        $std->indTot = 1;
        $this->make->tagprod($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 1;
        $std->vAliq = 1;
        $std->vISSQN = 1;
        $std->cMunFG = '1234567';
        $std->cListServ = '10.10';
        $std->vDeducao = 1;
        $std->vOutro = 1;
        $std->vDescIncond = 1;
        $std->vDescCond = 1;
        $std->vISSRet = 1;
        $std->indISS = 1;
        $std->cServico = 1;
        $std->cMun = 123456;
        $std->cPais = 55;
        $std->nProcesso = '123';
        $std->indIncentivo = '12';


        $element = $this->make->tagISSQN($std);
        $this->validarCriacaoTag2($std, $element, 'ISSQN');
    }

    public function test_taginfRespTec(): void
    {
        $std = new \stdClass();
        $std->CNPJ = '76038276000120';
        $std->xContato = 'Fulano de Tal';
        $std->email = 'fulano@email.com';
        $std->fone = '51999999999';
        $std->CSRT = '456';
        $std->idCSRT = '123';

        $element = $this->make->taginfRespTec($std);
        $this->validarCriacaoTag2($std, $element, 'infRespTec', ['CSRT']);
    }

    public function test_tagagropecuario_defencivo(): void
    {
        $std = new \stdClass();
        $std->nReceituario = '1234567890ABCDEFGHIJ'; //Obrigatório se houver defencivo 1-20 caracteres, opcional caso contrario
        $std->CPFRespTec = '12345678901'; //Obrigatório se houver defencivo 11 digitos, opcional caso contrario
        //$std->tpGuia = '1'; //Obrigatório se houver guia 1-GTA, 2-TTA, 3-DTA, 4-ATV, 5-PTV, 6-GVT, 7-GF, opcional caso contrario
        //$std->UFGuia = 'MG'; //opcional
        //$std->serieGuia = 'A12345678'; //opcional 9 caracteres
        //$std->nGuia = '123456789'; //Obrigatório se houver guia 9 digitos, opcional caso contrario

        $element = $this->make->tagagropecuario($std);
        $this->validarCriacaoTag2($std, $element, 'agropecuario', ['nReceituario', 'CPFRespTec']);
    }

    public function test_tagagropecuario_guia(): void
    {
        $std = new \stdClass();
        //$std->nReceituario = '1234567890ABCDEFGHIJ'; //Obrigatório se houver defencivo 1-20 caracteres, opcional caso contrario
        //$std->CPFRespTec = '12345678901'; //Obrigatório se houver defencivo 11 digitos, opcional caso contrario
        $std->tpGuia = '1'; //Obrigatório se houver guia 1-GTA, 2-TTA, 3-DTA, 4-ATV, 5-PTV, 6-GVT, 7-GF, opcional caso contrario
        $std->UFGuia = 'MG'; //opcional
        $std->serieGuia = 'A12345678'; //opcional 9 caracteres
        $std->nGuia = '123456789'; //Obrigatório se houver guia 9 digitos, opcional caso contrario

        $element = $this->make->tagagropecuario($std);
        $this->validarCriacaoTag2($std, $element, 'agropecuario', ['tpGuia']);
    }

    private function validarCriacaoTag2(
        \stdClass $std,
        \DOMElement $element,
        string $tagName,
        array $camposIgnore = ['item']
    ): void {
        $attributos = get_object_vars($std);
        $this->assertEquals($tagName, $element->nodeName);
        foreach ($camposIgnore as $campo) {
            unset($attributos[$campo]);
        }

        foreach ($attributos as $attributo => $valor) {
            if ($valor === null) {
                continue;
            }
            $element2 = $element->getElementsByTagName($attributo)->item(0);
            $this->assertNotNull($element2, "Atributo {$attributo} não encontrado!");
            $this->assertEquals($std->{$attributo}, $element2->nodeValue, "Campo {$attributo} possui valor incorreto!");
        }
    }

    public function test_tagICMSPart(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '90';
        $std->modBC = 1;
        $std->vBC = 200;
        $std->pRedBC = 5;
        $std->pICMS = 10;
        $std->vICMS = 20;
        $std->modBCST = 4;
        $std->pMVAST = 30;
        $std->pRedBCST = 0;
        $std->vBCST = 60;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;
        $std->pBCOp = 1;
        $std->UFST = 'EX';
        $tag = $this->make->tagICMSPart($std);
        $tag2 = $tag->getElementsByTagName('ICMSPart')->item(0);
        $this->assertEquals('ICMSPart', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSST(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '41';
        $std->vBCSTRet = 200;
        $std->vICMSSTRet = 20;
        $std->vBCSTDest = 30;
        $std->vICMSSTDest = 2;
        $std->vBCFCPSTRet = 2;
        $std->pFCPSTRet = 2;
        $std->vFCPSTRet = 2;
        $std->pST = 2;
        $std->vICMSSubstituto = 2;
        $std->pRedBCEfet = 2;
        $std->vBCEfet = 2;
        $std->pICMSEfet = 2;
        $std->vICMSEfet = 2;

        $tag = $this->make->tagICMSST($std);
        $tag2 = $tag->getElementsByTagName('ICMSST')->item(0);
        $this->assertEquals('ICMSST', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_101(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '101';
        $std->pCredSN = 3;
        $std->vCredICMSSN = 4;

        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN101')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN101', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_102(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '102';

        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN102')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN102', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_103(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '103';

        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN102')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN102', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_300(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '300';

        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN102')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN102', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_400(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '400';

        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN102')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN102', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_201(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '201';
        $std->modBCST = 4;
        $std->pMVAST = 10;
        $std->pRedBCST = 20;
        $std->vBCST = 300;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;
        $std->pCredSN = 1;
        $std->vCredICMSSN = 1;


        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN201')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN201', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_202(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '202';
        $std->modBCST = 4;
        $std->pMVAST = 10;
        $std->pRedBCST = 20;
        $std->vBCST = 300;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;

        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN202')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN202', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_203(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '203';
        $std->modBCST = 4;
        $std->pMVAST = 10;
        $std->pRedBCST = 20;
        $std->vBCST = 300;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;

        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN202')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN202', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_500(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '500';
        $std->vBCSTRet = 1;
        $std->pST = 1;
        $std->vICMSSubstituto = 1;
        $std->vICMSSTRet = 1;
        $std->vBCFCPSTRet = 1;
        $std->pFCPSTRet = 1;
        $std->vFCPSTRet = 1;
        $std->pRedBCEfet = 1;
        $std->vBCEfet = 1;
        $std->pICMSEfet = 1;
        $std->vICMSEfet = 1;


        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN500')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN500', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSN_900(): void
    {
        $this->make->tagide(new \stdClass());
        $this->make->tagemit(new \stdClass());

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '900';
        $std->modBC = 3;
        $std->vBC = 100;
        $std->pRedBC = 1;
        $std->pICMS = 1;
        $std->vICMS = 1;
        $std->pCredSN = 3;
        $std->vCredICMSSN = 4;
        $std->modBCST = 3;
        $std->pMVAST = 1;
        $std->pRedBCST = 1;
        $std->vBCST = 1;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;


        $tag = $this->make->tagICMSSN($std);
        $tag2 = $tag->getElementsByTagName('ICMSSN900')->item(0);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals('ICMSSN900', $tag2->nodeName);

        $this->validarExistenciaCampos($std, $tag2);
    }

    public function test_tagICMSSNShouldAcceptEmptyOrig_whenCrtIs4AndCsosnInAllowedList(): void
    {
        $std = new \stdClass();
        $std->CRT = 4;
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = null;
        $std->CSOSN = '900';
        $std->modBC = 3;
        $std->vBC = 100;
        $std->pRedBC = 1;
        $std->pICMS = 1;
        $std->vICMS = 1;
        $std->pCredSN = 3;
        $std->vCredICMSSN = 4;
        $std->modBCST = 3;
        $std->pMVAST = 1;
        $std->pRedBCST = 1;
        $std->vBCST = 1;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;

        $icmssn = $this->make->tagICMSSN($std);
        $result = $icmssn->getElementsByTagName('ICMSSN900')->item(0);

        $this->assertEquals('ICMS', $icmssn->nodeName);
        $this->assertEquals('ICMSSN900', $result->nodeName);
        $this->assertNull($result->getElementsByTagName('orig')->item(0));

        $this->validarExistenciaCampos($std, $result);
    }

    /*
    public function test_tagICMSSNShouldNotAcceptEmptyOrig_whenCrtIs1(): void
    {
        $std = new \stdClass();
        $std->CRT = 1;
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = null;
        $std->CSOSN = '900';
        $std->modBC = 3;
        $std->vBC = 100;
        $std->pRedBC = 1;
        $std->pICMS = 1;
        $std->vICMS = 1;
        $std->pCredSN = 3;
        $std->vCredICMSSN = 4;
        $std->modBCST = 3;
        $std->pMVAST = 1;
        $std->pRedBCST = 1;
        $std->vBCST = 1;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;

        $icmssn = $this->make->tagICMSSN($std);
        $result = $icmssn->getElementsByTagName('ICMSSN900')->item(0);

        $this->assertEquals('ICMS', $icmssn->nodeName);
        $this->assertEquals('ICMSSN900', $result->nodeName);
        $this->assertContains(
            'Preenchimento Obrigatório! [orig] [item 1] Origem da mercadoria',
            $this->make->getErrors()
        );
        $this->validarExistenciaCampos($std, $result);
    }*/

    public function test_tagICMSSNShouldNotAcceptEmptyOrig_whenCrtIs4AndCsosnIsNotInAllowedList(): void
    {
        $std = new \stdClass();
        $std->CRT = 1;
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = null;
        $std->CSOSN = '500';
        $std->modBC = 3;
        $std->vBC = 100;
        $std->pRedBC = 1;
        $std->pICMS = 1;
        $std->vICMS = 1;
        $std->pCredSN = 3;
        $std->vCredICMSSN = 4;
        $std->modBCST = 3;
        $std->pMVAST = 1;
        $std->pRedBCST = 1;
        $std->vBCST = 1;
        $std->pICMSST = 1;
        $std->vICMSST = 1;
        $std->vBCFCPST = 1;
        $std->pFCPST = 1;
        $std->vFCPST = 1;

        $icmssn = $this->make->tagICMSSN($std);
        $result = $icmssn->getElementsByTagName('ICMSSN500')->item(0);

        $this->assertEquals('ICMS', $icmssn->nodeName);
        $this->assertEquals('ICMSSN500', $result->nodeName);
        $this->assertContains(
            'Preenchimento Obrigatório! [orig] [item 1] Origem da mercadoria',
            $this->make->getErrors()
        );
    }

    /*
    public function test_tagNCMShouldAcceptEmptyValue_andChangeToDefaultValue_whenCrtIs4AndIdDestIs1(): void
    {
        $std = new \stdClass();
        $std->idDest = 1;
        $this->make->tagide($std);

        $std = new \stdClass();
        $std->CRT = 4;
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->cProd = '1111';
        $std->cEAN = "SEM GTIN";
        $std->xProd = 'CAMISETA REGATA GG';
        $std->NCM = null;
        $std->CFOP = 5101;
        $std->uCom = 'UN';
        $std->qCom = 1;
        $std->vUnCom = 100.00;
        $std->vProd = 100.00;
        $std->cEANTrib = "SEM GTIN";
        $std->uTrib = 'UN';
        $std->qTrib = 1;
        $std->vUnTrib = 100.00;
        $std->indTot = 1;
        $prod = $this->make->tagprod($std);

        $this->assertEquals('00000000', $prod->getElementsByTagName('NCM')->item(0)->nodeValue);
    }*/

    public function test_tagNCMShouldNotAcceptEmptyValue_whenCrtIs1(): void
    {
        $std = new \stdClass();
        $std->idDest = 1;
        $this->make->tagide($std);

        $std = new \stdClass();
        $std->CRT = 1;
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->cProd = '1111';
        $std->cEAN = "SEM GTIN";
        $std->xProd = 'CAMISETA REGATA GG';
        $std->NCM = null;
        $std->CFOP = 5101;
        $std->uCom = 'UN';
        $std->qCom = 1;
        $std->vUnCom = 100.00;
        $std->vProd = 100.00;
        $std->cEANTrib = "SEM GTIN";
        $std->uTrib = 'UN';
        $std->qTrib = 1;
        $std->vUnTrib = 100.00;
        $std->indTot = 1;
        $this->make->tagprod($std);

        $this->assertContains(
            'Preenchimento Obrigatório! [NCM] I01 <prod> - [item 1] Código NCM com 8 dígitos ou 2 dígitos (gênero)',
            $this->make->getErrors()
        );
    }

    public function test_tagNCMShouldNotAcceptEmptyValue_whenCrtIs4AndIdDestIsNot1(): void
    {
        $std = new \stdClass();
        $std->idDest = 2;
        $this->make->tagide($std);

        $std = new \stdClass();
        $std->CRT = 4;
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->cProd = '1111';
        $std->cEAN = "SEM GTIN";
        $std->xProd = 'CAMISETA REGATA GG';
        $std->NCM = null;
        $std->CFOP = 5101;
        $std->uCom = 'UN';
        $std->qCom = 1;
        $std->vUnCom = 100.00;
        $std->vProd = 100.00;
        $std->cEANTrib = "SEM GTIN";
        $std->uTrib = 'UN';
        $std->qTrib = 1;
        $std->vUnTrib = 100.00;
        $std->indTot = 1;
        $this->make->tagprod($std);

        $this->assertContains(
            'Preenchimento Obrigatório! [NCM] I01 <prod> - [item 1] Código NCM com 8 dígitos ou 2 dígitos (gênero)',
            $this->make->getErrors()
        );
    }

    private function validarExistenciaCampos(\stdClass $std, \DOMElement $tag): void
    {
        $attributos = get_object_vars($std);
        unset($attributos['item']);
        foreach ($attributos as $attributo => $valor) {
            if ($valor === null) {
                continue;
            }
            $elemento = $tag->getElementsByTagName($attributo)->item(0);
            $this->assertInstanceOf(\DOMElement::class, $elemento, "Elemento {$attributo} não encontrado");
            $this->assertEquals($std->{$attributo}, $elemento->nodeValue, "Campo {$attributo} possui valor incorreto!");
        }
    }


    protected function setUp(): void
    {
        $this->make = new Make();
    }
}
