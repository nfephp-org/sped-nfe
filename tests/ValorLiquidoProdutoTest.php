<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use DOMDocument;
use NFePHP\NFe\Make;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * NT 2026.008 - campos vUnComLiq (I11b), vProdLiq (I11c) e vProdLiqTot (W01a)
 */
class ValorLiquidoProdutoTest extends TestCase
{
    public function testEmiteCamposLiquidosNoItemEMTotal(): void
    {
        $xml = $this->buildXml(true);
        $dom = $this->loadXml($xml);

        $this->assertSame('10.5000000000', $this->nodeValue($dom, '//det[@nItem="1"]/prod/vUnComLiq'));
        $this->assertSame('31.50', $this->nodeValue($dom, '//det[@nItem="1"]/prod/vProdLiq'));
        $this->assertSame('68.5000000000', $this->nodeValue($dom, '//det[@nItem="2"]/prod/vUnComLiq'));
        $this->assertSame('68.50', $this->nodeValue($dom, '//det[@nItem="2"]/prod/vProdLiq'));
        $this->assertSame('100.00', $this->nodeValue($dom, '//total/vProdLiqTot'));
    }

    public function testVProdLiqTotEIgualASomaDosItens(): void
    {
        $dom = $this->loadXml($this->buildXml(true));

        $soma = 0.0;
        foreach ($dom->getElementsByTagName('vProdLiq') as $node) {
            $soma += (float) $node->nodeValue;
        }

        $this->assertEqualsWithDelta($soma, (float) $this->nodeValue($dom, '//total/vProdLiqTot'), 0.001);
    }

    public function testVProdLiqEIgualAVUnComLiqVezesQCom(): void
    {
        $dom = $this->loadXml($this->buildXml(true));

        foreach ($dom->getElementsByTagName('prod') as $prod) {
            $qCom = (float) $prod->getElementsByTagName('qCom')->item(0)->nodeValue;
            $vUnComLiq = (float) $prod->getElementsByTagName('vUnComLiq')->item(0)->nodeValue;
            $vProdLiq = (float) $prod->getElementsByTagName('vProdLiq')->item(0)->nodeValue;
            $this->assertEqualsWithDelta($vUnComLiq * $qCom, $vProdLiq, 0.01);
        }
    }

    public function testOrdemDosElementosNoXml(): void
    {
        $dom = $this->loadXml($this->buildXml(true));

        $prodChildren = $this->childNames($dom->getElementsByTagName('prod')->item(0));
        $posVProd = array_search('vProd', $prodChildren, true);
        $this->assertSame('vUnComLiq', $prodChildren[$posVProd + 1]);
        $this->assertSame('vProdLiq', $prodChildren[$posVProd + 2]);
        $this->assertSame('cEANTrib', $prodChildren[$posVProd + 3]);

        $totalChildren = $this->childNames($dom->getElementsByTagName('total')->item(0));
        $this->assertSame(['vProdLiqTot', 'ICMSTot'], $totalChildren);
    }

    public function testInformarSomenteUmDosCamposLiquidosDoItemRegistraErro(): void
    {
        $make = new Make();

        $std = new stdClass();
        $std->item = 1;
        $std->cProd = '001';
        $std->cEAN = 'SEM GTIN';
        $std->xProd = 'Produto Teste';
        $std->NCM = '61091000';
        $std->CFOP = '5102';
        $std->uCom = 'UN';
        $std->qCom = '1.0000';
        $std->vUnCom = '10.00';
        $std->vProd = '10.00';
        $std->vProdLiq = '10.00';
        $std->cEANTrib = 'SEM GTIN';
        $std->uTrib = 'UN';
        $std->qTrib = '1.0000';
        $std->vUnTrib = '10.00';
        $std->indTot = 1;
        $make->tagprod($std);

        $this->assertStringContainsString('vUnComLiq', implode(' ', $make->getErrors()));
    }

    public function testSemOsCamposNaoEmiteNenhumaTagNova(): void
    {
        $xml = $this->buildXml(false);

        $this->assertStringNotContainsString('vUnComLiq', $xml);
        $this->assertStringNotContainsString('vProdLiq', $xml);
        $this->assertStringNotContainsString('vProdLiqTot', $xml);
    }

    private function loadXml(string $xml): DOMDocument
    {
        $dom = new DOMDocument();
        $dom->loadXML(str_replace(' xmlns="http://www.portalfiscal.inf.br/nfe"', '', $xml));

        return $dom;
    }

    private function nodeValue(DOMDocument $dom, string $query): ?string
    {
        $node = (new \DOMXPath($dom))->query($query)->item(0);

        return $node ? $node->nodeValue : null;
    }

    private function childNames(\DOMNode $parent): array
    {
        $names = [];
        foreach ($parent->childNodes as $child) {
            if ($child instanceof \DOMElement) {
                $names[] = $child->nodeName;
            }
        }

        return $names;
    }

    private function buildXml(bool $comValorLiquido): string
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

        $itens = [
            [1, '3.0000', '10.50', '31.50', '10.50', '31.50'],
            [2, '1.0000', '68.5000000000', '68.50', '68.5000000000', '68.50'],
        ];
        foreach ($itens as [$item, $qCom, $vUnCom, $vProd, $vUnComLiq, $vProdLiq]) {
            $std = new stdClass();
            $std->item = $item;
            $std->cProd = '00' . $item;
            $std->cEAN = 'SEM GTIN';
            $std->xProd = 'Produto Teste';
            $std->NCM = '61091000';
            $std->CFOP = '5102';
            $std->uCom = 'UN';
            $std->qCom = $qCom;
            $std->vUnCom = $vUnCom;
            $std->vProd = $vProd;
            if ($comValorLiquido) {
                $std->vUnComLiq = $vUnComLiq;
                $std->vProdLiq = $vProdLiq;
            }
            $std->cEANTrib = 'SEM GTIN';
            $std->uTrib = 'UN';
            $std->qTrib = $qCom;
            $std->vUnTrib = $vUnCom;
            $std->indTot = 1;
            $make->tagprod($std);

            $std = new stdClass();
            $std->item = $item;
            $std->orig = '0';
            $std->CST = '00';
            $std->modBC = '0';
            $std->vBC = $vProd;
            $std->pICMS = '18.00';
            $std->vICMS = number_format((float) $vProd * 0.18, 2, '.', '');
            $make->tagICMS($std);

            $std = new stdClass();
            $std->item = $item;
            $std->CST = '07';
            $make->tagPIS($std);

            $std = new stdClass();
            $std->item = $item;
            $std->CST = '07';
            $make->tagCOFINS($std);
        }

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

        return $make->getXML();
    }
}
