<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ProdAType\CombAType;

/**
 * Class representing CIDEAType
 */
class CIDEAType
{

    /**
     * BC do CIDE ( Quantidade comercializada)
     *
     * @property string $qBCProd
     */
    private $qBCProd = null;

    /**
     * Alíquota do CIDE (em reais)
     *
     * @property string $vAliqProd
     */
    private $vAliqProd = null;

    /**
     * Valor do CIDE
     *
     * @property string $vCIDE
     */
    private $vCIDE = null;

    /**
     * Gets as qBCProd
     *
     * BC do CIDE ( Quantidade comercializada)
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
     * BC do CIDE ( Quantidade comercializada)
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
     * Alíquota do CIDE (em reais)
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
     * Alíquota do CIDE (em reais)
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
     * Gets as vCIDE
     *
     * Valor do CIDE
     *
     * @return string
     */
    public function getVCIDE()
    {
        return $this->vCIDE;
    }

    /**
     * Sets a new vCIDE
     *
     * Valor do CIDE
     *
     * @param string $vCIDE
     * @return self
     */
    public function setVCIDE($vCIDE)
    {
        $this->vCIDE = $vCIDE;
        return $this;
    }


}

