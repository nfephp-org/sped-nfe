<?php

declare(strict_types=1);

namespace NFePHP\NFe\Tests;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Complements;
use NFePHP\NFe\Exception\DocumentsException;
use NFePHP\NFe\Factories\QRCode;
use NFePHP\NFe\Make;
use NFePHP\NFe\Tests\Common\ToolsFake;

class CommunicationCoverageTest extends NFeTestCase
{
    protected ToolsFake $tools;

    protected function setUp(): void
    {
        $this->tools = new ToolsFake(
            $this->configJson,
            Certificate::readPfx($this->contentpfx, $this->passwordpfx)
        );
    }

    // ──────────────────────────────────────────────────────────────────────
    //  1. sefazEnviaLote
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_envia_lote_modelo_55_sincrono(): void
    {
        $xml = $this->loadFixture('exemplo_xml_envia_lote_modelo_55.xml');
        $this->setSuccessReturn();
        $idLote = '9999999';
        $resp = $this->tools->sefazEnviaLote([$xml], $idLote, 1);
        $this->assertIsString($resp);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<idLote>9999999</idLote>', $request);
        $this->assertStringContainsString('<indSinc>1</indSinc>', $request);
    }

    public function test_sefaz_envia_lote_modelo_55_assincrono(): void
    {
        $xml = $this->loadFixture('exemplo_xml_envia_lote_modelo_55.xml');
        $this->setSuccessReturn();
        $resp = $this->tools->sefazEnviaLote([$xml], '888', 0);
        $this->assertIsString($resp);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<indSinc>0</indSinc>', $request);
    }

    public function test_sefaz_envia_lote_modelo_65_sincrono(): void
    {
        $xml = $this->loadFixture('exemplo_xml_envia_lote_modelo_65.xml');
        $this->tools->model(65);
        $this->setSuccessReturn();
        $resp = $this->tools->sefazEnviaLote([$xml], '777', 1);
        $this->assertIsString($resp);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<idLote>777</idLote>', $request);
    }

    public function test_sefaz_envia_lote_modelo_65_assincrono(): void
    {
        $xml = $this->loadFixture('exemplo_xml_envia_lote_modelo_65.xml');
        $this->tools->model(65);
        $this->setSuccessReturn();
        $resp = $this->tools->sefazEnviaLote([$xml], '666', 0);
        $this->assertIsString($resp);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<indSinc>0</indSinc>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  2. sefazConsultaRecibo
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_consulta_recibo_valido(): void
    {
        $this->tools->sefazConsultaRecibo('143220020730398');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<nRec>143220020730398</nRec>', $request);
        $this->assertStringContainsString('consReciNFe', $request);
    }

    public function test_sefaz_consulta_recibo_com_tpAmb(): void
    {
        $this->tools->sefazConsultaRecibo('143220020730398', 1);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<tpAmb>1</tpAmb>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  3. sefazConsultaChave
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_consulta_chave_valida(): void
    {
        $this->tools->sefazConsultaChave('43211105730928000145650010000002401717268120');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString(
            '<chNFe>43211105730928000145650010000002401717268120</chNFe>',
            $request
        );
        $this->assertStringContainsString('consSitNFe', $request);
    }

    public function test_sefaz_consulta_chave_44_digitos_diferente_uf(): void
    {
        // chave com cUF=35 (SP) deve funcionar pois usa UF da chave
        $this->tools->sefazConsultaChave('35220605730928000145550010000048661583302923');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('35220605730928000145550010000048661583302923', $request);
    }

    public function test_sefaz_consulta_chave_vazia_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('');
    }

    public function test_sefaz_consulta_chave_curta_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('1234567890123456789012345678901234567890123');
    }

    public function test_sefaz_consulta_chave_nao_numerica_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA');
    }

    public function test_sefaz_consulta_chave_longa_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazConsultaChave('123456789012345678901234567890123456789012345');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  4. sefazInutiliza
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_inutiliza_serie_1(): void
    {
        $this->tools->sefazInutiliza(1, 1, 10, 'Testando Inutilizacao', 1, '22');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('inutNFe', $request);
        $this->assertStringContainsString('<nNFIni>1</nNFIni>', $request);
        $this->assertStringContainsString('<nNFFin>10</nNFFin>', $request);
    }

    public function test_sefaz_inutiliza_serie_diferente(): void
    {
        $this->tools->sefazInutiliza(5, 100, 200, 'Justificativa de teste', 2, '24');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<serie>5</serie>', $request);
        $this->assertStringContainsString('<nNFIni>100</nNFIni>', $request);
        $this->assertStringContainsString('<nNFFin>200</nNFFin>', $request);
        $this->assertStringContainsString('<tpAmb>2</tpAmb>', $request);
    }

    public function test_sefaz_inutiliza_sem_ano(): void
    {
        $this->tools->sefazInutiliza(1, 50, 60, 'Justificativa sem ano');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<ano>' . date('y') . '</ano>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  5. sefazStatus
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_status_uf_rs(): void
    {
        $this->tools->sefazStatus('RS');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('consStatServ', $request);
        $this->assertStringContainsString('<xServ>STATUS</xServ>', $request);
    }

    public function test_sefaz_status_uf_sp(): void
    {
        $this->tools->sefazStatus('SP');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('consStatServ', $request);
    }

    public function test_sefaz_status_sem_uf_usa_config(): void
    {
        $this->tools->sefazStatus('');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('consStatServ', $request);
    }

    public function test_sefaz_status_com_tpAmb(): void
    {
        $this->tools->sefazStatus('SP', 1);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<tpAmb>1</tpAmb>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  6. sefazDistDFe
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_dist_dfe_com_ultNSU(): void
    {
        $this->tools->sefazDistDFe(100);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('distDFeInt', $request);
        $this->assertStringContainsString('<ultNSU>000000000000100</ultNSU>', $request);
    }

    public function test_sefaz_dist_dfe_com_numNSU(): void
    {
        $this->tools->sefazDistDFe(0, 500);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<NSU>000000000000500</NSU>', $request);
    }

    public function test_sefaz_dist_dfe_com_chave(): void
    {
        $chave = '35220605730928000145550010000048661583302923';
        $this->tools->sefazDistDFe(0, 0, $chave);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString("<chNFe>$chave</chNFe>", $request);
        $this->assertStringContainsString('consChNFe', $request);
    }

    public function test_sefaz_dist_dfe_ultNSU_zero(): void
    {
        $this->tools->sefazDistDFe(0);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<ultNSU>000000000000000</ultNSU>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    //  7. sefazCCe
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_cce_request(): void
    {
        $chave = '35220605730928000145550010000048661583302923';
        $xCorrecao = 'Descricao da correcao';
        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $this->tools->sefazCCe($chave, $xCorrecao, 1, $dhEvento, '12345');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Carta de Correcao', $request);
        $this->assertStringContainsString($chave, $request);
        $this->assertStringContainsString('<xCorrecao>', $request);
        $this->assertStringContainsString('<xCondUso>', $request);
    }

    public function test_sefaz_cce_chave_vazia_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazCCe('', 'motivo');
    }

    public function test_sefaz_cce_correcao_vazia_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazCCe('35220605730928000145550010000048661583302923', '');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  8. sefazCancela
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_cancela_request(): void
    {
        $chNFe = '35150300822602000124550010009923461099234656';
        $xJust = 'Preenchimento incorreto dos dados';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $nProt = '123456789101234';
        $this->tools->sefazCancela($chNFe, $xJust, $nProt, $dhEvento, '123');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Cancelamento', $request);
        $this->assertStringContainsString('<nProt>123456789101234</nProt>', $request);
        $this->assertStringContainsString($chNFe, $request);
    }

    public function test_sefaz_cancela_chave_vazia_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazCancela('', 'just', 'prot');
    }

    public function test_sefaz_cancela_just_vazia_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazCancela('35150300822602000124550010009923461099234656', '', 'prot');
    }

    // ──────────────────────────────────────────────────────────────────────
    //  9. sefazCancelaPorSubstituicao
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_cancela_por_substituicao_modelo_55_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->model(55);
        $this->tools->sefazCancelaPorSubstituicao(
            '35240305730928000145650010000001421071400478',
            'Justificativa',
            '123456789101234',
            '35240305730928000145650010000001421071400478',
            '1'
        );
    }

    public function test_sefaz_cancela_por_substituicao_modelo_65(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $this->tools->model(65);
        $this->tools->sefazCancelaPorSubstituicao(
            $chNFe,
            'Preenchimento incorreto',
            '123456789101234',
            $chNFe,
            '1',
            $dhEvento,
            '123'
        );
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Cancelamento por substituicao', $request);
        $this->assertStringContainsString('<chNFeRef>' . $chNFe . '</chNFeRef>', $request);
    }

    public function test_sefaz_cancela_por_substituicao_parametros_vazios_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->model(65);
        $this->tools->sefazCancelaPorSubstituicao(
            '35240305730928000145650010000001421071400478',
            'just',
            '123456789101234',
            '35240305730928000145650010000001421071400478',
            '' // verAplic vazio e this->verAplic vazio
        );
    }

    // ──────────────────────────────────────────────────────────────────────
    // 10. sefazManifesta (all 4 event types)
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_manifesta_confirmacao(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $this->tools->sefazManifesta($chNFe, 210200, '', 1, $dhEvento, '123');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Confirmacao da Operacao', $request);
        $this->assertStringContainsString('<tpEvento>210200</tpEvento>', $request);
    }

    public function test_sefaz_manifesta_ciencia(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $this->tools->sefazManifesta($chNFe, 210210, '', 1, $dhEvento, '456');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Ciencia da Operacao', $request);
        $this->assertStringContainsString('<tpEvento>210210</tpEvento>', $request);
    }

    public function test_sefaz_manifesta_desconhecimento(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $this->tools->sefazManifesta($chNFe, 210220, '', 1, $dhEvento, '789');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Desconhecimento da Operacao', $request);
        $this->assertStringContainsString('<tpEvento>210220</tpEvento>', $request);
    }

    public function test_sefaz_manifesta_nao_realizada(): void
    {
        $chNFe = '35240305730928000145650010000001421071400478';
        $xJust = 'Operacao nao foi realizada conforme esperado';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $this->tools->sefazManifesta($chNFe, 210240, $xJust, 1, $dhEvento, '101');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Operacao nao Realizada', $request);
        $this->assertStringContainsString('<tpEvento>210240</tpEvento>', $request);
        $this->assertStringContainsString('<xJust>', $request);
    }

    public function test_sefaz_manifesta_chave_vazia_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->sefazManifesta('', 210200);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 11. sefazEvento (generic)
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_evento_generico(): void
    {
        $chNFe = '35220605730928000145550010000048661583302923';
        $dhEvento = new \DateTime('2024-05-31T11:59:12-03:00');
        $xCondUso = 'A Carta de Correcao e disciplinada pelo paragrafo '
            . '1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 '
            . 'e pode ser utilizada para regularizacao de erro ocorrido '
            . 'na emissao de documento fiscal, desde que o erro nao esteja '
            . 'relacionado com: I - as variaveis que determinam o valor '
            . 'do imposto tais como: base de calculo, aliquota, '
            . 'diferenca de preco, quantidade, valor da operacao ou da '
            . 'prestacao; II - a correcao de dados cadastrais que implique '
            . 'mudanca do remetente ou do destinatario; III - a data de '
            . 'emissao ou de saida.';
        $tagAdic = '<xCorrecao>Correcao da descricao do produto constante na nota fiscal</xCorrecao>'
            . "<xCondUso>$xCondUso</xCondUso>";
        $this->tools->sefazEvento('SP', $chNFe, 110110, 1, $tagAdic, $dhEvento, '999');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('envEvento', $request);
        $this->assertStringContainsString('<idLote>999</idLote>', $request);
        $this->assertStringContainsString($chNFe, $request);
    }

    public function test_sefaz_evento_cancela_com_lote_automatico(): void
    {
        $chNFe = '35150300822602000124550010009923461099234656';
        $dhEvento = new \DateTime('2024-02-01 14:07:05 -03:00');
        $tagAdic = '<nProt>123456789101234</nProt>'
            . '<xJust>Preenchimento incorreto dos dados da nota fiscal</xJust>';
        $this->tools->sefazEvento('SP', $chNFe, 110111, 1, $tagAdic, $dhEvento, null);
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<idLote>', $request);
        $this->assertStringContainsString('Cancelamento', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 12. sefazComprovanteEntrega
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_comprovante_entrega(): void
    {
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->verAplic = '1.0';
        $std->data_recebimento = '2024-01-15T10:30:00-03:00';
        $std->documento_recebedor = '12345678901';
        $std->nome_recebedor = 'Fulano de Tal';
        $std->latitude = '-23.550500';
        $std->longitude = '-46.633300';
        $std->imagem = 'base64imagedata';
        $std->nSeqEvento = 1;
        $std->cancelar = false;
        $dhEvento = new \DateTime('2024-01-15T10:30:00-03:00');

        $this->tools->sefazComprovanteEntrega($std, $dhEvento, '555');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Comprovante de Entrega da NF-e', $request);
        $this->assertStringContainsString('<dhEntrega>', $request);
        $this->assertStringContainsString('<nDoc>12345678901</nDoc>', $request);
        $this->assertStringContainsString('<xNome>Fulano de Tal</xNome>', $request);
        $this->assertStringContainsString('<latGPS>', $request);
        $this->assertStringContainsString('<longGPS>', $request);
        $this->assertStringContainsString('<hashComprovante>', $request);
    }

    public function test_sefaz_comprovante_entrega_sem_gps(): void
    {
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->verAplic = '1.0';
        $std->data_recebimento = '2024-01-15T10:30:00-03:00';
        $std->documento_recebedor = '12345678901';
        $std->nome_recebedor = 'Beltrano';
        $std->latitude = '';
        $std->longitude = '';
        $std->imagem = 'base64imagedata';
        $std->nSeqEvento = 1;
        $std->cancelar = false;
        $dhEvento = new \DateTime('2024-01-15T10:30:00-03:00');

        $this->tools->sefazComprovanteEntrega($std, $dhEvento, '556');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Comprovante de Entrega da NF-e', $request);
        $this->assertStringNotContainsString('<latGPS>', $request);
    }

    public function test_sefaz_comprovante_entrega_cancelamento(): void
    {
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->verAplic = '1.0';
        $std->nProcEvento = '135220000001234';
        $std->imagem = 'base64imagedata';
        $std->nSeqEvento = 1;
        $std->cancelar = true;
        $dhEvento = new \DateTime('2024-01-15T10:30:00-03:00');

        $this->tools->sefazComprovanteEntrega($std, $dhEvento, '557');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Cancelamento Comprovante de Entrega da NF-e', $request);
        $this->assertStringContainsString('<nProtEvento>135220000001234</nProtEvento>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 13. sefazInsucessoEntrega
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_insucesso_entrega(): void
    {
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->verAplic = '1.0';
        $std->data_tentativa = '2024-01-15T10:30:00-03:00';
        $std->tentativas = 3;
        $std->tipo_motivo = 1;
        $std->justificativa = '';
        $std->latitude = '-23.550500';
        $std->longitude = '-46.633300';
        $std->imagem = 'base64imagedata';
        $std->nSeqEvento = 1;
        $std->cancelar = false;
        $dhEvento = new \DateTime('2024-01-15T10:30:00-03:00');

        $this->tools->sefazInsucessoEntrega($std, $dhEvento, '558');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Insucesso na Entrega da NF-e', $request);
        $this->assertStringContainsString('<dhTentativaEntrega>', $request);
        $this->assertStringContainsString('<nTentativa>3</nTentativa>', $request);
        $this->assertStringContainsString('<tpMotivo>1</tpMotivo>', $request);
        $this->assertStringContainsString('<latGPS>', $request);
    }

    public function test_sefaz_insucesso_entrega_motivo_4_com_justificativa(): void
    {
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->verAplic = '1.0';
        $std->data_tentativa = '2024-01-15T10:30:00-03:00';
        $std->tentativas = 1;
        $std->tipo_motivo = 4;
        $std->justificativa = 'Endereco nao encontrado pelo entregador no local indicado';
        $std->latitude = '';
        $std->longitude = '';
        $std->imagem = 'base64imagedata';
        $std->nSeqEvento = 1;
        $std->cancelar = false;
        $dhEvento = new \DateTime('2024-01-15T10:30:00-03:00');

        $this->tools->sefazInsucessoEntrega($std, $dhEvento, '559');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<tpMotivo>4</tpMotivo>', $request);
        $this->assertStringContainsString('<xJustMotivo>Endereco nao encontrado pelo entregador no local indicado</xJustMotivo>', $request);
    }

    public function test_sefaz_insucesso_entrega_cancelamento(): void
    {
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->verAplic = '1.0';
        $std->protocolo = '135220000005678';
        $std->nSeqEvento = 1;
        $std->cancelar = true;
        $dhEvento = new \DateTime('2024-01-15T10:30:00-03:00');

        $this->tools->sefazInsucessoEntrega($std, $dhEvento, '560');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('Cancelamento Insucesso na Entrega da NF-e', $request);
        $this->assertStringContainsString('<nProtEvento>135220000005678</nProtEvento>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 14. Complements - error cases
    // ──────────────────────────────────────────────────────────────────────

    public function test_complements_to_authorize_wrong_document_type(): void
    {
        $this->expectException(DocumentsException::class);
        // eSocial XML is not NFe/EnvEvento/InutNFe
        $wrongXml = '<eSocial xmlns="http://www.esocial.gov.br/schema/evt/evtAdmPrelim/v02_04_01">'
            . '<evtAdmPrelim Id="test"><ideEvento><tpAmb>2</tpAmb></ideEvento></evtAdmPrelim></eSocial>';
        $response = '<retorno>dummy</retorno>';
        Complements::toAuthorize($wrongXml, $response);
    }

    public function test_complements_to_authorize_empty_request_throws(): void
    {
        $this->expectException(DocumentsException::class);
        Complements::toAuthorize('', '<retorno>dummy</retorno>');
    }

    public function test_complements_to_authorize_empty_response_throws(): void
    {
        $this->expectException(DocumentsException::class);
        $request = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_xml_envia_lote_modelo_55.xml');
        Complements::toAuthorize($request, '');
    }

    public function test_complements_to_authorize_event_xml(): void
    {
        // Build a minimal envEvento request and matching retEnvEvento response
        $request = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<envEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<idLote>201704091147536</idLote>'
            . '<evento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<infEvento Id="ID21021035220605730928000145550010000048661583302923001">'
            . '<cOrgao>91</cOrgao>'
            . '<tpAmb>2</tpAmb>'
            . '<CNPJ>93623057000128</CNPJ>'
            . '<chNFe>35220605730928000145550010000048661583302923</chNFe>'
            . '<dhEvento>2024-05-31T11:59:12-03:00</dhEvento>'
            . '<tpEvento>210210</tpEvento>'
            . '<nSeqEvento>1</nSeqEvento>'
            . '<verEvento>1.00</verEvento>'
            . '<detEvento versao="1.00"><descEvento>Ciencia da Operacao</descEvento></detEvento>'
            . '</infEvento>'
            . '</evento>'
            . '</envEvento>';

        $response = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<retEnvEvento xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<idLote>201704091147536</idLote>'
            . '<tpAmb>2</tpAmb>'
            . '<verAplic>SP_EVENTOS_PL_100</verAplic>'
            . '<cOrgao>91</cOrgao>'
            . '<cStat>128</cStat>'
            . '<xMotivo>Lote de Evento Processado</xMotivo>'
            . '<retEvento versao="1.00">'
            . '<infEvento>'
            . '<tpAmb>2</tpAmb>'
            . '<verAplic>SP_EVENTOS_PL_100</verAplic>'
            . '<cOrgao>91</cOrgao>'
            . '<cStat>135</cStat>'
            . '<xMotivo>Evento registrado e vinculado a NF-e</xMotivo>'
            . '<chNFe>35220605730928000145550010000048661583302923</chNFe>'
            . '<tpEvento>210210</tpEvento>'
            . '<xEvento>Ciencia da Operacao</xEvento>'
            . '<nSeqEvento>1</nSeqEvento>'
            . '<dhRegEvento>2024-05-31T12:00:00-03:00</dhRegEvento>'
            . '<nProt>135220000009999</nProt>'
            . '</infEvento>'
            . '</retEvento>'
            . '</retEnvEvento>';

        $result = Complements::toAuthorize($request, $response);
        $this->assertStringContainsString('procEventoNFe', $result);
        $this->assertStringContainsString('135220000009999', $result);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 15. Complements::cancelRegister
    // ──────────────────────────────────────────────────────────────────────

    public function test_complements_cancel_register(): void
    {
        // Build a minimal protocoled NFe (nfeProc)
        $nfeProc = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<nfeProc xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00">'
            . '<NFe xmlns="http://www.portalfiscal.inf.br/nfe">'
            . '<infNFe versao="4.00" Id="NFe35220605730928000145550010000048661583302923">'
            . '<ide><cUF>35</cUF><mod>55</mod></ide>'
            . '</infNFe>'
            . '</NFe>'
            . '<protNFe versao="4.00">'
            . '<infProt>'
            . '<chNFe>35220605730928000145550010000048661583302923</chNFe>'
            . '<nProt>135220000009921</nProt>'
            . '<cStat>100</cStat>'
            . '</infProt>'
            . '</protNFe>'
            . '</nfeProc>';

        // Build a cancel event response
        $cancelamento = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<procEventoNFe xmlns="http://www.portalfiscal.inf.br/nfe" versao="1.00">'
            . '<retEvento versao="1.00">'
            . '<infEvento>'
            . '<cStat>135</cStat>'
            . '<tpEvento>110111</tpEvento>'
            . '<chNFe>35220605730928000145550010000048661583302923</chNFe>'
            . '<nProt>135220000009999</nProt>'
            . '</infEvento>'
            . '</retEvento>'
            . '</procEventoNFe>';

        $result = Complements::cancelRegister($nfeProc, $cancelamento);
        $this->assertStringContainsString('nfeProc', $result);
        $this->assertStringContainsString('retEvento', $result);
    }

    public function test_complements_cancel_register_no_protocol_throws(): void
    {
        $this->expectException(DocumentsException::class);
        $nfeNoProc = '<?xml version="1.0" encoding="UTF-8"?>'
            . '<NFe xmlns="http://www.portalfiscal.inf.br/nfe">'
            . '<infNFe versao="4.00" Id="NFe35220605730928000145550010000048661583302923">'
            . '<ide><cUF>35</cUF><mod>55</mod></ide>'
            . '</infNFe>'
            . '</NFe>';

        $cancelamento = '<procEventoNFe><retEvento><infEvento>'
            . '<cStat>135</cStat><tpEvento>110111</tpEvento>'
            . '<chNFe>35220605730928000145550010000048661583302923</chNFe>'
            . '<nProt>135220000009999</nProt>'
            . '</infEvento></retEvento></procEventoNFe>';

        Complements::cancelRegister($nfeNoProc, $cancelamento);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 16. Complements::b2bTag
    // ──────────────────────────────────────────────────────────────────────

    public function test_complements_b2b_tag_no_nfeProc_throws(): void
    {
        $this->expectException(DocumentsException::class);
        $nfeWithoutProc = '<NFe xmlns="http://www.portalfiscal.inf.br/nfe">'
            . '<infNFe versao="4.00"></infNFe></NFe>';
        $b2b = '<NFeB2BFin><data>test</data></NFeB2BFin>';
        Complements::b2bTag($nfeWithoutProc, $b2b);
    }

    public function test_complements_b2b_tag_no_b2b_tag_throws(): void
    {
        $this->expectException(DocumentsException::class);
        $nfeProc = '<nfeProc xmlns="http://www.portalfiscal.inf.br/nfe" versao="4.00">'
            . '<NFe><infNFe versao="4.00"></infNFe></NFe>'
            . '<protNFe><infProt><chNFe>123</chNFe></infProt></protNFe>'
            . '</nfeProc>';
        // B2B content does NOT contain the expected NFeB2BFin tag
        $b2b = '<OutraTag><data>test</data></OutraTag>';
        Complements::b2bTag($nfeProc, $b2b);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 17. QRCode::putQRTag
    // ──────────────────────────────────────────────────────────────────────

    public function test_qrcode_put_qr_tag_v200(): void
    {
        $xml = file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml');
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);

        $token = 'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G';
        $idToken = '000001';
        $urlqr = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaQRCode.aspx';
        $urichave = 'https://www.homologacao.nfce.fazenda.sp.gov.br/NFCeConsultaPublica/Paginas/ConsultaPublica.aspx';

        $result = QRCode::putQRTag($dom, $token, $idToken, '200', $urlqr, $urichave);
        $this->assertIsString($result);
        $this->assertStringContainsString('infNFeSupl', $result);
        $this->assertStringContainsString('<qrCode>', $result);
        $this->assertStringContainsString('<urlChave>', $result);
        $this->assertStringContainsString($urichave, $result);
    }

    public function test_qrcode_put_qr_tag_sem_token_throws(): void
    {
        $this->expectException(DocumentsException::class);
        $xml = file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml');
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($xml);
        QRCode::putQRTag($dom, '', '000001', '200', 'https://example.com', 'https://example.com');
    }

    public function test_qrcode_put_qr_tag_sem_idtoken_throws(): void
    {
        $this->expectException(DocumentsException::class);
        $xml = file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml');
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($xml);
        QRCode::putQRTag($dom, 'TOKENXYZ', '', '200', 'https://example.com', 'https://example.com');
    }

    public function test_qrcode_put_qr_tag_sem_url_throws(): void
    {
        $this->expectException(DocumentsException::class);
        $xml = file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml');
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($xml);
        QRCode::putQRTag($dom, 'TOKENXYZ', '000001', '200', '', 'https://example.com');
    }

    public function test_qrcode_put_qr_tag_versao_vazia_usa_200(): void
    {
        $xml = file_get_contents(__DIR__ . '/fixtures/xml/nfce_sem_qrcode.xml');
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);

        $result = QRCode::putQRTag(
            $dom,
            'GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G',
            '000001',
            '', // empty version defaults to 200
            'https://example.com/qrcode',
            'https://example.com/chave'
        );
        $this->assertStringContainsString('infNFeSupl', $result);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 18. Make - entrega tags
    // ──────────────────────────────────────────────────────────────────────

    public function test_make_tag_entrega_cnpj(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->CNPJ = '11222333000181';
        $std->CPF = null;
        $std->xNome = 'Empresa Destino';
        $std->xLgr = 'Rua Exemplo';
        $std->nro = '100';
        $std->xCpl = 'Sala 1';
        $std->xBairro = 'Centro';
        $std->cMun = '3550308';
        $std->xMun = 'Sao Paulo';
        $std->UF = 'SP';
        $std->CEP = '01001000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = '1133334444';
        $std->email = 'teste@teste.com';
        $std->IE = '123456789';

        $element = $make->tagentrega($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('entrega', $element->tagName);
        $this->assertEquals('11222333000181', $element->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('Rua Exemplo', $element->getElementsByTagName('xLgr')->item(0)->nodeValue);
        $this->assertEquals('Centro', $element->getElementsByTagName('xBairro')->item(0)->nodeValue);
        $this->assertEquals('SP', $element->getElementsByTagName('UF')->item(0)->nodeValue);
        $this->assertEquals('123456789', $element->getElementsByTagName('IE')->item(0)->nodeValue);
    }

    public function test_make_tag_entrega_cpf(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->CPF = '12345678901';
        $std->CNPJ = null;
        $std->xNome = 'Pessoa Fisica';
        $std->xLgr = 'Av Brasil';
        $std->nro = '200';
        $std->xCpl = null;
        $std->xBairro = 'Jardim';
        $std->cMun = '3304557';
        $std->xMun = 'Rio de Janeiro';
        $std->UF = 'RJ';
        $std->CEP = '20040020';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = null;
        $std->email = null;
        $std->IE = null;

        $element = $make->tagentrega($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('12345678901', $element->getElementsByTagName('CPF')->item(0)->nodeValue);
        $this->assertEmpty($element->getElementsByTagName('CNPJ')->item(0));
    }

    // ──────────────────────────────────────────────────────────────────────
    // 19. Make - retirada tags
    // ──────────────────────────────────────────────────────────────────────

    public function test_make_tag_retirada_cnpj(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->CNPJ = '99887766000100';
        $std->CPF = null;
        $std->xNome = 'Empresa Origem';
        $std->xLgr = 'Rua Retirada';
        $std->nro = '50';
        $std->xCpl = null;
        $std->xBairro = 'Industrial';
        $std->cMun = '4106902';
        $std->xMun = 'Curitiba';
        $std->UF = 'PR';
        $std->CEP = '80000000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = null;
        $std->email = null;
        $std->IE = null;

        $element = $make->tagretirada($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('retirada', $element->tagName);
        $this->assertEquals('99887766000100', $element->getElementsByTagName('CNPJ')->item(0)->nodeValue);
        $this->assertEquals('Curitiba', $element->getElementsByTagName('xMun')->item(0)->nodeValue);
    }

    public function test_make_tag_retirada_cpf(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->CPF = '98765432100';
        $std->CNPJ = null;
        $std->xNome = 'Produtor Rural';
        $std->xLgr = 'Estrada Municipal';
        $std->nro = 'KM 5';
        $std->xCpl = 'Lote 10';
        $std->xBairro = 'Zona Rural';
        $std->cMun = '5108402';
        $std->xMun = 'Varzea Grande';
        $std->UF = 'MT';
        $std->CEP = '78000000';
        $std->cPais = '1058';
        $std->xPais = 'BRASIL';
        $std->fone = '6533331111';
        $std->email = 'rural@teste.com';
        $std->IE = '987654321';

        $element = $make->tagretirada($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('98765432100', $element->getElementsByTagName('CPF')->item(0)->nodeValue);
        $this->assertEmpty($element->getElementsByTagName('CNPJ')->item(0));
        $this->assertEquals('987654321', $element->getElementsByTagName('IE')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 20. Make - comb (fuel) tags
    // ──────────────────────────────────────────────────────────────────────

    public function test_make_tag_comb(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->item = 1;
        $std->cProdANP = '320102001';
        $std->descANP = 'GASOLINA C COMUM';
        $std->pGLP = null;
        $std->pGNn = null;
        $std->pGNi = null;
        $std->vPart = null;
        $std->CODIF = '123456789';
        $std->qTemp = 100.1234;
        $std->UFCons = 'SP';
        $std->qBCProd = '';
        $std->vAliqProd = '';
        $std->vCIDE = '';
        $std->pBio = null;

        $element = $make->tagcomb($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('comb', $element->tagName);
        $this->assertEquals('320102001', $element->getElementsByTagName('cProdANP')->item(0)->nodeValue);
        $this->assertEquals('GASOLINA C COMUM', $element->getElementsByTagName('descANP')->item(0)->nodeValue);
        $this->assertEquals('123456789', $element->getElementsByTagName('CODIF')->item(0)->nodeValue);
        $this->assertEquals('SP', $element->getElementsByTagName('UFCons')->item(0)->nodeValue);
    }

    public function test_make_tag_comb_with_cide(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->item = 1;
        $std->cProdANP = '320102001';
        $std->descANP = 'GASOLINA C COMUM';
        $std->pGLP = 50.1234;
        $std->pGNn = 30.5678;
        $std->pGNi = 19.3088;
        $std->vPart = 10.50;
        $std->CODIF = null;
        $std->qTemp = null;
        $std->UFCons = 'SP';
        $std->qBCProd = 1000.5000;
        $std->vAliqProd = 0.1234;
        $std->vCIDE = 123.46;
        $std->pBio = 15.0000;

        $element = $make->tagcomb($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        // CIDE sub-element should be present
        $this->assertNotEmpty($element->getElementsByTagName('CIDE')->item(0));
        $this->assertEquals('1000.5000', $element->getElementsByTagName('qBCProd')->item(0)->nodeValue);
        $this->assertEquals('0.1234', $element->getElementsByTagName('vAliqProd')->item(0)->nodeValue);
        $this->assertEquals('123.46', $element->getElementsByTagName('vCIDE')->item(0)->nodeValue);
        // GLP percentages
        $this->assertNotEmpty($element->getElementsByTagName('pGLP')->item(0));
        $this->assertNotEmpty($element->getElementsByTagName('pBio')->item(0));
    }

    public function test_make_tag_encerrante(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->item = 1;
        $std->nBico = '1';
        $std->nBomba = '2';
        $std->nTanque = '3';
        $std->vEncIni = 1000.123;
        $std->vEncFin = 1050.456;

        $element = $make->tagencerrante($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('encerrante', $element->tagName);
        $this->assertEquals('1', $element->getElementsByTagName('nBico')->item(0)->nodeValue);
        $this->assertEquals('2', $element->getElementsByTagName('nBomba')->item(0)->nodeValue);
        $this->assertEquals('3', $element->getElementsByTagName('nTanque')->item(0)->nodeValue);
        $this->assertEquals('1000.123', $element->getElementsByTagName('vEncIni')->item(0)->nodeValue);
        $this->assertEquals('1050.456', $element->getElementsByTagName('vEncFin')->item(0)->nodeValue);
    }

    public function test_make_tag_encerrante_sem_bomba(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->item = 2;
        $std->nBico = '5';
        $std->nBomba = null;
        $std->nTanque = '1';
        $std->vEncIni = 500.000;
        $std->vEncFin = 600.000;

        $element = $make->tagencerrante($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('5', $element->getElementsByTagName('nBico')->item(0)->nodeValue);
        $this->assertEmpty($element->getElementsByTagName('nBomba')->item(0));
    }

    public function test_make_tag_orig_comb(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->item = 1;
        $std->indImport = '0';
        $std->cUFOrig = '35';
        $std->pOrig = 100.0000;

        $element = $make->tagorigComb($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('origComb', $element->tagName);
        $this->assertEquals('0', $element->getElementsByTagName('indImport')->item(0)->nodeValue);
        $this->assertEquals('35', $element->getElementsByTagName('cUFOrig')->item(0)->nodeValue);
        $this->assertEquals('100.0000', $element->getElementsByTagName('pOrig')->item(0)->nodeValue);
    }

    public function test_make_tag_orig_comb_importado(): void
    {
        $make = new Make();

        $std = new \stdClass();
        $std->item = 1;
        $std->indImport = '1';
        $std->cUFOrig = '35';
        $std->pOrig = 50.5000;

        $element = $make->tagorigComb($std);
        $this->assertInstanceOf(\DOMElement::class, $element);
        $this->assertEquals('1', $element->getElementsByTagName('indImport')->item(0)->nodeValue);
        $this->assertEquals('50.5000', $element->getElementsByTagName('pOrig')->item(0)->nodeValue);
    }

    public function test_make_multiple_orig_comb_same_item(): void
    {
        $make = new Make();

        $std1 = new \stdClass();
        $std1->item = 1;
        $std1->indImport = '0';
        $std1->cUFOrig = '35';
        $std1->pOrig = 60.0000;
        $make->tagorigComb($std1);

        $std2 = new \stdClass();
        $std2->item = 1;
        $std2->indImport = '1';
        $std2->cUFOrig = '41';
        $std2->pOrig = 40.0000;
        $element2 = $make->tagorigComb($std2);

        // Second call should also return a valid DOMElement
        $this->assertInstanceOf(\DOMElement::class, $element2);
        $this->assertEquals('41', $element2->getElementsByTagName('cUFOrig')->item(0)->nodeValue);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 21. TraitEventsRTC - checkModel (model 65 throws)
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_info_pagto_integral_model_65_throws(): void
    {
        $this->expectException(\NFePHP\NFe\Exception\InvalidArgumentException::class);
        $this->tools->model(65);
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->nSeqEvento = 1;
        $this->tools->sefazInfoPagtoIntegral($std);
    }

    public function test_sefaz_info_pagto_integral_chave_mod_65_throws(): void
    {
        $this->expectException(\NFePHP\NFe\Exception\InvalidArgumentException::class);
        $this->tools->model(55);
        $std = new \stdClass();
        // chave with mod=65 at position 20-21
        $std->chNFe = '35220605730928000145650010000048661583302923';
        $std->nSeqEvento = 1;
        $this->tools->sefazInfoPagtoIntegral($std);
    }

    public function test_sefaz_info_pagto_integral_success(): void
    {
        $this->tools->model(55);
        $this->tools->setVerAplic('TestApp_1.0');
        $std = new \stdClass();
        $std->chNFe = '35220605730928000145550010000048661583302923';
        $std->nSeqEvento = 1;
        $this->tools->sefazInfoPagtoIntegral($std, 'TestApp_1.0');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('<tpEvento>112110</tpEvento>', $request);
        $this->assertStringContainsString('<indQuitacao>1</indQuitacao>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    // 22. TraitEPECNfce - sefazStatusEpecNfce
    // ──────────────────────────────────────────────────────────────────────

    public function test_sefaz_status_epec_nfce_modelo_55_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->model(55);
        $this->tools->sefazStatusEpecNfce('SP');
    }

    public function test_sefaz_status_epec_nfce_uf_nao_sp_throws(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->tools->model(65);
        $this->tools->sefazStatusEpecNfce('RS');
    }

    public function test_sefaz_status_epec_nfce_sp(): void
    {
        $this->tools->model(65);
        $this->tools->sefazStatusEpecNfce('SP');
        $request = $this->tools->getRequest();
        $this->assertStringContainsString('consStatServ', $request);
        $this->assertStringContainsString('<xServ>STATUS</xServ>', $request);
    }

    // ──────────────────────────────────────────────────────────────────────
    // Helper methods
    // ──────────────────────────────────────────────────────────────────────

    protected function loadFixture(string $filename): string
    {
        $xml = simplexml_load_string(
            file_get_contents(__DIR__ . '/fixtures/xml/' . $filename),
            'SimpleXMLElement',
            LIBXML_NOBLANKS
        );
        $customXML = new \SimpleXMLElement($xml->asXML());
        $dom = dom_import_simplexml($customXML);
        return $dom->ownerDocument->saveXML($dom->ownerDocument->documentElement);
    }

    protected function setSuccessReturn(): void
    {
        $responseBody = file_get_contents(__DIR__ . '/fixtures/xml/exemplo_retorno_sucesso_envia_lote.xml');
        $this->tools->getSoap()->setReturnValue($responseBody);
    }
}
