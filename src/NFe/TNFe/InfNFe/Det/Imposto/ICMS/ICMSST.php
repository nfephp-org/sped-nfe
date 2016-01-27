<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\ICMS;

/**
 * Class representing ICMSST
 */
class ICMSST
{

    /**
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno
     *
     * @property string $orig
     */
    private $orig = null;

    /**
     * Tributção pelo ICMS
     * 41-Não Tributado
     *
     * @property string $cST
     */
    private $cST = null;

    /**
     * Informar o valor da BC do ICMS ST retido na UF remetente
     *
     * @property string $vBCSTRet
     */
    private $vBCSTRet = null;

    /**
     * Informar o valor do ICMS ST retido na UF remetente (iv2.0))
     *
     * @property string $vICMSSTRet
     */
    private $vICMSSTRet = null;

    /**
     * Informar o valor da BC do ICMS ST da UF destino
     *
     * @property string $vBCSTDest
     */
    private $vBCSTDest = null;

    /**
     * Informar o valor da BC do ICMS ST da UF destino (v2.0)
     *
     * @property string $vICMSSTDest
     */
    private $vICMSSTDest = null;

    /**
     * Gets as orig
     *
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno
     *
     * @return string
     */
    public function getOrig()
    {
        return $this->orig;
    }

    /**
     * Sets a new orig
     *
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno
     *
     * @param string $orig
     * @return self
     */
    public function setOrig($orig)
    {
        $this->orig = $orig;
        return $this;
    }

    /**
     * Gets as cST
     *
     * Tributção pelo ICMS
     * 41-Não Tributado
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
     * Tributção pelo ICMS
     * 41-Não Tributado
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
     * Gets as vBCSTRet
     *
     * Informar o valor da BC do ICMS ST retido na UF remetente
     *
     * @return string
     */
    public function getVBCSTRet()
    {
        return $this->vBCSTRet;
    }

    /**
     * Sets a new vBCSTRet
     *
     * Informar o valor da BC do ICMS ST retido na UF remetente
     *
     * @param string $vBCSTRet
     * @return self
     */
    public function setVBCSTRet($vBCSTRet)
    {
        $this->vBCSTRet = $vBCSTRet;
        return $this;
    }

    /**
     * Gets as vICMSSTRet
     *
     * Informar o valor do ICMS ST retido na UF remetente (iv2.0))
     *
     * @return string
     */
    public function getVICMSSTRet()
    {
        return $this->vICMSSTRet;
    }

    /**
     * Sets a new vICMSSTRet
     *
     * Informar o valor do ICMS ST retido na UF remetente (iv2.0))
     *
     * @param string $vICMSSTRet
     * @return self
     */
    public function setVICMSSTRet($vICMSSTRet)
    {
        $this->vICMSSTRet = $vICMSSTRet;
        return $this;
    }

    /**
     * Gets as vBCSTDest
     *
     * Informar o valor da BC do ICMS ST da UF destino
     *
     * @return string
     */
    public function getVBCSTDest()
    {
        return $this->vBCSTDest;
    }

    /**
     * Sets a new vBCSTDest
     *
     * Informar o valor da BC do ICMS ST da UF destino
     *
     * @param string $vBCSTDest
     * @return self
     */
    public function setVBCSTDest($vBCSTDest)
    {
        $this->vBCSTDest = $vBCSTDest;
        return $this;
    }

    /**
     * Gets as vICMSSTDest
     *
     * Informar o valor da BC do ICMS ST da UF destino (v2.0)
     *
     * @return string
     */
    public function getVICMSSTDest()
    {
        return $this->vICMSSTDest;
    }

    /**
     * Sets a new vICMSSTDest
     *
     * Informar o valor da BC do ICMS ST da UF destino (v2.0)
     *
     * @param string $vICMSSTDest
     * @return self
     */
    public function setVICMSSTDest($vICMSSTDest)
    {
        $this->vICMSSTDest = $vICMSSTDest;
        return $this;
    }


}

