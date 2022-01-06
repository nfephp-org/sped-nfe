<?php

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Convert;
use PHPStan\Testing\TestCase;

class ConvertTest extends TestCase
{
    /**
     * @return void
     */
    public function test_convert()
    {
        $txt = file_get_contents(__DIR__ . '/fixtures/txt/nfe_4.00_local_01.txt');
        $conv = new Convert($txt);
        $xmls = $conv->toXml();
        $this->assertCount(1, $xmls);
        $nfe = new \SimpleXMLElement($xmls[0]);

        //identificação
        $this->assertSame('35', (string)$nfe->infNFe->ide->cUF);
        $this->assertSame('00000501', (string)$nfe->infNFe->ide->cNF);
        $this->assertSame('VENDA MERC.SUB.TRIBUTARIA', (string)$nfe->infNFe->ide->natOp);
        $this->assertSame('55', (string)$nfe->infNFe->ide->mod);
        $this->assertSame('1', (string)$nfe->infNFe->ide->serie);
        $this->assertSame('502', (string)$nfe->infNFe->ide->nNF);
        $this->assertSame('2018-08-13T17:28:10-03:00', (string)$nfe->infNFe->ide->dhEmi);
        $this->assertSame('2018-08-14T09:00:00-03:00', (string)$nfe->infNFe->ide->dhSaiEnt);
        $this->assertSame('1', (string)$nfe->infNFe->ide->tpNF);
        $this->assertSame('1', (string)$nfe->infNFe->ide->idDest);
        $this->assertSame('3550308', (string)$nfe->infNFe->ide->cMunFG);
        $this->assertSame('1', (string)$nfe->infNFe->ide->tpImp);
        $this->assertSame('1', (string)$nfe->infNFe->ide->tpEmis);
        $this->assertSame('8', (string)$nfe->infNFe->ide->cDV);
        $this->assertSame('1', (string)$nfe->infNFe->ide->tpAmb);
        $this->assertSame('1', (string)$nfe->infNFe->ide->finNFe);
        $this->assertSame('0', (string)$nfe->infNFe->ide->indFinal);
        $this->assertSame('3', (string)$nfe->infNFe->ide->indPres);
        $this->assertSame('0', (string)$nfe->infNFe->ide->indIntermed);
        $this->assertSame('0', (string)$nfe->infNFe->ide->procEmi);
        $this->assertSame('3.2.1.1', (string)$nfe->infNFe->ide->verProc);

        //emitente
        $this->assertSame('25028332000105', (string)$nfe->infNFe->emit->CNPJ);

        //destinatario
        $this->assertSame('17812455000295', (string)$nfe->infNFe->dest->CNPJ);

        //itens
        $this->assertCount(4, $nfe->infNFe->det);

        $produto1 = $nfe->infNFe->det[0];
        $this->assertSame('11352', (string)$produto1->prod->cProd);

        $produto2 = $nfe->infNFe->det[1];
        $this->assertSame('14169', (string)$produto2->prod->cProd);

        $produto3 = $nfe->infNFe->det[2];
        $this->assertSame('355', (string)$produto3->prod->cProd);

        $produto4 = $nfe->infNFe->det[3];
        $this->assertSame('45', (string)$produto4->prod->cProd);

        //totais
        $this->assertEquals(55.84, (float)$nfe->infNFe->total->ICMSTot->vBC);
        $this->assertEquals(10.04, (float)$nfe->infNFe->total->ICMSTot->vICMS);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vICMSDeson);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vFCP);
        $this->assertEquals(94.87, (float)$nfe->infNFe->total->ICMSTot->vBCST);
        $this->assertEquals(12.39, (float)$nfe->infNFe->total->ICMSTot->vST);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vFCPST);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vFCPSTRet);
        $this->assertEquals(103.88, (float)$nfe->infNFe->total->ICMSTot->vProd);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vFrete);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vSeg);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vDesc);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vII);
        $this->assertEquals(0.12, (float)$nfe->infNFe->total->ICMSTot->vIPI);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vIPIDevol);
        $this->assertEquals(0.67, (float)$nfe->infNFe->total->ICMSTot->vPIS);
        $this->assertEquals(3.12, (float)$nfe->infNFe->total->ICMSTot->vCOFINS);
        $this->assertEquals(0.00, (float)$nfe->infNFe->total->ICMSTot->vOutro);
        $this->assertEquals(116.39, (float)$nfe->infNFe->total->ICMSTot->vNF);
    }
}
