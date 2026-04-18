<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Tests\NFeTestCase;

class StandardizeTest extends NFeTestCase
{
    public function testWhichIs()
    {
        $st = new Standardize();
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $resp = $st->whichIs($xml);
        $this->assertEquals('NFe', $resp);
    }

    public function testWhichIsFailNotXMLSting()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $st = new Standardize();
        $st->whichIs('jslsj ks slk lk');
    }

    public function testWhichIsFailNotXMLNumber()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $st = new Standardize();
        //@phpstan-ignore-next-line
        $st->whichIs(100);
    }

    public function testWhichIsFailNotXMLSpace()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $st = new Standardize();
        $st->whichIs('  ');
    }

    public function testWhichIsFailNotXMLNull()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $st = new Standardize();
        $st->whichIs(null);
    }

    public function testWhichIsFailNotXMLEmptyString()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $st = new Standardize();
        $st->whichIs('');
    }

    public function testWhichIsFailNotBelongToNFe()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $st = new Standardize();
        $xml = file_get_contents($this->fixturesPath . 'xml/cte.xml');
        $st->whichIs($xml);
    }

    // public function testToNode()
    // {
    //     $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
    //     $st = new Standardize($xml);
    //     $expectedDom = new \DOMDocument('1.0', 'UTF-8');
    //     $expectedDom->formatOutput = false;
    //     $expectedDom->preserveWhiteSpace = false;
    //     $expectedDom->loadXML($xml);
    //     $expectedElement = $expectedDom->documentElement;
    //     $actualDom = new \DOMDocument('1.0', 'UTF-8');
    //     $actualDom->formatOutput = false;
    //     $actualDom->preserveWhiteSpace = false;
    //     $actualDom->loadXML("{$st}");
    //     $actualElement = $actualDom->documentElement;
    //     $this->assertEqualXMLStructure($expectedElement, $actualElement);
    // }

    public function testToJson()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $st = new Standardize($xml);
        $expected = file_get_contents($this->fixturesPath . 'txt/2017nova-nfe.json');
        // $this->assertEquals($expected, $st->toJson());
        $json = $st->toJson();
        $this->assertJsonStringEqualsJsonString($expected, $json);
    }

    public function testToArray()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $st = new Standardize($xml);
        $expected = json_decode(file_get_contents($this->fixturesPath . 'txt/2017nova-nfe.json'), true);
        $this->assertEquals($expected, $st->toArray());
    }

    public function testToStd()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/nfe_4.0.xml');
        $st = new Standardize($xml);
        $json = $st->toJson();
        $std = $st->toStd();
        $expected = json_decode(file_get_contents($this->fixturesPath . 'txt/nfe_4.0.json'));
        $this->assertEquals($expected, $std);
    }

    public function testToString()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $st = new Standardize($xml);
        $st->whichIs();
        $result = (string)$st;
        $this->assertNotEmpty($result);
        $this->assertStringContainsString('<NFe', $result);
    }

    public function testSimpleXml()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $st = new Standardize($xml);
        $sxml = $st->simpleXml();
        $this->assertInstanceOf(\SimpleXMLElement::class, $sxml);
    }

    public function testToStdWithXmlParameter()
    {
        $st = new Standardize();
        $xml = file_get_contents($this->fixturesPath . 'xml/nfe_4.0.xml');
        $std = $st->toStd($xml);
        $this->assertIsObject($std);
    }

    public function testToJsonWithXmlParameter()
    {
        $st = new Standardize();
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $json = $st->toJson($xml);
        $this->assertJson($json);
    }

    public function testToArrayWithXmlParameter()
    {
        $st = new Standardize();
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $arr = $st->toArray($xml);
        $this->assertIsArray($arr);
        $this->assertNotEmpty($arr);
    }

    public function testWhichIsWithConstructorXml()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/nfe_4.0.xml');
        $st = new Standardize($xml);
        $result = $st->whichIs();
        $this->assertTrue(in_array($result, $st->rootTagList));
    }

    public function testNfceXml()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/nfce.xml');
        $st = new Standardize($xml);
        $resp = $st->whichIs();
        // nfce.xml is a processed NFe (nfeProc)
        $this->assertNotEmpty($resp);
        $this->assertTrue(in_array($resp, $st->rootTagList));
    }

    public function testWhichIsDistDFeInt()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/exemplo_xml_dist_dfe.xml');
        $st = new Standardize();
        $resp = $st->whichIs($xml);
        $this->assertEquals('distDFeInt', $resp);
    }

    public function testWhichIsRetConsStatServ()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/retConsStatServ.xml');
        $st = new Standardize();
        $resp = $st->whichIs($xml);
        $this->assertEquals('retConsStatServ', $resp);
    }

    public function testWhichIsRetEnviNFe()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/retEnviNFe.xml');
        $st = new Standardize();
        $resp = $st->whichIs($xml);
        $this->assertEquals('retEnviNFe', $resp);
    }

    public function testToStdWithNfceQRCode()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/nfce.xml');
        $st = new Standardize($xml);
        $std = $st->toStd();
        $this->assertIsObject($std);
        // nfce.xml has infNFeSupl with qrCode
        if (isset($std->infNFeSupl)) {
            $this->assertNotEmpty($std->infNFeSupl->qrCode);
            $this->assertNotEmpty($std->infNFeSupl->urlChave);
        }
    }

    public function testWhichIsWithNfeResultMsgEmpty()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        $this->expectExceptionMessage('veio em BRANCO');
        $xml = '<?xml version="1.0" encoding="utf-8"?>'
            . '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">'
            . '<soap:Body><nfeResultMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeAutorizacao4"></nfeResultMsg>'
            . '</soap:Body></soap:Envelope>';
        $st = new Standardize();
        $st->whichIs($xml);
    }

    public function testWhichIsWithNfeResultMsgNonEmpty()
    {
        $this->expectException(\NFePHP\NFe\Exception\DocumentsException::class);
        // nfeResultMsg with content but no recognized root tag should throw "wrongDocument"
        $xml = '<?xml version="1.0" encoding="utf-8"?>'
            . '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope">'
            . '<soap:Body><nfeResultMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeAutorizacao4">'
            . '<unknownTag>test</unknownTag>'
            . '</nfeResultMsg></soap:Body></soap:Envelope>';
        $st = new Standardize();
        $st->whichIs($xml);
    }
}
