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

    protected function setUp(): void
    {
        $this->make = new Make();
    }
}
