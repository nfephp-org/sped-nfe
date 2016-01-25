<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType;

/**
 * Class representing RetTribAType
 */
class RetTribAType
{

    /**
     * Valor Retido de PIS
     *
     * @property string $vRetPIS
     */
    private $vRetPIS = null;

    /**
     * Valor Retido de COFINS
     *
     * @property string $vRetCOFINS
     */
    private $vRetCOFINS = null;

    /**
     * Valor Retido de CSLL
     *
     * @property string $vRetCSLL
     */
    private $vRetCSLL = null;

    /**
     * Base de Cálculo do IRRF
     *
     * @property string $vBCIRRF
     */
    private $vBCIRRF = null;

    /**
     * Valor Retido de IRRF
     *
     * @property string $vIRRF
     */
    private $vIRRF = null;

    /**
     * Base de Cálculo da Retenção da Previdêncica Social
     *
     * @property string $vBCRetPrev
     */
    private $vBCRetPrev = null;

    /**
     * Valor da Retenção da Previdêncica Social
     *
     * @property string $vRetPrev
     */
    private $vRetPrev = null;

    /**
     * Gets as vRetPIS
     *
     * Valor Retido de PIS
     *
     * @return string
     */
    public function getVRetPIS()
    {
        return $this->vRetPIS;
    }

    /**
     * Sets a new vRetPIS
     *
     * Valor Retido de PIS
     *
     * @param string $vRetPIS
     * @return self
     */
    public function setVRetPIS($vRetPIS)
    {
        $this->vRetPIS = $vRetPIS;
        return $this;
    }

    /**
     * Gets as vRetCOFINS
     *
     * Valor Retido de COFINS
     *
     * @return string
     */
    public function getVRetCOFINS()
    {
        return $this->vRetCOFINS;
    }

    /**
     * Sets a new vRetCOFINS
     *
     * Valor Retido de COFINS
     *
     * @param string $vRetCOFINS
     * @return self
     */
    public function setVRetCOFINS($vRetCOFINS)
    {
        $this->vRetCOFINS = $vRetCOFINS;
        return $this;
    }

    /**
     * Gets as vRetCSLL
     *
     * Valor Retido de CSLL
     *
     * @return string
     */
    public function getVRetCSLL()
    {
        return $this->vRetCSLL;
    }

    /**
     * Sets a new vRetCSLL
     *
     * Valor Retido de CSLL
     *
     * @param string $vRetCSLL
     * @return self
     */
    public function setVRetCSLL($vRetCSLL)
    {
        $this->vRetCSLL = $vRetCSLL;
        return $this;
    }

    /**
     * Gets as vBCIRRF
     *
     * Base de Cálculo do IRRF
     *
     * @return string
     */
    public function getVBCIRRF()
    {
        return $this->vBCIRRF;
    }

    /**
     * Sets a new vBCIRRF
     *
     * Base de Cálculo do IRRF
     *
     * @param string $vBCIRRF
     * @return self
     */
    public function setVBCIRRF($vBCIRRF)
    {
        $this->vBCIRRF = $vBCIRRF;
        return $this;
    }

    /**
     * Gets as vIRRF
     *
     * Valor Retido de IRRF
     *
     * @return string
     */
    public function getVIRRF()
    {
        return $this->vIRRF;
    }

    /**
     * Sets a new vIRRF
     *
     * Valor Retido de IRRF
     *
     * @param string $vIRRF
     * @return self
     */
    public function setVIRRF($vIRRF)
    {
        $this->vIRRF = $vIRRF;
        return $this;
    }

    /**
     * Gets as vBCRetPrev
     *
     * Base de Cálculo da Retenção da Previdêncica Social
     *
     * @return string
     */
    public function getVBCRetPrev()
    {
        return $this->vBCRetPrev;
    }

    /**
     * Sets a new vBCRetPrev
     *
     * Base de Cálculo da Retenção da Previdêncica Social
     *
     * @param string $vBCRetPrev
     * @return self
     */
    public function setVBCRetPrev($vBCRetPrev)
    {
        $this->vBCRetPrev = $vBCRetPrev;
        return $this;
    }

    /**
     * Gets as vRetPrev
     *
     * Valor da Retenção da Previdêncica Social
     *
     * @return string
     */
    public function getVRetPrev()
    {
        return $this->vRetPrev;
    }

    /**
     * Sets a new vRetPrev
     *
     * Valor da Retenção da Previdêncica Social
     *
     * @param string $vRetPrev
     * @return self
     */
    public function setVRetPrev($vRetPrev)
    {
        $this->vRetPrev = $vRetPrev;
        return $this;
    }


}

