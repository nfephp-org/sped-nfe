<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use InvalidArgumentException;
use NFePHP\NFe\SAE;
use NFePHP\NFe\Tests\Common\SoapFake;

class SAETest extends NFeTestCase
{
    protected SAE $sae;
    protected SoapFake $soapFake;

    protected function setUp(): void
    {
        $this->sae = new SAE($this->certificate, 'SP', SAE::TPAMB_HOMOLOGACAO);
        $this->soapFake = new SoapFake($this->certificate);
        $this->soapFake->setReturnValue('<retNfceListagemChaves/>');
        $this->sae->loadSoapClass($this->soapFake);
    }

    public function testConstructThrowsOnInvalidTpAmb(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SAE($this->certificate, 'SP', 99);
    }

    public function testConstructThrowsOnUFNotAvailable(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new SAE($this->certificate, 'AM');
    }

    public function testListagemChavesBuildsCorrectRequest(): void
    {
        $this->sae->listagemChaves('2024-01-01T00:00');
        $request = $this->sae->lastRequest;

        $this->assertStringContainsString('<nfceListagemChaves', $request);
        $this->assertStringContainsString('versao="1.00"', $request);
        $this->assertStringContainsString('<tpAmb>2</tpAmb>', $request);
        $this->assertStringContainsString('<dataHoraInicial>2024-01-01T00:00</dataHoraInicial>', $request);
        $this->assertStringNotContainsString('<dataHoraFinal>', $request);
    }

    public function testListagemChavesWithEndDateBuildsCorrectRequest(): void
    {
        $this->sae->listagemChaves('2024-01-01T00:00', '2024-01-31T23:59');
        $request = $this->sae->lastRequest;

        $this->assertStringContainsString('<dataHoraInicial>2024-01-01T00:00</dataHoraInicial>', $request);
        $this->assertStringContainsString('<dataHoraFinal>2024-01-31T23:59</dataHoraFinal>', $request);
    }

    public function testListagemChavesSendsToHomologacaoUrl(): void
    {
        $this->sae->listagemChaves('2024-01-01T00:00');
        $params = $this->soapFake->getSendParams();

        $this->assertStringContainsString('homologacao.nfce.fazenda.sp.gov.br', $params['url']);
        $this->assertStringContainsString('NFCeListagemChaves', $params['url']);
    }

    public function testListagemChavesSendsToProducaoUrl(): void
    {
        $sae = new SAE($this->certificate, 'SP', SAE::TPAMB_PRODUCAO);
        $sae->loadSoapClass($this->soapFake);
        $sae->listagemChaves('2024-01-01T00:00');
        $params = $this->soapFake->getSendParams();

        $this->assertStringNotContainsString('homologacao', $params['url']);
        $this->assertStringContainsString('nfce.fazenda.sp.gov.br', $params['url']);
    }

    public function testListagemChavesThrowsOnInvalidDateFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sae->listagemChaves('01/01/2024');
    }

    public function testListagemChavesThrowsOnInvalidEndDateFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sae->listagemChaves('2024-01-01T00:00', '31-01-2024T23:59');
    }

    public function testDownloadXMLBuildsCorrectRequest(): void
    {
        $this->soapFake->setReturnValue('<retNfceDownloadXML/>');
        $chave = '35240193623057000128650010000002401717268120';
        $this->sae->downloadXML($chave);
        $request = $this->sae->lastRequest;

        $this->assertStringContainsString('<nfceDownloadXML', $request);
        $this->assertStringContainsString('versao="1.00"', $request);
        $this->assertStringContainsString('<tpAmb>2</tpAmb>', $request);
        $this->assertStringContainsString("<chNFCe>$chave</chNFCe>", $request);
    }

    public function testDownloadXMLSendsToCorrectUrl(): void
    {
        $this->soapFake->setReturnValue('<retNfceDownloadXML/>');
        $chave = '35240193623057000128650010000002401717268120';
        $this->sae->downloadXML($chave);
        $params = $this->soapFake->getSendParams();

        $this->assertStringContainsString('NFCeDownloadXML', $params['url']);
    }

    public function testDownloadXMLThrowsOnShortKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sae->downloadXML('123456789012345678901234567890123456789012'); // 42 digits
    }

    public function testDownloadXMLThrowsOnLongKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sae->downloadXML('3524019362305700012865001000000240171726812099'); // 46 digits
    }

    public function testDownloadXMLAcceptsAlphanumericKey(): void
    {
        $this->soapFake->setReturnValue('<retNfceDownloadXML/>');
        $chave = '3524019362305700012865001000000240171726812A'; // alphanumeric (CNPJ alfanumérico)
        $this->sae->downloadXML($chave);
        $this->assertStringContainsString("<chNFCe>$chave</chNFCe>", $this->sae->lastRequest);
    }

    public function testDownloadXMLThrowsOnSpecialCharKey(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->sae->downloadXML('3524019362305700012865001000000240171726812!'); // caractere especial
    }

    public function testCheckSoapCreatesSoapCurlWhenNotInjected(): void
    {
        $sae = new SAE($this->certificate, 'SP', SAE::TPAMB_HOMOLOGACAO);

        $ref = new \ReflectionClass($sae);
        $method = $ref->getMethod('checkSoap');
        $method->setAccessible(true);
        $method->invoke($sae);

        $prop = $ref->getProperty('soap');
        $prop->setAccessible(true);
        $this->assertInstanceOf(\NFePHP\Common\Soap\SoapCurl::class, $prop->getValue($sae));
    }

    public function testLoadConfigThrowsWhenFileNotFound(): void
    {
        $sae = new SAE($this->certificate, 'SP', SAE::TPAMB_HOMOLOGACAO);

        $ref = new \ReflectionClass($sae);
        $prop = $ref->getProperty('pathwsfiles');
        $prop->setAccessible(true);
        $prop->setValue($sae, '/nonexistent/path/');

        $method = $ref->getMethod('loadConfig');
        $method->setAccessible(true);

        $this->expectException(\RuntimeException::class);
        $method->invoke($sae);
    }

    public function testServicioThrowsForUnknownService(): void
    {
        $ref = new \ReflectionClass($this->sae);
        $method = $ref->getMethod('servico');
        $method->setAccessible(true);

        $this->expectException(InvalidArgumentException::class);
        $method->invoke($this->sae, 'ServicoInexistente');
    }
}
