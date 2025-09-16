<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;

/**
 * @property Dom $dom
 * @property DOMElement $retirada
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagRetirada
{
    /**
     * Identificação do Local de retirada F01 pai A01
     * tag NFe/infNFe/retirada (opcional)
     * NOTA: ajustado para NT 2018.005
     */
    public function tagretirada(stdClass $std): DOMElement
    {
        $possible = [
            'xLgr',
            'nro',
            'xCpl',
            'xBairro',
            'cMun',
            'xMun',
            'UF',
            'CNPJ',
            'CPF',
            'xNome',
            'CEP',
            'cPais',
            'xPais',
            'fone',
            'email',
            'IE'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'F01 <retirada> - ';
        $this->retirada = $this->dom->createElement("retirada");
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $this->retirada,
                "CNPJ",
                $std->CNPJ,
                false,
                $identificador . "CNPJ do Cliente da Retirada"
            );
        } elseif (!empty($std->CPF)) {
            $this->dom->addChild(
                $this->retirada,
                "CPF",
                $std->CPF,
                false,
                $identificador . "CPF do Cliente da Retirada"
            );
        }
        $this->dom->addChild(
            $this->retirada,
            "xNome",
            $std->xNome,
            false,
            $identificador . "Nome do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xLgr",
            $std->xLgr,
            true,
            $identificador . "Logradouro do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "nro",
            $std->nro,
            true,
            $identificador . "Número do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xCpl",
            $std->xCpl,
            false,
            $identificador . "Complemento do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xBairro",
            $std->xBairro,
            true,
            $identificador . "Bairro do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "cMun",
            $std->cMun,
            true,
            $identificador . "Código do município do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xMun",
            $std->xMun,
            true,
            $identificador . "Nome do município do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "UF",
            $std->UF,
            true,
            $identificador . "Sigla da UF do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "CEP",
            $std->CEP,
            false,
            $identificador . "CEP do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "cPais",
            $std->cPais,
            false,
            $identificador . "Codigo do Pais do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xPais",
            $std->xPais,
            false,
            $identificador . "Pais do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "fone",
            $std->fone,
            false,
            $identificador . "Fone do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "email",
            $std->email,
            false,
            $identificador . "Email do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "IE",
            $std->IE,
            false,
            $identificador . "IE do Cliente da Retirada"
        );
        return $this->retirada;
    }
}
