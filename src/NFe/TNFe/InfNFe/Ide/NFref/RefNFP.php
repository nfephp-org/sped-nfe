<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref;

/**
 * Class representing RefNFP
 */
class RefNFP
{

    /**
     * Código da UF do emitente do Documento FiscalUtilizar a Tabela do IBGE (Anexo IV
     * - Tabela de UF, Município e País)
     *
     * @property string $cUF
     */
    private $cUF = null;

    /**
     * AAMM da emissão da NF de produtor
     *
     * @property string $aAMM
     */
    private $aAMM = null;

    /**
     * CNPJ do emitente da NF de produtor
     *
     * @property string $cNPJ
     */
    private $cNPJ = null;

    /**
     * CPF do emitente da NF de produtor
     *
     * @property string $cPF
     */
    private $cPF = null;

    /**
     * IE do emitente da NF de Produtor
     *
     * @property string $iE
     */
    private $iE = null;

    /**
     * Código do modelo do Documento Fiscal - utilizar 04 para NF de produtor ou 01
     * para NF Avulsa
     *
     * @property string $mod
     */
    private $mod = null;

    /**
     * Série do Documento Fiscal, informar zero se inexistentesérie
     *
     * @property string $serie
     */
    private $serie = null;

    /**
     * Número do Documento Fiscal - 1 – 999999999
     *
     * @property string $nNF
     */
    private $nNF = null;

    /**
     * Gets as cUF
     *
     * Código da UF do emitente do Documento FiscalUtilizar a Tabela do IBGE (Anexo IV
     * - Tabela de UF, Município e País)
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
     * Código da UF do emitente do Documento FiscalUtilizar a Tabela do IBGE (Anexo IV
     * - Tabela de UF, Município e País)
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
     * AAMM da emissão da NF de produtor
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
     * AAMM da emissão da NF de produtor
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
     * CNPJ do emitente da NF de produtor
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
     * CNPJ do emitente da NF de produtor
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
     * Gets as cPF
     *
     * CPF do emitente da NF de produtor
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->cPF;
    }

    /**
     * Sets a new cPF
     *
     * CPF do emitente da NF de produtor
     *
     * @param string $cPF
     * @return self
     */
    public function setCPF($cPF)
    {
        $this->cPF = $cPF;
        return $this;
    }

    /**
     * Gets as iE
     *
     * IE do emitente da NF de Produtor
     *
     * @return string
     */
    public function getIE()
    {
        return $this->iE;
    }

    /**
     * Sets a new iE
     *
     * IE do emitente da NF de Produtor
     *
     * @param string $iE
     * @return self
     */
    public function setIE($iE)
    {
        $this->iE = $iE;
        return $this;
    }

    /**
     * Gets as mod
     *
     * Código do modelo do Documento Fiscal - utilizar 04 para NF de produtor ou 01
     * para NF Avulsa
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
     * Código do modelo do Documento Fiscal - utilizar 04 para NF de produtor ou 01
     * para NF Avulsa
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
     * Série do Documento Fiscal, informar zero se inexistentesérie
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
     * Série do Documento Fiscal, informar zero se inexistentesérie
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
     * Número do Documento Fiscal - 1 – 999999999
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
     * Número do Documento Fiscal - 1 – 999999999
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

