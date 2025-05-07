<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property  Dom $dom
 * @property stdClass $stdTot
 * @property array $aPIS
 * @property array $aPISST
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagDetPIS
{
    /**
     * Grupo PIS Q01 pai M01
     * tag NFe/infNFe/det[]/imposto/PIS
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagPIS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CST',
            'vBC',
            'pPIS',
            'vPIS',
            'qBCProd',
            'vAliqProd'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "Q01 <PIS> Item: $std->item -";
        switch ($std->CST) {
            case '01':
            case '02':
                $pisItem = $this->dom->createElement('PISAliq');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Código de Situação Tributária do PIS (CST)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador Valor da Base de Cálculo do PIS (vBC)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'pPIS',
                    $this->conditionalNumberFormatting($std->pPIS, 4),
                    true,
                    "$identificador Alíquota do PIS (em percentual) (pPIS)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $this->conditionalNumberFormatting($std->vPIS),
                    true,
                    "$identificador Valor do PIS (vPIS)"
                );
                //totalizador
                $this->stdTot->vPIS += (float) !empty($std->vPIS) ? $std->vPIS : 0;
                break;
            case '03':
                $pisItem = $this->dom->createElement('PISQtde');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Código de Situação Tributária do PIS (CST)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'qBCProd',
                    $this->conditionalNumberFormatting($std->qBCProd, 4),
                    true,
                    "$identificador Quantidade Vendida (qBCProd)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vAliqProd',
                    $this->conditionalNumberFormatting($std->vAliqProd, 4),
                    true,
                    "$identificador Alíquota do PIS (em reais) (vAliqProd)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $this->conditionalNumberFormatting($std->vPIS),
                    true,
                    "$identificador Valor do PIS (vPIS)"
                );
                //totalizador
                $this->stdTot->vPIS += (float) !empty($std->vPIS) ? $std->vPIS : 0;
                break;
            case '04':
            case '05':
            case '06':
            case '07':
            case '08':
            case '09':
                $pisItem = $this->dom->createElement('PISNT');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Código de Situação Tributária do PIS (CST)"
                );
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
                $pisItem = $this->dom->createElement('PISOutr');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Código de Situação Tributária do PIS (CST)"
                );
                if (!isset($std->qBCProd)) {
                    $this->dom->addChild(
                        $pisItem,
                        'vBC',
                        $this->conditionalNumberFormatting($std->vBC),
                        $std->vBC !== null,
                        "$identificador Valor da Base de Cálculo do PIS (vBC)"
                    );
                    $this->dom->addChild(
                        $pisItem,
                        'pPIS',
                        $this->conditionalNumberFormatting($std->pPIS, 4),
                        $std->pPIS !== null,
                        "$identificador Alíquota do PIS (em percentual) (pPIS)"
                    );
                } else {
                    $this->dom->addChild(
                        $pisItem,
                        'qBCProd',
                        $this->conditionalNumberFormatting($std->qBCProd, 4),
                        false,
                        "$identificador Quantidade Vendida (qBCProd)"
                    );
                    $this->dom->addChild(
                        $pisItem,
                        'vAliqProd',
                        $this->conditionalNumberFormatting($std->vAliqProd, 4),
                        false,
                        " $identificador Alíquota do PIS (em reais) (vAliqProd)"
                    );
                }
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $this->conditionalNumberFormatting($std->vPIS),
                    false,
                    "$identificador Valor do PIS (vPIS)"
                );
                //totalizador
                $this->stdTot->vPIS += (float) !empty($std->vPIS) ? $std->vPIS : 0;
                break;
        }
        $pis = $this->dom->createElement('PIS');
        if (isset($pisItem)) {
            $pis->appendChild($pisItem);
        }
        $this->aPIS[$std->item] = $pis;
        return $pis;
    }

    /**
     * Grupo PIS Substituição Tributária R01 pai M01
     * tag NFe/infNFe/det[]/imposto/PISST (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagPISST(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vPIS',
            'vBC',
            'pPIS',
            'qBCProd',
            'vAliqProd',
            'indSomaPISST',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "R01 <PISST> Item: $std->item -";
        if ($std->indSomaPISST == 1) {
            $this->stdTot->vPISST += $std->vPIS;
        }
        $pisst = $this->dom->createElement('PISST');
        if (!isset($std->qBCProd)) {
            $this->dom->addChild(
                $pisst,
                'vBC',
                $this->conditionalNumberFormatting($std->vBC),
                true,
                "$identificador Valor da Base de Cálculo do PIS (vBC)"
            );
            $this->dom->addChild(
                $pisst,
                'pPIS',
                $this->conditionalNumberFormatting($std->pPIS, 4),
                true,
                "$identificador  Alíquota do PIS (em percentual) (pPIS)"
            );
        } else {
            $this->dom->addChild(
                $pisst,
                'qBCProd',
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                true,
                "$identificador  Quantidade Vendida (qBCProd)"
            );
            $this->dom->addChild(
                $pisst,
                'vAliqProd',
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                true,
                "$identificador  Alíquota do PIS (em reais) (vAliqProd)"
            );
        }
        $this->dom->addChild(
            $pisst,
            'vPIS',
            $this->conditionalNumberFormatting($std->vPIS),
            true,
            "$identificador  Valor do PIS (vPIS)"
        );
        $this->dom->addChild(
            $pisst,
            'indSomaPISST',
            $std->indSomaPISST ?? null,
            false,
            "$identificador  Indica se o valor do PISST compõe o valor total da NF-e (indSomaPISST)"
        );
        $this->aPISST[$std->item] = $pisst;
        return $pisst;
    }
}
