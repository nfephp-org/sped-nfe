<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests\Lookup;

use DOMElement;
use NFePHP\NFe\Lookup\CpfCnpjComBrLookup;
use NFePHP\NFe\Lookup\LookupException;
use NFePHP\NFe\Lookup\Resolver;
use NFePHP\NFe\Make;
use PHPUnit\Framework\TestCase;
use stdClass;

class CpfCnpjComBrLookupTest extends TestCase
{
    private const TOKEN = '5ae973d7a997af13f0aaf2bf60e65803';

    private function corpoCpf(): string
    {
        return json_encode([
            'status' => 1,
            'cpf' => '000.000.000-00',
            'nome' => 'Test Token',
            'nascimento' => '31/12/1900',
            'endereco' => 'Rua A',
            'numero' => '100 B',
            'complemento' => 'Apto 03',
            'bairro' => 'Centro',
            'cep' => '99999123',
            'cidade' => 'Sao Paulo',
            'uf' => 'SP',
            'ibge' => '1234567',
            'pacoteUsado' => 3,
        ], JSON_THROW_ON_ERROR);
    }

    private function corpoCnpj(int $pacote = 5, string $optante = ''): string
    {
        $dados = [
            'status' => 1,
            'cnpj' => '11.222.333/0001-81',
            'tipo' => 'Matriz',
            'razao' => 'TOKEN TEST LTDA',
            'fantasia' => 'TOKEN TEST',
            'matrizEndereco' => [
                'cep' => '0000-111',
                'tipo' => 'Rua',
                'logradouro' => 'Rua A',
                'numero' => '1',
                'complemento' => 'Sala 1',
                'bairro' => 'Centro',
                'cidade' => 'Montes Claros',
                'uf' => 'MG',
            ],
            'ibge' => [
                'estado' => ['id' => 11, 'nome' => 'Minas Gerais', 'sigla' => 'MG', 'ibge_id' => 31],
                'cidade' => ['id' => 2745, 'nome' => 'Montes Claros', 'ibge_id' => 3143302],
            ],
            'pacoteUsado' => $pacote,
        ];
        if ($optante !== '') {
            $dados['simplesNacional'] = ['optante' => $optante];
        }
        return json_encode($dados, JSON_THROW_ON_ERROR);
    }

    /**
     * Corpo de resposta do pacote 16 (inscrições estaduais).
     *
     * @param array<int, array{sigla:string, ativo:bool, inscricao?:string}> $inscricoes
     */
    private function corpoIe(array $inscricoes): string
    {
        static $siglaParaId = [
            'MG' => ['id' => 11, 'nome' => 'Minas Gerais', 'ibge_id' => 31],
            'GO' => ['id' => 9, 'nome' => 'Goias', 'ibge_id' => 52],
            'SP' => ['id' => 26, 'nome' => 'Sao Paulo', 'ibge_id' => 35],
        ];
        $lista = [];
        foreach ($inscricoes as $indice => $inscricao) {
            $sigla = $inscricao['sigla'];
            $estado = $siglaParaId[$sigla] ?? ['id' => 0, 'nome' => $sigla, 'ibge_id' => 0];
            $lista[] = [
                'inscricao_estadual' => $inscricao['inscricao'] ?? ('10394773' . $indice),
                'ativo' => $inscricao['ativo'],
                'atualizado_em' => '2026-01-10 12:00:00',
                'estado' => [
                    'id' => $estado['id'],
                    'nome' => $estado['nome'],
                    'sigla' => $sigla,
                    'ibge_id' => $estado['ibge_id'],
                ],
            ];
        }
        return json_encode([
            'status' => 1,
            'cnpj' => '11.222.333/0001-81',
            'razao' => 'TOKEN TEST LTDA',
            'inscricoesEstaduais' => $lista,
        ], JSON_THROW_ON_ERROR);
    }

    /**
     * @param array<int, array{status:int, body:string}> $respostas
     */
    private function lookup(array $respostas, int $pacoteCpf = 3, int $pacoteCnpj = 5): CpfCnpjComBrLookup
    {
        return new CpfCnpjComBrLookup(
            self::TOKEN,
            new FakeHttpTransport($respostas),
            $pacoteCpf,
            $pacoteCnpj
        );
    }

    public function testConsultarCpfNormalizaOsCampos(): void
    {
        $lookup = $this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]);
        $dados = $lookup->consultarCpf('000.000.000-00');

        $this->assertSame('CPF', $dados->tipo);
        $this->assertSame('00000000000', $dados->documento);
        $this->assertSame('Test Token', $dados->nome);
        $this->assertSame('Rua A', $dados->logradouro);
        $this->assertSame('100 B', $dados->numero);
        $this->assertSame('Apto 03', $dados->complemento);
        $this->assertSame('Centro', $dados->bairro);
        $this->assertSame('99999123', $dados->cep);
        $this->assertSame('Sao Paulo', $dados->municipio);
        $this->assertSame('SP', $dados->uf);
        $this->assertNull($dados->simplesNacionalOptante);
        $this->assertInstanceOf(stdClass::class, $dados->bruto);
    }

    public function testCodigoMunicipioCpfTemSeteDigitos(): void
    {
        $lookup = $this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]);
        $dados = $lookup->consultarCpf('00000000000');

        $this->assertSame('1234567', $dados->codigoMunicipio);
        $this->assertSame(7, strlen((string) $dados->codigoMunicipio));
    }

    public function testResolverPorCpfMontaStdClassParaTagdest(): void
    {
        $resolver = new Resolver($this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]));
        $std = $resolver->porCpf('000.000.000-00');

        $this->assertSame('Test Token', $std->xNome);
        $this->assertSame('00000000000', $std->CPF);
        $this->assertFalse(property_exists($std, 'CNPJ'));
        $this->assertSame('Rua A', $std->xLgr);
        $this->assertSame('100 B', $std->nro);
        $this->assertSame('Apto 03', $std->xCpl);
        $this->assertSame('Centro', $std->xBairro);
        $this->assertSame('1234567', $std->cMun);
        $this->assertSame('Sao Paulo', $std->xMun);
        $this->assertSame('SP', $std->UF);
        $this->assertSame('99999123', $std->CEP);
    }

    public function testResolverNuncaPreencheIeImIndIEDest(): void
    {
        $resolver = new Resolver($this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]));
        $std = $resolver->porCpf('00000000000');

        $this->assertFalse(property_exists($std, 'IE'));
        $this->assertFalse(property_exists($std, 'IM'));
        $this->assertFalse(property_exists($std, 'indIEDest'));
        $this->assertFalse(property_exists($std, 'ISUF'));
    }

    public function testConsultarCnpjNormalizaOsCampos(): void
    {
        $lookup = $this->lookup([['status' => 200, 'body' => $this->corpoCnpj()]]);
        $dados = $lookup->consultarCnpj('11.222.333/0001-81');

        $this->assertSame('CNPJ', $dados->tipo);
        $this->assertSame('11222333000181', $dados->documento);
        $this->assertSame('TOKEN TEST LTDA', $dados->nome);
        $this->assertSame('TOKEN TEST', $dados->fantasia);
        $this->assertSame('Rua A', $dados->logradouro);
        $this->assertSame('1', $dados->numero);
        $this->assertSame('Sala 1', $dados->complemento);
        $this->assertSame('Centro', $dados->bairro);
        $this->assertSame('0000111', $dados->cep);
        $this->assertSame('Montes Claros', $dados->municipio);
        $this->assertSame('3143302', $dados->codigoMunicipio);
        $this->assertSame('MG', $dados->uf);
        $this->assertNull($dados->simplesNacionalOptante);
    }

    public function testCodigoMunicipioCnpjVemDoIbgeCidade(): void
    {
        $lookup = $this->lookup([['status' => 200, 'body' => $this->corpoCnpj()]]);
        $dados = $lookup->consultarCnpj('11222333000181');

        $this->assertSame('3143302', $dados->codigoMunicipio);
        $this->assertSame(7, strlen((string) $dados->codigoMunicipio));
    }

    public function testResolverPorCnpjMontaStdClassParaTagdest(): void
    {
        $resolver = new Resolver($this->lookup([['status' => 200, 'body' => $this->corpoCnpj()]]));
        $std = $resolver->porCnpj('11.222.333/0001-81');

        $this->assertSame('TOKEN TEST LTDA', $std->xNome);
        $this->assertSame('11222333000181', $std->CNPJ);
        $this->assertFalse(property_exists($std, 'CPF'));
        $this->assertSame('Rua A', $std->xLgr);
        $this->assertSame('3143302', $std->cMun);
        $this->assertSame('Montes Claros', $std->xMun);
        $this->assertSame('MG', $std->UF);
    }

    public function testPacoteSeisDerivaSimplesNacionalNao(): void
    {
        $lookup = $this->lookup(
            [['status' => 200, 'body' => $this->corpoCnpj(6, 'Não')]],
            3,
            6
        );
        $dados = $lookup->consultarCnpj('11222333000181');

        $this->assertFalse($dados->simplesNacionalOptante);
        $this->assertSame(6, $dados->pacote);
    }

    public function testPacoteSeisDerivaSimplesNacionalSim(): void
    {
        $lookup = $this->lookup(
            [['status' => 200, 'body' => $this->corpoCnpj(6, 'Sim')]],
            3,
            6
        );
        $dados = $lookup->consultarCnpj('11222333000181');

        $this->assertTrue($dados->simplesNacionalOptante);
    }

    public function testUrlIncluiTokenPacoteEDocumento(): void
    {
        $transport = new FakeHttpTransport([['status' => 200, 'body' => $this->corpoCpf()]]);
        $lookup = new CpfCnpjComBrLookup(self::TOKEN, $transport, 3, 5);
        $lookup->consultarCpf('000.000.000-00');

        $this->assertSame(
            'https://api.cpfcnpj.com.br/' . self::TOKEN . '/3/00000000000',
            $transport->ultimaUrl
        );
    }

    public function testStatusZeroLancaExcecaoComCodigo(): void
    {
        $corpo = json_encode([
            'status' => 0,
            'erro' => 'Token não pertence ao IP de origem',
            'erroCodigo' => 1000,
        ], JSON_THROW_ON_ERROR);
        $lookup = $this->lookup([['status' => 200, 'body' => $corpo]]);

        $this->expectException(LookupException::class);
        $this->expectExceptionMessageMatches('/1000/');
        $lookup->consultarCpf('00000000000');
    }

    public function testErroHttpLancaExcecao(): void
    {
        $lookup = $this->lookup([['status' => 500, 'body' => '']]);

        $this->expectException(LookupException::class);
        $this->expectExceptionMessageMatches('/500/');
        $lookup->consultarCpf('00000000000');
    }

    public function testRespostaNaoJsonLancaExcecao(): void
    {
        $lookup = $this->lookup([['status' => 200, 'body' => 'isto nao e json']]);

        $this->expectException(LookupException::class);
        $lookup->consultarCnpj('11222333000181');
    }

    public function testCpfComTamanhoInvalidoLancaExcecao(): void
    {
        $lookup = $this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]);

        $this->expectException(LookupException::class);
        $lookup->consultarCpf('123');
    }

    public function testResolverPorDocumentoInvalidoLancaExcecao(): void
    {
        $resolver = new Resolver($this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]));

        $this->expectException(LookupException::class);
        $resolver->porDocumento('123');
    }

    public function testPorDocumentoRoteiaPorTamanho(): void
    {
        $resolverCpf = new Resolver($this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]));
        $porCpf = $resolverCpf->porDocumento('000.000.000-00');
        $this->assertSame('00000000000', $porCpf->CPF);
        $this->assertFalse(property_exists($porCpf, 'CNPJ'));

        $resolverCnpj = new Resolver($this->lookup([['status' => 200, 'body' => $this->corpoCnpj()]]));
        $porCnpj = $resolverCnpj->porDocumento('11.222.333/0001-81');
        $this->assertSame('11222333000181', $porCnpj->CNPJ);
        $this->assertFalse(property_exists($porCnpj, 'CPF'));
    }

    public function testCnpjSemMatrizEnderecoNaoQuebraEUsaIbgeParaCMun(): void
    {
        $corpo = json_encode([
            'status' => 1,
            'cnpj' => '11.222.333/0001-81',
            'razao' => 'TOKEN TEST LTDA',
            'ibge' => [
                'cidade' => ['id' => 2745, 'nome' => 'Montes Claros', 'ibge_id' => 3143302],
            ],
        ], JSON_THROW_ON_ERROR);
        $lookup = $this->lookup([['status' => 200, 'body' => $corpo]]);
        $dados = $lookup->consultarCnpj('11222333000181');

        $this->assertNull($dados->logradouro);
        $this->assertNull($dados->numero);
        $this->assertNull($dados->bairro);
        $this->assertNull($dados->cep);
        $this->assertNull($dados->uf);
        $this->assertSame('3143302', $dados->codigoMunicipio);
        $this->assertSame('Montes Claros', $dados->municipio);
    }

    public function testCnpjSemIbgeMantemCMunNulo(): void
    {
        $corpo = json_encode([
            'status' => 1,
            'cnpj' => '11.222.333/0001-81',
            'razao' => 'TOKEN TEST LTDA',
            'matrizEndereco' => [
                'logradouro' => 'Rua A',
                'cidade' => 'Montes Claros',
                'uf' => 'MG',
            ],
        ], JSON_THROW_ON_ERROR);
        $lookup = $this->lookup([['status' => 200, 'body' => $corpo]]);
        $dados = $lookup->consultarCnpj('11222333000181');

        $this->assertNull($dados->codigoMunicipio);
        $this->assertSame('Montes Claros', $dados->municipio);
        $this->assertSame('Rua A', $dados->logradouro);
    }

    public function testCpfSemEnderecoMantemCamposNulos(): void
    {
        $corpo = json_encode([
            'status' => 1,
            'cpf' => '000.000.000-00',
            'nome' => 'Test Token',
        ], JSON_THROW_ON_ERROR);
        $lookup = $this->lookup([['status' => 200, 'body' => $corpo]]);
        $dados = $lookup->consultarCpf('00000000000');

        $this->assertSame('Test Token', $dados->nome);
        $this->assertNull($dados->logradouro);
        $this->assertNull($dados->cep);
        $this->assertNull($dados->municipio);
        $this->assertNull($dados->codigoMunicipio);
        $this->assertNull($dados->uf);
    }

    public function testCnpjAlfanumericoENormalizadoNaUrl(): void
    {
        $transport = new FakeHttpTransport([['status' => 200, 'body' => $this->corpoCnpj()]]);
        $lookup = new CpfCnpjComBrLookup(self::TOKEN, $transport, 3, 5);
        $dados = $lookup->consultarCnpj('12.abc.345/01de-35');

        $this->assertSame('12ABC34501DE35', $dados->documento);
        $this->assertSame(
            'https://api.cpfcnpj.com.br/' . self::TOKEN . '/5/12ABC34501DE35',
            $transport->ultimaUrl
        );
    }

    public function testIntegracaoComMakeNaNfce(): void
    {
        $resolver = new Resolver($this->lookup([['status' => 200, 'body' => $this->corpoCpf()]]));
        $dest = $resolver->porCpf('000.000.000-00');

        $make = $this->makeNfce();
        $elDest = $make->tagdest($dest);
        $elEnder = $make->tagenderDest($dest);

        $this->assertInstanceOf(DOMElement::class, $elDest);
        $this->assertInstanceOf(DOMElement::class, $elEnder);

        $xml = (string) $elDest->ownerDocument->saveXML($elDest);
        $this->assertStringContainsString('<indIEDest>9</indIEDest>', $xml);
        $this->assertStringContainsString('<CPF>00000000000</CPF>', $xml);
        $this->assertStringContainsString('<cMun>1234567</cMun>', $xml);
        $this->assertStringNotContainsString('<IE>', $xml);
    }

    public function testConsultarInscricoesEstaduaisNormalizaOsCampos(): void
    {
        $corpo = $this->corpoIe([
            ['sigla' => 'GO', 'ativo' => true, 'inscricao' => '103947736'],
            ['sigla' => 'SP', 'ativo' => false, 'inscricao' => '111222333'],
        ]);
        $lookup = $this->lookup([['status' => 200, 'body' => $corpo]]);
        $inscricoes = $lookup->consultarInscricoesEstaduais('11.222.333/0001-81');

        $this->assertCount(2, $inscricoes);
        $this->assertSame('GO', $inscricoes[0]->uf);
        $this->assertSame('103947736', $inscricoes[0]->inscricao);
        $this->assertTrue($inscricoes[0]->ativo);
        $this->assertSame('SP', $inscricoes[1]->uf);
        $this->assertFalse($inscricoes[1]->ativo);
    }

    public function testUrlDaInscricaoEstadualUsaPacoteDezesseis(): void
    {
        $transport = new FakeHttpTransport([
            ['status' => 200, 'body' => $this->corpoIe([['sigla' => 'MG', 'ativo' => true]])],
        ]);
        $lookup = new CpfCnpjComBrLookup(self::TOKEN, $transport, 3, 5);
        $lookup->consultarInscricoesEstaduais('11.222.333/0001-81');

        $this->assertSame(
            'https://api.cpfcnpj.com.br/' . self::TOKEN . '/16/11222333000181',
            $transport->ultimaUrl
        );
    }

    public function testInscricaoEstadualSemBlocoDevolveListaVazia(): void
    {
        $corpo = json_encode([
            'status' => 1,
            'cnpj' => '11.222.333/0001-81',
            'razao' => 'TOKEN TEST LTDA',
        ], JSON_THROW_ON_ERROR);
        $lookup = $this->lookup([['status' => 200, 'body' => $corpo]]);

        $this->assertSame([], $lookup->consultarInscricoesEstaduais('11222333000181'));
    }

    public function testInscricaoEstadualComAtivoStringFalsyEhTratadaComoInativa(): void
    {
        $corpo = json_encode([
            'status' => 1,
            'cnpj' => '11.222.333/0001-81',
            'razao' => 'TOKEN TEST LTDA',
            'inscricoesEstaduais' => [
                [
                    'inscricao_estadual' => '103947736',
                    'ativo' => 'false',
                    'estado' => ['id' => 11, 'nome' => 'Minas Gerais', 'sigla' => 'MG', 'ibge_id' => 31],
                ],
                [
                    'inscricao_estadual' => '900000000',
                    'ativo' => '1',
                    'estado' => ['id' => 9, 'nome' => 'Goias', 'sigla' => 'GO', 'ibge_id' => 52],
                ],
            ],
        ], JSON_THROW_ON_ERROR);
        $lookup = $this->lookup([['status' => 200, 'body' => $corpo]]);
        $inscricoes = $lookup->consultarInscricoesEstaduais('11222333000181');

        $this->assertFalse($inscricoes[0]->ativo);
        $this->assertTrue($inscricoes[1]->ativo);
    }

    public function testResolverComInscricaoEstadualPreencheIeAtivaDaUf(): void
    {
        $resolver = (new Resolver($this->lookup([
            ['status' => 200, 'body' => $this->corpoCnpj()],
            ['status' => 200, 'body' => $this->corpoIe([
                ['sigla' => 'MG', 'ativo' => true, 'inscricao' => '0011234567'],
            ])],
        ])))->comInscricaoEstadual();

        $std = $resolver->porCnpj('11.222.333/0001-81');

        $this->assertSame('0011234567', $std->IE);
        $this->assertSame('1', $std->indIEDest);
    }

    public function testResolverEscolheIeDaUfCertaEntreVariasUfs(): void
    {
        $resolver = (new Resolver($this->lookup([
            ['status' => 200, 'body' => $this->corpoCnpj()],
            ['status' => 200, 'body' => $this->corpoIe([
                ['sigla' => 'GO', 'ativo' => true, 'inscricao' => '900000000'],
                ['sigla' => 'MG', 'ativo' => true, 'inscricao' => '0022334455'],
                ['sigla' => 'SP', 'ativo' => true, 'inscricao' => '700000000'],
            ])],
        ])))->comInscricaoEstadual();

        $std = $resolver->porCnpj('11222333000181');

        $this->assertSame('0022334455', $std->IE);
        $this->assertSame('1', $std->indIEDest);
    }

    public function testResolverIgnoraIeInativaDaUf(): void
    {
        $resolver = (new Resolver($this->lookup([
            ['status' => 200, 'body' => $this->corpoCnpj()],
            ['status' => 200, 'body' => $this->corpoIe([
                ['sigla' => 'MG', 'ativo' => false, 'inscricao' => '0033445566'],
            ])],
        ])))->comInscricaoEstadual();

        $std = $resolver->porCnpj('11222333000181');

        $this->assertFalse(property_exists($std, 'IE'));
        $this->assertFalse(property_exists($std, 'indIEDest'));
    }

    public function testResolverSemIeParaUfNaoPreenche(): void
    {
        $resolver = (new Resolver($this->lookup([
            ['status' => 200, 'body' => $this->corpoCnpj()],
            ['status' => 200, 'body' => $this->corpoIe([
                ['sigla' => 'GO', 'ativo' => true],
                ['sigla' => 'SP', 'ativo' => true],
            ])],
        ])))->comInscricaoEstadual();

        $std = $resolver->porCnpj('11222333000181');

        $this->assertFalse(property_exists($std, 'IE'));
        $this->assertFalse(property_exists($std, 'indIEDest'));
    }

    public function testResolverSemFlagNaoConsultaIeEComportamentoIdentico(): void
    {
        $resolver = new Resolver($this->lookup([
            ['status' => 200, 'body' => $this->corpoCnpj()],
        ]));

        $std = $resolver->porCnpj('11222333000181');

        $this->assertSame('11222333000181', $std->CNPJ);
        $this->assertFalse(property_exists($std, 'IE'));
        $this->assertFalse(property_exists($std, 'indIEDest'));
    }

    public function testResolverComInscricaoEstadualPropagaErroDoPacoteDezesseis(): void
    {
        $corpoErro = json_encode([
            'status' => 0,
            'erro' => 'Pacote nao contratado',
            'erroCodigo' => 1005,
        ], JSON_THROW_ON_ERROR);
        $resolver = (new Resolver($this->lookup([
            ['status' => 200, 'body' => $this->corpoCnpj()],
            ['status' => 200, 'body' => $corpoErro],
        ])))->comInscricaoEstadual();

        $this->expectException(LookupException::class);
        $this->expectExceptionMessageMatches('/1005/');
        $resolver->porCnpj('11222333000181');
    }

    public function testIntegracaoComMakeNaNfeContribuinte(): void
    {
        $resolver = (new Resolver($this->lookup([
            ['status' => 200, 'body' => $this->corpoCnpj()],
            ['status' => 200, 'body' => $this->corpoIe([
                ['sigla' => 'MG', 'ativo' => true, 'inscricao' => '0044556677'],
            ])],
        ])))->comInscricaoEstadual();
        $dest = $resolver->porCnpj('11.222.333/0001-81');

        $make = $this->makeNfe();
        $elDest = $make->tagdest($dest);
        $make->tagenderDest($dest);

        $xml = (string) $elDest->ownerDocument->saveXML($elDest);
        $this->assertStringContainsString('<indIEDest>1</indIEDest>', $xml);
        $this->assertStringContainsString('<IE>0044556677</IE>', $xml);
        $this->assertStringContainsString('<CNPJ>11222333000181</CNPJ>', $xml);
    }

    private function makeNfe(): Make
    {
        $make = new Make();

        $std = new stdClass();
        $std->Id = null;
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '31';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '55';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2026-01-15T10:00:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3143302';
        $std->tpImp = '1';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '1';
        $std->finNFe = '1';
        $std->indFinal = '0';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        return $make;
    }

    private function makeNfce(): Make
    {
        $make = new Make();

        $std = new stdClass();
        $std->Id = null;
        $std->versao = '4.00';
        $make->taginfNFe($std);

        $std = new stdClass();
        $std->cUF = '35';
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = '65';
        $std->serie = '1';
        $std->nNF = '1';
        $std->dhEmi = '2026-01-15T10:00:00-03:00';
        $std->tpNF = '1';
        $std->idDest = '1';
        $std->cMunFG = '3550308';
        $std->tpImp = '4';
        $std->tpEmis = '1';
        $std->cDV = '0';
        $std->tpAmb = '1';
        $std->finNFe = '1';
        $std->indFinal = '1';
        $std->indPres = '1';
        $std->procEmi = '0';
        $std->verProc = '5.0';
        $make->tagide($std);

        return $make;
    }
}
