<?php
namespace NFePHP\NFe\Tests;

use NFePHP\Common\Files\FilesFolders;
use NFePHP\NFe\Tools;
use PHPUnit_Framework_TestCase;


class ToolsTest extends PHPUnit_Framework_TestCase {

    private $xmlFilepath;
    private $xmlContent;

    public function testDeveRetornarArrayVazioSeXmlForValido() {
        $retorno = Tools::validarXmlNfe($this->xmlContent, Tools::$PL_008i2);
        $this->assertInternalType('array', $retorno);
        $this->assertEmpty($retorno);
    }

    public function testDeveRetornarArrayComErrosDeValidacaoSeXmlForInvalido() {
        $invalidXmlContent = str_replace('<cDV>0</cDV>', '', $this->xmlContent);
        $retorno = Tools::validarXmlNfe($invalidXmlContent, Tools::$PL_008i2);
        $this->assertInternalType('array', $retorno);
        $this->assertNotEmpty($retorno);
    }

    protected function setUp() {
        parent::setUp();
        $this->xmlFilepath = implode(DIRECTORY_SEPARATOR, [__DIR__, 'fixtures', 'nfe_v310.xml']);
        $this->xmlContent = FilesFolders::readFile($this->xmlFilepath);
    }

    protected function tearDown() {
        parent::tearDown();
        unset($this->xmlFilepath, $this->xmlContent);
    }

}
