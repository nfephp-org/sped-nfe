<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto;

/**
 * Class representing PIS
 */
class PIS
{

    /**
     * Código de Situação Tributária do PIS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISAliq $pISAliq
     */
    private $pISAliq = null;

    /**
     * Código de Situação Tributária do PIS.
     * 03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota
     * por Unidade de Produto;
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISQtde $pISQtde
     */
    private $pISQtde = null;

    /**
     * Código de Situação Tributária do PIS.
     * 04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
     * 06 - Operação Tributável - Alíquota Zero;
     * 07 - Operação Isenta da contribuição;
     * 08 - Operação Sem Incidência da contribuição;
     * 09 - Operação com suspensão da contribuição;
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISNT $pISNT
     */
    private $pISNT = null;

    /**
     * Código de Situação Tributária do PIS.
     * 99 - Outras Operações.
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISOutr $pISOutr
     */
    private $pISOutr = null;

    /**
     * Gets as pISAliq
     *
     * Código de Situação Tributária do PIS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISAliq
     */
    public function getPISAliq()
    {
        return $this->pISAliq;
    }

    /**
     * Sets a new pISAliq
     *
     * Código de Situação Tributária do PIS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISAliq $pISAliq
     * @return self
     */
    public function setPISAliq(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISAliq $pISAliq)
    {
        $this->pISAliq = $pISAliq;
        return $this;
    }

    /**
     * Gets as pISQtde
     *
     * Código de Situação Tributária do PIS.
     * 03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota
     * por Unidade de Produto;
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISQtde
     */
    public function getPISQtde()
    {
        return $this->pISQtde;
    }

    /**
     * Sets a new pISQtde
     *
     * Código de Situação Tributária do PIS.
     * 03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota
     * por Unidade de Produto;
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISQtde $pISQtde
     * @return self
     */
    public function setPISQtde(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISQtde $pISQtde)
    {
        $this->pISQtde = $pISQtde;
        return $this;
    }

    /**
     * Gets as pISNT
     *
     * Código de Situação Tributária do PIS.
     * 04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
     * 06 - Operação Tributável - Alíquota Zero;
     * 07 - Operação Isenta da contribuição;
     * 08 - Operação Sem Incidência da contribuição;
     * 09 - Operação com suspensão da contribuição;
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISNT
     */
    public function getPISNT()
    {
        return $this->pISNT;
    }

    /**
     * Sets a new pISNT
     *
     * Código de Situação Tributária do PIS.
     * 04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
     * 06 - Operação Tributável - Alíquota Zero;
     * 07 - Operação Isenta da contribuição;
     * 08 - Operação Sem Incidência da contribuição;
     * 09 - Operação com suspensão da contribuição;
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISNT $pISNT
     * @return self
     */
    public function setPISNT(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISNT $pISNT)
    {
        $this->pISNT = $pISNT;
        return $this;
    }

    /**
     * Gets as pISOutr
     *
     * Código de Situação Tributária do PIS.
     * 99 - Outras Operações.
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISOutr
     */
    public function getPISOutr()
    {
        return $this->pISOutr;
    }

    /**
     * Sets a new pISOutr
     *
     * Código de Situação Tributária do PIS.
     * 99 - Outras Operações.
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISOutr $pISOutr
     * @return self
     */
    public function setPISOutr(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Imposto\PIS\PISOutr $pISOutr)
    {
        $this->pISOutr = $pISOutr;
        return $this;
    }


}

