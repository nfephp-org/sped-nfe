<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;

trait TraitTagInfNfe
{
    /**
     * Informações da NF-e A01 pai NFe
     * tag NFe/infNFe
     */
    public function taginfNFe(stdClass $std): DOMElement
    {
        $possible = ['Id', 'versao', 'pk_nItem'];
        $std = $this->equilizeParameters($std, $possible);
        $chave = preg_replace('/[^0-9]/', '', $std->Id);
        $this->infNFe = $this->dom->createElement("infNFe");
        $this->infNFe->setAttribute("Id", 'NFe' . $chave);
        $this->infNFe->setAttribute(
            "versao",
            $std->versao
        );
        $this->version = $std->versao;
        if (!empty($std->pk_nItem)) {
            $this->infNFe->setAttribute("pk_nItem", $std->pk_nItem);
        }
        $this->chNFe = $chave;
        return $this->infNFe;
    }
}
