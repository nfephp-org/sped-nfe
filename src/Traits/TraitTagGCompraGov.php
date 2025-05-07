<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use Exception;
use DOMException;

/**
 * @property  Dom $dom
 * @property DOMElement $gCompraGov
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagGCompraGov
{
    /**
     * Informação de compras governamentais B31 pai B01
     * tag NFe/infNFe/ide/gCompraGov (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     * @throws Exception
     */
    public function taggCompraGov(stdClass $std): DOMElement
    {
        $possible = ['tpEnteGov', 'pRedutor'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'B31 <gCompraGov> - ';
        $gc = $this->dom->createElement("gCompraGov");
        $this->dom->addChild(
            $gc,
            "tpEnteGov",
            $std->tpEnteGov,
            true,
            $identificador . "Tipo Compras Governamentais (tpEnteGov)"
        );
        $this->dom->addChild(
            $gc,
            "pRedutor",
            $this->conditionalNumberFormatting($std->pRedutor, 4),
            true,
            $identificador . "Percentual de redução de alíquota em compra governamental (pRedutor)"
        );
        $this->gCompraGov = $gc;
        return $gc;
    }
}
