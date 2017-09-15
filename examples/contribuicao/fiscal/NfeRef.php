<?php

namespace App\Helpers\Fiscal;

class NfeRef
{
    // grupo de documento referenciado
    private $refNfe; //Informação da NF modelo 1/1A referenciada
    private $refNfCUf;
    private $refNfAaMm; // ano mes
    private $refCnpj;
    private $refMod;
    private $refSerie;
    private $refNNf;
    // informacoes de nfe de produtor rural referenciada
    private $retNFPCUf;
    private $retNFPAaMm;
    private $retNFPCnpj;
    private $retNFPMod;
    private $retNFPSerie;
    private $retNFPNNf;
    private $retNFPRefCte;
    // informaçoes de nfce
    private $refECFMod;
    private $refECFNEcf;
    private $refECFCoo;

    /**
     * @return mixed
     */
    public function getRefNfe()
    {
        return $this->refNfe;
    }

    /**
     * @param mixed $refNfe
     */
    public function setRefNfe($refNfe)
    {
        $this->refNfe = $refNfe;
    }

    /**
     * @return mixed
     */
    public function getRefNfCUf()
    {
        return $this->refNfCUf;
    }

    /**
     * @param mixed $refNfCUf
     */
    public function setRefNfCUf($refNfCUf)
    {
        $this->refNfCUf = $refNfCUf;
    }

    /**
     * @return mixed
     */
    public function getRefNfAaMm()
    {
        return $this->refNfAaMm;
    }

    /**
     * @param mixed $refNfAaMm
     */
    public function setRefNfAaMm($refNfAaMm)
    {
        $this->refNfAaMm = $refNfAaMm;
    }

    /**
     * @return mixed
     */
    public function getRefCnpj()
    {
        return $this->refCnpj;
    }

    /**
     * @param mixed $refCnpj
     */
    public function setRefCnpj($refCnpj)
    {
        $this->refCnpj = $refCnpj;
    }

    /**
     * @return mixed
     */
    public function getRefMod()
    {
        return $this->refMod;
    }

    /**
     * @param mixed $refMod
     */
    public function setRefMod($refMod)
    {
        $this->refMod = $refMod;
    }

    /**
     * @return mixed
     */
    public function getRefSerie()
    {
        return $this->refSerie;
    }

    /**
     * @param mixed $refSerie
     */
    public function setRefSerie($refSerie)
    {
        $this->refSerie = $refSerie;
    }

    /**
     * @return mixed
     */
    public function getRefNNf()
    {
        return $this->refNNf;
    }

    /**
     * @param mixed $refNNf
     */
    public function setRefNNf($refNNf)
    {
        $this->refNNf = $refNNf;
    }

    /**
     * @return mixed
     */
    public function getRetNFPCUf()
    {
        return $this->retNFPCUf;
    }

    /**
     * @param mixed $retNFPCUf
     */
    public function setRetNFPCUf($retNFPCUf)
    {
        $this->retNFPCUf = $retNFPCUf;
    }

    /**
     * @return mixed
     */
    public function getRetNFPAaMm()
    {
        return $this->retNFPAaMm;
    }

    /**
     * @param mixed $retNFPAaMm
     */
    public function setRetNFPAaMm($retNFPAaMm)
    {
        $this->retNFPAaMm = $retNFPAaMm;
    }

    /**
     * @return mixed
     */
    public function getRetNFPCnpj()
    {
        return $this->retNFPCnpj;
    }

    /**
     * @param mixed $retNFPCnpj
     */
    public function setRetNFPCnpj($retNFPCnpj)
    {
        $this->retNFPCnpj = $retNFPCnpj;
    }

    /**
     * @return mixed
     */
    public function getRetNFPMod()
    {
        return $this->retNFPMod;
    }

    /**
     * @param mixed $retNFPMod
     */
    public function setRetNFPMod($retNFPMod)
    {
        $this->retNFPMod = $retNFPMod;
    }

    /**
     * @return mixed
     */
    public function getRetNFPSerie()
    {
        return $this->retNFPSerie;
    }

    /**
     * @param mixed $retNFPSerie
     */
    public function setRetNFPSerie($retNFPSerie)
    {
        $this->retNFPSerie = $retNFPSerie;
    }

    /**
     * @return mixed
     */
    public function getRetNFPNNf()
    {
        return $this->retNFPNNf;
    }

    /**
     * @param mixed $retNFPNNf
     */
    public function setRetNFPNNf($retNFPNNf)
    {
        $this->retNFPNNf = $retNFPNNf;
    }

    /**
     * @return mixed
     */
    public function getRetNFPRefCte()
    {
        return $this->retNFPRefCte;
    }

    /**
     * @param mixed $retNFPRefCte
     */
    public function setRetNFPRefCte($retNFPRefCte)
    {
        $this->retNFPRefCte = $retNFPRefCte;
    }

    /**
     * @return mixed
     */
    public function getRefECFMod()
    {
        return $this->refECFMod;
    }

    /**
     * @param mixed $refECFMod
     */
    public function setRefECFMod($refECFMod)
    {
        $this->refECFMod = $refECFMod;
    }

    /**
     * @return mixed
     */
    public function getRefECFNEcf()
    {
        return $this->refECFNEcf;
    }

    /**
     * @param mixed $refECFNEcf
     */
    public function setRefECFNEcf($refECFNEcf)
    {
        $this->refECFNEcf = $refECFNEcf;
    }

    /**
     * @return mixed
     */
    public function getRefECFCoo()
    {
        return $this->refECFCoo;
    }

    /**
     * @param mixed $refECFCoo
     */
    public function setRefECFCoo($refECFCoo)
    {
        $this->refECFCoo = $refECFCoo;
    }






}