<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;

/**
 * @property Dom $dom
 * @property array $aAutXML
 * @method equilizeParameters($std, $possible)
 */

trait TraitTagAutXml
{
    /**
     * Pessoas autorizadas para o download do XML da NF-e G50 pai A01
     * tag NFe/infNFe/autXML
     */
    public function tagautXML(stdClass $std): DOMElement
    {
        $possible = ['CNPJ', 'CPF'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'G50 autXML - ';
        $std->CNPJ = !empty($std->CNPJ) ? $std->CNPJ : null;
        $std->CPF = !empty($std->CPF) ? $std->CPF : null;
        $autXML = $this->dom->createElement("autXML");
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $autXML,
                "CNPJ",
                $std->CNPJ,
                false,
                $identificador . "CNPJ do Cliente Autorizado"
            );
        } elseif (!empty($std->CPF)) {
            $this->dom->addChild(
                $autXML,
                "CPF",
                $std->CPF,
                false,
                $identificador . "CPF do Cliente Autorizado"
            );
        }
        $this->aAutXML[] = $autXML;
        return $autXML;
    }
}
