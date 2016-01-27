<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod;

/**
 * Class representing Arma
 */
class Arma
{

    /**
     * Indicador do tipo de arma de fogo (0 - Uso permitido; 1 - Uso restrito)
     *
     * @property string $tpArma
     */
    private $tpArma = null;

    /**
     * Número de série da arma
     *
     * @property string $nSerie
     */
    private $nSerie = null;

    /**
     * Número de série do cano
     *
     * @property string $nCano
     */
    private $nCano = null;

    /**
     * Descrição completa da arma, compreendendo: calibre, marca, capacidade, tipo de
     * funcionamento, comprimento e demais elementos que permitam a sua perfeita
     * identificação.
     *
     * @property string $descr
     */
    private $descr = null;

    /**
     * Gets as tpArma
     *
     * Indicador do tipo de arma de fogo (0 - Uso permitido; 1 - Uso restrito)
     *
     * @return string
     */
    public function getTpArma()
    {
        return $this->tpArma;
    }

    /**
     * Sets a new tpArma
     *
     * Indicador do tipo de arma de fogo (0 - Uso permitido; 1 - Uso restrito)
     *
     * @param string $tpArma
     * @return self
     */
    public function setTpArma($tpArma)
    {
        $this->tpArma = $tpArma;
        return $this;
    }

    /**
     * Gets as nSerie
     *
     * Número de série da arma
     *
     * @return string
     */
    public function getNSerie()
    {
        return $this->nSerie;
    }

    /**
     * Sets a new nSerie
     *
     * Número de série da arma
     *
     * @param string $nSerie
     * @return self
     */
    public function setNSerie($nSerie)
    {
        $this->nSerie = $nSerie;
        return $this;
    }

    /**
     * Gets as nCano
     *
     * Número de série do cano
     *
     * @return string
     */
    public function getNCano()
    {
        return $this->nCano;
    }

    /**
     * Sets a new nCano
     *
     * Número de série do cano
     *
     * @param string $nCano
     * @return self
     */
    public function setNCano($nCano)
    {
        $this->nCano = $nCano;
        return $this;
    }

    /**
     * Gets as descr
     *
     * Descrição completa da arma, compreendendo: calibre, marca, capacidade, tipo de
     * funcionamento, comprimento e demais elementos que permitam a sua perfeita
     * identificação.
     *
     * @return string
     */
    public function getDescr()
    {
        return $this->descr;
    }

    /**
     * Sets a new descr
     *
     * Descrição completa da arma, compreendendo: calibre, marca, capacidade, tipo de
     * funcionamento, comprimento e demais elementos que permitam a sua perfeita
     * identificação.
     *
     * @param string $descr
     * @return self
     */
    public function setDescr($descr)
    {
        $this->descr = $descr;
        return $this;
    }


}

