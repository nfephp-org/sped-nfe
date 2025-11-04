<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Exception\RuntimeException;
use stdClass;
use DOMElement;
use NFePHP\Common\Strings;

/**
 * @property Dom $dom
 * @property int $mod
 * @property int $tpAmb
 * @property DOMElement $dest
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagDest
{
    /**
     * Identificação do Destinatário da NF-e E01 pai A01
     * tag NFe/infNFe/dest (opcional para modelo 65)
     */
    public function tagdest(stdClass $std): DOMElement
    {
        $possible = [
            'xNome',
            'indIEDest',
            'IE',
            'ISUF',
            'IM',
            'email',
            'CNPJ',
            'CPF',
            'idEstrangeiro'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'E01 dest -';
        $flagNome = true; //marca se xNome é ou não obrigatório
        $temIE = !empty($std->IE) && $std->IE !== 'ISENTO'; // Tem inscrição municipal
        if (!$temIE && $std->indIEDest == 1) {
            $std->indIEDest = 2;
        }
        if ($this->mod == '65') {
            $std->indIEDest = 9;
            if ($std->xNome == '') {
                $flagNome = false; //marca se xNome é ou não obrigatório
            }
        }
        $xNome = $std->xNome;
        $this->dest = $this->dom->createElement("dest");
        if ($this->tpAmb == '2' && !empty($xNome)) {
            $xNome = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
            //a exigência do CNPJ 99999999000191 não existe mais
        } elseif ($this->tpAmb == '2' && $this->mod == '65') {
            $xNome = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $this->dest,
                "CNPJ",
                $std->CNPJ,
                true,
                $identificador . "CNPJ do destinatário"
            );
        } elseif (!empty($std->CPF)) {
            $this->dom->addChild(
                $this->dest,
                "CPF",
                Strings::onlyNumbers($std->CPF),
                true,
                $identificador . "CPF do destinatário"
            );
        } elseif ($std->idEstrangeiro !== null) {
            $this->dom->addChild(
                $this->dest,
                "idEstrangeiro",
                $std->idEstrangeiro,
                true,
                $identificador . "Identificação do destinatário no caso de comprador estrangeiro",
                true
            );
            $std->indIEDest = '9';
        }
        $this->dom->addChild(
            $this->dest,
            "xNome",
            $xNome,
            $flagNome, //se mod 55 true ou mod 65 false
            $identificador . "Razão Social ou nome do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "indIEDest",
            Strings::onlyNumbers($std->indIEDest),
            true,
            $identificador . "Indicador da IE do Destinatário"
        );
        if ($temIE) {
            $this->dom->addChild(
                $this->dest,
                "IE",
                $std->IE,
                true,
                $identificador . "Inscrição Estadual do Destinatário"
            );
        }
        $this->dom->addChild(
            $this->dest,
            "ISUF",
            Strings::onlyNumbers($std->ISUF),
            false,
            $identificador . "Inscrição na SUFRAMA do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "IM",
            $std->IM,
            false,
            $identificador . "Inscrição Municipal do Tomador do Serviço do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "email",
            $std->email,
            false,
            $identificador . "Email do destinatário"
        );
        return $this->dest;
    }

    /**
     * Endereço do Destinatário da NF-e E05 pai E01
     * tag NFe/infNFe/dest/enderDest  (opcional para modelo 65)
     * Os dados do destinatário devem ser inseridos antes deste método
     */
    public function tagenderDest(stdClass $std): DOMElement
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

        $identificador = 'E05 enderDest -';
        if (!$this->dest) {
            throw new RuntimeException('A TAG dest deve ser criada antes do endereço do mesmo.');
        }
        $this->enderDest = $this->dom->createElement("enderDest");
        $this->dom->addChild(
            $this->enderDest,
            "xLgr",
            $std->xLgr,
            true,
            $identificador . "Logradouro do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "nro",
            $std->nro,
            true,
            $identificador . "Número do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xCpl",
            $std->xCpl,
            false,
            $identificador . "Complemento do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xBairro",
            $std->xBairro,
            true,
            $identificador . "Bairro do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "cMun",
            $std->cMun,
            true,
            $identificador . "Código do município do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xMun",
            $std->xMun,
            true,
            $identificador . "Nome do município do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "UF",
            $std->UF,
            true,
            $identificador . "Sigla da UF do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "CEP",
            $std->CEP,
            false,
            $identificador . "Código do CEP do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "cPais",
            $std->cPais,
            false,
            $identificador . "Código do País do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xPais",
            $std->xPais,
            false,
            $identificador . "Nome do País do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "fone",
            $std->fone,
            false,
            $identificador . "Telefone do Endereço do Destinatário"
        );
        if (!empty($this->dest)) {
            $node = $this->dest->getElementsByTagName("indIEDest")->item(0);
            if (!isset($node)) {
                $node = $this->dest->getElementsByTagName("IE")->item(0);
            }
            $this->dest->insertBefore($this->enderDest, $node);
        }
        return $this->enderDest;
    }
}
