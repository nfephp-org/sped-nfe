<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod;

/**
 * Class representing Med
 */
class Med
{

    /**
     * Número do lote do medicamento
     *
     * @property string $nLote
     */
    private $nLote = null;

    /**
     * Quantidade de produtos no lote
     *
     * @property string $qLote
     */
    private $qLote = null;

    /**
     * Data de Fabricação do medicamento (AAAA-MM-DD)
     *
     * @property string $dFab
     */
    private $dFab = null;

    /**
     * Data de validade do medicamento (AAAA-MM-DD)
     *
     * @property string $dVal
     */
    private $dVal = null;

    /**
     * Preço Máximo ao Consumidor
     *
     * @property string $vPMC
     */
    private $vPMC = null;

    /**
     * Gets as nLote
     *
     * Número do lote do medicamento
     *
     * @return string
     */
    public function getNLote()
    {
        return $this->nLote;
    }

    /**
     * Sets a new nLote
     *
     * Número do lote do medicamento
     *
     * @param string $nLote
     * @return self
     */
    public function setNLote($nLote)
    {
        $this->nLote = $nLote;
        return $this;
    }

    /**
     * Gets as qLote
     *
     * Quantidade de produtos no lote
     *
     * @return string
     */
    public function getQLote()
    {
        return $this->qLote;
    }

    /**
     * Sets a new qLote
     *
     * Quantidade de produtos no lote
     *
     * @param string $qLote
     * @return self
     */
    public function setQLote($qLote)
    {
        $this->qLote = $qLote;
        return $this;
    }

    /**
     * Gets as dFab
     *
     * Data de Fabricação do medicamento (AAAA-MM-DD)
     *
     * @return string
     */
    public function getDFab()
    {
        return $this->dFab;
    }

    /**
     * Sets a new dFab
     *
     * Data de Fabricação do medicamento (AAAA-MM-DD)
     *
     * @param string $dFab
     * @return self
     */
    public function setDFab($dFab)
    {
        $this->dFab = $dFab;
        return $this;
    }

    /**
     * Gets as dVal
     *
     * Data de validade do medicamento (AAAA-MM-DD)
     *
     * @return string
     */
    public function getDVal()
    {
        return $this->dVal;
    }

    /**
     * Sets a new dVal
     *
     * Data de validade do medicamento (AAAA-MM-DD)
     *
     * @param string $dVal
     * @return self
     */
    public function setDVal($dVal)
    {
        $this->dVal = $dVal;
        return $this;
    }

    /**
     * Gets as vPMC
     *
     * Preço Máximo ao Consumidor
     *
     * @return string
     */
    public function getVPMC()
    {
        return $this->vPMC;
    }

    /**
     * Sets a new vPMC
     *
     * Preço Máximo ao Consumidor
     *
     * @param string $vPMC
     * @return self
     */
    public function setVPMC($vPMC)
    {
        $this->vPMC = $vPMC;
        return $this;
    }


}

