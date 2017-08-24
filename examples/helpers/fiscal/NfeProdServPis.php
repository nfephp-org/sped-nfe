<?php

namespace App\Helpers\Fiscal;

class NfeProdServPis
{
    private $nItem;
    private $cst;
    private $vBC = 0.00;
    private $pPIS = '';
    private $vPIS;
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
            return 0.00;
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
    public function getPPIS()
    {
        if (empty($this->pPIS)) {
            return 0.00;
        }
        return $this->pPIS;
    }

    /**
     * @param mixed $pPIS
     */
    public function setPPIS($pPIS)
    {
        $this->pPIS = $pPIS;
    }

    /**
     * @return mixed
     */
    public function getVPIS()
    {
        if (empty($this->vPis)) {
            return 0.00;
        }
        return $this->vPIS;
    }

    /**
     * @param mixed $vPIS
     */
    public function setVPIS($vPIS)
    {
        $this->vPIS = $vPIS;
    }

    /**
     * @return mixed
     */
    public function getQBCProd()
    {
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