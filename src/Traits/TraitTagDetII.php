<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property stdClass $stdTot
 * @property array $aII
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagDetII
{
    /**
     * Grupo Imposto de Importação P01 pai M01
     * tag NFe/infNFe/det[]/imposto/II
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagII(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vBC',
            'vDespAdu',
            'vII',
            'vIOF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "P01 <II> Item: $std->item -";
        //totalizador
        $this->stdTot->vII += (float) $std->vII;
        $tii = $this->dom->createElement('II');
        $this->dom->addChild(
            $tii,
            "vBC",
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "$identificador Valor BC do Imposto de Importação (vBC)"
        );
        $this->dom->addChild(
            $tii,
            "vDespAdu",
            $this->conditionalNumberFormatting($std->vDespAdu),
            true,
            "$identificador Valor despesas aduaneiras (vDespAdu)"
        );
        $this->dom->addChild(
            $tii,
            "vII",
            $this->conditionalNumberFormatting($std->vII),
            true,
            "$identificador Valor Imposto de Importação (vII)"
        );
        $this->dom->addChild(
            $tii,
            "vIOF",
            $this->conditionalNumberFormatting($std->vIOF),
            true,
            "$identificador Valor Imposto sobre Operações Financeiras (vIOF)"
        );
        $this->aII[$std->item] = $tii;
        return $tii;
    }
}
