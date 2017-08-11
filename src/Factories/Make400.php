<?php

namespace NFePHP\NFe\Factories;

/**
 * Classe a construção do xml da NFe modelo 55 e modelo 65
 * Apenas para a versão 4.00 do layout
 * @category  NFePHP
 * @package   NFePHP\NFe\Factories\Make400
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\NFe\Factories\MakeBasic;
use NFePHP\Common\Strings;
use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use RuntimeException;
use DOMElement;
use DOMNode;
use DateTime;

class Make400 extends MakeBasic
{
    /**
     * @var string
     */
    protected $versao = '4.00';
    /**
     * @var array of DOMElements
     */
    protected $aRastro = [];

    /**
     * Função construtora cria um objeto DOMDocument
     * que será carregado com o documento fiscal
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Informações de identificação da NF-e B01 pai A01
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/ide
     * @param  int $cUF
     * @param  int $cNF
     * @param  string $natOp
     * @param  int $mod
     * @param  int $serie
     * @param  int $nNF
     * @param  string $dhEmi
     * @param  string $dhSaiEnt
     * @param  int $tpNF
     * @param  int $idDest
     * @param  string $cMunFG
     * @param  int $tpImp
     * @param  int $tpEmis
     * @param  int $cDV
     * @param  int $tpAmb
     * @param  int $finNFe
     * @param  int $indFinal
     * @param  int $indPres
     * @param  int $procEmi
     * @param  string $verProc
     * @param  string $dhCont
     * @param  string $xJust
     * @return DOMElement
     */
    public function tagide(
        $cUF,
        $cNF,
        $natOp,
        $indPag,
        $mod,
        $serie,
        $nNF,
        $dhEmi,
        $dhSaiEnt,
        $tpNF,
        $idDest,
        $cMunFG,
        $tpImp,
        $tpEmis,
        $cDV,
        $tpAmb,
        $finNFe,
        $indFinal,
        $indPres,
        $procEmi = 0,
        $verProc = '',
        $dhCont = '',
        $xJust = ''
    ) {
        $this->tpAmb = $tpAmb;
        $identificador = 'B01 <ide> - ';
        $ide = $this->dom->createElement("ide");
        $this->dom->addChild(
            $ide,
            "cUF",
            $cUF,
            true,
            $identificador . "Código da UF do emitente do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "cNF",
            str_pad($cNF, 8, '0', STR_PAD_LEFT),
            true,
            $identificador . "Código Numérico que compõe a Chave de Acesso"
        );
        $this->dom->addChild(
            $ide,
            "natOp",
            Strings::replaceSpecialsChars(substr(trim($natOp), 0, 60)),
            true,
            $identificador . "Descrição da Natureza da Operaçãoo"
        );
        $this->dom->addChild(
            $ide,
            "mod",
            $mod,
            true,
            $identificador . "Código do Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "serie",
            $serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "nNF",
            $nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "dhEmi",
            $dhEmi,
            true,
            $identificador . "Data e hora de emissão do Documento Fiscal"
        );
        if ($mod == '55' && !empty($dhSaiEnt)) {
            $this->dom->addChild(
                $ide,
                "dhSaiEnt",
                $dhSaiEnt,
                false,
                $identificador . "Data e hora de Saída ou da Entrada da Mercadoria/Produto"
            );
        }
        $this->dom->addChild(
            $ide,
            "tpNF",
            $tpNF,
            true,
            $identificador . "Tipo de Operação"
        );
        $this->dom->addChild(
            $ide,
            "idDest",
            $idDest,
            true,
            $identificador . "Identificador de local de destino da operação"
        );
        $this->dom->addChild(
            $ide,
            "cMunFG",
            $cMunFG,
            true,
            $identificador . "Código do Município de Ocorrência do Fato Gerador"
        );
        $this->dom->addChild(
            $ide,
            "tpImp",
            $tpImp,
            true,
            $identificador . "Formato de Impressão do DANFE"
        );
        $this->dom->addChild(
            $ide,
            "tpEmis",
            $tpEmis,
            true,
            $identificador . "Tipo de Emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "cDV",
            $cDV,
            true,
            $identificador . "Dígito Verificador da Chave de Acesso da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "tpAmb",
            $tpAmb,
            true,
            $identificador . "Identificação do Ambiente"
        );
        $this->dom->addChild(
            $ide,
            "finNFe",
            $finNFe,
            true,
            $identificador . "Finalidade de emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "indFinal",
            $indFinal,
            true,
            $identificador . "Indica operação com Consumidor final"
        );
        $this->dom->addChild(
            $ide,
            "indPres",
            $indPres,
            true,
            $identificador . "Indicador de presença do comprador no estabelecimento comercial no momento da operação"
        );
        $this->dom->addChild(
            $ide,
            "procEmi",
            $procEmi,
            true,
            $identificador . "Processo de emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "verProc",
            $verProc,
            true,
            $identificador . "Versão do Processo de emissão da NF-e"
        );
        if ($dhCont != '' && $xJust != '') {
            $this->dom->addChild(
                $ide,
                "dhCont",
                $dhCont,
                true,
                $identificador . "Data e Hora da entrada em contingência"
            );
            $this->dom->addChild(
                $ide,
                "xJust",
                Strings::replaceSpecialsChars(substr(trim($xJust), 0, 256)),
                true,
                $identificador . "Justificativa da entrada em contingência"
            );
        }
        $this->mod = $mod;
        $this->ide = $ide;
        return $ide;
    }

    /**
     * Código Especificador da Substituição Tributária – CEST,
     * que identifica a mercadoria sujeita aos regimes de substituição
     * tributária e de antecipação do recolhimento do imposto.
     * vide NT2015.003 e NT_2016.002_v1.20 I05b pai I01
     * tag NFe/infNFe/det[item]/prod/ctrltST (opcional)
     * @param  int $nItem
     * @param  string $codigo CEST
     * @param  string $indEscala S Produzido em Escala Relevante;
     *                           N Produzido em Escala NÃO Relevante
     * @param  string $cnpjFab Identificação do fabricante
     * @return DOMElement
     */
    public function tagCEST($nItem, $codigo, $indEscala = '', $cnpjFab = '')
    {
        $identificador = 'I05b <ctrltST> - ';
        $ctrltST = $this->dom->createElement("ctrltST");
        $this->dom->addChild(
            $ctrltST,
            "CEST",
            Strings::onlyNumbers($codigo),
            true,
            "$identificador [item $nItem] Numero CEST"
        );
        $this->dom->addChild(
            $ctrltST,
            "indEscala",
            trim($indEscala),
            false,
            "$identificador [item $nItem] Indicador de Produção em escala relevante"
        );
        $this->dom->addChild(
            $ctrltST,
            "CNPJFab",
            Strings::onlyNumbers($cnpjFab),
            false,
            "$identificador [item $nItem] CNPJ do Fabricante da Mercadoria,"
            . "obrigatório para produto em escala NÃO relevante."
        );
        $this->aCest[$nItem] = $ctrltST;
        return $ctrltST;
    }

    /**
     * Detalhamento de Produtos e Serviços I01 pai H01
     * tag NFe/infNFe/det[]/prod
     * @param  string $nItem
     * @param  string $cProd
     * @param  string $cEAN
     * @param  string $xProd
     * @param  string $NCM
     * @param  string $cBenef
     * @param  string $EXTIPI
     * @param  string $CFOP
     * @param  string $uCom
     * @param  string $qCom
     * @param  string $vUnCom
     * @param  string $vProd
     * @param  string $cEANTrib
     * @param  string $uTrib
     * @param  string $qTrib
     * @param  string $vUnTrib
     * @param  string $vFrete
     * @param  string $vSeg
     * @param  string $vDesc
     * @param  string $vOutro
     * @param  string $indTot
     * @param  string $xPed
     * @param  string $nItemPed
     * @param  string $nFCI
     * @return DOMElement
     */
    public function tagprod(
        $nItem = '',
        $cProd = '',
        $cEAN = '',
        $xProd = '',
        $NCM = '',
        $cBenef = '',
        $EXTIPI = '',
        $CFOP = '',
        $uCom = '',
        $qCom = '',
        $vUnCom = '',
        $vProd = '',
        $cEANTrib = '',
        $uTrib = '',
        $qTrib = '',
        $vUnTrib = '',
        $vFrete = '',
        $vSeg = '',
        $vDesc = '',
        $vOutro = '',
        $indTot = '',
        $xPed = '',
        $nItemPed = '',
        $nFCI = ''
    ) {
        $identificador = 'I01 <prod> - ';
        $prod = $this->dom->createElement("prod");
        $this->dom->addChild(
            $prod,
            "cProd",
            $cProd,
            true,
            $identificador . "[item $nItem] Código do produto ou serviço"
        );
        $this->dom->addChild(
            $prod,
            "cEAN",
            $cEAN,
            true,
            $identificador . "[item $nItem] GTIN (Global Trade Item Number) do produto, antigo "
            . "código EAN ou código de barras",
            true
        );
        if ($this->tpAmb == '2' && $this->mod == '65') {
            $xProd = 'NOTA FISCAL EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }
        $this->dom->addChild(
            $prod,
            "xProd",
            $xProd,
            true,
            $identificador . "[item $nItem] Descrição do produto ou serviço"
        );
        $this->dom->addChild(
            $prod,
            "NCM",
            $NCM,
            true,
            $identificador . "[item $nItem] Código NCM com 8 dígitos ou 2 dígitos (gênero)"
        );
        $this->dom->addChild(
            $prod,
            "cBenef",
            $cBenef,
            false,
            $identificador . "[item $nItem] Código de Benefício Fiscal utilizado pela UF"
        );
        $this->dom->addChild(
            $prod,
            "EXTIPI",
            $EXTIPI,
            false,
            $identificador . "[item $nItem] Preencher de acordo com o código EX da TIPI"
        );
        $this->dom->addChild(
            $prod,
            "CFOP",
            $CFOP,
            true,
            $identificador . "[item $nItem] Código Fiscal de Operações e Prestações"
        );
        $this->dom->addChild(
            $prod,
            "uCom",
            $uCom,
            true,
            $identificador . "[item $nItem] Unidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "qCom",
            $qCom,
            true,
            $identificador . "[item $nItem] Quantidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnCom",
            $vUnCom,
            true,
            $identificador . "[item $nItem] Valor Unitário de Comercialização do produto"
        );
        $this->dom->addChild(
            $prod,
            "vProd",
            $vProd,
            true,
            $identificador . "[item $nItem] Valor Total Bruto dos Produtos ou Serviços"
        );
        $this->dom->addChild(
            $prod,
            "cEANTrib",
            $cEANTrib,
            true,
            $identificador . "[item $nItem] GTIN (Global Trade Item Number) da unidade tributável, antigo "
            . "código EAN ou código de barras",
            true
        );
        $this->dom->addChild(
            $prod,
            "uTrib",
            $uTrib,
            true,
            $identificador . "[item $nItem] Unidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "qTrib",
            $qTrib,
            true,
            $identificador . "[item $nItem] Quantidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnTrib",
            $vUnTrib,
            true,
            $identificador . "[item $nItem] Valor Unitário de tributação do produto"
        );
        $this->dom->addChild(
            $prod,
            "vFrete",
            $vFrete,
            false,
            $identificador . "[item $nItem] Valor Total do Frete"
        );
        $this->dom->addChild(
            $prod,
            "vSeg",
            $vSeg,
            false,
            $identificador . "[item $nItem] Valor Total do Seguro"
        );
        $this->dom->addChild(
            $prod,
            "vDesc",
            $vDesc,
            false,
            $identificador . "[item $nItem] Valor do Desconto"
        );
        $this->dom->addChild(
            $prod,
            "vOutro",
            $vOutro,
            false,
            $identificador . "[item $nItem] Outras despesas acessórias"
        );
        $this->dom->addChild(
            $prod,
            "indTot",
            $indTot,
            true,
            $identificador . "[item $nItem] Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)"
        );
        $this->dom->addChild(
            $prod,
            "xPed",
            $xPed,
            false,
            $identificador . "[item $nItem] Número do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nItemPed",
            $nItemPed,
            false,
            $identificador . "[item $nItem] Item do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nFCI",
            $nFCI,
            false,
            $identificador . "[item $nItem] Número de controle da FCI - Ficha de Conteúdo de Importação"
        );
        $this->aProd[$nItem] = $prod;
        return $prod;
    }


    /**
     * Detalhamento de medicamentos K01 pai I90
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]/prod/med (opcional)
     * @param  int $nItem
     * @param  string $cProdANVISA
     * @param  string $vPMC
     * @return DOMElement
     */
    public function tagmed(
        $nItem,
        $cProdANVISA,
        $vPMC
    ) {
        $identificador = 'K01 <med> - ';
        $med = $this->dom->createElement("med");
        $this->dom->addChild(
            $med,
            "cProdANVISA",
            $cProdANVISA,
            true,
            "$identificador [item $nItem] Numero ANVISA"
        );
        $this->dom->addChild(
            $med,
            "vPMC",
            $vPMC,
            true,
            "$identificador [item $nItem] Preço máximo consumidor"
        );
        $this->aMed[$nItem] = $med;
        return $med;
    }

    /**
     * Detalhamento de combustiveis L101 pai I90
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]/prod/comb (opcional)
     * @param string $nItem
     * @param string $cProdANP
     * @param string $descANP
     * @param string $pGLP
     * @param string $pGNn
     * @param string $pGNi
     * @param string $vPart
     * @param string $codif
     * @param string $qTemp
     * @param string $ufCons
     * @param string $qBCProd
     * @param string $vAliqProd
     * @param string $vCIDE
     * @return DOMElement
     */
    public function tagcomb(
        $nItem = '',
        $cProdANP = '',
        $descANP = '',
        $pGLP = '',
        $pGNn = '',
        $pGNi = '',
        $vPart = '',
        $codif = '',
        $qTemp = '',
        $ufCons = '',
        $qBCProd = '',
        $vAliqProd = '',
        $vCIDE = ''
    ) {
        $identificador = 'L101 <comb> - ';
        $comb = $this->dom->createElement("comb");
        $this->dom->addChild(
            $comb,
            "cProdANP",
            $cProdANP,
            true,
            "$identificador [item $nItem] Utilizar a codificação de produtos do"
            . " Sistema de Informações de Movimentação de Produtos - "
            . "SIMP (http://www.anp.gov.br/simp/). (NT 2012/003)"
        );
        $this->dom->addChild(
            $comb,
            "descANP",
            $descANP,
            true,
            "$identificador [item $nItem] Utilizar a descrição de produtos do "
            . "Sistema de Informações de Movimentação de Produtos - "
            . "SIMP (http://www.anp.gov.br/simp/"
        );
        $this->dom->addChild(
            $comb,
            "pGLP",
            $pGLP,
            false,
            "$identificador [item $nItem] Percentual do GLP derivado do "
            . "petróleo no produto GLP (cProdANP=210203001) 1v4"
        );
        $this->dom->addChild(
            $comb,
            "pGNn",
            $pGNn,
            false,
            "$identificador [item $nItem] Percentual de Gás Natural Nacional"
            . " – GLGNn para o produto GLP (cProdANP=210203001) 1v4"
        );
        $this->dom->addChild(
            $comb,
            "pGNi",
            $pGNi,
            false,
            "$identificador [item $nItem] Percentual de Gás Natural Importado"
            . " – GLGNi para o produto GLP (cProdANP=210203001) 1v4"
        );
        $this->dom->addChild(
            $comb,
            "vPart",
            $vPart,
            false,
            "$identificador [item $nItem] Valor de partida (cProdANP=210203001) "
        );
        $this->dom->addChild(
            $comb,
            "CODIF",
            $codif,
            false,
            "$identificador [item $nItem] Código de autorização / registro do"
            . " CODIF"
        );
        $this->dom->addChild(
            $comb,
            "qTemp",
            $qTemp,
            false,
            "$identificador [item $nItem] Quantidade de combustível faturada à temperatura ambiente."
        );
        $this->dom->addChild($comb, "UFCons", $ufCons, true, "[item $nItem] Sigla da UF de consumo");
        if ($qBCProd != "") {
            $tagCIDE = $this->dom->createElement("CIDE");
            $this->dom->addChild(
                $tagCIDE,
                "qBCProd",
                $qBCProd,
                true,
                "$identificador [item $nItem] BC da CIDE"
            );
            $this->dom->addChild(
                $tagCIDE,
                "vAliqProd",
                $vAliqProd,
                true,
                "$identificador [item $nItem] Valor da alíquota da CIDE"
            );
            $this->dom->addChild(
                $tagCIDE,
                "vCIDE",
                $vCIDE,
                true,
                "$identificador [item $nItem] Valor da CIDE"
            );
            $this->dom->appChild($comb, $tagCIDE);
        }
        $this->aComb[$nItem] = $comb;
        return $comb;
    }

    /**
     * Rastreabilidade do produto podem ser até 500 por item TAG I80 pai I01
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]/prod/rastro
     * @param int $nItem
     * @param string $nLote
     * @param float $qLote
     * @param string $dFab
     * @param string $dVal
     * @param string $cAgreg
     * @return DOMElement
     */
    public function tagRastro($nItem, $nLote, $qLote, $dFab, $dVal, $cAgreg = '')
    {
        $identificador = 'I80 <rastro> - ';
        $rastro = $this->dom->createElement("rastro");
        $this->dom->addChild(
            $rastro,
            "nLote",
            substr(trim($nLote), 0, 20),
            true,
            $identificador . "[item $nItem] Número do lote"
        );
        $this->dom->addChild(
            $rastro,
            "qLote",
            number_format($qLote, 3, '.', ''),
            true,
            $identificador . "[item $nItem] Quantidade do lote"
        );
        $this->dom->addChild(
            $rastro,
            "dFab",
            trim($dFab),
            true,
            $identificador . "[item $nItem] Data de fabricação"
        );
        $this->dom->addChild(
            $rastro,
            "dVal",
            trim($dVal),
            true,
            $identificador . "[item $nItem] Data da validade"
        );
        $this->dom->addChild(
            $rastro,
            "cAgreg",
            Strings::onlyNumbers($cAgreg),
            true,
            $identificador . "[item $nItem] Código de Agregação"
        );
        $this->aRastro[$nItem][] = $rastro;
        return $rastro;
    }

    /**
     * Informações do ICMS da Operação própria e ST N01 pai M01
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]/imposto/ICMS
     * @param  string $nItem
     * @param  string $orig
     * @param  string $CST
     * @param  string $modBC
     * @param  string $pRedBC
     * @param  string $vBC
     * @param  string $pICMS
     * @param  string $vICMS
     * @param  string $vICMSDeson
     * @param  string $motDesICMS
     * @param  string $modBCST
     * @param  string $pMVAST
     * @param  string $pRedBCST
     * @param  string $vBCST
     * @param  string $pICMSST
     * @param  string $vICMSST
     * @param  string $pDif
     * @param  string $vICMSDif
     * @param  string $vICMSOp
     * @param  string $vBCSTRet
     * @param  string $vICMSSTRet
     * @param  string $pFCP
     * @param  string $vFCP
     * @param  string $vBCFCPST
     * @param  string $pFCPST
     * @param  string $vFCPST
     * @param  string $vBCFCPSTRet
     * @param  string $pFCPSTRet
     * @param  string $vFCPSTRet
     * @param  string $pST
     * @return DOMElement
     */
    public function tagICMS(
        $nItem = '',
        $orig = '',
        $CST = '',
        $modBC = '',
        $pRedBC = '',
        $vBC = '',
        $pICMS = '',
        $vICMS = '',
        $vICMSDeson = '',
        $motDesICMS = '',
        $modBCST = '',
        $pMVAST = '',
        $pRedBCST = '',
        $vBCST = '',
        $pICMSST = '',
        $vICMSST = '',
        $pDif = '',
        $vICMSDif = '',
        $vICMSOp = '',
        $vBCSTRet = '',
        $vICMSSTRet = '',
        $vBCFCP = '',
        $pFCP = '',
        $vFCP = '',
        $vBCFCPST = '',
        $pFCPST = '',
        $vFCPST = '',
        $vBCFCPSTRet = '',
        $pFCPSTRet = '',
        $vFCPSTRet = '',
        $pST = ''
    ) {
        $identificador = 'N01 <ICMSxx> - ';
        switch ($CST) {
            case '00':
                $icms = $this->dom->createElement("ICMS00");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 00"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $modBC,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $vBC,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $pICMS,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $vICMS,
                    true,
                    "$identificador [item $nItem] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $pFCP,
                    false,
                    "$identificador [item $nItem] Percentual do ICMS "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $vFCP,
                    false,
                    "$identificador [item $nItem] Valor do ICMS relativo "
                    . "ao Fundo de Combate à Pobreza (FCP)"
                );
                break;
            case '10':
                $icms = $this->dom->createElement("ICMS10");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 10"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $modBC,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $vBC,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $pICMS,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $vICMS,
                    true,
                    "$identificador [item $nItem] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $vBCFCP,
                    false,
                    "$identificador [item $nItem] Valor da Base de calculo "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $pFCP,
                    false,
                    "$identificador [item $nItem] Percentual do ICMS "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $vFCP,
                    false,
                    "$identificador [item $nItem] Valor do ICMS relativo "
                    . "ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $modBCST,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $pMVAST,
                    false,
                    "$identificador [item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $pRedBCST,
                    false,
                    "$identificador [item $nItem] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $vBCST,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $pICMSST,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $vICMSST,
                    true,
                    "$identificador [item $nItem] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $pFCPST,
                    false,
                    "[item $nItem] Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $vFCPST,
                    false,
                    "[item $nItem] Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                break;
            case '20':
                $icms = $this->dom->createElement("ICMS20");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 20"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $modBC,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $pRedBC,
                    true,
                    "$identificador [item $nItem] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $vBC,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $pICMS,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $vICMS,
                    true,
                    "$identificador [item $nItem] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $vBCFCP,
                    false,
                    "$identificador [item $nItem] Valor da Base de calculo "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $pFCP,
                    false,
                    "$identificador [item $nItem] Percentual do ICMS "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $vFCP,
                    false,
                    "$identificador [item $nItem] Valor do ICMS relativo "
                    . "ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $vICMSDeson,
                    false,
                    "$identificador [item $nItem] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $motDesICMS,
                    false,
                    "$identificador [item $nItem] Motivo da desoneração do ICMS"
                );
                break;
            case '30':
                $icms = $this->dom->createElement("ICMS30");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 30"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $modBCST,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $pMVAST,
                    false,
                    "$identificador [item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $pRedBCST,
                    false,
                    "$identificador [item $nItem] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $vBCST,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $pICMSST,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $vICMSST,
                    true,
                    "$identificador [item $nItem] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $pFCPST,
                    false,
                    "[item $nItem] Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $vFCPST,
                    false,
                    "[item $nItem] Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $vICMSDeson,
                    false,
                    "$identificador [item $nItem] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $motDesICMS,
                    false,
                    "$identificador [item $nItem] Motivo da desoneração do ICMS"
                );
                break;
            case '40':
            case '41':
            case '50':
                $icms = $this->dom->createElement("ICMS40");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS $CST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $vICMSDeson,
                    false,
                    "$identificador [item $nItem] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $motDesICMS,
                    false,
                    "$identificador [item $nItem] Motivo da desoneração do ICMS"
                );
                break;
            case '51':
                $icms = $this->dom->createElement("ICMS51");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 51"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $modBC,
                    false,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $pRedBC,
                    false,
                    "$identificador [item $nItem] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $vBC,
                    false,
                    "$identificador [item $nItem] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $pICMS,
                    false,
                    "$identificador [item $nItem] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSOp',
                    $vICMSOp,
                    false,
                    "$identificador [item $nItem] Valor do ICMS da Operação"
                );
                $this->dom->addChild(
                    $icms,
                    'pDif',
                    $pDif,
                    false,
                    "$identificador [item $nItem] Percentual do diferimento"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDif',
                    $vICMSDif,
                    false,
                    "$identificador [item $nItem] Valor do ICMS diferido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $vICMS,
                    false,
                    "$identificador [item $nItem] Valor do ICMS realmente devido"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $vBCFCP,
                    false,
                    "$identificador [item $nItem] Valor da Base de calculo "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $pFCP,
                    false,
                    "$identificador [item $nItem] Percentual do ICMS "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $vFCP,
                    false,
                    "$identificador [item $nItem] Valor do ICMS relativo "
                    . "ao Fundo de Combate à Pobreza (FCP)"
                );
                break;
            case '60':
                $icms = $this->dom->createElement("ICMS60");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 60"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCSTRet',
                    $vBCSTRet,
                    false,
                    "$identificador [item $nItem] Valor da BC do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTRet',
                    $vICMSSTRet,
                    false,
                    "$identificador [item $nItem] Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP "
                    . "retido anteriormente"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPSTRet',
                    $pFCPSTRet,
                    false,
                    "[item $nItem] "
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPSTRet',
                    $vFCPSTRet,
                    false,
                    "[item $nItem] "
                );
                $this->dom->addChild(
                    $icms,
                    'pST',
                    $pST,
                    false,
                    "[item $nItem] "
                );
                break;
            case '70':
                $icms = $this->dom->createElement("ICMS70");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 70"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $modBC,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $pRedBC,
                    true,
                    "$identificador [item $nItem] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $vBC,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $pICMS,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $vICMS,
                    true,
                    "$identificador [item $nItem] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $vBCFCP,
                    false,
                    "$identificador [item $nItem] Valor da Base de calculo "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $pFCP,
                    false,
                    "$identificador [item $nItem] Percentual do ICMS "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $vFCP,
                    false,
                    "$identificador [item $nItem] Valor do ICMS relativo "
                    . "ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $modBCST,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $pMVAST,
                    false,
                    "$identificador [item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $pRedBCST,
                    false,
                    "$identificador [item $nItem] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $vBCST,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $pICMSST,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $vICMSST,
                    true,
                    "$identificador [item $nItem] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $pFCPST,
                    false,
                    "[item $nItem] Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $vFCPST,
                    false,
                    "[item $nItem] Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $vICMSDeson,
                    false,
                    "$identificador [item $nItem] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $motDesICMS,
                    false,
                    "$identificador [item $nItem] Motivo da desoneração do ICMS"
                );
                break;
            case '90':
                $icms = $this->dom->createElement("ICMS90");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $orig,
                    true,
                    "$identificador [item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $CST,
                    true,
                    "$identificador [item $nItem] Tributação do ICMS = 90"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $modBC,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $vBC,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $pRedBC,
                    false,
                    "$identificador [item $nItem] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $pICMS,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $vICMS,
                    true,
                    "$identificador [item $nItem] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $vBCFCP,
                    false,
                    "$identificador [item $nItem] Valor da Base de calculo "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $pFCP,
                    false,
                    "$identificador [item $nItem] Percentual do ICMS "
                    . "relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $vFCP,
                    false,
                    "$identificador [item $nItem] Valor do ICMS relativo "
                    . "ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $modBCST,
                    true,
                    "$identificador [item $nItem] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $pMVAST,
                    false,
                    "$identificador [item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $pRedBCST,
                    false,
                    "$identificador [item $nItem] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $vBCST,
                    true,
                    "$identificador [item $nItem] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $pICMSST,
                    true,
                    "$identificador [item $nItem] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $vICMSST,
                    true,
                    "$identificador [item $nItem] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $pFCPST,
                    false,
                    "[item $nItem] Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $vFCPST,
                    false,
                    "[item $nItem] Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $vICMSDeson,
                    false,
                    "$identificador [item $nItem] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $motDesICMS,
                    false,
                    "$identificador [item $nItem] Motivo da desoneração do ICMS"
                );
                break;
        }
        $tagIcms = $this->dom->createElement('ICMS');
        if (isset($icms)) {
            $tagIcms->appendChild($icms);
        }
        $this->aICMS[$nItem] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Tributação ICMS pelo Simples Nacional N10c pai N01
     * NOTA: Ajustado para NT2016_002_v1.00
     * Tag NFe/infNFe/det[]/imposto/ICMS/ICMSSNxxx
     * @param  string $nItem
     * @param  string $orig
     * @param  string $csosn
     * @param  string $modBC
     * @param  string $vBC
     * @param  string $pRedBC
     * @param  string $pICMS
     * @param  string $vICMS
     * @param  string $pCredSN
     * @param  string $vCredICMSSN
     * @param  string $modBCST
     * @param  string $pMVAST
     * @param  string $pRedBCST
     * @param  string $vBCST
     * @param  string $pICMSST
     * @param  string $vICMSST
     * @param  string $vBCSTRet
     * @param  string $vICMSSTRet
     * @param  string $vBCFCPST
     * @param  string $pFCPST
     * @param  string $vFCPST
     * @param  string $vBCFCPSTRet
     * @param  string $pFCPSTRet
     * @param  string $vFCPSTRet
     * @param  string $pST
     * @return DOMElement
     */
    public function tagICMSSN(
        $nItem = '',
        $orig = '',
        $csosn = '',
        $modBC = '',
        $vBC = '',
        $pRedBC = '',
        $pICMS = '',
        $vICMS = '',
        $pCredSN = '',
        $vCredICMSSN = '',
        $modBCST = '',
        $pMVAST = '',
        $pRedBCST = '',
        $vBCST = '',
        $pICMSST = '',
        $vICMSST = '',
        $vBCSTRet = '',
        $vICMSSTRet = '',
        $vBCFCPST = '',
        $pFCPST = '',
        $vFCPST = '',
        $vBCFCPSTRet = '',
        $pFCPSTRet = '',
        $vFCPSTRet = '',
        $pST = ''
    ) {
        switch ($csosn) {
            case '101':
                $icmsSN = $this->dom->createElement("ICMSSN101");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $orig,
                    true,
                    "[item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $csosn,
                    true,
                    "[item $nItem] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $pCredSN,
                    true,
                    "[item $nItem] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $vCredICMSSN,
                    true,
                    "[item $nItem] Valor crédito do ICMS que pode ser aproveitado nos termos do"
                    . " art. 23 da LC 123 (Simples Nacional)"
                );
                break;
            case '102':
            case '103':
            case '300':
            case '400':
                $icmsSN = $this->dom->createElement("ICMSSN102");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $orig,
                    true,
                    "[item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $csosn,
                    true,
                    "[item $nItem] Código de Situação da Operação Simples Nacional"
                );
                break;
            case '201':
                $icmsSN = $this->dom->createElement("ICMSSN201");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $orig,
                    true,
                    "[item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $csosn,
                    true,
                    "[item $nItem] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $modBCST,
                    true,
                    "[item $nItem] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $pMVAST,
                    false,
                    "[item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $pRedBCST,
                    false,
                    "[item $nItem] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $vBCST,
                    true,
                    "[item $nItem] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $pICMSST,
                    true,
                    "[item $nItem] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $vICMSST,
                    true,
                    "[item $nItem] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $pCredSN,
                    true,
                    "[item $nItem] Alíquota aplicável de cálculo do "
                    . "crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $vCredICMSSN,
                    true,
                    "[item $nItem] Valor crédito do ICMS que pode ser aproveitado nos "
                    . "termos do art. 23 da LC 123 (Simples Nacional)"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $pFCPST,
                    false,
                    "[item $nItem] Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $vFCPST,
                    false,
                    "[item $nItem] Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                break;
            case '202':
            case '203':
                $icmsSN = $this->dom->createElement("ICMSSN202");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $orig,
                    true,
                    "[item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $csosn,
                    true,
                    "[item $nItem] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $modBCST,
                    true,
                    "[item $nItem] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $pMVAST,
                    false,
                    "[item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $pRedBCST,
                    false,
                    "[item $nItem] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $vBCST,
                    true,
                    "[item $nItem] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $pICMSST,
                    true,
                    "[item $nItem] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $vICMSST,
                    true,
                    "[item $nItem] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $pFCPST,
                    false,
                    "[item $nItem] Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $vFCPST,
                    false,
                    "[item $nItem] Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                break;
            case '500':
                $icmsSN = $this->dom->createElement("ICMSSN500");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $orig,
                    true,
                    "[item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $csosn,
                    true,
                    "[item $nItem] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCSTRet',
                    $vBCSTRet,
                    false,
                    "[item $nItem] Valor da BC do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSSTRet',
                    $vICMSSTRet,
                    false,
                    "[item $nItem] Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPSTRet',
                    $vBCFCPSTRet,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP "
                    . "retido anteriormente"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPSTRet',
                    $pFCPSTRet,
                    false,
                    "[item $nItem] Percentual do FCP retido anteriormente "
                    . "por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPSTRet',
                    $vFCPSTRet,
                    false,
                    "[item $nItem] Valor do FCP retido anteriormente por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pST',
                    $pST,
                    false,
                    "[item $nItem] Alíquota suportada pelo Consumidor Final"
                );
                break;
            case '900':
                $icmsSN = $this->dom->createElement("ICMSSN900");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $orig,
                    true,
                    "[item $nItem] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $csosn,
                    true,
                    "[item $nItem] Código de Situação da Operação "
                    . "Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBC',
                    $modBC,
                    false,
                    "[item $nItem] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBC',
                    $vBC,
                    false,
                    "[item $nItem] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBC',
                    $pRedBC,
                    false,
                    "[item $nItem] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMS',
                    $pICMS,
                    false,
                    "[item $nItem] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMS',
                    $vICMS,
                    false,
                    "[item $nItem] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $modBCST,
                    false,
                    "[item $nItem] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $pMVAST,
                    false,
                    "[item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $pRedBCST,
                    false,
                    "[item $nItem] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $vBCST,
                    false,
                    "[item $nItem] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $pICMSST,
                    false,
                    "[item $nItem] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $vICMSST,
                    false,
                    "[item $nItem] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $vBCFCPST,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $pFCPST,
                    false,
                    "[item $nItem] Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $vFCPST,
                    false,
                    "[item $nItem] Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $pCredSN,
                    false,
                    "[item $nItem] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $vCredICMSSN,
                    false,
                    "[item $nItem] Valor crédito do ICMS que pode ser "
                    . "aproveitado nos termos do"
                    . " art. 23 da LC 123 (Simples Nacional)"
                );
                break;
        }
        //caso exista a tag aICMS[$nItem] inserir nela caso contrario criar
        if (!empty($this->aICMS[$nItem])) {
            $tagIcms = $this->aICMS[$nItem];
        } else {
            $tagIcms = $this->dom->createElement('ICMS');
        }
        if (isset($icmsSN)) {
            $this->dom->appChild($tagIcms, $icmsSN, "Inserindo ICMSST em ICMS[$nItem]");
        }
        $this->aICMS[$nItem] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Grupo ICMSUFDest NA01 pai M01
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]/imposto/ICMSUFDest (opcional)
     * Grupo a ser informado nas vendas interestaduais para consumidor final,
     * não contribuinte do ICMS
     * @param  string $nItem
     * @param  string $vBCUFDest
     * @param  string $vBCFCPUFDest
     * @param  string $pFCPUFDest
     * @param  string $pICMSUFDest
     * @param  string $pICMSInter
     * @param  string $pICMSInterPart
     * @param  string $vFCPUFDest
     * @param  string $vICMSUFDest
     * @param  string $vICMSUFRemet
     * @return DOMElement
     */
    public function tagICMSUFDest(
        $nItem = '',
        $vBCUFDest = '',
        $vBCFCPUFDest = '',
        $pFCPUFDest = '',
        $pICMSUFDest = '',
        $pICMSInter = '',
        $pICMSInterPart = '',
        $vFCPUFDest = '',
        $vICMSUFDest = '',
        $vICMSUFRemet = ''
    ) {
        $icmsUFDest = $this->dom->createElement('ICMSUFDest');
        $this->dom->addChild(
            $icmsUFDest,
            "vBCUFDest",
            $vBCUFDest,
            true,
            "[item $nItem] Valor da BC do ICMS na UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vBCFCPUFDest",
            $vBCFCPUFDest,
            true,
            "[item $nItem] Valor da BC FCP na UF de destino"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pFCPUFDest",
            $pFCPUFDest,
            true,
            "[item $nItem] Percentual do ICMS relativo ao Fundo de "
            . "Combate à Pobreza (FCP) na UF de destino"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSUFDest",
            $pICMSUFDest,
            true,
            "[item $nItem] Alíquota interna da UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSInter",
            $pICMSInter,
            true,
            "[item $nItem] Alíquota interestadual das UF envolvidas"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSInterPart",
            $pICMSInterPart,
            true,
            "[item $nItem] Percentual provisório de partilha entre os Estados"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vFCPUFDest",
            $vFCPUFDest,
            true,
            "[item $nItem] Valor do ICMS relativo ao Fundo de Combate à "
            . "Pobreza (FCP) da UF de destino"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vICMSUFDest",
            $vICMSUFDest,
            true,
            "[item $nItem] Valor do ICMS de partilha para a UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vICMSUFRemet",
            $vICMSUFRemet,
            true,
            "[item $nItem] Valor do ICMS de partilha para a UF do remetente"
        );
        $this->aICMSUFDest[$nItem] = $icmsUFDest;
        $this->aTotICMSUFDest['vICMSUFDest'] += $vICMSUFDest;
        $this->aTotICMSUFDest['vFCPUFDest'] += $vFCPUFDest;
        $this->aTotICMSUFDest['vICMSUFRemet'] += $vICMSUFRemet;
        return $icmsUFDest;
    }

    /**
     * Grupo Totais referentes ao ICMS W02 pai W01
     * tag NFe/infNFe/total/ICMSTot
     * @param  string $vBC
     * @param  string $vICMS
     * @param  string $vICMSDeson
     * @param  string $vBCST
     * @param  string $vST
     * @param  string $vProd
     * @param  string $vFrete
     * @param  string $vSeg
     * @param  string $vDesc
     * @param  string $vII
     * @param  string $vIPI
     * @param  string $vPIS
     * @param  string $vCOFINS
     * @param  string $vOutro
     * @param  string $vNF
     * @param  string $vTotTrib
     * @return DOMElement
     */
    public function tagICMSTot(
        $vBC = '',
        $vICMS = '',
        $vICMSDeson = '',
        $vFCP = '',
        $vBCST = '',
        $vST = '',
        $vFCPST = '',
        $vFCPSTRet = '',
        $vProd = '',
        $vFrete = '',
        $vSeg = '',
        $vDesc = '',
        $vII = '',
        $vIPI = '',
        $vIPIDevol = '',
        $vPIS = '',
        $vCOFINS = '',
        $vOutro = '',
        $vNF = '',
        $vTotTrib = ''
    ) {
        $this->buildTotal();
        $ICMSTot = $this->dom->createElement("ICMSTot");
        $this->dom->addChild(
            $ICMSTot,
            "vBC",
            $vBC,
            true,
            "Base de Cálculo do ICMS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMS",
            $vICMS,
            true,
            "Valor Total do ICMS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSDeson",
            $vICMSDeson,
            true,
            "Valor Total do ICMS desonerado"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFCP",
            $vFCP,
            true,
            "Valor Total do FCP (Fundo de Combate à Pobreza)"
        );
        /**
        $this->dom->addChild(
        $ICMSTot,
        "vFCPUFDest",
        $this->aTotICMSUFDest['vFCPUFDest'],
        false,
        "Valor total do ICMS relativo ao Fundo de Combate à Pobreza(FCP) para a UF de destino"
        );
         *
         */
        /**
        $this->dom->addChild(
        $ICMSTot,
        "vICMSUFDest",
        $this->aTotICMSUFDest['vICMSUFDest'],
        false,
        "Valor total do ICMS de partilha para a UF do destinatário"
        );
         *
         */
        /**
        $this->dom->addChild(
        $ICMSTot,
        "vICMSUFRemet",
        $this->aTotICMSUFDest['vICMSUFRemet'],
        false,
        "Valor total do ICMS de partilha para a UF do remetente"
        );
         *
         */
        $this->dom->addChild(
            $ICMSTot,
            "vBCST",
            $vBCST,
            true,
            "Base de Cálculo do ICMS ST"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vST",
            $vST,
            true,
            "Valor Total do ICMS ST"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFCPST",
            $vFCPST,
            true,
            "Valor Total do FCP (Fundo de Combate à Pobreza) retido "
            . "por substituição tributária"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFCPSTRet",
            $vFCPSTRet,
            true,
            "Valor Total do FCP retido anteriormente por "
            . "Substituição Tributária"
        );

        $this->dom->addChild(
            $ICMSTot,
            "vProd",
            $vProd,
            true,
            "Valor Total dos produtos e serviços"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFrete",
            $vFrete,
            true,
            "Valor Total do Frete"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vSeg",
            $vSeg,
            true,
            "Valor Total do Seguro"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vDesc",
            $vDesc,
            true,
            "Valor Total do Desconto"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vII",
            $vII,
            true,
            "Valor Total do II"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vIPI",
            $vIPI,
            true,
            "Valor Total do IPI"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vIPIDevol",
            $vIPIDevol,
            true,
            "Valor Total do IPI devolvido"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vPIS",
            $vPIS,
            true,
            "Valor do PIS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vCOFINS",
            $vCOFINS,
            true,
            "Valor da COFINS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vOutro",
            $vOutro,
            true,
            "Outras Despesas acessórias"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vNF",
            $vNF,
            true,
            "Valor Total da NF-e"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vTotTrib",
            $vTotTrib,
            false,
            "Valor aproximado total de tributos federais, estaduais e municipais."
        );
        $this->dom->appChild($this->total, $ICMSTot, '');
        return $ICMSTot;
    }

    /**
     * Grupo de Formas de Pagamento YA01 pai A01
     * NOTA: Ajustado para NT2016_002_v1.20
     * tag NFe/infNFe/pag (obrigatorio na NT2016_002_v1.20)
     * Apenas para o modelo 65 NFCe
     * @param float $vTroco
     * @return DOMElement
     */
    public function tagpag(
        $vTroco
    ) {
        $this->buildPag();
        $pag = $this->dom->createElement("pag");
        $this->dom->addChild(
            $this->aPag[0],
            "vTroco",
            $vTroco,
            false,
            "Valor do troco"
        );
        return $pag;
    }

    /**
     * Grupo de Formas de Pagamento YA01a pai YA01
     * NOTA: Ajuste nt_2016_002_v1.20
     * tag NFe/infNFe/pag/detPag
     * @param  int $nItemDetPag
     * @param int $tPag
     * @param float $vPag
     * @param float $vTroco
     * @return DOMElement
     */
    public function tagDetPag(
        $nItemDetPag,
        $tPag,
        $vPag
    ) {
        $this->aDetPag[$nItemDetPag] = $this->dom->createElement("detPag");
        $detPag = $this->dom->createElement("detPag");
        $this->dom->addChild(
            $this->aDetPag[$nItemDetPag],
            "tPag",
            $tPag,
            true,
            "Forma de pagamento"
        );
        $this->dom->addChild(
            $this->aDetPag[$nItemDetPag],
            "vPag",
            $vPag,
            true,
            "Valor do Pagamento"
        );
        return $detPag;
    }

    /**
     * Grupo de Cartões YA04 pai YA01a
     * NOTA: Ajustado para NT2016_002_v1.20
     * tag NFe/infNFe/pag/card
     * @param  int $nItemDetPag
     * @param  string $cnpj
     * @param  string $tBand
     * @param  string $cAut
     * @param  string $tpIntegra
     * @return DOMElement
     */
    public function tagcard(
        $nItemDetPag = 0,
        $cnpj = '',
        $tBand = '',
        $cAut = '',
        $tpIntegra = ''
    ) {
        //apenas para modelo 65
        if ($this->mod == '65' && $tBand != '') {
            $card = $this->dom->createElement("card");
            $this->dom->addChild(
                $card,
                "tpIntegra",
                $tpIntegra,
                false,
                "Tipo de Integração para pagamento"
            );
            $this->dom->addChild(
                $card,
                "CNPJ",
                $cnpj,
                true,
                "CNPJ da Credenciadora de cartão de crédito e/ou débito"
            );
            $this->dom->addChild(
                $card,
                "tBand",
                $tBand,
                true,
                "Bandeira da operadora de cartão de crédito e/ou débito"
            );
            $this->dom->addChild(
                $card,
                "cAut",
                $cAut,
                true,
                "Número de autorização da operação cartão de crédito e/ou débito"
            );
            $this->dom->appChild($this->aDetPag[$nItemDetPag], $card, "Inclusão do node Card");

            return $card;
        }
    }


    /**
     * Insere dentro da tag det os produtos
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]
     */
    protected function buildDet()
    {
        if (empty($this->aProd)) {
            return '';
        }
        //insere NVE
        foreach ($this->aNVE as $nItem => $nve) {
            $prod = $this->aProd[$nItem];
            foreach ($nve as $child) {
                $node = $prod->getElementsByTagName("cBenef")->item(0);
                if (empty($node)) {
                    $node = $prod->getElementsByTagName("EXTIPI")->item(0);
                    if (empty($node)) {
                        $node = $prod->getElementsByTagName("CFOP")->item(0);
                    }
                }
                $prod->insertBefore($child, $node);
            }
        }
        //insere ctrltST só pode existir um por item
        foreach ($this->aCest as $nItem => $ctrltST) {
            $prod = $this->aProd[$nItem];
            $node = $prod->getElementsByTagName("cBenef")->item(0);
            if (empty($node)) {
                $node = $prod->getElementsByTagName("EXTIPI")->item(0);
                if (empty($node)) {
                    $node = $prod->getElementsByTagName("CFOP")->item(0);
                }
            }
            $prod->insertBefore($ctrltST, $node);
        }
        //insere DI
        foreach ($this->aDI as $nItem => $aDI) {
            $prod = $this->aProd[$nItem];
            foreach ($aDI as $child) {
                $node = $prod->getElementsByTagName("xPed")->item(0);
                if (! empty($node)) {
                    $prod->insertBefore($child, $node);
                } else {
                    $this->dom->appChild($prod, $child, "Inclusão do node DI");
                }
            }
            $this->aProd[$nItem] = $prod;
        }
        //insere detExport
        foreach ($this->aDetExport as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            $this->dom->appChild($prod, $child, "Inclusão do node detExport");
            $this->aProd[$nItem] = $prod;
        }
        //insere rastro
        foreach ($this->aRastro as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            $this->dom->appChild($prod, $child, "Inclusão do node rastro");
            $this->aProd[$nItem] = $prod;
        }
        //insere veiculo
        foreach ($this->aVeicProd as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            $this->dom->appChild($prod, $child, "Inclusão do node veiculo");
            $this->aProd[$nItem] = $prod;
        }
        //insere medicamentos
        foreach ($this->aMed as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            $this->dom->appChild($prod, $child, "Inclusão do node medicamento");
            $this->aProd[$nItem] = $prod;
        }
        //insere armas
        foreach ($this->aArma as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            $this->dom->appChild($prod, $child, "Inclusão do node arma");
            $this->aProd[$nItem] = $prod;
        }
        //insere combustivel
        foreach ($this->aComb as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            if (! empty($this->aEncerrante)) {
                $encerrante = $this->aEncerrante[$nItem];
                if (! empty($encerrante)) {
                    $this->dom->appChild($child, $encerrante, "inclusão do node encerrante na tag comb");
                }
            }
            $this->dom->appChild($prod, $child, "Inclusão do node combustivel");
            $this->aProd[$nItem] = $prod;
        }
        //insere RECOPI
        foreach ($this->aRECOPI as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            $this->dom->appChild($prod, $child, "Inclusão do node RECOPI");
            $this->aProd[$nItem] = $prod;
        }
        //montagem da tag imposto[]
        $this->buildImp();
        //montagem da tag det[]
        foreach ($this->aProd as $nItem => $prod) {
            $det = $this->dom->createElement("det");
            $det->setAttribute("nItem", $nItem);
            $det->appendChild($prod);
            //insere imposto
            if (!empty($this->aImposto[$nItem])) {
                $child = $this->aImposto[$nItem];
                $this->dom->appChild($det, $child, "Inclusão do node imposto");
            }
            //insere impostoDevol
            if (!empty($this->aImpostoDevol)) {
                $child = $this->aImpostoDevol[$nItem];
                $this->dom->appChild($det, $child, "Inclusão do node impostoDevol");
            }
            //insere infAdProd
            if (!empty($this->aInfAdProd[$nItem])) {
                $child = $this->aInfAdProd[$nItem];
                $this->dom->appChild($det, $child, "Inclusão do node infAdProd");
            }
            $this->aDet[] = $det;
            $det = null;
        }
    }

    /**
     * Insere a tag pag, os detalhamentos dos pagamentos e cartoes
     * NOTA: Ajustado para NT2016_002_v1.20
     * tag NFe/infNFe/pag/
     * tag NFe/infNFe/pag/detPag[]
     * tag NFe/infNFe/pag/detPag[]/Card
     */
    protected function buildTagPag()
    {
        $this->dom->appChild($this->infNFe, $this->aPag[0], 'Falta tag "infNFe"');
        if (count($this->aDetPag)) {
            foreach ($this->aDetPag as $detPag) {
                $node = $this->aPag[0]->getElementsByTagName("vTroco")->item(0);
                if (!empty($node)) {
                    $this->aPag[0]->insertBefore($detPag, $node);
                } else {
                    $this->dom->appChild($this->aPag[0], $detPag, 'Falta tag "Pag"');
                }
            }
        }
    }
}
