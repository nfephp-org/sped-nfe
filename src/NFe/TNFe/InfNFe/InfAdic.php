<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe;

/**
 * Class representing InfAdic
 */
class InfAdic
{

    /**
     * Informações adicionais de interesse do Fisco (v2.0)
     *
     * @property string $infAdFisco
     */
    private $infAdFisco = null;

    /**
     * Informações complementares de interesse do Contribuinte
     *
     * @property string $infCpl
     */
    private $infCpl = null;

    /**
     * Campo de uso livre do contribuinte
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsCont[] $obsCont
     */
    private $obsCont = null;

    /**
     * Campo de uso exclusivo do Fisco
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsFisco[] $obsFisco
     */
    private $obsFisco = null;

    /**
     * Grupo de informações do processo referenciado
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ProcRef[] $procRef
     */
    private $procRef = null;

    /**
     * Gets as infAdFisco
     *
     * Informações adicionais de interesse do Fisco (v2.0)
     *
     * @return string
     */
    public function getInfAdFisco()
    {
        return $this->infAdFisco;
    }

    /**
     * Sets a new infAdFisco
     *
     * Informações adicionais de interesse do Fisco (v2.0)
     *
     * @param string $infAdFisco
     * @return self
     */
    public function setInfAdFisco($infAdFisco)
    {
        $this->infAdFisco = $infAdFisco;
        return $this;
    }

    /**
     * Gets as infCpl
     *
     * Informações complementares de interesse do Contribuinte
     *
     * @return string
     */
    public function getInfCpl()
    {
        return $this->infCpl;
    }

    /**
     * Sets a new infCpl
     *
     * Informações complementares de interesse do Contribuinte
     *
     * @param string $infCpl
     * @return self
     */
    public function setInfCpl($infCpl)
    {
        $this->infCpl = $infCpl;
        return $this;
    }

    /**
     * Adds as obsCont
     *
     * Campo de uso livre do contribuinte
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsCont $obsCont
     */
    public function addToObsCont(\NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsCont $obsCont)
    {
        $this->obsCont[] = $obsCont;
        return $this;
    }

    /**
     * isset obsCont
     *
     * Campo de uso livre do contribuinte
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetObsCont($index)
    {
        return isset($this->obsCont[$index]);
    }

    /**
     * unset obsCont
     *
     * Campo de uso livre do contribuinte
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @param scalar $index
     * @return void
     */
    public function unsetObsCont($index)
    {
        unset($this->obsCont[$index]);
    }

    /**
     * Gets as obsCont
     *
     * Campo de uso livre do contribuinte
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsCont[]
     */
    public function getObsCont()
    {
        return $this->obsCont;
    }

    /**
     * Sets a new obsCont
     *
     * Campo de uso livre do contribuinte
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsCont[] $obsCont
     * @return self
     */
    public function setObsCont(array $obsCont)
    {
        $this->obsCont = $obsCont;
        return $this;
    }

    /**
     * Adds as obsFisco
     *
     * Campo de uso exclusivo do Fisco
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsFisco $obsFisco
     */
    public function addToObsFisco(\NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsFisco $obsFisco)
    {
        $this->obsFisco[] = $obsFisco;
        return $this;
    }

    /**
     * isset obsFisco
     *
     * Campo de uso exclusivo do Fisco
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetObsFisco($index)
    {
        return isset($this->obsFisco[$index]);
    }

    /**
     * unset obsFisco
     *
     * Campo de uso exclusivo do Fisco
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @param scalar $index
     * @return void
     */
    public function unsetObsFisco($index)
    {
        unset($this->obsFisco[$index]);
    }

    /**
     * Gets as obsFisco
     *
     * Campo de uso exclusivo do Fisco
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsFisco[]
     */
    public function getObsFisco()
    {
        return $this->obsFisco;
    }

    /**
     * Sets a new obsFisco
     *
     * Campo de uso exclusivo do Fisco
     * informar o nome do campo no atributo xCampo
     * e o conteúdo do campo no xTexto
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ObsFisco[] $obsFisco
     * @return self
     */
    public function setObsFisco(array $obsFisco)
    {
        $this->obsFisco = $obsFisco;
        return $this;
    }

    /**
     * Adds as procRef
     *
     * Grupo de informações do processo referenciado
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ProcRef $procRef
     */
    public function addToProcRef(\NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ProcRef $procRef)
    {
        $this->procRef[] = $procRef;
        return $this;
    }

    /**
     * isset procRef
     *
     * Grupo de informações do processo referenciado
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetProcRef($index)
    {
        return isset($this->procRef[$index]);
    }

    /**
     * unset procRef
     *
     * Grupo de informações do processo referenciado
     *
     * @param scalar $index
     * @return void
     */
    public function unsetProcRef($index)
    {
        unset($this->procRef[$index]);
    }

    /**
     * Gets as procRef
     *
     * Grupo de informações do processo referenciado
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ProcRef[]
     */
    public function getProcRef()
    {
        return $this->procRef;
    }

    /**
     * Sets a new procRef
     *
     * Grupo de informações do processo referenciado
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic\ProcRef[] $procRef
     * @return self
     */
    public function setProcRef(array $procRef)
    {
        $this->procRef = $procRef;
        return $this;
    }


}

