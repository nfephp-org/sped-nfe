<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISAType;

/**
 * Class representing PISOutrAType
 */
class PISOutrAType
{

    /**
     * Código de Situação Tributária do PIS.
     * 99 - Outras Operações.
     *
     * @property string $cST
     */
    private $cST = null;

    /**
     * Valor da BC do PIS
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Alíquota do PIS (em percentual)
     *
     * @property string $pPIS
     */
    private $pPIS = null;

    /**
     * Quantidade Vendida (NT2011/004)
     *
     * @property string $qBCProd
     */
    private $qBCProd = null;

    /**
     * Alíquota do PIS (em reais) (NT2011/004)
     *
     * @property string $vAliqProd
     */
    private $vAliqProd = null;

    /**
     * Valor do PIS
     *
     * @property string $vPIS
     */
    private $vPIS = null;

    /**
     * Gets as cST
     *
     * Código de Situação Tributária do PIS.
     * 99 - Outras Operações.
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
     * Código de Situação Tributária do PIS.
     * 99 - Outras Operações.
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
     * Valor da BC do PIS
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
     * Valor da BC do PIS
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
     * Alíquota do PIS (em percentual)
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
     * Alíquota do PIS (em percentual)
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
     * Quantidade Vendida (NT2011/004)
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
     * Quantidade Vendida (NT2011/004)
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
     * Alíquota do PIS (em reais) (NT2011/004)
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
     * Alíquota do PIS (em reais) (NT2011/004)
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
     * Valor do PIS
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
     * Valor do PIS
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

