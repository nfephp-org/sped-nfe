<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TProtNFe
 *
 * Tipo Protocolo de status resultado do processamento da NF-e
 * XSD Type: TProtNFe
 */
class TProtNFe
{

    /**
     * @property string $versao
     */
    private $versao = null;

    /**
     * Dados do protocolo de status
     *
     * @property \NFePHP\NFe\NFe\TProtNFe\InfProt $infProt
     */
    private $infProt = null;

    /**
     * @property \NFePHP\NFe\NFe\Signature $signature
     */
    private $signature = null;

    /**
     * Gets as versao
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Sets a new versao
     *
     * @param string $versao
     * @return self
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Gets as infProt
     *
     * Dados do protocolo de status
     *
     * @return \NFePHP\NFe\NFe\TProtNFe\InfProt
     */
    public function getInfProt()
    {
        return $this->infProt;
    }

    /**
     * Sets a new infProt
     *
     * Dados do protocolo de status
     *
     * @param \NFePHP\NFe\NFe\TProtNFe\InfProt $infProt
     * @return self
     */
    public function setInfProt(\NFePHP\NFe\NFe\TProtNFe\InfProt $infProt)
    {
        $this->infProt = $infProt;
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

