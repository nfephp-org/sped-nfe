<?php

namespace App\Helpers\Fiscal;

class NfeIde
{

    private $cUf; // codigo uf
    private $cNf; //codigo nota fiscal
    private $natOp; //descricao natureza da operacao
    private $indPag;
    private $mod; //55 nf-e emitida em substituição ao modelo 1 ou 1A; 65 = nfc-e utilizada nas operacoes de venda no varejo;
    private $serie; //serie do documento fiscal, preencher com zeros na hiótese de a nf-e nao possuir serie;
    private $nNf;
    private $dhEmi;
    private $dhSaiEnt;
    private $tpNf;
    private $idDest;
    private $cMunFg; // codgo do municio de ocorrencia do fato gerador
    private $tpImp;
    private $tpEmis;
    private $cDv;
    private $tpAmb;
    private $finNFe;
    private $indFinal; //1- nfe normal; 2- nfe complementar; 3 - nfe de ajuste; 4 - devolucao de mercadoria;
    private $indPres; // 0=Não se aplica (por exemplo, Nota Fiscal complementar ou de ajuste); 1=Operação presencial; 2=Operação não presencial, pela Internet; 3=Operação não presencial, Teleatendimento; 4=NFC-e em operação com entrega a domicílio; 5=Operação presencial, fora do estabelecimento; 9=Operação não presencial, outros.
    private $procEmi;
    private $verProc;
    private $dhCont;
    private $xJust;

    /**
     * @return mixed
     */
    public function getCUf()
    {
        return $this->cUf;
    }

    /**
     * @param mixed $cUf
     */
    public function setCUf($cUf)
    {
        $this->cUf = $cUf;
    }

    /**
     * @return mixed
     */
    public function getCNf()
    {
        return $this->cNf;
    }

    /**
     * @param mixed $cNf
     */
    public function setCNf($cNf)
    {
        $this->cNf = $cNf;
    }

    /**
     * @return mixed
     */
    public function getNatOp()
    {
        return $this->natOp;
    }

    /**
     * @param mixed $natOp
     */
    public function setNatOp($natOp)
    {
        $this->natOp = $natOp;
    }

    /**
     * @return mixed
     */
    public function getIndPag()
    {
        return $this->indPag;
    }

    /**
     * @param mixed $indPag
     */
    public function setIndPag($indPag)
    {
        $this->indPag = $indPag;
    }

    /**
     * @return mixed
     */
    public function getMod()
    {
        return $this->mod;
    }

    /**
     * @param mixed $mod
     */
    public function setMod($mod)
    {
        $this->mod = $mod;
    }

    /**
     * @return mixed
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * @param mixed $serie
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }

    /**
     * @return mixed
     */
    public function getNNf()
    {
        return $this->nNf;
    }

    /**
     * @param mixed $nNf
     */
    public function setNNf($nNf)
    {
        $this->nNf = $nNf;
    }

    /**
     * @return mixed
     */
    public function getDhEmi()
    {
        return $this->dhEmi;
    }

    /**
     * @param mixed $dhEmi
     */
    public function setDhEmi($dhEmi)
    {
        $this->dhEmi = $dhEmi;
    }

    /**
     * @return mixed
     */
    public function getDhSaiEnt()
    {
        return $this->dhSaiEnt;
    }

    /**
     * @param mixed $dhSaiEnt
     */
    public function setDhSaiEnt($dhSaiEnt)
    {
        $this->dhSaiEnt = $dhSaiEnt;
    }

    /**
     * @return mixed
     */
    public function getTpNf()
    {
        return $this->tpNf;
    }

    /**
     * @param mixed $tpNf
     */
    public function setTpNf($tpNf)
    {
        $this->tpNf = $tpNf;
    }

    /**
     * @return mixed
     */
    public function getIdDest()
    {
        return $this->idDest;
    }

    /**
     * @param mixed $idDest
     */
    public function setIdDest($idDest)
    {
        $this->idDest = $idDest;
    }

    /**
     * @return mixed
     */
    public function getCMunFg()
    {
        return $this->cMunFg;
    }

    /**
     * @param mixed $cMunFg
     */
    public function setCMunFg($cMunFg)
    {
        $this->cMunFg = $cMunFg;
    }

    /**
     * @return mixed
     */
    public function getTpImp()
    {
        return $this->tpImp;
    }

    /**
     * @param mixed $tpImp
     */
    public function setTpImp($tpImp)
    {
        $this->tpImp = $tpImp;
    }

    /**
     * @return mixed
     */
    public function getTpEmis()
    {
        return $this->tpEmis;
    }

    /**
     * @param mixed $tpEmis
     */
    public function setTpEmis($tpEmis)
    {
        $this->tpEmis = $tpEmis;
    }

    /**
     * @return mixed
     */
    public function getCDv()
    {
        return $this->cDv;
    }

    /**
     * @param mixed $cDv
     */
    public function setCDv($cDv)
    {
        $this->cDv = $cDv;
    }

    /**
     * @return mixed
     */
    public function getTpAmb()
    {
        return $this->tpAmb;
    }

    /**
     * @param mixed $tpAmb
     */
    public function setTpAmb($tpAmb)
    {
        $this->tpAmb = $tpAmb;
    }

    /**
     * @return mixed
     */
    public function getFinNFe()
    {
        return $this->finNFe;
    }

    /**
     * @param mixed $finNFe
     */
    public function setFinNFe($finNFe)
    {
        $this->finNFe = $finNFe;
    }

    /**
     * @return mixed
     */
    public function getIndFinal()
    {
        return $this->indFinal;
    }

    /**
     * @param mixed $indFinal
     */
    public function setIndFinal($indFinal)
    {
        $this->indFinal = $indFinal;
    }

    /**
     * @return mixed
     */
    public function getIndPres()
    {
        return $this->indPres;
    }

    /**
     * @param mixed $indPres
     */
    public function setIndPres($indPres)
    {
        $this->indPres = $indPres;
    }

    /**
     * @return mixed
     */
    public function getProcEmi()
    {
        return $this->procEmi;
    }

    /**
     * @param mixed $procEmi
     */
    public function setProcEmi($procEmi)
    {
        $this->procEmi = $procEmi;
    }

    /**
     * @return mixed
     */
    public function getVerProc()
    {
        return $this->verProc;
    }

    /**
     * @param mixed $verProc
     */
    public function setVerProc($verProc)
    {
        $this->verProc = $verProc;
    }

    /**
     * @return mixed
     */
    public function getDhCont()
    {
        return $this->dhCont;
    }

    /**
     * @param mixed $dhCont
     */
    public function setDhCont($dhCont)
    {
        $this->dhCont = $dhCont;
    }

    /**
     * @return mixed
     */
    public function getXJust()
    {
        return $this->xJust;
    }

    /**
     * @param mixed $xJust
     */
    public function setXJust($xJust)
    {
        $this->xJust = $xJust;
    }



}
