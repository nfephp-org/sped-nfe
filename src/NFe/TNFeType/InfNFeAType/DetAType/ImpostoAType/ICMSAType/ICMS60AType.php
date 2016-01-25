<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType;

/**
 * Class representing ICMS60AType
 */
class ICMS60AType
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
     * Tributação pelo ICMS 
     * 60 - ICMS cobrado anteriormente por substituição tributária
     *
     * @property string $cST
     */
    private $cST = null;

    /**
     * Valor da BC do ICMS ST retido anteriormente
     *
     * @property string $vBCSTRet
     */
    private $vBCSTRet = null;

    /**
     * Valor do ICMS ST retido anteriormente
     *
     * @property string $vICMSSTRet
     */
    private $vICMSSTRet = null;

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
     * Tributação pelo ICMS 
     * 60 - ICMS cobrado anteriormente por substituição tributária
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
     * Tributação pelo ICMS 
     * 60 - ICMS cobrado anteriormente por substituição tributária
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
     * Valor da BC do ICMS ST retido anteriormente
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
     * Valor da BC do ICMS ST retido anteriormente
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
     * Valor do ICMS ST retido anteriormente
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
     * Valor do ICMS ST retido anteriormente
     *
     * @param string $vICMSSTRet
     * @return self
     */
    public function setVICMSSTRet($vICMSSTRet)
    {
        $this->vICMSSTRet = $vICMSSTRet;
        return $this;
    }


}

