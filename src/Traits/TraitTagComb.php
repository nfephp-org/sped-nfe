<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use DOMException;
use NFePHP\Common\DOMImproved as Dom;

/**
 * @property Dom $dom
 * @property array $aComb
 * @property array $aEncerrante
 * @property array $aOrigComb
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagComb
{
    /**
     * Detalhamento de combustiveis L101 pai I90
     * tag NFe/infNFe/det[]/prod/comb (opcional)
     * LA|cProdANP|pMixGN|CODIF|qTemp|UFCons|
     * NOTA: Ajustado para NT2016_002_v1.30
     * LA|cProdANP|descANP|pGLP|pGNn|pGNi|vPart|CODIF|qTemp|UFCons|
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagcomb(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'cProdANP',
            'descANP',
            'pGLP',
            'pGNn',
            'pGNi',
            'vPart',
            'CODIF',
            'qTemp',
            'UFCons',
            'qBCProd',
            'vAliqProd',
            'vCIDE',
            'pBio'
        ];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = "L101 <comb> Item: $std->item -";
        $comb = $this->dom->createElement("comb");
        $this->dom->addChild(
            $comb,
            "cProdANP",
            $std->cProdANP,
            true,
            "$identificador Código de produto da ANP"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "descANP",
            $std->descANP,
            true,
            "$identificador Utilizar a descrição de produtos do "
            . "Sistema de Informações de Movimentação de Produtos - "
            . "SIMP (http://www.anp.gov.br/simp/"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "pGLP",
            $this->conditionalNumberFormatting($std->pGLP, 4),
            false,
            "$identificador Percentual do GLP derivado do "
            . "petróleo no produto GLP (cProdANP=210203001) 1v4"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "pGNn",
            $this->conditionalNumberFormatting($std->pGNn, 4),
            false,
            "$identificador Percentual de Gás Natural Nacional"
            . " – GLGNn para o produto GLP (cProdANP=210203001) 1v4"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "pGNi",
            $this->conditionalNumberFormatting($std->pGNi, 4),
            false,
            "$identificador Percentual de Gás Natural Importado"
            . " – GLGNi para o produto GLP (cProdANP=210203001) 1v4"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "vPart",
            $this->conditionalNumberFormatting($std->vPart),
            false,
            "$identificador Valor de partida (cProdANP=210203001) "
        );
        $this->dom->addChild(
            $comb,
            "CODIF",
            $std->CODIF,
            false,
            "$identificador Código de autorização / registro do CODIF"
        );
        $this->dom->addChild(
            $comb,
            "qTemp",
            $this->conditionalNumberFormatting($std->qTemp, 4),
            false,
            "$identificador Quantidade de combustível faturada à temperatura ambiente."
        );
        $this->dom->addChild(
            $comb,
            "UFCons",
            $std->UFCons,
            true,
            "$identificador  Sigla da UF de consumo"
        );
        if ($std->qBCProd != "") {
            $tagCIDE = $this->dom->createElement("CIDE");
            $this->dom->addChild(
                $tagCIDE,
                "qBCProd",
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                true,
                "$identificador BC da CIDE"
            );
            $this->dom->addChild(
                $tagCIDE,
                "vAliqProd",
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                true,
                "$identificador Valor da alíquota da CIDE"
            );
            $this->dom->addChild(
                $tagCIDE,
                "vCIDE",
                $this->conditionalNumberFormatting($std->vCIDE),
                true,
                "$identificador Valor da CIDE"
            );
            $this->dom->appChild($comb, $tagCIDE);
        }
        $this->dom->addChild(
            $comb,
            "pBio",
            $this->conditionalNumberFormatting($std->pBio, 4),
            false,
            "$identificador Percentual do índice de mistura do Biodiesel (B100) no Óleo Diesel B "
            . "instituído pelo órgão regulamentador"
        );
        $this->aComb[$std->item] = $comb;
        return $comb;
    }

    /**
     * informações relacionadas com as operações de combustíveis, subgrupo de
     * encerrante que permite o controle sobre as operações de venda de combustíveis
     * LA11 pai LA01
     * tag NFe/infNFe/det[]/prod/comb/encerrante (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagencerrante(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nBico',
            'nBomba',
            'nTanque',
            'vEncIni',
            'vEncFin'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "LA11 <encerrante> Item: $std->item -";
        $encerrante = $this->dom->createElement("encerrante");
        $this->dom->addChild(
            $encerrante,
            "nBico",
            $std->nBico,
            true,
            "$identificador Número de identificação do bico utilizado no abastecimento"
        );
        $this->dom->addChild(
            $encerrante,
            "nBomba",
            $std->nBomba,
            false,
            "$identificador Número de identificação da bomba ao qual o bico está interligado"
        );
        $this->dom->addChild(
            $encerrante,
            "nTanque",
            $std->nTanque,
            true,
            "$identificador Número de identificação do tanque ao qual o bico está interligado"
        );
        $this->dom->addChild(
            $encerrante,
            "vEncIni",
            $this->conditionalNumberFormatting($std->vEncIni, 3),
            true,
            "$identificador Valor do Encerrante no início do abastecimento"
        );
        $this->dom->addChild(
            $encerrante,
            "vEncFin",
            $this->conditionalNumberFormatting($std->vEncFin, 3),
            true,
            "$identificador Valor do Encerrante no final do abastecimento"
        );
        $this->aEncerrante[$std->item] = $encerrante;
        return $encerrante;
    }

    /**
     * Grupo indicador da origem do combustível
     * LA18 pai LA01
     * tag NFe/infNFe/det[]/prod/comb/origComb[]
     * NOTA: Adicionado para NT2023_0001_v1.10
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagorigComb(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'indImport',
            'cUFOrig',
            'pOrig'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "LA18 <origComb> Item: $std->item -";
        $origComb = $this->dom->createElement("origComb");
        $this->dom->addChild(
            $origComb,
            "indImport",
            $std->indImport,
            true,
            "$identificador Indicador de importação"
        );
        $this->dom->addChild(
            $origComb,
            "cUFOrig",
            $std->cUFOrig,
            true,
            "$identificador Código da UF"
        );
        $this->dom->addChild(
            $origComb,
            "pOrig",
            $this->conditionalNumberFormatting($std->pOrig, 4),
            true,
            "$identificador Percentual originário para a UF"
        );
        $this->aOrigComb[$std->item][] = $origComb;
        return $origComb;
    }
}
