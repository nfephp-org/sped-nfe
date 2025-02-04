<?php

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Convert;
use NFePHP\NFe\Exception\ParserException;
use PHPUnit\Framework\TestCase;

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

        $this->assertIdentificacao($nfe);
        $this->assertEmitente($nfe);
        $this->assertDestinatario($nfe);
        $this->assertItens($nfe);
        $this->assertTotais($nfe);
        $this->assertFrete($nfe);
        $this->assertCobranca($nfe);
        $this->assertPagamento($nfe);
        $this->assertInfoAdicional($nfe);
    }

    public function test_convert_errors()
    {
        $this->expectException(ParserException::class);
        $this->expectExceptionMessageMatches('/A chave informada está incorreta/');
        $txt = file_get_contents(__DIR__ . '/fixtures/txt/nfe_4.00_local_error.txt');
        $conv = new Convert($txt);
        $conv->toXml();
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertIdentificacao($nfe)
    {
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
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertEmitente($nfe)
    {
        $this->assertSame('25028332000105', (string)$nfe->infNFe->emit->CNPJ);
        $this->assertSame('GSMMY COMERCIO DE CHOCOLATES LTDA', (string)$nfe->infNFe->emit->xNome);
        $this->assertSame('140950881119', (string)$nfe->infNFe->emit->IE);
        $this->assertSame('3', (string)$nfe->infNFe->emit->CRT);
        $this->assertSame('RUA CAETEZAL', (string)$nfe->infNFe->emit->enderEmit->xLgr);
        $this->assertSame('296', (string)$nfe->infNFe->emit->enderEmit->nro);
        $this->assertSame('AGUA FRIA', (string)$nfe->infNFe->emit->enderEmit->xBairro);
        $this->assertSame('3550308', (string)$nfe->infNFe->emit->enderEmit->cMun);
        $this->assertSame('SAO PAULO', (string)$nfe->infNFe->emit->enderEmit->xMun);
        $this->assertSame('SP', (string)$nfe->infNFe->emit->enderEmit->UF);
        $this->assertSame('02334130', (string)$nfe->infNFe->emit->enderEmit->CEP);
        $this->assertSame('1122813500', (string)$nfe->infNFe->emit->enderEmit->fone);
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertDestinatario($nfe)
    {
        $this->assertSame('17812455000295', (string)$nfe->infNFe->dest->CNPJ);
        $this->assertSame('SILVANA MARCONI - VL LEOPOLDINA', (string)$nfe->infNFe->dest->xNome);
        $this->assertSame('1', (string)$nfe->infNFe->dest->indIEDest);
        $this->assertSame('142304338112', (string)$nfe->infNFe->dest->IE);
        $this->assertSame('vilaleopoldina@munik.com.br', (string)$nfe->infNFe->dest->email);

        $this->assertSame('R SCHILLING', (string)$nfe->infNFe->dest->enderDest->xLgr);
        $this->assertSame('491', (string)$nfe->infNFe->dest->enderDest->nro);
        $this->assertSame('VILA LEOPOLDINA', (string)$nfe->infNFe->dest->enderDest->xBairro);
        $this->assertSame('3550308', (string)$nfe->infNFe->dest->enderDest->cMun);
        $this->assertSame('SAO PAULO', (string)$nfe->infNFe->dest->enderDest->xMun);
        $this->assertSame('SP', (string)$nfe->infNFe->dest->enderDest->UF);
        $this->assertSame('05302001', (string)$nfe->infNFe->dest->enderDest->CEP);
        $this->assertSame('1143053063', (string)$nfe->infNFe->dest->enderDest->fone);
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertItens($nfe)
    {
        //itens
        $this->assertCount(4, $nfe->infNFe->det);

        $produto1 = $nfe->infNFe->det[0];
        $this->assertSame('11352', (string)$produto1->prod->cProd);
        $this->assertSame('7897112913525', (string)$produto1->prod->cEAN);
        $this->assertSame('CX DE BOMBOM SORTIDO 105G - 11352', (string)$produto1->prod->xProd);
        $this->assertSame('18069000', (string)$produto1->prod->NCM);
        $this->assertSame('1700700', (string)$produto1->prod->CEST);
        $this->assertSame('5401', (string)$produto1->prod->CFOP);
        $this->assertSame('CX', (string)$produto1->prod->uCom);
        $this->assertSame('10.0000', (string)$produto1->prod->qCom);
        $this->assertSame('2.5300000000', (string)$produto1->prod->vUnCom);
        $this->assertSame('25.30', (string)$produto1->prod->vProd);
        $this->assertSame('7897112913525', (string)$produto1->prod->cEANTrib);
        $this->assertSame('CX', (string)$produto1->prod->uTrib);
        $this->assertSame('10.0000', (string)$produto1->prod->qTrib);
        $this->assertSame('2.5300000000', (string)$produto1->prod->vUnTrib);
        $this->assertSame('1', (string)$produto1->prod->indTot);
        $this->assertSame('0', (string)$produto1->prod->nItemPed);

        $this->assertSame('1', (string)$produto1->prod->gCred->cCredPresumido);
        $this->assertSame('10.0000', (string)$produto1->prod->gCred->pCredPresumido);
        $this->assertSame('100.00', (string)$produto1->prod->gCred->vCredPresumido);

        //imposto
        $this->assertSame('0.00', (string)$produto1->imposto->vTotTrib);

        //ICMS
        $this->assertSame('0', (string)$produto1->imposto->ICMS->ICMS10->orig);
        $this->assertSame('10', (string)$produto1->imposto->ICMS->ICMS10->CST);
        $this->assertSame('3', (string)$produto1->imposto->ICMS->ICMS10->modBC);
        $this->assertSame('25.30', (string)$produto1->imposto->ICMS->ICMS10->vBC);
        $this->assertSame('18.0000', (string)$produto1->imposto->ICMS->ICMS10->pICMS);
        $this->assertSame('4.55', (string)$produto1->imposto->ICMS->ICMS10->vICMS);
        $this->assertSame('0', (string)$produto1->imposto->ICMS->ICMS10->modBCST);
        $this->assertSame('42.27', (string)$produto1->imposto->ICMS->ICMS10->vBCST);
        $this->assertSame('18.0000', (string)$produto1->imposto->ICMS->ICMS10->pICMSST);
        $this->assertSame('3.06', (string)$produto1->imposto->ICMS->ICMS10->vICMSST);

        //IPI
        $this->assertSame('0', (string)$produto1->imposto->IPI->qSelo);
        $this->assertSame('999', (string)$produto1->imposto->IPI->cEnq);
        $this->assertSame('50', (string)$produto1->imposto->IPI->IPITrib->CST);
        $this->assertSame('25.30', (string)$produto1->imposto->IPI->IPITrib->vBC);
        $this->assertSame('0.0000', (string)$produto1->imposto->IPI->IPITrib->pIPI);
        $this->assertSame('0.12', (string)$produto1->imposto->IPI->IPITrib->vIPI);

        //PIS
        $this->assertSame('01', (string)$produto1->imposto->PIS->PISAliq->CST);
        $this->assertSame('25.30', (string)$produto1->imposto->PIS->PISAliq->vBC);
        $this->assertSame('0.6500', (string)$produto1->imposto->PIS->PISAliq->pPIS);
        $this->assertSame('0.16', (string)$produto1->imposto->PIS->PISAliq->vPIS);


        //COFINS
        $this->assertSame('01', (string)$produto1->imposto->COFINS->COFINSAliq->CST);
        $this->assertSame('25.30', (string)$produto1->imposto->COFINS->COFINSAliq->vBC);
        $this->assertSame('3.0000', (string)$produto1->imposto->COFINS->COFINSAliq->pCOFINS);
        $this->assertSame('0.76', (string)$produto1->imposto->COFINS->COFINSAliq->vCOFINS);

        $produto2 = $nfe->infNFe->det[1];
        $this->assertSame('14169', (string)$produto2->prod->cProd);

        $produto3 = $nfe->infNFe->det[2];
        $this->assertSame('355', (string)$produto3->prod->cProd);

        $produto4 = $nfe->infNFe->det[3];
        $this->assertSame('45', (string)$produto4->prod->cProd);
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertTotais($nfe)
    {
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


    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertFrete($nfe)
    {
        //transportadora
        $this->assertEquals('3', (string)$nfe->infNFe->transp->modFrete);
        $this->assertEquals('47269568000257', (string)$nfe->infNFe->transp->transporta->CNPJ);
        $this->assertEquals('CARRO PROPRIO -MUNIK', (string)$nfe->infNFe->transp->transporta->xNome);
        $this->assertEquals('111220540115', (string)$nfe->infNFe->transp->transporta->IE);
        $this->assertEquals('R CAITEZAL, 316', (string)$nfe->infNFe->transp->transporta->xEnder);
        $this->assertEquals('SAO PAULO', (string)$nfe->infNFe->transp->transporta->xMun);
        $this->assertEquals('SP', (string)$nfe->infNFe->transp->transporta->UF);

        //volumes
        $this->assertEquals('1', (string)$nfe->infNFe->transp->vol->qVol);
        $this->assertEquals('VOLUME', (string)$nfe->infNFe->transp->vol->esp);
        $this->assertEquals('MUNIK', (string)$nfe->infNFe->transp->vol->marca);
        $this->assertEquals('4.230', (string)$nfe->infNFe->transp->vol->pesoL);
        $this->assertEquals('4.230', (string)$nfe->infNFe->transp->vol->pesoB);
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertCobranca($nfe)
    {
        $this->assertEquals('502', (string)$nfe->infNFe->cobr->fat->nFat);
        $this->assertEquals('116.39', (string)$nfe->infNFe->cobr->fat->vOrig);
        $this->assertEquals('0.00', (string)$nfe->infNFe->cobr->fat->vDesc);
        $this->assertEquals('116.39', (string)$nfe->infNFe->cobr->fat->vLiq);

        $this->assertEquals('001', (string)$nfe->infNFe->cobr->dup->nDup);
        $this->assertEquals('2018-08-13', (string)$nfe->infNFe->cobr->dup->dVenc);
        $this->assertEquals('116.39', (string)$nfe->infNFe->cobr->dup->vDup);
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertPagamento($nfe)
    {
        $this->assertEquals('0', (string)$nfe->infNFe->pag->detPag->indPag);
        $this->assertEquals('01', (string)$nfe->infNFe->pag->detPag->tPag);
        $this->assertEquals('116.39', (string)$nfe->infNFe->pag->detPag->vPag);
    }

    /**
     * @param \SimpleXMLElement $nfe
     * @return void
     */
    protected function assertInfoAdicional($nfe)
    {
        $this->assertEquals(
            'BASE DO ICMS REDUZIDA EM 61,11 CF RICMS Pedido 000068',
            (string)$nfe->infNFe->infAdic->infCpl
        );
    }
}
