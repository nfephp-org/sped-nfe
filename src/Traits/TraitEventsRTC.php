<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\UFList;
use NFePHP\NFe\Exception\InvalidArgumentException;
use stdClass;

/**
 * @property stdClass $config
 * @property int $cUF
 * @property int $modelo
 * @property string $timezone
 * @method sefazEvento($uf,$chave,$tpEvento,$nSeqEvento,$tagAdic,$dhEvento,$lote)
 */
trait TraitEventsRTC
{
    /**
     * Evento: Informação de efetivo pagamento integral para liberar crédito presumido do adquirente
     * Permitir que o emitente da NFe informe o efetivo pagamento integral a fim de liberar crédito presumido
     * do adquirente
     * Modelo: NF-e modelo 55, Autor do Evento: Emitente da NFe, Código do Tipo de Evento: 112110
     *
     * $std = (object) [
     *     'chNFe' => '12345678901234567890123456789012345678901234', //OBRIGATÓRIO
     *     'nSeqEvento' => 1  //opcional, Default = 1
     * ];
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazInfoPagtoIntegral(stdClass $std, ?string $verAplic = null): string
    {
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '112110';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>"  //1=Empresa Emitente
            . "<verAplic>{$verAplic}</verAplic>"
            . "<indQuitacao>1</indQuitacao>";

        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Solicitação de Apropriação de crédito presumido
     * Evento a ser gerado pelo adquirente, em relação às notas fiscais de aquisição de emissão de terceiros e que
     * lhe gerem o dire ito à apropriação de crédito presumido.
     * Modelo: NF-e modelo 55, Autor: Adquirente/Destinatário (quando os dois estiverem preenchidos, devem ser iguais)
     * da nota fiscal, Código do Tipo de Evento: 211110
     *
     * $itens = [];
     * $itens[1] = [
     *      'item' => 1,
     *      'vBC' => 100.00,
     *      'gIBS' => [
     *          'cCredPres' => '01',
     *          'pCredPres' => 2.5000,
     *          'vCredPres' => 2.50
     *      ],
     *      'gCBS' => [
     *          'cCredPres' => '01',
     *          'pCredPres' => 2.5000,
     *          'vCredPres' => 2.50
     *      ]
     * ];
     *
     * $std = new stdClass();
     * $std->chNFe = '12345678901234567890123456789012345678901234';
     * $std->nSeqEvento = 1;
     * $std->itens = json_decode(json_encode($itens));
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazSolApropCredPresumido(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '211110';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>2</tpAutor>" //2=Empresa destinatária     @todo quem realmente emite esse evento ??
            . "<verAplic>{$verAplic}</verAplic>";
        $gcred = '';
        foreach ($std->itens as $item) {
            $bc = number_format($item->vBC, 2, '.', '');
            $gcred .= "<gCredPres nItem=\"{$item->item}\"><vBC>{$bc}</vBC>";
            if (!empty($item->gIBS)) {
                $g = $item->gIBS;
                $pc = number_format($g->pCredPres, 4, '.', '');
                $vc = number_format($g->vCredPres, 2, '.', '');
                $gibs = "<gIBS>"
                    . "<cCredPres>{$g->cCredPres}</cCredPres>"
                    . "<pCredPres>{$pc}</pCredPres>"
                    . "<vCredPres>{$vc}</vCredPres>"
                    . "</gIBS>";
                $gcred .= $gibs;
            }
            if (!empty($item->gCBS)) {
                $g = $item->gCBS;
                $pc = number_format($g->pCredPres, 4, '.', '');
                $vc = number_format($g->vCredPres, 2, '.', '');
                $gcbs = "<gCBS>"
                    . "<cCredPres>{$g->cCredPres}</cCredPres>"
                    . "<pCredPres>{$pc}</pCredPres>"
                    . "<vCredPres>{$vc}</vCredPres>"
                    . "</gCBS>";
                $gcred .= $gcbs;
            }
            $gcred .= "</gCredPres>";
        }
        $tagAdic .= $gcred;

        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Destinação de item para consumo pessoal
     * Permitir ao adquirente informar quando uma aquisição for destinada para o consumo de pessoa física,
     * hipótese em que não haverá direito à apropriação de crédito.
     * Evento a ser registrado após a emissão da nota de bens destinados para uso e consumo pessoal.
     * Uma mesma NFe de aquisição pode receber vários Eventos desse tipo, com nSeqEvento diferentes
     * (eventos cumulativos).
     * Modelo: NF-e modelo 55, Autor do Evento: Destinatário da NF-e, Código do Tipo de Evento: 211120
     * tpAutor => Caso NF-e de Importação, informar 1-Empresa Emitente, nos demais casos 2-Empresa destinatária.
     *
     * $itens[1] = (object) [
     *      'item' => 1,
     *      'vIBS' => 10.00,
     *      'vCBS' => 10.00,
     *      'quantidade' => 10,
     *      'unidade' => 'PC'
     *      'chave' => '12345678901234567890123456789012345678901234',
     *      'nItem' => 1
     *  ];
     *
     *  $std = new stdClass;
     *  $std->chNFe = '12345678901234567890123456789012345678901234'; //OBRIGATÓRIO
     *  $std->nSeqEvento = 1; //opcional DEFAULT = 1
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazDestinoConsumoPessoal(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '211120';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>{$std->tpAutor}</tpAutor>"
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vIBS, 2, '.', '');
            $vc = number_format($item->vCBS, 2, '.', '');
            $qt = number_format($item->quantidade, 4, '.', '');
            $gc = "<gConsumo nItem=\"{$item->item}\">"
                . "<vIBS>{$vi}</vIBS>"
                . "<vCBS>{$vc}</vCBS>"
                . "<gControleEstoque>"
                . "<qConsumo>{$qt}</qConsumo>"
                . "<uConsumo>{$item->unidade}</uConsumo>"
                . "</gControleEstoque>"
                . "<DFeReferenciado>"
                . "<chaveAcesso>{$item->chave}</chaveAcesso>"
                . "<nItemDFeRef>{$item->nItem}</nItemDFeRef>"
                . "</DFeReferenciado>"
                . "</gConsumo>";
            $tagAdic .= $gc;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Aceite de débito na apuração por emissão de nota de crédito
     * Permitir ao destinatário informar que concorda com os valores constantes em nota de crédito emitida pelo
     * fornecedor ou pelo adquirente que serão lançados a débito na apuração assistida de IBS e CBS.
     * Modelo: NF-e modelo 55, Autor do Evento: Destinatário da NF-e, Código do Tipo de Evento: 211128
     *
     * $std = new stdClass;
     * $std->chNFe = '12345678901234567890123456789012345678901234';
     * $std->nSeqEvento = 1;
     * $std->dhEvento = '2025-09-23\T13:34:30-03:00';
     * $std->lote = null;
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazAceiteDebito(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '211128';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>2</tpAutor>" //2=Empresa destinatária
            . "<verAplic>{$verAplic}</verAplic>"
            . "<indAceitacao>1</indAceitacao>";
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Imobilização de Item
     * Evento a ser gerado pelo adquirente de bem, quando este for integrado ao seu ativo imobilizado, a fim de
     * viabilizar a adequada identificação, pelos sistemas da administração tributária, de prazo-limite para
     * apreciação de eventuais pedidos de ressarcimento do respectivo crédito, nos termos do art. 40, I da LC 214/2025.
     * Modelo: NF-e modelo 55, Autor do Evento: Destinatário da NF-e (Adquirente), Código do Tipo de Evento: 211130
     *
     * $itens[1] = (object) [
     *      'item' => 1,
     *      'vIBS' => 10.00,
     *      'vCBS' => 10.00,
     *      'quantidade' => 10,
     *      'unidade' => 'PC'
     *  ];
     *
     *  $std = new stdClass;
     *  $std->chNFe = '12345678901234567890123456789012345678901234';
     *  $std->nSeqEvento = 1;
     *  $std->dhEvento = '2025-09-23\T13:34:30-03:00';
     *  $std->lote = null;
     *  $std->itens = $itens;
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazImobilizacaoItem(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '211130';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>2</tpAutor>" //2=Empresa destinatária
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vIBS, 2, '.', '');
            $vc = number_format($item->vCBS, 2, '.', '');
            $qtd = number_format($item->quantidade, 4, '.', '');
            $gc = "<gImobilizacao nItem=\"{$item->item}\">"
                . "<vIBS>{$vi}</vIBS>"
                . "<vCBS>{$vc}</vCBS>"
                . "<gControleEstoque>"
                . "<qImobilizado>{$qtd}</qImobilizado>"
                . "<uImobilizado>{$item->unidade}</uImobilizado>"
                . "</gControleEstoque>"
                . "</gImobilizacao>";
            $tagAdic .= $gc;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Solicitação de Apropriação de Crédito de Combustível
     * Evento a ser gerado pelo adquirente de combustível listado no art. 172 da LC 214/2025 e que pertença à cadeia
     * produtiva desses combustíveis, para solicitar a apropriação de crédito referente à parcela que for consumida
     * em sua atividade comercial.
     * Modelo: NF-e modelo 55
     * Autor do Evento: Destinatário da NF-e (Adquirente de combustível parte da cadeia produtiva de combustíveis)
     * Código do Tipo de Evento: 211140
     *
     * $itens[1] = (object) [
     *       'item' => 1,
     *       'vIBS' => 10.00,
     *       'vCBS' => 10.00,
     *       'quantidade' => 10,
     *       'unidade' => 'LT'
     *   ];
     *
     *   $std = new stdClass;
     *   $std->chNFe = '12345678901234567890123456789012345678901234';
     *   $std->nSeqEvento = 1;
     *   $std->dhEvento = '2025-09-23\T13:34:30-03:00';
     *   $std->lote = null;
     *   $std->itens = $itens;
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazApropriacaoCreditoComb(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '211140';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>2</tpAutor>"  //2=Empresa destinatária
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vIBS, 2, '.', '');
            $vc = number_format($item->vCBS, 2, '.', '');
            $qtd = number_format($item->quantidade, 4, '.', '');
            $gc = "<gConsumoComb nItem=\"{$item->item}\">"
                . "<vIBS>{$vi}</vIBS>"
                . "<vCBS>{$vc}</vCBS>"
                . "<gControleEstoque>"
                . "<qComb>{$qtd}</qComb>"
                . "<uComb>{$item->unidade}</uComb>"
                . "</gControleEstoque>"
                . "</gConsumoComb>";
            $tagAdic .= $gc;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Solicitação de Apropriação de Crédito para bens e serviços que dependem de atividade do adquirente
     * Evento a ser gerado pelo adquirente para apropriação de crédito de bens e serviços que dependam da sua atividade
     * Modelo: NF-e modelo 55, Autor do Evento: Destinatário da NFe (adquirente), Código do Tipo de Evento: 211150
     *
     * $itens = [];
     * $itens[] = [
     *       'item' => 1,
     *       'vIBS' => 10.00,
     *       'vCBS' => 10.00,
     *   ];
     *
     *   $std = new stdClass();
     *   $std->chNFe = '12345678901234567890123456789012345678901234';
     *   $std->nSeqEvento = 1; //opcional DEFAULT = 1
     *   $std->itens = $itens;
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazApropriacaoCreditoBens(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '211150';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>2</tpAutor>"  //2=Empresa destinatária.
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vCredIBS, 2, '.', '');
            $vc = number_format($item->vCredCBS, 2, '.', '');
            $cred = "<gCredito nItem=\"{$item->item}\">"
                . "<vCredIBS>{$vi}</vCredIBS>"
                . "<vCredCBS>{$vc}</vCredCBS>"
                . "</gCredito>";
            $tagAdic .= $cred;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Manifestação sobre Pedido de Transferência de Crédito de IBS em Operações de Sucessão
     * Evento a ser gerado pela sucessora em relação às notas fiscais de transferência de crédito de outra sucessora
     * da mesma empresa sucedida para informar aceite da transferência de crédito de IBS.
     * Modelo: NF-e modelo 55, Autor: Empresa sucessora, Código do Tipo de Evento: 212110
     *
     *   $std = new stdClass;
     *   $std->chNFe = '12345678901234567890123456789012345678901234';
     *   $std->nSeqEvento = 1;
     *   $std->dhEvento = '2025-09-23\T13:34:30-03:00';
     *   $std->lote = null;
     *   $std->itens = $itens;
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazManifestacaoTransfCredIBS(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '212110';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>8</tpAutor>" //8= Empresa sucessora
            . "<verAplic>{$verAplic}</verAplic>"
            . "<indAceitacao>1</indAceitacao>";
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Manifestação sobre Pedido de Transferência de Crédito de CBS em Operações de Sucessão
     * Evento a ser gerado pela sucessora em relação às notas fiscais de transferência de crédito de outra sucessora
     * da mesma empresa sucedida para informar aceite da transferência de crédito de CBS.
     * Modelo: NF-e modelo 55, Autor: Empresa sucessora, Código do Tipo de Evento: 212120
     *
     *   $std = new stdClass;
     *   $std->chNFe = '12345678901234567890123456789012345678901234';
     *   $std->nSeqEvento = 1;
     *   $std->dhEvento = '2025-09-23\T13:34:30-03:00';
     *   $std->lote = null;
     *   $std->itens = $itens;
     *
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazManifestacaoTransfCredCBS(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '212120';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>8</tpAutor>" //8= Empresa sucessora
            . "<verAplic>{$verAplic}</verAplic>"
            . "<indAceitacao>1</indAceitacao>";
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Cancelamento de Evento
     * Permitir que o autor de um Evento já autorizado possa proceder o seu cancelamento.
     * Modelo: NF-e modelo 55, Autor do Evento: O mesmo Autor do Evento que está sendo cancelado.
     * Tipo de Evento (Código - Descrição): 110001 - Cancelamento de Evento
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazCancelaEvento(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '110001';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>{$std->tpAutor}</tpAutor>"
            . "<verAplic>{$verAplic}</verAplic>"
            . "<tpEventoAut>{$std->tpEventoAut}</tpEventoAut>"
            . "<nProtEvento>{$std->nProtEvento}</nProtEvento>";
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Importação em ALC/ZFM não convertida em isenção
     * Permitir que o adquirente das regiões incentivadas (ALC/ZFM) informe que a tributação na importação não se
     * converteu em isenção de um determinado item por não atender as condições da legislação.
     * Modelo: NF-e modelo 55, Autor do Evento: emitente da NFe (adquirente), Código do Tipo de Evento: 112120
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     * @throws \Exception
     */
    public function sefazImportacaoZFM(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '112120';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>" //1=Emitente
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vIBS, 2, '.', '');
            $vc = number_format($item->vCBS, 2, '.', '');
            $qtd = number_format($item->quantidade, 4, '.', '');
            $gc = "<gConsumo nItem=\"{$item->item}\">"
                . "<vIBS>{$vi}</vIBS>"
                . "<vCBS>{$vc}</vCBS>"
                . "<gControleEstoque>"
                . "<qtde>{$qtd}</qtde>"
                . "<unidade>{$item->unidade}</unidade>"
                . "</gControleEstoque>"
                . "</gConsumo>";
            $tagAdic .= $gc;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Perecimento, perda, roubo ou furto durante o transporte contratado pelo adquirente
     * Permitir ao adquirente informar quando uma aquisição for objeto de roubo, perda, furto ou perecimento.
     * Observação: O evento atual está relacionado aos bens que foram objeto de perecimento, perda, roubo ou furto
     * em trânsito, em fornecimentos com frete FOB.
     * Modelo: NF-e modelo 55
     * Autor do Evento: Destinatário da NF-e em notas de saída
     * Código do Tipo de Evento: 211124
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     * @throws \Exception
     */
    public function sefazRouboPerdaTransporteAdquirente(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '211124';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>2</tpAutor>" //2=Empresa destinatária
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vIBS, 2, '.', '');
            $vc = number_format($item->vCBS, 2, '.', '');
            $qtd = number_format($item->quantidade, 4, '.', '');
            $gc = "<gPerecimento nItem=\"{$item->item}\">"
                . "<vIBS>{$vi}</vIBS>"
                . "<vCBS>{$vc}</vCBS>"
                . "<gControleEstoque>"
                . "<qPerecimento>{$qtd}</qPerecimento>"
                . "<uPerecimento>{$item->unidade}</uPerecimento>"
                . "</gControleEstoque>"
                . "</gPerecimento>";
            $tagAdic .= $gc;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Perecimento, perda, roubo ou furto durante o transporte contratado pelo fornecedor
     * Permitir ao fornecedor informar quando um bem for objeto de roubo, perda, furto ou perecimento antes da entrega,
     * durante o transporte contratado pelo fornecedor.
     * Observação: O evento atual está relacionado aos bens móveis materiais que foram objeto de perecimento, perda,
     * roubo ou furto em trânsito, em fornecimentos com frete CIF.
     * Modelo: NF-e modelo 55
     * Autor do Evento: emitente da NF-e em notas de saída.
     * Código do Tipo de Evento: 112130
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     * @throws \Exception
     */
    public function sefazRouboPerdaTransporteFornecedor(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '112130';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>" //2=Empresa emitente
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vIBS, 2, '.', '');
            $vc = number_format($item->vCBS, 2, '.', '');
            $gvi = number_format($item->gControleEstoque_vIBS, 2, '.', '');
            $gvc = number_format($item->gControleEstoque_vCBS, 2, '.', '');
            $qtd = number_format($item->quantidade, 4, '.', '');
            $gc = "<gPerecimento nItem=\"{$item->item}\">"
                . "<vIBS>{$vi}</vIBS>"
                . "<vCBS>{$vc}</vCBS>"
                . "<gControleEstoque>"
                . "<qPerecimento>{$qtd}</qPerecimento>"
                . "<uPerecimento>{$item->unidade}</uPerecimento>"
                . "<vIBS>{$gvi}</vIBS>"
                . "<vCBS>{$gvc}</vCBS>"
                . "</gControleEstoque>"
                . "</gPerecimento>";
            $tagAdic .= $gc;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Fornecimento não realizado com pagamento antecipado
     * Permitir ao fornecedor informar que um pagamento antecipado não teve o respectivo fornecimento realizado.
     * Modelo: NF-e modelo 55
     * Autor do Evento: emitente da NF-e de nota de débito do tipo 06 = Pagamento antecipado
     * Código do Tipo de Evento: 112140
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazFornecimentoNaoRealizado(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '112140';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>" //1=Empresa emitente
            . "<verAplic>{$verAplic}</verAplic>";
        foreach ($std->itens as $item) {
            $vi = number_format($item->vIBS, 2, '.', '');
            $vc = number_format($item->vCBS, 2, '.', '');
            $qtd = number_format($item->quantidade, 4, '.', '');
            $gc = "<gItemNaoFornecido nItem=\"{$item->item}\">"
                . "<vIBS>{$vi}</vIBS>"
                . "<vCBS>{$vc}</vCBS>"
                . "<gControleEstoque>"
                . "<qNaoFornecida>{$qtd}</qNaoFornecida>"
                . "<uNaoFornecida>{$item->unidade}</uNaoFornecida>"
                . "</gControleEstoque>"
                . "</gItemNaoFornecido>";
            $tagAdic .= $gc;
        }
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Evento: Atualização da Data de Previsão de Entrega
     * Função: Permitir ao fornecedor atualizar a data da previsão de entrega ou disponibilização do bem ao adquirente,
     * de forma à remover o débito do mês em que foi previsto inicialmente.
     * Modelo: NF-e modelo 55
     * Autor do Evento: emitente da NF-e
     * Código do Tipo de Evento: 112150
     * @param stdClass $std
     * @param string|null $verAplic
     * @return string
     */
    public function sefazAtualizacaoDataEntrega(stdClass $std, ?string $verAplic = null): string
    {
        //apenas 55
        $this->checkModel($std);
        $verAplic = $this->resolveVerAplic($verAplic);
        $tpEvento = '112150';
        $tagAdic = "<cOrgaoAutor>{$this->cUF}</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>" //1=Empresa emitente
            . "<verAplic>{$verAplic}</verAplic>"
            . "<dPrevEntrega>{$std->data_prevista}</dPrevEntrega>";
        return $this->sefazEvento(
            'SVRS',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento ?? 1,
            $tagAdic,
            null,
            null
        );
    }

    /**
     * Somente aceitar modelo 55
     * @param stdClass $std
     * @return void
     */
    protected function checkModel(stdClass $std): void
    {
        //apenas 55
        if ($this->modelo !== 55) {
            throw new InvalidArgumentException(
                'O ambiente está ajustado para modelo 65 (NFCe) e esse evento atende apenas o modelo 55 (NFe)'
            );
        }
        if (!empty($std->chNFe)) {
            if (substr($std->chNFe, 20, 2) !== '55') {
                throw new InvalidArgumentException('A chave da NFe informada não é uma NFe modelo 55');
            }
        }
    }

    /**
     * Resolve variavel verAplic
     * @param string|null $verAplic
     * @return string
     */
    protected function resolveVerAplic(?string $verAplic = null): string
    {
        if (!empty($verAplic)) {
            return $verAplic;
        }
        return !empty($this->verAplic) ? $this->verAplic : '4.00';
    }
}
