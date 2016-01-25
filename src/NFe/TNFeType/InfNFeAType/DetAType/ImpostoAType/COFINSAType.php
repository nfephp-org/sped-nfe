<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType;

/**
 * Class representing COFINSAType
 */
class COFINSAType
{

    /**
     * Código de Situação Tributária do COFINS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @property
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSAliqAType
     * $cOFINSAliq
     */
    private $cOFINSAliq = null;

    /**
     * Código de Situação Tributária do COFINS.
     * 03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota
     * por Unidade de Produto;
     *
     * @property
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSQtdeAType
     * $cOFINSQtde
     */
    private $cOFINSQtde = null;

    /**
     * Código de Situação Tributária do COFINS:
     * 04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
     * 06 - Operação Tributável - Alíquota Zero;
     * 07 - Operação Isenta da contribuição;
     * 08 - Operação Sem Incidência da contribuição;
     * 09 - Operação com suspensão da contribuição;
     *
     * @property
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSNTAType
     * $cOFINSNT
     */
    private $cOFINSNT = null;

    /**
     * Código de Situação Tributária do COFINS:
     * 49 - Outras Operações de Saída
     * 50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita
     * Tributada no Mercado Interno
     * 51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita
     * Não Tributada no Mercado Interno
     * 52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de
     * Exportação
     * 53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e
     * Não-Tributadas no Mercado Interno
     * 54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no
     * Mercado Interno e de Exportação
     * 55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no
     * Mercado Interno e de Exportação
     * 56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e
     * Não-Tributadas no Mercado Interno, e de Exportação
     * 60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita Tributada no Mercado Interno
     * 61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita Não-Tributada no Mercado Interno
     * 62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita de Exportação
     * 63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas e Não-Tributadas no Mercado Interno
     * 64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas no Mercado Interno e de Exportação
     * 65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Não-Tributadas no Mercado Interno e de Exportação
     * 66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
     * 67 - Crédito Presumido - Outras Operações
     * 70 - Operação de Aquisição sem Direito a Crédito
     * 71 - Operação de Aquisição com Isenção
     * 72 - Operação de Aquisição com Suspensão
     * 73 - Operação de Aquisição a Alíquota Zero
     * 74 - Operação de Aquisição sem Incidência da Contribuição
     * 75 - Operação de Aquisição por Substituição Tributária
     * 98 - Outras Operações de Entrada
     * 99 - Outras Operações.
     *
     * @property
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSOutrAType
     * $cOFINSOutr
     */
    private $cOFINSOutr = null;

    /**
     * Gets as cOFINSAliq
     *
     * Código de Situação Tributária do COFINS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @return
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSAliqAType
     */
    public function getCOFINSAliq()
    {
        return $this->cOFINSAliq;
    }

    /**
     * Sets a new cOFINSAliq
     *
     * Código de Situação Tributária do COFINS.
     *  01 – Operação Tributável - Base de Cálculo = Valor da Operação
     * Alíquota Normal (Cumulativo/Não Cumulativo);
     * 02 - Operação Tributável - Base de Calculo = Valor da Operação (Alíquota
     * Diferenciada);
     *
     * @param
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSAliqAType
     * $cOFINSAliq
     * @return self
     */
    public function setCOFINSAliq(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSAliqAType $cOFINSAliq)
    {
        $this->cOFINSAliq = $cOFINSAliq;
        return $this;
    }

    /**
     * Gets as cOFINSQtde
     *
     * Código de Situação Tributária do COFINS.
     * 03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota
     * por Unidade de Produto;
     *
     * @return
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSQtdeAType
     */
    public function getCOFINSQtde()
    {
        return $this->cOFINSQtde;
    }

    /**
     * Sets a new cOFINSQtde
     *
     * Código de Situação Tributária do COFINS.
     * 03 - Operação Tributável - Base de Calculo = Quantidade Vendida x Alíquota
     * por Unidade de Produto;
     *
     * @param
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSQtdeAType
     * $cOFINSQtde
     * @return self
     */
    public function setCOFINSQtde(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSQtdeAType $cOFINSQtde)
    {
        $this->cOFINSQtde = $cOFINSQtde;
        return $this;
    }

    /**
     * Gets as cOFINSNT
     *
     * Código de Situação Tributária do COFINS:
     * 04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
     * 06 - Operação Tributável - Alíquota Zero;
     * 07 - Operação Isenta da contribuição;
     * 08 - Operação Sem Incidência da contribuição;
     * 09 - Operação com suspensão da contribuição;
     *
     * @return
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSNTAType
     */
    public function getCOFINSNT()
    {
        return $this->cOFINSNT;
    }

    /**
     * Sets a new cOFINSNT
     *
     * Código de Situação Tributária do COFINS:
     * 04 - Operação Tributável - Tributação Monofásica - (Alíquota Zero);
     * 06 - Operação Tributável - Alíquota Zero;
     * 07 - Operação Isenta da contribuição;
     * 08 - Operação Sem Incidência da contribuição;
     * 09 - Operação com suspensão da contribuição;
     *
     * @param
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSNTAType
     * $cOFINSNT
     * @return self
     */
    public function setCOFINSNT(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSNTAType $cOFINSNT)
    {
        $this->cOFINSNT = $cOFINSNT;
        return $this;
    }

    /**
     * Gets as cOFINSOutr
     *
     * Código de Situação Tributária do COFINS:
     * 49 - Outras Operações de Saída
     * 50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita
     * Tributada no Mercado Interno
     * 51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita
     * Não Tributada no Mercado Interno
     * 52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de
     * Exportação
     * 53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e
     * Não-Tributadas no Mercado Interno
     * 54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no
     * Mercado Interno e de Exportação
     * 55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no
     * Mercado Interno e de Exportação
     * 56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e
     * Não-Tributadas no Mercado Interno, e de Exportação
     * 60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita Tributada no Mercado Interno
     * 61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita Não-Tributada no Mercado Interno
     * 62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita de Exportação
     * 63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas e Não-Tributadas no Mercado Interno
     * 64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas no Mercado Interno e de Exportação
     * 65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Não-Tributadas no Mercado Interno e de Exportação
     * 66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
     * 67 - Crédito Presumido - Outras Operações
     * 70 - Operação de Aquisição sem Direito a Crédito
     * 71 - Operação de Aquisição com Isenção
     * 72 - Operação de Aquisição com Suspensão
     * 73 - Operação de Aquisição a Alíquota Zero
     * 74 - Operação de Aquisição sem Incidência da Contribuição
     * 75 - Operação de Aquisição por Substituição Tributária
     * 98 - Outras Operações de Entrada
     * 99 - Outras Operações.
     *
     * @return
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSOutrAType
     */
    public function getCOFINSOutr()
    {
        return $this->cOFINSOutr;
    }

    /**
     * Sets a new cOFINSOutr
     *
     * Código de Situação Tributária do COFINS:
     * 49 - Outras Operações de Saída
     * 50 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita
     * Tributada no Mercado Interno
     * 51 - Operação com Direito a Crédito – Vinculada Exclusivamente a Receita
     * Não Tributada no Mercado Interno
     * 52 - Operação com Direito a Crédito - Vinculada Exclusivamente a Receita de
     * Exportação
     * 53 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e
     * Não-Tributadas no Mercado Interno
     * 54 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas no
     * Mercado Interno e de Exportação
     * 55 - Operação com Direito a Crédito - Vinculada a Receitas Não-Tributadas no
     * Mercado Interno e de Exportação
     * 56 - Operação com Direito a Crédito - Vinculada a Receitas Tributadas e
     * Não-Tributadas no Mercado Interno, e de Exportação
     * 60 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita Tributada no Mercado Interno
     * 61 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita Não-Tributada no Mercado Interno
     * 62 - Crédito Presumido - Operação de Aquisição Vinculada Exclusivamente a
     * Receita de Exportação
     * 63 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas e Não-Tributadas no Mercado Interno
     * 64 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas no Mercado Interno e de Exportação
     * 65 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Não-Tributadas no Mercado Interno e de Exportação
     * 66 - Crédito Presumido - Operação de Aquisição Vinculada a Receitas
     * Tributadas e Não-Tributadas no Mercado Interno, e de Exportação
     * 67 - Crédito Presumido - Outras Operações
     * 70 - Operação de Aquisição sem Direito a Crédito
     * 71 - Operação de Aquisição com Isenção
     * 72 - Operação de Aquisição com Suspensão
     * 73 - Operação de Aquisição a Alíquota Zero
     * 74 - Operação de Aquisição sem Incidência da Contribuição
     * 75 - Operação de Aquisição por Substituição Tributária
     * 98 - Outras Operações de Entrada
     * 99 - Outras Operações.
     *
     * @param
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSOutrAType
     * $cOFINSOutr
     * @return self
     */
    public function setCOFINSOutr(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType\COFINSOutrAType $cOFINSOutr)
    {
        $this->cOFINSOutr = $cOFINSOutr;
        return $this;
    }


}

