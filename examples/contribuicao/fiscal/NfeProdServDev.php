<?php

namespace App\Helpers\Fiscal;

class NfeProdServDev
{

    private $impostoDevol; // informacao de imposto devolvido
    private $pDevol;
    private $ipi;
    private $vIpiDevol;

    /**
     * @return mixed
     */
    public function getImpostoDevol()
    {
        return $this->impostoDevol;
    }

    /**
     * @param mixed $impostoDevol
     */
    public function setImpostoDevol($impostoDevol)
    {
        $this->impostoDevol = $impostoDevol;
    }

    /**
     * @return mixed
     */
    public function getPDevol()
    {
        return $this->pDevol;
    }

    /**
     * @param mixed $pDevol
     */
    public function setPDevol($pDevol)
    {
        $this->pDevol = $pDevol;
    }

    /**
     * @return mixed
     */
    public function getIpi()
    {
        return $this->ipi;
    }

    /**
     * @param mixed $ipi
     */
    public function setIpi($ipi)
    {
        $this->ipi = $ipi;
    }

    /**
     * @return mixed
     */
    public function getVIpiDevol()
    {
        return $this->vIpiDevol;
    }

    /**
     * @param mixed $vIpiDevol
     */
    public function setVIpiDevol($vIpiDevol)
    {
        $this->vIpiDevol = $vIpiDevol;
    }




}