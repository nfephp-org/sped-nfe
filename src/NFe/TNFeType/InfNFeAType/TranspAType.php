<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType;

/**
 * Class representing TranspAType
 */
class TranspAType
{

    /**
     * Modalidade do frete
     * 0- Por conta do emitente;
     * 1- Por conta do destinatário/remetente;
     * 2- Por conta de terceiros;
     * 9- Sem frete (v2.0)
     *
     * @property string $modFrete
     */
    private $modFrete = null;

    /**
     * Dados do transportador
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\TransportaAType
     * $transporta
     */
    private $transporta = null;

    /**
     * Dados da retenção ICMS do Transporte
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\RetTranspAType
     * $retTransp
     */
    private $retTransp = null;

    /**
     * Dados do veículo
     *
     * @property \NFePHP\NFe\NFe\TVeiculoType $veicTransp
     */
    private $veicTransp = null;

    /**
     * Dados do reboque/Dolly (v2.0)
     *
     * @property \NFePHP\NFe\NFe\TVeiculoType[] $reboque
     */
    private $reboque = null;

    /**
     * Identificação do vagão (v2.0)
     *
     * @property string $vagao
     */
    private $vagao = null;

    /**
     * Identificação da balsa (v2.0)
     *
     * @property string $balsa
     */
    private $balsa = null;

    /**
     * Dados dos volumes
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\VolAType[] $vol
     */
    private $vol = null;

    /**
     * Gets as modFrete
     *
     * Modalidade do frete
     * 0- Por conta do emitente;
     * 1- Por conta do destinatário/remetente;
     * 2- Por conta de terceiros;
     * 9- Sem frete (v2.0)
     *
     * @return string
     */
    public function getModFrete()
    {
        return $this->modFrete;
    }

    /**
     * Sets a new modFrete
     *
     * Modalidade do frete
     * 0- Por conta do emitente;
     * 1- Por conta do destinatário/remetente;
     * 2- Por conta de terceiros;
     * 9- Sem frete (v2.0)
     *
     * @param string $modFrete
     * @return self
     */
    public function setModFrete($modFrete)
    {
        $this->modFrete = $modFrete;
        return $this;
    }

    /**
     * Gets as transporta
     *
     * Dados do transportador
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\TransportaAType
     */
    public function getTransporta()
    {
        return $this->transporta;
    }

    /**
     * Sets a new transporta
     *
     * Dados do transportador
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\TransportaAType
     * $transporta
     * @return self
     */
    public function setTransporta(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\TransportaAType $transporta)
    {
        $this->transporta = $transporta;
        return $this;
    }

    /**
     * Gets as retTransp
     *
     * Dados da retenção ICMS do Transporte
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\RetTranspAType
     */
    public function getRetTransp()
    {
        return $this->retTransp;
    }

    /**
     * Sets a new retTransp
     *
     * Dados da retenção ICMS do Transporte
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\RetTranspAType
     * $retTransp
     * @return self
     */
    public function setRetTransp(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\RetTranspAType $retTransp)
    {
        $this->retTransp = $retTransp;
        return $this;
    }

    /**
     * Gets as veicTransp
     *
     * Dados do veículo
     *
     * @return \NFePHP\NFe\NFe\TVeiculoType
     */
    public function getVeicTransp()
    {
        return $this->veicTransp;
    }

    /**
     * Sets a new veicTransp
     *
     * Dados do veículo
     *
     * @param \NFePHP\NFe\NFe\TVeiculoType $veicTransp
     * @return self
     */
    public function setVeicTransp(\NFePHP\NFe\NFe\TVeiculoType $veicTransp)
    {
        $this->veicTransp = $veicTransp;
        return $this;
    }

    /**
     * Adds as reboque
     *
     * Dados do reboque/Dolly (v2.0)
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TVeiculoType $reboque
     */
    public function addToReboque(\NFePHP\NFe\NFe\TVeiculoType $reboque)
    {
        $this->reboque[] = $reboque;
        return $this;
    }

    /**
     * isset reboque
     *
     * Dados do reboque/Dolly (v2.0)
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetReboque($index)
    {
        return isset($this->reboque[$index]);
    }

    /**
     * unset reboque
     *
     * Dados do reboque/Dolly (v2.0)
     *
     * @param scalar $index
     * @return void
     */
    public function unsetReboque($index)
    {
        unset($this->reboque[$index]);
    }

    /**
     * Gets as reboque
     *
     * Dados do reboque/Dolly (v2.0)
     *
     * @return \NFePHP\NFe\NFe\TVeiculoType[]
     */
    public function getReboque()
    {
        return $this->reboque;
    }

    /**
     * Sets a new reboque
     *
     * Dados do reboque/Dolly (v2.0)
     *
     * @param \NFePHP\NFe\NFe\TVeiculoType[] $reboque
     * @return self
     */
    public function setReboque(array $reboque)
    {
        $this->reboque = $reboque;
        return $this;
    }

    /**
     * Gets as vagao
     *
     * Identificação do vagão (v2.0)
     *
     * @return string
     */
    public function getVagao()
    {
        return $this->vagao;
    }

    /**
     * Sets a new vagao
     *
     * Identificação do vagão (v2.0)
     *
     * @param string $vagao
     * @return self
     */
    public function setVagao($vagao)
    {
        $this->vagao = $vagao;
        return $this;
    }

    /**
     * Gets as balsa
     *
     * Identificação da balsa (v2.0)
     *
     * @return string
     */
    public function getBalsa()
    {
        return $this->balsa;
    }

    /**
     * Sets a new balsa
     *
     * Identificação da balsa (v2.0)
     *
     * @param string $balsa
     * @return self
     */
    public function setBalsa($balsa)
    {
        $this->balsa = $balsa;
        return $this;
    }

    /**
     * Adds as vol
     *
     * Dados dos volumes
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\VolAType $vol
     */
    public function addToVol(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\VolAType $vol)
    {
        $this->vol[] = $vol;
        return $this;
    }

    /**
     * isset vol
     *
     * Dados dos volumes
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetVol($index)
    {
        return isset($this->vol[$index]);
    }

    /**
     * unset vol
     *
     * Dados dos volumes
     *
     * @param scalar $index
     * @return void
     */
    public function unsetVol($index)
    {
        unset($this->vol[$index]);
    }

    /**
     * Gets as vol
     *
     * Dados dos volumes
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\VolAType[]
     */
    public function getVol()
    {
        return $this->vol;
    }

    /**
     * Sets a new vol
     *
     * Dados dos volumes
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\VolAType[] $vol
     * @return self
     */
    public function setVol(array $vol)
    {
        $this->vol = $vol;
        return $this;
    }


}

