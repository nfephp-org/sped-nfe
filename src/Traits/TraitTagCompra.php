<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property DOMElement $compra
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagCompra
{
    /**
     * Grupo Compra ZB01 pai A01
     * tag NFe/infNFe/compra (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagcompra(stdClass $std): DOMElement
    {
        $possible = ['xNEmp', 'xPed', 'xCont'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZB01 <compra> -';
        $this->compra = $this->dom->createElement("compra");
        $this->dom->addChild(
            $this->compra,
            "xNEmp",
            $std->xNEmp,
            false,
            "$identificador Nota de Empenho"
        );
        $this->dom->addChild(
            $this->compra,
            "xPed",
            $std->xPed,
            false,
            "$identificador Pedido"
        );
        $this->dom->addChild(
            $this->compra,
            "xCont",
            $std->xCont,
            false,
            "$identificador Contrato"
        );
        return $this->compra;
    }
}
