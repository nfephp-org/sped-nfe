<?php

namespace App\Helpers\Fiscal;

class NfeTranspReboque
{

    private $placa;
    private $UF;
    private $RNTC;
    private $vagao;
    private $balsa;

    /**
     * @return mixed
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * @param mixed $placa
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;
    }

    /**
     * @return mixed
     */
    public function getUF()
    {
        return $this->UF;
    }

    /**
     * @param mixed $UF
     */
    public function setUF($UF)
    {
        $this->UF = $UF;
    }

    /**
     * @return mixed
     */
    public function getRNTC()
    {
        return $this->RNTC;
    }

    /**
     * @param mixed $RNTC
     */
    public function setRNTC($RNTC)
    {
        $this->RNTC = $RNTC;
    }

    /**
     * @return mixed
     */
    public function getVagao()
    {
        return $this->vagao;
    }

    /**
     * @param mixed $vagao
     */
    public function setVagao($vagao)
    {
        $this->vagao = $vagao;
    }

    /**
     * @return mixed
     */
    public function getBalsa()
    {
        return $this->balsa;
    }

    /**
     * @param mixed $balsa
     */
    public function setBalsa($balsa)
    {
        $this->balsa = $balsa;
    }



}