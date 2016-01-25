<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\ICMSAType;

/**
 * Class representing ICMS40AType
 */
class ICMS40AType
{

    /**
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno
     *
     * @property string $orig
     */
    private $orig = null;

    /**
     * Tributação pelo ICMS 
     * 40 - Isenta 
     * 41 - Não tributada 
     * 50 - Suspensão 
     * 51 - Diferimento
     *
     * @property string $cST
     */
    private $cST = null;

    /**
     * O valor do ICMS será informado apenas nas operações com veículos
     * beneficiados com a desoneração condicional do ICMS.
     *
     * @property string $vICMSDeson
     */
    private $vICMSDeson = null;

    /**
     * Este campo será preenchido quando o campo anterior estiver preenchido.
     * Informar o motivo da desoneração:
     * 1 – Táxi;
     * 3 – Produtor Agropecuário;
     * 4 – Frotista/Locadora;
     * 5 – Diplomático/Consular;
     * 6 – Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre
     * Comércio (Resolução 714/88 e 790/94 – CONTRAN e suas alterações);
     * 7 – SUFRAMA;
     * 8 - Venda a órgão Público;
     * 9 – Outros
     * 10- Deficiente Condutor
     * 11- Deficiente não condutor
     * 16 - Olimpíadas Rio 2016
     *
     * @property string $motDesICMS
     */
    private $motDesICMS = null;

    /**
     * Gets as orig
     *
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno
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
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno
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
     * Gets as cST
     *
     * Tributação pelo ICMS 
     * 40 - Isenta 
     * 41 - Não tributada 
     * 50 - Suspensão 
     * 51 - Diferimento
     *
     * @return string
     */
    public function getCST()
    {
        return $this->cST;
    }

    /**
     * Sets a new cST
     *
     * Tributação pelo ICMS 
     * 40 - Isenta 
     * 41 - Não tributada 
     * 50 - Suspensão 
     * 51 - Diferimento
     *
     * @param string $cST
     * @return self
     */
    public function setCST($cST)
    {
        $this->cST = $cST;
        return $this;
    }

    /**
     * Gets as vICMSDeson
     *
     * O valor do ICMS será informado apenas nas operações com veículos
     * beneficiados com a desoneração condicional do ICMS.
     *
     * @return string
     */
    public function getVICMSDeson()
    {
        return $this->vICMSDeson;
    }

    /**
     * Sets a new vICMSDeson
     *
     * O valor do ICMS será informado apenas nas operações com veículos
     * beneficiados com a desoneração condicional do ICMS.
     *
     * @param string $vICMSDeson
     * @return self
     */
    public function setVICMSDeson($vICMSDeson)
    {
        $this->vICMSDeson = $vICMSDeson;
        return $this;
    }

    /**
     * Gets as motDesICMS
     *
     * Este campo será preenchido quando o campo anterior estiver preenchido.
     * Informar o motivo da desoneração:
     * 1 – Táxi;
     * 3 – Produtor Agropecuário;
     * 4 – Frotista/Locadora;
     * 5 – Diplomático/Consular;
     * 6 – Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre
     * Comércio (Resolução 714/88 e 790/94 – CONTRAN e suas alterações);
     * 7 – SUFRAMA;
     * 8 - Venda a órgão Público;
     * 9 – Outros
     * 10- Deficiente Condutor
     * 11- Deficiente não condutor
     * 16 - Olimpíadas Rio 2016
     *
     * @return string
     */
    public function getMotDesICMS()
    {
        return $this->motDesICMS;
    }

    /**
     * Sets a new motDesICMS
     *
     * Este campo será preenchido quando o campo anterior estiver preenchido.
     * Informar o motivo da desoneração:
     * 1 – Táxi;
     * 3 – Produtor Agropecuário;
     * 4 – Frotista/Locadora;
     * 5 – Diplomático/Consular;
     * 6 – Utilitários e Motocicletas da Amazônia Ocidental e Áreas de Livre
     * Comércio (Resolução 714/88 e 790/94 – CONTRAN e suas alterações);
     * 7 – SUFRAMA;
     * 8 - Venda a órgão Público;
     * 9 – Outros
     * 10- Deficiente Condutor
     * 11- Deficiente não condutor
     * 16 - Olimpíadas Rio 2016
     *
     * @param string $motDesICMS
     * @return self
     */
    public function setMotDesICMS($motDesICMS)
    {
        $this->motDesICMS = $motDesICMS;
        return $this;
    }


}

