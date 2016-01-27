<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TNFe
 *
 * Tipo Nota Fiscal Eletrônica
 * XSD Type: TNFe
 */
class TNFe
{

    /**
     * Informações da Nota Fiscal eletrônica
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe $infNFe
     */
    private $infNFe = null;

    /**
     * Informações suplementares Nota Fiscal
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFeSupl $infNFeSupl
     */
    private $infNFeSupl = null;

    /**
     * @property \NFePHP\NFe\NFe\Signature $signature
     */
    private $signature = null;

    /**
     * Gets as infNFe
     *
     * Informações da Nota Fiscal eletrônica
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe
     */
    public function getInfNFe()
    {
        return $this->infNFe;
    }

    /**
     * Sets a new infNFe
     *
     * Informações da Nota Fiscal eletrônica
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe $infNFe
     * @return self
     */
    public function setInfNFe(\NFePHP\NFe\NFe\TNFe\InfNFe $infNFe)
    {
        $this->infNFe = $infNFe;
        return $this;
    }

    /**
     * Gets as infNFeSupl
     *
     * Informações suplementares Nota Fiscal
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFeSupl
     */
    public function getInfNFeSupl()
    {
        return $this->infNFeSupl;
    }

    /**
     * Sets a new infNFeSupl
     *
     * Informações suplementares Nota Fiscal
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFeSupl $infNFeSupl
     * @return self
     */
    public function setInfNFeSupl(\NFePHP\NFe\NFe\TNFe\InfNFeSupl $infNFeSupl)
    {
        $this->infNFeSupl = $infNFeSupl;
        return $this;
    }

    /**
     * Gets as signature
     *
     * @return \NFePHP\NFe\NFe\Signature
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Sets a new signature
     *
     * @param \NFePHP\NFe\NFe\Signature $signature
     * @return self
     */
    public function setSignature(\NFePHP\NFe\NFe\Signature $signature)
    {
        $this->signature = $signature;
        return $this;
    }


}

