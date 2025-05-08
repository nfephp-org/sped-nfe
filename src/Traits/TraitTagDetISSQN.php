<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property stdClass $stdTot
 * @property array $aISSQN
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagDetISSQN
{
    /**
     * Grupo ISSQN U01 pai M01
     * tag NFe/infNFe/det[]/imposto/ISSQN (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagISSQN(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vBC',
            'vAliq',
            'vISSQN',
            'cMunFG',
            'cListServ',
            'vDeducao',
            'vOutro',
            'vDescIncond',
            'vDescCond',
            'vISSRet',
            'indISS',
            'cServico',
            'cMun',
            'cPais',
            'nProcesso',
            'indIncentivo'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "U01 <ISSQN> Item: $std->item -";
        // Adiciona o totalizador, somente se maior que ZERO
        if ($std->vBC > 0) {
            $this->stdISSQNTot->vBC += (float)$std->vBC;
            $this->stdISSQNTot->vISS += $std->vISSQN ?? 0.0;
            $this->stdISSQNTot->vISSRet += $std->vISSRet ?? 0.0;
            $this->stdISSQNTot->vDeducao += $std->vDeducao ?? 0.0;
            $this->stdISSQNTot->vOutro += $std->vOutro ?? 0.0;
            $this->stdISSQNTot->vDescIncond += $std->vDescIncond ?? 0.0;
            $this->stdISSQNTot->vDescCond += $std->vDescCond ?? 0.0;
        }
        //$this->aItensServ[] = $std->item;
        /**
        // totalizador
        if ($this->aProd[$std->item]->getElementsByTagName('indTot')->item(0)->nodeValue == 1) {
            // Captura o valor do item
            $vProd = (float) ($this->aProd[$std->item]->getElementsByTagName('vProd')->item(0)->nodeValue);

            // Remove o valor to totalizador de produtos e Adiciona o valor do item no totalizador de serviços
            $this->stdTot->vProd -= $vProd;
            $this->stdISSQNTot->vServ += $vProd;
        }*/

        $issqn = $this->dom->createElement("ISSQN");
        $this->dom->addChild(
            $issqn,
            "vBC",
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "$identificador Valor da Base de Cálculo do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "vAliq",
            $this->conditionalNumberFormatting($std->vAliq, 4),
            true,
            "$identificador Alíquota do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "vISSQN",
            $this->conditionalNumberFormatting($std->vISSQN),
            true,
            "$identificador Valor do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "cMunFG",
            $std->cMunFG,
            true,
            "$identificador Código do município de ocorrência do fato gerador do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "cListServ",
            $std->cListServ,
            true,
            "$identificador Item da Lista de Serviços"
        );
        $this->dom->addChild(
            $issqn,
            "vDeducao",
            $this->conditionalNumberFormatting($std->vDeducao),
            false,
            "$identificador Valor dedução para redução da Base de Cálculo"
        );
        $this->dom->addChild(
            $issqn,
            "vOutro",
            $this->conditionalNumberFormatting($std->vOutro),
            false,
            "$identificador Valor outras retenções"
        );
        $this->dom->addChild(
            $issqn,
            "vDescIncond",
            $this->conditionalNumberFormatting($std->vDescIncond),
            false,
            "$identificador Valor desconto incondicionado"
        );
        $this->dom->addChild(
            $issqn,
            "vDescCond",
            $this->conditionalNumberFormatting($std->vDescCond),
            false,
            "$identificador Valor desconto condicionado"
        );
        $this->dom->addChild(
            $issqn,
            "vISSRet",
            $this->conditionalNumberFormatting($std->vISSRet),
            false,
            "$identificador Valor retenção ISS"
        );
        $this->dom->addChild(
            $issqn,
            "indISS",
            $std->indISS,
            true,
            "$identificador Indicador da exigibilidade do ISS"
        );
        $this->dom->addChild(
            $issqn,
            "cServico",
            $std->cServico,
            false,
            "$identificador Código do serviço prestado dentro do município"
        );
        $this->dom->addChild(
            $issqn,
            "cMun",
            $std->cMun,
            false,
            "$identificador Código do Município de incidência do imposto"
        );
        $this->dom->addChild(
            $issqn,
            "cPais",
            $std->cPais,
            false,
            "$identificador Código do País onde o serviço foi prestado"
        );
        $this->dom->addChild(
            $issqn,
            "nProcesso",
            $std->nProcesso,
            false,
            "$identificador Número do processo judicial ou administrativo de suspensão da exigibilidade"
        );
        $this->dom->addChild(
            $issqn,
            "indIncentivo",
            $std->indIncentivo,
            true,
            "$identificador Indicador de incentivo Fiscal"
        );
        $this->aISSQN[$std->item] = $issqn;
        return $issqn;
    }
}
