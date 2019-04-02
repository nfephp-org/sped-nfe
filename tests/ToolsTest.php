<?php

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Tools;

class ToolsTest extends NFeTestCase
{
    use URIConsultaNfce;
    /**
     * @var Tools
     */
    protected $tools;

    protected function setUp()
    {
        $this->tools = new Tools(
            $this->configJson,
            Certificate::readPfx($this->contentpfx, $this->passwordpfx)
        );
    }

    /**
     * Testa a consulta pelo número do recibo validando o parâmetro vazio.
     */
    public function testSefazConsultaReciboThrowsInvalidArgExceptionSemRecibo()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaRecibo('');
    }

    /**
     * Testa a consulta pela chave validando o parâmetro da chave vazio.
     */
    public function testSefazConsultaChaveThrowsInvalidArgExceptionSemChave()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('');
    }

    /**
     * Testa a consulta pela chave validando o parâmetro de chave incompleta (comprimento diferente de 44 digitos).
     */
    public function testSefazConsultaChaveThrowsInvalidArgExceptionChaveCompleta()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('1234567890123456789012345678901234567890123'); // 43 digitos
    }

    /**
     * Testa a consulta pela chave validando uma chave alfanumérica.
     */
    public function testSefazConsultaChaveThrowsInvalidArgExceptionChaveNaoNumerica()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('aqui temos uma chave nao numerica');
    }

    /**
     * @dataProvider \NFePHP\NFe\Tests\ToolsTest::ufProvider
     * @param string $uf
     * @throws \ReflectionException
     */
    public function testReturnURIConsultaNFCeInHomologation(string $uf)
    {
        $class = new \ReflectionClass(Tools::class);
        $object = $class->newInstanceWithoutConstructor();
        $object->pathwsfiles = realpath(__DIR__ . '/../storage') . '/';

        $method = new \ReflectionMethod(Tools::class, 'getURIConsultaNFCe');
        $method->setAccessible(true);
        $result = $method->invokeArgs($object, [$uf, '2']);
        $this->assertEquals(self::getUri('2', $uf), $result);
    }

    /**
     * @dataProvider \NFePHP\NFe\Tests\ToolsTest::ufProvider
     * @param string $uf
     * @throws \ReflectionException
     */
    public function testReturnURIConsultaNFCeInProduction(string $uf)
    {
        $class = new \ReflectionClass(Tools::class);
        $object = $class->newInstanceWithoutConstructor();
        $object->pathwsfiles = realpath(
            __DIR__ . '/../storage'
        ) . '/';

        $method = new \ReflectionMethod(Tools::class, 'getURIConsultaNFCe');
        $method->setAccessible(true);
        $result = $method->invokeArgs($object, [$uf, '1']);
        $this->assertEquals(self::getUri('1', $uf), $result);
    }

    public function ufProvider()
    {
        return [
            ["AC"],
            ["AL"],
            ["AP"],
            ["AM"],
            ["BA"],
            ["CE"],
            ["DF"],
            ["ES"],
            ["GO"],
            ["MA"],
            ["MG"],
            ["MS"],
            ["MT"],
            ["PA"],
            ["PB"],
            ["PE"],
            ["PR"],
            ["PI"],
            ["RJ"],
            ["RN"],
            ["RO"],
            ["RR"],
            ["RS"],
            ["SE"],
            ["SC"],
            ["SP"],
            ["TO"],
        ];
    }
}
