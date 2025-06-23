<?php

/**
 * Classe a construção do xml da NFe modelo 55 e modelo 65
 * Esta classe basica está estruturada para montar XML da NFe para o
 * layout versão 4.00, os demais modelos serão derivados deste
 *
 * @category  API
 * @package   NFePHP\NFe\
 * @copyright Copyright (c) 2008-2020
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe;

use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Strings;
use NFePHP\NFe\Common\Gtin;
use stdClass;
use RuntimeException;
use InvalidArgumentException;
use DOMElement;
use DateTime;

class Make
{
    /**
     * @var array
     */
    public $errors = [];
    /**
     * @var string
     */
    public $chNFe;
    /**
     * @var string
     */
    public $xml;
    /**
     * @var stdClass
     */
    public $stdTot;
    /**
     * @var stdClass
     */
    protected $stdISSQNTot;
    /**
     * @var string
     */
    protected $version;
    /**
     * @var integer
     */
    protected $mod = 55;
    /**
     * @var \NFePHP\Common\DOMImproved
     */
    public $dom;
    /**
     * @var integer
     */
    protected $tpAmb = 2;
    /**
     * @var ?DOMElement
     */
    protected $NFe;
    /**
     * @var DOMElement
     */
    protected $infNFe;
    /**
     * @var DOMElement
     */
    protected $ide;
    /**
     * @var DOMElement
     */
    protected $emit;
    /**
     * @var DOMElement
     */
    protected $enderEmit;
    /**
     * @var ?DOMElement
     */
    protected $dest;
    /**
     * @var DOMElement
     */
    protected $enderDest;
    /**
     * @var DOMElement
     */
    protected $retirada;
    /**
     * @var DOMElement
     */
    protected $entrega;
    /**
     * @var DOMElement
     */
    protected $total;
    /**
     * @var ?DOMElement
     */
    protected $cobr;
    /**
     * @var DOMElement
     */
    protected $transp;
    /**
     * @var ?DOMElement
     */
    protected $infAdic;
    /**
     * @var DOMElement
     */
    protected $exporta;
    /**
     * @var DOMElement
     */
    protected $compra;
    /**
     * @var DOMElement
     */
    protected $cana;
    /**
     * @var DOMElement
     */
    protected $infNFeSupl;
    /**
     * @var array of DOMElements
     */
    protected $aNFref = [];
    /**
     * @var array of DOMElements
     */
    protected $aDup = [];
    /**
     * @var DOMElement
     */
    protected $pag;
    /**
     * @var array of DOMElements
     */
    protected $aDetPag = [];
    /**
     * @var DOMElement
     */
    protected $intermed;
    /**
     * @var array of DOMElements
     */
    protected $aReboque = [];
    /**
     * @var array of DOMElements
     */
    protected $aVol = [];
    /**
     * @var array of DOMElements
     */
    protected $aAutXML = [];
    /**
     * @var array of DOMElements
     */
    protected $aDet = [];
    /**
     * @var array of DOMElements
     */
    protected $aProd = [];
    /**
     * @var array
     */
    protected $aProdCreditoPresumido = [];
    /**
     * @var array of DOMElements
     */
    protected $obsItem = [];
    /**
     * @var array of DOMElements
     */
    protected $aRastro = [];
    /**
     * @var array of DOMElements
     */
    protected $aNVE = [];
    /**
     * @var array of DOMElements
     */
    protected $aCest = [];
    /**
     * @var array of DOMElements
     */
    protected $aRECOPI = [];
    /**
     * @var array of DOMElements
     */
    protected $aDetExport = [];
    /**
     * @var array of DOMElements
     */
    protected $aDI = [];
    /**
     * @var array of DOMElements
     */
    protected $aAdi = [];
    /**
     * @var array of DOMElements
     */
    protected $aVeicProd = [];
    /**
     * @var array of DOMElements
     */
    protected $aMed = [];
    /**
     * @var array of DOMElements
     */
    protected $aArma = [];
    /**
     * @var array of DOMElements
     */
    protected $aComb = [];
    /**
     * @var array of DOMElements
     */
    protected $aEncerrante = [];
    /**
     * @var array of DOMElements
     */
    protected $aOrigComb = [];
    /**
     * @var array of DOMElements
     */
    protected $aImposto = [];
    /**
     * @var array of DOMElements
     */
    protected $aICMS = [];
    /**
     * @var array of DOMElements
     */
    protected $aICMSUFDest = [];
    /**
     * @var array of DOMElements
     */
    protected $aIPI = [];
    /**
     * @var array of DOMElements
     */
    protected $aII = [];
    /**
     * @var array of DOMElements
     */
    protected $aISSQN = [];
    /**
     * @var array
     */
    protected $aPIS = [];
    /**
     * @var array of DOMElements
     */
    protected $aPISST = [];
    /**
     * @var array of DOMElements
     */
    protected $aCOFINS = [];
    /**
     * @var array of DOMElements
     */
    protected $aCOFINSST = [];
    /**
     * @var array of DOMElements
     */
    protected $aImpostoDevol = [];
    /**
     * @var array of DOMElements
     */
    protected $aInfAdProd = [];
    /**
     * @var array of DOMElements
     */
    protected $aObsCont = [];
    /**
     * @var array of DOMElements
     */
    protected $aObsFisco = [];
    /**
     * @var array of DOMElements
     */
    protected $aProcRef = [];
    /**
     * @var DOMElement
     */
    protected $infRespTec;
    /**
     * @var DOMElement
     */
    protected $agropecuario;
    /**
     * @var string
     */
    protected $csrt;
    /**
     * @var boolean
     */
    protected $replaceAccentedChars = false;
    /**
     * @var array
     */
    protected $aItensServ = [];
    /**
     * @var DOMElement
     */
    protected $ISSQNTot;
    /**
     * @var DOMElement
     */
    protected $ICMSTot;
    /**
     * @var ?DOMElement
     */
    protected $retTrib;
    /**
     * @var \stdClass
     */
    protected $stdISSQN;
    /**
     * @var \stdClass
     */
    protected $stdICMSTot;
    /**
     * @var bool
     */
    protected $flagISSQNCalc = false;
    /**
     * @var bool
     */
    protected $checkgtin = false;

    /**
     * Função construtora cria um objeto DOMDocument
     * que será carregado com o documento fiscal
     */
    public function __construct()
    {
        $this->dom = new Dom('1.0', 'UTF-8');
        $this->dom->preserveWhiteSpace = false;
        $this->dom->formatOutput = false;
        //elemento totalizador
        $this->stdTot = new \stdClass();
        $this->stdTot->vBC = 0;
        $this->stdTot->vICMS = 0;
        $this->stdTot->vICMSDeson = 0;
        $this->stdTot->vFCP = 0;
        $this->stdTot->vFCPUFDest = 0;
        $this->stdTot->vICMSUFDest = 0;
        $this->stdTot->vICMSUFRemet = 0;
        $this->stdTot->vBCST = 0;
        $this->stdTot->vST = 0;
        $this->stdTot->vFCPST = 0;
        $this->stdTot->vFCPSTRet = 0;
        $this->stdTot->vProd = 0;
        $this->stdTot->vFrete = 0;
        $this->stdTot->vSeg = 0;
        $this->stdTot->vDesc = 0;
        $this->stdTot->vII = 0;
        $this->stdTot->vIPI = 0;
        $this->stdTot->vIPIDevol = 0;
        // $this->stdTot->vServ = 0;
        $this->stdTot->vPIS = 0;
        $this->stdTot->vCOFINS = 0;
        $this->stdTot->vPISST = 0;
        $this->stdTot->vCOFINSST = 0;
        $this->stdTot->vOutro = 0;
        $this->stdTot->vNF = 0;
        $this->stdTot->vTotTrib = 0;
        $this->stdTot->qBCMono = 0;
        $this->stdTot->vICMSMono = 0;
        $this->stdTot->qBCMonoReten = 0;
        $this->stdTot->vICMSMonoReten = 0;
        $this->stdTot->qBCMonoRet = 0;
        $this->stdTot->vICMSMonoRet = 0;

        $this->stdISSQNTot = new \stdClass();
        $this->stdISSQNTot->vServ = null;
        $this->stdISSQNTot->vBC = null;
        $this->stdISSQNTot->vISS = null;
        $this->stdISSQNTot->vPIS = null;
        $this->stdISSQNTot->vCOFINS = null;
        $this->stdISSQNTot->dCompet = null;
        $this->stdISSQNTot->vDeducao = null;
        $this->stdISSQNTot->vOutro = null;
        $this->stdISSQNTot->vDescIncond = null;
        $this->stdISSQNTot->vDescCond = null;
        $this->stdISSQNTot->vISSRet = null;
        $this->stdISSQNTot->cRegTrib = null;
    }

    /**
     * Set character convertion to ASCII only ou not
     */
    public function setOnlyAscii(bool $option = false)
    {
        $this->replaceAccentedChars = $option;
    }

    /**
     * Set if GTIN is or not validate
     * @param bool $option
     * @return void
     */
    public function setCheckGtin(bool $option = true)
    {
        $this->checkgtin = $option;
    }

    /**
     * Returns xml string and assembly it is necessary
     */
    public function getXML(): string
    {
        if (empty($this->xml)) {
            $this->montaNFe();
        }
        return $this->xml;
    }

    /**
     * Retorns the key number of NFe (44 digits)
     */
    public function getChave(): string
    {
        return $this->chNFe;
    }

    /**
     * Returns the model of NFe 55 or 65
     */
    public function getModelo(): int
    {
        return $this->mod;
    }

    /**
     * Call method of xml assembly. For compatibility only.
     */
    public function montaNFe(): string
    {
        return $this->monta();
    }

    /**
     * NFe xml mount method
     * this function returns TRUE on success or FALSE on error
     * The xml of the NFe must be retrieved by the getXML() function or
     * directly by the public property $xml
     *
     * @throws RuntimeException
     */
    public function monta(): string
    {
        //cria a tag raiz da Nfe
        $this->buildNFe();
        //processa nfeRef e coloca as tags na tag ide
        foreach ($this->aNFref as $nfeRef) {
            $this->dom->appChild($this->ide, $nfeRef, 'Falta tag "ide"');
        }
        //monta as tags det e coloca no array $this->aDet com os detalhes dos produtos
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
        //força a construção do total
        $this->total = $this->dom->createElement("total");
        $this->tagISSQNTot($this->stdISSQN);
        $this->tagICMSTot($this->stdICMSTot);
        $this->dom->appChild($this->total, $this->ICMSTot, 'Falta tag "total"');
        $this->dom->appChild($this->total, $this->ISSQNTot, 'Falta tag "total"');
        if ($this->retTrib) {
            $this->dom->appChild($this->total, $this->retTrib, 'Falta tag "total"');
        }
        //[28a] tag total (326 W01)
        $this->dom->appChild($this->infNFe, $this->total, 'Falta tag "infNFe"');
        //mota a tag vol
        $this->buildVol();
        //[32] tag transp (356 X01)
        $this->dom->appChild($this->infNFe, $this->transp, 'Falta tag "infNFe"');
        //[39a] tag cobr (389 Y01)
        $this->dom->appChild($this->infNFe, $this->cobr, 'Falta tag "infNFe"');
        //[42] tag pag (398a YA01)
        //processa Pag e coloca as tags na tag pag
        $this->buildTagPag();
        //[43] tag infIntermed (398.26 YB01) NT 2020.006_1.00
        $this->dom->appChild($this->infNFe, $this->intermed, 'Falta tag "infNFe"');
        //[44] tag infAdic (399 Z01)
        $this->dom->appChild($this->infNFe, $this->infAdic, 'Falta tag "infNFe"');
        //[48] tag exporta (402 ZA01)
        $this->dom->appChild($this->infNFe, $this->exporta, 'Falta tag "infNFe"');
        //[49] tag compra (405 ZB01)
        $this->dom->appChild($this->infNFe, $this->compra, 'Falta tag "infNFe"');
        //[50] tag cana (409 ZC01)
        $this->dom->appChild($this->infNFe, $this->cana, 'Falta tag "infNFe"');
        //Responsável Técnico
        $this->dom->appChild($this->infNFe, $this->infRespTec, 'Falta tag "infNFe"');
        //agropacuario
        $this->dom->appChild($this->infNFe, $this->agropecuario, 'Falta tag "infNFe"');
        //[1] tag infNFe (1 A01)
        $this->dom->appChild($this->NFe, $this->infNFe, 'Falta tag "NFe"');
        //[0] tag NFe
        $this->dom->appendChild($this->NFe);
        // testa da chave
        $this->checkNFeKey($this->dom);
        $this->xml = $this->dom->saveXML();

        if (count($this->getErrors()) > 0) {
            throw new RuntimeException('Existem erros nas tags. Obtenha os erros com getErrors().');
        }

        return $this->xml;
    }

    /**
     * Informações da NF-e A01 pai NFe
     * tag NFe/infNFe
     */
    public function taginfNFe(stdClass $std): DOMElement
    {
        $possible = ['Id', 'versao', 'pk_nItem'];
        $std = $this->equilizeParameters($std, $possible);
        $chave = preg_replace('/[^0-9]/', '', (string)$std->Id);
        $this->infNFe = $this->dom->createElement("infNFe");
        $this->infNFe->setAttribute("Id", 'NFe' . $chave);
        $this->infNFe->setAttribute(
            "versao",
            $std->versao
        );
        $this->version = $std->versao;
        if (!empty($std->pk_nItem)) {
            $this->infNFe->setAttribute("pk_nItem", $std->pk_nItem);
        }
        $this->chNFe = $chave;
        return $this->infNFe;
    }

    /**
     * Informações de identificação da NF-e B01 pai A01
     * NOTA: Ajustado para NT2020_006_v1.00
     * tag NFe/infNFe/ide
     */
    public function tagide(stdClass $std): DOMElement
    {
        $possible = [
            'cUF',
            'cNF',
            'natOp',
            'indPag',
            'mod',
            'serie',
            'nNF',
            'dhEmi',
            'dhSaiEnt',
            'tpNF',
            'idDest',
            'cMunFG',
            'tpImp',
            'tpEmis',
            'cDV',
            'tpAmb',
            'finNFe',
            'indFinal',
            'indPres',
            'indIntermed',
            'procEmi',
            'verProc',
            'dhCont',
            'xJust'
        ];
        $std = $this->equilizeParameters($std, $possible);

        if (empty($std->cNF)) {
            $std->cNF = Keys::random($std->nNF);
        }
        if (empty($std->cDV)) {
            $std->cDV = 0;
        }
        //validação conforme NT 2019.001
        $std->cNF = str_pad($std->cNF, 8, '0', STR_PAD_LEFT);
        if (intval($std->cNF) == intval($std->nNF)) {
            throw new InvalidArgumentException("O valor [{$std->cNF}] não é "
                . "aceitável para cNF, não pode ser igual ao de nNF, vide NT2019.001");
        }
        if (method_exists(Keys::class, 'cNFIsValid')) {
            if (!Keys::cNFIsValid($std->cNF)) {
                throw new InvalidArgumentException("O valor [{$std->cNF}] para cNF "
                    . "é invalido, deve respeitar a NT2019.001");
            }
        }
        $this->tpAmb = $std->tpAmb;
        $this->mod = $std->mod;
        $identificador = 'B01 <ide> - ';
        $ide = $this->dom->createElement("ide");
        $this->dom->addChild(
            $ide,
            "cUF",
            $std->cUF,
            true,
            $identificador . "Código da UF do emitente do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "cNF",
            $std->cNF,
            true,
            $identificador . "Código Numérico que compõe a Chave de Acesso"
        );
        $this->dom->addChild(
            $ide,
            "natOp",
            substr(trim((string)$std->natOp), 0, 60),
            true,
            $identificador . "Descrição da Natureza da Operação"
        );
        $this->dom->addChild(
            $ide,
            "mod",
            $std->mod,
            true,
            $identificador . "Código do Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "serie",
            $std->serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "nNF",
            $std->nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "dhEmi",
            $std->dhEmi,
            true,
            $identificador . "Data e hora de emissão do Documento Fiscal"
        );
        if ($std->mod == '55' && !empty($std->dhSaiEnt)) {
            $this->dom->addChild(
                $ide,
                "dhSaiEnt",
                $std->dhSaiEnt,
                false,
                $identificador . "Data e hora de Saída ou da Entrada da Mercadoria/Produto"
            );
        }
        $this->dom->addChild(
            $ide,
            "tpNF",
            $std->tpNF,
            true,
            $identificador . "Tipo de Operação"
        );
        $this->dom->addChild(
            $ide,
            "idDest",
            $std->idDest,
            true,
            $identificador . "Identificador de local de destino da operação"
        );
        $this->dom->addChild(
            $ide,
            "cMunFG",
            $std->cMunFG,
            true,
            $identificador . "Código do Município de Ocorrência do Fato Gerador"
        );
        $this->dom->addChild(
            $ide,
            "tpImp",
            $std->tpImp,
            true,
            $identificador . "Formato de Impressão do DANFE"
        );
        $this->dom->addChild(
            $ide,
            "tpEmis",
            $std->tpEmis,
            true,
            $identificador . "Tipo de Emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "cDV",
            !empty($std->cDV) ? $std->cDV : '0',
            true,
            $identificador . "Dígito Verificador da Chave de Acesso da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "tpAmb",
            $std->tpAmb,
            true,
            $identificador . "Identificação do Ambiente"
        );
        $this->dom->addChild(
            $ide,
            "finNFe",
            $std->finNFe,
            true,
            $identificador . "Finalidade de emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "indFinal",
            $std->indFinal,
            true,
            $identificador . "Indica operação com Consumidor final"
        );
        $this->dom->addChild(
            $ide,
            "indPres",
            $std->indPres,
            true,
            $identificador . "Indicador de presença do comprador no estabelecimento comercial no momento da operação"
        );
        $this->dom->addChild(
            $ide,
            "indIntermed",
            $std->indIntermed ?? null,
            false,
            $identificador . "Indicador de intermediador/marketplace"
        );
        $this->dom->addChild(
            $ide,
            "procEmi",
            $std->procEmi,
            true,
            $identificador . "Processo de emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "verProc",
            $std->verProc,
            true,
            $identificador . "Versão do Processo de emissão da NF-e"
        );
        if (!empty($std->dhCont) && !empty($std->xJust)) {
            $this->dom->addChild(
                $ide,
                "dhCont",
                $std->dhCont,
                true,
                $identificador . "Data e Hora da entrada em contingência"
            );
            $this->dom->addChild(
                $ide,
                "xJust",
                substr(trim($std->xJust ?? ''), 0, 256),
                true,
                $identificador . "Justificativa da entrada em contingência"
            );
        }
        $this->ide = $ide;
        return $ide;
    }

    /**
     * Chave de acesso da NF-e referenciada BA02 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFe
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagrefNFe(stdClass $std): DOMElement
    {
        $possible = ['refNFe', 'refNFeSig'];
        $std = $this->equilizeParameters($std, $possible);
        if (empty($std->refNFe) && empty($std->refNFeSig)) {
            return $this->dom->createElement("refNFe", '');
        }
        $num = $this->buildNFref();
        if (!empty($std->refNFe)) {
            $refNFe = $this->dom->createElement("refNFe", $std->refNFe);
            $this->dom->appChild($this->aNFref[$num - 1], $refNFe);
        } else {
            $refNFe = $this->dom->createElement("refNFeSig", $std->refNFeSig);
            $this->dom->appChild($this->aNFref[$num - 1], $refNFe);
        }
        return $refNFe;
    }

    /**
     * Informação da NF modelo 1/1A referenciada BA03 pai BA01
     * tag NFe/infNFe/ide/NFref/NF DOMNode
     */
    public function tagrefNF(stdClass $std): DOMElement
    {
        $possible = ['cUF', 'AAMM', 'CNPJ', 'mod', 'serie', 'nNF'];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'BA03 <refNF> - ';
        $num = $this->buildNFref();
        $refNF = $this->dom->createElement("refNF");
        $this->dom->addChild(
            $refNF,
            "cUF",
            $std->cUF,
            true,
            $identificador . "Código da UF do emitente"
        );
        $this->dom->addChild(
            $refNF,
            "AAMM",
            $std->AAMM,
            true,
            $identificador . "Ano e Mês de emissão da NF-e"
        );
        $this->dom->addChild(
            $refNF,
            "CNPJ",
            $std->CNPJ,
            true,
            $identificador . "CNPJ do emitente"
        );
        $this->dom->addChild(
            $refNF,
            "mod",
            $std->mod,
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNF,
            "serie",
            $std->serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNF,
            "nNF",
            $std->nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->appChild($this->aNFref[$num - 1], $refNF);
        return $refNF;
    }

    /**
     * Informações da NF de produtor rural referenciada BA10 pai BA01
     * tag NFe/infNFe/ide/NFref/refNFP
     */
    public function tagrefNFP(stdClass $std): DOMElement
    {
        $possible = [
            'cUF',
            'AAMM',
            'CNPJ',
            'CPF',
            'IE',
            'mod',
            'serie',
            'nNF'
        ];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'BA10 <refNFP> - ';
        $num = $this->buildNFref();
        $refNFP = $this->dom->createElement("refNFP");
        $this->dom->addChild(
            $refNFP,
            "cUF",
            $std->cUF,
            true,
            $identificador . "Código da UF do emitente"
        );
        $this->dom->addChild(
            $refNFP,
            "AAMM",
            $std->AAMM,
            true,
            $identificador . "AAMM da emissão da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "CNPJ",
            $std->CNPJ,
            false,
            $identificador . "Informar o CNPJ do emitente da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "CPF",
            $std->CPF,
            false,
            $identificador . "Informar o CPF do emitente da NF de produtor"
        );
        $this->dom->addChild(
            $refNFP,
            "IE",
            $std->IE,
            true,
            $identificador . "Informar a IE do emitente da NF de Produtor ou o literal 'ISENTO'"
        );
        $this->dom->addChild(
            $refNFP,
            "mod",
            str_pad($std->mod, 2, '0', STR_PAD_LEFT),
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNFP,
            "serie",
            $std->serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $refNFP,
            "nNF",
            $std->nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->appChild($this->aNFref[$num - 1], $refNFP);
        return $refNFP;
    }

    /**
     * Chave de acesso do CT-e referenciada BA19 pai BA01
     * tag NFe/infNFe/ide/NFref/refCTe
     */
    public function tagrefCTe(stdClass $std): DOMElement
    {
        $possible = ['refCTe'];
        $std = $this->equilizeParameters($std, $possible);

        $num = $this->buildNFref();
        $refCTe = $this->dom->createElement("refCTe", $std->refCTe);
        $this->dom->appChild($this->aNFref[$num - 1], $refCTe);
        return $refCTe;
    }

    /**
     * Informações do Cupom Fiscal referenciado BA20 pai BA01
     * tag NFe/infNFe/ide/NFref/refECF
     */
    public function tagrefECF(stdClass $std): DOMElement
    {
        $possible = ['mod', 'nECF', 'nCOO'];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'BA20 <refECF> - ';
        $num = $this->buildNFref();
        $refECF = $this->dom->createElement("refECF");
        $this->dom->addChild(
            $refECF,
            "mod",
            $std->mod,
            true,
            $identificador . "Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $refECF,
            "nECF",
            str_pad($std->nECF, 3, '0', STR_PAD_LEFT),
            true,
            $identificador . "Número de ordem sequencial do ECF"
        );
        $this->dom->addChild(
            $refECF,
            "nCOO",
            str_pad($std->nCOO, 6, '0', STR_PAD_LEFT),
            true,
            $identificador . "Número do Contador de Ordem de Operação - COO"
        );
        $this->dom->appChild($this->aNFref[$num - 1], $refECF);
        return $refECF;
    }

    /**
     * Identificação do emitente da NF-e C01 pai A01
     * tag NFe/infNFe/emit
     */
    public function tagemit(stdClass $std): DOMElement
    {
        $possible = [
            'xNome',
            'xFant',
            'IE',
            'IEST',
            'IM',
            'CNAE',
            'CRT',
            'CNPJ',
            'CPF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'C01 <emit> - ';
        $this->emit = $this->dom->createElement("emit");
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $this->emit,
                "CNPJ",
                Strings::onlyNumbers($std->CNPJ),
                false,
                $identificador . "CNPJ do emitente"
            );
        } elseif (!empty($std->CPF)) {
            $this->dom->addChild(
                $this->emit,
                "CPF",
                Strings::onlyNumbers($std->CPF),
                false,
                $identificador . "CPF do remetente"
            );
        }
        $this->dom->addChild(
            $this->emit,
            "xNome",
            substr(trim($std->xNome ?? ''), 0, 60),
            true,
            $identificador . "Razão Social ou Nome do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "xFant",
            isset($std->xFant) ? substr(trim($std->xFant), 0, 60) : null,
            false,
            $identificador . "Nome fantasia do emitente"
        );
        if ($std->IE !== 'ISENTO') {
            $std->IE = Strings::onlyNumbers($std->IE);
        }
        $this->dom->addChild(
            $this->emit,
            "IE",
            $std->IE,
            true,
            $identificador . "Inscrição Estadual do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IEST",
            Strings::onlyNumbers($std->IEST),
            false,
            $identificador . "IE do Substituto Tributário do emitente"
        );
        $this->dom->addChild(
            $this->emit,
            "IM",
            Strings::onlyNumbers($std->IM),
            false,
            $identificador . "Inscrição Municipal do Prestador de Serviço do emitente"
        );
        if (!empty($std->IM) && !empty($std->CNAE)) {
            $this->dom->addChild(
                $this->emit,
                "CNAE",
                Strings::onlyNumbers($std->CNAE),
                false,
                $identificador . "CNAE fiscal do emitente"
            );
        }
        $this->dom->addChild(
            $this->emit,
            "CRT",
            $std->CRT,
            true,
            $identificador . "Código de Regime Tributário do emitente"
        );
        return $this->emit;
    }

    /**
     * Endereço do emitente C05 pai C01
     * tag NFe/infNFe/emit/endEmit
     */
    public function tagenderEmit(stdClass $std): DOMElement
    {
        $possible = [
            'xLgr',
            'nro',
            'xCpl',
            'xBairro',
            'cMun',
            'xMun',
            'UF',
            'CEP',
            'cPais',
            'xPais',
            'fone'
        ];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'C05 <enderEmit> - ';
        $this->enderEmit = $this->dom->createElement("enderEmit");
        $this->dom->addChild(
            $this->enderEmit,
            "xLgr",
            substr(trim($std->xLgr ?? ''), 0, 60),
            true,
            $identificador . "Logradouro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "nro",
            substr(trim($std->nro ?? ''), 0, 60),
            true,
            $identificador . "Número do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xCpl",
            isset($std->xCpl) ? substr(trim($std->xCpl), 0, 60) : null,
            false,
            $identificador . "Complemento do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xBairro",
            substr(trim($std->xBairro ?? ''), 0, 60),
            true,
            $identificador . "Bairro do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cMun",
            Strings::onlyNumbers($std->cMun),
            true,
            $identificador . "Código do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xMun",
            substr(trim($std->xMun ?? ''), 0, 60),
            true,
            $identificador . "Nome do município do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "UF",
            strtoupper(trim($std->UF ?? '')),
            true,
            $identificador . "Sigla da UF do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "CEP",
            Strings::onlyNumbers($std->CEP),
            true,
            $identificador . "Código do CEP do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "cPais",
            Strings::onlyNumbers($std->cPais),
            false,
            $identificador . "Código do País do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "xPais",
            isset($std->xPais) ? substr(trim($std->xPais), 0, 60) : null,
            false,
            $identificador . "Nome do País do Endereço do emitente"
        );
        $this->dom->addChild(
            $this->enderEmit,
            "fone",
            isset($std->fone) ? trim($std->fone) : null,
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
     */
    public function tagdest(stdClass $std): DOMElement
    {
        $possible = [
            'xNome',
            'indIEDest',
            'IE',
            'ISUF',
            'IM',
            'email',
            'CNPJ',
            'CPF',
            'idEstrangeiro'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'E01 <dest> - ';
        $flagNome = true; //marca se xNome é ou não obrigatório
        $temIE = !empty($std->IE) && $std->IE !== 'ISENTO'; // Tem inscrição municipal
        $this->dest = $this->dom->createElement("dest");
        if (!$temIE && $std->indIEDest == 1) {
            $std->indIEDest = 2;
        }
        if ($this->mod == '65') {
            $std->indIEDest = '9';
            if (empty($std->xNome)) {
                $flagNome = false; //marca se xNome é ou não obrigatório
            }
        }
        $xNome = $std->xNome ?? null;
        if ($this->tpAmb == '2' && !empty($xNome)) {
            $xNome = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
            //a exigência do CNPJ 99999999000191 não existe mais
        } elseif ($this->tpAmb == '2' && $this->mod == '65') {
            $xNome = 'NF-E EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $this->dest,
                "CNPJ",
                Strings::onlyNumbers($std->CNPJ),
                true,
                $identificador . "CNPJ do destinatário"
            );
        } elseif (!empty($std->CPF)) {
            $this->dom->addChild(
                $this->dest,
                "CPF",
                Strings::onlyNumbers($std->CPF),
                true,
                $identificador . "CPF do destinatário"
            );
        } elseif ($std->idEstrangeiro !== null) {
            $this->dom->addChild(
                $this->dest,
                "idEstrangeiro",
                $std->idEstrangeiro,
                true,
                $identificador . "Identificação do destinatário no caso de comprador estrangeiro",
                true
            );
            $std->indIEDest = '9';
        }
        $this->dom->addChild(
            $this->dest,
            "xNome",
            isset($xNome) ? substr(trim($xNome), 0, 60) : null,
            $flagNome, //se mod 55 true ou mod 65 false
            $identificador . "Razão Social ou nome do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "indIEDest",
            Strings::onlyNumbers($std->indIEDest),
            true,
            $identificador . "Indicador da IE do Destinatário"
        );
        if ($temIE) {
            $this->dom->addChild(
                $this->dest,
                "IE",
                $std->IE,
                true,
                $identificador . "Inscrição Estadual do Destinatário"
            );
        }
        $this->dom->addChild(
            $this->dest,
            "ISUF",
            Strings::onlyNumbers($std->ISUF),
            false,
            $identificador . "Inscrição na SUFRAMA do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "IM",
            Strings::onlyNumbers($std->IM),
            false,
            $identificador . "Inscrição Municipal do Tomador do Serviço do destinatário"
        );
        $this->dom->addChild(
            $this->dest,
            "email",
            isset($std->email) ? substr(trim($std->email), 0, 60) : null,
            false,
            $identificador . "Email do destinatário"
        );
        return $this->dest;
    }

    /**
     * Endereço do Destinatário da NF-e E05 pai E01
     * tag NFe/infNFe/dest/enderDest  (opcional para modelo 65)
     * Os dados do destinatário devem ser inseridos antes deste método
     */
    public function tagenderDest(stdClass $std): DOMElement
    {
        $possible = [
            'xLgr',
            'nro',
            'xCpl',
            'xBairro',
            'cMun',
            'xMun',
            'UF',
            'CEP',
            'cPais',
            'xPais',
            'fone'
        ];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'E05 <enderDest> - ';
        if (!$this->dest) {
            throw new RuntimeException('A TAG dest deve ser criada antes do endereço do mesmo.');
        }
        $this->enderDest = $this->dom->createElement("enderDest");
        $this->dom->addChild(
            $this->enderDest,
            "xLgr",
            $std->xLgr,
            true,
            $identificador . "Logradouro do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "nro",
            $std->nro,
            true,
            $identificador . "Número do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xCpl",
            $std->xCpl,
            false,
            $identificador . "Complemento do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xBairro",
            $std->xBairro,
            true,
            $identificador . "Bairro do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "cMun",
            $std->cMun,
            true,
            $identificador . "Código do município do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xMun",
            $std->xMun,
            true,
            $identificador . "Nome do município do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "UF",
            $std->UF,
            true,
            $identificador . "Sigla da UF do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "CEP",
            $std->CEP,
            false,
            $identificador . "Código do CEP do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "cPais",
            $std->cPais,
            false,
            $identificador . "Código do País do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "xPais",
            $std->xPais,
            false,
            $identificador . "Nome do País do Endereço do Destinatário"
        );
        $this->dom->addChild(
            $this->enderDest,
            "fone",
            $std->fone,
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
     * NOTA: ajustado para NT 2018.005
     */
    public function tagretirada(stdClass $std): DOMElement
    {
        $possible = [
            'xLgr',
            'nro',
            'xCpl',
            'xBairro',
            'cMun',
            'xMun',
            'UF',
            'CNPJ',
            'CPF',
            'xNome',
            'CEP',
            'cPais',
            'xPais',
            'fone',
            'email',
            'IE'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'F01 <retirada> - ';
        $this->retirada = $this->dom->createElement("retirada");
        if (empty($std->CPF)) {
            $this->dom->addChild(
                $this->retirada,
                "CNPJ",
                $std->CNPJ ?? '',
                true,
                $identificador . "CNPJ do Cliente da Retirada",
                true
            );
        } else {
            $this->dom->addChild(
                $this->retirada,
                "CPF",
                $std->CPF,
                false,
                $identificador . "CPF do Cliente da Retirada"
            );
        }
        $this->dom->addChild(
            $this->retirada,
            "xNome",
            $std->xNome,
            false,
            $identificador . "Nome do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xLgr",
            $std->xLgr,
            true,
            $identificador . "Logradouro do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "nro",
            $std->nro,
            true,
            $identificador . "Número do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xCpl",
            $std->xCpl,
            false,
            $identificador . "Complemento do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xBairro",
            $std->xBairro,
            true,
            $identificador . "Bairro do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "cMun",
            $std->cMun,
            true,
            $identificador . "Código do município do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xMun",
            $std->xMun,
            true,
            $identificador . "Nome do município do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "UF",
            $std->UF,
            true,
            $identificador . "Sigla da UF do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "CEP",
            $std->CEP,
            false,
            $identificador . "CEP do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "cPais",
            $std->cPais,
            false,
            $identificador . "Codigo do Pais do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "xPais",
            $std->xPais,
            false,
            $identificador . "Pais do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "fone",
            $std->fone,
            false,
            $identificador . "Fone do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "email",
            $std->email,
            false,
            $identificador . "Email do Endereco do Cliente da Retirada"
        );
        $this->dom->addChild(
            $this->retirada,
            "IE",
            $std->IE,
            false,
            $identificador . "IE do Cliente da Retirada"
        );
        return $this->retirada;
    }

    /**
     * Identificação do Local de entrega G01 pai A01
     * tag NFe/infNFe/entrega (opcional)
     * NOTA: ajustado para NT 2018.005
     */
    public function tagentrega(stdClass $std): DOMElement
    {
        $possible = [
            'xLgr',
            'nro',
            'xCpl',
            'xBairro',
            'cMun',
            'xMun',
            'UF',
            'CNPJ',
            'CPF',
            'xNome',
            'CEP',
            'cPais',
            'xPais',
            'fone',
            'email',
            'IE'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'G01 <entrega> - ';
        $this->entrega = $this->dom->createElement("entrega");
        if (empty($std->CPF)) {
            $this->dom->addChild(
                $this->entrega,
                "CNPJ",
                $std->CNPJ ?? '',
                true,
                $identificador . "CNPJ do Cliente da Entrega",
                true
            );
        } else {
            $this->dom->addChild(
                $this->entrega,
                "CPF",
                $std->CPF,
                false,
                $identificador . "CPF do Cliente da Entrega"
            );
        }
        $this->dom->addChild(
            $this->entrega,
            "xNome",
            $std->xNome,
            false,
            $identificador . "Nome do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xLgr",
            $std->xLgr,
            true,
            $identificador . "Logradouro do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "nro",
            $std->nro,
            true,
            $identificador . "Número do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xCpl",
            $std->xCpl,
            false,
            $identificador . "Complemento do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xBairro",
            $std->xBairro,
            true,
            $identificador . "Bairro do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "cMun",
            $std->cMun,
            true,
            $identificador . "Código do município do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xMun",
            $std->xMun,
            true,
            $identificador . "Nome do município do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "UF",
            $std->UF,
            true,
            $identificador . "Sigla da UF do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "CEP",
            $std->CEP,
            false,
            $identificador . "CEP do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "cPais",
            $std->cPais,
            false,
            $identificador . "Codigo do Pais do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "xPais",
            $std->xPais,
            false,
            $identificador . "Pais do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "fone",
            $std->fone,
            false,
            $identificador . "Fone do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "email",
            $std->email,
            false,
            $identificador . "Email do Endereco do Cliente da Entrega"
        );
        $this->dom->addChild(
            $this->entrega,
            "IE",
            $std->IE,
            false,
            $identificador . "IE do Cliente da Entrega"
        );
        return $this->entrega;
    }

    /**
     * Pessoas autorizadas para o download do XML da NF-e G50 pai A01
     * tag NFe/infNFe/autXML
     */
    public function tagautXML(stdClass $std): DOMElement
    {
        $possible = ['CNPJ', 'CPF'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'G50 <autXML> - ';
        $std->CNPJ = !empty($std->CNPJ) ? $std->CNPJ : null;
        $std->CPF = !empty($std->CPF) ? $std->CPF : null;
        $autXML = $this->dom->createElement("autXML");
        $this->dom->addChild(
            $autXML,
            "CNPJ",
            $std->CNPJ,
            false,
            $identificador . "CNPJ do Cliente Autorizado"
        );
        $this->dom->addChild(
            $autXML,
            "CPF",
            $std->CPF,
            false,
            $identificador . "CPF do Cliente Autorizado"
        );
        $this->aAutXML[] = $autXML;
        return $autXML;
    }

    /**
     * Informações adicionais do produto V01 pai H01
     * tag NFe/infNFe/det[]/infAdProd
     */
    public function taginfAdProd(stdClass $std): DOMElement
    {
        $possible = ['item', 'infAdProd'];
        $std = $this->equilizeParameters($std, $possible);
        $infAdProd = $this->dom->createElement(
            "infAdProd",
            substr(trim($std->infAdProd ?? ''), 0, 500)
        );
        $this->aInfAdProd[$std->item] = $infAdProd;
        return $infAdProd;
    }

    /**
     * Detalhamento do crédito presumido do item da NFe
     * Grupo opcional para informações do Crédito Presumido. Obs.: A exigência do preenchimento das informações
     * do crédito presumido fica a critério de cada UF
     * tag NFe/infNFe/det[]/prod/[cCredPresumido, pCredPresumido, vCredPresumido]
     * NT 2019.001 v1.62
     * @param stdClass $std
     * @return DOMElement
     */
    public function tagCreditoPresumidoProd(stdClass $std)
    {
        $possible  = ['item', 'cCredPresumido', 'pCredPresumido', 'vCredPresumido'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I05g <gCred> - ';
        $gcred = $this->dom->createElement("gCred");
        $this->dom->addChild(
            $gcred,
            "cCredPresumido",
            $std->cCredPresumido,
            true,
            $identificador . "[item $std->item] cCredPresumido Código de Benefício Fiscal de Crédito "
                . "Presumido na UF aplicado ao item",
            true
        );
        $this->dom->addChild(
            $gcred,
            "pCredPresumido",
            $this->conditionalNumberFormatting($std->pCredPresumido, 4),
            true,
            $identificador . "[item $std->item] pCredPresumido Percentual do Crédito Presumido",
            true
        );
        $this->dom->addChild(
            $gcred,
            "vCredPresumido",
            $this->conditionalNumberFormatting($std->vCredPresumido, 2),
            true,
            $identificador . "[item $std->item] vCredPresumido Valor do Crédito Presumido",
            true
        );
        $this->aProdCreditoPresumido[$std->item][] = $gcred;
        return $gcred;
    }

    /**
     * Detalhamento de Produtos e Serviços I01 pai H01
     * tag NFe/infNFe/det[]/prod
     * NOTA: Ajustado para NT2016_002_v1.30
     * NOTA: Ajustado para NT2020_005_v1.20
     */
    public function tagprod(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'cProd',
            'cEAN',
            'cBarra',
            'xProd',
            'NCM',
            'cBenef',
            'EXTIPI',
            'CFOP',
            'uCom',
            'qCom',
            'vUnCom',
            'vProd',
            'cEANTrib',
            'cBarraTrib',
            'uTrib',
            'qTrib',
            'vUnTrib',
            'vFrete',
            'vSeg',
            'vDesc',
            'vOutro',
            'indTot',
            'xPed',
            'nItemPed',
            'nFCI'
        ];
        $std = $this->equilizeParameters($std, $possible);
        //totalizador
        if ($std->indTot == 1) {
            $this->stdTot->vProd += (float) $this->conditionalNumberFormatting($std->vProd);
        }
        $this->stdTot->vFrete += (float) $this->conditionalNumberFormatting($std->vFrete);
        $this->stdTot->vSeg += (float) $this->conditionalNumberFormatting($std->vSeg);
        $this->stdTot->vDesc += (float) $this->conditionalNumberFormatting($std->vDesc);
        $this->stdTot->vOutro += (float) $this->conditionalNumberFormatting($std->vOutro);

        $cean = !empty($std->cEAN) ? trim(strtoupper($std->cEAN)) : '';
        $ceantrib = !empty($std->cEANTrib) ? trim(strtoupper($std->cEANTrib)) : '';
        //throw exception if not is Valid
        if ($this->checkgtin) {
            try {
                Gtin::isValid($cean);
            } catch (\InvalidArgumentException $e) {
                $this->errors[] = "cEANT {$cean} " . $e->getMessage();
            }

            try {
                Gtin::isValid($ceantrib);
            } catch (\InvalidArgumentException $e) {
                $this->errors[] = "cEANTrib {$ceantrib} " . $e->getMessage();
            }
        }

        /*
        $CRT = null;
        if (!empty($this->emit->getElementsByTagName("CRT")->item(0))) {
             $CRT = (int) $this->emit->getElementsByTagName("CRT")->item(0)->nodeValue;
        }

        $idDest = null;
        if (!empty($this->ide->getElementsByTagName("idDest")->item(0))) {
            $idDest = (int) $this->ide->getElementsByTagName("idDest")->item(0)->nodeValue;
        }

        $allowEmptyNcm = $CRT == 4 && $idDest == 1;

        if ($allowEmptyNcm && empty($std->NCM)) {
            $std->NCM = '00000000';
        }
        */
        $identificador = 'I01 <prod> - ';
        $prod = $this->dom->createElement("prod");
        $this->dom->addChild(
            $prod,
            "cProd",
            $std->cProd,
            true,
            $identificador . "[item $std->item] Código do produto ou serviço"
        );
        $this->dom->addChild(
            $prod,
            "cEAN",
            $cean,
            true,
            $identificador . "[item $std->item] GTIN (Global Trade Item Number) do produto, antigo "
                . "código EAN ou código de barras",
            true
        );
        $this->dom->addChild(
            $prod,
            "cBarra",
            $std->cBarra ?? null,
            false,
            $identificador . "[item $std->item] cBarra Código de barras diferente do padrão GTIN"
        );
        $xProd = $std->xProd;
        if ($this->tpAmb == '2' && $this->mod == '65' && $std->item === 1) {
            $xProd = 'NOTA FISCAL EMITIDA EM AMBIENTE DE HOMOLOGACAO - SEM VALOR FISCAL';
        }
        $this->dom->addChild(
            $prod,
            "xProd",
            $xProd,
            true,
            $identificador . "[item $std->item] Descrição do produto ou serviço"
        );
        $this->dom->addChild(
            $prod,
            "NCM",
            $std->NCM,
            true,
            $identificador . "[item $std->item] Código NCM com 8 dígitos ou 2 dígitos (gênero)"
        );
        //incluido no layout 4.00
        $this->dom->addChild(
            $prod,
            "cBenef",
            $std->cBenef,
            false,
            $identificador . "[item $std->item] Código de Benefício Fiscal utilizado pela UF"
        );
        $this->dom->addChild(
            $prod,
            "EXTIPI",
            $std->EXTIPI,
            false,
            $identificador . "[item $std->item] Preencher de acordo com o código EX da TIPI"
        );
        $this->dom->addChild(
            $prod,
            "CFOP",
            $std->CFOP,
            true,
            $identificador . "[item $std->item] Código Fiscal de Operações e Prestações"
        );
        $this->dom->addChild(
            $prod,
            "uCom",
            $std->uCom,
            true,
            $identificador . "[item $std->item] Unidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "qCom",
            $this->conditionalNumberFormatting($std->qCom, 4),
            true,
            $identificador . "[item $std->item] Quantidade Comercial do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnCom",
            $this->conditionalNumberFormatting($std->vUnCom, 10),
            true,
            $identificador . "[item $std->item] Valor Unitário de Comercialização do produto"
        );
        $this->dom->addChild(
            $prod,
            "vProd",
            $this->conditionalNumberFormatting($std->vProd),
            true,
            $identificador . "[item $std->item] Valor Total Bruto dos Produtos ou Serviços"
        );
        $this->dom->addChild(
            $prod,
            "cEANTrib",
            $ceantrib,
            true,
            $identificador . "[item $std->item] GTIN (Global Trade Item Number) da unidade tributável, antigo "
                . "código EAN ou código de barras",
            true
        );
        $this->dom->addChild(
            $prod,
            "cBarraTrib",
            $std->cBarraTrib ?? null,
            false,
            $identificador . "[item $std->item] cBarraTrib Código de Barras da "
                . "unidade tributável que seja diferente do padrão GTIN"
        );
        $this->dom->addChild(
            $prod,
            "uTrib",
            $std->uTrib,
            true,
            $identificador . "[item $std->item] Unidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "qTrib",
            $this->conditionalNumberFormatting($std->qTrib, 4),
            true,
            $identificador . "[item $std->item] Quantidade Tributável do produto"
        );
        $this->dom->addChild(
            $prod,
            "vUnTrib",
            $this->conditionalNumberFormatting($std->vUnTrib, 10),
            true,
            $identificador . "[item $std->item] Valor Unitário de tributação do produto"
        );
        $this->dom->addChild(
            $prod,
            "vFrete",
            $this->conditionalNumberFormatting($std->vFrete),
            false,
            $identificador . "[item $std->item] Valor Total do Frete"
        );
        $this->dom->addChild(
            $prod,
            "vSeg",
            $this->conditionalNumberFormatting($std->vSeg),
            false,
            $identificador . "[item $std->item] Valor Total do Seguro"
        );
        $this->dom->addChild(
            $prod,
            "vDesc",
            $this->conditionalNumberFormatting($std->vDesc),
            false,
            $identificador . "[item $std->item] Valor do Desconto"
        );
        $this->dom->addChild(
            $prod,
            "vOutro",
            $this->conditionalNumberFormatting($std->vOutro),
            false,
            $identificador . "[item $std->item] Outras despesas acessórias"
        );
        $this->dom->addChild(
            $prod,
            "indTot",
            $std->indTot,
            true,
            $identificador . "[item $std->item] Indica se valor do Item (vProd) entra no valor total da NF-e (vProd)"
        );
        $this->dom->addChild(
            $prod,
            "xPed",
            $std->xPed,
            false,
            $identificador . "[item $std->item] Número do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nItemPed",
            $std->nItemPed,
            false,
            $identificador . "[item $std->item] Item do Pedido de Compra"
        );
        $this->dom->addChild(
            $prod,
            "nFCI",
            $std->nFCI,
            false,
            $identificador . "[item $std->item] Número de controle da FCI "
                . "Ficha de Conteúdo de Importação"
        );
        $this->aProd[$std->item] = $prod;
        return $prod;
    }

    /**
     * Grupo de observações de uso livre (para o item da NF-e)
     * Grupo de observações de uso livre do Contribuinte
     */
    public function tagprodObsCont(stdClass $std): ?DOMElement
    {
        $possible = [
            'item',
            'xCampo',
            'xTexto'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'VA01 <obsItem> - ';
        $obsItem = $this->dom->createElement("obsItem");
        $obsCont = $this->dom->createElement("obsCont");
        $this->dom->addChild(
            $obsCont,
            "xCampo",
            substr(trim($std->xCampo ?? ''), 0, 20),
            true,
            $identificador . "[item $std->item] (obsCont/xCampo) Identificação do campo"
        );
        $this->dom->addChild(
            $obsCont,
            "xTexto",
            substr(trim($std->xTexto ?? ''), 0, 60),
            true,
            $identificador . "[item $std->item] (obsCont/xTexto) Conteúdo do campo"
        );
        $obsItem->appendChild($obsCont);
        $this->obsItem[$std->item] = $obsItem;
        return $obsItem;
    }

    /**
     * NVE NOMENCLATURA DE VALOR ADUANEIRO E ESTATÍSTICA
     * Podem ser até 8 NVE's por item
     *
     */
    public function tagNVE(stdClass $std): ?DOMElement
    {
        $possible = ['item', 'NVE'];
        $std = $this->equilizeParameters($std, $possible);

        if ($std->NVE == '') {
            return null;
        }
        $nve = $this->dom->createElement("NVE", $std->NVE);
        $this->aNVE[$std->item][] = $nve;
        return $nve;
    }

    /**
     * Código Especificador da Substituição Tributária – CEST,
     * que identifica a mercadoria sujeita aos regimes de substituição
     * tributária e de antecipação do recolhimento do imposto.
     * vide NT2015.003  I05C pai
     * tag NFe/infNFe/det[item]/prod/CEST (opcional)
     * NOTA: Ajustado para NT2016_002_v1.30
     */
    public function tagCEST(stdClass $std): DOMElement
    {
        $possible = ['item', 'CEST', 'indEscala', 'CNPJFab'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I05b <ctrltST> - ';
        $ctrltST = $this->dom->createElement("ctrltST");
        $this->dom->addChild(
            $ctrltST,
            "CEST",
            Strings::onlyNumbers($std->CEST),
            true,
            "$identificador [item $std->item] Numero CEST"
        );
        //incluido no layout 4.00
        $this->dom->addChild(
            $ctrltST,
            "indEscala",
            $std->indEscala,
            false,
            "$identificador [item $std->item] Indicador de Produção em escala relevante"
        );
        //incluido no layout 4.00
        $this->dom->addChild(
            $ctrltST,
            "CNPJFab",
            Strings::onlyNumbers($std->CNPJFab),
            false,
            "$identificador [item $std->item] CNPJ do Fabricante da Mercadoria,"
                . "obrigatório para produto em escala NÃO relevante."
        );
        $this->aCest[$std->item][] = $ctrltST;
        return $ctrltST;
    }

    /**
     * tag NFe/infNFe/det[item]/prod/nRECOPI
     */
    public function tagRECOPI(stdClass $std): DOMElement
    {
        $possible = ['item', 'nRECOPI'];
        $std = $this->equilizeParameters($std, $possible);
        $recopi = $this->dom->createElement("nRECOPI", $std->nRECOPI);
        $this->aRECOPI[$std->item] = $recopi;
        return $recopi;
    }

    /**
     * Declaração de Importação I8 pai I01
     * tag NFe/infNFe/det[]/prod/DI
     */
    public function tagDI(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nDI',
            'dDI',
            'xLocDesemb',
            'UFDesemb',
            'dDesemb',
            'tpViaTransp',
            'vAFRMM',
            'tpIntermedio',
            'CNPJ',
            'CPF',
            'UFTerceiro',
            'cExportador'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I8 <DI> - ';
        $tDI = $this->dom->createElement("DI");
        $this->dom->addChild(
            $tDI,
            "nDI",
            $std->nDI,
            true,
            $identificador . "[item $std->item] Número do Documento de Importação (DI, DSI, DIRE, ...)"
        );
        $this->dom->addChild(
            $tDI,
            "dDI",
            $std->dDI,
            true,
            $identificador . "[item $std->item] Data de Registro do documento"
        );
        $this->dom->addChild(
            $tDI,
            "xLocDesemb",
            $std->xLocDesemb,
            true,
            $identificador . "[item $std->item] Local de desembaraço"
        );
        $this->dom->addChild(
            $tDI,
            "UFDesemb",
            $std->UFDesemb,
            true,
            $identificador . "[item $std->item] Sigla da UF onde ocorreu o Desembaraço Aduaneiro"
        );
        $this->dom->addChild(
            $tDI,
            "dDesemb",
            $std->dDesemb,
            true,
            $identificador . "[item $std->item] Data do Desembaraço Aduaneiro"
        );
        $this->dom->addChild(
            $tDI,
            "tpViaTransp",
            $std->tpViaTransp,
            true,
            $identificador . "[item $std->item] Via de transporte internacional "
                . "informada na Declaração de Importação (DI)"
        );
        $this->dom->addChild(
            $tDI,
            "vAFRMM",
            $this->conditionalNumberFormatting($std->vAFRMM),
            false,
            $identificador . "[item $std->item] Valor da AFRMM "
                . "- Adicional ao Frete para Renovação da Marinha Mercante"
        );
        $this->dom->addChild(
            $tDI,
            "tpIntermedio",
            $std->tpIntermedio,
            true,
            $identificador . "[item $std->item] Forma de importação quanto a intermediação"
        );
        if (!empty($std->CNPJ)) {
            $this->dom->addChild(
                $tDI,
                "CNPJ",
                $std->CNPJ,
                false,
                $identificador . "[item $std->item] CNPJ do adquirente ou do encomendante"
            );
        } else {
            $this->dom->addChild(
                $tDI,
                "CPF",
                $std->CPF,
                false,
                $identificador . "[item $std->item] CPF do adquirente ou do encomendante"
            );
        }
        $this->dom->addChild(
            $tDI,
            "UFTerceiro",
            $std->UFTerceiro,
            false,
            $identificador . "[item $std->item] Sigla da UF do adquirente ou do encomendante"
        );
        $this->dom->addChild(
            $tDI,
            "cExportador",
            $std->cExportador,
            true,
            $identificador . "[item $std->item] Código do Exportador"
        );
        $this->aDI[$std->item][$std->nDI] = $tDI;
        return $tDI;
    }

    /**
     * Adições I25 pai I18
     * tag NFe/infNFe/det[]/prod/DI/adi
     */
    public function tagadi(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nDI',
            'nAdicao',
            'nSeqAdic',
            'cFabricante',
            'vDescDI',
            'nDraw'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I25 <adi> - ';
        $adi = $this->dom->createElement("adi");
        $this->dom->addChild(
            $adi,
            "nAdicao",
            $std->nAdicao ?? null,
            false,
            $identificador . "[item $std->item] Número da Adição"
        );
        $this->dom->addChild(
            $adi,
            "nSeqAdic",
            $std->nSeqAdic,
            true,
            $identificador . "[item $std->item] Número sequencial do item dentro da Adição"
        );
        $this->dom->addChild(
            $adi,
            "cFabricante",
            $std->cFabricante,
            true,
            $identificador . "[item $std->item] Código do fabricante estrangeiro"
        );
        $this->dom->addChild(
            $adi,
            "vDescDI",
            $this->conditionalNumberFormatting($std->vDescDI),
            false,
            $identificador . "[item $std->item] Valor do desconto do item da DI Adição"
        );
        $this->dom->addChild(
            $adi,
            "nDraw",
            $std->nDraw,
            false,
            $identificador . "[item $std->item] Número do ato concessório de Drawback"
        );
        $this->aAdi[$std->item][$std->nDI][] = $adi;
        //colocar a adi em seu DI respectivo
        $nodeDI = $this->aDI[$std->item][$std->nDI];
        $this->dom->appChild($nodeDI, $adi);
        $this->aDI[$std->item][$std->nDI] = $nodeDI;
        return $adi;
    }

    /**
     * Grupo de informações de exportação para o item I50 pai I01
     * tag NFe/infNFe/det[]/prod/detExport
     */
    public function tagdetExport(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nDraw'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I50 <detExport> - ';
        $detExport = $this->dom->createElement("detExport");
        $this->dom->addChild(
            $detExport,
            "nDraw",
            Strings::onlyNumbers($std->nDraw),
            false,
            $identificador . "[item $std->item] Número do ato concessório de Drawback"
        );
        $this->aDetExport[$std->item][] = $detExport;
        return $detExport;
    }

    /**
     * Grupo de informações de exportação para o item I52 pai I52
     * tag NFe/infNFe/det[]/prod/detExport
     */
    public function tagdetExportInd(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nRE',
            'chNFe',
            'qExport'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I52 <exportInd> - ';
        $exportInd = $this->dom->createElement("exportInd");
        $this->dom->addChild(
            $exportInd,
            "nRE",
            Strings::onlyNumbers($std->nRE),
            true,
            $identificador . "[item $std->item] Número do Registro de Exportação"
        );
        $this->dom->addChild(
            $exportInd,
            "chNFe",
            Strings::onlyNumbers($std->chNFe),
            true,
            $identificador . "[item $std->item] Chave de Acesso da NF-e recebida para exportação"
        );
        $this->dom->addChild(
            $exportInd,
            "qExport",
            $this->conditionalNumberFormatting($std->qExport, 4),
            true,
            $identificador . "[item $std->item] Quantidade do item realmente exportado"
        );
        //obtem o ultimo detExport
        $nDE = (is_countable($this->aDetExport[$std->item]) ? count($this->aDetExport[$std->item]) : 0) - 1;
        if ($nDE < 0) {
            throw new RuntimeException('A TAG detExportInd deve ser criada depois da detExport, pois pertence a ela.');
        }
        //colocar a exportInd em seu DetExport respectivo
        $nodeDetExport = $this->aDetExport[$std->item][$nDE];
        $this->dom->appChild($nodeDetExport, $exportInd);
        $this->aDetExport[$std->item][$nDE] = $nodeDetExport;
        return $exportInd;
    }

    /**
     * Rastreabilidade do produto podem ser até 500 por item TAG I80 pai I01
     * NOTA: Ajustado para NT2016_002_v1.00
     * tag NFe/infNFe/det[]/prod/rastro
     */
    public function tagRastro(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nLote',
            'qLote',
            'dFab',
            'dVal',
            'cAgreg'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'I80 <rastro> - ';
        $rastro = $this->dom->createElement("rastro");
        $this->dom->addChild(
            $rastro,
            "nLote",
            substr(trim($std->nLote ?? ''), 0, 20),
            true,
            $identificador . "[item $std->item] Número do lote"
        );
        $this->dom->addChild(
            $rastro,
            "qLote",
            $this->conditionalNumberFormatting($std->qLote, 3),
            true,
            $identificador . "[item $std->item] Quantidade do lote"
        );
        $this->dom->addChild(
            $rastro,
            "dFab",
            $std->dFab,
            true,
            $identificador . "[item $std->item] Data de fabricação"
        );
        $this->dom->addChild(
            $rastro,
            "dVal",
            $std->dVal,
            true,
            $identificador . "[item $std->item] Data da validade"
        );
        $this->dom->addChild(
            $rastro,
            "cAgreg",
            $std->cAgreg,
            false,
            $identificador . "[item $std->item] Código de Agregação"
        );
        $this->aRastro[$std->item][] = $rastro;
        return $rastro;
    }

    /**
     * Detalhamento de Veículos novos J01 pai I90
     * tag NFe/infNFe/det[]/prod/veicProd (opcional)
     */
    public function tagveicProd(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'tpOp',
            'chassi',
            'cCor',
            'xCor',
            'pot',
            'cilin',
            'pesoL',
            'pesoB',
            'nSerie',
            'tpComb',
            'nMotor',
            'CMT',
            'dist',
            'anoMod',
            'anoFab',
            'tpPint',
            'tpVeic',
            'espVeic',
            'VIN',
            'condVeic',
            'cMod',
            'cCorDENATRAN',
            'lota',
            'tpRest'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'J01 <veicProd> - ';
        $veicProd = $this->dom->createElement("veicProd");
        $this->dom->addChild(
            $veicProd,
            "tpOp",
            $std->tpOp,
            true,
            "$identificador [item $std->item] Tipo da operação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "chassi",
            $std->chassi,
            true,
            "$identificador [item $std->item] Chassi do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cCor",
            $std->cCor,
            true,
            "$identificador [item $std->item] Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "xCor",
            $std->xCor,
            true,
            "$identificador [item $std->item] Descrição da Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pot",
            $std->pot,
            true,
            "$identificador [item $std->item] Potência Motor (CV) do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cilin",
            $std->cilin,
            true,
            "$identificador [item $std->item] Cilindradas do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pesoL",
            $std->pesoL,
            true,
            "$identificador [item $std->item] Peso Líquido do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "pesoB",
            $std->pesoB,
            true,
            "$identificador [item $std->item] Peso Bruto do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "nSerie",
            $std->nSerie,
            true,
            "$identificador [item $std->item] Serial (série) do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpComb",
            $std->tpComb,
            true,
            "$identificador [item $std->item] Tipo de combustível do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "nMotor",
            $std->nMotor,
            true,
            "$identificador [item $std->item] Número de Motor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "CMT",
            $this->conditionalNumberFormatting($std->CMT, 4),
            true,
            "$identificador [item $std->item] Capacidade Máxima de Tração do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "dist",
            $std->dist,
            true,
            "$identificador [item $std->item] Distância entre eixos do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "anoMod",
            $std->anoMod,
            true,
            "$identificador [item $std->item] Ano Modelo de Fabricação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "anoFab",
            $std->anoFab,
            true,
            "$identificador [item $std->item] Ano de Fabricação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpPint",
            $std->tpPint,
            true,
            "$identificador [item $std->item] Tipo de Pintura do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpVeic",
            $std->tpVeic,
            true,
            "$identificador [item $std->item] Tipo de Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "espVeic",
            $std->espVeic,
            true,
            "$identificador [item $std->item] Espécie de Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "VIN",
            $std->VIN,
            true,
            "$identificador [item $std->item] Condição do VIN do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "condVeic",
            $std->condVeic,
            true,
            "$identificador [item $std->item] Condição do Veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cMod",
            $std->cMod,
            true,
            "$identificador [item $std->item] Código Marca Modelo do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "cCorDENATRAN",
            $std->cCorDENATRAN,
            true,
            "$identificador [item $std->item] Código da Cor do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "lota",
            $std->lota,
            true,
            "$identificador [item $std->item] Capacidade máxima de lotação do veículo"
        );
        $this->dom->addChild(
            $veicProd,
            "tpRest",
            $std->tpRest,
            true,
            "$identificador [item $std->item] Restrição do veículo"
        );
        $this->aVeicProd[$std->item] = $veicProd;
        return $veicProd;
    }

    /**
     * Detalhamento de medicamentos K01 pai I90
     * NOTA: Ajustado para NT2018.005
     * tag NFe/infNFe/det[]/prod/med (opcional)
     */
    public function tagmed(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vPMC',
            'cProdANVISA',
            'xMotivoIsencao'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'K01 <med> - ';
        $med = $this->dom->createElement("med");
        $this->dom->addChild(
            $med,
            "cProdANVISA",
            $std->cProdANVISA,
            false,
            "$identificador [item $std->item] Numero ANVISA"
        );
        $this->dom->addChild(
            $med,
            "xMotivoIsencao",
            $std->xMotivoIsencao,
            false,
            "$identificador [item $std->item] Motivo da isenção da ANVISA"
        );
        $this->dom->addChild(
            $med,
            "vPMC",
            $this->conditionalNumberFormatting($std->vPMC),
            true,
            "$identificador [item $std->item] Preço máximo consumidor"
        );
        $this->aMed[$std->item] = $med;
        return $med;
    }

    /**
     * Detalhamento de armas L01 pai I90
     * tag NFe/infNFe/det[]/prod/arma (opcional)
     */
    public function tagarma(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nAR',
            'tpArma',
            'nSerie',
            'nCano',
            'descr'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'L01 <arma> - ';
        $arma = $this->dom->createElement("arma");
        $this->dom->addChild(
            $arma,
            "tpArma",
            $std->tpArma,
            true,
            "$identificador [item $std->item] Indicador do tipo de arma de fogo"
        );
        $this->dom->addChild(
            $arma,
            "nSerie",
            $std->nSerie,
            true,
            "$identificador [item $std->item] Número de série da arma"
        );
        $this->dom->addChild(
            $arma,
            "nCano",
            $std->nCano,
            true,
            "$identificador [item $std->item] Número de série do cano"
        );
        $this->dom->addChild(
            $arma,
            "descr",
            $std->descr,
            true,
            "$identificador [item $std->item] Descrição completa da arma, compreendendo: calibre, marca, capacidade, "
                . "tipo de funcionamento, comprimento e demais elementos que "
                . "permitam a sua perfeita identificação."
        );
        $this->aArma[$std->item][$std->nAR] = $arma;
        return $arma;
    }

    /**
     * Detalhamento de combustiveis L101 pai I90
     * tag NFe/infNFe/det[]/prod/comb (opcional)
     * LA|cProdANP|pMixGN|CODIF|qTemp|UFCons|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * LA|cProdANP|descANP|pGLP|pGNn|pGNi|vPart|CODIF|qTemp|UFCons|
     *
     * NOTA: Ajustado para NT2023_0001_v1.10
     */
    public function tagcomb(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'cProdANP',
            'descANP',
            'pGLP',
            'pGNn',
            'pGNi',
            'vPart',
            'CODIF',
            'qTemp',
            'UFCons',
            'qBCProd',
            'vAliqProd',
            'vCIDE',
            'pBio',
            'origComb'
        ];
        $std = $this->equilizeParameters($std, $possible);

        $identificador = 'L101 <comb> - ';
        $comb = $this->dom->createElement("comb");
        $this->dom->addChild(
            $comb,
            "cProdANP",
            $std->cProdANP,
            true,
            "$identificador [item $std->item] Código de produto da ANP"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "descANP",
            $std->descANP,
            true,
            "$identificador [item $std->item] Utilizar a descrição de produtos do "
                . "Sistema de Informações de Movimentação de Produtos - "
                . "SIMP (http://www.anp.gov.br/simp/"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "pGLP",
            $this->conditionalNumberFormatting($std->pGLP, 4),
            false,
            "$identificador [item $std->item] Percentual do GLP derivado do "
                . "petróleo no produto GLP (cProdANP=210203001) 1v4"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "pGNn",
            $this->conditionalNumberFormatting($std->pGNn, 4),
            false,
            "$identificador [item $std->item] Percentual de Gás Natural Nacional"
                . " – GLGNn para o produto GLP (cProdANP=210203001) 1v4"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "pGNi",
            $this->conditionalNumberFormatting($std->pGNi, 4),
            false,
            "$identificador [item $std->item] Percentual de Gás Natural Importado"
                . " – GLGNi para o produto GLP (cProdANP=210203001) 1v4"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $comb,
            "vPart",
            $this->conditionalNumberFormatting($std->vPart),
            false,
            "$identificador [item $std->item] Valor de partida (cProdANP=210203001) "
        );
        $this->dom->addChild(
            $comb,
            "CODIF",
            $std->CODIF,
            false,
            "[item $std->item] Código de autorização / registro do CODIF"
        );
        $this->dom->addChild(
            $comb,
            "qTemp",
            $this->conditionalNumberFormatting($std->qTemp, 4),
            false,
            "$identificador [item $std->item] Quantidade de combustível faturada à temperatura ambiente."
        );
        $this->dom->addChild(
            $comb,
            "UFCons",
            $std->UFCons,
            true,
            "[item $std->item] Sigla da UF de consumo"
        );

        if (!empty($std->origComb)) {
            $tagOrigmComb = $this->tagorigComb($std->origComb);
            $this->dom->appChild($comb, $tagOrigmComb);
        }

        if ($std->qBCProd != "") {
            $tagCIDE = $this->dom->createElement("CIDE");
            $this->dom->addChild(
                $tagCIDE,
                "qBCProd",
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                true,
                "$identificador [item $std->item] BC da CIDE"
            );
            $this->dom->addChild(
                $tagCIDE,
                "vAliqProd",
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                true,
                "$identificador [item $std->item] Valor da alíquota da CIDE"
            );
            $this->dom->addChild(
                $tagCIDE,
                "vCIDE",
                $this->conditionalNumberFormatting($std->vCIDE),
                true,
                "$identificador [item $std->item] Valor da CIDE"
            );
            $this->dom->appChild($comb, $tagCIDE);
        }
        $this->dom->addChild(
            $comb,
            "pBio",
            $this->conditionalNumberFormatting($std->pBio, 4),
            false,
            "$identificador [item $std->item] Percentual do índice de mistura do Biodiesel (B100) no Óleo Diesel B "
                . "instituído pelo órgão regulamentador"
        );
        $this->aComb[$std->item] = $comb;
        return $comb;
    }

    /**
     * informações relacionadas com as operações de combustíveis, subgrupo de
     * encerrante que permite o controle sobre as operações de venda de combustíveis
     * LA11 pai LA01
     * tag NFe/infNFe/det[]/prod/comb/encerrante (opcional)
     */
    public function tagencerrante(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'nBico',
            'nBomba',
            'nTanque',
            'vEncIni',
            'vEncFin'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'LA11 <encerrante> - ';
        $encerrante = $this->dom->createElement("encerrante");
        $this->dom->addChild(
            $encerrante,
            "nBico",
            $std->nBico,
            true,
            "$identificador [item $std->item] Número de identificação do bico utilizado no abastecimento"
        );
        $this->dom->addChild(
            $encerrante,
            "nBomba",
            $std->nBomba,
            false,
            "$identificador [item $std->item] Número de identificação da bomba ao qual o bico está interligado"
        );
        $this->dom->addChild(
            $encerrante,
            "nTanque",
            $std->nTanque,
            true,
            "$identificador [item $std->item] Número de identificação do tanque ao qual o bico está interligado"
        );
        $this->dom->addChild(
            $encerrante,
            "vEncIni",
            $this->conditionalNumberFormatting($std->vEncIni, 3),
            true,
            "$identificador [item $std->item] Valor do Encerrante no início do abastecimento"
        );
        $this->dom->addChild(
            $encerrante,
            "vEncFin",
            $this->conditionalNumberFormatting($std->vEncFin, 3),
            true,
            "$identificador [item $std->item] Valor do Encerrante no final do abastecimento"
        );

        $this->aEncerrante[$std->item] = $encerrante;
        return $encerrante;
    }

    /**
     * Grupo indicador da origem do combustível
     * encerrante que permite o controle sobre as operações de venda de combustíveis
     * LA18 pai LA01
     * tag NFe/infNFe/det[]/prod/comb/origComb[]
     *
     * NOTA: Adicionado para NT2023_0001_v1.10
     */
    public function tagorigComb(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'indImport',
            'cUFOrig',
            'pOrig'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'LA18 <origComb> - ';
        $origComb = $this->dom->createElement("origComb");
        $this->dom->addChild(
            $origComb,
            "indImport",
            $std->indImport,
            true,
            "$identificador [item $std->item] Indicador de importação"
        );
        $this->dom->addChild(
            $origComb,
            "cUFOrig",
            $std->cUFOrig,
            true,
            "$identificador [item $std->item] Código da UF"
        );
        $this->dom->addChild(
            $origComb,
            "pOrig",
            $this->conditionalNumberFormatting($std->pOrig, 4),
            true,
            "$identificador [item $std->item] Percentual originário para a UF"
        );
        $this->aOrigComb[$std->item][] = $origComb;
        return $origComb;
    }

    /**
     * Impostos com o valor total tributado M01 pai H01
     * tag NFe/infNFe/det[]/imposto
     */
    public function tagimposto(stdClass $std): DOMElement
    {
        $possible = ['item', 'vTotTrib'];
        $std = $this->equilizeParameters($std, $possible);
        //totalizador dos valores dos itens
        $this->stdTot->vTotTrib += (float) $std->vTotTrib;
        $identificador = 'M01 <imposto> - ';
        $imposto = $this->dom->createElement("imposto");
        $this->dom->addChild(
            $imposto,
            "vTotTrib",
            $this->conditionalNumberFormatting($std->vTotTrib),
            false,
            "$identificador [item $std->item] Valor aproximado total de tributos federais, estaduais e municipais."
        );
        $this->aImposto[$std->item] = $imposto;
        return $imposto;
    }

    /**
     * Informações do ICMS da Operação própria e ST N01 pai M01
     * tag NFe/infNFe/det[]/imposto/ICMS
     * NOTA: ajustado NT 2020.005-v1.20
     *
     * NOTA: Ajustado para NT2023_0001_v1.10
     */
    public function tagICMS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'orig',
            'CST',
            'modBC',
            'vBC',
            'pICMS',
            'vICMS',
            'pFCP',
            'vFCP',
            'vBCFCP',
            'modBCST',
            'pMVAST',
            'pRedBCST',
            'vBCST',
            'pICMSST',
            'vICMSST',
            'vBCFCPST',
            'pFCPST',
            'vFCPST',
            'vICMSDeson',
            'motDesICMS',
            'pRedBC',
            'vICMSOp',
            'pDif',
            'vICMSDif',
            'vBCSTRet',
            'pST',
            'vICMSSTRet',
            'vBCFCPSTRet',
            'pFCPSTRet',
            'vFCPSTRet',
            'pRedBCEfet',
            'vBCEfet',
            'pICMSEfet',
            'vICMSEfet',
            'vICMSSubstituto',
            'vICMSSTDeson',
            'motDesICMSST',
            'pFCPDif',
            'vFCPDif',
            'vFCPEfet',
            'pRedAdRem',
            'motRedAdRem',
            'qBCMono',
            'adRemICMS',
            'vICMSMono',
            'vICMSMonoOp',
            'adRemICMSReten',
            'vICMSMonoReten',
            'vICMSMonoDif',
            'vICMSMonoRet',
            'adRemICMSRet',
            'cBenefRBC',
            'indDeduzDeson'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'N01 <ICMSxx> - ';
        switch ($std->CST) {
            case '00':
                $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
                $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
                $this->stdTot->vFCP += (float) !empty($std->vFCP) ? $std->vFCP : 0;

                $icms = $this->dom->createElement("ICMS00");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 00"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador [item $std->item] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador [item $std->item] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador [item $std->item] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador [item $std->item] Valor do Fundo de Combate "
                        . "à Pobreza (FCP)"
                );
                break;
            case '02':
                $this->stdTot->qBCMono += (float) !empty($std->qBCMono) ? $std->qBCMono : 0;
                $this->stdTot->vICMSMono += (float) !empty($std->vICMSMono) ? $std->vICMSMono : 0;

                $icms = $this->dom->createElement("ICMS02");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 02"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMono',
                    $this->conditionalNumberFormatting($std->qBCMono, 4),
                    false,
                    "$identificador [item $std->item] Quantidade tributada"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMS',
                    $this->conditionalNumberFormatting($std->adRemICMS, 4),
                    true,
                    "$identificador [item $std->item] Alíquota ad rem do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMono',
                    $this->conditionalNumberFormatting($std->vICMSMono),
                    true,
                    "$identificador [item $std->item] Valor do ICMS próprio"
                );
                break;
            case '10':
                $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
                $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
                $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
                $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;
                $this->stdTot->vFCPST += (float) !empty($std->vFCPST) ? $std->vFCPST : 0;
                $this->stdTot->vFCP += (float) !empty($std->vFCP) ? $std->vFCP : 0;

                $icms = $this->dom->createElement("ICMS10");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 10"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador [item $std->item] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador [item $std->item] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador [item $std->item] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador [item $std->item] Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador [item $std->item] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador [item $std->item] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador [item $std->item] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador [item $std->item] Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTDeson',
                    $this->conditionalNumberFormatting($std->vICMSSTDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS- ST desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMSST',
                    $std->motDesICMSST ?? null,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS- ST"
                );
                break;
            case '15':
                $this->stdTot->qBCMono += (float) !empty($std->qBCMono) ? $std->qBCMono : 0;
                $this->stdTot->vICMSMono += (float) !empty($std->vICMSMono) ? $std->vICMSMono : 0;
                $this->stdTot->qBCMonoReten += (float) !empty($std->qBCMonoReten) ? $std->qBCMonoReten : 0;
                $this->stdTot->vICMSMonoReten += (float) !empty($std->vICMSMonoReten) ? $std->vICMSMonoReten : 0;

                $icms = $this->dom->createElement("ICMS15");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 15"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMono',
                    $this->conditionalNumberFormatting($std->qBCMono, 4),
                    false,
                    "$identificador [item $std->item] Quantidade tributada"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMS',
                    $this->conditionalNumberFormatting($std->adRemICMS, 4),
                    true,
                    "$identificador [item $std->item] Alíquota ad rem do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMono',
                    $this->conditionalNumberFormatting($std->vICMSMono),
                    true,
                    "$identificador [item $std->item] Valor do ICMS próprio"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMonoReten',
                    $this->conditionalNumberFormatting($std->qBCMonoReten, 4),
                    false,
                    "$identificador [item $std->item] Quantidade tributada sujeita a retenção"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMSReten',
                    $this->conditionalNumberFormatting($std->adRemICMSReten, 4),
                    true,
                    "$identificador [item $std->item] Alíquota ad rem do imposto com retenção"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoReten',
                    $this->conditionalNumberFormatting($std->vICMSMonoReten),
                    true,
                    "$identificador [item $std->item] Valor do ICMS com retenção"
                );
                if (!empty($std->pRedAdRem)) {
                    $this->dom->addChild(
                        $icms,
                        "pRedAdRem",
                        $this->conditionalNumberFormatting($std->pRedAdRem),
                        true,
                        "Percentual de redução do valor da alíquota adrem do ICMS"
                    );
                    $this->dom->addChild(
                        $icms,
                        "motRedAdRem",
                        $std->motRedAdRem,
                        true,
                        "Motivo da redução do adrem"
                    );
                }
                break;
            case '20':
                $this->stdTot->vICMSDeson += (float)!empty($std->vICMSDeson) ? $std->vICMSDeson : 0;
                $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
                $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
                $this->stdTot->vFCP += (float) !empty($std->vFCP) ? $std->vFCP : 0;

                $icms = $this->dom->createElement("ICMS20");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 20"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    true,
                    "$identificador [item $std->item] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador [item $std->item] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador [item $std->item] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador [item $std->item] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador [item $std->item] Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador [item $std->item] Indica se o valor do ICMS desonerado (vICMSDeson) "
                        . "deduz do valor do item (vProd)."
                );
                break;
            case '30':
                $this->stdTot->vICMSDeson += (float)!empty($std->vICMSDeson) ? $std->vICMSDeson : 0;
                $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
                $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;
                $this->stdTot->vFCPST += (float) !empty($std->vFCPST) ? $std->vFCPST : 0;

                $icms = $this->dom->createElement("ICMS30");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 30"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador [item $std->item] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador [item $std->item] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador [item $std->item] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador [item $std->item] Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador [item $std->item] Indica se o valor do ICMS desonerado (vICMSDeson) "
                        . "deduz do valor do item (vProd)."
                );
                break;
            case '40':
            case '41':
            case '50':
                $this->stdTot->vICMSDeson += (float)!empty($std->vICMSDeson) ? $std->vICMSDeson : 0;
                $icms = $this->dom->createElement("ICMS40");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS $std->CST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador [item $std->item] Indica se o valor do ICMS desonerado (vICMSDeson) "
                        . "deduz do valor do item (vProd)."
                );
                break;
            case '51':
                $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
                $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
                $this->stdTot->vFCP += (float) !empty($std->vFCP) ? $std->vFCP : 0;

                $icms = $this->dom->createElement("ICMS51");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 51"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    false,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    false,
                    "$identificador [item $std->item] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'cBenefRBC',
                    $std->cBenefRBC,
                    false,
                    "$identificador [item $std->item] Código de Benefício Fiscal na UF aplicado ao "
                        . "item quando houver RBC."
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    false,
                    "$identificador [item $std->item] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    false,
                    "$identificador [item $std->item] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSOp',
                    $this->conditionalNumberFormatting($std->vICMSOp),
                    false,
                    "$identificador [item $std->item] Valor do ICMS da Operação"
                );
                $this->dom->addChild(
                    $icms,
                    'pDif',
                    $this->conditionalNumberFormatting($std->pDif, 4),
                    false,
                    "$identificador [item $std->item] Percentual do diferimento"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDif',
                    $this->conditionalNumberFormatting($std->vICMSDif),
                    false,
                    "$identificador [item $std->item] Valor do ICMS diferido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    false,
                    "$identificador [item $std->item] Valor do ICMS realmente devido"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador [item $std->item] Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPDif',
                    $this->conditionalNumberFormatting($std->pFCPDif),
                    false,
                    "$identificador [item $std->item] Percentual do diferimento "
                        . "do ICMS relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPDif',
                    $this->conditionalNumberFormatting($std->vFCPDif),
                    false,
                    "$identificador [item $std->item] Valor do ICMS relativo ao "
                        . "Fundo de Combate à Pobreza (FCP) diferido"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPEfet',
                    $this->conditionalNumberFormatting($std->vFCPEfet),
                    false,
                    "$identificador [item $std->item] Valor efetivo do ICMS relativo "
                        . "ao Fundo de Combate à Pobreza (FCP)"
                );
                break;
            case '53':
                $this->stdTot->qBCMono += (float) !empty($std->qBCMono) ? $std->qBCMono : 0;
                $this->stdTot->vICMSMono += (float) !empty($std->vICMSMono) ? $std->vICMSMono : 0;
                $this->stdTot->qBCMonoReten += (float) !empty($std->qBCMonoReten) ? $std->qBCMonoReten : 0;
                $this->stdTot->vICMSMonoReten += (float) !empty($std->vICMSMonoReten) ? $std->vICMSMonoReten : 0;

                $icms = $this->dom->createElement("ICMS53");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 53"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMono',
                    $this->conditionalNumberFormatting($std->qBCMono, 4),
                    false,
                    "$identificador [item $std->item] BC do ICMS em quantidade conforme unidade de medida "
                        . "estabelecida na legislação para o produto"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMS',
                    $this->conditionalNumberFormatting($std->adRemICMS, 4),
                    false,
                    "$identificador [item $std->item] Alíquota ad rem do ICMS estabelecida para o produto."
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoOp',
                    $this->conditionalNumberFormatting($std->vICMSMonoOp),
                    false,
                    "$identificador [item $std->item] valor do ICMS é obtido pela multiplicação da alíquota ad "
                        . "rem pela quantidade do produto conforme unidade de "
                        . "medida estabelecida em legislação, como se não houvesseo diferimento."
                );
                $this->dom->addChild(
                    $icms,
                    'pDif',
                    $this->conditionalNumberFormatting($std->pDif, 4),
                    false,
                    "$identificador [item $std->item] Percentual do diferimento"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoDif',
                    $this->conditionalNumberFormatting($std->vICMSMonoDif),
                    false,
                    "$identificador [item $std->item] Valor do ICMS diferido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMono',
                    $this->conditionalNumberFormatting($std->vICMSMono),
                    false,
                    "$identificador [item $std->item] Valor do ICMS próprio devido"
                );
                break;
            case '60':
                $this->stdTot->vFCPSTRet += (float) !empty($std->vFCPSTRet) ? $std->vFCPSTRet : 0;
                $icms = $this->dom->createElement("ICMS60");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 60"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCSTRet',
                    $this->conditionalNumberFormatting($std->vBCSTRet),
                    false,
                    "$identificador [item $std->item] Valor da BC do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'pST',
                    $this->conditionalNumberFormatting($std->pST, 4),
                    false,
                    "$identificador [item $std->item] Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSubstituto',
                    $this->conditionalNumberFormatting($std->vICMSSubstituto),
                    false,
                    "$identificador [item $std->item] Valor do ICMS próprio do Substituto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTRet',
                    $this->conditionalNumberFormatting($std->vICMSSTRet),
                    false,
                    "$identificador [item $std->item] Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPSTRet',
                    $this->conditionalNumberFormatting($std->vBCFCPSTRet),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo "
                        . "do FCP retido anteriormente por ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPSTRet',
                    $this->conditionalNumberFormatting($std->pFCPSTRet, 4),
                    false,
                    "$identificador [item $std->item] Percentual do FCP retido "
                        . "anteriormente por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPSTRet',
                    $this->conditionalNumberFormatting($std->vFCPSTRet),
                    false,
                    "$identificador [item $std->item] Valor do FCP retido por "
                        . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCEfet',
                    $this->conditionalNumberFormatting($std->pRedBCEfet, 4),
                    false,
                    "$identificador [item $std->item] Percentual de redução "
                        . "para obtenção da base de cálculo efetiva"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCEfet',
                    $this->conditionalNumberFormatting($std->vBCEfet),
                    false,
                    "$identificador [item $std->item] base de calculo efetiva"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSEfet',
                    $this->conditionalNumberFormatting($std->pICMSEfet, 4),
                    false,
                    "$identificador [item $std->item] Alíquota do ICMS na operação a consumidor final"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSEfet',
                    $this->conditionalNumberFormatting($std->vICMSEfet),
                    false,
                    "$identificador [item $std->item] Valor do ICMS efetivo"
                );
                break;
            case '61':
                $this->stdTot->qBCMonoRet += (float) !empty($std->qBCMonoRet) ? $std->qBCMonoRet : 0;
                $this->stdTot->vICMSMonoRet += (float) !empty($std->vICMSMonoRet) ? $std->vICMSMonoRet : 0;

                $icms = $this->dom->createElement("ICMS61");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 61"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMonoRet',
                    $this->conditionalNumberFormatting($std->qBCMonoRet, 4),
                    false,
                    "$identificador [item $std->item] Quantidade tributada retida anteriormente"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMSRet',
                    $this->conditionalNumberFormatting($std->adRemICMSRet, 4),
                    true,
                    "$identificador [item $std->item] Alíquota ad rem do imposto retido anteriormente"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoRet',
                    $this->conditionalNumberFormatting($std->vICMSMonoRet),
                    true,
                    "$identificador [item $std->item] Valor do ICMS retido anteriormente"
                );
                break;
            case '70':
                $this->stdTot->vICMSDeson += (float) !empty($std->vICMSDeson) ? $std->vICMSDeson : 0;
                $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
                $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
                $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
                $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;
                $this->stdTot->vFCPST += (float) !empty($std->vFCPST) ? $std->vFCPST : 0;
                $this->stdTot->vFCP += (float) !empty($std->vFCP) ? $std->vFCP : 0;

                $icms = $this->dom->createElement("ICMS70");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 70"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    true,
                    "$identificador [item $std->item] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador [item $std->item] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador [item $std->item] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador [item $std->item] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $std->vFCP,
                    false,
                    "$identificador [item $std->item] Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador [item $std->item] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador [item $std->item] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador [item $std->item] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador [item $std->item] Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador [item $std->item] Indica se o valor do ICMS desonerado (vICMSDeson) "
                        . "deduz do valor do item (vProd)."
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTDeson',
                    $this->conditionalNumberFormatting($std->vICMSSTDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS- ST desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMSST',
                    $std->motDesICMSST ?? null,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS- ST"
                );
                break;
            case '90':
                $this->stdTot->vICMSDeson += (float) !empty($std->vICMSDeson) ? $std->vICMSDeson : 0;
                $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
                $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
                $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
                $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;
                $this->stdTot->vFCPST += (float) !empty($std->vFCPST) ? $std->vFCPST : 0;
                $this->stdTot->vFCP += (float) !empty($std->vFCP) ? $std->vFCP : 0;

                $icms = $this->dom->createElement("ICMS90");
                $this->dom->addChild(
                    $icms,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador [item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador [item $std->item] Tributação do ICMS = 90"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    false,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    false,
                    "$identificador [item $std->item] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    false,
                    "$identificador [item $std->item] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    false,
                    "$identificador [item $std->item] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    false,
                    "$identificador [item $std->item] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador [item $std->item] Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    false,
                    "$identificador [item $std->item] Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador [item $std->item] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    false,
                    "$identificador [item $std->item] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    false,
                    "$identificador [item $std->item] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    false,
                    "$identificador [item $std->item] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador [item $std->item] Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador [item $std->item] Percentual do Fundo de "
                        . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador [item $std->item] Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador [item $std->item] Indica se o valor do ICMS desonerado (vICMSDeson) "
                        . "deduz do valor do item (vProd)."
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTDeson',
                    $this->conditionalNumberFormatting($std->vICMSSTDeson),
                    false,
                    "$identificador [item $std->item] Valor do ICMS- ST desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMSST',
                    $std->motDesICMSST ?? null,
                    false,
                    "$identificador [item $std->item] Motivo da desoneração do ICMS- ST"
                );
                break;
        }
        $tagIcms = $this->dom->createElement('ICMS');
        if (isset($icms)) {
            $tagIcms->appendChild($icms);
        }
        $this->aICMS[$std->item] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Grupo de Partilha do ICMS entre a UF de origem e UF de destino ou
     * a UF definida na legislação. N10a pai N01
     * tag NFe/infNFe/det[]/imposto/ICMS/ICMSPart
     */
    public function tagICMSPart(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'orig',
            'CST',
            'modBC',
            'vBC',
            'pRedBC',
            'pICMS',
            'vICMS',
            'modBCST',
            'pMVAST',
            'pRedBCST',
            'vBCST',
            'pICMSST',
            'vICMSST',
            'vBCFCPST',
            'pFCPST',
            'vFCPST',
            'pBCOp',
            'UFST'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
        $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
        $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
        $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;
        $icmsPart = $this->dom->createElement("ICMSPart");
        $this->dom->addChild(
            $icmsPart,
            'orig',
            $std->orig,
            true,
            "[item $std->item] Origem da mercadoria"
        );
        $this->dom->addChild(
            $icmsPart,
            'CST',
            $std->CST,
            true,
            "[item $std->item] Tributação do ICMS 10 ou 90"
        );
        $this->dom->addChild(
            $icmsPart,
            'modBC',
            $std->modBC,
            true,
            "[item $std->item] Modalidade de determinação da BC do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBC',
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "[item $std->item] Valor da BC do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'pRedBC',
            $this->conditionalNumberFormatting($std->pRedBC, 4),
            false,
            "[item $std->item] Percentual da Redução de BC"
        );
        $this->dom->addChild(
            $icmsPart,
            'pICMS',
            $this->conditionalNumberFormatting($std->pICMS, 4),
            true,
            "[item $std->item] Alíquota do imposto"
        );
        $this->dom->addChild(
            $icmsPart,
            'vICMS',
            $this->conditionalNumberFormatting($std->vICMS),
            true,
            "[item $std->item] Valor do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'modBCST',
            $std->modBCST,
            true,
            "[item $std->item] Modalidade de determinação da BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pMVAST',
            $this->conditionalNumberFormatting($std->pMVAST, 4),
            false,
            "[item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pRedBCST',
            $this->conditionalNumberFormatting($std->pRedBCST, 4),
            false,
            "[item $std->item] Percentual da Redução de BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBCST',
            $this->conditionalNumberFormatting($std->vBCST),
            true,
            "[item $std->item] Valor da BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pICMSST',
            $this->conditionalNumberFormatting($std->pICMSST, 4),
            true,
            "[item $std->item] Alíquota do imposto do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vICMSST',
            $this->conditionalNumberFormatting($std->vICMSST),
            true,
            "[item $std->item] Valor do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBCFCPST',
            $this->conditionalNumberFormatting($std->vBCFCPST),
            false,
            "[item $std->item] Valor da Base de Cálculo do FCP ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pFCPST',
            $this->conditionalNumberFormatting($std->pFCPST, 4),
            false,
            "[item $std->item] Percentual do Fundo de "
                . "Combate à Pobreza (FCP) ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vFCPST',
            $this->conditionalNumberFormatting($std->vFCPST),
            false,
            "[item $std->item] Valor do FCP ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pBCOp',
            $this->conditionalNumberFormatting($std->pBCOp, 4),
            true,
            "[item $std->item] Percentual da BC operação própria"
        );
        $this->dom->addChild(
            $icmsPart,
            'UFST',
            $std->UFST,
            true,
            "[item $std->item] UF para qual é devido o ICMS ST"
        );
        //caso exista a tag aICMS[$std->item] inserir nela caso contrario criar
        if (!empty($this->aICMS[$std->item])) {
            $tagIcms = $this->aICMS[$std->item];
        } else {
            $tagIcms = $this->dom->createElement('ICMS');
        }
        $this->dom->appChild($tagIcms, $icmsPart, "Inserindo ICMSPart em ICMS[$std->item]");
        $this->aICMS[$std->item] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Grupo de Repasse de ICMSST retido anteriormente em operações
     * interestaduais com repasses através do Substituto Tributário
     * NOTA: ajustado NT 2018.005
     * tag NFe/infNFe/det[]/imposto/ICMS/ICMSST N10b pai N01
     */
    public function tagICMSST(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'orig',
            'CST',
            'vBCSTRet',
            'vICMSSTRet',
            'vBCSTDest',
            'vICMSSTDest',
            'vBCFCPSTRet',
            'pFCPSTRet',
            'vFCPSTRet',
            'pST',
            'vICMSSubstituto',
            'pRedBCEfet',
            'vBCEfet',
            'pICMSEfet',
            'vICMSEfet'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->stdTot->vFCPSTRet += (float) !empty($std->vFCPSTRet) ? $std->vFCPSTRet : 0;
        $icmsST = $this->dom->createElement("ICMSST");
        $this->dom->addChild(
            $icmsST,
            'orig',
            $std->orig,
            true,
            "[item $std->item] Origem da mercadoria"
        );
        $this->dom->addChild(
            $icmsST,
            'CST',
            $std->CST,
            true,
            "[item $std->item] Tributação do ICMS 41 ou 60"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCSTRet',
            $this->conditionalNumberFormatting($std->vBCSTRet),
            true,
            "[item $std->item] Valor do BC do ICMS ST retido na UF remetente"
        );
        $this->dom->addChild(
            $icmsST,
            'pST',
            $this->conditionalNumberFormatting($std->pST, 4),
            false,
            "[item $std->item] Alíquota suportada pelo Consumidor Final"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSubstituto',
            $this->conditionalNumberFormatting($std->vICMSSubstituto),
            false,
            "[item $std->item] Valor do ICMS próprio do Substituto"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSTRet',
            $this->conditionalNumberFormatting($std->vICMSSTRet),
            true,
            "[item $std->item] Valor do ICMS ST retido na UF remetente"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCFCPSTRet',
            $this->conditionalNumberFormatting($std->vBCFCPSTRet),
            false,
            "[item $std->item] Valor da Base de Cálculo do FCP"
        );
        $this->dom->addChild(
            $icmsST,
            'pFCPSTRet',
            $this->conditionalNumberFormatting($std->pFCPSTRet, 4),
            false,
            "[item $std->item] Percentual do FCP retido"
        );
        $this->dom->addChild(
            $icmsST,
            'vFCPSTRet',
            $this->conditionalNumberFormatting($std->vFCPSTRet),
            false,
            "[item $std->item] Valor do FCP retido"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCSTDest',
            $this->conditionalNumberFormatting($std->vBCSTDest),
            true,
            "[item $std->item] Valor da BC do ICMS ST da UF destino"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSTDest',
            $this->conditionalNumberFormatting($std->vICMSSTDest),
            true,
            "[item $std->item] Valor do ICMS ST da UF destino"
        );
        $this->dom->addChild(
            $icmsST,
            'pRedBCEfet',
            $this->conditionalNumberFormatting($std->pRedBCEfet, 4),
            false,
            "[item $std->item] Percentual de redução da base de cálculo efetiva"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCEfet',
            $this->conditionalNumberFormatting($std->vBCEfet),
            false,
            "[item $std->item] Valor da base de cálculo efetiva"
        );
        $this->dom->addChild(
            $icmsST,
            'pICMSEfet',
            $this->conditionalNumberFormatting($std->pICMSEfet, 4),
            false,
            "[item $std->item] Alíquota do ICMS efetiva"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSEfet',
            $this->conditionalNumberFormatting($std->vICMSEfet),
            false,
            "[item $std->item] Valor do ICMS efetivo"
        );
        //caso exista a tag aICMS[$std->item] inserir nela caso contrario criar
        if (!empty($this->aICMS[$std->item])) {
            $tagIcms = $this->aICMS[$std->item];
        } else {
            $tagIcms = $this->dom->createElement('ICMS');
        }
        $this->dom->appChild($tagIcms, $icmsST, "Inserindo ICMSST em ICMS[$std->item]");
        $this->aICMS[$std->item] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Tributação ICMS pelo Simples Nacional N10c pai N01
     * tag NFe/infNFe/det[]/imposto/ICMS/ICMSSN N10c pai N01
     */
    public function tagICMSSN(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'orig',
            'CSOSN',
            'pCredSN',
            'vCredICMSSN',
            'modBCST',
            'pMVAST',
            'pRedBCST',
            'vBCST',
            'pICMSST',
            'vICMSST',
            'vBCFCPST',
            'pFCPST',
            'vFCPST',
            'vBCSTRet',
            'pST',
            'vICMSSTRet',
            'vBCFCPSTRet',
            'pFCPSTRet',
            'vFCPSTRet',
            'modBC',
            'vBC',
            'pRedBC',
            'pICMS',
            'vICMS',
            'pRedBCEfet',
            'vBCEfet',
            'pICMSEfet',
            'vICMSEfet',
            'vICMSSubstituto'
        ];
        $std = $this->equilizeParameters($std, $possible);
        //totalizador generico
        $this->stdTot->vFCPST += (float) !empty($std->vFCPST) ? $std->vFCPST : 0;
        $this->stdTot->vFCPSTRet += (float) !empty($std->vFCPSTRet) ? $std->vFCPSTRet : 0;

        /*
        $CRT = null;
        if (!empty($this->emit->getElementsByTagName("CRT")->item(0))) {
            $CRT = (int) $this->emit->getElementsByTagName("CRT")->item(0)->nodeValue;
        }

        $allowEmptyOrig = $CRT == 4 && in_array($std->CSOSN, [
            '102', '103', '300', '400', '900',
        ]);
        */
        switch ($std->CSOSN) {
            case '101':
                $icmsSN = $this->dom->createElement("ICMSSN101");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $std->orig,
                    true,
                    "[item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "[item $std->item] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $this->conditionalNumberFormatting($std->pCredSN, 2),
                    true,
                    "[item $std->item] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $this->conditionalNumberFormatting($std->vCredICMSSN),
                    true,
                    "[item $std->item] Valor crédito do ICMS que pode ser aproveitado nos termos do"
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
                    $std->orig ?? null, //poderá ser null caso CRT=4 e 102
                    false,
                    "[item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "[item $std->item] Código de Situação da Operação Simples Nacional"
                );
                break;
            case '201':
                $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
                $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;

                $icmsSN = $this->dom->createElement("ICMSSN201");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $std->orig,
                    true,
                    "[item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "[item $std->item] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "[item $std->item] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "[item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "[item $std->item] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "[item $std->item] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "[item $std->item] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "[item $std->item] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    isset($std->vBCFCPST) ? true : false,
                    "[item $std->item] Valor da Base de Cálculo do FCP "
                        . "retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    isset($std->pFCPST) ? true : false,
                    "[item $std->item] Percentual do FCP retido por "
                        . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    isset($std->vFCPST) ? true : false,
                    "[item $std->item] Valor do FCP retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $this->conditionalNumberFormatting($std->pCredSN, 4),
                    false,
                    "[item $std->item] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $this->conditionalNumberFormatting($std->vCredICMSSN),
                    false,
                    "[item $std->item] Valor crédito do ICMS que pode ser aproveitado nos "
                        . "termos do art. 23 da LC 123 (Simples Nacional)"
                );
                break;
            case '202':
            case '203':
                $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
                $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;

                $icmsSN = $this->dom->createElement("ICMSSN202");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $std->orig,
                    true,
                    "[item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "[item $std->item] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "[item $std->item] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "[item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "[item $std->item] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "[item $std->item] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "[item $std->item] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "[item $std->item] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    isset($std->vBCFCPST) ? true : false,
                    "[item $std->item] Valor da Base de Cálculo do FCP "
                        . "retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    isset($std->pFCPST) ? true : false,
                    "[item $std->item] Percentual do FCP retido por "
                        . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    isset($std->vFCPST) ? true : false,
                    "[item $std->item] Valor do FCP retido por Substituição Tributária"
                );
                break;
            case '500':
                $icmsSN = $this->dom->createElement("ICMSSN500");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $std->orig,
                    true,
                    "[item $std->item] Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "[item $std->item] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCSTRet',
                    $this->conditionalNumberFormatting($std->vBCSTRet),
                    isset($std->vBCSTRet) ? true : false,
                    "[item $std->item] Valor da BC do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pST',
                    $this->conditionalNumberFormatting($std->pST, 4),
                    isset($std->pST) ? true : false,
                    "[item $std->item] Alíquota suportada pelo Consumidor Final"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSSubstituto',
                    $this->conditionalNumberFormatting($std->vICMSSubstituto),
                    false,
                    "[item $std->item] Valor do ICMS próprio do Substituto"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSSTRet',
                    $this->conditionalNumberFormatting($std->vICMSSTRet),
                    isset($std->vICMSSTRet) ? true : false,
                    "[item $std->item] Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPSTRet',
                    $this->conditionalNumberFormatting($std->vBCFCPSTRet, 2),
                    isset($std->vBCFCPSTRet) ? true : false,
                    "[item $std->item] Valor da Base de Cálculo do FCP "
                        . "retido anteriormente por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPSTRet',
                    $this->conditionalNumberFormatting($std->pFCPSTRet, 4),
                    isset($std->pFCPSTRet) ? true : false,
                    "[item $std->item] Percentual do FCP retido anteriormente por "
                        . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPSTRet',
                    $this->conditionalNumberFormatting($std->vFCPSTRet),
                    isset($std->vFCPSTRet) ? true : false,
                    "[item $std->item] Valor do FCP retido anteiormente por "
                        . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCEfet',
                    $this->conditionalNumberFormatting($std->pRedBCEfet, 4),
                    isset($std->pRedBCEfet) ? true : false,
                    "[item $std->item] Percentual de redução da base "
                        . "de cálculo efetiva"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCEfet',
                    $this->conditionalNumberFormatting($std->vBCEfet),
                    isset($std->vBCEfet) ? true : false,
                    "[item $std->item] Valor da base de cálculo efetiva"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSEfet',
                    $this->conditionalNumberFormatting($std->pICMSEfet, 4),
                    isset($std->pICMSEfet) ? true : false,
                    "[item $std->item] Alíquota do ICMS efetiva"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSEfet',
                    $this->conditionalNumberFormatting($std->vICMSEfet),
                    isset($std->vICMSEfet) ? true : false,
                    "[item $std->item] Valor do ICMS efetivo"
                );
                break;
            case '900':
                $this->stdTot->vBC += (float) !empty($std->vBC) ? $std->vBC : 0;
                $this->stdTot->vICMS += (float) !empty($std->vICMS) ? $std->vICMS : 0;
                $this->stdTot->vBCST += (float) !empty($std->vBCST) ? $std->vBCST : 0;
                $this->stdTot->vST += (float) !empty($std->vICMSST) ? $std->vICMSST : 0;
                $icmsSN = $this->dom->createElement("ICMSSN900");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $std->orig ?? null, //poderá ser null caso CRT=4 e 900
                    false,
                    "[item $std->item] Origem da mercadoria",
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "[item $std->item] Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBC',
                    $std->modBC,
                    isset($std->modBC) ? true : false,
                    "[item $std->item] Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    isset($std->vBC) ? true : false,
                    "[item $std->item] Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    false,
                    "[item $std->item] Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    isset($std->pICMS) ? true : false,
                    "[item $std->item] Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    isset($std->pICMS) ? true : false,
                    "[item $std->item] Valor do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $std->modBCST,
                    isset($std->modBCST) ? true : false,
                    "[item $std->item] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "[item $std->item] Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "[item $std->item] Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    isset($std->vBCST) ? true : false,
                    "[item $std->item] Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    isset($std->pICMSST) ? true : false,
                    "[item $std->item] Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    isset($std->vICMSST) ? true : false,
                    "[item $std->item] Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    isset($std->vBCFCPST) ? true : false,
                    "[item $std->item] Valor da Base de Cálculo do FCP "
                        . "retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    isset($std->pFCPST) ? true : false,
                    "[item $std->item] Percentual do FCP retido por "
                        . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    isset($std->vFCPST) ? true : false,
                    "[item $std->item] Valor do FCP retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $this->conditionalNumberFormatting($std->pCredSN, 4),
                    isset($std->pCredSN) ? true : false,
                    "[item $std->item] Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $this->conditionalNumberFormatting($std->vCredICMSSN),
                    isset($std->vCredICMSSN) ? true : false,
                    "[item $std->item] Valor crédito do ICMS que pode ser aproveitado nos termos do"
                        . " art. 23 da LC 123 (Simples Nacional)"
                );
                break;
        }
        //caso exista a tag aICMS[$std-item] inserir nela caso contrario criar
        if (!empty($this->aICMS[$std->item])) {
            $tagIcms = $this->aICMS[$std->item];
        } else {
            $tagIcms = $this->dom->createElement('ICMS');
        }
        if (isset($icmsSN)) {
            $this->dom->appChild($tagIcms, $icmsSN, "Inserindo ICMSST em ICMS[$std->item]");
        }
        $this->aICMS[$std->item] = $tagIcms;
        return $tagIcms;
    }

    /**
     * Grupo ICMSUFDest NA01 pai M01
     * tag NFe/infNFe/det[]/imposto/ICMSUFDest (opcional)
     * Grupo a ser informado nas vendas interestaduais para consumidor final,
     * não contribuinte do ICMS
     */
    public function tagICMSUFDest(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vBCUFDest',
            'vBCFCPUFDest',
            'pFCPUFDest',
            'pICMSUFDest',
            'pICMSInter',
            'pICMSInterPart',
            'vFCPUFDest',
            'vICMSUFDest',
            'vICMSUFRemet'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->stdTot->vICMSUFDest += (float) $std->vICMSUFDest;
        $this->stdTot->vFCPUFDest += (float) $std->vFCPUFDest;
        $this->stdTot->vICMSUFRemet += (float) $std->vICMSUFRemet;
        $icmsUFDest = $this->dom->createElement('ICMSUFDest');
        $this->dom->addChild(
            $icmsUFDest,
            "vBCUFDest",
            $this->conditionalNumberFormatting($std->vBCUFDest),
            true,
            "[item $std->item] Valor da BC do ICMS na UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vBCFCPUFDest",
            $this->conditionalNumberFormatting($std->vBCFCPUFDest),
            false,
            "[item $std->item] Valor da BC do ICMS na UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pFCPUFDest",
            $this->conditionalNumberFormatting($std->pFCPUFDest, 4),
            false,
            "[item $std->item] Percentual do ICMS relativo ao Fundo de Combate à Pobreza (FCP) na UF de destino"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSUFDest",
            $this->conditionalNumberFormatting($std->pICMSUFDest, 4),
            true,
            "[item $std->item] Alíquota interna da UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSInter",
            $this->conditionalNumberFormatting($std->pICMSInter, 2),
            true,
            "[item $std->item] Alíquota interestadual das UF envolvidas"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSInterPart",
            $this->conditionalNumberFormatting($std->pICMSInterPart, 4),
            true,
            "[item $std->item] Percentual provisório de partilha entre os Estados"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vFCPUFDest",
            $this->conditionalNumberFormatting($std->vFCPUFDest),
            false,
            "[item $std->item] Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vICMSUFDest",
            $this->conditionalNumberFormatting($std->vICMSUFDest),
            true,
            "[item $std->item] Valor do ICMS de partilha para a UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vICMSUFRemet",
            $this->conditionalNumberFormatting($std->vICMSUFRemet),
            true,
            "[item $std->item] Valor do ICMS de partilha para a UF do remetente"
        );
        $this->aICMSUFDest[$std->item] = $icmsUFDest;
        return $icmsUFDest;
    }

    /**
     * Grupo IPI O01 pai M01
     * tag NFe/infNFe/det[]/imposto/IPI (opcional)
     */
    public function tagIPI(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'clEnq',
            'CNPJProd',
            'cSelo',
            'qSelo',
            'cEnq',
            'CST',
            'vIPI',
            'vBC',
            'pIPI',
            'qUnid',
            'vUnid'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $ipi = $this->dom->createElement('IPI');
        $this->dom->addChild(
            $ipi,
            "clEnq",
            $std->clEnq,
            false,
            "[item $std->item] Classe de enquadramento do IPI para Cigarros e Bebidas"
        );
        $this->dom->addChild(
            $ipi,
            "CNPJProd",
            $std->CNPJProd,
            false,
            "[item $std->item] CNPJ do produtor da mercadoria, quando diferente do emitente. "
                . "Somente para os casos de exportação direta ou indireta."
        );
        $this->dom->addChild(
            $ipi,
            "cSelo",
            $std->cSelo,
            false,
            "[item $std->item] Código do selo de controle IPI"
        );
        $this->dom->addChild(
            $ipi,
            "qSelo",
            $std->qSelo,
            false,
            "[item $std->item] Quantidade de selo de controle"
        );
        $this->dom->addChild(
            $ipi,
            "cEnq",
            $std->cEnq,
            true,
            "[item $std->item] Código de Enquadramento Legal do IPI"
        );
        if ($std->CST == '00' || $std->CST == '49' || $std->CST == '50' || $std->CST == '99') {
            //totalizador
            $this->stdTot->vIPI += (float) $std->vIPI;
            $ipiTrib = $this->dom->createElement('IPITrib');
            $this->dom->addChild(
                $ipiTrib,
                "CST",
                $std->CST,
                true,
                "[item $std->item] Código da situação tributária do IPI"
            );
            $this->dom->addChild(
                $ipiTrib,
                "vBC",
                $this->conditionalNumberFormatting($std->vBC),
                false,
                "[item $std->item] Valor da BC do IPI"
            );
            $this->dom->addChild(
                $ipiTrib,
                "pIPI",
                $this->conditionalNumberFormatting($std->pIPI, 4),
                false,
                "[item $std->item] Alíquota do IPI"
            );
            $this->dom->addChild(
                $ipiTrib,
                "qUnid",
                $this->conditionalNumberFormatting($std->qUnid, 4),
                false,
                "[item $std->item] Quantidade total na unidade padrão para tributação (somente para os "
                    . "produtos tributados por unidade)"
            );
            $this->dom->addChild(
                $ipiTrib,
                "vUnid",
                $this->conditionalNumberFormatting($std->vUnid, 4),
                false,
                "[item $std->item] Valor por Unidade Tributável"
            );
            $this->dom->addChild(
                $ipiTrib,
                "vIPI",
                $this->conditionalNumberFormatting($std->vIPI),
                true,
                "[item $std->item] Valor do IPI"
            );
            $ipi->appendChild($ipiTrib);
        } else {
            $ipINT = $this->dom->createElement('IPINT');
            $this->dom->addChild(
                $ipINT,
                "CST",
                $std->CST,
                true,
                "[item $std->item] Código da situação tributária do IPINT"
            );
            $ipi->appendChild($ipINT);
        }
        $this->aIPI[$std->item] = $ipi;
        return $ipi;
    }

    /**
     * Grupo Imposto de Importação P01 pai M01
     * tag NFe/infNFe/det[]/imposto/II
     */
    public function tagII(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vBC',
            'vDespAdu',
            'vII',
            'vIOF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        //totalizador
        $this->stdTot->vII += (float) $std->vII;
        $tii = $this->dom->createElement('II');
        $this->dom->addChild(
            $tii,
            "vBC",
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "[item $std->item] Valor BC do Imposto de Importação"
        );
        $this->dom->addChild(
            $tii,
            "vDespAdu",
            $this->conditionalNumberFormatting($std->vDespAdu),
            true,
            "[item $std->item] Valor despesas aduaneiras"
        );
        $this->dom->addChild(
            $tii,
            "vII",
            $this->conditionalNumberFormatting($std->vII),
            true,
            "[item $std->item] Valor Imposto de Importação"
        );
        $this->dom->addChild(
            $tii,
            "vIOF",
            $this->conditionalNumberFormatting($std->vIOF),
            true,
            "[item $std->item] Valor Imposto sobre Operações Financeiras"
        );
        $this->aII[$std->item] = $tii;
        return $tii;
    }

    /**
     * Grupo PIS Q01 pai M01
     * tag NFe/infNFe/det[]/imposto/PIS
     */
    public function tagPIS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CST',
            'vBC',
            'pPIS',
            'vPIS',
            'qBCProd',
            'vAliqProd'
        ];
        $std = $this->equilizeParameters($std, $possible);

        switch ($std->CST) {
            case '01':
            case '02':
                $pisItem = $this->dom->createElement('PISAliq');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $std->CST,
                    true,
                    "[item $std->item] Código de Situação Tributária do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "[item $std->item] Valor da Base de Cálculo do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'pPIS',
                    $this->conditionalNumberFormatting($std->pPIS, 4),
                    true,
                    "[item $std->item] Alíquota do PIS (em percentual)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $this->conditionalNumberFormatting($std->vPIS),
                    true,
                    "[item $std->item] Valor do PIS"
                );
                //totalizador
                $this->stdTot->vPIS += (float) !empty($std->vPIS) ? $std->vPIS : 0;
                break;
            case '03':
                $pisItem = $this->dom->createElement('PISQtde');
                $this->dom->addChild(
                    $pisItem,
                    'CST',
                    $std->CST,
                    true,
                    "[item $std->item] Código de Situação Tributária do PIS"
                );
                $this->dom->addChild(
                    $pisItem,
                    'qBCProd',
                    $this->conditionalNumberFormatting($std->qBCProd, 4),
                    true,
                    "[item $std->item] Quantidade Vendida"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vAliqProd',
                    $this->conditionalNumberFormatting($std->vAliqProd, 4),
                    true,
                    "[item $std->item] Alíquota do PIS (em reais)"
                );
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $this->conditionalNumberFormatting($std->vPIS),
                    true,
                    "[item $std->item] Valor do PIS"
                );
                //totalizador
                $this->stdTot->vPIS += (float) !empty($std->vPIS) ? $std->vPIS : 0;
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
                    $std->CST,
                    true,
                    "[item $std->item] Código de Situação Tributária do PIS"
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
                    $std->CST,
                    true,
                    "[item $std->item] Código de Situação Tributária do PIS"
                );
                if (!isset($std->qBCProd)) {
                    $this->dom->addChild(
                        $pisItem,
                        'vBC',
                        $this->conditionalNumberFormatting($std->vBC),
                        ($std->vBC !== null) ? true : false,
                        "[item $std->item] Valor da Base de Cálculo do PIS"
                    );
                    $this->dom->addChild(
                        $pisItem,
                        'pPIS',
                        $this->conditionalNumberFormatting($std->pPIS, 4),
                        ($std->pPIS !== null) ? true : false,
                        "[item $std->item] Alíquota do PIS (em percentual)"
                    );
                } else {
                    $this->dom->addChild(
                        $pisItem,
                        'qBCProd',
                        $this->conditionalNumberFormatting($std->qBCProd, 4),
                        ($std->qBCProd !== null) ? true : false,
                        "[item $std->item] Quantidade Vendida"
                    );
                    $this->dom->addChild(
                        $pisItem,
                        'vAliqProd',
                        $this->conditionalNumberFormatting($std->vAliqProd, 4),
                        ($std->vAliqProd !== null) ? true : false,
                        "[item $std->item] Alíquota do PIS (em reais)"
                    );
                }
                $this->dom->addChild(
                    $pisItem,
                    'vPIS',
                    $this->conditionalNumberFormatting($std->vPIS),
                    ($std->vPIS !== null) ? true : false,
                    "[item $std->item] Valor do PIS"
                );
                //totalizador
                $this->stdTot->vPIS += (float) !empty($std->vPIS) ? $std->vPIS : 0;
                break;
        }
        $pis = $this->dom->createElement('PIS');
        if (isset($pisItem)) {
            $pis->appendChild($pisItem);
        }

        $this->aPIS[$std->item] = $pis;
        return $pis;
    }

    /**
     * Grupo PIS Substituição Tributária R01 pai M01
     * tag NFe/infNFe/det[]/imposto/PISST (opcional)
     */
    public function tagPISST(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vPIS',
            'vBC',
            'pPIS',
            'qBCProd',
            'vAliqProd',
            'indSomaPISST',
        ];
        $std = $this->equilizeParameters($std, $possible);
        if ($std->indSomaPISST == 1) {
            $this->stdTot->vPISST += $std->vPIS;
        }
        $pisst = $this->dom->createElement('PISST');
        if (!isset($std->qBCProd)) {
            $this->dom->addChild(
                $pisst,
                'vBC',
                $this->conditionalNumberFormatting($std->vBC),
                true,
                "[item $std->item] Valor da Base de Cálculo do PIS"
            );
            $this->dom->addChild(
                $pisst,
                'pPIS',
                $this->conditionalNumberFormatting($std->pPIS, 4),
                true,
                "[item $std->item] Alíquota do PIS (em percentual)"
            );
        } else {
            $this->dom->addChild(
                $pisst,
                'qBCProd',
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                true,
                "[item $std->item] Quantidade Vendida"
            );
            $this->dom->addChild(
                $pisst,
                'vAliqProd',
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                true,
                "[item $std->item] Alíquota do PIS (em reais)"
            );
        }
        $this->dom->addChild(
            $pisst,
            'vPIS',
            $this->conditionalNumberFormatting($std->vPIS),
            true,
            "[item $std->item] Valor do PIS"
        );
        $this->dom->addChild(
            $pisst,
            'indSomaPISST',
            $std->indSomaPISST ?? null,
            false,
            "[item $std->item] Indica se o valor do PISST compõe o valor total da NF-e"
        );
        $this->aPISST[$std->item] = $pisst;
        return $pisst;
    }

    /**
     * Grupo COFINS S01 pai M01
     * tag det[item]/imposto/COFINS (opcional)
     */
    public function tagCOFINS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CST',
            'vBC',
            'pCOFINS',
            'vCOFINS',
            'qBCProd',
            'vAliqProd'
        ];
        $std = $this->equilizeParameters($std, $possible);
        switch ($std->CST) {
            case '01':
            case '02':
                $confinsItem = $this->buildCOFINSAliq($std);
                //totalizador
                $this->stdTot->vCOFINS += (float) $std->vCOFINS;
                break;
            case '03':
                $confinsItem = $this->dom->createElement('COFINSQtde');
                $this->dom->addChild(
                    $confinsItem,
                    'CST',
                    $std->CST,
                    true,
                    "[item $std->item] Código de Situação Tributária da COFINS"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'qBCProd',
                    $this->conditionalNumberFormatting($std->qBCProd, 4),
                    true,
                    "[item $std->item] Quantidade Vendida"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'vAliqProd',
                    $this->conditionalNumberFormatting($std->vAliqProd, 4),
                    true,
                    "[item $std->item] Alíquota do COFINS (em reais)"
                );
                $this->dom->addChild(
                    $confinsItem,
                    'vCOFINS',
                    $this->conditionalNumberFormatting($std->vCOFINS),
                    true,
                    "[item $std->item] Valor do COFINS"
                );
                //totalizador
                $this->stdTot->vCOFINS += (float) $std->vCOFINS;
                break;
            case '04':
            case '05':
            case '06':
            case '07':
            case '08':
            case '09':
                $confinsItem = $this->buildCOFINSNT($std);
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
                $confinsItem = $this->buildCOFINSoutr($std);
                //totalizador
                $this->stdTot->vCOFINS += (float) $std->vCOFINS;
                break;
        }
        $confins = $this->dom->createElement('COFINS');
        if (isset($confinsItem)) {
            $confins->appendChild($confinsItem);
        }
        $this->aCOFINS[$std->item] = $confins;
        return $confins;
    }

    /**
     * Grupo COFINS Substituição Tributária T01 pai M01
     * tag NFe/infNFe/det[]/imposto/COFINSST (opcional)
     */
    public function tagCOFINSST(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vCOFINS',
            'vBC',
            'pCOFINS',
            'qBCProd',
            'vAliqProd',
            'indSomaCOFINSST'
        ];
        $std = $this->equilizeParameters($std, $possible);
        if ($std->indSomaCOFINSST == 1) {
            $this->stdTot->vCOFINSST += $std->vCOFINS;
        }
        $cofinsst = $this->dom->createElement("COFINSST");
        if (!isset($std->qBCProd)) {
            $this->dom->addChild(
                $cofinsst,
                "vBC",
                $this->conditionalNumberFormatting($std->vBC),
                true,
                "[item $std->item] Valor da Base de Cálculo da COFINS"
            );
            $this->dom->addChild(
                $cofinsst,
                "pCOFINS",
                $this->conditionalNumberFormatting($std->pCOFINS, 4),
                true,
                "[item $std->item] Alíquota da COFINS (em percentual)"
            );
        } else {
            $this->dom->addChild(
                $cofinsst,
                "qBCProd",
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                true,
                "[item $std->item] Quantidade Vendida"
            );
            $this->dom->addChild(
                $cofinsst,
                "vAliqProd",
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                true,
                "[item $std->item] Alíquota da COFINS (em reais)"
            );
        }
        $this->dom->addChild(
            $cofinsst,
            "vCOFINS",
            $this->conditionalNumberFormatting($std->vCOFINS),
            true,
            "[item $std->item] Valor da COFINS"
        );
        $this->dom->addChild(
            $cofinsst,
            "indSomaCOFINSST",
            $std->indSomaCOFINSST ?? null,
            false,
            "[item $std->item] Valor da COFINS"
        );
        $this->aCOFINSST[$std->item] = $cofinsst;
        return $cofinsst;
    }

    /**
     * Grupo ISSQN U01 pai M01
     * tag NFe/infNFe/det[]/imposto/ISSQN (opcional)
     */
    public function tagISSQN(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vBC',
            'vAliq',
            'vISSQN',
            'cMunFG',
            'cListServ',
            'vDeducao',
            'vOutro',
            'vDescIncond',
            'vDescCond',
            'vISSRet',
            'indISS',
            'cServico',
            'cMun',
            'cPais',
            'nProcesso',
            'indIncentivo'
        ];
        $std = $this->equilizeParameters($std, $possible);

        // Adiciona o totalizador, somente se maior que ZERO
        empty($std->vBC) ?: $this->stdISSQNTot->vBC += (float) $std->vBC;
        empty($std->vISSQN) ?: $this->stdISSQNTot->vISS += $std->vISSQN ?? 0.0;
        empty($std->vISSRet) ?: $this->stdISSQNTot->vISSRet += $std->vISSRet ?? 0.0;
        empty($std->vDeducao) ?: $this->stdISSQNTot->vDeducao += $std->vDeducao ?? 0.0;
        empty($std->vOutro) ?: $this->stdISSQNTot->vOutro += $std->vOutro ?? 0.0;
        empty($std->vDescIncond) ?: $this->stdISSQNTot->vDescIncond += $std->vDescIncond ?? 0.0;
        empty($std->vDescCond) ?: $this->stdISSQNTot->vDescCond += $std->vDescCond ?? 0.0;

        $this->aItensServ[] = $std->item;

        // totalizador
        if ($this->aProd[$std->item]->getElementsByTagName('indTot')->item(0)->nodeValue == 1) {
            // Captura o valor do item
            $vProd = (float) ($this->aProd[$std->item]->getElementsByTagName('vProd')->item(0)->nodeValue);

            // Remove o valor to totalizador de produtos e Adiciona o valor do item no totalizador de serviços
            $this->stdTot->vProd -= $vProd;
            $this->stdISSQNTot->vServ += $vProd;
        }

        $issqn = $this->dom->createElement("ISSQN");
        $this->dom->addChild(
            $issqn,
            "vBC",
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "[item $std->item] Valor da Base de Cálculo do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "vAliq",
            $this->conditionalNumberFormatting($std->vAliq, 4),
            true,
            "[item $std->item] Alíquota do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "vISSQN",
            $this->conditionalNumberFormatting($std->vISSQN),
            true,
            "[item $std->item] Valor do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "cMunFG",
            $std->cMunFG,
            true,
            "[item $std->item] Código do município de ocorrência do fato gerador do ISSQN"
        );
        $this->dom->addChild(
            $issqn,
            "cListServ",
            $std->cListServ,
            true,
            "[item $std->item] Item da Lista de Serviços"
        );
        $this->dom->addChild(
            $issqn,
            "vDeducao",
            $this->conditionalNumberFormatting($std->vDeducao),
            false,
            "[item $std->item] Valor dedução para redução da Base de Cálculo"
        );
        $this->dom->addChild(
            $issqn,
            "vOutro",
            $this->conditionalNumberFormatting($std->vOutro),
            false,
            "[item $std->item] Valor outras retenções"
        );
        $this->dom->addChild(
            $issqn,
            "vDescIncond",
            $this->conditionalNumberFormatting($std->vDescIncond),
            false,
            "[item $std->item] Valor desconto incondicionado"
        );
        $this->dom->addChild(
            $issqn,
            "vDescCond",
            $this->conditionalNumberFormatting($std->vDescCond),
            false,
            "[item $std->item] Valor desconto condicionado"
        );
        $this->dom->addChild(
            $issqn,
            "vISSRet",
            $this->conditionalNumberFormatting($std->vISSRet),
            false,
            "[item $std->item] Valor retenção ISS"
        );
        $this->dom->addChild(
            $issqn,
            "indISS",
            $std->indISS,
            true,
            "[item $std->item] Indicador da exigibilidade do ISS"
        );
        $this->dom->addChild(
            $issqn,
            "cServico",
            $std->cServico,
            false,
            "[item $std->item] Código do serviço prestado dentro do município"
        );
        $this->dom->addChild(
            $issqn,
            "cMun",
            $std->cMun,
            false,
            "[item $std->item] Código do Município de incidência do imposto"
        );
        $this->dom->addChild(
            $issqn,
            "cPais",
            $std->cPais,
            false,
            "[item $std->item] Código do País onde o serviço foi prestado"
        );
        $this->dom->addChild(
            $issqn,
            "nProcesso",
            $std->nProcesso,
            false,
            "[item $std->item] Número do processo judicial ou administrativo de suspensão da exigibilidade"
        );
        $this->dom->addChild(
            $issqn,
            "indIncentivo",
            $std->indIncentivo,
            true,
            "[item $std->item] Indicador de incentivo Fiscal"
        );
        $this->aISSQN[$std->item] = $issqn;
        return $issqn;
    }

    /**
     * Informação do Imposto devolvido U50 pai H01
     * tag NFe/infNFe/det[]/impostoDevol (opcional)
     */
    public function tagimpostoDevol(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'pDevol',
            'vIPIDevol'
        ];
        $std = $this->equilizeParameters($std, $possible);
        //totalizador
        $this->stdTot->vIPIDevol += (float) $std->vIPIDevol;
        $impostoDevol = $this->dom->createElement("impostoDevol");
        $this->dom->addChild(
            $impostoDevol,
            "pDevol",
            $this->conditionalNumberFormatting($std->pDevol, 2),
            true,
            "[item $std->item] Percentual da mercadoria devolvida"
        );
        $parent = $this->dom->createElement("IPI");
        $this->dom->addChild(
            $parent,
            "vIPIDevol",
            $this->conditionalNumberFormatting($std->vIPIDevol),
            true,
            "[item $std->item] Valor do IPI devolvido"
        );
        $impostoDevol->appendChild($parent);
        $this->aImpostoDevol[$std->item] = $impostoDevol;
        return $impostoDevol;
    }

    /**
     * Grupo Totais referentes ao ICMS W02 pai W01
     * tag NFe/infNFe/total/ICMSTot
     */
    public function tagICMSTot(?stdClass $std = null): DOMElement
    {
        $this->buildTotal();
        $possible = [
            'vBC',
            'vICMS',
            'vICMSDeson',
            'vBCST',
            'vST',
            'vProd',
            'vFrete',
            'vSeg',
            'vDesc',
            'vII',
            'vIPI',
            'vPIS',
            'vCOFINS',
            'vOutro',
            'vNF',
            'vIPIDevol',
            'vTotTrib',
            'vFCP',
            'vFCPST',
            'vFCPSTRet',
            'vFCPUFDest',
            'vICMSUFDest',
            'vICMSUFRemet',
            'qBCMono',
            'vICMSMono',
            'qBCMonoReten',
            'vICMSMonoReten',
            'qBCMonoRet',
            'vICMSMonoRet',
        ];
        if (isset($std)) {
            $std = $this->equilizeParameters($std, $possible);
        }
        $this->stdICMSTot = $std;

        $vBC = $std->vBC ?? $this->stdTot->vBC;
        $vICMS = $std->vICMS ?? $this->stdTot->vICMS;
        $vICMSDeson = !empty($std->vICMSDeson) ? $std->vICMSDeson : $this->stdTot->vICMSDeson;
        $vBCST = !empty($std->vBCST) ? $std->vBCST : $this->stdTot->vBCST;
        $vST = !empty($std->vST) ? $std->vST : $this->stdTot->vST;
        $vProd = !empty($std->vProd) ? $std->vProd : $this->stdTot->vProd;
        $vFrete = !empty($std->vFrete) ? $std->vFrete : $this->stdTot->vFrete;
        $vSeg = !empty($std->vSeg) ? $std->vSeg : $this->stdTot->vSeg;
        $vDesc = !empty($std->vDesc) ? $std->vDesc : $this->stdTot->vDesc;
        $vII = !empty($std->vII) ? $std->vII : $this->stdTot->vII;
        $vIPI = !empty($std->vIPI) ? $std->vIPI : $this->stdTot->vIPI;
        $vPIS = !empty($std->vPIS) ? $std->vPIS : $this->stdTot->vPIS;
        $vCOFINS = !empty($std->vCOFINS) ? $std->vCOFINS : $this->stdTot->vCOFINS;
        $vOutro = !empty($std->vOutro) ? $std->vOutro : $this->stdTot->vOutro;
        $vNF = !empty($std->vNF) ? $std->vNF : $this->stdTot->vNF;
        $vIPIDevol = !empty($std->vIPIDevol) ? $std->vIPIDevol : $this->stdTot->vIPIDevol;
        $vTotTrib = !empty($std->vTotTrib) ? $std->vTotTrib : $this->stdTot->vTotTrib;
        $vFCP = !empty($std->vFCP) ? $std->vFCP : $this->stdTot->vFCP;
        $vFCPST = !empty($std->vFCPST) ? $std->vFCPST : $this->stdTot->vFCPST;
        $vFCPSTRet = !empty($std->vFCPSTRet) ? $std->vFCPSTRet : $this->stdTot->vFCPSTRet;
        $vFCPUFDest = !empty($std->vFCPUFDest) ? $std->vFCPUFDest : $this->stdTot->vFCPUFDest;
        $vICMSUFDest = !empty($std->vICMSUFDest) ? $std->vICMSUFDest : $this->stdTot->vICMSUFDest;
        $vICMSUFRemet = !empty($std->vICMSUFRemet) ? $std->vICMSUFRemet : $this->stdTot->vICMSUFRemet;
        $qBCMono = !empty($std->qBCMono) ? $std->qBCMono : $this->stdTot->qBCMono;
        $vICMSMono = !empty($std->vICMSMono) ? $std->vICMSMono : $this->stdTot->vICMSMono;
        $qBCMonoReten = !empty($std->qBCMonoReten) ? $std->qBCMonoReten : $this->stdTot->qBCMonoReten;
        $vICMSMonoReten = !empty($std->vICMSMonoReten) ? $std->vICMSMonoReten : $this->stdTot->vICMSMonoReten;
        $qBCMonoRet = !empty($std->qBCMonoRet) ? $std->qBCMonoRet : $this->stdTot->qBCMonoRet;
        $vICMSMonoRet = !empty($std->vICMSMonoRet) ? $std->vICMSMonoRet : $this->stdTot->vICMSMonoRet;

        //campos opcionais incluir se maior que zero
        $vFCPUFDest = ($vFCPUFDest > 0) ? number_format($vFCPUFDest, 2, '.', '') : null;
        $vICMSUFDest = ($vICMSUFDest > 0) ? number_format($vICMSUFDest, 2, '.', '') : null;
        $vICMSUFRemet = ($vICMSUFRemet > 0) ? number_format($vICMSUFRemet, 2, '.', '') : null;
        $vTotTrib = ($vTotTrib > 0) ? number_format($vTotTrib, 2, '.', '') : null;


        //campos obrigatórios para 4.00
        $vFCP = number_format($vFCP, 2, '.', '');
        $vFCPST = number_format($vFCPST, 2, '.', '');
        $vFCPSTRet = number_format($vFCPSTRet, 2, '.', '');
        $vIPIDevol = number_format($vIPIDevol, 2, '.', '');

        $ICMSTot = $this->dom->createElement("ICMSTot");
        $this->dom->addChild(
            $ICMSTot,
            "vBC",
            $this->conditionalNumberFormatting($vBC),
            true,
            "Base de Cálculo do ICMS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMS",
            $this->conditionalNumberFormatting($vICMS),
            true,
            "Valor Total do ICMS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSDeson",
            $this->conditionalNumberFormatting($vICMSDeson),
            true,
            "Valor Total do ICMS desonerado"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFCPUFDest",
            $this->conditionalNumberFormatting($vFCPUFDest),
            false,
            "Valor total do ICMS relativo ao Fundo de Combate à Pobreza(FCP) "
                . "para a UF de destino"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSUFDest",
            $this->conditionalNumberFormatting($vICMSUFDest),
            false,
            "Valor total do ICMS de partilha para a UF do destinatário"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSUFRemet",
            $this->conditionalNumberFormatting($vICMSUFRemet),
            false,
            "Valor total do ICMS de partilha para a UF do remetente"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vFCP",
            $this->conditionalNumberFormatting($vFCP),
            false,
            "Valor total do ICMS relativo ao Fundo de Combate à Pobreza(FCP) "
                . "para a UF de destino"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vBCST",
            $this->conditionalNumberFormatting($vBCST),
            true,
            "Base de Cálculo do ICMS ST"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vST",
            $this->conditionalNumberFormatting($vST),
            true,
            "Valor Total do ICMS ST"
        );
        //incluso na 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vFCPST",
            $this->conditionalNumberFormatting($vFCPST),
            false, //true para 4.00
            "Valor Total do FCP (Fundo de Combate à Pobreza) "
                . "retido por substituição tributária"
        );
        //incluso na 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vFCPSTRet",
            $this->conditionalNumberFormatting($vFCPSTRet),
            false, //true para 4.00
            "Valor Total do FCP retido anteriormente por "
                . "Substituição Tributária"
        );
        //incluso NT 2023.001-1.10
        $this->dom->addChild(
            $ICMSTot,
            "qBCMono",
            $this->conditionalNumberFormatting(!empty($qBCMono) ? $qBCMono : null),
            false,
            "Valor total da quantidade tributada do ICMS monofásico próprio"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSMono",
            $this->conditionalNumberFormatting(!empty($vICMSMono) ? $vICMSMono : null),
            false,
            "Valor total do ICMS monofásico próprio"
        );
        $this->dom->addChild(
            $ICMSTot,
            "qBCMonoReten",
            $this->conditionalNumberFormatting(!empty($qBCMonoReten) ? $qBCMonoReten : null),
            false,
            "Valor total da quantidade tributada do ICMS monofásico sujeito a retenção"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSMonoReten",
            $this->conditionalNumberFormatting(!empty($vICMSMonoReten) ? $vICMSMonoReten : null),
            false,
            "Valor total do ICMS monofásico sujeito a retenção"
        );
        $this->dom->addChild(
            $ICMSTot,
            "qBCMonoRet",
            $this->conditionalNumberFormatting(!empty($qBCMonoRet) ? $qBCMonoRet : null),
            false,
            "Valor total da quantidade tributada do ICMS monofásico retido anteriormente"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSMonoRet",
            $this->conditionalNumberFormatting(!empty($vICMSMonoRet) ? $vICMSMonoRet : null),
            false,
            "Valor total do ICMS monofásico retido anteriormente"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vProd",
            $this->conditionalNumberFormatting($vProd),
            true,
            "Valor Total dos produtos e serviços"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFrete",
            $this->conditionalNumberFormatting($vFrete),
            true,
            "Valor Total do Frete"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vSeg",
            $this->conditionalNumberFormatting($vSeg),
            true,
            "Valor Total do Seguro"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vDesc",
            $this->conditionalNumberFormatting($vDesc),
            true,
            "Valor Total do Desconto"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vII",
            $this->conditionalNumberFormatting($vII),
            true,
            "Valor Total do II"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vIPI",
            $this->conditionalNumberFormatting($vIPI),
            true,
            "Valor Total do IPI"
        );
        //incluso 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vIPIDevol",
            $this->conditionalNumberFormatting($vIPIDevol),
            false,
            "Valor Total do IPI"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vPIS",
            $this->conditionalNumberFormatting($vPIS),
            true,
            "Valor do PIS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vCOFINS",
            $this->conditionalNumberFormatting($vCOFINS),
            true,
            "Valor da COFINS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vOutro",
            $this->conditionalNumberFormatting($vOutro),
            true,
            "Outras Despesas acessórias"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vNF",
            $this->conditionalNumberFormatting($vNF),
            true,
            "Valor Total da NF-e"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vTotTrib",
            $this->conditionalNumberFormatting($vTotTrib),
            false,
            "Valor aproximado total de tributos federais, estaduais e municipais."
        );
        $this->ICMSTot = $ICMSTot;
        return $ICMSTot;
    }

    /**
     * Grupo Totais referentes ao ISSQN W17 pai W01
     * tag NFe/infNFe/total/ISSQNTot (opcional)
     * @return DOMElement|void
     */
    public function tagISSQNTot(?stdClass $std = null)
    {
        if (empty($this->aItensServ)) {
            //não existem itens com ISSQN
            return;
        }
        $this->buildISSQNTot();
        $possible = [
            'vServ',
            'vBC',
            'vISS',
            'vPIS',
            'vCOFINS',
            'dCompet',
            'vDeducao',
            'vOutro',
            'vDescIncond',
            'vDescCond',
            'vISSRet',
            'cRegTrib'
        ];
        if (isset($std)) {
            $std = $this->equilizeParameters($std, $possible);
        }
        $this->stdISSQN = $std;

        $vServ = $std->vServ ?? $this->stdISSQNTot->vServ;
        $vBC = $std->vBC ?? $this->stdISSQNTot->vBC;
        $vISS = $std->vISS ?? $this->stdISSQNTot->vISS;
        $vPIS = $std->vPIS ?? $this->stdISSQNTot->vPIS;
        $vCOFINS = $std->vCOFINS ?? $this->stdISSQNTot->vCOFINS;
        $dCompet = $std->dCompet ?? date('Y-m-d');
        $vDeducao = $std->vDeducao ?? $this->stdISSQNTot->vDeducao;
        $vOutro = $std->vOutro ?? $this->stdISSQNTot->vOutro;
        $vDescIncond = $std->vDescIncond ?? $this->stdISSQNTot->vDescIncond;
        $vDescCond = $std->vDescCond ?? $this->stdISSQNTot->vDescCond;
        $vISSRet = $std->vISSRet ?? $this->stdISSQNTot->vISSRet;
        $cRegTrib = $std->cRegTrib ?? $this->stdISSQNTot->cRegTrib;

        //nulificar caso seja menor ou igual a ZERO
        $vServ = ($vServ > 0) ? number_format($vServ, 2, '.', '') : null;
        $vBC = ($vBC > 0) ? number_format($vBC, 2, '.', '') : null;
        $vISS = ($vISS > 0) ? number_format($vISS, 2, '.', '') : null;
        $vPIS = ($vPIS > 0) ? number_format($vPIS, 2, '.', '') : null;
        $vCOFINS = ($vCOFINS > 0) ? number_format($vCOFINS, 2, '.', '') : null;
        $vDeducao = ($vDeducao > 0) ? number_format($vDeducao, 2, '.', '') : null;
        $vOutro = ($vOutro > 0) ? number_format($vOutro, 2, '.', '') : null;
        $vDescIncond = ($vDescIncond > 0) ? number_format($vDescIncond, 2, '.', '') : null;
        $vDescCond = ($vDescCond > 0) ? number_format($vDescCond, 2, '.', '') : null;
        $vISSRet = ($vISSRet > 0) ? number_format($vISSRet, 2, '.', '') : null;

        $ISSQNTot = $this->dom->createElement("ISSQNtot");
        $this->dom->addChild(
            $ISSQNTot,
            "vServ",
            $this->conditionalNumberFormatting($vServ),
            false,
            "Valor total dos Serviços sob não incidência ou não tributados pelo ICMS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vBC",
            $this->conditionalNumberFormatting($vBC),
            false,
            "Valor total Base de Cálculo do ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vISS",
            $this->conditionalNumberFormatting($vISS),
            false,
            "Valor total do ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vPIS",
            $this->conditionalNumberFormatting($vPIS),
            false,
            "Valor total do PIS sobre serviços"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vCOFINS",
            $this->conditionalNumberFormatting($vCOFINS),
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
            $this->conditionalNumberFormatting($vDeducao),
            false,
            "Valor total dedução para redução da Base de Cálculo"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vOutro",
            $this->conditionalNumberFormatting($vOutro),
            false,
            "Valor total outras retenções"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDescIncond",
            $this->conditionalNumberFormatting($vDescIncond),
            false,
            "Valor total desconto incondicionado"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDescCond",
            $this->conditionalNumberFormatting($vDescCond),
            false,
            "Valor total desconto condicionado"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vISSRet",
            $this->conditionalNumberFormatting($vISSRet),
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
        $this->ISSQNTot = $ISSQNTot;
        return $ISSQNTot;
    }

    /**
     * Grupo Retenções de Tributos W23 pai W01
     * tag NFe/infNFe/total/reTrib (opcional)
     */
    public function tagretTrib(stdClass $std): DOMElement
    {
        $possible = [
            'vRetPIS',
            'vRetCOFINS',
            'vRetCSLL',
            'vBCIRRF',
            'vIRRF',
            'vBCRetPrev',
            'vRetPrev'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $retTrib = $this->dom->createElement("retTrib");
        $this->dom->addChild(
            $retTrib,
            "vRetPIS",
            $this->conditionalNumberFormatting($std->vRetPIS),
            false,
            "Valor Retido de PIS"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetCOFINS",
            $this->conditionalNumberFormatting($std->vRetCOFINS),
            false,
            "Valor Retido de COFINS"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetCSLL",
            $this->conditionalNumberFormatting($std->vRetCSLL),
            false,
            "Valor Retido de CSLL"
        );
        $this->dom->addChild(
            $retTrib,
            "vBCIRRF",
            $this->conditionalNumberFormatting($std->vBCIRRF),
            false,
            "Base de Cálculo do IRRF"
        );
        $this->dom->addChild(
            $retTrib,
            "vIRRF",
            $this->conditionalNumberFormatting($std->vIRRF),
            false,
            "Valor Retido do IRRF"
        );
        $this->dom->addChild(
            $retTrib,
            "vBCRetPrev",
            $this->conditionalNumberFormatting($std->vBCRetPrev),
            false,
            "Base de Cálculo da Retenção da Previdência Social"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetPrev",
            $this->conditionalNumberFormatting($std->vRetPrev),
            false,
            "Valor da Retenção da Previdência Social"
        );
        $this->retTrib = $retTrib;
        //$this->dom->appChild($this->total, $retTrib, '');
        return $retTrib;
    }

    /**
     * Grupo Informações do Transporte X01 pai A01
     * tag NFe/infNFe/transp (obrigatório)
     */
    public function tagtransp(stdClass $std): DOMElement
    {
        $this->transp = $this->dom->createElement("transp");
        $this->dom->addChild(
            $this->transp,
            "modFrete",
            $std->modFrete,
            true,
            "Modalidade do frete"
        );
        return $this->transp;
    }

    /**
     * Grupo Transportador X03 pai X01
     * tag NFe/infNFe/transp/tranporta (opcional)
     */
    public function tagtransporta(stdClass $std): DOMElement
    {
        $possible = [
            'xNome',
            'IE',
            'xEnder',
            'xMun',
            'UF',
            'CNPJ',
            'CPF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $transporta = $this->dom->createElement("transporta");
        $this->dom->addChild(
            $transporta,
            "CNPJ",
            $std->CNPJ,
            false,
            "CNPJ do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "CPF",
            $std->CPF,
            false,
            "CPF do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xNome",
            $std->xNome,
            false,
            "Razão Social ou nome do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "IE",
            $std->IE,
            false,
            "Inscrição Estadual do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xEnder",
            $std->xEnder,
            false,
            "Endereço Completo do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "xMun",
            $std->xMun,
            false,
            "Nome do município do Transportador"
        );
        $this->dom->addChild(
            $transporta,
            "UF",
            $std->UF,
            false,
            "Sigla da UF do Transportador"
        );
        $this->dom->appChild(
            $this->transp,
            $transporta,
            'A tag transp deveria ter sido carregada primeiro.'
        );
        $this->dom->appChild($this->transp, $transporta, "Inclusão do node vol");
        return $transporta;
    }

    /**
     * Grupo Retenção ICMS transporte X11 pai X01
     * tag NFe/infNFe/transp/retTransp (opcional)
     */
    public function tagretTransp(stdClass $std): DOMElement
    {
        $possible = [
            'vServ',
            'vBCRet',
            'pICMSRet',
            'vICMSRet',
            'CFOP',
            'cMunFG'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $retTransp = $this->dom->createElement("retTransp");
        $this->dom->addChild(
            $retTransp,
            "vServ",
            $this->conditionalNumberFormatting($std->vServ),
            true,
            "Valor do Serviço"
        );
        $this->dom->addChild(
            $retTransp,
            "vBCRet",
            $this->conditionalNumberFormatting($std->vBCRet),
            true,
            "BC da Retenção do ICMS"
        );
        $this->dom->addChild(
            $retTransp,
            "pICMSRet",
            $this->conditionalNumberFormatting($std->pICMSRet, 4),
            true,
            "Alíquota da Retenção"
        );
        $this->dom->addChild(
            $retTransp,
            "vICMSRet",
            $this->conditionalNumberFormatting($std->vICMSRet),
            true,
            "Valor do ICMS Retido"
        );
        $this->dom->addChild(
            $retTransp,
            "CFOP",
            $std->CFOP,
            true,
            "CFOP"
        );
        $this->dom->addChild(
            $retTransp,
            "cMunFG",
            $std->cMunFG,
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
     * Grupo Veículo Transporte X18 pai X17.1
     * tag NFe/infNFe/transp/veicTransp (opcional)
     * Ajustado NT 2020.005 v1.20
     */
    public function tagveicTransp(stdClass $std): DOMElement
    {
        $possible = [
            'placa',
            'UF',
            'RNTC'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $veicTransp = $this->dom->createElement("veicTransp");
        $this->dom->addChild(
            $veicTransp,
            "placa", // X19
            $std->placa,
            true,
            "Placa do Veículo"
        );
        $this->dom->addChild(
            $veicTransp,
            "UF", // X20
            $std->UF,
            false,
            "Sigla da UF do Veículo"
        );
        $this->dom->addChild(
            $veicTransp,
            "RNTC", // X21
            $std->RNTC,
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
     * Ajustado NT 2020.005 v1.20
     */
    public function tagreboque(stdClass $std): DOMElement
    {
        $possible = [
            'placa',
            'UF',
            'RNTC'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $reboque = $this->dom->createElement("reboque");
        $this->dom->addChild(
            $reboque,
            "placa", // X23
            $std->placa,
            true,
            "Placa do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "UF", // X24
            $std->UF,
            false,
            "Sigla da UF do Veículo Reboque"
        );
        $this->dom->addChild(
            $reboque,
            "RNTC", // X25
            $std->RNTC,
            false,
            "Registro Nacional de Transportador de Carga (ANTT) do Veículo Reboque"
        );
        $this->dom->appChild(
            $this->transp,
            $reboque,
            'A tag transp deveria ter sido carregada primeiro.'
        );
        return $reboque;
    }

    /**
     * Campo Vagao X25a pai X01
     * tag NFe/infNFe/transp/vagao (opcional)
     */
    public function tagvagao(stdClass $std)
    {
        $possible = [
            'vagao'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->dom->addChild(
            $this->transp,
            "vagao",
            $std->vagao,
            false,
            "Identificação do vagão do Veículo Reboque"
        );
    }

    /**
     * Campo Balsa X25b pai X01
     * tag NFe/infNFe/transp/balsa (opcional)
     */
    public function tagbalsa(stdClass $std)
    {
        $possible = [
            'balsa'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->dom->addChild(
            $this->transp,
            "balsa",
            $std->balsa,
            false,
            "Identificação da balsa do Veículo Reboque"
        );
    }

    /**
     * Grupo Volumes X26 pai X01
     * tag NFe/infNFe/transp/vol (opcional)
     */
    public function tagvol(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'qVol',
            'esp',
            'marca',
            'nVol',
            'pesoL',
            'pesoB'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $vol = $this->dom->createElement("vol");
        $this->dom->addChild(
            $vol,
            "qVol",
            $this->conditionalNumberFormatting($std->qVol, 0),
            false,
            "Quantidade de volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "esp",
            $std->esp,
            false,
            "Espécie dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "marca",
            $std->marca,
            false,
            "Marca dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "nVol",
            $std->nVol,
            false,
            "Numeração dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "pesoL",
            $this->conditionalNumberFormatting($std->pesoL, 3),
            false,
            "Peso Líquido (em kg) dos volumes transportados"
        );
        $this->dom->addChild(
            $vol,
            "pesoB",
            $this->conditionalNumberFormatting($std->pesoB, 3),
            false,
            "Peso Bruto (em kg) dos volumes transportados"
        );
        $this->aVol[$std->item] = $vol;
        return $vol;
    }

    /**
     * Grupo Lacres X33 pai X26
     * tag NFe/infNFe/transp/vol/lacres (opcional)
     */
    public function taglacres(stdClass $std): DOMElement
    {
        $lacre = $this->dom->createElement("lacres");
        $this->dom->addChild(
            $lacre,
            "nLacre",
            $std->nLacre,
            true,
            "Número dos Lacres"
        );
        $this->dom->appChild($this->aVol[$std->item], $lacre, "Inclusão do node lacres");
        return $lacre;
    }

    /**
     * Node vol
     */
    protected function buildVol()
    {
        foreach ($this->aVol as $num => $vol) {
            $this->dom->appChild($this->transp, $vol, "Inclusão do node vol");
        }
    }

    /**
     * Grupo Pagamento Y pai A01
     * NOTA: Ajustado para NT2016_002_v1.30
     * tag NFe/infNFe/pag (obrigatorio na NT2016_002_v1.30)
     * Obrigatório para 55 e 65
     */
    public function tagpag(stdClass $std): DOMElement
    {
        $possible = [
            'vTroco'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $pag = $this->dom->createElement("pag");
        //incluso no layout 4.00
        $this->dom->addChild(
            $pag,
            "vTroco",
            $this->conditionalNumberFormatting($std->vTroco),
            false,
            "Valor do troco"
        );
        return $this->pag = $pag;
    }

    /**
     * Grupo de Formas de Pagamento YA01a pai YA01
     * NOTA: Ajuste NT_2016_002_v1.30
     * NOTA: Ajuste NT_2016_002_v1 51
     * NOTA: Ajuste NT_2020_006
     * tag NFe/infNFe/pag/detPag
     */
    public function tagdetPag(stdClass $std): DOMElement
    {
        $possible = [
            'indPag',
            'tPag',
            'xPag',
            'vPag',
            'dPag',
            'CNPJ',
            'tBand',
            'cAut',
            'tpIntegra',
            'CNPJPag',
            'UFPag',
            'CNPJReceb',
            'idTermPag'
        ];
        $std = $this->equilizeParameters($std, $possible);
        //padrão para layout 4.00
        $detPag = $this->dom->createElement("detPag");
        $this->dom->addChild(
            $detPag,
            "indPag",
            $std->indPag,
            false,
            "Indicador da Forma de Pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "tPag",
            $std->tPag,
            true,
            "Forma de pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "xPag",
            !empty($std->xPag) ? $std->xPag : null,
            false,
            "Descricao da Forma de pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "vPag",
            $this->conditionalNumberFormatting($std->vPag),
            true,
            "Valor do Pagamento"
        );
        $this->dom->addChild(
            $detPag,
            "dPag",
            !empty($std->dPag) ? $std->dPag : null,
            false,
            "Data do Pagamento"
        );
        //NT 2023.004 v1.00
        if (!empty($std->CNPJPag) && !empty($std->UFPag)) {
            $this->dom->addChild(
                $detPag,
                "CNPJPag",
                $std->CNPJPag,
                false,
                "CNPJ transacional do pagamento"
            );
            $this->dom->addChild(
                $detPag,
                "UFPag",
                $std->UFPag,
                false,
                "UF do CNPJ do estabelecimento onde o pagamento foi processado/transacionado/recebido"
            );
        }
        if (!empty($std->tpIntegra)) {
            $card = $this->dom->createElement("card");
            $this->dom->addChild(
                $card,
                "tpIntegra",
                $std->tpIntegra,
                true,
                "Tipo de Integração para pagamento"
            );
            $this->dom->addChild(
                $card,
                "CNPJ",
                !empty($std->CNPJ) ? $std->CNPJ : null,
                false,
                "CNPJ da Credenciadora de cartão de crédito e/ou débito"
            );
            $this->dom->addChild(
                $card,
                "tBand",
                !empty($std->tBand) ? $std->tBand : null,
                false,
                "Bandeira da operadora de cartão de crédito e/ou débito"
            );
            $this->dom->addChild(
                $card,
                "cAut",
                !empty($std->cAut) ? $std->cAut : null,
                false,
                "Número de autorização da operação cartão de crédito e/ou débito"
            );
            //NT 2023.004 v1.00
            $this->dom->addChild(
                $card,
                "CNPJReceb",
                !empty($std->CNPJReceb) ? $std->CNPJReceb : null,
                false,
                "CNPJ do beneficiário do pagamento"
            );
            //NT 2023.004 v1.00
            $this->dom->addChild(
                $card,
                "idTermPag",
                !empty($std->idTermPag) ? $std->idTermPag : null,
                false,
                "Identificador do terminal de pagamento"
            );
            $this->dom->appChild($detPag, $card, "Inclusão do node Card");
        }
        $node = !empty($this->pag->getElementsByTagName("vTroco")->item(0))
            ? $this->pag->getElementsByTagName("vTroco")->item(0)
            : null;
        if (!empty($node)) {
            $this->pag->insertBefore($detPag, $node);
        } else {
            $this->dom->appChild($this->pag, $detPag, 'Falta tag "Pag"');
        }
        return $detPag;
    }

    /**
     * Dados do intermediador
     *
     *
     */
    public function tagIntermed(stdClass $std): \DomElement
    {
        $possible = [
            'CNPJ',
            'idCadIntTran'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $tag = $this->dom->createElement("infIntermed");
        $this->dom->addChild(
            $tag,
            "CNPJ",
            $std->CNPJ,
            true,
            "CNPJ do Intermediador da Transação (agenciador, plataforma de "
                . "delivery, marketplace e similar) de serviços e de negócios"
        );
        $this->dom->addChild(
            $tag,
            "idCadIntTran",
            $std->idCadIntTran,
            true,
            "Identificador cadastrado no intermediador"
        );
        return $this->intermed = $tag;
    }

    /**
     * Grupo Fatura Y02 pai Y01
     * tag NFe/infNFe/cobr/fat (opcional)
     */
    public function tagfat(stdClass $std): DOMElement
    {
        $possible = [
            'nFat',
            'vOrig',
            'vDesc',
            'vLiq'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->buildCobr();
        $fat = $this->dom->createElement("fat");
        $this->dom->addChild(
            $fat,
            "nFat",
            $std->nFat,
            false,
            "Número da Fatura"
        );
        $this->dom->addChild(
            $fat,
            "vOrig",
            $this->conditionalNumberFormatting($std->vOrig),
            false,
            "Valor Original da Fatura"
        );
        $this->dom->addChild(
            $fat,
            "vDesc",
            $this->conditionalNumberFormatting($std->vDesc),
            false,
            "Valor do desconto"
        );
        $this->dom->addChild(
            $fat,
            "vLiq",
            $this->conditionalNumberFormatting($std->vLiq),
            false,
            "Valor Líquido da Fatura"
        );
        $this->dom->appChild($this->cobr, $fat);
        return $fat;
    }

    /**
     * Grupo Duplicata Y07 pai Y02
     * tag NFe/infNFe/cobr/fat/dup (opcional)
     * É necessário criar a tag fat antes de criar as duplicatas
     */
    public function tagdup(stdClass $std): DOMElement
    {
        $possible = [
            'nDup',
            'dVenc',
            'vDup'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->buildCobr();
        $dup = $this->dom->createElement("dup");
        $this->dom->addChild(
            $dup,
            "nDup",
            $std->nDup,
            false,
            "Número da Duplicata"
        );
        $this->dom->addChild(
            $dup,
            "dVenc",
            $std->dVenc,
            false,
            "Data de vencimento"
        );
        $this->dom->addChild(
            $dup,
            "vDup",
            $this->conditionalNumberFormatting($std->vDup),
            true,
            "Valor da duplicata"
        );
        $this->dom->appChild($this->cobr, $dup, 'Inclui duplicata na tag cobr');
        return $dup;
    }

    /**
     * Grupo de Informações Adicionais Z01 pai A01
     * tag NFe/infNFe/infAdic (opcional)
     */
    public function taginfAdic(stdClass $std): DOMElement
    {
        $possible = ['infAdFisco', 'infCpl'];
        $std = $this->equilizeParameters($std, $possible);
        $this->buildInfAdic();
        $this->dom->addChild(
            $this->infAdic,
            "infAdFisco",
            Strings::replaceUnacceptableCharacters($std->infAdFisco ?? null),
            false,
            "Informações Adicionais de Interesse do Fisco"
        );
        $this->dom->addChild(
            $this->infAdic,
            "infCpl",
            Strings::replaceUnacceptableCharacters($std->infCpl ?? null),
            false,
            "Informações Complementares de interesse do Contribuinte"
        );
        return $this->infAdic;
    }

    /**
     * Grupo Campo de uso livre do contribuinte Z04 pai Z01
     * tag NFe/infNFe/infAdic/obsCont (opcional)
     * O método taginfAdic deve ter sido carregado antes
     */
    public function tagobsCont(stdClass $std): DOMElement
    {
        $possible = ['xCampo', 'xTexto'];
        $std = $this->equilizeParameters($std, $possible);
        $this->buildInfAdic();
        $obsCont = $this->dom->createElement("obsCont");
        $obsCont->setAttribute("xCampo", $std->xCampo);
        $this->dom->addChild(
            $obsCont,
            "xTexto",
            $std->xTexto,
            true,
            "Conteúdo do campo"
        );
        $this->dom->appChild($this->infAdic, $obsCont, '');
        return $obsCont;
    }

    /**
     * Grupo Campo de uso livre do Fisco Z07 pai Z01
     * tag NFe/infNFe/infAdic/obsFisco (opcional)
     * O método taginfAdic deve ter sido carregado antes
     */
    public function tagobsFisco(stdClass $std): DOMElement
    {
        $possible = ['xCampo', 'xTexto'];
        $std = $this->equilizeParameters($std, $possible);
        $this->buildInfAdic();
        $obsFisco = $this->dom->createElement("obsFisco");
        $obsFisco->setAttribute("xCampo", $std->xCampo);
        $this->dom->addChild(
            $obsFisco,
            "xTexto",
            $std->xTexto,
            true,
            "Conteúdo do campo"
        );
        $this->dom->appChild($this->infAdic, $obsFisco, '');
        return $obsFisco;
    }

    /**
     * Grupo Processo referenciado Z10 pai Z01
     * tag NFe/infNFe/procRef (opcional)
     * O método taginfAdic deve ter sido carregado antes
     */
    public function tagprocRef(stdClass $std): DOMElement
    {
        $possible = ['nProc', 'indProc', 'tpAto'];
        $std = $this->equilizeParameters($std, $possible);
        $this->buildInfAdic();
        $procRef = $this->dom->createElement("procRef");
        $this->dom->addChild(
            $procRef,
            "nProc",
            $std->nProc,
            true,
            "Identificador do processo ou ato concessório"
        );
        $this->dom->addChild(
            $procRef,
            "indProc",
            $std->indProc,
            true,
            "Indicador da origem do processo"
        );
        $this->dom->addChild(
            $procRef,
            "tpAto",
            $std->tpAto,
            false,
            "Tipo do ato concessório"
        );
        $this->dom->appChild($this->infAdic, $procRef, '');
        return $procRef;
    }

    /**
     * Grupo Exportação ZA01 pai A01
     * tag NFe/infNFe/exporta (opcional)
     */
    public function tagexporta(stdClass $std): DOMElement
    {
        $possible = ['UFSaidaPais', 'xLocExporta', 'xLocDespacho'];
        $std = $this->equilizeParameters($std, $possible);
        $this->exporta = $this->dom->createElement("exporta");
        $this->dom->addChild(
            $this->exporta,
            "UFSaidaPais",
            $std->UFSaidaPais,
            true,
            "Sigla da UF de Embarque ou de transposição de fronteira"
        );
        $this->dom->addChild(
            $this->exporta,
            "xLocExporta",
            $std->xLocExporta,
            true,
            "Descrição do Local de Embarque ou de transposição de fronteira"
        );
        $this->dom->addChild(
            $this->exporta,
            "xLocDespacho",
            $std->xLocDespacho,
            false,
            "Descrição do local de despacho"
        );
        return $this->exporta;
    }

    /**
     * Grupo Compra ZB01 pai A01
     * tag NFe/infNFe/compra (opcional)
     */
    public function tagcompra(stdClass $std): DOMElement
    {
        $possible = ['xNEmp', 'xPed', 'xCont'];
        $std = $this->equilizeParameters($std, $possible);
        $this->compra = $this->dom->createElement("compra");
        $this->dom->addChild(
            $this->compra,
            "xNEmp",
            $std->xNEmp,
            false,
            "Nota de Empenho"
        );
        $this->dom->addChild(
            $this->compra,
            "xPed",
            $std->xPed,
            false,
            "Pedido"
        );
        $this->dom->addChild(
            $this->compra,
            "xCont",
            $std->xCont,
            false,
            "Contrato"
        );
        return $this->compra;
    }

    /**
     * Grupo Cana ZC01 pai A01
     * tag NFe/infNFe/cana (opcional)
     */
    public function tagcana(stdClass $std): DOMElement
    {
        $possible = [
            'safra',
            'ref',
            'qTotMes',
            'qTotAnt',
            'qTotGer',
            'vFor',
            'vTotDed',
            'vLiqFor'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->cana = $this->dom->createElement("cana");
        $this->dom->addChild(
            $this->cana,
            "safra",
            $std->safra,
            true,
            "Identificação da safra"
        );
        $this->dom->addChild(
            $this->cana,
            "ref",
            $std->ref,
            true,
            "Mês e ano de referência"
        );
        $this->dom->addChild(
            $this->cana,
            "qTotMes",
            $std->qTotMes,
            true,
            "Quantidade Total do Mês"
        );
        $this->dom->addChild(
            $this->cana,
            "qTotAnt",
            $std->qTotAnt,
            true,
            "Quantidade Total Anterior"
        );
        $this->dom->addChild(
            $this->cana,
            "qTotGer",
            $std->qTotGer,
            true,
            "Quantidade Total Geral"
        );
        $this->dom->addChild(
            $this->cana,
            "vFor",
            $this->conditionalNumberFormatting($std->vFor),
            true,
            "Valor dos Fornecimentos"
        );
        $this->dom->addChild(
            $this->cana,
            "vTotDed",
            $this->conditionalNumberFormatting($std->vTotDed),
            true,
            "Valor Total da Dedução"
        );
        $this->dom->addChild(
            $this->cana,
            "vLiqFor",
            $this->conditionalNumberFormatting($std->vLiqFor),
            true,
            "Valor Líquido dos Fornecimentos"
        );
        return $this->cana;
    }

    /**
     * Grupo Fornecimento diário de cana ZC04 pai ZC01
     * tag NFe/infNFe/cana/forDia
     */
    public function tagforDia(stdClass $std): DOMElement
    {
        $forDia = $this->dom->createElement("forDia");
        $forDia->setAttribute("dia", $std->dia);
        $this->dom->addChild(
            $forDia,
            "qtde",
            $this->conditionalNumberFormatting($std->qtde, 10),
            true,
            "Quantidade"
        );
        $qTotMes = $this->cana->getElementsByTagName('qTotMes')->item(0);
        $this->cana->insertBefore($forDia, $qTotMes);
        return $forDia;
    }

    /**
     * Grupo Deduções – Taxas e Contribuições ZC10 pai ZC01
     * tag NFe/infNFe/cana/deduc (opcional)
     */
    public function tagdeduc(stdClass $std): DOMElement
    {
        $possible = ['xDed', 'vDed'];
        $std = $this->equilizeParameters($std, $possible);
        $deduc = $this->dom->createElement("deduc");
        $this->dom->addChild(
            $deduc,
            "xDed",
            $std->xDed,
            true,
            "Descrição da Dedução"
        );
        $this->dom->addChild(
            $deduc,
            "vDed",
            $this->conditionalNumberFormatting($std->vDed),
            true,
            "Valor da Dedução"
        );
        $vFor = $this->cana->getElementsByTagName('vFor')->item(0);
        $this->cana->insertBefore($deduc, $vFor);
        return $deduc;
    }

    /**
     * Informações suplementares da Nota Fiscal
     */
    public function taginfNFeSupl(stdClass $std): DOMElement
    {
        $possible = ['qrcode', 'urlChave'];
        $std = $this->equilizeParameters($std, $possible);

        $infNFeSupl = $this->dom->createElement("infNFeSupl");
        $nodeqr = $infNFeSupl->appendChild($this->dom->createElement('qrCode'));
        $nodeqr->appendChild($this->dom->createCDATASection($std->qrcode));
        //incluido no layout 4.00
        $std->urlChave = !empty($std->urlChave) ? $std->urlChave : null;
        $this->dom->addChild(
            $infNFeSupl,
            "urlChave",
            $std->urlChave,
            false,
            "URL de consulta por chave de acesso a ser impressa no DANFE NFC-e"
        );
        $this->infNFeSupl = $infNFeSupl;
        return $infNFeSupl;
    }

    /**
     * Informações do Responsável técnico ZD01 pai A01
     * tag NFe/infNFe/infRespTec (opcional)
     * @throws RuntimeException
     */
    public function taginfRespTec(stdClass $std): DOMElement
    {
        $possible = [
            'CNPJ',
            'xContato',
            'email',
            'fone',
            'CSRT',
            'idCSRT'
        ];

        $std = $this->equilizeParameters($std, $possible);
        $infRespTec = $this->dom->createElement("infRespTec");
        $this->dom->addChild(
            $infRespTec,
            "CNPJ",
            $std->CNPJ ?? '',
            true,
            "Informar o CNPJ da pessoa jurídica responsável pelo sistema "
                . "utilizado na emissão do documento fiscal eletrônico",
            true
        );
        $this->dom->addChild(
            $infRespTec,
            "xContato",
            $std->xContato,
            true,
            "Informar o nome da pessoa a ser contatada na empresa desenvolvedora "
                . "do sistema utilizado na emissão do documento fiscal eletrônico"
        );
        $this->dom->addChild(
            $infRespTec,
            "email",
            $std->email,
            true,
            "Informar o e-mail da pessoa a ser contatada na empresa "
                . "desenvolvedora do sistema."
        );
        $this->dom->addChild(
            $infRespTec,
            "fone",
            $std->fone,
            true,
            "Informar o telefone da pessoa a ser contatada na empresa "
                . "desenvolvedora do sistema."
        );
        if (!empty($std->CSRT) && !empty($std->idCSRT)) {
            $this->csrt = $std->CSRT;
            $this->dom->addChild(
                $infRespTec,
                "idCSRT",
                $std->idCSRT,
                true,
                "Identificador do CSRT utilizado para montar o hash do CSRT"
            );
            $this->dom->addChild(
                $infRespTec,
                "hashCSRT",
                $this->hashCSRT($std->CSRT),
                true,
                "hash do CSRT"
            );
        }
        $this->infRespTec = $infRespTec;
        return $infRespTec;
    }

    /**
     * Informações de produtos da agricultura, pecuária e produção Florestal ZF01 pai A01
     * tag NFe/infNFe/agropecuario (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagagropecuario(stdClass $std): DOMElement
    {
        $possible = [
            'nReceituario',
            'CPFRespTec',
            'tpGuia',
            'UFGuia',
            'serieGuia',
            'nGuia'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $agro = $this->dom->createElement("agropecuario");
        if (!empty($std->nReceituario)) {
            $def = $this->dom->createElement("defensivo");
            $this->dom->addChild(
                $def,
                "nReceituario",
                $std->nReceituario,
                true,
                "Número da receita ou receituário do agrotóxico/defensivo agrícola"
            );
            $this->dom->addChild(
                $def,
                "CPFRespTec",
                $std->CPFRespTec,
                true,
                "CPF do Responsável Técnico, emitente do receituário"
            );
            $agro->appendChild($def);
        } elseif (!empty($std->tpGuia)) {
            $guia = $this->dom->createElement("guiaTransito");
            $this->dom->addChild(
                $guia,
                "tpGuia",
                $std->tpGuia,
                true,
                "Tipo da Guia"
            );
            $this->dom->addChild(
                $guia,
                "UFGuia",
                !empty($std->UFGuia) ? $std->UFGuia : null,
                false,
                "UF de emissão"
            );
            $this->dom->addChild(
                $guia,
                "serieGuia",
                $std->serieGuia ?? null,
                false,
                "Série da Guia"
            );
            $this->dom->addChild(
                $guia,
                "nGuia",
                $std->nGuia,
                true,
                "Número da Guia"
            );
            $agro->appendChild($guia);
        }
        $this->agropecuario = $agro;
        return $agro;
    }

    /**
     * Tag raiz da NFe
     * tag NFe DOMNode
     * Função chamada pelo método [ monta ]
     *
     */
    protected function buildNFe(): DOMElement
    {
        if (!$this->NFe) {
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
     */
    protected function buildNFref()
    {
        $this->aNFref[] = $this->dom->createElement("NFref");
        return count($this->aNFref);
    }

    /**
     * Insere dentro dentro das tags imposto o ICMS IPI II PIS COFINS ISSQN
     * tag NFe/infNFe/det[]/imposto
     */
    protected function buildImp(): void
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
     */
    protected function buildCOFINSAliq(stdClass $std): DOMElement
    {
        $confinsAliq = $this->dom->createElement('COFINSAliq');
        $this->dom->addChild(
            $confinsAliq,
            'CST',
            $std->CST,
            true,
            "Código de Situação Tributária da COFINS"
        );
        $this->dom->addChild(
            $confinsAliq,
            'vBC',
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "Valor da Base de Cálculo da COFINS"
        );
        $this->dom->addChild(
            $confinsAliq,
            'pCOFINS',
            $this->conditionalNumberFormatting($std->pCOFINS, 4),
            true,
            "Alíquota da COFINS (em percentual)"
        );
        $this->dom->addChild(
            $confinsAliq,
            'vCOFINS',
            $this->conditionalNumberFormatting($std->vCOFINS),
            true,
            "Valor da COFINS"
        );
        return $confinsAliq;
    }

    /**
     * Grupo COFINS não tributado S04 pai S01
     * tag NFe/infNFe/det[]/imposto/COFINS/COFINSNT (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     */
    protected function buildCOFINSNT(stdClass $std): DOMElement
    {
        $confinsnt = $this->dom->createElement('COFINSNT');
        $this->dom->addChild(
            $confinsnt,
            "CST",
            $std->CST,
            true,
            "Código de Situação Tributária da COFINS"
        );
        return $confinsnt;
    }

    /**
     * Grupo COFINS Outras Operações S05 pai S01
     * tag NFe/infNFe/det[]/imposto/COFINS/COFINSoutr (opcional)
     * Função chamada pelo método [ tagCOFINS ]
     */
    protected function buildCOFINSoutr(stdClass $std): DOMElement
    {
        $confinsoutr = $this->dom->createElement('COFINSOutr');
        $this->dom->addChild(
            $confinsoutr,
            "CST",
            $std->CST,
            true,
            "Código de Situação Tributária da COFINS"
        );
        if (!isset($std->qBCProd)) {
            $this->dom->addChild(
                $confinsoutr,
                "vBC",
                $this->conditionalNumberFormatting($std->vBC),
                ($std->vBC !== null) ? true : false,
                "Valor da Base de Cálculo da COFINS"
            );
            $this->dom->addChild(
                $confinsoutr,
                "pCOFINS",
                $this->conditionalNumberFormatting($std->pCOFINS, 4),
                ($std->pCOFINS !== null) ? true : false,
                "Alíquota da COFINS (em percentual)"
            );
        } else {
            $this->dom->addChild(
                $confinsoutr,
                "qBCProd",
                $this->conditionalNumberFormatting($std->qBCProd, 4),
                ($std->qBCProd !== null) ? true : false,
                "Quantidade Vendida"
            );
            $this->dom->addChild(
                $confinsoutr,
                "vAliqProd",
                $this->conditionalNumberFormatting($std->vAliqProd, 4),
                ($std->vAliqProd !== null) ? true : false,
                "Alíquota da COFINS (em reais)"
            );
        }
        $this->dom->addChild(
            $confinsoutr,
            "vCOFINS",
            $this->conditionalNumberFormatting($std->vCOFINS),
            true,
            "Valor da COFINS"
        );
        return $confinsoutr;
    }

    /**
     * Insere dentro da tag det os produtos
     * tag NFe/infNFe/det[]
     * @return array|string
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
        //insere CEST
        foreach ($this->aCest as $nItem => $cest) {
            $prod = $this->aProd[$nItem];
            /** @var \DOMElement $child */
            foreach ($cest as $child) {
                $node = $prod->getElementsByTagName("cBenef")->item(0);
                if (empty($node)) {
                    $node = $prod->getElementsByTagName("EXTIPI")->item(0);
                    if (empty($node)) {
                        $node = $prod->getElementsByTagName("CFOP")->item(0);
                    }
                }
                $cchild = $child->getElementsByTagName("CEST")->item(0);
                $prod->insertBefore($cchild, $node);
                $cchild = $child->getElementsByTagName("indEscala")->item(0);
                if (!empty($cchild)) {
                    $prod->insertBefore($cchild, $node);
                }
                $cchild = $child->getElementsByTagName("CNPJFab")->item(0);
                if (!empty($cchild)) {
                    $prod->insertBefore($cchild, $node);
                    $this->aProd[$nItem] = $prod;
                }
            }
        }
        //insere credito presumido
        $it = 0;
        foreach ($this->aProdCreditoPresumido as $key => $cps) {
            $prod = $this->aProd[$key];
            if (!empty($prod->getElementsByTagName("EXTIPI")->item(0))) {
                $node = $prod->getElementsByTagName("EXTIPI")->item(0);
            } else {
                $node = $prod->getElementsByTagName("CFOP")->item(0);
            }
            foreach ($cps as $cp) {
                $prod->insertBefore($cp, $node);
            }
        }
        //insere DI
        foreach ($this->aDI as $nItem => $aDI) {
            $prod = $this->aProd[$nItem];
            foreach ($aDI as $child) {
                $nodexped = $prod->getElementsByTagName("xPed")->item(0);
                if (!empty($nodexped)) {
                    $prod->insertBefore($child, $nodexped);
                } else {
                    $nodenItemPed = $prod->getElementsByTagName("nItemPed")->item(0);
                    if (!empty($nodenItemPed)) {
                        $prod->insertBefore($child, $nodenItemPed);
                    } else {
                        $node = $prod->getElementsByTagName("FCI")->item(0);
                        if (!empty($node)) {
                            $prod->insertBefore($child, $node);
                        } else {
                            $this->dom->appChild($prod, $child, "Inclusão do node DI");
                        }
                    }
                }
            }
            $this->aProd[$nItem] = $prod;
        }
        //insere detExport
        foreach ($this->aDetExport as $nItem => $detexport) {
            $prod = $this->aProd[$nItem];
            foreach ($detexport as $child) {
                $node = $prod->getElementsByTagName("xPed")->item(0);
                if (!empty($node)) {
                    $prod->insertBefore($child, $node);
                } else {
                    $this->dom->appChild($prod, $child, "Inclusão do node DetExport");
                }
            }
            $this->aProd[$nItem] = $prod;
        }
        //insere Rastro
        foreach ($this->aRastro as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            foreach ($child as $rastro) {
                $this->dom->appChild($prod, $rastro, "Inclusão do node Rastro");
            }
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
        foreach ($this->aArma as $nItem => $arma) {
            $prod = $this->aProd[$nItem];
            foreach ($arma as $child) {
                $node = $prod->getElementsByTagName("imposto")->item(0);
                if (!empty($node)) {
                    $prod->insertBefore($child, $node);
                } else {
                    $this->dom->appChild($prod, $child, "Inclusão do node arma");
                }
            }
            $this->aProd[$nItem] = $prod;
        }
        //insere combustivel
        foreach ($this->aComb as $nItem => $child) {
            $prod = $this->aProd[$nItem];
            if (!empty($this->aEncerrante)) {
                $encerrante = $this->aEncerrante[$nItem];
                if (!empty($encerrante)) {
                    $pbio = $child->getElementsByTagName("pBio")->item(0);
                    if (!empty($pbio)) {
                        $child->insertBefore($encerrante, $pbio);
                    } else {
                        $this->dom->appChild($child, $encerrante, "inclusão do node encerrante na tag comb");
                    }
                }
            }
            //incluso NT 2023.001-1.10 /1.20
            if (!empty($this->aOrigComb[$nItem])) {
                foreach ($this->aOrigComb[$nItem] as $origcomb) {
                    $this->dom->appChild($child, $origcomb, "inclusão do node origComb na tag comb");
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
            if (!empty($this->aImpostoDevol[$nItem])) {
                $child = $this->aImpostoDevol[$nItem];
                $this->dom->appChild($det, $child, "Inclusão do node impostoDevol");
            }
            //insere infAdProd
            if (!empty($this->aInfAdProd[$nItem])) {
                $child = $this->aInfAdProd[$nItem];
                $this->dom->appChild($det, $child, "Inclusão do node infAdProd");
            }
            //insere obsItem
            if (!empty($this->obsItem[$nItem])) {
                $child = $this->obsItem[$nItem];
                $this->dom->appChild($det, $child, "Inclusão do node obsItem");
            }
            $this->aDet[] = $det;
            $det = null;
        }
        return $this->aProd;
    }

    /**
     * Insere a tag pag, os detalhamentos dos pagamentos e cartoes
     * NOTA: Ajustado para NT2016_002_v1.30
     * tag NFe/infNFe/pag/
     * tag NFe/infNFe/pag/detPag[]
     * tag NFe/infNFe/pag/detPag[]/Card
     */
    protected function buildTagPag()
    {
        $this->dom->appChild($this->infNFe, $this->pag, 'Falta tag "infNFe"');
    }

    /**
     * Grupo Totais da NF-e W01 pai A01
     * tag NFe/infNFe/total
     */
    protected function buildTotal()
    {
        //round all values
        $this->stdTot->vBC = round($this->stdTot->vBC, 2);
        $this->stdTot->vICMS = round($this->stdTot->vICMS, 2);
        $this->stdTot->vICMSDeson = round($this->stdTot->vICMSDeson, 2);
        $this->stdTot->vFCP = round($this->stdTot->vFCP, 2);
        $this->stdTot->vFCPUFDest = round($this->stdTot->vFCPUFDest, 2);
        $this->stdTot->vICMSUFDest = round($this->stdTot->vICMSUFDest, 2);
        $this->stdTot->vICMSUFRemet = round($this->stdTot->vICMSUFRemet, 2);
        $this->stdTot->vBCST = round($this->stdTot->vBCST, 2);
        $this->stdTot->vST = round($this->stdTot->vST, 2);
        $this->stdTot->vFCPST = round($this->stdTot->vFCPST, 2);
        $this->stdTot->vFCPSTRet = round($this->stdTot->vFCPSTRet, 2);
        $this->stdTot->vProd = round($this->stdTot->vProd, 2);
        $this->stdTot->vFrete = round($this->stdTot->vFrete, 2);
        $this->stdTot->vSeg = round($this->stdTot->vSeg, 2);
        $this->stdTot->vDesc = round($this->stdTot->vDesc, 2);
        $this->stdTot->vII = round($this->stdTot->vII, 2);
        $this->stdTot->vIPI = round($this->stdTot->vIPI, 2);
        $this->stdTot->vIPIDevol = round($this->stdTot->vIPIDevol, 2);
        $this->stdTot->vPIS = round($this->stdTot->vPIS, 2);
        $this->stdTot->vCOFINS = round($this->stdTot->vCOFINS, 2);
        $this->stdTot->vOutro = round($this->stdTot->vOutro, 2);
        $this->stdTot->vNF = round($this->stdTot->vNF, 2);
        $this->stdTot->vTotTrib = round($this->stdTot->vTotTrib, 2);

        $this->stdTot->vNF = $this->stdTot->vProd
            - $this->stdTot->vDesc
            - $this->stdTot->vICMSDeson
            + $this->stdTot->vST
            + $this->stdTot->vFCPST
            + $this->stdTot->vICMSMonoReten
            + $this->stdTot->vFrete
            + $this->stdTot->vSeg
            + $this->stdTot->vOutro
            + $this->stdTot->vII
            + $this->stdTot->vIPI
            + $this->stdTot->vIPIDevol
            + $this->stdISSQNTot->vServ
            + $this->stdTot->vPISST
            + $this->stdTot->vCOFINSST;
    }

    protected function buildISSQNTot()
    {
        if ($this->flagISSQNCalc) {
            return;
        }

        //totaliza PIS e COFINS dos Itens de Serviço
        foreach ($this->aItensServ as $item) {
            if (!empty($this->aPIS[$item])) {
                $vPIS = (float) $this->getNodeValue($this->aPIS[$item], 'vPIS');
                $this->stdISSQNTot->vPIS += (float) $vPIS;
                //remove esse valor do total já contabiizado no stdTot
                $this->stdTot->vPIS -= $vPIS;
            }
            //totalizar COFINS desses itens
            if (!empty($this->aCOFINS[$item])) {
                $vCOFINS = (float) $this->getNodeValue($this->aCOFINS[$item], 'vCOFINS');
                $this->stdISSQNTot->vCOFINS += (float) $vCOFINS;
                //remove esse valor do total já contabiizado no stdTot
                $this->stdTot->vCOFINS -= $vCOFINS;
            }
        }
        $this->stdISSQNTot->vServ = $this->conditionalNumberFormatting($this->stdISSQNTot->vServ);
        $this->stdISSQNTot->vBC = $this->conditionalNumberFormatting($this->stdISSQNTot->vBC);
        $this->stdISSQNTot->vISS = $this->conditionalNumberFormatting($this->stdISSQNTot->vISS);
        $this->stdISSQNTot->vPIS = $this->conditionalNumberFormatting($this->stdISSQNTot->vPIS);
        $this->stdISSQNTot->vCOFINS = $this->conditionalNumberFormatting($this->stdISSQNTot->vCOFINS);
        $this->stdISSQNTot->vDeducao = $this->conditionalNumberFormatting($this->stdISSQNTot->vDeducao);
        $this->stdISSQNTot->vOutro = $this->conditionalNumberFormatting($this->stdISSQNTot->vOutro);
        $this->stdISSQNTot->vDescIncond = $this->conditionalNumberFormatting($this->stdISSQNTot->vDescIncond);
        $this->stdISSQNTot->vDescCond = $this->conditionalNumberFormatting($this->stdISSQNTot->vDescCond);
        $this->stdISSQNTot->vISSRet = $this->conditionalNumberFormatting($this->stdISSQNTot->vISSRet);

        $this->flagISSQNCalc = true;
    }

    private function getNodeValue(DOMElement $node, string $name)
    {
        $dom = new Dom('1.0', 'utf-8');
        $dom->loadXML("<root></root>");
        $newnode = $dom->importNode($node, true);
        $dom->documentElement->appendChild($newnode);
        return $dom->getNodeValue($name);
    }

    /**
     * Grupo Cobrança Y01 pai A01
     * tag NFe/infNFe/cobr (opcional)
     * Depende de fat
     */
    protected function buildCobr()
    {
        if (!$this->cobr) {
            $this->cobr = $this->dom->createElement("cobr");
        }
    }

    /**
     * Grupo de Informações Adicionais Z01 pai A01
     * tag NFe/infNFe/infAdic (opcional)
     * Função chamada pelos metodos
     * [taginfAdic] [tagobsCont] [tagobsFisco] [tagprocRef]
     */
    protected function buildInfAdic(): DOMElement
    {
        if (!$this->infAdic) {
            $this->infAdic = $this->dom->createElement("infAdic");
        }
        return $this->infAdic;
    }

    /**
     * Remonta a chave da NFe de 44 digitos com base em seus dados
     * já contidos na NFE.
     * Isso é útil no caso da chave informada estar errada
     * se a chave estiver errada a mesma é substituida
     */
    protected function checkNFeKey(Dom $dom): void
    {
        $infNFe = $dom->getElementsByTagName("infNFe")->item(0);
        $ide = $dom->getElementsByTagName("ide")->item(0);
        $emit = $dom->getElementsByTagName("emit")->item(0);
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        if (!empty($emit->getElementsByTagName('CNPJ')->item(0)->nodeValue)) {
            $doc = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        } else {
            $doc = $emit->getElementsByTagName('CPF')->item(0)->nodeValue;
        }
        $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
        $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
        $nNF = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $cNF = $ide->getElementsByTagName('cNF')->item(0)->nodeValue;
        $chave = str_replace('NFe', '', $infNFe->getAttribute("Id"));
        $dt = new DateTime($dhEmi);
        $infRespTec = $dom->getElementsByTagName("infRespTec")->item(0);
        $chaveMontada = Keys::build(
            $cUF,
            $dt->format('y'),
            $dt->format('m'),
            $doc,
            $mod,
            $serie,
            $nNF,
            $tpEmis,
            $cNF
        );
        if (empty($chave)) {
            //chave não foi passada por parâmetro então colocar a chavemontada
            $infNFe->setAttribute('Id', "NFe$chaveMontada");
            $chave = $chaveMontada;
            $this->chNFe = $chaveMontada;
            $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chave, -1);
            //trocar também o hash se o CSRT for passado
            if (!empty($this->csrt)) {
                $hashCSRT = $this->hashCSRT($this->csrt);
                $infRespTec->getElementsByTagName("hashCSRT")
                    ->item(0)->nodeValue = $hashCSRT;
            }
        }
        //caso a chave contida na NFe esteja errada
        //substituir a chave
        if ($chaveMontada != $chave) {
            $this->chNFe = $chaveMontada;
            $this->errors[] = "A chave informada está incorreta [$chave] => [correto: $chaveMontada].";
        }
    }

    /**
     * Retorna os erros detectados
     */
    public function getErrors(): array
    {
        return array_merge($this->errors, $this->dom->errors);
    }

    /**
     * Includes missing or unsupported properties in stdClass
     * Replace all unsuported chars
     */
    protected function equilizeParameters(stdClass $std, array $possible): stdClass
    {
        return Strings::equilizeParameters(
            $std,
            $possible,
            $this->replaceAccentedChars
        );
    }

    /**
     * Calcula hash sha1 retornando Base64Binary
     */
    protected function hashCSRT(string $CSRT): string
    {
        $comb = $CSRT . $this->chNFe;
        return base64_encode(sha1($comb, true));
    }

    /**
     * Formatação numerica condicional
     * @param string|float|int|null $value
     */
    protected function conditionalNumberFormatting($value = null, int $decimal = 2): ?string
    {
        if (is_numeric($value)) {
            return number_format($value, $decimal, '.', '');
        }

        return null;
    }
}
