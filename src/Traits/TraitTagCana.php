<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property Dom $dom
 * @property DOMElement $cana
 * @property array $aForDia
 * @property array $aDeduc
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
 */
trait TraitTagCana
{
    /**
     * Grupo Cana ZC01 pai A01
     * tag NFe/infNFe/cana (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagcana(stdClass $std): DOMElement
    {
        $possible = [
            'safra',
            'ref',
            'qTotMes',
            'qTotAnt',
            'qTotGer',
            'vFor',
            'vTotDed',
            'vLiqFor'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZC01 cana -';
        $this->cana = $this->dom->createElement("cana");
        $this->dom->addChild(
            $this->cana,
            "safra",
            $std->safra,
            true,
            "$identificador Identificação da safra"
        );
        $this->dom->addChild(
            $this->cana,
            "ref",
            $std->ref,
            true,
            "$identificador Mês e ano de referência"
        );
        $this->dom->addChild(
            $this->cana,
            "qTotMes",
            $std->qTotMes,
            true,
            "$identificador Quantidade Total do Mês"
        );
        $this->dom->addChild(
            $this->cana,
            "qTotAnt",
            $std->qTotAnt,
            true,
            "$identificador Quantidade Total Anterior"
        );
        $this->dom->addChild(
            $this->cana,
            "qTotGer",
            $std->qTotGer,
            true,
            "$identificador Quantidade Total Geral"
        );
        $this->dom->addChild(
            $this->cana,
            "vFor",
            $this->conditionalNumberFormatting($std->vFor),
            true,
            "$identificador Valor dos Fornecimentos"
        );
        $this->dom->addChild(
            $this->cana,
            "vTotDed",
            $this->conditionalNumberFormatting($std->vTotDed),
            true,
            "$identificador Valor Total da Dedução"
        );
        $this->dom->addChild(
            $this->cana,
            "vLiqFor",
            $this->conditionalNumberFormatting($std->vLiqFor),
            true,
            "$identificador Valor Líquido dos Fornecimentos"
        );
        return $this->cana;
    }

    /**
     * Grupo Fornecimento diário de cana ZC04 pai ZC01
     * tag NFe/infNFe/cana/forDia
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagforDia(stdClass $std): DOMElement
    {
        $possible = [
            'dia',
            'qtde'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZC04 forDia -';
        $forDia = $this->dom->createElement("forDia");
        $forDia->setAttribute("dia", $std->dia);
        $this->dom->addChild(
            $forDia,
            "qtde",
            $this->conditionalNumberFormatting($std->qtde, 10),
            true,
            "$identificador Quantidade"
        );
        $this->aForDia[] = $forDia;
        return $forDia;
    }

    /**
     * Grupo Deduções – Taxas e Contribuições ZC10 pai ZC01
     * tag NFe/infNFe/cana/deduc (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagdeduc(stdClass $std): DOMElement
    {
        $possible = ['xDed', 'vDed'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZC10 deduc -';
        $deduc = $this->dom->createElement("deduc");
        $this->dom->addChild(
            $deduc,
            "xDed",
            $std->xDed,
            true,
            "$identificador Descrição da Dedução"
        );
        $this->dom->addChild(
            $deduc,
            "vDed",
            $this->conditionalNumberFormatting($std->vDed),
            true,
            "$identificador Valor da Dedução"
        );
        $this->aDeduc[] = $deduc;
        return $deduc;
    }
}
