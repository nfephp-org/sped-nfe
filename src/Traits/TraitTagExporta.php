<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property DOMElement $exporta
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagExporta
{
    /**
     * Grupo Exportação ZA01 pai A01
     * tag NFe/infNFe/exporta (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagexporta(stdClass $std): DOMElement
    {
        $possible = ['UFSaidaPais', 'xLocExporta', 'xLocDespacho'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZA01 exporta -';
        $this->exporta = $this->dom->createElement("exporta");
        $this->dom->addChild(
            $this->exporta,
            "UFSaidaPais",
            $std->UFSaidaPais,
            true,
            "$identificador Sigla da UF de Embarque ou de transposição de fronteira"
        );
        $this->dom->addChild(
            $this->exporta,
            "xLocExporta",
            $std->xLocExporta,
            true,
            "$identificador Descrição do Local de Embarque ou de transposição de fronteira"
        );
        $this->dom->addChild(
            $this->exporta,
            "xLocDespacho",
            $std->xLocDespacho,
            false,
            "$identificador Descrição do local de despacho"
        );
        return $this->exporta;
    }
}
