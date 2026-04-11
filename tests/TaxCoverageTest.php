<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Make;

/**
 * Tests targeting uncovered branches in TraitTagDetICMS, TraitTagDetPIS, and TraitTagDetCOFINS.
 */
class TaxCoverageTest extends NFeTestCase
{
    protected Make $make;

    protected function setUp(): void
    {
        $this->make = new Make();
        // Minimal required tags so tagICMS/tagPIS/tagCOFINS can work
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

    private function setupImposto(int $item = 1): void
    {
        $std = new \stdClass();
        $std->item = $item;
        $std->vTotTrib = 0;
        $this->make->tagimposto($std);
    }

    // =========================================================================
    // ICMS CST TESTS
    // =========================================================================

    public function testICMS00(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '00';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 18.00;
        $std->pFCP = 2.0000;
        $std->vFCP = 2.00;
        $result = $this->make->tagICMS($std);
        $this->assertInstanceOf(\DOMElement::class, $result);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS00>', $xml);
        $this->assertStringContainsString('<vFCP>', $xml);
    }

    public function testICMS00WithoutFCP(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '00';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 18.00;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS00>', $xml);
        $this->assertStringNotContainsString('<vFCP>', $xml);
    }

    public function testICMS02(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '02';
        $std->qBCMono = 100.0000;
        $std->adRemICMS = 1.5000;
        $std->vICMSMono = 150.00;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS02>', $xml);
        $this->assertStringContainsString('<adRemICMS>', $xml);
    }

    public function testICMS10(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '10';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 18.00;
        $std->vBCFCP = 100.00;
        $std->pFCP = 2.0000;
        $std->vFCP = 2.00;
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vBCFCPST = 140.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.80;
        $std->vICMSSTDeson = 1.00;
        $std->motDesICMSST = 3;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS10>', $xml);
        $this->assertStringContainsString('<vFCPST>', $xml);
        $this->assertStringContainsString('<vICMSSTDeson>', $xml);
        $this->assertStringContainsString('<motDesICMSST>', $xml);
    }

    public function testICMS15(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '15';
        $std->qBCMono = 100.0000;
        $std->adRemICMS = 1.5000;
        $std->vICMSMono = 150.00;
        $std->qBCMonoReten = 50.0000;
        $std->adRemICMSReten = 1.0000;
        $std->vICMSMonoReten = 50.00;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS15>', $xml);
        $this->assertStringContainsString('<qBCMonoReten>', $xml);
        $this->assertStringNotContainsString('<pRedAdRem>', $xml);
    }

    public function testICMS15WithPRedAdRem(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '15';
        $std->qBCMono = 100.0000;
        $std->adRemICMS = 1.5000;
        $std->vICMSMono = 150.00;
        $std->qBCMonoReten = 50.0000;
        $std->adRemICMSReten = 1.0000;
        $std->vICMSMonoReten = 50.00;
        $std->pRedAdRem = 10.00;
        $std->motRedAdRem = 1;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS15>', $xml);
        $this->assertStringContainsString('<pRedAdRem>', $xml);
        $this->assertStringContainsString('<motRedAdRem>', $xml);
    }

    public function testICMS20(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '20';
        $std->modBC = 3;
        $std->pRedBC = 10.0000;
        $std->vBC = 90.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 16.20;
        $std->vBCFCP = 90.00;
        $std->pFCP = 2.0000;
        $std->vFCP = 1.80;
        $std->vICMSDeson = 1.80;
        $std->motDesICMS = 9;
        $std->indDeduzDeson = 1;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS20>', $xml);
        $this->assertStringContainsString('<vICMSDeson>', $xml);
        $this->assertStringContainsString('<indDeduzDeson>', $xml);
    }

    public function testICMS30(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '30';
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vBCFCPST = 140.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.80;
        $std->vICMSDeson = 1.80;
        $std->motDesICMS = 9;
        $std->indDeduzDeson = 1;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS30>', $xml);
        $this->assertStringContainsString('<vBCFCPST>', $xml);
        $this->assertStringContainsString('<indDeduzDeson>', $xml);
    }

    public function testICMS40(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '40';
        $std->vICMSDeson = 18.00;
        $std->motDesICMS = 1;
        $std->indDeduzDeson = 1;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS40>', $xml);
        $this->assertStringContainsString('<vICMSDeson>', $xml);
    }

    public function testICMS41(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '41';
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS40>', $xml);
        $this->assertStringContainsString('<CST>41</CST>', $xml);
    }

    public function testICMS50(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '50';
        $std->vICMSDeson = 5.00;
        $std->motDesICMS = 9;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS40>', $xml);
        $this->assertStringContainsString('<CST>50</CST>', $xml);
    }

    public function testICMS51WithDif(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '51';
        $std->modBC = 3;
        $std->pRedBC = 10.0000;
        $std->cBenefRBC = 'SP999999';
        $std->vBC = 90.00;
        $std->pICMS = 18.0000;
        $std->vICMSOp = 16.20;
        $std->pDif = 33.3333;
        $std->vICMSDif = 5.40;
        $std->vICMS = 10.80;
        $std->vBCFCP = 90.00;
        $std->pFCP = 2.0000;
        $std->vFCP = 1.80;
        $std->pFCPDif = 33.33;
        $std->vFCPDif = 0.60;
        $std->vFCPEfet = 1.20;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS51>', $xml);
        $this->assertStringContainsString('<pDif>', $xml);
        $this->assertStringContainsString('<vICMSDif>', $xml);
        $this->assertStringContainsString('<cBenefRBC>', $xml);
        $this->assertStringContainsString('<pFCPDif>', $xml);
        $this->assertStringContainsString('<vFCPDif>', $xml);
        $this->assertStringContainsString('<vFCPEfet>', $xml);
    }

    public function testICMS51Minimal(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '51';
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS51>', $xml);
        $this->assertStringNotContainsString('<pDif>', $xml);
    }

    public function testICMS53(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '53';
        $std->qBCMono = 100.0000;
        $std->adRemICMS = 1.5000;
        $std->vICMSMonoOp = 150.00;
        $std->pDif = 33.3333;
        $std->vICMSMonoDif = 50.00;
        $std->vICMSMono = 100.00;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS53>', $xml);
        $this->assertStringContainsString('<vICMSMonoOp>', $xml);
        $this->assertStringContainsString('<vICMSMonoDif>', $xml);
    }

    public function testICMS60(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '60';
        $std->vBCSTRet = 100.00;
        $std->pST = 18.0000;
        $std->vICMSSubstituto = 10.00;
        $std->vICMSSTRet = 8.00;
        $std->vBCFCPSTRet = 100.00;
        $std->pFCPSTRet = 2.0000;
        $std->vFCPSTRet = 2.00;
        $std->pRedBCEfet = 10.0000;
        $std->vBCEfet = 90.00;
        $std->pICMSEfet = 18.0000;
        $std->vICMSEfet = 16.20;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS60>', $xml);
        $this->assertStringContainsString('<vICMSSubstituto>', $xml);
        $this->assertStringContainsString('<pRedBCEfet>', $xml);
        $this->assertStringContainsString('<vICMSEfet>', $xml);
    }

    public function testICMS60Minimal(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '60';
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS60>', $xml);
        $this->assertStringNotContainsString('<vICMSSubstituto>', $xml);
    }

    public function testICMS61(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '61';
        $std->qBCMonoRet = 100.0000;
        $std->adRemICMSRet = 1.5000;
        $std->vICMSMonoRet = 150.00;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS61>', $xml);
        $this->assertStringContainsString('<adRemICMSRet>', $xml);
    }

    public function testICMS70Full(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '70';
        $std->modBC = 3;
        $std->pRedBC = 10.0000;
        $std->vBC = 90.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 16.20;
        $std->vBCFCP = 90.00;
        $std->pFCP = 2.0000;
        $std->vFCP = 1.80;
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 126.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 6.48;
        $std->vBCFCPST = 126.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.52;
        $std->vICMSDeson = 1.80;
        $std->motDesICMS = 9;
        $std->indDeduzDeson = 1;
        $std->vICMSSTDeson = 1.00;
        $std->motDesICMSST = 3;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS70>', $xml);
        $this->assertStringContainsString('<vICMSSTDeson>', $xml);
        $this->assertStringContainsString('<motDesICMSST>', $xml);
        $this->assertStringContainsString('<indDeduzDeson>', $xml);
    }

    public function testICMS70WithoutSTDeson(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '70';
        $std->modBC = 3;
        $std->pRedBC = 10.0000;
        $std->vBC = 90.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 16.20;
        $std->modBCST = 4;
        $std->vBCST = 126.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 6.48;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS70>', $xml);
        $this->assertStringNotContainsString('<vICMSSTDeson>', $xml);
    }

    public function testICMS90Full(): void
    {
        $this->markTestSkipped('Campos estarão disponíveis a partir de junho/2026, aguardando publicação do XSD.');
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '90';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pRedBC = 10.0000;
        $std->cBenefRBC = 'SP999999';
        $std->pICMS = 18.0000;
        $std->vICMSOp = 16.20;
        $std->pDif = 33.3333;
        $std->vICMSDif = 5.40;
        $std->vICMS = 10.80;
        $std->vBCFCP = 100.00;
        $std->pFCP = 2.0000;
        $std->vFCP = 2.00;
        $std->pFCPDif = 33.3333;
        $std->vFCPDif = 0.67;
        $std->vFCPEfet = 1.33;
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vBCFCPST = 140.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.80;
        $std->vICMSDeson = 1.80;
        $std->motDesICMS = 9;
        $std->indDeduzDeson = 1;
        $std->vICMSSTDeson = 1.00;
        $std->motDesICMSST = 3;
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS90>', $xml);
        $this->assertStringContainsString('<cBenefRBC>', $xml);
        $this->assertStringContainsString('<vICMSOp>', $xml);
        $this->assertStringContainsString('<pDif>', $xml);
        $this->assertStringContainsString('<vICMSDif>', $xml);
        $this->assertStringContainsString('<pFCPDif>', $xml);
        $this->assertStringContainsString('<vFCPDif>', $xml);
        $this->assertStringContainsString('<vFCPEfet>', $xml);
        $this->assertStringContainsString('<vICMSSTDeson>', $xml);
        $this->assertStringContainsString('<motDesICMSST>', $xml);
    }

    public function testICMS90Minimal(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '90';
        $result = $this->make->tagICMS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMS90>', $xml);
        $this->assertStringNotContainsString('<cBenefRBC>', $xml);
    }

    // =========================================================================
    // ICMSPart
    // =========================================================================

    public function testICMSPart(): void
    {
        $this->markTestSkipped('Campos estarão disponíveis a partir de junho/2026, aguardando publicação do XSD.');
        // Initialize stdTot->vICMSST which the trait accesses but Make's constructor does not set
        if (!isset($this->make->stdTot->vICMSST)) {
            $this->make->stdTot->vICMSST = 0;
        }
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '10';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pRedBC = 0;
        $std->pICMS = 18.0000;
        $std->vICMS = 18.00;
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vBCFCPST = 140.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.80;
        $std->pBCOp = 100.0000;
        $std->UFST = 'SP';
        $std->vICMSDeson = 1.00;
        $std->motDesICMS = 9;
        $std->indDeduzDeson = 1;
        $result = $this->make->tagICMSPart($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSPart>', $xml);
        $this->assertStringContainsString('<UFST>', $xml);
        $this->assertStringContainsString('<vICMSDeson>', $xml);
    }

    // =========================================================================
    // ICMSST
    // =========================================================================

    public function testICMSST(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '41';
        $std->vBCSTRet = 100.00;
        $std->pST = 18.0000;
        $std->vICMSSubstituto = 10.00;
        $std->vICMSSTRet = 8.00;
        $std->vBCFCPSTRet = 100.00;
        $std->pFCPSTRet = 2.0000;
        $std->vFCPSTRet = 2.00;
        $std->vBCSTDest = 80.00;
        $std->vICMSSTDest = 14.40;
        $std->pRedBCEfet = 10.0000;
        $std->vBCEfet = 90.00;
        $std->pICMSEfet = 18.0000;
        $std->vICMSEfet = 16.20;
        $result = $this->make->tagICMSST($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSST>', $xml);
        $this->assertStringContainsString('<vICMSSubstituto>', $xml);
        $this->assertStringContainsString('<vICMSEfet>', $xml);
    }

    // =========================================================================
    // ICMSSN (Simples Nacional) CSOSN TESTS
    // =========================================================================

    public function testICMSSN101(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '101';
        $std->pCredSN = 2.00;
        $std->vCredICMSSN = 2.00;
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN101>', $xml);
        $this->assertStringContainsString('<pCredSN>', $xml);
    }

    public function testICMSSN102(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '102';
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN102>', $xml);
    }

    public function testICMSSN103(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '103';
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN102>', $xml);
        $this->assertStringContainsString('<CSOSN>103</CSOSN>', $xml);
    }

    public function testICMSSN300(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '300';
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN102>', $xml);
        $this->assertStringContainsString('<CSOSN>300</CSOSN>', $xml);
    }

    public function testICMSSN400(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '400';
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN102>', $xml);
        $this->assertStringContainsString('<CSOSN>400</CSOSN>', $xml);
    }

    public function testICMSSN201Full(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '201';
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vBCFCPST = 140.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.80;
        $std->pCredSN = 2.0000;
        $std->vCredICMSSN = 2.00;
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN201>', $xml);
        $this->assertStringContainsString('<vBCFCPST>', $xml);
        $this->assertStringContainsString('<pFCPST>', $xml);
        $this->assertStringContainsString('<vFCPST>', $xml);
        $this->assertStringContainsString('<pCredSN>', $xml);
        $this->assertStringContainsString('<vCredICMSSN>', $xml);
    }

    public function testICMSSN201Minimal(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '201';
        $std->modBCST = 4;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN201>', $xml);
        $this->assertStringNotContainsString('<vBCFCPST>', $xml);
    }

    public function testICMSSN202(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '202';
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vBCFCPST = 140.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.80;
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN202>', $xml);
        $this->assertStringContainsString('<vFCPST>', $xml);
    }

    public function testICMSSN203(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '203';
        $std->modBCST = 4;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN202>', $xml);
        $this->assertStringContainsString('<CSOSN>203</CSOSN>', $xml);
    }

    public function testICMSSN500Full(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '500';
        $std->vBCSTRet = 100.00;
        $std->pST = 18.0000;
        $std->vICMSSubstituto = 10.00;
        $std->vICMSSTRet = 8.00;
        $std->vBCFCPSTRet = 100.00;
        $std->pFCPSTRet = 2.0000;
        $std->vFCPSTRet = 2.00;
        $std->pRedBCEfet = 10.0000;
        $std->vBCEfet = 90.00;
        $std->pICMSEfet = 18.0000;
        $std->vICMSEfet = 16.20;
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN500>', $xml);
        $this->assertStringContainsString('<vICMSSubstituto>', $xml);
        $this->assertStringContainsString('<vBCFCPSTRet>', $xml);
        $this->assertStringContainsString('<pRedBCEfet>', $xml);
        $this->assertStringContainsString('<vICMSEfet>', $xml);
    }

    public function testICMSSN500Minimal(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '500';
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN500>', $xml);
        $this->assertStringNotContainsString('<vICMSSubstituto>', $xml);
    }

    public function testICMSSN900Full(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CSOSN = '900';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pRedBC = 10.0000;
        $std->pICMS = 18.0000;
        $std->vICMS = 16.20;
        $std->modBCST = 4;
        $std->pMVAST = 40.0000;
        $std->pRedBCST = 0;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vBCFCPST = 140.00;
        $std->pFCPST = 2.0000;
        $std->vFCPST = 2.80;
        $std->pCredSN = 2.0000;
        $std->vCredICMSSN = 2.00;
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN900>', $xml);
        $this->assertStringContainsString('<modBC>', $xml);
        $this->assertStringContainsString('<pRedBC>', $xml);
        $this->assertStringContainsString('<vBCFCPST>', $xml);
        $this->assertStringContainsString('<pCredSN>', $xml);
    }

    public function testICMSSN900Minimal(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CSOSN = '900';
        $result = $this->make->tagICMSSN($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSSN900>', $xml);
        $this->assertStringNotContainsString('<modBC>', $xml);
    }

    // =========================================================================
    // ICMSUFDest
    // =========================================================================

    public function testICMSUFDest(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBCUFDest = 100.00;
        $std->vBCFCPUFDest = 100.00;
        $std->pFCPUFDest = 2.0000;
        $std->pICMSUFDest = 18.0000;
        $std->pICMSInter = 12.00;
        $std->pICMSInterPart = 100.00;
        $std->vFCPUFDest = 2.00;
        $std->vICMSUFDest = 6.00;
        $std->vICMSUFRemet = 0;
        $result = $this->make->tagICMSUFDest($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<ICMSUFDest>', $xml);
        $this->assertStringContainsString('<vBCUFDest>', $xml);
    }

    // =========================================================================
    // PIS TESTS
    // =========================================================================

    public function testPISAliqCST01(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = 1.65;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISAliq>', $xml);
        $this->assertStringContainsString('<CST>01</CST>', $xml);
        $this->assertStringContainsString('<vBC>', $xml);
        $this->assertStringContainsString('<pPIS>', $xml);
        $this->assertStringContainsString('<vPIS>', $xml);
    }

    public function testPISAliqCST02(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '02';
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = 1.65;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISAliq>', $xml);
        $this->assertStringContainsString('<CST>02</CST>', $xml);
    }

    public function testPISQtdeCST03(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '03';
        $std->qBCProd = 100.0000;
        $std->vAliqProd = 0.0165;
        $std->vPIS = 1.65;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISQtde>', $xml);
        $this->assertStringContainsString('<qBCProd>', $xml);
        $this->assertStringContainsString('<vAliqProd>', $xml);
    }

    /**
     * @dataProvider pisNTCSTProvider
     */
    public function testPISNT(string $cst): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = $cst;
        $std->vPIS = 0;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISNT>', $xml);
        $this->assertStringContainsString("<CST>{$cst}</CST>", $xml);
    }

    public static function pisNTCSTProvider(): array
    {
        return [
            'CST 04' => ['04'],
            'CST 05' => ['05'],
            'CST 06' => ['06'],
            'CST 07' => ['07'],
            'CST 08' => ['08'],
            'CST 09' => ['09'],
        ];
    }

    public function testPISOutrWithVBC(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '49';
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = 1.65;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISOutr>', $xml);
        $this->assertStringContainsString('<vBC>', $xml);
        $this->assertStringContainsString('<pPIS>', $xml);
        $this->assertStringNotContainsString('<qBCProd>', $xml);
    }

    public function testPISOutrWithQBCProd(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '99';
        $std->qBCProd = 100.0000;
        $std->vAliqProd = 0.0165;
        $std->vPIS = 1.65;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISOutr>', $xml);
        $this->assertStringContainsString('<qBCProd>', $xml);
        $this->assertStringContainsString('<vAliqProd>', $xml);
        $this->assertStringNotContainsString('<vBC>', $xml);
    }

    /**
     * @dataProvider pisOutrCSTProvider
     */
    public function testPISOutrVariousCST(string $cst): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = $cst;
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = 1.65;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISOutr>', $xml);
        $this->assertStringContainsString("<CST>{$cst}</CST>", $xml);
    }

    public static function pisOutrCSTProvider(): array
    {
        return [
            'CST 50' => ['50'],
            'CST 51' => ['51'],
            'CST 52' => ['52'],
            'CST 53' => ['53'],
            'CST 54' => ['54'],
            'CST 55' => ['55'],
            'CST 56' => ['56'],
            'CST 60' => ['60'],
            'CST 61' => ['61'],
            'CST 62' => ['62'],
            'CST 63' => ['63'],
            'CST 64' => ['64'],
            'CST 65' => ['65'],
            'CST 66' => ['66'],
            'CST 67' => ['67'],
            'CST 70' => ['70'],
            'CST 71' => ['71'],
            'CST 72' => ['72'],
            'CST 73' => ['73'],
            'CST 74' => ['74'],
            'CST 75' => ['75'],
            'CST 98' => ['98'],
        ];
    }

    // =========================================================================
    // PISST
    // =========================================================================

    public function testPISSTWithVBC(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = 1.65;
        $std->indSomaPISST = 1;
        $result = $this->make->tagPISST($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISST>', $xml);
        $this->assertStringContainsString('<vBC>', $xml);
        $this->assertStringContainsString('<pPIS>', $xml);
        $this->assertStringContainsString('<indSomaPISST>', $xml);
    }

    public function testPISSTWithQBCProd(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCProd = 100.0000;
        $std->vAliqProd = 0.0165;
        $std->vPIS = 1.65;
        $std->indSomaPISST = 0;
        $result = $this->make->tagPISST($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISST>', $xml);
        $this->assertStringContainsString('<qBCProd>', $xml);
        $this->assertStringContainsString('<vAliqProd>', $xml);
        $this->assertStringNotContainsString('<vBC>', $xml);
    }

    // =========================================================================
    // COFINS TESTS
    // =========================================================================

    public function testCOFINSAliqCST01(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $result = $this->make->tagCOFINS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSAliq>', $xml);
        $this->assertStringContainsString('<CST>01</CST>', $xml);
        $this->assertStringContainsString('<vBC>', $xml);
        $this->assertStringContainsString('<pCOFINS>', $xml);
        $this->assertStringContainsString('<vCOFINS>', $xml);
    }

    public function testCOFINSAliqCST02(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '02';
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $result = $this->make->tagCOFINS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSAliq>', $xml);
        $this->assertStringContainsString('<CST>02</CST>', $xml);
    }

    public function testCOFINSQtdeCST03(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '03';
        $std->qBCProd = 100.0000;
        $std->vAliqProd = 0.0760;
        $std->vCOFINS = 7.60;
        $result = $this->make->tagCOFINS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSQtde>', $xml);
        $this->assertStringContainsString('<qBCProd>', $xml);
        $this->assertStringContainsString('<vAliqProd>', $xml);
    }

    /**
     * @dataProvider cofinsNTCSTProvider
     */
    public function testCOFINSNT(string $cst): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = $cst;
        $std->vCOFINS = 0;
        $result = $this->make->tagCOFINS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSNT>', $xml);
        $this->assertStringContainsString("<CST>{$cst}</CST>", $xml);
    }

    public static function cofinsNTCSTProvider(): array
    {
        return [
            'CST 04' => ['04'],
            'CST 05' => ['05'],
            'CST 06' => ['06'],
            'CST 07' => ['07'],
            'CST 08' => ['08'],
            'CST 09' => ['09'],
        ];
    }

    public function testCOFINSOutrWithVBC(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '49';
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $result = $this->make->tagCOFINS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSOutr>', $xml);
        $this->assertStringContainsString('<vBC>', $xml);
        $this->assertStringContainsString('<pCOFINS>', $xml);
        $this->assertStringNotContainsString('<qBCProd>', $xml);
    }

    public function testCOFINSOutrWithQBCProd(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '99';
        $std->qBCProd = 100.0000;
        $std->vAliqProd = 0.0760;
        $std->vCOFINS = 7.60;
        $result = $this->make->tagCOFINS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSOutr>', $xml);
        $this->assertStringContainsString('<qBCProd>', $xml);
        $this->assertStringContainsString('<vAliqProd>', $xml);
        $this->assertStringNotContainsString('<vBC>', $xml);
    }

    /**
     * @dataProvider cofinsOutrCSTProvider
     */
    public function testCOFINSOutrVariousCST(string $cst): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = $cst;
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $result = $this->make->tagCOFINS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSOutr>', $xml);
        $this->assertStringContainsString("<CST>{$cst}</CST>", $xml);
    }

    public static function cofinsOutrCSTProvider(): array
    {
        return [
            'CST 50' => ['50'],
            'CST 51' => ['51'],
            'CST 52' => ['52'],
            'CST 53' => ['53'],
            'CST 54' => ['54'],
            'CST 55' => ['55'],
            'CST 56' => ['56'],
            'CST 60' => ['60'],
            'CST 61' => ['61'],
            'CST 62' => ['62'],
            'CST 63' => ['63'],
            'CST 64' => ['64'],
            'CST 65' => ['65'],
            'CST 66' => ['66'],
            'CST 67' => ['67'],
            'CST 70' => ['70'],
            'CST 71' => ['71'],
            'CST 72' => ['72'],
            'CST 73' => ['73'],
            'CST 74' => ['74'],
            'CST 75' => ['75'],
            'CST 98' => ['98'],
        ];
    }

    // =========================================================================
    // COFINSST
    // =========================================================================

    public function testCOFINSSTWithVBC(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $std->indSomaCOFINSST = 1;
        $result = $this->make->tagCOFINSST($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSST>', $xml);
        $this->assertStringContainsString('<vBC>', $xml);
        $this->assertStringContainsString('<pCOFINS>', $xml);
        $this->assertStringContainsString('<indSomaCOFINSST>', $xml);
    }

    public function testCOFINSSTWithQBCProd(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->qBCProd = 100.0000;
        $std->vAliqProd = 0.0760;
        $std->vCOFINS = 7.60;
        $std->indSomaCOFINSST = 0;
        $result = $this->make->tagCOFINSST($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<COFINSST>', $xml);
        $this->assertStringContainsString('<qBCProd>', $xml);
        $this->assertStringContainsString('<vAliqProd>', $xml);
        $this->assertStringNotContainsString('<vBC>', $xml);
    }

    public function testCOFINSSTWithIndSoma1(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $std->indSomaCOFINSST = 1;
        $this->make->tagCOFINSST($std);
        // Verify the totalizer was updated - if indSomaCOFINSST == 1,
        // stdTot->vCOFINSST should include vCOFINS
        $this->assertEquals(7.60, $this->make->stdTot->vCOFINSST);
    }

    public function testCOFINSSTWithIndSoma0(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $std->indSomaCOFINSST = 0;
        $this->make->tagCOFINSST($std);
        // indSomaCOFINSST == 0 means it should NOT add to totalizer
        $this->assertEquals(0, $this->make->stdTot->vCOFINSST);
    }

    // =========================================================================
    // PISST totalizer tests
    // =========================================================================

    public function testPISSTWithIndSoma1(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = 1.65;
        $std->indSomaPISST = 1;
        $this->make->tagPISST($std);
        $this->assertEquals(1.65, $this->make->stdTot->vPISST);
    }

    public function testPISSTWithIndSoma0(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = 1.65;
        $std->indSomaPISST = 0;
        $this->make->tagPISST($std);
        $this->assertEquals(0, $this->make->stdTot->vPISST);
    }

    // =========================================================================
    // PIS/COFINS Totalizer branch tests (vPIS empty vs filled)
    // =========================================================================

    public function testPISAliqWithEmptyVPIS(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = null;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISAliq>', $xml);
    }

    public function testCOFINSAliqTotalizer(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $this->make->tagCOFINS($std);
        $this->assertEquals(7.60, $this->make->stdTot->vCOFINS);
    }

    public function testCOFINSQtdeTotalizer(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '03';
        $std->qBCProd = 100.0000;
        $std->vAliqProd = 0.0760;
        $std->vCOFINS = 7.60;
        $this->make->tagCOFINS($std);
        $this->assertEquals(7.60, $this->make->stdTot->vCOFINS);
    }

    public function testCOFINSOutrTotalizer(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '99';
        $std->vBC = 100.00;
        $std->pCOFINS = 7.6000;
        $std->vCOFINS = 7.60;
        $this->make->tagCOFINS($std);
        $this->assertEquals(7.60, $this->make->stdTot->vCOFINS);
    }

    // =========================================================================
    // PIS Outr without vPIS (null branch)
    // =========================================================================

    public function testPISOutrWithNullVPIS(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->CST = '99';
        $std->vBC = 100.00;
        $std->pPIS = 1.6500;
        $std->vPIS = null;
        $result = $this->make->tagPIS($std);
        $xml = $result->ownerDocument->saveXML($result);
        $this->assertStringContainsString('<PISOutr>', $xml);
    }

    // =========================================================================
    // ICMS totalization checks
    // =========================================================================

    public function testICMS00Totals(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '00';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 18.00;
        $this->make->tagICMS($std);
        $this->assertEquals(100.00, $this->make->stdTot->vBC);
        $this->assertEquals(18.00, $this->make->stdTot->vICMS);
    }

    public function testICMS10Totals(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '10';
        $std->modBC = 3;
        $std->vBC = 100.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 18.00;
        $std->modBCST = 4;
        $std->vBCST = 140.00;
        $std->pICMSST = 18.0000;
        $std->vICMSST = 7.20;
        $std->vFCPST = 2.80;
        $std->vFCP = 2.00;
        $this->make->tagICMS($std);
        $this->assertEquals(140.00, $this->make->stdTot->vBCST);
        $this->assertEquals(7.20, $this->make->stdTot->vST);
        $this->assertEquals(2.80, $this->make->stdTot->vFCPST);
    }

    public function testICMS20Totals(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '20';
        $std->modBC = 3;
        $std->pRedBC = 10.0000;
        $std->vBC = 90.00;
        $std->pICMS = 18.0000;
        $std->vICMS = 16.20;
        $std->vICMSDeson = 1.80;
        $std->motDesICMS = 9;
        $this->make->tagICMS($std);
        $this->assertEquals(1.80, $this->make->stdTot->vICMSDeson);
    }

    public function testICMS02Totals(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '02';
        $std->qBCMono = 100.0000;
        $std->adRemICMS = 1.5000;
        $std->vICMSMono = 150.00;
        $this->make->tagICMS($std);
        $this->assertEquals(100.0, $this->make->stdTot->qBCMono);
        $this->assertEquals(150.00, $this->make->stdTot->vICMSMono);
    }

    public function testICMS61Totals(): void
    {
        $std = new \stdClass();
        $std->item = 1;
        $std->orig = 0;
        $std->CST = '61';
        $std->qBCMonoRet = 100.0000;
        $std->adRemICMSRet = 1.5000;
        $std->vICMSMonoRet = 150.00;
        $this->make->tagICMS($std);
        $this->assertEquals(100.0, $this->make->stdTot->qBCMonoRet);
        $this->assertEquals(150.00, $this->make->stdTot->vICMSMonoRet);
    }
}
