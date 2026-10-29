<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property array $aPgtoVinc
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagPgtoVinc
{
    /**
     * Grupo de informações da Vinculação com a Transação de Pagamento YC01 pai A01
     * tag NFe/infNFe/gPgtoVinc (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagPgtoVinc(stdClass $std): DOMElement
    {
        $possible = ['nPag', 'idTransacao', 'tpMeioPgto', 'CNPJReceb', 'CNPJBasePSP'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "YC01 gPgtoVinc - gPgto nPag: $std->nPag ";
        $vinc = $this->dom->createElement("gPgto");
        $vinc->setAttribute("nPag", $std->nPag);
        $vinc->setAttribute("idTransacao", $std->idTransacao);
        $this->dom->addChild(
            $vinc,
            "tpMeioPgto",
            $std->tpMeioPgto,
            true,
            "$identificador Código do meio de pagamento"
        );
        $this->dom->addChild(
            $vinc,
            "CNPJReceb",
            $std->CNPJReceb,
            true,
            "$identificador CNPJ completo do recebedor do pagamento (fornecedor, plataforma, ou outra entidade"
            . " que receba o pagamento do adquirente)"
        );
        $this->dom->addChild(
            $vinc,
            "CNPJBasePSP",
            $std->CNPJBasePSP,
            true,
            "$identificador CNPJ base da instituição financeira ou de pagamento utilizada pelo recebedor do "
            . "pagamento (fornecedor, plataforma, ou outra entidade que receba o pagamento do adquirente)"
        );
        $this->aPgtoVinc[$std->nPag] = $vinc;
        return $vinc;
    }
}
