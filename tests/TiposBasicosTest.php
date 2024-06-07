<?php

namespace NFePHP\NFe\Tests;

use PHPUnit\Framework\TestCase;

class TiposBasicosTest extends TestCase
{
    public function test_TString(): void
    {
        if (PHP_VERSION_ID < 80100) {
            $this->markTestSkipped('Versão muito baixa do PHP para o teste');
        }

        $doc = new \DOMDocument();
        $xsdstring = file_get_contents(dirname(__DIR__) . '/schemes/PL_009_V4/tiposBasico_v4.00.xsd');
        $doc->loadXML(mb_convert_encoding($xsdstring, 'utf-8', mb_detect_encoding($xsdstring)));
        $xpath = new \DOMXPath($doc);
        $xpath->registerNamespace('xs', 'http://www.w3.org/2001/XMLSchema');

        $item = $xpath->query('xs:simpleType[@name="TString"]/xs:restriction/xs:pattern')->item(0);
        $this->assertNotNull($item, 'Não foi encontrado o simpleType TString');
        /** @var \DOMNamedNodeMap $atributos */
        $atributos = $item->attributes;

        /** @var \DOMAttr $node */
        $node = $atributos->getNamedItem('value');

        $this->assertEquals(
            '[!-ÿ]{1}[ -ÿ]*[!-ÿ]{1}|[!-ÿ]{1}',
            $node->value,
            'Por favor, corrija o pattern no arquivo tiposBasico_v4.00.xsd. Issue #940'
        );
    }
}
