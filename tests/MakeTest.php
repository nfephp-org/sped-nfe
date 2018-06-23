<?php

namespace NFePHP\NFe\Tests;

use NFePHP\NFe\Make;
use PHPUnit\Framework\TestCase;

class MakeTest extends TestCase
{
    protected $make;

    public function testTaginfNFe()
    {
        $std = new \stdClass();
        $std->Id = '0123456789';
        $std->versao = '4.00';

        $infNFe = $this->make->taginfNFe($std);

        $this->assertInstanceOf(\DOMElement::class, $infNFe);
        $this->assertEquals('NFe' . $std->Id, $infNFe->getAttribute('Id'));
        $this->assertEquals($std->versao, $infNFe->getAttribute('versao'));
        $this->assertEmpty($infNFe->getAttribute('pk_nItem'));
    }

    public function testTaginfNFeComPkNItem()
    {
        $std = new \stdClass();
        $std->Id = '0123456789';
        $std->versao = '3.10';
        $std->pk_nItem = '1';

        $infNFe = $this->make->taginfNFe($std);

        $this->assertInstanceOf(\DOMElement::class, $infNFe);
        $this->assertEquals('NFe' . $std->Id, $infNFe->getAttribute('Id'));
        $this->assertEquals($std->versao, $infNFe->getAttribute('versao'));
        $this->assertEquals($std->pk_nItem, $infNFe->getAttribute('pk_nItem'));
    }

    protected function setUp()
    {
        $this->make = new Make();
    }
}
