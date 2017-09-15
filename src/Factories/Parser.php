<?php

namespace NFePHP\NFe\Factories;

/**
 * Classe de conversão do TXT para XML
 *
 * @category  API
 * @package   NFePHP\NFe
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\NFe\Make;
use stdClass;

class Parser
{
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
     * @var stdClass
     */
    protected $stdNFP;
    /**
     * @var stdClass
     */
    protected $stdEmit;
    /**
     * @var stdClass
     */
    protected $stdDest;
    /**
     * @var stdClass
     */
    protected $stdRetirada;
    /**
     * @var stdClass
     */
    protected $stdEntrega;
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
     * Configure environment to correct NFe layout
     * @param string $version
     */
    public function __construct($version = '3.10')
    {
        $ver = str_replace('.', '', $version);
        $path = realpath(__DIR__."/../../storage/txtstructure$ver.json");
        $this->structure = json_decode(file_get_contents($path), true);
        $this->make = new Make();
    }
    
    /**
     *
     * @param array $nota
     * @return type
     */
    public function toXml($nota)
    {
        $this->array2xml($nota);
        //monta a tag combustíveis se existir
        if (!empty($this->stdComb)) {
            $this->make->tagcomb($this->stdComb);
        }
        if ($this->make->monta()) {
            return $this->make->getXML();
        }
        return [];
    }

    /**
     * Converte uma Nota Fiscal em um array de txt em um xml
     * @return string
     * @throws Exception\RuntimeException
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
                $msg = "O txt tem um metodo não definido!! $lin";
                throw new \RuntimeException($msg);
            }
            $struct = $this->structure[strtoupper($fields[0])];
            $std = $this->fieldsToStd($fields, $struct);
            $this->$metodo($std);
        }
    }

    protected static function fieldsToStd($dfls, $struct)
    {
        $sfls = explode('|', $struct);
        $len = count($sfls)-1;
        $std = new \stdClass();
        for ($i = 1; $i < $len; $i++) {
            $name = $sfls[$i];
            $data = $dfls[$i];
            if (!empty($name)) {
                $std->$name = $data;
            }
        }
        return $std;
    }

    /**
     * Clear the string of unwanted characters
     * Will remove all duplicated spaces and if wanted
     * replace all accented characters by their originals
     * and all the special ones
     * @param string $field string to be cleaned
     */
    protected function clearFieldsString($std)
    {
        $n = [];
        foreach ($fields as $field) {
            if ($this->limparString) {
                $field = Strings::replaceSpecialsChars($field);
            }
            $n[] = $field;
        }
        if (empty($n[count($n)-1])) {
            unset($n[count($n)-1]);
        }
        return $n;
    }
    
    /**
     * Cria a tag infNFe [A]
     * A|versao|Id|pk_nItem|
     * @param stdClass $std
     */
    protected function aEntity($std)
    {
        $this->make->taginfNFe($std);
    }
    
    /**
     * Cria a tag ide [B]
     * B|cUF|cNF|natOp|indPag|mod|serie|nNF|dhEmi|dhSaiEnt|tpNF|idDest|cMunFG
     *  |tpImp|tpEmis|cDV|tp Amb|finNFe|indFinal|indPres|procEmi|verProc|dhCont|xJust|
     * NOTA: Ajustado para NT2016_002_v1.30
     * B|cUF|cNF|natOp|mod|serie|nNF|dhEmi|dhSaiEnt|tpNF|idDest|cMunFG|tpImp
     *  |tpEmis|cDV|tp Amb|finNFe|indFinal|indPres|procEmi|verProc|dhCont|xJust|
     * @param stdClass $std
     */
    protected function bEntity($std)
    {
        $this->make->tagide($std);
    }
    
    /**
     * Cria a tag nfref [BA]
     * BA|
     * @param stdClass $std
     */
    protected function baEntity($std)
    {
        //fake não faz nada
        $fields = [];
    }
    
    /**
     * Cria a tag refNFe [BA02]
     * BA02|refNFe|
     * @param stdClass $std
     */
    protected function ba02Entity($std)
    {
        $this->make->tagrefNFe($std);
    }
    
    /**
     * Cria a tag refNF [BA03]
     * BA03|cUF|AAMM|CNPJ|mod|serie|nNF|
     * @param stdClass $std
     */
    protected function ba03Entity($std)
    {
        $this->make->tagrefNF($std);
    }
    
    /**
     * Carrega a tag refNFP [BA10]
     * BA10|cUF|AAMM|IE|mod|serie|nNF|
     * @param stdClass $std
     */
    protected function ba10Entity($std)
    {
        $this->stdNFP = $std;
        $this->stdNFP->CNPJ = null;
        $this->stdNFP->CPF = null;
    }
    
    /**
     * CNPJ para a tag refNFP [BA13], pertence a BA10
     * BA13|CNPJ|
     * @param stdClass $std
     */
    protected function ba13Entity($std)
    {
        $this->stdNFP->CNPJ = $std->CNPJ;
        $this->buildBA10Entity();
        $this->stdNFP = null;
    }
    
    /**
     * CPF para a tag refNFP [BA14], pertence a BA10
     * BA14|CPF|
     * @param stdClass $std
     */
    protected function ba14Entity($std)
    {
        $this->stdNFP->CPF = $std->CPF;
        $this->buildBA10Entity();
        $this->stdNFP = null;
    }
    
    /**
     * Cria a tag refNFP [BA10]
     */
    protected function buildBA10Entity()
    {
        $this->make->tagrefNFP($this->stdNFP);
    }
    
    /**
     * Cria a tag refCTe [BA19]
     * B19|refCTe|
     * @param stdClass $std
     */
    protected function ba19Entity($std)
    {
        $this->make->tagrefCTe($std);
    }
    
    /**
     * Cria a tag refECF [BA20]
     * BA20|mod|nECF|nCOO|
     * @param stdClass $std
     */
    protected function ba20Entity($std)
    {
        $this->make->tagrefECF($std);
    }
    
    /**
     * Carrega a tag emit [C]
     * C|XNome|XFant|IE|IEST|IM|CNAE|CRT|
     * @param stdClass $std
     */
    protected function cEntity($std)
    {
        $this->stdEmit = $std;
        $this->stdEmit->CNPJ = null;
        $this->stdEmit->CPF = null;
    }
    
    /**
     * CNPJ da tag emit [C02], pertence a C
     * C02|CNPJ|
     * @param stdClass $std
     */
    protected function c02Entity($std)
    {
        $this->stdEmit->CNPJ = $std->CNPJ;
        $this->buildCEntity();
        $this->stdEmit = null;
    }
    
    /**
     * CPF da tag emit [C02a], pertence a C
     * C02a|CPF|
     * @param stdClass $std
     */
    protected function c02aEntity($std)
    {
        $this->stdEmit->CPF = $std->CPF;
        $this->linhaCEntity();
        $this->stdEmit = null;
    }
    
    /**
     * Cria a tag emit [C]
     */
    protected function buildCEntity()
    {
        $this->make->tagemit($this->stdEmit);
    }
    
    /**
     * Cria a tag enderEmit [C05]
     * C05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|
     * @param stdClass $std
     */
    protected function c05Entity($std)
    {
        $this->make->tagenderEmit($std);
    }
    
    /**
     * Carrega a tag dest [E]
     * E|xNome|indIEDest|IE|ISUF|IM|email|
     * @param stdClass $std
     */
    protected function eEntity($std)
    {
        $this->stdDest = $std;
        $this->stdDest->CNPJ = null;
        $this->stdDest->CPF = null;
        $this->stdDest->idEstrangeiro = null;
    }
    
    /**
     * CNPJ para a tag dest [E02], pertene a E
     * E02|CNPJ|
     * @param stdClass $std
     */
    protected function e02Entity($std)
    {
        $this->stdDest->CNPJ = $std->CNPJ;
        $this->buildEEntity();
        $this->stdDest = null;
    }
    
    /**
     * CPF para a tag dest [E03], pertene a E
     * E03|CPF|
     * @param stdClass $std
     */
    protected function e03Entity($std)
    {
        $this->stdDest->CPF = $std->CPF;
        $this->buildEEntity();
        $this->stdDest = null;
    }
    
    /**
     * idEstrangeiro para a tag dest [E03a], pertene a E
     * E03a|idEstrangeiro|
     * @param stdClass $std
     */
    protected function e03aEntity($std)
    {
        $this->stdDest->idEstrangeiro = $std->idEstrangeiro;
        $this->buildEEntity();
        $this->stdDest = null;
    }
    
    /**
     * Cria a tag dest [E]
     */
    protected function buildEEntity()
    {
        $this->make->tagdest($this->stdDest);
    }
    
    /**
     * Cria a tag enderDest [E05]
     * E05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|
     * @param stdClass $std
     */
    protected function e05Entity($std)
    {
        $this->make->tagenderDest($std);
    }
    
    /**
     * Carrega a tag retirada [F]
     * F|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|
     * @param stdClass $std
     */
    protected function fEntity($std)
    {
        $this->stdRetirada = $std;
        $this->stdRetirada->CNPJ = null;
        $this->stdRetirada->CPF = null;
    }
    
    /**
     * CNPJ para a tag retirada [F02], pertence a F
     * F02|CNPJ|
     * @param stdClass $std
     */
    protected function f02Entity($std)
    {
        $this->stdRetirada->CNPJ = $std->CNPJ;
        $this->buildFEntity();
        $this->stdRetirada = null;
    }
    
    /**
     * CPF para a tag retirada [F02a], pertence a F
     * F02a|CPF|
     * @param stdClass $std
     */
    protected function f02aEntity($std)
    {
        $this->stdRetirada->CPF = $std->CPF;
        $this->buildFEntity();
        $this->stdRetirada = null;
    }
    
    /**
     * Cria a tag retirada [F]
     */
    protected function buildFEntity()
    {
        $this->make->tagretirada($this->stdRetirada);
    }
    
    /**
     * Carrega e cria a tag entrega [G]
     * G|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|
     * @param stdClass $std
     */
    protected function gEntity($std)
    {
        $this->stdEntrega = $std;
        $this->stdEntrega->CNPJ = null;
        $this->stdEntrega->CPF = null;
    }
    
    /**
     * CNPJ para a tag entrega [G02], pertence a G
     * G02|CNPJ|
     * @param stdClass $std
     */
    protected function g02Entity($std)
    {
        $this->stdEntrega->CNPJ = $std->CNPJ;
        $this->buildGEntity();
        $this->stdEntrega = null;
    }
    
    /**
     * CPF para a tag entrega [G02a], pertence a G
     * G02a|CPF|
     * @param stdClass $std
     */
    protected function g02aEntity($std)
    {
        $this->stdEntrega->CPF = $std->CPFJ;
        $this->buildGEntity();
        $this->stdEntrega = null;
    }
    
    /**
     * Cria a tag entrega [G]
     */
    protected function buildGEntity()
    {
        $this->make->tagentrega($this->stdEntrega);
    }
    
    /**
     * Cria a tag autXML [GA]
     * GA|
     * @param stdClass $std
     */
    protected function gaEntity($std)
    {
        //fake não faz nada
        $fields = [];
    }
    
    /**
     * Cria a tag autXML com CNPJ [GA02], pertence a GA
     * GA02|CNPJ|
     * @param stdClass $std
     */
    protected function ga02Entity($std)
    {
        $this->make->tagautXML($std);
    }
    
    /**
     * Cria a tag autXML com CPF [GA03], pertence a GA
     * GA03|CPF|
     * @param stdClass $std
     */
    protected function ga03Entity($std)
    {
        $this->make->tagautXML($std);
    }
    
    /**
     * Cria a tag det/infAdProd [H]
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
     * Cria a tag prod [I]
     * I|cProd|cEAN|xProd|NCM|EXTIPI|CFOP|uCom|qCom|vUnCom|vProd|cEANTrib|uTrib|qTrib|vUnTrib|vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * I|cProd|cEAN|xProd|NCM|cBenf|EXTIPI|CFOP|uCom|qCom|vUnCom|vProd|cEANTrib|uTrib|qTrib|vUnTrib|vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|
     * @param stdClass $std
     */
    protected function iEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagprod($std);
    }

    /**
     * Cria a tag NVE [I05A]
     * I05A|NVE|
     * @param stdClass $std
     */
    protected function i05aEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagNVE($std);
    }

    /**
     * Cria a tag CEST [I05C]
     * I05C|CEST|
     * NOTA: Ajustado para NT2016_002_v1.30
     * I05C|CEST|indEscala|CNPJFab|
     * @param stdClass $std
     */
    protected function i05cEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagCEST($std);
    }
 
    /**
     * Cria a tag DI [I18]
     * I18|nDI|dDI|xLocDesemb|UFDesemb|dDesemb|tpViaTransp|vAFRMM|tpIntermedio|CNPJ|UFTerceiro|cExportador|
     * @param stdClass $std
     */
    protected function i18Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagDI($std);
        $this->nDI = $std->nDI;
    }
    
    /**
     * Cria a tag adi [I25], pertence a I18
     * I25|nAdicao|nSeqAdicC|cFabricante|vDescDI|nDraw|
     * @param stdClass $std
     */
    protected function i25Entity($std)
    {
        $std->item = $this->item;
        $std->nDI = $this->nDI;
        $this->make->tagadi($std);
    }
    
    /**
     * Carrega e cria a tag detExport [I50]
     * I50|nDraw|
     * @param stdClass $std
     */
    protected function i50Entity($std)
    {
        $std->item = $this->item;
        $std->nRE = null;
        $std->chNFe = null;
        $std->qExport = null;
        $this->make->tagdetExport($std);
    }
    
    /**
     * Carrega e cria a tag detExport/exportInd [I52]
     * I52|nRE|chNFe|qExport|
     * @param stdClass $std
     */
    protected function i52Entity($std)
    {
        $std->item = $this->item;
        $std->nDraw = null;
        $this->make->tagdetExport($std);
    }
    
    /**
     * Cria a tag RASTRO [I80]
     * NOTA: Ajustado para NT2016_002_v1.30
     * I80|nLote|qLote|dFab|dVal|cAgreg|
     * @param stdClass $std
     */
    protected function i80Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagRastro($std);
    }

    /**
     * Cria a tag veicProd [JA]
     * JA|tpOp|chassi|cCor|xCor|pot|cilin|pesoL|pesoB|nSerie|tpComb|nMotor|CMT|dist|anoMod|anoFab|tpPint|tpVeic|espVeic|VIN|condVeic|cMod|cCorDENATRAN|lota|tpRest|
     * @param stdClass $std
     */
    protected function jaEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagveicProd($std);
    }
    
    /**
     * Cria a tag med [K]
     * K|nLote|qLote|dFab|dVal|vPMC|
     * NOTA: Ajustado para NT2016_002_v1.30
     * K|cProdANVISA|vPMC|
     * @param stdClass $std
     */
    protected function kEntity($std)
    {
        $std->item = $this->item;
        $std->nLote = !empty($std->nLote) ? $std->nLote : null;
        $std->qLote = !empty($std->qLote) ? $std->qLote : null;
        $std->dFab = !empty($std->dFab) ? $std->dFab : null;
        $std->dVal = !empty($std->dVal) ? $std->dVal : null;
        $std->cProdANVISA = !empty($std->cProdANVISA) ? $std->cProdANVISA : null;
        $this->make->tagmed($std);
    }
    
    /**
     * Cria a tag arma [L]
     * L|tpArma|nSerie|nCano|descr|
     * @param stdClass $std
     */
    protected function lEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagarma($std);
    }
   
    /**
     * Carrega e cria a tag comb [LA]
     * LA|cProdANP|pMixGN|CODIF|qTemp|UFCons|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * LA|cProdANP|descANP|pGLP|pGNn|pGNi|vPart|CODIF|qTemp|UFCons|
     * @param stdClass $std
     */
    protected function laEntity($std)
    {
        $this->stdComb = $std;
        //como o campo abaixo é opcional não é possivel saber de antemão
        //se o mesmo existe ou não então
        //invocar na montagem final buildLAEntity()
    }
    
    /**
     * Carrega e cria a tag comb [LA07]
     * LA07|qBCProd|vAliqProd|vCIDE|
     * @param stdClass $std
     */
    protected function la07Entity($std)
    {
        $this->stdComb->qBCProd = $std->qBCProd;
        $this->stdComb->vAliqProd = $std->vAliqProd;
        $this->stdComb->vCIDE = $std->vCIDE;
        //como este campo é opcional, pode ser que não exista então
        //invocar na montagem final buildLAEntity()
    }
    
    /**
     * Carrega e cria a tag encerrante [LA11]
     * LA11|nBico|nBomba|nTanque|vEncIni|vEncFin|
     * @param stdClass $std
     */
    protected function la11Entity($std)
    {
        $std->item = $this->item;
        $this->make->tagencerrante($std);
    }

    /**
     * Cria a tag comb [LA]
     * @param stdClass $std
     */
    protected function buildLAEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagcomb($this->stdComb);
    }
    
    /**
     * Cria a tag RECOPI [LB]
     * LB|nRECOPI|
     * @param stdClass $std
     */
    protected function lbEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagRECOPI($std);
    }
    
    /**
     * Cria a tag imposto [M]
     * M|vTotTrib|
     * @param stdClass $std
     */
    protected function mEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagimposto($std);
    }
    
    /**
     * Carrega a tag ICMS [N]
     * N|
     * @param stdClass $std
     */
    protected function nEntity($std)
    {
        //fake não faz nada
        $fields = [];
    }
  
    /**
     * Carrega e cria a tag ICMS [N02]
     * N02|orig|CST|modBC|vBC|pICMS|vICMS|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N02|orig|CST|modBC|vBC|pICMS|vICMS|pFCP|vFCP|
     * @param stdClass $std
     */
    protected function n02Entity($std)
    {
        $this->buildNEntity($std);
    }
    
    /**
     * Carrega e cria a tag ICMS [N03]
     * N03|orig|CST|modBC|vBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N03|orig|CST|modBC|vBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|
     * @param stdClass $std
     */
    protected function n03Entity($std)
    {
        $this->buildNEntity($std);
    }
    
    /**
     * Carrega e cria a tag ICMS [N04]
     * N04|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|vICMSDeson|motDesICMS|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N04|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|BCFCP|pFCP|vFCP|vICMSDeson|motDesICMS|
     * @param stdClass $std
     */
    protected function n04Entity($std)
    {
        $this->buildNEntity($std);
    }

    /**
     * Carrega e cria a tag ICMS [N05]
     * N05|orig|CST|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N05|orig|CST|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     */
    protected function n05Entity($std)
    {
        $this->buildNEntity($std);
    }
    
    /**
     * Carrega e cria a tag ICMS [N06]
     * N06|orig|CST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     */
    protected function n06Entity($std)
    {
        $this->buildNEntity($std);
    }
    
    /**
     * Carrega e cria a tag ICMS [N07]
     * N07|orig|CST|modBC|pRedBC|vBC|pICMS|vICMSOp|pDif|vICMSDif|vICMS|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N07|orig|CST|modBC|pRedBC|vBC|pICMS|vICMSOp|pDif|vICMSDif|vICMS|vBCFCP|pFCP|vFCP|
     * @param stdClass $std
     */
    protected function n07Entity($std)
    {
        $this->buildNEntity($std);
    }
    
    /**
     * Carrega e cria a tag ICMS [N08]
     * N08|orig|CST|vBCSTRet|vICMSSTRet|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N08|orig|CST|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|
     * @param stdClass $std
     */
    protected function n08Entity($std)
    {
        $this->buildNEntity($std);
    }
    
    /**
     * Carrega e cria a tag ICMS [N09]
     * N09|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N09|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     */
    protected function n09Entity($std)
    {
        $this->buildNEntity($std);
    }
    
    /**
     * Carrega e cria a tag ICMS [N10]
     * N10|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N10|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|
     * @param stdClass $std
     */
    protected function n10Entity($std)
    {
        $this->buildNEntity($std);
    }


    /**
     * Cria a tag ICMS [N]
     * NOTA: Ajustado para NT2016_002_v1.30
     * @param array $fields
     */
    protected function buildNEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMS($std);
    }
    
    /**
     * Cria a tag ICMSPart [N10a]
     * N10a|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pBCOp|UFST|
     * @param stdClass $std
     */
    protected function n10aEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMSPart($std);
    }
    
    /**
     * Cria a tag ICMSST [N10b]
     * N10b|orig|CST|vBCSTRet|vICMSSTRet|vBCSTDest|vICMSSTDest|
     * @param stdClass $std
     */
    protected function n10bEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMSST($std);
    }
    
    /**
     * Carrega e Cria a tag ICMSSN [N10c]
     * N10c|orig|CSOSN|pCredSN|vCredICMSSN|
     * @param stdClass $std
     */
    protected function n10cEntity($std)
    {
        $this->buildNSNEntity($std);
    }
    
    /**
     * Carrega e Cria a tag ICMSSN [N10d]
     * N10d|orig|CSOSN|
     * @param stdClass $std
     */
    protected function n10dEntity($std)
    {
        $this->buildNSNEntity($std);
    }
    

    /**
     * Carrega e Cria a tag ICMSSN [N10e]
     * N10e|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pCredSN|vCredICMSSN|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N10e|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|pCredSN|vCredICMSSN|pCredSN|vCredICMSSN|
     * @param stdClass $std
     */
    protected function n10eEntity($std)
    {
        $this->buildNSNEntity($std);
    }
    /**
     * Carrega e Cria a tag ICMSSN [N10f]
     * N10f|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N10f|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|
     * @param stdClass $std
     */
    protected function n10fEntity($std)
    {
        $this->buildNSNEntity($std);
    }
    
    /**
     * Carrega e Cria a tag ICMSSN [N10g]
     * N10g|orig|CSOSN|vBCSTRet|vICMSSTRet|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N10g|orig|CSOSN|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|
     * @param stdClass $std
     */
    protected function n10gEntity($std)
    {
        $this->buildNSNEntity($std);
    }
    
    /**
     * Carrega e Cria a tag ICMSSN [N10h]
     * N10h|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pCredSN|vCredICMSSN|
     *
     * NOTA: Ajustado para NT2016_002_v1.30
     * N10h|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|pCredSN|vCredICMSSN|
     * @param stdClass $std
     */
    protected function n10hEntity($std)
    {
        $this->buildNSNEntity($std);
    }
   
    /**
     * Nsn|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|pCredSN|vCredICMSSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCSTRet|vICMSSTRet|vBCFCPST|pFCPST|vFCPST|
     * @param type $std
     */
    protected function buildNSNEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagICMSSN($std);
    }
   
    /**
     * Carrega a tag IPI [O]
     * O|clEnq|CNPJProd|cSelo|qSelo|cEnq|
     * @param stdClass $std
     */
    protected function oEntity($std)
    {
        $std->item = $this->item;
        $this->stdIPI = $std;
    }
    
    /**
     * Carrega e cria a tag IPI [O07]
     * O07|CST|vIPI|
     * @param stdClass $std
     */
    protected function o07Entity($std)
    {
        $this->stdIPI->CST = $std->CST;
        $this->stdIPI->vIPI = $std->vIPI;
    }
    
    /**
     * Carrega e cria a tag IPI [O08]
     * O08|CST|
     * @param stdClass $std
     */
    protected function o08Entity($std)
    {
        $this->stdIPI->CST = $std->CST;
        $this->buildOEntity();
    }
    
    /**
     * Carrega e cria a tag IPI [O10]
     * O10|vBC|pIPI|
     * @param stdClass $std
     */
    protected function o10Entity($std)
    {
        $this->stdIPI->vBC = $std->vBC;
        $this->stdIPI->pIPI = $std->pIPI;
        $this->buildOEntity();
    }
    
    /**
     * Carrega e cria a tag IPI [O11]
     * O11|qUnid|vUnid|
     * @param stdClass $std
     */
    protected function o11Entity($std)
    {
        $this->stdIPI->qUnid = $std->qUnid;
        $this->stdIPI->vUnid = $std->vUnid;
        $this->buildOEntity();
    }
    
    /**
     * Cria a tag IPI [O]
     * Oxx|cst|clEnq|cnpjProd|cSelo|qSelo|cEnq|vBC|pIPI|qUnid|vUnid|vIPI|
     */
    protected function buildOEntity()
    {
        $this->make->tagIPI($this->stdIPI);
    }
    
    /**
     * Cria a tag II [P]
     * P|vBC|vDespAdu|vII|vIOF|
     * @param stdClass $std
     */
    protected function pEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagII($std);
    }
    
    /**
     * Carrega a tag PIS [Q]
     * Q|
     * @param stdClass $std
     */
    protected function qEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdPIS = $std;
    }
    
    /**
     * Carrega e cria a tag PIS [Q02]
     * Q02|CST|vBC|pPIS|vPIS|
     * @param stdClass $std
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
     * Carrega e cria a tag PIS [Q03]
     * Q03|CST|qBCProd|vAliqProd|vPIS|
     * @param stdClass $std
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
     * Carrega e cria a tag PIS [Q04]
     * Q04|CST|
     * @param stdClass $std
     */
    protected function q04Entity($std)
    {
        $this->stdPIS->CST = $std->CST;
        $this->buildQEntity();
    }
    
    /**
     * Carrega e cria a tag PIS [Q05]
     * Q05|CST|vPIS|
     * @param stdClass $std
     */
    protected function q05Entity($std)
    {
        $this->stdPIS->CST = $std->CST;
        $this->stdPIS->vPIS = $std->vPIS;
        $this->buildQEntity();
    }
    
    /**
     * Carrega e cria a tag PIS [Q07]
     * Q07|vBC|pPIS|
     * @param stdClass $std
     */
    protected function q07Entity($std)
    {
        $this->stdPIS->vBC = $std->vBC;
        $this->stdPIS->pPIS = $std->pPIS;
        $this->buildQEntity();
    }
    
    /**
     * Carrega e cria a tag PIS [Q10]
     * Q10|qBCProd|vAliqProd|
     * @param stdClass $std
     */
    protected function q10Entity($std)
    {
        $this->stdPIS->qBCProd = $std->qBCProd;
        $this->stdPIS->vAliqProd  = $std->vAliqProd;
        $this->buildQEntity();
    }
    
    /**
     * Cria a tag PIS [Q]
     * Qxx|CST|vBC|pPIS|vPIS|qBCProd|vAliqProd|
     */
    protected function buildQEntity()
    {
        $this->make->tagPIS($this->stdPIS);
    }
    
    /**
     * Carrega tag PISST [R]
     * R|vPIS|
     * @param stdClass $std
     */
    protected function rEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdPISST = $std;
    }
    
    /**
     * Carrega e cria tag PISST [R02]
     * R02|vBC|pPIS|
     * @param stdClass $std
     */
    protected function r02Entity($std)
    {
        $this->stdPISST->vBC = $std->vBC;
        $this->stdPISST->pPIS = $std->pPIS;
        $this->buildREntity();
    }
    
    /**
     * Carrega e cria tag PISST [R04]
     * R04|qBCProd|vAliqProd|vPIS|
     * @param stdClass $std
     */
    protected function r04Entity($std)
    {
        $this->stdPISST->qBCProd = $std->qBCProd;
        $this->stdPISST->vAliqProd = $std->vAliqProd;
        $this->stdPISST->vPIS = $std->vPIS;
        $this->buildREntity();
    }
    
    /**
     * Cria a tag PISST
     * Rxx|vBC|pPIS|qBCProd|vAliqProd|vPIS|
     */
    protected function buildREntity()
    {
        $this->make->tagPISST($this->stdPISST);
    }
    
    /**
     * Carrega COFINS [S]
     * S|
     * @param stdClass $std
     */
    protected function sEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdCOFINS = $std;
    }
    
    /**
     * Carrega COFINS [S02]
     * S02|CST|vBC|pCOFINS|vCOFINS|
     * @param stdClass $std
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
     * Carrega COFINS [S03]
     * S03|CST|qBCProd|vAliqProd|vCOFINS|
     * @param stdClass $std
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
     * Carrega COFINS [S04]
     * S04|CST|
     * @param stdClass $std
     */
    protected function s04Entity($std)
    {
        $this->stdCOFINS->CST = $std->CST;
        $this->buildSEntity();
    }
    
    /**
     * Carrega COFINS [S05]
     * S05|CST|vCOFINS|
     * @param stdClass $std
     */
    protected function s05Entity($std)
    {
        $this->stdCOFINS->CST = $std->CST;
        $this->stdCOFINS->vCOFINS = $std->vCOFINS;
    }
    
    /**
     * Carrega e cria a tag COFINS [S07]
     * S07|vBC|pCOFINS|
     * @param stdClass $std
     */
    protected function s07Entity($std)
    {
        $this->stdCOFINS->vBC = $std->vBC;
        $this->stdCOFINS->pCOFINS = $std->pCOFINS;
        $this->buildSEntity();
    }
    
    /**
     * Carrega e cria a tag COFINS [S09]
     * S09|qBCProd|vAliqProd|
     * @param stdClass $std
     */
    protected function s09Entity($std)
    {
        $this->stdCOFINS->qBCProd = $std->qBCProd;
        $this->stdCOFINS->vAliqProd = $std->vAliqProd;
        $this->buildSEntity();
    }
    
    /**
     * Cria a tag COFINS
     * Sxx|CST|vBC|pCOFINS|vCOFINS|qBCProd|vAliqProd|
     */
    protected function buildSEntity()
    {
        $this->make->tagCOFINS($this->stdCOFINS);
    }
    
    /**
     * COFINSST [T]
     * T|vCOFINS|
     * @param stdClass $std
     */
    protected function tEntity($std)
    {
        //carrega numero do item
        $std->item = $this->item;
        $this->stdCOFINSST = $std;
    }
    
    /**
     * Carrega e cria COFINSST [T02]
     * T02|vBC|pCOFINS|
     * @param stdClass $std
     */
    protected function t02Entity($std)
    {
        $this->stdCOFINSST->vBC = $std->vBC;
        $this->stdCOFINSST->pCOFINS = $std->pCOFINS;
        $this->buildTEntity();
    }
    
    /**
     * Carrega e cria COFINSST [T04]
     * T04|qBCProd|vAliqProd|
     * @param stdClass $std
     */
    protected function t04Entity($std)
    {
        $this->stdCOFINSST->qBCProd = $std->qBCProd;
        $this->stdCOFINSST->vAliqProd = $std->vAliqProd;
        $this->buildTEntity();
    }
    
    /**
     * Cria a tag COFINSST
     * Txx|vBC|pCOFINS|qBCProd|vAliqProd|vCOFINS|
     * @param stdClass $std
     */
    protected function buildTEntity()
    {
        $std->item = $this->item;
        $this->make->tagCOFINSST($this->stdCOFINSST);
    }
    
    /**
     * Cria a tag ISSQN [U]
     * U|vBC|vAliq|vISSQN|cMunFG|cListServ|vDeducao|vOutro|vDescIncond
     *  |vDescCond|vISSRet|indISS|cServico|cMun|cPais|nProcesso|indIncentivo|
     * @param stdClass $std
     */
    protected function uEntity($std)
    {
        $std->item = $this->item;
        $this->make->tagISSQN($std);
    }
    
    /**
     * Cria a tag tagimpostoDevol [UA]
     * UA|pDevol|vIPIDevol|
     * @param stdClass $std
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
     */
    protected function wEntity($std)
    {
        //fake não faz nada
        $fields = [];
    }
    
    /**
     * Cria tag ICMSTot [W02]
     * W02|vBC|vICMS|vICMSDeson|vBCST|vST|vProd|vFrete|vSeg|vDesc|vII|vIPI|vPIS|vCOFINS|vOutro|vNF|vTotTrib|
     * NOTA: Ajustado para NT2016_002_v1.30
     * W02|vBC|vICMS|vICMSDeson|vFCP|vBCST|vST|vFCPST|vFCPSTRet|vProd|vFrete|vSeg|vDesc|vII|vIPI|vIPIDevol|vPIS|vCOFINS|vOutro|vNF|vTotTrib|
     * @param stdClass $std
     */
    protected function w02Entity($std)
    {
        $this->make->tagICMSTot($std);
    }

    
    /**
     * Cria a tag ISSQNTot [W17]
     * W17|vServ|vBC|vISS|vPIS|vCOFINS|dCompet|vDeducao|vOutro|vDescIncond
     *    |vDescCond|vISSRet|cRegTrib|
     * @param stdClass $std
     */
    protected function w17Entity($std)
    {
        $this->make->tagISSQNTot($std);
    }
    
    /**
     * Cria a tag retTrib [W23]
     * W23|vRetPIS|vRetCOFINS|vRetCSLL|vBCIRRF|vIRRF|vBCRetPrev|vRetPrev|
     * @param stdClass $std
     */
    protected function w23Entity($std)
    {
        $this->make->tagretTrib($std);
    }
    
    /**
     * Cria a tag transp [X]
     * X|modFrete|
     * @param stdClass $std
     */
    protected function xEntity($std)
    {
        $this->make->tagtransp($std);
    }
    
    /**
     * Carrega endereço tranpotadora [X03]
     * X03|xNome|IE|xEnder|xMun|UF|
     * @param stdClass $std
     */
    protected function x03Entity($std)
    {
        $this->stdTransporta = $std;
    }
    
    /**
     * Carrega e cria transp com CNPJ [X04]
     * X04|CNPJ|
     * @param stdClass $std
     */
    protected function x04Entity($std)
    {
        $this->stdTransporta->CNPJ = $std->CNPJ;
        $this->stdTransporta->CPF = null;
        $this->make->tagtransporta($this->stdTransporta);
        $this->stdTransporta = null;
    }
    
    /**
     * Carrega e cria transp com CPF [X05]
     * X05|CPF|
     * @param stdClass $std
     */
    protected function x05Entity($std)
    {
        $this->stdTransporta->CPF = $std->CPF;
        $this->stdTransporta->CNPJ = null;
        $this->make->tagtransporta($this->stdTransporta);
        $this->stdTransporta = null;
    }
    
    /**
     * Carrega impostos transportadora [X11]
     * X11|vServ|vBCRet|pICMSRet|vICMSRet|CFOP|cMunFG|
     * @param stdClass $std
     */
    protected function x11Entity($std)
    {
        $this->make->tagretTransp($std);
    }
    
    /**
     * Cria a tag veicTransp [X18]
     * X18|placa|UF|RNTC|
     * @param stdClass $std
     */
    protected function x18Entity($std)
    {
        $this->make->tagveicTransp($std);
    }
    
    /**
     * Cria a tag reboque [X22]
     * X22|placa|UF|RNTC|vagao|balsa|
     * @param stdClass $std
     */
    protected function x22Entity($std)
    {
        $this->make->tagreboque($std);
    }
    
    /**
     * Carrega volumes [X26]
     * X26|qVol|esp|marca|nVol|pesoL|pesoB|
     * @param stdClass $std
     */
    protected function x26Entity($std)
    {
        $this->volId += 1;
        $std->item = $this->volId;
        $this->make->tagvol($std);
    }
    
    /**
     * Carrega o lacre [X33]
     * X33|nLacre|
     * @param stdClass $std
     */
    protected function x33Entity($std)
    {
        $std->item = $this->volId;
        $this->make->taglacres($std);
    }
    
    /**
     * Cria a tag vol
     * @param stdClass $std
     */
    protected function buildVolEntity($std)
    {
        $this->make->tagvol($std);
    }
   
    /**
     * yEntity [Y]
     * Y|
     * NOTA: Ajustado para NT2016_002_v1.30
     * Y|vTroco|
     * @param stdClass $std
     */
    protected function yEntity($std)
    {
        $this->make->tagpag($std);
    }
    

    /**
     * Cria as tags pag e card [YA]
     * YA|tPag|vPag|CNPJ|tBand|cAut|tpIntegra|
     * @param stdClass $std
     */
    protected function yaEntity($std)
    {
        $this->make->tagdetPag($std);
    }
    
    /**
     * Cria a tag fat [Y02]
     * Y02|nFat|vOrig|vDesc|vLiq|
     * @param stdClass $std
     */
    protected function y02Entity($std)
    {
        $this->make->tagfat($std);
    }
    
    /**
     * Cria a tag dup [Y07]
     * Y07|nDup|dVenc|vDup|
     * @param stdClass $std
     */
    protected function y07Entity($std)
    {
        $this->make->tagdup($std);
    }
    
    /**
     * Cria a a tag infAdic [Z]
     * Z|infAdFisco|infCpl|
     * @param stdClass $std
     */
    protected function zEntity($std)
    {
        $this->make->taginfAdic($std);
    }
    
    /**
     * Cria a tag obsCont [Z04]
     * Z04|xCampo|xTexto|
     * @param stdClass $std
     */
    protected function z04Entity($std)
    {
        $this->make->tagobsCont($std);
    }
    
    /**
     * Cria a tag obsFisco [Z07]
     * Z07|xCampo|xTexto|
     * @param stdClass $std
     */
    protected function z07Entity($std)
    {
        $this->make->tagobsFisco($std);
    }
    
    /**
     * Cria a tag procRef [Z10]
     * Z10|nProc|indProc|
     * @param stdClass $std
     */
    protected function z10Entity($std)
    {
        $this->make->tagprocRef($std);
    }
    
    /**
     * Cria a tag exporta [ZA]
     * ZA|UFSaidaPais|xLocExporta|xLocDespacho|
     * @param stdClass $std
     */
    protected function zaEntity($std)
    {
        $this->make->tagexporta($std);
    }
    
    /**
     * Cria a tag compra [ZB]
     * ZB|xNEmp|xPed|xCont|
     * @param stdClass $std
     */
    protected function zbEntity($std)
    {
        $this->make->tagcompra($std);
    }
    
    /**
     * Cria a tag cana [ZC]
     * ZC|safra|ref|qTotMes|qTotAnt|qTotGer|vFor|vTotDed|vLiqFor|
     * @param stdClass $std
     */
    protected function zcEntity($std)
    {
        $this->make->tagcana($std);
    }
    
    /**
     * Cria a tag forDia [ZC04]
     * ZC04|dia|qtde|
     * @param stdClass $std
     */
    protected function zc04Entity($std)
    {
        $this->make->tagforDia($std);
    }
    
    /**
     * Cria a tag deduc [ZC10]
     * ZC10|xDed|vDed|
     * @param stdClass $std
     */
    protected function zc10Entity($std)
    {
        $this->make->tagdeduc($std);
    }
    
    /**
     * Cria a tag infNFeSupl com o qrCode para impressão da DANFCE [ZX01]
     * ZX01|qrcode|
     * NOTA: Ajustado para NT2016_002_v1.20
     * ZX01|qrcode|urlChave|
     * @param stdClass $std
     */
    protected function zx01Entity($std)
    {
        $this->make->taginfNFeSupl($std);
    }
}
