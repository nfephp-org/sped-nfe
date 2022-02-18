<?php

namespace NFePHP\NFe\Tests\Factories;

use NFePHP\NFe\Factories\QRCode;
use NFePHP\NFe\Tests\NFeTestCase;

class QRCodeTest extends NFeTestCase
{
    /**
     * @covers \NFePHP\NFe\Factories\QRCode::get200
     * @covers \NFePHP\NFe\Factories\QRCode::str2Hex
     */
    // public function testPutQRTag()
    // {
    //     $dom = new \DOMDocument('1.0', 'UTF-8');
    //     $dom->formatOutput = false;
    //     $dom->preserveWhiteSpace = false;
    //     $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');

    //     $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
    //     $idToken = '000001';
    //     $sigla = '';
    //     $versao = '200';
    //     $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';

    //     $expected = file_get_contents($this->fixturesPath . 'xml/nfce_com_qrcode.xml');
    //     $expectedDom = new \DOMDocument('1.0', 'UTF-8');
    //     $expectedDom->formatOutput = false;
    //     $expectedDom->preserveWhiteSpace = false;
    //     $expectedDom->load($this->fixturesPath . 'xml/nfce_com_qrcode.xml');
    //     $expectedElement = $expectedDom->documentElement;

    //     $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
    //     $actualDom = new \DOMDocument('1.0', 'UTF-8');
    //     $actualDom->formatOutput = false;
    //     $actualDom->preserveWhiteSpace = false;
    //     $xml = $actualDom->loadXML($response);
    //     $actualElement = $actualDom->documentElement;
    //     $this->assertEqualXMLStructure($expectedElement, $actualElement);
    // }

    public function testPutQRTagFailWithoutCSC()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');
        $token = '';
        $idToken = '000001';
        $sigla = '';
        $versao = '200';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
    }

    public function testPutQRTagFailWithoutCSCid()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');
        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '';
        $sigla = '';
        $versao = '200';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
    }

    public function testPutQRTagFailWithoutURL()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');
        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '000001';
        $sigla = '';
        $versao = '200';
        $urlqr = '';
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr);
    }
}
