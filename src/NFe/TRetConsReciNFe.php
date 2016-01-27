<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TRetConsReciNFe
 *
 * Tipo Retorno do Pedido de Consulta do Recido do Lote de Notas Fiscais
 * Eletrônicas
 * XSD Type: TRetConsReciNFe
 */
class TRetConsReciNFe
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
     * Versão do Aplicativo que processou a NF-e
     *
     * @property string $verAplic
     */
    private $verAplic = null;

    /**
     * Número do Recibo Consultado
     *
     * @property string $nRec
     */
    private $nRec = null;

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
     * Data e hora de processamento, no formato AAAA-MM-DDTHH:MM:SSTZD. Em caso de
     * Rejeição, com data e hora do recebimento do Lote de NF-e enviado.
     *
     * @property string $dhRecbto
     */
    private $dhRecbto = null;

    /**
     * Código da Mensagem (v2.0) 
     * alterado para tamanho variavel 1-4. (NT2011/004)
     *
     * @property string $cMsg
     */
    private $cMsg = null;

    /**
     * Mensagem da SEFAZ para o emissor. (v2.0)
     *
     * @property string $xMsg
     */
    private $xMsg = null;

    /**
     * Protocolo de status resultado do processamento da NF-e
     *
     * @property \NFePHP\NFe\NFe\TProtNFe[] $protNFe
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
     * Versão do Aplicativo que processou a NF-e
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
     * Versão do Aplicativo que processou a NF-e
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
     * Gets as nRec
     *
     * Número do Recibo Consultado
     *
     * @return string
     */
    public function getNRec()
    {
        return $this->nRec;
    }

    /**
     * Sets a new nRec
     *
     * Número do Recibo Consultado
     *
     * @param string $nRec
     * @return self
     */
    public function setNRec($nRec)
    {
        $this->nRec = $nRec;
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
     * Data e hora de processamento, no formato AAAA-MM-DDTHH:MM:SSTZD. Em caso de
     * Rejeição, com data e hora do recebimento do Lote de NF-e enviado.
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
     * Data e hora de processamento, no formato AAAA-MM-DDTHH:MM:SSTZD. Em caso de
     * Rejeição, com data e hora do recebimento do Lote de NF-e enviado.
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
     * Gets as cMsg
     *
     * Código da Mensagem (v2.0) 
     * alterado para tamanho variavel 1-4. (NT2011/004)
     *
     * @return string
     */
    public function getCMsg()
    {
        return $this->cMsg;
    }

    /**
     * Sets a new cMsg
     *
     * Código da Mensagem (v2.0) 
     * alterado para tamanho variavel 1-4. (NT2011/004)
     *
     * @param string $cMsg
     * @return self
     */
    public function setCMsg($cMsg)
    {
        $this->cMsg = $cMsg;
        return $this;
    }

    /**
     * Gets as xMsg
     *
     * Mensagem da SEFAZ para o emissor. (v2.0)
     *
     * @return string
     */
    public function getXMsg()
    {
        return $this->xMsg;
    }

    /**
     * Sets a new xMsg
     *
     * Mensagem da SEFAZ para o emissor. (v2.0)
     *
     * @param string $xMsg
     * @return self
     */
    public function setXMsg($xMsg)
    {
        $this->xMsg = $xMsg;
        return $this;
    }

    /**
     * Adds as protNFe
     *
     * Protocolo de status resultado do processamento da NF-e
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TProtNFe $protNFe
     */
    public function addToProtNFe(\NFePHP\NFe\NFe\TProtNFe $protNFe)
    {
        $this->protNFe[] = $protNFe;
        return $this;
    }

    /**
     * isset protNFe
     *
     * Protocolo de status resultado do processamento da NF-e
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetProtNFe($index)
    {
        return isset($this->protNFe[$index]);
    }

    /**
     * unset protNFe
     *
     * Protocolo de status resultado do processamento da NF-e
     *
     * @param scalar $index
     * @return void
     */
    public function unsetProtNFe($index)
    {
        unset($this->protNFe[$index]);
    }

    /**
     * Gets as protNFe
     *
     * Protocolo de status resultado do processamento da NF-e
     *
     * @return \NFePHP\NFe\NFe\TProtNFe[]
     */
    public function getProtNFe()
    {
        return $this->protNFe;
    }

    /**
     * Sets a new protNFe
     *
     * Protocolo de status resultado do processamento da NF-e
     *
     * @param \NFePHP\NFe\NFe\TProtNFe[] $protNFe
     * @return self
     */
    public function setProtNFe(array $protNFe)
    {
        $this->protNFe = $protNFe;
        return $this;
    }


}

