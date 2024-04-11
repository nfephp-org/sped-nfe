<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;

trait TraitTagDetObs
{
    /**
     * Grupo de observações de uso livre (para o item da NF-e)
     * Grupo de observações de uso livre do Contribuinte
     */
    public function tagprodObsCont(stdClass $std): ?DOMElement
    {
        $possible = [
            'item',
            'xCampo',
            'xTexto'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'VA01 <obsItem> - ';
        $obsItem = $this->dom->createElement("obsItem");
        $obsCont = $this->dom->createElement("obsCont");
        $this->dom->addChild(
            $obsCont,
            "xCampo",
            substr(trim($std->xCampo), 0, 20),
            true,
            $identificador . "[item $std->item] (obsCont/xCampo) Identificação do campo"
        );
        $this->dom->addChild(
            $obsCont,
            "xTexto",
            substr(trim($std->xTexto), 0, 60),
            true,
            $identificador . "[item $std->item] (obsCont/xTexto) Conteúdo do campo"
        );
        $obsItem->appendChild($obsCont);
        $this->obsItem[$std->item] = $obsItem;
        return $obsItem;
    }
}
