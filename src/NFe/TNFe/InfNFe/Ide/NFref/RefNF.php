<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref;

/**
 * Class representing RefNF
 */
class RefNF
{

    /**
     * Código da UF do emitente do Documento Fiscal. Utilizar a Tabela do IBGE.
     *
     * @property string $cUF
     */
    private $cUF = null;

    /**
     * AAMM da emissão
     *
     * @property string $aAMM
     */
    private $aAMM = null;

    /**
     * CNPJ do emitente do documento fiscal referenciado
     *
     * @property string $cNPJ
     */
    private $cNPJ = null;

    /**
     * Código do modelo do Documento Fiscal. Utilizar 01 para NF modelo 1/1A
     *
     * @property string $mod
     */
    private $mod = null;

    /**
     * Série do Documento Fiscal, informar zero se inexistente
     *
     * @property string $serie
     */
    private $serie = null;

    /**
     * Número do Documento Fiscal
     *
     * @property string $nNF
     */
    private $nNF = null;

    /**
     * Gets as cUF
     *
     * Código da UF do emitente do Documento Fiscal. Utilizar a Tabela do IBGE.
     *
     * @return string
     */
    public function getCUF()
    {
        return $this->cUF;
    }

    /**
     * Sets a new cUF
     *
     * Código da UF do emitente do Documento Fiscal. Utilizar a Tabela do IBGE.
     *
     * @param string $cUF
     * @return self
     */
    public function setCUF($cUF)
    {
        $this->cUF = $cUF;
        return $this;
    }

    /**
     * Gets as aAMM
     *
     * AAMM da emissão
     *
     * @return string
     */
    public function getAAMM()
    {
        return $this->aAMM;
    }

    /**
     * Sets a new aAMM
     *
     * AAMM da emissão
     *
     * @param string $aAMM
     * @return self
     */
    public function setAAMM($aAMM)
    {
        $this->aAMM = $aAMM;
        return $this;
    }

    /**
     * Gets as cNPJ
     *
     * CNPJ do emitente do documento fiscal referenciado
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
     * CNPJ do emitente do documento fiscal referenciado
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
     * Gets as mod
     *
     * Código do modelo do Documento Fiscal. Utilizar 01 para NF modelo 1/1A
     *
     * @return string
     */
    public function getMod()
    {
        return $this->mod;
    }

    /**
     * Sets a new mod
     *
     * Código do modelo do Documento Fiscal. Utilizar 01 para NF modelo 1/1A
     *
     * @param string $mod
     * @return self
     */
    public function setMod($mod)
    {
        $this->mod = $mod;
        return $this;
    }

    /**
     * Gets as serie
     *
     * Série do Documento Fiscal, informar zero se inexistente
     *
     * @return string
     */
    public function getSerie()
    {
        return $this->serie;
    }

    /**
     * Sets a new serie
     *
     * Série do Documento Fiscal, informar zero se inexistente
     *
     * @param string $serie
     * @return self
     */
    public function setSerie($serie)
    {
        $this->serie = $serie;
        return $this;
    }

    /**
     * Gets as nNF
     *
     * Número do Documento Fiscal
     *
     * @return string
     */
    public function getNNF()
    {
        return $this->nNF;
    }

    /**
     * Sets a new nNF
     *
     * Número do Documento Fiscal
     *
     * @param string $nNF
     * @return self
     */
    public function setNNF($nNF)
    {
        $this->nNF = $nNF;
        return $this;
    }


}

