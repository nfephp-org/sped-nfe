<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use NFePHP\NFe\Common\Gtin;

trait TraitTagDet
{
    /**
     * Informações adicionais do produto V01 pai H01
     * tag NFe/infNFe/det[]/infAdProd
     */
    public function taginfAdProd(stdClass $std): DOMElement
    {
        $possible = ['item', 'infAdProd'];
        $std = $this->equilizeParameters($std, $possible);
        $infAdProd = $this->dom->createElement(
            "infAdProd",
            substr(trim($std->infAdProd), 0, 500)
        );
        $this->aInfAdProd[$std->item] = $infAdProd;
        return $infAdProd;
    }

    /**
     * Detalhamento de Produtos e Serviços I01 pai H01
     * tag NFe/infNFe/det[]/prod
     * NOTA: Ajustado para NT2016_002_v1.30
     * NOTA: Ajustado para NT2020_005_v1.20
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
            'xPed',
            'nItemPed',
            'nFCI'
        ];
        $std = $this->equilizeParameters($std, $possible);
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
        //throw exception if not is Valid
        try {
            Gtin::isValid($cean);
        } catch (\InvalidArgumentException $e) {
            $this->errors[] = "cEANT {$cean} " . $e->getMessage();
        }

        try {
            Gtin::isValid($ceantrib);
        } catch (\InvalidArgumentException $e) {
            $this->errors[] = "cEANTrib {$ceantrib} " . $e->getMessage();
        }

        $identificador = 'I01 <prod> - ';
        $prod = $this->dom->createElement("prod");
        $this->dom->addChild(
            $prod,
            "cProd",
            $std->cProd,
            true,
            $identificador . "[item $std->item] Código do produto ou serviço"
        );
        $this->dom->addChild(
            $prod,
            "cEAN",
            $cean,
            true,
            $identificador . "[item $std->item] GTIN (Global Trade Item Number) do produto, antigo "
            . "código EAN ou código de barras",
            true
        );
        $this->dom->addChild(
            $prod,
            "cBarra",
            $std->cBarra ?? null,
            false,
            $identificador . "[item $std->item] cBarra Código de barras diferente do padrão GTIN"
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
            $identificador . "[item $std->item] Descrição do produto ou serviço"
        );
        $this->dom->addChild(
            $prod,
            "NCM",
            $std->NCM,
            true,
            $identificador . "[item $std->item] Código NCM com 8 dígitos ou 2 dígitos (gênero)"
        );
        //incluido no layout 4.00
        $this->dom->addChild(
            $prod,
            "cBenef",
            $std->cBenef,
            false,
            $identificador . "[item $std->item] Código de Benefício Fiscal utilizado pela UF"
        );
        $this->dom->addChild(
            $prod,
            "EXTIPI",
            $std->EXTIPI,
            false,
            $identificador . "[item $std->item] Preencher de acordo com o código EX da TIPI"
        );
        $this->dom->addChild(
            $prod,
            "CFOP",
            $std->CFOP,
            true,
            $identificador . "[item $std->item] Código Fiscal de Operações e Prestações"
        );
        $this->dom->addChild(
            $prod,
            "uCom",
            $std->uCom,
            true,
            $identificador . "[item $std->item] Unidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "qCom",
            $this->conditionalNumberFormatting($std->qCom, 4),
            true,
            $identificador . "[item $std->item] Quantidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnCom",
            $this->conditionalNumberFormatting($std->vUnCom, 10),
            true,
            $identificador . "[item $std->item] Valor Unitário de Comercialização do produto"
        );
        $this->dom->addChild(
            $prod,
            "vProd",
            $this->conditionalNumberFormatting($std->vProd),
            true,
            $identificador . "[item $std->item] Valor Total Bruto dos Produtos ou Serviços"
        );
        $this->dom->addChild(
            $prod,
            "cEANTrib",
            $ceantrib,
            true,
            $identificador . "[item $std->item] GTIN (Global Trade Item Number) da unidade tributável, antigo "
            . "código EAN ou código de barras",
            true
        );
        $this->dom->addChild(
            $prod,
            "cBarraTrib",
            $std->cBarraTrib ?? null,
            false,
            $identificador . "[item $std->item] cBarraTrib Código de Barras da "
            . "unidade tributável que seja diferente do padrão GTIN"
        );
        $this->dom->addChild(
            $prod,
            "uTrib",
            $std->uTrib,
            true,
            $identificador . "[item $std->item] Unidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "qTrib",
            $this->conditionalNumberFormatting($std->qTrib, 4),
            true,
            $identificador . "[item $std->item] Quantidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnTrib",
            $this->conditionalNumberFormatting($std->vUnTrib, 10),
            true,
            $identificador . "[item $std->item] Valor Unitário de tributação do produto"
        );
        $this->dom->addChild(
            $prod,
            "vFrete",
            $this->conditionalNumberFormatting($std->vFrete),
            false,
            $identificador . "[item $std->item] Valor Total do Frete"
        );
        $this->dom->addChild(
            $prod,
            "vSeg",
            $this->conditionalNumberFormatting($std->vSeg),
            false,
            $identificador . "[item $std->item] Valor Total do Seguro"
        );
        $this->dom->addChild(
            $prod,
            "vDesc",
            $this->conditionalNumberFormatting($std->vDesc),
            false,
            $identificador . "[item $std->item] Valor do Desconto"
        );
        $this->dom->addChild(
            $prod,
            "vOutro",
            $this->conditionalNumberFormatting($std->vOutro),
            false,
            $identificador . "[item $std->item] Outras despesas acessórias"
        );
        $this->dom->addChild(
            $prod,
            "indTot",
            $std->indTot,
            true,
            $identificador . "[item $std->item] Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)"
        );
        $this->dom->addChild(
            $prod,
            "xPed",
            $std->xPed,
            false,
            $identificador . "[item $std->item] Número do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nItemPed",
            $std->nItemPed,
            false,
            $identificador . "[item $std->item] Item do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nFCI",
            $std->nFCI,
            false,
            $identificador . "[item $std->item] Número de controle da FCI "
            . "Ficha de Conteúdo de Importação"
        );
        $this->aProd[$std->item] = $prod;
        return $prod;
    }
}
