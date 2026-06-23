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
 * @property array $aRefDFeAnt
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
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
        $possible = ['tpEnteGov', 'pRedutor', 'tpOperGov', 'refDFeAnt'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'B31 gCompraGov -';
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
        $this->dom->addChild(
            $gc,
            "tpOperGov",
            $std->tpOperGov,
            true,
            $identificador . "Tipo de operação com o ente governamental (tpOperGov)"
        );
        $this->gCompraGov = $gc;
        return $gc;
    }

    /**
     * Chave de acesso do documento fiscal anterior BB05 pai BB01
     * tag NFe/infNFe/ide/gCompraGov/refDFeAnt (opcional) 0-99 repetições
     * NT 2005.002 v1.50
     * @param stdClass $std
     * @return DOMElement
     */
    public function tagrefDFeAnt(stdClass $std): DOMElement
    {
        $possible = ['refDFeAnt'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'BB05 refDFeAnt -';
        $refDFeAnt = $this->dom->createElement("refDFeAnt", $std->refDFeAnt);
        $this->aRefDFeAnt[] = $refDFeAnt;
        return $refDFeAnt;
    }
}
