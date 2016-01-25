<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TEnderecoType
 *
 * Tipo Dados do Endereço // 24/10/08 - tamanho mínimo
 * XSD Type: TEndereco
 */
class TEnderecoType
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
     * Código do município (utilizar a tabela do IBGE), informar 9999999 para
     * operações com o exterior.
     *
     * @property string $cMun
     */
    private $cMun = null;

    /**
     * Nome do município, informar EXTERIOR para operações com o exterior.
     *
     * @property string $xMun
     */
    private $xMun = null;

    /**
     * Sigla da UF, informar EX para operações com o exterior.
     *
     * @property string $uF
     */
    private $uF = null;

    /**
     * CEP
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
     * Telefone, preencher com Código DDD + número do telefone , nas operações com
     * exterior é permtido informar o código do país + código da localidade +
     * número do telefone
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
     * Código do município (utilizar a tabela do IBGE), informar 9999999 para
     * operações com o exterior.
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
     * Código do município (utilizar a tabela do IBGE), informar 9999999 para
     * operações com o exterior.
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
     * Nome do município, informar EXTERIOR para operações com o exterior.
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
     * Nome do município, informar EXTERIOR para operações com o exterior.
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
     * Sigla da UF, informar EX para operações com o exterior.
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
     * Sigla da UF, informar EX para operações com o exterior.
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
     * CEP
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
     * CEP
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
     * Telefone, preencher com Código DDD + número do telefone , nas operações com
     * exterior é permtido informar o código do país + código da localidade +
     * número do telefone
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
     * Telefone, preencher com Código DDD + número do telefone , nas operações com
     * exterior é permtido informar o código do país + código da localidade +
     * número do telefone
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

