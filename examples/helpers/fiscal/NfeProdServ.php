<?php

namespace App\Helpers\Fiscal;

class NfeProdServ
{

    private $nItem;
    private $cProd;
    private $cEAN;
    private $xProd;
    private $cBenef;
    private $ncm;
    private $nve;
    private $extipi;
    private $cfop;
    private $uCom;
    private $qCom;
    private $vUnCom;
    private $vProd;
    private $cEanTrib;
    private $uTrib;
    private $qTrib;
    private $vUnTrib;
    private $vFrete;
    private $vSeg;
    private $vDesc = '';
    private $vOutro;
    private $indTot;
    // declaracao de importação
    private $nDi;
    private $dDi;
    private $xLocDesemb;
    private $UfDesemb;
    private $dDesemb;
    private $tpViaTransp;
    private $vAfrmm;
    private $tpIntermedio;
    private $cnpj;
    private $ufTerceiro;
    private $cExportador;
    private $nAdicao;
    private $nSeqAdic;
    private $cFabricante;
    private $vDescDi;
    private $nDraw;
    private $nRe;
    private $chNfe;
    private $qExport;
    // pedido de compra
    private $xPed;
    private $nItemPed;
    //grupo diversos
    private $nFci;
    private $vTotTrib;

    private $icms;
    private $crt;

    private $cofins;
    private $ipi;
    private $pis;
    private $ii;
    private $issqn;
    private $devolucao;

    private $cest;
    private $infAdProd;

    /**
     * @return mixed
     */
    public function getNItem()
    {
        return $this->nItem;
    }

    /**
     * @param mixed $nItem
     */
    public function setNItem($nItem)
    {
        $this->nItem = $nItem;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCBenef()
    {
        return $this->cBenef;
    }

    /**
     * @param mixed $cBenef
     */
    public function setCBenef($cBenef)
    {
        $this->cBenef = $cBenef;
    }

    /**
     * @return mixed
     */
    public function getCProd()
    {
        return $this->cProd;
    }

    /**
     * @param mixed $cProd
     */
    public function setCProd($cProd)
    {
        $this->cProd = $cProd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCEAN()
    {
        return $this->cEAN;
    }

    /**
     * @param mixed $cEAN
     */
    public function setCEAN($cEAN)
    {
        $this->cEAN = $cEAN;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getXProd()
    {
        return $this->xProd;
    }

    /**
     * @param mixed $xProd
     */
    public function setXProd($xProd)
    {
        $this->xProd = $xProd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNcm()
    {
        return $this->ncm;
    }

    /**
     * @param mixed $ncm
     */
    public function setNcm($ncm)
    {
        $this->ncm = $ncm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNve()
    {
        return $this->nve;
    }

    /**
     * @param mixed $nve
     */
    public function setNve($nve)
    {
        $this->nve = $nve;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtipi()
    {
        return $this->extipi;
    }

    /**
     * @param mixed $extipi
     */
    public function setExtipi($extipi)
    {
        $this->extipi = $extipi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCfop()
    {
        return $this->cfop;
    }

    /**
     * @param mixed $cfop
     */
    public function setCfop($cfop)
    {
        $this->cfop = $cfop;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUCom()
    {
        return $this->uCom;
    }

    /**
     * @param mixed $uCom
     */
    public function setUCom($uCom)
    {
        $this->uCom = $uCom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQCom()
    {
        return $this->qCom;
    }

    /**
     * @param mixed $qCom
     */
    public function setQCom($qCom)
    {
        $this->qCom = $qCom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVUnCom()
    {
        return $this->vUnCom;
    }

    /**
     * @param mixed $vUnCom
     */
    public function setVUnCom($vUnCom)
    {
        $this->vUnCom = $vUnCom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVProd()
    {
        return $this->vProd;
    }

    /**
     * @param mixed $vProd
     */
    public function setVProd($vProd)
    {
        $this->vProd = $vProd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCEanTrib()
    {
        return $this->cEanTrib;
    }

    /**
     * @param mixed $cEanTrib
     */
    public function setCEanTrib($cEanTrib)
    {
        $this->cEanTrib = $cEanTrib;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUTrib()
    {
        return $this->uTrib;
    }

    /**
     * @param mixed $uTrib
     */
    public function setUTrib($uTrib)
    {
        $this->uTrib = $uTrib;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQTrib()
    {
        return $this->qTrib;
    }

    /**
     * @param mixed $qTrib
     */
    public function setQTrib($qTrib)
    {
        $this->qTrib = $qTrib;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVUnTrib()
    {
        return $this->vUnTrib;
    }

    /**
     * @param mixed $vUnTrib
     */
    public function setVUnTrib($vUnTrib)
    {
        $this->vUnTrib = $vUnTrib;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVFrete()
    {
        return $this->vFrete;
    }

    /**
     * @param mixed $vFrete
     */
    public function setVFrete($vFrete)
    {
        $this->vFrete = $vFrete;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVSeg()
    {
        return $this->vSeg;
    }

    /**
     * @param mixed $vSeg
     */
    public function setVSeg($vSeg)
    {
        $this->vSeg = $vSeg;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVDesc()
    {
        if ($this->vDesc > 0) {
            return $this->vDesc;
        } else {
            return '';
        }

    }

    /**
     * @param mixed $vDesc
     */
    public function setVDesc($vDesc)
    {
        if ($vDesc) {
            $this->vDesc = $vDesc;
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVOutro()
    {
        return $this->vOutro;
    }

    /**
     * @param mixed $vOutro
     */
    public function setVOutro($vOutro)
    {
        $this->vOutro = $vOutro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIndTot()
    {
        return $this->indTot;
    }

    /**
     * @param mixed $indTot
     */
    public function setIndTot($indTot)
    {
        $this->indTot = $indTot;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNDi()
    {
        return $this->nDi;
    }

    /**
     * @param mixed $nDi
     */
    public function setNDi($nDi)
    {
        $this->nDi = $nDi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDDi()
    {
        return $this->dDi;
    }

    /**
     * @param mixed $dDi
     */
    public function setDDi($dDi)
    {
        $this->dDi = $dDi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getXLocDesemb()
    {
        return $this->xLocDesemb;
    }

    /**
     * @param mixed $xLocDesemb
     */
    public function setXLocDesemb($xLocDesemb)
    {
        $this->xLocDesemb = $xLocDesemb;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUfDesemb()
    {
        return $this->UfDesemb;
    }

    /**
     * @param mixed $UfDesemb
     */
    public function setUfDesemb($UfDesemb)
    {
        $this->UfDesemb = $UfDesemb;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDDesemb()
    {
        return $this->dDesemb;
    }

    /**
     * @param mixed $dDesemb
     */
    public function setDDesemb($dDesemb)
    {
        $this->dDesemb = $dDesemb;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpViaTransp()
    {
        return $this->tpViaTransp;
    }

    /**
     * @param mixed $tpViaTransp
     */
    public function setTpViaTransp($tpViaTransp)
    {
        $this->tpViaTransp = $tpViaTransp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVAfrmm()
    {
        return $this->vAfrmm;
    }

    /**
     * @param mixed $vAfrmm
     */
    public function setVAfrmm($vAfrmm)
    {
        $this->vAfrmm = $vAfrmm;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTpIntermedio()
    {
        return $this->tpIntermedio;
    }

    /**
     * @param mixed $tpIntermedio
     */
    public function setTpIntermedio($tpIntermedio)
    {
        $this->tpIntermedio = $tpIntermedio;
        return $this;
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
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUfTerceiro()
    {
        return $this->ufTerceiro;
    }

    /**
     * @param mixed $ufTerceiro
     */
    public function setUfTerceiro($ufTerceiro)
    {
        $this->ufTerceiro = $ufTerceiro;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCExportador()
    {
        return $this->cExportador;
    }

    /**
     * @param mixed $cExportador
     */
    public function setCExportador($cExportador)
    {
        $this->cExportador = $cExportador;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNAdicao()
    {
        return $this->nAdicao;
    }

    /**
     * @param mixed $nAdicao
     */
    public function setNAdicao($nAdicao)
    {
        $this->nAdicao = $nAdicao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNSeqAdic()
    {
        return $this->nSeqAdic;
    }

    /**
     * @param mixed $nSeqAdic
     */
    public function setNSeqAdic($nSeqAdic)
    {
        $this->nSeqAdic = $nSeqAdic;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCFabricante()
    {
        return $this->cFabricante;
    }

    /**
     * @param mixed $cFabricante
     */
    public function setCFabricante($cFabricante)
    {
        $this->cFabricante = $cFabricante;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVDescDi()
    {
        return $this->vDescDi;
    }

    /**
     * @param mixed $vDescDi
     */
    public function setVDescDi($vDescDi)
    {
        $this->vDescDi = $vDescDi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNDraw()
    {
        return $this->nDraw;
    }

    /**
     * @param mixed $nDraw
     */
    public function setNDraw($nDraw)
    {
        $this->nDraw = $nDraw;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNRe()
    {
        return $this->nRe;
    }

    /**
     * @param mixed $nRe
     */
    public function setNRe($nRe)
    {
        $this->nRe = $nRe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getChNfe()
    {
        return $this->chNfe;
    }

    /**
     * @param mixed $chNfe
     */
    public function setChNfe($chNfe)
    {
        $this->chNfe = $chNfe;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getQExport()
    {
        return $this->qExport;
    }

    /**
     * @param mixed $qExport
     */
    public function setQExport($qExport)
    {
        $this->qExport = $qExport;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getXPed()
    {
        return $this->xPed;
    }

    /**
     * @param mixed $xPed
     */
    public function setXPed($xPed)
    {
        $this->xPed = $xPed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNItemPed()
    {
        return $this->nItemPed;
    }

    /**
     * @param mixed $nItemPed
     */
    public function setNItemPed($nItemPed)
    {
        $this->nItemPed = $nItemPed;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNFci()
    {
        return $this->nFci;
    }

    /**
     * @param mixed $nFci
     */
    public function setNFci($nFci)
    {
        $this->nFci = $nFci;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVTotTrib()
    {
        return $this->vTotTrib;
    }

    /**
     * @param mixed $vTotTrib
     */
    public function setVTotTrib($vTotTrib)
    {
        $this->vTotTrib = $vTotTrib;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcms()
    {
        return $this->icms;
    }

    /**
     * @param mixed $icms
     */
    public function setIcms($icms)
    {
        $this->icms = $icms;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCrt()
    {
        return $this->crt;
    }

    /**
     * @param mixed $crt
     */
    public function setCrt($crt)
    {
        $this->crt = $crt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCofins()
    {
        return $this->cofins;
    }

    /**
     * @param mixed $cofins
     */
    public function setCofins($cofins)
    {
        $this->cofins = $cofins;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIpi()
    {
        return $this->ipi;
    }

    /**
     * @param mixed $ipi
     */
    public function setIpi($ipi)
    {
        $this->ipi = $ipi;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPis()
    {
        return $this->pis;
    }

    /**
     * @param mixed $pis
     */
    public function setPis($pis)
    {
        $this->pis = $pis;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIi()
    {
        return $this->ii;
    }

    /**
     * @param mixed $ii
     */
    public function setIi($ii)
    {
        $this->ii = $ii;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIssqn()
    {
        return $this->issqn;
    }

    /**
     * @param mixed $issqn
     */
    public function setIssqn($issqn)
    {
        $this->issqn = $issqn;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDevolucao()
    {
        return $this->devolucao;
    }

    /**
     * @param mixed $devolucao
     */
    public function setDevolucao($devolucao)
    {
        $this->devolucao = $devolucao;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInfAdProd()
    {
        return $this->infAdProd;
    }

    /**
     * @param mixed $infAdProd
     */
    public function setInfAdProd($infAdProd)
    {
        $this->infAdProd = $infAdProd;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCest()
    {
        return $this->cest;
    }

    /**
     * @param mixed $cest
     */
    public function setCest($cest)
    {
        $this->cest = $cest;
        return $this;
    }


}