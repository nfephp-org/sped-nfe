<?php

namespace NFePHP\NFe\Tests\Auxiliar;

use NFePHP\NFe\Auxiliar\IdentifyNFe;
use NFePHP\Common\Dom\Dom;

class IdentifyNFeTest extends \PHPUnit_Framework_TestCase
{
    public $filepath;
    
    public function __construct()
    {
        $this->filepath = dirname(dirname(__FILE__)).'/fixtures/';
    }
    
    public function testIdentificarRetConsStatServ()
    {
        $file = $this->filepath.'retConsStatServ.xml';
        $xml = file_get_contents($file);
        $dom = new Dom('1.0', 'utf-8');
        $dom->loadXMLString($xml);
        $node = $dom->getElementsByTagName('retConsStatServ')->item(0);
        $aResp = array();
        $aExpc = [
            'Id' => 'retConsStatServ',
            'tag' => 'retConsStatServ',
            'dom' => $dom,
            'chave' => '',
            'tpAmb' => '',
            'dhEmi' => '',
            'versao' => 3.10,
            'xml' => $dom->saveXML($node)
        ];
        $scheme = IdentifyNFe::identificar($xml, $aResp);
        $this->assertEquals($aResp, $aExpc);
        $this->assertEquals('retConsStatServ', $scheme);
    }
    
    public function testIdentificarNFe()
    {
        $file = $this->filepath.'NFe.xml';
        $xml = file_get_contents($file);
        $dom = new Dom('1.0', 'utf-8');
        $dom->loadXMLString($xml);
        $node = $dom->getElementsByTagName('NFe')->item(0);
        $aResp = array();
        $aExpc = [
            'Id' => 'nfe',
            'tag' => 'NFe',
            'dom' => $dom,
            'chave' => '35151258716523000119550010000000011001800826',
            'tpAmb' => 2,
            'dhEmi' => '2015-12-17T11:39:00-02:00',
            'versao' => 3.10,
            'xml' => $dom->saveXML($node)
        ];        
        $scheme = IdentifyNFe::identificar($xml, $aResp);
        $this->assertEquals($aResp, $aExpc);
        $this->assertEquals('nfe', $scheme);
    }
}
