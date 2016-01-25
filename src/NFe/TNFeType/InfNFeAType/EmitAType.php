<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType;

/**
 * Class representing EmitAType
 */
class EmitAType
{

    /**
     * Número do CNPJ do emitente
     *
     * @property string $cNPJ
     */
    private $cNPJ = null;

    /**
     * Número do CPF do emitente
     *
     * @property string $cPF
     */
    private $cPF = null;

    /**
     * Razão Social ou Nome do emitente
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * Nome fantasia
     *
     * @property string $xFant
     */
    private $xFant = null;

    /**
     * Endereço do emitente
     *
     * @property \NFePHP\NFe\NFe\TEnderEmiType $enderEmit
     */
    private $enderEmit = null;

    /**
     * Inscrição Estadual do Emitente
     *
     * @property string $iE
     */
    private $iE = null;

    /**
     * Inscricao Estadual do Substituto Tributário
     *
     * @property string $iEST
     */
    private $iEST = null;

    /**
     * Inscrição Municipal
     *
     * @property string $iM
     */
    private $iM = null;

    /**
     * CNAE Fiscal
     *
     * @property string $cNAE
     */
    private $cNAE = null;

    /**
     * Código de Regime Tributário. 
     * Este campo será obrigatoriamente preenchido com:
     * 1 – Simples Nacional;
     * 2 – Simples Nacional – excesso de sublimite de receita bruta;
     * 3 – Regime Normal.
     *
     * @property string $cRT
     */
    private $cRT = null;

    /**
     * Gets as cNPJ
     *
     * Número do CNPJ do emitente
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
     * Número do CNPJ do emitente
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
     * Número do CPF do emitente
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
     * Número do CPF do emitente
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
     * Razão Social ou Nome do emitente
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
     * Razão Social ou Nome do emitente
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
     * Gets as xFant
     *
     * Nome fantasia
     *
     * @return string
     */
    public function getXFant()
    {
        return $this->xFant;
    }

    /**
     * Sets a new xFant
     *
     * Nome fantasia
     *
     * @param string $xFant
     * @return self
     */
    public function setXFant($xFant)
    {
        $this->xFant = $xFant;
        return $this;
    }

    /**
     * Gets as enderEmit
     *
     * Endereço do emitente
     *
     * @return \NFePHP\NFe\NFe\TEnderEmiType
     */
    public function getEnderEmit()
    {
        return $this->enderEmit;
    }

    /**
     * Sets a new enderEmit
     *
     * Endereço do emitente
     *
     * @param \NFePHP\NFe\NFe\TEnderEmiType $enderEmit
     * @return self
     */
    public function setEnderEmit(\NFePHP\NFe\NFe\TEnderEmiType $enderEmit)
    {
        $this->enderEmit = $enderEmit;
        return $this;
    }

    /**
     * Gets as iE
     *
     * Inscrição Estadual do Emitente
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
     * Inscrição Estadual do Emitente
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
     * Gets as iEST
     *
     * Inscricao Estadual do Substituto Tributário
     *
     * @return string
     */
    public function getIEST()
    {
        return $this->iEST;
    }

    /**
     * Sets a new iEST
     *
     * Inscricao Estadual do Substituto Tributário
     *
     * @param string $iEST
     * @return self
     */
    public function setIEST($iEST)
    {
        $this->iEST = $iEST;
        return $this;
    }

    /**
     * Gets as iM
     *
     * Inscrição Municipal
     *
     * @return string
     */
    public function getIM()
    {
        return $this->iM;
    }

    /**
     * Sets a new iM
     *
     * Inscrição Municipal
     *
     * @param string $iM
     * @return self
     */
    public function setIM($iM)
    {
        $this->iM = $iM;
        return $this;
    }

    /**
     * Gets as cNAE
     *
     * CNAE Fiscal
     *
     * @return string
     */
    public function getCNAE()
    {
        return $this->cNAE;
    }

    /**
     * Sets a new cNAE
     *
     * CNAE Fiscal
     *
     * @param string $cNAE
     * @return self
     */
    public function setCNAE($cNAE)
    {
        $this->cNAE = $cNAE;
        return $this;
    }

    /**
     * Gets as cRT
     *
     * Código de Regime Tributário. 
     * Este campo será obrigatoriamente preenchido com:
     * 1 – Simples Nacional;
     * 2 – Simples Nacional – excesso de sublimite de receita bruta;
     * 3 – Regime Normal.
     *
     * @return string
     */
    public function getCRT()
    {
        return $this->cRT;
    }

    /**
     * Sets a new cRT
     *
     * Código de Regime Tributário. 
     * Este campo será obrigatoriamente preenchido com:
     * 1 – Simples Nacional;
     * 2 – Simples Nacional – excesso de sublimite de receita bruta;
     * 3 – Regime Normal.
     *
     * @param string $cRT
     * @return self
     */
    public function setCRT($cRT)
    {
        $this->cRT = $cRT;
        return $this;
    }


}

