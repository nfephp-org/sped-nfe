<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TEnderEmiType
 *
 * Tipo Dados do Endereço do Emitente // 24/10/08 - desmembrado / tamanho mínimo
 * XSD Type: TEnderEmi
 */
class TEnderEmiType
{

    /**
     * Logradouro
     *
     * @property string $xLgr
     */
    private $xLgr = null;

    /**
     * Número
     *
     * @property string $nro
     */
    private $nro = null;

    /**
     * Complemento
     *
     * @property string $xCpl
     */
    private $xCpl = null;

    /**
     * Bairro
     *
     * @property string $xBairro
     */
    private $xBairro = null;

    /**
     * Código do município
     *
     * @property string $cMun
     */
    private $cMun = null;

    /**
     * Nome do município
     *
     * @property string $xMun
     */
    private $xMun = null;

    /**
     * Sigla da UF
     *
     * @property string $uF
     */
    private $uF = null;

    /**
     * CEP - NT 2011/004
     *
     * @property string $cEP
     */
    private $cEP = null;

    /**
     * Código do país
     *
     * @property string $cPais
     */
    private $cPais = null;

    /**
     * Nome do país
     *
     * @property string $xPais
     */
    private $xPais = null;

    /**
     * Preencher com Código DDD + número do telefone (v.2.0)
     *
     * @property string $fone
     */
    private $fone = null;

    /**
     * Gets as xLgr
     *
     * Logradouro
     *
     * @return string
     */
    public function getXLgr()
    {
        return $this->xLgr;
    }

    /**
     * Sets a new xLgr
     *
     * Logradouro
     *
     * @param string $xLgr
     * @return self
     */
    public function setXLgr($xLgr)
    {
        $this->xLgr = $xLgr;
        return $this;
    }

    /**
     * Gets as nro
     *
     * Número
     *
     * @return string
     */
    public function getNro()
    {
        return $this->nro;
    }

    /**
     * Sets a new nro
     *
     * Número
     *
     * @param string $nro
     * @return self
     */
    public function setNro($nro)
    {
        $this->nro = $nro;
        return $this;
    }

    /**
     * Gets as xCpl
     *
     * Complemento
     *
     * @return string
     */
    public function getXCpl()
    {
        return $this->xCpl;
    }

    /**
     * Sets a new xCpl
     *
     * Complemento
     *
     * @param string $xCpl
     * @return self
     */
    public function setXCpl($xCpl)
    {
        $this->xCpl = $xCpl;
        return $this;
    }

    /**
     * Gets as xBairro
     *
     * Bairro
     *
     * @return string
     */
    public function getXBairro()
    {
        return $this->xBairro;
    }

    /**
     * Sets a new xBairro
     *
     * Bairro
     *
     * @param string $xBairro
     * @return self
     */
    public function setXBairro($xBairro)
    {
        $this->xBairro = $xBairro;
        return $this;
    }

    /**
     * Gets as cMun
     *
     * Código do município
     *
     * @return string
     */
    public function getCMun()
    {
        return $this->cMun;
    }

    /**
     * Sets a new cMun
     *
     * Código do município
     *
     * @param string $cMun
     * @return self
     */
    public function setCMun($cMun)
    {
        $this->cMun = $cMun;
        return $this;
    }

    /**
     * Gets as xMun
     *
     * Nome do município
     *
     * @return string
     */
    public function getXMun()
    {
        return $this->xMun;
    }

    /**
     * Sets a new xMun
     *
     * Nome do município
     *
     * @param string $xMun
     * @return self
     */
    public function setXMun($xMun)
    {
        $this->xMun = $xMun;
        return $this;
    }

    /**
     * Gets as uF
     *
     * Sigla da UF
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
     * Sigla da UF
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
     * Gets as cEP
     *
     * CEP - NT 2011/004
     *
     * @return string
     */
    public function getCEP()
    {
        return $this->cEP;
    }

    /**
     * Sets a new cEP
     *
     * CEP - NT 2011/004
     *
     * @param string $cEP
     * @return self
     */
    public function setCEP($cEP)
    {
        $this->cEP = $cEP;
        return $this;
    }

    /**
     * Gets as cPais
     *
     * Código do país
     *
     * @return string
     */
    public function getCPais()
    {
        return $this->cPais;
    }

    /**
     * Sets a new cPais
     *
     * Código do país
     *
     * @param string $cPais
     * @return self
     */
    public function setCPais($cPais)
    {
        $this->cPais = $cPais;
        return $this;
    }

    /**
     * Gets as xPais
     *
     * Nome do país
     *
     * @return string
     */
    public function getXPais()
    {
        return $this->xPais;
    }

    /**
     * Sets a new xPais
     *
     * Nome do país
     *
     * @param string $xPais
     * @return self
     */
    public function setXPais($xPais)
    {
        $this->xPais = $xPais;
        return $this;
    }

    /**
     * Gets as fone
     *
     * Preencher com Código DDD + número do telefone (v.2.0)
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
     * Preencher com Código DDD + número do telefone (v.2.0)
     *
     * @param string $fone
     * @return self
     */
    public function setFone($fone)
    {
        $this->fone = $fone;
        return $this;
    }


}

