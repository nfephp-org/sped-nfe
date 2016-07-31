<?php

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Convert;

class ConvertTest extends \PHPUnit_Framework_TestCase
{
    public function testInstantiable()
    {
        $evt = new Convert();
        $this->assertInstanceOf(Convert::class, $evt);
    }
    
    public function testTxt2xml()
    {
        $txt = dirname(__FILE__) . '/fixtures/NFe.txt';
        $evt = new Convert();
        $anf = $evt->txt2xml($txt);
        $dom = new \DOMDocument();
        $dom->loadXML($anf[0]);
        $actualElement = $dom->getElementsByTagName('NFe')->item(0);
        $xml = dirname(__FILE__) . '/fixtures/NFe.xml';
        $dom1 = new \DOMDocument();
        $dom1->load($xml);
        $expectedElement = $dom1->getElementsByTagName('NFe')->item(0);
        $this->assertEqualXMLStructure($expectedElement, $actualElement);
    }
    
    public function testTxt2xmlMulti()
    {
        $txt = dirname(__FILE__) . '/fixtures/Multinota.txt';
        $evt = new Convert();
        $anf = $evt->txt2xml($txt);
        
        $dom0 = new \DOMDocument();
        $dom0->loadXML($anf[0]);
        $actualElement0 = $dom0->getElementsByTagName('NFe')->item(0);
        
        $dom1 = new \DOMDocument();
        $dom1->loadXML($anf[1]);
        $actualElement1 = $dom1->getElementsByTagName('NFe')->item(0);
        
        
        $xml = dirname(__FILE__) . '/fixtures/NFe.xml';
        $dom2 = new \DOMDocument();
        $dom2->load($xml);
        $expectedElement = $dom2->getElementsByTagName('NFe')->item(0);
        
        $this->assertEqualXMLStructure($expectedElement, $actualElement0);
        $this->assertEqualXMLStructure($expectedElement, $actualElement1);
    }
}
