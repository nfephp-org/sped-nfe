<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests\Lookup;

use NFePHP\NFe\Lookup\HttpTransport;

/**
 * Transporte HTTP falso, em memória, para os testes do provedor de consulta.
 *
 * Guarda a última URL recebida e devolve as respostas configuradas em ordem,
 * repetindo a última quando a fila se esgota.
 */
class FakeHttpTransport implements HttpTransport
{
    /** @var string|null */
    public $ultimaUrl;

    /** @var array<int, array{status:int, body:string}> */
    private $respostas;

    /** @var int */
    private $indice = 0;

    /**
     * @param array<int, array{status:int, body:string}> $respostas
     */
    public function __construct(array $respostas)
    {
        $this->respostas = array_values($respostas);
    }

    /**
     * @return array{status:int, body:string}
     */
    public function get(string $url): array
    {
        $this->ultimaUrl = $url;
        $total = count($this->respostas);
        $posicao = $this->indice < $total ? $this->indice : $total - 1;
        $this->indice++;
        return $this->respostas[$posicao];
    }
}
