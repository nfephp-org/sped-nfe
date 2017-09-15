<?php

namespace App\Helpers\Fiscal;

class NfeDuplicata
{

    private $cDuplicata;
    private $dVencimento;
    private $vDuplicata;

    /**
     * @return mixed
     */
    public function getCDuplicata()
    {
        return $this->cDuplicata;
    }

    /**
     * @param mixed $cDuplicata
     */
    public function setCDuplicata($cDuplicata)
    {
        $this->cDuplicata = $cDuplicata;
    }

    /**
     * @return mixed
     */
    public function getDVencimento()
    {
        return $this->dVencimento;
    }

    /**
     * @param mixed $dVencimento
     */
    public function setDVencimento($dVencimento)
    {
        $this->dVencimento = $dVencimento;
    }

    /**
     * @return mixed
     */
    public function getVDuplicata()
    {
        return $this->vDuplicata;
    }

    /**
     * @param mixed $vDuplicata
     */
    public function setVDuplicata($vDuplicata)
    {
        $this->vDuplicata = $vDuplicata;
    }



}