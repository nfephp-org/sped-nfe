<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe;

/**
 * Class representing Total
 */
class Total
{

    /**
     * Totais referentes ao ICMS
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Total\ICMSTot $iCMSTot
     */
    private $iCMSTot = null;

    /**
     * Totais referentes ao ISSQN
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Total\ISSQNtot $iSSQNtot
     */
    private $iSSQNtot = null;

    /**
     * Retenção de Tributos Federais
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Total\RetTrib $retTrib
     */
    private $retTrib = null;

    /**
     * Gets as iCMSTot
     *
     * Totais referentes ao ICMS
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Total\ICMSTot
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
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Total\ICMSTot $iCMSTot
     * @return self
     */
    public function setICMSTot(\NFePHP\NFe\NFe\TNFe\InfNFe\Total\ICMSTot $iCMSTot)
    {
        $this->iCMSTot = $iCMSTot;
        return $this;
    }

    /**
     * Gets as iSSQNtot
     *
     * Totais referentes ao ISSQN
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Total\ISSQNtot
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
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Total\ISSQNtot $iSSQNtot
     * @return self
     */
    public function setISSQNtot(\NFePHP\NFe\NFe\TNFe\InfNFe\Total\ISSQNtot $iSSQNtot)
    {
        $this->iSSQNtot = $iSSQNtot;
        return $this;
    }

    /**
     * Gets as retTrib
     *
     * Retenção de Tributos Federais
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Total\RetTrib
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
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Total\RetTrib $retTrib
     * @return self
     */
    public function setRetTrib(\NFePHP\NFe\NFe\TNFe\InfNFe\Total\RetTrib $retTrib)
    {
        $this->retTrib = $retTrib;
        return $this;
    }


}

