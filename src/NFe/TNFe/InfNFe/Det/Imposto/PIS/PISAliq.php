<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS;

/**
 * Class representing PISAliq
 */
class PISAliq
{

    /**
     * Código de Situação Tributária do PIS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @property string $cST
     */
    private $cST = null;

    /**
     * Valor da BC do PIS
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Alíquota do PIS (em percentual)
     *
     * @property string $pPIS
     */
    private $pPIS = null;

    /**
     * Valor do PIS
     *
     * @property string $vPIS
     */
    private $vPIS = null;

    /**
     * Gets as cST
     *
     * Código de Situação Tributária do PIS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @return string
     */
    public function getCST()
    {
        return $this->cST;
    }

    /**
     * Sets a new cST
     *
     * Código de Situação Tributária do PIS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @param string $cST
     * @return self
     */
    public function setCST($cST)
    {
        $this->cST = $cST;
        return $this;
    }

    /**
     * Gets as vBC
     *
     * Valor da BC do PIS
     *
     * @return string
     */
    public function getVBC()
    {
        return $this->vBC;
    }

    /**
     * Sets a new vBC
     *
     * Valor da BC do PIS
     *
     * @param string $vBC
     * @return self
     */
    public function setVBC($vBC)
    {
        $this->vBC = $vBC;
        return $this;
    }

    /**
     * Gets as pPIS
     *
     * Alíquota do PIS (em percentual)
     *
     * @return string
     */
    public function getPPIS()
    {
        return $this->pPIS;
    }

    /**
     * Sets a new pPIS
     *
     * Alíquota do PIS (em percentual)
     *
     * @param string $pPIS
     * @return self
     */
    public function setPPIS($pPIS)
    {
        $this->pPIS = $pPIS;
        return $this;
    }

    /**
     * Gets as vPIS
     *
     * Valor do PIS
     *
     * @return string
     */
    public function getVPIS()
    {
        return $this->vPIS;
    }

    /**
     * Sets a new vPIS
     *
     * Valor do PIS
     *
     * @param string $vPIS
     * @return self
     */
    public function setVPIS($vPIS)
    {
        $this->vPIS = $vPIS;
        return $this;
    }


}

