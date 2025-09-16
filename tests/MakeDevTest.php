<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\MakeDev;
use PHPUnit\Framework\TestCase;

class MakeDevTest extends TestCase
{
    /**
     * @var MakeDev
     */
    protected $make;

    public function __construct()
    {
        TestCase::__construct();
        $this->make = new MakeDev('PL_010');
    }

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
        $std->cMunFGIBS = ''; //RTC
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->tpNFDebito = ''; //RTC
        $std->tpNFCredito = ''; //RTC
        $std->cDV = '';
        $std->tpAmb = '';
        $std->finNFe = '';
        $std->indFinal = '';
        $std->indPres = '';
        $std->indIntermed = '';
        $std->procEmi = '';
        $std->verProc = '';
        $std->dhCont = '';
        $std->xJust = '';

        $ide = $this->make->tagide($std);
        $errors = $this->make->getErrors();
        $this->assertStringContainsString('cUF', $errors[0]); //cUF incorreto não permite determinar a Zona de Tempo
        $this->assertStringContainsString('cUF', $errors[1]); //cUF é obrigatório
        $this->assertEmpty($ide->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->assertEquals('78888888', $ide->getElementsByTagName('cNF')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('natOp')->item(0)->nodeValue);
        $this->assertStringContainsString('natOp', $errors[2]);
        $this->assertStringContainsString('mod', $errors[3]);
        $this->assertStringContainsString('serie', $errors[4]);
        $this->assertStringContainsString('nNF', $errors[5]);
        $this->assertStringContainsString('dhEmi', $errors[6]);
        $this->assertStringContainsString('tpNF', $errors[7]);
        $this->assertStringContainsString('idDest', $errors[8]);
        $this->assertStringContainsString('cMunFG', $errors[9]);
        $this->assertEquals('0', $ide->getElementsByTagName('cDV')->item(0)->nodeValue);
        $this->assertStringContainsString('tpAmb', $errors[10]);
        $this->assertStringContainsString('finNFe', $errors[11]);
        $this->assertStringContainsString('indFinal', $errors[12]);
        $this->assertStringContainsString('indPres', $errors[13]);
        $this->assertStringContainsString('procEmi', $errors[14]);
        $this->assertStringContainsString('verProc', $errors[15]);
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
        $std->cMunFGIBS = '5002704'; //RTC somente será incluso se informado e indPres = 5
        $std->tpImp = '4';
        $std->tpEmis = '1';
        $std->tpNFDebito = '1'; //RTC ou é debito ou nenhum dos dois
        $std->tpNFCredito = '1'; //RTC ou é credito ou nenhum dos dois
        $std->cDV = '2';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '5';
        $std->indIntermed = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $std->dhCont = null;
        $std->xJust = null;

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
        $this->assertEquals($std->cMunFGIBS, $ide->getElementsByTagName('cMunFGIBS')->item(0)->nodeValue);
        $this->assertEquals($std->tpImp, $ide->getElementsByTagName('tpImp')->item(0)->nodeValue);
        $this->assertEquals($std->tpEmis, $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue);
        $this->assertEquals($std->tpNFDebito, $ide->getElementsByTagName('tpNFDebito')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('tpNFCredito')->item(0));
        $this->assertEquals($std->cDV, $ide->getElementsByTagName('cDV')->item(0)->nodeValue);
        $this->assertEquals($std->tpAmb, $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue);
        $this->assertEquals($std->finNFe, $ide->getElementsByTagName('finNFe')->item(0)->nodeValue);
        $this->assertEquals($std->indFinal, $ide->getElementsByTagName('indFinal')->item(0)->nodeValue);
        $this->assertEquals($std->indPres, $ide->getElementsByTagName('indPres')->item(0)->nodeValue);
        $this->assertEquals($std->indIntermed, $ide->getElementsByTagName('indIntermed')->item(0)->nodeValue);
        $this->assertEquals($std->procEmi, $ide->getElementsByTagName('procEmi')->item(0)->nodeValue);
        $this->assertEquals($std->verProc, $ide->getElementsByTagName('verProc')->item(0)->nodeValue);
        $this->assertEmpty($ide->getElementsByTagName('dhCont')->item(0));
        $this->assertEmpty($ide->getElementsByTagName('xJust')->item(0));
    }
}
