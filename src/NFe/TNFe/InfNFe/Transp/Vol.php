<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Transp;

/**
 * Class representing Vol
 */
class Vol
{

    /**
     * Quantidade de volumes transportados
     *
     * @property string $qVol
     */
    private $qVol = null;

    /**
     * Espécie dos volumes transportados
     *
     * @property string $esp
     */
    private $esp = null;

    /**
     * Marca dos volumes transportados
     *
     * @property string $marca
     */
    private $marca = null;

    /**
     * Numeração dos volumes transportados
     *
     * @property string $nVol
     */
    private $nVol = null;

    /**
     * Peso líquido (em kg)
     *
     * @property string $pesoL
     */
    private $pesoL = null;

    /**
     * Peso bruto (em kg)
     *
     * @property string $pesoB
     */
    private $pesoB = null;

    /**
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Transp\Vol\Lacres[] $lacres
     */
    private $lacres = null;

    /**
     * Gets as qVol
     *
     * Quantidade de volumes transportados
     *
     * @return string
     */
    public function getQVol()
    {
        return $this->qVol;
    }

    /**
     * Sets a new qVol
     *
     * Quantidade de volumes transportados
     *
     * @param string $qVol
     * @return self
     */
    public function setQVol($qVol)
    {
        $this->qVol = $qVol;
        return $this;
    }

    /**
     * Gets as esp
     *
     * Espécie dos volumes transportados
     *
     * @return string
     */
    public function getEsp()
    {
        return $this->esp;
    }

    /**
     * Sets a new esp
     *
     * Espécie dos volumes transportados
     *
     * @param string $esp
     * @return self
     */
    public function setEsp($esp)
    {
        $this->esp = $esp;
        return $this;
    }

    /**
     * Gets as marca
     *
     * Marca dos volumes transportados
     *
     * @return string
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * Sets a new marca
     *
     * Marca dos volumes transportados
     *
     * @param string $marca
     * @return self
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
        return $this;
    }

    /**
     * Gets as nVol
     *
     * Numeração dos volumes transportados
     *
     * @return string
     */
    public function getNVol()
    {
        return $this->nVol;
    }

    /**
     * Sets a new nVol
     *
     * Numeração dos volumes transportados
     *
     * @param string $nVol
     * @return self
     */
    public function setNVol($nVol)
    {
        $this->nVol = $nVol;
        return $this;
    }

    /**
     * Gets as pesoL
     *
     * Peso líquido (em kg)
     *
     * @return string
     */
    public function getPesoL()
    {
        return $this->pesoL;
    }

    /**
     * Sets a new pesoL
     *
     * Peso líquido (em kg)
     *
     * @param string $pesoL
     * @return self
     */
    public function setPesoL($pesoL)
    {
        $this->pesoL = $pesoL;
        return $this;
    }

    /**
     * Gets as pesoB
     *
     * Peso bruto (em kg)
     *
     * @return string
     */
    public function getPesoB()
    {
        return $this->pesoB;
    }

    /**
     * Sets a new pesoB
     *
     * Peso bruto (em kg)
     *
     * @param string $pesoB
     * @return self
     */
    public function setPesoB($pesoB)
    {
        $this->pesoB = $pesoB;
        return $this;
    }

    /**
     * Adds as lacres
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Transp\Vol\Lacres $lacres
     */
    public function addToLacres(\NFePHP\NFe\NFe\TNFe\InfNFe\Transp\Vol\Lacres $lacres)
    {
        $this->lacres[] = $lacres;
        return $this;
    }

    /**
     * isset lacres
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetLacres($index)
    {
        return isset($this->lacres[$index]);
    }

    /**
     * unset lacres
     *
     * @param scalar $index
     * @return void
     */
    public function unsetLacres($index)
    {
        unset($this->lacres[$index]);
    }

    /**
     * Gets as lacres
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Transp\Vol\Lacres[]
     */
    public function getLacres()
    {
        return $this->lacres;
    }

    /**
     * Sets a new lacres
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Transp\Vol\Lacres[] $lacres
     * @return self
     */
    public function setLacres(array $lacres)
    {
        $this->lacres = $lacres;
        return $this;
    }


}

