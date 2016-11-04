<?php

namespace NFePHP\NFe;

/**
 * Classe a construção do xml da NFe modelo 55 e modelo 65
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\MakeNFe
 * @copyright Copyright (c) 2008
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */


use Brazanation\Documents\NFeAccessKey;
use Brazanation\Documents\Exception\InvalidDocument as  InvalidDocumentException;

use NFePHP\Common\SpedDOM;
use \DOMDocument;
use \DOMElement;
use \DOMNode;

class Make
{
    /**
     * @var array
     */
    public $erros = [];
    /**
     * @var string
     */
    public $chNFe;
    /**
     * @var string
     */
    public $xml = '';
    /**
     * @var string
     */
    private $versao = '3.10';
    /**
     * @var integer
     */
    private $mod = 55;
    /**
     * @var \NFePHP\Common\Dom\Dom
     */
    private $dom;
    /**
     * @var string
     */
    private $tpAmb = '2';
    /**
     * @var DOMElement
     */
    private $NFe;
    /**
     * @var DOMElement
     */
    private $infNFe;
    /**
     * @var DOMElement
     */
    private $ide;
    /**
     * @var DOMElement
     */
    private $emit;
    /**
     * @var DOMElement
     */
    private $enderEmit;
    /**
     * @var DOMElement
     */
    private $dest;
    /**
     * @var DOMElement
     */
    private $enderDest;
    /**
     * @var DOMElement
     */
    private $retirada;
    /**
     * @var DOMElement
     */
    private $entrega;
    /**
     * @var DOMElement
     */
    private $total;
    /**
     * @var DOMElement
     */
    private $cobr;
    /**
     * @var DOMElement
     */
    private $transp;
    /**
     * @var DOMElement
     */
    private $infAdic;
    /**
     * @var DOMElement
     */
    private $exporta;
    /**
     * @var DOMElement
     */
    private $compra;
    /**
     * @var DOMElement
     */
    private $cana;
    /**
     * @var array
     */
    private $aTotICMSUFDest = ['vFCPUFDest' => '', 'vICMSUFDest' => '', 'vICMSUFRemet' => ''];
    /**
     * @var array
     */
    private $aNFref = [];
    /**
     * @var array
     */
    private $aDup = [];
    /**
     * @var array
     */
    private $aPag = [];
    /**
     * @var array
     */
    private $aReboque = [];
    /**
     * @var array
     */
    private $aVol = [];
    /**
     * @var array
     */
    private $aAutXML = [];
    /**
     * @var array
     */
    private $aDet = [];
    /**
     * @var array
     */
    private $aProd = [];
    /**
     * @var array
     */
    private $aNVE = [];
    /**
     * @var array
     */
    private $aCest = [];
    /**
     * @var array
     */
    private $aRECOPI = [];
    /**
     * @var array
     */
    private $aDetExport = [];
    /**
     * @var array
     */
    private $aDI = [];
    /**
     * @var array
     */
    private $aAdi = [];
    /**
     * @var array
     */
    private $aVeicProd = [];
    /**
     * @var array
     */
    private $aMed = [];
    /**
     * @var array
     */
    private $aArma = [];
    /**
     * @var array
     */
    private $aComb = [];
    /**
     * @var array
     */
    private $aEncerrante = [];
    /**
     * @var array
     */
    private $aImposto = [];
    /**
     * @var array
     */
    private $aICMS = [];
    /**
     * @var array
     */
    private $aICMSUFDest = [];
    /**
     * @var array
     */
    private $aIPI = [];
    /**
     * @var array
     */
    private $aII = [];
    /**
     * @var array
     */
    private $aISSQN = [];
    /**
     * @var array
     */
    private $aPIS = [];
    /**
     * @var array
     */
    private $aPISST = [];
    /**
     * @var array
     */
    private $aCOFINS = [];
    /**
     * @var array
     */
    private $aCOFINSST = [];
    /**
     * @var array
     */
    private $aImpostoDevol = [];
    /**
     * @var array
     */
    private $aInfAdProd = [];
    /**
     * @var array
     */
    private $aObsCont = [];
    /**
     * @var array
     */
    private $aObsFisco = [];
    /**
     * @var array
     */
    private $aProcRef = [];
    /**
     * @var array
     */
    private $aForDia = [];
    /**
     * @var array
     */
    private $aDeduc = [];

    /**
     * Função construtora cria um objeto DOMDocument
     * que será carregado com o documento fiscal
     */
    public function __construct()
    {
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;
    }
    
    /**
     * Retorna o xml que foi montado
     * @return string
     */
    public function __toString()
    {
        return $this->xml;
    }
    
    /**
     * Retorna o numero da chave da NFe
     * @return type
     */
    public function chave()
    {
        return $this->chNFe;
    }
    
    /**
     * Retrona o modelo de NFe 55 ou 65
     * @return int
     */
    public function modelo()
    {
        return $this->mod;
    }
    
    /**
     * montaNFe
     * Método de montagem do xml da NFe
     * essa função retorna TRUE em caso de sucesso ou FALSE se houve erro
     * O xml da NFe deve ser recuperado pela funçao __toString() ou diretamente pela
     * propriedade publica $xml
     * @return boolean
     */
    public function montaNFe()
    {
        //cria a tag raiz da Nfe
        $this->buildNFe();
        //cria a tagInfNFe se ainda não existir
        if (empty($this->infNFe)) {
            $this->taginfNFe('11', $this->versao);
        }
        //processa nfeRef e coloca as tags na tag ide
        foreach ($this->aNFref as $nfeRef) {
            $this->dom->appChild($this->ide, $nfeRef, 'Falta tag "ide"');
        }
        //monta as tags det com os detalhes dos produtos
        $this->buildDet();
        //[2] tag ide (5 B01)
        $this->dom->appChild($this->infNFe, $this->ide, 'Falta tag "infNFe"');
        //[8] tag emit (30 C01)
        $this->dom->appChild($this->infNFe, $this->emit, 'Falta tag "infNFe"');
        //[10] tag dest (62 E01)
        $this->dom->appChild($this->infNFe, $this->dest, 'Falta tag "infNFe"');
        //[12] tag retirada (80 F01)
        $this->dom->appChild($this->infNFe, $this->retirada, 'Falta tag "infNFe"');
        //[13] tag entrega (89 G01)
        $this->dom->appChild($this->infNFe, $this->entrega, 'Falta tag "infNFe"');
        //[14] tag autXML (97a.1 G50)
        foreach ($this->aAutXML as $aut) {
            $this->dom->appChild($this->infNFe, $aut, 'Falta tag "infNFe"');
        }
        //[14a] tag det (98 H01)
        foreach ($this->aDet as $det) {
            $this->dom->appChild($this->infNFe, $det, 'Falta tag "infNFe"');
        }
        //[28a] tag total (326 W01)
        $this->dom->appChild($this->infNFe, $this->total, 'Falta tag "infNFe"');
        //[32] tag transp (356 X01)
        $this->dom->appChild($this->infNFe, $this->transp, 'Falta tag "infNFe"');
        //[39a] tag cobr (389 Y01)
        $this->dom->appChild($this->infNFe, $this->cobr, 'Falta tag "infNFe"');
        //[42] tag pag (398a YA01)
        //processa aPag e coloca as tags na tag pag
        foreach ($this->aPag as $pag) {
            $this->dom->appChild($this->infNFe, $pag, 'Falta tag "infNFe"');
        }
        //[44] tag infAdic (399 Z01)
        $this->dom->appChild($this->infNFe, $this->infAdic, 'Falta tag "infNFe"');
        //[48] tag exporta (402 ZA01)
        $this->dom->appChild($this->infNFe, $this->exporta, 'Falta tag "infNFe"');
        //[49] tag compra (405 ZB01)
        $this->dom->appChild($this->infNFe, $this->compra, 'Falta tag "infNFe"');
        //[50] tag cana (409 ZC01)
        $this->dom->appChild($this->infNFe, $this->cana, 'Falta tag "infNFe"');
        //[1] tag infNFe (1 A01)
        $this->dom->appChild($this->NFe, $this->infNFe, 'Falta tag "NFe"');
        //[0] tag NFe
        $this->dom->appChild($this->dom, $this->NFe, 'Falta DOMDocument');
        //testa da chave e a refaz se necessário
        $this->checkNFeKey($this->dom);
        
        if (count($this->dom->erros) > 0) {
            return false;
        }
        $this->xml = $this->dom->saveXML();
        return true;
    }

    /**
     * Informações da NF-e A01 pai NFe
     * tag NFe/infNFe
     * @param string $chave
     * @param string $versao
     * @return DOMElement
     */
    public function taginfNFe($chave, $versao)
    {
        $this->infNFe = $this->dom->createElement("infNFe");
        $this->infNFe->setAttribute("Id", 'NFe' . $chave);
        $this->infNFe->setAttribute("versao", $versao);
        $this->versao = $versao;
        $this->chNFe = $chave;
        return $this->infNFe;
    }

    /**
     * Informações de identificação da NF-e B01 pai A01
     * tag NFe/infNFe/ide
     * @param string $cUF
     * @param string $cNF
     * @param string $natOp
     * @param string $indPag
     * @param string $mod
     * @param string $serie
     * @param string $nNF
     * @param string $dhEmi
     * @param string $dhSaiEnt
     * @param string $tpNF
     * @param string $idDest
     * @param string $cMunFG
     * @param string $tpImp
     * @param string $tpEmis
     * @param string $cDV
     * @param string $tpAmb
     * @param string $finNFe
     * @param string $indFinal
     * @param string $indPres
     * @param string $procEmi
     * @param string $verProc
     * @param string $dhCont
     * @param string $xJust
     * @return DOMElement
     */
    public function tagide(
        $cUF = '',
        $cNF = '',
        $natOp = '',
        $indPag = '',
        $mod = '',
        $serie = '',
        $nNF = '',
        $dhEmi = '',
        $dhSaiEnt = '',
        $tpNF = '',
        $idDest = '',
        $cMunFG = '',
        $tpImp = '',
        $tpEmis = '',
        $cDV = '',
        $tpAmb = '',
        $finNFe = '',
        $indFinal = '0',
        $indPres = '',
        $procEmi = '',
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
            $cNF,
            true,
            $identificador . "Código Numérico que compõe a Chave de Acesso"
        );
        $this->dom->addChild(
            $ide,
            "natOp",
            $natOp,
            true,
            $identificador . "Descrição da Natureza da Operaçãoo"
        );
        $this->dom->addChild(
            $ide,
            "indPag",
            $indPag,
            true,
            $identificador . "Indicador da forma de pagamento"
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
        if ($dhEmi == '') {
            $dhEmi = DateTime::convertTimestampToSefazTime();
        }
        $this->dom->addChild(
            $ide,
            "dhEmi",
            $dhEmi,
            true,
            $identificador . "Data e hora de emissão do Documento Fiscal"
        );
        if ($mod == '55' && $dhSaiEnt != '') {
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
                $xJust,
                true,
                $identificador . "Justificativa da entrada em contingência"
            );
        }
        $this->mod = $mod;
        $this->ide = $ide;
        return $ide;
    }

    /**
     * Chave de acesso da NF-e referenciada BA02 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFe
     * @param string $refNFe
     * @return DOMElement
     */
    public function tagrefNFe($refNFe = '')
    {
        $num = $this->builtNFref();
        $refNFe = $this->dom->createElement("refNFe", $refNFe);
        $this->dom->appChild($this->aNFref[$num-1], $refNFe);
        return $refNFe;
    }

    /**
     * Informação da NF modelo 1/1A referenciada BA03 pai BA01
     * tag NFe/infNFe/ide/NFref/NF DOMNode
     * @param string $cUF
     * @param string $aamm
     * @param string $cnpj
     * @param string $mod
     * @param string $serie
     * @param string $nNF
     * @return DOMElement
     */
    public function tagrefNF(
        $cUF = '',
        $aamm = '',
        $cnpj = '',
        $mod = '',
        $serie = '',
        $nNF = ''
    ) {
        $identificador = 'BA03 <refNF> - ';
        $num = $this->builtNFref();
        $refNF = $this->dom->createElement("refNF");
        $this->dom->addChild(
            $refNF,
            "cUF",
            $cUF,
            true,
            $identificador . "Código da UF do emitente"
        );
        $this->dom->addChild(
            $refNF,
            "AAMM",
            $aamm,
            true,
            $identificador . "Ano e Mês de emissão da NF-e"
        );
        $this->dom->addChild(
            $refNF,
            "CNPJ",
            $cnpj,
            true,
            $identificador . "CNPJ do emitente"
        );
        $this->dom->addChild(
            $refNF,
            "mod",
            $mod,
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNF,
            "serie",
            $serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNF,
            "nNF",
            $nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->appChild($this->aNFref[$num-1], $refNF);
        return $refNF;
    }

    /**
     * Informações da NF de produtor rural referenciada BA10 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFP
     * @param string $cUF
     * @param string $aamm
     * @param string $cnpj
     * @param string $cpf
     * @param string $numIE
     * @param string $mod
     * @param string $serie
     * @param string $nNF
     * @return DOMElement
     */
    public function tagrefNFP(
        $cUF,
        $aamm,
        $cnpj,
        $cpf,
        $numIE,
        $mod,
        $serie,
        $nNF
    ) {
        $identificador = 'BA10 <refNFP> - ';
        $num = $this->buildNFref();
        $refNFP = $this->dom->createElement("refNFP");
        $this->dom->addChild(
            $refNFP,
            "cUF",
            $cUF,
            true,
            $identificador . "Código da UF do emitente"
        );
        $this->dom->addChild(
            $refNFP,
            "AAMM",
            $aamm,
            true,
            $identificador . "AAMM da emissão da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "CNPJ",
            $cnpj,
            false,
            $identificador . "Informar o CNPJ do emitente da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "CPF",
            $cpf,
            false,
            $identificador . "Informar o CPF do emitente da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "IE",
            $numIE,
            true,
            $identificador . "Informar a IE do emitente da NF de Produtor ou o literal 'ISENTO'"
        );
        $this->dom->addChild(
            $refNFP,
            "mod",
            $mod,
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNFP,
            "serie",
            $serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNFP,
            "nNF",
            $nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->appChild($this->aNFref[$num-1], $refNFP);
        return $refNFP;
    }

    /**
     * Chave de acesso do CT-e referenciada BA19 pai BA01
     * tag NFe/infNFe/ide/NFref/refCTe
     * @param string $refCTe
     * @return DOMElement
     */
    public function tagrefCTe($refCTe)
    {
        $num = $this->buildNFref();
        $refCTe = $this->dom->createElement("refCTe", $refCTe);
        $this->dom->appChild($this->aNFref[$num-1], $refCTe);
        return $refCTe;
    }

    /**
     * Informações do Cupom Fiscal referenciado BA20 pai BA01
     * tag NFe/infNFe/ide/NFref/refECF
     * @param string $mod
     * @param string $nECF
     * @param string $nCOO
     * @return DOMElement
     */
    public function tagrefECF(
        $mod = '',
        $nECF = '',
        $nCOO = ''
    ) {
        $identificador = 'BA20 <refECF> - ';
        $num = $this->buildNFref();
        $refECF = $this->dom->createElement("refECF");
        $this->dom->addChild(
            $refECF,
            "mod",
            $mod,
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refECF,
            "nECF",
            $nECF,
            true,
            $identificador . "Número de ordem sequencial do ECF"
        );
        $this->dom->addChild(
            $refECF,
            "nCOO",
            $nCOO,
            true,
            $identificador . "Número do Contador de Ordem de Operação - COO"
        );
        $this->dom->appChild($this->aNFref[$num-1], $refECF);
        return $refECF;
    }

    /**
     * Identificação do emitente da NF-e C01 pai A01
     * tag NFe/infNFe/emit
     * @param string $cnpj
     * @param string $cpf
     * @param string $xNome
     * @param string $xFant
     * @param string $numIE
     * @param string $numIEST
     * @param string $numIM
     * @param string $cnae
     * @param string $crt
     * @return DOMElement
     */
    public function tagemit(
        $cnpj = '',
        $cpf = '',
        $xNome = '',
        $xFant = '',
        $numIE = '',
        $numIEST = '',
        $numIM = '',
        $cnae = '',
        $crt = ''
    ) {
        $identificador = 'C01 <emit> - ';
        $this->emit = $this->dom->createElement("emit");
        $this->dom->addChild(
            $this->emit,
            "CNPJ",
            $cnpj,
            false,
            $identificador . "CNPJ do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "CPF",
            $cpf,
            false,
            $identificador . "CPF do remetente"
        );
        $this->dom->addChild(
            $this->emit,
            "xNome",
            $xNome,
            true,
            $identificador . "Razão Social ou Nome do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "xFant",
            $xFant,
            false,
            $identificador . "Nome fantasia do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IE",
            $numIE,
            true,
            $identificador . "Inscrição Estadual do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IEST",
            $numIEST,
            false,
            $identificador . "IE do Substituto Tributário do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IM",
            $numIM,
            false,
            $identificador . "Inscrição Municipal do Prestador de Serviço do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "CNAE",
            $cnae,
            false,
            $identificador . "CNAE fiscal do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "CRT",
            $crt,
            true,
            $identificador . "Código de Regime Tributário do emitente"
        );
        return $this->emit;
    }

    /**
     * Endereço do emitente C05 pai C01
     * tag NFe/infNFe/emit/endEmit
     * @param string $xLgr
     * @param string $nro
     * @param string $xCpl
     * @param string $xBairro
     * @param string $cMun
     * @param string $xMun
     * @param string $siglaUF
     * @param string $cep
     * @param string $cPais
     * @param string $xPais
     * @param string $fone
     * @return DOMElement
     */
    public function tagenderEmit(
        $xLgr = '',
        $nro = '',
        $xCpl = '',
        $xBairro = '',
        $cMun = '',
        $xMun = '',
        $siglaUF = '',
        $cep = '',
        $cPais = '',
        $xPais = '',
        $fone = ''
    ) {
        $identificador = 'C05 <enderEmit> - ';
        $this->enderEmit = $this->dom->createElement("enderEmit");
        $this->dom->addChild(
            $this->enderEmit,
            "xLgr",
            $xLgr,
            true,
            $identificador . "Logradouro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "nro",
            $nro,
            true,
            $identificador . "Número do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xCpl",
            $xCpl,
            false,
            $identificador . "Complemento do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xBairro",
            $xBairro,
            true,
            $identificador . "Bairro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cMun",
            $cMun,
            true,
            $identificador . "Código do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xMun",
            $xMun,
            true,
            $identificador . "Nome do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "UF",
            $siglaUF,
            true,
            $identificador . "Sigla da UF do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "CEP",
            $cep,
            true,
            $identificador . "Código do CEP do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cPais",
            $cPais,
            false,
            $identificador . "Código do País do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xPais",
            $xPais,
            false,
            $identificador . "Nome do País do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "fone",
            $fone,
            false,
            $identificador . "Telefone do Endereço do emitente"
        );
        $node = $this->emit->getElementsByTagName("IE")->item(0);
        $this->emit->insertBefore($this->enderEmit, $node);
        return $this->enderEmit;
    }

    /**
     * Identificação do Destinatário da NF-e E01 pai A01
     * tag NFe/infNFe/dest (opcional para modelo 65)
     * @param string $cnpj
     * @param string $cpf
     * @param string $idEstrangeiro
     * @param string $xNome
     * @param string $indIEDest
     * @param string $numIE
     * @param string $isUF
     * @param string $numIM
     * @param string $email
     * @return DOMElement
     */
    public function tagdest(
        $cnpj = '',
        $cpf = '',
        $idEstrangeiro = '',
        $xNome = '',
        $indIEDest = '',
        $numIE = '',
        $isUF = '',
        $numIM = '',
        $email = ''
    ) {
        $identificador = 'E01 <dest> - ';
        $flagNome = true;//marca se xNome é ou não obrigatório
        $temIE = $numIE != '' && $numIE != 'ISENTO'; // Tem inscrição municipal

        $this->dest = $this->dom->createElement("dest");
        if (!$temIE && $indIEDest == '1') {
            $indIEDest = '2';
        }
        if ($this->mod == '65') {
            $indIEDest = '9';
            if ($xNome == '') {
                $flagNome = false;//marca se xNome é ou não obrigatório
            }
        }
        if ($this->tpAmb == '2' && $this->mod == '55') {
            $xNome = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
            //a exigência do CNPJ 99999999000191 não existe mais
        }
        $this->dom->addChild(
            $this->dest,
            "CNPJ",
            $cnpj,
            false,
            $identificador . "CNPJ do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "CPF",
            $cpf,
            false,
            $identificador . "CPF do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "idEstrangeiro",
            $idEstrangeiro,
            false,
            $identificador . "Identificação do destinatário no caso de comprador estrangeiro"
        );
        if ($idEstrangeiro != '') {
            $indIEDest = '9';
        }
        $this->dom->addChild(
            $this->dest,
            "xNome",
            $xNome,
            $flagNome, //se mod 55 true ou mod 65 false
            $identificador . "Razão Social ou nome do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "indIEDest",
            $indIEDest,
            true,
            $identificador . "Indicador da IE do Destinatário"
        );
        if ($temIE) {
            $this->dom->addChild(
                $this->dest,
                "IE",
                $numIE,
                true,
                $identificador . "Inscrição Estadual do Destinatário"
            );
        }
        $this->dom->addChild(
            $this->dest,
            "ISUF",
            $isUF,
            false,
            $identificador . "Inscrição na SUFRAMA do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "IM",
            $numIM,
            false,
            $identificador . "Inscrição Municipal do Tomador do Serviço do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "email",
            $email,
            false,
            $identificador . "Email do destinatário"
        );
        return $this->dest;
    }

    /**
     * Endereço do Destinatário da NF-e E05 pai E01
     * tag NFe/infNFe/dest/enderDest  (opcional para modelo 65)
     * Os dados do destinatário devem ser inseridos antes deste método
     * @param string $xLgr
     * @param string $nro
     * @param string $xCpl
     * @param string $xBairro
     * @param string $cMun
     * @param string $xMun
     * @param string $siglaUF
     * @param string $cep
     * @param string $cPais
     * @param string $xPais
     * @param string $fone
     * @return DOMElement
     */
    public function tagenderDest(
        $xLgr = '',
        $nro = '',
        $xCpl = '',
        $xBairro = '',
        $cMun = '',
        $xMun = '',
        $siglaUF = '',
        $cep = '',
        $cPais = '',
        $xPais = '',
        $fone = ''
    ) {
        $identificador = 'E05 <enderDest> - ';
        if (empty($this->dest)) {
            throw new RuntimeException('A TAG dest deve ser criada antes do endereço do mesmo.');
        }
        $this->enderDest = $this->dom->createElement("enderDest");
        $this->dom->addChild(
            $this->enderDest,
            "xLgr",
            $xLgr,
            true,
            $identificador . "Logradouro do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "nro",
            $nro,
            true,
            $identificador . "Número do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xCpl",
            $xCpl,
            false,
            $identificador . "Complemento do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xBairro",
            $xBairro,
            true,
            $identificador . "Bairro do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "cMun",
            $cMun,
            true,
            $identificador . "Código do município do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xMun",
            $xMun,
            true,
            $identificador . "Nome do município do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "UF",
            $siglaUF,
            true,
            $identificador . "Sigla da UF do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "CEP",
            $cep,
            false,
            $identificador . "Código do CEP do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "cPais",
            $cPais,
            false,
            $identificador . "Código do País do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xPais",
            $xPais,
            false,
            $identificador . "Nome do País do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "fone",
            $fone,
            false,
            $identificador . "Telefone do Endereço do Destinatário"
        );
        $node = $this->dest->getElementsByTagName("indIEDest")->item(0);
        if (!isset($node)) {
            $node = $this->dest->getElementsByTagName("IE")->item(0);
        }
        $this->dest->insertBefore($this->enderDest, $node);
        return $this->enderDest;
    }

    /**
     * Identificação do Local de retirada F01 pai A01
     * tag NFe/infNFe/retirada (opcional)
     * @param string $cnpj
     * @param string $cpf
     * @param string $xLgr
     * @param string $nro
     * @param string $xCpl
     * @param string $xBairro
     * @param string $cMun
     * @param string $xMun
     * @param string $siglaUF
     * @return DOMElement
     */
    public function tagretirada(
        $cnpj = '',
        $cpf = '',
        $xLgr = '',
        $nro = '',
        $xCpl = '',
        $xBairro = '',
        $cMun = '',
        $xMun = '',
        $siglaUF = ''
    ) {
        $identificador = 'F01 <retirada> - ';
        $this->retirada = $this->dom->createElement("retirada");
        $this->dom->addChild(
            $this->retirada,
            "CNPJ",
            $cnpj,
            false,
            $identificador . "CNPJ do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "CPF",
            $cpf,
            false,
            $identificador . "CPF do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xLgr",
            $xLgr,
            true,
            $identificador . "Logradouro do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "nro",
            $nro,
            true,
            $identificador . "Número do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xCpl",
            $xCpl,
            false,
            $identificador . "Complemento do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xBairro",
            $xBairro,
            true,
            $identificador . "Bairro do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "cMun",
            $cMun,
            true,
            $identificador . "Código do município do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xMun",
            $xMun,
            true,
            $identificador . "Nome do município do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "UF",
            $siglaUF,
            true,
            $identificador . "Sigla da UF do Endereco do Cliente da Retirada"
        );
        return $this->retirada;
    }

    /**
     * Identificação do Local de entrega G01 pai A01
     * tag NFe/infNFe/entrega (opcional)
     * @param string $cnpj
     * @param string $cpf
     * @param string $xLgr
     * @param string $nro
     * @param string $xCpl
     * @param string $xBairro
     * @param string $cMun
     * @param string $xMun
     * @param string $siglaUF
     * @return DOMElement
     */
    public function tagentrega(
        $cnpj = '',
        $cpf = '',
        $xLgr = '',
        $nro = '',
        $xCpl = '',
        $xBairro = '',
        $cMun = '',
        $xMun = '',
        $siglaUF = ''
    ) {
        $identificador = 'G01 <entrega> - ';
        $this->entrega = $this->dom->createElement("entrega");
        $this->dom->addChild(
            $this->entrega,
            "CNPJ",
            $cnpj,
            false,
            $identificador . "CNPJ do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "CPF",
            $cpf,
            false,
            $identificador . "CPF do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xLgr",
            $xLgr,
            true,
            $identificador . "Logradouro do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "nro",
            $nro,
            true,
            $identificador . "Número do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xCpl",
            $xCpl,
            false,
            $identificador . "Complemento do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xBairro",
            $xBairro,
            true,
            $identificador . "Bairro do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "cMun",
            $cMun,
            true,
            $identificador . "Código do município do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xMun",
            $xMun,
            true,
            $identificador . "Nome do município do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "UF",
            $siglaUF,
            true,
            $identificador . "Sigla da UF do Endereco do Cliente da Entrega"
        );
        return $this->entrega;
    }

    /**
     * Pessoas autorizadas para o download do XML da NF-e G50 pai A01
     * tag NFe/infNFe/autXML (somente versão 3.1)
     * @param string $cnpj
     * @param string $cpf
     * @return array
     */
    public function tagautXML($cnpj = '', $cpf = '')
    {
        $identificador = 'G50 <autXML> - ';
        if (intval($this->versao, 10) > 2) {
            $autXML = $this->dom->createElement("autXML");
            $this->dom->addChild(
                $autXML,
                "CNPJ",
                $cnpj,
                false,
                $identificador . "CNPJ do Cliente Autorizado"
            );
            $this->dom->addChild(
                $autXML,
                "CPF",
                $cpf,
                false,
                $identificador . "CPF do Cliente Autorizado"
            );
            $this->aAutXML[] = $autXML;
            return $autXML;
        } else {
            return [];
        }
    }

    /**
     * Detalhamento de Produtos e Serviços I01 pai H01
     * tag NFe/infNFe/det[]/prod
     * @param string $nItem
     * @param string $cProd
     * @param string $cEAN
     * @param string $xProd
     * @param string $NCM
     * @param string $EXTIPI
     * @param string $CFOP
     * @param string $uCom
     * @param string $qCom
     * @param string $vUnCom
     * @param string $vProd
     * @param string $cEANTrib
     * @param string $uTrib
     * @param string $qTrib
     * @param string $vUnTrib
     * @param string $vFrete
     * @param string $vSeg
     * @param string $vDesc
     * @param string $vOutro
     * @param string $indTot
     * @param string $xPed
     * @param string $nItemPed
     * @param string $nFCI
     * @param string $nRECOPI
     * @return DOMElement
     */
    public function tagprod(
        $nItem = '',
        $cProd = '',
        $cEAN = '',
        $xProd = '',
        $NCM = '',
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
     * NVE NOMENCLATURA DE VALOR ADUANEIRO E ESTATÍSTICA
     * Podem ser até 8 NVE's por item
     * @param string $nItem
     * @param string $texto
     * @return DOMElement
     */
    public function tagNVE($nItem = '', $texto = '')
    {
        if ($texto == '') {
            return '';
        }
        $nve = $this->dom->createElement("NVE", $texto);
        $this->aNVE[$nItem][] = $nve;
        return $nve;
    }

    /**
     * Código Especificador da Substituição Tributária – CEST,
     * que identifica a mercadoria sujeita aos regimes de substituição
     * tributária e de antecipação do recolhimento do imposto.
     * vide NT2015.003
     * @param string $nItem
     * @param string $texto
     * @return DOMElement
     */
    public function tagCEST($nItem = '', $texto = '')
    {
        if ($texto == '') {
            return '';
        }
        $cest = $this->dom->createElement("CEST", $texto);
        $this->aCest[$nItem][] = $cest;
        return $cest;
    }

    /**
     * RECOPI Sistema de Registro e Controle das
     * Operações com Papel Imune instituído através
     * do Convênio ICMS 09/2012
     * @param string $nItem
     * @param string $texto
     * @return DOMElement
     */
    public function tagRECOPI($nItem = '', $texto = '')
    {
        if ($texto == '') {
            return '';
        }
        $recopi = $this->dom->createElement("RECOPI", $texto);
        $this->aRECOPI[$nItem] = $recopi;
        return $recopi;
    }

    /**
     * Informações adicionais do produto
     * tag NFe/infNFe/det[]/infAdProd
     * @param string $nItem
     * @param string $texto
     * @return DOMElement
     */
    public function taginfAdProd($nItem = '', $texto = '')
    {
        if ($texto == '') {
            return '';
        }
        $infAdProd = $this->dom->createElement("infAdProd", $texto);
        $this->aInfAdProd[$nItem] = $infAdProd;
        return $infAdProd;
    }

    /**
     * Declaração de Importação I8 pai I01
     * tag NFe/infNFe/det[]/prod/DI
     * @param string $nItem
     * @param string $nDI
     * @param string $dDI
     * @param string $xLocDesemb
     * @param string $UFDesemb
     * @param string $dDesemb
     * @param string $tpViaTransp
     * @param string $vAFRMM
     * @param string $tpIntermedio
     * @param string $CNPJ
     * @param string $UFTerceiro
     * @param string $cExportador
     * @return DOMElement
     */
    public function tagDI(
        $nItem = '',
        $nDI = '',
        $dDI = '',
        $xLocDesemb = '',
        $UFDesemb = '',
        $dDesemb = '',
        $tpViaTransp = '',
        $vAFRMM = '',
        $tpIntermedio = '',
        $CNPJ = '',
        $UFTerceiro = '',
        $cExportador = ''
    ) {
        $identificador = 'I8 <DI> - ';
        $tDI = $this->dom->createElement("DI");
        $this->dom->addChild(
            $tDI,
            "nDI",
            $nDI,
            true,
            $identificador . "[item $nItem] Número do Documento de Importação (DI, DSI, DIRE, ...)"
        );
        $this->dom->addChild(
            $tDI,
            "dDI",
            $dDI,
            true,
            $identificador . "[item $nItem] Data de Registro do documento"
        );
        $this->dom->addChild(
            $tDI,
            "xLocDesemb",
            $xLocDesemb,
            true,
            $identificador . "[item $nItem] Local de desembaraço"
        );
        $this->dom->addChild(
            $tDI,
            "UFDesemb",
            $UFDesemb,
            true,
            $identificador . "[item $nItem] Sigla da UF onde ocorreu o Desembaraço Aduaneiro"
        );
        $this->dom->addChild(
            $tDI,
            "dDesemb",
            $dDesemb,
            true,
            $identificador . "[item $nItem] Data do Desembaraço Aduaneiro"
        );
        $this->dom->addChild(
            $tDI,
            "tpViaTransp",
            $tpViaTransp,
            true,
            $identificador . "[item $nItem] Via de transporte internacional informada na "
                . "Declaração de Importação (DI)"
        );
        $this->dom->addChild(
            $tDI,
            "vAFRMM",
            $vAFRMM,
            false,
            $identificador . "[item $nItem] Valor da AFRMM - Adicional ao Frete para Renovação da Marinha Mercante"
        );
        $this->dom->addChild(
            $tDI,
            "tpIntermedio",
            $tpIntermedio,
            true,
            $identificador . "[item $nItem] Forma de importação quanto a intermediação"
        );
        $this->dom->addChild(
            $tDI,
            "CNPJ",
            $CNPJ,
            false,
            $identificador . "[item $nItem] CNPJ do adquirente ou do encomendante"
        );
        $this->dom->addChild(
            $tDI,
            "UFTerceiro",
            $UFTerceiro,
            false,
            $identificador . "[item $nItem] Sigla da UF do adquirente ou do encomendante"
        );
        $this->dom->addChild(
            $tDI,
            "cExportador",
            $cExportador,
            true,
            $identificador . "[item $nItem] Código do Exportador"
        );
        $this->aDI[$nItem][$nDI] = $tDI;
        return $tDI;
    }

    /**
     * Adições I25 pai I18
     * tag NFe/infNFe/det[]/prod/DI/adi
     * @param string $nItem
     * @param string $nDI
     * @param string $nAdicao
     * @param string $nSeqAdic
     * @param string $cFabricante
     * @param string $vDescDI
     * @param string $nDraw
     * @return DOMElement
     */
    public function tagadi(
        $nItem = '',
        $nDI = '',
        $nAdicao = '',
        $nSeqAdic = '',
        $cFabricante = '',
        $vDescDI = '',
        $nDraw = ''
    ) {
        $identificador = 'I25 <adi> - ';
        $adi = $this->dom->createElement("adi");
        $this->dom->addChild(
            $adi,
            "nAdicao",
            $nAdicao,
            true,
            $identificador . "[item $nItem] Número da Adição"
        );
        $this->dom->addChild(
            $adi,
            "nSeqAdic",
            $nSeqAdic,
            true,
            $identificador . "[item $nItem] Número sequencial do item dentro da Adição"
        );
        $this->dom->addChild(
            $adi,
            "cFabricante",
            $cFabricante,
            true,
            $identificador . "[item $nItem] Código do fabricante estrangeiro"
        );
        $this->dom->addChild(
            $adi,
            "vDescDI",
            $vDescDI,
            false,
            $identificador . "[item $nItem] Valor do desconto do item da DI Adição"
        );
        $this->dom->addChild(
            $adi,
            "nDraw",
            $nDraw,
            false,
            $identificador . "[item $nItem] Número do ato concessório de Drawback"
        );
        $this->aAdi[$nItem][$nDI][] = $adi;
        //colocar a adi em seu DI respectivo
        $nodeDI = $this->aDI[$nItem][$nDI];
        $this->dom->appChild($nodeDI, $adi);
        $this->aDI[$nItem][$nDI] = $nodeDI;
        return $adi;
    }

    /**
     * Grupo de informações de exportação para o item I50 pai I01
     * tag NFe/infNFe/det[]/prod/detExport
     * @param string $nItem
     * @param string $nDraw
     * @param string $exportInd
     * @param string $nRE
     * @param string $chNFe
     * @param string $qExport
     * @return DOMElement
     */
    public function tagdetExport(
        $nItem = '',
        $nDraw = '',
        $nRE = '',
        $chNFe = '',
        $qExport = ''
    ) {
        $identificador = 'I50 <detExport> - ';
        $detExport = $this->dom->createElement("detExport");
        $this->dom->addChild(
            $detExport,
            "nDraw",
            $nDraw,
            false,
            $identificador . "[item $nItem] Número do ato concessório de Drawback"
        );
        $exportInd = $this->dom->createElement("exportInd");
        $this->dom->addChild(
            $exportInd,
            "nRE",
            $nRE,
            true,
            $identificador . "[item $nItem] Número do Registro de Exportação"
        );
        $this->dom->addChild(
            $exportInd,
            "chNFe",
            $chNFe,
            true,
            $identificador . "[item $nItem] Chave de Acesso da NF-e recebida para exportação"
        );
        $this->dom->addChild(
            $exportInd,
            "qExport",
            $qExport,
            true,
            $identificador . "[item $nItem] Quantidade do item realmente exportado"
        );
        $detExport->appendChild($exportInd);
        $this->aDetExport[$nItem] = $detExport;
        return $detExport;
    }

    /**
     * Detalhamento de Veículos novos J01 pai I90
     * tag NFe/infNFe/det[]/prod/veicProd (opcional)
     * @param string $nItem
     * @param string $tpOp
     * @param string $chassi
     * @param string $cCor
     * @param string $xCor
     * @param string $pot
     * @param string $cilin
     * @param string $pesoL
     * @param string $pesoB
     * @param string $nSerie
     * @param string $tpComb
     * @param string $nMotor
     * @param string $CMT
     * @param string $dist
     * @param string $anoMod
     * @param string $anoFab
     * @param string $tpPint
     * @param string $tpVeic
     * @param string $espVeic
     * @param string $VIN
     * @param string $condVeic
     * @param string $cMod
     * @param string $cCorDENATRAN
     * @param string $lota
     * @param string $tpRest
     * @return DOMElement
     */
    public function tagveicProd(
        $nItem = '',
        $tpOp = '',
        $chassi = '',
        $cCor = '',
        $xCor = '',
        $pot = '',
        $cilin = '',
        $pesoL = '',
        $pesoB = '',
        $nSerie = '',
        $tpComb = '',
        $nMotor = '',
        $CMT = '',
        $dist = '',
        $anoMod = '',
        $anoFab = '',
        $tpPint = '',
        $tpVeic = '',
        $espVeic = '',
        $VIN = '',
        $condVeic = '',
        $cMod = '',
        $cCorDENATRAN = '',
        $lota = '',
        $tpRest = ''
    ) {
        $identificador = 'J01 <veicProd> - ';
        $veicProd = $this->dom->createElement("veicProd");
        $this->dom->addChild(
            $veicProd,
            "tpOp",
            $tpOp,
            true,
            "$identificador [item $nItem] Tipo da operação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "chassi",
            $chassi,
            true,
            "$identificador [item $nItem] Chassi do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cCor",
            $cCor,
            true,
            "$identificador [item $nItem] Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "xCor",
            $xCor,
            true,
            "$identificador [item $nItem] Descrição da Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pot",
            $pot,
            true,
            "$identificador [item $nItem] Potência Motor (CV) do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cilin",
            $cilin,
            true,
            "$identificador [item $nItem] Cilindradas do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pesoL",
            $pesoL,
            true,
            "$identificador [item $nItem] Peso Líquido do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pesoB",
            $pesoB,
            true,
            "$identificador [item $nItem] Peso Bruto do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "nSerie",
            $nSerie,
            true,
            "$identificador [item $nItem] Serial (série) do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpComb",
            $tpComb,
            true,
            "$identificador [item $nItem] Tipo de combustível do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "nMotor",
            $nMotor,
            true,
            "$identificador [item $nItem] Número de Motor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "CMT",
            $CMT,
            true,
            "$identificador [item $nItem] Capacidade Máxima de Tração do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "dist",
            $dist,
            true,
            "$identificador [item $nItem] Distância entre eixos do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "anoMod",
            $anoMod,
            true,
            "$identificador [item $nItem] Ano Modelo de Fabricação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "anoFab",
            $anoFab,
            true,
            "$identificador [item $nItem] Ano de Fabricação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpPint",
            $tpPint,
            true,
            "$identificador [item $nItem] Tipo de Pintura do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpVeic",
            $tpVeic,
            true,
            "$identificador [item $nItem] Tipo de Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "espVeic",
            $espVeic,
            true,
            "$identificador [item $nItem] Espécie de Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "VIN",
            $VIN,
            true,
            "$identificador [item $nItem] Condição do VIN do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "condVeic",
            $condVeic,
            true,
            "$identificador [item $nItem] Condição do Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cMod",
            $cMod,
            true,
            "$identificador [item $nItem] Código Marca Modelo do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cCorDENATRAN",
            $cCorDENATRAN,
            true,
            "$identificador [item $nItem] Código da Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "lota",
            $lota,
            true,
            "$identificador [item $nItem] Capacidade máxima de lotação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpRest",
            $tpRest,
            true,
            "$identificador [item $nItem] Restrição do veículo"
        );
        $this->aVeicProd[$nItem] = $veicProd;
        return $veicProd;
    }

    /**
     * Detalhamento de medicamentos K01 pai I90
     * tag NFe/infNFe/det[]/prod/med (opcional)
     * @param string $nItem
     * @param string $nLote
     * @param string $qLote
     * @param string $dFab
     * @param string $dVal
     * @param string $vPMC
     * @return DOMElement
     */
    public function tagmed(
        $nItem = '',
        $nLote = '',
        $qLote = '',
        $dFab = '',
        $dVal = '',
        $vPMC = ''
    ) {
        $identificador = 'K01 <med> - ';
        $med = $this->dom->createElement("med");
        $this->dom->addChild(
            $med,
            "nLote",
            $nLote,
            true,
            "$identificador [item $nItem] Número do Lote de medicamentos ou de matérias-primas farmacêuticas"
        );
        $this->dom->addChild(
            $med,
            "qLote",
            $qLote,
            true,
            "$identificador [item $nItem] Quantidade de produto no Lote de medicamentos "
                . "ou de matérias-primas farmacêuticas"
        );
        $this->dom->addChild(
            $med,
            "dFab",
            $dFab,
            true,
            "$identificador [item $nItem] Data de fabricação"
        );
        $this->dom->addChild(
            $med,
            "dVal",
            $dVal,
            true,
            "$identificador [item $nItem] Data de validade"
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
     * Detalhamento de armas L01 pai I90
     * tag NFe/infNFe/det[]/prod/arma (opcional)
     * @param string $nItem
     * @param string $tpArma
     * @param string $nSerie
     * @param string $nCano
     * @param string $descr
     * @return DOMElement
     */
    public function tagarma(
        $nItem = '',
        $tpArma = '',
        $nSerie = '',
        $nCano = '',
        $descr = ''
    ) {
        $identificador = 'L01 <arma> - ';
        $arma = $this->dom->createElement("arma");
        $this->dom->addChild(
            $arma,
            "tpArma",
            $tpArma,
            true,
            "$identificador [item $nItem] Indicador do tipo de arma de fogo"
        );
        $this->dom->addChild(
            $arma,
            "nSerie",
            $nSerie,
            true,
            "$identificador [item $nItem] Número de série da arma"
        );
        $this->dom->addChild(
            $arma,
            "nCano",
            $nCano,
            true,
            "$identificador [item $nItem] Número de série do cano"
        );
        $this->dom->addChild(
            $arma,
            "descr",
            $descr,
            true,
            "$identificador [item $nItem] Descrição completa da arma, compreendendo: calibre, marca, capacidade, "
            . "tipo de funcionamento, comprimento e demais elementos que "
            . "permitam a sua perfeita identificação."
        );
        $this->aArma[$nItem] = $arma;
        return $arma;
    }

    /**
     * Detalhamento de combustiveis L101 pai I90
     * tag NFe/infNFe/det[]/prod/comb (opcional)
     * @param string $nItem
     * @param string $cProdANP
     * @param string $pMixGN
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
        $pMixGN = '',
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
            "$identificador [item $nItem] Código de produto da ANP"
        );
        $this->dom->addChild(
            $comb,
            "pMixGN",
            $pMixGN,
            false,
            "$identificador [item $nItem] Percentual de Gás Natural para o produto GLP (cProdANP=210203001)"
        );
        $this->dom->addChild(
            $comb,
            "CODIF",
            $codif,
            false,
            "[item $nItem] Código de autorização / registro do CODIF"
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
     * informações relacionadas com as operações de combustíveis, subgrupo de
     * encerrante que permite o controle sobre as operações de venda de combustíveis
     * LA11 pai LA01
     * tag NFe/infNFe/det[]/prod/comb/encerrante (opcional)
     * @param string $nItem
     * @param string $nBico
     * @param string $nBomba
     * @param string $nTanque
     * @param string $vEncIni
     * @param string $vEncFin
     * @return DOMElement
     */
    public function tagencerrante($nItem = '', $nBico = '', $nBomba = '', $nTanque = '', $vEncIni = '', $vEncFin = '')
    {
        $identificador = 'LA11 <encerrante> - ';
        $encerrante = $this->dom->createElement("encerrante");
        $this->dom->addChild(
            $encerrante,
            "nBico",
            $nBico,
            true,
            "$identificador [item $nItem] Número de identificação do bico utilizado no abastecimento"
        );
        $this->dom->addChild(
            $encerrante,
            "nBomba",
            $nBomba,
            false,
            "$identificador [item $nItem] Número de identificação da bomba ao qual o bico está interligado"
        );
        $this->dom->addChild(
            $encerrante,
            "nTanque",
            $nTanque,
            true,
            "$identificador [item $nItem] Número de identificação do tanque ao qual o bico está interligado"
        );
        $this->dom->addChild(
            $encerrante,
            "vEncIni",
            $vEncIni,
            true,
            "$identificador [item $nItem] Valor do Encerrante no início do abastecimento"
        );
        $this->dom->addChild(
            $encerrante,
            "vEncFin",
            $vEncFin,
            true,
            "$identificador [item $nItem] Valor do Encerrante no final do abastecimento"
        );
        $this->aEncerrante[$nItem] = $encerrante;
        return $encerrante;
    }

    /**
     * M01 pai H01
     * tag NFe/infNFe/det[]/imposto
     * @param string $nItem
     * @param string $vTotTrib
     * @return DOMElement
     */
    public function tagimposto($nItem = '', $vTotTrib = '')
    {
        $identificador = 'M01 <imposto> - ';
        $imposto = $this->dom->createElement("imposto");
        $this->dom->addChild(
            $imposto,
            "vTotTrib",
            $vTotTrib,
            false,
            "$identificador [item $nItem] Valor aproximado total de tributos federais, estaduais e municipais."
        );
        $this->aImposto[$nItem] = $imposto;
        return $imposto;
    }

    /**
     * Informações do ICMS da Operação própria e ST N01 pai M01
     * tag NFe/infNFe/det[]/imposto/ICMS
     * @param string $nItem
     * @param string $orig
     * @param string $CST
     * @param string $modBC
     * @param string $pRedBC
     * @param string $vBC
     * @param string $pICMS
     * @param string $vICMS
     * @param string $vICMSDeson
     * @param string $motDesICMS
     * @param string $modBCST
     * @param string $pMVAST
     * @param string $pRedBCST
     * @param string $vBCST
     * @param string $pICMSST
     * @param string $vICMSST
     * @param string $pDif
     * @param string $vICMSDif
     * @param string $vICMSOp
     * @param string $vBCSTRet
     * @param string $vICMSSTRet
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
        $vICMSSTRet = ''
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
     * Grupo de Partilha do ICMS entre a UF de origem e UF de destino ou
     * a UF definida na legislação. N10a pai N01
     * tag NFe/infNFe/det[]/imposto/ICMS/ICMSPart
     * @param string $nItem
     * @param string $orig
     * @param string $cst
     * @param string $modBC
     * @param string $vBC
     * @param string $pRedBC
     * @param string $pICMS
     * @param string $vICMS
     * @param string $modBCST
     * @param string $pMVAST
     * @param string $pRedBCST
     * @param string $vBCST
     * @param string $pICMSST
     * @param string $vICMSST
     * @param string $pBCOp
     * @param string $ufST
     * @return DOMElement
     */
    public function tagICMSPart(
        $nItem = '',
        $orig = '',
        $cst = '',
        $modBC = '',
        $vBC = '',
        $pRedBC = '',
        $pICMS = '',
        $vICMS = '',
        $modBCST = '',
        $pMVAST = '',
        $pRedBCST = '',
        $vBCST = '',
        $pICMSST = '',
        $vICMSST = '',
        $pBCOp = '',
        $ufST = ''
    ) {
        $icmsPart = $this->dom->createElement("ICMSPart");
        $this->dom->addChild(
            $icmsPart,
            'orig',
            $orig,
            true,
            "[item $nItem] Origem da mercadoria"
        );
        $this->dom->addChild(
            $icmsPart,
            'CST',
            $cst,
            true,
            "[item $nItem] Tributação do ICMS 10 ou 90"
        );
        $this->dom->addChild(
            $icmsPart,
            'modBC',
            $modBC,
            true,
            "[item $nItem] Modalidade de determinação da BC do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBC',
            $vBC,
            true,
            "[item $nItem] Valor da BC do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'pRedBC',
            $pRedBC,
            false,
            "[item $nItem] Percentual da Redução de BC"
        );
        $this->dom->addChild(
            $icmsPart,
            'pICMS',
            $pICMS,
            true,
            "[item $nItem] Alíquota do imposto"
        );
        $this->dom->addChild(
            $icmsPart,
            'vICMS',
            $vICMS,
            true,
            "[item $nItem] Valor do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'modBCST',
            $modBCST,
            true,
            "[item $nItem] Modalidade de determinação da BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pMVAST',
            $pMVAST,
            false,
            "[item $nItem] Percentual da margem de valor Adicionado do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pRedBCST',
            $pRedBCST,
            false,
            "[item $nItem] Percentual da Redução de BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBCST',
            $vBCST,
            true,
            "[item $nItem] Valor da BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pICMSST',
            $pICMSST,
            true,
            "[item $nItem] Alíquota do imposto do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vICMSST',
            $vICMSST,
            true,
            "[item $nItem] Valor do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pBCOp',
            $pBCOp,
            true,
            "[item $nItem] Percentual da BC operação própria"
        );
        $this->dom->addChild(
            $icmsPart,
            'UFST',
            $ufST,
            true,
            "[item $nItem] UF para qual é devido o ICMS ST"
        );
        //caso exista a tag aICMS[$nItem] inserir nela caso contrario criar
        if (!empty($this->aICMS[$nItem])) {
            $tagIcms = $this->aICMS[$nItem];
        } else {
            $tagIcms = $this->dom->createElement('ICMS');
        }
        $this->dom->appChild($tagIcms, $icmsPart, "Inserindo ICMSPart em ICMS[$nItem]");
        $this->aICMS[$nItem] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Grupo de Repasse de ICMS ST retido anteriormente em operações
     * interestaduais com repasses através do Substituto Tributário
     * @param string $nItem
     * @param string $orig
     * @param string $cst
     * @param string $vBCSTRet
     * @param string $vICMSSTRet
     * @param string $vBCSTDest
     * @param string $vICMSSTDest
     * @return DOMElement
     */
    public function tagICMSST(
        $nItem = '',
        $orig = '',
        $cst = '',
        $vBCSTRet = '',
        $vICMSSTRet = '',
        $vBCSTDest = '',
        $vICMSSTDest = ''
    ) {
        $icmsST = $this->dom->createElement("ICMSST");
        $this->dom->addChild(
            $icmsST,
            'orig',
            $orig,
            true,
            "[item $nItem] Origem da mercadoria"
        );
        $this->dom->addChild(
            $icmsST,
            'CST',
            $cst,
            true,
            "[item $nItem] Tributação do ICMS 41"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCSTRet',
            $vBCSTRet,
            true,
            "[item $nItem] Valor do BC do ICMS ST retido na UF remetente"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSTRet',
            $vICMSSTRet,
            false,
            "[item $nItem] Valor do ICMS ST retido na UF remetente"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCSTDest',
            $vBCSTDest,
            true,
            "[item $nItem] Valor da BC do ICMS ST da UF destino"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSTDest',
            $vICMSSTDest,
            true,
            "[item $nItem] Valor do ICMS ST da UF destino"
        );
        //caso exista a tag aICMS[$nItem] inserir nela caso contrario criar
        if (!empty($this->aICMS[$nItem])) {
            $tagIcms = $this->aICMS[$nItem];
        } else {
            $tagIcms = $this->dom->createElement('ICMS');
        }
        $this->dom->appChild($tagIcms, $icmsST, "Inserindo ICMSST em ICMS[$nItem]");
        $this->aICMS[$nItem] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Tributação ICMS pelo Simples Nacional N10c pai N01
     * @param string $nItem
     * @param string $orig
     * @param string $csosn
     * @param string $modBC
     * @param string $vBC
     * @param string $pRedBC
     * @param string $pICMS
     * @param string $vICMS
     * @param string $pCredSN
     * @param string $vCredICMSSN
     * @param string $modBCST
     * @param string $pMVAST
     * @param string $pRedBCST
     * @param string $vBCST
     * @param string $pICMSST
     * @param string $vICMSST
     * @param string $vBCSTRet
     * @param string $vICMSSTRet
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
        $vICMSSTRet = ''
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
                        "[item $nItem] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                    );
                    $this->dom->addChild(
                        $icmsSN,
                        'vCredICMSSN',
                        $vCredICMSSN,
                        true,
                        "[item $nItem] Valor crédito do ICMS que pode ser aproveitado nos "
                            . "termos do art. 23 da LC 123 (Simples Nacional)"
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
                    "[item $nItem] Código de Situação da Operação Simples Nacional"
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
                        "[item $nItem] Valor crédito do ICMS que pode ser aproveitado nos termos do"
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
     * tag NFe/infNFe/det[]/imposto/ICMSUFDest (opcional)
     * Grupo a ser informado nas vendas interestaduais para consumidor final,
     * não contribuinte do ICMS
     * @param string $nItem
     * @param string $vBCUFDest
     * @param string $pFCPUFDest
     * @param string $pICMSUFDest
     * @param string $pICMSInter
     * @param string $pICMSInterPart
     * @param string $vFCPUFDest
     * @param string $vICMSUFDest
     * @param string $vICMSUFRemet
     * @return DOMElement
     */
    public function tagICMSUFDest(
        $nItem = '',
        $vBCUFDest = '',
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
            "pFCPUFDest",
            $pFCPUFDest,
            true,
            "[item $nItem] Percentual do ICMS relativo ao Fundo de Combate à Pobreza (FCP) na UF de destino"
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
            "[item $nItem] Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino"
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
     * Grupo IPI O01 pai M01
     * tag NFe/infNFe/det[]/imposto/IPI (opcional)
     * @param string $nItem
     * @param string $cst
     * @param string $clEnq
     * @param string $cnpjProd
     * @param string $cSelo
     * @param string $qSelo
     * @param string $cEnq
     * @param string $vBC
     * @param string $pIPI
     * @param string $qUnid
     * @param string $vUnid
     * @param string $vIPI
     * @return DOMElement
     */
    public function tagIPI(
        $nItem = '',
        $cst = '',
        $clEnq = '',
        $cnpjProd = '',
        $cSelo = '',
        $qSelo = '',
        $cEnq = '',
        $vBC = '',
        $pIPI = '',
        $qUnid = '',
        $vUnid = '',
        $vIPI = ''
    ) {
        $ipi = $this->dom->createElement('IPI');
        $this->dom->addChild(
            $ipi,
            "clEnq",
            $clEnq,
            false,
            "[item $nItem] Classe de enquadramento do IPI para Cigarros e Bebidas"
        );
        $this->dom->addChild(
            $ipi,
            "CNPJProd",
            $cnpjProd,
            false,
            "[item $nItem] CNPJ do produtor da mercadoria, quando diferente do emitente. "
            . "Somente para os casos de exportação direta ou indireta."
        );
        $this->dom->addChild(
            $ipi,
            "cSelo",
            $cSelo,
            false,
            "[item $nItem] Código do selo de controle IPI"
        );
        $this->dom->addChild(
            $ipi,
            "qSelo",
            $qSelo,
            false,
            "[item $nItem] Quantidade de selo de controle"
        );
        $this->dom->addChild(
            $ipi,
            "cEnq",
            $cEnq,
            true,
            "[item $nItem] Código de Enquadramento Legal do IPI"
        );
        if ($cst == '00' || $cst == '49'|| $cst == '50' || $cst == '99') {
            $ipiTrib = $this->dom->createElement('IPITrib');
            $this->dom->addChild(
                $ipiTrib,
                "CST",
                $cst,
                true,
                "[item $nItem] Código da situação tributária do IPI"
            );
            $this->dom->addChild(
                $ipiTrib,
                "vBC",
                $vBC,
                false,
                "[item $nItem] Valor da BC do IPI"
            );
            $this->dom->addChild(
                $ipiTrib,
                "pIPI",
                $pIPI,
                false,
                "[item $nItem] Alíquota do IPI"
            );
            $this->dom->addChild(
                $ipiTrib,
                "qUnid",
                $qUnid,
                false,
                "[item $nItem] Quantidade total na unidade padrão para tributação (somente para os "
                    . "produtos tributados por unidade)"
            );
            $this->dom->addChild(
                $ipiTrib,
                "vUnid",
                $vUnid,
                false,
                "[item $nItem] Valor por Unidade Tributável"
            );
            $this->dom->addChild(
                $ipiTrib,
                "vIPI",
                $vIPI,
                true,
                "[item $nItem] Valor do IPI"
            );
            $ipi->appendChild($ipiTrib);
        } else {
            $ipINT = $this->dom->createElement('IPINT');
            $this->dom->addChild(
                $ipINT,
                "CST",
                $cst,
                true,
                "[item $nItem] Código da situação tributária do IPINT"
            );
            $ipi->appendChild($ipINT);
        }
        $this->aIPI[$nItem] = $ipi;
        return $ipi;
    }

    /**
     * Grupo Imposto de Importação P01 pai M01
     * tag NFe/infNFe/det[]/imposto/II
     * @param string $nItem
     * @param string $vBC
     * @param string $vDespAdu
     * @param string $vII
     * @param string $vIOF
     * @return DOMElement
     */
    public function tagII($nItem = '', $vBC = '', $vDespAdu = '', $vII = '', $vIOF = '')
    {
        $tii = $this->dom->createElement('II');
        $this->dom->addChild(
            $tii,
            "vBC",
            $vBC,
            true,
            "[item $nItem] Valor BC do Imposto de Importação"
        );
        $this->dom->addChild(
            $tii,
            "vDespAdu",
            $vDespAdu,
            true,
            "[item $nItem] Valor despesas aduaneiras"
        );
        $this->dom->addChild(
            $tii,
            "vII",
            $vII,
            true,
            "[item $nItem] Valor Imposto de Importação"
        );
        $this->dom->addChild(
            $tii,
            "vIOF",
            $vIOF,
            true,
            "[item $nItem] Valor Imposto sobre Operações Financeiras"
        );
        $this->aII[$nItem] = $tii;
        return $tii;
    }

    /**
     * Grupo PIS Q01 pai M01
     * tag NFe/infNFe/det[]/imposto/PIS
     * @param string $nItem
     * @param string $cst
     * @param string $vBC
     * @param string $pPIS
     * @param string $vPIS
     * @param string $qBCProd
     * @param string $vAliqProd
     * @return DOMElement
     */
    public function tagPIS(
        $nItem = '',
        $cst = '',
        $vBC = '',
        $pPIS = '',
        $vPIS = '',
        $qBCProd = '',
        $vAliqProd = ''
    ) {
        switch ($cst) {
            case '01':
            case '02':
                $pisItem = $this->dom->createElement('PISAliq');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $cst,
                    true,
                    "[item $nItem] Código de Situação Tributária do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vBC',
                    $vBC,
                    true,
                    "[item $nItem] Valor da Base de Cálculo do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'pPIS',
                    $pPIS,
                    true,
                    "[item $nItem] Alíquota do PIS (em percentual)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $vPIS,
                    true,
                    "[item $nItem] Valor do PIS"
                );
                break;
            case '03':
                $pisItem = $this->dom->createElement('PISQtde');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $cst,
                    true,
                    "[item $nItem] Código de Situação Tributária do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'qBCProd',
                    $qBCProd,
                    true,
                    "[item $nItem] Quantidade Vendida"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vAliqProd',
                    $vAliqProd,
                    true,
                    "[item $nItem] Alíquota do PIS (em reais)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $vPIS,
                    true,
                    "[item $nItem] Valor do PIS"
                );
                break;
            case '04':
            case '05':
            case '06':
            case '07':
            case '08':
            case '09':
                $pisItem = $this->dom->createElement('PISNT');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $cst,
                    true,
                    "[item $nItem] Código de Situação Tributária do PIS"
                );
                break;
            case '49':
            case '50':
            case '51':
            case '52':
            case '53':
            case '54':
            case '55':
            case '56':
            case '60':
            case '61':
            case '62':
            case '63':
            case '64':
            case '65':
            case '66':
            case '67':
            case '70':
            case '71':
            case '72':
            case '73':
            case '74':
            case '75':
            case '98':
            case '99':
                $pisItem = $this->dom->createElement('PISOutr');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $cst,
                    true,
                    "[item $nItem] Código de Situação Tributária do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vBC',
                    $vBC,
                    false,
                    "[item $nItem] Valor da Base de Cálculo do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'pPIS',
                    $pPIS,
                    false,
                    "[item $nItem] Alíquota do PIS (em percentual)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'qBCProd',
                    $qBCProd,
                    false,
                    "[item $nItem] Quantidade Vendida"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vAliqProd',
                    $vAliqProd,
                    false,
                    "[item $nItem] Alíquota do PIS (em reais)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $vPIS,
                    true,
                    "[item $nItem] Valor do PIS"
                );
                break;
        }
        $pis = $this->dom->createElement('PIS');
        if (isset($pisItem)) {
            $pis->appendChild($pisItem);
        }
        $this->aPIS[$nItem] = $pis;
        return $pis;
    }

    /**
     * Grupo PIS Substituição Tributária R01 pai M01
     * tag NFe/infNFe/det[]/imposto/PISST (opcional)
     * @param string $nItem
     * @param string $vBC
     * @param string $pPIS
     * @param string $qBCProd
     * @param string $vAliqProd
     * @param string $vPIS
     * @return DOMElement
     */
    public function tagPISST(
        $nItem = '',
        $vBC = '',
        $pPIS = '',
        $qBCProd = '',
        $vAliqProd = '',
        $vPIS = ''
    ) {
        $pisst = $this->dom->createElement('PISST');
        $this->dom->addChild(
            $pisst,
            'vBC',
            $vBC,
            true,
            "[item $nItem] Valor da Base de Cálculo do PIS"
        );
        $this->dom->addChild(
            $pisst,
            'pPIS',
            $pPIS,
            true,
            "[item $nItem] Alíquota do PIS (em percentual)"
        );
        $this->dom->addChild(
            $pisst,
            'qBCProd',
            $qBCProd,
            true,
            "[item $nItem] Quantidade Vendida"
        );
        $this->dom->addChild(
            $pisst,
            'vAliqProd',
            $vAliqProd,
            true,
            "[item $nItem] Alíquota do PIS (em reais)"
        );
        $this->dom->addChild(
            $pisst,
            'vPIS',
            $vPIS,
            true,
            "[item $nItem] Valor do PIS"
        );
        $this->aPISST[$nItem] = $pisst;
        return $pisst;
    }

    /**
     * Grupo COFINS S01 pai M01
     * tag det/imposto/COFINS (opcional)
     * @param string $nItem
     * @param string $cst
     * @param string $vBC
     * @param string $pCOFINS
     * @param string $vCOFINS
     * @param string $qBCProd
     * @param string $vAliqProd
     * @return DOMElement
     */
    public function tagCOFINS(
        $nItem = '',
        $cst = '',
        $vBC = '',
        $pCOFINS = '',
        $vCOFINS = '',
        $qBCProd = '',
        $vAliqProd = ''
    ) {
        switch ($cst) {
            case '01':
            case '02':
                $confinsItem = $this->buildCOFINSAliq($cst, $vBC, $pCOFINS, $vCOFINS);
                break;
            case '03':
                $confinsItem = $this->dom->createElement('COFINSQtde');
                $this->dom->addChild(
                    $confinsItem,
                    'CST',
                    $cst,
                    true,
                    "[item $nItem] Código de Situação Tributária da COFINS"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'qBCProd',
                    $qBCProd,
                    true,
                    "[item $nItem] Quantidade Vendida"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'vAliqProd',
                    $vAliqProd,
                    true,
                    "[item $nItem] Alíquota do COFINS (em reais)"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'vCOFINS',
                    $vCOFINS,
                    true,
                    "[item $nItem] Valor do COFINS"
                );
                break;
            case '04':
            case '05':
            case '06':
            case '07':
            case '08':
            case '09':
                $confinsItem = $this->buildCOFINSNT($cst);
                break;
            case '49':
            case '50':
            case '51':
            case '52':
            case '53':
            case '54':
            case '55':
            case '56':
            case '60':
            case '61':
            case '62':
            case '63':
            case '64':
            case '65':
            case '66':
            case '67':
            case '70':
            case '71':
            case '72':
            case '73':
            case '74':
            case '75':
            case '98':
            case '99':
                $confinsItem = $this->buildCOFINSoutr($cst, $vBC, $pCOFINS, $qBCProd, $vAliqProd, $vCOFINS);
                break;
        }
        $confins = $this->dom->createElement('COFINS');
        if (isset($confinsItem)) {
            $confins->appendChild($confinsItem);
        }
        $this->aCOFINS[$nItem] = $confins;
        return $confins;
    }

    /**
     * Grupo COFINS Substituição Tributária T01 pai M01
     * tag NFe/infNFe/det[]/imposto/COFINSST (opcional)
     * @param string $nItem
     * @param string $vBC
     * @param string $pCOFINS
     * @param string $qBCProd
     * @param string $vAliqProd
     * @param string $vCOFINS
     * @return DOMElement
     */
    public function tagCOFINSST(
        $nItem = '',
        $vBC = '',
        $pCOFINS = '',
        $qBCProd = '',
        $vAliqProd = '',
        $vCOFINS = ''
    ) {
        $cofinsst = $this->dom->createElement("COFINSST");
        $this->dom->addChild(
            $cofinsst,
            "vBC",
            $vBC,
            true,
            "[item $nItem] Valor da Base de Cálculo da COFINS"
        );
        $this->dom->addChild(
            $cofinsst,
            "pCOFINS",
            $pCOFINS,
            true,
            "[item $nItem] Alíquota da COFINS (em percentual)"
        );
        $this->dom->addChild(
            $cofinsst,
            "qBCProd",
            $qBCProd,
            true,
            "[item $nItem] Quantidade Vendida"
        );
        $this->dom->addChild(
            $cofinsst,
            "vAliqProd",
            $vAliqProd,
            true,
            "[item $nItem] Alíquota da COFINS (em reais)"
        );
        $this->dom->addChild(
            $cofinsst,
            "vCOFINS",
            $vCOFINS,
            true,
            "[item $nItem] Valor da COFINS"
        );
        $this->aCOFINSST[$nItem] = $cofinsst;
        return $cofinsst;
    }

    /**
     * Grupo ISSQN U01 pai M01
     * tag NFe/infNFe/det[]/imposto/ISSQN (opcional)
     * @param string $nItem
     * @param string $vBC
     * @param string $vAliq
     * @param string $vISSQN
     * @param string $cMunFG
     * @param string $cListServ
     * @param string $vDeducao
     * @param string $vOutro
     * @param string $vDescIncond
     * @param string $vDescCond
     * @param string $vISSRet
     * @param string $indISS
     * @param string $cServico
     * @param string $cMun
     * @param string $cPais
     * @param string $nProcesso
     * @param string $indIncentivo
     * @return DOMElement
     */
    public function tagISSQN(
        $nItem = '',
        $vBC = '',
        $vAliq = '',
        $vISSQN = '',
        $cMunFG = '',
        $cListServ = '',
        $vDeducao = '',
        $vOutro = '',
        $vDescIncond = '',
        $vDescCond = '',
        $vISSRet = '',
        $indISS = '',
        $cServico = '',
        $cMun = '',
        $cPais = '',
        $nProcesso = '',
        $indIncentivo = ''
    ) {
        $issqn = $this->dom->createElement("ISSQN");
        $this->dom->addChild(
            $issqn,
            "vBC",
            $vBC,
            true,
            "[item $nItem] Valor da Base de Cálculo do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "vAliq",
            $vAliq,
            true,
            "[item $nItem] Alíquota do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "vISSQN",
            $vISSQN,
            true,
            "[item $nItem] Valor do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "cMunFG",
            $cMunFG,
            true,
            "[item $nItem] Código do município de ocorrência do fato gerador do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "cListServ",
            $cListServ,
            true,
            "[item $nItem] Item da Lista de Serviços"
        );
        $this->dom->addChild(
            $issqn,
            "vDeducao",
            $vDeducao,
            false,
            "[item $nItem] Valor dedução para redução da Base de Cálculo"
        );
        $this->dom->addChild(
            $issqn,
            "vOutro",
            $vOutro,
            false,
            "[item $nItem] Valor outras retenções"
        );
        $this->dom->addChild(
            $issqn,
            "vDescIncond",
            $vDescIncond,
            false,
            "[item $nItem] Valor desconto incondicionado"
        );
        $this->dom->addChild(
            $issqn,
            "vDescCond",
            $vDescCond,
            false,
            "[item $nItem] Valor desconto condicionado"
        );
        $this->dom->addChild(
            $issqn,
            "vISSRet",
            $vISSRet,
            false,
            "[item $nItem] Valor retenção ISS"
        );
        $this->dom->addChild(
            $issqn,
            "indISS",
            $indISS,
            true,
            "[item $nItem] Indicador da exigibilidade do ISS"
        );
        $this->dom->addChild(
            $issqn,
            "cServico",
            $cServico,
            false,
            "[item $nItem] Código do serviço prestado dentro do município"
        );
        $this->dom->addChild(
            $issqn,
            "cMun",
            $cMun,
            false,
            "[item $nItem] Código do Município de incidência do imposto"
        );
        $this->dom->addChild(
            $issqn,
            "cPais",
            $cPais,
            false,
            "[item $nItem] Código do País onde o serviço foi prestado"
        );
        $this->dom->addChild(
            $issqn,
            "nProcesso",
            $nProcesso,
            false,
            "[item $nItem] Número do processo judicial ou administrativo de suspensão da exigibilidade"
        );
        $this->dom->addChild(
            $issqn,
            "indIncentivo",
            $indIncentivo,
            true,
            "[item $nItem] Indicador de incentivo Fiscal"
        );
        $this->aISSQN[$nItem] = $issqn;
        return $issqn;
    }

    /**
     * Informação do Imposto devolvido U50 pai H01
     * tag NFe/infNFe/det[]/impostoDevol (opcional)
     * @param string $nItem
     * @param string $pDevol
     * @param string $vIPIDevol
     * @return DOMElement
     */
    public function tagimpostoDevol($nItem = '', $pDevol = '', $vIPIDevol = '')
    {
        $impostoDevol = $this->dom->createElement("impostoDevol");
        $this->dom->addChild(
            $impostoDevol,
            "pDevol",
            $pDevol,
            true,
            "[item $nItem] Percentual da mercadoria devolvida"
        );
        $parent = $this->dom->createElement("IPI");
        $this->dom->addChild(
            $parent,
            "vIPIDevol",
            $vIPIDevol,
            true,
            "[item $nItem] Valor do IPI devolvido"
        );
        $impostoDevol->appendChild($parent);
        $this->aImpostoDevol[$nItem] = $impostoDevol;
        return $impostoDevol;
    }

    /**
     * Grupo Totais referentes ao ICMS W02 pai W01
     * tag NFe/infNFe/total/ICMSTot
     * @param string $vBC
     * @param string $vICMS
     * @param string $vICMSDeson
     * @param string $vBCST
     * @param string $vST
     * @param string $vProd
     * @param string $vFrete
     * @param string $vSeg
     * @param string $vDesc
     * @param string $vII
     * @param string $vIPI
     * @param string $vPIS
     * @param string $vCOFINS
     * @param string $vOutro
     * @param string $vNF
     * @param string $vTotTrib
     * @return DOMElement
     */
    public function tagICMSTot(
        $vBC = '',
        $vICMS = '',
        $vICMSDeson = '',
        $vBCST = '',
        $vST = '',
        $vProd = '',
        $vFrete = '',
        $vSeg = '',
        $vDesc = '',
        $vII = '',
        $vIPI = '',
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
            "vFCPUFDest",
            $this->aTotICMSUFDest['vFCPUFDest'],
            false,
            "Valor total do ICMS relativo ao Fundo de Combate à Pobreza(FCP) para a UF de destino"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSUFDest",
            $this->aTotICMSUFDest['vICMSUFDest'],
            false,
            "Valor total do ICMS de partilha para a UF do destinatário"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSUFRemet",
            $this->aTotICMSUFDest['vICMSUFRemet'],
            false,
            "Valor total do ICMS de partilha para a UF do remetente"
        );
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
     * Grupo Totais referentes ao ISSQN W17 pai W01
     * tag NFe/infNFe/total/ISSQNTot (opcional)
     * @param string $vServ
     * @param string $vBC
     * @param string $vISS
     * @param string $vPIS
     * @param string $vCOFINS
     * @param string $dCompet
     * @param string $vDeducao
     * @param string $vOutro
     * @param string $vDescIncond
     * @param string $vDescCond
     * @param string $vISSRet
     * @param string $cRegTrib
     * @param string $vOutro
     * @param string $vDescIncond
     * @param string $vDescCond
     * @param string $vISSRet
     * @param string $cRegTrib
     * @return DOMElement
     */
    public function tagISSQNTot(
        $vServ = '',
        $vBC = '',
        $vISS = '',
        $vPIS = '',
        $vCOFINS = '',
        $dCompet = '',
        $vDeducao = '',
        $vOutro = '',
        $vDescIncond = '',
        $vDescCond = '',
        $vISSRet = '',
        $cRegTrib = ''
    ) {
        $this->buildTotal();
        $ISSQNTot = $this->dom->createElement("ISSQNtot");
        $this->dom->addChild(
            $ISSQNTot,
            "vServ",
            $vServ,
            false,
            "Valor total dos Serviços sob não incidência ou não tributados pelo ICMS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vBC",
            $vBC,
            false,
            "Valor total Base de Cálculo do ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vISS",
            $vISS,
            false,
            "Valor total do ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vPIS",
            $vPIS,
            false,
            "Valor total do PIS sobre serviços"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vCOFINS",
            $vCOFINS,
            false,
            "Valor total da COFINS sobre serviços"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "dCompet",
            $dCompet,
            true,
            "Data da prestação do serviço"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDeducao",
            $vDeducao,
            false,
            "Valor total dedução para redução da Base de Cálculo"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vOutro",
            $vOutro,
            false,
            "Valor total outras retenções"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDescIncond",
            $vDescIncond,
            false,
            "Valor total desconto incondicionado"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDescCond",
            $vDescCond,
            false,
            "Valor total desconto condicionado"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vISSRet",
            $vISSRet,
            false,
            "Valor total retenção ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "cRegTrib",
            $cRegTrib,
            false,
            "Código do Regime Especial de Tributação"
        );
        $this->dom->appChild($this->total, $ISSQNTot, '');
        return $ISSQNTot;
    }

    /**
     * Grupo Retenções de Tributos W23 pai W01
     * tag NFe/infNFe/total/reTrib (opcional)
     * @param string $vRetPIS
     * @param string $vRetCOFINS
     * @param string $vRetCSLL
     * @param string $vBCIRRF
     * @param string $vIRRF
     * @param string $vBCRetPrev
     * @param string $vRetPrev
     * @return DOMElement
     */
    public function tagretTrib(
        $vRetPIS = '',
        $vRetCOFINS = '',
        $vRetCSLL = '',
        $vBCIRRF = '',
        $vIRRF = '',
        $vBCRetPrev = '',
        $vRetPrev = ''
    ) {
        $retTrib = $this->dom->createElement("retTrib");
        $this->dom->addChild(
            $retTrib,
            "vRetPIS",
            $vRetPIS,
            false,
            "Valor Retido de PIS"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetCOFINS",
            $vRetCOFINS,
            false,
            "Valor Retido de COFINS"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetCSLL",
            $vRetCSLL,
            false,
            "Valor Retido de CSLL"
        );
        $this->dom->addChild(
            $retTrib,
            "vBCIRRF",
            $vBCIRRF,
            false,
            "Base de Cálculo do IRRF"
        );
        $this->dom->addChild(
            $retTrib,
            "vIRRF",
            $vIRRF,
            false,
            "Valor Retido do IRRF"
        );
        $this->dom->addChild(
            $retTrib,
            "vBCRetPrev",
            $vBCRetPrev,
            false,
            "Base de Cálculo da Retenção da Previdência Social"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetPrev",
            $vRetPrev,
            false,
            "Valor da Retenção da Previdência Social"
        );
        $this->dom->appChild($this->total, $retTrib, '');
        return $retTrib;
    }

    /**
     * Grupo Informações do Transporte X01 pai A01
     * tag NFe/infNFe/transp (obrigatório)
     * @param string $modFrete
     * @return DOMElement
     */
    public function tagtransp($modFrete = '')
    {
        $this->transp = $this->dom->createElement("transp");
        $this->dom->addChild(
            $this->transp,
            "modFrete",
            $modFrete,
            true,
            "Modalidade do frete"
        );
        return $this->transp;
    }

    /**
     * Grupo Transportador X03 pai X01
     * tag NFe/infNFe/transp/tranporta (opcional)
     * @param string $numCNPJ
     * @param string $numCPF
     * @param string $xNome
     * @param string $numIE
     * @param string $xEnder
     * @param string $xMun
     * @param string $siglaUF
     * @return DOMElement
     */
    public function tagtransporta(
        $numCNPJ = '',
        $numCPF = '',
        $xNome = '',
        $numIE = '',
        $xEnder = '',
        $xMun = '',
        $siglaUF = ''
    ) {
        $transporta = $this->dom->createElement("transporta");
        $this->dom->addChild(
            $transporta,
            "CNPJ",
            $numCNPJ,
            false,
            "CNPJ do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "CPF",
            $numCPF,
            false,
            "CPF do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xNome",
            $xNome,
            false,
            "Razão Social ou nome do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "IE",
            $numIE,
            false,
            "Inscrição Estadual do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xEnder",
            $xEnder,
            false,
            "Endereço Completo do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xMun",
            $xMun,
            false,
            "Nome do município do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "UF",
            $siglaUF,
            false,
            "Sigla da UF do Transportador"
        );
        $this->dom->appChild(
            $this->transp,
            $transporta,
            'A tag transp deveria ter sido carregada primeiro.'
        );
        return $transporta;
    }

    /**
     * Grupo Veículo Transporte X18 pai X17.1
     * tag NFe/infNFe/transp/veicTransp (opcional)
     * @param string $placa
     * @param string $siglaUF
     * @param string $rntc
     * @return DOMElement
     */
    public function tagveicTransp(
        $placa = '',
        $siglaUF = '',
        $rntc = ''
    ) {
        $veicTransp = $this->dom->createElement("veicTransp");
        $this->dom->addChild(
            $veicTransp,
            "placa",
            $placa,
            true,
            "Placa do Veículo"
        );
        $this->dom->addChild(
            $veicTransp,
            "UF",
            $siglaUF,
            true,
            "Sigla da UF do Veículo"
        );
        $this->dom->addChild(
            $veicTransp,
            "RNTC",
            $rntc,
            false,
            "Registro Nacional de Transportador de Carga (ANTT) do Veículo"
        );
        $this->dom->appChild(
            $this->transp,
            $veicTransp,
            'A tag transp deveria ter sido carregada primeiro.'
        );
        return $veicTransp;
    }

    /**
     * Grupo Reboque X22 pai X17.1
     * tag NFe/infNFe/transp/reboque (opcional)
     * @param string $placa
     * @param string $siglaUF
     * @param string $rntc
     * @param string $vagao
     * @param string $balsa
     * @return DOMElement
     */
    public function tagreboque(
        $placa = '',
        $siglaUF = '',
        $rntc = '',
        $vagao = '',
        $balsa = ''
    ) {
        $reboque = $this->dom->createElement("reboque");
        $this->dom->addChild(
            $reboque,
            "placa",
            $placa,
            true,
            "Placa do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "UF",
            $siglaUF,
            true,
            "Sigla da UF do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "RNTC",
            $rntc,
            false,
            "Registro Nacional de Transportador de Carga (ANTT) do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "vagao",
            $vagao,
            false,
            "Identificação do vagão do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "balsa",
            $balsa,
            false,
            "Identificação da balsa do Veículo Reboque"
        );
        $this->aReboque[] = $reboque;
        $this->dom->appChild(
            $this->transp,
            $reboque,
            'A tag transp deveria ter sido carregada primeiro.'
        );
        return $reboque;
    }

    /**
     * Grupo Retenção ICMS transporte X11 pai X01
     * tag NFe/infNFe/transp/retTransp (opcional)
     * @param string $vServ
     * @param string $vBCRet
     * @param string $pICMSRet
     * @param string $vICMSRet
     * @param string $cfop
     * @param string $cMunFG
     * @return DOMElement
     */
    public function tagretTransp(
        $vServ = '',
        $vBCRet = '',
        $pICMSRet = '',
        $vICMSRet = '',
        $cfop = '',
        $cMunFG = ''
    ) {
        $retTransp = $this->dom->createElement("retTransp");
        $this->dom->addChild(
            $retTransp,
            "vServ",
            $vServ,
            true,
            "Valor do Serviço"
        );
        $this->dom->addChild(
            $retTransp,
            "vBCRet",
            $vBCRet,
            true,
            "BC da Retenção do ICMS"
        );
        $this->dom->addChild(
            $retTransp,
            "pICMSRet",
            $pICMSRet,
            true,
            "Alíquota da Retenção"
        );
        $this->dom->addChild(
            $retTransp,
            "vICMSRet",
            $vICMSRet,
            true,
            "Valor do ICMS Retido"
        );
        $this->dom->addChild(
            $retTransp,
            "CFOP",
            $cfop,
            true,
            "CFOP"
        );
        $this->dom->addChild(
            $retTransp,
            "cMunFG",
            $cMunFG,
            true,
            "Código do município de ocorrência do fato gerador do ICMS do transporte"
        );
        $this->dom->appChild(
            $this->transp,
            $retTransp,
            'A tag transp deveria ter sido carregada primeiro.'
        );
        return $retTransp;
    }

    /**
     * Grupo Volumes X26 pai X01
     * tag NFe/infNFe/transp/vol (opcional)
     * @param string $qVol
     * @param string $esp
     * @param string $marca
     * @param string $nVol
     * @param string $pesoL
     * @param string $pesoB
     * @param array  $aLacres
     * @return DOMElement
     */
    public function tagvol(
        $qVol = '',
        $esp = '',
        $marca = '',
        $nVol = '',
        $pesoL = '',
        $pesoB = '',
        $aLacres = array()
    ) {
        $vol = $this->dom->createElement("vol");
        $this->dom->addChild(
            $vol,
            "qVol",
            $qVol,
            false,
            "Quantidade de volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "esp",
            $esp,
            false,
            "Espécie dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "marca",
            $marca,
            false,
            "Marca dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "nVol",
            $nVol,
            false,
            "Numeração dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "pesoL",
            $pesoL,
            false,
            "Peso Líquido (em kg) dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "pesoB",
            $pesoB,
            false,
            "Peso Bruto (em kg) dos volumes transportados"
        );
        if (!empty($aLacres)) {
            //tag transp/vol/lacres (opcional)
            foreach ($aLacres as $nLacre) {
                $lacre = $this->buildLacres($nLacre);
                $vol->appendChild($lacre);
                $lacre = null;
            }
        }
        $this->aVol[] = $vol;
        $this->dom->appChild(
            $this->transp,
            $vol,
            'A tag transp deveria ter sido carregada primeiro.'
        );
        return $vol;
    }

    /**
     * Grupo Fatura Y02 pai Y01
     * tag NFe/infNFe/cobr/fat (opcional)
     * @param string $nFat
     * @param string $vOrig
     * @param string $vDesc
     * @param string $vLiq
     * @return DOMElement
     */
    public function tagfat(
        $nFat = '',
        $vOrig = '',
        $vDesc = '',
        $vLiq = ''
    ) {
        $this->buildCobr();
        $fat = $this->dom->createElement("fat");
        $this->dom->addChild($fat, "nFat", $nFat, false, "Número da Fatura");
        $this->dom->addChild($fat, "vOrig", $vOrig, false, "Valor Original da Fatura");
        $this->dom->addChild($fat, "vDesc", $vDesc, false, "Valor do desconto");
        $this->dom->addChild($fat, "vLiq", $vLiq, false, "Valor Líquido da Fatura");
        $this->dom->appChild($this->cobr, $fat);
        return $fat;
    }

    /**
     * Grupo Duplicata Y07 pai Y02
     * tag NFe/infNFe/cobr/fat/dup (opcional)
     * É necessário criar a tag fat antes de criar as duplicatas
     * @param string $nDup
     * @param string $dVenc
     * @param string $vDup
     * @return DOMElement
     */
    public function tagdup(
        $nDup = '',
        $dVenc = '',
        $vDup = ''
    ) {
        $this->buildCobr();
        $dup = $this->dom->createElement("dup");
        $this->dom->addChild($dup, "nDup", $nDup, false, "Número da Duplicata");
        $this->dom->addChild($dup, "dVenc", $dVenc, false, "Data de vencimento");
        $this->dom->addChild($dup, "vDup", $vDup, true, "Valor da duplicata");
        $this->dom->appChild($this->cobr, $dup, 'Inclui duplicata na tag cobr');
        $this->aDup[] = $dup;
        return $dup;
    }

    /**
     * Grupo de Formas de Pagamento YA01 pai A01
     * tag NFe/infNFe/pag (opcional)
     * Apenas para o modelo 65 NFCe
     * @param string $tPag
     * @param string $vPag
     * @return DOMElement
     */
    public function tagpag(
        $tPag = '',
        $vPag = ''
    ) {
        $num = $this->buildPag();
        $pag = $this->dom->createElement("pag");
        $this->dom->addChild(
            $this->aPag[$num-1],
            "tPag",
            $tPag,
            true,
            "Forma de pagamento"
        );
        $this->dom->addChild(
            $this->aPag[$num-1],
            "vPag",
            $vPag,
            true,
            "Valor do Pagamento"
        );
        return $pag;
    }

    /**
     * Grupo de Cartões YA04 pai YA01
     * tag NFe/infNFe/pag/card
     * @param string $cnpj
     * @param string $tBand
     * @param string $cAut
     * @param string $tpIntegra
     * @return DOMElement
     */
    public function tagcard(
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
            $this->dom->appChild($this->aPag[count($this->aPag)-1], $card, '');
            return $card;
        }
    }

    /**
     * Grupo de Informações Adicionais Z01 pai A01
     * tag NFe/infNFe/infAdic (opcional)
     * @param string $infAdFisco
     * @param string $infCpl
     * @return DOMElement
     */
    public function taginfAdic(
        $infAdFisco = '',
        $infCpl = ''
    ) {
        $this->buildInfAdic();
        $this->dom->addChild(
            $this->infAdic,
            "infAdFisco",
            $infAdFisco,
            false,
            "Informações Adicionais de Interesse do Fisco"
        );
        $this->dom->addChild(
            $this->infAdic,
            "infCpl",
            $infCpl,
            false,
            "Informações Complementares de interesse do Contribuinte"
        );
        return $this->infAdic;
    }

    /**
     * Grupo Campo de uso livre do contribuinte Z04 pai Z01
     * tag NFe/infNFe/infAdic/obsCont (opcional)
     * O método taginfAdic deve ter sido carregado antes
     * @param string $xCampo
     * @param string $xTexto
     * @return DOMElement
     */
    public function tagobsCont(
        $xCampo = '',
        $xTexto = ''
    ) {
        $this->buildInfAdic();
        $obsCont = $this->dom->createElement("obsCont");
        $obsCont->setAttribute("xCampo", $xCampo);
        $this->dom->addChild($obsCont, "xTexto", $xTexto, true, "Conteúdo do campo");
        $this->aObsCont[] = $obsCont;
        $this->dom->appChild($this->infAdic, $obsCont, '');
        return $obsCont;
    }

    /**
     * Grupo Campo de uso livre do Fisco Z07 pai Z01
     * tag NFe/infNFe/infAdic/obsFisco (opcional)
     * O método taginfAdic deve ter sido carregado antes
     * @param string $xCampo
     * @param string $xTexto
     * @return DOMElement
     */
    public function tagobsFisco(
        $xCampo = '',
        $xTexto = ''
    ) {
        $this->buildInfAdic();
        $obsFisco = $this->dom->createElement("obsFisco");
        $obsFisco->setAttribute("xCampo", $xCampo);
        $this->dom->addChild($obsFisco, "xTexto", $xTexto, true, "Conteúdo do campo");
        $this->aObsFisco[] = $obsFisco;
        $this->dom->appChild($this->infAdic, $obsFisco, '');
        return $obsFisco;
    }

    /**
     * Grupo Processo referenciado Z10 pai Z01 (NT2012.003)
     * tag NFe/infNFe/procRef (opcional)
     * O método taginfAdic deve ter sido carregado antes
     * @param string $nProc
     * @param string $indProc
     * @return DOMElement
     */
    public function tagprocRef(
        $nProc = '',
        $indProc = ''
    ) {
        $this->buildInfAdic();
        $procRef = $this->dom->createElement("procRef");
        $this->dom->addChild(
            $procRef,
            "nProc",
            $nProc,
            true,
            "Identificador do processo ou ato concessório"
        );
        $this->dom->addChild(
            $procRef,
            "indProc",
            $indProc,
            true,
            "Indicador da origem do processo"
        );
        $this->aProcRef[] = $procRef;
        $this->dom->appChild($this->infAdic, $procRef, '');
        return $procRef;
    }

    /**
     * Grupo Exportação ZA01 pai A01
     * tag NFe/infNFe/exporta (opcional)
     * @param string $ufSaidaPais
     * @param string $xLocExporta
     * @param string $xLocDespacho
     * @return DOMElement
     */
    public function tagexporta(
        $ufSaidaPais = '',
        $xLocExporta = '',
        $xLocDespacho = ''
    ) {
        $this->exporta = $this->dom->createElement("exporta");
        $this->dom->addChild(
            $this->exporta,
            "UFSaidaPais",
            $ufSaidaPais,
            true,
            "Sigla da UF de Embarque ou de transposição de fronteira"
        );
        $this->dom->addChild(
            $this->exporta,
            "xLocExporta",
            $xLocExporta,
            true,
            "Descrição do Local de Embarque ou de transposição de fronteira"
        );
        $this->dom->addChild(
            $this->exporta,
            "xLocDespacho",
            $xLocDespacho,
            false,
            "Descrição do local de despacho"
        );
        return $this->exporta;
    }

    /**
     * Grupo Compra ZB01 pai A01
     * tag NFe/infNFe/compra (opcional)
     * @param string $xNEmp
     * @param string $xPed
     * @param string $xCont
     * @return DOMElement
     */
    public function tagcompra(
        $xNEmp = '',
        $xPed = '',
        $xCont = ''
    ) {
        $this->compra = $this->dom->createElement("compra");
        $this->dom->addChild($this->compra, "xNEmp", $xNEmp, false, "Nota de Empenho");
        $this->dom->addChild($this->compra, "xPed", $xPed, false, "Pedido");
        $this->dom->addChild($this->compra, "xCont", $xCont, false, "Contrato");
        return $this->compra;
    }

    /**
     * Grupo Cana ZC01 pai A01
     * tag NFe/infNFe/cana (opcional)
     * @param string $safra
     * @param string $ref
     * @return DOMElement
     */
    public function tagcana(
        $safra = '',
        $ref = ''
    ) {
        $this->cana = $this->dom->createElement("cana");
        $this->dom->addChild($this->cana, "safra", $safra, true, "Identificação da safra");
        $this->dom->addChild($this->cana, "ref", $ref, true, "Mês e ano de referência");
        return $this->cana;
    }

    /**
     * Grupo Fornecimento diário de cana ZC04 pai ZC01
     * tag NFe/infNFe/cana/forDia
     * @param string $dia
     * @param string $qtde
     * @param string $qTotMes
     * @param string $qTotAnt
     * @param string $qTotGer
     * @return DOMElement
     */
    public function tagforDia(
        $dia = '',
        $qtde = '',
        $qTotMes = '',
        $qTotAnt = '',
        $qTotGer = ''
    ) {
        $forDia = $this->dom->createElement("forDia");
        $forDia->setAttribute("dia", $dia);
        $this->dom->addChild(
            $forDia,
            "qtde",
            $qtde,
            true,
            "Quantidade"
        );
        $this->dom->addChild(
            $forDia,
            "qTotMes",
            $qTotMes,
            true,
            "Quantidade Total do Mês"
        );
        $this->dom->addChild(
            $forDia,
            "qTotAnt",
            $qTotAnt,
            true,
            "Quantidade Total Anterior"
        );
        $this->dom->addChild(
            $forDia,
            "qTotGer",
            $qTotGer,
            true,
            "Quantidade Total Geral"
        );
        $this->aForDia[] = $forDia;
        $this->dom->appChild($this->cana, $forDia, 'O metodo tacana deveria ter sido chamado antes. [tagforDia]');
        return $forDia;
    }

    /**
     * Grupo Deduções – Taxas e Contribuições ZC10 pai ZC01
     * tag NFe/infNFe/cana/deduc (opcional)
     * @param string $xDed
     * @param string $vDed
     * @param string $vFor
     * @param string $vTotDed
     * @param string $vLiqFor
     * @return DOMElement
     */
    public function tagdeduc(
        $xDed = '',
        $vDed = '',
        $vFor = '',
        $vTotDed = '',
        $vLiqFor = ''
    ) {
        $deduc = $this->dom->createElement("deduc");
        $this->dom->addChild(
            $deduc,
            "xDed",
            $xDed,
            true,
            "Descrição da Dedução"
        );
        $this->dom->addChild(
            $deduc,
            "vDed",
            $vDed,
            true,
            "Valor da Dedução"
        );
        $this->dom->addChild(
            $deduc,
            "vFor",
            $vFor,
            true,
            "Valor dos Fornecimentos"
        );
        $this->dom->addChild(
            $deduc,
            "vTotDed",
            $vTotDed,
            true,
            "Valor Total da Dedução"
        );
        $this->dom->addChild(
            $deduc,
            "vLiqFor",
            $vLiqFor,
            true,
            "Valor Líquido dos Fornecimentos"
        );
        $this->aDeduc[] = $deduc;
        $this->dom->appChild(
            $this->cana,
            $deduc,
            'O metodo tagcana deveria ter sido chamado antes. [tagdeduc]'
        );
        return $deduc;
    }

    /**
     * Tag raiz da NFe
     * tag NFe DOMNode
     * Função chamada pelo método [ monta ]
     * @return DOMElement
     */
    private function buildNFe()
    {
        if (empty($this->NFe)) {
            $this->NFe = $this->dom->createElement("NFe");
            $this->NFe->setAttribute("xmlns", "http://www.portalfiscal.inf.br/nfe");
        }
        return $this->NFe;
    }

    /**
     * Informação de Documentos Fiscais referenciados BA01 pai B01
     * tag NFe/infNFe/ide/NFref
     * Podem ser criados até 500 desses Nodes por NFe
     * Função chamada pelos métodos
     * [tagrefNFe] [tagrefNF] [tagrefNFP]  [tagCTeref] [tagrefECF]
     * @return int contagem do numero de tags NFref
     */
    private function builtNFref()
    {
        $this->aNFref[] = $this->dom->createElement("NFref");
        return count($this->aNFref);
    }

    /**
     * Informação de pagamentos
     * tag NFe/infNFe/pag
     * Podem ser criados até 100 desses Nodes por NFe
     * Função chamada pelo método [tagPag]
     * @return int Total registros
     */
    private function buildPag()
    {
        $this->aPag[] = $this->dom->createElement("pag");
        return count($this->aPag);
    }

    /**
     * Insere dentro dentro das tags imposto o ICMS IPI II PIS COFINS ISSQN
     * tag NFe/infNFe/det[]/imposto
     * @return void
     */
    private function buildImp()
    {
        foreach ($this->aImposto as $nItem => $imposto) {
            if (!empty($this->aICMS[$nItem])) {
                $this->dom->appChild($imposto, $this->aICMS[$nItem], "Inclusão do node ICMS");
            }
            if (!empty($this->aIPI[$nItem])) {
                $this->dom->appChild($imposto, $this->aIPI[$nItem], "Inclusão do node IPI");
            }
            if (!empty($this->aII[$nItem])) {
                $this->dom->appChild($imposto, $this->aII[$nItem], "Inclusão do node II");
            }
            if (!empty($this->aISSQN[$nItem])) {
                $this->dom->appChild($imposto, $this->aISSQN[$nItem], "Inclusão do node ISSQN");
            }
            if (!empty($this->aPIS[$nItem])) {
                $this->dom->appChild($imposto, $this->aPIS[$nItem], "Inclusão do node PIS");
            }
            if (!empty($this->aPISST[$nItem])) {
                $this->dom->appChild($imposto, $this->aPISST[$nItem], "Inclusão do node PISST");
            }
            if (!empty($this->aCOFINS[$nItem])) {
                $this->dom->appChild($imposto, $this->aCOFINS[$nItem], "Inclusão do node COFINS");
            }
            if (!empty($this->aCOFINSST[$nItem])) {
                $this->dom->appChild($imposto, $this->aCOFINSST[$nItem], "Inclusão do node COFINSST");
            }
            if (!empty($this->aICMSUFDest[$nItem])) {
                $this->dom->appChild($imposto, $this->aICMSUFDest[$nItem], "Inclusão do node ICMSUFDest");
            }
            $this->aImposto[$nItem] = $imposto;
        }
    }

    /**
     * Grupo COFINS tributado pela alíquota S02 pai S01
     * tag det/imposto/COFINS/COFINSAliq (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     * @param string $cst
     * @param string $vBC
     * @param string $pCOFINS
     * @param string $vCOFINS
     * @return DOMElement
     */
    private function buildCOFINSAliq($cst = '', $vBC = '', $pCOFINS = '', $vCOFINS = '')
    {
        $confinsAliq = $this->dom->createElement('COFINSAliq');
        $this->dom->addChild(
            $confinsAliq,
            'CST',
            $cst,
            true,
            "Código de Situação Tributária da COFINS"
        );
        $this->dom->addChild(
            $confinsAliq,
            'vBC',
            $vBC,
            true,
            "Valor da Base de Cálculo da COFINS"
        );
        $this->dom->addChild(
            $confinsAliq,
            'pCOFINS',
            $pCOFINS,
            true,
            "Alíquota da COFINS (em percentual)"
        );
        $this->dom->addChild(
            $confinsAliq,
            'vCOFINS',
            $vCOFINS,
            true,
            "Valor da COFINS"
        );
        return $confinsAliq;
    }

    /**
     * Grupo COFINS não tributado S04 pai S01
     * tag NFe/infNFe/det[]/imposto/COFINS/COFINSNT (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     * @param string $cst
     * @return DOMElement
     */
    private function buildCOFINSNT($cst = '')
    {
        $confinsnt = $this->dom->createElement('COFINSNT');
        $this->dom->addChild(
            $confinsnt,
            "CST",
            $cst,
            true,
            "Código de Situação Tributária da COFINS"
        );
        return $confinsnt;
    }

    /**
     * Grupo COFINS Outras Operações S05 pai S01
     * tag NFe/infNFe/det[]/imposto/COFINS/COFINSoutr (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     * @param string $cst
     * @param string $vBC
     * @param string $pCOFINS
     * @param string $qBCProd
     * @param string $vAliqProd
     * @param string $vCOFINS
     * @return DOMElement
     */
    private function buildCOFINSoutr($cst = '', $vBC = '', $pCOFINS = '', $qBCProd = '', $vAliqProd = '', $vCOFINS = '')
    {
        $confinsoutr = $this->dom->createElement('COFINSOutr');
        $this->dom->addChild(
            $confinsoutr,
            "CST",
            $cst,
            true,
            "Código de Situação Tributária da COFINS"
        );
        $this->dom->addChild(
            $confinsoutr,
            "vBC",
            $vBC,
            false,
            "Valor da Base de Cálculo da COFINS"
        );
        $this->dom->addChild(
            $confinsoutr,
            "pCOFINS",
            $pCOFINS,
            false,
            "Alíquota da COFINS (em percentual)"
        );
        $this->dom->addChild(
            $confinsoutr,
            "qBCProd",
            $qBCProd,
            false,
            "Quantidade Vendida"
        );
        $this->dom->addChild(
            $confinsoutr,
            "vAliqProd",
            $vAliqProd,
            false,
            "Alíquota da COFINS (em reais)"
        );
        $this->dom->addChild(
            $confinsoutr,
            "vCOFINS",
            $vCOFINS,
            true,
            "Valor da COFINS"
        );
        return $confinsoutr;
    }

    /**
     * Insere dentro da tag det os produtos
     * tag NFe/infNFe/det[]
     */
    private function buildDet()
    {
        if (empty($this->aProd)) {
            return '';
        }
        //insere NVE
        foreach ($this->aNVE as $nItem => $nve) {
            $prod = $this->aProd[$nItem];
            foreach ($nve as $child) {
                $node = $prod->getElementsByTagName("EXTIPI")->item(0);
                if (empty($node)) {
                    $node = $prod->getElementsByTagName("CFOP")->item(0);
                }
                $prod->insertBefore($child, $node);
            }
        }
        //insere CEST
        foreach ($this->aCest as $nItem => $cest) {
            $prod = $this->aProd[$nItem];
            foreach ($cest as $child) {
                $node = $prod->getElementsByTagName("EXTIPI")->item(0);
                if (empty($node)) {
                    $node = $prod->getElementsByTagName("CFOP")->item(0);
                }
                $prod->insertBefore($child, $node);
            }
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
     * Grupo Totais da NF-e W01 pai A01
     * tag NFe/infNFe/total
     * @return void
     */
    private function buildTotal()
    {
        if (empty($this->total)) {
            $this->total = $this->dom->createElement("total");
        }
        //ajuste de digitos dos campos totalizados
        if ($this->aTotICMSUFDest['vICMSUFDest'] != '') {
            $this->aTotICMSUFDest['vICMSUFDest'] = number_format($this->aTotICMSUFDest['vICMSUFDest'], 2, '.', '');
            $this->aTotICMSUFDest['vICMSUFRemet'] = number_format($this->aTotICMSUFDest['vICMSUFRemet'], 2, '.', '');
            $this->aTotICMSUFDest['vFCPUFDest'] = number_format($this->aTotICMSUFDest['vFCPUFDest'], 2, '.', '');
        }
    }

    /**
     * Grupo Lacres X33 pai X26
     * tag NFe/infNFe/transp/vol/lacres (opcional)
     * @param string $nLacre
     * @return DOMElement
     */
    protected function buildLacres($nLacre = '')
    {
        $lacre = $this->dom->createElement("lacres");
        $this->dom->addChild($lacre, "nLacre", $nLacre, true, "Número dos Lacres");
        return $lacre;
    }

    /**
     * Grupo Cobrança Y01 pai A01
     * tag NFe/infNFe/cobr (opcional)
     * Depende de fat
     * @return void
     */
    private function buildCobr()
    {
        if (empty($this->cobr)) {
            $this->cobr = $this->dom->createElement("cobr");
        }
    }

    /**
     * Grupo de Informações Adicionais Z01 pai A01
     * tag NFe/infNFe/infAdic (opcional)
     * Função chamada pelos metodos
     * [taginfAdic] [tagobsCont] [tagobsFisco] [tagprocRef]
     * @return DOMElement
     */
    private function buildInfAdic()
    {
        if (empty($this->infAdic)) {
            $this->infAdic = $this->dom->createElement("infAdic");
        }
        return $this->infAdic;
    }

    /**
     * Remonta a chave da NFe de 44 digitos com base em seus dados
     * já contidos na NFE.
     * Isso é útil no caso da chave informada estar errada
     * se a chave estiver errada a mesma é substituida
     * @param Dom $dom
     * @return void
     */
    private function checkNFeKey($dom)
    {
        $infNFe= $dom->getElementsByTagName("infNFe")->item(0);
        $ide = $dom->getElementsByTagName("ide")->item(0);
        $emit = $dom->getElementsByTagName("emit")->item(0);
        
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $cnpj = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
        $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
        $nNF = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $cNF = $ide->getElementsByTagName('cNF')->item(0)->nodeValue;
        $chave = str_replace('NFe', '', $infNFe->getAttribute("Id"));
        
        $dt = \DateTime($dhEmi);
        
        try {
            $nfeKey = NFeAccessKey::generate(
                $cUF,
                $dt->format('ym'),
                new Cnpj($cnpj),
                $serie,
                $nNF,
                $cNF
            );
        } catch (InvalidDocumentException $e) {
            echo $e->getMessage();
        }
        
        $chaveMontada = Keys::build(
            $cUF,
            $dt->format('y'),
            $dt->format('m'),
            $cnpj,
            $mod,
            $serie,
            $nNF,
            $tpEmis,
            $cNF
        );
        //caso a chave contida na NFe esteja errada
        //substituir a chave
        if ($chaveMontada != $chave) {
            $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chaveMontada, -1);
            $infNFe = $dom->getElementsByTagName("infNFe")->item(0);
            $infNFe->setAttribute("Id", "NFe" . $chaveMontada);
            $this->chNFe = $chaveMontada;
        }
    }
}
