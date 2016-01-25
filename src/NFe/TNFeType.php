<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TNFeType
 *
 * Tipo Nota Fiscal Eletrônica
 * XSD Type: TNFe
 */
class TNFeType
{

    /**
     * Informações da Nota Fiscal eletrônica
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType $infNFe
     */
    private $infNFe = null;

    /**
     * Informações suplementares Nota Fiscal
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeSuplAType $infNFeSupl
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
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType
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
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType $infNFe
     * @return self
     */
    public function setInfNFe(\NFePHP\NFe\NFe\TNFeType\InfNFeAType $infNFe)
    {
        $this->infNFe = $infNFe;
        return $this;
    }

    /**
     * Gets as infNFeSupl
     *
     * Informações suplementares Nota Fiscal
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeSuplAType
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
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeSuplAType $infNFeSupl
     * @return self
     */
    public function setInfNFeSupl(\NFePHP\NFe\NFe\TNFeType\InfNFeSuplAType $infNFeSupl)
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

