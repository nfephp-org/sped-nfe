<?php

namespace App\Helpers\Fiscal;

class NfeFaturamento
{

    private $nFatura;
    private $vOriginal;
    private $vLiquido;
    private $vDesc;
    private $duplicata;
    private $pagamentos;

    /**
     * @return mixed
     */
    public function getNFatura()
    {
        return $this->nFatura;
    }

    /**
     * @param mixed $nFatura
     */
    public function setNFatura($nFatura)
    {
        $this->nFatura = $nFatura;
    }

    /**
     * @return mixed
     */
    public function getVOriginal()
    {
        return $this->vOriginal;
    }

    /**
     * @param mixed $vOriginal
     */
    public function setVOriginal($vOriginal)
    {
        $this->vOriginal = $vOriginal;
    }

    /**
     * @return mixed
     */
    public function getVLiquido()
    {
        return $this->vLiquido;
    }

    /**
     * @param mixed $vLiquido
     */
    public function setVLiquido($vLiquido)
    {
        $this->vLiquido = $vLiquido;
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
    public function setVDesc($vDesc)
    {
        $this->vDesc = $vDesc;
    }

    /**
     * @return mixed
     */
    public function getDuplicata()
    {
        return $this->duplicata;
    }

    /**
     * @param mixed $duplicata
     */
    public function setDuplicata($duplicata)
    {
        $this->duplicata = $duplicata;
    }


    public function addDuplicata($duplicata)
    {
        $this->duplicata[] = $duplicata;
    }

    /**
     * @return mixed
     */
    public function getPagamentos()
    {
        return $this->pagamentos;
    }

    /**
     * @param mixed $pagamentos
     */
    public function setPagamentos($pagamentos)
    {
        $this->pagamentos = $pagamentos;
    }

    public function addPagamentos(\App\Helpers\Fiscal\NfePagto $pagamentos)
    {
        $this->pagamentos[] = $pagamentos;
    }



}