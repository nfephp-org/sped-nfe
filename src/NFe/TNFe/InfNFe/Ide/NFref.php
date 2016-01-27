<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Ide;

/**
 * Class representing NFref
 */
class NFref
{

    /**
     * Chave de acesso das NF-e referenciadas. Chave de acesso compostas por Código da
     * UF (tabela do IBGE) + AAMM da emissão + CNPJ do Emitente + modelo, série e
     * número da NF-e Referenciada + Código Numérico + DV.
     *
     * @property string $refNFe
     */
    private $refNFe = null;

    /**
     * Dados da NF modelo 1/1A referenciada
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNF $refNF
     */
    private $refNF = null;

    /**
     * Grupo com as informações NF de produtor referenciada
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNFP $refNFP
     */
    private $refNFP = null;

    /**
     * Utilizar esta TAG para referenciar um CT-e emitido anteriormente, vinculada a
     * NF-e atual
     *
     * @property string $refCTe
     */
    private $refCTe = null;

    /**
     * Grupo do Cupom Fiscal vinculado à NF-e
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefECF $refECF
     */
    private $refECF = null;

    /**
     * Gets as refNFe
     *
     * Chave de acesso das NF-e referenciadas. Chave de acesso compostas por Código da
     * UF (tabela do IBGE) + AAMM da emissão + CNPJ do Emitente + modelo, série e
     * número da NF-e Referenciada + Código Numérico + DV.
     *
     * @return string
     */
    public function getRefNFe()
    {
        return $this->refNFe;
    }

    /**
     * Sets a new refNFe
     *
     * Chave de acesso das NF-e referenciadas. Chave de acesso compostas por Código da
     * UF (tabela do IBGE) + AAMM da emissão + CNPJ do Emitente + modelo, série e
     * número da NF-e Referenciada + Código Numérico + DV.
     *
     * @param string $refNFe
     * @return self
     */
    public function setRefNFe($refNFe)
    {
        $this->refNFe = $refNFe;
        return $this;
    }

    /**
     * Gets as refNF
     *
     * Dados da NF modelo 1/1A referenciada
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNF
     */
    public function getRefNF()
    {
        return $this->refNF;
    }

    /**
     * Sets a new refNF
     *
     * Dados da NF modelo 1/1A referenciada
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNF $refNF
     * @return self
     */
    public function setRefNF(\NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNF $refNF)
    {
        $this->refNF = $refNF;
        return $this;
    }

    /**
     * Gets as refNFP
     *
     * Grupo com as informações NF de produtor referenciada
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNFP
     */
    public function getRefNFP()
    {
        return $this->refNFP;
    }

    /**
     * Sets a new refNFP
     *
     * Grupo com as informações NF de produtor referenciada
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNFP $refNFP
     * @return self
     */
    public function setRefNFP(\NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefNFP $refNFP)
    {
        $this->refNFP = $refNFP;
        return $this;
    }

    /**
     * Gets as refCTe
     *
     * Utilizar esta TAG para referenciar um CT-e emitido anteriormente, vinculada a
     * NF-e atual
     *
     * @return string
     */
    public function getRefCTe()
    {
        return $this->refCTe;
    }

    /**
     * Sets a new refCTe
     *
     * Utilizar esta TAG para referenciar um CT-e emitido anteriormente, vinculada a
     * NF-e atual
     *
     * @param string $refCTe
     * @return self
     */
    public function setRefCTe($refCTe)
    {
        $this->refCTe = $refCTe;
        return $this;
    }

    /**
     * Gets as refECF
     *
     * Grupo do Cupom Fiscal vinculado à NF-e
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefECF
     */
    public function getRefECF()
    {
        return $this->refECF;
    }

    /**
     * Sets a new refECF
     *
     * Grupo do Cupom Fiscal vinculado à NF-e
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefECF $refECF
     * @return self
     */
    public function setRefECF(\NFePHP\NFe\NFe\TNFe\InfNFe\Ide\NFref\RefECF $refECF)
    {
        $this->refECF = $refECF;
        return $this;
    }


}

