<?php

namespace App\Helpers\Fiscal;

class NfeTransp
{
    private $modFrete; //0=Por conta do emitente; 1=Por conta do destinatário/remetente; 2=Por conta de terceiros; 9=Sem Frete;
    private $cnpj;
    private $cpf;
    private $xNome;
    private $ie;
    private $xEnder;
    private $xMun;
    private $UF;

    private $placa;
    private $placa_uf;
    private $RNTC;

    private $reboque;
    private $volume;


    /**
     * @return mixed
     */
    public function getReboque()
    {
        return $this->reboque;
    }

    /**
     * @param mixed $reboque
     */
    public function setReboque($reboque)
    {
        $this->reboque = $reboque;
    }

    public function addReboque($reboque)
    {
        $this->reboque[] = $reboque;
    }

    /**
     * @return mixed
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * @param mixed $volume
     */
    public function setVolume($volume)
    {
        $this->volume = $volume;
    }

    public function addVolume($volume)
    {
        $this->volume[] = $volume;
    }


    /**
     * @return mixed
     */
    public function getModFrete()
    {
        return $this->modFrete;
    }

    /**
     * @param mixed $modFrete
     */
    public function setModFrete($modFrete)
    {
        $this->modFrete = $modFrete;
    }

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
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * @param mixed $cpf
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;
    }

    /**
     * @return mixed
     */
    public function getXNome()
    {
        return $this->xNome;
    }

    /**
     * @param mixed $xNome
     */
    public function setXNome($xNome)
    {
        $this->xNome = $xNome;
    }

    /**
     * @return mixed
     */
    public function getIe()
    {
        return $this->ie;
    }

    /**
     * @param mixed $ie
     */
    public function setIe($ie)
    {
        $this->ie = $ie;
    }

    /**
     * @return mixed
     */
    public function getXEnder()
    {
        return $this->xEnder;
    }

    /**
     * @param mixed $xEnder
     */
    public function setXEnder($xEnder)
    {
        $this->xEnder = $xEnder;
    }

    /**
     * @return mixed
     */
    public function getXMun()
    {
        return $this->xMun;
    }

    /**
     * @param mixed $xMun
     */
    public function setXMun($xMun)
    {
        $this->xMun = $xMun;
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
    public function getPlacaUf()
    {
        return $this->placa_uf;
    }

    /**
     * @param mixed $placa_uf
     */
    public function setPlacaUf($placa_uf)
    {
        $this->placa_uf = $placa_uf;
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



}