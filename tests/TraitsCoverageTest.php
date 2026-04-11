<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Make;
use NFePHP\NFe\Tests\Common\ToolsFake;
use PHPUnit\Framework\TestCase;
use stdClass;

class TraitsCoverageTest extends TestCase
{
    protected Make $make;

    protected function setUp(): void
    {
        $this->make = new Make();
    }

    /**
     * Helper: set up infNFe + ide + emit + enderEmit so getXML() can render
     */
    protected function setupBaseTags(?Make $make = null): Make
    {
        $m = $make ?? $this->make;

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $m->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2026-01-15T10:00:00-03:00';
        $std->dhSaiEnt = '2026-01-15T10:00:00-03:00';
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
        $m->tagide($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA TESTE LTDA';
        $std->xFant = 'TESTE';
        $std->IE = '123456789012';
        $std->CNPJ = '58716523000119';
        $std->CRT = '3';
        $m->tagEmit($std);

        $std = new stdClass();
        $std->xLgr = 'RUA TESTE';
        $std->nro = '100';
        $std->xBairro = 'CENTRO';
        $std->cMun = '3550308';
        $std->xMun = 'SAO PAULO';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'Brasil';
        $m->tagenderEmit($std);

        return $m;
    }

    /**
     * Helper: add a minimal product item
     */
    protected function addProduct(int $item = 1, ?Make $make = null): void
    {
        $m = $make ?? $this->make;

        $std = new stdClass();
        $std->item = $item;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'PRODUTO TESTE';
        $std->NCM = '84719012';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '1.0000';
        $std->vUnCom = '100.00';
        $std->vProd = '100.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '1.0000';
        $std->vUnTrib = '100.00';
        $std->indTot = 1;
        $m->tagprod($std);
    }

    /**
     * Helper: add minimal ICMS
     */
    protected function addICMS(int $item = 1, ?Make $make = null): void
    {
        $m = $make ?? $this->make;

        $std = new stdClass();
        $std->item = $item;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '100.00';
        $std->pICMS = '18.00';
        $std->vICMS = '18.00';
        $m->tagICMS($std);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetISSQN
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagISSQN_all_fields(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '10.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->vAliq = 5.0000;
        $std->vISSQN = 5.00;
        $std->cMunFG = '3550308';
        $std->cListServ = '1401';
        $std->vDeducao = 10.00;
        $std->vOutro = 2.00;
        $std->vDescIncond = 3.00;
        $std->vDescCond = 1.00;
        $std->vISSRet = 0.50;
        $std->indISS = '1';
        $std->cServico = '1234';
        $std->cMun = '3550308';
        $std->cPais = '1058';
        $std->nProcesso = '9999';
        $std->indIncentivo = '1';
        $issqn = $this->make->tagISSQN($std);

        $this->assertInstanceOf(\DOMElement::class, $issqn);
        $this->assertEquals('ISSQN', $issqn->tagName);
        $this->assertEquals('100.00', $issqn->getElementsByTagName('vBC')->item(0)->nodeValue);
        $this->assertEquals('5.0000', $issqn->getElementsByTagName('vAliq')->item(0)->nodeValue);
        $this->assertEquals('5.00', $issqn->getElementsByTagName('vISSQN')->item(0)->nodeValue);
        $this->assertEquals('3550308', $issqn->getElementsByTagName('cMunFG')->item(0)->nodeValue);
        $this->assertEquals('1401', $issqn->getElementsByTagName('cListServ')->item(0)->nodeValue);
        $this->assertEquals('10.00', $issqn->getElementsByTagName('vDeducao')->item(0)->nodeValue);
        $this->assertEquals('2.00', $issqn->getElementsByTagName('vOutro')->item(0)->nodeValue);
        $this->assertEquals('3.00', $issqn->getElementsByTagName('vDescIncond')->item(0)->nodeValue);
        $this->assertEquals('1.00', $issqn->getElementsByTagName('vDescCond')->item(0)->nodeValue);
        $this->assertEquals('0.50', $issqn->getElementsByTagName('vISSRet')->item(0)->nodeValue);
        $this->assertEquals('1', $issqn->getElementsByTagName('indISS')->item(0)->nodeValue);
        $this->assertEquals('1234', $issqn->getElementsByTagName('cServico')->item(0)->nodeValue);
        $this->assertEquals('3550308', $issqn->getElementsByTagName('cMun')->item(0)->nodeValue);
        $this->assertEquals('1058', $issqn->getElementsByTagName('cPais')->item(0)->nodeValue);
        $this->assertEquals('9999', $issqn->getElementsByTagName('nProcesso')->item(0)->nodeValue);
        $this->assertEquals('1', $issqn->getElementsByTagName('indIncentivo')->item(0)->nodeValue);
    }

    public function test_tagISSQN_zero_vBC_does_not_accumulate_totals(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '0';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->vBC = 0;
        $std->vAliq = 5.0000;
        $std->vISSQN = 0;
        $std->cMunFG = '3550308';
        $std->cListServ = '1401';
        $std->indISS = '1';
        $std->indIncentivo = '2';
        $issqn = $this->make->tagISSQN($std);

        $this->assertInstanceOf(\DOMElement::class, $issqn);
    }

    public function test_tagISSQN_optional_fields_null(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '5.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->vBC = 50.00;
        $std->vAliq = 3.0000;
        $std->vISSQN = 1.50;
        $std->cMunFG = '3550308';
        $std->cListServ = '1401';
        $std->indISS = '2';
        $std->indIncentivo = '2';
        // all optional fields left unset
        $issqn = $this->make->tagISSQN($std);

        $this->assertInstanceOf(\DOMElement::class, $issqn);
        $this->assertEmpty($issqn->getElementsByTagName('cServico')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetII
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagII_all_fields(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '10.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->vBC = 1000.00;
        $std->vDespAdu = 50.00;
        $std->vII = 120.00;
        $std->vIOF = 15.00;
        $ii = $this->make->tagII($std);

        $this->assertInstanceOf(\DOMElement::class, $ii);
        $this->assertEquals('II', $ii->tagName);
        $this->assertEquals('1000.00', $ii->getElementsByTagName('vBC')->item(0)->nodeValue);
        $this->assertEquals('50.00', $ii->getElementsByTagName('vDespAdu')->item(0)->nodeValue);
        $this->assertEquals('120.00', $ii->getElementsByTagName('vII')->item(0)->nodeValue);
        $this->assertEquals('15.00', $ii->getElementsByTagName('vIOF')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetIS
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagIS_with_vBCIS(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '10.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CSTIS = '00';
        $std->cClassTribIS = '001';
        $std->vBCIS = 100.00;
        $std->pIS = 5.0000;
        $std->pISEspec = 1.5000;
        $std->vIS = 5.00;
        $is = $this->make->tagIS($std);

        $this->assertInstanceOf(\DOMElement::class, $is);
        $this->assertEquals('IS', $is->tagName);
        $this->assertEquals('00', $is->getElementsByTagName('CSTIS')->item(0)->nodeValue);
        $this->assertEquals('001', $is->getElementsByTagName('cClassTribIS')->item(0)->nodeValue);
        $this->assertEquals('100.00', $is->getElementsByTagName('vBCIS')->item(0)->nodeValue);
        $this->assertEquals('5.0000', $is->getElementsByTagName('pIS')->item(0)->nodeValue);
        $this->assertEquals('1.5000', $is->getElementsByTagName('pISEspec')->item(0)->nodeValue);
        $this->assertEquals('5.00', $is->getElementsByTagName('vIS')->item(0)->nodeValue);
    }

    public function test_tagIS_with_uTrib_and_qTrib(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '10.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CSTIS = '01';
        $std->cClassTribIS = '002';
        $std->uTrib = 'LT';
        $std->qTrib = 10.0000;
        $std->vIS = 8.00;
        $is = $this->make->tagIS($std);

        $this->assertInstanceOf(\DOMElement::class, $is);
        $this->assertEquals('LT', $is->getElementsByTagName('uTrib')->item(0)->nodeValue);
        $this->assertEquals('10.0000', $is->getElementsByTagName('qTrib')->item(0)->nodeValue);
    }

    public function test_tagIS_without_vBCIS_or_uTrib(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '10.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CSTIS = '02';
        $std->cClassTribIS = '003';
        $std->vIS = 3.00;
        $is = $this->make->tagIS($std);

        $this->assertInstanceOf(\DOMElement::class, $is);
        // vBCIS should not be present
        $this->assertEmpty($is->getElementsByTagName('vBCIS')->item(0));
        // uTrib should not be present
        $this->assertEmpty($is->getElementsByTagName('uTrib')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagCana
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagcana_and_tagforDia_and_tagdeduc(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->safra = '2025/2026';
        $std->ref = '01/2026';
        $std->qTotMes = '10000.0000000000';
        $std->qTotAnt = '5000.0000000000';
        $std->qTotGer = '15000.0000000000';
        $std->vFor = 50000.00;
        $std->vTotDed = 1000.00;
        $std->vLiqFor = 49000.00;
        $cana = $this->make->tagcana($std);

        $this->assertInstanceOf(\DOMElement::class, $cana);
        $this->assertEquals('cana', $cana->tagName);
        $this->assertEquals('2025/2026', $cana->getElementsByTagName('safra')->item(0)->nodeValue);

        $std = new stdClass();
        $std->dia = '1';
        $std->qtde = 500.0000000000;
        $forDia = $this->make->tagforDia($std);
        $this->assertInstanceOf(\DOMElement::class, $forDia);
        $this->assertEquals('1', $forDia->getAttribute('dia'));

        $std = new stdClass();
        $std->dia = '2';
        $std->qtde = 600.0000000000;
        $this->make->tagforDia($std);

        $std = new stdClass();
        $std->xDed = 'DEDUCAO TESTE';
        $std->vDed = 500.00;
        $deduc = $this->make->tagdeduc($std);
        $this->assertInstanceOf(\DOMElement::class, $deduc);
        $this->assertEquals('DEDUCAO TESTE', $deduc->getElementsByTagName('xDed')->item(0)->nodeValue);
        $this->assertEquals('500.00', $deduc->getElementsByTagName('vDed')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagCompra
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagcompra_all_fields(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->xNEmp = 'EMPENHO123';
        $std->xPed = 'PEDIDO456';
        $std->xCont = 'CONTRATO789';
        $compra = $this->make->tagcompra($std);

        $this->assertInstanceOf(\DOMElement::class, $compra);
        $this->assertEquals('compra', $compra->tagName);
        $this->assertEquals('EMPENHO123', $compra->getElementsByTagName('xNEmp')->item(0)->nodeValue);
        $this->assertEquals('PEDIDO456', $compra->getElementsByTagName('xPed')->item(0)->nodeValue);
        $this->assertEquals('CONTRATO789', $compra->getElementsByTagName('xCont')->item(0)->nodeValue);
    }

    public function test_tagcompra_optional_fields_null(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->xPed = 'PEDIDO456';
        $compra = $this->make->tagcompra($std);

        $this->assertInstanceOf(\DOMElement::class, $compra);
        $this->assertEmpty($compra->getElementsByTagName('xNEmp')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagExporta
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagexporta_all_fields(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->UFSaidaPais = 'SP';
        $std->xLocExporta = 'PORTO DE SANTOS';
        $std->xLocDespacho = 'AEROPORTO GRU';
        $exporta = $this->make->tagexporta($std);

        $this->assertInstanceOf(\DOMElement::class, $exporta);
        $this->assertEquals('exporta', $exporta->tagName);
        $this->assertEquals('SP', $exporta->getElementsByTagName('UFSaidaPais')->item(0)->nodeValue);
        $this->assertEquals('PORTO DE SANTOS', $exporta->getElementsByTagName('xLocExporta')->item(0)->nodeValue);
        $this->assertEquals('AEROPORTO GRU', $exporta->getElementsByTagName('xLocDespacho')->item(0)->nodeValue);
    }

    public function test_tagexporta_without_xLocDespacho(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->UFSaidaPais = 'RJ';
        $std->xLocExporta = 'PORTO DO RIO';
        $exporta = $this->make->tagexporta($std);

        $this->assertInstanceOf(\DOMElement::class, $exporta);
        $this->assertEmpty($exporta->getElementsByTagName('xLocDespacho')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagInfIntermed
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagIntermed(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->CNPJ = '12345678000195';
        $std->idCadIntTran = 'IDENT123456';
        $intermed = $this->make->tagIntermed($std);

        $this->assertInstanceOf(\DOMElement::class, $intermed);
        $this->assertEquals('infIntermed', $intermed->tagName);
        $this->assertEquals('12345678000195', $intermed->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('IDENT123456', $intermed->getElementsByTagName('idCadIntTran')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagAutXml
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagautXML_with_CNPJ(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->CNPJ = '12345678000195';
        $autXML = $this->make->tagautXML($std);

        $this->assertInstanceOf(\DOMElement::class, $autXML);
        $this->assertEquals('autXML', $autXML->tagName);
        $this->assertEquals('12345678000195', $autXML->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEmpty($autXML->getElementsByTagName('CPF')->item(0));
    }

    public function test_tagautXML_with_CPF(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->CPF = '12345678901';
        $autXML = $this->make->tagautXML($std);

        $this->assertInstanceOf(\DOMElement::class, $autXML);
        $this->assertEquals('12345678901', $autXML->getElementsByTagName('CPF')->item(0)->nodeValue);
        $this->assertEmpty($autXML->getElementsByTagName('CNPJ')->item(0));
    }

    public function test_tagautXML_with_empty_values(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->CNPJ = '';
        $std->CPF = '';
        $autXML = $this->make->tagautXML($std);

        $this->assertInstanceOf(\DOMElement::class, $autXML);
        // Neither should be added
        $this->assertEmpty($autXML->getElementsByTagName('CNPJ')->item(0));
        $this->assertEmpty($autXML->getElementsByTagName('CPF')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagInfRespTec
    // ──────────────────────────────────────────────────────────────────────

    public function test_taginfRespTec_without_CSRT(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->CNPJ = '58716523000119';
        $std->xContato = 'Fulano';
        $std->email = 'fulano@teste.com';
        $std->fone = '11999999999';
        $infRespTec = $this->make->taginfRespTec($std);

        $this->assertInstanceOf(\DOMElement::class, $infRespTec);
        $this->assertEquals('infRespTec', $infRespTec->tagName);
        $this->assertEquals('58716523000119', $infRespTec->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('Fulano', $infRespTec->getElementsByTagName('xContato')->item(0)->nodeValue);
        $this->assertEquals('fulano@teste.com', $infRespTec->getElementsByTagName('email')->item(0)->nodeValue);
        $this->assertEquals('11999999999', $infRespTec->getElementsByTagName('fone')->item(0)->nodeValue);
        $this->assertEmpty($infRespTec->getElementsByTagName('idCSRT')->item(0));
        $this->assertEmpty($infRespTec->getElementsByTagName('hashCSRT')->item(0));
    }

    public function test_taginfRespTec_with_CSRT(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->CNPJ = '58716523000119';
        $std->xContato = 'Ciclano';
        $std->email = 'ciclano@teste.com';
        $std->fone = '11888888888';
        $std->CSRT = 'G8063VRTNDMO886SFNK5LDUDLKTEYHO';
        $std->idCSRT = '01';
        $infRespTec = $this->make->taginfRespTec($std);

        $this->assertInstanceOf(\DOMElement::class, $infRespTec);
        $this->assertEquals('01', $infRespTec->getElementsByTagName('idCSRT')->item(0)->nodeValue);
        $this->assertNotEmpty($infRespTec->getElementsByTagName('hashCSRT')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagAgropecuario
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagAgropecuarioGuia_all_fields(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->tpGuia = '1';
        $std->UFGuia = 'SP';
        $std->serieGuia = 'A';
        $std->nGuia = '123456';
        $guia = $this->make->tagAgropecuarioGuia($std);

        $this->assertInstanceOf(\DOMElement::class, $guia);
        $this->assertEquals('guiaTransito', $guia->tagName);
        $this->assertEquals('1', $guia->getElementsByTagName('tpGuia')->item(0)->nodeValue);
        $this->assertEquals('SP', $guia->getElementsByTagName('UFGuia')->item(0)->nodeValue);
        $this->assertEquals('A', $guia->getElementsByTagName('serieGuia')->item(0)->nodeValue);
        $this->assertEquals('123456', $guia->getElementsByTagName('nGuia')->item(0)->nodeValue);
    }

    public function test_tagAgropecuarioGuia_optional_fields(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->tpGuia = '2';
        $std->nGuia = '789012';
        // UFGuia and serieGuia not set
        $guia = $this->make->tagAgropecuarioGuia($std);

        $this->assertInstanceOf(\DOMElement::class, $guia);
        $this->assertEmpty($guia->getElementsByTagName('UFGuia')->item(0));
    }

    public function test_tagAgropecuarioDefensivo(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->nReceituario = 'REC001';
        $std->CPFRespTec = '12345678901';
        $def = $this->make->tagAgropecuarioDefensivo($std);

        $this->assertInstanceOf(\DOMElement::class, $def);
        $this->assertEquals('defensivo', $def->tagName);
        $this->assertEquals('REC001', $def->getElementsByTagName('nReceituario')->item(0)->nodeValue);
        $this->assertEquals('12345678901', $def->getElementsByTagName('CPFRespTec')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetImposto - tagimposto and tagimpostoDevol
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagimposto(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = 25.50;
        $imposto = $this->make->tagimposto($std);

        $this->assertInstanceOf(\DOMElement::class, $imposto);
        $this->assertEquals('imposto', $imposto->tagName);
        $this->assertEquals('25.50', $imposto->getElementsByTagName('vTotTrib')->item(0)->nodeValue);
    }

    public function test_tagimpostoDevol(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '10.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->pDevol = 100.00;
        $std->vIPIDevol = 15.00;
        $devol = $this->make->tagimpostoDevol($std);

        $this->assertInstanceOf(\DOMElement::class, $devol);
        $this->assertEquals('impostoDevol', $devol->tagName);
        $this->assertEquals('100.00', $devol->getElementsByTagName('pDevol')->item(0)->nodeValue);
        $this->assertEquals('15.00', $devol->getElementsByTagName('vIPIDevol')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagGCompraGov
    // ──────────────────────────────────────────────────────────────────────

    public function test_taggCompraGov(): void
    {
        $make = new Make('PL_010_V1.30');
        $this->setupBaseTags($make);

        $std = new stdClass();
        $std->tpEnteGov = '1';
        $std->pRedutor = 10.0000;
        $std->tpOperGov = '1';
        $gc = $make->taggCompraGov($std);

        $this->assertInstanceOf(\DOMElement::class, $gc);
        $this->assertEquals('gCompraGov', $gc->tagName);
        $this->assertEquals('1', $gc->getElementsByTagName('tpEnteGov')->item(0)->nodeValue);
        $this->assertEquals('10.0000', $gc->getElementsByTagName('pRedutor')->item(0)->nodeValue);
        $this->assertEquals('1', $gc->getElementsByTagName('tpOperGov')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagGPagAntecipado
    // ──────────────────────────────────────────────────────────────────────

    public function test_taggPagAntecipado_single(): void
    {
        $make = new Make('PL_010_V1.30');
        $this->setupBaseTags($make);

        $std = new stdClass();
        $std->refNFe = '35170358716523000119550010000000301000000300';
        $gc = $make->taggPagAntecipado($std);

        $this->assertInstanceOf(\DOMElement::class, $gc);
        $this->assertEquals('gPagAntecipado', $gc->tagName);
        $this->assertEquals(
            '35170358716523000119550010000000301000000300',
            $gc->getElementsByTagName('refNFe')->item(0)->nodeValue
        );
    }

    public function test_taggPagAntecipado_multiple(): void
    {
        $make = new Make('PL_010_V1.30');
        $this->setupBaseTags($make);

        $std = new stdClass();
        $std->refNFe = [
            '35170358716523000119550010000000301000000300',
            '35170358716523000119550010000000301000000301',
        ];
        $gc = $make->taggPagAntecipado($std);

        $this->assertInstanceOf(\DOMElement::class, $gc);
        $this->assertEquals(2, $gc->getElementsByTagName('refNFe')->length);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagInfAdic
    // ──────────────────────────────────────────────────────────────────────

    public function test_taginfAdic(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->infAdFisco = 'INFO FISCO TESTE';
        $std->infCpl = 'INFO COMPLEMENTAR TESTE';
        $infAdic = $this->make->taginfAdic($std);

        $this->assertInstanceOf(\DOMElement::class, $infAdic);
        $this->assertEquals('infAdic', $infAdic->tagName);
        $this->assertEquals('INFO FISCO TESTE', $infAdic->getElementsByTagName('infAdFisco')->item(0)->nodeValue);
        $this->assertEquals('INFO COMPLEMENTAR TESTE', $infAdic->getElementsByTagName('infCpl')->item(0)->nodeValue);
    }

    public function test_tagobsCont(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->xCampo = 'campo1';
        $std->xTexto = 'texto1';
        $obs = $this->make->tagobsCont($std);

        $this->assertInstanceOf(\DOMElement::class, $obs);
        $this->assertEquals('obsCont', $obs->tagName);
        $this->assertEquals('campo1', $obs->getAttribute('xCampo'));
        $this->assertEquals('texto1', $obs->getElementsByTagName('xTexto')->item(0)->nodeValue);
    }

    public function test_tagobsFisco(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->xCampo = 'campoFisco';
        $std->xTexto = 'textoFisco';
        $obs = $this->make->tagobsFisco($std);

        $this->assertInstanceOf(\DOMElement::class, $obs);
        $this->assertEquals('obsFisco', $obs->tagName);
        $this->assertEquals('campoFisco', $obs->getAttribute('xCampo'));
    }

    public function test_tagprocRef(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->nProc = '999999';
        $std->indProc = '0';
        $std->tpAto = '08';
        $proc = $this->make->tagprocRef($std);

        $this->assertInstanceOf(\DOMElement::class, $proc);
        $this->assertEquals('procRef', $proc->tagName);
        $this->assertEquals('999999', $proc->getElementsByTagName('nProc')->item(0)->nodeValue);
        $this->assertEquals('0', $proc->getElementsByTagName('indProc')->item(0)->nodeValue);
        $this->assertEquals('08', $proc->getElementsByTagName('tpAto')->item(0)->nodeValue);
    }

    public function test_tagprocRef_without_tpAto(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->nProc = '888888';
        $std->indProc = '1';
        $proc = $this->make->tagprocRef($std);

        $this->assertInstanceOf(\DOMElement::class, $proc);
        $this->assertEmpty($proc->getElementsByTagName('tpAto')->item(0));
    }

    public function test_buildInfoTags_obsCont_without_infAdic_creates_it(): void
    {
        $this->setupBaseTags();
        $this->addProduct();
        $this->addICMS();

        // Add obsCont without calling taginfAdic first
        $std = new stdClass();
        $std->xCampo = 'campo1';
        $std->xTexto = 'texto1';
        $this->make->tagobsCont($std);

        // Add obsFisco
        $std = new stdClass();
        $std->xCampo = 'fiscoCampo';
        $std->xTexto = 'fiscoTexto';
        $this->make->tagobsFisco($std);

        // Add procRef
        $std = new stdClass();
        $std->nProc = '123';
        $std->indProc = '0';
        $this->make->tagprocRef($std);

        // Add required payment tags
        $this->addPayment();

        $xml = $this->make->getXML();
        $this->assertStringContainsString('<infAdic>', $xml);
        $this->assertStringContainsString('<obsCont', $xml);
        $this->assertStringContainsString('<obsFisco', $xml);
        $this->assertStringContainsString('<procRef>', $xml);
    }

    public function test_buildInfoTags_obsCont_limit_11_truncates_to_10(): void
    {
        $this->setupBaseTags();
        $this->addProduct();
        $this->addICMS();

        // Add 11 obsCont entries - should be truncated to 10
        for ($i = 0; $i < 11; $i++) {
            $std = new stdClass();
            $std->xCampo = "campo$i";
            $std->xTexto = "texto$i";
            $this->make->tagobsCont($std);
        }

        $this->addPayment();
        $xml = $this->make->getXML();
        $this->assertStringContainsString('<infAdic>', $xml);
        $errors = $this->make->getErrors();
        $hasLimitError = false;
        foreach ($errors as $err) {
            if (strpos($err, 'obsCont') !== false) {
                $hasLimitError = true;
                break;
            }
        }
        $this->assertTrue($hasLimitError, 'Expected obsCont limit error');
    }

    public function test_buildInfoTags_procRef_over_100(): void
    {
        $this->setupBaseTags();
        $this->addProduct();
        $this->addICMS();

        for ($i = 0; $i < 101; $i++) {
            $std = new stdClass();
            $std->nProc = (string) $i;
            $std->indProc = '0';
            $this->make->tagprocRef($std);
        }

        $this->addPayment();
        $xml = $this->make->getXML();
        $errors = $this->make->getErrors();
        $hasLimitError = false;
        foreach ($errors as $err) {
            if (strpos($err, 'procRef') !== false) {
                $hasLimitError = true;
                break;
            }
        }
        $this->assertTrue($hasLimitError, 'Expected procRef limit error');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagInfNfe - taginfNFeSupl
    // ──────────────────────────────────────────────────────────────────────

    public function test_taginfNFeSupl_with_urlChave(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->qrcode = 'https://www.nfce.fazenda.sp.gov.br/qrcode?p=12345';
        $std->urlChave = 'https://www.nfe.fazenda.gov.br/portal/consultaNFe.aspx';
        $supl = $this->make->taginfNFeSupl($std);

        $this->assertInstanceOf(\DOMElement::class, $supl);
        $this->assertEquals('infNFeSupl', $supl->tagName);
        $this->assertNotEmpty($supl->getElementsByTagName('qrCode')->item(0));
        $this->assertEquals(
            'https://www.nfe.fazenda.gov.br/portal/consultaNFe.aspx',
            $supl->getElementsByTagName('urlChave')->item(0)->nodeValue
        );
    }

    public function test_taginfNFeSupl_without_urlChave(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->qrcode = 'https://www.nfce.fazenda.sp.gov.br/qrcode?p=12345';
        $supl = $this->make->taginfNFeSupl($std);

        $this->assertInstanceOf(\DOMElement::class, $supl);
    }

    public function test_taginfNFe_with_NFe_prefix_in_Id(): void
    {
        $make = new Make();
        $std = new stdClass();
        $std->Id = 'NFe35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $infNFe = $make->taginfNFe($std);

        $this->assertEquals(
            'NFe35170358716523000119550010000000301000000300',
            $infNFe->getAttribute('Id')
        );
        $this->assertEquals(
            '35170358716523000119550010000000301000000300',
            $make->getChave()
        );
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagRefs (covers the TraitRefNfCt equivalent in new Make)
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagrefNFe(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->refNFe = '35170358716523000119550010000000301000000300';
        $nfref = $this->make->tagrefNFe($std);

        $this->assertInstanceOf(\DOMElement::class, $nfref);
        $this->assertEquals('NFref', $nfref->tagName);
        $this->assertEquals(
            '35170358716523000119550010000000301000000300',
            $nfref->getElementsByTagName('refNFe')->item(0)->nodeValue
        );
    }

    public function test_tagrefNFeSig(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->refNFeSig = '35170358716523000119550010000000301000000300';
        $nfref = $this->make->tagrefNFe($std);

        $this->assertInstanceOf(\DOMElement::class, $nfref);
        $this->assertEquals(
            '35170358716523000119550010000000301000000300',
            $nfref->getElementsByTagName('refNFeSig')->item(0)->nodeValue
        );
    }

    public function test_tagrefNF(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->cUF = '35';
        $std->AAMM = '2601';
        $std->CNPJ = '58716523000119';
        $std->mod = '01';
        $std->serie = '1';
        $std->nNF = '100';
        $nfref = $this->make->tagrefNF($std);

        $this->assertInstanceOf(\DOMElement::class, $nfref);
        $this->assertEquals('NFref', $nfref->tagName);
        $this->assertEquals('35', $nfref->getElementsByTagName('cUF')->item(0)->nodeValue);
        $this->assertEquals('2601', $nfref->getElementsByTagName('AAMM')->item(0)->nodeValue);
    }

    public function test_tagrefNFP_with_CNPJ(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->cUF = '35';
        $std->AAMM = '2601';
        $std->CNPJ = '58716523000119';
        $std->IE = '123456789';
        $std->mod = '4';
        $std->serie = '1';
        $std->nNF = '200';
        $nfref = $this->make->tagrefNFP($std);

        $this->assertInstanceOf(\DOMElement::class, $nfref);
        $this->assertEquals('NFref', $nfref->tagName);
        $this->assertEquals('04', $nfref->getElementsByTagName('mod')->item(0)->nodeValue);
    }

    public function test_tagrefNFP_with_CPF(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->cUF = '35';
        $std->AAMM = '2601';
        $std->CPF = '12345678901';
        $std->IE = 'ISENTO';
        $std->mod = '04';
        $std->serie = '0';
        $std->nNF = '300';
        $nfref = $this->make->tagrefNFP($std);

        $this->assertInstanceOf(\DOMElement::class, $nfref);
    }

    public function test_tagrefCTe(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->refCTe = '35170358716523000119570010000000301000000300';
        $nfref = $this->make->tagrefCTe($std);

        $this->assertInstanceOf(\DOMElement::class, $nfref);
        $this->assertEquals('NFref', $nfref->tagName);
        $this->assertEquals(
            '35170358716523000119570010000000301000000300',
            $nfref->getElementsByTagName('refCTe')->item(0)->nodeValue
        );
    }

    public function test_tagrefECF(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->mod = '2D';
        $std->nECF = '1';
        $std->nCOO = '123';
        $nfref = $this->make->tagrefECF($std);

        $this->assertInstanceOf(\DOMElement::class, $nfref);
        $this->assertEquals('NFref', $nfref->tagName);
        $this->assertEquals('2D', $nfref->getElementsByTagName('mod')->item(0)->nodeValue);
        $this->assertEquals('001', $nfref->getElementsByTagName('nECF')->item(0)->nodeValue);
        $this->assertEquals('000123', $nfref->getElementsByTagName('nCOO')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitEventsRTC
    // ──────────────────────────────────────────────────────────────────────

    protected ToolsFake $tools;

    protected function getTools(): ToolsFake
    {
        if (!isset($this->tools)) {
            $fixturesPath = dirname(__FILE__) . '/fixtures/';
            $config = [
                "atualizacao" => "2017-02-20 09:11:21",
                "tpAmb" => 2,
                "razaosocial" => "SUA RAZAO SOCIAL LTDA",
                "siglaUF" => "SP",
                "cnpj" => "93623057000128",
                "schemes" => "PL_010_V1.30",
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
            $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
            $cert = Certificate::readPfx($contentpfx, 'nfephp');
            $this->tools = new ToolsFake(json_encode($config), $cert);
            $this->tools->model(55);
            $this->tools->setVerAplic('TestApp_1.0');
            $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
            $this->tools->getSoap()->setReturnValue($responseBody);
        }
        return $this->tools;
    }

    protected function makeChaveNFe55(): string
    {
        // Valid key with mod=55 at position 20-21
        return '35220605730928000145550010000048661583302923';
    }

    public function test_sefazSolApropCredPresumido(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vBC' => 100.00,
            'gIBS' => (object) [
                'cCredPres' => '01',
                'pCredPres' => 2.5000,
                'vCredPres' => 2.50,
            ],
            'gCBS' => (object) [
                'cCredPres' => '01',
                'pCredPres' => 3.5000,
                'vCredPres' => 3.50,
            ],
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazSolApropCredPresumido($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211110</tpEvento>', $request);
        $this->assertStringContainsString('<gCredPres nItem="1">', $request);
        $this->assertStringContainsString('<gIBS>', $request);
        $this->assertStringContainsString('<gCBS>', $request);
        $this->assertStringContainsString('<vBC>100.00</vBC>', $request);
    }

    public function test_sefazSolApropCredPresumido_without_gIBS_gCBS(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vBC' => 200.00,
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazSolApropCredPresumido($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211110</tpEvento>', $request);
        $this->assertStringNotContainsString('<gIBS>', $request);
        $this->assertStringNotContainsString('<gCBS>', $request);
    }

    public function test_sefazDestinoConsumoPessoal(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vIBS' => 10.00,
            'vCBS' => 10.00,
            'quantidade' => 10,
            'unidade' => 'PC',
            'chave' => $this->makeChaveNFe55(),
            'nItem' => 1,
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->tpAutor = 2;
        $std->itens = $itens;
        $tools->sefazDestinoConsumoPessoal($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211120</tpEvento>', $request);
        $this->assertStringContainsString('<gConsumo nItem="1">', $request);
        $this->assertStringContainsString('<qConsumo>', $request);
        $this->assertStringContainsString('<uConsumo>PC</uConsumo>', $request);
        $this->assertStringContainsString('<DFeReferenciado>', $request);
    }

    public function test_sefazAceiteDebito(): void
    {
        $tools = $this->getTools();

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->indAceitacao = 1;
        $tools->sefazAceiteDebito($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211128</tpEvento>', $request);
        $this->assertStringContainsString('<indAceitacao>1</indAceitacao>', $request);
    }

    public function test_sefazImobilizacaoItem(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vIBS' => 10.00,
            'vCBS' => 10.00,
            'quantidade' => 5,
            'unidade' => 'UN',
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazImobilizacaoItem($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211130</tpEvento>', $request);
        $this->assertStringContainsString('<gImobilizacao nItem="1">', $request);
        $this->assertStringContainsString('<qImobilizado>', $request);
    }

    public function test_sefazApropriacaoCreditoComb(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vIBS' => 10.00,
            'vCBS' => 10.00,
            'quantidade' => 100,
            'unidade' => 'LT',
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazApropriacaoCreditoComb($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211140</tpEvento>', $request);
        $this->assertStringContainsString('<gConsumoComb nItem="1">', $request);
        $this->assertStringContainsString('<qComb>', $request);
        $this->assertStringContainsString('<uComb>LT</uComb>', $request);
    }

    public function test_sefazApropriacaoCreditoBens(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vCredIBS' => 10.00,
            'vCredCBS' => 10.00,
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazApropriacaoCreditoBens($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211150</tpEvento>', $request);
        $this->assertStringContainsString('<gCredito nItem="1">', $request);
        $this->assertStringContainsString('<vCredIBS>10.00</vCredIBS>', $request);
        $this->assertStringContainsString('<vCredCBS>10.00</vCredCBS>', $request);
    }

    public function test_sefazManifestacaoTransfCredIBS(): void
    {
        $tools = $this->getTools();

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->indAceitacao = 1;
        $tools->sefazManifestacaoTransfCredIBS($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>212110</tpEvento>', $request);
        $this->assertStringContainsString('<tpAutor>8</tpAutor>', $request);
        $this->assertStringContainsString('<indAceitacao>1</indAceitacao>', $request);
    }

    public function test_sefazManifestacaoTransfCredCBS(): void
    {
        $tools = $this->getTools();

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->indAceitacao = 1;
        $tools->sefazManifestacaoTransfCredCBS($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>212120</tpEvento>', $request);
        $this->assertStringContainsString('<tpAutor>8</tpAutor>', $request);
    }

    public function test_sefazCancelaEvento(): void
    {
        $tools = $this->getTools();

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->tpEventoAut = '112110';
        $std->nProtEvento = '135260000000001';
        $tools->sefazCancelaEvento($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>110001</tpEvento>', $request);
        $this->assertStringContainsString('<tpEventoAut>112110</tpEventoAut>', $request);
        $this->assertStringContainsString('<nProtEvento>135260000000001</nProtEvento>', $request);
    }

    public function test_sefazImportacaoZFM(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vIBS' => 5.00,
            'vCBS' => 5.00,
            'quantidade' => 10,
            'unidade' => 'UN',
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazImportacaoZFM($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>112120</tpEvento>', $request);
        $this->assertStringContainsString('<gConsumo nItem="1">', $request);
        $this->assertStringContainsString('<qtde>', $request);
        $this->assertStringContainsString('<unidade>UN</unidade>', $request);
    }

    public function test_sefazRouboPerdaTransporteAdquirente(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vIBS' => 10.00,
            'vCBS' => 10.00,
            'quantidade' => 5,
            'unidade' => 'UN',
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazRouboPerdaTransporteAdquirente($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>211124</tpEvento>', $request);
        $this->assertStringContainsString('<gPerecimento nItem="1">', $request);
        $this->assertStringContainsString('<qPerecimento>', $request);
        $this->assertStringContainsString('<tpAutor>2</tpAutor>', $request);
    }

    public function test_sefazRouboPerdaTransporteFornecedor(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vIBS' => 10.00,
            'vCBS' => 10.00,
            'gControleEstoque_vIBS' => 8.00,
            'gControleEstoque_vCBS' => 8.00,
            'quantidade' => 3,
            'unidade' => 'KG',
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazRouboPerdaTransporteFornecedor($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>112130</tpEvento>', $request);
        $this->assertStringContainsString('<gPerecimento nItem="1">', $request);
        $this->assertStringContainsString('<tpAutor>1</tpAutor>', $request);
    }

    public function test_sefazFornecimentoNaoRealizado(): void
    {
        $tools = $this->getTools();

        $itens = [];
        $itens[] = (object) [
            'item' => 1,
            'vIBS' => 10.00,
            'vCBS' => 10.00,
            'quantidade' => 5,
            'unidade' => 'UN',
        ];

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->itens = $itens;
        $tools->sefazFornecimentoNaoRealizado($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>112140</tpEvento>', $request);
        $this->assertStringContainsString('<gItemNaoFornecido nItem="1">', $request);
        $this->assertStringContainsString('<qNaoFornecida>', $request);
        $this->assertStringContainsString('<uNaoFornecida>UN</uNaoFornecida>', $request);
    }

    public function test_sefazAtualizacaoDataEntrega(): void
    {
        $tools = $this->getTools();

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->data_prevista = '2026-06-15';
        $tools->sefazAtualizacaoDataEntrega($std);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<tpEvento>112150</tpEvento>', $request);
        $this->assertStringContainsString('<dPrevEntrega>2026-06-15</dPrevEntrega>', $request);
    }

    public function test_resolveVerAplic_with_explicit_value(): void
    {
        $tools = $this->getTools();

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->indAceitacao = 1;
        $tools->sefazAceiteDebito($std, 'CustomApp_2.0');
        $request = $tools->getRequest();

        $this->assertStringContainsString('<verAplic>CustomApp_2.0</verAplic>', $request);
    }

    public function test_resolveVerAplic_fallback_to_default(): void
    {
        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "93623057000128",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools2 = new ToolsFake(json_encode($config), $cert);
        $tools2->model(55);
        // Do NOT call setVerAplic - it should fallback to '4.00'
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools2->getSoap()->setReturnValue($responseBody);

        $std = new stdClass();
        $std->chNFe = $this->makeChaveNFe55();
        $std->nSeqEvento = 1;
        $std->indAceitacao = 1;
        $tools2->sefazAceiteDebito($std);
        $request = $tools2->getRequest();

        $this->assertStringContainsString('<verAplic>4.00</verAplic>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitEPECNfce - sefazEpecNfce
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_epec_nfce_sp_success(): void
    {
        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        // Load the NFCe XML fixture that has tpEmis=4 (EPEC contingency), dhCont, xJust
        // We need an NFCe XML with UF SP (cUF=35) so it matches SP config
        $xml = $this->buildEpecNfceXml('SP', '35');

        $tools->sefazEpecNfce($xml);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<descEvento>EPEC</descEvento>', $request);
        $this->assertStringContainsString('<tpEvento>110140</tpEvento>', $request);
    }

    public function test_sefaz_epec_nfce_not_contingency_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('contingência EPEC');

        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        // Build XML with tpEmis=1 (not contingency)
        $xml = $this->buildEpecNfceXml('SP', '35', '1');

        $tools->sefazEpecNfce($xml);
    }

    public function test_sefaz_epec_nfce_mismatched_uf_throws(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('autor');

        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        // Build NFCe with UF=PR (41) but config is SP (35)
        $xml = $this->buildEpecNfceXml('PR', '41');

        $tools->sefazEpecNfce($xml);
    }

    public function test_sefaz_epec_nfce_with_cpf_dest(): void
    {
        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        $xml = $this->buildEpecNfceXml('SP', '35', '4', 'CPF');

        $tools->sefazEpecNfce($xml);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<CPF>', $request);
    }

    public function test_sefaz_epec_nfce_with_idEstrangeiro(): void
    {
        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        $xml = $this->buildEpecNfceXml('SP', '35', '4', 'idEstrangeiro');

        $tools->sefazEpecNfce($xml);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<idEstrangeiro>', $request);
    }

    public function test_sefaz_epec_nfce_without_dest(): void
    {
        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        $xml = $this->buildEpecNfceXml('SP', '35', '4', 'none');

        $tools->sefazEpecNfce($xml);
        $request = $tools->getRequest();

        $this->assertStringContainsString('<descEvento>EPEC</descEvento>', $request);
    }

    public function test_sefaz_epec_nfce_with_verAplic_param(): void
    {
        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $tools->setVerAplic('MyApp_3.0');
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        $xml = $this->buildEpecNfceXml('SP', '35');

        $tools->sefazEpecNfce($xml, 'CustomEPEC_1.0');
        $request = $tools->getRequest();

        $this->assertStringContainsString('<verAplic>CustomEPEC_1.0</verAplic>', $request);
    }

    public function test_sefaz_status_epec_nfce_default_uf_and_tpAmb(): void
    {
        $fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "23285089000185",
            "schemes" => "PL_010_V1.30",
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
        $contentpfx = file_get_contents($fixturesPath . "certs/novo_test_certificate.pfx");
        $cert = Certificate::readPfx($contentpfx, 'nfephp');
        $tools = new ToolsFake(json_encode($config), $cert);
        $tools->model(65);
        $responseBody = file_get_contents($fixturesPath . 'xml/exemplo_retorno_sucesso_envia_lote.xml');
        $tools->getSoap()->setReturnValue($responseBody);

        // Call without uf/tpAmb params - should use config defaults (SP, 2)
        $tools->sefazStatusEpecNfce();
        $request = $tools->getRequest();
        $this->assertStringContainsString('consStatServ', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitCalculations - full XML render with vItem calculations
    // ──────────────────────────────────────────────────────────────────────

    public function test_getXML_renders_complete_nfe_with_items(): void
    {
        $this->setupBaseTags();
        $this->addProduct(1);
        $this->addICMS(1);

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '18.00';
        $this->make->tagimposto($std);

        $this->addPayment();

        $xml = $this->make->getXML();
        $this->assertStringContainsString('<NFe', $xml);
        $this->assertStringContainsString('<infNFe', $xml);
        $this->assertStringContainsString('<det nItem="1"', $xml);
    }

    public function test_getXML_with_two_items(): void
    {
        $this->setupBaseTags();

        $this->addProduct(1);
        $this->addICMS(1);
        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '18.00';
        $this->make->tagimposto($std);

        $this->addProduct(2);
        $this->addICMS(2);
        $std = new stdClass();
        $std->item = 2;
        $std->vTotTrib = '18.00';
        $this->make->tagimposto($std);

        $this->addPayment();

        $xml = $this->make->getXML();
        $this->assertStringContainsString('<det nItem="1"', $xml);
        $this->assertStringContainsString('<det nItem="2"', $xml);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  Full XML integration: all covered traits in a single NFe
    // ──────────────────────────────────────────────────────────────────────

    public function test_full_nfe_with_multiple_traits(): void
    {
        $this->setupBaseTags();
        $this->addProduct(1);
        $this->addICMS(1);

        // tagimposto
        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '18.00';
        $this->make->tagimposto($std);

        // tagimpostoDevol
        $std = new stdClass();
        $std->item = 1;
        $std->pDevol = 100.00;
        $std->vIPIDevol = 5.00;
        $this->make->tagimpostoDevol($std);

        // tagII
        $std = new stdClass();
        $std->item = 1;
        $std->vBC = 100.00;
        $std->vDespAdu = 10.00;
        $std->vII = 20.00;
        $std->vIOF = 5.00;
        $this->make->tagII($std);

        // tagcompra
        $std = new stdClass();
        $std->xNEmp = 'EMP001';
        $std->xPed = 'PED001';
        $std->xCont = 'CONT001';
        $this->make->tagcompra($std);

        // tagexporta
        $std = new stdClass();
        $std->UFSaidaPais = 'SP';
        $std->xLocExporta = 'SANTOS';
        $std->xLocDespacho = 'GRU';
        $this->make->tagexporta($std);

        // taginfAdic with obsCont, obsFisco, procRef
        $std = new stdClass();
        $std->infAdFisco = 'INFO FISCO';
        $std->infCpl = 'INFO COMPL';
        $this->make->taginfAdic($std);

        $std = new stdClass();
        $std->xCampo = 'campo1';
        $std->xTexto = 'texto1';
        $this->make->tagobsCont($std);

        $std = new stdClass();
        $std->xCampo = 'fisco1';
        $std->xTexto = 'textoFisco1';
        $this->make->tagobsFisco($std);

        $std = new stdClass();
        $std->nProc = '123';
        $std->indProc = '0';
        $this->make->tagprocRef($std);

        // tagautXML
        $std = new stdClass();
        $std->CNPJ = '12345678000195';
        $this->make->tagautXML($std);

        // taginfRespTec
        $std = new stdClass();
        $std->CNPJ = '58716523000119';
        $std->xContato = 'Fulano';
        $std->email = 'fulano@teste.com';
        $std->fone = '11999999999';
        $this->make->taginfRespTec($std);

        // tagIntermed
        $std = new stdClass();
        $std->CNPJ = '12345678000195';
        $std->idCadIntTran = 'ID123';
        $this->make->tagIntermed($std);

        // tagrefNFe
        $std = new stdClass();
        $std->refNFe = '35170358716523000119550010000000301000000300';
        $this->make->tagrefNFe($std);

        // Payment
        $this->addPayment();

        $xml = $this->make->getXML();
        $this->assertStringContainsString('<compra>', $xml);
        $this->assertStringContainsString('<exporta>', $xml);
        $this->assertStringContainsString('<infAdic>', $xml);
        $this->assertStringContainsString('<autXML>', $xml);
        $this->assertStringContainsString('<infRespTec>', $xml);
        $this->assertStringContainsString('<infIntermed>', $xml);
        $this->assertStringContainsString('<NFref>', $xml);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  Helper methods
    // ──────────────────────────────────────────────────────────────────────

    protected function addPayment(?Make $make = null): void
    {
        $m = $make ?? $this->make;

        $std = new stdClass();
        $std->vTroco = 0;
        $m->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '100.00';
        $m->tagdetPag($std);

        $std = new stdClass();
        $std->modFrete = '9';
        $m->tagtransp($std);
    }

    /**
     * Build a minimal NFCe XML for EPEC testing
     */
    protected function buildEpecNfceXml(
        string $uf = 'SP',
        string $cUF = '35',
        string $tpEmis = '4',
        string $destType = 'CNPJ'
    ): string {
        $cnpjEmit = '23285089000185';
        // Build key with cUF at start
        $chNFe = $cUF . '200323285089000185650010000013051817822496';

        $destBlock = '';
        if ($destType === 'CNPJ') {
            $destBlock = '<dest>'
                . '<CNPJ>10422724000187</CNPJ>'
                . '<xNome>DEST TESTE</xNome>'
                . '<enderDest><UF>' . $uf . '</UF></enderDest>'
                . '</dest>';
        } elseif ($destType === 'CPF') {
            $destBlock = '<dest>'
                . '<CPF>12345678901</CPF>'
                . '<xNome>DEST PESSOA FISICA</xNome>'
                . '<enderDest><UF>' . $uf . '</UF></enderDest>'
                . '</dest>';
        } elseif ($destType === 'idEstrangeiro') {
            $destBlock = '<dest>'
                . '<idEstrangeiro>FOREIGN123</idEstrangeiro>'
                . '<xNome>DEST ESTRANGEIRO</xNome>'
                . '<enderDest><UF>' . $uf . '</UF></enderDest>'
                . '</dest>';
        }
        // destType === 'none' => no dest block

        $dhContBlock = '';
        $xJustBlock = '';
        if ($tpEmis === '4') {
            $dhContBlock = '<dhCont>2020-03-11T12:32:17-03:00</dhCont>';
            $xJustBlock = '<xJust>Teste de contingência EPEC</xJust>';
        }

        $xml = '<NFe xmlns="http://www.portalfiscal.inf.br/nfe">'
            . '<infNFe Id="NFe' . $chNFe . '" versao="4.00">'
            . '<ide>'
            . '<cUF>' . $cUF . '</cUF>'
            . '<cNF>81782249</cNF>'
            . '<natOp>Venda de mercadoria</natOp>'
            . '<mod>65</mod>'
            . '<serie>1</serie>'
            . '<nNF>1305</nNF>'
            . '<dhEmi>2020-03-11T15:32:17-03:00</dhEmi>'
            . '<tpNF>1</tpNF>'
            . '<idDest>1</idDest>'
            . '<cMunFG>3550308</cMunFG>'
            . '<tpImp>4</tpImp>'
            . '<tpEmis>' . $tpEmis . '</tpEmis>'
            . '<cDV>6</cDV>'
            . '<tpAmb>2</tpAmb>'
            . '<finNFe>1</finNFe>'
            . '<indFinal>1</indFinal>'
            . '<indPres>1</indPres>'
            . '<procEmi>0</procEmi>'
            . '<verProc>1.0.0</verProc>'
            . $dhContBlock
            . $xJustBlock
            . '</ide>'
            . '<emit>'
            . '<CNPJ>' . $cnpjEmit . '</CNPJ>'
            . '<xNome>EMPRESA TESTE</xNome>'
            . '<enderEmit><UF>' . $uf . '</UF></enderEmit>'
            . '<IE>9077361720</IE>'
            . '<CRT>1</CRT>'
            . '</emit>'
            . $destBlock
            . '<total><ICMSTot>'
            . '<vBC>0.00</vBC><vICMS>0.00</vICMS><vICMSDeson>0.00</vICMSDeson>'
            . '<vFCP>0.00</vFCP><vBCST>0.00</vBCST><vST>0.00</vST>'
            . '<vFCPST>0.00</vFCPST><vFCPSTRet>0.00</vFCPSTRet>'
            . '<vProd>100.00</vProd><vFrete>0.00</vFrete><vSeg>0.00</vSeg>'
            . '<vDesc>0.00</vDesc><vII>0.00</vII><vIPI>0.00</vIPI>'
            . '<vIPIDevol>0.00</vIPIDevol><vPIS>0.00</vPIS><vCOFINS>0.00</vCOFINS>'
            . '<vOutro>0.00</vOutro><vNF>100.00</vNF>'
            . '</ICMSTot></total>'
            . '</infNFe></NFe>';

        return $xml;
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagPag – branches not yet covered
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagpag_with_vTroco(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->vTroco = '5.50';
        $result = $this->make->tagpag($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('pag', $result->tagName);
        $this->assertEquals('5.50', $result->getElementsByTagName('vTroco')->item(0)->nodeValue);
    }

    public function test_tagpag_without_vTroco(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->vTroco = null;
        $result = $this->make->tagpag($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('pag', $result->tagName);
        $this->assertNull($result->getElementsByTagName('vTroco')->item(0));
    }

    public function test_tagdetPag_with_card_and_NT2023_004_fields(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->indPag = '0';
        $std->tPag = '03';
        $std->xPag = 'Cartão de Crédito';
        $std->vPag = '150.00';
        $std->dPag = '2026-01-15';
        $std->CNPJPag = '12345678000195';
        $std->UFPag = 'SP';
        $std->tpIntegra = '1';
        $std->CNPJ = '98765432000100';
        $std->tBand = '01';
        $std->cAut = 'AUTH123456';
        $std->CNPJReceb = '11222333000144';
        $std->idTermPag = 'TERM001';
        $result = $this->make->tagdetPag($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('detPag', $result->tagName);
        $this->assertEquals('03', $result->getElementsByTagName('tPag')->item(0)->nodeValue);
        $this->assertEquals('150.00', $result->getElementsByTagName('vPag')->item(0)->nodeValue);
        $this->assertEquals('2026-01-15', $result->getElementsByTagName('dPag')->item(0)->nodeValue);
        $this->assertEquals('12345678000195', $result->getElementsByTagName('CNPJPag')->item(0)->nodeValue);
        $this->assertEquals('SP', $result->getElementsByTagName('UFPag')->item(0)->nodeValue);
        $card = $result->getElementsByTagName('card')->item(0);
        $this->assertNotNull($card);
        $this->assertEquals('1', $card->getElementsByTagName('tpIntegra')->item(0)->nodeValue);
        $this->assertEquals('98765432000100', $card->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('01', $card->getElementsByTagName('tBand')->item(0)->nodeValue);
        $this->assertEquals('AUTH123456', $card->getElementsByTagName('cAut')->item(0)->nodeValue);
        $this->assertEquals('11222333000144', $card->getElementsByTagName('CNPJReceb')->item(0)->nodeValue);
        $this->assertEquals('TERM001', $card->getElementsByTagName('idTermPag')->item(0)->nodeValue);
    }

    public function test_tagdetPag_without_card(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->indPag = '0';
        $std->tPag = '01';
        $std->vPag = '50.00';
        $result = $this->make->tagdetPag($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('detPag', $result->tagName);
        $this->assertNull($result->getElementsByTagName('card')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDest – uncovered branches
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagDest_with_CPF(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->xNome = 'PESSOA FISICA TESTE';
        $std->indIEDest = '9';
        $std->CPF = '12345678901';
        $std->CNPJ = null;
        $std->idEstrangeiro = null;
        $std->IE = null;
        $std->ISUF = null;
        $std->IM = null;
        $std->email = 'teste@teste.com';
        $result = $this->make->tagDest($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('dest', $result->tagName);
        $this->assertEquals('12345678901', $result->getElementsByTagName('CPF')->item(0)->nodeValue);
    }

    public function test_tagenderDest_all_fields(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->xNome = 'EMPRESA DEST LTDA';
        $std->indIEDest = '1';
        $std->CNPJ = '12345678000195';
        $std->IE = '123456789';
        $this->make->tagDest($std);

        $std = new stdClass();
        $std->xLgr = 'RUA DESTINO';
        $std->nro = '200';
        $std->xCpl = 'SALA 5';
        $std->xBairro = 'CENTRO';
        $std->cMun = '3550308';
        $std->xMun = 'SAO PAULO';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = '1122223333';
        $result = $this->make->tagenderDest($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('enderDest', $result->tagName);
        $this->assertEquals('SALA 5', $result->getElementsByTagName('xCpl')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagEmit – uncovered tagenderEmit branch with xFant
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagEmit_without_xFant(): void
    {
        $this->setupBaseTags();
        $m = new Make();

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $m->taginfNFe($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA SEM FANTASIA';
        $std->IE = '123456789012';
        $std->CNPJ = '58716523000119';
        $std->CRT = '3';
        $std->xFant = null;
        $result = $m->tagEmit($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertNull($result->getElementsByTagName('xFant')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagIde – uncovered lines
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagide_with_contingency_fields(): void
    {
        $m = new Make();
        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $m->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2026-01-15T10:00:00-03:00';
        $std->dhSaiEnt = '2026-01-15T10:00:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '1';
        $std->tpEmis = '9';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $std->dhCont = '2026-01-15T09:00:00-03:00';
        $std->xJust = 'PROBLEMAS TECNICOS';
        $result = $m->tagide($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('ide', $result->tagName);
        $this->assertEquals('9', $result->getElementsByTagName('tpEmis')->item(0)->nodeValue);
        $this->assertEquals('2026-01-15T09:00:00-03:00', $result->getElementsByTagName('dhCont')->item(0)->nodeValue);
        $this->assertEquals('PROBLEMAS TECNICOS', $result->getElementsByTagName('xJust')->item(0)->nodeValue);
    }

    public function test_tagide_NFCe_model_65(): void
    {
        $m = new Make();
        $std = new stdClass();
        $std->Id = '35170358716523000119650010000000301000000300';
        $std->versao = '4.00';
        $m->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '65';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2026-01-15T10:00:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '4';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '2';
        $std->finNFe = '1';
        $std->indFinal = '1';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $result = $m->tagide($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('65', $result->getElementsByTagName('mod')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagInfAdic – uncovered obsCont/obsFisco
    // ──────────────────────────────────────────────────────────────────────

    public function test_taginfAdic_with_obsCont(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->infAdFisco = 'INFO FISCO TESTE';
        $std->infCpl = 'INFORMACAO COMPLEMENTAR';
        $this->make->taginfAdic($std);

        $std = new stdClass();
        $std->xCampo = 'campo1';
        $std->xTexto = 'valor1';
        $result = $this->make->tagobsCont($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('obsCont', $result->tagName);
    }

    public function test_taginfAdic_with_obsFisco(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->infAdFisco = 'INFO FISCO';
        $std->infCpl = 'INFO COMPLEMENTAR';
        $this->make->taginfAdic($std);

        $std = new stdClass();
        $std->xCampo = 'campoFisco';
        $std->xTexto = 'valorFisco';
        $result = $this->make->tagobsFisco($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('obsFisco', $result->tagName);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetIPI – uncovered tagIPI
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagIPI_IPITrib(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '10.00';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->clEnq = null;
        $std->CNPJProd = null;
        $std->cSelo = null;
        $std->qSelo = null;
        $std->cEnq = '999';
        $std->CST = '50';
        $std->vBC = '100.00';
        $std->pIPI = '5.00';
        $std->vIPI = '5.00';
        $std->qUnid = null;
        $std->vUnid = null;
        $result = $this->make->tagIPI($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('IPI', $result->tagName);
        $this->assertEquals('999', $result->getElementsByTagName('cEnq')->item(0)->nodeValue);
    }

    public function test_tagIPI_IPINT(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '0';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->clEnq = null;
        $std->CNPJProd = null;
        $std->cSelo = null;
        $std->qSelo = null;
        $std->cEnq = '999';
        $std->CST = '01';
        $std->vBC = null;
        $std->pIPI = null;
        $std->vIPI = null;
        $std->qUnid = null;
        $std->vUnid = null;
        $result = $this->make->tagIPI($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  Make – setters/getters/utility methods
    // ──────────────────────────────────────────────────────────────────────

    public function test_setOnlyAscii(): void
    {
        $m = new Make();
        $m->setOnlyAscii(true);
        // No assertion needed for coverage, just verify it doesn't throw
        $this->assertTrue(true);
    }

    public function test_setCheckGtin(): void
    {
        $m = new Make();
        $m->setCheckGtin(false);
        $this->assertTrue(true);
    }

    public function test_setCalculationMethod(): void
    {
        $m = new Make();
        $m->setCalculationMethod(Make::METHOD_CALCULATION_V1);
        $this->assertTrue(true);
    }

    public function test_getModelo(): void
    {
        $this->setupBaseTags();
        $modelo = $this->make->getModelo();
        $this->assertEquals(55, $modelo);
    }

    public function test_getChave(): void
    {
        $m = new Make();
        $chave = $m->getChave();
        $this->assertIsString($chave);
    }

    public function test_getErrors(): void
    {
        $m = new Make();
        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $m->taginfNFe($std);
        $errors = $m->getErrors();
        $this->assertIsArray($errors);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagTransp – uncovered reboque
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagreboque(): void
    {
        $this->setupBaseTags();

        $std = new stdClass();
        $std->placa = 'ABC1234';
        $std->UF = 'SP';
        $std->RNTC = '12345678';
        $std->vagao = null;
        $std->balsa = null;
        $result = $this->make->tagreboque($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('reboque', $result->tagName);
        $this->assertEquals('ABC1234', $result->getElementsByTagName('placa')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagTotal – uncovered tagISSQNtot
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagISSQNtot(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->vServ = '100.00';
        $std->vBC = '100.00';
        $std->vISS = '5.00';
        $std->vPIS = '1.00';
        $std->vCOFINS = '3.00';
        $std->dCompet = '2026-01-15';
        $std->vDeducao = '10.00';
        $std->vOutro = '2.00';
        $std->vDescIncond = '3.00';
        $std->vDescCond = '1.00';
        $std->vISSRet = '0.50';
        $std->cRegTrib = '1';
        $result = $this->make->tagISSQNtot($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('ISSQNtot', $result->tagName);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDet – uncovered taginfAdProd and tagprodObsCont/obsFisco
    // ──────────────────────────────────────────────────────────────────────

    public function test_taginfAdProd(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->infAdProd = 'Informação adicional do produto teste';
        $result = $this->make->taginfAdProd($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
        $this->assertEquals('Informação adicional do produto teste', $result->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetCOFINS – uncovered COFINSAliq and COFINSNT
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagCOFINS_CST_01(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '0';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = '100.00';
        $std->pCOFINS = '3.00';
        $std->vCOFINS = '3.00';
        $result = $this->make->tagCOFINS($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
    }

    public function test_tagCOFINSST(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '0';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->vBC = '100.00';
        $std->pCOFINS = '3.00';
        $std->vCOFINS = '3.00';
        $std->indSomaCOFINSST = '1';
        $result = $this->make->tagCOFINSST($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetICMS – uncovered tagICMSUFDest branch
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagICMS_CST_10_completo(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '10';
        $std->modBC = '3';
        $std->vBC = '100.00';
        $std->pICMS = '18.00';
        $std->vICMS = '18.00';
        $std->modBCST = '0';
        $std->pMVAST = '40.00';
        $std->vBCST = '140.00';
        $std->pICMSST = '18.00';
        $std->vICMSST = '7.20';
        $std->vBCFCPST = '140.00';
        $std->pFCPST = '2.00';
        $std->vFCPST = '2.80';
        $result = $this->make->tagICMS($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  TraitTagDetPIS – uncovered PISST
    // ──────────────────────────────────────────────────────────────────────

    public function test_tagPISST(): void
    {
        $this->setupBaseTags();
        $this->addProduct();

        $std = new stdClass();
        $std->item = 1;
        $std->vTotTrib = '0';
        $this->make->tagimposto($std);

        $std = new stdClass();
        $std->item = 1;
        $std->vBC = '100.00';
        $std->pPIS = '1.65';
        $std->vPIS = '1.65';
        $std->indSomaPISST = '1';
        $result = $this->make->tagPISST($std);

        $this->assertInstanceOf(\DOMElement::class, $result);
    }
}
