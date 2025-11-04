<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property DOMElement $pag
 * @property array $aDetPag
 * @property DOMElement $card
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
 */
trait TraitTagPag
{
    /**
     * Grupo Pagamento Y pai A01
     * NOTA: Ajustado para NT2016_002_v1.30
     * tag NFe/infNFe/pag (obrigatorio na NT2016_002_v1.30)
     * Obrigatório para 55 e 65
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagpag(stdClass $std): DOMElement
    {
        $possible = [
            'vTroco'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'YA01 pag -';
        $this->pag = $this->dom->createElement("pag");
        //incluso no layout 4.00
        $this->dom->addChild(
            $this->pag,
            "vTroco",
            $this->conditionalNumberFormatting($std->vTroco),
            false,
            "$identificador Valor do troco"
        );
        return $this->pag;
    }

    /**
     * Grupo de Formas de Pagamento YA01a pai YA01
     * NOTA: Ajuste NT_2016_002_v1.30
     * NOTA: Ajuste NT_2016_002_v1 51
     * NOTA: Ajuste NT_2020_006
     * tag NFe/infNFe/pag/detPag
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagdetPag(stdClass $std): DOMElement
    {
        $possible = [
            'indPag',
            'tPag',
            'xPag',
            'vPag',
            'dPag',
            'CNPJ',
            'tBand',
            'cAut',
            'tpIntegra',
            'CNPJPag',
            'UFPag',
            'CNPJReceb',
            'idTermPag'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'YA01a detPag -';
        $detPag = $this->dom->createElement("detPag");
        $this->dom->addChild(
            $detPag,
            "indPag",
            $std->indPag,
            false,
            "$identificador Indicador da Forma de Pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "tPag",
            $std->tPag,
            true,
            "$identificador Forma de pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "xPag",
            $std->xPag,
            false,
            "$identificador Descricao da Forma de pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "vPag",
            $this->conditionalNumberFormatting($std->vPag),
            true,
            "$identificador Valor do Pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "dPag",
            !empty($std->dPag) ? $std->dPag : null,
            false,
            "$identificador Data do Pagamento"
        );
        //NT 2023.004 v1.00
        if (!empty($std->CNPJPag) && !empty($std->UFPag)) {
            $this->dom->addChild(
                $detPag,
                "CNPJPag",
                $std->CNPJPag,
                false,
                "$identificador CNPJ transacional do pagamento"
            );
            $this->dom->addChild(
                $detPag,
                "UFPag",
                $std->UFPag,
                false,
                "$identificador UF do CNPJ do estabelecimento onde o pagamento foi processado/transacionado/recebido"
            );
        }
        if (!empty($std->tpIntegra)) {
            $card = $this->dom->createElement("card");
            $this->dom->addChild(
                $card,
                "tpIntegra",
                $std->tpIntegra,
                true,
                "$identificador Tipo de Integração para pagamento"
            );
            $this->dom->addChild(
                $card,
                "CNPJ",
                !empty($std->CNPJ) ? $std->CNPJ : null,
                false,
                "$identificador CNPJ da Credenciadora de cartão de crédito e/ou débito"
            );
            $this->dom->addChild(
                $card,
                "tBand",
                !empty($std->tBand) ? $std->tBand : null,
                false,
                "$identificador Bandeira da operadora de cartão de crédito e/ou débito"
            );
            $this->dom->addChild(
                $card,
                "cAut",
                !empty($std->cAut) ? $std->cAut : null,
                false,
                "$identificador Número de autorização da operação cartão de crédito e/ou débito"
            );
            //NT 2023.004 v1.00
            $this->dom->addChild(
                $card,
                "CNPJReceb",
                !empty($std->CNPJReceb) ? $std->CNPJReceb : null,
                false,
                "$identificador CNPJ do beneficiário do pagamento"
            );
            //NT 2023.004 v1.00
            $this->dom->addChild(
                $card,
                "idTermPag",
                !empty($std->idTermPag) ? $std->idTermPag : null,
                false,
                "$identificador Identificador do terminal de pagamento"
            );
            $this->dom->appChild($detPag, $card, "Inclusão do node Card");
        }
        $this->aDetPag[] = $detPag;
        return $detPag;
    }
}
