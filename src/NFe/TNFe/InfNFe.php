<?php

namespace NFePHP\NFe\NFe\TNFe;

/**
 * Class representing InfNFe
 */
class InfNFe
{

    /**
     * Versão do leiaute (v2.0)
     *
     * @property string $versao
     */
    private $versao = null;

    /**
     * PL_005d - 11/08/09 - validação do Id
     *
     * @property string $id
     */
    private $id = null;

    /**
     * identificação da NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Ide $ide
     */
    private $ide = null;

    /**
     * Identificação do emitente
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Emit $emit
     */
    private $emit = null;

    /**
     * Emissão de avulsa, informar os dados do Fisco emitente
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Avulsa $avulsa
     */
    private $avulsa = null;

    /**
     * Identificação do Destinatário
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Dest $dest
     */
    private $dest = null;

    /**
     * Identificação do Local de Retirada (informar apenas quando for diferente do
     * endereço do remetente)
     *
     * @property \NFePHP\NFe\NFe\TLocal $retirada
     */
    private $retirada = null;

    /**
     * Identificação do Local de Entrega (informar apenas quando for diferente do
     * endereço do destinatário)
     *
     * @property \NFePHP\NFe\NFe\TLocal $entrega
     */
    private $entrega = null;

    /**
     * Pessoas autorizadas para o download do XML da NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\AutXML[] $autXML
     */
    private $autXML = null;

    /**
     * Dados dos detalhes da NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det[] $det
     */
    private $det = null;

    /**
     * Dados dos totais da NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Total $total
     */
    private $total = null;

    /**
     * Dados dos transportes da NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Transp $transp
     */
    private $transp = null;

    /**
     * Dados da cobrança da NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Cobr $cobr
     */
    private $cobr = null;

    /**
     * Dados de Pagamento. Obrigatório apenas para (NFC-e) NT 2012/004
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Pag[] $pag
     */
    private $pag = null;

    /**
     * Informações adicionais da NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic $infAdic
     */
    private $infAdic = null;

    /**
     * Informações de exportação
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Exporta $exporta
     */
    private $exporta = null;

    /**
     * Informações de compras (Nota de Empenho, Pedido e Contrato)
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Compra $compra
     */
    private $compra = null;

    /**
     * Informações de registro aquisições de cana
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Cana $cana
     */
    private $cana = null;

    /**
     * Gets as versao
     *
     * Versão do leiaute (v2.0)
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
     * Versão do leiaute (v2.0)
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
     * Gets as id
     *
     * PL_005d - 11/08/09 - validação do Id
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
     * PL_005d - 11/08/09 - validação do Id
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
     * Gets as ide
     *
     * identificação da NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Ide
     */
    public function getIde()
    {
        return $this->ide;
    }

    /**
     * Sets a new ide
     *
     * identificação da NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Ide $ide
     * @return self
     */
    public function setIde(\NFePHP\NFe\NFe\TNFe\InfNFe\Ide $ide)
    {
        $this->ide = $ide;
        return $this;
    }

    /**
     * Gets as emit
     *
     * Identificação do emitente
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Emit
     */
    public function getEmit()
    {
        return $this->emit;
    }

    /**
     * Sets a new emit
     *
     * Identificação do emitente
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Emit $emit
     * @return self
     */
    public function setEmit(\NFePHP\NFe\NFe\TNFe\InfNFe\Emit $emit)
    {
        $this->emit = $emit;
        return $this;
    }

    /**
     * Gets as avulsa
     *
     * Emissão de avulsa, informar os dados do Fisco emitente
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Avulsa
     */
    public function getAvulsa()
    {
        return $this->avulsa;
    }

    /**
     * Sets a new avulsa
     *
     * Emissão de avulsa, informar os dados do Fisco emitente
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Avulsa $avulsa
     * @return self
     */
    public function setAvulsa(\NFePHP\NFe\NFe\TNFe\InfNFe\Avulsa $avulsa)
    {
        $this->avulsa = $avulsa;
        return $this;
    }

    /**
     * Gets as dest
     *
     * Identificação do Destinatário
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Dest
     */
    public function getDest()
    {
        return $this->dest;
    }

    /**
     * Sets a new dest
     *
     * Identificação do Destinatário
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Dest $dest
     * @return self
     */
    public function setDest(\NFePHP\NFe\NFe\TNFe\InfNFe\Dest $dest)
    {
        $this->dest = $dest;
        return $this;
    }

    /**
     * Gets as retirada
     *
     * Identificação do Local de Retirada (informar apenas quando for diferente do
     * endereço do remetente)
     *
     * @return \NFePHP\NFe\NFe\TLocal
     */
    public function getRetirada()
    {
        return $this->retirada;
    }

    /**
     * Sets a new retirada
     *
     * Identificação do Local de Retirada (informar apenas quando for diferente do
     * endereço do remetente)
     *
     * @param \NFePHP\NFe\NFe\TLocal $retirada
     * @return self
     */
    public function setRetirada(\NFePHP\NFe\NFe\TLocal $retirada)
    {
        $this->retirada = $retirada;
        return $this;
    }

    /**
     * Gets as entrega
     *
     * Identificação do Local de Entrega (informar apenas quando for diferente do
     * endereço do destinatário)
     *
     * @return \NFePHP\NFe\NFe\TLocal
     */
    public function getEntrega()
    {
        return $this->entrega;
    }

    /**
     * Sets a new entrega
     *
     * Identificação do Local de Entrega (informar apenas quando for diferente do
     * endereço do destinatário)
     *
     * @param \NFePHP\NFe\NFe\TLocal $entrega
     * @return self
     */
    public function setEntrega(\NFePHP\NFe\NFe\TLocal $entrega)
    {
        $this->entrega = $entrega;
        return $this;
    }

    /**
     * Adds as autXML
     *
     * Pessoas autorizadas para o download do XML da NF-e
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\AutXML $autXML
     */
    public function addToAutXML(\NFePHP\NFe\NFe\TNFe\InfNFe\AutXML $autXML)
    {
        $this->autXML[] = $autXML;
        return $this;
    }

    /**
     * isset autXML
     *
     * Pessoas autorizadas para o download do XML da NF-e
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetAutXML($index)
    {
        return isset($this->autXML[$index]);
    }

    /**
     * unset autXML
     *
     * Pessoas autorizadas para o download do XML da NF-e
     *
     * @param scalar $index
     * @return void
     */
    public function unsetAutXML($index)
    {
        unset($this->autXML[$index]);
    }

    /**
     * Gets as autXML
     *
     * Pessoas autorizadas para o download do XML da NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\AutXML[]
     */
    public function getAutXML()
    {
        return $this->autXML;
    }

    /**
     * Sets a new autXML
     *
     * Pessoas autorizadas para o download do XML da NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\AutXML[] $autXML
     * @return self
     */
    public function setAutXML(array $autXML)
    {
        $this->autXML = $autXML;
        return $this;
    }

    /**
     * Adds as det
     *
     * Dados dos detalhes da NF-e
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det $det
     */
    public function addToDet(\NFePHP\NFe\NFe\TNFe\InfNFe\Det $det)
    {
        $this->det[] = $det;
        return $this;
    }

    /**
     * isset det
     *
     * Dados dos detalhes da NF-e
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDet($index)
    {
        return isset($this->det[$index]);
    }

    /**
     * unset det
     *
     * Dados dos detalhes da NF-e
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDet($index)
    {
        unset($this->det[$index]);
    }

    /**
     * Gets as det
     *
     * Dados dos detalhes da NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det[]
     */
    public function getDet()
    {
        return $this->det;
    }

    /**
     * Sets a new det
     *
     * Dados dos detalhes da NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det[] $det
     * @return self
     */
    public function setDet(array $det)
    {
        $this->det = $det;
        return $this;
    }

    /**
     * Gets as total
     *
     * Dados dos totais da NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Total
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Sets a new total
     *
     * Dados dos totais da NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Total $total
     * @return self
     */
    public function setTotal(\NFePHP\NFe\NFe\TNFe\InfNFe\Total $total)
    {
        $this->total = $total;
        return $this;
    }

    /**
     * Gets as transp
     *
     * Dados dos transportes da NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Transp
     */
    public function getTransp()
    {
        return $this->transp;
    }

    /**
     * Sets a new transp
     *
     * Dados dos transportes da NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Transp $transp
     * @return self
     */
    public function setTransp(\NFePHP\NFe\NFe\TNFe\InfNFe\Transp $transp)
    {
        $this->transp = $transp;
        return $this;
    }

    /**
     * Gets as cobr
     *
     * Dados da cobrança da NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Cobr
     */
    public function getCobr()
    {
        return $this->cobr;
    }

    /**
     * Sets a new cobr
     *
     * Dados da cobrança da NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Cobr $cobr
     * @return self
     */
    public function setCobr(\NFePHP\NFe\NFe\TNFe\InfNFe\Cobr $cobr)
    {
        $this->cobr = $cobr;
        return $this;
    }

    /**
     * Adds as pag
     *
     * Dados de Pagamento. Obrigatório apenas para (NFC-e) NT 2012/004
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Pag $pag
     */
    public function addToPag(\NFePHP\NFe\NFe\TNFe\InfNFe\Pag $pag)
    {
        $this->pag[] = $pag;
        return $this;
    }

    /**
     * isset pag
     *
     * Dados de Pagamento. Obrigatório apenas para (NFC-e) NT 2012/004
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetPag($index)
    {
        return isset($this->pag[$index]);
    }

    /**
     * unset pag
     *
     * Dados de Pagamento. Obrigatório apenas para (NFC-e) NT 2012/004
     *
     * @param scalar $index
     * @return void
     */
    public function unsetPag($index)
    {
        unset($this->pag[$index]);
    }

    /**
     * Gets as pag
     *
     * Dados de Pagamento. Obrigatório apenas para (NFC-e) NT 2012/004
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Pag[]
     */
    public function getPag()
    {
        return $this->pag;
    }

    /**
     * Sets a new pag
     *
     * Dados de Pagamento. Obrigatório apenas para (NFC-e) NT 2012/004
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Pag[] $pag
     * @return self
     */
    public function setPag(array $pag)
    {
        $this->pag = $pag;
        return $this;
    }

    /**
     * Gets as infAdic
     *
     * Informações adicionais da NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic
     */
    public function getInfAdic()
    {
        return $this->infAdic;
    }

    /**
     * Sets a new infAdic
     *
     * Informações adicionais da NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic $infAdic
     * @return self
     */
    public function setInfAdic(\NFePHP\NFe\NFe\TNFe\InfNFe\InfAdic $infAdic)
    {
        $this->infAdic = $infAdic;
        return $this;
    }

    /**
     * Gets as exporta
     *
     * Informações de exportação
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Exporta
     */
    public function getExporta()
    {
        return $this->exporta;
    }

    /**
     * Sets a new exporta
     *
     * Informações de exportação
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Exporta $exporta
     * @return self
     */
    public function setExporta(\NFePHP\NFe\NFe\TNFe\InfNFe\Exporta $exporta)
    {
        $this->exporta = $exporta;
        return $this;
    }

    /**
     * Gets as compra
     *
     * Informações de compras (Nota de Empenho, Pedido e Contrato)
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Compra
     */
    public function getCompra()
    {
        return $this->compra;
    }

    /**
     * Sets a new compra
     *
     * Informações de compras (Nota de Empenho, Pedido e Contrato)
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Compra $compra
     * @return self
     */
    public function setCompra(\NFePHP\NFe\NFe\TNFe\InfNFe\Compra $compra)
    {
        $this->compra = $compra;
        return $this;
    }

    /**
     * Gets as cana
     *
     * Informações de registro aquisições de cana
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Cana
     */
    public function getCana()
    {
        return $this->cana;
    }

    /**
     * Sets a new cana
     *
     * Informações de registro aquisições de cana
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Cana $cana
     * @return self
     */
    public function setCana(\NFePHP\NFe\NFe\TNFe\InfNFe\Cana $cana)
    {
        $this->cana = $cana;
        return $this;
    }


}

