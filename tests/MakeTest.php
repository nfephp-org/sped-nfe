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

        $tag = $this->make->tagICMS($std);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals($std->orig, $tag->getElementsByTagName('orig')->item(0)->nodeValue);
        $this->assertEquals($std->CST, $tag->getElementsByTagName('CST')->item(0)->nodeValue);
        $this->assertEquals($std->modBC, $tag->getElementsByTagName('modBC')->item(0)->nodeValue);
        $this->assertEquals($std->vBC, $tag->getElementsByTagName('vBC')->item(0)->nodeValue);
        $this->assertEquals($std->pICMS, $tag->getElementsByTagName('pICMS')->item(0)->nodeValue);
        $this->assertEquals($std->vICMS, $tag->getElementsByTagName('vICMS')->item(0)->nodeValue);
        $this->assertEquals($std->pFCP, $tag->getElementsByTagName('pFCP')->item(0)->nodeValue);
        $this->assertEquals($std->vFCP, $tag->getElementsByTagName('vFCP')->item(0)->nodeValue);
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

        $tag = $this->make->tagICMS($std);
        $this->assertEquals('ICMS', $tag->nodeName);
        $this->assertEquals($std->orig, $tag->getElementsByTagName('orig')->item(0)->nodeValue);
        $this->assertEquals($std->CST, $tag->getElementsByTagName('CST')->item(0)->nodeValue);
        $this->assertEquals($std->modBC, $tag->getElementsByTagName('modBC')->item(0)->nodeValue);
        $this->assertEquals($std->pRedBC, $tag->getElementsByTagName('pRedBC')->item(0)->nodeValue);
        $this->assertEquals($std->vBC, $tag->getElementsByTagName('vBC')->item(0)->nodeValue);
        $this->assertEquals($std->pICMS, $tag->getElementsByTagName('pICMS')->item(0)->nodeValue);
        $this->assertEquals($std->vICMS, $tag->getElementsByTagName('vICMS')->item(0)->nodeValue);
        $this->assertEquals($std->vBCFCP, $tag->getElementsByTagName('vBCFCP')->item(0)->nodeValue);
        $this->assertEquals($std->pFCP, $tag->getElementsByTagName('pFCP')->item(0)->nodeValue);
        $this->assertEquals($std->vFCP, $tag->getElementsByTagName('vFCP')->item(0)->nodeValue);
        $this->assertEquals($std->vICMSDeson, $tag->getElementsByTagName('vICMSDeson')->item(0)->nodeValue);
        $this->assertEquals($std->motDesICMS, $tag->getElementsByTagName('motDesICMS')->item(0)->nodeValue);
    }

    protected function setUp(): void
    {
        $this->make = new Make();
    }
}
