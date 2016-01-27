<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto;

/**
 * Class representing ICMSUFDest
 */
class ICMSUFDest
{

    /**
     * Valor da Base de Cálculo do ICMS na UF do destinatário.
     *
     * @property string $vBCUFDest
     */
    private $vBCUFDest = null;

    /**
     * Percentual adicional inserido na alíquota interna da UF de destino, relativo ao
     * Fundo de Combate à Pobreza (FCP) naquela UF.
     *
     * @property string $pFCPUFDest
     */
    private $pFCPUFDest = null;

    /**
     * Alíquota adotada nas operações internas na UF do destinatário para o produto
     * / mercadoria.
     *
     * @property string $pICMSUFDest
     */
    private $pICMSUFDest = null;

    /**
     * Alíquota interestadual das UF envolvidas: - 4% alíquota interestadual para
     * produtos importados; - 7% para os Estados de origem do Sul e Sudeste (exceto
     * ES), destinado para os Estados do Norte e Nordeste ou ES; - 12% para os demais
     * casos.
     *
     * @property string $pICMSInter
     */
    private $pICMSInter = null;

    /**
     * Percentual de partilha para a UF do destinatário: - 40% em 2016; - 60% em 2017;
     * - 80% em 2018; - 100% a partir de 2019.
     *
     * @property string $pICMSInterPart
     */
    private $pICMSInterPart = null;

    /**
     * Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino.
     *
     * @property string $vFCPUFDest
     */
    private $vFCPUFDest = null;

    /**
     * Valor do ICMS de partilha para a UF do destinatário.
     *
     * @property string $vICMSUFDest
     */
    private $vICMSUFDest = null;

    /**
     * Valor do ICMS de partilha para a UF do remetente. Nota: A partir de 2019, este
     * valor será zero.
     *
     * @property string $vICMSUFRemet
     */
    private $vICMSUFRemet = null;

    /**
     * Gets as vBCUFDest
     *
     * Valor da Base de Cálculo do ICMS na UF do destinatário.
     *
     * @return string
     */
    public function getVBCUFDest()
    {
        return $this->vBCUFDest;
    }

    /**
     * Sets a new vBCUFDest
     *
     * Valor da Base de Cálculo do ICMS na UF do destinatário.
     *
     * @param string $vBCUFDest
     * @return self
     */
    public function setVBCUFDest($vBCUFDest)
    {
        $this->vBCUFDest = $vBCUFDest;
        return $this;
    }

    /**
     * Gets as pFCPUFDest
     *
     * Percentual adicional inserido na alíquota interna da UF de destino, relativo ao
     * Fundo de Combate à Pobreza (FCP) naquela UF.
     *
     * @return string
     */
    public function getPFCPUFDest()
    {
        return $this->pFCPUFDest;
    }

    /**
     * Sets a new pFCPUFDest
     *
     * Percentual adicional inserido na alíquota interna da UF de destino, relativo ao
     * Fundo de Combate à Pobreza (FCP) naquela UF.
     *
     * @param string $pFCPUFDest
     * @return self
     */
    public function setPFCPUFDest($pFCPUFDest)
    {
        $this->pFCPUFDest = $pFCPUFDest;
        return $this;
    }

    /**
     * Gets as pICMSUFDest
     *
     * Alíquota adotada nas operações internas na UF do destinatário para o produto
     * / mercadoria.
     *
     * @return string
     */
    public function getPICMSUFDest()
    {
        return $this->pICMSUFDest;
    }

    /**
     * Sets a new pICMSUFDest
     *
     * Alíquota adotada nas operações internas na UF do destinatário para o produto
     * / mercadoria.
     *
     * @param string $pICMSUFDest
     * @return self
     */
    public function setPICMSUFDest($pICMSUFDest)
    {
        $this->pICMSUFDest = $pICMSUFDest;
        return $this;
    }

    /**
     * Gets as pICMSInter
     *
     * Alíquota interestadual das UF envolvidas: - 4% alíquota interestadual para
     * produtos importados; - 7% para os Estados de origem do Sul e Sudeste (exceto
     * ES), destinado para os Estados do Norte e Nordeste ou ES; - 12% para os demais
     * casos.
     *
     * @return string
     */
    public function getPICMSInter()
    {
        return $this->pICMSInter;
    }

    /**
     * Sets a new pICMSInter
     *
     * Alíquota interestadual das UF envolvidas: - 4% alíquota interestadual para
     * produtos importados; - 7% para os Estados de origem do Sul e Sudeste (exceto
     * ES), destinado para os Estados do Norte e Nordeste ou ES; - 12% para os demais
     * casos.
     *
     * @param string $pICMSInter
     * @return self
     */
    public function setPICMSInter($pICMSInter)
    {
        $this->pICMSInter = $pICMSInter;
        return $this;
    }

    /**
     * Gets as pICMSInterPart
     *
     * Percentual de partilha para a UF do destinatário: - 40% em 2016; - 60% em 2017;
     * - 80% em 2018; - 100% a partir de 2019.
     *
     * @return string
     */
    public function getPICMSInterPart()
    {
        return $this->pICMSInterPart;
    }

    /**
     * Sets a new pICMSInterPart
     *
     * Percentual de partilha para a UF do destinatário: - 40% em 2016; - 60% em 2017;
     * - 80% em 2018; - 100% a partir de 2019.
     *
     * @param string $pICMSInterPart
     * @return self
     */
    public function setPICMSInterPart($pICMSInterPart)
    {
        $this->pICMSInterPart = $pICMSInterPart;
        return $this;
    }

    /**
     * Gets as vFCPUFDest
     *
     * Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino.
     *
     * @return string
     */
    public function getVFCPUFDest()
    {
        return $this->vFCPUFDest;
    }

    /**
     * Sets a new vFCPUFDest
     *
     * Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino.
     *
     * @param string $vFCPUFDest
     * @return self
     */
    public function setVFCPUFDest($vFCPUFDest)
    {
        $this->vFCPUFDest = $vFCPUFDest;
        return $this;
    }

    /**
     * Gets as vICMSUFDest
     *
     * Valor do ICMS de partilha para a UF do destinatário.
     *
     * @return string
     */
    public function getVICMSUFDest()
    {
        return $this->vICMSUFDest;
    }

    /**
     * Sets a new vICMSUFDest
     *
     * Valor do ICMS de partilha para a UF do destinatário.
     *
     * @param string $vICMSUFDest
     * @return self
     */
    public function setVICMSUFDest($vICMSUFDest)
    {
        $this->vICMSUFDest = $vICMSUFDest;
        return $this;
    }

    /**
     * Gets as vICMSUFRemet
     *
     * Valor do ICMS de partilha para a UF do remetente. Nota: A partir de 2019, este
     * valor será zero.
     *
     * @return string
     */
    public function getVICMSUFRemet()
    {
        return $this->vICMSUFRemet;
    }

    /**
     * Sets a new vICMSUFRemet
     *
     * Valor do ICMS de partilha para a UF do remetente. Nota: A partir de 2019, este
     * valor será zero.
     *
     * @param string $vICMSUFRemet
     * @return self
     */
    public function setVICMSUFRemet($vICMSUFRemet)
    {
        $this->vICMSUFRemet = $vICMSUFRemet;
        return $this;
    }


}

