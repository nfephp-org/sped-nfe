<?php

namespace App\Helpers\Fiscal;

class NfeVolume
{

    private $qVolume;
    private $especie;
    private $marca;
    private $nVolume;
    private $pesoL; // utilizar int, caso seja float irá dar erro na validação
    private $pesoB; //colocar int, caso seja flota irá dar erro na validação
    private $aLacre;

    /**
     * @return mixed
     */
    public function getQVolume()
    {
        return $this->qVolume;
    }

    /**
     * @param mixed $qVolume
     */
    public function setQVolume($qVolume)
    {
        $this->qVolume = $qVolume;
    }

    /**
     * @return mixed
     */
    public function getEspecie()
    {
        return $this->especie;
    }

    /**
     * @param mixed $especie
     */
    public function setEspecie($especie)
    {
        $this->especie = $especie;
    }

    /**
     * @return mixed
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param mixed $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return mixed
     */
    public function getNVolume()
    {
        return $this->nVolume;
    }

    /**
     * @param mixed $nVolume
     */
    public function setNVolume($nVolume)
    {
        $this->nVolume = $nVolume;
    }

    /**
     * @return mixed
     */
    public function getPesoL()
    {
        return $this->pesoL;
    }

    /**
     * @param mixed $pesoL
     */
    public function setPesoL($pesoL)
    {
        $this->pesoL = $pesoL;
    }

    /**
     * @return mixed
     */
    public function getPesoB()
    {
        return $this->pesoB;
    }

    /**
     * @param mixed $pesoB
     */
    public function setPesoB($pesoB)
    {
        $this->pesoB = $pesoB;
    }

    /**
     * @return mixed
     */
    public function getALacre()
    {
        return $this->aLacre;
    }

    /**
     * @param mixed $aLacre
     */
    public function setALacre($aLacre)
    {
        $this->aLacre = $aLacre;
    }

    public function addALacre($aLacre)
    {
        $this->aLacre[] = $aLacre;
    }



}