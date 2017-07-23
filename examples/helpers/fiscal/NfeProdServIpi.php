<?php

namespace App\Helpers\Fiscal;

class NfeProdServIpi
{
    private $nItem;
    private $cst = '';
    private $clEnq;
    private $cnpjProd;
    private $cSelo;
    private $qSelo;
    private $cEnq;
    private $vBC;
    private $pIPI;
    private $qUnid;
    private $vUnid;
    private $vIPI;

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
    public function getClEnq()
    {
        return $this->clEnq;
    }

    /**
     * @param mixed $clEnq
     */
    public function setClEnq($clEnq)
    {
        $this->clEnq = $clEnq;
    }

    /**
     * @return mixed
     */
    public function getCnpjProd()
    {
        return $this->cnpjProd;
    }

    /**
     * @param mixed $cnpjProd
     */
    public function setCnpjProd($cnpjProd)
    {
        $this->cnpjProd = $cnpjProd;
    }

    /**
     * @return mixed
     */
    public function getCSelo()
    {
        return $this->cSelo;
    }

    /**
     * @param mixed $cSelo
     */
    public function setCSelo($cSelo)
    {
        $this->cSelo = $cSelo;
    }

    /**
     * @return mixed
     */
    public function getQSelo()
    {
        return $this->qSelo;
    }

    /**
     * @param mixed $qSelo
     */
    public function setQSelo($qSelo)
    {
        $this->qSelo = $qSelo;
    }

    /**
     * @return mixed
     */
    public function getCEnq()
    {
        return $this->cEnq;
    }

    /**
     * @param mixed $cEnq
     */
    public function setCEnq($cEnq)
    {
        $this->cEnq = $cEnq;
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
    public function getPIPI()
    {
        return $this->pIPI;
    }

    /**
     * @param mixed $pIPI
     */
    public function setPIPI($pIPI)
    {
        $this->pIPI = $pIPI;
    }

    /**
     * @return mixed
     */
    public function getQUnid()
    {
        return $this->qUnid;
    }

    /**
     * @param mixed $qUnid
     */
    public function setQUnid($qUnid)
    {
        $this->qUnid = $qUnid;
    }

    /**
     * @return mixed
     */
    public function getVUnid()
    {
        return $this->vUnid;
    }

    /**
     * @param mixed $vUnid
     */
    public function setVUnid($vUnid)
    {
        $this->vUnid = $vUnid;
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
    public function setVIPI($vIPI)
    {
        $this->vIPI = $vIPI;
    }



}