<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
 * @property DOMImproved $dom
 * @property array $aIS
 * @property stdClass $stdIStot
 */
trait TraitTagDetIS
{
    /**
     * Grupo IS (Imposto selectivo) UB01 pai H01
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = "UB01 IS Item: $std->item -";
        //totalizador
        $this->stdIStot->vIS += (float) $std->vIS;
        $is = $this->dom->createElement("IS");
        $this->dom->addChild(
            $is,
            (string) "CSTIS",
            $std->CSTIS,
            true,
            "$identificador Código de Situação Tributária do Imposto Seletivo"
        );
        $this->dom->addChild(
            $is,
            "cClassTribIS",
            (string) $std->cClassTribIS,
            true,
            "$identificador Código de Classificação Tributária do Imposto Seletivo"
        );
        if (isset($std->vBCIS)) {
            $this->dom->addChild(
                $is,
                "vBCIS",
                $this->conditionalNumberFormatting($std->vBCIS),
                true,
                "$identificador Valor da Base de Cálculo do Imposto Seletivo"
            );
            $this->dom->addChild(
                $is,
                "pIS",
                $this->conditionalNumberFormatting($std->pIS ?? 0, 4),
                true,
                "$identificador Alíquota do Imposto Seletivo"
            );
            $this->dom->addChild(
                $is,
                "pISEspec",
                $this->conditionalNumberFormatting($std->pISEspec ?? null, 4),
                false,
                "$identificador Alíquota específica por unidade de medida apropriada"
            );
        }
        if (!empty($std->uTrib) && !empty($std->qTrib)) {
            $this->dom->addChild(
                $is,
                "uTrib",
                $std->uTrib,
                true,
                "$identificador Unidade de Medida Tributável"
            );
            $this->dom->addChild(
                $is,
                "qTrib",
                $this->conditionalNumberFormatting($std->qTrib, 4),
                true,
                "$identificador Quantidade com base no campo uTrib informado"
            );
        }
        $this->dom->addChild(
            $is,
            "vIS",
            $this->conditionalNumberFormatting($std->vIS),
            true,
            "$identificador Valor do Imposto Seletivo calculado"
        );
        $this->aIS[$std->item] = $is;
        return $is;
    }
}
