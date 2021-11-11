<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Tests\Common\ToolsFake;
use NFePHP\NFe\Tools;

class ToolsTest extends NFeTestCase
{
    use URIConsultaNfce;

    /**
     * @var \NFePHP\NFe\Tests\Common\ToolsFake
     */
    protected $tools;

    protected function setUp()
    {
        $this->tools = new ToolsFake(
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

    /**
     * @return void
     */
    public function test_sefaz_envia_lote_parametro_invalido()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazEnviaLote(""); //@phpstan-ignore-line
    }

    /**
     * @return void
     */
    public function test_sefaz_envia_lote_xml_valido_modelo_65()
    {
        $xml = $this->getXml(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_65.xml');
        $responseBody = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml');
        $this->tools->getSoap()->setReturnValue($responseBody);
        $this->tools->model(65);
        $idLote = 1636667815;
        $request = '<nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeAutorizacao4"><enviNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00"><idLote>'. $idLote .'</idLote><indSinc>1</indSinc>'. $xml .'</enviNFe></nfeDadosMsg>';
        $resposta = $this->tools->sefazEnviaLote([$xml], (string)$idLote, 1);
        $params = $this->tools->getSoap()->getSendParams();
        $this->assertEquals(str_replace("\n", "", $request), str_replace("\n", "", $params['request']));
        $standard = new Standardize($resposta);
        $std = $standard->toStd();
        $this->assertEquals("100", $std->protNFe->infProt->cStat);
        $this->assertEquals("Autorizado o uso da NF-e", $std->protNFe->infProt->xMotivo);
    }

    /**
     * @return void
     */
    public function test_sefaz_envia_lote_xml_valido_modelo_55()
    {
        $xml = $this->getXml(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $responseBody = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml');
        $this->tools->getSoap()->setReturnValue($responseBody);
        $idLote = 1636667815;
        $request = '<nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeAutorizacao4"><enviNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00"><idLote>'. $idLote .'</idLote><indSinc>1</indSinc>'. $xml .'</enviNFe></nfeDadosMsg>';
        $resposta = $this->tools->sefazEnviaLote([$xml], (string)$idLote, 1);
        $params = $this->tools->getSoap()->getSendParams();
        $this->assertEquals(str_replace("\n", "", $request), str_replace("\n", "", $params['request']));
        $standard = new Standardize($resposta);
        $std = $standard->toStd();
        $this->assertEquals("100", $std->protNFe->infProt->cStat);
        $this->assertEquals("Autorizado o uso da NF-e", $std->protNFe->infProt->xMotivo);
    }

    /**
     * @param string $caminho
     * @return false|string
     * @throws \Exception
     */
    protected function getXml($caminho)
    {
        $xml = simplexml_load_file($caminho, 'SimpleXMLElement', LIBXML_NOBLANKS);
        $customXML = new \SimpleXMLElement($xml->asXML());
        $dom = dom_import_simplexml($customXML);
        return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
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
