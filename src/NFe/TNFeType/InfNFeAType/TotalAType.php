<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType;

/**
 * Class representing TotalAType
 */
class TotalAType
{

    /**
     * Totais referentes ao ICMS
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ICMSTotAType $iCMSTot
     */
    private $iCMSTot = null;

    /**
     * Totais referentes ao ISSQN
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ISSQNtotAType
     * $iSSQNtot
     */
    private $iSSQNtot = null;

    /**
     * Retenção de Tributos Federais
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\RetTribAType $retTrib
     */
    private $retTrib = null;

    /**
     * Gets as iCMSTot
     *
     * Totais referentes ao ICMS
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ICMSTotAType
     */
    public function getICMSTot()
    {
        return $this->iCMSTot;
    }

    /**
     * Sets a new iCMSTot
     *
     * Totais referentes ao ICMS
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ICMSTotAType $iCMSTot
     * @return self
     */
    public function setICMSTot(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ICMSTotAType $iCMSTot)
    {
        $this->iCMSTot = $iCMSTot;
        return $this;
    }

    /**
     * Gets as iSSQNtot
     *
     * Totais referentes ao ISSQN
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ISSQNtotAType
     */
    public function getISSQNtot()
    {
        return $this->iSSQNtot;
    }

    /**
     * Sets a new iSSQNtot
     *
     * Totais referentes ao ISSQN
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ISSQNtotAType $iSSQNtot
     * @return self
     */
    public function setISSQNtot(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\ISSQNtotAType $iSSQNtot)
    {
        $this->iSSQNtot = $iSSQNtot;
        return $this;
    }

    /**
     * Gets as retTrib
     *
     * Retenção de Tributos Federais
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\RetTribAType
     */
    public function getRetTrib()
    {
        return $this->retTrib;
    }

    /**
     * Sets a new retTrib
     *
     * Retenção de Tributos Federais
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\RetTribAType $retTrib
     * @return self
     */
    public function setRetTrib(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\TotalAType\RetTribAType $retTrib)
    {
        $this->retTrib = $retTrib;
        return $this;
    }


}

