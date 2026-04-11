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
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, '', $this->certificate);
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
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, '', $this->certificate);;
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
        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, '', $this->certificate);;;
    }

    public function testPutQRTagVersao200_offline()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');
        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '000001';
        $versao = '200';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $urichave = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaPublica.aspx';

        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, $urichave, $this->certificate);

        $this->assertNotEmpty($response);
        $resultDom = new \DOMDocument('1.0', 'UTF-8');
        $resultDom->loadXML($response);
        $qrCode = $resultDom->getElementsByTagName('qrCode')->item(0);
        $this->assertNotNull($qrCode);
        $this->assertStringContainsString('?p=', $qrCode->nodeValue);
        $urlChave = $resultDom->getElementsByTagName('urlChave')->item(0);
        $this->assertNotNull($urlChave);
    }

    public function testPutQRTagVersao200_online()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');

        // Change tpEmis to 1 (online)
        $ide = $dom->getElementsByTagName('ide')->item(0);
        $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue = '1';
        // Remove contingency fields
        $dhCont = $ide->getElementsByTagName('dhCont')->item(0);
        if ($dhCont) {
            $ide->removeChild($dhCont);
        }
        $xJust = $ide->getElementsByTagName('xJust')->item(0);
        if ($xJust) {
            $ide->removeChild($xJust);
        }

        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '000001';
        $versao = '200';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $urichave = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaPublica.aspx';

        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, $urichave, $this->certificate);

        $this->assertNotEmpty($response);
        $resultDom = new \DOMDocument('1.0', 'UTF-8');
        $resultDom->loadXML($response);
        $qrCode = $resultDom->getElementsByTagName('qrCode')->item(0);
        $this->assertNotNull($qrCode);
        // Online mode should not contain day/value info
        $this->assertStringContainsString('?p=', $qrCode->nodeValue);
    }

    public function testPutQRTagVersao300_online()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');

        // Change tpEmis to 1 (online)
        $ide = $dom->getElementsByTagName('ide')->item(0);
        $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue = '1';
        $dhCont = $ide->getElementsByTagName('dhCont')->item(0);
        if ($dhCont) {
            $ide->removeChild($dhCont);
        }
        $xJust = $ide->getElementsByTagName('xJust')->item(0);
        if ($xJust) {
            $ide->removeChild($xJust);
        }

        $token = '';
        $idToken = '';
        $versao = '300';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $urichave = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaPublica.aspx';

        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, $urichave, $this->certificate);

        $this->assertNotEmpty($response);
        $resultDom = new \DOMDocument('1.0', 'UTF-8');
        $resultDom->loadXML($response);
        $qrCode = $resultDom->getElementsByTagName('qrCode')->item(0);
        $this->assertNotNull($qrCode);
        // v3 online: chave|3|tpAmb
        $this->assertStringContainsString('|3|', $qrCode->nodeValue);
    }

    public function testPutQRTagVersao300_offline()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');

        $token = '';
        $idToken = '';
        $versao = '300';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $urichave = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaPublica.aspx';

        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, $urichave, $this->certificate);

        $this->assertNotEmpty($response);
        $resultDom = new \DOMDocument('1.0', 'UTF-8');
        $resultDom->loadXML($response);
        $qrCode = $resultDom->getElementsByTagName('qrCode')->item(0);
        $this->assertNotNull($qrCode);
        // v3 offline has signature
        $this->assertStringContainsString('|3|', $qrCode->nodeValue);
    }

    public function testPutQRTagVersaoEmpty_defaults_to_200()
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->load($this->fixturesPath . 'xml/nfce_sem_qrcode.xml');

        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '000001';
        $versao = '';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $urichave = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaPublica.aspx';

        $response = QRCode::putQRTag($dom, $token, $idToken, $versao, $urlqr, $urichave, $this->certificate);

        $this->assertNotEmpty($response);
        $resultDom = new \DOMDocument('1.0', 'UTF-8');
        $resultDom->loadXML($response);
        $qrCode = $resultDom->getElementsByTagName('qrCode')->item(0);
        $this->assertNotNull($qrCode);
    }
}
