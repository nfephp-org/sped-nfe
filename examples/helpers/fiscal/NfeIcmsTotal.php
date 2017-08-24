<?php

namespace App\Helpers\Fiscal;

class NfeIcmsTotal
{
    private $vBC = 0.00;
    private $vICMS = 0.00;
    private $vICMSDeson = 0.00;
    private $vFCP = 0.00;
    private $vBCST = 0.00;
    private $vST = 0.00;
    private $vFCPST = 0.00;
    private $vFCPSTRet = 0.00;
    private $vProd = 0.00;
    private $vFrete = 0.00;
    private $vSeg = 0.00;
    private $vDesc = 0.00;
    private $vII = 0.00;
    private $vIPI = 0.00;
    private $vIPIDevol = 0.00;
    private $vPIS = 0.00;
    private $vCOFINS = 0.00;
    private $vOutro = 0.00;
    private $vNF = 0.00;
    private $vTotTrib = 0.00;


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
    public function sumVBC($vBC)
    {
        $this->vBC += $vBC;
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
    public function sumVICMS($vICMS)
    {
        $this->vICMS += $vICMS;
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
    public function sumVICMSDeson($vICMSDeson)
    {
        $this->vICMSDeson += $vICMSDeson;
    }

    /**
     * @return mixed
     */
    public function getVFCP()
    {
        return $this->vFCP;
    }

    /**
     * @param mixed $vFCP
     */
    public function sumVFCP($vFCP)
    {
        $this->vFCP += $vFCP;
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
    public function sumVBCST($vBCST)
    {
        $this->vBCST += $vBCST;
    }

    /**
     * @return mixed
     */
    public function getVST()
    {
        return $this->vST;
    }

    /**
     * @param mixed $vST
     */
    public function sumVST($vST)
    {
        $this->vST += $vST;
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
    public function sumVFCPST($vFCPST)
    {
        $this->vFCPST += $vFCPST;
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
    public function sumVFCPSTRet($vFCPSTRet)
    {
        $this->vFCPSTRet += $vFCPSTRet;
    }

    /**
     * @return mixed
     */
    public function getVProd()
    {
        return $this->vProd;
    }

    /**
     * @param mixed $vProd
     */
    public function sumVProd($vProd)
    {
        $this->vProd += $vProd;
    }

    /**
     * @return mixed
     */
    public function getVFrete()
    {
        return $this->vFrete;
    }

    /**
     * @param mixed $vFrete
     */
    public function sumVFrete($vFrete)
    {
        $this->vFrete += $vFrete;
    }

    /**
     * @return mixed
     */
    public function getVSeg()
    {
        return $this->vSeg;
    }

    /**
     * @param mixed $vSeg
     */
    public function sumVSeg($vSeg)
    {
        $this->vSeg += $vSeg;
    }

    /**
     * @return mixed
     */
    public function getVDesc()
    {
        return $this->vDesc;
    }

    /**
     * @param mixed $vDesc
     */
    public function sumVDesc($vDesc)
    {
        $this->vDesc += $vDesc;
    }

    /**
     * @return mixed
     */
    public function getVII()
    {
        return $this->vII;
    }

    /**
     * @param mixed $vII
     */
    public function sumVII($vII)
    {
        $this->vII += $vII;
    }

    /**
     * @return mixed
     */
    public function getVIPI()
    {
        return $this->vIPI;
    }

    /**
     * @param mixed $vIPI
     */
    public function sumVIPI($vIPI)
    {
        $this->vIPI += $vIPI;
    }

    /**
     * @return mixed
     */
    public function getVIPIDevol()
    {
        return $this->vIPIDevol;
    }

    /**
     * @param mixed $vIPIDevol
     */
    public function sumVIPIDevol($vIPIDevol)
    {
        $this->vIPIDevol += $vIPIDevol;
    }

    /**
     * @return mixed
     */
    public function getVPIS()
    {
        if (empty($this->vPIS)) {
            return 0.00;
        }
        return number_format($this->vPIS, 2, '.', '');
    }

    /**
     * @param mixed $vPIS
     */
    public function sumVPIS($vPIS)
    {
        $this->vPIS += $vPIS;
    }

    /**
     * @return mixed
     */
    public function getVCOFINS()
    {
        if (empty($this->vCOFINS)) {
            return 0.00;
        }
        return number_format($this->vCOFINS, 2, '.', '');
    }

    /**
     * @param mixed $vCOFINS
     */
    public function sumVCOFINS($vCOFINS)
    {
        $this->vCOFINS += $vCOFINS;
    }

    /**
     * @return mixed
     */
    public function getVOutro()
    {
        if (empty($this->vOutro)) {
            return 0.00;
        }
        return $this->vOutro;
    }

    /**
     * @param mixed $vOutro
     */
    public function sumVOutro($vOutro)
    {
        $this->vOutro += $vOutro;
    }

    /**
     * @return mixed
     */
    public function getVNF()
    {
        return $this->vNF;
    }

    /**
     * @param mixed $vNF
     */
    public function sumVNF($vNF)
    {
        $this->vNF += $vNF;
    }

    /**
     * @return mixed
     */
    public function getVTotTrib()
    {
        return $this->vTotTrib;
    }

    /**
     * @param mixed $vTotTrib
     */
    public function sumVTotTrib($vTotTrib)
    {
        $this->vTotTrib += $vTotTrib;
    }

    /**
     * @param mixed $vBC
     */
    public function setVBC($vBC)
    {
        $this->vBC = $vBC;
    }

    /**
     * @param mixed $vICMS
     */
    public function setVICMS($vICMS)
    {
        $this->vICMS = $vICMS;
    }

    /**
     * @param mixed $vICMSDeson
     */
    public function setVICMSDeson($vICMSDeson)
    {
        $this->vICMSDeson = $vICMSDeson;
    }

    /**
     * @param mixed $vFCP
     */
    public function setVFCP($vFCP)
    {
        $this->vFCP = $vFCP;
    }

    /**
     * @param mixed $vBCST
     */
    public function setVBCST($vBCST)
    {
        $this->vBCST = $vBCST;
    }

    /**
     * @param mixed $vST
     */
    public function setVST($vST)
    {
        $this->vST = $vST;
    }

    /**
     * @param mixed $vFCPST
     */
    public function setVFCPST($vFCPST)
    {
        $this->vFCPST = $vFCPST;
    }

    /**
     * @param mixed $vFCPSTRet
     */
    public function setVFCPSTRet($vFCPSTRet)
    {
        $this->vFCPSTRet = $vFCPSTRet;
    }

    /**
     * @param mixed $vProd
     */
    public function setVProd($vProd)
    {
        $this->vProd = $vProd;
    }

    /**
     * @param mixed $vFrete
     */
    public function setVFrete($vFrete)
    {
        $this->vFrete = $vFrete;
    }

    /**
     * @param mixed $vSeg
     */
    public function setVSeg($vSeg)
    {
        $this->vSeg = $vSeg;
    }

    /**
     * @param mixed $vDesc
     */
    public function setVDesc($vDesc)
    {
        $this->vDesc = $vDesc;
    }

    /**
     * @param mixed $vII
     */
    public function setVII($vII)
    {
        $this->vII = $vII;
    }

    /**
     * @param mixed $vIPI
     */
    public function setVIPI($vIPI)
    {
        $this->vIPI = $vIPI;
    }

    /**
     * @param mixed $vIPIDevol
     */
    public function setVIPIDevol($vIPIDevol)
    {
        $this->vIPIDevol = $vIPIDevol;
    }

    /**
     * @param mixed $vPIS
     */
    public function setVPIS($vPIS)
    {
        $this->vPIS = $vPIS;
    }

    /**
     * @param mixed $vCOFINS
     */
    public function setVCOFINS($vCOFINS)
    {
        $this->vCOFINS = $vCOFINS;
    }

    /**
     * @param mixed $vOutro
     */
    public function setVOutro($vOutro)
    {
        $this->vOutro = $vOutro;
    }

    /**
     * @param mixed $vNF
     */
    public function setVNF($vNF)
    {
        $this->vNF = $vNF;
    }

    /**
     * @param mixed $vTotTrib
     */
    public function setVTotTrib($vTotTrib)
    {
        $this->vTotTrib = $vTotTrib;
    }




}