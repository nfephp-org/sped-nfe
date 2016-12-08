<?php

namespace NFePHP\NFe;

/**
 * Class to conver NFe in txt format to XML
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Convert
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\NFe\Make;

class Convert
{
    /**
     * @var bool
     */
    protected $limparString = true;
    /**
     * @var string
     */
    protected $version = '3.10';
    /**
     * @var Make
     */
    protected $make;
    /**
     * @var array
     */
    protected $linhaBA10 = array();
    /**
     * @var array
     */
    protected $linhaC = array();
    /**
     * @var array
     */
    protected $linhaE = array();
    /**
     * @var array
     */
    protected $linhaF = array();
    /**
     * @var array
     */
    protected $linhaG = array();
    /**
     * @var int
     */
    protected $nItem = 0;
    /**
     * @var int
     */
    protected $nDI = '0';
    /**
     * @var array
     */
    protected $linhaI50 = array();
    /**
     * @var array
     */
    protected $linhaLA = array();
    /**
     * @var array
     */
    protected $linhaO = array();
    /**
     * @var array
     */
    protected $linhaQ = array();
    /**
     * @var array
     */
    protected $linhaR = array();
    /**
     * @var array
     */
    protected $linhaS = array();
    /**
     * @var array
     */
    protected $linhaT = array();
    /**
     * @var array
     */
    protected $linhaX = array();
    /**
     * @var array
     */
    protected $linhaX26 = array();
    /**
     * @var int
     */
    protected $volId = -1;
    /**
     * @var array
     */
    protected $linhaZC = array();
    /**
     * @var array
     */
    protected $aLacres = array();

    /**
     * contructor
     * @param  boolean $limparString Ativa flag para limpar os caracteres especiais
     *                e acentos
     * @return void
     */
    public function __construct($limparString = true)
    {
        $this->limparString = $limparString;
    }

    /**
     * Converts one or many NFe from txt to xml
     * @param  string $txt content of NFe in txt format
     * @return array
     */
    public function txt2xml($txt)
    {
        $aNF = array();
        $aDados = explode("\n", $txt);
        $aNotas = $this->zSliceNotas($aDados);
        foreach ($aNotas as $nota) {
            $this->notafiscalEntity();
            $this->zArray2xml($nota);
            foreach ($this->linhaX26 as $vol) {
                $this->zLinhaXVolEntity($vol);
            }
            if ($this->make->montaNFe()) {
                $aNF[] = $this->make->getXML();
            }
        }
        return $aNF;
    }

    /**
     * Creates the instance of the constructor class
     */
    protected function notafiscalEntity()
    {
        $this->zClearParam();
        $this->make = new Make();
        $aCampos = array();
    }

    /**
     * Make tag <infNFe>
     * @param  array $aCampos
     * @throws \RuntimeException
     */
    protected function aEntity($aCampos)
    {
        //A|versao|Id|pk_nItem|
        if ($aCampos[1] != $this->version) {
            $msg = "A conversão somente para a versão $this->version !";
            throw new \RuntimeException($msg);
        }
        $chave = preg_replace('/[^0-9]/', '', $aCampos[2]);
        $this->make->taginfNFe($chave, $this->version);
    }

    /**
     * Make tag <ide>
     * @param array $aCampos
     */
    protected function bEntity($aCampos)
    {
        //B|cUF|cNF|natOp|indPag|mod|serie|nNF|dhEmi
        // |dhSaiEnt|tpNF|idDest|cMunFG|tpImp|tpEmis
        // |cDV|tp Amb|finNFe|indFinal
        // |indPres|procEmi|verProc|dhCont|xJust|
        $this->make->tagide(
            $aCampos[1], //cUF
            $aCampos[2], //cNF
            $aCampos[3], //natOp
            $aCampos[4], //indPag
            $aCampos[5], //mod
            $aCampos[6], //serie
            $aCampos[7], //nNF
            $aCampos[8], //dhEmi
            $aCampos[9], //dhSaiEnt
            $aCampos[10], //tpNF
            $aCampos[11], //idDest
            $aCampos[12], //cMunFG
            $aCampos[13], //tpImp
            $aCampos[14], //tpEmis
            $aCampos[15], //cDV
            $aCampos[16], //tpAmb
            $aCampos[17], //finNFe
            $aCampos[18], //indFinal
            $aCampos[19], //indPres
            $aCampos[20], //procEmi
            $aCampos[21], //verProc
            $aCampos[22], //dhCont
            $aCampos[23] //xJust
        );
    }

    /**
     * Get BA marker from txt
     * @param array $aCampos
     */
    protected function baEntity($aCampos)
    {
        //BA|
        //fake não faz nada
        $aCampos = array();
    }

    /**
     * Make tag <refNFe>
     * @param array $aCampos
     */
    protected function ba02Entity($aCampos)
    {
        //BA02|refNFe|
        $this->make->tagrefNFe($aCampos[1]);
    }

    /**
     * Make tag <refNF>
     * @param array $aCampos
     */
    protected function ba03Entity($aCampos)
    {
        //BA03|cUF|AAMM|CNPJ|mod|serie|nNF|
        $this->make->tagrefNF(
            $aCampos[1], //cUF
            $aCampos[2], //aamm
            $aCampos[3], //cnpj
            $aCampos[4], //mod
            $aCampos[5], //serie
            $aCampos[6] //nNF
        );
    }

    /**
     * Make tag <refNFP>
     * @param array $aCampos
     */
    protected function ba10Entity($aCampos)
    {
        //BA10|cUF|AAMM|IE|mod|serie|nNF|
        $this->linhaBA10[0] = $aCampos[0];
        $this->linhaBA10[1] = $aCampos[1];
        $this->linhaBA10[2] = $aCampos[2];
        $this->linhaBA10[3] = $aCampos[3];
        $this->linhaBA10[4] = $aCampos[4];
        $this->linhaBA10[5] = $aCampos[5];
        $this->linhaBA10[6] = $aCampos[6];
        $this->linhaBA10[7] = '';
        $this->linhaBA10[8] = '';
    }

    /**
     * ba13Entity
     * @param array $aCampos
     */
    protected function ba13Entity($aCampos)
    {
        //BA13|CNPJ|
        $this->linhaBA10[7] = $aCampos[1];
        $this->zLinhaBA10Entity($this->linhaBA10);
    }

    /**
     * ba14Entity
     * @param array $aCampos
     */
    protected function ba14Entity($aCampos)
    {
        //BA14|CPF|
        $this->linhaBA10[8] = $aCampos[1];
        $this->zLinhaBA10Entity($this->linhaBA10);
    }

    /**
     * Make tag <refNFP>
     * @param array $aCampos
     */
    protected function zLinhaBA10Entity($aCampos)
    {
        //BA10xx|cUF|AAMM|IE|mod|serie|nNF|CNPJ|CPF
        $this->make->tagrefNFP(
            $aCampos[1], //cUF
            $aCampos[2], //aamm
            $aCampos[7], //cnpj
            $aCampos[8], //cpf
            $aCampos[3], //IE
            $aCampos[4], //mod
            $aCampos[5], //serie
            $aCampos[6] //nNF
        );
    }

    /**
     * Make tag <refCTe>
     * @param array $aCampos
     */
    protected function ba19Entity($aCampos)
    {
        //B19|refCTe|
        $this->make->tagrefCTe($aCampos[1]);
    }

    /**
     * Make tag <refECF>
     * @param array $aCampos
     */
    protected function ba20Entity($aCampos)
    {
        //BA20|mod|nECF|nCOO|
        $this->make->tagrefECF(
            $aCampos[1], //mod
            $aCampos[2], //nECF
            $aCampos[3] //nCOO
        );
    }

    /**
     * Load cEntity
     * @param array $aCampos
     */
    protected function cEntity($aCampos)
    {
        //C|XNome|XFant|IE|IEST|IM|CNAE|CRT|
        $this->linhaC[0] = $aCampos[0];
        $this->linhaC[1] = $aCampos[1];
        $this->linhaC[2] = $aCampos[2];
        $this->linhaC[3] = $aCampos[3];
        $this->linhaC[4] = $aCampos[4];
        $this->linhaC[5] = $aCampos[5];
        $this->linhaC[6] = $aCampos[6];
        $this->linhaC[7] = $aCampos[7];
        $this->linhaC[8] = ''; //CNPJ
        $this->linhaC[9] = ''; //CPF
    }

    /**
     * c02Entity
     * @param array $aCampos
     */
    protected function c02Entity($aCampos)
    {
        //C02|cnpj|
        $this->linhaC[8] = $aCampos[1]; //CNPJ
        $this->zLinhaCEntity($this->linhaC);
    }

    /**
     * c02aEntity
     * @param array $aCampos
     */
    protected function c02aEntity($aCampos)
    {
        //C02a|cpf|
        $this->linhaC[9] = $aCampos[1];//CPF
        $this->linhaCEntity($this->linhaC);
    }

    /**
     * Make tag <emit>
     * @param array $aCampos
     */
    protected function zLinhaCEntity($aCampos)
    {
        //Cxx|XNome|XFant|IE|IEST|IM|CNAE|CRT|CNPJ|CPF|
        $this->make->tagemit(
            $aCampos[8], //cnpj
            $aCampos[9], //cpf
            $aCampos[1], //xNome
            $aCampos[2], //xFant
            $aCampos[3], //numIE
            $aCampos[4], //numIEST
            $aCampos[5], //numIM
            $aCampos[6], //cnae
            $aCampos[7] //crt
        );
    }

    /**
     * Make tag <enderEmit>
     * @param array $aCampos
     */
    protected function c05Entity($aCampos)
    {
        //C05|XLgr|Nro|Cpl|Bairro|CMun|XMun|UF|CEP|cPais|xPais|fone|
        $this->make->tagenderEmit(
            $aCampos[1], //xLgr
            $aCampos[2], //nro
            $aCampos[3], //xCpl
            $aCampos[4], //xBairro
            $aCampos[5], //cMun
            $aCampos[6], //xMun
            $aCampos[7], //siglaUF
            $aCampos[8], //cep
            $aCampos[9], //cPais
            $aCampos[10], //xPais
            $aCampos[11] //fone
        );
    }

    /**
     * Load eEntity
     * @param array $aCampos
     */
    protected function eEntity($aCampos)
    {
        //E|xNome|indIEDest|IE|ISUF|IM|email|
        $this->linhaE[0] = $aCampos[0];
        $this->linhaE[1] = $aCampos[1];
        $this->linhaE[2] = $aCampos[2];
        $this->linhaE[3] = $aCampos[3];
        $this->linhaE[4] = $aCampos[4];
        $this->linhaE[5] = $aCampos[5];
        $this->linhaE[6] = $aCampos[6];
        $this->linhaE[7] = '';
        $this->linhaE[8] = '';
        $this->linhaE[9] = '';
    }

    /**
     * e02Entity
     * @param array $aCampos
     */
    protected function e02Entity($aCampos)
    {
        //E02|CNPJ| [dest]
        $this->linhaE[7] = $aCampos[1];
        $this->zLinhaEEntity($this->linhaE);
    }

    /**
     * e03Entity
     * @param array $aCampos
     */
    protected function e03Entity($aCampos)
    {
        //E03|CPF| [dest]
        $this->linhaE[8] = $aCampos[1];
        $this->zLinhaEEntity($this->linhaE);
    }

    /**
     * e03aEntity
     * @param array $aCampos
     */
    protected function e03aEntity($aCampos)
    {
        //E03a|idEstrangeiro| [dest]
        $this->linhaE[9] = $aCampos[1];
        $this->zLinhaEEntity($this->linhaE);
    }

    /**
     * Make tag <dest>
     * @param array $aCampos
     */
    protected function zLinhaEEntity($aCampos)
    {
        //Exx|xNome|indIEDest|IE|ISUF|IM|email|CNPJ/CPF/idExtrangeiro
        $this->make->tagdest(
            $aCampos[7], //cnpj
            $aCampos[8], //cpf
            $aCampos[9], //idEstrangeiro
            $aCampos[1], //xNome
            $aCampos[2], //indIEDest
            $aCampos[3], //IE
            $aCampos[4], //ISUF
            $aCampos[5], //IM
            $aCampos[6] //email
        );
    }

    /**
     * Make tag <enderDest>
     * @param array $aCampos
     */
    protected function e05Entity($aCampos)
    {
        //E05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|
        $this->make->tagenderDest(
            $aCampos[1], //xLgr
            $aCampos[2], //nro
            $aCampos[3], //xCpl
            $aCampos[4], //xBairro
            $aCampos[5], //cMun
            $aCampos[6], //xMun
            $aCampos[7], //siglaUF
            $aCampos[8], //cep
            $aCampos[9], //cPais
            $aCampos[10], //xPais
            $aCampos[11] //fone
        );
    }

    /**
     * Load fEntity (Local de retirada)
     * @param array $aCampos
     */
    protected function fEntity($aCampos)
    {
        //F|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|
        $this->linhaF[0] = $aCampos[0];
        $this->linhaF[1] = $aCampos[1];
        $this->linhaF[2] = $aCampos[2];
        $this->linhaF[3] = $aCampos[3];
        $this->linhaF[4] = $aCampos[4];
        $this->linhaF[5] = $aCampos[5];
        $this->linhaF[6] = $aCampos[6];
        $this->linhaF[7] = $aCampos[7];
        $this->linhaF[8] = '';
        $this->linhaF[9] = '';
    }

    /**
     * f02Entity
     * @param array $aCampos
     */
    protected function f02Entity($aCampos)
    {
        //F02|CNPJ| [retirada]
        $this->linhaF[8] = $aCampos[1];
        $this->zLinhaFEntity($this->linhaF);
    }

    /**
     * f02aEntity
     * @param array $aCampos
     */
    protected function f02aEntity($aCampos)
    {
        //F02a|CPF
        $this->linhaF[9] = $aCampos[1];
        $this->zLinhaFEntity($this->linhaF);
    }

    /**
     * Make tag <retirada>
     * @param array $aCampos
     */
    protected function zLinhaFEntity($aCampos)
    {
        //Fxx|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CNPJ|CPF
        $this->make->tagretirada(
            $aCampos[8], //cnpj
            $aCampos[9], //cpf
            $aCampos[1], //xLgr
            $aCampos[2], //nro
            $aCampos[3], //xCpl
            $aCampos[4], //xBairro
            $aCampos[5], //cMun
            $aCampos[6], //xMun
            $aCampos[7] //siglaUF
        );
    }

    /**
     * Load gEntity (Local de entrega)
     * @param array $aCampos
     */
    protected function gEntity($aCampos)
    {
        //G|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|
        $this->linhaG[0] = $aCampos[0];
        $this->linhaG[1] = $aCampos[1];
        $this->linhaG[2] = $aCampos[2];
        $this->linhaG[3] = $aCampos[3];
        $this->linhaG[4] = $aCampos[4];
        $this->linhaG[5] = $aCampos[5];
        $this->linhaG[6] = $aCampos[6];
        $this->linhaG[7] = $aCampos[7];
        $this->linhaG[8] = '';
        $this->linhaG[9] = '';
    }

    /**
     * g02Entity
     * @param array $aCampos
     */
    protected function g02Entity($aCampos)
    {
        //G02|CNPJ
        $this->linhaG[8] = $aCampos[1];
        $this->zLinhaGEntity($this->linhaG);
    }

    /**
     * g02aEntity
     * @param array $aCampos
     */
    protected function g02aEntity($aCampos)
    {
        //G02a|CPF
        $this->linhaG[9] = $aCampos[1];
        $this->zLinhaGEntity($this->linhaG);
    }

    /**
     * Make tag <entrega>
     * @param array $aCampos
     */
    protected function zLinhaGEntity($aCampos)
    {
        //Gxx|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CNPJ|CPF
        $this->make->tagentrega(
            $aCampos[8], //cnpj
            $aCampos[9], //cpf
            $aCampos[1], //xLgr
            $aCampos[2], //nro
            $aCampos[3], //xCpl
            $aCampos[4], //xBairro
            $aCampos[5], //cMun
            $aCampos[6], //xMun
            $aCampos[7] //siglaUF
        );
    }

    /**
     * Get txt marker GA02
     * @param array $aCampos
     */
    protected function gaEntity($aCampos)
    {
        //GA02
        //fake não faz nada
        $aCampos = array();
    }

    /**
     * Make tag <autXML>  with CNPJ
     * @param array $aCampos
     */
    protected function ga02Entity($aCampos)
    {
        //GA02|CNPJ|
        $this->make->tagautXML($aCampos[1], '');
    }

    /**
     * Make tag <autXML> with CPF
     * @param array $aCampos
     */
    protected function ga03Entity($aCampos)
    {
        //GA03|CPF|
        $this->make->tagautXML('', $aCampos[1]);
    }

    /**
     * Make tag <infAdProd>
     * @param array $aCampos
     */
    protected function hEntity($aCampos)
    {
        //H|item|infAdProd
        if (! empty($aCampos[2])) {
            $this->make->taginfAdProd($aCampos[1], $aCampos[2]);
        }
        $this->nItem = (integer) $aCampos[1];
    }

    /**
     * Make tag <prod>
     * @param array $aCampos
     */
    protected function iEntity($aCampos)
    {
        //I|cProd|cEAN|xProd|NCM|EXTIPI|CFOP|uCom|qCom|vUnCom
        // |vProd|cEANTrib|uTrib|qTrib|vUnTrib
        // |vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|
        $this->make->tagprod(
            $this->nItem, //nItem
            $aCampos[1], //cProd
            $aCampos[2], //cEAN
            $aCampos[3], //xProd
            $aCampos[4], //NCM
            $aCampos[5], //EXTIPI
            $aCampos[6], //CFOP
            $aCampos[7], //uCom
            $aCampos[8], //qCom
            $aCampos[9], //vUnCom
            $aCampos[10], //vProd
            $aCampos[11], //cEANTrib
            $aCampos[12], //uTrib
            $aCampos[13], //qTrib
            $aCampos[14], //vUnTrib
            $aCampos[15], //vFrete
            $aCampos[16], //vSeg
            $aCampos[17], //vDesc
            $aCampos[18], //vOutro
            $aCampos[19], //indTot
            $aCampos[20], //xPed
            $aCampos[21], //nItemPed
            $aCampos[22] //nFCI
        );
    }

    /**
     * Make tag <NVE>
     * @param array $aCampos
     */
    protected function i05aEntity($aCampos)
    {
        //I05A|NVE
        $this->make->tagNVE($this->nItem, $aCampos[1]);
    }

    /**
     * Make tag <CEST>
     * @param array $aCampos
     */
    protected function i05cEntity($aCampos)
    {
        //I05C|CEST
        $this->make->tagCEST($this->nItem, $aCampos[1]);
    }

    /**
     * Make tag <DI>
     * @param array $aCampos
     */
    protected function i18Entity($aCampos)
    {
        //I18|nDI|dDI|xLocDesemb|UFDesemb|dDesemb|tpViaTransp
        //   |vAFRMM|tpIntermedio|CNPJ|UFTerceiro|cExportador|
        $this->make->tagDI(
            $this->nItem,
            $aCampos[1], //nDI
            $aCampos[2], //dDI
            $aCampos[3], //xLocDesemb
            $aCampos[4], //UFDesemb
            $aCampos[5], //dDesemb
            $aCampos[6], //tpViaTransp
            $aCampos[7], //vAFRMM
            $aCampos[8], //tpIntermedio
            $aCampos[9], //CNPJ
            $aCampos[10], //UFTerceiro
            $aCampos[11] //cExportador
        );
        $this->nDI = $aCampos[1];
    }

    /**
     * Make tag <adi>
     * @param array $aCampos
     */
    protected function i25Entity($aCampos)
    {
        //I25|nAdicao|nSeqAdicC|cFabricante|vDescDI|nDraw|
        $this->make->tagadi(
            $this->nItem,
            $this->nDI,
            $aCampos[1], //nAdicao
            $aCampos[2], //nSeqAdicC
            $aCampos[3], //cFabricante
            $aCampos[4], //vDescDI
            $aCampos[5] //nDraw
        );
    }

    /**
     * LOad I50
     * @param array $aCampos
     */
    protected function i50Entity($aCampos)
    {
        //I50|nDraw|
        $this->linhaI50[0] = $aCampos[1];
        $this->linhaI50[1] = '';
        $this->linhaI50[2] = '';
        $this->linhaI50[3] = '';
        $this->zLinhaI50Entity($this->linhaI50);
    }

    /**
     * Load I52
     * @param array $aCampos
     */
    protected function i52Entity($aCampos)
    {
        //I52|nRE|chNFe|qExport|
        $this->linhaI50[1] = $aCampos[1];
        $this->linhaI50[2] = $aCampos[2];
        $this->linhaI50[3] = $aCampos[3];
        $this->zLinhaI50Entity($this->linhaI50);
    }

    /**
     * Make tag <detExport>
     * @param array $aCampos
     */
    protected function zLinhaI50Entity($aCampos)
    {
        //I50xx|nDraw|nRE|chNFe|qExport|
        $this->make->tagdetExport(
            $this->nItem,
            $aCampos[1], //nDraw
            $aCampos[2], //nRE
            $aCampos[3], //chNFe
            $aCampos[4] //qExport
        );
    }

    /**
     * Make tag <veicProd>
     * @param array $aCampos
     */
    protected function jaEntity($aCampos)
    {
        //JA|tpOp|chassi|cCor|xCor|pot|cilin|pesoL|pesoB|nSerie
        //  |tpComb|nMotor|CMT|dist|anoMod|anoFab|tpPint|tpVeic
        //  |espVeic|VIN|condVeic|cMod|cCorDENATRAN|lota|tpRest|
        $this->make->tagveicProd(
            $this->nItem,
            $aCampos[1], //tpOp
            $aCampos[2], //chassi
            $aCampos[3], //cCor
            $aCampos[4], //xCor
            $aCampos[5], //pot
            $aCampos[6], //cilin
            $aCampos[7], //pesoL
            $aCampos[8], //pesoB
            $aCampos[9], //nSerie
            $aCampos[10], //tpComb
            $aCampos[11], //nMotor
            $aCampos[12], //cmt
            $aCampos[13], //dist
            $aCampos[14], //anoMod
            $aCampos[15], //anoFab
            $aCampos[16], //tpPint
            $aCampos[17], //tpVeic
            $aCampos[18], //espVeic
            $aCampos[19], //vIn
            $aCampos[20], //condVeic
            $aCampos[21], //cMod
            $aCampos[22], //cCorDENATRAN
            $aCampos[23], //lota
            $aCampos[24] //tpRest
        );
    }

    /**
     * Make tag <med>
     * @param array $aCampos
     */
    protected function kEntity($aCampos)
    {
        //K|nLote|qLote|dFab|dVal|vPMC|
        $this->make->tagmed(
            $this->nItem,
            $aCampos[1], //nLote
            $aCampos[2], //qLote
            $aCampos[3], //dFab
            $aCampos[4], //dVal
            $aCampos[5] //vPMC
        );
    }

    /**
     * Make tag <arma>
     * @param array $aCampos
     */
    protected function lEntity($aCampos)
    {
        //L|tpArma|nSerie|nCano|descr|
        $this->make->tagarma(
            $this->nItem,
            $aCampos[1], //tpArma
            $aCampos[2], //nSerie
            $aCampos[3], //nCano
            $aCampos[4] //descr
        );
    }

    /**
     * Load LA
     * @param arry $aCampos
     */
    protected function laEntity($aCampos)
    {
        //LA|cProdANP|pMixGN|CODIF|qTemp|UFCons|
        $this->linhaLA = $aCampos;
        $this->linhaLA[6] = '';
        $this->linhaLA[7] = '';
        $this->linhaLA[8] = '';
        $this->zLinhaLAEntity($this->linhaLA);
    }

    /**
     * Load LA07
     * @param array $aCampos
     */
    protected function la07Entity($aCampos)
    {
        //LA07|qBCProd|vAliqProd|vCIDE|
        $this->linhaLA[6] = $aCampos[1];
        $this->linhaLA[7] = $aCampos[2];
        $this->linhaLA[8] = $aCampos[3];
        $this->zLinhaLAEntity($this->linhaLA);
    }

    /**
     * Make tag <comb>
     * @param type $aCampos
     */
    protected function zLinhaLAEntity($aCampos)
    {
        //LAxx|cProdANP|pMixGN|CODIF|qTemp|UFCons|qBCProd|vAliqProd|vCIDE|
        $this->make->tagcomb(
            $this->nItem,
            $aCampos[1], //cProdANP
            $aCampos[2], //pMixGN
            $aCampos[3], //codif
            $aCampos[4], //qTemp
            $aCampos[5], //ufCons
            $aCampos[6], //qBCProd
            $aCampos[7], //vAliqProd
            $aCampos[8] //vCIDE
        );
    }

    /**
     * Make tag <RECOPI>
     * @param array $aCampos
     */
    protected function lbEntity($aCampos)
    {
        //LB|nRECOPI|
        $this->make->tagRECOPI($this->nItem, $aCampos[1]);
    }

    /**
     * Make tag <imposto>
     * @param array $aCampos
     */
    protected function mEntity($aCampos)
    {
        //M|vTotTrib|
        $this->make->tagimposto($this->nItem, $aCampos[1]);
    }

    /**
     * Get N marker trom txt
     * @param array $aCampos
     */
    protected function nEntity($aCampos)
    {
        //N|
        //fake não faz nada
        $aCampos = array();
    }

    /**
     * Load N02
     * @param array $aCampos
     */
    protected function n02Entity($aCampos)
    {
        //N02|orig|CST|modBC|vBC|pICMS|vICMS|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            $aCampos[3], //modBC
            '', //pRedBC
            $aCampos[4], //vBC
            $aCampos[5], //pICMS
            $aCampos[6], //vICMS
            '', //vICMSDeson
            '', //motDesICMS
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N03
     * @param array $aCampos
     */
    protected function n03Entity($aCampos)
    {
        //N03|orig|CST|modBC|vBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            $aCampos[3], //modBC
            '', //pRedBC
            $aCampos[4], //vBC
            $aCampos[5], //pICMS
            $aCampos[6], //vICMS
            '', //vICMSDeson
            '', //motDesICMS
            $aCampos[7], //modBCST
            $aCampos[8], //pMVAST
            $aCampos[9], //pRedBCST
            $aCampos[10], //vBCST
            $aCampos[11], //pICMSST
            $aCampos[12], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N04
     * @param array $aCampos
     */
    protected function n04Entity($aCampos)
    {
        //N04|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|vICMSDeson|motDesICMS|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            $aCampos[3], //modBC
            $aCampos[4], //pRedBC
            $aCampos[5], //vBC
            $aCampos[6], //pICMS
            $aCampos[7], //vICMS
            $aCampos[8], //vICMSDeson
            $aCampos[9], //motDesICMS
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N05
     * @param array $aCampos
     */
    protected function n05Entity($aCampos)
    {
        //N05|orig|CST|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            '', //modBC
            '', //pRedBC
            '', //vBC
            '', //pICMS
            '', //vICMS
            $aCampos[9], //vICMSDeson
            $aCampos[10], //motDesICMS
            $aCampos[3], //modBCST
            $aCampos[4], //pMVAST
            $aCampos[5], //pRedBCST
            $aCampos[6], //vBCST
            $aCampos[7], //pICMSST
            $aCampos[8], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N06
     * @param array $aCampos
     */
    protected function n06Entity($aCampos)
    {
        //N06|orig|CST|vICMSDeson|motDesICMS|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            '', //modBC
            '', //pRedBC
            '', //vBC
            '', //pICMS
            '', //vICMS
            $aCampos[3], //vICMSDeson
            $aCampos[4], //motDesICMS
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N07
     * @param array $aCampos
     */
    protected function n07Entity($aCampos)
    {
        //N07|orig|CST|modBC|pRedBC|vBC|pICMS|vICMSOp|pDif|vICMSDif|vICMS|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            $aCampos[3], //modBC
            $aCampos[4], //pRedBC
            $aCampos[5], //vBC
            $aCampos[6], //pICMS
            $aCampos[10], //vICMS
            '', //vICMSDeson
            '', //motDesICMS
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            $aCampos[8], //pDif
            $aCampos[9], //vICMSDif
            $aCampos[7], //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N08
     * @param array $aCampos
     */
    protected function n08Entity($aCampos)
    {
        //N08|orig|CST|vBCSTRet|vICMSSTRet|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            '', //modBC
            '', //pRedBC
            '', //vBC
            '', //pICMS
            '', //vICMS
            '', //vICMSDeson
            '', //motDesICMS
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            $aCampos[3], //vBCSTRet
            $aCampos[4] //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N09
     * @param array $aCampos
     */
    protected function n09Entity($aCampos)
    {
        //N09|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            $aCampos[3], //modBC
            $aCampos[4], //pRedBC
            $aCampos[5], //vBC
            $aCampos[6], //pICMS
            $aCampos[7], //vICMS
            $aCampos[14], //vICMSDeson
            $aCampos[15], //motDesICMS
            $aCampos[8], //modBCST
            $aCampos[9], //pMVAST
            $aCampos[10], //pRedBCST
            $aCampos[11], //vBCST
            $aCampos[12], //pICMSST
            $aCampos[13], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Load N10
     * @param array $aCampos
     */
    protected function n10Entity($aCampos)
    {
        //N10|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            $aCampos[3], //modBC
            $aCampos[5], //pRedBC
            $aCampos[4], //vBC
            $aCampos[6], //pICMS
            $aCampos[7], //vICMS
            $aCampos[14], //vICMSDeson
            $aCampos[15], //motDesICMS
            $aCampos[8], //modBCST
            $aCampos[9], //pMVAST
            $aCampos[10], //pRedBCST
            $aCampos[11], //vBCST
            $aCampos[12], //pICMSST
            $aCampos[13], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNEntity($aFields);
    }

    /**
     * Make tag <ICMSPart>
     * @param array $aCampos
     */
    protected function n10aEntity($aCampos)
    {
        //N10a|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pBCOp|UFST|
        $this->make->tagICMSPart(
            $this->nItem,
            $aCampos[1], //orig = '',
            $aCampos[2], //cst = '',
            $aCampos[3], //modBC = '',
            $aCampos[4], //vBC = '',
            $aCampos[5], //pRedBC = '',
            $aCampos[6], //pICMS = '',
            $aCampos[7], //vICMS = '',
            $aCampos[8], //modBCST = '',
            $aCampos[9], //pMVAST = '',
            $aCampos[10], //pRedBCST = '',
            $aCampos[11], //vBCST = '',
            $aCampos[12], //pICMSST = '',
            $aCampos[13], //vICMSST = '',
            $aCampos[14], //pBCOp = '',
            $aCampos[15] //ufST = ''
        );
    }

    /**
     * Make tag <ICMSST>
     * @param array $aCampos
     */
    protected function n10bEntity($aCampos)
    {
        //N10b|orig|CST|vBCSTRet|vICMSSTRet|vBCSTDest|vICMSSTDest|
        $this->make->tagICMSST(
            $this->nItem,
            $aCampos[1], //orig = '',
            $aCampos[2], //cst = '',
            $aCampos[3], //vBCSTRet = '',
            $aCampos[4], //vICMSSTRet = '',
            $aCampos[5], //vBCSTDest = '',
            $aCampos[6] //vICMSSTDest = ''
        );
    }

    /**
     * Load N10c
     * @param type $aCampos
     */
    protected function n10cEntity($aCampos)
    {
        //N10c|orig|CSOSN|pCredSN|vCredICMSSN|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            $aCampos[3], //pCredSN
            $aCampos[4], //vCredICMSSN
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNSNEntity($aFields);
    }

    /**
     * Load N10d
     * @param array $aCampos
     */
    protected function n10dEntity($aCampos)
    {
        //N10d|orig|CSOSN|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            '', //pCredSN
            '', //vCredICMSSN
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNSNEntity($aFields);
    }

    /**
     * Load N10e
     * @param array $aCampos
     */
    protected function n10eEntity($aCampos)
    {
        //N10e|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pCredSN|vCredICMSSN|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            $aCampos[9], //pCredSN
            $aCampos[10], //vCredICMSSN
            $aCampos[3], //modBCST
            $aCampos[4], //pMVAST
            $aCampos[5], //pRedBCST
            $aCampos[6], //vBCST
            $aCampos[7], //pICMSST
            $aCampos[8], //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNSNEntity($aFields);
    }

    /**
     * Load N10f
     * @param array $aCampos
     */
    protected function n10fEntity($aCampos)
    {
        //N10f|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            '', //pCredSN
            '', //vCredICMSSN
            $aCampos[3], //modBCST
            $aCampos[4], //pMVAST
            $aCampos[5], //pRedBCST
            $aCampos[6], //vBCST
            $aCampos[7], //pICMSST
            $aCampos[8], //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNSNEntity($aFields);
    }

    /**
     * Load N10g
     * @param array $aCampos
     */
    protected function n10gEntity($aCampos)
    {
        //N10g|orig|CSOSN|vBCSTRet|vICMSSTRet|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            '', //pCredSN
            '', //vCredICMSSN
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            $aCampos[3], //vBCSTRet
            $aCampos[4] //vICMSSTRet
        );
        $this->zLinhaNSNEntity($aFields);
    }

    /**
     * Load N10h
     * @param array $aCampos
     */
    protected function n10hEntity($aCampos)
    {
        //N10h|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST
        //    |vBCST|pICMSST|vICMSST|pCredSN|vCredICMSSN|
        $aFields = array(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //csosn
            $aCampos[3], //modBC
            $aCampos[4], //vBC
            $aCampos[5], //pRedBC
            $aCampos[6], //pICMS
            $aCampos[7], //vICMS
            $aCampos[14], //pCredSN
            $aCampos[15], //vCredICMSSN
            $aCampos[8], //modBCST
            $aCampos[9], //pMVAST
            $aCampos[10], //pRedBCST
            $aCampos[11], //vBCST
            $aCampos[12], //pICMSST
            $aCampos[13], //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        $this->zLinhaNSNEntity($aFields);
    }

    /**
     * Make tag <ICMSUFDest>
     * @param array $aCampos
     */
    protected function naEntity($aCampos)
    {
        //NA|vBCUFDest|pFCPUFDest|pICMSUFDest|pICMSInter|pICMSInterPart|vFCPUFDest|vICMSUFDest|vICMSFRemet|
        if ($aCampos[1] != '') {
            $this->make->tagICMSUFDest(
                $this->nItem,
                $aCampos[1], //$vBCUFDest,
                $aCampos[2], //$pFCPUFDest,
                $aCampos[3], //$pICMSUFDest,
                $aCampos[4], //$pICMSInter,
                $aCampos[5], //$pICMSInterPart,
                $aCampos[6], //$vFCPUFDest,
                $aCampos[7], //$vICMSUFDest,
                $aCampos[8] //$vICMSUFRemet
            );
        }
    }

    /**
     * Make tag <ICMS>
     * @param array $aCampos
     */
    protected function zLinhaNEntity($aCampos)
    {
        //Nxx|orig|cst|modBC|pRedBC|vBC|pICMS|vICMS|vICMSDeson|motDesICMS|modBCST
        //   |pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pDif|vICMSDif|vICMSOp
        //   |BCSTRet|vICMSSTRet|
        $this->make->tagICMS(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //cst
            $aCampos[3], //modBC
            $aCampos[4], //pRedBC
            $aCampos[5], //vBC
            $aCampos[6], //pICMS
            $aCampos[7], //vICMS
            $aCampos[8], //vICMSDeson
            $aCampos[9], //motDesICMS
            $aCampos[10], //modBCST
            $aCampos[11], //pMVAST
            $aCampos[12], //pRedBCST
            $aCampos[13], //vBCST
            $aCampos[14], //pICMSST
            $aCampos[15], //vICMSST
            $aCampos[16], //pDif
            $aCampos[17], //vICMSDif
            $aCampos[18], //vICMSOp
            $aCampos[19], //vBCSTRet
            $aCampos[20] //vICMSSTRet
        );
    }

    /**
     * Load tag <ICMSSN>
     * @param array $aCampos
     */
    protected function zLinhaNSNEntity($aCampos)
    {
        //Nsn|orig|csosn|modBC|vBC|pRedBC|pICMS|vICMS|pCredSN
        //   |vCredICMSSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST
        //   |vICMSST|vBCSTRet|vICMSSTRet|
        $this->make->tagICMSSN(
            $this->nItem,
            $aCampos[1], //orig
            $aCampos[2], //csosn
            $aCampos[3], //modBC
            $aCampos[4], //vBC
            $aCampos[5], //pRedBC
            $aCampos[6], //pICMS
            $aCampos[7], //vICMS
            $aCampos[8], //pCredSN
            $aCampos[9], //vCredICMSSN
            $aCampos[10], //modBCST
            $aCampos[11], //pMVAST
            $aCampos[12], //pRedBCST
            $aCampos[13], //vBCST
            $aCampos[14], //pICMSST
            $aCampos[15], //vICMSST
            $aCampos[16], //vBCSTRet
            $aCampos[17] //vICMSSTRet
        );
    }

    /**
     * Load O
     * @param array $aCampos
     */
    protected function oEntity($aCampos)
    {
        //O|clEnq|CNPJProd|cSelo|qSelo|cEnq|
        $this->linhaO[0] = $this->nItem;
        $this->linhaO[1] = ''; //cst
        $this->linhaO[2] = $aCampos[1]; //clEnq
        $this->linhaO[3] = $aCampos[2]; //cnpjProd
        $this->linhaO[4] = $aCampos[3]; //cSelo
        $this->linhaO[5] = $aCampos[4]; //qSelo
        $this->linhaO[6] = $aCampos[5]; //cEnq
        $this->linhaO[7] = ''; //vBC
        $this->linhaO[8] = ''; //pIPI
        $this->linhaO[9] = ''; //qUnid
        $this->linhaO[10] = ''; //vUnid
        $this->linhaO[11] = ''; //vIPI
    }

    /**
     * Load O07
     * @param array $aCampos
     */
    protected function o07Entity($aCampos)
    {
        //O07|CST|vIPI|
        $this->linhaO[1] = $aCampos[1];
        $this->linhaO[11] = $aCampos[2];
    }

    /**
     * Load O10
     * @param array $aCampos
     */
    protected function o10Entity($aCampos)
    {
        //O10|vBC|pIPI|
        $this->linhaO[7] = $aCampos[1]; //vBC
        $this->linhaO[8] = $aCampos[2]; //pIPI
        $this->zLinhaOEntity($this->linhaO);
    }

    /**
     * Load O11
     * @param array $aCampos
     */
    protected function o11Entity($aCampos)
    {
        //O11|qUnid|vUnid|
        $this->linhaO[9] = $aCampos[1]; //qUnid
        $this->linhaO[10] = $aCampos[2]; //vUnid
        $this->zLinhaOEntity($this->linhaO);
    }

    /**
     * Load O08
     * @param array $aCampos
     */
    protected function o08Entity($aCampos)
    {
        //O08|CST|
        $this->linhaO[1] = $aCampos[1];
        $this->zLinhaOEntity($this->linhaO);
    }

    /**
     * Make tag <IPI>
     * @param array $aCampos
     */
    protected function zLinhaOEntity($aCampos)
    {
        //Oxx|cst|clEnq|cnpjProd|cSelo|qSelo|cEnq|vBC|pIPI|qUnid|vUnid|vIPI|
        $this->make->tagIPI(
            $this->nItem,
            $aCampos[1], //cst
            $aCampos[2], //clEnq
            $aCampos[3], //cnpjProd
            $aCampos[4], //cSelo
            $aCampos[5], //qSelo
            $aCampos[6], //cEnq
            $aCampos[7], //vBC
            $aCampos[8], //pIPI
            $aCampos[9], //qUnid
            $aCampos[10], //vUnid
            $aCampos[11] //vIPI
        );
    }

    /**
     * pEntity
     * Cria a tag II
     *
     * @param array $aCampos
     */
    protected function pEntity($aCampos)
    {
        //P|vBC|vDespAdu|vII|vIOF|
        $this->make->tagII(
            $this->nItem,
            $aCampos[1], //vBC
            $aCampos[2], //vDespAdu
            $aCampos[3], //vII
            $aCampos[4] //vIOF
        );
    }

    /**
     * qEntity
     *
     * @param array $aCampos
     */
    protected function qEntity($aCampos)
    {
        //Q|
        //carrega numero do item
        $aCampos = array();
        $this->linhaQ[0] = $this->nItem;
        $this->linhaQ[1] = ''; //cst
        $this->linhaQ[2] = ''; //vBC
        $this->linhaQ[3] = ''; //pPIS
        $this->linhaQ[4] = ''; //vPIS
        $this->linhaQ[5] = ''; //qBCProd
        $this->linhaQ[6] = ''; //vAliqProd
    }

    /**
     * q02Entity
     *
     * @param array $aCampos
     */
    protected function q02Entity($aCampos)
    {
        //Q02|CST|vBC|pPIS|vPIS|
        $this->linhaQ[1] = $aCampos[1]; //cst
        $this->linhaQ[2] = $aCampos[2]; //vBC
        $this->linhaQ[3] = $aCampos[3]; //pPIS
        $this->linhaQ[4] = $aCampos[4]; //vPIS
        $this->zLinhaQEntity($this->linhaQ);
    }

    /**
     * q03Entity
     *
     * @param array $aCampos
     */
    protected function q03Entity($aCampos)
    {
        //Q03|CST|qBCProd|vAliqProd|vPIS|
        $this->linhaQ[1] = $aCampos[1]; //cst
        $this->linhaQ[4] = $aCampos[4]; //vPIS
        $this->linhaQ[5] = $aCampos[2]; //qBCProd
        $this->linhaQ[6] = $aCampos[3]; //vAliqProd
        $this->zLinhaQEntity($this->linhaQ);
    }

    /**
     * q04Entity
     *
     * @param array $aCampos
     */
    protected function q04Entity($aCampos)
    {
        //Q04|CST|
        $this->linhaQ[1] = $aCampos[1]; //cst
        $this->zLinhaQEntity($this->linhaQ);
    }

    /**
     * q05Entity
     *
     * @param array $aCampos
     */
    protected function q05Entity($aCampos)
    {
        //Q05|CST|vPIS|
        $this->linhaQ[1] = $aCampos[1]; //cst
        $this->linhaQ[2] = ''; //vBC
        $this->linhaQ[3] = ''; //pPIS
        $this->linhaQ[4] = $aCampos[2]; //vPIS
        $this->linhaQ[5] = ''; //qBCProd
        $this->linhaQ[6] = ''; //vAliqProd
        $this->zLinhaQEntity($this->linhaQ);
    }

    /**
     * q07Entity
     *
     * @param array $aCampos
     */
    protected function q07Entity($aCampos)
    {
        //Q07|vBC|pPIS|
        $this->linhaQ[2] = $aCampos[1]; //vBC
        $this->linhaQ[3] = $aCampos[2]; //pPIS
        $this->zLinhaQEntity($this->linhaQ);
    }

    /**
     * q10Entity
     *
     * @param array $aCampos
     */
    protected function q10Entity($aCampos)
    {
        //Q10|qBCProd|vAliqProd|
        $this->linhaQ[5] = $aCampos[1]; //qBCProd
        $this->linhaQ[6] = $aCampos[2]; //vAliqProd
        $this->zLinhaQEntity($this->linhaQ);
    }

    /**
     * zLinhaQEntity
     * Cria a tag PIS
     *
     * @param array $aCampos
     */
    protected function zLinhaQEntity($aCampos)
    {
        //Qxx|CST|vBC|pPIS|vPIS|qBCProd|vAliqProd|
        $this->make->tagPIS(
            $this->nItem,
            $aCampos[1], //cst
            $aCampos[2], //vBC
            $aCampos[3], //pPIS
            $aCampos[4], //vPIS
            $aCampos[5], //qBCProd
            $aCampos[6] //vAliqProd
        );
    }

    /**
     * rEntity
     *
     * @param array $aCampos
     */
    protected function rEntity($aCampos)
    {
        //R|vPIS|
        $this->linhaR[0] = $this->nItem;
        $this->linhaR[1] = ''; //vBC
        $this->linhaR[2] = ''; //pPIS
        $this->linhaR[3] = ''; //qBCProd
        $this->linhaR[4] = ''; //vAliqProd
        $this->linhaR[5] = $aCampos[1]; //vPIS
    }

    /**
     * r02Entity
     *
     * @param array $aCampos
     */
    protected function r02Entity($aCampos)
    {
        //R02|vBC|pPIS|
        $this->linhaR[1] = $aCampos[1]; //vBC
        $this->linhaR[2] = $aCampos[1]; //pPIS
        $this->zLinhaREntity($this->linhaR);
    }

    /**
     * r04Entity
     *
     * @param array $aCampos
     */
    protected function r04Entity($aCampos)
    {
        //R04|qBCProd|vAliqProd|vPIS|
        $this->linhaR[3] = $aCampos[1]; //qBCProd
        $this->linhaR[4] = $aCampos[2]; //vAliqProd
        $this->linhaR[5] = $aCampos[3]; //vPIS
        $this->zLinhaREntity($this->linhaR);
    }

    /**
     * zLinhaREntity
     * Cria a tag PISST
     *
     * @param array $aCampos
     */
    protected function zLinhaREntity($aCampos)
    {
        //Rxx|vBC|pPIS|qBCProd|vAliqProd|vPIS|
        $this->make->tagPISST(
            $this->nItem,
            $aCampos[1], //vBC
            $aCampos[2], //pPIS
            $aCampos[3], //qBCProd
            $aCampos[4], //vAliqProd
            $aCampos[5] //vPIS
        );
    }

    /**
     * sEntity
     *
     * @param array $aCampos
     */
    protected function sEntity($aCampos)
    {
        //S|
        //fake não faz nada
        $aCampos = array();
        $this->linhaS[0] = '';
        $this->linhaS[1] = '';
        $this->linhaS[2] = '';
        $this->linhaS[3] = '';
        $this->linhaS[4] = '';
        $this->linhaS[5] = '';
        $this->linhaS[6] = '';
    }

    /**
     * s02Entity
     *
     * @param array $aCampos
     */
    protected function s02Entity($aCampos)
    {
        //S02|CST|vBC|pCOFINS|vCOFINS|
        $this->linhaS[0] = $this->nItem;
        $this->linhaS[1] = $aCampos[1]; //cst
        $this->linhaS[2] = $aCampos[2]; //vBC
        $this->linhaS[3] = $aCampos[3]; //pCOFINS
        $this->linhaS[4] = $aCampos[4]; //vCOFINS
        $this->linhaS[5] = ''; //qBCProd
        $this->linhaS[6] = ''; //vAliqProd
        $this->zLinhaSEntity($this->linhaS);
    }

    /**
     * s03Entity
     *
     * @param array $aCampos
     */
    protected function s03Entity($aCampos)
    {
        //S03|CST|qBCProd|vAliqProd|vCOFINS|
        $this->linhaS[1] = $aCampos[1]; //cst
        $this->linhaS[4] = $aCampos[4]; //vCOFINS
        $this->linhaS[5] = $aCampos[2]; //qBCProd
        $this->linhaS[6] = $aCampos[3]; //vAliqProd
        $this->zLinhaSEntity($this->linhaS);
    }

    /**
     * s04Entity
     *
     * @param array $aCampos
     */
    protected function s04Entity($aCampos)
    {
        //S04|CST|
        $this->linhaS[1] = $aCampos[1]; //cst
        $this->zLinhaSEntity($this->linhaS);
    }

    /**
     * s05Entity
     *
     * @param array $aCampos
     */
    protected function s05Entity($aCampos)
    {
        //S05|CST|vCOFINS|
        $this->linhaS[1] = $aCampos[1]; //cst
        $this->linhaS[4] = $aCampos[2]; //vCOFINS
    }

    /**
     * s07Entity
     *
     * @param array $aCampos
     */
    protected function s07Entity($aCampos)
    {
        //S07|vBC|pCOFINS|
        $this->linhaS[2] = $aCampos[1]; //vBC
        $this->linhaS[3] = $aCampos[2]; //pCOFINS
        $this->zLinhaSEntity($this->linhaS);
    }

    /**
     * s09Entity
     *
     * @param array $aCampos
     */
    protected function s09Entity($aCampos)
    {
        //S09|qBCProd|vAliqProd|
        $this->linhaS[5] = $aCampos[1]; //qBCProd
        $this->linhaS[6] = $aCampos[2]; //vAliqProd
        $this->zLinhaSEntity($this->linhaS);
    }

    /**
     * zLinhaSEntity
     * Cria a tag COFINS
     *
     * @param array $aCampos
     */
    protected function zLinhaSEntity($aCampos)
    {
        //Sxx|CST|vBC|pCOFINS|vCOFINS|qBCProd|vAliqProd|
        $this->make->tagCOFINS(
            $this->nItem,
            $aCampos[1], //cst
            $aCampos[2], //vBC
            $aCampos[3], //pCOFINS
            $aCampos[4], //vCOFINS
            $aCampos[5], //qBCProd
            $aCampos[6] //vAliqProd
        );
    }

    /**
     * tEntity
     *
     * @param array $aCampos
     */
    protected function tEntity($aCampos)
    {
        //T|vCOFINS|
        $this->linhaT[0] = $this->nItem;
        $this->linhaT[1] = ''; //$vBC
        $this->linhaT[2] = ''; //$pCOFINS
        $this->linhaT[3] = ''; //$qBCProd
        $this->linhaT[4] = ''; //$vAliqProd
        $this->linhaT[5] = $aCampos[1]; //$vCOFINS
    }

    /**
     * t02Entity
     *
     * @param array $aCampos
     */
    protected function t02Entity($aCampos)
    {
        //T02|vBC|pCOFINS|
        $this->linhaT[1] = $aCampos[1]; //$vBC
        $this->linhaT[2] = $aCampos[2]; //$pCOFINS
        $this->zLinhaTEntity($this->linhaT);
    }

    /**
     * t04Entity
     *
     * @param array $aCampos
     */
    protected function t04Entity($aCampos)
    {
        //T04|qBCProd|vAliqProd|
        $this->linhaT[3] = $aCampos[1]; //$qBCProd
        $this->linhaT[4] = $aCampos[2]; //$vAliqProd
        $this->zLinhaTEntity($this->linhaT);
    }

    /**
     * zLinhaTEntity
     * Cria a tag COFINSST
     *
     * @param array $aCampos
     */
    protected function zLinhaTEntity($aCampos)
    {
        //Txx|vBC|pCOFINS|qBCProd|vAliqProd|vCOFINS|
        $this->make->tagCOFINSST(
            $this->nItem,
            $aCampos[1], //$vBC
            $aCampos[2], //$pCOFINS
            $aCampos[3], //$qBCProd
            $aCampos[4], //$vAliqProd
            $aCampos[5] //$vCOFINS
        );
    }

    /**
     * uEntity
     * Cria a tag ISSQN
     *
     * @param array $aCampos
     */
    protected function uEntity($aCampos)
    {
        //U|vBC|vAliq|vISSQN|cMunFG|cListServ|vDeducao|vOutro|vDescIncond
        // |vDescCond|vISSRet|indISS|cServico|cMun|cPais|nProcesso|indIncentivo|
        $this->make->tagISSQN(
            $this->nItem,
            $aCampos[1], //$vBC
            $aCampos[2], //$vAliq
            $aCampos[3], //$vISSQN
            $aCampos[4], //$cMunFG
            $aCampos[5], //$cListServ
            $aCampos[6], //$vDeducao
            $aCampos[7], //$vOutro
            $aCampos[8], //$vDescIncond
            $aCampos[9], //$vDescCond
            $aCampos[10], //$vISSRet
            $aCampos[11], //$indISS
            $aCampos[12], //$cServico
            $aCampos[13], //$cMun
            $aCampos[14], //$cPais
            $aCampos[15], //$nProcesso
            $aCampos[16] //$indIncentivo
        );
    }

    /**
     * uaEntity
     * Cria a tag tagimpostoDevol
     *
     * @param array $aCampos
     */
    protected function uaEntity($aCampos)
    {
        //UA|pDevol|vIPIDevol|
        $this->make->tagimpostoDevol(
            $this->nItem,
            $aCampos[1], //pDevol
            $aCampos[2] //vIPIDevol
        );
    }

    /**
     * wEntity
     *
     * @param array $aCampos
     */
    protected function wEntity($aCampos)
    {
        //W|
        //fake não faz nada
        $aCampos = array();
    }

    /**
     * w02Entity
     * Cria tag ICMSTot
     *
     * @param array $aCampos
     */
    protected function w02Entity($aCampos)
    {
        //W02|vBC|vICMS|vICMSDeson|vBCST|vST|vProd|vFrete|vSeg|vDesc|vII|vIPI
        //   |vPIS|vCOFINS|vOutro|vNF|vTotTrib|
        $this->make->tagICMSTot(
            $aCampos[1], //$vBC
            $aCampos[2], //$vICMS
            $aCampos[3], //$vICMSDeson
            $aCampos[4], //$vBCST
            $aCampos[5], //$vST
            $aCampos[6], //$vProd
            $aCampos[7], //$vFrete
            $aCampos[8], //$vSeg
            $aCampos[9], //$vDesc
            $aCampos[10], //$vII
            $aCampos[11], //$vIPI
            $aCampos[12], //$vPIS
            $aCampos[13], //$vCOFINS
            $aCampos[14], //$vOutro
            $aCampos[15], //$vNF
            $aCampos[16] //$vTotTrib
        );
    }

    /**
     * w17Entity
     * Cria a tag ISSQNTot
     *
     * @param array $aCampos
     */
    protected function w17Entity($aCampos)
    {
        //W17|vServ|vBC|vISS|vPIS|vCOFINS|dCompet|vDeducao|vOutro|vDescIncond
        //   |vDescCond|vISSRet|cRegTrib|
        $this->make->tagISSQNTot(
            $aCampos[1], //$vServ
            $aCampos[2], //$vBC
            $aCampos[3], //$vISS
            $aCampos[4], //$vPIS
            $aCampos[5], //$vCOFINS
            $aCampos[6], //$dCompet
            $aCampos[7], //$vDeducao
            $aCampos[8], //$vOutro
            $aCampos[9], //$vDescIncond
            $aCampos[10], //$vDescCond
            $aCampos[11], //$vISSRet
            $aCampos[12] //$cRegTrib
        );
    }

    /**
     * w23Entity
     * Cria a tag retTrib
     *
     * @param type $aCampos
     */
    protected function w23Entity($aCampos)
    {
        //W23|vRetPIS|vRetCOFINS|vRetCSLL|vBCIRRF|vIRRF|vBCRetPrev|vRetPrev|
        $this->make->tagretTrib(
            $aCampos[1], //$vRetPIS
            $aCampos[2], //$vRetCOFINS
            $aCampos[3], //$vRetCSLL
            $aCampos[4], //$vBCIRRF
            $aCampos[5], //$vIRRF
            $aCampos[6], //$vBCRetPrev
            $aCampos[7] //$vRetPrev
        );
    }

    /**
     * xEntity
     * Cria a tag transp
     *
     * @param array $aCampos
     */
    protected function xEntity($aCampos)
    {
        //X|modFrete|
        $this->make->tagtransp($aCampos[1]);
    }

    /**
     * x03Entity
     *
     * @param array $aCampos
     */
    protected function x03Entity($aCampos)
    {
        //X03|xNome|IE|xEnder|xMun|UF|
        $this->linhaX[0] = '';
        $this->linhaX[1] = ''; //$numCNPJ
        $this->linhaX[2] = ''; //$numCPF
        $this->linhaX[3] = $aCampos[1]; //$xNome
        $this->linhaX[4] = $aCampos[2]; //$numIE
        $this->linhaX[5] = $aCampos[3]; //$xEnder
        $this->linhaX[6] = $aCampos[4]; //$xMun
        $this->linhaX[7] = $aCampos[5]; //$siglaUF
    }
    /**
     * x04Entity
     *
     * @param array $aCampos
     */
    protected function x04Entity($aCampos)
    {
        //X04|CNPJ|
        $this->linhaX[1] = $aCampos[1]; //$numCNPJ
        $this->zLinhaXEntity($this->linhaX);
    }

    /**
     * x05Entity
     *
     * @param array $aCampos
     */
    protected function x05Entity($aCampos)
    {
        //X05|CPF|
        $this->linhaX[2] = $aCampos[1]; //$numCPF
        $this->zLinhaXEntity($this->linhaX);
    }

    /**
     * zLinhaXEntity
     * Cria a tag transporta
     *
     * @param array $aCampos
     */
    protected function zLinhaXEntity($aCampos)
    {
        //Xnn|CNPJ|CPF|xNome|IE|xEnder|xMun|UF|
        $this->make->tagtransporta(
            $aCampos[1], //$numCNPJ
            $aCampos[2], //$numCPF
            $aCampos[3], //$xNome
            $aCampos[4], //$numIE
            $aCampos[5], //$xEnder
            $aCampos[6], //$xMun
            $aCampos[7] //$siglaUF
        );
    }

    /**
     * x11Entity
     *
     * @param array $aCampos
     */
    protected function x11Entity($aCampos)
    {
        //X11|vServ|vBCRet|pICMSRet|vICMSRet|CFOP|cMunFG|
        $this->make->tagretTransp(
            $aCampos[1], //$vServ
            $aCampos[2], //$vBCRet
            $aCampos[3], //$pICMSRet
            $aCampos[4], //$vICMSRet
            $aCampos[5], //$cfop
            $aCampos[6] //$cMunFG
        );
    }

    /**
     * x18Entity
     * Cria a tag veicTransp
     *
     * @param array $aCampos
     */
    protected function x18Entity($aCampos)
    {
        //X18|placa|UF|RNTC|
        $this->make->tagveicTransp(
            $aCampos[1], //$placa
            $aCampos[2], //$siglaUF
            $aCampos[3] //$rntc
        );
    }

    /**
     * x22Entity
     * Cria a tag reboque
     *
     * @param array $aCampos
     */
    protected function x22Entity($aCampos)
    {
        //X22|placa|UF|RNTC|vagao|balsa|
        $this->make->tagreboque(
            $aCampos[1], //$placa
            $aCampos[3], //$siglaUF
            $aCampos[4], //$rntc
            $aCampos[5], //$vagao
            $aCampos[6] //$balsa
        );
    }

    /**
     * x26Entity
     *
     * @param array $aCampos
     */
    protected function x26Entity($aCampos)
    {
        //X26|qVol|esp|marca|nVol|pesoL|pesoB|
        $this->volId += 1;
        $this->linhaX26[$this->volId][0] = $this->volId;
        $this->linhaX26[$this->volId][1] = $aCampos[1]; //$qVol = '',
        $this->linhaX26[$this->volId][2] = $aCampos[2]; //$esp = '',
        $this->linhaX26[$this->volId][3] = $aCampos[3]; //$marca = '',
        $this->linhaX26[$this->volId][4] = $aCampos[4]; //$nVol = '',
        $this->linhaX26[$this->volId][5] = $aCampos[5]; //$pesoL = '',
        $this->linhaX26[$this->volId][6] = $aCampos[6]; //$pesoB = '',
    }

    /**
     * x33Entity
     *
     * @param array $aCampos
     */
    protected function x33Entity($aCampos)
    {
        //X33|nLacre|
        $this->aLacres[$this->volId][] = $aCampos[1];
    }

    /**
     * zLinhaXVolEntity
     * Cria a tag vol
     *
     * @param array $aCampos
     */
    protected function zLinhaXVolEntity($aCampos)
    {
        $lacres = '';
        if ($this->volId > -1 && ! empty($this->aLacres)) {
            $lacres = $this->aLacres[$aCampos[0]];
        }
        $this->make->tagvol(
            $aCampos[1], //$qVol = '',
            $aCampos[2], //$esp = '',
            $aCampos[3], //$marca = '',
            $aCampos[4], //$nVol = '',
            $aCampos[5], //$pesoL = '',
            $aCampos[6], //$pesoB = '',
            $lacres
        );
    }

    /**
     * yEntity
     *
     * @param array $aCampos
     */
    protected function yEntity($aCampos)
    {
        //Y|
        //fake não faz nada
        $aCampos = array();
    }

    /**
     * y02Entity
     * Cria a tag fat
     *
     * @param array $aCampos
     */
    protected function y02Entity($aCampos)
    {
        //Y02|nFat|vOrig|vDesc|vLiq|
        $this->make->tagfat(
            $aCampos[1], //$nFat
            $aCampos[2], //$vOrig
            $aCampos[3], //$vDesc
            $aCampos[4] //$vLiq
        );
    }

    /**
     * y07Entity
     * Cria a tag dup
     *
     * @param array $aCampos
     */
    protected function y07Entity($aCampos)
    {
        //Y07|nDup|dVenc|vDup|
        $this->make->tagdup(
            $aCampos[1], //$nDup
            $aCampos[2], //$dVenc
            $aCampos[3] //$vDup
        );
    }

    /**
     * yaEntity
     * Cria as tags pag e card
     *
     * @param array $aCampos
     */
    protected function yaEntity($aCampos)
    {
        //YA|tPag|vPag|CNPJ|tBand|cAut|tpIntegra|
        $this->make->tagpag(
            $aCampos[1], //$tPag
            $aCampos[2] //$vPag
        );
        if ($aCampos[4] != '') {
            $this->make->tagcard(
                $aCampos[3], //$cnpj
                $aCampos[4], //$tBand
                $aCampos[5], //$cAut
                $aCampos[6] //$tpIntegra
            );
        }
    }

    /**
     * zEntity
     * Cria a a tag infAdic
     *
     * @param array $aCampos
     */
    protected function zEntity($aCampos)
    {
        //Z|infAdFisco|infCpl|
        $this->make->taginfAdic(
            $aCampos[1], //$infAdFisco
            $aCampos[2] //$infCpl
        );
    }

    /**
     * z04Entity
     * Cria a tag obsCont
     *
     * @param array $aCampos
     */
    protected function z04Entity($aCampos)
    {
        //Z04|xCampo|xTexto|
        $this->make->tagobsCont(
            $aCampos[1], //$xCampo
            $aCampos[2] //$xTexto
        );
    }

    /**
     * z07Entity
     * Cria a tag obsFisco
     *
     * @param array $aCampos
     */
    protected function z07Entity($aCampos)
    {
        //Z07|xCampo|xTexto|
        $this->make->tagobsFisco(
            $aCampos[1], //$xCampo
            $aCampos[2] //$xTexto
        );
    }

    /**
     * z10Entity
     * Cria a tag prcRef
     *
     * @param array $aCampos
     */
    protected function z10Entity($aCampos)
    {
        //Z10|nProc|indProc|
        $this->make->tagprocRef(
            $aCampos[1], //$nProc
            $aCampos[2] //$indProc
        );
    }

    /**
     * zaEntity
     * Cria a tag exporta
     *
     * @param array $aCampos
     */
    protected function zaEntity($aCampos)
    {
        //ZA|UFSaidaPais|xLocExporta|xLocDespacho|
        $this->make->tagexporta(
            $aCampos[1], //$ufSaidaPais
            $aCampos[2], //$xLocExporta
            $aCampos[3] //$xLocDespacho
        );
    }

    /**
     * zbEntity
     * Cria a tag compra
     *
     * @param array $aCampos
     */
    protected function zbEntity($aCampos)
    {
        //ZB|xNEmp|xPed|xCont|
        $this->make->tagcompra(
            $aCampos[1], //$xNEmp
            $aCampos[2], //$xPed
            $aCampos[3] //$xCont
        );
    }

    /**
     * zc01Entity
     * Cria a tag cana
     *
     * @param array $aCampos
     */
    protected function zc01Entity($aCampos)
    {
        //ZC|safra|ref|qTotMes|qTotAnt|qTotGer|vFor|vTotDed|vLiqFor|
        $this->make->tagcana(
            $aCampos[1], //$safra
            $aCampos[2] //$ref
        );
        $this->linhaZC[1] = $aCampos[3]; //qTotMes
        $this->linhaZC[2] = $aCampos[4]; //qTotAnt
        $this->linhaZC[3] = $aCampos[5]; //qTotGer
        $this->linhaZC[4] = $aCampos[6]; //vFor
        $this->linhaZC[5] = $aCampos[7]; //vTotDed
        $this->linhaZC[6] = $aCampos[8]; //vLiqFor
    }

    /**
     * zc04Entity
     * Cria a tag forDia
     *
     * @param array $aCampos
     */
    protected function zc04Entity($aCampos)
    {
        //ZC04|dia|qtde|
        $this->make->tagforDia(
            $aCampos[1], //$dia
            $aCampos[2], //$qtde
            $this->linhaZC[1], //$qTotMes
            $this->linhaZC[2], //$qTotAnt
            $this->linhaZC[3] //$qTotGer
        );
    }

    /**
     * zc10Entity
     * Cria a tag deduc
     *
     * @param array $aCampos
     */
    protected function zc10Entity($aCampos)
    {
        //ZC10|xDed|vDed|
        $this->make->tagdeduc(
            $aCampos[1], //$xDed
            $aCampos[2], //$vDed
            $this->linhaZC[4], //$vFor
            $this->linhaZC[5], //$vTotDed
            $this->linhaZC[6] //$vLiqFor
        );
    }

    /**
     * zx01Entity
     * Cria a tag infNFeSupl com o qrCode para impressão da DANFCE
     *
     * @param array $aCampos
     */
    protected function zx01Entity($aCampos)
    {
        //ZX01|qrcode
        $this->make->taginfNFeSupl($aCampos[1]);
    }

    /**
     * zClearParam
     * Clear all parameters
     */
    protected function zClearParam()
    {
        $this->make = null;
        $this->linhaBA10 = array(); //refNFP
        $this->linhaC = array(); //emit
        $this->linhaE = array(); //dest
        $this->linhaF = array();
        $this->linhaG = array();
        $this->nItem = 0; //numero do item da NFe
        $this->nDI = '0'; //numero da DI
        $this->linhaI50 = array(); //dados de exportação
        $this->linhaLA = array();
        $this->linhaO = array();
        $this->linhaQ = array();
        $this->linhaR = array();
        $this->linhaS = array();
        $this->linhaT = array();
        $this->linhaX = array();
        $this->linhaX26 = array();
        $this->volId = -1;
        $this->aLacres = array();
        $this->linhaZC = array();
    }

    /**
     * zSliceNotas
     * Separa as notas em um array
     *
     * @param  array $array
     * @return array
     */
    protected function zSliceNotas($array)
    {
        $annu = explode('|', $array[0]);
        $numnotas = $annu[1];
        unset($array[0]);
        if ($numnotas == 1) {
            $aNotas[] = $array;
            return $aNotas;
        }
        $iCount = 0;
        $xCount = 0;
        $resp = array();
        foreach ($array as $linha) {
            if (substr($linha, 0, 2) == 'A|') {
                $resp[$xCount]['init'] = $iCount;
                if ($xCount > 0) {
                    $resp[$xCount -1]['fim'] = $iCount;
                }
                $xCount += 1;
            }
            $iCount += 1;
        }
        $resp[$xCount-1]['fim'] = $iCount;
        foreach ($resp as $marc) {
            $length = $marc['fim']-$marc['init'];
            $aNotas[] = array_slice($array, $marc['init'], $length, false);
        }
        return $aNotas;
    }

    /**
     * zArray2xml
     * Converte uma Nota Fiscal em um array de txt em um xml
     *
     * @param  array $aDados
     * @return string
     * @throws Exception\RuntimeException
     */
    protected function zArray2xml($aDados = array())
    {
        foreach ($aDados as $dado) {
            $aCampos = $this->zClean(explode("|", $dado));
            $metodo = strtolower(str_replace(' ', '', $aCampos[0])).'Entity';
            if (! method_exists($this, $metodo)) {
                $msg = "O txt tem um metodo não definido!! $dado";
                throw new Exception\RuntimeException($msg);
            }
            $this->$metodo($aCampos);
        }
    }

    /**
     * Clear strings
     * @param  array $aCampos
     * @return array
     */
    protected function zClean($aCampos = array())
    {
        foreach ($aCampos as $campo) {
            $campo = trim(preg_replace('/\s+/', ' ', $campo));
            if ($this->limparString) {
                $campo = Strings::cleanString($campo);
            }
        }
        return $aCampos;
    }
}
