<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TNfeProcType
 *
 * Tipo da NF-e processada
 * XSD Type: TNfeProc
 */
class TNfeProcType
{

    /**
     * @property string $versao
     */
    private $versao = null;

    /**
     * @property \NFePHP\NFe\NFe\TNFeType $nFe
     */
    private $nFe = null;

    /**
     * @property \NFePHP\NFe\NFe\TProtNFeType $protNFe
     */
    private $protNFe = null;

    /**
     * Gets as versao
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Sets a new versao
     *
     * @param string $versao
     * @return self
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Gets as nFe
     *
     * @return \NFePHP\NFe\NFe\TNFeType
     */
    public function getNFe()
    {
        return $this->nFe;
    }

    /**
     * Sets a new nFe
     *
     * @param \NFePHP\NFe\NFe\TNFeType $nFe
     * @return self
     */
    public function setNFe(\NFePHP\NFe\NFe\TNFeType $nFe)
    {
        $this->nFe = $nFe;
        return $this;
    }

    /**
     * Gets as protNFe
     *
     * @return \NFePHP\NFe\NFe\TProtNFeType
     */
    public function getProtNFe()
    {
        return $this->protNFe;
    }

    /**
     * Sets a new protNFe
     *
     * @param \NFePHP\NFe\NFe\TProtNFeType $protNFe
     * @return self
     */
    public function setProtNFe(\NFePHP\NFe\NFe\TProtNFeType $protNFe)
    {
        $this->protNFe = $protNFe;
        return $this;
    }


}

