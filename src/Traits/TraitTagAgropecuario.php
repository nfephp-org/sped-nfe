<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use NFePHP\Common\DOMImproved;

/**
 * @method equilizeParameters($std, $possible)
 * @property DOMImproved $dom
 * @property int $mod
 * @property int $tpAmb
 * @property DOMElement $dest
 */
trait TraitTagAgropecuario
{
    /**
     * Informações de produtos da agricultura, pecuária e produção Florestal ZF01 pai A01
     * tag NFe/infNFe/agropecuario (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagagropecuario(stdClass $std): DOMElement
    {
        $possible = [
            'nReceituario',
            'CPFRespTec',
            'tpGuia',
            'UFGuia',
            'serieGuia',
            'nGuia'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $agro = $this->dom->createElement("agropecuario");
        if (!empty($std->nReceituario)) {
            $def = $this->dom->createElement("defencivo");
            $this->dom->addChild(
                $def,
                "nReceituario",
                $std->nReceituario,
                true,
                "Número da receita ou receituário do agrotóxico/defensivo agrícola"
            );
            $this->dom->addChild(
                $def,
                "CPFRespTec",
                $std->CPFRespTec,
                true,
                "CPF do Responsável Técnico, emitente do receituário"
            );
            $agro->appendChild($def);
        } elseif (!empty($std->tpGuia)) {
            $guia = $this->dom->createElement("guiaTransito");
            $this->dom->addChild(
                $guia,
                "tpGuia",
                $std->tpGuia,
                true,
                "Tipo da Guia"
            );
            $this->dom->addChild(
                $guia,
                "UFGuia",
                !empty($std->UFGuia) ? $std->UFGuia : null,
                false,
                "UF de emissão"
            );
            $this->dom->addChild(
                $guia,
                "serieGuia",
                $std->serieGuia ?? null,
                false,
                "Série da Guia"
            );
            $this->dom->addChild(
                $guia,
                "nGuia",
                $std->nGuia,
                true,
                "Número da Guia"
            );
            $agro->appendChild($guia);
        }
        $this->agropecuario = $agro;
        return $agro;
    }
}
