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

    protected function setUp(): void
    {
        $this->make = new MakeDev('PL_010');
    }

    // =========================================================================
    // Constructor / utility methods
    // =========================================================================

    public function testConstructorDefaultSchema()
    {
        $make = new MakeDev();
        $this->assertInstanceOf(MakeDev::class, $make);
    }

    public function testConstructorWithSchema()
    {
        $make = new MakeDev('PL_010_V1.30');
        $this->assertInstanceOf(MakeDev::class, $make);
    }

    public function testGetChaveReturnsEmptyByDefault()
    {
        $this->assertEquals('', $this->make->getChave());
    }

    public function testGetModeloReturnsIntByDefault()
    {
        $this->assertIsInt($this->make->getModelo());
    }

    public function testGetErrorsReturnsEmptyByDefault()
    {
        $this->assertIsArray($this->make->getErrors());
    }

    public function testSetOnlyAscii()
    {
        $this->make->setOnlyAscii(true);
        // No exception thrown - method works
        $this->assertTrue(true);
    }

    public function testSetCheckGtin()
    {
        $this->make->setCheckGtin(false);
        $this->assertTrue(true);
    }

    public function testSetCalculationMethod()
    {
        $this->make->setCalculationMethod(MakeDev::METHOD_CALCULATION_V1);
        $this->assertTrue(true);
    }

    // =========================================================================
    // taginfNFe
    // =========================================================================

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

    // =========================================================================
    // tagide
    // =========================================================================

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

    // =========================================================================
    // render() - complete NFe assembly
    // =========================================================================

    public function testRenderMinimalNFe55()
    {
        $this->buildMinimalNFe55();

        $xml = $this->make->render();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<NFe', $xml);
        $this->assertStringContainsString('<infNFe', $xml);
        $this->assertStringContainsString('<ide>', $xml);
        $this->assertStringContainsString('<emit>', $xml);
        $this->assertStringContainsString('<dest>', $xml);
        $this->assertStringContainsString('<det ', $xml);
        $this->assertStringContainsString('<total>', $xml);
        $this->assertStringContainsString('<pag>', $xml);
    }

    public function testGetXMLCallsRenderIfEmpty()
    {
        $this->buildMinimalNFe55();

        $xml = $this->make->getXML();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<NFe', $xml);
    }

    public function testMontaNFeCallsRender()
    {
        $this->buildMinimalNFe55();

        $xml = $this->make->montaNFe();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<NFe', $xml);
    }

    public function testGetChaveAfterRender()
    {
        $this->buildMinimalNFe55();
        $this->make->render();

        $chave = $this->make->getChave();
        $this->assertNotEmpty($chave);
        $this->assertEquals(44, strlen($chave));
    }

    public function testGetModeloAfterIde()
    {
        $this->buildMinimalNFe55();

        $this->assertEquals(55, $this->make->getModelo());
    }

    public function testRenderMinimalNFe65()
    {
        $this->buildMinimalNFe65();

        $xml = $this->make->render();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<NFe', $xml);
        $this->assertStringContainsString('<mod>65</mod>', $xml);
    }

    public function testSetCalculationMethodDoesNotThrow()
    {
        $this->make->setCalculationMethod(MakeDev::METHOD_CALCULATION_V1);
        // Both V1 and V2 constants are currently equal to 1
        $this->make->setCalculationMethod(MakeDev::METHOD_CALCULATION_V2);
        $this->assertTrue(true);
    }

    public function testRenderWithoutProdReturnsError()
    {
        $std = new \stdClass();
        $std->versao = '4.00';
        $this->make->taginfNFe($std);

        $std = new \stdClass();
        $std->cUF = 35;
        $std->cNF = '00000030';
        $std->natOp = 'VENDA';
        $std->mod = 55;
        $std->serie = 1;
        $std->nNF = 30;
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = 3518800;
        $std->tpImp = 1;
        $std->tpEmis = 1;
        $std->cDV = 0;
        $std->tpAmb = 2;
        $std->finNFe = 1;
        $std->indFinal = 1;
        $std->indPres = 1;
        $std->procEmi = 0;
        $std->verProc = '4.00';
        $this->make->tagide($std);

        $xml = $this->make->render();

        $errors = $this->make->getErrors();
        $this->assertNotEmpty($errors);
    }

    public function testRenderWithIBSCBS()
    {
        $this->buildMinimalNFe55();

        // Add IBSCBS
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_vIBSUF = 9.50;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_vIBSMun = 3.50;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;
        $this->make->tagIBSCBS($std);

        $xml = $this->make->render();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<IBSCBS>', $xml);
        $this->assertStringContainsString('<gIBSCBS>', $xml);
        $this->assertStringContainsString('<vItem>', $xml);
    }

    public function testRenderWithIBSCBSMono()
    {
        $this->buildMinimalNFe55();

        // Add IBSCBS base
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '02';
        $std->cClassTrib = '12345678';
        $this->make->tagIBSCBS($std);

        // Add monofasico
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCMono = 500.0000;
        $std->adRemIBS = 1.2000;
        $std->adRemCBS = 0.8000;
        $std->vIBSMono = 600.00;
        $std->vCBSMono = 400.00;
        $this->make->tagIBSCBSMono($std);

        $xml = $this->make->render();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<gIBSCBSMono>', $xml);
    }

    // =========================================================================
    // Helpers to build minimal NFe documents
    // =========================================================================

    private function buildMinimalNFe55(): void
    {
        $std = new \stdClass();
        $std->versao = '4.00';
        $this->make->taginfNFe($std);

        $std = new \stdClass();
        $std->cUF = 35;
        $std->cNF = '00000030';
        $std->natOp = 'VENDA';
        $std->mod = 55;
        $std->serie = 1;
        $std->nNF = 30;
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->dhSaiEnt = null;
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = 3518800;
        $std->tpImp = 1;
        $std->tpEmis = 1;
        $std->cDV = 0;
        $std->tpAmb = 2;
        $std->finNFe = 1;
        $std->indFinal = 1;
        $std->indPres = 1;
        $std->procEmi = 0;
        $std->verProc = '4.00';
        $this->make->tagide($std);

        $std = new \stdClass();
        $std->xNome = 'EMPRESA TESTE';
        $std->xFant = 'TESTE';
        $std->IE = '6816168099';
        $std->CRT = 3;
        $std->CNPJ = '58716523000119';
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->xLgr = 'RUA TESTE';
        $std->nro = '100';
        $std->xBairro = 'CENTRO';
        $std->cMun = 3518800;
        $std->xMun = 'GUARARAPES';
        $std->UF = 'SP';
        $std->CEP = '16700000';
        $std->cPais = 1058;
        $std->xPais = 'BRASIL';
        $this->make->tagenderEmit($std);

        $std = new \stdClass();
        $std->xNome = 'CLIENTE TESTE';
        $std->indIEDest = 9;
        $std->CPF = '12345678901';
        $this->make->tagdest($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->cProd = '0001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'PRODUTO TESTE';
        $std->NCM = '66159900';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = 1;
        $std->vUnCom = 100.00;
        $std->vProd = 100.00;
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = 1;
        $std->vUnTrib = 100.00;
        $std->indTot = 1;
        $this->make->tagprod($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '00';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 18.00;
        $this->make->tagICMS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 100.00;
        $std->pPIS = 1.65;
        $std->vPIS = 1.65;
        $this->make->tagPIS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 100.00;
        $std->pCOFINS = 7.60;
        $std->vCOFINS = 7.60;
        $this->make->tagCOFINS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->vTotTrib = 0;
        $this->make->tagimposto($std);

        $std = new \stdClass();
        $std->modFrete = 9;
        $this->make->tagtransp($std);

        $std = new \stdClass();
        $std->vTroco = 0;
        $this->make->tagpag($std);

        $std = new \stdClass();
        $std->indPag = 0;
        $std->tPag = '01';
        $std->vPag = 100.00;
        $this->make->tagdetPag($std);
    }

    private function buildMinimalNFe65(): void
    {
        $std = new \stdClass();
        $std->versao = '4.00';
        $this->make->taginfNFe($std);

        $std = new \stdClass();
        $std->cUF = 35;
        $std->cNF = '00000030';
        $std->natOp = 'VENDA';
        $std->mod = 65;
        $std->serie = 1;
        $std->nNF = 30;
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = 3518800;
        $std->tpImp = 4;
        $std->tpEmis = 1;
        $std->cDV = 0;
        $std->tpAmb = 2;
        $std->finNFe = 1;
        $std->indFinal = 1;
        $std->indPres = 1;
        $std->procEmi = 0;
        $std->verProc = '4.00';
        $this->make->tagide($std);

        $std = new \stdClass();
        $std->xNome = 'EMPRESA TESTE';
        $std->xFant = 'TESTE';
        $std->IE = '6816168099';
        $std->CRT = 3;
        $std->CNPJ = '58716523000119';
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->xLgr = 'RUA TESTE';
        $std->nro = '100';
        $std->xBairro = 'CENTRO';
        $std->cMun = 3518800;
        $std->xMun = 'GUARARAPES';
        $std->UF = 'SP';
        $std->CEP = '16700000';
        $std->cPais = 1058;
        $std->xPais = 'BRASIL';
        $this->make->tagenderEmit($std);

        $std = new \stdClass();
        $std->xNome = 'CLIENTE TESTE';
        $std->indIEDest = 9;
        $std->CPF = '12345678901';
        $this->make->tagdest($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->cProd = '0001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'PRODUTO TESTE';
        $std->NCM = '66159900';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = 1;
        $std->vUnCom = 50.00;
        $std->vProd = 50.00;
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = 1;
        $std->vUnTrib = 50.00;
        $std->indTot = 1;
        $this->make->tagprod($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '00';
        $std->modBC = 3;
        $std->vBC = 50.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 9.00;
        $this->make->tagICMS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 50.00;
        $std->pPIS = 1.65;
        $std->vPIS = 0.83;
        $this->make->tagPIS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 50.00;
        $std->pCOFINS = 7.60;
        $std->vCOFINS = 3.80;
        $this->make->tagCOFINS($std);

        $std = new \stdClass();
        $std->item = 1;
        $std->vTotTrib = 0;
        $this->make->tagimposto($std);

        $std = new \stdClass();
        $std->modFrete = 9;
        $this->make->tagtransp($std);

        $std = new \stdClass();
        $std->vTroco = 0;
        $this->make->tagpag($std);

        $std = new \stdClass();
        $std->indPag = 0;
        $std->tPag = '01';
        $std->vPag = 50.00;
        $this->make->tagdetPag($std);
    }
}
