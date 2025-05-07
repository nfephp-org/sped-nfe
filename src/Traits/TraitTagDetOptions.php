<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property Dom $dom
 * @property array $aRECOPI
 * @property array $aRastro
 * @property array $aVeicProd
 * @property array $aMed
 * @property array $aArma
 * @property array $aComb
 * @property array $aDFeReferenciado
 * @property array $errors
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagDetOptions
{
    /**
     * tag NFe/infNFe/det[item]/prod/nRECOPI
     * @param stdClass $std
     * @return DOMElement|null
     * @throws DOMException
     */
    public function tagRECOPI(stdClass $std): ?DOMElement
    {
        $possible = ['item', 'nRECOPI'];
        $std = $this->equilizeParameters($std, $possible);
        if (empty($std->nRECOPI) || !is_numeric($std->nRECOPI)) {
            $this->errors[] = "LB01 <nRECOPI> Item: $std->item - Erro ao montar o campo nRECOPI";
            return null;
        }
        $recopi = $this->dom->createElement("nRECOPI", $std->nRECOPI);
        $this->aRECOPI[$std->item] = $recopi;
        return $recopi;
    }

    /**
     * Rastreabilidade do produto podem ser até 500 por item TAG I80 pai I01
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]/prod/rastro
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagRastro(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nLote',
            'qLote',
            'dFab',
            'dVal',
            'cAgreg'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "I80 <rastro> Item: $std->item -";
        $rastro = $this->dom->createElement("rastro");
        $this->dom->addChild(
            $rastro,
            "nLote",
            $std->nLote,
            true,
            "$identificador Número do lote"
        );
        $this->dom->addChild(
            $rastro,
            "qLote",
            $this->conditionalNumberFormatting($std->qLote, 3),
            true,
            "$identificador Quantidade do lote"
        );
        $this->dom->addChild(
            $rastro,
            "dFab",
            $std->dFab,
            true,
            $identificador . "Data de fabricação"
        );
        $this->dom->addChild(
            $rastro,
            "dVal",
            $std->dVal,
            true,
            $identificador . "Data da validade"
        );
        $this->dom->addChild(
            $rastro,
            "cAgreg",
            $std->cAgreg,
            false,
            $identificador . "Código de Agregação"
        );
        $this->aRastro[$std->item][] = $rastro;
        return $rastro;
    }

    /**
     * Detalhamento de Veículos novos J01 pai I90
     * tag NFe/infNFe/det[]/prod/veicProd (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagveicProd(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'tpOp',
            'chassi',
            'cCor',
            'xCor',
            'pot',
            'cilin',
            'pesoL',
            'pesoB',
            'nSerie',
            'tpComb',
            'nMotor',
            'CMT',
            'dist',
            'anoMod',
            'anoFab',
            'tpPint',
            'tpVeic',
            'espVeic',
            'VIN',
            'condVeic',
            'cMod',
            'cCorDENATRAN',
            'lota',
            'tpRest'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "J01 <veicProd> Item: $std->item -";
        $veicProd = $this->dom->createElement("veicProd");
        $this->dom->addChild(
            $veicProd,
            "tpOp",
            $std->tpOp,
            true,
            "$identificador Tipo da operação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "chassi",
            $std->chassi,
            true,
            "$identificador Chassi do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cCor",
            $std->cCor,
            true,
            "$identificador Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "xCor",
            $std->xCor,
            true,
            "$identificador Descrição da Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pot",
            $std->pot,
            true,
            "$identificador Potência Motor (CV) do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cilin",
            $std->cilin,
            true,
            "$identificador Cilindradas do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pesoL",
            $std->pesoL,
            true,
            "$identificador Peso Líquido do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pesoB",
            $std->pesoB,
            true,
            "$identificador Peso Bruto do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "nSerie",
            $std->nSerie,
            true,
            "$identificador Serial (série) do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpComb",
            $std->tpComb,
            true,
            "$identificador Tipo de combustível do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "nMotor",
            $std->nMotor,
            true,
            "$identificador Número de Motor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "CMT",
            $this->conditionalNumberFormatting($std->CMT, 4),
            true,
            "$identificador Capacidade Máxima de Tração do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "dist",
            $std->dist,
            true,
            "$identificador Distância entre eixos do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "anoMod",
            $std->anoMod,
            true,
            "$identificador Ano Modelo de Fabricação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "anoFab",
            $std->anoFab,
            true,
            "$identificador Ano de Fabricação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpPint",
            $std->tpPint,
            true,
            "$identificador Tipo de Pintura do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpVeic",
            $std->tpVeic,
            true,
            "$identificador Tipo de Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "espVeic",
            $std->espVeic,
            true,
            "$identificador Espécie de Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "VIN",
            $std->VIN,
            true,
            "$identificador Condição do VIN do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "condVeic",
            $std->condVeic,
            true,
            "$identificador Condição do Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cMod",
            $std->cMod,
            true,
            "$identificador Código Marca Modelo do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cCorDENATRAN",
            $std->cCorDENATRAN,
            true,
            "$identificador Código da Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "lota",
            $std->lota,
            true,
            "$identificador Capacidade máxima de lotação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpRest",
            $std->tpRest,
            true,
            "$identificador Restrição do veículo"
        );
        $this->aVeicProd[$std->item] = $veicProd;
        return $veicProd;
    }

    /**
     * Detalhamento de medicamentos K01 pai I90
     * NOTA: Ajustado para NT2018.005
     * tag NFe/infNFe/det[]/prod/med (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagmed(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vPMC',
            'cProdANVISA',
            'xMotivoIsencao'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "K01 <med> Item: $std->item - ";
        $med = $this->dom->createElement("med");
        $this->dom->addChild(
            $med,
            "cProdANVISA",
            $std->cProdANVISA,
            false,
            "$identificador Numero ANVISA"
        );
        $this->dom->addChild(
            $med,
            "xMotivoIsencao",
            $std->xMotivoIsencao,
            false,
            "$identificador Motivo da isenção da ANVISA"
        );
        $this->dom->addChild(
            $med,
            "vPMC",
            $this->conditionalNumberFormatting($std->vPMC),
            true,
            "$identificador Preço máximo consumidor"
        );
        $this->aMed[$std->item] = $med;
        return $med;
    }

    /**
     * Detalhamento de armas L01 pai I90
     * tag NFe/infNFe/det[]/prod/arma (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagarma(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'tpArma',
            'nSerie',
            'nCano',
            'descr'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "L01 <arma> Item: $std->item -";
        $arma = $this->dom->createElement("arma");
        $this->dom->addChild(
            $arma,
            "tpArma",
            $std->tpArma,
            true,
            "$identificador Indicador do tipo de arma de fogo"
        );
        $this->dom->addChild(
            $arma,
            "nSerie",
            $std->nSerie,
            true,
            "$identificador Número de série da arma"
        );
        $this->dom->addChild(
            $arma,
            "nCano",
            $std->nCano,
            true,
            "$identificador Número de série do cano"
        );
        $this->dom->addChild(
            $arma,
            "descr",
            $std->descr,
            true,
            "$identificador Descrição completa da arma, compreendendo: calibre, marca, capacidade, "
            . "tipo de funcionamento, comprimento e demais elementos que "
            . "permitam a sua perfeita identificação."
        );
        $this->aArma[$std->item][] = $arma;
        return $arma;
    }

    /**
     * Referenciamento de item de outros DFe
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagDFeReferenciado(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'chaveAcesso',
            'nItem',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "VC01 <DFeReferenciado> Item: $std->item -";
        $dfe = $this->dom->createElement("DFeReferenciado");
        $this->dom->addChild(
            $dfe,
            "chaveAcesso",
            $std->chaveAcesso,
            true,
            "$identificador Chave de Acesso do DFe referenciado"
        );
        $this->dom->addChild(
            $dfe,
            "nItem",
            $std->nItem,
            false,
            "$identificador Número do item do documento referenciado. Corresponde ao atributo nItem "
                . "do elemento det do documento original."
        );
        $this->aDFeReferenciado[$std->item] = $dfe;
        return $dfe;
    }
}
