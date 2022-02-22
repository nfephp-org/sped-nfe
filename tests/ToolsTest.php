<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use NFePHP\Common\Strings;
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

    protected function setUp(): void
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

    public function test_sefaz_consulta_recibo_valido()
    {
        $this->tools->sefazConsultaRecibo('143220020730398');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_request_consulta_recibo.xml');
        $this->assertSame($esperado, $request);
    }

    /**
     * Testa a consulta pela chave validando o parâmetro da chave vazio.
     */
    public function testSefazConsultaChaveThrowsInvalidArgExceptionSemChave()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('');
    }

    public function test_sefaz_consulta_chave_valida()
    {
        $this->tools->sefazConsultaChave('43211105730928000145650010000002401717268120');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_request_consulta_chave.xml');
        $this->assertSame($esperado, $request);
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
        $this->expectException(\TypeError::class);
        $this->tools->sefazEnviaLote(""); //@phpstan-ignore-line
    }

    /**
     * @return void
     */
    public function test_sefaz_envia_lote_varios_xml_sincronos()
    {
        $xml = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_65.xml');
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Envio sincrono deve ser usado para enviar uma UNICA nota por vez. ' .
            'Você está tentando enviar varias.');
        $this->tools->sefazEnviaLote([$xml, $xml], "1", 1);
    }

    /**
     * @return void
     */
    public function test_sefaz_envia_lote_xml_valido_modelo_65()
    {
        $xml = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_65.xml');
        $tools = $this->getToolsForModelWithSuccessReturn(65);
        $idLote = "1636667815";
        $resposta = $tools->sefazEnviaLote([$xml], $idLote, 1);
        $this->assertTrue(is_string($resposta));
        $request = $this->buildRequestExpected($xml, $idLote);
        $this->assertEquals($request, $tools->getRequest());
    }

    /**
     * @return void
     */
    public function test_sefaz_envia_lote_xml_valido_modelo_55()
    {
        $xml = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $tools = $this->getToolsForModelWithSuccessReturn(55);
        $idLote = "1636667815";
        $resposta = $this->tools->sefazEnviaLote([$xml], $idLote, 1);
        $this->assertTrue(is_string($resposta));
        $request = $this->buildRequestExpected($xml, $idLote);
        $this->assertEquals($request, $tools->getRequest());
    }

    /**
     * @return void
     */
    public function test_sefaz_envia_lote_xml_valido_modelo_55_compactado()
    {
        $xml = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        $tools = $this->getToolsForModelWithSuccessReturn(55);
        $idLote = "1636667815";
        $resposta = $this->tools->sefazEnviaLote([$xml], $idLote, 1, true);
        $this->assertTrue(is_string($resposta));
        $request = $this->buildExpectedNfe($xml, $idLote);
        $this->assertEquals($request, $tools->getRequest());
    }

    /**
     * @return void
     */
    public function test_sefaz_inutiliza()
    {
        $this->tools->sefazInutiliza(1, 1, 10, 'Testando Inutilização', 1, '22');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_inutiliza.xml');
        $this->assertSame($esperado, $request);
    }

    /**
     * @return void
     */
    public function test_sefaz_cadastro_cnpj()
    {
        $this->tools->sefazCadastro('RS', '20532295000154');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_cadastro_cnpj.xml');
        $this->assertSame($esperado, $request);
    }

    /**
     * @return void
     */
    public function test_sefaz_cadastro_ie()
    {
        $this->tools->sefazCadastro('RS', '', '1234567');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_cadastro_ie.xml');
        $this->assertSame($esperado, $request);
    }

    /**
     * @return void
     */
    public function test_sefaz_cadastro_cpf()
    {
        $this->tools->sefazCadastro('RS', '', '', '60140174028');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_cadastro_cpf.xml');
        $this->assertSame($esperado, $request);
    }

    /**
     * @return void
     */
    public function test_sefaz_status()
    {
        $this->tools->sefazStatus('RS');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_status.xml');
        $this->assertSame($esperado, $request);
    }

    /**
     * @return void
     */
    public function test_sefaz_dist_dfe()
    {
        $this->tools->sefazDistDFe(100, 200);
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_dist_dfe.xml');
        $this->assertSame($esperado, $request);
    }

    /**
     * @param string $xml
     * @param int|string $idLote
     * @return string
     */
    protected function buildRequestExpected($xml, $idLote)
    {
        return '<nfeDadosMsg xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeAutorizacao4">' .
            '<enviNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00"><idLote>' . $idLote .
            '</idLote><indSinc>1</indSinc>' . $xml . '</enviNFe></nfeDadosMsg>';
    }

    protected function buildExpectedNfe($xml, $idLote): string
    {
        $request = '<enviNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00"><idLote>' . $idLote .
            '</idLote><indSinc>1</indSinc>' . $xml . '</enviNFe>';
        $gzdata = base64_encode(gzencode($request, 9, FORCE_GZIP));

        return '<nfeDadosMsgZip xmlns="http://www.portalfiscal.inf.br/nfe/wsdl/NFeAutorizacao4">' .
            $gzdata . '</nfeDadosMsgZip>';
    }

    /**
     * @param int $model
     * @return \NFePHP\NFe\Tests\Common\ToolsFake
     */
    protected function getToolsForModelWithSuccessReturn($model = 55): ToolsFake
    {
        $responseBody = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml');
        $this->tools->getSoap()->setReturnValue($responseBody);
        $this->tools->model($model);

        return $this->tools;
    }

    /**
     * @param string $filePath
     * @return false|string
     * @throws \Exception
     */
    protected function getCleanXml($filePath)
    {
        $xml = simplexml_load_file($filePath, 'SimpleXMLElement', LIBXML_NOBLANKS);
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
