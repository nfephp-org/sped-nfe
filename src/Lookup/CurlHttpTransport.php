<?php

namespace NFePHP\NFe\Lookup;

/**
 * Transporte HTTP padrão baseado na extensão cURL.
 *
 * Faz uma requisição GET simples, sem estado, e devolve o código HTTP e o
 * corpo recebido. Para cenários de teste basta implementar HttpTransport com
 * respostas em memória.
 */
class CurlHttpTransport implements HttpTransport
{
    /**
     * Tempo máximo, em segundos, para conexão e para a requisição completa.
     *
     * @var int
     */
    private $timeout;

    public function __construct(int $timeout = 10)
    {
        $this->timeout = $timeout;
    }

    /**
     * @return array{status:int, body:string}
     */
    public function get(string $url): array
    {
        $handle = curl_init();
        if ($handle === false) {
            throw new LookupException('Não foi possível inicializar o cURL.');
        }
        curl_setopt($handle, CURLOPT_URL, $url);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($handle, CURLOPT_MAXREDIRS, 3);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($handle, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($handle, CURLOPT_HTTPHEADER, ['Accept: application/json']);
        $body = curl_exec($handle);
        $erro = curl_error($handle);
        $codigo = (int) curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        if ($body === false) {
            throw new LookupException('Falha na requisição HTTP: ' . $erro);
        }
        return ['status' => $codigo, 'body' => (string) $body];
    }
}
