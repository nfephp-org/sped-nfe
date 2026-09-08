<?php

namespace NFePHP\NFe\Lookup;

/**
 * Contrato mínimo de transporte HTTP usado pelos provedores de consulta.
 *
 * A abstração isola a chamada de rede, o que permite injetar um transporte
 * de teste (em memória) sem depender de bibliotecas externas nem tocar a rede
 * durante os testes.
 */
interface HttpTransport
{
    /**
     * Executa uma requisição GET e devolve o código HTTP e o corpo da resposta.
     *
     * @param string $url URL completa a consultar.
     * @return array{status:int, body:string} Código HTTP e corpo da resposta.
     */
    public function get(string $url): array;
}
