<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property Dom $dom
 * @property stdClass $stdTot
 * @property array $aImposto
 * @property array $aImpostoDevol
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagDetImposto
{
    /**
     * Impostos com o valor total tributado M01 pai H01
     * tag NFe/infNFe/det[]/imposto
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagimposto(stdClass $std): DOMElement
    {
        $possible = ['item', 'vTotTrib'];
        $std = $this->equilizeParameters($std, $possible);
        //totalizador dos valores dos itens
        $this->stdTot->vTotTrib += (float) $std->vTotTrib;
        $identificador = "M01 <imposto> Item: $std->item -";
        $imposto = $this->dom->createElement("imposto");
        $this->dom->addChild(
            $imposto,
            "vTotTrib",
            $this->conditionalNumberFormatting($std->vTotTrib),
            false,
            "$identificador Valor aproximado total de tributos federais, estaduais e municipais. (vTotTrib)"
        );
        $this->aImposto[$std->item] = $imposto;
        return $imposto;
    }

    /**
     * Informação do Imposto devolvido U50 pai H01
     * tag NFe/infNFe/det[]/impostoDevol (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagimpostoDevol(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'pDevol',
            'vIPIDevol'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "U50 <impostoDevol> Item: $std->item -";
        //totalizador
        $this->stdTot->vIPIDevol += (float) $std->vIPIDevol;
        $impostoDevol = $this->dom->createElement("impostoDevol");
        $this->dom->addChild(
            $impostoDevol,
            "pDevol",
            $this->conditionalNumberFormatting($std->pDevol, 2),
            true,
            "$identificador Percentual da mercadoria devolvida (pDevol)"
        );
        $parent = $this->dom->createElement("IPI");
        $this->dom->addChild(
            $parent,
            "vIPIDevol",
            $this->conditionalNumberFormatting($std->vIPIDevol),
            true,
            "$identificador Valor do IPI devolvido (vIPIDevol)"
        );
        $impostoDevol->appendChild($parent);
        $this->aImpostoDevol[$std->item] = $impostoDevol;
        return $impostoDevol;
    }
}
