<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property DOMElement $gPagAntecipado
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagGPagAntecipado
{
    /**
     * Tag gPagAntecipado BC01 pai B01
     * tag NFe/infNFe/ide/gPagAntecipado (opcional)
     * Informado para abater as parcelas de antecipação de pagamento, conforme Art. 10. § 4º
     * Referência a uma NF-e (modelo 55) emitida anteriormente, referente a pagamento antecipado
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggPagAntecipado(stdClass $std): DOMElement
    {
        $possible = ['refNFe'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'BC01 gPagAntecipado -';
        $gc = $this->dom->createElement("gPagAntecipado");
        $arr = (array) $std->refNFe;
        foreach ($arr as $key => $value) {
            $this->dom->addChild(
                $gc,
                "refNFe",
                $value,
                true,
                $identificador . "Chave de acesso da NF-e de antecipação de pagamento (refNFe)"
            );
        }
        $this->gPagAntecipado = $gc;
        return $gc;
    }
}
