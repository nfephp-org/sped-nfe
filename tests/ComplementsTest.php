<?php

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Complements;
use NFePHP\NFe\Exception\DocumentsException;
use NFePHP\NFe\Tests\NFeTestCase;

class ComplementsTest extends NFeTestCase
{
    public function test_to_authorize_nfe_valid()
    {
        $request = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/retEnviNFe.xml');
        $nfeProtocoled = Complements::toAuthorize($request, $response);
        $this->assertStringContainsString('143220000009921', $nfeProtocoled);
    }

    public function test_to_authorize_nfe_invalid_digest()
    {
        $this->expectException(DocumentsException::class);
        $request = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/retEnviNFe2.xml');
        Complements::toAuthorize($request, $response);
    }

    public function test_to_authorize_inut_cpf(): void
    {
        $request = file_get_contents(__DIR__ . '/fixtures/xml/request_inut_cpf.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/response_inut_cpf.xml');
        $output = Complements::toAuthorize($request, $response);
        $dom = new \DOMDocument();
        $dom->loadXML($output);
        $tag = $dom->getElementsByTagName('ProcInutNFe')->item(0);
        $numeroProtocolo = $tag->getElementsByTagName('nProt')->item(0)->nodeValue;
        $this->assertEquals('151250011427132', $numeroProtocolo);
    }

    public function test_to_authorize_inut_cnpj(): void
    {
        $request = file_get_contents(__DIR__ . '/fixtures/xml/request_inut_cnpj.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/response_inut_cnpj.xml');
        $output = Complements::toAuthorize($request, $response);
        $dom = new \DOMDocument();
        $dom->loadXML($output);
        $tag = $dom->getElementsByTagName('ProcInutNFe')->item(0);
        $numeroProtocolo = $tag->getElementsByTagName('nProt')->item(0)->nodeValue;
        $this->assertEquals('152250025831513', $numeroProtocolo);
    }

    public function testToAuthorizeEvent()
    {
    }

    public function testToAuthorizeFailWrongDocument()
    {
    }

    public function testToAuthorizeFailNotXML()
    {
    }

    public function testToAuthorizeFailWrongNode()
    {
    }

    public function testCancelRegister()
    {
    }

    public function testCancelRegisterFailNotNFe()
    {
    }

    public function testB2B()
    {
    }

    public function testB2BFailNotNFe()
    {
    }

    public function testB2BFailWrongNode()
    {
    }
}

