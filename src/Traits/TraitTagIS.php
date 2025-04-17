<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved;
use stdClass;
use DOMElement;

/**
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 * @property DOMImproved $dom
 * @property array $aIS
 * @property stdClass $stdTot
 */
trait TraitTagIS
{
    /**
     * Grupo IS (Imposto selectivo) UB01 pai H01
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagIS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CSTIS',
            'cClassTribIS',
            'vBCIS',
            'pIS',
            'pISEspec',
            'uTrib',
            'qTrib',
            'vIS'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->stdTot->vIS += (float) $std->vIS;
        $is = $this->dom->createElement("IS");
        $this->dom->addChild(
            $is,
            (string) "CSTIS",
            $std->CSTIS,
            true,
            "[item $std->item] Código de Situação Tributária do Imposto Seletivo"
        );
        $this->dom->addChild(
            $is,
            "cClassTribIS",
            (string) $std->cClassTribIS,
            true,
            "[item $std->item] Código de Classificação Tributária do Imposto Seletivo"
        );
        $obriga = false;
        if (!empty($std->vBCIS) || !empty($std->pIS) || !empty($std->pISEspec)) {
            $obriga = true;
        }
        $this->dom->addChild(
            $is,
            "vBCIS",
            $this->conditionalNumberFormatting($std->vBCIS),
            $obriga,
            "[item $std->item] Valor da Base de Cálculo do Imposto Seletivo"
        );
        $this->dom->addChild(
            $is,
            "pIS",
            $this->conditionalNumberFormatting($std->pIS),
            $obriga,
            "[item $std->item] Alíquota do Imposto Seletivo"
        );
        $this->dom->addChild(
            $is,
            "pISEspec",
            $this->conditionalNumberFormatting($std->pISEspec),
            false,
            "[item $std->item] Alíquota específica por unidade de medida apropriada"
        );
        $obriga = false;
        if (!empty($std->uTrib) || !empty($std->qTrib) || !empty($std->vIS)) {
            $obriga = true;
        }
        $this->dom->addChild(
            $is,
            "uTrib",
            $std->uTrib,
            $obriga,
            "[item $std->item] Unidade de Medida Tributável"
        );
        $this->dom->addChild(
            $is,
            "qTrib",
            $this->conditionalNumberFormatting($std->qTrib),
            $obriga,
            "[item $std->item] Unidade de Medida Tributável"
        );
        $this->aIS[$std->item] = $is;
        return $is;
    }
}
