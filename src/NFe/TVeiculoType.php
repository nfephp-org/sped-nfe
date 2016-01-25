<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TVeiculoType
 *
 * Tipo Dados do Veículo
 * XSD Type: TVeiculo
 */
class TVeiculoType
{

    /**
     * Placa do veículo (NT2011/004)
     *
     * @property string $placa
     */
    private $placa = null;

    /**
     * Sigla da UF
     *
     * @property string $uF
     */
    private $uF = null;

    /**
     * Registro Nacional de Transportador de Carga (ANTT)
     *
     * @property string $rNTC
     */
    private $rNTC = null;

    /**
     * Gets as placa
     *
     * Placa do veículo (NT2011/004)
     *
     * @return string
     */
    public function getPlaca()
    {
        return $this->placa;
    }

    /**
     * Sets a new placa
     *
     * Placa do veículo (NT2011/004)
     *
     * @param string $placa
     * @return self
     */
    public function setPlaca($placa)
    {
        $this->placa = $placa;
        return $this;
    }

    /**
     * Gets as uF
     *
     * Sigla da UF
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
     * Sigla da UF
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
     * Gets as rNTC
     *
     * Registro Nacional de Transportador de Carga (ANTT)
     *
     * @return string
     */
    public function getRNTC()
    {
        return $this->rNTC;
    }

    /**
     * Sets a new rNTC
     *
     * Registro Nacional de Transportador de Carga (ANTT)
     *
     * @param string $rNTC
     * @return self
     */
    public function setRNTC($rNTC)
    {
        $this->rNTC = $rNTC;
        return $this;
    }


}

