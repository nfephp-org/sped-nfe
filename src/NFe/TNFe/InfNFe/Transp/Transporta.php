<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Transp;

/**
 * Class representing Transporta
 */
class Transporta
{

    /**
     * CNPJ do transportador
     *
     * @property string $cNPJ
     */
    private $cNPJ = null;

    /**
     * CPF do transportador
     *
     * @property string $cPF
     */
    private $cPF = null;

    /**
     * Razão Social ou nome do transportador
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * Inscrição Estadual (v2.0)
     *
     * @property string $iE
     */
    private $iE = null;

    /**
     * Endereço completo
     *
     * @property string $xEnder
     */
    private $xEnder = null;

    /**
     * Nome do munícipio
     *
     * @property string $xMun
     */
    private $xMun = null;

    /**
     * Sigla da UF
     *
     * @property string $uF
     */
    private $uF = null;

    /**
     * Gets as cNPJ
     *
     * CNPJ do transportador
     *
     * @return string
     */
    public function getCNPJ()
    {
        return $this->cNPJ;
    }

    /**
     * Sets a new cNPJ
     *
     * CNPJ do transportador
     *
     * @param string $cNPJ
     * @return self
     */
    public function setCNPJ($cNPJ)
    {
        $this->cNPJ = $cNPJ;
        return $this;
    }

    /**
     * Gets as cPF
     *
     * CPF do transportador
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->cPF;
    }

    /**
     * Sets a new cPF
     *
     * CPF do transportador
     *
     * @param string $cPF
     * @return self
     */
    public function setCPF($cPF)
    {
        $this->cPF = $cPF;
        return $this;
    }

    /**
     * Gets as xNome
     *
     * Razão Social ou nome do transportador
     *
     * @return string
     */
    public function getXNome()
    {
        return $this->xNome;
    }

    /**
     * Sets a new xNome
     *
     * Razão Social ou nome do transportador
     *
     * @param string $xNome
     * @return self
     */
    public function setXNome($xNome)
    {
        $this->xNome = $xNome;
        return $this;
    }

    /**
     * Gets as iE
     *
     * Inscrição Estadual (v2.0)
     *
     * @return string
     */
    public function getIE()
    {
        return $this->iE;
    }

    /**
     * Sets a new iE
     *
     * Inscrição Estadual (v2.0)
     *
     * @param string $iE
     * @return self
     */
    public function setIE($iE)
    {
        $this->iE = $iE;
        return $this;
    }

    /**
     * Gets as xEnder
     *
     * Endereço completo
     *
     * @return string
     */
    public function getXEnder()
    {
        return $this->xEnder;
    }

    /**
     * Sets a new xEnder
     *
     * Endereço completo
     *
     * @param string $xEnder
     * @return self
     */
    public function setXEnder($xEnder)
    {
        $this->xEnder = $xEnder;
        return $this;
    }

    /**
     * Gets as xMun
     *
     * Nome do munícipio
     *
     * @return string
     */
    public function getXMun()
    {
        return $this->xMun;
    }

    /**
     * Sets a new xMun
     *
     * Nome do munícipio
     *
     * @param string $xMun
     * @return self
     */
    public function setXMun($xMun)
    {
        $this->xMun = $xMun;
        return $this;
    }

    /**
     * Gets as uF
     *
     * Sigla da UF
     *
     * @return string
     */
    public function getUF()
    {
        return $this->uF;
    }

    /**
     * Sets a new uF
     *
     * Sigla da UF
     *
     * @param string $uF
     * @return self
     */
    public function setUF($uF)
    {
        $this->uF = $uF;
        return $this;
    }


}

