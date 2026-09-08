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
 * Por padrão o Resolver não preenche IE, IM nem indIEDest, e o comportamento é
 * idêntico ao de antes desta opção. O caso de uso mais direto é a NFC-e
 * (modelo 65), em que o próprio Make força indIEDest = 9 e dispensa a IE, e a
 * NF-e modelo 55 para destinatário pessoa física ou não contribuinte
 * (indIEDest = 9).
 *
 * Para o B2B contribuinte do ICMS existe a opção comInscricaoEstadual(). Com
 * ela ligada, e desde que o provedor implemente InscricaoEstadualLookup, o
 * Resolver faz uma consulta extra (pacote CNPJ H, ID 16) e seleciona a primeira
 * inscrição ATIVA cuja UF é igual à UF do endereço do destinatário; inscrições
 * inativas são ignoradas, nunca servem de fallback. Havendo IE ativa para a UF,
 * preenche o campo IE e marca indIEDest = 1 (contribuinte). Não havendo IE ativa
 * para a UF, nada é forçado: o campo IE e o indIEDest ficam como estão, e a
 * decisão permanece com o integrador. O Resolver nunca declara IE isenta por
 * conta própria.
 *
 * A falha na consulta ao pacote 16 é propagada (fail loud), por decisão: quem
 * optou pela IE recebe o erro em vez de uma nota de contribuinte emitida sem a
 * IE. Se preferir degradar em silêncio, o integrador envolve a chamada em um
 * try/catch próprio.
 */
class Resolver
{
    /**
     * @var PessoaLookup
     */
    private $lookup;

    /**
     * Liga a busca opcional da Inscrição Estadual do destinatário.
     *
     * @var bool
     */
    private $comInscricaoEstadual = false;

    public function __construct(PessoaLookup $lookup)
    {
        $this->lookup = $lookup;
    }

    /**
     * Liga ou desliga o preenchimento opcional da Inscrição Estadual do
     * destinatário nas consultas de CNPJ. Ligado, cada resolução de CNPJ faz
     * uma consulta extra ao pacote CNPJ H (ID 16). Devolve o próprio Resolver
     * para permitir encadeamento.
     */
    public function comInscricaoEstadual(bool $incluir = true): self
    {
        $this->comInscricaoEstadual = $incluir;
        return $this;
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
        $std = $this->montar($this->lookup->consultarCnpj($cnpj));
        if ($this->comInscricaoEstadual) {
            $this->preencherInscricaoEstadual($std, $cnpj);
        }
        return $std;
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

    /**
     * Consulta a Inscrição Estadual do CNPJ e, quando encontra uma inscrição
     * ativa para a UF do endereço do destinatário, preenche IE e marca
     * indIEDest = 1. Sem UF no endereço, sem provedor de IE ou sem inscrição
     * ativa para a UF, não altera nada.
     */
    private function preencherInscricaoEstadual(stdClass $std, string $cnpj): void
    {
        if (!$this->lookup instanceof InscricaoEstadualLookup) {
            return;
        }
        $uf = isset($std->UF) ? strtoupper(trim((string) $std->UF)) : '';
        if ($uf === '') {
            return;
        }
        $inscricao = $this->escolherInscricaoAtivaPorUf(
            $this->lookup->consultarInscricoesEstaduais($cnpj),
            $uf
        );
        if ($inscricao === null) {
            return;
        }
        $std->IE = $inscricao;
        $std->indIEDest = '1';
    }

    /**
     * Seleciona, na lista de inscrições, a primeira inscrição ativa cuja UF
     * coincide com a UF do destinatário. Inscrições inativas são ignoradas e
     * nunca servem de fallback. Havendo mais de uma inscrição ativa para a UF,
     * devolve a primeira da lista (ordem definida pelo provedor). Devolve o
     * número da inscrição ou null quando não há candidata.
     *
     * @param array<int, stdClass> $inscricoes
     */
    private function escolherInscricaoAtivaPorUf(array $inscricoes, string $uf): ?string
    {
        foreach ($inscricoes as $inscricao) {
            if (!$inscricao instanceof stdClass) {
                continue;
            }
            $ieUf = isset($inscricao->uf) ? strtoupper(trim((string) $inscricao->uf)) : '';
            $numero = isset($inscricao->inscricao) ? trim((string) $inscricao->inscricao) : '';
            if ($ieUf === $uf && $numero !== '' && !empty($inscricao->ativo)) {
                return $numero;
            }
        }
        return null;
    }
}
