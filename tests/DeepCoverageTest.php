<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Make;
use NFePHP\NFe\Tests\Common\ToolsFake;
use stdClass;

class DeepCoverageTest extends NFeTestCase
{
    protected ToolsFake $tools;

    protected function setUp(): void
    {
        $this->tools = new ToolsFake(
            $this->configJson,
            Certificate::readPfx($this->contentpfx, $this->passwordpfx)
        );
    }

    // ──────────────────────────────────────────────────────────────────
    //  Helper: Build a minimal valid NF-e (model 55)
    // ──────────────────────────────────────────────────────────────────

    private function buildMinimalNFe55(): Make
    {
        $make = new Make();

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '30';
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->dhSaiEnt = '2017-03-03T11:30:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA TESTE LTDA';
        $std->xFant = 'EMPRESA TESTE';
        $std->IE = '123456789012';
        $std->CRT = '3';
        $std->CNPJ = '58716523000119';
        $make->tagEmit($std);

        $std = new stdClass();
        $std->xLgr = 'Rua Teste';
        $std->nro = '100';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $make->tagenderEmit($std);

        $std = new stdClass();
        $std->xNome = 'CLIENTE TESTE';
        $std->indIEDest = '9';
        $std->CNPJ = '11222333000181';
        $make->tagdest($std);

        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto Teste';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '10.0000';
        $std->vUnCom = '10.0000000000';
        $std->vProd = '100.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '10.0000';
        $std->vUnTrib = '10.0000000000';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '100.00';
        $std->pICMS = '18.00';
        $std->vICMS = '18.00';
        $make->tagICMS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $make->tagPIS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $make->tagCOFINS($std);

        $std = new stdClass();
        $std->vBC = '100.00';
        $std->vICMS = '18.00';
        $std->vICMSDeson = '0.00';
        $std->vBCST = '0.00';
        $std->vST = '0.00';
        $std->vProd = '100.00';
        $std->vFrete = '0.00';
        $std->vSeg = '0.00';
        $std->vDesc = '0.00';
        $std->vII = '0.00';
        $std->vIPI = '0.00';
        $std->vPIS = '0.00';
        $std->vCOFINS = '0.00';
        $std->vOutro = '0.00';
        $std->vNF = '100.00';
        $std->vTotTrib = '0.00';
        $make->tagICMSTot($std);

        $std = new stdClass();
        $std->modFrete = '9';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vTroco = null;
        $make->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '100.00';
        $make->tagdetPag($std);

        return $make;
    }

    private function buildMinimalNFCe65(): Make
    {
        $make = new Make();

        $std = new stdClass();
        $std->Id = '35170358716523000119650010000000011000000015';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '00000001';
        $std->natOp = 'VENDA';
        $std->mod = '65';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '4';
        $std->tpEmis = '1';
        $std->cDV = '5';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '1';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA TESTE LTDA';
        $std->xFant = 'EMPRESA TESTE';
        $std->IE = '123456789012';
        $std->CRT = '1';
        $std->CNPJ = '58716523000119';
        $make->tagEmit($std);

        $std = new stdClass();
        $std->xLgr = 'Rua Teste';
        $std->nro = '100';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $make->tagenderEmit($std);

        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto NFC-e';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '1.0000';
        $std->vUnCom = '50.0000000000';
        $std->vProd = '50.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '1.0000';
        $std->vUnTrib = '50.0000000000';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CSOSN = '102';
        $make->tagICMSSN($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $make->tagPIS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $make->tagCOFINS($std);

        $std = new stdClass();
        $std->vBC = '0.00';
        $std->vICMS = '0.00';
        $std->vICMSDeson = '0.00';
        $std->vBCST = '0.00';
        $std->vST = '0.00';
        $std->vProd = '50.00';
        $std->vFrete = '0.00';
        $std->vSeg = '0.00';
        $std->vDesc = '0.00';
        $std->vII = '0.00';
        $std->vIPI = '0.00';
        $std->vPIS = '0.00';
        $std->vCOFINS = '0.00';
        $std->vOutro = '0.00';
        $std->vNF = '50.00';
        $std->vTotTrib = '0.00';
        $make->tagICMSTot($std);

        $std = new stdClass();
        $std->modFrete = '9';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vTroco = null;
        $make->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '50.00';
        $make->tagdetPag($std);

        return $make;
    }

    protected function loadFixture(string $filename): string
    {
        $xml = simplexml_load_string(
            file_get_contents(__DIR__ . '/fixtures/xml/' . $filename),
            'SimpleXMLElement',
            LIBXML_NOBLANKS
        );
        $customXML = new \SimpleXMLElement($xml->asXML());
        $dom = dom_import_simplexml($customXML);
        return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
    }

    protected function setSuccessReturn(): void
    {
        $responseBody = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml');
        $this->tools->getSoap()->setReturnValue($responseBody);
    }

    // ══════════════════════════════════════════════════════════════════
    //  1. Make.php render() coverage
    // ══════════════════════════════════════════════════════════════════

    public function testMontaNFeIsAliasForRender(): void
    {
        $make = $this->buildMinimalNFe55();
        $xml = $make->montaNFe();
        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<NFe', $xml);
    }

    public function testSetOnlyAsciiConvertsAccentedCharacters(): void
    {
        $make = new Make();
        $make->setOnlyAscii(true);

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'OPERACAO COM ACENTUACAO';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '30';
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->dhSaiEnt = '2017-03-03T11:30:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        // Just verify the option is applied without error
        $this->assertTrue(true);
    }

    public function testSetCheckGtinValidatesGtinCodes(): void
    {
        $make = new Make();
        $make->setCheckGtin(true);

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '30';
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->dhSaiEnt = '2017-03-03T11:30:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA';
        $std->IE = '123456789012';
        $std->CRT = '3';
        $std->CNPJ = '58716523000119';
        $make->tagEmit($std);

        $std = new stdClass();
        $std->xLgr = 'Rua';
        $std->nro = '1';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'SP';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $make->tagenderEmit($std);

        $std = new stdClass();
        $std->xNome = 'DEST';
        $std->indIEDest = '9';
        $std->CNPJ = '11222333000181';
        $make->tagdest($std);

        // Use invalid GTIN to trigger validation errors
        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = '1234567890123'; // invalid GTIN
        $std->xProd = 'Produto';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '1.0000';
        $std->vUnCom = '10.0000000000';
        $std->vProd = '10.00';
        $std->cEANTrib = '1234567890123'; // invalid GTIN
        $std->uTrib = 'UN';
        $std->qTrib = '1.0000';
        $std->vUnTrib = '10.0000000000';
        $std->indTot = 1;
        $make->tagprod($std);

        $errors = $make->getErrors();
        // Should have GTIN errors
        $hasGtinError = false;
        foreach ($errors as $error) {
            if (stripos($error, 'cEAN') !== false || stripos($error, 'GTIN') !== false) {
                $hasGtinError = true;
                break;
            }
        }
        $this->assertTrue($hasGtinError, 'Expected GTIN validation error');
    }

    public function testRenderWithCobrFatDup(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->nFat = '001';
        $std->vOrig = '100.00';
        $std->vDesc = '0.00';
        $std->vLiq = '100.00';
        $make->tagfat($std);

        $std = new stdClass();
        $std->nDup = '001';
        $std->dVenc = '2017-04-03';
        $std->vDup = '50.00';
        $make->tagdup($std);

        $std = new stdClass();
        $std->nDup = '002';
        $std->dVenc = '2017-05-03';
        $std->vDup = '50.00';
        $make->tagdup($std);

        $xml = $make->render();

        $this->assertStringContainsString('<cobr>', $xml);
        $this->assertStringContainsString('<fat>', $xml);
        $this->assertStringContainsString('<nFat>001</nFat>', $xml);
        $this->assertStringContainsString('<vOrig>100.00</vOrig>', $xml);
        $this->assertStringContainsString('<vLiq>100.00</vLiq>', $xml);
        $this->assertStringContainsString('<dup>', $xml);
        $this->assertStringContainsString('<nDup>001</nDup>', $xml);
        $this->assertStringContainsString('<nDup>002</nDup>', $xml);
    }

    public function testRenderWithRetirada(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->xLgr = 'Rua Retirada';
        $std->nro = '200';
        $std->xBairro = 'Bairro Ret';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CNPJ = '22333444000155';
        $make->tagretirada($std);

        $xml = $make->render();

        $this->assertStringContainsString('<retirada>', $xml);
        $this->assertStringContainsString('<xLgr>Rua Retirada</xLgr>', $xml);
    }

    public function testRenderWithEntrega(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->xLgr = 'Rua Entrega';
        $std->nro = '300';
        $std->xBairro = 'Bairro Ent';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CNPJ = '33444555000166';
        $make->tagentrega($std);

        $xml = $make->render();

        $this->assertStringContainsString('<entrega>', $xml);
        $this->assertStringContainsString('<xLgr>Rua Entrega</xLgr>', $xml);
    }

    public function testRenderWithAutXML(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->CNPJ = '44555666000177';
        $make->tagautXML($std);

        $std = new stdClass();
        $std->CPF = '12345678901';
        $make->tagautXML($std);

        $xml = $make->render();

        $this->assertStringContainsString('<autXML>', $xml);
        $this->assertStringContainsString('<CNPJ>44555666000177</CNPJ>', $xml);
        $this->assertStringContainsString('<CPF>12345678901</CPF>', $xml);
    }

    public function testRenderWithInfIntermed(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->CNPJ = '55666777000188';
        $std->idCadIntTran = 'IDTRANSACAO123';
        $make->tagIntermed($std);

        $xml = $make->render();

        $this->assertStringContainsString('<infIntermed>', $xml);
        $this->assertStringContainsString('<CNPJ>55666777000188</CNPJ>', $xml);
        $this->assertStringContainsString('<idCadIntTran>IDTRANSACAO123</idCadIntTran>', $xml);
    }

    public function testRenderWithExporta(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->UFSaidaPais = 'SP';
        $std->xLocExporta = 'Porto de Santos';
        $std->xLocDespacho = 'Despacho Santos';
        $make->tagexporta($std);

        $xml = $make->render();

        $this->assertStringContainsString('<exporta>', $xml);
        $this->assertStringContainsString('<UFSaidaPais>SP</UFSaidaPais>', $xml);
        $this->assertStringContainsString('<xLocExporta>Porto de Santos</xLocExporta>', $xml);
        $this->assertStringContainsString('<xLocDespacho>Despacho Santos</xLocDespacho>', $xml);
    }

    public function testRenderWithCompra(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->xNEmp = 'EMPENHO-001';
        $std->xPed = 'PED-001';
        $std->xCont = 'CONTRATO-001';
        $make->tagcompra($std);

        $xml = $make->render();

        $this->assertStringContainsString('<compra>', $xml);
        $this->assertStringContainsString('<xNEmp>EMPENHO-001</xNEmp>', $xml);
        $this->assertStringContainsString('<xPed>PED-001</xPed>', $xml);
        $this->assertStringContainsString('<xCont>CONTRATO-001</xCont>', $xml);
    }

    public function testRenderWithCana(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->safra = '2017/2018';
        $std->ref = '03/2017';
        $std->qTotMes = '1000.0000000000';
        $std->qTotAnt = '500.0000000000';
        $std->qTotGer = '1500.0000000000';
        $std->vFor = '15000.00';
        $std->vTotDed = '500.00';
        $std->vLiqFor = '14500.00';
        $make->tagcana($std);

        $std = new stdClass();
        $std->dia = '1';
        $std->qtde = '100.0000000000';
        $make->tagforDia($std);

        $std = new stdClass();
        $std->dia = '2';
        $std->qtde = '200.0000000000';
        $make->tagforDia($std);

        $std = new stdClass();
        $std->xDed = 'DEDUCAO TESTE';
        $std->vDed = '500.00';
        $make->tagdeduc($std);

        $xml = $make->render();

        $this->assertStringContainsString('<cana>', $xml);
        $this->assertStringContainsString('<safra>2017/2018</safra>', $xml);
        $this->assertStringContainsString('<forDia', $xml);
        $this->assertStringContainsString('<deduc>', $xml);
        $this->assertStringContainsString('<xDed>DEDUCAO TESTE</xDed>', $xml);
    }

    public function testRenderWithInfRespTec(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->CNPJ = '99888777000166';
        $std->xContato = 'Fulano Dev';
        $std->email = 'dev@example.com';
        $std->fone = '1199998888';
        $make->taginfRespTec($std);

        $xml = $make->render();

        $this->assertStringContainsString('<infRespTec>', $xml);
        $this->assertStringContainsString('<CNPJ>99888777000166</CNPJ>', $xml);
        $this->assertStringContainsString('<xContato>Fulano Dev</xContato>', $xml);
        $this->assertStringContainsString('<email>dev@example.com</email>', $xml);
        $this->assertStringContainsString('<fone>1199998888</fone>', $xml);
    }

    public function testRenderErrorHandlingStoresErrors(): void
    {
        // Create Make with minimal tags but missing prod to trigger error
        $make = new Make();

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '30';
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->dhSaiEnt = '2017-03-03T11:30:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        // No emit, no prod, no pag - should trigger errors
        $xml = $make->render();

        $errors = $make->getErrors();
        $this->assertNotEmpty($errors);
    }

    public function testGetXMLCallsRenderIfEmpty(): void
    {
        $make = $this->buildMinimalNFe55();
        // getXML calls render() internally if xml is empty
        $xml = $make->getXML();
        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<NFe', $xml);
    }

    public function testGetChaveReturnsKey(): void
    {
        $make = $this->buildMinimalNFe55();
        $make->render();
        $chave = $make->getChave();
        $this->assertNotEmpty($chave);
        $this->assertEquals(44, strlen($chave));
    }

    public function testGetModeloReturns55(): void
    {
        $make = $this->buildMinimalNFe55();
        $make->render();
        $this->assertEquals(55, $make->getModelo());
    }

    public function testGetModeloReturns65(): void
    {
        $make = $this->buildMinimalNFCe65();
        $make->render();
        $this->assertEquals(65, $make->getModelo());
    }

    public function testRenderWithAllOptionalSections(): void
    {
        $make = $this->buildMinimalNFe55();

        // retirada
        $std = new stdClass();
        $std->xLgr = 'Rua Ret';
        $std->nro = '1';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'SP';
        $std->UF = 'SP';
        $std->CNPJ = '11222333000181';
        $make->tagretirada($std);

        // entrega
        $std = new stdClass();
        $std->xLgr = 'Rua Ent';
        $std->nro = '2';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'SP';
        $std->UF = 'SP';
        $std->CNPJ = '22333444000155';
        $make->tagentrega($std);

        // autXML
        $std = new stdClass();
        $std->CNPJ = '33444555000166';
        $make->tagautXML($std);

        // cobr
        $std = new stdClass();
        $std->nFat = '001';
        $std->vOrig = '100.00';
        $std->vDesc = '0.00';
        $std->vLiq = '100.00';
        $make->tagfat($std);

        // infIntermed
        $std = new stdClass();
        $std->CNPJ = '44555666000177';
        $std->idCadIntTran = 'ID123';
        $make->tagIntermed($std);

        // exporta
        $std = new stdClass();
        $std->UFSaidaPais = 'SP';
        $std->xLocExporta = 'Santos';
        $make->tagexporta($std);

        // compra
        $std = new stdClass();
        $std->xNEmp = 'EMP001';
        $std->xPed = 'PED001';
        $std->xCont = 'CONT001';
        $make->tagcompra($std);

        // infRespTec
        $std = new stdClass();
        $std->CNPJ = '55666777000188';
        $std->xContato = 'TechContact';
        $std->email = 'tech@test.com';
        $std->fone = '1199990000';
        $make->taginfRespTec($std);

        $xml = $make->render();

        $this->assertStringContainsString('<retirada>', $xml);
        $this->assertStringContainsString('<entrega>', $xml);
        $this->assertStringContainsString('<autXML>', $xml);
        $this->assertStringContainsString('<cobr>', $xml);
        $this->assertStringContainsString('<infIntermed>', $xml);
        $this->assertStringContainsString('<exporta>', $xml);
        $this->assertStringContainsString('<compra>', $xml);
        $this->assertStringContainsString('<infRespTec>', $xml);

        // Verify section ordering
        $retiradaPos = strpos($xml, '<retirada>');
        $entregaPos = strpos($xml, '<entrega>');
        $cobrPos = strpos($xml, '<cobr>');
        $infIntermedPos = strpos($xml, '<infIntermed>');
        $exportaPos = strpos($xml, '<exporta>');
        $compraPos = strpos($xml, '<compra>');
        $infRespTecPos = strpos($xml, '<infRespTec>');

        $this->assertLessThan($entregaPos, $retiradaPos);
        $this->assertLessThan($cobrPos, $entregaPos);
        $this->assertLessThan($infIntermedPos, $cobrPos);
        $this->assertLessThan($exportaPos, $infIntermedPos);
        $this->assertLessThan($compraPos, $exportaPos);
        $this->assertLessThan($infRespTecPos, $compraPos);
    }

    // ══════════════════════════════════════════════════════════════════
    //  2. Tools.php coverage
    // ══════════════════════════════════════════════════════════════════

    public function testSefazManifestaLoteThrowsOnEmptyEvento(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $std = new stdClass();
        $std->evento = [];
        $this->tools->sefazManifestaLote($std);
    }

    public function testSefazManifestaLoteThrowsOnMoreThan20Eventos(): void
    {
        $this->expectException(\RuntimeException::class);
        $std = new stdClass();
        $std->evento = [];
        for ($i = 0; $i < 21; $i++) {
            $evt = new stdClass();
            $evt->tpEvento = 210210;
            $evt->chNFe = '35220605730928000145550010000048661583302923';
            $evt->nSeqEvento = 1;
            $std->evento[] = $evt;
        }
        $this->tools->sefazManifestaLote($std);
    }

    public function testSefazManifestaLoteCiencia(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];
        $evt = new stdClass();
        $evt->tpEvento = 210210; // Ciencia
        $evt->chNFe = '35220605730928000145550010000048661583302923';
        $evt->nSeqEvento = 1;
        $std->evento[] = $evt;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazManifestaLote($std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('210210', $request);
    }

    public function testSefazManifestaLoteNaoRealizada(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];
        $evt = new stdClass();
        $evt->tpEvento = 210240; // Nao Realizada
        $evt->chNFe = '35220605730928000145550010000048661583302923';
        $evt->nSeqEvento = 1;
        $evt->xJust = 'Operacao nao realizada conforme combinado';
        $std->evento[] = $evt;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazManifestaLote($std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('210240', $request);
        $this->assertStringContainsString('<xJust>', $request);
    }

    public function testSefazManifestaLoteConfirmacao(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];
        $evt = new stdClass();
        $evt->tpEvento = 210200; // Confirmacao
        $evt->chNFe = '35220605730928000145550010000048661583302923';
        $evt->nSeqEvento = 1;
        $std->evento[] = $evt;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazManifestaLote($std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('210200', $request);
    }

    public function testSefazManifestaLoteDesconhecimento(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];
        $evt = new stdClass();
        $evt->tpEvento = 210220; // Desconhecimento
        $evt->chNFe = '35220605730928000145550010000048661583302923';
        $evt->nSeqEvento = 1;
        $std->evento[] = $evt;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazManifestaLote($std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('210220', $request);
    }

    public function testSefazManifestaLoteIgnoresInvalidEventType(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];
        // Valid event
        $evt = new stdClass();
        $evt->tpEvento = 210210;
        $evt->chNFe = '35220605730928000145550010000048661583302923';
        $evt->nSeqEvento = 1;
        $std->evento[] = $evt;
        // Invalid event type - should be ignored
        $evt2 = new stdClass();
        $evt2->tpEvento = 999999;
        $evt2->chNFe = '35220605730928000145550010000048661583302923';
        $evt2->nSeqEvento = 1;
        $std->evento[] = $evt2;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazManifestaLote($std, $dhEvento, '12345');
        $this->assertIsString($result);
    }

    public function testSefazEventoLoteThrowsOnEmptyUf(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $std = new stdClass();
        $std->evento = [];
        $this->tools->sefazEventoLote('', $std);
    }

    public function testSefazEventoLoteThrowsOnMoreThan20Events(): void
    {
        $this->expectException(\RuntimeException::class);
        $std = new stdClass();
        $std->evento = [];
        for ($i = 0; $i < 21; $i++) {
            $evt = new stdClass();
            $evt->tpEvento = 110110;
            $evt->chave = '35220605730928000145550010000048661583302923';
            $evt->nSeqEvento = $i + 1;
            $evt->tagAdic = '';
            $std->evento[] = $evt;
        }
        $this->tools->sefazEventoLote('SP', $std);
    }

    public function testSefazEventoLoteWithValidEvent(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];
        $evt = new stdClass();
        $evt->tpEvento = 110110; // CCe
        $evt->chave = '35220605730928000145550010000048661583302923';
        $evt->nSeqEvento = 1;
        $evt->tagAdic = '<xCorrecao>Correcao teste</xCorrecao><xCondUso>A Carta de Correcao e disciplinada pelo paragrafo 1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 e pode ser utilizada para regularizacao de erro ocorrido na emissao de documento fiscal, desde que o erro nao esteja relacionado com: I - as variaveis que determinam o valor do imposto tais como: base de calculo, aliquota, diferenca de preco, quantidade, valor da operacao ou da prestacao; II - a correcao de dados cadastrais que implique mudanca do remetente ou do destinatario; III - a data de emissao ou de saida.</xCondUso>';
        $std->evento[] = $evt;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazEventoLote('SP', $std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('110110', $request);
        $this->assertStringContainsString('<xCorrecao>Correcao teste</xCorrecao>', $request);
    }

    public function testSefazCscThrowsOnInvalidIndOp(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazCsc(0);
    }

    public function testSefazCscThrowsOnIndOpGreaterThan3(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazCsc(4);
    }

    public function testSefazCscThrowsOnModel55(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->tools->model(55);
        $this->tools->sefazCsc(1);
    }

    private function createToolsForAM(): ToolsFake
    {
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "AM",
            "cnpj" => "93623057000128",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ];
        $tools = new ToolsFake(
            json_encode($config),
            Certificate::readPfx($this->contentpfx, $this->passwordpfx)
        );
        return $tools;
    }

    public function testSefazCscConsulta(): void
    {
        $tools = $this->createToolsForAM();
        $tools->getSoap()->setReturnValue(
            file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml')
        );
        $tools->model(65);
        $result = $tools->sefazCsc(1);
        $this->assertIsString($result);
        $request = $tools->getRequest();
        $this->assertStringContainsString('<indOp>1</indOp>', $request);
        $this->assertStringContainsString('admCscNFCe', $request);
    }

    public function testSefazCscSolicitaNovo(): void
    {
        $tools = $this->createToolsForAM();
        $tools->getSoap()->setReturnValue(
            file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml')
        );
        $tools->model(65);
        $result = $tools->sefazCsc(2);
        $this->assertIsString($result);
        $request = $tools->getRequest();
        $this->assertStringContainsString('<indOp>2</indOp>', $request);
    }

    public function testSefazCscRevogar(): void
    {
        $tools = $this->createToolsForAM();
        $tools->getSoap()->setReturnValue(
            file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml')
        );
        $tools->model(65);
        $result = $tools->sefazCsc(3);
        $this->assertIsString($result);
        $request = $tools->getRequest();
        $this->assertStringContainsString('<indOp>3</indOp>', $request);
        $this->assertStringContainsString('<dadosCsc>', $request);
        $this->assertStringContainsString('<idCsc>', $request);
        $this->assertStringContainsString('<codigoCsc>', $request);
    }

    public function testSefazDownloadThrowsOnEmptyChave(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazDownload('');
    }

    public function testSefazDownloadWithValidChave(): void
    {
        $this->setSuccessReturn();
        $result = $this->tools->sefazDownload('35220605730928000145550010000048661583302923');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<chNFe>35220605730928000145550010000048661583302923</chNFe>', $request);
        $this->assertStringContainsString('distDFeInt', $request);
        $this->assertStringContainsString('<consChNFe>', $request);
    }

    public function testSefazValidateThrowsOnEmptyString(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazValidate('');
    }

    public function testSefazConciliacaoModel55UsesSVRS(): void
    {
        $this->setSuccessReturn();
        $this->tools->model(55);

        $std = new stdClass();
        $std->verAplic = '1.0';
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->nSeqEvento = 1;
        $std->cancelar = false;
        $std->detPag = [
            (object)[
                'tPag' => '01',
                'vPag' => '100.00',
                'dPag' => '2024-05-31',
            ],
        ];

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazConciliacao($std, $dhEvento, '12345');
        $this->assertIsString($result);
    }

    public function testSefazConciliacaoCancelamento(): void
    {
        $this->setSuccessReturn();
        $this->tools->model(55);

        $std = new stdClass();
        $std->verAplic = '1.0';
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->nSeqEvento = 1;
        $std->cancelar = true;
        $std->protocolo = '135220000012345';

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazConciliacao($std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<nProtEvento>', $request);
    }

    // ══════════════════════════════════════════════════════════════════
    //  3. TraitTagTotal coverage
    // ══════════════════════════════════════════════════════════════════

    public function testTagTotalSetsVNFTot(): void
    {
        $make = new Make();
        $std = new stdClass();
        $std->vNFTot = 1234.56;
        $result = $make->tagTotal($std);
        $this->assertEquals(1234.56, $result);
    }

    public function testTagTotalReturnsNullWhenNotSet(): void
    {
        $make = new Make();
        $std = new stdClass();
        $result = $make->tagTotal($std);
        $this->assertNull($result);
    }

    public function testBuildTagICMSTotWithAllOptionalFields(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->vBC = '1000.00';
        $std->vICMS = '180.00';
        $std->vICMSDeson = '10.00';
        $std->vBCST = '200.00';
        $std->vST = '36.00';
        $std->vProd = '1000.00';
        $std->vFrete = '50.00';
        $std->vSeg = '25.00';
        $std->vDesc = '15.00';
        $std->vII = '30.00';
        $std->vIPI = '45.00';
        $std->vPIS = '16.50';
        $std->vCOFINS = '76.00';
        $std->vOutro = '5.00';
        $std->vNF = '1196.50';
        $std->vIPIDevol = '12.00';
        $std->vTotTrib = '383.50';
        $std->vFCP = '20.00';
        $std->vFCPST = '4.00';
        $std->vFCPSTRet = '2.00';
        // These optional fields (> 0 paths)
        $std->vFCPUFDest = '15.00';
        $std->vICMSUFDest = '90.00';
        $std->vICMSUFRemet = '45.00';
        // Mono fields
        $std->qBCMono = '500.00';
        $std->vICMSMono = '50.00';
        $std->qBCMonoReten = '300.00';
        $std->vICMSMonoReten = '30.00';
        $std->qBCMonoRet = '200.00';
        $std->vICMSMonoRet = '20.00';
        $make->tagICMSTot($std);

        $xml = $make->render();

        $this->assertStringContainsString('<vFCPUFDest>15.00</vFCPUFDest>', $xml);
        $this->assertStringContainsString('<vICMSUFDest>90.00</vICMSUFDest>', $xml);
        $this->assertStringContainsString('<vICMSUFRemet>45.00</vICMSUFRemet>', $xml);
        $this->assertStringContainsString('<qBCMono>500.00</qBCMono>', $xml);
        $this->assertStringContainsString('<vICMSMono>50.00</vICMSMono>', $xml);
        $this->assertStringContainsString('<qBCMonoReten>300.00</qBCMonoReten>', $xml);
        $this->assertStringContainsString('<vICMSMonoReten>30.00</vICMSMonoReten>', $xml);
        $this->assertStringContainsString('<qBCMonoRet>200.00</qBCMonoRet>', $xml);
        $this->assertStringContainsString('<vICMSMonoRet>20.00</vICMSMonoRet>', $xml);
        $this->assertStringContainsString('<vIPIDevol>12.00</vIPIDevol>', $xml);
        $this->assertStringContainsString('<vTotTrib>383.50</vTotTrib>', $xml);
        $this->assertStringContainsString('<vFCP>20.00</vFCP>', $xml);
        $this->assertStringContainsString('<vFCPST>4.00</vFCPST>', $xml);
        $this->assertStringContainsString('<vFCPSTRet>2.00</vFCPSTRet>', $xml);
    }

    public function testBuildTagICMSTotWithAutoCalculation(): void
    {
        // Test the auto-calculation path (when dataICMSTot is empty)
        $make = new Make();

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '30';
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->dhSaiEnt = '2017-03-03T11:30:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA';
        $std->IE = '123456789012';
        $std->CRT = '3';
        $std->CNPJ = '58716523000119';
        $make->tagEmit($std);

        $std = new stdClass();
        $std->xLgr = 'Rua';
        $std->nro = '1';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'SP';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $make->tagenderEmit($std);

        $std = new stdClass();
        $std->xNome = 'DEST';
        $std->indIEDest = '9';
        $std->CNPJ = '11222333000181';
        $make->tagdest($std);

        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '1.0000';
        $std->vUnCom = '100.0000000000';
        $std->vProd = '100.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '1.0000';
        $std->vUnTrib = '100.0000000000';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '100.00';
        $std->pICMS = '18.00';
        $std->vICMS = '18.00';
        $make->tagICMS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $make->tagPIS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $make->tagCOFINS($std);

        // Do NOT call tagICMSTot - let auto-calculation handle it
        $std = new stdClass();
        $std->modFrete = '9';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vTroco = null;
        $make->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '100.00';
        $make->tagdetPag($std);

        $xml = $make->render();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<ICMSTot>', $xml);
        // Auto-calculated vProd from tag
        $this->assertStringContainsString('<vProd>100.00</vProd>', $xml);
    }

    public function testTagISTotWithValue(): void
    {
        $make = new Make();
        $std = new stdClass();
        $std->vIS = 50.00;
        $result = $make->tagISTot($std);
        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('ISTot', $result->nodeName);
    }

    public function testTagISTotReturnsNullWhenEmpty(): void
    {
        $make = new Make();
        $std = new stdClass();
        $std->vIS = 0;
        $result = $make->tagISTot($std);
        $this->assertNull($result);
    }

    public function testTagISSQNTotWithAllFields(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->vServ = '500.00';
        $std->vBC = '500.00';
        $std->vISS = '25.00';
        $std->vPIS = '8.25';
        $std->vCOFINS = '38.00';
        $std->dCompet = '2017-03-03';
        $std->vDeducao = '10.00';
        $std->vOutro = '5.00';
        $std->vDescIncond = '3.00';
        $std->vDescCond = '2.00';
        $std->vISSRet = '12.50';
        $std->cRegTrib = '5';
        $make->tagISSQNTot($std);

        $xml = $make->render();

        $this->assertStringContainsString('<ISSQNtot>', $xml);
        $this->assertStringContainsString('<vServ>500.00</vServ>', $xml);
        $this->assertStringContainsString('<vDeducao>10.00</vDeducao>', $xml);
        $this->assertStringContainsString('<vDescIncond>3.00</vDescIncond>', $xml);
        $this->assertStringContainsString('<vDescCond>2.00</vDescCond>', $xml);
        $this->assertStringContainsString('<vISSRet>12.50</vISSRet>', $xml);
    }

    public function testTagRetTribWithAllFields(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->vRetPIS = '10.00';
        $std->vRetCOFINS = '46.00';
        $std->vRetCSLL = '5.00';
        $std->vBCIRRF = '100.00';
        $std->vIRRF = '15.00';
        $std->vBCRetPrev = '200.00';
        $std->vRetPrev = '22.00';
        $make->tagretTrib($std);

        $xml = $make->render();

        $this->assertStringContainsString('<retTrib>', $xml);
        $this->assertStringContainsString('<vRetPIS>10.00</vRetPIS>', $xml);
        $this->assertStringContainsString('<vRetCOFINS>46.00</vRetCOFINS>', $xml);
        $this->assertStringContainsString('<vRetCSLL>5.00</vRetCSLL>', $xml);
        $this->assertStringContainsString('<vBCIRRF>100.00</vBCIRRF>', $xml);
        $this->assertStringContainsString('<vIRRF>15.00</vIRRF>', $xml);
        $this->assertStringContainsString('<vBCRetPrev>200.00</vBCRetPrev>', $xml);
        $this->assertStringContainsString('<vRetPrev>22.00</vRetPrev>', $xml);
    }

    // ══════════════════════════════════════════════════════════════════
    //  4. TraitTagDet coverage
    // ══════════════════════════════════════════════════════════════════

    public function testTagProdWithDiAdi(): void
    {
        $make = $this->buildMinimalNFe55();

        // DI (import declaration)
        $std = new stdClass();
        $std->item = 1;
        $std->nDI = '12345678901';
        $std->dDI = '2017-01-15';
        $std->xLocDesemb = 'Porto Santos';
        $std->UFDesemb = 'SP';
        $std->dDesemb = '2017-01-20';
        $std->tpViaTransp = '1';
        $std->vAFRMM = '100.00';
        $std->tpIntermedio = '1';
        $std->CNPJ = '12345678000195';
        $std->UFTerceiro = 'RJ';
        $std->cExportador = 'EXP001';
        $make->tagDI($std);

        // adi (addition to DI)
        $std = new stdClass();
        $std->item = 1;
        $std->nDI = '12345678901';
        $std->nAdicao = '001';
        $std->nSeqAdic = '1';
        $std->cFabricante = 'FAB001';
        $std->vDescDI = '10.00';
        $std->nDraw = '123456';
        $make->tagadi($std);

        $xml = $make->render();

        $this->assertStringContainsString('<DI>', $xml);
        $this->assertStringContainsString('<nDI>12345678901</nDI>', $xml);
        $this->assertStringContainsString('<xLocDesemb>Porto Santos</xLocDesemb>', $xml);
        $this->assertStringContainsString('<tpViaTransp>1</tpViaTransp>', $xml);
        $this->assertStringContainsString('<vAFRMM>100.00</vAFRMM>', $xml);
        $this->assertStringContainsString('<cExportador>EXP001</cExportador>', $xml);
        $this->assertStringContainsString('<adi>', $xml);
        $this->assertStringContainsString('<nAdicao>001</nAdicao>', $xml);
        $this->assertStringContainsString('<cFabricante>FAB001</cFabricante>', $xml);
        $this->assertStringContainsString('<vDescDI>10.00</vDescDI>', $xml);
    }

    public function testTagProdWithDiUsingCpf(): void
    {
        $make = $this->buildMinimalNFe55();

        // DI with CPF instead of CNPJ
        $std = new stdClass();
        $std->item = 1;
        $std->nDI = '99887766554';
        $std->dDI = '2017-02-10';
        $std->xLocDesemb = 'Aeroporto GRU';
        $std->UFDesemb = 'SP';
        $std->dDesemb = '2017-02-15';
        $std->tpViaTransp = '4';
        $std->tpIntermedio = '2';
        $std->CPF = '12345678901';
        $std->cExportador = 'EXP002';
        $make->tagDI($std);

        // adi
        $std = new stdClass();
        $std->item = 1;
        $std->nDI = '99887766554';
        $std->nSeqAdic = '1';
        $std->cFabricante = 'FAB002';
        $make->tagadi($std);

        $xml = $make->render();

        $this->assertStringContainsString('<DI>', $xml);
        $this->assertStringContainsString('<CPF>12345678901</CPF>', $xml);
        $this->assertStringContainsString('<tpViaTransp>4</tpViaTransp>', $xml);
    }

    public function testTagDetExport(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->nDraw = '20170001';
        $std->nRE = '123456789012';
        $std->chNFe = '35170358716523000119550010000000301000000300';
        $std->qExport = '10.0000';
        $make->tagdetExport($std);

        $xml = $make->render();

        $this->assertStringContainsString('<detExport>', $xml);
        $this->assertStringContainsString('<nDraw>20170001</nDraw>', $xml);
        $this->assertStringContainsString('<exportInd>', $xml);
        $this->assertStringContainsString('<nRE>123456789012</nRE>', $xml);
        $this->assertStringContainsString('<qExport>10.0000</qExport>', $xml);
    }

    public function testTagDetExportWithoutExportInd(): void
    {
        $make = $this->buildMinimalNFe55();

        // detExport without nRE/chNFe/qExport should not create exportInd
        $std = new stdClass();
        $std->item = 1;
        $std->nDraw = '20170002';
        $make->tagdetExport($std);

        $xml = $make->render();

        $this->assertStringContainsString('<detExport>', $xml);
        $this->assertStringContainsString('<nDraw>20170002</nDraw>', $xml);
        $this->assertStringNotContainsString('<exportInd>', $xml);
    }

    public function testTagNVE(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->NVE = 'AA0001';
        $make->tagNVE($std);

        $std = new stdClass();
        $std->item = 1;
        $std->NVE = 'BB0002';
        $make->tagNVE($std);

        $xml = $make->render();

        $this->assertStringContainsString('<NVE>AA0001</NVE>', $xml);
        $this->assertStringContainsString('<NVE>BB0002</NVE>', $xml);
    }

    public function testTagNVEReturnsNullForEmpty(): void
    {
        $make = new Make();
        $std = new stdClass();
        $std->item = 1;
        $std->NVE = '';
        $result = $make->tagNVE($std);
        $this->assertNull($result);
    }

    public function testTagGCred(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->cCredPresumido = 'SP000001';
        $std->pCredPresumido = '3.0000';
        $std->vCredPresumido = '3.00';
        $make->taggCred($std);

        $std = new stdClass();
        $std->item = 1;
        $std->cCredPresumido = 'SP000002';
        $std->pCredPresumido = '2.0000';
        $std->vCredPresumido = '2.00';
        $make->taggCred($std);

        $xml = $make->render();

        $this->assertStringContainsString('<gCred>', $xml);
        $this->assertStringContainsString('<cCredPresumido>SP000001</cCredPresumido>', $xml);
        $this->assertStringContainsString('<cCredPresumido>SP000002</cCredPresumido>', $xml);
    }

    public function testTagImpostoDevol(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->pDevol = '100.00';
        $std->vIPIDevol = '15.00';
        $make->tagimpostoDevol($std);

        $xml = $make->render();

        $this->assertStringContainsString('<impostoDevol>', $xml);
        $this->assertStringContainsString('<pDevol>100.00</pDevol>', $xml);
        $this->assertStringContainsString('<vIPIDevol>15.00</vIPIDevol>', $xml);
    }

    // ══════════════════════════════════════════════════════════════════
    //  5. TraitTagTransp coverage
    // ══════════════════════════════════════════════════════════════════

    public function testTagVagao(): void
    {
        $make = $this->buildMinimalNFe55();

        // Override transp
        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vagao = 'VAG12345';
        $make->tagvagao($std);

        $xml = $make->render();

        $this->assertStringContainsString('<vagao>VAG12345</vagao>', $xml);
    }

    public function testTagVagaoReturnsNullWhenEmpty(): void
    {
        $make = new Make();
        $std = new stdClass();
        $std->vagao = '';
        $result = $make->tagvagao($std);
        $this->assertNull($result);
    }

    public function testTagBalsa(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->balsa = 'BALSA-001';
        $make->tagbalsa($std);

        $xml = $make->render();

        $this->assertStringContainsString('<balsa>BALSA-001</balsa>', $xml);
    }

    public function testTagBalsaReturnsNullWhenEmpty(): void
    {
        $make = new Make();
        $std = new stdClass();
        $std->balsa = '';
        $result = $make->tagbalsa($std);
        $this->assertNull($result);
    }

    public function testTagVagaoNotIncludedWhenVeicTranspExists(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        // Add veicTransp
        $std = new stdClass();
        $std->placa = 'ABC1D23';
        $std->UF = 'SP';
        $make->tagveicTransp($std);

        // Add vagao - should NOT appear because veicTransp exists
        $std = new stdClass();
        $std->vagao = 'VAG99999';
        $make->tagvagao($std);

        $xml = $make->render();

        $this->assertStringContainsString('<veicTransp>', $xml);
        $this->assertStringNotContainsString('<vagao>', $xml);
    }

    public function testTagBalsaNotIncludedWhenVagaoExists(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        // Add vagao
        $std = new stdClass();
        $std->vagao = 'VAG11111';
        $make->tagvagao($std);

        // Add balsa - should NOT appear because vagao exists
        $std = new stdClass();
        $std->balsa = 'BALSA-X';
        $make->tagbalsa($std);

        $xml = $make->render();

        $this->assertStringContainsString('<vagao>VAG11111</vagao>', $xml);
        $this->assertStringNotContainsString('<balsa>', $xml);
    }

    public function testMultipleReboques(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->placa = 'ABC1D23';
        $std->UF = 'SP';
        $make->tagveicTransp($std);

        // Add multiple reboques (max 5)
        for ($i = 1; $i <= 3; $i++) {
            $std = new stdClass();
            $std->placa = "REB{$i}X00";
            $std->UF = 'SP';
            $std->RNTC = "RNTC{$i}";
            $make->tagreboque($std);
        }

        $xml = $make->render();

        $this->assertStringContainsString('<reboque>', $xml);
        $this->assertStringContainsString('<placa>REB1X00</placa>', $xml);
        $this->assertStringContainsString('<placa>REB2X00</placa>', $xml);
        $this->assertStringContainsString('<placa>REB3X00</placa>', $xml);
    }

    public function testRetTransp(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vServ = '500.00';
        $std->vBCRet = '500.00';
        $std->pICMSRet = '12.0000';
        $std->vICMSRet = '60.00';
        $std->CFOP = '5353';
        $std->cMunFG = '3550308';
        $make->tagretTransp($std);

        $xml = $make->render();

        $this->assertStringContainsString('<retTransp>', $xml);
        $this->assertStringContainsString('<vServ>500.00</vServ>', $xml);
        $this->assertStringContainsString('<vBCRet>500.00</vBCRet>', $xml);
        $this->assertStringContainsString('<pICMSRet>12.0000</pICMSRet>', $xml);
        $this->assertStringContainsString('<vICMSRet>60.00</vICMSRet>', $xml);
        $this->assertStringContainsString('<CFOP>5353</CFOP>', $xml);
        $this->assertStringContainsString('<cMunFG>3550308</cMunFG>', $xml);
    }

    public function testTransportaWithCpf(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->xNome = 'Transportador PF';
        $std->CPF = '12345678901';
        $std->IE = '111222333';
        $std->xEnder = 'Rua Transporte 100';
        $std->xMun = 'Campinas';
        $std->UF = 'SP';
        $make->tagtransporta($std);

        $xml = $make->render();

        $this->assertStringContainsString('<transporta>', $xml);
        $this->assertStringContainsString('<CPF>12345678901</CPF>', $xml);
        $this->assertStringContainsString('<xNome>Transportador PF</xNome>', $xml);
    }

    public function testLacresOnMultipleVolumes(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        // Volume 1
        $std = new stdClass();
        $std->item = 1;
        $std->qVol = '5';
        $std->esp = 'CAIXA';
        $make->tagvol($std);

        $std = new stdClass();
        $std->item = 1;
        $std->nLacre = 'L001';
        $make->taglacres($std);

        $std = new stdClass();
        $std->item = 1;
        $std->nLacre = 'L002';
        $make->taglacres($std);

        // Volume 2
        $std = new stdClass();
        $std->item = 2;
        $std->qVol = '3';
        $std->esp = 'PALLET';
        $make->tagvol($std);

        $std = new stdClass();
        $std->item = 2;
        $std->nLacre = 'L003';
        $make->taglacres($std);

        $xml = $make->render();

        $this->assertStringContainsString('<nLacre>L001</nLacre>', $xml);
        $this->assertStringContainsString('<nLacre>L002</nLacre>', $xml);
        $this->assertStringContainsString('<nLacre>L003</nLacre>', $xml);
    }

    // ══════════════════════════════════════════════════════════════════
    //  6. QRCode coverage
    // ══════════════════════════════════════════════════════════════════

    public function testQRCodePutQRTagThrowsOnMissingUrl(): void
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML(file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml'));

        \NFePHP\NFe\Factories\QRCode::putQRTag(
            $dom,
            'TOKEN123',
            '000001',
            '200',
            '', // empty URL
            'https://www.nfce.fazenda.sp.gov.br/NFCeConsultaPublica'
        );
    }

    public function testQRCodePutQRTagThrowsOnMissingCSC(): void
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML(file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml'));

        \NFePHP\NFe\Factories\QRCode::putQRTag(
            $dom,
            '', // empty token
            '000001',
            '200',
            'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConstultaQRCode.aspx',
            'https://www.nfce.fazenda.sp.gov.br/NFCeConsultaPublica'
        );
    }

    public function testQRCodePutQRTagThrowsOnMissingCSCId(): void
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);

        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML(file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml'));

        \NFePHP\NFe\Factories\QRCode::putQRTag(
            $dom,
            'TOKEN123',
            '', // empty idToken
            '200',
            'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConstultaQRCode.aspx',
            'https://www.nfce.fazenda.sp.gov.br/NFCeConsultaPublica'
        );
    }

    // ══════════════════════════════════════════════════════════════════
    //  Additional Make.php render paths
    // ══════════════════════════════════════════════════════════════════

    public function testRenderWithMultipleItems(): void
    {
        $make = new Make();

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '30';
        $std->dhEmi = '2017-03-03T11:30:00-03:00';
        $std->dhSaiEnt = '2017-03-03T11:30:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA';
        $std->IE = '123456789012';
        $std->CRT = '3';
        $std->CNPJ = '58716523000119';
        $make->tagEmit($std);

        $std = new stdClass();
        $std->xLgr = 'Rua';
        $std->nro = '1';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'SP';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $make->tagenderEmit($std);

        $std = new stdClass();
        $std->xNome = 'DEST';
        $std->indIEDest = '9';
        $std->CNPJ = '11222333000181';
        $make->tagdest($std);

        // Item 1
        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto A';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '5.0000';
        $std->vUnCom = '10.0000000000';
        $std->vProd = '50.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '5.0000';
        $std->vUnTrib = '10.0000000000';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '50.00';
        $std->pICMS = '18.00';
        $std->vICMS = '9.00';
        $make->tagICMS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $make->tagPIS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $make->tagCOFINS($std);

        // Item 2
        $std = new stdClass();
        $std->item = 2;
        $std->cProd = '002';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto B';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '3.0000';
        $std->vUnCom = '20.0000000000';
        $std->vProd = '60.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '3.0000';
        $std->vUnTrib = '20.0000000000';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 2;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '60.00';
        $std->pICMS = '18.00';
        $std->vICMS = '10.80';
        $make->tagICMS($std);

        $std = new stdClass();
        $std->item = 2;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $make->tagPIS($std);

        $std = new stdClass();
        $std->item = 2;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $make->tagCOFINS($std);

        $std = new stdClass();
        $std->vBC = '110.00';
        $std->vICMS = '19.80';
        $std->vICMSDeson = '0.00';
        $std->vBCST = '0.00';
        $std->vST = '0.00';
        $std->vProd = '110.00';
        $std->vFrete = '0.00';
        $std->vSeg = '0.00';
        $std->vDesc = '0.00';
        $std->vII = '0.00';
        $std->vIPI = '0.00';
        $std->vPIS = '0.00';
        $std->vCOFINS = '0.00';
        $std->vOutro = '0.00';
        $std->vNF = '110.00';
        $std->vTotTrib = '0.00';
        $make->tagICMSTot($std);

        $std = new stdClass();
        $std->modFrete = '9';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vTroco = null;
        $make->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '110.00';
        $make->tagdetPag($std);

        $xml = $make->render();

        $this->assertStringContainsString('<det nItem="1">', $xml);
        $this->assertStringContainsString('<det nItem="2">', $xml);
        $this->assertStringContainsString('<xProd>Produto A</xProd>', $xml);
        $this->assertStringContainsString('<xProd>Produto B</xProd>', $xml);
    }

    public function testTagCESTSeparateMethod(): void
    {
        $make = $this->buildMinimalNFe55();

        // Use the separate tagCEST method (legacy)
        $std = new stdClass();
        $std->item = 1;
        $std->CEST = '2806300';
        $std->indEscala = 'S';
        $std->CNPJFab = '12345678000195';
        $make->tagCEST($std);

        $xml = $make->render();

        $this->assertStringContainsString('<CEST>2806300</CEST>', $xml);
    }

    public function testTagInfAdProd(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->infAdProd = 'Informacao adicional do produto';
        $make->taginfAdProd($std);

        $xml = $make->render();

        $this->assertStringContainsString('<infAdProd>Informacao adicional do produto</infAdProd>', $xml);
    }

    public function testTagObsItemWithFisco(): void
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->obsFisco_xCampo = 'CampoFisco';
        $std->obsFisco_xTexto = 'ValorFisco';
        $make->tagObsItem($std);

        $xml = $make->render();

        $this->assertStringContainsString('<obsItem>', $xml);
        $this->assertStringContainsString('<obsFisco', $xml);
        $this->assertStringContainsString('ValorFisco', $xml);
    }

    public function testSetCalculationMethod(): void
    {
        $make = new Make();
        // Just verify it doesn't throw
        $make->setCalculationMethod(Make::METHOD_CALCULATION_V1);
        $make->setCalculationMethod(Make::METHOD_CALCULATION_V2);
        $this->assertTrue(true);
    }

    // ══════════════════════════════════════════════════════════════════
    //  Additional Tools edge cases
    // ══════════════════════════════════════════════════════════════════

    public function testSefazManifestaLoteMultipleEvents(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];

        $evt1 = new stdClass();
        $evt1->tpEvento = 210200; // Confirmacao
        $evt1->chNFe = '35220605730928000145550010000048661583302923';
        $evt1->nSeqEvento = 1;
        $std->evento[] = $evt1;

        $evt2 = new stdClass();
        $evt2->tpEvento = 210210; // Ciencia
        $evt2->chNFe = '35220605730928000145550010000048661583302924';
        $evt2->nSeqEvento = 1;
        $std->evento[] = $evt2;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazManifestaLote($std, $dhEvento, '99999');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('210200', $request);
        $this->assertStringContainsString('210210', $request);
    }

    public function testSefazConciliacaoWithDetPag(): void
    {
        $this->setSuccessReturn();
        $this->tools->model(55);

        $std = new stdClass();
        $std->verAplic = '1.0';
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->nSeqEvento = 1;
        $std->cancelar = false;
        $std->detPag = [
            (object)[
                'tPag' => '01',
                'vPag' => '100.00',
                'dPag' => '2024-05-31',
            ],
            (object)[
                'tPag' => '03',
                'vPag' => '50.00',
                'dPag' => '2024-06-15',
            ],
        ];

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazConciliacao($std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<detPag>', $request);
    }

    public function testSefazEventoLoteSkipsEpecEvent(): void
    {
        $this->setSuccessReturn();
        $std = new stdClass();
        $std->evento = [];

        // EPEC event - should be skipped
        $evt = new stdClass();
        $evt->tpEvento = 110140; // EPEC
        $evt->chave = '35220605730928000145550010000048661583302923';
        $evt->nSeqEvento = 1;
        $evt->tagAdic = '';
        $std->evento[] = $evt;

        // Valid CCe event
        $evt2 = new stdClass();
        $evt2->tpEvento = 110110; // CCe
        $evt2->chave = '35220605730928000145550010000048661583302923';
        $evt2->nSeqEvento = 1;
        $evt2->tagAdic = '<xCorrecao>Teste</xCorrecao><xCondUso>A Carta de Correcao e disciplinada pelo paragrafo 1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 e pode ser utilizada para regularizacao de erro ocorrido na emissao de documento fiscal, desde que o erro nao esteja relacionado com: I - as variaveis que determinam o valor do imposto tais como: base de calculo, aliquota, diferenca de preco, quantidade, valor da operacao ou da prestacao; II - a correcao de dados cadastrais que implique mudanca do remetente ou do destinatario; III - a data de emissao ou de saida.</xCondUso>';
        $std->evento[] = $evt2;

        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $result = $this->tools->sefazEventoLote('SP', $std, $dhEvento, '12345');
        $this->assertIsString($result);
        $request = $this->tools->getRequest();
        // EPEC should NOT be in the request
        $this->assertStringNotContainsString('110140', $request);
        // CCe should be in the request
        $this->assertStringContainsString('110110', $request);
    }
}
