<?php

namespace NFePHP\NFe\NFe\TIpiType;

/**
 * Class representing IPITribAType
 */
class IPITribAType
{

    /**
     * Código da Situação Tributária do IPI:
     * 00-Entrada com recuperação de crédito
     * 49 - Outras entradas
     * 50-Saída tributada
     * 99-Outras saídas
     *
     * @property string $cST
     */
    private $cST = null;

    /**
     * Valor da BC do IPI
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Alíquota do IPI
     *
     * @property string $pIPI
     */
    private $pIPI = null;

    /**
     * Quantidade total na unidade padrão para tributação
     *
     * @property string $qUnid
     */
    private $qUnid = null;

    /**
     * Valor por Unidade Tributável. Informar o valor do imposto Pauta por unidade de
     * medida.
     *
     * @property string $vUnid
     */
    private $vUnid = null;

    /**
     * Valor do IPI
     *
     * @property string $vIPI
     */
    private $vIPI = null;

    /**
     * Gets as cST
     *
     * Código da Situação Tributária do IPI:
     * 00-Entrada com recuperação de crédito
     * 49 - Outras entradas
     * 50-Saída tributada
     * 99-Outras saídas
     *
     * @return string
     */
    public function getCST()
    {
        return $this->cST;
    }

    /**
     * Sets a new cST
     *
     * Código da Situação Tributária do IPI:
     * 00-Entrada com recuperação de crédito
     * 49 - Outras entradas
     * 50-Saída tributada
     * 99-Outras saídas
     *
     * @param string $cST
     * @return self
     */
    public function setCST($cST)
    {
        $this->cST = $cST;
        return $this;
    }

    /**
     * Gets as vBC
     *
     * Valor da BC do IPI
     *
     * @return string
     */
    public function getVBC()
    {
        return $this->vBC;
    }

    /**
     * Sets a new vBC
     *
     * Valor da BC do IPI
     *
     * @param string $vBC
     * @return self
     */
    public function setVBC($vBC)
    {
        $this->vBC = $vBC;
        return $this;
    }

    /**
     * Gets as pIPI
     *
     * Alíquota do IPI
     *
     * @return string
     */
    public function getPIPI()
    {
        return $this->pIPI;
    }

    /**
     * Sets a new pIPI
     *
     * Alíquota do IPI
     *
     * @param string $pIPI
     * @return self
     */
    public function setPIPI($pIPI)
    {
        $this->pIPI = $pIPI;
        return $this;
    }

    /**
     * Gets as qUnid
     *
     * Quantidade total na unidade padrão para tributação
     *
     * @return string
     */
    public function getQUnid()
    {
        return $this->qUnid;
    }

    /**
     * Sets a new qUnid
     *
     * Quantidade total na unidade padrão para tributação
     *
     * @param string $qUnid
     * @return self
     */
    public function setQUnid($qUnid)
    {
        $this->qUnid = $qUnid;
        return $this;
    }

    /**
     * Gets as vUnid
     *
     * Valor por Unidade Tributável. Informar o valor do imposto Pauta por unidade de
     * medida.
     *
     * @return string
     */
    public function getVUnid()
    {
        return $this->vUnid;
    }

    /**
     * Sets a new vUnid
     *
     * Valor por Unidade Tributável. Informar o valor do imposto Pauta por unidade de
     * medida.
     *
     * @param string $vUnid
     * @return self
     */
    public function setVUnid($vUnid)
    {
        $this->vUnid = $vUnid;
        return $this;
    }

    /**
     * Gets as vIPI
     *
     * Valor do IPI
     *
     * @return string
     */
    public function getVIPI()
    {
        return $this->vIPI;
    }

    /**
     * Sets a new vIPI
     *
     * Valor do IPI
     *
     * @param string $vIPI
     * @return self
     */
    public function setVIPI($vIPI)
    {
        $this->vIPI = $vIPI;
        return $this;
    }


}

