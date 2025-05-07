<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use DOMException;
use NFePHP\Common\DOMImproved as Dom;

/**
 * @property DOMElement $infNFe
 * @property string $version
 * @property string $chNFe
 * @property Dom $dom
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagInfNfe
{
    /**
     * Informações da NF-e A01 pai NFe
     * tag NFe/infNFe
     * @throws DOMException
     */
    public function taginfNFe(stdClass $std): DOMElement
    {
        $possible = ['Id', 'versao', 'pk_nItem'];
        $std = $this->equilizeParameters($std, $possible);
        $chave = null;
        $this->version = $std->versao;
        if (!empty($std->Id)) {
            $chave = substr($std->Id, 2, 44);
        }
        $this->infNFe = $this->dom->createElement("infNFe");
        $this->infNFe->setAttribute("Id", 'NFe' . $chave);
        $this->infNFe->setAttribute("versao", $std->versao);
        if (!empty($std->pk_nItem)) {
            $this->infNFe->setAttribute("pk_nItem", $std->pk_nItem);
        }
        $this->chNFe = $chave;
        return $this->infNFe;
    }
}
