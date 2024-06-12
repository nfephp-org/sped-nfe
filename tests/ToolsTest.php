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

    protected ToolsFake $tools;

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

    public function test_sefaz_inutiliza(): void
    {
        $this->tools->sefazInutiliza(1, 1, 10, 'Testando Inutilização', 1, '22');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_inutiliza.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefaz_cadastro_cnpj(): void
    {
        $this->tools->sefazCadastro('RS', '20532295000154');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_cadastro_cnpj.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefaz_cadastro_ie(): void
    {
        $this->tools->sefazCadastro('RS', '', '1234567');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_cadastro_ie.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefaz_cadastro_cpf(): void
    {
        $this->tools->sefazCadastro('RS', '', '', '60140174028');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_cadastro_cpf.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefaz_status(): void
    {
        $this->tools->sefazStatus('RS');
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_status.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefaz_dist_dfe(): void
    {
        $this->tools->sefazDistDFe(100, 200);
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_dist_dfe.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefazCCe(): void
    {
        $chave = '35220605730928000145550010000048661583302923';
        $xCorrecao = 'Descrição da correção';
        $nSeqEvento = 1;
        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $lote = '12345';
        $retorno = $this->tools->sefazCCe($chave, $xCorrecao, $nSeqEvento, $dhEvento, $lote);
        //@todo Testar o $retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_request_cce_cnpj.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefazAtorInteressado(): void
    {
        $std = new \stdClass();
        $std->tpAutor = 1;
        $std->verAplic = 2;
        $std->CNPJ = '88880563000162';
        $std->tpAutorizacao = 0;
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->nSeqEvento = 1;
        $dhEvento = new \DateTime('2024-05-31T13:45:41-03:00');
        $lote = '202405311345419';
        $retorno = $this->tools->sefazAtorInteressado($std, $dhEvento, $lote);
        //@todo Testar o $retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_request_sefazAtorInteressado.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefazEPP(): void
    {
        $chNFe = '35150300822602000124550010009923461099234656';
        $nProt = '135150001686732';
        $itens = [
            [1, 111],
            [2, 222],
            [3, 333]
        ];
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $retorno = $this->tools->sefazEPP($chNFe, $nProt, $itens, 1, 1, $dhEvento, '123');
        //@todo fazer mock do retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_request_sefazEPP.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefazECPP(): void
    {
        $chNFe = '35150300822602000124550010009923461099234656';
        $nProt = '135150001686732';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $retorno = $this->tools->sefazECPP($chNFe, $nProt, 1, 1, $dhEvento, '123');
        //@todo fazer mock do retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_request_sefazECPP.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefazCancela(): void
    {
        $chNFe = '35150300822602000124550010009923461099234656';
        $xJust = 'Preenchimento incorreto dos dados';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $nProt = '123456789101234';
        $retorno = $this->tools->sefazCancela($chNFe, $xJust, $nProt, $dhEvento, '123');
        //@todo fazer mock do retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_sefazCancela.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefazCancelaPorSubstituicaoErroChave(): void
    {
        $msg = 'Cancelamento pro Substituição deve ser usado apenas para operações com modelo 65 NFCe';
        $this->expectExceptionMessage($msg);
        $chNFe = '35150300822602000124550010009923461099234656';
        $chReferenciada = '35170705248891000181550010000011831339972127';
        $xJust = 'Preenchimento incorreto dos dados';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $nProt = '123456789101234';
        $this->tools->sefazCancelaPorSubstituicao($chNFe, $xJust, $nProt, $chReferenciada, "1", $dhEvento, '123');
    }

    public function test_sefazCancelaPorSubstituicao(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $chReferenciada = '35240305730928000145650010000001421071400478';
        $xJust = 'Preenchimento incorreto dos dados';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $nProt = '123456789101234';
        $this->tools->model(65);
        $retorno = $this->tools->sefazCancelaPorSubstituicao(
            $chNFe,
            $xJust,
            $nProt,
            $chReferenciada,
            "1",
            $dhEvento,
            '123'
        );
        //@todo fazer mock do retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_request_sefazCancelaPorSubstituicao.xml');
        $this->assertSame($esperado, $request);
    }

    public function test_sefazManifesta(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $xJust = 'Preenchimento incorreto dos dados';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $tpEvento = 210210; //ciencia da operação
        $retorno = $this->tools->sefazManifesta(
            $chNFe,
            $tpEvento,
            $xJust,
            1,
            $dhEvento,
            '123'
        );
        //@todo fazer mock do retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_request_sefazManifesta.xml');
        $this->assertSame($esperado, $request);
    }

    /*public function test_sefazManifestaLote(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $xJust = 'Preenchimento incorreto dos dados';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $tpEvento = 210210; //ciencia da operação
        $retorno = $this->tools->sefazManifestaLote(
            $chNFe,
            $tpEvento,
            $xJust,
            1,
            $dhEvento,
            '123'
        );
        //@todo fazer mock do retorno
        $request = $this->tools->getRequest();
        $esperado = $this->getCleanXml(__DIR__ . '/fixtures/xml/exemplo_xml_request_sefazManifesta.xml');
        $this->assertSame($esperado, $request);
    }

    /*public function test_sefazComprovanteEntrega(): void
    {
        $retorno = $this->tools->sefazComprovanteEntrega();
    }

    public function test_sefazInsucessoEntrega(): void
    {
        $retorno = $this->tools->sefazInsucessoEntrega();
    }

    public function test_sefazEventoLote(): void
    {
        $retorno = $this->tools->sefazEventoLote();
    }

    public function test_sefazEPEC(): void
    {
        $retorno = $this->tools->sefazEPEC();
    }

    public function test_sefazDownload(): void
    {
        $retorno = $this->tools->sefazDownload();
    }

    public function test_sefazCsc(): void
    {
        $retorno = $this->tools->sefazCsc();
    }

    public function test_sefazValidate(): void
    {
        $retorno = $this->tools->sefazValidate();
    }*/

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
        $xml = simplexml_load_string(file_get_contents($filePath), 'SimpleXMLElement', LIBXML_NOBLANKS);
        $customXML = new \SimpleXMLElement($xml->asXML());
        $dom = dom_import_simplexml($customXML);
        return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
    }

    public function ufProvider(): array
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
