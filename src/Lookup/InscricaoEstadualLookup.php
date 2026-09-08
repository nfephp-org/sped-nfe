<?php

namespace NFePHP\NFe\Lookup;

/**
 * Contrato opcional para provedores que também expõem a Inscrição Estadual
 * (IE) de uma pessoa jurídica.
 *
 * É um contrato separado de PessoaLookup, e por isso aditivo: um provedor só o
 * implementa quando consegue devolver as IEs de um CNPJ. O Resolver consulta a
 * IE apenas quando o provedor injetado implementa esta interface e a opção está
 * ligada, mantendo o comportamento padrão (sem IE) para os demais.
 *
 * Cada item devolvido é um stdClass normalizado com:
 *  - uf: sigla da unidade federativa da inscrição (ex.: 'GO'), ou null;
 *  - inscricao: número da inscrição estadual, apenas o valor informado;
 *  - ativo: bool indicando se a inscrição está ativa.
 */
interface InscricaoEstadualLookup
{
    /**
     * Consulta as inscrições estaduais de um CNPJ e devolve a lista já
     * normalizada. A lista é vazia quando o provedor não retorna inscrições.
     *
     * @return array<int, \stdClass>
     */
    public function consultarInscricoesEstaduais(string $cnpj): array;
}
