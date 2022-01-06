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
        $this->assertContains('143220000009921', $nfeProtocoled);
    }

    public function test_to_authorize_nfe_invalid_digest()
    {
        $this->expectException(DocumentsException::class);
        $request = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $response = file_get_contents(__DIR__ . '/fixtures/xml/retEnviNFe2.xml');
        Complements::toAuthorize($request, $response);
    }

    public function testToAuthorizeInut()
    {
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
