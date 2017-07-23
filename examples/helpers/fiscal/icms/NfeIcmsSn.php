<?php

namespace App\Helpers\Fiscal\Icms;

class NfeIcmsSn
{
    private $nItem;
    private $orig;
    private $csosn;
    private $modBC;
    private $vBC;
    private $pRedBC;
    private $pICMS;
    private $vICMS;
    private $pCredSN;
    private $vCredICMSSN;
    private $modBCST;
    private $pMVAST;
    private $pRedBCST;
    private $vBCST;
    private $pICMSST;
    private $vICMSST;
    private $vBCSTRet;
    private $vICMSSTRet;
    private $vBCFCPST;
    private $pFCPST;
    private $vFCPST;
    private $vBCFCPSTRet;
    private $pFCPSTRet;
    private $vFCPSTRet;
    private $pST;
    private $vICMSDeson = 0;
    private $motDesICMS = 0;
    private $pDif = 0;
    private $vICMSDif = 0;
    private $vICMSOp = 0;

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
    public function getMotDesICMS()
    {
        return $this->motDesICMS;
    }

    /**
     * @param int $motDesICMS
     */
    public function setMotDesICMS($motDesICMS)
    {
        $this->motDesICMS = $motDesICMS;
    }


    /**
     * @return int
     */
    public function getVICMSDeson()
    {
        return $this->vICMSDeson;
    }

    /**
     * @param int $vICMSDeson
     */
    public function setVICMSDeson($vICMSDeson)
    {
        $this->vICMSDeson = $vICMSDeson;
    }



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
    public function getCsosn()
    {
        return $this->csosn;
    }

    /**
     * @param mixed $csosn
     */
    public function setCsosn($csosn)
    {
        $this->csosn = $csosn;
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
    public function getPCredSN()
    {
        return $this->pCredSN;
    }

    /**
     * @param mixed $pCredSN
     */
    public function setPCredSN($pCredSN)
    {
        $this->pCredSN = $pCredSN;
    }

    /**
     * @return mixed
     */
    public function getVCredICMSSN()
    {
        return $this->vCredICMSSN;
    }

    /**
     * @param mixed $vCredICMSSN
     */
    public function setVCredICMSSN($vCredICMSSN)
    {
        $this->vCredICMSSN = $vCredICMSSN;
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
     * @return mixed
     */
    public function getVBCSTRet()
    {
        return $this->vBCSTRet;
    }

    /**
     * @param mixed $vBCSTRet
     */
    public function setVBCSTRet($vBCSTRet)
    {
        $this->vBCSTRet = $vBCSTRet;
    }

    /**
     * @return mixed
     */
    public function getVICMSSTRet()
    {
        return $this->vICMSSTRet;
    }

    /**
     * @param mixed $vICMSSTRet
     */
    public function setVICMSSTRet($vICMSSTRet)
    {
        $this->vICMSSTRet = $vICMSSTRet;
    }

    /**
     * @return mixed
     */
    public function getVBCFCPST()
    {
        return $this->vBCFCPST;
    }

    /**
     * @param mixed $vBCFCPST
     */
    public function setVBCFCPST($vBCFCPST)
    {
        $this->vBCFCPST = $vBCFCPST;
    }

    /**
     * @return mixed
     */
    public function getPFCPST()
    {
        return $this->pFCPST;
    }

    /**
     * @param mixed $pFCPST
     */
    public function setPFCPST($pFCPST)
    {
        $this->pFCPST = $pFCPST;
    }

    /**
     * @return mixed
     */
    public function getVFCPST()
    {
        return $this->vFCPST;
    }

    /**
     * @param mixed $vFCPST
     */
    public function setVFCPST($vFCPST)
    {
        $this->vFCPST = $vFCPST;
    }

    /**
     * @return mixed
     */
    public function getVBCFCPSTRet()
    {
        return $this->vBCFCPSTRet;
    }

    /**
     * @param mixed $vBCFCPSTRet
     */
    public function setVBCFCPSTRet($vBCFCPSTRet)
    {
        $this->vBCFCPSTRet = $vBCFCPSTRet;
    }

    /**
     * @return mixed
     */
    public function getPFCPSTRet()
    {
        return $this->pFCPSTRet;
    }

    /**
     * @param mixed $pFCPSTRet
     */
    public function setPFCPSTRet($pFCPSTRet)
    {
        $this->pFCPSTRet = $pFCPSTRet;
    }

    /**
     * @return mixed
     */
    public function getVFCPSTRet()
    {
        return $this->vFCPSTRet;
    }

    /**
     * @param mixed $vFCPSTRet
     */
    public function setVFCPSTRet($vFCPSTRet)
    {
        $this->vFCPSTRet = $vFCPSTRet;
    }

    /**
     * @return mixed
     */
    public function getPST()
    {
        return $this->pST;
    }

    /**
     * @param mixed $pST
     */
    public function setPST($pST)
    {
        $this->pST = $pST;
    }



}