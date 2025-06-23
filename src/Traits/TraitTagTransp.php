<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property Dom $dom
 * @property DOMElement $transp
 * @property DOMElement $transporta
 * @property DOMElement $retTransp
 * @property DOMElement $veicTransp
 * @property array $reboque
 * @property DOMElement $balsa
 * @property DOMElement $vagao
 * @property array $vol
 * @property array $lacre
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagTransp
{
    /**
     * Grupo Informações do Transporte X01 pai A01
     * tag NFe/infNFe/transp (obrigatório)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagtransp(stdClass $std): DOMElement
    {
        $possible = [
            'modFrete'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'X01 <transp> -';
        $this->transp = $this->dom->createElement("transp");
        $this->dom->addChild(
            $this->transp,
            "modFrete",
            $std->modFrete,
            true,
            "$identificador Modalidade do frete (modFrete)"
        );
        return $this->transp;
    }

    /**
     * Grupo Transportador X03 pai X01
     * tag NFe/infNFe/transp/tranporta (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagtransporta(stdClass $std): DOMElement
    {
        $possible = [
            'xNome',
            'IE',
            'xEnder',
            'xMun',
            'UF',
            'CNPJ',
            'CPF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'X03 <transporta> -';
        $transporta = $this->dom->createElement("transporta");
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $transporta,
                "CNPJ",
                $std->CNPJ,
                false,
                "$identificador CNPJ do Transportador (CNPJ)"
            );
        } elseif (!empty($std->CPF)) {
            $this->dom->addChild(
                $transporta,
                "CPF",
                $std->CPF,
                false,
                "$identificador CPF do Transportador (CPF)"
            );
        }
        $this->dom->addChild(
            $transporta,
            "xNome",
            $std->xNome,
            false,
            "$identificador Razão Social ou nome do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "IE",
            $std->IE,
            false,
            "$identificador Inscrição Estadual do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xEnder",
            $std->xEnder,
            false,
            "$identificador Endereço Completo do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xMun",
            $std->xMun,
            false,
            "$identificador Nome do município do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "UF",
            $std->UF,
            false,
            "$identificador Sigla da UF do Transportador"
        );
        $this->transporta = $transporta;
        return $transporta;
    }

    /**
     * Grupo Retenção ICMS transporte X11 pai X01
     * tag NFe/infNFe/transp/retTransp (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagretTransp(stdClass $std): DOMElement
    {
        $possible = [
            'vServ',
            'vBCRet',
            'pICMSRet',
            'vICMSRet',
            'CFOP',
            'cMunFG'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'X11 <retTransp> -';
        $retTransp = $this->dom->createElement("retTransp");
        $this->dom->addChild(
            $retTransp,
            "vServ",
            $this->conditionalNumberFormatting($std->vServ),
            true,
            "$identificador Valor do Serviço"
        );
        $this->dom->addChild(
            $retTransp,
            "vBCRet",
            $this->conditionalNumberFormatting($std->vBCRet),
            true,
            "$identificador BC da Retenção do ICMS"
        );
        $this->dom->addChild(
            $retTransp,
            "pICMSRet",
            $this->conditionalNumberFormatting($std->pICMSRet, 4),
            true,
            "$identificador Alíquota da Retenção"
        );
        $this->dom->addChild(
            $retTransp,
            "vICMSRet",
            $this->conditionalNumberFormatting($std->vICMSRet),
            true,
            "$identificador Valor do ICMS Retido"
        );
        $this->dom->addChild(
            $retTransp,
            "CFOP",
            $std->CFOP,
            true,
            "$identificador CFOP"
        );
        $this->dom->addChild(
            $retTransp,
            "cMunFG",
            $std->cMunFG,
            true,
            "$identificador Código do município de ocorrência do fato gerador do ICMS do transporte"
        );
        $this->retTransp = $retTransp;
        return $retTransp;
    }

    /**
     * Grupo Veículo Transporte X18 pai X17.1
     * tag NFe/infNFe/transp/veicTransp (opcional)
     * Ajustado NT 2020.005 v1.20
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagveicTransp(stdClass $std): DOMElement
    {
        $possible = [
            'placa',
            'UF',
            'RNTC'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'X18 <veicTransp> -';
        $veicTransp = $this->dom->createElement("veicTransp");
        $this->dom->addChild(
            $veicTransp,
            "placa",
            $std->placa,
            true,
            "$identificador Placa do Veículo"
        );
        $this->dom->addChild(
            $veicTransp,
            "UF",
            $std->UF,
            false,
            "$identificador Sigla da UF do Veículo"
        );
        $this->dom->addChild(
            $veicTransp,
            "RNTC",
            $std->RNTC,
            false,
            "$identificador Registro Nacional de Transportador de Carga (ANTT) do Veículo"
        );
        $this->veicTransp = $veicTransp;
        return $veicTransp;
    }

    /**
     * Grupo Reboque X22 pai X17.1
     * tag NFe/infNFe/transp/reboque (opcional)
     * Ajustado NT 2020.005 v1.20
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagreboque(stdClass $std): DOMElement
    {
        $possible = [
            'placa',
            'UF',
            'RNTC'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'X22 <reboque> -';
        $reboque = $this->dom->createElement("reboque");
        $this->dom->addChild(
            $reboque,
            "placa",
            $std->placa,
            true,
            "$identificador Placa do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "UF",
            $std->UF,
            false,
            "$identificador Sigla da UF do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "RNTC",
            $std->RNTC,
            false,
            "$identificador Registro Nacional de Transportador de Carga (ANTT) do Veículo Reboque"
        );
        $this->aReboque[] = $reboque;
        return $reboque;
    }

    /**
     * Campo Vagao X25a pai X01
     * tag NFe/infNFe/transp/vagao (opcional)
     */
    public function tagvagao(stdClass $std): ?DOMElement
    {
        $possible = [
            'vagao'
        ];
        $std = $this->equilizeParameters($std, $possible);
        if (empty($std->vagao)) {
            return null;
        }
        $this->vagao = $this->dom->createElement("vagao", $std->vagao);
        return $this->vagao;
    }

    /**
     * Campo Balsa X25b pai X01
     * tag NFe/infNFe/transp/balsa (opcional)
     * @param stdClass $std
     * @return DOMElement|null
     * @throws DOMException
     */
    public function tagbalsa(stdClass $std): ?DOMElement
    {
        $possible = [
            'balsa'
        ];
        $std = $this->equilizeParameters($std, $possible);
        if (empty($std->balsa)) {
            return null;
        }
        $this->balsa = $this->dom->createElement("balsa", $std->balsa);
        return $this->balsa;
    }

    /**
     * Grupo Volumes X26 pai X01
     * tag NFe/infNFe/transp/vol (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagvol(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'qVol',
            'esp',
            'marca',
            'nVol',
            'pesoL',
            'pesoB'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'X26 <vol> -';
        $vol = $this->dom->createElement("vol");
        $this->dom->addChild(
            $vol,
            "qVol",
            $this->conditionalNumberFormatting($std->qVol, 0),
            false,
            "$identificador Quantidade de volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "esp",
            $std->esp,
            false,
            "$identificador Espécie dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "marca",
            $std->marca,
            false,
            "$identificador Marca dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "nVol",
            $std->nVol,
            false,
            "$identificador Numeração dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "pesoL",
            $this->conditionalNumberFormatting($std->pesoL, 3),
            false,
            "$identificador Peso Líquido (em kg) dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "pesoB",
            $this->conditionalNumberFormatting($std->pesoB, 3),
            false,
            "$identificador Peso Bruto (em kg) dos volumes transportados"
        );
        $this->aVol[$std->item] = $vol;
        return $vol;
    }

    /**
     * Grupo Lacres X33 pai X26
     * tag NFe/infNFe/transp/vol/lacres (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taglacres(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nLacre'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'X33 <lacres> -';
        $lacre = $this->dom->createElement("lacres");
        $this->dom->addChild(
            $lacre,
            "nLacre",
            $std->nLacre,
            true,
            "$identificador Número dos Lacres"
        );
        $this->aLacre[$std->item][] = $lacre;
        return $lacre;
    }

    /**
     * Node vol
     */
    protected function buildVol()
    {
        foreach ($this->aVol as $num => $vol) {
            $this->dom->appChild($this->transp, $vol, "Inclusão do node vol");
        }
    }
}
