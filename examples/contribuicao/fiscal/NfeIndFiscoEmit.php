<?php

namespace App\Helpers\Fiscal;

/*
 * Atenção uso exclusivo do fisco
 */
class NfeIndFiscoEmit
{

    private $cnpj;
    private $xOrgao;
    private $matr;
    private $xAgente;
    private $fone;
    private $uf;
    private $nDar;
    private $vDar;
    private $repEmi;
    private $dPag;

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
    public function getXOrgao()
    {
        return $this->xOrgao;
    }

    /**
     * @param mixed $xOrgao
     */
    public function setXOrgao($xOrgao)
    {
        $this->xOrgao = $xOrgao;
    }

    /**
     * @return mixed
     */
    public function getMatr()
    {
        return $this->matr;
    }

    /**
     * @param mixed $matr
     */
    public function setMatr($matr)
    {
        $this->matr = $matr;
    }

    /**
     * @return mixed
     */
    public function getXAgente()
    {
        return $this->xAgente;
    }

    /**
     * @param mixed $xAgente
     */
    public function setXAgente($xAgente)
    {
        $this->xAgente = $xAgente;
    }

    /**
     * @return mixed
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * @param mixed $fone
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
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

    /**
     * @return mixed
     */
    public function getNDar()
    {
        return $this->nDar;
    }

    /**
     * @param mixed $nDar
     */
    public function setNDar($nDar)
    {
        $this->nDar = $nDar;
    }

    /**
     * @return mixed
     */
    public function getVDar()
    {
        return $this->vDar;
    }

    /**
     * @param mixed $vDar
     */
    public function setVDar($vDar)
    {
        $this->vDar = $vDar;
    }

    /**
     * @return mixed
     */
    public function getRepEmi()
    {
        return $this->repEmi;
    }

    /**
     * @param mixed $repEmi
     */
    public function setRepEmi($repEmi)
    {
        $this->repEmi = $repEmi;
    }

    /**
     * @return mixed
     */
    public function getDPag()
    {
        return $this->dPag;
    }

    /**
     * @param mixed $dPag
     */
    public function setDPag($dPag)
    {
        $this->dPag = $dPag;
    }


}
