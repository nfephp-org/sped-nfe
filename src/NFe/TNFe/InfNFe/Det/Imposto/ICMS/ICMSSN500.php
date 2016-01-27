<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\ICMS;

/**
 * Class representing ICMSSN500
 */
class ICMSSN500
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
     * 500 – ICMS cobrado anterirmente por substituição tributária (substituído)
     * ou por antecipação
     * (v.2.0)
     *
     * @property string $cSOSN
     */
    private $cSOSN = null;

    /**
     * Valor da BC do ICMS ST retido anteriormente (v2.0)
     *
     * @property string $vBCSTRet
     */
    private $vBCSTRet = null;

    /**
     * Valor do ICMS ST retido anteriormente (v2.0)
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
     * Gets as cSOSN
     *
     * 500 – ICMS cobrado anterirmente por substituição tributária (substituído)
     * ou por antecipação
     * (v.2.0)
     *
     * @return string
     */
    public function getCSOSN()
    {
        return $this->cSOSN;
    }

    /**
     * Sets a new cSOSN
     *
     * 500 – ICMS cobrado anterirmente por substituição tributária (substituído)
     * ou por antecipação
     * (v.2.0)
     *
     * @param string $cSOSN
     * @return self
     */
    public function setCSOSN($cSOSN)
    {
        $this->cSOSN = $cSOSN;
        return $this;
    }

    /**
     * Gets as vBCSTRet
     *
     * Valor da BC do ICMS ST retido anteriormente (v2.0)
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
     * Valor da BC do ICMS ST retido anteriormente (v2.0)
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
     * Valor do ICMS ST retido anteriormente (v2.0)
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
     * Valor do ICMS ST retido anteriormente (v2.0)
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

