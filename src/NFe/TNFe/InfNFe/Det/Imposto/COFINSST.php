<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto;

/**
 * Class representing COFINSST
 */
class COFINSST
{

    /**
     * Valor da BC do COFINS ST
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Alíquota do COFINS ST(em percentual)
     *
     * @property string $pCOFINS
     */
    private $pCOFINS = null;

    /**
     * Quantidade Vendida
     *
     * @property string $qBCProd
     */
    private $qBCProd = null;

    /**
     * Alíquota do COFINS ST(em reais)
     *
     * @property string $vAliqProd
     */
    private $vAliqProd = null;

    /**
     * Valor do COFINS ST
     *
     * @property string $vCOFINS
     */
    private $vCOFINS = null;

    /**
     * Gets as vBC
     *
     * Valor da BC do COFINS ST
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
     * Valor da BC do COFINS ST
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
     * Gets as pCOFINS
     *
     * Alíquota do COFINS ST(em percentual)
     *
     * @return string
     */
    public function getPCOFINS()
    {
        return $this->pCOFINS;
    }

    /**
     * Sets a new pCOFINS
     *
     * Alíquota do COFINS ST(em percentual)
     *
     * @param string $pCOFINS
     * @return self
     */
    public function setPCOFINS($pCOFINS)
    {
        $this->pCOFINS = $pCOFINS;
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
     * Alíquota do COFINS ST(em reais)
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
     * Alíquota do COFINS ST(em reais)
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
     * Gets as vCOFINS
     *
     * Valor do COFINS ST
     *
     * @return string
     */
    public function getVCOFINS()
    {
        return $this->vCOFINS;
    }

    /**
     * Sets a new vCOFINS
     *
     * Valor do COFINS ST
     *
     * @param string $vCOFINS
     * @return self
     */
    public function setVCOFINS($vCOFINS)
    {
        $this->vCOFINS = $vCOFINS;
        return $this;
    }


}

