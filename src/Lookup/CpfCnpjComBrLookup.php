<?php

namespace NFePHP\NFe\Lookup;

use stdClass;

/**
 * Provedor de consulta de pessoas baseado na API pública cpfcnpj.com.br.
 *
 * Faz uma requisição GET para
 * https://api.cpfcnpj.com.br/{token}/{pacote}/{documento} e normaliza a
 * resposta para o formato descrito na interface PessoaLookup.
 *
 * Pacotes usados por padrão:
 *  - CPF: pacote 3 (nome e endereço completo, com código IBGE de 7 dígitos);
 *  - CNPJ: pacote 5 (razão social, endereço da matriz e código IBGE do
 *    município). O pacote 6 pode ser informado para trazer também o bloco
 *    simplesNacional, útil ao integrador que precisa derivar o CRT do
 *    emitente.
 *
 * A Inscrição Estadual (IE) é opcional e sai de uma consulta à parte, ao
 * pacote CNPJ H (ID 16), exposta por consultarInscricoesEstaduais. Ela só é
 * usada quando o integrador liga a opção no Resolver, e custa uma consulta
 * extra. Sem ligar a opção, o Resolver mantém o comportamento padrão e nunca
 * preenche IE, IM ou indIEDest. A Inscrição Municipal continua fora do escopo
 * do provedor.
 */
class CpfCnpjComBrLookup implements PessoaLookup, InscricaoEstadualLookup
{
    /**
     * URL base da API, sem a barra final.
     *
     * @var string
     */
    private $baseUrl;

    /**
     * Token de acesso obtido no painel em API > Tokens.
     *
     * @var string
     */
    private $token;

    /**
     * Transporte HTTP responsável pela requisição.
     *
     * @var HttpTransport
     */
    private $transport;

    /**
     * Pacote usado nas consultas de CPF.
     *
     * @var int
     */
    private $pacoteCpf;

    /**
     * Pacote usado nas consultas de CNPJ.
     *
     * @var int
     */
    private $pacoteCnpj;

    /**
     * Pacote usado nas consultas de Inscrição Estadual (CNPJ H, ID 16).
     *
     * @var int
     */
    private $pacoteIe;

    public function __construct(
        string $token,
        ?HttpTransport $transport = null,
        int $pacoteCpf = 3,
        int $pacoteCnpj = 5,
        string $baseUrl = 'https://api.cpfcnpj.com.br',
        int $pacoteIe = 16
    ) {
        $this->token = $token;
        $this->transport = $transport ?? new CurlHttpTransport();
        $this->pacoteCpf = $pacoteCpf;
        $this->pacoteCnpj = $pacoteCnpj;
        $this->baseUrl = rtrim($baseUrl, '/');
        $this->pacoteIe = $pacoteIe;
    }

    public function consultarCpf(string $cpf): stdClass
    {
        $documento = $this->somenteDigitos($cpf);
        if (strlen($documento) !== 11) {
            throw new LookupException('CPF inválido: são esperados 11 dígitos.');
        }
        $resposta = $this->consultar($this->pacoteCpf, $documento);
        return $this->normalizarCpf($resposta, $documento);
    }

    public function consultarCnpj(string $cnpj): stdClass
    {
        $documento = $this->normalizarCnpjDocumento($cnpj);
        $resposta = $this->consultar($this->pacoteCnpj, $documento);
        return $this->normalizarCnpj($resposta, $documento);
    }

    /**
     * Consulta as inscrições estaduais de um CNPJ no pacote CNPJ H (ID 16) e
     * devolve a lista já normalizada. É uma consulta à parte das de dados
     * cadastrais, e portanto cobra uma consulta extra no provedor.
     *
     * @return array<int, stdClass>
     */
    public function consultarInscricoesEstaduais(string $cnpj): array
    {
        $documento = $this->normalizarCnpjDocumento($cnpj);
        $resposta = $this->consultar($this->pacoteIe, $documento);
        return $this->normalizarInscricoesEstaduais($resposta);
    }

    /**
     * Executa a consulta e devolve o corpo já decodificado, após validar o
     * código HTTP e o campo status da resposta.
     */
    private function consultar(int $pacote, string $documento): stdClass
    {
        $url = $this->baseUrl . '/' . rawurlencode($this->token)
            . '/' . $pacote . '/' . rawurlencode($documento);
        $resposta = $this->transport->get($url);
        if ($resposta['status'] < 200 || $resposta['status'] >= 300) {
            throw new LookupException(
                'Erro HTTP ' . $resposta['status'] . ' ao consultar o provedor cpfcnpj.com.br.'
            );
        }
        $data = json_decode($resposta['body']);
        if (!$data instanceof stdClass) {
            throw new LookupException('Resposta inválida do provedor cpfcnpj.com.br.');
        }
        if ((int) ($data->status ?? 0) !== 1) {
            $mensagem = isset($data->erro) ? (string) $data->erro : 'consulta não autorizada';
            $codigo = isset($data->erroCodigo) ? (string) $data->erroCodigo : 's/ código';
            throw new LookupException(
                'Consulta recusada pelo provedor cpfcnpj.com.br: '
                . $mensagem . ' (código ' . $codigo . ').'
            );
        }
        return $data;
    }

    private function normalizarCpf(stdClass $data, string $documento): stdClass
    {
        $n = new stdClass();
        $n->tipo = 'CPF';
        $n->documento = $documento;
        $n->nome = isset($data->nome) ? (string) $data->nome : null;
        $n->fantasia = null;
        $n->logradouro = isset($data->endereco) ? (string) $data->endereco : null;
        $n->numero = isset($data->numero) ? (string) $data->numero : null;
        $n->complemento = isset($data->complemento) ? (string) $data->complemento : null;
        $n->bairro = isset($data->bairro) ? (string) $data->bairro : null;
        $n->cep = isset($data->cep) ? $this->somenteDigitos((string) $data->cep) : null;
        $n->municipio = isset($data->cidade) ? (string) $data->cidade : null;
        $n->codigoMunicipio = isset($data->ibge) ? (string) $data->ibge : null;
        $n->uf = isset($data->uf) ? (string) $data->uf : null;
        $n->simplesNacionalOptante = null;
        $n->pacote = $this->pacoteCpf;
        $n->bruto = $data;
        return $n;
    }

    private function normalizarCnpj(stdClass $data, string $documento): stdClass
    {
        $endereco = ($data->matrizEndereco ?? null) instanceof stdClass
            ? $data->matrizEndereco
            : new stdClass();

        $codigoMunicipio = null;
        $municipio = null;
        if (
            ($data->ibge ?? null) instanceof stdClass
            && ($data->ibge->cidade ?? null) instanceof stdClass
        ) {
            $cidade = $data->ibge->cidade;
            $codigoMunicipio = isset($cidade->ibge_id) ? (string) $cidade->ibge_id : null;
            $municipio = isset($cidade->nome) ? (string) $cidade->nome : null;
        }
        if ($municipio === null && isset($endereco->cidade)) {
            $municipio = (string) $endereco->cidade;
        }

        $optante = null;
        if (
            ($data->simplesNacional ?? null) instanceof stdClass
            && isset($data->simplesNacional->optante)
        ) {
            $optante = strtolower(trim((string) $data->simplesNacional->optante)) === 'sim';
        }

        $n = new stdClass();
        $n->tipo = 'CNPJ';
        $n->documento = $documento;
        $n->nome = isset($data->razao) ? (string) $data->razao : null;
        $n->fantasia = isset($data->fantasia) ? (string) $data->fantasia : null;
        $n->logradouro = isset($endereco->logradouro) ? (string) $endereco->logradouro : null;
        $n->numero = isset($endereco->numero) ? (string) $endereco->numero : null;
        $n->complemento = isset($endereco->complemento) ? (string) $endereco->complemento : null;
        $n->bairro = isset($endereco->bairro) ? (string) $endereco->bairro : null;
        $n->cep = isset($endereco->cep) ? $this->somenteDigitos((string) $endereco->cep) : null;
        $n->municipio = $municipio;
        $n->codigoMunicipio = $codigoMunicipio;
        $n->uf = isset($endereco->uf) ? (string) $endereco->uf : null;
        $n->simplesNacionalOptante = $optante;
        $n->pacote = $this->pacoteCnpj;
        $n->bruto = $data;
        return $n;
    }

    /**
     * Converte o bloco inscricoesEstaduais do pacote 16 em uma lista de
     * stdClass com uf (sigla), inscricao e ativo. Entradas sem número de
     * inscrição são descartadas.
     *
     * @return array<int, stdClass>
     */
    private function normalizarInscricoesEstaduais(stdClass $data): array
    {
        $lista = [];
        $inscricoes = $data->inscricoesEstaduais ?? null;
        if (!is_array($inscricoes)) {
            return $lista;
        }
        foreach ($inscricoes as $item) {
            if (!$item instanceof stdClass) {
                continue;
            }
            $inscricao = isset($item->inscricao_estadual)
                ? trim((string) $item->inscricao_estadual)
                : '';
            if ($inscricao === '') {
                continue;
            }
            $uf = null;
            if (
                ($item->estado ?? null) instanceof stdClass
                && isset($item->estado->sigla)
            ) {
                $uf = strtoupper(trim((string) $item->estado->sigla));
            }
            $ie = new stdClass();
            $ie->uf = $uf;
            $ie->inscricao = $inscricao;
            $ie->ativo = $this->ehAtivo($item->ativo ?? false);
            $lista[] = $ie;
        }
        return $lista;
    }

    /**
     * Normaliza e valida um CNPJ, devolvendo apenas os 14 caracteres úteis.
     */
    private function normalizarCnpjDocumento(string $cnpj): string
    {
        $documento = $this->somenteAlfanumerico($cnpj);
        if (strlen($documento) !== 14) {
            throw new LookupException('CNPJ inválido: são esperados 14 caracteres.');
        }
        return $documento;
    }

    /**
     * Converte o campo ativo em bool de forma defensiva. O provedor envia um
     * booleano, mas strings como "0", "false" ou "não" são tratadas como
     * inativas para não declarar uma IE inativa por engano.
     *
     * @param mixed $valor
     */
    private function ehAtivo($valor): bool
    {
        if (is_bool($valor)) {
            return $valor;
        }
        if (is_int($valor)) {
            return $valor === 1;
        }
        $texto = strtolower(trim((string) $valor));
        return in_array($texto, ['1', 'true', 't', 'sim', 's'], true);
    }

    private function somenteDigitos(string $valor): string
    {
        return (string) preg_replace('/\D/', '', $valor);
    }

    private function somenteAlfanumerico(string $valor): string
    {
        return strtoupper((string) preg_replace('/[^0-9A-Za-z]/', '', $valor));
    }
}
