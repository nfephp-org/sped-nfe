<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;

trait TraitTagDetNve
{
    /**
     * NVE NOMENCLATURA DE VALOR ADUANEIRO E ESTATÍSTICA
     * Podem ser até 8 NVE's por item
     *
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
}
