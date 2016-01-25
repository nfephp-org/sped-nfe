<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType;

/**
 * Class representing DestAType
 */
class DestAType
{

    /**
     * Número do CNPJ
     *
     * @property string $cNPJ
     */
    private $cNPJ = null;

    /**
     * Número do CPF
     *
     * @property string $cPF
     */
    private $cPF = null;

    /**
     * Identificador do destinatário, em caso de comprador estrangeiro
     *
     * @property string $idEstrangeiro
     */
    private $idEstrangeiro = null;

    /**
     * Razão Social ou nome do destinatário
     *
     * @property string $xNome
     */
    private $xNome = null;

    /**
     * Dados do endereço
     *
     * @property \NFePHP\NFe\NFe\TEnderecoType $enderDest
     */
    private $enderDest = null;

    /**
     * Indicador da IE do destinatário:
     * 1 – Contribuinte ICMSpagamento à vista;
     * 2 – Contribuinte isento de inscrição;
     * 9 – Não Contribuinte
     *
     * @property string $indIEDest
     */
    private $indIEDest = null;

    /**
     * Inscrição Estadual (obrigatório nas operações com contribuintes do ICMS)
     *
     * @property string $iE
     */
    private $iE = null;

    /**
     * Inscrição na SUFRAMA (Obrigatório nas operações com as áreas com
     * benefícios de incentivos fiscais sob controle da SUFRAMA) PL_005d - 11/08/09 -
     * alterado para aceitar 8 ou 9 dígitos
     *
     * @property string $iSUF
     */
    private $iSUF = null;

    /**
     * Inscrição Municipal do tomador do serviço
     *
     * @property string $iM
     */
    private $iM = null;

    /**
     * Informar o e-mail do destinatário. O campo pode ser utilizado para informar o
     * e-mail
     * de recepção da NF-e indicada pelo destinatário
     *
     * @property string $email
     */
    private $email = null;

    /**
     * Gets as cNPJ
     *
     * Número do CNPJ
     *
     * @return string
     */
    public function getCNPJ()
    {
        return $this->cNPJ;
    }

    /**
     * Sets a new cNPJ
     *
     * Número do CNPJ
     *
     * @param string $cNPJ
     * @return self
     */
    public function setCNPJ($cNPJ)
    {
        $this->cNPJ = $cNPJ;
        return $this;
    }

    /**
     * Gets as cPF
     *
     * Número do CPF
     *
     * @return string
     */
    public function getCPF()
    {
        return $this->cPF;
    }

    /**
     * Sets a new cPF
     *
     * Número do CPF
     *
     * @param string $cPF
     * @return self
     */
    public function setCPF($cPF)
    {
        $this->cPF = $cPF;
        return $this;
    }

    /**
     * Gets as idEstrangeiro
     *
     * Identificador do destinatário, em caso de comprador estrangeiro
     *
     * @return string
     */
    public function getIdEstrangeiro()
    {
        return $this->idEstrangeiro;
    }

    /**
     * Sets a new idEstrangeiro
     *
     * Identificador do destinatário, em caso de comprador estrangeiro
     *
     * @param string $idEstrangeiro
     * @return self
     */
    public function setIdEstrangeiro($idEstrangeiro)
    {
        $this->idEstrangeiro = $idEstrangeiro;
        return $this;
    }

    /**
     * Gets as xNome
     *
     * Razão Social ou nome do destinatário
     *
     * @return string
     */
    public function getXNome()
    {
        return $this->xNome;
    }

    /**
     * Sets a new xNome
     *
     * Razão Social ou nome do destinatário
     *
     * @param string $xNome
     * @return self
     */
    public function setXNome($xNome)
    {
        $this->xNome = $xNome;
        return $this;
    }

    /**
     * Gets as enderDest
     *
     * Dados do endereço
     *
     * @return \NFePHP\NFe\NFe\TEnderecoType
     */
    public function getEnderDest()
    {
        return $this->enderDest;
    }

    /**
     * Sets a new enderDest
     *
     * Dados do endereço
     *
     * @param \NFePHP\NFe\NFe\TEnderecoType $enderDest
     * @return self
     */
    public function setEnderDest(\NFePHP\NFe\NFe\TEnderecoType $enderDest)
    {
        $this->enderDest = $enderDest;
        return $this;
    }

    /**
     * Gets as indIEDest
     *
     * Indicador da IE do destinatário:
     * 1 – Contribuinte ICMSpagamento à vista;
     * 2 – Contribuinte isento de inscrição;
     * 9 – Não Contribuinte
     *
     * @return string
     */
    public function getIndIEDest()
    {
        return $this->indIEDest;
    }

    /**
     * Sets a new indIEDest
     *
     * Indicador da IE do destinatário:
     * 1 – Contribuinte ICMSpagamento à vista;
     * 2 – Contribuinte isento de inscrição;
     * 9 – Não Contribuinte
     *
     * @param string $indIEDest
     * @return self
     */
    public function setIndIEDest($indIEDest)
    {
        $this->indIEDest = $indIEDest;
        return $this;
    }

    /**
     * Gets as iE
     *
     * Inscrição Estadual (obrigatório nas operações com contribuintes do ICMS)
     *
     * @return string
     */
    public function getIE()
    {
        return $this->iE;
    }

    /**
     * Sets a new iE
     *
     * Inscrição Estadual (obrigatório nas operações com contribuintes do ICMS)
     *
     * @param string $iE
     * @return self
     */
    public function setIE($iE)
    {
        $this->iE = $iE;
        return $this;
    }

    /**
     * Gets as iSUF
     *
     * Inscrição na SUFRAMA (Obrigatório nas operações com as áreas com
     * benefícios de incentivos fiscais sob controle da SUFRAMA) PL_005d - 11/08/09 -
     * alterado para aceitar 8 ou 9 dígitos
     *
     * @return string
     */
    public function getISUF()
    {
        return $this->iSUF;
    }

    /**
     * Sets a new iSUF
     *
     * Inscrição na SUFRAMA (Obrigatório nas operações com as áreas com
     * benefícios de incentivos fiscais sob controle da SUFRAMA) PL_005d - 11/08/09 -
     * alterado para aceitar 8 ou 9 dígitos
     *
     * @param string $iSUF
     * @return self
     */
    public function setISUF($iSUF)
    {
        $this->iSUF = $iSUF;
        return $this;
    }

    /**
     * Gets as iM
     *
     * Inscrição Municipal do tomador do serviço
     *
     * @return string
     */
    public function getIM()
    {
        return $this->iM;
    }

    /**
     * Sets a new iM
     *
     * Inscrição Municipal do tomador do serviço
     *
     * @param string $iM
     * @return self
     */
    public function setIM($iM)
    {
        $this->iM = $iM;
        return $this;
    }

    /**
     * Gets as email
     *
     * Informar o e-mail do destinatário. O campo pode ser utilizado para informar o
     * e-mail
     * de recepção da NF-e indicada pelo destinatário
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets a new email
     *
     * Informar o e-mail do destinatário. O campo pode ser utilizado para informar o
     * e-mail
     * de recepção da NF-e indicada pelo destinatário
     *
     * @param string $email
     * @return self
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }


}

