<?php

namespace App\Helpers\Fiscal;

/*
 * utilizado somente se diferente do endereco do remetente
 */

class NfeLocalRetirada
{
    private $cnpj;
    private $cpf;
    private $xLgr;
    private $nro;
    private $xCpl;
    private $xBairro;
    private $cMun;
    private $xMin;
    private $uf;

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
    public function getXLgr()
    {
        return $this->xLgr;
    }

    /**
     * @param mixed $xLgr
     */
    public function setXLgr($xLgr)
    {
        $this->xLgr = $xLgr;
    }

    /**
     * @return mixed
     */
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * @param mixed $nro
     */
    public function setNro($nro)
    {
        $this->nro = $nro;
    }

    /**
     * @return mixed
     */
    public function getXCpl()
    {
        return $this->xCpl;
    }

    /**
     * @param mixed $xCpl
     */
    public function setXCpl($xCpl)
    {
        $this->xCpl = $xCpl;
    }

    /**
     * @return mixed
     */
    public function getXBairro()
    {
        return $this->xBairro;
    }

    /**
     * @param mixed $xBairro
     */
    public function setXBairro($xBairro)
    {
        $this->xBairro = $xBairro;
    }

    /**
     * @return mixed
     */
    public function getCMun()
    {
        return $this->cMun;
    }

    /**
     * @param mixed $cMun
     */
    public function setCMun($cMun)
    {
        $this->cMun = $cMun;
    }

    /**
     * @return mixed
     */
    public function getXMin()
    {
        return $this->xMin;
    }

    /**
     * @param mixed $xMin
     */
    public function setXMin($xMin)
    {
        $this->xMin = $xMin;
    }

    /**
     * @return mixed
     */
    public function getUf()
    {
        return $this->uf;
    }

    /**
     * @param mixed $uf
     */
    public function setUf($uf)
    {
        $this->uf = $uf;
    }

}