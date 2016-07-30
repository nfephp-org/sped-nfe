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
        $xml = dirname(__FILE__) . '/fixtures/NFe.xml';
        $expected = file_get_contents($xml);
        $this->assertEquals($expected, $anf[0]);
    }
    
    public function testTxt2xmlMulti()
    {
        $txt = dirname(__FILE__) . '/fixtures/Multinota.txt';
        $evt = new Convert();
        $anf = $evt->txt2xml($txt);
        $xml = dirname(__FILE__) . '/fixtures/NFe.xml';
        $expected = file_get_contents($xml);
        $this->assertEquals($expected, $anf[0]);
        $this->assertEquals($expected, $anf[1]);
    }
}
