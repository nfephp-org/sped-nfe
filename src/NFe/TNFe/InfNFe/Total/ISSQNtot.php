<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Total;

/**
 * Class representing ISSQNtot
 */
class ISSQNtot
{

    /**
     * Valor Total dos Serviços sob não-incidência ou não tributados pelo ICMS
     *
     * @property string $vServ
     */
    private $vServ = null;

    /**
     * Base de Cálculo do ISS
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Valor Total do ISS
     *
     * @property string $vISS
     */
    private $vISS = null;

    /**
     * Valor do PIS sobre serviços
     *
     * @property string $vPIS
     */
    private $vPIS = null;

    /**
     * Valor do COFINS sobre serviços
     *
     * @property string $vCOFINS
     */
    private $vCOFINS = null;

    /**
     * Data da prestação do serviço (AAAA-MM-DD)
     *
     * @property string $dCompet
     */
    private $dCompet = null;

    /**
     * Valor dedução para redução da base de cálculo
     *
     * @property string $vDeducao
     */
    private $vDeducao = null;

    /**
     * Valor outras retenções
     *
     * @property string $vOutro
     */
    private $vOutro = null;

    /**
     * Valor desconto incondicionado
     *
     * @property string $vDescIncond
     */
    private $vDescIncond = null;

    /**
     * Valor desconto condicionado
     *
     * @property string $vDescCond
     */
    private $vDescCond = null;

    /**
     * Valor Total Retenção ISS
     *
     * @property string $vISSRet
     */
    private $vISSRet = null;

    /**
     * Código do regime especial de tributação
     *
     * @property string $cRegTrib
     */
    private $cRegTrib = null;

    /**
     * Gets as vServ
     *
     * Valor Total dos Serviços sob não-incidência ou não tributados pelo ICMS
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
     * Valor Total dos Serviços sob não-incidência ou não tributados pelo ICMS
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
     * Gets as vBC
     *
     * Base de Cálculo do ISS
     *
     * @return string
     */
    public function getVBC()
    {
        return $this->vBC;
    }

    /**
     * Sets a new vBC
     *
     * Base de Cálculo do ISS
     *
     * @param string $vBC
     * @return self
     */
    public function setVBC($vBC)
    {
        $this->vBC = $vBC;
        return $this;
    }

    /**
     * Gets as vISS
     *
     * Valor Total do ISS
     *
     * @return string
     */
    public function getVISS()
    {
        return $this->vISS;
    }

    /**
     * Sets a new vISS
     *
     * Valor Total do ISS
     *
     * @param string $vISS
     * @return self
     */
    public function setVISS($vISS)
    {
        $this->vISS = $vISS;
        return $this;
    }

    /**
     * Gets as vPIS
     *
     * Valor do PIS sobre serviços
     *
     * @return string
     */
    public function getVPIS()
    {
        return $this->vPIS;
    }

    /**
     * Sets a new vPIS
     *
     * Valor do PIS sobre serviços
     *
     * @param string $vPIS
     * @return self
     */
    public function setVPIS($vPIS)
    {
        $this->vPIS = $vPIS;
        return $this;
    }

    /**
     * Gets as vCOFINS
     *
     * Valor do COFINS sobre serviços
     *
     * @return string
     */
    public function getVCOFINS()
    {
        return $this->vCOFINS;
    }

    /**
     * Sets a new vCOFINS
     *
     * Valor do COFINS sobre serviços
     *
     * @param string $vCOFINS
     * @return self
     */
    public function setVCOFINS($vCOFINS)
    {
        $this->vCOFINS = $vCOFINS;
        return $this;
    }

    /**
     * Gets as dCompet
     *
     * Data da prestação do serviço (AAAA-MM-DD)
     *
     * @return string
     */
    public function getDCompet()
    {
        return $this->dCompet;
    }

    /**
     * Sets a new dCompet
     *
     * Data da prestação do serviço (AAAA-MM-DD)
     *
     * @param string $dCompet
     * @return self
     */
    public function setDCompet($dCompet)
    {
        $this->dCompet = $dCompet;
        return $this;
    }

    /**
     * Gets as vDeducao
     *
     * Valor dedução para redução da base de cálculo
     *
     * @return string
     */
    public function getVDeducao()
    {
        return $this->vDeducao;
    }

    /**
     * Sets a new vDeducao
     *
     * Valor dedução para redução da base de cálculo
     *
     * @param string $vDeducao
     * @return self
     */
    public function setVDeducao($vDeducao)
    {
        $this->vDeducao = $vDeducao;
        return $this;
    }

    /**
     * Gets as vOutro
     *
     * Valor outras retenções
     *
     * @return string
     */
    public function getVOutro()
    {
        return $this->vOutro;
    }

    /**
     * Sets a new vOutro
     *
     * Valor outras retenções
     *
     * @param string $vOutro
     * @return self
     */
    public function setVOutro($vOutro)
    {
        $this->vOutro = $vOutro;
        return $this;
    }

    /**
     * Gets as vDescIncond
     *
     * Valor desconto incondicionado
     *
     * @return string
     */
    public function getVDescIncond()
    {
        return $this->vDescIncond;
    }

    /**
     * Sets a new vDescIncond
     *
     * Valor desconto incondicionado
     *
     * @param string $vDescIncond
     * @return self
     */
    public function setVDescIncond($vDescIncond)
    {
        $this->vDescIncond = $vDescIncond;
        return $this;
    }

    /**
     * Gets as vDescCond
     *
     * Valor desconto condicionado
     *
     * @return string
     */
    public function getVDescCond()
    {
        return $this->vDescCond;
    }

    /**
     * Sets a new vDescCond
     *
     * Valor desconto condicionado
     *
     * @param string $vDescCond
     * @return self
     */
    public function setVDescCond($vDescCond)
    {
        $this->vDescCond = $vDescCond;
        return $this;
    }

    /**
     * Gets as vISSRet
     *
     * Valor Total Retenção ISS
     *
     * @return string
     */
    public function getVISSRet()
    {
        return $this->vISSRet;
    }

    /**
     * Sets a new vISSRet
     *
     * Valor Total Retenção ISS
     *
     * @param string $vISSRet
     * @return self
     */
    public function setVISSRet($vISSRet)
    {
        $this->vISSRet = $vISSRet;
        return $this;
    }

    /**
     * Gets as cRegTrib
     *
     * Código do regime especial de tributação
     *
     * @return string
     */
    public function getCRegTrib()
    {
        return $this->cRegTrib;
    }

    /**
     * Sets a new cRegTrib
     *
     * Código do regime especial de tributação
     *
     * @param string $cRegTrib
     * @return self
     */
    public function setCRegTrib($cRegTrib)
    {
        $this->cRegTrib = $cRegTrib;
        return $this;
    }


}

