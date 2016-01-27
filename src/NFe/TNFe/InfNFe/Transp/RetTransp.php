<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Transp;

/**
 * Class representing RetTransp
 */
class RetTransp
{

    /**
     * Valor do Serviço
     *
     * @property string $vServ
     */
    private $vServ = null;

    /**
     * BC da Retenção do ICMS
     *
     * @property string $vBCRet
     */
    private $vBCRet = null;

    /**
     * Alíquota da Retenção
     *
     * @property string $pICMSRet
     */
    private $pICMSRet = null;

    /**
     * Valor do ICMS Retido
     *
     * @property string $vICMSRet
     */
    private $vICMSRet = null;

    /**
     * Código Fiscal de Operações e Prestações // PL_006f - alterado para permitir
     * somente CFOP de transportes
     *
     * @property string $cFOP
     */
    private $cFOP = null;

    /**
     * Código do Município de Ocorrência do Fato Gerador (utilizar a tabela do IBGE)
     *
     * @property string $cMunFG
     */
    private $cMunFG = null;

    /**
     * Gets as vServ
     *
     * Valor do Serviço
     *
     * @return string
     */
    public function getVServ()
    {
        return $this->vServ;
    }

    /**
     * Sets a new vServ
     *
     * Valor do Serviço
     *
     * @param string $vServ
     * @return self
     */
    public function setVServ($vServ)
    {
        $this->vServ = $vServ;
        return $this;
    }

    /**
     * Gets as vBCRet
     *
     * BC da Retenção do ICMS
     *
     * @return string
     */
    public function getVBCRet()
    {
        return $this->vBCRet;
    }

    /**
     * Sets a new vBCRet
     *
     * BC da Retenção do ICMS
     *
     * @param string $vBCRet
     * @return self
     */
    public function setVBCRet($vBCRet)
    {
        $this->vBCRet = $vBCRet;
        return $this;
    }

    /**
     * Gets as pICMSRet
     *
     * Alíquota da Retenção
     *
     * @return string
     */
    public function getPICMSRet()
    {
        return $this->pICMSRet;
    }

    /**
     * Sets a new pICMSRet
     *
     * Alíquota da Retenção
     *
     * @param string $pICMSRet
     * @return self
     */
    public function setPICMSRet($pICMSRet)
    {
        $this->pICMSRet = $pICMSRet;
        return $this;
    }

    /**
     * Gets as vICMSRet
     *
     * Valor do ICMS Retido
     *
     * @return string
     */
    public function getVICMSRet()
    {
        return $this->vICMSRet;
    }

    /**
     * Sets a new vICMSRet
     *
     * Valor do ICMS Retido
     *
     * @param string $vICMSRet
     * @return self
     */
    public function setVICMSRet($vICMSRet)
    {
        $this->vICMSRet = $vICMSRet;
        return $this;
    }

    /**
     * Gets as cFOP
     *
     * Código Fiscal de Operações e Prestações // PL_006f - alterado para permitir
     * somente CFOP de transportes
     *
     * @return string
     */
    public function getCFOP()
    {
        return $this->cFOP;
    }

    /**
     * Sets a new cFOP
     *
     * Código Fiscal de Operações e Prestações // PL_006f - alterado para permitir
     * somente CFOP de transportes
     *
     * @param string $cFOP
     * @return self
     */
    public function setCFOP($cFOP)
    {
        $this->cFOP = $cFOP;
        return $this;
    }

    /**
     * Gets as cMunFG
     *
     * Código do Município de Ocorrência do Fato Gerador (utilizar a tabela do IBGE)
     *
     * @return string
     */
    public function getCMunFG()
    {
        return $this->cMunFG;
    }

    /**
     * Sets a new cMunFG
     *
     * Código do Município de Ocorrência do Fato Gerador (utilizar a tabela do IBGE)
     *
     * @param string $cMunFG
     * @return self
     */
    public function setCMunFG($cMunFG)
    {
        $this->cMunFG = $cMunFG;
        return $this;
    }


}

