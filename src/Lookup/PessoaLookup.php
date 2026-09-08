<?php

namespace NFePHP\NFe\Lookup;

use stdClass;

/**
 * Contrato de um provedor de consulta de pessoas (física ou jurídica).
 *
 * Uma implementação recebe um documento e devolve um objeto com os dados já
 * normalizados, com os mesmos nomes de campo independentemente do provedor,
 * pronto para o Resolver montar o stdClass de destinatário consumido pelo
 * sped-nfe.
 *
 * Campos do objeto normalizado devolvido:
 *  - tipo: 'CPF' ou 'CNPJ'
 *  - documento: apenas dígitos (ou alfanumérico, no caso de CNPJ)
 *  - nome: nome da pessoa física ou razão social
 *  - fantasia: nome fantasia, quando houver
 *  - logradouro, numero, complemento, bairro, cep
 *  - municipio: nome do município
 *  - codigoMunicipio: código IBGE de 7 dígitos do município
 *  - uf: sigla da unidade federativa
 *  - simplesNacionalOptante: bool, ou null quando o pacote não informa
 *  - pacote: número do pacote consultado
 *  - bruto: stdClass com a resposta original do provedor
 */
interface PessoaLookup
{
    /**
     * Consulta uma pessoa física pelo CPF e devolve os dados normalizados.
     */
    public function consultarCpf(string $cpf): stdClass;

    /**
     * Consulta uma pessoa jurídica pelo CNPJ e devolve os dados normalizados.
     */
    public function consultarCnpj(string $cnpj): stdClass;
}
