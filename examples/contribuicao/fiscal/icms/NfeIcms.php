<?php

namespace App\Helpers\Fiscal\Icms;

class NfeIcms
{
    private $nItem;
    private $orig;
    private $cst;
    private $modBC;
    private $pRedBC;
    private $vBC;
    private $pICMS;
    private $vICMS;
    private $vICMSDeson;
    private $motDesICMS;
    private $modBCST;
    private $pMVAST;
    private $pRedBCST;
    private $vBCST;
    private $pICMSST;
    private $vICMSST;
    private $pDif = 0;
    private $vICMSDif = 0;
    private $vICMSOp = 0;
    private $vBCSTRet = 0;
    private $vICMSSTRet = 0;

    /**
     * @return mixed
     */
    public function getNItem()
    {
        return $this->nItem;
    }

    /**
     * @param mixed $nItem
     */
    public function setNItem($nItem)
    {
        $this->nItem = $nItem;
    }

    /**
     * @return mixed
     */
    public function getOrig()
    {
        return $this->orig;
    }

    /**
     * @param mixed $orig
     */
    public function setOrig($orig)
    {
        $this->orig = $orig;
    }

    /**
     * @return mixed
     */
    public function getCst()
    {
        return $this->cst;
    }

    /**
     * @param mixed $cst
     */
    public function setCst($cst)
    {
        $this->cst = $cst;
    }

    /**
     * @return mixed
     */
    public function getModBC()
    {
        return $this->modBC;
    }

    /**
     * @param mixed $modBC
     */
    public function setModBC($modBC)
    {
        $this->modBC = $modBC;
    }

    /**
     * @return mixed
     */
    public function getPRedBC()
    {
        return $this->pRedBC;
    }

    /**
     * @param mixed $pRedBC
     */
    public function setPRedBC($pRedBC)
    {
        $this->pRedBC = $pRedBC;
    }

    /**
     * @return mixed
     */
    public function getVBC()
    {
        return $this->vBC;
    }

    /**
     * @param mixed $vBC
     */
    public function setVBC($vBC)
    {
        $this->vBC = $vBC;
    }

    /**
     * @return mixed
     */
    public function getPICMS()
    {
        return $this->pICMS;
    }

    /**
     * @param mixed $pICMS
     */
    public function setPICMS($pICMS)
    {
        $this->pICMS = $pICMS;
    }

    /**
     * @return mixed
     */
    public function getVICMS()
    {
        return $this->vICMS;
    }

    /**
     * @param mixed $vICMS
     */
    public function setVICMS($vICMS)
    {
        $this->vICMS = $vICMS;
    }

    /**
     * @return mixed
     */
    public function getVICMSDeson()
    {
        return $this->vICMSDeson;
    }

    /**
     * @param mixed $vICMSDeson
     */
    public function setVICMSDeson($vICMSDeson)
    {
        $this->vICMSDeson = $vICMSDeson;
    }

    /**
     * @return mixed
     */
    public function getMotDesICMS()
    {
        return $this->motDesICMS;
    }

    /**
     * @param mixed $motDesICMS
     */
    public function setMotDesICMS($motDesICMS)
    {
        $this->motDesICMS = $motDesICMS;
    }

    /**
     * @return mixed
     */
    public function getModBCST()
    {
        return $this->modBCST;
    }

    /**
     * @param mixed $modBCST
     */
    public function setModBCST($modBCST)
    {
        $this->modBCST = $modBCST;
    }

    /**
     * @return mixed
     */
    public function getPMVAST()
    {
        return $this->pMVAST;
    }

    /**
     * @param mixed $pMVAST
     */
    public function setPMVAST($pMVAST)
    {
        $this->pMVAST = $pMVAST;
    }

    /**
     * @return mixed
     */
    public function getPRedBCST()
    {
        return $this->pRedBCST;
    }

    /**
     * @param mixed $pRedBCST
     */
    public function setPRedBCST($pRedBCST)
    {
        $this->pRedBCST = $pRedBCST;
    }

    /**
     * @return mixed
     */
    public function getVBCST()
    {
        return $this->vBCST;
    }

    /**
     * @param mixed $vBCST
     */
    public function setVBCST($vBCST)
    {
        $this->vBCST = $vBCST;
    }

    /**
     * @return mixed
     */
    public function getPICMSST()
    {
        return $this->pICMSST;
    }

    /**
     * @param mixed $pICMSST
     */
    public function setPICMSST($pICMSST)
    {
        $this->pICMSST = $pICMSST;
    }

    /**
     * @return mixed
     */
    public function getVICMSST()
    {
        return $this->vICMSST;
    }

    /**
     * @param mixed $vICMSST
     */
    public function setVICMSST($vICMSST)
    {
        $this->vICMSST = $vICMSST;
    }

    /**
     * @return int
     */
    public function getPDif()
    {
        return $this->pDif;
    }

    /**
     * @param int $pDif
     */
    public function setPDif($pDif)
    {
        $this->pDif = $pDif;
    }

    /**
     * @return int
     */
    public function getVICMSDif()
    {
        return $this->vICMSDif;
    }

    /**
     * @param int $vICMSDif
     */
    public function setVICMSDif($vICMSDif)
    {
        $this->vICMSDif = $vICMSDif;
    }

    /**
     * @return int
     */
    public function getVICMSOp()
    {
        return $this->vICMSOp;
    }

    /**
     * @param int $vICMSOp
     */
    public function setVICMSOp($vICMSOp)
    {
        $this->vICMSOp = $vICMSOp;
    }

    /**
     * @return int
     */
    public function getVBCSTRet()
    {
        return $this->vBCSTRet;
    }

    /**
     * @param int $vBCSTRet
     */
    public function setVBCSTRet($vBCSTRet)
    {
        $this->vBCSTRet = $vBCSTRet;
    }

    /**
     * @return int
     */
    public function getVICMSSTRet()
    {
        return $this->vICMSSTRet;
    }

    /**
     * @param int $vICMSSTRet
     */
    public function setVICMSSTRet($vICMSSTRet)
    {
        $this->vICMSSTRet = $vICMSSTRet;
    }

}