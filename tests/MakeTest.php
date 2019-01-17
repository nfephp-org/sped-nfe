<?php

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
        $std->cNF = '88888888';
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
        $this->assertContains('cUF', $this->make->dom->errors[0]);
        $this->assertEquals('88888888', $ide->getElementsByTagName('cNF')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('natOp')->item(0)->nodeValue);
        $this->assertContains('natOp', $this->make->dom->errors[1]);
        $this->assertContains('mod', $this->make->dom->errors[2]);
        $this->assertContains('serie', $this->make->dom->errors[3]);
        $this->assertContains('nNF', $this->make->dom->errors[4]);
        $this->assertContains('dhEmi', $this->make->dom->errors[5]);
        $this->assertContains('tpNF', $this->make->dom->errors[6]);
        $this->assertContains('idDest', $this->make->dom->errors[7]);
        $this->assertContains('cMunFG', $this->make->dom->errors[8]);
        $this->assertEquals('0', $ide->getElementsByTagName('cDV')->item(0)->nodeValue);
        $this->assertContains('tpAmb', $this->make->dom->errors[9]);
        $this->assertContains('finNFe', $this->make->dom->errors[10]);
        $this->assertContains('indFinal', $this->make->dom->errors[11]);
        $this->assertContains('indPres', $this->make->dom->errors[12]);
        $this->assertContains('procEmi', $this->make->dom->errors[13]);
        $this->assertContains('verProc', $this->make->dom->errors[14]);
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

    protected function setUp()
    {
        $this->make = new Make();
    }
}
