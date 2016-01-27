<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TRetEnviNFe
 *
 * Tipo Retorno do Pedido de Autorização da Nota Fiscal Eletrônica
 * XSD Type: TRetEnviNFe
 */
class TRetEnviNFe
{

    /**
     * @property string $versao
     */
    private $versao = null;

    /**
     * Identificação do Ambiente:
     * 1 - Produção
     * 2 - Homologação
     *
     * @property string $tpAmb
     */
    private $tpAmb = null;

    /**
     * Versão do Aplicativo que recebeu o Lote.
     *
     * @property string $verAplic
     */
    private $verAplic = null;

    /**
     * Código do status da mensagem enviada.
     *
     * @property string $cStat
     */
    private $cStat = null;

    /**
     * Descrição literal do status do serviço solicitado.
     *
     * @property string $xMotivo
     */
    private $xMotivo = null;

    /**
     * código da UF de atendimento
     *
     * @property string $cUF
     */
    private $cUF = null;

    /**
     * Data e hora do recebimento, no formato AAAA-MM-DDTHH:MM:SSTZD
     *
     * @property string $dhRecbto
     */
    private $dhRecbto = null;

    /**
     * Dados do Recibo do Lote
     *
     * @property \NFePHP\NFe\NFe\TRetEnviNFe\InfRec $infRec
     */
    private $infRec = null;

    /**
     * Protocolo de status resultado do processamento sincrono da NFC-e
     *
     * @property \NFePHP\NFe\NFe\TProtNFe $protNFe
     */
    private $protNFe = null;

    /**
     * Gets as versao
     *
     * @return string
     */
    public function getVersao()
    {
        return $this->versao;
    }

    /**
     * Sets a new versao
     *
     * @param string $versao
     * @return self
     */
    public function setVersao($versao)
    {
        $this->versao = $versao;
        return $this;
    }

    /**
     * Gets as tpAmb
     *
     * Identificação do Ambiente:
     * 1 - Produção
     * 2 - Homologação
     *
     * @return string
     */
    public function getTpAmb()
    {
        return $this->tpAmb;
    }

    /**
     * Sets a new tpAmb
     *
     * Identificação do Ambiente:
     * 1 - Produção
     * 2 - Homologação
     *
     * @param string $tpAmb
     * @return self
     */
    public function setTpAmb($tpAmb)
    {
        $this->tpAmb = $tpAmb;
        return $this;
    }

    /**
     * Gets as verAplic
     *
     * Versão do Aplicativo que recebeu o Lote.
     *
     * @return string
     */
    public function getVerAplic()
    {
        return $this->verAplic;
    }

    /**
     * Sets a new verAplic
     *
     * Versão do Aplicativo que recebeu o Lote.
     *
     * @param string $verAplic
     * @return self
     */
    public function setVerAplic($verAplic)
    {
        $this->verAplic = $verAplic;
        return $this;
    }

    /**
     * Gets as cStat
     *
     * Código do status da mensagem enviada.
     *
     * @return string
     */
    public function getCStat()
    {
        return $this->cStat;
    }

    /**
     * Sets a new cStat
     *
     * Código do status da mensagem enviada.
     *
     * @param string $cStat
     * @return self
     */
    public function setCStat($cStat)
    {
        $this->cStat = $cStat;
        return $this;
    }

    /**
     * Gets as xMotivo
     *
     * Descrição literal do status do serviço solicitado.
     *
     * @return string
     */
    public function getXMotivo()
    {
        return $this->xMotivo;
    }

    /**
     * Sets a new xMotivo
     *
     * Descrição literal do status do serviço solicitado.
     *
     * @param string $xMotivo
     * @return self
     */
    public function setXMotivo($xMotivo)
    {
        $this->xMotivo = $xMotivo;
        return $this;
    }

    /**
     * Gets as cUF
     *
     * código da UF de atendimento
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
     * código da UF de atendimento
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
     * Gets as dhRecbto
     *
     * Data e hora do recebimento, no formato AAAA-MM-DDTHH:MM:SSTZD
     *
     * @return string
     */
    public function getDhRecbto()
    {
        return $this->dhRecbto;
    }

    /**
     * Sets a new dhRecbto
     *
     * Data e hora do recebimento, no formato AAAA-MM-DDTHH:MM:SSTZD
     *
     * @param string $dhRecbto
     * @return self
     */
    public function setDhRecbto($dhRecbto)
    {
        $this->dhRecbto = $dhRecbto;
        return $this;
    }

    /**
     * Gets as infRec
     *
     * Dados do Recibo do Lote
     *
     * @return \NFePHP\NFe\NFe\TRetEnviNFe\InfRec
     */
    public function getInfRec()
    {
        return $this->infRec;
    }

    /**
     * Sets a new infRec
     *
     * Dados do Recibo do Lote
     *
     * @param \NFePHP\NFe\NFe\TRetEnviNFe\InfRec $infRec
     * @return self
     */
    public function setInfRec(\NFePHP\NFe\NFe\TRetEnviNFe\InfRec $infRec)
    {
        $this->infRec = $infRec;
        return $this;
    }

    /**
     * Gets as protNFe
     *
     * Protocolo de status resultado do processamento sincrono da NFC-e
     *
     * @return \NFePHP\NFe\NFe\TProtNFe
     */
    public function getProtNFe()
    {
        return $this->protNFe;
    }

    /**
     * Sets a new protNFe
     *
     * Protocolo de status resultado do processamento sincrono da NFC-e
     *
     * @param \NFePHP\NFe\NFe\TProtNFe $protNFe
     * @return self
     */
    public function setProtNFe(\NFePHP\NFe\NFe\TProtNFe $protNFe)
    {
        $this->protNFe = $protNFe;
        return $this;
    }


}

