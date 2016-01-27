<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det;

/**
 * Class representing Prod
 */
class Prod
{

    /**
     * Código do produto ou serviço. Preencher com CFOP caso se trate de itens não
     * relacionados com mercadorias/produto e que o contribuinte não possua
     * codificação própria
     * Formato ”CFOP9999”.
     *
     * @property string $cProd
     */
    private $cProd = null;

    /**
     * GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de
     * barras
     *
     * @property string $cEAN
     */
    private $cEAN = null;

    /**
     * Descrição do produto ou serviço
     *
     * @property string $xProd
     */
    private $xProd = null;

    /**
     * Código NCM (8 posições), será permitida a informação do gênero (posição
     * do capítulo do NCM) quando a operação não for de comércio exterior
     * (importação/exportação) ou o produto não seja tributado pelo IPI. Em caso
     * de item de serviço ou item que não tenham produto (Ex. transferência de
     * crédito, crédito do ativo imobilizado, etc.), informar o código 00 (zeros)
     * (v2.0)
     *
     * @property string $nCM
     */
    private $nCM = null;

    /**
     * Nomenclatura de Valor aduaneio e Estatístico
     *
     * @property string[] $nVE
     */
    private $nVE = null;

    /**
     * Codigo especificador da Substuicao Tributaria - CEST, que identifica a
     * mercadoria sujeita aos regimes de substituicao tributária e de antecipação do
     * recolhimento do imposto
     *
     * @property string $cEST
     */
    private $cEST = null;

    /**
     * Código EX TIPI (3 posições)
     *
     * @property string $eXTIPI
     */
    private $eXTIPI = null;

    /**
     * Código Fiscal de Operações e Prestações
     *
     * @property string $cFOP
     */
    private $cFOP = null;

    /**
     * Unidade comercial
     *
     * @property string $uCom
     */
    private $uCom = null;

    /**
     * Quantidade Comercial do produto, alterado para aceitar de 0 a 4 casas decimais e
     * 11 inteiros.
     *
     * @property string $qCom
     */
    private $qCom = null;

    /**
     * Valor unitário de comercialização - alterado para aceitar 0 a 10 casas
     * decimais e 11 inteiros
     *
     * @property string $vUnCom
     */
    private $vUnCom = null;

    /**
     * Valor bruto do produto ou serviço.
     *
     * @property string $vProd
     */
    private $vProd = null;

    /**
     * GTIN (Global Trade Item Number) da unidade tributável, antigo código EAN ou
     * código de barras
     *
     * @property string $cEANTrib
     */
    private $cEANTrib = null;

    /**
     * Unidade Tributável
     *
     * @property string $uTrib
     */
    private $uTrib = null;

    /**
     * Quantidade Tributável - alterado para aceitar de 0 a 4 casas decimais e 11
     * inteiros
     *
     * @property string $qTrib
     */
    private $qTrib = null;

    /**
     * Valor unitário de tributação - - alterado para aceitar 0 a 10 casas decimais
     * e 11 inteiros
     *
     * @property string $vUnTrib
     */
    private $vUnTrib = null;

    /**
     * Valor Total do Frete
     *
     * @property string $vFrete
     */
    private $vFrete = null;

    /**
     * Valor Total do Seguro
     *
     * @property string $vSeg
     */
    private $vSeg = null;

    /**
     * Valor do Desconto
     *
     * @property string $vDesc
     */
    private $vDesc = null;

    /**
     * Outras despesas acessórias
     *
     * @property string $vOutro
     */
    private $vOutro = null;

    /**
     * Este campo deverá ser preenchido com:
     *  0 – o valor do item (vProd) não compõe o valor total da NF-e (vProd)
     *  1 – o valor do item (vProd) compõe o valor total da NF-e (vProd)
     *
     * @property string $indTot
     */
    private $indTot = null;

    /**
     * Delcaração de Importação
     * (NT 2011/004)
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DI[] $dI
     */
    private $dI = null;

    /**
     * Detalhe da exportação
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport[] $detExport
     */
    private $detExport = null;

    /**
     * pedido de compra - Informação de interesse do emissor para controle do B2B.
     *
     * @property string $xPed
     */
    private $xPed = null;

    /**
     * Número do Item do Pedido de Compra - Identificação do número do item do
     * pedido de Compra
     *
     * @property string $nItemPed
     */
    private $nItemPed = null;

    /**
     * Número de controle da FCI - Ficha de Conteúdo de Importação.
     *
     * @property string $nFCI
     */
    private $nFCI = null;

    /**
     * Veículos novos
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\VeicProd $veicProd
     */
    private $veicProd = null;

    /**
     * grupo do detalhamento de Medicamentos e de matérias-primas farmacêuticas
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Med[] $med
     */
    private $med = null;

    /**
     * Armamentos
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Arma[] $arma
     */
    private $arma = null;

    /**
     * Informar apenas para operações com combustíveis líquidos
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb $comb
     */
    private $comb = null;

    /**
     * Número do RECOPI
     *
     * @property string $nRECOPI
     */
    private $nRECOPI = null;

    /**
     * Gets as cProd
     *
     * Código do produto ou serviço. Preencher com CFOP caso se trate de itens não
     * relacionados com mercadorias/produto e que o contribuinte não possua
     * codificação própria
     * Formato ”CFOP9999”.
     *
     * @return string
     */
    public function getCProd()
    {
        return $this->cProd;
    }

    /**
     * Sets a new cProd
     *
     * Código do produto ou serviço. Preencher com CFOP caso se trate de itens não
     * relacionados com mercadorias/produto e que o contribuinte não possua
     * codificação própria
     * Formato ”CFOP9999”.
     *
     * @param string $cProd
     * @return self
     */
    public function setCProd($cProd)
    {
        $this->cProd = $cProd;
        return $this;
    }

    /**
     * Gets as cEAN
     *
     * GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de
     * barras
     *
     * @return string
     */
    public function getCEAN()
    {
        return $this->cEAN;
    }

    /**
     * Sets a new cEAN
     *
     * GTIN (Global Trade Item Number) do produto, antigo código EAN ou código de
     * barras
     *
     * @param string $cEAN
     * @return self
     */
    public function setCEAN($cEAN)
    {
        $this->cEAN = $cEAN;
        return $this;
    }

    /**
     * Gets as xProd
     *
     * Descrição do produto ou serviço
     *
     * @return string
     */
    public function getXProd()
    {
        return $this->xProd;
    }

    /**
     * Sets a new xProd
     *
     * Descrição do produto ou serviço
     *
     * @param string $xProd
     * @return self
     */
    public function setXProd($xProd)
    {
        $this->xProd = $xProd;
        return $this;
    }

    /**
     * Gets as nCM
     *
     * Código NCM (8 posições), será permitida a informação do gênero (posição
     * do capítulo do NCM) quando a operação não for de comércio exterior
     * (importação/exportação) ou o produto não seja tributado pelo IPI. Em caso
     * de item de serviço ou item que não tenham produto (Ex. transferência de
     * crédito, crédito do ativo imobilizado, etc.), informar o código 00 (zeros)
     * (v2.0)
     *
     * @return string
     */
    public function getNCM()
    {
        return $this->nCM;
    }

    /**
     * Sets a new nCM
     *
     * Código NCM (8 posições), será permitida a informação do gênero (posição
     * do capítulo do NCM) quando a operação não for de comércio exterior
     * (importação/exportação) ou o produto não seja tributado pelo IPI. Em caso
     * de item de serviço ou item que não tenham produto (Ex. transferência de
     * crédito, crédito do ativo imobilizado, etc.), informar o código 00 (zeros)
     * (v2.0)
     *
     * @param string $nCM
     * @return self
     */
    public function setNCM($nCM)
    {
        $this->nCM = $nCM;
        return $this;
    }

    /**
     * Adds as nVE
     *
     * Nomenclatura de Valor aduaneio e Estatístico
     *
     * @return self
     * @param string $nVE
     */
    public function addToNVE($nVE)
    {
        $this->nVE[] = $nVE;
        return $this;
    }

    /**
     * isset nVE
     *
     * Nomenclatura de Valor aduaneio e Estatístico
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetNVE($index)
    {
        return isset($this->nVE[$index]);
    }

    /**
     * unset nVE
     *
     * Nomenclatura de Valor aduaneio e Estatístico
     *
     * @param scalar $index
     * @return void
     */
    public function unsetNVE($index)
    {
        unset($this->nVE[$index]);
    }

    /**
     * Gets as nVE
     *
     * Nomenclatura de Valor aduaneio e Estatístico
     *
     * @return string[]
     */
    public function getNVE()
    {
        return $this->nVE;
    }

    /**
     * Sets a new nVE
     *
     * Nomenclatura de Valor aduaneio e Estatístico
     *
     * @param string $nVE
     * @return self
     */
    public function setNVE(array $nVE)
    {
        $this->nVE = $nVE;
        return $this;
    }

    /**
     * Gets as cEST
     *
     * Codigo especificador da Substuicao Tributaria - CEST, que identifica a
     * mercadoria sujeita aos regimes de substituicao tributária e de antecipação do
     * recolhimento do imposto
     *
     * @return string
     */
    public function getCEST()
    {
        return $this->cEST;
    }

    /**
     * Sets a new cEST
     *
     * Codigo especificador da Substuicao Tributaria - CEST, que identifica a
     * mercadoria sujeita aos regimes de substituicao tributária e de antecipação do
     * recolhimento do imposto
     *
     * @param string $cEST
     * @return self
     */
    public function setCEST($cEST)
    {
        $this->cEST = $cEST;
        return $this;
    }

    /**
     * Gets as eXTIPI
     *
     * Código EX TIPI (3 posições)
     *
     * @return string
     */
    public function getEXTIPI()
    {
        return $this->eXTIPI;
    }

    /**
     * Sets a new eXTIPI
     *
     * Código EX TIPI (3 posições)
     *
     * @param string $eXTIPI
     * @return self
     */
    public function setEXTIPI($eXTIPI)
    {
        $this->eXTIPI = $eXTIPI;
        return $this;
    }

    /**
     * Gets as cFOP
     *
     * Código Fiscal de Operações e Prestações
     *
     * @return string
     */
    public function getCFOP()
    {
        return $this->cFOP;
    }

    /**
     * Sets a new cFOP
     *
     * Código Fiscal de Operações e Prestações
     *
     * @param string $cFOP
     * @return self
     */
    public function setCFOP($cFOP)
    {
        $this->cFOP = $cFOP;
        return $this;
    }

    /**
     * Gets as uCom
     *
     * Unidade comercial
     *
     * @return string
     */
    public function getUCom()
    {
        return $this->uCom;
    }

    /**
     * Sets a new uCom
     *
     * Unidade comercial
     *
     * @param string $uCom
     * @return self
     */
    public function setUCom($uCom)
    {
        $this->uCom = $uCom;
        return $this;
    }

    /**
     * Gets as qCom
     *
     * Quantidade Comercial do produto, alterado para aceitar de 0 a 4 casas decimais e
     * 11 inteiros.
     *
     * @return string
     */
    public function getQCom()
    {
        return $this->qCom;
    }

    /**
     * Sets a new qCom
     *
     * Quantidade Comercial do produto, alterado para aceitar de 0 a 4 casas decimais e
     * 11 inteiros.
     *
     * @param string $qCom
     * @return self
     */
    public function setQCom($qCom)
    {
        $this->qCom = $qCom;
        return $this;
    }

    /**
     * Gets as vUnCom
     *
     * Valor unitário de comercialização - alterado para aceitar 0 a 10 casas
     * decimais e 11 inteiros
     *
     * @return string
     */
    public function getVUnCom()
    {
        return $this->vUnCom;
    }

    /**
     * Sets a new vUnCom
     *
     * Valor unitário de comercialização - alterado para aceitar 0 a 10 casas
     * decimais e 11 inteiros
     *
     * @param string $vUnCom
     * @return self
     */
    public function setVUnCom($vUnCom)
    {
        $this->vUnCom = $vUnCom;
        return $this;
    }

    /**
     * Gets as vProd
     *
     * Valor bruto do produto ou serviço.
     *
     * @return string
     */
    public function getVProd()
    {
        return $this->vProd;
    }

    /**
     * Sets a new vProd
     *
     * Valor bruto do produto ou serviço.
     *
     * @param string $vProd
     * @return self
     */
    public function setVProd($vProd)
    {
        $this->vProd = $vProd;
        return $this;
    }

    /**
     * Gets as cEANTrib
     *
     * GTIN (Global Trade Item Number) da unidade tributável, antigo código EAN ou
     * código de barras
     *
     * @return string
     */
    public function getCEANTrib()
    {
        return $this->cEANTrib;
    }

    /**
     * Sets a new cEANTrib
     *
     * GTIN (Global Trade Item Number) da unidade tributável, antigo código EAN ou
     * código de barras
     *
     * @param string $cEANTrib
     * @return self
     */
    public function setCEANTrib($cEANTrib)
    {
        $this->cEANTrib = $cEANTrib;
        return $this;
    }

    /**
     * Gets as uTrib
     *
     * Unidade Tributável
     *
     * @return string
     */
    public function getUTrib()
    {
        return $this->uTrib;
    }

    /**
     * Sets a new uTrib
     *
     * Unidade Tributável
     *
     * @param string $uTrib
     * @return self
     */
    public function setUTrib($uTrib)
    {
        $this->uTrib = $uTrib;
        return $this;
    }

    /**
     * Gets as qTrib
     *
     * Quantidade Tributável - alterado para aceitar de 0 a 4 casas decimais e 11
     * inteiros
     *
     * @return string
     */
    public function getQTrib()
    {
        return $this->qTrib;
    }

    /**
     * Sets a new qTrib
     *
     * Quantidade Tributável - alterado para aceitar de 0 a 4 casas decimais e 11
     * inteiros
     *
     * @param string $qTrib
     * @return self
     */
    public function setQTrib($qTrib)
    {
        $this->qTrib = $qTrib;
        return $this;
    }

    /**
     * Gets as vUnTrib
     *
     * Valor unitário de tributação - - alterado para aceitar 0 a 10 casas decimais
     * e 11 inteiros
     *
     * @return string
     */
    public function getVUnTrib()
    {
        return $this->vUnTrib;
    }

    /**
     * Sets a new vUnTrib
     *
     * Valor unitário de tributação - - alterado para aceitar 0 a 10 casas decimais
     * e 11 inteiros
     *
     * @param string $vUnTrib
     * @return self
     */
    public function setVUnTrib($vUnTrib)
    {
        $this->vUnTrib = $vUnTrib;
        return $this;
    }

    /**
     * Gets as vFrete
     *
     * Valor Total do Frete
     *
     * @return string
     */
    public function getVFrete()
    {
        return $this->vFrete;
    }

    /**
     * Sets a new vFrete
     *
     * Valor Total do Frete
     *
     * @param string $vFrete
     * @return self
     */
    public function setVFrete($vFrete)
    {
        $this->vFrete = $vFrete;
        return $this;
    }

    /**
     * Gets as vSeg
     *
     * Valor Total do Seguro
     *
     * @return string
     */
    public function getVSeg()
    {
        return $this->vSeg;
    }

    /**
     * Sets a new vSeg
     *
     * Valor Total do Seguro
     *
     * @param string $vSeg
     * @return self
     */
    public function setVSeg($vSeg)
    {
        $this->vSeg = $vSeg;
        return $this;
    }

    /**
     * Gets as vDesc
     *
     * Valor do Desconto
     *
     * @return string
     */
    public function getVDesc()
    {
        return $this->vDesc;
    }

    /**
     * Sets a new vDesc
     *
     * Valor do Desconto
     *
     * @param string $vDesc
     * @return self
     */
    public function setVDesc($vDesc)
    {
        $this->vDesc = $vDesc;
        return $this;
    }

    /**
     * Gets as vOutro
     *
     * Outras despesas acessórias
     *
     * @return string
     */
    public function getVOutro()
    {
        return $this->vOutro;
    }

    /**
     * Sets a new vOutro
     *
     * Outras despesas acessórias
     *
     * @param string $vOutro
     * @return self
     */
    public function setVOutro($vOutro)
    {
        $this->vOutro = $vOutro;
        return $this;
    }

    /**
     * Gets as indTot
     *
     * Este campo deverá ser preenchido com:
     *  0 – o valor do item (vProd) não compõe o valor total da NF-e (vProd)
     *  1 – o valor do item (vProd) compõe o valor total da NF-e (vProd)
     *
     * @return string
     */
    public function getIndTot()
    {
        return $this->indTot;
    }

    /**
     * Sets a new indTot
     *
     * Este campo deverá ser preenchido com:
     *  0 – o valor do item (vProd) não compõe o valor total da NF-e (vProd)
     *  1 – o valor do item (vProd) compõe o valor total da NF-e (vProd)
     *
     * @param string $indTot
     * @return self
     */
    public function setIndTot($indTot)
    {
        $this->indTot = $indTot;
        return $this;
    }

    /**
     * Adds as dI
     *
     * Delcaração de Importação
     * (NT 2011/004)
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DI $dI
     */
    public function addToDI(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DI $dI)
    {
        $this->dI[] = $dI;
        return $this;
    }

    /**
     * isset dI
     *
     * Delcaração de Importação
     * (NT 2011/004)
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDI($index)
    {
        return isset($this->dI[$index]);
    }

    /**
     * unset dI
     *
     * Delcaração de Importação
     * (NT 2011/004)
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDI($index)
    {
        unset($this->dI[$index]);
    }

    /**
     * Gets as dI
     *
     * Delcaração de Importação
     * (NT 2011/004)
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DI[]
     */
    public function getDI()
    {
        return $this->dI;
    }

    /**
     * Sets a new dI
     *
     * Delcaração de Importação
     * (NT 2011/004)
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DI[] $dI
     * @return self
     */
    public function setDI(array $dI)
    {
        $this->dI = $dI;
        return $this;
    }

    /**
     * Adds as detExport
     *
     * Detalhe da exportação
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport $detExport
     */
    public function addToDetExport(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport $detExport)
    {
        $this->detExport[] = $detExport;
        return $this;
    }

    /**
     * isset detExport
     *
     * Detalhe da exportação
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDetExport($index)
    {
        return isset($this->detExport[$index]);
    }

    /**
     * unset detExport
     *
     * Detalhe da exportação
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDetExport($index)
    {
        unset($this->detExport[$index]);
    }

    /**
     * Gets as detExport
     *
     * Detalhe da exportação
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport[]
     */
    public function getDetExport()
    {
        return $this->detExport;
    }

    /**
     * Sets a new detExport
     *
     * Detalhe da exportação
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport[] $detExport
     * @return self
     */
    public function setDetExport(array $detExport)
    {
        $this->detExport = $detExport;
        return $this;
    }

    /**
     * Gets as xPed
     *
     * pedido de compra - Informação de interesse do emissor para controle do B2B.
     *
     * @return string
     */
    public function getXPed()
    {
        return $this->xPed;
    }

    /**
     * Sets a new xPed
     *
     * pedido de compra - Informação de interesse do emissor para controle do B2B.
     *
     * @param string $xPed
     * @return self
     */
    public function setXPed($xPed)
    {
        $this->xPed = $xPed;
        return $this;
    }

    /**
     * Gets as nItemPed
     *
     * Número do Item do Pedido de Compra - Identificação do número do item do
     * pedido de Compra
     *
     * @return string
     */
    public function getNItemPed()
    {
        return $this->nItemPed;
    }

    /**
     * Sets a new nItemPed
     *
     * Número do Item do Pedido de Compra - Identificação do número do item do
     * pedido de Compra
     *
     * @param string $nItemPed
     * @return self
     */
    public function setNItemPed($nItemPed)
    {
        $this->nItemPed = $nItemPed;
        return $this;
    }

    /**
     * Gets as nFCI
     *
     * Número de controle da FCI - Ficha de Conteúdo de Importação.
     *
     * @return string
     */
    public function getNFCI()
    {
        return $this->nFCI;
    }

    /**
     * Sets a new nFCI
     *
     * Número de controle da FCI - Ficha de Conteúdo de Importação.
     *
     * @param string $nFCI
     * @return self
     */
    public function setNFCI($nFCI)
    {
        $this->nFCI = $nFCI;
        return $this;
    }

    /**
     * Gets as veicProd
     *
     * Veículos novos
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\VeicProd
     */
    public function getVeicProd()
    {
        return $this->veicProd;
    }

    /**
     * Sets a new veicProd
     *
     * Veículos novos
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\VeicProd $veicProd
     * @return self
     */
    public function setVeicProd(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\VeicProd $veicProd)
    {
        $this->veicProd = $veicProd;
        return $this;
    }

    /**
     * Adds as med
     *
     * grupo do detalhamento de Medicamentos e de matérias-primas farmacêuticas
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Med $med
     */
    public function addToMed(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Med $med)
    {
        $this->med[] = $med;
        return $this;
    }

    /**
     * isset med
     *
     * grupo do detalhamento de Medicamentos e de matérias-primas farmacêuticas
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetMed($index)
    {
        return isset($this->med[$index]);
    }

    /**
     * unset med
     *
     * grupo do detalhamento de Medicamentos e de matérias-primas farmacêuticas
     *
     * @param scalar $index
     * @return void
     */
    public function unsetMed($index)
    {
        unset($this->med[$index]);
    }

    /**
     * Gets as med
     *
     * grupo do detalhamento de Medicamentos e de matérias-primas farmacêuticas
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Med[]
     */
    public function getMed()
    {
        return $this->med;
    }

    /**
     * Sets a new med
     *
     * grupo do detalhamento de Medicamentos e de matérias-primas farmacêuticas
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Med[] $med
     * @return self
     */
    public function setMed(array $med)
    {
        $this->med = $med;
        return $this;
    }

    /**
     * Adds as arma
     *
     * Armamentos
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Arma $arma
     */
    public function addToArma(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Arma $arma)
    {
        $this->arma[] = $arma;
        return $this;
    }

    /**
     * isset arma
     *
     * Armamentos
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetArma($index)
    {
        return isset($this->arma[$index]);
    }

    /**
     * unset arma
     *
     * Armamentos
     *
     * @param scalar $index
     * @return void
     */
    public function unsetArma($index)
    {
        unset($this->arma[$index]);
    }

    /**
     * Gets as arma
     *
     * Armamentos
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Arma[]
     */
    public function getArma()
    {
        return $this->arma;
    }

    /**
     * Sets a new arma
     *
     * Armamentos
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Arma[] $arma
     * @return self
     */
    public function setArma(array $arma)
    {
        $this->arma = $arma;
        return $this;
    }

    /**
     * Gets as comb
     *
     * Informar apenas para operações com combustíveis líquidos
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb
     */
    public function getComb()
    {
        return $this->comb;
    }

    /**
     * Sets a new comb
     *
     * Informar apenas para operações com combustíveis líquidos
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb $comb
     * @return self
     */
    public function setComb(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\Comb $comb)
    {
        $this->comb = $comb;
        return $this;
    }

    /**
     * Gets as nRECOPI
     *
     * Número do RECOPI
     *
     * @return string
     */
    public function getNRECOPI()
    {
        return $this->nRECOPI;
    }

    /**
     * Sets a new nRECOPI
     *
     * Número do RECOPI
     *
     * @param string $nRECOPI
     * @return self
     */
    public function setNRECOPI($nRECOPI)
    {
        $this->nRECOPI = $nRECOPI;
        return $this;
    }


}

