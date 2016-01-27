<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod;

/**
 * Class representing Comb
 */
class Comb
{

    /**
     * Código de produto da ANP. codificação de produtos do SIMP
     * (http://www.anp.gov.br)
     *
     * @property string $cProdANP
     */
    private $cProdANP = null;

    /**
     * Percentual de gas natural para o produto GLP
     *
     * @property string $pMixGN
     */
    private $pMixGN = null;

    /**
     * Código de autorização / registro do CODIF. Informar apenas quando a UF
     * utilizar o CODIF (Sistema de Controle do Diferimento do Imposto nas Operações
     * com AEAC - Álcool Etílico Anidro Combustível).
     *
     * @property string $cODIF
     */
    private $cODIF = null;

    /**
     * Quantidade de combustível
     * faturada à temperatura ambiente.
     * Informar quando a quantidade
     * faturada informada no campo
     * qCom (I10) tiver sido ajustada para
     * uma temperatura diferente da
     * ambiente.
     *
     * @property string $qTemp
     */
    private $qTemp = null;

    /**
     * Sigla da UF de Consumo
     *
     * @property string $uFCons
     */
    private $uFCons = null;

    /**
     * CIDE Combustíveis
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\CIDE $cIDE
     */
    private $cIDE = null;

    /**
     * Informações do grupo de "encerrante"
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\Encerrante $encerrante
     */
    private $encerrante = null;

    /**
     * Gets as cProdANP
     *
     * Código de produto da ANP. codificação de produtos do SIMP
     * (http://www.anp.gov.br)
     *
     * @return string
     */
    public function getCProdANP()
    {
        return $this->cProdANP;
    }

    /**
     * Sets a new cProdANP
     *
     * Código de produto da ANP. codificação de produtos do SIMP
     * (http://www.anp.gov.br)
     *
     * @param string $cProdANP
     * @return self
     */
    public function setCProdANP($cProdANP)
    {
        $this->cProdANP = $cProdANP;
        return $this;
    }

    /**
     * Gets as pMixGN
     *
     * Percentual de gas natural para o produto GLP
     *
     * @return string
     */
    public function getPMixGN()
    {
        return $this->pMixGN;
    }

    /**
     * Sets a new pMixGN
     *
     * Percentual de gas natural para o produto GLP
     *
     * @param string $pMixGN
     * @return self
     */
    public function setPMixGN($pMixGN)
    {
        $this->pMixGN = $pMixGN;
        return $this;
    }

    /**
     * Gets as cODIF
     *
     * Código de autorização / registro do CODIF. Informar apenas quando a UF
     * utilizar o CODIF (Sistema de Controle do Diferimento do Imposto nas Operações
     * com AEAC - Álcool Etílico Anidro Combustível).
     *
     * @return string
     */
    public function getCODIF()
    {
        return $this->cODIF;
    }

    /**
     * Sets a new cODIF
     *
     * Código de autorização / registro do CODIF. Informar apenas quando a UF
     * utilizar o CODIF (Sistema de Controle do Diferimento do Imposto nas Operações
     * com AEAC - Álcool Etílico Anidro Combustível).
     *
     * @param string $cODIF
     * @return self
     */
    public function setCODIF($cODIF)
    {
        $this->cODIF = $cODIF;
        return $this;
    }

    /**
     * Gets as qTemp
     *
     * Quantidade de combustível
     * faturada à temperatura ambiente.
     * Informar quando a quantidade
     * faturada informada no campo
     * qCom (I10) tiver sido ajustada para
     * uma temperatura diferente da
     * ambiente.
     *
     * @return string
     */
    public function getQTemp()
    {
        return $this->qTemp;
    }

    /**
     * Sets a new qTemp
     *
     * Quantidade de combustível
     * faturada à temperatura ambiente.
     * Informar quando a quantidade
     * faturada informada no campo
     * qCom (I10) tiver sido ajustada para
     * uma temperatura diferente da
     * ambiente.
     *
     * @param string $qTemp
     * @return self
     */
    public function setQTemp($qTemp)
    {
        $this->qTemp = $qTemp;
        return $this;
    }

    /**
     * Gets as uFCons
     *
     * Sigla da UF de Consumo
     *
     * @return string
     */
    public function getUFCons()
    {
        return $this->uFCons;
    }

    /**
     * Sets a new uFCons
     *
     * Sigla da UF de Consumo
     *
     * @param string $uFCons
     * @return self
     */
    public function setUFCons($uFCons)
    {
        $this->uFCons = $uFCons;
        return $this;
    }

    /**
     * Gets as cIDE
     *
     * CIDE Combustíveis
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\CIDE
     */
    public function getCIDE()
    {
        return $this->cIDE;
    }

    /**
     * Sets a new cIDE
     *
     * CIDE Combustíveis
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\CIDE $cIDE
     * @return self
     */
    public function setCIDE(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\CIDE $cIDE)
    {
        $this->cIDE = $cIDE;
        return $this;
    }

    /**
     * Gets as encerrante
     *
     * Informações do grupo de "encerrante"
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\Encerrante
     */
    public function getEncerrante()
    {
        return $this->encerrante;
    }

    /**
     * Sets a new encerrante
     *
     * Informações do grupo de "encerrante"
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\Encerrante $encerrante
     * @return self
     */
    public function setEncerrante(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb\Encerrante $encerrante)
    {
        $this->encerrante = $encerrante;
        return $this;
    }


}

