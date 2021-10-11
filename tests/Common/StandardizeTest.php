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
        //@phpstan-ignore-next-line
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

    public function testToNode()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $st = new Standardize($xml);
        $expectedDom = new \DOMDocument('1.0', 'UTF-8');
        $expectedDom->formatOutput = false;
        $expectedDom->preserveWhiteSpace = false;
        $expectedDom->loadXML($xml);
        $expectedElement = $expectedDom->documentElement;
        $actualDom = new \DOMDocument('1.0', 'UTF-8');
        $actualDom->formatOutput = false;
        $actualDom->preserveWhiteSpace = false;
        $actualDom->loadXML("{$st}");
        $actualElement = $actualDom->documentElement;
        $this->assertEqualXMLStructure($expectedElement, $actualElement);
    }

    public function testToJson()
    {
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $st = new Standardize($xml);
        $expected = file_get_contents($this->fixturesPath . 'txt/2017nova-nfe.json');
        $this->assertEquals($expected, $st->toJson());
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
        $xml = file_get_contents($this->fixturesPath . 'xml/2017nfe_antiga_v310.xml');
        $st = new Standardize($xml);
        $expected = json_decode(file_get_contents($this->fixturesPath . 'txt/2017nova-nfe.json'));
        $this->assertEquals($expected, $st->toStd());
    }
}
