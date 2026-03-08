<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Make;
use stdClass;

class RenderCoverageTest extends NFeTestCase
{
    /**
     * Build a minimal valid NF-e (model 55) with all required groups.
     * Returns the Make instance ready for render().
     */
    private function buildMinimalNFe55(): Make
    {
        $make = new Make();

        // infNFe
        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make->taginfNFe($std);

        // ide
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

        // emit
        $std = new stdClass();
        $std->xNome = 'EMPRESA TESTE LTDA';
        $std->xFant = 'EMPRESA TESTE';
        $std->IE = '123456789012';
        $std->CRT = '3';
        $std->CNPJ = '58716523000119';
        $make->tagEmit($std);

        // enderEmit
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

        // dest
        $std = new stdClass();
        $std->xNome = 'CLIENTE TESTE';
        $std->indIEDest = '9';
        $std->CNPJ = '11222333000181';
        $make->tagdest($std);

        // prod item 1
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

        // ICMS
        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '100.00';
        $std->pICMS = '18.00';
        $std->vICMS = '18.00';
        $make->tagICMS($std);

        // PIS
        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $make->tagPIS($std);

        // COFINS
        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $make->tagCOFINS($std);

        // ICMSTot
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

        // transp
        $std = new stdClass();
        $std->modFrete = '9';
        $make->tagtransp($std);

        // pag
        $std = new stdClass();
        $std->vTroco = null;
        $make->tagpag($std);

        // detPag
        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '100.00';
        $make->tagdetPag($std);

        return $make;
    }

    /**
     * Build a minimal NFC-e (model 65).
     */
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

        // dest (optional for NFCe, but we include minimal)
        $std = new stdClass();
        $std->xNome = '';
        $std->indIEDest = '9';
        $std->CPF = '12345678901';
        $make->tagdest($std);

        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto NFCe';
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

    // ---------------------------------------------------------------
    // 2. Test render() with a COMPLETE NF-e (model 55)
    // ---------------------------------------------------------------

    public function testRenderCompleteNFe55HasAllSections()
    {
        $make = $this->buildMinimalNFe55();
        $xml = $make->render();

        $this->assertNotEmpty($xml);
        // Verify top-level structure
        $this->assertStringContainsString('<NFe xmlns="http://www.portalfiscal.inf.br/nfe">', $xml);
        $this->assertStringContainsString('<infNFe', $xml);
        // ide section
        $this->assertStringContainsString('<ide>', $xml);
        $this->assertStringContainsString('<cUF>35</cUF>', $xml);
        $this->assertStringContainsString('<mod>55</mod>', $xml);
        // emit section
        $this->assertStringContainsString('<emit>', $xml);
        $this->assertStringContainsString('<CNPJ>58716523000119</CNPJ>', $xml);
        // dest section
        $this->assertStringContainsString('<dest>', $xml);
        // det section
        $this->assertStringContainsString('<det nItem="1">', $xml);
        $this->assertStringContainsString('<prod>', $xml);
        $this->assertStringContainsString('<imposto>', $xml);
        // total section
        $this->assertStringContainsString('<total>', $xml);
        $this->assertStringContainsString('<ICMSTot>', $xml);
        // transp section
        $this->assertStringContainsString('<transp>', $xml);
        $this->assertStringContainsString('<modFrete>9</modFrete>', $xml);
        // pag section
        $this->assertStringContainsString('<pag>', $xml);
        $this->assertStringContainsString('<detPag>', $xml);

        // Verify section order: ide < emit < dest < det < total < transp < pag
        $idePos = strpos($xml, '<ide>');
        $emitPos = strpos($xml, '<emit>');
        $destPos = strpos($xml, '<dest>');
        $detPos = strpos($xml, '<det ');
        $totalPos = strpos($xml, '<total>');
        $transpPos = strpos($xml, '<transp>');
        $pagPos = strpos($xml, '<pag>');

        $this->assertLessThan($emitPos, $idePos);
        $this->assertLessThan($destPos, $emitPos);
        $this->assertLessThan($detPos, $destPos);
        $this->assertLessThan($totalPos, $detPos);
        $this->assertLessThan($transpPos, $totalPos);
        $this->assertLessThan($pagPos, $transpPos);
    }

    // ---------------------------------------------------------------
    // 3. Test render() with NFC-e (model 65)
    // ---------------------------------------------------------------

    public function testRenderNFCeModel65()
    {
        $make = $this->buildMinimalNFCe65();
        $xml = $make->render();

        $this->assertNotEmpty($xml);
        $this->assertStringContainsString('<mod>65</mod>', $xml);
        // In homologacao (tpAmb=2), first item xProd is replaced
        $this->assertStringContainsString(
            'NOTA FISCAL EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL',
            $xml
        );
        $this->assertStringContainsString('<indFinal>1</indFinal>', $xml);
        $this->assertStringContainsString('<tpImp>4</tpImp>', $xml);
        $this->assertStringContainsString('<total>', $xml);
        $this->assertStringContainsString('<pag>', $xml);
    }

    // ---------------------------------------------------------------
    // 4. Test TraitTagTotal: tagICMSTot, tagISSQNTot, tagretTrib
    // ---------------------------------------------------------------

    public function testTagICMSTotWithAccumulatedValues()
    {
        $make = $this->buildMinimalNFe55();

        // Override ICMSTot with specific accumulated values
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
        $std->vIPIDevol = '0.00';
        $std->vTotTrib = '383.50';
        $std->vFCP = '20.00';
        $std->vFCPST = '4.00';
        $std->vFCPSTRet = '2.00';
        $make->tagICMSTot($std);

        $xml = $make->render();

        $this->assertStringContainsString('<vBC>1000.00</vBC>', $xml);
        $this->assertStringContainsString('<vICMS>180.00</vICMS>', $xml);
        $this->assertStringContainsString('<vICMSDeson>10.00</vICMSDeson>', $xml);
        $this->assertStringContainsString('<vBCST>200.00</vBCST>', $xml);
        $this->assertStringContainsString('<vST>36.00</vST>', $xml);
        $this->assertStringContainsString('<vFrete>50.00</vFrete>', $xml);
        $this->assertStringContainsString('<vSeg>25.00</vSeg>', $xml);
        $this->assertStringContainsString('<vDesc>15.00</vDesc>', $xml);
        $this->assertStringContainsString('<vII>30.00</vII>', $xml);
        $this->assertStringContainsString('<vIPI>45.00</vIPI>', $xml);
        $this->assertStringContainsString('<vPIS>16.50</vPIS>', $xml);
        $this->assertStringContainsString('<vCOFINS>76.00</vCOFINS>', $xml);
        $this->assertStringContainsString('<vOutro>5.00</vOutro>', $xml);
        $this->assertStringContainsString('<vTotTrib>383.50</vTotTrib>', $xml);
        $this->assertStringContainsString('<vFCP>20.00</vFCP>', $xml);
        $this->assertStringContainsString('<vFCPST>4.00</vFCPST>', $xml);
        $this->assertStringContainsString('<vFCPSTRet>2.00</vFCPSTRet>', $xml);
    }

    public function testTagISSQNTotInRenderOutput()
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
        $this->assertStringContainsString('<vISS>25.00</vISS>', $xml);
        $this->assertStringContainsString('<dCompet>2017-03-03</dCompet>', $xml);
        $this->assertStringContainsString('<vDeducao>10.00</vDeducao>', $xml);
        $this->assertStringContainsString('<vISSRet>12.50</vISSRet>', $xml);
        $this->assertStringContainsString('<cRegTrib>5</cRegTrib>', $xml);
    }

    public function testTagRetTribInRenderOutput()
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

        // retTrib should be inside <total>
        $totalPos = strpos($xml, '<total>');
        $retTribPos = strpos($xml, '<retTrib>');
        $totalEndPos = strpos($xml, '</total>');
        $this->assertGreaterThan($totalPos, $retTribPos);
        $this->assertLessThan($totalEndPos, $retTribPos);
    }

    // ---------------------------------------------------------------
    // 5. Test TraitTagTransp: full transport group
    // ---------------------------------------------------------------

    public function testTagTranspFullInRenderOutput()
    {
        $make = $this->buildMinimalNFe55();

        // Overwrite transp with modFrete=0 (emitente)
        $std = new stdClass();
        $std->modFrete = '0';
        $make->tagtransp($std);

        // transporta (carrier)
        $std = new stdClass();
        $std->xNome = 'Transportadora ABC';
        $std->IE = '111222333444';
        $std->xEnder = 'Rua do Transporte, 500';
        $std->xMun = 'Campinas';
        $std->UF = 'SP';
        $std->CNPJ = '12345678000195';
        $make->tagtransporta($std);

        // veicTransp
        $std = new stdClass();
        $std->placa = 'ABC1D23';
        $std->UF = 'SP';
        $std->RNTC = '12345678';
        $make->tagveicTransp($std);

        // reboque
        $std = new stdClass();
        $std->placa = 'XYZ9F87';
        $std->UF = 'SP';
        $std->RNTC = '87654321';
        $make->tagreboque($std);

        // vol with lacres
        $std = new stdClass();
        $std->item = 1;
        $std->qVol = '10';
        $std->esp = 'CAIXA';
        $std->marca = 'MARCA X';
        $std->nVol = '001';
        $std->pesoL = '100.500';
        $std->pesoB = '120.300';
        $make->tagvol($std);

        // lacres
        $std = new stdClass();
        $std->item = 1;
        $std->nLacre = 'LACRE001';
        $make->taglacres($std);

        $std = new stdClass();
        $std->item = 1;
        $std->nLacre = 'LACRE002';
        $make->taglacres($std);

        $xml = $make->render();

        $this->assertStringContainsString('<modFrete>0</modFrete>', $xml);
        $this->assertStringContainsString('<transporta>', $xml);
        $this->assertStringContainsString('<CNPJ>12345678000195</CNPJ>', $xml);
        $this->assertStringContainsString('<xNome>Transportadora ABC</xNome>', $xml);
        $this->assertStringContainsString('<IE>111222333444</IE>', $xml);
        $this->assertStringContainsString('<xEnder>Rua do Transporte, 500</xEnder>', $xml);
        $this->assertStringContainsString('<xMun>Campinas</xMun>', $xml);
        $this->assertStringContainsString('<veicTransp>', $xml);
        $this->assertStringContainsString('<placa>ABC1D23</placa>', $xml);
        $this->assertStringContainsString('<RNTC>12345678</RNTC>', $xml);
        $this->assertStringContainsString('<reboque>', $xml);
        $this->assertStringContainsString('<placa>XYZ9F87</placa>', $xml);
        $this->assertStringContainsString('<vol>', $xml);
        $this->assertStringContainsString('<qVol>10</qVol>', $xml);
        $this->assertStringContainsString('<esp>CAIXA</esp>', $xml);
        $this->assertStringContainsString('<marca>MARCA X</marca>', $xml);
        $this->assertStringContainsString('<nVol>001</nVol>', $xml);
        $this->assertStringContainsString('<pesoL>100.500</pesoL>', $xml);
        $this->assertStringContainsString('<pesoB>120.300</pesoB>', $xml);
        $this->assertStringContainsString('<lacres>', $xml);
        $this->assertStringContainsString('<nLacre>LACRE001</nLacre>', $xml);
        $this->assertStringContainsString('<nLacre>LACRE002</nLacre>', $xml);
    }

    // ---------------------------------------------------------------
    // 6. Test TraitTagDet: tagprod with optional fields, taginfAdProd, tagObsItem
    // ---------------------------------------------------------------

    public function testTagProdWithAllOptionalFields()
    {
        $make = $this->buildMinimalNFe55();

        // Re-add prod item 1 with all optional fields
        // We need a fresh Make so item 1 is not duplicated
        $make2 = new Make();

        $std = new stdClass();
        $std->Id = '35170358716523000119550010000000301000000300';
        $std->versao = '4.00';
        $make2->taginfNFe($std);

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
        $make2->tagide($std);

        $std = new stdClass();
        $std->xNome = 'EMPRESA TESTE LTDA';
        $std->IE = '123456789012';
        $std->CRT = '3';
        $std->CNPJ = '58716523000119';
        $make2->tagEmit($std);

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
        $make2->tagenderEmit($std);

        $std = new stdClass();
        $std->xNome = 'CLIENTE TESTE';
        $std->indIEDest = '9';
        $std->CNPJ = '11222333000181';
        $make2->tagdest($std);

        // prod with ALL optional fields
        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = '7891234567890';
        $std->xProd = 'Produto Completo';
        $std->NCM = '61091000';
        $std->CEST = '2806300';
        $std->indEscala = 'S';
        $std->CNPJFab = '12345678000195';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '5.0000';
        $std->vUnCom = '20.0000000000';
        $std->vProd = '100.00';
        $std->cEANTrib = '7891234567890';
        $std->uTrib = 'UN';
        $std->qTrib = '5.0000';
        $std->vUnTrib = '20.0000000000';
        $std->vFrete = '10.00';
        $std->vSeg = '5.00';
        $std->vDesc = '3.00';
        $std->vOutro = '2.00';
        $std->indTot = 1;
        $std->xPed = 'PED-12345';
        $std->nItemPed = '001';
        $make2->tagprod($std);

        // ICMS
        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '100.00';
        $std->pICMS = '18.00';
        $std->vICMS = '18.00';
        $make2->tagICMS($std);

        // PIS
        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pPIS = 0;
        $std->vPIS = 0;
        $make2->tagPIS($std);

        // COFINS
        $std = new stdClass();
        $std->item = 1;
        $std->CST = '07';
        $std->vBC = 0;
        $std->pCOFINS = 0;
        $std->vCOFINS = 0;
        $make2->tagCOFINS($std);

        // infAdProd
        $std = new stdClass();
        $std->item = 1;
        $std->infAdProd = 'Informacao adicional do produto item 1';
        $make2->taginfAdProd($std);

        // obsItem
        $std = new stdClass();
        $std->item = 1;
        $std->obsCont_xCampo = 'CampoTeste';
        $std->obsCont_xTexto = 'ValorTeste';
        $make2->tagObsItem($std);

        $std = new stdClass();
        $std->vBC = '100.00';
        $std->vICMS = '18.00';
        $std->vICMSDeson = '0.00';
        $std->vBCST = '0.00';
        $std->vST = '0.00';
        $std->vProd = '100.00';
        $std->vFrete = '10.00';
        $std->vSeg = '5.00';
        $std->vDesc = '3.00';
        $std->vII = '0.00';
        $std->vIPI = '0.00';
        $std->vPIS = '0.00';
        $std->vCOFINS = '0.00';
        $std->vOutro = '2.00';
        $std->vNF = '114.00';
        $std->vTotTrib = '0.00';
        $make2->tagICMSTot($std);

        $std = new stdClass();
        $std->modFrete = '9';
        $make2->tagtransp($std);

        $std = new stdClass();
        $std->vTroco = null;
        $make2->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '114.00';
        $make2->tagdetPag($std);

        $xml = $make2->render();

        // Verify optional fields in prod
        $this->assertStringContainsString('<cEAN>7891234567890</cEAN>', $xml);
        $this->assertStringContainsString('<CEST>2806300</CEST>', $xml);
        $this->assertStringContainsString('<indEscala>S</indEscala>', $xml);
        $this->assertStringContainsString('<CNPJFab>12345678000195</CNPJFab>', $xml);
        $this->assertStringContainsString('<vFrete>10.00</vFrete>', $xml);
        $this->assertStringContainsString('<vSeg>5.00</vSeg>', $xml);
        $this->assertStringContainsString('<vDesc>3.00</vDesc>', $xml);
        $this->assertStringContainsString('<vOutro>2.00</vOutro>', $xml);
        $this->assertStringContainsString('<xPed>PED-12345</xPed>', $xml);
        $this->assertStringContainsString('<nItemPed>001</nItemPed>', $xml);

        // infAdProd
        $this->assertStringContainsString('<infAdProd>Informacao adicional do produto item 1</infAdProd>', $xml);

        // obsItem
        $this->assertStringContainsString('<obsItem>', $xml);
        $this->assertStringContainsString('xCampo="CampoTeste"', $xml);
        $this->assertStringContainsString('<xTexto>ValorTeste</xTexto>', $xml);
    }

    // ---------------------------------------------------------------
    // 7. Test TraitTagDetOptions: tagRastro, tagveicProd, tagmed,
    //    tagarma, tagRECOPI, tagDFeReferenciado
    // ---------------------------------------------------------------

    public function testTagRastroBatchTracking()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->nLote = 'LOTE2025A';
        $std->qLote = '100.000';
        $std->dFab = '2025-01-15';
        $std->dVal = '2026-01-15';
        $std->cAgreg = 'AGR001';
        $make->tagRastro($std);

        $std = new stdClass();
        $std->item = 1;
        $std->nLote = 'LOTE2025B';
        $std->qLote = '50.000';
        $std->dFab = '2025-02-10';
        $std->dVal = '2026-02-10';
        $make->tagRastro($std);

        $xml = $make->render();

        $this->assertStringContainsString('<rastro>', $xml);
        $this->assertStringContainsString('<nLote>LOTE2025A</nLote>', $xml);
        $this->assertStringContainsString('<qLote>100.000</qLote>', $xml);
        $this->assertStringContainsString('<dFab>2025-01-15</dFab>', $xml);
        $this->assertStringContainsString('<dVal>2026-01-15</dVal>', $xml);
        $this->assertStringContainsString('<cAgreg>AGR001</cAgreg>', $xml);
        $this->assertStringContainsString('<nLote>LOTE2025B</nLote>', $xml);
    }

    public function testTagVeicProdVehicle()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->tpOp = '1';
        $std->chassi = '9BWSU19F08B302158';
        $std->cCor = '1';
        $std->xCor = 'BRANCA';
        $std->pot = '150';
        $std->cilin = '1600';
        $std->pesoL = '1200';
        $std->pesoB = '1350';
        $std->nSerie = 'AAA111222';
        $std->tpComb = '16';
        $std->nMotor = 'MOT12345';
        $std->CMT = '1800.0000';
        $std->dist = '2600';
        $std->anoMod = '2025';
        $std->anoFab = '2024';
        $std->tpPint = 'M';
        $std->tpVeic = '06';
        $std->espVeic = '1';
        $std->VIN = 'R';
        $std->condVeic = '1';
        $std->cMod = '123456';
        $std->cCorDENATRAN = '01';
        $std->lota = '5';
        $std->tpRest = '0';
        $make->tagveicProd($std);

        $xml = $make->render();

        $this->assertStringContainsString('<veicProd>', $xml);
        $this->assertStringContainsString('<chassi>9BWSU19F08B302158</chassi>', $xml);
        $this->assertStringContainsString('<xCor>BRANCA</xCor>', $xml);
        $this->assertStringContainsString('<pot>150</pot>', $xml);
        $this->assertStringContainsString('<nMotor>MOT12345</nMotor>', $xml);
        $this->assertStringContainsString('<anoMod>2025</anoMod>', $xml);
        $this->assertStringContainsString('<anoFab>2024</anoFab>', $xml);
        $this->assertStringContainsString('<tpRest>0</tpRest>', $xml);
    }

    public function testTagMedMedicine()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->cProdANVISA = '1234567890123';
        $std->xMotivoIsencao = null;
        $std->vPMC = '49.90';
        $make->tagmed($std);

        $xml = $make->render();

        $this->assertStringContainsString('<med>', $xml);
        $this->assertStringContainsString('<cProdANVISA>1234567890123</cProdANVISA>', $xml);
        $this->assertStringContainsString('<vPMC>49.90</vPMC>', $xml);
    }

    public function testTagArmaWeapon()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->tpArma = '0';
        $std->nSerie = 'SR12345';
        $std->nCano = 'CN67890';
        $std->descr = 'REVOLVER CALIBRE 38';
        $make->tagarma($std);

        $xml = $make->render();

        $this->assertStringContainsString('<arma>', $xml);
        $this->assertStringContainsString('<tpArma>0</tpArma>', $xml);
        $this->assertStringContainsString('<nSerie>SR12345</nSerie>', $xml);
        $this->assertStringContainsString('<nCano>CN67890</nCano>', $xml);
        $this->assertStringContainsString('<descr>REVOLVER CALIBRE 38</descr>', $xml);
    }

    public function testTagRECOPI()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->nRECOPI = '20250101120000123456';
        $make->tagRECOPI($std);

        $xml = $make->render();

        $this->assertStringContainsString('<nRECOPI>20250101120000123456</nRECOPI>', $xml);
    }

    public function testTagRECOPIWithInvalidDataReturnsNull()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->item = 1;
        $std->nRECOPI = '';
        $result = $make->tagRECOPI($std);

        $this->assertNull($result);
        $errors = $make->getErrors();
        $this->assertNotEmpty($errors);
    }

    public function testTagDFeReferenciado()
    {
        // DFeReferenciado is only added for schema > 9 (PL_010)
        $make = new Make('PL_010_V1.30');

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

        // DFeReferenciado
        $std = new stdClass();
        $std->item = 1;
        $std->chaveAcesso = '35170358716523000119550010000000291000000291';
        $std->nItem = '1';
        $make->tagDFeReferenciado($std);

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

        $xml = $make->render();

        $this->assertStringContainsString('<DFeReferenciado>', $xml);
        $this->assertStringContainsString(
            '<chaveAcesso>35170358716523000119550010000000291000000291</chaveAcesso>',
            $xml
        );
        $this->assertStringContainsString('<nItem>1</nItem>', $xml);
    }

    // ---------------------------------------------------------------
    // 8. Test TraitTagRefs: tagrefNFe, tagrefNF, tagrefNFP, tagrefCTe, tagrefECF
    // ---------------------------------------------------------------

    public function testTagRefNFeInIde()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->refNFe = '35170358716523000119550010000000291000000291';
        $make->tagrefNFe($std);

        $xml = $make->render();

        $this->assertStringContainsString('<NFref>', $xml);
        $this->assertStringContainsString(
            '<refNFe>35170358716523000119550010000000291000000291</refNFe>',
            $xml
        );
        // NFref should be inside <ide>
        $idePos = strpos($xml, '<ide>');
        $nfrefPos = strpos($xml, '<NFref>');
        $ideEndPos = strpos($xml, '</ide>');
        $this->assertGreaterThan($idePos, $nfrefPos);
        $this->assertLessThan($ideEndPos, $nfrefPos);
    }

    public function testTagRefNFInIde()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->cUF = '35';
        $std->AAMM = '1703';
        $std->CNPJ = '58716523000119';
        $std->mod = '01';
        $std->serie = '1';
        $std->nNF = '100';
        $make->tagrefNF($std);

        $xml = $make->render();

        $this->assertStringContainsString('<NFref>', $xml);
        $this->assertStringContainsString('<refNF>', $xml);
        $this->assertStringContainsString('<AAMM>1703</AAMM>', $xml);
        $this->assertStringContainsString('<mod>01</mod>', $xml);
    }

    public function testTagRefNFPWithCNPJInIde()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->cUF = '35';
        $std->AAMM = '1703';
        $std->CNPJ = '58716523000119';
        $std->CPF = null;
        $std->IE = '123456789012';
        $std->mod = '04';
        $std->serie = '1';
        $std->nNF = '50';
        $make->tagrefNFP($std);

        $xml = $make->render();

        $this->assertStringContainsString('<refNFP>', $xml);
        $this->assertStringContainsString('<CNPJ>58716523000119</CNPJ>', $xml);
        $this->assertStringContainsString('<IE>123456789012</IE>', $xml);
        $this->assertStringContainsString('<mod>04</mod>', $xml);
    }

    public function testTagRefNFPWithCPFInIde()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->cUF = '35';
        $std->AAMM = '1703';
        $std->CNPJ = null;
        $std->CPF = '12345678901';
        $std->IE = 'ISENTO';
        $std->mod = '04';
        $std->serie = '0';
        $std->nNF = '10';
        $make->tagrefNFP($std);

        $xml = $make->render();

        $this->assertStringContainsString('<refNFP>', $xml);
        $this->assertStringContainsString('<CPF>12345678901</CPF>', $xml);
        $this->assertStringContainsString('<IE>ISENTO</IE>', $xml);
    }

    public function testTagRefCTeInIde()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->refCTe = '35170358716523000119570010000000011000000014';
        $make->tagrefCTe($std);

        $xml = $make->render();

        $this->assertStringContainsString('<NFref>', $xml);
        $this->assertStringContainsString(
            '<refCTe>35170358716523000119570010000000011000000014</refCTe>',
            $xml
        );
    }

    public function testTagRefECFInIde()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->mod = '2D';
        $std->nECF = '123';
        $std->nCOO = '456789';
        $make->tagrefECF($std);

        $xml = $make->render();

        $this->assertStringContainsString('<refECF>', $xml);
        $this->assertStringContainsString('<mod>2D</mod>', $xml);
        $this->assertStringContainsString('<nECF>123</nECF>', $xml);
        $this->assertStringContainsString('<nCOO>456789</nCOO>', $xml);
    }

    public function testMultipleRefsInIde()
    {
        $make = $this->buildMinimalNFe55();

        $std = new stdClass();
        $std->refNFe = '35170358716523000119550010000000291000000291';
        $make->tagrefNFe($std);

        $std = new stdClass();
        $std->refCTe = '35170358716523000119570010000000011000000014';
        $make->tagrefCTe($std);

        $xml = $make->render();

        // Both NFref blocks should be in ide
        $this->assertStringContainsString('<refNFe>', $xml);
        $this->assertStringContainsString('<refCTe>', $xml);

        // Count NFref occurrences - should be 2
        $this->assertEquals(2, substr_count($xml, '<NFref>'));
    }

    // ---------------------------------------------------------------
    // 9. Test TraitTagPag: tagpag with vTroco, tagdetPag with card details
    // ---------------------------------------------------------------

    public function testTagPagWithVTrocoAndCardDetails()
    {
        $make = $this->buildMinimalNFe55();

        // Override pag with vTroco
        $std = new stdClass();
        $std->vTroco = '50.00';
        $make->tagpag($std);

        // detPag with card
        $std = new stdClass();
        $std->tPag = '03'; // cartao credito
        $std->vPag = '150.00';
        $std->tpIntegra = '1';
        $std->CNPJ = '12345678000195';
        $std->tBand = '01';
        $std->cAut = 'AUTH123456';
        $make->tagdetPag($std);

        $xml = $make->render();

        $this->assertStringContainsString('<pag>', $xml);
        $this->assertStringContainsString('<vTroco>50.00</vTroco>', $xml);
        $this->assertStringContainsString('<detPag>', $xml);
        $this->assertStringContainsString('<tPag>03</tPag>', $xml);
        $this->assertStringContainsString('<vPag>150.00</vPag>', $xml);
        $this->assertStringContainsString('<card>', $xml);
        $this->assertStringContainsString('<tpIntegra>1</tpIntegra>', $xml);
        $this->assertStringContainsString('<CNPJ>12345678000195</CNPJ>', $xml);
        $this->assertStringContainsString('<tBand>01</tBand>', $xml);
        $this->assertStringContainsString('<cAut>AUTH123456</cAut>', $xml);

        // vTroco must come AFTER detPag
        $detPagPos = strpos($xml, '<detPag>');
        $vTrocoPos = strpos($xml, '<vTroco>');
        $this->assertGreaterThan($detPagPos, $vTrocoPos);
    }

    public function testTagPagMultiplePayments()
    {
        $make = $this->buildMinimalNFe55();

        // buildMinimalNFe55 already adds one detPag (tPag=01, vPag=100.00)
        // Add a second card payment
        $std = new stdClass();
        $std->tPag = '03';
        $std->vPag = '50.00';
        $std->tpIntegra = '2';
        $make->tagdetPag($std);

        $xml = $make->render();

        // Should have 2 detPag entries (one from buildMinimalNFe55, one added here)
        $this->assertEquals(2, substr_count($xml, '<detPag>'));
        $this->assertStringContainsString('<tPag>01</tPag>', $xml);
        $this->assertStringContainsString('<tPag>03</tPag>', $xml);
    }

    // ---------------------------------------------------------------
    // 10. Test TraitCalculations: totals correctly calculated
    // ---------------------------------------------------------------

    public function testCalculationsTotalsFromMultipleItems()
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

        // Item 1: vProd=200, vFrete=10, vDesc=5
        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto A';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '10.0000';
        $std->vUnCom = '20.0000000000';
        $std->vProd = '200.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '10.0000';
        $std->vUnTrib = '20.0000000000';
        $std->vFrete = '10.00';
        $std->vDesc = '5.00';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '200.00';
        $std->pICMS = '18.00';
        $std->vICMS = '36.00';
        $make->tagICMS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = '200.00';
        $std->pPIS = '1.65';
        $std->vPIS = '3.30';
        $make->tagPIS($std);

        $std = new stdClass();
        $std->item = 1;
        $std->CST = '01';
        $std->vBC = '200.00';
        $std->pCOFINS = '7.60';
        $std->vCOFINS = '15.20';
        $make->tagCOFINS($std);

        // Item 2: vProd=300, vSeg=8, vOutro=3
        $std = new stdClass();
        $std->item = 2;
        $std->cProd = '002';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto B';
        $std->NCM = '84713012';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '3.0000';
        $std->vUnCom = '100.0000000000';
        $std->vProd = '300.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '3.0000';
        $std->vUnTrib = '100.0000000000';
        $std->vSeg = '8.00';
        $std->vOutro = '3.00';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 2;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '300.00';
        $std->pICMS = '12.00';
        $std->vICMS = '36.00';
        $make->tagICMS($std);

        $std = new stdClass();
        $std->item = 2;
        $std->CST = '01';
        $std->vBC = '300.00';
        $std->pPIS = '1.65';
        $std->vPIS = '4.95';
        $make->tagPIS($std);

        $std = new stdClass();
        $std->item = 2;
        $std->CST = '01';
        $std->vBC = '300.00';
        $std->pCOFINS = '7.60';
        $std->vCOFINS = '22.80';
        $make->tagCOFINS($std);

        // Let the library calculate totals (don't set tagICMSTot)
        // The stdTot accumulates from tagprod calls:
        // vProd = 200+300 = 500
        // vFrete = 10+0 = 10
        // vDesc = 5+0 = 5
        // vSeg = 0+8 = 8
        // vOutro = 0+3 = 3

        $std = new stdClass();
        $std->modFrete = '9';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vTroco = null;
        $make->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '516.00';
        $make->tagdetPag($std);

        $xml = $make->render();

        // The library accumulates vProd/vFrete/vDesc/vSeg/vOutro from tagprod
        // and calculates vNF = vProd - vDesc + vST + vFrete + vSeg + vOutro + vII + vIPI + vIPIDevol
        // = 500 - 5 + 0 + 10 + 8 + 3 + 0 + 0 + 0 = 516

        $this->assertStringContainsString('<vProd>500.00</vProd>', $xml);
        $this->assertStringContainsString('<vFrete>10.00</vFrete>', $xml);
        $this->assertStringContainsString('<vDesc>5.00</vDesc>', $xml);
        $this->assertStringContainsString('<vSeg>8.00</vSeg>', $xml);
        $this->assertStringContainsString('<vOutro>3.00</vOutro>', $xml);
        $this->assertStringContainsString('<vNF>516.00</vNF>', $xml);

        // Verify two det items exist
        $this->assertEquals(2, substr_count($xml, '<det nItem='));
        $this->assertStringContainsString('<det nItem="1">', $xml);
        $this->assertStringContainsString('<det nItem="2">', $xml);
    }

    public function testCalculationsWithDifferentTaxValues()
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

        // Single item with explicit ICMSTot to test the override
        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto Teste';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '10.0000';
        $std->vUnCom = '25.0000000000';
        $std->vProd = '250.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '10.0000';
        $std->vUnTrib = '25.0000000000';
        $std->vFrete = '15.50';
        $std->vSeg = '7.25';
        $std->vDesc = '12.75';
        $std->vOutro = '4.00';
        $std->indTot = 1;
        $make->tagprod($std);

        $std = new stdClass();
        $std->item = 1;
        $std->orig = '0';
        $std->CST = '00';
        $std->modBC = '0';
        $std->vBC = '250.00';
        $std->pICMS = '18.00';
        $std->vICMS = '45.00';
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

        // Explicitly pass ICMSTot with specific values including vTotTrib
        $std = new stdClass();
        $std->vBC = '250.00';
        $std->vICMS = '45.00';
        $std->vICMSDeson = '0.00';
        $std->vBCST = '0.00';
        $std->vST = '0.00';
        $std->vProd = '250.00';
        $std->vFrete = '15.50';
        $std->vSeg = '7.25';
        $std->vDesc = '12.75';
        $std->vII = '0.00';
        $std->vIPI = '0.00';
        $std->vPIS = '0.00';
        $std->vCOFINS = '0.00';
        $std->vOutro = '4.00';
        $std->vNF = '264.00';
        $std->vIPIDevol = '0.00';
        $std->vTotTrib = '45.00';
        $make->tagICMSTot($std);

        $std = new stdClass();
        $std->modFrete = '9';
        $make->tagtransp($std);

        $std = new stdClass();
        $std->vTroco = null;
        $make->tagpag($std);

        $std = new stdClass();
        $std->tPag = '01';
        $std->vPag = '264.00';
        $make->tagdetPag($std);

        $xml = $make->render();

        // When tagICMSTot is called, buildTotalICMS still recalculates vNF from stdTot
        // which was accumulated from tagprod: vProd=250, vFrete=15.50, vSeg=7.25, vDesc=12.75, vOutro=4
        // vNF = 250 - 12.75 + 0 + 0 + 0 + 15.50 + 7.25 + 4 + 0 + 0 + 0 + 0 + 0 + 0 = 264.00
        $this->assertStringContainsString('<vNF>264.00</vNF>', $xml);
        $this->assertStringContainsString('<vTotTrib>45.00</vTotTrib>', $xml);

        // Verify that the per-item values are also present
        $this->assertStringContainsString('<vFrete>15.50</vFrete>', $xml);
        $this->assertStringContainsString('<vSeg>7.25</vSeg>', $xml);
        $this->assertStringContainsString('<vDesc>12.75</vDesc>', $xml);
        $this->assertStringContainsString('<vOutro>4.00</vOutro>', $xml);
    }

    // ---------------------------------------------------------------
    // 11. Test TraitTagCobr (already 100% but included for completeness)
    // ---------------------------------------------------------------

    public function testTagCobrInRenderOutput()
    {
        $make = $this->buildMinimalNFe55();

        // Cobr - let's check it appears. We need tagfat and tagdup.
        $std = new stdClass();
        $std->nFat = '001';
        $std->vOrig = '100.00';
        $std->vDesc = '0.00';
        $std->vLiq = '100.00';
        $make->tagfat($std);

        $std = new stdClass();
        $std->nDup = '001';
        $std->dVenc = '2017-04-03';
        $std->vDup = '100.00';
        $make->tagdup($std);

        $xml = $make->render();

        $this->assertStringContainsString('<cobr>', $xml);
        $this->assertStringContainsString('<fat>', $xml);
        $this->assertStringContainsString('<nFat>001</nFat>', $xml);
        $this->assertStringContainsString('<dup>', $xml);
        $this->assertStringContainsString('<nDup>001</nDup>', $xml);
        $this->assertStringContainsString('<dVenc>2017-04-03</dVenc>', $xml);
        $this->assertStringContainsString('<vDup>100.00</vDup>', $xml);
    }
}
