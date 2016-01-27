<?php

namespace NFePHP\NFe\NFe\TProtNFe;

/**
 * Class representing InfProt
 */
class InfProt
{

    /**
     * @property string $id
     */
    private $id = null;

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
     * Chaves de acesso da NF-e, compostas por: UF do emitente, AAMM da emissão da
     * NFe, CNPJ do emitente, modelo, série e número da NF-e e código numérico+DV.
     *
     * @property string $chNFe
     */
    private $chNFe = null;

    /**
     * Data e hora de processamento, no formato AAAA-MM-DDTHH:MM:SSTZD. Deve ser
     * preenchida com data e hora da gravação no Banco em caso de Confirmação. Em
     * caso de Rejeição, com data e hora do recebimento do Lote de NF-e enviado.
     *
     * @property string $dhRecbto
     */
    private $dhRecbto = null;

    /**
     * Número do Protocolo de Status da NF-e. 1 posição (1 – Secretaria de Fazenda
     * Estadual 2 – Receita Federal); 2 - códiga da UF - 2 posições ano; 10
     * seqüencial no ano.
     *
     * @property string $nProt
     */
    private $nProt = null;

    /**
     * Digest Value da NF-e processada. Utilizado para conferir a integridade da NF-e
     * original.
     *
     * @property mixed $digVal
     */
    private $digVal = null;

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
     * Gets as id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a new id
     *
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
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
     * Gets as chNFe
     *
     * Chaves de acesso da NF-e, compostas por: UF do emitente, AAMM da emissão da
     * NFe, CNPJ do emitente, modelo, série e número da NF-e e código numérico+DV.
     *
     * @return string
     */
    public function getChNFe()
    {
        return $this->chNFe;
    }

    /**
     * Sets a new chNFe
     *
     * Chaves de acesso da NF-e, compostas por: UF do emitente, AAMM da emissão da
     * NFe, CNPJ do emitente, modelo, série e número da NF-e e código numérico+DV.
     *
     * @param string $chNFe
     * @return self
     */
    public function setChNFe($chNFe)
    {
        $this->chNFe = $chNFe;
        return $this;
    }

    /**
     * Gets as dhRecbto
     *
     * Data e hora de processamento, no formato AAAA-MM-DDTHH:MM:SSTZD. Deve ser
     * preenchida com data e hora da gravação no Banco em caso de Confirmação. Em
     * caso de Rejeição, com data e hora do recebimento do Lote de NF-e enviado.
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
     * Data e hora de processamento, no formato AAAA-MM-DDTHH:MM:SSTZD. Deve ser
     * preenchida com data e hora da gravação no Banco em caso de Confirmação. Em
     * caso de Rejeição, com data e hora do recebimento do Lote de NF-e enviado.
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
     * Gets as nProt
     *
     * Número do Protocolo de Status da NF-e. 1 posição (1 – Secretaria de Fazenda
     * Estadual 2 – Receita Federal); 2 - códiga da UF - 2 posições ano; 10
     * seqüencial no ano.
     *
     * @return string
     */
    public function getNProt()
    {
        return $this->nProt;
    }

    /**
     * Sets a new nProt
     *
     * Número do Protocolo de Status da NF-e. 1 posição (1 – Secretaria de Fazenda
     * Estadual 2 – Receita Federal); 2 - códiga da UF - 2 posições ano; 10
     * seqüencial no ano.
     *
     * @param string $nProt
     * @return self
     */
    public function setNProt($nProt)
    {
        $this->nProt = $nProt;
        return $this;
    }

    /**
     * Gets as digVal
     *
     * Digest Value da NF-e processada. Utilizado para conferir a integridade da NF-e
     * original.
     *
     * @return mixed
     */
    public function getDigVal()
    {
        return $this->digVal;
    }

    /**
     * Sets a new digVal
     *
     * Digest Value da NF-e processada. Utilizado para conferir a integridade da NF-e
     * original.
     *
     * @param mixed $digVal
     * @return self
     */
    public function setDigVal($digVal)
    {
        $this->digVal = $digVal;
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


}

