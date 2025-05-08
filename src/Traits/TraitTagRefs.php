<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use DOMException;
use NFePHP\Common\DOMImproved as Dom;

/**
 * @property Dom $dom
 * @property array $aNFref
 * @property array $aCTeref
 * @property array $aECFref
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagRefs
{
    /**
     * Chave de acesso da NF-e referenciada BA02 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFe
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagrefNFe(stdClass $std): DOMElement
    {
        $possible = ['refNFe', 'refNFeSig'];
        $std = $this->equilizeParameters($std, $possible);
        $nfref = $this->dom->createElement("NFref");
        if (!empty($std->refNFe)) {
            $refNFe = $this->dom->createElement("refNFe", $std->refNFe);
            $this->dom->appChild($nfref, $refNFe);
        } elseif (!empty($std->refNFeSig)) {
            $refNFe = $this->dom->createElement("refNFeSig", $std->refNFeSig);
            $this->dom->appChild($nfref, $refNFe);
        }
        $this->aNFref[] = $nfref;
        return $nfref;
    }

    /**
     * Informação da NF modelo 1/1A referenciada BA03 pai BA01
     * tag NFe/infNFe/ide/NFref/NF DOMNode
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagrefNF(stdClass $std): DOMElement
    {
        $possible = ['cUF', 'AAMM', 'CNPJ', 'mod', 'serie', 'nNF'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'BA03 <refNF> - ';
        $nfref = $this->dom->createElement("NFref");
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
        $this->dom->appChild($nfref, $refNF);
        $this->aNFref[] = $nfref;
        return $nfref;
    }

    /**
     * Informações da NF de produtor rural referenciada BA10 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFP
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = 'BA10 <refNFP> - ';
        $nfref = $this->dom->createElement("NFref");
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
        $this->dom->appChild($nfref, $refNFP);
        $this->aNFref[] = $nfref;
        return $nfref;
    }

    /**
     * Chave de acesso do CT-e referenciada BA19 pai BA01
     * tag NFe/infNFe/ide/NFref/refCTe
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagrefCTe(stdClass $std): DOMElement
    {
        $possible = ['refCTe'];
        $std = $this->equilizeParameters($std, $possible);
        $nfref = $this->dom->createElement("NFref");
        $refCTe = $this->dom->createElement("refCTe", $std->refCTe);
        $this->dom->appChild($nfref, $refCTe);
        $this->aNFref[] = $nfref;
        return $nfref;
    }

    /**
     * Informações do Cupom Fiscal referenciado BA20 pai BA01
     * tag NFe/infNFe/ide/NFref/refECF
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagrefECF(stdClass $std): DOMElement
    {
        $possible = ['mod', 'nECF', 'nCOO'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'BA20 <refECF> - ';
        $nfref = $this->dom->createElement("NFref");
        $refECF = $this->dom->createElement("refECF");
        $this->dom->addChild(
            $refECF,
            "mod",
            $std->mod,
            true,
            "$identificador Modelo do Documento Fiscal (mod)"
        );
        $this->dom->addChild(
            $refECF,
            "nECF",
            str_pad($std->nECF, 3, '0', STR_PAD_LEFT),
            true,
            "$identificador Número de ordem sequencial do ECF (nECF)"
        );
        $this->dom->addChild(
            $refECF,
            "nCOO",
            str_pad($std->nCOO, 6, '0', STR_PAD_LEFT),
            true,
            "$identificador Número do Contador de Ordem de Operação (nCOO)"
        );
        $this->dom->appChild($nfref, $refECF);
        $this->aNFref[] = $nfref;
        return $nfref;
    }
}
