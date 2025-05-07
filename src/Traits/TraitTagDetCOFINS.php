<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property stdClass $stdTot
 * @property array $aCOFINS
 * @property array $aCOFINSST
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagDetCOFINS
{
    /**
     * Grupo COFINS S01 pai M01
     * tag det[item]/imposto/COFINS (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagCOFINS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CST',
            'vBC',
            'pCOFINS',
            'vCOFINS',
            'qBCProd',
            'vAliqProd'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "S01 <COFINS> Item: $std->item -";
        switch ($std->CST) {
            case '01':
            case '02':
                $confinsItem = $this->buildCOFINSAliq($std);
                //totalizador
                $this->stdTot->vCOFINS += (float)$std->vCOFINS;
                break;
            case '03':
                $confinsItem = $this->dom->createElement('COFINSQtde');
                $this->dom->addChild(
                    $confinsItem,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Código de Situação Tributária da COFINS (CST)"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'qBCProd',
                    $this->conditionalNumberFormatting($std->qBCProd, 4),
                    true,
                    "$identificador  Quantidade Vendida (qBCProd)"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'vAliqProd',
                    $this->conditionalNumberFormatting($std->vAliqProd, 4),
                    true,
                    "$identificador  Alíquota do COFINS (em reais) (vAliqProd)"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'vCOFINS',
                    $this->conditionalNumberFormatting($std->vCOFINS),
                    true,
                    "$identificador Valor do COFINS (vCOFINS)"
                );
                //totalizador
                $this->stdTot->vCOFINS += (float)$std->vCOFINS;
                break;
            case '04':
            case '05':
            case '06':
            case '07':
            case '08':
            case '09':
                $confinsItem = $this->buildCOFINSNT($std);
                break;
            case '49':
            case '50':
            case '51':
            case '52':
            case '53':
            case '54':
            case '55':
            case '56':
            case '60':
            case '61':
            case '62':
            case '63':
            case '64':
            case '65':
            case '66':
            case '67':
            case '70':
            case '71':
            case '72':
            case '73':
            case '74':
            case '75':
            case '98':
            case '99':
                $confinsItem = $this->buildCOFINSoutr($std);
                //totalizador
                $this->stdTot->vCOFINS += (float)$std->vCOFINS;
                break;
        }
        $confins = $this->dom->createElement('COFINS');
        if (isset($confinsItem)) {
            $confins->appendChild($confinsItem);
        }
        $this->aCOFINS[$std->item] = $confins;
        return $confins;
    }

    /**
     * Grupo COFINS Substituição Tributária T01 pai M01
     * tag NFe/infNFe/det[]/imposto/COFINSST (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagCOFINSST(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vCOFINS',
            'vBC',
            'pCOFINS',
            'qBCProd',
            'vAliqProd',
            'indSomaCOFINSST'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "T01 <COFINS> Item: $std->item -";
        if ($std->indSomaCOFINSST == 1) {
            $this->stdTot->vCOFINSST += $std->vCOFINS;
        }
        $cofinsst = $this->dom->createElement("COFINSST");
        if (!isset($std->qBCProd)) {
            $this->dom->addChild(
                $cofinsst,
                "vBC",
                $this->conditionalNumberFormatting($std->vBC),
                true,
                "$identificador Valor da Base de Cálculo da COFINS (vBC)"
            );
            $this->dom->addChild(
                $cofinsst,
                "pCOFINS",
                $this->conditionalNumberFormatting($std->pCOFINS, 4),
                true,
                "$identificador Alíquota da COFINS (em percentual) (pCOFINS)"
            );
        } else {
            $this->dom->addChild(
                $cofinsst,
                "qBCProd",
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                true,
                "$identificador Quantidade Vendida (qBCProd)"
            );
            $this->dom->addChild(
                $cofinsst,
                "vAliqProd",
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                true,
                "$identificador Alíquota da COFINS (em reais) (vAliqProd)"
            );
        }
        $this->dom->addChild(
            $cofinsst,
            "vCOFINS",
            $this->conditionalNumberFormatting($std->vCOFINS),
            true,
            "$identificador Valor da COFINS (vCOFINS)"
        );
        $this->dom->addChild(
            $cofinsst,
            "indSomaCOFINSST",
            $std->indSomaCOFINSST,
            false,
            "$identificador Valor da COFINS (vCOFINS)"
        );
        $this->aCOFINSST[$std->item] = $cofinsst;
        return $cofinsst;
    }

    /**
     * Grupo COFINS tributado pela alíquota S02 pai S01
     * tag det/imposto/COFINS/COFINSAliq (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    protected function buildCOFINSAliq(stdClass $std): DOMElement
    {
        $identificador = "S02 <COFINSAliq> Item: $std->item -";
        $confinsAliq = $this->dom->createElement('COFINSAliq');
        $this->dom->addChild(
            $confinsAliq,
            'CST',
            $std->CST,
            true,
            "$identificador Código de Situação Tributária da COFINS (CST)"
        );
        $this->dom->addChild(
            $confinsAliq,
            'vBC',
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "$identificador Valor da Base de Cálculo da COFINS (vBC)"
        );
        $this->dom->addChild(
            $confinsAliq,
            'pCOFINS',
            $this->conditionalNumberFormatting($std->pCOFINS, 4),
            true,
            "$identificador Alíquota da COFINS (em percentual) (pCOFINS)"
        );
        $this->dom->addChild(
            $confinsAliq,
            'vCOFINS',
            $this->conditionalNumberFormatting($std->vCOFINS),
            true,
            "$identificador Valor da COFINS (vCOFINS)"
        );
        return $confinsAliq;
    }

    /**
     * Grupo COFINS não tributado S04 pai S01
     * tag NFe/infNFe/det[]/imposto/COFINS/COFINSNT (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    protected function buildCOFINSNT(stdClass $std): DOMElement
    {
        $identificador = "S04 <COFINSNT> Item: $std->item -";
        $confinsnt = $this->dom->createElement('COFINSNT');
        $this->dom->addChild(
            $confinsnt,
            "CST",
            $std->CST,
            true,
            "$identificador Código de Situação Tributária da COFINS (CST)"
        );
        return $confinsnt;
    }

    /**
     * Grupo COFINS Outras Operações S05 pai S01
     * tag NFe/infNFe/det[]/imposto/COFINS/COFINSoutr (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    protected function buildCOFINSoutr(stdClass $std): DOMElement
    {
        $identificador = "S05 <COFINSoutr> Item: $std->item -";
        $confinsoutr = $this->dom->createElement('COFINSOutr');
        $this->dom->addChild(
            $confinsoutr,
            "CST",
            $std->CST,
            true,
            "$identificador Código de Situação Tributária da COFINS (CST)"
        );
        if (!isset($std->qBCProd)) {
            $this->dom->addChild(
                $confinsoutr,
                "vBC",
                $this->conditionalNumberFormatting($std->vBC),
                false,
                "$identificador Valor da Base de Cálculo da COFINS (vBC)"
            );
            $this->dom->addChild(
                $confinsoutr,
                "pCOFINS",
                $this->conditionalNumberFormatting($std->pCOFINS, 4),
                false,
                "$identificador Alíquota da COFINS (em percentual) (pCOFINS)"
            );
        } else {
            $this->dom->addChild(
                $confinsoutr,
                "qBCProd",
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                false,
                "$identificador Quantidade Vendida (qBCProd)"
            );
            $this->dom->addChild(
                $confinsoutr,
                "vAliqProd",
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                false,
                "$identificador Alíquota da COFINS (em reais) (vAliqProd)"
            );
        }
        $this->dom->addChild(
            $confinsoutr,
            "vCOFINS",
            $this->conditionalNumberFormatting($std->vCOFINS),
            true,
            "$identificador Valor da COFINS (vCOFINS)"
        );
        return $confinsoutr;
    }
}
