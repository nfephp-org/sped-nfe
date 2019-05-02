<?php

namespace NFePHP\NFe\Factories;

/**
 * Classe de conversão do TXT para XML
 * NOTA: ajustado para Nota Técnica 2018.005 Versão 1.00 – Dezembro de 2018
 * @category  API
 * @package   NFePHP\NFe
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\NFe\Make;
use NFePHP\NFe\Exception\DocumentsException;
use stdClass;

class Parser
{
    const LOCAL = "LOCAL";
    const LOCAL_V12 = "LOCAL_V12";
    const SEBRAE = "SEBRAE";

    /**
     * @var array
     */
    protected $structure;
    /**
     * @var Make
     */
    protected $make;
    /**
     * @var int
     */
    protected $item = 0;
    /**
     * @var int
     */
    protected $nDI = 0;
    /**
     * @var int
     */
    protected $volId = -1;
    /**
     * @var stdClass|null
     */
    protected $stdNFP;
    /**
     * @var stdClass|null
     */
    protected $stdEmit;
    /**
     * @var stdClass|null
     */
    protected $stdDest;
    /**
     * @var stdClass|null
     */
    protected $stdRetirada;
    /**
     * @var stdClass|null
     */
    protected $stdEntrega;
    /**
     * @var stdClass|null
     */
    protected $stdAutXML;
    /**
     * @var stdClass
     */
    protected $stdComb;
    /**
     * @var stdClass
     */
    protected $stdIPI;
    /**
     * @var stdClass
     */
    protected $stdPIS;
    /**
     * @var stdClass
     */
    protected $stdPISST;
    /**
     * @var stdClass
     */
    protected $stdII;
    /**
     * @var stdClass
     */
    protected $stdCOFINS;
    /**
     * @var stdClass
     */
    protected $stdCOFINSST;
    /**
     * @var stdClass|null
     */
    protected $stdTransporta;
    /**
     * @var string
     */
    protected $baselayout;

    /**
     * Configure environment to correct NFe layout
     * @param string $version
     * @param string $baselayout
     */
    public function __construct($version = '4.00', $baselayout = self::LOCAL)
    {
        $ver = str_replace('.', '', $version);
        $comp = "";
        if ($baselayout === 'SEBRAE') {
            $comp = "_sebrae";
        } elseif ($baselayout == 'LOCAL_V12') {
            $comp = "_v1.2";
        }
        $this->baselayout = $baselayout;
        $path = realpath(__DIR__."/../../storage/txtstructure$ver" . $comp . ".json");
        $this->structure = json_decode(file_get_contents($path), true);
        $this->make = new Make();
    }

    /**
     * Convert txt to XML
     * @param array $nota
     * @return string|null
     */
    public function toXml($nota)
    {
        $this->array2xml($nota);
        if ($this->make->monta()) {
            return $this->make->getXML();
        }
        return null;
    }

    /**
     * Converte txt array to xml
     * @param array $nota
     * @return void
     */
    protected function array2xml($nota)
    {
        foreach ($nota as $lin) {
            $fields = explode('|', $lin);
            if (empty($fields)) {
                continue;
            }
            $metodo = strtolower(str_replace(' ', '', $fields[0])).'Entity';
            if (!method_exists(__CLASS__, $metodo)) {
                throw DocumentsException::wrongDocument(16, $lin); //campo não definido
            }
            $struct = $this->structure[strtoupper($fields[0])];
            $std = $this->fieldsToStd($fields, $struct);
            $this->$metodo($std);
        }
    }

    /**
     * Creates stdClass for all tag fields
     * @param array $dfls
     * @param string $struct
     * @return stdClass
     */
    protected static function fieldsToStd($dfls, $struct)
    {
        $sfls = explode('|', $struct);
        $len = count($sfls)-1;
        $std = new \stdClass();
        for ($i = 1; $i < $len; $i++) {
            $name = $sfls[$i];
            $data = $dfls[$i];
            if (!empty($name) && $data !== '') {
                $std->$name = $data;
            }
        }
        return $std;
    }

    /**
     * Create tag infNFe [A]
     * A|versao|Id|pk_nItem|
     * @param stdClass $std
     * @return void
     */
    protected function aEntity($std)
    {
        $this->make->taginfNFe($std);
    }

    /**
     * Create tag ide [B]
     * B|cUF|cNF|natOp|mod|serie|nNF|dhEmi|dhSaiEnt|tpNF|idDest|cMunFG|tpImp
     *  |tpEmis|cDV|tpAmb|finNFe|indFinal|indPres|procEmi|verProc|dhCont|xJust|
     * @param stdClass $std
     * @return void
     */
    protected function bEntity($std)
    {
        $this->make->tagide($std);
    }

    /**
     * Create tag nfref [BA]
     * BA|
     * @param stdClass $std
     * @return void
     */
    protected function baEntity($std)
    {
        //fake não faz nada
        $field = null;
    }

    /**
     * Create tag refNFe [BA02]
     * BA02|refNFe|
     * @param stdClass $std
     * @return void
     */
    protected function ba02Entity($std)
    {
        $this->make->tagrefNFe($std);
    }

    /**
     * Create tag refNF [BA03]
     * BA03|cUF|AAMM|CNPJ|mod|serie|nNF|
     * @param stdClass $std
     * @return void
     */
    protected function ba03Entity($std)
    {
        $this->make->tagrefNF($std);
    }

    /**
     * Load fields for tag refNFP [BA10]
     * BA10|cUF|AAMM|IE|mod|serie|nNF|
     * @param stdClass $std
     * @return void
     */
    protected function ba10Entity($std)
    {
        $this->stdNFP = $std;
        $this->stdNFP->CNPJ = null;
        $this->stdNFP->CPF = null;
    }

    /**
     * Create tag refNFP [BA13], with CNPJ belongs to [BA10]
     * BA13|CNPJ|
     * @param stdClass $std
     * @return void
     */
    protected function ba13Entity($std)
    {
        $this->stdNFP->CNPJ = $std->CNPJ;
        $this->buildBA10Entity();
        $this->stdNFP = null;
    }

    /**
     * Create tag refNFP [BA14], with CPF belongs to [BA10]
     * BA14|CPF|
     * @param stdClass $std
     * @return void
     */
    protected function ba14Entity($std)
    {
        $this->stdNFP->CPF = $std->CPF;
        $this->buildBA10Entity();
        $this->stdNFP = null;
    }

    /**
     * Create tag refNFP [BA10]
     * @return void
     */
    protected function buildBA10Entity()
    {
        $this->make->tagrefNFP($this->stdNFP);
    }

    /**
     * Create tag refCTe [BA19]
     * B19|refCTe|
     * @param stdClass $std
     * @return void
     */
    protected function ba19Entity($std)
    {
        $this->make->tagrefCTe($std);
    }

    /**
     * Create tag refECF [BA20]
     * BA20|mod|nECF|nCOO|
     * @param stdClass $std
     * @return void
     */
    protected function ba20Entity($std)
    {
        $this->make->tagrefECF($std);
    }

    /**
     * Load fields for tag emit [C]
     * C|XNome|XFant|IE|IEST|IM|CNAE|CRT|
     * @param stdClass $std
     * @return void
     */
    protected function cEntity($std)
    {
        $this->stdEmit = $std;
        $this->stdEmit->CNPJ = null;
        $this->stdEmit->CPF = null;
    }

    /**
     * Create tag emit [C02], with CNPJ belongs to [C]
     * C02|CNPJ|
     * @param stdClass $std
     * @return void
     */
    protected function c02Entity($std)
    {
        $this->stdEmit->CNPJ = $std->CNPJ;
        $this->buildCEntity();
        $this->stdEmit = null;
    }

    /**
     * Create tag emit [C02a], with CPF belongs to [C]
     * C02a|CPF|
     * @param stdClass $std
     * @return void
     */
    protected function c02aEntity($std)
    {
        $this->stdEmit->CPF = $std->CPF;
        $this->buildCEntity();
        $this->stdEmit = null;
    }

    protected function dEntity($std)
    {
        //nada
    }

    /**
     * Create tag emit [C]
     * @return void
     */
    protected function buildCEntity()
    {
        $this->make->tagemit($this->stdEmit);
    }

    /**
     * Create tag enderEmit [C05]
     * C05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|
     * @param stdClass $std
     * @return void
     */
    protected function c05Entity($std)
    {
        $this->make->tagenderEmit($std);
    }

    /**
     * Load fields for tag dest [E]
     * E|xNome|indIEDest|IE|ISUF|IM|email|
     * @param stdClass $std
     * @return void
     */
    protected function eEntity($std)
    {
        $this->stdDest = $std;
        $this->stdDest->CNPJ = null;
        $this->stdDest->CPF = null;
        $this->stdDest->idEstrangeiro = null;
    }

    /**
     * Create tag dest [E02], with CNPJ belongs to [E]
     * E02|CNPJ|
     * @param stdClass $std
     * @return void
     */
    protected function e02Entity($std)
    {
        $this->stdDest->CNPJ = $std->CNPJ;
        $this->buildEEntity();
        $this->stdDest = null;
    }

    /**
     * Create tag dest [E03], with CPF belongs to [E]
     * E03|CPF|
     * @param stdClass $std
     * @return void
     */
    protected function e03Entity($std)
    {
        $this->stdDest->CPF = $std->CPF;
        $this->buildEEntity();
        $this->stdDest = null;
    }

    /**
     * Create tag dest [E03a], with idEstrangeiro belongs to [E]
     * E03a|idEstrangeiro|
     * @param stdClass $std
     * @return void
     */
    protected function e03aEntity($std)
    {
        $this->stdDest->idEstrangeiro = !empty($std->idEstrangeiro) ? $std->idEstrangeiro : '';
        $this->buildEEntity();
        $this->stdDest = null;
    }

    /**
     * Create tag dest [E]
     * @return void
     */
    protected function buildEEntity()
    {
        $this->make->tagdest($this->stdDest);
    }

    /**
     * Create tag enderDest [E05]
     * E05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|
     * @param stdClass $std
     * @return void
     */
    protected function e05Entity($std)
    {
        $this->make->tagenderDest($std);
    }

    /**
     * Load fields for tag retirada [F]
     * F|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|email|IE|
     * @param stdClass $std
     * @return void
     */
    protected function fEntity($std)
    {
        $this->stdRetirada = null;
        $this->stdRetirada = $std;
        $this->stdRetirada->CNPJ = null;
        $this->stdRetirada->CPF = null;
        $this->stdRetirada->xNome = null;
    }

    /**
     * Create tag retirada [F02], with CNPJ belongs to [F]
     * F02|CNPJ|
     * @param stdClass $std
     * @return void
     */
    protected function f02Entity($std)
    {
        $this->stdRetirada->CNPJ = $std->CNPJ;
        $this->buildFEntity();
    }

    /**
     * Create tag retirada [F02a], with CPF belongs to [F]
     * F02a|CPF|
     * @param stdClass $std
     * @return void
     */
    protected function f02aEntity($std)
    {
        $this->stdRetirada->CPF = $std->CPF;
        $this->buildFEntity();
    }
    
    /**
     * Create tag retirada [F02b], with xNome belongs to [F]
     * F02a|xNome|
     * @param stdClass $std
     * @return void
     */
    protected function f02bEntity($std)
    {
        $this->stdRetirada->xNome = $std->xNome;
        $this->buildFEntity();
    }

    /**
     * Create tag retirada [F]
     * @return void
     */
    protected function buildFEntity()
    {
        $this->make->tagretirada($this->stdRetirada);
    }

    /**
     * Load fields for tag entrega [G]
     * G|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|email|IE|
     * @param stdClass $std
     * @return void
     */
    protected function gEntity($std)
    {
        $this->stdEntrega = null;
        $this->stdEntrega = $std;
        $this->stdEntrega->CNPJ = null;
        $this->stdEntrega->CPF = null;
        $this->stdEntrega->xNome = null;
    }

    /**
     * Create tag entrega [G02], with CNPJ belongs to [G]
     * G02|CNPJ|
     * @param stdClass $std
     * @return void
     */
    protected function g02Entity($std)
    {
        $this->stdEntrega->CNPJ = $std->CNPJ;
        $this->buildGEntity();
    }

    /**
     * Create tag entrega [G02a], with CPF belongs to [G]
     * G02a|CPF|
     * @param stdClass $std
     * @return void
     */
    protected function g02aEntity($std)
    {
        $this->stdEntrega->CPF = $std->CPF;
        $this->buildGEntity();
    }
    
    /**
     * Create tag entrega [G02b], with xNome belongs to [G]
     * G02b|xNome|
     * @param stdClass $std
     * @return void
     */
    protected function g02bEntity($std)
    {
        $this->stdEntrega->xNome = $std->xNome;
        $this->buildGEntity();
    }
    

    /**
     * Create tag entrega [G]
     * @return void
     */
    protected function buildGEntity()
    {
        $this->make->tagentrega($this->stdEntrega);
    }

    /**
     * Create tag autXML [GA]
     * GA|
     * @param stdClass $std
     * @return void
     */
    protected function gaEntity($std)
    {
        //fake não faz nada
        $std->CNPJ = null;
        $std->CPF = null;
        $this->stdAutXML = $std;
    }

    /**
     * Create tag autXML with CNPJ [GA02], belongs to [GA]
     * GA02|CNPJ|
     * @param stdClass $std
     * @return void
     */
    protected function ga02Entity($std)
    {
        $this->stdAutXML->CNPJ = $std->CNPJ;
        $this->make->tagautXML($this->stdAutXML);
        $this->stdAutXML = null;
    }

    /**
     * Create tag autXML with CPF [GA03], belongs to GA
     * GA03|CPF|
     * @param stdClass $std
     * @return void
     */
    protected function ga03Entity($std)
    {
        $this->stdAutXML->CPF = $std->CPF;
        $this->make->tagautXML($this->stdAutXML);
        $this->stdAutXML = null;
    }

    /**
     * Create tag det/infAdProd [H]
     * H|item|infAdProd|
     * @param stdClass $std
     */
    protected function hEntity($std)
    {
        if (!empty($std->infAdProd)) {
            $this->make->taginfAdProd($std);
        }
        $this->item = (integer) $std->item;
    }

    /**
     * Create tag prod [I]
     * LOCAL
     * I|cProd|cEAN|xProd|NCM|cBenef|EXTIPI|CFOP|uCom|qCom|vUnCom|vProd|cEANTrib|uTrib|qTrib|vUnTrib|vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|
     * SEBRAE
     * I|cProd|cEAN|xProd|NCM|EXTIPI|CFOP|uCom|qCom|vUnCom|vProd|cEANTrib|uTrib|qTrib|vUnTrib|vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|
     * @param stdClass $std
     * @return void
     */
    protected function iEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagprod($std);
    }

    /**
     * Create tag NVE [I05A]
     * I05A|NVE|
     * @param stdClass $std
     * @return void
     */
    protected function i05aEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagNVE($std);
    }

    /**
     * Create tag CEST [I05C]
     * I05C|CEST|indEscala|CNPJFab|
     * SEBRAE
     * I05C|CEST|indEscala|CNPJFab|cBenef|
     * @param stdClass $std
     * @return void
     */
    protected function i05cEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagCEST($std);
    }

    /**
     * Create tag DI [I18]
     * I18|nDI|dDI|xLocDesemb|UFDesemb|dDesemb|tpViaTransp|vAFRMM|tpIntermedio|CNPJ|UFTerceiro|cExportador|
     * @param stdClass $std
     * @return void
     */
    protected function i18Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagDI($std);
        $this->nDI = $std->nDI;
    }

    /**
     * Create tag adi [I25], belongs to [I18]
     * I25|nAdicao|nSeqAdicC|cFabricante|vDescDI|nDraw|
     * @param stdClass $std
     * @return void
     */
    protected function i25Entity($std)
    {
        $std->item = $this->item;
        $std->nDI = $this->nDI;
        $this->make->tagadi($std);
    }

    /**
     * Load fields for tag detExport [I50]
     * I50|nDraw|
     * @param stdClass $std
     * @return void
     */
    protected function i50Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagdetExport($std);
    }

    /**
     * Create tag detExport/exportInd [I52], belongs to [I50]
     * I52|nRE|chNFe|qExport|
     * @param stdClass $std
     * @return void
     */
    protected function i52Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagdetExportInd($std);
    }

    /**
     * Create tag RASTRO [I80]
     * I80|nLote|qLote|dFab|dVal|cAgreg|
     * @param stdClass $std
     * @return void
     */
    protected function i80Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagRastro($std);
    }

    /**
     * Create tag veicProd [JA]
     * JA|tpOp|chassi|cCor|xCor|pot|cilin|pesoL|pesoB|nSerie|tpComb|nMotor|CMT|dist|anoMod|anoFab|tpPint|tpVeic|espVeic|VIN|condVeic|cMod|cCorDENATRAN|lota|tpRest|
     * @param stdClass $std
     * @return void
     */
    protected function jaEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagveicProd($std);
    }

    /**
     * Create tag med [K]
     * K|cProdANVISA|vPMC|xMotivoIsencao|
     * @param stdClass $std
     * @return void
     */
    protected function kEntity($std)
    {
        $std->item = $this->item;
        $std->nLote = !empty($std->nLote) ? $std->nLote : null;
        $std->qLote = !empty($std->qLote) ? $std->qLote : null;
        $std->dFab = !empty($std->dFab) ? $std->dFab : null;
        $std->dVal = !empty($std->dVal) ? $std->dVal : null;
        $std->cProdANVISA = !empty($std->cProdANVISA) ? $std->cProdANVISA : null;
        $std->xMotivoIsencao = !empty($std->xMotivoIsencao) ? $std->xMotivoIsencao : null;
        $this->make->tagmed($std);
    }

    /**
     * Create tag arma [L]
     * L|tpArma|nSerie|nCano|descr|
     * @param stdClass $std
     * @return void
     */
    protected function lEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagarma($std);
    }

    /**
     * Load fields for tag comb [LA]
     * LA|cProdANP|descANP|pGLP|pGNn|pGNi|vPart|CODIF|qTemp|UFCons|
     * @param stdClass $std
     * @return void
     */
    protected function laEntity($std)
    {
        $std->item = $this->item;
        $this->stdComb = $std;
    }

    /**
     * Load fields for tag comb [LA07], belongs to [LA]
     * LA07|qBCProd|vAliqProd|vCIDE|
     * @param stdClass $std
     * @return void
     */
    protected function la07Entity($std)
    {
        $this->stdComb->qBCProd = $std->qBCProd;
        $this->stdComb->vAliqProd = $std->vAliqProd;
        $this->stdComb->vCIDE = $std->vCIDE;
    }

    /**
     * Load fields for tag encerrante [LA11]
     * LA11|nBico|nBomba|nTanque|vEncIni|vEncFin|
     * @param stdClass $std
     * @return void
     */
    protected function la11Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagencerrante($std);
    }

    /**
     * Create tag comb [LA]
     * @return void
     */
    protected function buildLAEntity()
    {
        if (!empty($this->stdComb)) {
            $this->make->tagcomb($this->stdComb);
        }
    }

    /**
     * Create tag RECOPI [LB]
     * LB|nRECOPI|
     * @param stdClass $std
     * @return void
     */
    protected function lbEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagRECOPI($std);
    }

    /**
     * Create tag imposto [M]
     * M|vTotTrib|
     * @param stdClass $std
     * @return void
     */
    protected function mEntity($std)
    {
        //create tag comb [LA]
        $this->buildLAEntity();

        $std->item = $this->item;
        $this->make->tagimposto($std);
    }

    /**
     * Carrega a tag ICMS [N]
     * N|
     * @param stdClass $std
     * @return void
     */
    protected function nEntity($std)
    {
        //fake não faz nada
        $field = null;
    }

    /**
     * Load fields for tag ICMS [N02]
     * N02|orig|CST|modBC|vBC|pICMS|vICMS|pFCP|vFCP|
     * @param stdClass $std
     * @return void
     */
    protected function n02Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N03]
     * N03|orig|CST|modBC|vBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|
     * @param stdClass $std
     * @return void
     */
    protected function n03Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N04]
     * N04|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|BCFCP|pFCP|vFCP|vICMSDeson|motDesICMS|
     * @param stdClass $std
     * @return void
     */
    protected function n04Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N05]
     * N05|orig|CST|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     * @return void
     */
    protected function n05Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N06]
     * N06|orig|CST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     * @return void
     */
    protected function n06Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N07]
     * N07|orig|CST|modBC|pRedBC|vBC|pICMS|vICMSOp|pDif|vICMSDif|vICMS|vBCFCP|pFCP|vFCP|
     * @param stdClass $std
     * @return void
     */
    protected function n07Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N08]
     * N08|orig|CST|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|
     * @param stdClass $std
     * @return void
     */
    protected function n08Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N09]
     * N09|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     * @return void
     */
    protected function n09Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Load fields for tag ICMS [N10]
     * N10|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     * @return void
     */
    protected function n10Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Create tag ICMS [N]
     * NOTE: adjusted for NT2016_002_v1.30
     * @param \stdClass $std
     * @return void
     */
    protected function buildNEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMS($std);
    }

    /**
     * Create tag ICMSPart [N10a]
     * N10a|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pBCOp|UFST|
     * @param stdClass $std
     * @return void
     */
    protected function n10aEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMSPart($std);
    }

    /**
     * Create tag ICMSST [N10b]
     * N10b|orig|CST|vBCSTRet|vICMSSTRet|vBCSTDest|vICMSSTDest|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|
     * @param stdClass $std
     * @return void
     */
    protected function n10bEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMSST($std);
    }

    /**
     * Carrega e Create tag ICMSSN [N10c]
     * N10c|orig|CSOSN|pCredSN|vCredICMSSN|
     * @param stdClass $std
     * @return void
     */
    protected function n10cEntity($std)
    {
        $this->buildNSNEntity($std);
    }

    /**
     * Carrega e Create tag ICMSSN [N10d]
     * N10d|orig|CSOSN|
     * @param stdClass $std
     * @return void
     */
    protected function n10dEntity($std)
    {
        $this->buildNSNEntity($std);
    }


    /**
     * Carrega e Create tag ICMSSN [N10e]
     * N10e|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|pCredSN|vCredICMSSN|pCredSN|vCredICMSSN|
     * @param stdClass $std
     * @return void
     */
    protected function n10eEntity($std)
    {
        $this->buildNSNEntity($std);
    }
    /**
     * Carrega e Create tag ICMSSN [N10f]
     * N10f|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|
     * @param stdClass $std
     * @return void
     */
    protected function n10fEntity($std)
    {
        $this->buildNSNEntity($std);
    }

    /**
     * Carrega e Create tag ICMSSN [N10g]
     * N10g|orig|CSOSN|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|
     * @param stdClass $std
     * @return void
     */
    protected function n10gEntity($std)
    {
        $this->buildNSNEntity($std);
    }

    /**
     * Carrega e Create tag ICMSSN [N10h]
     * N10h|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|pCredSN|vCredICMSSN|
     * @param stdClass $std
     * @return void
     */
    protected function n10hEntity($std)
    {
        $this->buildNSNEntity($std);
    }

    /**
     * Create tag ICMSSN [NS]
     * Nsn|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|pCredSN|vCredICMSSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCSTRet|vICMSSTRet|vBCFCPST|pFCPST|vFCPST|
     * @param stdClass $std
     * @return void
     */
    protected function buildNSNEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMSSN($std);
    }

    /**
     * Load field fot tag ICMSUFDest [NA]
     * NA|vBCUFDest|pFCPUFDest|pICMSUFDest|pICMSInter|pICMSInterPart|vFCPUFDest|vICMSUFDest|vICMSFRemet|
     * @param stdClass $std
     * @return void
     */
    protected function naEntity($std)
    {
        $this->buildNAEntity($std);
    }

    /**
     * Create tag ICMSUFDest [NA]
     * @param stdClass $std
     * @return void
     */
    protected function buildNAEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMSUFDest($std);
    }

    /**
     * Load fields for tag IPI [O]
     * O|clEnq|CNPJProd|cSelo|qSelo|cEnq|
     * @param stdClass $std
     * @return void
     */
    protected function oEntity($std)
    {
        $std->item = $this->item;
        $this->stdIPI = $std;
        $this->stdIPI->CST = null;
        $this->stdIPI->vIPI = null;
        $this->stdIPI->vBC = null;
        $this->stdIPI->pIPI = null;
        $this->stdIPI->qUnid = null;
        $this->stdIPI->vUnid = null;
    }

    /**
     * Load fields for tag IPI [O07], belongs to [O]
     * O07|CST|vIPI|
     * @param stdClass $std
     * @return void
     */
    protected function o07Entity($std)
    {
        $this->stdIPI->CST = $std->CST;
        $this->stdIPI->vIPI = $std->vIPI;
    }

    /**
     * Load fields for tag IPI [O08], belongs to [O]
     * O08|CST|
     * @param stdClass $std
     * @return void
     */
    protected function o08Entity($std)
    {
        $this->stdIPI->CST = $std->CST;
        $this->buildOEntity();
    }

    /**
     * Load fields for tag IPI [O10], belongs to [O]
     * O10|vBC|pIPI|
     * @param stdClass $std
     * @return void
     */
    protected function o10Entity($std)
    {
        $this->stdIPI->vBC = $std->vBC;
        $this->stdIPI->pIPI = $std->pIPI;
        $this->buildOEntity();
    }

    /**
     * Load fields for tag IPI [O11], belongs to [O]
     * O11|qUnid|vUnid|
     * @param stdClass $std
     * @return void
     */
    protected function o11Entity($std)
    {
        $this->stdIPI->qUnid = $std->qUnid;
        $this->stdIPI->vUnid = $std->vUnid;
        $this->buildOEntity();
    }

    /**
     * Create tag IPI [O]
     * Oxx|cst|clEnq|cnpjProd|cSelo|qSelo|cEnq|vBC|pIPI|qUnid|vUnid|vIPI|
     * @return void
     */
    protected function buildOEntity()
    {
        $this->make->tagIPI($this->stdIPI);
    }

    /**
     * Create tag II [P]
     * P|vBC|vDespAdu|vII|vIOF|
     * @param stdClass $std
     * @return void
     */
    protected function pEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagII($std);
    }

    /**
     * Load fields for tag PIS [Q]
     * Q|
     * @param stdClass $std
     * @return void
     */
    protected function qEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdPIS = $std;
        $this->stdPIS->vBC = null;
        $this->stdPIS->pPIS = null;
        $this->stdPIS->vPIS = null;
        $this->stdPIS->qBCProd = null;
        $this->stdPIS->vAliqProd = null;
    }

    /**
     * Load fields for tag PIS [Q02], belongs to [Q]
     * Q02|CST|vBC|pPIS|vPIS|
     * @param stdClass $std
     * @return void
     */
    protected function q02Entity($std)
    {
        $this->stdPIS->CST = $std->CST;
        $this->stdPIS->vBC = $std->vBC;
        $this->stdPIS->pPIS = $std->pPIS;
        $this->stdPIS->vPIS = $std->vPIS;
        $this->buildQEntity();
    }

    /**
     * Load fields for tag PIS [Q03], belongs to [Q]
     * Q03|CST|qBCProd|vAliqProd|vPIS|
     * @param stdClass $std
     * @return void
     */
    protected function q03Entity($std)
    {
        $this->stdPIS->CST = $std->CST;
        $this->stdPIS->vPIS = $std->vPIS;
        $this->stdPIS->qBCProd = $std->qBCProd;
        $this->stdPIS->vAliqProd  = $std->vAliqProd;
        $this->buildQEntity();
    }

    /**
     * Load fields for tag PIS [Q04], belongs to [Q]
     * Q04|CST|
     * @param stdClass $std
     * @return void
     */
    protected function q04Entity($std)
    {
        $this->stdPIS->CST = $std->CST;
        $this->buildQEntity();
    }

    /**
     * Load fields for tag PIS [Q05], belongs to [Q]
     * Q05|CST|vPIS|
     * @param stdClass $std
     * @return void
     */
    protected function q05Entity($std)
    {
        $this->stdPIS->CST = $std->CST;
        $this->stdPIS->vPIS = $std->vPIS;
        $this->buildQEntity();
    }

    /**
     * Load fields for tag PIS [Q07], belongs to [Q]
     * Q07|vBC|pPIS|
     * @param stdClass $std
     * @return void
     */
    protected function q07Entity($std)
    {
        $this->stdPIS->vBC = $std->vBC;
        $this->stdPIS->pPIS = $std->pPIS;
        $this->buildQEntity();
    }

    /**
     * Load fields for tag PIS [Q10], belongs to [Q]
     * Q10|qBCProd|vAliqProd|
     * @param stdClass $std
     * @return void
     */
    protected function q10Entity($std)
    {
        $this->stdPIS->qBCProd = $std->qBCProd;
        $this->stdPIS->vAliqProd  = $std->vAliqProd;
        $this->buildQEntity();
    }

    /**
     * Create tag PIS [Q]
     * Qxx|CST|vBC|pPIS|vPIS|qBCProd|vAliqProd|
     * @return void
     */
    protected function buildQEntity()
    {
        $this->make->tagPIS($this->stdPIS);
    }

    /**
     * Load fields for tag PISST [R]
     * R|vPIS|
     * @param stdClass $std
     * @return void
     */
    protected function rEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdPISST = $std;
        $this->stdPISST->vBC = null;
        $this->stdPISST->pPIS = null;
        $this->stdPISST->vPIS = null;
        $this->stdPISST->qBCProd = null;
        $this->stdPISST->vAliqProd = null;
    }

    /**
     * Load fields for tag PISST [R02], belongs to [R]
     * R02|vBC|pPIS|
     * @param stdClass $std
     * @return void
     */
    protected function r02Entity($std)
    {
        $this->stdPISST->vBC = $std->vBC;
        $this->stdPISST->pPIS = $std->pPIS;
        $this->buildREntity();
    }

    /**
     * Load fields for tag PISST [R04], belongs to [R]
     * R04|qBCProd|vAliqProd|vPIS|
     * @param stdClass $std
     * @return void
     */
    protected function r04Entity($std)
    {
        $this->stdPISST->qBCProd = $std->qBCProd;
        $this->stdPISST->vAliqProd = $std->vAliqProd;
        $this->stdPISST->vPIS = $std->vPIS;
        $this->buildREntity();
    }

    /**
     * Create tag PISST
     * Rxx|vBC|pPIS|qBCProd|vAliqProd|vPIS|
     * @return void
     */
    protected function buildREntity()
    {
        $this->make->tagPISST($this->stdPISST);
    }

    /**
     * Load fields for tag COFINS [S]
     * S|
     * @param stdClass $std
     * @return void
     */
    protected function sEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdCOFINS = $std;
        $this->stdCOFINS->vBC = null;
        $this->stdCOFINS->pCOFINS = null;
        $this->stdCOFINS->vCOFINS = null;
        $this->stdCOFINS->qBCProd = null;
        $this->stdCOFINS->vAliqProd = null;
    }

    /**
     * Load fields for tag COFINS [S02], belongs to [S]
     * S02|CST|vBC|pCOFINS|vCOFINS|
     * @param stdClass $std
     * @return void
     */
    protected function s02Entity($std)
    {
        $this->stdCOFINS->CST = $std->CST;
        $this->stdCOFINS->vBC = $std->vBC;
        $this->stdCOFINS->pCOFINS = $std->pCOFINS;
        $this->stdCOFINS->vCOFINS = $std->vCOFINS;
        $this->buildSEntity();
    }

    /**
     * Load fields for tag COFINS [S03], belongs to [S]
     * S03|CST|qBCProd|vAliqProd|vCOFINS|
     * @param stdClass $std
     * @return void
     */
    protected function s03Entity($std)
    {
        $this->stdCOFINS->CST = $std->CST;
        $this->stdCOFINS->qBCProd = $std->qBCProd;
        $this->stdCOFINS->vAliqProd = $std->vAliqProd;
        $this->stdCOFINS->vCOFINS = $std->vCOFINS;
        $this->buildSEntity();
    }

    /**
     * Load fields for tag COFINS [S04], belongs to [S]
     * S04|CST|
     * @param stdClass $std
     * @return void
     */
    protected function s04Entity($std)
    {
        $this->stdCOFINS->CST = $std->CST;
        $this->buildSEntity();
    }

    /**
     * Load fields for tag COFINS [S05], belongs to [S]
     * S05|CST|vCOFINS|
     * @param stdClass $std
     * @return void
     */
    protected function s05Entity($std)
    {
        $this->stdCOFINS->CST = $std->CST;
        $this->stdCOFINS->vCOFINS = $std->vCOFINS;
    }

    /**
     * Load fields for tag COFINS [S07], belongs to [S]
     * S07|vBC|pCOFINS|
     * @param stdClass $std
     * @return void
     */
    protected function s07Entity($std)
    {
        $this->stdCOFINS->vBC = $std->vBC;
        $this->stdCOFINS->pCOFINS = $std->pCOFINS;
        $this->buildSEntity();
    }

    /**
     * Load fields for tag COFINS [S09], belongs to [S]
     * S09|qBCProd|vAliqProd|
     * @param stdClass $std
     * @return void
     */
    protected function s09Entity($std)
    {
        $this->stdCOFINS->qBCProd = $std->qBCProd;
        $this->stdCOFINS->vAliqProd = $std->vAliqProd;
        $this->buildSEntity();
    }

    /**
     * Create tag COFINS [S]
     * Sxx|CST|vBC|pCOFINS|vCOFINS|qBCProd|vAliqProd|
     * @return void
     */
    protected function buildSEntity()
    {
        $this->make->tagCOFINS($this->stdCOFINS);
    }

    /**
     * Load fields for tag COFINSST [T]
     * T|vCOFINS|
     * @param stdClass $std
     * @return void
     */
    protected function tEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdCOFINSST = $std;
        $this->stdCOFINSST->vBC = null;
        $this->stdCOFINSST->pCOFINS = null;
        $this->stdCOFINSST->vCOFINS = null;
        $this->stdCOFINSST->qBCProd = null;
        $this->stdCOFINSST->vAliqProd = null;
    }

    /**
     * Load fields for tag COFINSST [T02], belongs to [T]
     * T02|vBC|pCOFINS|
     * @param stdClass $std
     * @return void
     */
    protected function t02Entity($std)
    {
        $this->stdCOFINSST->vBC = $std->vBC;
        $this->stdCOFINSST->pCOFINS = $std->pCOFINS;
        $this->buildTEntity();
    }

    /**
     * Load fields for tag COFINSST [T04], belongs to [T]
     * T04|qBCProd|vAliqProd|
     * @param stdClass $std
     * @return void
     */
    protected function t04Entity($std)
    {
        $this->stdCOFINSST->qBCProd = $std->qBCProd;
        $this->stdCOFINSST->vAliqProd = $std->vAliqProd;
        $this->buildTEntity();
    }

    /**
     * Create tag COFINSST [T]
     * Txx|vBC|pCOFINS|qBCProd|vAliqProd|vCOFINS|
     * @return void
     */
    protected function buildTEntity()
    {
        $this->stdCOFINSST->item = $this->item;
        $this->make->tagCOFINSST($this->stdCOFINSST);
    }

    /**
     * Create tag ISSQN [U]
     * U|vBC|vAliq|vISSQN|cMunFG|cListServ|vDeducao|vOutro|vDescIncond
     *  |vDescCond|vISSRet|indISS|cServico|cMun|cPais|nProcesso|indIncentivo|
     * @param stdClass $std
     * @return void
     */
    protected function uEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagISSQN($std);
    }

    /**
     * Create tag tagimpostoDevol [UA]
     * UA|pDevol|vIPIDevol|
     * @param stdClass $std
     * @return void
     */
    protected function uaEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagimpostoDevol($std);
    }

    /**
     * Linha W [W]
     * W|
     * @param stdClass $std
     * @return void
     */
    protected function wEntity($std)
    {
        //fake não faz nada
        $field = null;
    }

    /**
     * Cria tag ICMSTot [W02], belongs to [W]
     * W02|vBC|vICMS|vICMSDeson|vFCP|vBCST|vST|vFCPST|vFCPSTRet|vProd|vFrete|vSeg|vDesc|vII|vIPI|vIPIDevol|vPIS|vCOFINS|vOutro|vNF|vTotTrib|vFCPUFDest|vICMSUFDest|vICMSUFRemet|
     * @param stdClass $std
     * @return void
     */
    protected function w02Entity($std)
    {
        $this->make->tagICMSTot($std);
    }

    protected function w04cEntity($std)
    {
    }

    protected function w04eEntity($std)
    {
    }

    protected function w04gEntity($std)
    {
    }

    /**
     * Create tag ISSQNTot [W17], belongs to [W]
     * W17|vServ|vBC|vISS|vPIS|vCOFINS|dCompet|vDeducao|vOutro|vDescIncond
     *    |vDescCond|vISSRet|cRegTrib|
     * @param stdClass $std
     * @return void
     */
    protected function w17Entity($std)
    {
        $this->make->tagISSQNTot($std);
    }

    /**
     * Create tag retTrib [W23], belongs to [W]
     * W23|vRetPIS|vRetCOFINS|vRetCSLL|vBCIRRF|vIRRF|vBCRetPrev|vRetPrev|
     * @param stdClass $std
     * @return void
     */
    protected function w23Entity($std)
    {
        $this->make->tagretTrib($std);
    }

    /**
     * Create tag transp [X]
     * X|modFrete|
     * @param stdClass $std
     * @return void
     */
    protected function xEntity($std)
    {
        $this->make->tagtransp($std);
    }

    /**
     * Load fields for tag transporta [X03], belongs to [X]
     * X03|xNome|IE|xEnder|xMun|UF|
     * @param stdClass $std
     * @return void
     */
    protected function x03Entity($std)
    {
        $this->stdTransporta = $std;
    }

    /**
     * Load fields for tag transporta [X04], with CNPJ, belonsgs to [X03]
     * X04|CNPJ|
     * @param stdClass $std
     * @return void
     */
    protected function x04Entity($std)
    {
        $this->stdTransporta->CNPJ = $std->CNPJ;
        $this->stdTransporta->CPF = null;
        $this->make->tagtransporta($this->stdTransporta);
        $this->stdTransporta = null;
    }

    /**
     * Load fields for tag transporta [X05], with CPF, belonsgs to [X03]
     * X05|CPF|
     * @param stdClass $std
     * @return void
     */
    protected function x05Entity($std)
    {
        $this->stdTransporta->CPF = $std->CPF;
        $this->stdTransporta->CNPJ = null;
        $this->make->tagtransporta($this->stdTransporta);
        $this->stdTransporta = null;
    }

    /**
     * Load fields for tag retTransp [X11], belongs to [X]
     * X11|vServ|vBCRet|pICMSRet|vICMSRet|CFOP|cMunFG|
     * @param stdClass $std
     * @return void
     */
    protected function x11Entity($std)
    {
        $this->make->tagretTransp($std);
    }

    /**
     * Create tag veicTransp [X18], belongs to [X]
     * X18|placa|UF|RNTC|
     * @param stdClass $std
     * @return void
     */
    protected function x18Entity($std)
    {
        $this->make->tagveicTransp($std);
    }

    /**
     * Create tag reboque [X22], belogns to [X]
     * X22|placa|UF|RNTC|
     * @param stdClass $std
     * @return void
     */
    protected function x22Entity($std)
    {
        $this->make->tagreboque($std);
    }

    /**
     * Create tag vagao [X25a], belogns to [X01]
     * X25a|vagao|
     * @param stdClass $std
     * @return void
     */
    protected function x25aEntity($std)
    {
        $this->make->tagvagao($std);
    }

    /**
     * Create tag balsa [X25b], belogns to [X01]
     * X25b|balsa|
     * @param stdClass $std
     * @return void
     */
    protected function x25bEntity($std)
    {
        $this->make->tagbalsa($std);
    }

    /**
     * Create tag vol [X26], belongs to [X]
     * X26|qVol|esp|marca|nVol|pesoL|pesoB|
     * @param stdClass $std
     * @return void
     */
    protected function x26Entity($std)
    {
        $this->volId += 1;
        $std->item = $this->volId;
        $this->make->tagvol($std);
    }

    /**
     * Create tag lacre [X33], belongs to [X]
     * X33|nLacre|
     * @param stdClass $std
     * @return void
     */
    protected function x33Entity($std)
    {
        $std->item = $this->volId;
        $this->make->taglacres($std);
    }

    /**
     * Create tag vol
     * @param stdClass $std
     * @return void
     */
    protected function buildVolEntity($std)
    {
        $this->make->tagvol($std);
    }

    /**
     * yEntity [Y]
     *
     * LOCAL
     * Y|vTroco|
     * @param stdClass $std
     * @return void
     */
    protected function yEntity($std)
    {
        if ($this->baselayout !== 'SEBRAE') {
            $this->make->tagpag($std);
        }
    }

    /**
     * Create tag fat [Y02]
     * Y02|nFat|vOrig|vDesc|vLiq|
     * @param stdClass $std
     * @return void
     */
    protected function y02Entity($std)
    {
        $this->make->tagfat($std);
    }

    /**
     * Create tag dup [Y07]
     * Y07|nDup|dVenc|vDup|
     * @param stdClass $std
     * @return void
     */
    protected function y07Entity($std)
    {
        $this->make->tagdup($std);
    }

    /**
     * Creates tag detPag and card [YA]
     * YA|tPag|vPag|CNPJ|tBand|cAut|tpIntegra|
     * SEBRAE
     * YA|troco|
     * @param stdClass $std
     * @return void
     */
    protected function yaEntity($std)
    {
        if ($this->baselayout === 'SEBRAE') {
            $this->make->tagpag($std);
        } else {
            $this->make->tagdetPag($std);
        }
    }

    /**
     * Creates tag detPag and card [YA]
     * SEBRAE
     * YA01|indPag|tPag|vPag|",
     * @param stdClass $std
     */
    protected function ya01Entity($std)
    {
        $this->make->tagdetPag($std);
    }



    /**
     * Create a tag infAdic [Z]
     * Z|infAdFisco|infCpl|
     * @param stdClass $std
     * @return void
     */
    protected function zEntity($std)
    {
        $this->make->taginfAdic($std);
    }

    /**
     * Create tag obsCont [Z04]
     * Z04|xCampo|xTexto|
     * @param stdClass $std
     * @return void
     */
    protected function z04Entity($std)
    {
        $this->make->tagobsCont($std);
    }

    /**
     * Create tag obsFisco [Z07]
     * Z07|xCampo|xTexto|
     * @param stdClass $std
     * @return void
     */
    protected function z07Entity($std)
    {
        $this->make->tagobsFisco($std);
    }

    /**
     * Create tag procRef [Z10]
     * Z10|nProc|indProc|
     * @param stdClass $std
     * @return void
     */
    protected function z10Entity($std)
    {
        $this->make->tagprocRef($std);
    }

    /**
     * Create tag exporta [ZA]
     * ZA|UFSaidaPais|xLocExporta|xLocDespacho|
     * @param stdClass $std
     * @return void
     */
    protected function zaEntity($std)
    {
        $this->make->tagexporta($std);
    }

    /**
     * Create tag compra [ZB]
     * ZB|xNEmp|xPed|xCont|
     * @param stdClass $std
     * @return void
     */
    protected function zbEntity($std)
    {
        $this->make->tagcompra($std);
    }

    /**
     * Create tag cana [ZC]
     * ZC|safra|ref|qTotMes|qTotAnt|qTotGer|vFor|vTotDed|vLiqFor|
     * @param stdClass $std
     * @return void
     */
    protected function zcEntity($std)
    {
        $this->make->tagcana($std);
    }

    /**
     * Create tag forDia [ZC04]
     * ZC04|dia|qtde|
     * @param stdClass $std
     * @return void
     */
    protected function zc04Entity($std)
    {
        $this->make->tagforDia($std);
    }

    /**
     * Create tag deduc [ZC10]
     * ZC10|xDed|vDed|
     * @param stdClass $std
     * @return void
     */
    protected function zc10Entity($std)
    {
        $this->make->tagdeduc($std);
    }
    
    /**
     * Create tag infRespTec [ZD01]
     * ZD|CNPJ|xContato|email|fone|CSRTidCSRT|
     * @param stdClass $std
     * @return void
     */
    protected function zdEntity($std)
    {
        $this->make->taginfRespTec($std);
    }

    /**
     * Create tag infNFeSupl com o qrCode para impressão da DANFCE [ZX01]
     * ZX01|qrcode|urlChave|
     * @param stdClass $std
     * @return void
     */
    protected function zx01Entity($std)
    {
        $this->make->taginfNFeSupl($std);
    }
}
