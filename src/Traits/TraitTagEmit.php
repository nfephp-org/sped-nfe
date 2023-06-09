<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use NFePHP\Common\Strings;

trait TraitTagEmit
{
    /**
     * Identificação do emitente da NF-e C01 pai A01
     * tag NFe/infNFe/emit
     */
    public function tagemit(stdClass $std): DOMElement
    {
        $possible = [
            'xNome',
            'xFant',
            'IE',
            'IEST',
            'IM',
            'CNAE',
            'CRT',
            'CNPJ',
            'CPF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'C01 <emit> - ';
        $this->emit = $this->dom->createElement("emit");
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $this->emit,
                "CNPJ",
                Strings::onlyNumbers($std->CNPJ),
                false,
                $identificador . "CNPJ do emitente"
            );
        } elseif (!empty($std->CPF)) {
            $this->dom->addChild(
                $this->emit,
                "CPF",
                Strings::onlyNumbers($std->CPF),
                false,
                $identificador . "CPF do remetente"
            );
        }
        $this->dom->addChild(
            $this->emit,
            "xNome",
            substr(trim($std->xNome), 0, 60),
            true,
            $identificador . "Razão Social ou Nome do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "xFant",
            substr(trim($std->xFant), 0, 60),
            false,
            $identificador . "Nome fantasia do emitente"
        );
        if ($std->IE !== 'ISENTO') {
            $std->IE = Strings::onlyNumbers($std->IE);
        }
        $this->dom->addChild(
            $this->emit,
            "IE",
            $std->IE,
            true,
            $identificador . "Inscrição Estadual do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IEST",
            Strings::onlyNumbers($std->IEST),
            false,
            $identificador . "IE do Substituto Tributário do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IM",
            Strings::onlyNumbers($std->IM),
            false,
            $identificador . "Inscrição Municipal do Prestador de Serviço do emitente"
        );
        if (!empty($std->IM) && !empty($std->CNAE)) {
            $this->dom->addChild(
                $this->emit,
                "CNAE",
                Strings::onlyNumbers($std->CNAE),
                false,
                $identificador . "CNAE fiscal do emitente"
            );
        }
        $this->dom->addChild(
            $this->emit,
            "CRT",
            $std->CRT,
            true,
            $identificador . "Código de Regime Tributário do emitente"
        );
        return $this->emit;
    }

    /**
     * Endereço do emitente C05 pai C01
     * tag NFe/infNFe/emit/endEmit
     */
    public function tagenderEmit(stdClass $std): DOMElement
    {
        $possible = [
            'xLgr',
            'nro',
            'xCpl',
            'xBairro',
            'cMun',
            'xMun',
            'UF',
            'CEP',
            'cPais',
            'xPais',
            'fone'
        ];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'C05 <enderEmit> - ';
        $this->enderEmit = $this->dom->createElement("enderEmit");
        $this->dom->addChild(
            $this->enderEmit,
            "xLgr",
            substr(trim($std->xLgr), 0, 60),
            true,
            $identificador . "Logradouro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "nro",
            substr(trim($std->nro), 0, 60),
            true,
            $identificador . "Número do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xCpl",
            substr(trim($std->xCpl), 0, 60),
            false,
            $identificador . "Complemento do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xBairro",
            substr(trim($std->xBairro), 0, 60),
            true,
            $identificador . "Bairro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cMun",
            Strings::onlyNumbers($std->cMun),
            true,
            $identificador . "Código do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xMun",
            substr(trim($std->xMun), 0, 60),
            true,
            $identificador . "Nome do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "UF",
            strtoupper(trim($std->UF)),
            true,
            $identificador . "Sigla da UF do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "CEP",
            Strings::onlyNumbers($std->CEP),
            true,
            $identificador . "Código do CEP do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cPais",
            Strings::onlyNumbers($std->cPais),
            false,
            $identificador . "Código do País do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xPais",
            substr(trim($std->xPais), 0, 60),
            false,
            $identificador . "Nome do País do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "fone",
            trim($std->fone),
            false,
            $identificador . "Telefone do Endereço do emitente"
        );
        $node = $this->emit->getElementsByTagName("IE")->item(0);
        $this->emit->insertBefore($this->enderEmit, $node);
        return $this->enderEmit;
    }
}
