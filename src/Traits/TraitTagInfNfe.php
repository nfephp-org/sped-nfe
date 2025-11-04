<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use DOMException;
use NFePHP\Common\DOMImproved as Dom;

/**
 * @property DOMElement $infNFe
 * @property DOMElement $infNFeSupl
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
        $this->version = (string) $std->versao;
        if (!empty($std->Id)) {
            $chave = $std->Id;
            if (substr($std->Id, 0, 3) == 'NFe') {
                $chave = substr($std->Id, 3, 44);
            }
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

    /**
     * Informações suplementares da Nota Fiscal
     */
    public function taginfNFeSupl(stdClass $std): DOMElement
    {
        $possible = ['qrcode', 'urlChave'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = " infNFeSupl -";
        $infNFeSupl = $this->dom->createElement("infNFeSupl");
        $nodeqr = $infNFeSupl->appendChild($this->dom->createElement('qrCode'));
        $nodeqr->appendChild($this->dom->createCDATASection($std->qrcode));
        //incluido no layout 4.00
        $std->urlChave = !empty($std->urlChave) ? $std->urlChave : null;
        $this->dom->addChild(
            $infNFeSupl,
            "urlChave",
            $std->urlChave,
            false,
            "$identificador URL de consulta por chave de acesso a ser impressa no DANFE NFC-e"
        );
        $this->infNFeSupl = $infNFeSupl;
        return $infNFeSupl;
    }
}
