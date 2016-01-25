<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\IdeAType\NFrefAType;

/**
 * Class representing RefECFAType
 */
class RefECFAType
{

    /**
     * Código do modelo do Documento Fiscal 
     * Preencher com "2B", quando se tratar de Cupom Fiscal emitido por máquina
     * registradora (não ECF), com "2C", quando se tratar de Cupom Fiscal PDV, ou
     * "2D", quando se tratar de Cupom Fiscal (emitido por ECF)
     *
     * @property string $mod
     */
    private $mod = null;

    /**
     * Informar o número de ordem seqüencial do ECF que emitiu o Cupom Fiscal
     * vinculado à NF-e
     *
     * @property string $nECF
     */
    private $nECF = null;

    /**
     * Informar o Número do Contador de Ordem de Operação - COO vinculado à NF-e
     *
     * @property string $nCOO
     */
    private $nCOO = null;

    /**
     * Gets as mod
     *
     * Código do modelo do Documento Fiscal 
     * Preencher com "2B", quando se tratar de Cupom Fiscal emitido por máquina
     * registradora (não ECF), com "2C", quando se tratar de Cupom Fiscal PDV, ou
     * "2D", quando se tratar de Cupom Fiscal (emitido por ECF)
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
     * Código do modelo do Documento Fiscal 
     * Preencher com "2B", quando se tratar de Cupom Fiscal emitido por máquina
     * registradora (não ECF), com "2C", quando se tratar de Cupom Fiscal PDV, ou
     * "2D", quando se tratar de Cupom Fiscal (emitido por ECF)
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
     * Gets as nECF
     *
     * Informar o número de ordem seqüencial do ECF que emitiu o Cupom Fiscal
     * vinculado à NF-e
     *
     * @return string
     */
    public function getNECF()
    {
        return $this->nECF;
    }

    /**
     * Sets a new nECF
     *
     * Informar o número de ordem seqüencial do ECF que emitiu o Cupom Fiscal
     * vinculado à NF-e
     *
     * @param string $nECF
     * @return self
     */
    public function setNECF($nECF)
    {
        $this->nECF = $nECF;
        return $this;
    }

    /**
     * Gets as nCOO
     *
     * Informar o Número do Contador de Ordem de Operação - COO vinculado à NF-e
     *
     * @return string
     */
    public function getNCOO()
    {
        return $this->nCOO;
    }

    /**
     * Sets a new nCOO
     *
     * Informar o Número do Contador de Ordem de Operação - COO vinculado à NF-e
     *
     * @param string $nCOO
     * @return self
     */
    public function setNCOO($nCOO)
    {
        $this->nCOO = $nCOO;
        return $this;
    }


}

