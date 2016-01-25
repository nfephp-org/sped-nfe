<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType;

/**
 * Class representing CanaAType
 */
class CanaAType
{

    /**
     * Identificação da safra
     *
     * @property string $safra
     */
    private $safra = null;

    /**
     * Mês e Ano de Referência, formato: MM/AAAA
     *
     * @property string $ref
     */
    private $ref = null;

    /**
     * Fornecimentos diários
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\ForDiaAType[] $forDia
     */
    private $forDia = null;

    /**
     * Total do mês
     *
     * @property string $qTotMes
     */
    private $qTotMes = null;

    /**
     * Total Anterior
     *
     * @property string $qTotAnt
     */
    private $qTotAnt = null;

    /**
     * Total Geral
     *
     * @property string $qTotGer
     */
    private $qTotGer = null;

    /**
     * Deduções - Taxas e Contribuições
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\DeducAType[] $deduc
     */
    private $deduc = null;

    /**
     * Valor dos fornecimentos
     *
     * @property string $vFor
     */
    private $vFor = null;

    /**
     * Valor Total das Deduções
     *
     * @property string $vTotDed
     */
    private $vTotDed = null;

    /**
     * Valor Líquido dos fornecimentos
     *
     * @property string $vLiqFor
     */
    private $vLiqFor = null;

    /**
     * Gets as safra
     *
     * Identificação da safra
     *
     * @return string
     */
    public function getSafra()
    {
        return $this->safra;
    }

    /**
     * Sets a new safra
     *
     * Identificação da safra
     *
     * @param string $safra
     * @return self
     */
    public function setSafra($safra)
    {
        $this->safra = $safra;
        return $this;
    }

    /**
     * Gets as ref
     *
     * Mês e Ano de Referência, formato: MM/AAAA
     *
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * Sets a new ref
     *
     * Mês e Ano de Referência, formato: MM/AAAA
     *
     * @param string $ref
     * @return self
     */
    public function setRef($ref)
    {
        $this->ref = $ref;
        return $this;
    }

    /**
     * Adds as forDia
     *
     * Fornecimentos diários
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\ForDiaAType $forDia
     */
    public function addToForDia(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\ForDiaAType $forDia)
    {
        $this->forDia[] = $forDia;
        return $this;
    }

    /**
     * isset forDia
     *
     * Fornecimentos diários
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetForDia($index)
    {
        return isset($this->forDia[$index]);
    }

    /**
     * unset forDia
     *
     * Fornecimentos diários
     *
     * @param scalar $index
     * @return void
     */
    public function unsetForDia($index)
    {
        unset($this->forDia[$index]);
    }

    /**
     * Gets as forDia
     *
     * Fornecimentos diários
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\ForDiaAType[]
     */
    public function getForDia()
    {
        return $this->forDia;
    }

    /**
     * Sets a new forDia
     *
     * Fornecimentos diários
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\ForDiaAType[] $forDia
     * @return self
     */
    public function setForDia(array $forDia)
    {
        $this->forDia = $forDia;
        return $this;
    }

    /**
     * Gets as qTotMes
     *
     * Total do mês
     *
     * @return string
     */
    public function getQTotMes()
    {
        return $this->qTotMes;
    }

    /**
     * Sets a new qTotMes
     *
     * Total do mês
     *
     * @param string $qTotMes
     * @return self
     */
    public function setQTotMes($qTotMes)
    {
        $this->qTotMes = $qTotMes;
        return $this;
    }

    /**
     * Gets as qTotAnt
     *
     * Total Anterior
     *
     * @return string
     */
    public function getQTotAnt()
    {
        return $this->qTotAnt;
    }

    /**
     * Sets a new qTotAnt
     *
     * Total Anterior
     *
     * @param string $qTotAnt
     * @return self
     */
    public function setQTotAnt($qTotAnt)
    {
        $this->qTotAnt = $qTotAnt;
        return $this;
    }

    /**
     * Gets as qTotGer
     *
     * Total Geral
     *
     * @return string
     */
    public function getQTotGer()
    {
        return $this->qTotGer;
    }

    /**
     * Sets a new qTotGer
     *
     * Total Geral
     *
     * @param string $qTotGer
     * @return self
     */
    public function setQTotGer($qTotGer)
    {
        $this->qTotGer = $qTotGer;
        return $this;
    }

    /**
     * Adds as deduc
     *
     * Deduções - Taxas e Contribuições
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\DeducAType $deduc
     */
    public function addToDeduc(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\DeducAType $deduc)
    {
        $this->deduc[] = $deduc;
        return $this;
    }

    /**
     * isset deduc
     *
     * Deduções - Taxas e Contribuições
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDeduc($index)
    {
        return isset($this->deduc[$index]);
    }

    /**
     * unset deduc
     *
     * Deduções - Taxas e Contribuições
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDeduc($index)
    {
        unset($this->deduc[$index]);
    }

    /**
     * Gets as deduc
     *
     * Deduções - Taxas e Contribuições
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\DeducAType[]
     */
    public function getDeduc()
    {
        return $this->deduc;
    }

    /**
     * Sets a new deduc
     *
     * Deduções - Taxas e Contribuições
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CanaAType\DeducAType[] $deduc
     * @return self
     */
    public function setDeduc(array $deduc)
    {
        $this->deduc = $deduc;
        return $this;
    }

    /**
     * Gets as vFor
     *
     * Valor dos fornecimentos
     *
     * @return string
     */
    public function getVFor()
    {
        return $this->vFor;
    }

    /**
     * Sets a new vFor
     *
     * Valor dos fornecimentos
     *
     * @param string $vFor
     * @return self
     */
    public function setVFor($vFor)
    {
        $this->vFor = $vFor;
        return $this;
    }

    /**
     * Gets as vTotDed
     *
     * Valor Total das Deduções
     *
     * @return string
     */
    public function getVTotDed()
    {
        return $this->vTotDed;
    }

    /**
     * Sets a new vTotDed
     *
     * Valor Total das Deduções
     *
     * @param string $vTotDed
     * @return self
     */
    public function setVTotDed($vTotDed)
    {
        $this->vTotDed = $vTotDed;
        return $this;
    }

    /**
     * Gets as vLiqFor
     *
     * Valor Líquido dos fornecimentos
     *
     * @return string
     */
    public function getVLiqFor()
    {
        return $this->vLiqFor;
    }

    /**
     * Sets a new vLiqFor
     *
     * Valor Líquido dos fornecimentos
     *
     * @param string $vLiqFor
     * @return self
     */
    public function setVLiqFor($vLiqFor)
    {
        $this->vLiqFor = $vLiqFor;
        return $this;
    }


}

