<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType;

/**
 * Class representing AvulsaAType
 */
class AvulsaAType
{

    /**
     * CNPJ do Órgão emissor
     *
     * @property string $cNPJ
     */
    private $cNPJ = null;

    /**
     * Órgão emitente
     *
     * @property string $xOrgao
     */
    private $xOrgao = null;

    /**
     * Matrícula do agente
     *
     * @property string $matr
     */
    private $matr = null;

    /**
     * Nome do agente
     *
     * @property string $xAgente
     */
    private $xAgente = null;

    /**
     * Telefone
     *
     * @property string $fone
     */
    private $fone = null;

    /**
     * Sigla da Unidade da Federação
     *
     * @property string $uF
     */
    private $uF = null;

    /**
     * Número do Documento de Arrecadação de Receita
     *
     * @property string $nDAR
     */
    private $nDAR = null;

    /**
     * Data de emissão do DAR (AAAA-MM-DD)
     *
     * @property string $dEmi
     */
    private $dEmi = null;

    /**
     * Valor Total constante no DAR
     *
     * @property string $vDAR
     */
    private $vDAR = null;

    /**
     * Repartição Fiscal emitente
     *
     * @property string $repEmi
     */
    private $repEmi = null;

    /**
     * Data de pagamento do DAR (AAAA-MM-DD)
     *
     * @property string $dPag
     */
    private $dPag = null;

    /**
     * Gets as cNPJ
     *
     * CNPJ do Órgão emissor
     *
     * @return string
     */
    public function getCNPJ()
    {
        return $this->cNPJ;
    }

    /**
     * Sets a new cNPJ
     *
     * CNPJ do Órgão emissor
     *
     * @param string $cNPJ
     * @return self
     */
    public function setCNPJ($cNPJ)
    {
        $this->cNPJ = $cNPJ;
        return $this;
    }

    /**
     * Gets as xOrgao
     *
     * Órgão emitente
     *
     * @return string
     */
    public function getXOrgao()
    {
        return $this->xOrgao;
    }

    /**
     * Sets a new xOrgao
     *
     * Órgão emitente
     *
     * @param string $xOrgao
     * @return self
     */
    public function setXOrgao($xOrgao)
    {
        $this->xOrgao = $xOrgao;
        return $this;
    }

    /**
     * Gets as matr
     *
     * Matrícula do agente
     *
     * @return string
     */
    public function getMatr()
    {
        return $this->matr;
    }

    /**
     * Sets a new matr
     *
     * Matrícula do agente
     *
     * @param string $matr
     * @return self
     */
    public function setMatr($matr)
    {
        $this->matr = $matr;
        return $this;
    }

    /**
     * Gets as xAgente
     *
     * Nome do agente
     *
     * @return string
     */
    public function getXAgente()
    {
        return $this->xAgente;
    }

    /**
     * Sets a new xAgente
     *
     * Nome do agente
     *
     * @param string $xAgente
     * @return self
     */
    public function setXAgente($xAgente)
    {
        $this->xAgente = $xAgente;
        return $this;
    }

    /**
     * Gets as fone
     *
     * Telefone
     *
     * @return string
     */
    public function getFone()
    {
        return $this->fone;
    }

    /**
     * Sets a new fone
     *
     * Telefone
     *
     * @param string $fone
     * @return self
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
        return $this;
    }

    /**
     * Gets as uF
     *
     * Sigla da Unidade da Federação
     *
     * @return string
     */
    public function getUF()
    {
        return $this->uF;
    }

    /**
     * Sets a new uF
     *
     * Sigla da Unidade da Federação
     *
     * @param string $uF
     * @return self
     */
    public function setUF($uF)
    {
        $this->uF = $uF;
        return $this;
    }

    /**
     * Gets as nDAR
     *
     * Número do Documento de Arrecadação de Receita
     *
     * @return string
     */
    public function getNDAR()
    {
        return $this->nDAR;
    }

    /**
     * Sets a new nDAR
     *
     * Número do Documento de Arrecadação de Receita
     *
     * @param string $nDAR
     * @return self
     */
    public function setNDAR($nDAR)
    {
        $this->nDAR = $nDAR;
        return $this;
    }

    /**
     * Gets as dEmi
     *
     * Data de emissão do DAR (AAAA-MM-DD)
     *
     * @return string
     */
    public function getDEmi()
    {
        return $this->dEmi;
    }

    /**
     * Sets a new dEmi
     *
     * Data de emissão do DAR (AAAA-MM-DD)
     *
     * @param string $dEmi
     * @return self
     */
    public function setDEmi($dEmi)
    {
        $this->dEmi = $dEmi;
        return $this;
    }

    /**
     * Gets as vDAR
     *
     * Valor Total constante no DAR
     *
     * @return string
     */
    public function getVDAR()
    {
        return $this->vDAR;
    }

    /**
     * Sets a new vDAR
     *
     * Valor Total constante no DAR
     *
     * @param string $vDAR
     * @return self
     */
    public function setVDAR($vDAR)
    {
        $this->vDAR = $vDAR;
        return $this;
    }

    /**
     * Gets as repEmi
     *
     * Repartição Fiscal emitente
     *
     * @return string
     */
    public function getRepEmi()
    {
        return $this->repEmi;
    }

    /**
     * Sets a new repEmi
     *
     * Repartição Fiscal emitente
     *
     * @param string $repEmi
     * @return self
     */
    public function setRepEmi($repEmi)
    {
        $this->repEmi = $repEmi;
        return $this;
    }

    /**
     * Gets as dPag
     *
     * Data de pagamento do DAR (AAAA-MM-DD)
     *
     * @return string
     */
    public function getDPag()
    {
        return $this->dPag;
    }

    /**
     * Sets a new dPag
     *
     * Data de pagamento do DAR (AAAA-MM-DD)
     *
     * @param string $dPag
     * @return self
     */
    public function setDPag($dPag)
    {
        $this->dPag = $dPag;
        return $this;
    }


}

