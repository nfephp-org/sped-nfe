<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType;

/**
 * Class representing ICMSSN201AType
 */
class ICMSSN201AType
{

    /**
     * Origem da mercadoria:
     * 0 – Nacional;
     * 1 – Estrangeira – Importação direta;
     * 2 – Estrangeira – Adquirida no mercado interno. (v2.0)
     *
     * @property string $orig
     */
    private $orig = null;

    /**
     * 201- Tributada pelo Simples Nacional com permissão de crédito e com cobrança
     * do ICMS por Substituição Tributária (v.2.0)
     *
     * @property string $cSOSN
     */
    private $cSOSN = null;

    /**
     * Modalidade de determinação da BC do ICMS ST:
     * 0 – Preço tabelado ou máximo sugerido;
     * 1 - Lista Negativa (valor);
     * 2 - Lista Positiva (valor);
     * 3 - Lista Neutra (valor);
     * 4 - Margem Valor Agregado (%);
     * 5 - Pauta (valor). (v2.0)
     *
     * @property string $modBCST
     */
    private $modBCST = null;

    /**
     * Percentual da Margem de Valor Adicionado ICMS ST (v2.0)
     *
     * @property string $pMVAST
     */
    private $pMVAST = null;

    /**
     * Percentual de redução da BC ICMS ST (v2.0)
     *
     * @property string $pRedBCST
     */
    private $pRedBCST = null;

    /**
     * Valor da BC do ICMS ST (v2.0)
     *
     * @property string $vBCST
     */
    private $vBCST = null;

    /**
     * Alíquota do ICMS ST (v2.0)
     *
     * @property string $pICMSST
     */
    private $pICMSST = null;

    /**
     * Valor do ICMS ST (v2.0)
     *
     * @property string $vICMSST
     */
    private $vICMSST = null;

    /**
     * Alíquota aplicável de cálculo do crédito (Simples Nacional). (v2.0)
     *
     * @property string $pCredSN
     */
    private $pCredSN = null;

    /**
     * Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123
     * (Simples Nacional) (v2.0)
     *
     * @property string $vCredICMSSN
     */
    private $vCredICMSSN = null;

    /**
     * Gets as orig
     *
     * Origem da mercadoria:
     * 0 – Nacional;
     * 1 – Estrangeira – Importação direta;
     * 2 – Estrangeira – Adquirida no mercado interno. (v2.0)
     *
     * @return string
     */
    public function getOrig()
    {
        return $this->orig;
    }

    /**
     * Sets a new orig
     *
     * Origem da mercadoria:
     * 0 – Nacional;
     * 1 – Estrangeira – Importação direta;
     * 2 – Estrangeira – Adquirida no mercado interno. (v2.0)
     *
     * @param string $orig
     * @return self
     */
    public function setOrig($orig)
    {
        $this->orig = $orig;
        return $this;
    }

    /**
     * Gets as cSOSN
     *
     * 201- Tributada pelo Simples Nacional com permissão de crédito e com cobrança
     * do ICMS por Substituição Tributária (v.2.0)
     *
     * @return string
     */
    public function getCSOSN()
    {
        return $this->cSOSN;
    }

    /**
     * Sets a new cSOSN
     *
     * 201- Tributada pelo Simples Nacional com permissão de crédito e com cobrança
     * do ICMS por Substituição Tributária (v.2.0)
     *
     * @param string $cSOSN
     * @return self
     */
    public function setCSOSN($cSOSN)
    {
        $this->cSOSN = $cSOSN;
        return $this;
    }

    /**
     * Gets as modBCST
     *
     * Modalidade de determinação da BC do ICMS ST:
     * 0 – Preço tabelado ou máximo sugerido;
     * 1 - Lista Negativa (valor);
     * 2 - Lista Positiva (valor);
     * 3 - Lista Neutra (valor);
     * 4 - Margem Valor Agregado (%);
     * 5 - Pauta (valor). (v2.0)
     *
     * @return string
     */
    public function getModBCST()
    {
        return $this->modBCST;
    }

    /**
     * Sets a new modBCST
     *
     * Modalidade de determinação da BC do ICMS ST:
     * 0 – Preço tabelado ou máximo sugerido;
     * 1 - Lista Negativa (valor);
     * 2 - Lista Positiva (valor);
     * 3 - Lista Neutra (valor);
     * 4 - Margem Valor Agregado (%);
     * 5 - Pauta (valor). (v2.0)
     *
     * @param string $modBCST
     * @return self
     */
    public function setModBCST($modBCST)
    {
        $this->modBCST = $modBCST;
        return $this;
    }

    /**
     * Gets as pMVAST
     *
     * Percentual da Margem de Valor Adicionado ICMS ST (v2.0)
     *
     * @return string
     */
    public function getPMVAST()
    {
        return $this->pMVAST;
    }

    /**
     * Sets a new pMVAST
     *
     * Percentual da Margem de Valor Adicionado ICMS ST (v2.0)
     *
     * @param string $pMVAST
     * @return self
     */
    public function setPMVAST($pMVAST)
    {
        $this->pMVAST = $pMVAST;
        return $this;
    }

    /**
     * Gets as pRedBCST
     *
     * Percentual de redução da BC ICMS ST (v2.0)
     *
     * @return string
     */
    public function getPRedBCST()
    {
        return $this->pRedBCST;
    }

    /**
     * Sets a new pRedBCST
     *
     * Percentual de redução da BC ICMS ST (v2.0)
     *
     * @param string $pRedBCST
     * @return self
     */
    public function setPRedBCST($pRedBCST)
    {
        $this->pRedBCST = $pRedBCST;
        return $this;
    }

    /**
     * Gets as vBCST
     *
     * Valor da BC do ICMS ST (v2.0)
     *
     * @return string
     */
    public function getVBCST()
    {
        return $this->vBCST;
    }

    /**
     * Sets a new vBCST
     *
     * Valor da BC do ICMS ST (v2.0)
     *
     * @param string $vBCST
     * @return self
     */
    public function setVBCST($vBCST)
    {
        $this->vBCST = $vBCST;
        return $this;
    }

    /**
     * Gets as pICMSST
     *
     * Alíquota do ICMS ST (v2.0)
     *
     * @return string
     */
    public function getPICMSST()
    {
        return $this->pICMSST;
    }

    /**
     * Sets a new pICMSST
     *
     * Alíquota do ICMS ST (v2.0)
     *
     * @param string $pICMSST
     * @return self
     */
    public function setPICMSST($pICMSST)
    {
        $this->pICMSST = $pICMSST;
        return $this;
    }

    /**
     * Gets as vICMSST
     *
     * Valor do ICMS ST (v2.0)
     *
     * @return string
     */
    public function getVICMSST()
    {
        return $this->vICMSST;
    }

    /**
     * Sets a new vICMSST
     *
     * Valor do ICMS ST (v2.0)
     *
     * @param string $vICMSST
     * @return self
     */
    public function setVICMSST($vICMSST)
    {
        $this->vICMSST = $vICMSST;
        return $this;
    }

    /**
     * Gets as pCredSN
     *
     * Alíquota aplicável de cálculo do crédito (Simples Nacional). (v2.0)
     *
     * @return string
     */
    public function getPCredSN()
    {
        return $this->pCredSN;
    }

    /**
     * Sets a new pCredSN
     *
     * Alíquota aplicável de cálculo do crédito (Simples Nacional). (v2.0)
     *
     * @param string $pCredSN
     * @return self
     */
    public function setPCredSN($pCredSN)
    {
        $this->pCredSN = $pCredSN;
        return $this;
    }

    /**
     * Gets as vCredICMSSN
     *
     * Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123
     * (Simples Nacional) (v2.0)
     *
     * @return string
     */
    public function getVCredICMSSN()
    {
        return $this->vCredICMSSN;
    }

    /**
     * Sets a new vCredICMSSN
     *
     * Valor crédito do ICMS que pode ser aproveitado nos termos do art. 23 da LC 123
     * (Simples Nacional) (v2.0)
     *
     * @param string $vCredICMSSN
     * @return self
     */
    public function setVCredICMSSN($vCredICMSSN)
    {
        $this->vCredICMSSN = $vCredICMSSN;
        return $this;
    }


}

