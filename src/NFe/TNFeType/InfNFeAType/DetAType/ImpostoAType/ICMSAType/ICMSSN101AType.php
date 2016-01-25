<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType;

/**
 * Class representing ICMSSN101AType
 */
class ICMSSN101AType
{

    /**
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno 
     * (v2.0)
     *
     * @property string $orig
     */
    private $orig = null;

    /**
     * 101- Tributada pelo Simples Nacional com permissão de crédito. (v.2.0)
     *
     * @property string $cSOSN
     */
    private $cSOSN = null;

    /**
     * Alíquota aplicável de cálculo do crédito (Simples Nacional). (v2.0)
     *
     * @property string $pCredSN
     */
    private $pCredSN = null;

    /**
     * Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123
     * (Simples Nacional) (v2.0)
     *
     * @property string $vCredICMSSN
     */
    private $vCredICMSSN = null;

    /**
     * Gets as orig
     *
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno 
     * (v2.0)
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
     * (v2.0)
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
     * 101- Tributada pelo Simples Nacional com permissão de crédito. (v.2.0)
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
     * 101- Tributada pelo Simples Nacional com permissão de crédito. (v.2.0)
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
     * Gets as pCredSN
     *
     * Alíquota aplicável de cálculo do crédito (Simples Nacional). (v2.0)
     *
     * @return string
     */
    public function getPCredSN()
    {
        return $this->pCredSN;
    }

    /**
     * Sets a new pCredSN
     *
     * Alíquota aplicável de cálculo do crédito (Simples Nacional). (v2.0)
     *
     * @param string $pCredSN
     * @return self
     */
    public function setPCredSN($pCredSN)
    {
        $this->pCredSN = $pCredSN;
        return $this;
    }

    /**
     * Gets as vCredICMSSN
     *
     * Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123
     * (Simples Nacional) (v2.0)
     *
     * @return string
     */
    public function getVCredICMSSN()
    {
        return $this->vCredICMSSN;
    }

    /**
     * Sets a new vCredICMSSN
     *
     * Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123
     * (Simples Nacional) (v2.0)
     *
     * @param string $vCredICMSSN
     * @return self
     */
    public function setVCredICMSSN($vCredICMSSN)
    {
        $this->vCredICMSSN = $vCredICMSSN;
        return $this;
    }


}

