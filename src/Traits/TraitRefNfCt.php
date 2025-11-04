<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved;
use stdClass;
use DOMElement;

/**
 * @method equilizeParameters($std, $possible)
 * @method buildNFref()
 * @property DOMImproved $dom
 * @property array $aNFref
 */

trait TraitRefNfCt
{
    /**
     * Chave de acesso da NF-e referenciada BA02 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFe
     */
    public function tagrefNFe(stdClass $std): DOMElement
    {
        $possible = ['refNFe'];
        $std = $this->equilizeParameters($std, $possible);

        $num = $this->buildNFref();
        $refNFe = $this->dom->createElement("refNFe", $std->refNFe);
        $this->dom->appChild($this->aNFref[$num - 1], $refNFe);
        return $refNFe;
    }

    /**
     * Informação da NF modelo 1/1A referenciada BA03 pai BA01
     * tag NFe/infNFe/ide/NFref/NF DOMNode
     */
    public function tagrefNF(stdClass $std): DOMElement
    {
        $possible = ['cUF', 'AAMM', 'CNPJ', 'mod', 'serie', 'nNF'];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'BA03 refNF - ';
        $num = $this->buildNFref();
        $refNF = $this->dom->createElement("refNF");
        $this->dom->addChild(
            $refNF,
            "cUF",
            $std->cUF,
            true,
            $identificador . "Código da UF do emitente"
        );
        $this->dom->addChild(
            $refNF,
            "AAMM",
            $std->AAMM,
            true,
            $identificador . "Ano e Mês de emissão da NF-e"
        );
        $this->dom->addChild(
            $refNF,
            "CNPJ",
            $std->CNPJ,
            true,
            $identificador . "CNPJ do emitente"
        );
        $this->dom->addChild(
            $refNF,
            "mod",
            $std->mod,
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNF,
            "serie",
            $std->serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNF,
            "nNF",
            $std->nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->appChild($this->aNFref[$num - 1], $refNF);
        return $refNF;
    }

    /**
     * Informações da NF de produtor rural referenciada BA10 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFP
     */
    public function tagrefNFP(stdClass $std): DOMElement
    {
        $possible = [
            'cUF',
            'AAMM',
            'CNPJ',
            'CPF',
            'IE',
            'mod',
            'serie',
            'nNF'
        ];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'BA10 refNFP - ';
        $num = $this->buildNFref();
        $refNFP = $this->dom->createElement("refNFP");
        $this->dom->addChild(
            $refNFP,
            "cUF",
            $std->cUF,
            true,
            $identificador . "Código da UF do emitente"
        );
        $this->dom->addChild(
            $refNFP,
            "AAMM",
            $std->AAMM,
            true,
            $identificador . "AAMM da emissão da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "CNPJ",
            $std->CNPJ,
            false,
            $identificador . "Informar o CNPJ do emitente da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "CPF",
            $std->CPF,
            false,
            $identificador . "Informar o CPF do emitente da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "IE",
            $std->IE,
            true,
            $identificador . "Informar a IE do emitente da NF de Produtor ou o literal 'ISENTO'"
        );
        $this->dom->addChild(
            $refNFP,
            "mod",
            str_pad($std->mod, 2, '0', STR_PAD_LEFT),
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNFP,
            "serie",
            $std->serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNFP,
            "nNF",
            $std->nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->appChild($this->aNFref[$num - 1], $refNFP);
        return $refNFP;
    }

    /**
     * Chave de acesso do CT-e referenciada BA19 pai BA01
     * tag NFe/infNFe/ide/NFref/refCTe
     */
    public function tagrefCTe(stdClass $std): DOMElement
    {
        $possible = ['refCTe'];
        $std = $this->equilizeParameters($std, $possible);

        $num = $this->buildNFref();
        $refCTe = $this->dom->createElement("refCTe", $std->refCTe);
        $this->dom->appChild($this->aNFref[$num - 1], $refCTe);
        return $refCTe;
    }

    /**
     * Informações do Cupom Fiscal referenciado BA20 pai BA01
     * tag NFe/infNFe/ide/NFref/refECF
     */
    public function tagrefECF(stdClass $std): DOMElement
    {
        $possible = ['mod', 'nECF', 'nCOO'];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'BA20 refECF - ';
        $num = $this->buildNFref();
        $refECF = $this->dom->createElement("refECF");
        $this->dom->addChild(
            $refECF,
            "mod",
            $std->mod,
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refECF,
            "nECF",
            str_pad($std->nECF, 3, '0', STR_PAD_LEFT),
            true,
            $identificador . "Número de ordem sequencial do ECF"
        );
        $this->dom->addChild(
            $refECF,
            "nCOO",
            str_pad($std->nCOO, 6, '0', STR_PAD_LEFT),
            true,
            $identificador . "Número do Contador de Ordem de Operação - COO"
        );
        $this->dom->appChild($this->aNFref[$num - 1], $refECF);
        return $refECF;
    }
}
