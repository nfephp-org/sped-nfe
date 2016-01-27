<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\ICMS;

/**
 * Class representing ICMSSN102
 */
class ICMSSN102
{

    /**
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno 
     * (v2.0)
     *
     * @property string $orig
     */
    private $orig = null;

    /**
     * 102- Tributada pelo Simples Nacional sem permissão de crédito. 
     * 103 – Isenção do ICMS no Simples Nacional para faixa de receita bruta.
     * 300 – Imune.
     * 400 – Não tributda pelo Simples Nacional (v.2.0) (v.2.0)
     *
     * @property string $cSOSN
     */
    private $cSOSN = null;

    /**
     * Gets as orig
     *
     * origem da mercadoria: 0 - Nacional 
     * 1 - Estrangeira - Importação direta 
     * 2 - Estrangeira - Adquirida no mercado interno 
     * (v2.0)
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
     * (v2.0)
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
     * 102- Tributada pelo Simples Nacional sem permissão de crédito. 
     * 103 – Isenção do ICMS no Simples Nacional para faixa de receita bruta.
     * 300 – Imune.
     * 400 – Não tributda pelo Simples Nacional (v.2.0) (v.2.0)
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
     * 102- Tributada pelo Simples Nacional sem permissão de crédito. 
     * 103 – Isenção do ICMS no Simples Nacional para faixa de receita bruta.
     * 300 – Imune.
     * 400 – Não tributda pelo Simples Nacional (v.2.0) (v.2.0)
     *
     * @param string $cSOSN
     * @return self
     */
    public function setCSOSN($cSOSN)
    {
        $this->cSOSN = $cSOSN;
        return $this;
    }


}

