<?php

namespace NFePHP\NFe\Tests\Factories;

use NFePHP\NFe\Factories\Contingency;
use NFePHP\NFe\Factories\ContingencyNFe;
use NFePHP\NFe\Tests\NFeTestCase;
class ContingencyNFeTest extends NFeTestCase
{
    public function testAdjustSuccess()
    {
        $cont = new Contingency();
        $json = $cont->activate('RS', 'Teste de uso da classe em contingência');
        $xml = file_get_contents(__DIR__ . '/../fixtures/xml/nfe_layout4.xml');
        $newxml = ContingencyNFe::adjust($xml, $cont);
    }

    public function testAdjustNFeContingencyReady()
    {
        $cont = new Contingency();
        $json = $cont->activate('RS', 'Teste contingência SVCAN');
        $xml = file_get_contents(__DIR__ . '/../fixtures/xml/nfe_layout4_contingencia_sem_assinatura.xml');
        $newxml = ContingencyNFe::adjust($xml, $cont);
        $dom = new \DOMDocument();
        $dom->loadXML($newxml);
        //não deve haver alteração no xml, principalmente nesses 3 campos
        $tpEmis = (string) $dom->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $dhCont = (string) $dom->getElementsByTagName('dhCont')->item(0)->nodeValue;
        $xJust = (string) $dom->getElementsByTagName('xJust')->item(0)->nodeValue;
        $this->assertEquals($tpEmis, '6');
        $this->assertEquals($dhCont, '2024-06-11T23:30:41-03:00');
        $this->assertEquals($xJust, 'Teste de uso da classe em contingência');
    }

    public function testAdjustFailNFCe()
    {
        $this->expectException(\RuntimeException::class);
        $cont = new Contingency();
        $json = $cont->activate('RS', 'Teste de uso da classe em contingência');
        $xml = file_get_contents(__DIR__ . '/../fixtures/xml/nfce.xml');
        $newxml = ContingencyNFe::adjust($xml, $cont);
    }


}
