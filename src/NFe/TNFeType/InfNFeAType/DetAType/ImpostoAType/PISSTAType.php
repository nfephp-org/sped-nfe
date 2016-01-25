<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType;

/**
 * Class representing PISSTAType
 */
class PISSTAType
{

    /**
     * Valor da BC do PIS ST
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Alíquota do PIS ST (em percentual)
     *
     * @property string $pPIS
     */
    private $pPIS = null;

    /**
     * Quantidade Vendida
     *
     * @property string $qBCProd
     */
    private $qBCProd = null;

    /**
     * Alíquota do PIS ST (em reais)
     *
     * @property string $vAliqProd
     */
    private $vAliqProd = null;

    /**
     * Valor do PIS ST
     *
     * @property string $vPIS
     */
    private $vPIS = null;

    /**
     * Gets as vBC
     *
     * Valor da BC do PIS ST
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
     * Valor da BC do PIS ST
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
     * Gets as pPIS
     *
     * Alíquota do PIS ST (em percentual)
     *
     * @return string
     */
    public function getPPIS()
    {
        return $this->pPIS;
    }

    /**
     * Sets a new pPIS
     *
     * Alíquota do PIS ST (em percentual)
     *
     * @param string $pPIS
     * @return self
     */
    public function setPPIS($pPIS)
    {
        $this->pPIS = $pPIS;
        return $this;
    }

    /**
     * Gets as qBCProd
     *
     * Quantidade Vendida
     *
     * @return string
     */
    public function getQBCProd()
    {
        return $this->qBCProd;
    }

    /**
     * Sets a new qBCProd
     *
     * Quantidade Vendida
     *
     * @param string $qBCProd
     * @return self
     */
    public function setQBCProd($qBCProd)
    {
        $this->qBCProd = $qBCProd;
        return $this;
    }

    /**
     * Gets as vAliqProd
     *
     * Alíquota do PIS ST (em reais)
     *
     * @return string
     */
    public function getVAliqProd()
    {
        return $this->vAliqProd;
    }

    /**
     * Sets a new vAliqProd
     *
     * Alíquota do PIS ST (em reais)
     *
     * @param string $vAliqProd
     * @return self
     */
    public function setVAliqProd($vAliqProd)
    {
        $this->vAliqProd = $vAliqProd;
        return $this;
    }

    /**
     * Gets as vPIS
     *
     * Valor do PIS ST
     *
     * @return string
     */
    public function getVPIS()
    {
        return $this->vPIS;
    }

    /**
     * Sets a new vPIS
     *
     * Valor do PIS ST
     *
     * @param string $vPIS
     * @return self
     */
    public function setVPIS($vPIS)
    {
        $this->vPIS = $vPIS;
        return $this;
    }


}

