<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod;

/**
 * Class representing VeicProd
 */
class VeicProd
{

    /**
     * Tipo da Operação (1 - Venda concessionária; 2 - Faturamento direto; 3 - Venda
     * direta; 0 - Outros)
     *
     * @property string $tpOp
     */
    private $tpOp = null;

    /**
     * Chassi do veículo - VIN (código-identificação-veículo)
     *
     * @property string $chassi
     */
    private $chassi = null;

    /**
     * Cor do veículo (código de cada montadora)
     *
     * @property string $cCor
     */
    private $cCor = null;

    /**
     * Descrição da cor
     *
     * @property string $xCor
     */
    private $xCor = null;

    /**
     * Potência máxima do motor do veículo em cavalo vapor (CV).
     * (potência-veículo)
     *
     * @property string $pot
     */
    private $pot = null;

    /**
     * Capacidade voluntária do motor expressa em centímetros cúbicos (CC).
     * (cilindradas)
     *
     * @property string $cilin
     */
    private $cilin = null;

    /**
     * Peso líquido
     *
     * @property string $pesoL
     */
    private $pesoL = null;

    /**
     * Peso bruto
     *
     * @property string $pesoB
     */
    private $pesoB = null;

    /**
     * Serial (série)
     *
     * @property string $nSerie
     */
    private $nSerie = null;

    /**
     * Tipo de combustível-Tabela RENAVAM: 01-Álcool; 02-Gasolina; 03-Diesel;
     * 16-Álcool/Gas.; 17-Gas./Álcool/GNV; 18-Gasolina/Elétrico
     *
     * @property string $tpComb
     */
    private $tpComb = null;

    /**
     * Número do motor
     *
     * @property string $nMotor
     */
    private $nMotor = null;

    /**
     * CMT-Capacidade Máxima de Tração - em Toneladas 4 casas decimais
     *
     * @property string $cMT
     */
    private $cMT = null;

    /**
     * Distância entre eixos
     *
     * @property string $dist
     */
    private $dist = null;

    /**
     * Ano Modelo de Fabricação
     *
     * @property string $anoMod
     */
    private $anoMod = null;

    /**
     * Ano de Fabricação
     *
     * @property string $anoFab
     */
    private $anoFab = null;

    /**
     * Tipo de pintura
     *
     * @property string $tpPint
     */
    private $tpPint = null;

    /**
     * Tipo de veículo (utilizar tabela RENAVAM)
     *
     * @property string $tpVeic
     */
    private $tpVeic = null;

    /**
     * Espécie de veículo (utilizar tabela RENAVAM)
     *
     * @property string $espVeic
     */
    private $espVeic = null;

    /**
     * Informa-se o veículo tem VIN (chassi) remarcado.
     * R-Remarcado
     * N-NormalVIN
     *
     * @property string $vIN
     */
    private $vIN = null;

    /**
     * Condição do veículo (1 - acabado; 2 - inacabado; 3 - semi-acabado)
     *
     * @property string $condVeic
     */
    private $condVeic = null;

    /**
     * Código Marca Modelo (utilizar tabela RENAVAM)
     *
     * @property string $cMod
     */
    private $cMod = null;

    /**
     * Código da Cor Segundo as regras de pré-cadastro do DENATRAN:
     * 01-AMARELO;02-AZUL;03-BEGE;04-BRANCA;05-CINZA;06-DOURADA;07-GRENA 
     * 08-LARANJA;09-MARROM;10-PRATA;11-PRETA;12-ROSA;13-ROXA;14-VERDE;15-VERMELHA;16-FANTASIA
     *
     * @property string $cCorDENATRAN
     */
    private $cCorDENATRAN = null;

    /**
     * Quantidade máxima de permitida de passageiros sentados, inclusive motorista.
     *
     * @property string $lota
     */
    private $lota = null;

    /**
     * Restrição
     * 0 - Não há;
     * 1 - Alienação Fiduciária;
     * 2 - Arrendamento Mercantil;
     * 3 - Reserva de Domínio;
     * 4 - Penhor de Veículos;
     * 9 - outras.
     *
     * @property string $tpRest
     */
    private $tpRest = null;

    /**
     * Gets as tpOp
     *
     * Tipo da Operação (1 - Venda concessionária; 2 - Faturamento direto; 3 - Venda
     * direta; 0 - Outros)
     *
     * @return string
     */
    public function getTpOp()
    {
        return $this->tpOp;
    }

    /**
     * Sets a new tpOp
     *
     * Tipo da Operação (1 - Venda concessionária; 2 - Faturamento direto; 3 - Venda
     * direta; 0 - Outros)
     *
     * @param string $tpOp
     * @return self
     */
    public function setTpOp($tpOp)
    {
        $this->tpOp = $tpOp;
        return $this;
    }

    /**
     * Gets as chassi
     *
     * Chassi do veículo - VIN (código-identificação-veículo)
     *
     * @return string
     */
    public function getChassi()
    {
        return $this->chassi;
    }

    /**
     * Sets a new chassi
     *
     * Chassi do veículo - VIN (código-identificação-veículo)
     *
     * @param string $chassi
     * @return self
     */
    public function setChassi($chassi)
    {
        $this->chassi = $chassi;
        return $this;
    }

    /**
     * Gets as cCor
     *
     * Cor do veículo (código de cada montadora)
     *
     * @return string
     */
    public function getCCor()
    {
        return $this->cCor;
    }

    /**
     * Sets a new cCor
     *
     * Cor do veículo (código de cada montadora)
     *
     * @param string $cCor
     * @return self
     */
    public function setCCor($cCor)
    {
        $this->cCor = $cCor;
        return $this;
    }

    /**
     * Gets as xCor
     *
     * Descrição da cor
     *
     * @return string
     */
    public function getXCor()
    {
        return $this->xCor;
    }

    /**
     * Sets a new xCor
     *
     * Descrição da cor
     *
     * @param string $xCor
     * @return self
     */
    public function setXCor($xCor)
    {
        $this->xCor = $xCor;
        return $this;
    }

    /**
     * Gets as pot
     *
     * Potência máxima do motor do veículo em cavalo vapor (CV).
     * (potência-veículo)
     *
     * @return string
     */
    public function getPot()
    {
        return $this->pot;
    }

    /**
     * Sets a new pot
     *
     * Potência máxima do motor do veículo em cavalo vapor (CV).
     * (potência-veículo)
     *
     * @param string $pot
     * @return self
     */
    public function setPot($pot)
    {
        $this->pot = $pot;
        return $this;
    }

    /**
     * Gets as cilin
     *
     * Capacidade voluntária do motor expressa em centímetros cúbicos (CC).
     * (cilindradas)
     *
     * @return string
     */
    public function getCilin()
    {
        return $this->cilin;
    }

    /**
     * Sets a new cilin
     *
     * Capacidade voluntária do motor expressa em centímetros cúbicos (CC).
     * (cilindradas)
     *
     * @param string $cilin
     * @return self
     */
    public function setCilin($cilin)
    {
        $this->cilin = $cilin;
        return $this;
    }

    /**
     * Gets as pesoL
     *
     * Peso líquido
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
     * Peso líquido
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
     * Peso bruto
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
     * Peso bruto
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
     * Gets as nSerie
     *
     * Serial (série)
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
     * Serial (série)
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
     * Gets as tpComb
     *
     * Tipo de combustível-Tabela RENAVAM: 01-Álcool; 02-Gasolina; 03-Diesel;
     * 16-Álcool/Gas.; 17-Gas./Álcool/GNV; 18-Gasolina/Elétrico
     *
     * @return string
     */
    public function getTpComb()
    {
        return $this->tpComb;
    }

    /**
     * Sets a new tpComb
     *
     * Tipo de combustível-Tabela RENAVAM: 01-Álcool; 02-Gasolina; 03-Diesel;
     * 16-Álcool/Gas.; 17-Gas./Álcool/GNV; 18-Gasolina/Elétrico
     *
     * @param string $tpComb
     * @return self
     */
    public function setTpComb($tpComb)
    {
        $this->tpComb = $tpComb;
        return $this;
    }

    /**
     * Gets as nMotor
     *
     * Número do motor
     *
     * @return string
     */
    public function getNMotor()
    {
        return $this->nMotor;
    }

    /**
     * Sets a new nMotor
     *
     * Número do motor
     *
     * @param string $nMotor
     * @return self
     */
    public function setNMotor($nMotor)
    {
        $this->nMotor = $nMotor;
        return $this;
    }

    /**
     * Gets as cMT
     *
     * CMT-Capacidade Máxima de Tração - em Toneladas 4 casas decimais
     *
     * @return string
     */
    public function getCMT()
    {
        return $this->cMT;
    }

    /**
     * Sets a new cMT
     *
     * CMT-Capacidade Máxima de Tração - em Toneladas 4 casas decimais
     *
     * @param string $cMT
     * @return self
     */
    public function setCMT($cMT)
    {
        $this->cMT = $cMT;
        return $this;
    }

    /**
     * Gets as dist
     *
     * Distância entre eixos
     *
     * @return string
     */
    public function getDist()
    {
        return $this->dist;
    }

    /**
     * Sets a new dist
     *
     * Distância entre eixos
     *
     * @param string $dist
     * @return self
     */
    public function setDist($dist)
    {
        $this->dist = $dist;
        return $this;
    }

    /**
     * Gets as anoMod
     *
     * Ano Modelo de Fabricação
     *
     * @return string
     */
    public function getAnoMod()
    {
        return $this->anoMod;
    }

    /**
     * Sets a new anoMod
     *
     * Ano Modelo de Fabricação
     *
     * @param string $anoMod
     * @return self
     */
    public function setAnoMod($anoMod)
    {
        $this->anoMod = $anoMod;
        return $this;
    }

    /**
     * Gets as anoFab
     *
     * Ano de Fabricação
     *
     * @return string
     */
    public function getAnoFab()
    {
        return $this->anoFab;
    }

    /**
     * Sets a new anoFab
     *
     * Ano de Fabricação
     *
     * @param string $anoFab
     * @return self
     */
    public function setAnoFab($anoFab)
    {
        $this->anoFab = $anoFab;
        return $this;
    }

    /**
     * Gets as tpPint
     *
     * Tipo de pintura
     *
     * @return string
     */
    public function getTpPint()
    {
        return $this->tpPint;
    }

    /**
     * Sets a new tpPint
     *
     * Tipo de pintura
     *
     * @param string $tpPint
     * @return self
     */
    public function setTpPint($tpPint)
    {
        $this->tpPint = $tpPint;
        return $this;
    }

    /**
     * Gets as tpVeic
     *
     * Tipo de veículo (utilizar tabela RENAVAM)
     *
     * @return string
     */
    public function getTpVeic()
    {
        return $this->tpVeic;
    }

    /**
     * Sets a new tpVeic
     *
     * Tipo de veículo (utilizar tabela RENAVAM)
     *
     * @param string $tpVeic
     * @return self
     */
    public function setTpVeic($tpVeic)
    {
        $this->tpVeic = $tpVeic;
        return $this;
    }

    /**
     * Gets as espVeic
     *
     * Espécie de veículo (utilizar tabela RENAVAM)
     *
     * @return string
     */
    public function getEspVeic()
    {
        return $this->espVeic;
    }

    /**
     * Sets a new espVeic
     *
     * Espécie de veículo (utilizar tabela RENAVAM)
     *
     * @param string $espVeic
     * @return self
     */
    public function setEspVeic($espVeic)
    {
        $this->espVeic = $espVeic;
        return $this;
    }

    /**
     * Gets as vIN
     *
     * Informa-se o veículo tem VIN (chassi) remarcado.
     * R-Remarcado
     * N-NormalVIN
     *
     * @return string
     */
    public function getVIN()
    {
        return $this->vIN;
    }

    /**
     * Sets a new vIN
     *
     * Informa-se o veículo tem VIN (chassi) remarcado.
     * R-Remarcado
     * N-NormalVIN
     *
     * @param string $vIN
     * @return self
     */
    public function setVIN($vIN)
    {
        $this->vIN = $vIN;
        return $this;
    }

    /**
     * Gets as condVeic
     *
     * Condição do veículo (1 - acabado; 2 - inacabado; 3 - semi-acabado)
     *
     * @return string
     */
    public function getCondVeic()
    {
        return $this->condVeic;
    }

    /**
     * Sets a new condVeic
     *
     * Condição do veículo (1 - acabado; 2 - inacabado; 3 - semi-acabado)
     *
     * @param string $condVeic
     * @return self
     */
    public function setCondVeic($condVeic)
    {
        $this->condVeic = $condVeic;
        return $this;
    }

    /**
     * Gets as cMod
     *
     * Código Marca Modelo (utilizar tabela RENAVAM)
     *
     * @return string
     */
    public function getCMod()
    {
        return $this->cMod;
    }

    /**
     * Sets a new cMod
     *
     * Código Marca Modelo (utilizar tabela RENAVAM)
     *
     * @param string $cMod
     * @return self
     */
    public function setCMod($cMod)
    {
        $this->cMod = $cMod;
        return $this;
    }

    /**
     * Gets as cCorDENATRAN
     *
     * Código da Cor Segundo as regras de pré-cadastro do DENATRAN:
     * 01-AMARELO;02-AZUL;03-BEGE;04-BRANCA;05-CINZA;06-DOURADA;07-GRENA 
     * 08-LARANJA;09-MARROM;10-PRATA;11-PRETA;12-ROSA;13-ROXA;14-VERDE;15-VERMELHA;16-FANTASIA
     *
     * @return string
     */
    public function getCCorDENATRAN()
    {
        return $this->cCorDENATRAN;
    }

    /**
     * Sets a new cCorDENATRAN
     *
     * Código da Cor Segundo as regras de pré-cadastro do DENATRAN:
     * 01-AMARELO;02-AZUL;03-BEGE;04-BRANCA;05-CINZA;06-DOURADA;07-GRENA 
     * 08-LARANJA;09-MARROM;10-PRATA;11-PRETA;12-ROSA;13-ROXA;14-VERDE;15-VERMELHA;16-FANTASIA
     *
     * @param string $cCorDENATRAN
     * @return self
     */
    public function setCCorDENATRAN($cCorDENATRAN)
    {
        $this->cCorDENATRAN = $cCorDENATRAN;
        return $this;
    }

    /**
     * Gets as lota
     *
     * Quantidade máxima de permitida de passageiros sentados, inclusive motorista.
     *
     * @return string
     */
    public function getLota()
    {
        return $this->lota;
    }

    /**
     * Sets a new lota
     *
     * Quantidade máxima de permitida de passageiros sentados, inclusive motorista.
     *
     * @param string $lota
     * @return self
     */
    public function setLota($lota)
    {
        $this->lota = $lota;
        return $this;
    }

    /**
     * Gets as tpRest
     *
     * Restrição
     * 0 - Não há;
     * 1 - Alienação Fiduciária;
     * 2 - Arrendamento Mercantil;
     * 3 - Reserva de Domínio;
     * 4 - Penhor de Veículos;
     * 9 - outras.
     *
     * @return string
     */
    public function getTpRest()
    {
        return $this->tpRest;
    }

    /**
     * Sets a new tpRest
     *
     * Restrição
     * 0 - Não há;
     * 1 - Alienação Fiduciária;
     * 2 - Arrendamento Mercantil;
     * 3 - Reserva de Domínio;
     * 4 - Penhor de Veículos;
     * 9 - outras.
     *
     * @param string $tpRest
     * @return self
     */
    public function setTpRest($tpRest)
    {
        $this->tpRest = $tpRest;
        return $this;
    }


}

