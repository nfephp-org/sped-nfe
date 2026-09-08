<?php

namespace NFePHP\NFe\Lookup;

use stdClass;

/**
 * Monta o stdClass de destinatário a partir de um provedor PessoaLookup.
 *
 * O objeto devolvido já traz os campos que tagdest e tagenderDest consomem
 * (xNome, CPF/CNPJ, xLgr, nro, xCpl, xBairro, cMun, xMun, UF, CEP). Como cada
 * método do Make filtra apenas os campos que reconhece, o mesmo objeto pode
 * ser passado para as duas chamadas:
 *
 *     $resolver = new Resolver(new CpfCnpjComBrLookup($token));
 *     $dest = $resolver->porDocumento($documento);
 *     $make->tagdest($dest);
 *     $make->tagenderDest($dest);
 *
 * O Resolver nunca preenche IE, IM nem indIEDest. A definição de indIEDest e
 * o fornecimento da Inscrição Estadual permanecem com o integrador, porque o
 * provedor não expõe esses dados. O caso de uso mais direto é a NFC-e
 * (modelo 65), em que o próprio Make força indIEDest = 9 e dispensa a IE, e a
 * NF-e modelo 55 para destinatário pessoa física ou não contribuinte
 * (indIEDest = 9).
 */
class Resolver
{
    /**
     * @var PessoaLookup
     */
    private $lookup;

    public function __construct(PessoaLookup $lookup)
    {
        $this->lookup = $lookup;
    }

    /**
     * Resolve um destinatário pessoa física pelo CPF.
     */
    public function porCpf(string $cpf): stdClass
    {
        return $this->montar($this->lookup->consultarCpf($cpf));
    }

    /**
     * Resolve um destinatário pessoa jurídica pelo CNPJ.
     */
    public function porCnpj(string $cnpj): stdClass
    {
        return $this->montar($this->lookup->consultarCnpj($cnpj));
    }

    /**
     * Resolve um destinatário a partir de um documento, escolhendo CPF ou
     * CNPJ pela quantidade de caracteres úteis (11 para CPF, 14 para CNPJ).
     */
    public function porDocumento(string $documento): stdClass
    {
        $limpo = (string) preg_replace('/[^0-9A-Za-z]/', '', $documento);
        $tamanho = strlen($limpo);
        if ($tamanho === 11) {
            return $this->porCpf($documento);
        }
        if ($tamanho === 14) {
            return $this->porCnpj($documento);
        }
        throw new LookupException(
            'Documento inválido: informe um CPF (11) ou um CNPJ (14).'
        );
    }

    /**
     * Converte os dados normalizados no stdClass consumido por tagdest e
     * tagenderDest.
     */
    private function montar(stdClass $dados): stdClass
    {
        $std = new stdClass();
        $std->xNome = $dados->nome ?? null;
        if (($dados->tipo ?? null) === 'CNPJ') {
            $std->CNPJ = $dados->documento ?? null;
        } else {
            $std->CPF = $dados->documento ?? null;
        }
        $std->xLgr = $dados->logradouro ?? null;
        $std->nro = $dados->numero ?? null;
        $std->xCpl = $dados->complemento ?? null;
        $std->xBairro = $dados->bairro ?? null;
        $std->cMun = $dados->codigoMunicipio ?? null;
        $std->xMun = $dados->municipio ?? null;
        $std->UF = $dados->uf ?? null;
        $std->CEP = $dados->cep ?? null;
        return $std;
    }
}
