<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType;

/**
 * Class representing ImpostoAType
 */
class ImpostoAType
{

    /**
     * Valor estimado total de impostos federais, estaduais e municipais
     *
     * @property string $vTotTrib
     */
    private $vTotTrib = null;

    /**
     * Dados do ICMS Normal e ST
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType
     * $iCMS
     */
    private $iCMS = null;

    /**
     * @property \NFePHP\NFe\NFe\TIpiType $iPI
     */
    private $iPI = null;

    /**
     * Dados do Imposto de Importação
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\IIAType $iI
     */
    private $iI = null;

    /**
     * ISSQN
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ISSQNAType
     * $iSSQN
     */
    private $iSSQN = null;

    /**
     * Dados do PIS
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISAType
     * $pIS
     */
    private $pIS = null;

    /**
     * Dados do PIS Substituição Tributária
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISSTAType
     * $pISST
     */
    private $pISST = null;

    /**
     * Dados do COFINS
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType
     * $cOFINS
     */
    private $cOFINS = null;

    /**
     * Dados do COFINS da
     * Substituição Tributaria;
     *
     * @property
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSSTAType
     * $cOFINSST
     */
    private $cOFINSST = null;

    /**
     * Grupo a ser informado nas vendas interestarduais para consumidor final, não
     * contribuinte de ICMS
     *
     * @property
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSUFDestAType
     * $iCMSUFDest
     */
    private $iCMSUFDest = null;

    /**
     * Gets as vTotTrib
     *
     * Valor estimado total de impostos federais, estaduais e municipais
     *
     * @return string
     */
    public function getVTotTrib()
    {
        return $this->vTotTrib;
    }

    /**
     * Sets a new vTotTrib
     *
     * Valor estimado total de impostos federais, estaduais e municipais
     *
     * @param string $vTotTrib
     * @return self
     */
    public function setVTotTrib($vTotTrib)
    {
        $this->vTotTrib = $vTotTrib;
        return $this;
    }

    /**
     * Gets as iCMS
     *
     * Dados do ICMS Normal e ST
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType
     */
    public function getICMS()
    {
        return $this->iCMS;
    }

    /**
     * Sets a new iCMS
     *
     * Dados do ICMS Normal e ST
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType
     * $iCMS
     * @return self
     */
    public function setICMS(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType $iCMS)
    {
        $this->iCMS = $iCMS;
        return $this;
    }

    /**
     * Gets as iPI
     *
     * @return \NFePHP\NFe\NFe\TIpiType
     */
    public function getIPI()
    {
        return $this->iPI;
    }

    /**
     * Sets a new iPI
     *
     * @param \NFePHP\NFe\NFe\TIpiType $iPI
     * @return self
     */
    public function setIPI(\NFePHP\NFe\NFe\TIpiType $iPI)
    {
        $this->iPI = $iPI;
        return $this;
    }

    /**
     * Gets as iI
     *
     * Dados do Imposto de Importação
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\IIAType
     */
    public function getII()
    {
        return $this->iI;
    }

    /**
     * Sets a new iI
     *
     * Dados do Imposto de Importação
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\IIAType $iI
     * @return self
     */
    public function setII(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\IIAType $iI)
    {
        $this->iI = $iI;
        return $this;
    }

    /**
     * Gets as iSSQN
     *
     * ISSQN
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ISSQNAType
     */
    public function getISSQN()
    {
        return $this->iSSQN;
    }

    /**
     * Sets a new iSSQN
     *
     * ISSQN
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ISSQNAType
     * $iSSQN
     * @return self
     */
    public function setISSQN(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ISSQNAType $iSSQN)
    {
        $this->iSSQN = $iSSQN;
        return $this;
    }

    /**
     * Gets as pIS
     *
     * Dados do PIS
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISAType
     */
    public function getPIS()
    {
        return $this->pIS;
    }

    /**
     * Sets a new pIS
     *
     * Dados do PIS
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISAType $pIS
     * @return self
     */
    public function setPIS(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISAType $pIS)
    {
        $this->pIS = $pIS;
        return $this;
    }

    /**
     * Gets as pISST
     *
     * Dados do PIS Substituição Tributária
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISSTAType
     */
    public function getPISST()
    {
        return $this->pISST;
    }

    /**
     * Sets a new pISST
     *
     * Dados do PIS Substituição Tributária
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISSTAType
     * $pISST
     * @return self
     */
    public function setPISST(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\PISSTAType $pISST)
    {
        $this->pISST = $pISST;
        return $this;
    }

    /**
     * Gets as cOFINS
     *
     * Dados do COFINS
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType
     */
    public function getCOFINS()
    {
        return $this->cOFINS;
    }

    /**
     * Sets a new cOFINS
     *
     * Dados do COFINS
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType
     * $cOFINS
     * @return self
     */
    public function setCOFINS(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType $cOFINS)
    {
        $this->cOFINS = $cOFINS;
        return $this;
    }

    /**
     * Gets as cOFINSST
     *
     * Dados do COFINS da
     * Substituição Tributaria;
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSSTAType
     */
    public function getCOFINSST()
    {
        return $this->cOFINSST;
    }

    /**
     * Sets a new cOFINSST
     *
     * Dados do COFINS da
     * Substituição Tributaria;
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSSTAType
     * $cOFINSST
     * @return self
     */
    public function setCOFINSST(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSSTAType $cOFINSST)
    {
        $this->cOFINSST = $cOFINSST;
        return $this;
    }

    /**
     * Gets as iCMSUFDest
     *
     * Grupo a ser informado nas vendas interestarduais para consumidor final, não
     * contribuinte de ICMS
     *
     * @return
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSUFDestAType
     */
    public function getICMSUFDest()
    {
        return $this->iCMSUFDest;
    }

    /**
     * Sets a new iCMSUFDest
     *
     * Grupo a ser informado nas vendas interestarduais para consumidor final, não
     * contribuinte de ICMS
     *
     * @param
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSUFDestAType
     * $iCMSUFDest
     * @return self
     */
    public function setICMSUFDest(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSUFDestAType $iCMSUFDest)
    {
        $this->iCMSUFDest = $iCMSUFDest;
        return $this;
    }


}

