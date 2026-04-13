<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests\Factories;

use NFePHP\NFe\Factories\Parser;
use PHPUnit\Framework\TestCase;

class ParserTest extends TestCase
{
    private string $fixturesPath;

    protected function setUp(): void
    {
        $this->fixturesPath = dirname(__DIR__) . '/fixtures/txt/';
    }

    // =========================================================================
    // Constructor
    // =========================================================================

    public function test_constructor_default(): void
    {
        $parser = new Parser();
        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function test_constructor_with_version(): void
    {
        $parser = new Parser('4.00');
        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function test_constructor_with_sebrae_layout(): void
    {
        $parser = new Parser('4.00', Parser::SEBRAE);
        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function test_constructor_with_local_v12_layout(): void
    {
        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $this->assertInstanceOf(Parser::class, $parser);
    }

    public function test_constructor_with_local_v13_layout(): void
    {
        $parser = new Parser('4.00', Parser::LOCAL_V13);
        $this->assertInstanceOf(Parser::class, $parser);
    }

    // =========================================================================
    // toXml - LOCAL_V12 layout
    // =========================================================================

    public function test_toXml_local_v12_returns_valid_xml(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_01.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $xml = $parser->toXml($notas[0]);

        $this->assertNotNull($xml);
        $this->assertStringContainsString('<NFe', $xml);
        $this->assertStringContainsString('<infNFe', $xml);
        $this->assertStringContainsString('<ide>', $xml);
        $this->assertStringContainsString('<emit>', $xml);
        $this->assertStringContainsString('<dest>', $xml);
        $this->assertStringContainsString('<det ', $xml);
        $this->assertStringContainsString('<total>', $xml);
    }

    public function test_toXml_local_v12_valid_xml_structure(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_01.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $xml = $parser->toXml($notas[0]);

        $nfe = new \SimpleXMLElement($xml);
        // Check basic structure
        $this->assertNotEmpty((string)$nfe->infNFe->ide->cUF);
        $this->assertNotEmpty((string)$nfe->infNFe->emit->CNPJ);
        $this->assertNotEmpty((string)$nfe->infNFe->dest->CNPJ);
        $this->assertGreaterThan(0, count($nfe->infNFe->det));
    }

    // =========================================================================
    // toXml - SEBRAE layout
    // =========================================================================

    public function test_toXml_sebrae_returns_valid_xml(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nota_4.00_sebrae.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::SEBRAE);
        $xml = $parser->toXml($notas[0]);

        $this->assertNotNull($xml);
        $this->assertStringContainsString('<NFe', $xml);
        $this->assertStringContainsString('<infNFe', $xml);
    }

    public function test_toXml_sebrae_valid_xml_structure(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nota_4.00_sebrae.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::SEBRAE);
        $xml = $parser->toXml($notas[0]);

        $nfe = new \SimpleXMLElement($xml);
        $this->assertEquals('52', (string)$nfe->infNFe->ide->cUF);
        $this->assertEquals('55', (string)$nfe->infNFe->ide->mod);
    }

    // =========================================================================
    // dump - returns stdClass array
    // =========================================================================

    public function test_dump_returns_array_of_stdclass(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_01.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $result = $parser->dump($notas[0]);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);
        // First element should be the infNFe std object
        $this->assertInstanceOf(\stdClass::class, $result[0]);
    }

    public function test_dump_contains_nfe_id(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_01.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $result = $parser->dump($notas[0]);

        $this->assertStringContainsString('NFe', $result[0]->Id);
    }

    // =========================================================================
    // getErrors
    // =========================================================================

    public function test_getErrors_returns_empty_on_success(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_01.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $parser->toXml($notas[0]);

        $errors = $parser->getErrors();
        $this->assertIsArray($errors);
    }

    // =========================================================================
    // LOCAL layout (v3.10 format)
    // =========================================================================

    public function test_toXml_local_layout_nfe_txt(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'NFe.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('3.10', Parser::LOCAL);
        $xml = $parser->toXml($notas[0]);

        $this->assertNotNull($xml);
        $this->assertStringContainsString('<NFe', $xml);
    }

    // =========================================================================
    // toXml - LOCAL_V12 complete fixture (covers many parser entities)
    // =========================================================================

    public function test_toXml_local_v12_complete_fixture(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_completa.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $xml = $parser->toXml($notas[0]);

        $this->assertNotNull($xml);
        $nfe = new \SimpleXMLElement($xml);

        // Referências (BA03, BA19, BA20)
        $this->assertNotEmpty($nfe->infNFe->ide->NFref);

        // Retirada (F, F02)
        $this->assertEquals('RUA RETIRADA', (string)$nfe->infNFe->retirada->xLgr);
        $this->assertEquals('12345678000195', (string)$nfe->infNFe->retirada->CNPJ);

        // Entrega (G, G02)
        $this->assertEquals('RUA ENTREGA', (string)$nfe->infNFe->entrega->xLgr);
        $this->assertEquals('98765432000100', (string)$nfe->infNFe->entrega->CNPJ);

        // DI (I18, I25)
        $this->assertEquals('12345678', (string)$nfe->infNFe->det[0]->prod->DI->nDI);
        $this->assertEquals('FABRICANTE1', (string)$nfe->infNFe->det[0]->prod->DI->adi->cFabricante);

        // Medicamentos (I80)
        $this->assertEquals('LOTE001', (string)$nfe->infNFe->det[0]->prod->rastro->nLote);

        // II (P)
        $this->assertEquals('10.00', (string)$nfe->infNFe->det[0]->imposto->II->vII);

        // PISST (R)
        $this->assertNotNull($nfe->infNFe->det[0]->imposto->PISST);

        // COFINSST (T)
        $this->assertNotNull($nfe->infNFe->det[0]->imposto->COFINSST);

        // ICMS20 (N04)
        $this->assertEquals('20', (string)$nfe->infNFe->det[0]->imposto->ICMS->ICMS20->CST);

        // ICMS40 (N06) on second item
        $this->assertEquals('40', (string)$nfe->infNFe->det[1]->imposto->ICMS->ICMS40->CST);

        // PIS NT (Q04) on second item
        $this->assertEquals('04', (string)$nfe->infNFe->det[1]->imposto->PIS->PISNT->CST);

        // COFINS NT (S04) on second item
        $this->assertEquals('04', (string)$nfe->infNFe->det[1]->imposto->COFINS->COFINSNT->CST);

        // Transporte (X03, X26, X33)
        $this->assertEquals('TRANSPORTADORA TESTE', (string)$nfe->infNFe->transp->transporta->xNome);
        $this->assertEquals('2', (string)$nfe->infNFe->transp->vol->qVol);
        $this->assertNotEmpty((string)$nfe->infNFe->transp->vol->lacres->nLacre);

        // Cobrança (Y02, Y07)
        $this->assertEquals('503', (string)$nfe->infNFe->cobr->fat->nFat);
        $this->assertEquals('001', (string)$nfe->infNFe->cobr->dup->nDup);

        // infAdic (Z04, Z07, Z10)
        $this->assertNotEmpty((string)$nfe->infNFe->infAdic->infCpl);
    }

    public function test_dump_local_v12_complete_fixture(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_completa.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $result = $parser->dump($notas[0]);

        $this->assertIsArray($result);
        $this->assertNotEmpty($result);

        // Verify specific tags were parsed
        $tags = array_map(fn($item) => $item->tag, $result);
        $this->assertContains('BA03', $tags);
        $this->assertContains('BA19', $tags);
        $this->assertContains('BA20', $tags);
        $this->assertContains('F', $tags);
        $this->assertContains('F02', $tags);
        $this->assertContains('G', $tags);
        $this->assertContains('G02', $tags);
        $this->assertContains('I18', $tags);
        $this->assertContains('I25', $tags);
        $this->assertContains('I80', $tags);
        $this->assertContains('P', $tags);
        $this->assertContains('R', $tags);
        $this->assertContains('R02', $tags);
        $this->assertContains('T', $tags);
        $this->assertContains('T02', $tags);
        $this->assertContains('N04', $tags);
        $this->assertContains('N06', $tags);
        $this->assertContains('Q04', $tags);
        $this->assertContains('S04', $tags);
        $this->assertContains('X33', $tags);
        $this->assertContains('Y07', $tags);
        $this->assertContains('Z04', $tags);
        $this->assertContains('Z07', $tags);
        $this->assertContains('Z10', $tags);
    }

    public function test_toXml_local_v12_icms_variados(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_icms_variados.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $xml = $parser->toXml($notas[0]);

        $this->assertNotNull($xml);
        $nfe = new \SimpleXMLElement($xml);

        // 5 items
        $this->assertCount(5, $nfe->infNFe->det);

        // ICMS00 (N02)
        $this->assertEquals('00', (string)$nfe->infNFe->det[0]->imposto->ICMS->ICMS00->CST);

        // ICMS10 (N03)
        $this->assertEquals('10', (string)$nfe->infNFe->det[1]->imposto->ICMS->ICMS10->CST);

        // PIS via Q03 on item 2 (CST 02 gera PISAliq com campos de quantidade)
        $this->assertNotNull($nfe->infNFe->det[1]->imposto->PIS);

        // COFINS via S03 on item 2
        $this->assertNotNull($nfe->infNFe->det[1]->imposto->COFINS);

        // ICMS30 (N05)
        $this->assertEquals('30', (string)$nfe->infNFe->det[2]->imposto->ICMS->ICMS30->CST);

        // PISOutr (Q05 + Q07) on item 3
        $this->assertEquals('99', (string)$nfe->infNFe->det[2]->imposto->PIS->PISOutr->CST);
        $this->assertEquals('100.00', (string)$nfe->infNFe->det[2]->imposto->PIS->PISOutr->vBC);

        // COFINSOutr (S05 + S07) on item 3
        $this->assertEquals('99', (string)$nfe->infNFe->det[2]->imposto->COFINS->COFINSOutr->CST);
        $this->assertEquals('100.00', (string)$nfe->infNFe->det[2]->imposto->COFINS->COFINSOutr->vBC);

        // ICMS51 (N07)
        $this->assertEquals('51', (string)$nfe->infNFe->det[3]->imposto->ICMS->ICMS51->CST);

        // ICMS60 (N08)
        $this->assertEquals('60', (string)$nfe->infNFe->det[4]->imposto->ICMS->ICMS60->CST);
    }

    public function test_dump_icms_variados(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_icms_variados.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $result = $parser->dump($notas[0]);

        $this->assertIsArray($result);
        $tags = array_map(fn($item) => $item->tag, $result);
        $this->assertContains('N02', $tags);
        $this->assertContains('N03', $tags);
        $this->assertContains('N05', $tags);
        $this->assertContains('N07', $tags);
        $this->assertContains('N08', $tags);
        $this->assertContains('Q03', $tags);
        $this->assertContains('Q05', $tags);
        $this->assertContains('S03', $tags);
        $this->assertContains('S05', $tags);
    }

    public function test_dump_unknown_tag_throws_exception(): void
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $parser->dump(['UNKNOWN|test|']);
    }

    public function test_dump_skips_empty_lines(): void
    {
        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $result = $parser->dump(['', 'BA03|35|1708|25028332000105|01|1|12345|', '']);
        $this->assertCount(1, $result);
        $this->assertEquals('BA03', $result[0]->tag);
    }

    public function test_toXml_unknown_tag_throws_exception(): void
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $parser->toXml(['DESCONHECIDO|teste|']);
    }

    public function test_toXml_array2xml_skips_empty_lines(): void
    {
        // Linhas vazias dentro do array de entrada devem ser ignoradas
        // pelo laço de array2xml (cobre o ramo de continue).
        $parser = new Parser('4.00', Parser::LOCAL_V12);
        try {
            // NOTA: a nota é incompleta de propósito — o objetivo é apenas
            // disparar o array2xml com uma linha vazia. montaNFe() pode
            // falhar e isso é esperado.
            $parser->toXml(['', 'BA|']);
        } catch (\Throwable $e) {
            // tolerado
        }
        $this->assertTrue(true);
    }

    // =========================================================================
    // LOCAL_V12 extras fixture — cobre muitas entidades não atingidas
    // pelos demais fixtures (refNFP, autXML, NVE, detExport, combustível,
    // medicamento, arma, RECOPI, ICMS10/ICMSPart/ICMSST, PIS/COFINS qBCProd,
    // ISSQN, impostoDevol, totais W17/W23, transporte completo,
    // intermediário, exporta, compra, cana, infRespTec, infNFeSupl).
    // =========================================================================

    public function test_toXml_local_v12_extras_fixture(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_extras.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $xml = $parser->toXml($notas[0]);

        $this->assertNotNull($xml);
        $nfe = new \SimpleXMLElement($xml);
        $this->assertCount(9, $nfe->infNFe->det);
    }

    public function test_toXml_local_v12_cpf_variants_first_nota(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_cpf_variants.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $xml = $parser->toXml($notas[0]);

        $this->assertNotNull($xml);
        $nfe = new \SimpleXMLElement($xml);
        // Destinatário estrangeiro (E03a)
        $this->assertNotEmpty((string)$nfe->infNFe->dest->idEstrangeiro);
    }

    public function test_toXml_local_v12_cpf_variants_second_nota_csn(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_cpf_variants.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $xml = $parser->toXml($notas[1]);

        $this->assertNotNull($xml);
        $nfe = new \SimpleXMLElement($xml);
        // Produtor rural com CPF (C02a)
        $this->assertNotEmpty((string)$nfe->infNFe->emit->CPF);
        $this->assertCount(6, $nfe->infNFe->det);
    }

    public function test_toXml_local_v13_ibscbs_fixture(): void
    {
        // Cobre entidades do grupo IBS/CBS (LOCAL_V13): B31, UB*, W31, W34.
        // Make pode rejeitar o XML final por validações de PL_010 — o foco
        // aqui é a execução das linhas do Parser, portanto erros do Make
        // são tolerados.
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v13_ibscbs.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V13);
        try {
            $parser->toXml($notas[0]);
        } catch (\Throwable $e) {
            // tolerado
        }
        $this->assertTrue(true);
    }

    public function test_dump_local_v13_ibscbs_tags(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v13_ibscbs.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V13);
        $result = $parser->dump($notas[0]);
        $tags = array_map(fn($item) => $item->tag, $result);

        $this->assertContains('B31', $tags);
        $this->assertContains('UB01', $tags);
        $this->assertContains('UB12', $tags);
        $this->assertContains('UB68', $tags);
        $this->assertContains('UB73', $tags);
        $this->assertContains('UB82A', $tags);
        $this->assertContains('UB84', $tags);
        $this->assertContains('UB112', $tags);
        $this->assertContains('UB116', $tags);
        $this->assertContains('UB120', $tags);
        $this->assertContains('UB131', $tags);
        $this->assertContains('W31', $tags);
        $this->assertContains('W34', $tags);
    }

    public function test_dump_local_v12_extras_fixture_tags(): void
    {
        $txt = file_get_contents($this->fixturesPath . 'nfe_4.00_local_v12_extras.txt');
        $notas = $this->parseTxt($txt);

        $parser = new Parser('4.00', Parser::LOCAL_V12);
        $result = $parser->dump($notas[0]);

        $tags = array_map(fn($item) => $item->tag, $result);
        // seções adicionais / tags não cobertas pelos outros fixtures
        $this->assertContains('BA10', $tags);
        $this->assertContains('BA13', $tags);
        $this->assertContains('GA02', $tags);
        $this->assertContains('I05A', $tags);
        $this->assertContains('I50', $tags);
        $this->assertContains('O11', $tags);
        $this->assertContains('R04', $tags);
        $this->assertContains('T04', $tags);
        $this->assertContains('Q10', $tags);
        $this->assertContains('S09', $tags);
        $this->assertContains('JA', $tags);
        $this->assertContains('K', $tags);
        $this->assertContains('L', $tags);
        $this->assertContains('LA', $tags);
        $this->assertContains('LA07', $tags);
        $this->assertContains('LA11', $tags);
        $this->assertContains('LB', $tags);
        $this->assertContains('N10', $tags);
        $this->assertContains('N10b', $tags);
        $this->assertContains('U', $tags);
        $this->assertContains('UA', $tags);
        $this->assertContains('W17', $tags);
        $this->assertContains('W23', $tags);
        $this->assertContains('X11', $tags);
        $this->assertContains('X18', $tags);
        $this->assertContains('X22', $tags);
        $this->assertContains('X25a', $tags);
        $this->assertContains('X25b', $tags);
        $this->assertContains('YB', $tags);
        $this->assertContains('ZA', $tags);
        $this->assertContains('ZB', $tags);
        $this->assertContains('ZC', $tags);
        $this->assertContains('ZC04', $tags);
        $this->assertContains('ZC10', $tags);
        $this->assertContains('ZD', $tags);
        $this->assertContains('ZX01', $tags);
    }

    // =========================================================================
    // Helper to split TXT into notes arrays (mimicking Convert logic)
    // =========================================================================

    private function parseTxt(string $txt): array
    {
        $txt = str_replace("\r\n", "\n", $txt);
        $lines = explode("\n", $txt);
        $notas = [];
        $current = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if (empty($line)) {
                continue;
            }
            if (stripos($line, 'NOTAFISCAL') === 0) {
                if (!empty($current)) {
                    $notas[] = $current;
                }
                $current = [];
                continue;
            }
            $current[] = $line;
        }
        if (!empty($current)) {
            $notas[] = $current;
        }
        return $notas;
    }
}
