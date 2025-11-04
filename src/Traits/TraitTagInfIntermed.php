<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property DOMElement $infIntermed
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagInfIntermed
{
    /**
     * Grupo infIntermed YB01 pai A01
     * tag NFe/infNFe/infIntermed (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagIntermed(stdClass $std): DomElement
    {
        $possible = [
            'CNPJ',
            'idCadIntTran'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'YB01 infIntermed -';
        $tag = $this->dom->createElement("infIntermed");
        $this->dom->addChild(
            $tag,
            "CNPJ",
            $std->CNPJ,
            true,
            "$identificador CNPJ do Intermediador da Transação (agenciador, plataforma de "
            . "delivery, marketplace e similar) de serviços e de negócios"
        );
        $this->dom->addChild(
            $tag,
            "idCadIntTran",
            $std->idCadIntTran,
            true,
            "$identificador Identificador cadastrado no intermediador"
        );
        return $this->infIntermed = $tag;
    }
}
