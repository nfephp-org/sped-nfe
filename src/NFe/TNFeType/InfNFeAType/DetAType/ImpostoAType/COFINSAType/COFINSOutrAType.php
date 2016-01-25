<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ImpostoAType\COFINSAType;

/**
 * Class representing COFINSOutrAType
 */
class COFINSOutrAType
{

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
     * @property string $cST
     */
    private $cST = null;

    /**
     * Valor da BC do COFINS
     *
     * @property string $vBC
     */
    private $vBC = null;

    /**
     * Alíquota do COFINS (em percentual)
     *
     * @property string $pCOFINS
     */
    private $pCOFINS = null;

    /**
     * Quantidade Vendida (NT2011/004)
     *
     * @property string $qBCProd
     */
    private $qBCProd = null;

    /**
     * Alíquota do COFINS (em reais) (NT2011/004)
     *
     * @property string $vAliqProd
     */
    private $vAliqProd = null;

    /**
     * Valor do COFINS
     *
     * @property string $vCOFINS
     */
    private $vCOFINS = null;

    /**
     * Gets as cST
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
     * @return string
     */
    public function getCST()
    {
        return $this->cST;
    }

    /**
     * Sets a new cST
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
     * @param string $cST
     * @return self
     */
    public function setCST($cST)
    {
        $this->cST = $cST;
        return $this;
    }

    /**
     * Gets as vBC
     *
     * Valor da BC do COFINS
     *
     * @return string
     */
    public function getVBC()
    {
        return $this->vBC;
    }

    /**
     * Sets a new vBC
     *
     * Valor da BC do COFINS
     *
     * @param string $vBC
     * @return self
     */
    public function setVBC($vBC)
    {
        $this->vBC = $vBC;
        return $this;
    }

    /**
     * Gets as pCOFINS
     *
     * Alíquota do COFINS (em percentual)
     *
     * @return string
     */
    public function getPCOFINS()
    {
        return $this->pCOFINS;
    }

    /**
     * Sets a new pCOFINS
     *
     * Alíquota do COFINS (em percentual)
     *
     * @param string $pCOFINS
     * @return self
     */
    public function setPCOFINS($pCOFINS)
    {
        $this->pCOFINS = $pCOFINS;
        return $this;
    }

    /**
     * Gets as qBCProd
     *
     * Quantidade Vendida (NT2011/004)
     *
     * @return string
     */
    public function getQBCProd()
    {
        return $this->qBCProd;
    }

    /**
     * Sets a new qBCProd
     *
     * Quantidade Vendida (NT2011/004)
     *
     * @param string $qBCProd
     * @return self
     */
    public function setQBCProd($qBCProd)
    {
        $this->qBCProd = $qBCProd;
        return $this;
    }

    /**
     * Gets as vAliqProd
     *
     * Alíquota do COFINS (em reais) (NT2011/004)
     *
     * @return string
     */
    public function getVAliqProd()
    {
        return $this->vAliqProd;
    }

    /**
     * Sets a new vAliqProd
     *
     * Alíquota do COFINS (em reais) (NT2011/004)
     *
     * @param string $vAliqProd
     * @return self
     */
    public function setVAliqProd($vAliqProd)
    {
        $this->vAliqProd = $vAliqProd;
        return $this;
    }

    /**
     * Gets as vCOFINS
     *
     * Valor do COFINS
     *
     * @return string
     */
    public function getVCOFINS()
    {
        return $this->vCOFINS;
    }

    /**
     * Sets a new vCOFINS
     *
     * Valor do COFINS
     *
     * @param string $vCOFINS
     * @return self
     */
    public function setVCOFINS($vCOFINS)
    {
        $this->vCOFINS = $vCOFINS;
        return $this;
    }


}

