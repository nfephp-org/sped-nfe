<?php

/**
 * Class responsible for communication with SAE-NFC-e
 * (Serviços de Apoio à Escrituração da NFC-e)
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\SAE
 * @copyright NFePHP Copyright (c) 2008-2024
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe;

use InvalidArgumentException;
use NFePHP\Common\Certificate;
use NFePHP\Common\Soap\SoapCurl;
use NFePHP\Common\Soap\SoapInterface;
use NFePHP\Common\Strings;

class SAE
{
    public const TPAMB_PRODUCAO = 1;
    public const TPAMB_HOMOLOGACAO = 2;

    /**
     * Last SOAP request body
     * @var string
     */
    public string $lastRequest = '';

    /**
     * Last SOAP response body
     * @var string
     */
    public string $lastResponse = '';

    /**
     * @var Certificate
     */
    protected Certificate $certificate;

    /**
     * @var int
     */
    protected int $tpAmb;

    /**
     * @var string
     */
    protected string $uf;

    /**
     * @var \stdClass
     */
    protected \stdClass $config;

    /**
     * @var SoapInterface|null
     */
    protected ?SoapInterface $soap = null;

    /**
     * @var string
     */
    protected string $pathwsfiles = '';

    /**
     * @param Certificate $certificate e-CNPJ certificate used for authentication
     * @param string $uf State abbreviation (ex: SP)
     * @param int $tpAmb 1=Produção, 2=Homologação
     * @throws InvalidArgumentException
     */
    public function __construct(Certificate $certificate, string $uf, int $tpAmb = self::TPAMB_HOMOLOGACAO)
    {
        if (!in_array($tpAmb, [self::TPAMB_PRODUCAO, self::TPAMB_HOMOLOGACAO], true)) {
            throw new InvalidArgumentException('Ambiente inválido. Use 1 (Produção) ou 2 (Homologação).');
        }
        $this->certificate = $certificate;
        $this->tpAmb = $tpAmb;
        $this->uf = strtoupper(trim($uf));
        $this->pathwsfiles = realpath(__DIR__ . '/../storage') . '/';
        $this->loadConfig();
    }

    /**
     * Inject a custom SOAP implementation (useful for testing)
     */
    public function loadSoapClass(SoapInterface $soap): void
    {
        $this->soap = $soap;
    }

    /**
     * Returns the list of NFC-e access keys received by SEFAZ for the CNPJ in the certificate
     * for a given period. The response is limited to 2000 keys; if there are more, cStat=101
     * is returned and dhEmisUltNfce can be used to paginate.
     *
     * @param string $dataHoraInicial Start datetime in format YYYY-MM-DDThh:mm
     * @param string|null $dataHoraFinal End datetime in format YYYY-MM-DDThh:mm (optional)
     * @return string SOAP response XML
     * @throws InvalidArgumentException
     */
    public function listagemChaves(string $dataHoraInicial, ?string $dataHoraFinal = null): string
    {
        $this->validateDateHour($dataHoraInicial, 'dataHoraInicial');
        if ($dataHoraFinal !== null) {
            $this->validateDateHour($dataHoraFinal, 'dataHoraFinal');
        }

        $serv = $this->servico('NFCeListagemChaves');

        $content = "<nfceListagemChaves versao=\"{$this->config->versao}\" xmlns=\"{$this->config->namespace}\">"
            . "<tpAmb>{$this->tpAmb}</tpAmb>"
            . "<dataHoraInicial>{$dataHoraInicial}</dataHoraInicial>"
            . ($dataHoraFinal !== null ? "<dataHoraFinal>{$dataHoraFinal}</dataHoraFinal>" : '')
            . "</nfceListagemChaves>";

        $this->lastRequest = $content;
        $this->lastResponse = $this->send($serv, $content);
        return $this->lastResponse;
    }

    /**
     * Downloads the complete XML of a NFC-e (including its events) given an access key.
     * The CNPJ in the access key must match the CNPJ in the digital certificate.
     *
     * @param string $chNFCe 44-character alphanumeric NFC-e access key
     * @return string SOAP response XML
     * @throws InvalidArgumentException
     */
    public function downloadXML(string $chNFCe): string
    {
        if (strlen($chNFCe) !== 44 || !ctype_alnum($chNFCe)) {
            throw new InvalidArgumentException(
                'Chave de acesso inválida. Deve conter exatamente 44 caracteres alfanuméricos.'
            );
        }

        $serv = $this->servico('NFCeDownloadXML');

        $content = "<nfceDownloadXML versao=\"{$this->config->versao}\" xmlns=\"{$this->config->namespace}\">"
            . "<tpAmb>{$this->tpAmb}</tpAmb>"
            . "<chNFCe>{$chNFCe}</chNFCe>"
            . "</nfceDownloadXML>";

        $this->lastRequest = $content;
        $this->lastResponse = $this->send($serv, $content);
        return $this->lastResponse;
    }

    /**
     * @param \stdClass $serv
     * @param string $content
     * @return string
     */
    protected function send(\stdClass $serv, string $content): string
    {
        $namespace = "{$this->config->namespace}/wsdl/{$serv->operation}";
        $action = "\"$namespace/{$serv->method}\"";
        $body = "<nfeDadosMsg xmlns=\"$namespace\">$content</nfeDadosMsg>";

        $this->checkSoap();
        $namespaces = [
            'xmlns:xsi'  => 'http://www.w3.org/2001/XMLSchema-instance',
            'xmlns:xsd'  => 'http://www.w3.org/2001/XMLSchema',
            'xmlns:soap' => 'http://www.w3.org/2003/05/soap-envelope',
        ];
        $response = (string) $this->soap->send(
            $serv->url,
            $serv->method,
            $action,
            SOAP_1_2,
            [],
            $namespaces,
            $body,
            null
        );
        return Strings::normalize($response);
    }

    /**
     * @param string $service
     * @return \stdClass with url, method, operation
     * @throws InvalidArgumentException
     */
    protected function servico(string $service): \stdClass
    {
        $srv = $this->config->$service ?? null;
        if ($srv === null) {
            throw new InvalidArgumentException(
                "Serviço [{$service}] não disponível para o estado [{$this->uf}]."
            );
        }
        $env = $this->tpAmb === self::TPAMB_PRODUCAO ? 'producao' : 'homologacao';
        return (object) [
            'url'       => $srv->$env,
            'method'    => $srv->method,
            'operation' => $srv->operation,
        ];
    }

    protected function checkSoap(): void
    {
        if ($this->soap === null) {
            $this->soap = new SoapCurl($this->certificate);
        }
    }

    protected function loadConfig(): void
    {
        $path = $this->pathwsfiles . 'wsae_nfce.json';
        if (!file_exists($path)) {
            throw new \RuntimeException("Arquivo de configuração SAE não encontrado: $path");
        }
        $all = json_decode((string) file_get_contents($path));
        if (!isset($all->{$this->uf})) {
            throw new InvalidArgumentException(
                "SAE-NFC-e não disponível para o estado [{$this->uf}]."
            );
        }
        $this->config = $all->{$this->uf};
    }

    protected function validateDateHour(string $value, string $fieldName): void
    {
        if (!preg_match('/^\d{4}-\d{2}-\d{2}T\d{2}:\d{2}$/', $value)) {
            throw new InvalidArgumentException(
                "Campo $fieldName inválido. Use o formato AAAA-MM-DDThh:mm (ex: 2024-01-15T08:30)."
            );
        }
    }
}
