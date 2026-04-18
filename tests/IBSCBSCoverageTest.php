<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Make;

/**
 * Tests targeting TraitTagDetIBSCBS methods.
 */
class IBSCBSCoverageTest extends NFeTestCase
{
    protected Make $make;

    protected function setUp(): void
    {
        $this->make = new Make();
        $this->setupInfNFe();
        $this->setupIde();
        $this->setupEmit();
        $this->setupDest();
        $this->setupProd();
    }

    private function setupInfNFe(): void
    {
        $std = new \stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $this->make->taginfNFe($std);
    }

    private function setupIde(): void
    {
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
    }

    private function setupEmit(): void
    {
        $std = new \stdClass();
        $std->xNome = 'EMPRESA TESTE';
        $std->xFant = 'TESTE';
        $std->IE = '6816168099';
        $std->IEST = null;
        $std->IM = null;
        $std->CNAE = null;
        $std->CRT = 3;
        $std->CNPJ = '58716523000119';
        $this->make->tagemit($std);

        $std = new \stdClass();
        $std->xLgr = 'RUA TESTE';
        $std->nro = '100';
        $std->xCpl = null;
        $std->xBairro = 'CENTRO';
        $std->cMun = 3518800;
        $std->xMun = 'GUARARAPES';
        $std->UF = 'SP';
        $std->CEP = '16700000';
        $std->cPais = 1058;
        $std->xPais = 'BRASIL';
        $std->fone = null;
        $this->make->tagenderEmit($std);
    }

    private function setupDest(): void
    {
        $std = new \stdClass();
        $std->xNome = 'CLIENTE TESTE';
        $std->indIEDest = 9;
        $std->CPF = '12345678901';
        $this->make->tagdest($std);
    }

    private function setupProd(int $item = 1): void
    {
        $std = new \stdClass();
        $std->item = $item;
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
    }

    // =========================================================================
    // tagIBSCBS - basic with gIBSCBS (vBC informed)
    // =========================================================================

    public function test_tagIBSCBS_basic_with_vBC(): void
    {
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

        $result = $this->make->tagIBSCBS($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<CST>00</CST>', $xml);
        $this->assertStringContainsString('<cClassTrib>12345678</cClassTrib>', $xml);
        $this->assertStringContainsString('<gIBSCBS>', $xml);
        $this->assertStringContainsString('<vBC>100.00</vBC>', $xml);
        $this->assertStringContainsString('<gIBSUF>', $xml);
        $this->assertStringContainsString('<pIBSUF>9.5000</pIBSUF>', $xml);
        $this->assertStringContainsString('<vIBSUF>9.50</vIBSUF>', $xml);
        $this->assertStringContainsString('<gIBSMun>', $xml);
        $this->assertStringContainsString('<pIBSMun>3.50</pIBSMun>', $xml);
        $this->assertStringContainsString('<vIBSMun>3.50</vIBSMun>', $xml);
        $this->assertStringContainsString('<gCBS>', $xml);
        $this->assertStringContainsString('<pCBS>8.8000</pCBS>', $xml);
        $this->assertStringContainsString('<vCBS>8.80</vCBS>', $xml);
    }

    public function test_tagIBSCBS_without_vBC_no_gIBSCBS(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '90';
        $std->cClassTrib = '99999999';

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<CST>90</CST>', $xml);
        $this->assertStringNotContainsString('<gIBSCBS>', $xml);
        $this->assertStringNotContainsString('<vBC>', $xml);
    }

    public function test_tagIBSCBS_with_indDoacao(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->indDoacao = 1;
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_vIBSUF = 9.50;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_vIBSMun = 3.50;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<indDoacao>1</indDoacao>', $xml);
    }

    public function test_tagIBSCBS_with_gIBSUF_diferimento(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_pDif = 50.0000;
        $std->gIBSUF_vDif = 4.75;
        $std->gIBSUF_vIBSUF = 4.75;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_vIBSMun = 3.50;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gDif>', $xml);
        $this->assertStringContainsString('<pDif>50.0000</pDif>', $xml);
        $this->assertStringContainsString('<vDif>4.75</vDif>', $xml);
    }

    public function test_tagIBSCBS_with_gIBSUF_devolucao_tributo(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_vDevTrib = 2.00;
        $std->gIBSUF_vIBSUF = 7.50;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_vIBSMun = 3.50;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gDevTrib>', $xml);
        $this->assertStringContainsString('<vDevTrib>2.00</vDevTrib>', $xml);
    }

    public function test_tagIBSCBS_with_gIBSUF_reducao_aliquota(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_pRedAliq = 30.0000;
        $std->gIBSUF_pAliqEfet = 6.6500;
        $std->gIBSUF_vIBSUF = 6.65;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_vIBSMun = 3.50;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gRed>', $xml);
        $this->assertStringContainsString('<pRedAliq>30.0000</pRedAliq>', $xml);
        $this->assertStringContainsString('<pAliqEfet>6.6500</pAliqEfet>', $xml);
    }

    public function test_tagIBSCBS_with_gIBSMun_diferimento(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_vIBSUF = 9.50;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_pDif = 20.0000;
        $std->gIBSMun_vDif = 0.70;
        $std->gIBSMun_vIBSMun = 2.80;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        // Should have gDif inside gIBSMun
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gIBSMun = $dom->getElementsByTagName('gIBSMun')->item(0);
        $this->assertNotNull($gIBSMun);
        $gDif = $gIBSMun->getElementsByTagName('gDif')->item(0);
        $this->assertNotNull($gDif);
        $this->assertEquals('20.0000', $gDif->getElementsByTagName('pDif')->item(0)->nodeValue);
    }

    public function test_tagIBSCBS_with_gIBSMun_devolucao_tributo(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_vIBSUF = 9.50;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_vDevTrib = 1.00;
        $std->gIBSMun_vIBSMun = 2.50;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gIBSMun = $dom->getElementsByTagName('gIBSMun')->item(0);
        $devTrib = $gIBSMun->getElementsByTagName('gDevTrib')->item(0);
        $this->assertNotNull($devTrib);
        $this->assertEquals('1.00', $devTrib->getElementsByTagName('vDevTrib')->item(0)->nodeValue);
    }

    public function test_tagIBSCBS_with_gIBSMun_reducao_aliquota(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->vBC = 100.00;
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_vIBSUF = 9.50;
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_pRedAliq = 10.0000;
        $std->gIBSMun_pAliqEfet = 3.1500;
        $std->gIBSMun_vIBSMun = 3.15;
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_vCBS = 8.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gIBSMun = $dom->getElementsByTagName('gIBSMun')->item(0);
        $gRed = $gIBSMun->getElementsByTagName('gRed')->item(0);
        $this->assertNotNull($gRed);
        $this->assertEquals('10.0000', $gRed->getElementsByTagName('pRedAliq')->item(0)->nodeValue);
    }

    public function test_tagIBSCBS_with_gCBS_diferimento(): void
    {
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
        $std->gCBS_pDif = 25.0000;
        $std->gCBS_vDif = 2.20;
        $std->gCBS_vCBS = 6.60;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gCBS = $dom->getElementsByTagName('gCBS')->item(0);
        $gDif = $gCBS->getElementsByTagName('gDif')->item(0);
        $this->assertNotNull($gDif);
        $this->assertEquals('25.0000', $gDif->getElementsByTagName('pDif')->item(0)->nodeValue);
        $this->assertEquals('2.20', $gDif->getElementsByTagName('vDif')->item(0)->nodeValue);
    }

    public function test_tagIBSCBS_with_gCBS_devolucao_tributo(): void
    {
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
        $std->gCBS_vDevTrib = 3.00;
        $std->gCBS_vCBS = 5.80;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gCBS = $dom->getElementsByTagName('gCBS')->item(0);
        $devTrib = $gCBS->getElementsByTagName('gDevTrib')->item(0);
        $this->assertNotNull($devTrib);
        $this->assertEquals('3.00', $devTrib->getElementsByTagName('vDevTrib')->item(0)->nodeValue);
    }

    public function test_tagIBSCBS_with_gCBS_reducao_aliquota(): void
    {
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
        $std->gCBS_pRedAliq = 15.0000;
        $std->gCBS_pAliqEfet = 7.4800;
        $std->gCBS_vCBS = 7.48;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gCBS = $dom->getElementsByTagName('gCBS')->item(0);
        $gRed = $gCBS->getElementsByTagName('gRed')->item(0);
        $this->assertNotNull($gRed);
        $this->assertEquals('15.0000', $gRed->getElementsByTagName('pRedAliq')->item(0)->nodeValue);
        $this->assertEquals('7.4800', $gRed->getElementsByTagName('pAliqEfet')->item(0)->nodeValue);
    }

    public function test_tagIBSCBS_all_optional_groups(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '00';
        $std->cClassTrib = '12345678';
        $std->indDoacao = 1;
        $std->vBC = 1000.00;
        // gIBSUF with all optional subgroups
        $std->gIBSUF_pIBSUF = 9.5000;
        $std->gIBSUF_pDif = 10.0000;
        $std->gIBSUF_vDif = 9.50;
        $std->gIBSUF_vDevTrib = 5.00;
        $std->gIBSUF_pRedAliq = 20.0000;
        $std->gIBSUF_pAliqEfet = 7.6000;
        $std->gIBSUF_vIBSUF = 76.00;
        // gIBSMun with all optional subgroups
        $std->gIBSMun_pIBSMun = 3.5000;
        $std->gIBSMun_pDif = 5.0000;
        $std->gIBSMun_vDif = 1.75;
        $std->gIBSMun_vDevTrib = 2.00;
        $std->gIBSMun_pRedAliq = 15.0000;
        $std->gIBSMun_pAliqEfet = 2.9750;
        $std->gIBSMun_vIBSMun = 29.75;
        // gCBS with all optional subgroups
        $std->gCBS_pCBS = 8.8000;
        $std->gCBS_pDif = 12.0000;
        $std->gCBS_vDif = 10.56;
        $std->gCBS_vDevTrib = 3.00;
        $std->gCBS_pRedAliq = 10.0000;
        $std->gCBS_pAliqEfet = 7.9200;
        $std->gCBS_vCBS = 79.20;

        $result = $this->make->tagIBSCBS($std);

        $xml = $result->ownerDocument->saveXML($result);
        // Check all groups present
        $this->assertStringContainsString('<indDoacao>1</indDoacao>', $xml);
        $this->assertStringContainsString('<gIBSCBS>', $xml);
        $this->assertStringContainsString('<gIBSUF>', $xml);
        $this->assertStringContainsString('<gIBSMun>', $xml);
        $this->assertStringContainsString('<gCBS>', $xml);
        // Count gDif occurrences (should be 3 - one in each sub group)
        $this->assertEquals(3, substr_count($xml, '<gDif>'));
        // Count gDevTrib occurrences (should be 3)
        $this->assertEquals(3, substr_count($xml, '<gDevTrib>'));
        // Count gRed occurrences (should be 3)
        $this->assertEquals(3, substr_count($xml, '<gRed>'));
    }

    // =========================================================================
    // tagIBSCBSTribRegular
    // =========================================================================

    public function test_tagIBSCBSTribRegular(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CSTReg = '00';
        $std->cClassTribReg = '87654321';
        $std->pAliqEfetRegIBSUF = 9.5000;
        $std->vTribRegIBSUF = 9.50;
        $std->pAliqEfetRegIBSMun = 3.5000;
        $std->vTribRegIBSMun = 3.50;
        $std->pAliqEfetRegCBS = 8.8000;
        $std->vTribRegCBS = 8.80;

        $result = $this->make->tagIBSCBSTribRegular($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gTribRegular>', $xml);
        $this->assertStringContainsString('<CSTReg>00</CSTReg>', $xml);
        $this->assertStringContainsString('<cClassTribReg>87654321</cClassTribReg>', $xml);
        $this->assertStringContainsString('<pAliqEfetRegIBSUF>9.5000</pAliqEfetRegIBSUF>', $xml);
        $this->assertStringContainsString('<vTribRegIBSUF>9.50</vTribRegIBSUF>', $xml);
        $this->assertStringContainsString('<pAliqEfetRegIBSMun>3.5000</pAliqEfetRegIBSMun>', $xml);
        $this->assertStringContainsString('<vTribRegIBSMun>3.50</vTribRegIBSMun>', $xml);
        $this->assertStringContainsString('<pAliqEfetRegCBS>8.8000</pAliqEfetRegCBS>', $xml);
        $this->assertStringContainsString('<vTribRegCBS>8.80</vTribRegCBS>', $xml);
    }

    // =========================================================================
    // taggTribCompraGov
    // =========================================================================

    public function test_taggTribCompraGov(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->pAliqIBSUF = 9.5000;
        $std->vTribIBSUF = 95.00;
        $std->pAliqIBSMun = 3.5000;
        $std->vTribIBSMun = 35.00;
        $std->pAliqCBS = 8.8000;
        $std->vTribCBS = 88.00;

        $result = $this->make->taggTribCompraGov($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gTribCompraGov>', $xml);
        $this->assertStringContainsString('<pAliqIBSUF>9.5000</pAliqIBSUF>', $xml);
        $this->assertStringContainsString('<vTribIBSUF>95.00</vTribIBSUF>', $xml);
        $this->assertStringContainsString('<pAliqIBSMun>3.5000</pAliqIBSMun>', $xml);
        $this->assertStringContainsString('<vTribIBSMun>35.00</vTribIBSMun>', $xml);
        $this->assertStringContainsString('<pAliqCBS>8.8000</pAliqCBS>', $xml);
        $this->assertStringContainsString('<vTribCBS>88.00</vTribCBS>', $xml);
    }

    // =========================================================================
    // tagIBSCBSMono - monofasico (combustiveis)
    // =========================================================================

    public function test_tagIBSCBSMono_padrao(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCMono = 500.0000;
        $std->adRemIBS = 1.2000;
        $std->adRemCBS = 0.8000;
        $std->vIBSMono = 600.00;
        $std->vCBSMono = 400.00;

        $result = $this->make->tagIBSCBSMono($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gIBSCBSMono>', $xml);
        $this->assertStringContainsString('<gMonoPadrao>', $xml);
        $this->assertStringContainsString('<qBCMono>500.0000</qBCMono>', $xml);
        $this->assertStringContainsString('<adRemIBS>1.2000</adRemIBS>', $xml);
        $this->assertStringContainsString('<adRemCBS>0.8000</adRemCBS>', $xml);
        $this->assertStringContainsString('<vIBSMono>600.00</vIBSMono>', $xml);
        $this->assertStringContainsString('<vCBSMono>400.00</vCBSMono>', $xml);
        $this->assertStringNotContainsString('<gMonoReten>', $xml);
        $this->assertStringNotContainsString('<gMonoRet>', $xml);
        $this->assertStringNotContainsString('<gMonoDif>', $xml);
    }

    public function test_tagIBSCBSMono_with_retencao(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCMono = 500.0000;
        $std->adRemIBS = 1.2000;
        $std->adRemCBS = 0.8000;
        $std->vIBSMono = 600.00;
        $std->vCBSMono = 400.00;
        $std->qBCMonoReten = 200.0000;
        $std->adRemIBSReten = 1.0000;
        $std->vIBSMonoReten = 200.00;
        $std->adRemCBSReten = 0.5000;
        $std->vCBSMonoReten = 100.00;

        $result = $this->make->tagIBSCBSMono($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gMonoPadrao>', $xml);
        $this->assertStringContainsString('<gMonoReten>', $xml);
        $this->assertStringContainsString('<qBCMonoReten>200.0000</qBCMonoReten>', $xml);
        $this->assertStringContainsString('<adRemIBSReten>1.0000</adRemIBSReten>', $xml);
        $this->assertStringContainsString('<vIBSMonoReten>200.00</vIBSMonoReten>', $xml);
        $this->assertStringContainsString('<adRemCBSReten>0.5000</adRemCBSReten>', $xml);
        $this->assertStringContainsString('<vCBSMonoReten>100.00</vCBSMonoReten>', $xml);
    }

    public function test_tagIBSCBSMono_with_retido_anteriormente(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCMonoRet = 300.0000;
        $std->adRemIBSRet = 0.9000;
        $std->vIBSMonoRet = 270.00;
        $std->adRemCBSRet = 0.6000;
        $std->vCBSMonoRet = 180.00;

        $result = $this->make->tagIBSCBSMono($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gMonoRet>', $xml);
        $this->assertStringContainsString('<qBCMonoRet>300.0000</qBCMonoRet>', $xml);
        $this->assertStringContainsString('<adRemIBSRet>0.9000</adRemIBSRet>', $xml);
        $this->assertStringContainsString('<vIBSMonoRet>270.00</vIBSMonoRet>', $xml);
        $this->assertStringContainsString('<adRemCBSRet>0.6000</adRemCBSRet>', $xml);
        $this->assertStringContainsString('<vCBSMonoRet>180.00</vCBSMonoRet>', $xml);
        $this->assertStringNotContainsString('<gMonoPadrao>', $xml);
    }

    public function test_tagIBSCBSMono_with_diferimento(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCMono = 500.0000;
        $std->adRemIBS = 1.2000;
        $std->adRemCBS = 0.8000;
        $std->vIBSMono = 600.00;
        $std->vCBSMono = 400.00;
        $std->pDifIBS = 30.0000;
        $std->vIBSMonoDif = 180.00;
        $std->pDifCBS = 20.0000;
        $std->vCBSMonoDif = 80.00;

        $result = $this->make->tagIBSCBSMono($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gMonoDif>', $xml);
        $this->assertStringContainsString('<pDifIBS>30.0000</pDifIBS>', $xml);
        $this->assertStringContainsString('<vIBSMonoDif>180.00</vIBSMonoDif>', $xml);
        $this->assertStringContainsString('<pDifCBS>20.0000</pDifCBS>', $xml);
        $this->assertStringContainsString('<vCBSMonoDif>80.00</vCBSMonoDif>', $xml);
    }

    public function test_tagIBSCBSMono_all_groups(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCMono = 500.0000;
        $std->adRemIBS = 1.2000;
        $std->adRemCBS = 0.8000;
        $std->vIBSMono = 600.00;
        $std->vCBSMono = 400.00;
        $std->qBCMonoReten = 200.0000;
        $std->adRemIBSReten = 1.0000;
        $std->vIBSMonoReten = 200.00;
        $std->adRemCBSReten = 0.5000;
        $std->vCBSMonoReten = 100.00;
        $std->qBCMonoRet = 100.0000;
        $std->adRemIBSRet = 0.8000;
        $std->vIBSMonoRet = 80.00;
        $std->adRemCBSRet = 0.4000;
        $std->vCBSMonoRet = 40.00;
        $std->pDifIBS = 10.0000;
        $std->vIBSMonoDif = 60.00;
        $std->pDifCBS = 10.0000;
        $std->vCBSMonoDif = 40.00;
        $std->vTotIBSMonoItem = 740.00;
        $std->vTotCBSMonoItem = 460.00;

        $result = $this->make->tagIBSCBSMono($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gMonoPadrao>', $xml);
        $this->assertStringContainsString('<gMonoReten>', $xml);
        $this->assertStringContainsString('<gMonoRet>', $xml);
        $this->assertStringContainsString('<gMonoDif>', $xml);
        $this->assertStringContainsString('<vTotIBSMonoItem>740.00</vTotIBSMonoItem>', $xml);
        $this->assertStringContainsString('<vTotCBSMonoItem>460.00</vTotCBSMonoItem>', $xml);
    }

    public function test_tagIBSCBSMono_totals_calculated_when_not_provided(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCMono = 100.0000;
        $std->adRemIBS = 1.0000;
        $std->adRemCBS = 0.5000;
        $std->vIBSMono = 100.00;
        $std->vCBSMono = 50.00;
        $std->qBCMonoReten = 50.0000;
        $std->adRemIBSReten = 0.5000;
        $std->vIBSMonoReten = 25.00;
        $std->adRemCBSReten = 0.3000;
        $std->vCBSMonoReten = 15.00;
        $std->pDifIBS = 10.0000;
        $std->vIBSMonoDif = 10.00;
        $std->pDifCBS = 10.0000;
        $std->vCBSMonoDif = 5.00;
        // Do NOT set vTotIBSMonoItem / vTotCBSMonoItem - let them be calculated

        $result = $this->make->tagIBSCBSMono($std);

        $xml = $result->ownerDocument->saveXML($result);
        // vTotIBSMonoItem = vIBSMono(100) + vIBSMonoReten(25) - vIBSMonoDif(10) = 115
        $this->assertStringContainsString('<vTotIBSMonoItem>115.00</vTotIBSMonoItem>', $xml);
        // vTotCBSMonoItem = vCBSMono(50) + vCBSMonoReten(15) - vCBSMonoDif(5) = 60
        $this->assertStringContainsString('<vTotCBSMonoItem>60.00</vTotCBSMonoItem>', $xml);
    }

    // =========================================================================
    // taggTransfCred
    // =========================================================================

    public function test_taggTransfCred(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vIBS = 50.00;
        $std->vCBS = 30.00;

        $result = $this->make->taggTransfCred($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gTransfCred>', $xml);
        $this->assertStringContainsString('<vIBS>50.00</vIBS>', $xml);
        $this->assertStringContainsString('<vCBS>30.00</vCBS>', $xml);
    }

    // =========================================================================
    // taggCredPresIBSZFM
    // =========================================================================

    public function test_taggCredPresIBSZFM(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->competApur = '2026-01';
        $std->tpCredPresIBSZFM = 1;
        $std->vCredPresIBSZFM = 150.00;

        $result = $this->make->taggCredPresIBSZFM($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gCredPresIBSZFM>', $xml);
        $this->assertStringContainsString('<competApur>2026-01</competApur>', $xml);
        $this->assertStringContainsString('<tpCredPresIBSZFM>1</tpCredPresIBSZFM>', $xml);
        $this->assertStringContainsString('<vCredPresIBSZFM>150.00</vCredPresIBSZFM>', $xml);
    }

    public function test_taggCredPresIBSZFM_without_competApur(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->tpCredPresIBSZFM = 2;
        $std->vCredPresIBSZFM = 200.00;

        $result = $this->make->taggCredPresIBSZFM($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<tpCredPresIBSZFM>2</tpCredPresIBSZFM>', $xml);
        $this->assertStringContainsString('<vCredPresIBSZFM>200.00</vCredPresIBSZFM>', $xml);
    }

    // =========================================================================
    // taggAjusteCompet
    // =========================================================================

    public function test_taggAjusteCompet(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->competApur = '2026-03';
        $std->vIBS = 25.00;
        $std->vCBS = 15.00;

        $result = $this->make->taggAjusteCompet($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gAjusteCompet>', $xml);
        $this->assertStringContainsString('<competApur>2026-03</competApur>', $xml);
        $this->assertStringContainsString('<vIBS>25.00</vIBS>', $xml);
        $this->assertStringContainsString('<vCBS>15.00</vCBS>', $xml);
    }

    // =========================================================================
    // taggEstornoCred
    // =========================================================================

    public function test_taggEstornoCred(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vIBSEstCred = 10.00;
        $std->vCBSEstCred = 5.00;

        $result = $this->make->taggEstornoCred($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gEstornoCred>', $xml);
        $this->assertStringContainsString('<vIBSEstCred>10.00</vIBSEstCred>', $xml);
        $this->assertStringContainsString('<vCBSEstCred>5.00</vCBSEstCred>', $xml);
    }

    // =========================================================================
    // taggCredPresOper
    // =========================================================================

    public function test_taggCredPresOper_with_ibs_vCredPres(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBCCredPres = 1000.00;
        $std->cCredPres = '001';
        $std->ibs_pCredPres = 5.0000;
        $std->ibs_vCredPres = 50.00;
        $std->cbs_pCredPres = 3.0000;
        $std->cbs_vCredPres = 30.00;

        $result = $this->make->taggCredPresOper($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gCredPresOper>', $xml);
        $this->assertStringContainsString('<vBCCredPres>1000.00</vBCCredPres>', $xml);
        $this->assertStringContainsString('<cCredPres>001</cCredPres>', $xml);
        $this->assertStringContainsString('<gIBSCredPres>', $xml);
        $this->assertStringContainsString('<gCBSCredPres>', $xml);
        // Check vCredPres (not vCredPresCondSus)
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gIBS = $dom->getElementsByTagName('gIBSCredPres')->item(0);
        $this->assertNotNull($gIBS->getElementsByTagName('vCredPres')->item(0));
        $gCBS = $dom->getElementsByTagName('gCBSCredPres')->item(0);
        $this->assertNotNull($gCBS->getElementsByTagName('vCredPres')->item(0));
    }

    public function test_taggCredPresOper_with_condicao_suspensiva(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBCCredPres = 1000.00;
        $std->cCredPres = '002';
        $std->ibs_pCredPres = 5.0000;
        $std->ibs_vCredPresCondSus = 50.00;
        $std->cbs_pCredPres = 3.0000;
        $std->cbs_vCredPresCondSus = 30.00;

        $result = $this->make->taggCredPresOper($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gIBSCredPres>', $xml);
        $this->assertStringContainsString('<gCBSCredPres>', $xml);
        $dom = new \DOMDocument();
        $dom->loadXML($xml);
        $gIBS = $dom->getElementsByTagName('gIBSCredPres')->item(0);
        $this->assertNotNull($gIBS->getElementsByTagName('vCredPresCondSus')->item(0));
        $this->assertNull($gIBS->getElementsByTagName('vCredPres')->item(0));
        $gCBS = $dom->getElementsByTagName('gCBSCredPres')->item(0);
        $this->assertNotNull($gCBS->getElementsByTagName('vCredPresCondSus')->item(0));
        $this->assertNull($gCBS->getElementsByTagName('vCredPres')->item(0));
    }

    public function test_taggCredPresOper_without_ibs_and_cbs_groups(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBCCredPres = 500.00;
        $std->cCredPres = '003';

        $result = $this->make->taggCredPresOper($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gCredPresOper>', $xml);
        $this->assertStringContainsString('<vBCCredPres>500.00</vBCCredPres>', $xml);
        $this->assertStringNotContainsString('<gIBSCredPres>', $xml);
        $this->assertStringNotContainsString('<gCBSCredPres>', $xml);
    }

    public function test_taggCredPresOper_only_ibs_group(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBCCredPres = 500.00;
        $std->cCredPres = '004';
        $std->ibs_pCredPres = 5.0000;
        $std->ibs_vCredPres = 25.00;

        $result = $this->make->taggCredPresOper($std);

        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<gIBSCredPres>', $xml);
        $this->assertStringNotContainsString('<gCBSCredPres>', $xml);
    }
}
