<?php

namespace App\Helpers\Fiscal;

class NfeCard
{
    private $cnpj;
    private $tBand;
    private $cAut;
    private $tpIntegra;

    /**
     * @return mixed
     */
    public function getCnpj()
    {
        return $this->cnpj;
    }

    /**
     * @param mixed $cnpj
     */
    public function setCnpj($cnpj)
    {
        $this->cnpj = $cnpj;
    }

    /**
     * @return mixed
     */
    public function getTBand()
    {
        return $this->tBand;
    }

    /**
     * @param mixed $tBand
     */
    public function setTBand($tBand)
    {
        $this->tBand = $tBand;
    }

    /**
     * @return mixed
     */
    public function getCAut()
    {
        return $this->cAut;
    }

    /**
     * @param mixed $cAut
     */
    public function setCAut($cAut)
    {
        $this->cAut = $cAut;
    }

    /**
     * @return mixed
     */
    public function getTpIntegra()
    {
        return $this->tpIntegra;
    }

    /**
     * @param mixed $tpIntegra
     */
    public function setTpIntegra($tpIntegra)
    {
        $this->tpIntegra = $tpIntegra;
    }





}