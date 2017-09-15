<?php

namespace App\Helpers\Fiscal;

class NfeProdServCofins
{

    private $nItem;
    private $cst;
    private $vBC;
    private $pCOFINS;
    private $vCOFINS;
    private $qBCProd;
    private $vAliqProd;

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
    public function getVBC()
    {
        if (empty($this->vBC)) {
            return 0;
        }
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
    public function getPCOFINS()
    {
        if (empty($this->pCOFINS)) {
            return 0;
        }
        return $this->pCOFINS;
    }

    /**
     * @param mixed $pCOFINS
     */
    public function setPCOFINS($pCOFINS)
    {
        $this->pCOFINS = $pCOFINS;
    }

    /**
     * @return mixed
     */
    public function getVCOFINS()
    {
        if (empty($this->vCOFINS)) {
            return 0.00;
        }
        return $this->vCOFINS;
    }

    /**
     * @param mixed $vCOFINS
     */
    public function setVCOFINS($vCOFINS)
    {
        $this->vCOFINS = $vCOFINS;
    }

    /**
     * @return mixed
     */
    public function getQBCProd()
    {
        if (empty($this->qBCProd)) {
            return '';
        }
        return $this->qBCProd;
    }

    /**
     * @param mixed $qBCProd
     */
    public function setQBCProd($qBCProd)
    {
        $this->qBCProd = $qBCProd;
    }

    /**
     * @return mixed
     */
    public function getVAliqProd()
    {
        if (empty($this->vAliqProd)) {
            return '';
        }
        return $this->vAliqProd;
    }

    /**
     * @param mixed $vAliqProd
     */
    public function setVAliqProd($vAliqProd)
    {
        $this->vAliqProd = $vAliqProd;
    }




}