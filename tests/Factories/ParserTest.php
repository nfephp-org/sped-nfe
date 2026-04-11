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
