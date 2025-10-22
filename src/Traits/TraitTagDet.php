<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use NFePHP\NFe\Common\Gtin;
use stdClass;
use DOMElement;
use DOMException;
use InvalidArgumentException;

/**
 * @property Dom $dom
 * @property array $aProd
 * @property array $aInfAdProd
 * @property array $aObsItem
 * @property array $aVItem
 * @property array $aCest
 * @property array $aGCred
 * @property array $aDI
 * @property array $aAdi
 * @property array $aDetExport
 * @property int $tpAmb
 * @property int $mod
 * @property stdClass $stdTot
 * @property bool $checkgtin
 * @property array $errors
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
 */
trait TraitTagDet
{
    /**
     * Detalhamento de Produtos e Serviços I01 pai H01
     * tag NFe/infNFe/det[]/prod
     * NOTA: Ajustado para NT2016_002_v1.30
     * NOTA: Ajustado para NT2020_005_v1.20
     * NOTA: Ajustado para NT2025_002_v1.01
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagprod(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'cProd',
            'cEAN',
            'cBarra',
            'xProd',
            'NCM',
            'cBenef',
            'tpCredPresIBSZFM',
            'EXTIPI',
            'CFOP',
            'uCom',
            'qCom',
            'vUnCom',
            'vProd',
            'cEANTrib',
            'cBarraTrib',
            'uTrib',
            'qTrib',
            'vUnTrib',
            'vFrete',
            'vSeg',
            'vDesc',
            'vOutro',
            'indTot',
            'indBemMovelUsado',
            'xPed',
            'nItemPed',
            'nFCI',
            'CEST',
            'indEscala',
            'CNPJFab',
            'vItem' //PL_010
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "I01 prod - Item: $std->item";
        //dados para calculo do vItem
        if (empty($this->aVItem[$std->item])) {
            $this->aVItem[$std->item] = $this->aVItemStruct;
        }
        $this->aVItem[$std->item]['indTot'] = ($std->indTot ?? 0);
        $this->aVItem[$std->item]['vProd'] = ($std->vProd ?? 0);
        $this->aVItem[$std->item]['vDesc'] = ($std->vDesc ?? 0);
        $this->aVItem[$std->item]['vSeg'] = ($std->vSeg ?? 0);
        $this->aVItem[$std->item]['vFrete'] = ($std->vFrete ?? 0);
        $this->aVItem[$std->item]['vOutro'] = ($std->vOutro ?? 0);
        $this->aVItem[$std->item]['vItem'] = ($std->vItem ?? 0);
        //totalizador
        if ($std->indTot == 1) {
            $this->stdTot->vProd += (float) $this->conditionalNumberFormatting($std->vProd);
        }
        $this->stdTot->vFrete += (float) $this->conditionalNumberFormatting($std->vFrete);
        $this->stdTot->vSeg += (float) $this->conditionalNumberFormatting($std->vSeg);
        $this->stdTot->vDesc += (float) $this->conditionalNumberFormatting($std->vDesc);
        $this->stdTot->vOutro += (float) $this->conditionalNumberFormatting($std->vOutro);
        $cean = !empty($std->cEAN) ? trim(strtoupper($std->cEAN)) : '';
        $ceantrib = !empty($std->cEANTrib) ? trim(strtoupper($std->cEANTrib)) : '';
        if ($this->checkgtin) {
            try {
                Gtin::isValid($cean);
            } catch (InvalidArgumentException $e) {
                $this->errors[] = "Item: $std->item cEAN $cean " . $e->getMessage();
            }
            try {
                Gtin::isValid($ceantrib);
            } catch (InvalidArgumentException $e) {
                $this->errors[] = "Item: $std->item cEANTrib $ceantrib " . $e->getMessage();
            }
        }
        $prod = $this->dom->createElement("prod");
        $this->dom->addChild(
            $prod,
            "cProd",
            $std->cProd,
            true,
            "$identificador Código do produto ou serviço"
        );
        $this->dom->addChild(
            $prod,
            "cEAN",
            $cean,
            true,
            "$identificador GTIN (Global Trade Item Number) do produto, antigo "
            . "código EAN ou código de barras",
            true
        );
        $this->dom->addChild(
            $prod,
            "cBarra",
            $std->cBarra,
            false,
            "$identificador cBarra Código de barras diferente do padrão GTIN"
        );
        $xProd = $std->xProd;
        if ($this->tpAmb == '2' && $this->mod == '65' && $std->item === 1) {
            $xProd = 'NOTA FISCAL EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }
        $this->dom->addChild(
            $prod,
            "xProd",
            $xProd,
            true,
            "$identificador Descrição do produto ou serviço"
        );
        if (!in_array(strlen($std->NCM), [2,8])) {
            $this->errors[] = "Item: $std->item NCM $std->NCM deve ter 2 ou 8 dígitos";
        }
        $this->dom->addChild(
            $prod,
            "NCM",
            $std->NCM,
            true,
            "$identificador Código NCM com 8 dígitos ou 2 dígitos (gênero)"
        );
        $this->dom->addChild(
            $prod,
            "CEST",
            $std->CEST,
            false,
            "$identificador Codigo especificador da Substuicao Tributaria (CEST)"
        );
        if (!empty($std->CEST)) {
            $this->dom->addChild(
                $prod,
                "indEscala",
                $std->indEscala ?? null,
                false,
                "$identificador Indicador de escala de produção (indEscala)"
            );
            $this->dom->addChild(
                $prod,
                "CNPJFab",
                $std->CNPJFab ?? null,
                false,
                "$identificador CNPJ do Fabricante da Mercadoria, obrigatório para produto em escala NÃO relevante"
            );
        }
        $this->dom->addChild(
            $prod,
            "cBenef",
            $std->cBenef,
            false,
            "$identificador Código de Benefício Fiscal utilizado pela UF"
        );
        //NT 2025.002_V1.30 - PL_010_V1.30
        if ($this->schema > 9) {
            $this->dom->addChild(
                $prod,
                "tpCredPresIBSZFM",
                $std->tpCredPresIBSZFM,
                false,
                "$identificador Classificação para subapuração do IBS na ZFM"
            );
        }
        $this->dom->addChild(
            $prod,
            "EXTIPI",
            $std->EXTIPI,
            false,
            "$identificador Preencher de acordo com o código EX da TIPI"
        );
        $this->dom->addChild(
            $prod,
            "CFOP",
            $std->CFOP,
            true,
            "$identificador Código Fiscal de Operações e Prestações"
        );
        $this->dom->addChild(
            $prod,
            "uCom",
            $std->uCom,
            true,
            "$identificador Unidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "qCom",
            $this->conditionalNumberFormatting($std->qCom, 4),
            true,
            "$identificador Quantidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnCom",
            $this->conditionalNumberFormatting($std->vUnCom, 10),
            true,
            "$identificador Valor Unitário de Comercialização do produto"
        );
        $this->dom->addChild(
            $prod,
            "vProd",
            $this->conditionalNumberFormatting($std->vProd),
            true,
            "$identificador Valor Total Bruto dos Produtos ou Serviços"
        );
        $this->dom->addChild(
            $prod,
            "cEANTrib",
            $ceantrib,
            true,
            "$identificador GTIN (Global Trade Item Number) da unidade tributável, antigo "
            . "código EAN ou código de barras",
            true
        );
        $this->dom->addChild(
            $prod,
            "cBarraTrib",
            $std->cBarraTrib,
            false,
            "$identificador cBarraTrib Código de Barras da "
            . "unidade tributável que seja diferente do padrão GTIN"
        );
        $this->dom->addChild(
            $prod,
            "uTrib",
            $std->uTrib,
            true,
            "$identificador Unidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "qTrib",
            $this->conditionalNumberFormatting($std->qTrib, 4),
            true,
            "$identificador Quantidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnTrib",
            $this->conditionalNumberFormatting($std->vUnTrib, 10),
            true,
            "$identificador Valor Unitário de tributação do produto"
        );
        $this->dom->addChild(
            $prod,
            "vFrete",
            $this->conditionalNumberFormatting($std->vFrete),
            false,
            "$identificador Valor Total do Frete (vFrete)"
        );
        $this->dom->addChild(
            $prod,
            "vSeg",
            $this->conditionalNumberFormatting($std->vSeg),
            false,
            "$identificador Valor Total do Seguro (vSeg)"
        );
        $this->dom->addChild(
            $prod,
            "vDesc",
            $this->conditionalNumberFormatting($std->vDesc),
            false,
            "$identificador Valor do Desconto (vDesc)"
        );
        $this->dom->addChild(
            $prod,
            "vOutro",
            $this->conditionalNumberFormatting($std->vOutro),
            false,
            "$identificador Outras despesas acessórias (vOutro)"
        );
        $this->dom->addChild(
            $prod,
            "indTot",
            $std->indTot,
            true,
            "$identificador Indica se valor do Item (vProd) entra no valor total da NF-e (indTot)"
        );
        $this->dom->addChild(
            $prod,
            "indBemMovelUsado",
            !empty($std->indBemMovelUsado) ? 1 : null,
            false,
            "$identificador Indicador de fornecimento de bem móvel usado (indBemMovelUsado)"
        );
        $this->dom->addChild(
            $prod,
            "xPed",
            $std->xPed,
            false,
            "$identificador Número do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nItemPed",
            $std->nItemPed,
            false,
            "$identificador Item do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nFCI",
            $std->nFCI,
            false,
            "$identificador Número de controle da FCI "
            . "Ficha de Conteúdo de Importação"
        );
        $this->aProd[$std->item] = $prod;
        return $prod;
    }

    /**
     * Informações adicionais do produto V01 pai H01
     * tag NFe/infNFe/det[]/infAdProd
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taginfAdProd(stdClass $std): DOMElement
    {
        $possible = ['item', 'infAdProd'];
        $std = $this->equilizeParameters($std, $possible);
        $infAdProd = $this->dom->createElement(
            "infAdProd",
            $std->infAdProd
        );
        $this->aInfAdProd[$std->item] = $infAdProd;
        return $infAdProd;
    }

    /**
     * Grupo de observações de uso livre (para o item da NF-e)
     * Grupo de observações de uso livre do Contribuinte
     * @param stdClass $std
     * @return DOMElement|null
     * @throws DOMException
     */
    public function tagObsItem(stdClass $std): ?DOMElement
    {
        $possible = [
            'item',
            'obsCont_xCampo',
            'obsCont_xTexto',
            'obsFisco_xCampo',
            'obsFisco_xTexto'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "VA01 obsItem Item: $std->item -";
        $obsItem = $this->dom->createElement("obsItem");
        if (!empty($std->obsCont_xCampo) && !empty($std->obsCont_xTexto)) {
            $obsCont = $this->dom->createElement("obsCont");
            $obsCont->setAttribute("xCampo", $std->obsCont_xCampo ?? '');
            $this->dom->addChild(
                $obsCont,
                "xTexto",
                $std->obsCont_xTexto,
                true,
                $identificador . "$identificador (obsCont/xTexto) Conteúdo do campo"
            );
            $obsItem->appendChild($obsCont);
        }
        if (!empty($std->obsFisco_xCampo) && !empty($std->obsFisco_xTexto)) {
            $obsFisco = $this->dom->createElement("obsFisco");
            $obsFisco->setAttribute("xCampo", $std->obsCont_xCampo ?? '');
            $this->dom->addChild(
                $obsFisco,
                "xTexto",
                $std->obsFisco_xTexto,
                true,
                $identificador . "$identificador (obsCont/xTexto) Conteúdo do campo"
            );
            $obsItem->appendChild($obsFisco);
        }
        $this->aObsItem[$std->item] = $obsItem;
        return $obsItem;
    }

    /**
     * NVE NOMENCLATURA DE VALOR ADUANEIRO E ESTATÍSTICA
     * Podem ser até 8 NVE's por item
     * @param stdClass $std
     * @return DOMElement|null
     * @throws DOMException
     */
    public function tagNVE(stdClass $std): ?DOMElement
    {
        $possible = ['item', 'NVE'];
        $std = $this->equilizeParameters($std, $possible);
        if ($std->NVE == '') {
            return null;
        }
        $nve = $this->dom->createElement("NVE", $std->NVE);
        $this->aNVE[$std->item][] = $nve;
        return $nve;
    }

    /**
     * Grupo de informações sobre o CréditoPresumido no Item
     * tag NFe/infNFe/det[item]/gCred (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggCred(stdClass $std): DOMElement
    {
        $possible = ['item', 'cCredPresumido', 'pCredPresumido', 'vCredPresumido'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = " gCred Item: $std->item -";
        $gCred = $this->dom->createElement("gCred");
        $this->dom->addChild(
            $gCred,
            "cCredPresumido",
            $std->cCredPresumido,
            true,
            "$identificador Código de Benefício Fiscal de Crédito Presumido na UF aplicado ao item."
        );
        $this->dom->addChild(
            $gCred,
            "pCredPresumido",
            $this->conditionalNumberFormatting($std->pCredPresumido, 4),
            true,
            "$identificador Percentual do Crédito Presumido."
        );
        $this->dom->addChild(
            $gCred,
            "vCredPresumido",
            $this->conditionalNumberFormatting($std->vCredPresumido),
            false,
            "$identificador Valor do Crédito Presumido."
        );
        $this->aGCred[$std->item][] = $gCred;
        return $gCred;
    }

    /**
     * Declaração de Importação I8 pai I01
     * tag NFe/infNFe/det[]/prod/DI
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagDI(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nDI',
            'dDI',
            'xLocDesemb',
            'UFDesemb',
            'dDesemb',
            'tpViaTransp',
            'vAFRMM',
            'tpIntermedio',
            'CNPJ',
            'CPF',
            'UFTerceiro',
            'cExportador'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "I8 DI Item: $std->item -";
        $tDI = $this->dom->createElement("DI");
        $this->dom->addChild(
            $tDI,
            "nDI",
            $std->nDI,
            true,
            "$identificador Número do Documento de Importação (DI, DSI, DIRE, ...)"
        );
        $this->dom->addChild(
            $tDI,
            "dDI",
            $std->dDI,
            true,
            "$identificador Data de Registro do documento"
        );
        $this->dom->addChild(
            $tDI,
            "xLocDesemb",
            $std->xLocDesemb,
            true,
            "$identificador Local de desembaraço"
        );
        $this->dom->addChild(
            $tDI,
            "UFDesemb",
            $std->UFDesemb,
            true,
            "$identificador Sigla da UF onde ocorreu o Desembaraço Aduaneiro"
        );
        $this->dom->addChild(
            $tDI,
            "dDesemb",
            $std->dDesemb,
            true,
            "$identificador Data do Desembaraço Aduaneiro"
        );
        $this->dom->addChild(
            $tDI,
            "tpViaTransp",
            $std->tpViaTransp,
            true,
            "$identificador Via de transporte internacional "
            . "informada na Declaração de Importação (DI)"
        );
        $this->dom->addChild(
            $tDI,
            "vAFRMM",
            $this->conditionalNumberFormatting($std->vAFRMM),
            false,
            "$identificador Valor da AFRMM "
            . "- Adicional ao Frete para Renovação da Marinha Mercante"
        );
        $this->dom->addChild(
            $tDI,
            "tpIntermedio",
            $std->tpIntermedio,
            true,
            "$identificador Forma de importação quanto a intermediação"
        );
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $tDI,
                "CNPJ",
                $std->CNPJ,
                false,
                "$identificador CNPJ do adquirente ou do encomendante"
            );
        } else {
            $this->dom->addChild(
                $tDI,
                "CPF",
                $std->CPF,
                false,
                "$identificador CPF do adquirente ou do encomendante"
            );
        }
        $this->dom->addChild(
            $tDI,
            "UFTerceiro",
            $std->UFTerceiro,
            false,
            "$identificador Sigla da UF do adquirente ou do encomendante"
        );
        $this->dom->addChild(
            $tDI,
            "cExportador",
            $std->cExportador,
            true,
            "$identificador Código do Exportador"
        );
        $this->aDI[$std->item][] = $tDI;
        return $tDI;
    }

    /**
     * Adições I25 pai I18
     * tag NFe/infNFe/det[]/prod/DI/adi
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagadi(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nDI',
            'nAdicao',
            'nSeqAdic',
            'cFabricante',
            'vDescDI',
            'nDraw'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "I25 adi Item: $std->item -";
        $adi = $this->dom->createElement("adi");
        $this->dom->addChild(
            $adi,
            "nAdicao",
            $std->nAdicao ?? null,
            false,
            "$identificador Número da Adição"
        );
        $this->dom->addChild(
            $adi,
            "nSeqAdic",
            $std->nSeqAdic,
            true,
            "$identificador Número sequencial do item dentro da Adição"
        );
        $this->dom->addChild(
            $adi,
            "cFabricante",
            $std->cFabricante,
            true,
            "$identificador Código do fabricante estrangeiro"
        );
        $this->dom->addChild(
            $adi,
            "vDescDI",
            $this->conditionalNumberFormatting($std->vDescDI),
            false,
            "$identificador Valor do desconto do item da DI Adição"
        );
        $this->dom->addChild(
            $adi,
            "nDraw",
            $std->nDraw,
            false,
            "$identificador Número do ato concessório de Drawback"
        );
        $this->aAdi[$std->item][$std->nDI][] = $adi;
        return $adi;
    }

    /**
     * Grupo de informações de exportação para o item I50 pai I01
     * tag NFe/infNFe/det[]/prod/detExport
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagdetExport(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nDraw',
            'nRE',
            'chNFe',
            'qExport'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "I50 detExport Item: $std->item -";
        $detExport = $this->dom->createElement("detExport");
        $this->dom->addChild(
            $detExport,
            "nDraw",
            Strings::onlyNumbers($std->nDraw),
            false,
            "$identificador Número do ato concessório de Drawback"
        );
        if (!empty($std->nRE) || !empty($std->chNFe) || !empty($std->qExport)) {
            $exportInd = $this->dom->createElement("exportInd");
            $this->dom->addChild(
                $exportInd,
                "nRE",
                Strings::onlyNumbers($std->nRE),
                true,
                "$identificador Número do Registro de Exportação"
            );
            $this->dom->addChild(
                $exportInd,
                "chNFe",
                $std->chNFe,
                true,
                "$identificador Chave de Acesso da NF-e recebida para exportação"
            );
            $this->dom->addChild(
                $exportInd,
                "qExport",
                $this->conditionalNumberFormatting($std->qExport, 4),
                true,
                "$identificador Quantidade do item realmente exportado"
            );
            $this->dom->appChild($detExport, $exportInd);
        }
        $this->aDetExport[$std->item][] = $detExport;
        return $detExport;
    }
}
