<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use NFePHP\Common\DOMImproved;

/**
 * @property DOMImproved $dom
 * @property int $mod
 * @property int $tpAmb
 * @property DOMElement $agropecuarioGuia
 * @property array $agropecuarioDefencivo
 *  @method equilizeParameters($std, $possible)
 */
trait TraitTagAgropecuario
{
    /**
     * Informações de produtos da agricultura, pecuária e produção Florestal ZF01 pai A01
     * tag NFe/infNFe/agropecuario/guiaTransito (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagAgropecuarioGuia(stdClass $std): DOMElement
    {
        $possible = [
            'tpGuia',
            'UFGuia',
            'serieGuia',
            'nGuia'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZF04 guiaTransito -';
        $guia = $this->dom->createElement("guiaTransito");
        $this->dom->addChild(
            $guia,
            "tpGuia",
            $std->tpGuia,
            true,
            "$identificador Tipo da Guia"
        );
        $this->dom->addChild(
            $guia,
            "UFGuia",
            !empty($std->UFGuia) ? $std->UFGuia : null,
            false,
            "$identificador UF de emissão"
        );
        $this->dom->addChild(
            $guia,
            "serieGuia",
            $std->serieGuia ?? null,
            false,
            "$identificador Série da Guia"
        );
        $this->dom->addChild(
            $guia,
            "nGuia",
            $std->nGuia,
            true,
            "$identificador Número da Guia"
        );
        $this->agropecuarioGuia = $guia;
        return $guia;
    }

    /**
     * Bloco defencivo de 0 a 20 ocorrencias
     * tag NFe/infNFe/agropecuario/defensivo (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagAgropecuarioDefensivo(stdClass $std): DOMElement
    {
        $possible = [
            'nReceituario',
            'CPFRespTec'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZF02 defencifo -';
        $def = $this->dom->createElement("defensivo");
        $this->dom->addChild(
            $def,
            "nReceituario",
            $std->nReceituario,
            true,
            "$identificador Número da receita ou receituário do agrotóxico/defensivo agrícola"
        );
        $this->dom->addChild(
            $def,
            "CPFRespTec",
            $std->CPFRespTec,
            true,
            "$identificador CPF do Responsável Técnico, emitente do receituário"
        );
        $this->aAgropecuarioDefensivo[] = $def;
        return $def;
    }
}
