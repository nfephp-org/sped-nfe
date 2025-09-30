<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;

/**
 * @property Dom $dom
 * @property DOMElement $CEST
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagDetCEST
{
    /**
     * Código Especificador da Substituição Tributária – CEST,
     * que identifica a mercadoria sujeita aos regimes de substituição
     * tributária e de antecipação do recolhimento do imposto.
     * vide NT2015.003  I05C pai
     * tag NFe/infNFe/det[item]/prod/CEST (opcional)
     * NOTA: Ajustado para NT2016_002_v1.30
     */
    public function tagCEST(stdClass $std): DOMElement
    {
        $possible = ['item', 'CEST', 'indEscala', 'CNPJFab'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I05b <ctrltST> - ';
        $ctrltST = $this->dom->createElement("ctrltST");
        $this->dom->addChild(
            $ctrltST,
            "CEST",
            preg_replace("/[^0-9]/", "", (string) ($std->CEST)),
            true,
            "$identificador [item $std->item] Numero CEST"
        );
        //incluido no layout 4.00
        $this->dom->addChild(
            $ctrltST,
            "indEscala",
            $std->indEscala,
            false,
            "$identificador [item $std->item] Indicador de Produção em escala relevante"
        );
        //incluido no layout 4.00
        $this->dom->addChild(
            $ctrltST,
            "CNPJFab",
            preg_replace("/[^0-9]/", "", (string) $std->CNPJFab),
            false,
            "$identificador [item $std->item] CNPJ do Fabricante da Mercadoria,"
                . "obrigatório para produto em escala NÃO relevante."
        );
        $this->aCest[$std->item][] = $ctrltST;
        return $ctrltST;
    }
}
