<?php


class oldEntity
{
    /**
     * Make tag <infNFe>
     * @param  array $fields
     * @throws \RuntimeException
     */
    protected static function aEntity($fields)
    {
        //A|versao|Id|pk_nItem|
        if ($fields[1] != self::version) {
            $msg = "A conversão somente para a versão self::version !";
            throw new \RuntimeException($msg);
        }
        $chave = preg_replace('/[^0-9]/', '', $fields[2]);
        self::$make->taginfNFe($chave, self::version);
    }
    /**
     * Make tag <ide>
     * @param array $fields
     */
    protected static function bEntity($fields)
    {
        //B|cUF|cNF|natOp|indPag|mod|serie|nNF|dhEmi
        // |dhSaiEnt|tpNF|idDest|cMunFG|tpImp|tpEmis
        // |cDV|tp Amb|finNFe|indFinal
        // |indPres|procEmi|verProc|dhCont|xJust|
        self::$make->tagide(
            $fields[1], //cUF
            $fields[2], //cNF
            $fields[3], //natOp
            $fields[4], //indPag
            $fields[5], //mod
            $fields[6], //serie
            $fields[7], //nNF
            $fields[8], //dhEmi
            $fields[9], //dhSaiEnt
            $fields[10], //tpNF
            $fields[11], //idDest
            $fields[12], //cMunFG
            $fields[13], //tpImp
            $fields[14], //tpEmis
            $fields[15], //cDV
            $fields[16], //tpAmb
            $fields[17], //finNFe
            $fields[18], //indFinal
            $fields[19], //indPres
            $fields[20], //procEmi
            $fields[21], //verProc
            $fields[22], //dhCont
            $fields[23] //xJust
        );
    }
    /**
     * Get BA marker from txt
     * @param array $fields
     */
    protected static function baEntity($fields)
    {
        //BA|
        //fake não faz nada
        $fields = [];
    }
    /**
     * Make tag <refNFe>
     * @param array $fields
     */
    protected static function ba02Entity($fields)
    {
        //BA02|refNFe|
        self::$make->tagrefNFe($fields[1]);
    }
    /**
     * Make tag <refNF>
     * @param array $fields
     */
    protected static function ba03Entity($fields)
    {
        //BA03|cUF|AAMM|CNPJ|mod|serie|nNF|
        self::$make->tagrefNF(
            $fields[1], //cUF
            $fields[2], //aamm
            $fields[3], //cnpj
            $fields[4], //mod
            $fields[5], //serie
            $fields[6] //nNF
        );
    }
    /**
     * Make tag <refNFP>
     * @param array $fields
     */
    protected static function ba10Entity($fields)
    {
        //BA10|cUF|AAMM|IE|mod|serie|nNF|
        self::$linhaBA10[0] = $fields[0];
        self::$linhaBA10[1] = $fields[1];
        self::$linhaBA10[2] = $fields[2];
        self::$linhaBA10[3] = $fields[3];
        self::$linhaBA10[4] = $fields[4];
        self::$linhaBA10[5] = $fields[5];
        self::$linhaBA10[6] = $fields[6];
        self::$linhaBA10[7] = '';
        self::$linhaBA10[8] = '';
    }
    
    /**
     * ba13Entity
     * @param array $fields
     */
    protected static function ba13Entity($fields)
    {
        //BA13|CNPJ|
        self::linhaBA10[7] = $fields[1];
        self::linhaBA10Entity(self::linhaBA10);
    }
    /**
     * ba14Entity
     * @param array $fields
     */
    protected static function ba14Entity($fields)
    {
        //BA14|CPF|
        self::linhaBA10[8] = $fields[1];
        self::linhaBA10Entity(self::linhaBA10);
    }
    /**
     * Make tag <refNFP>
     * @param array $fields
     */
    protected static function linhaBA10Entity($fields)
    {
        //BA10xx|cUF|AAMM|IE|mod|serie|nNF|CNPJ|CPF
        self::$make->tagrefNFP(
            $fields[1], //cUF
            $fields[2], //aamm
            $fields[7], //cnpj
            $fields[8], //cpf
            $fields[3], //IE
            $fields[4], //mod
            $fields[5], //serie
            $fields[6] //nNF
        );
    }
    /**
     * Make tag <refCTe>
     * @param array $fields
     */
    protected static function ba19Entity($fields)
    {
        //B19|refCTe|
        self::$make->tagrefCTe($fields[1]);
    }
    /**
     * Make tag <refECF>
     * @param array $fields
     */
    protected static function ba20Entity($fields)
    {
        //BA20|mod|nECF|nCOO|
        self::$make->tagrefECF(
            $fields[1], //mod
            $fields[2], //nECF
            $fields[3] //nCOO
        );
    }
    /**
     * Load cEntity
     * @param array $fields
     */
    protected static function cEntity($fields)
    {
        //C|XNome|XFant|IE|IEST|IM|CNAE|CRT|
        self::linhaC[0] = $fields[0];
        self::linhaC[1] = $fields[1];
        self::linhaC[2] = $fields[2];
        self::linhaC[3] = $fields[3];
        self::linhaC[4] = $fields[4];
        self::linhaC[5] = $fields[5];
        self::linhaC[6] = $fields[6];
        self::linhaC[7] = $fields[7];
        self::linhaC[8] = ''; //CNPJ
        self::linhaC[9] = ''; //CPF
    }
    /**
     * c02Entity
     * @param array $fields
     */
    protected static function c02Entity($fields)
    {
        //C02|cnpj|
        self::linhaC[8] = $fields[1]; //CNPJ
        self::linhaCEntity(self::linhaC);
    }
    /**
     * c02aEntity
     * @param array $fields
     */
    protected static function c02aEntity($fields)
    {
        //C02a|cpf|
        self::linhaC[9] = $fields[1];//CPF
        self::linhaCEntity(self::linhaC);
    }
    /**
     * Make tag <emit>
     * @param array $fields
     */
    protected static function linhaCEntity($fields)
    {
        //Cxx|XNome|XFant|IE|IEST|IM|CNAE|CRT|CNPJ|CPF|
        self::$make->tagemit(
            $fields[8], //cnpj
            $fields[9], //cpf
            $fields[1], //xNome
            $fields[2], //xFant
            $fields[3], //numIE
            $fields[4], //numIEST
            $fields[5], //numIM
            $fields[6], //cnae
            $fields[7] //crt
        );
    }
    /**
     * Make tag <enderEmit>
     * @param array $fields
     */
    protected static function c05Entity($fields)
    {
        //C05|XLgr|Nro|Cpl|Bairro|CMun|XMun|UF|CEP|cPais|xPais|fone|
        self::$make->tagenderEmit(
            $fields[1], //xLgr
            $fields[2], //nro
            $fields[3], //xCpl
            $fields[4], //xBairro
            $fields[5], //cMun
            $fields[6], //xMun
            $fields[7], //siglaUF
            $fields[8], //cep
            $fields[9], //cPais
            $fields[10], //xPais
            $fields[11] //fone
        );
    }
    /**
     * Load eEntity
     * @param array $fields
     */
    protected static function eEntity($fields)
    {
        //E|xNome|indIEDest|IE|ISUF|IM|email|
        self::linhaE[0] = $fields[0];
        self::linhaE[1] = $fields[1];
        self::linhaE[2] = $fields[2];
        self::linhaE[3] = $fields[3];
        self::linhaE[4] = $fields[4];
        self::linhaE[5] = $fields[5];
        self::linhaE[6] = $fields[6];
        self::linhaE[7] = '';
        self::linhaE[8] = '';
        self::linhaE[9] = '';
    }
    /**
     * e02Entity
     * @param array $fields
     */
    protected static function e02Entity($fields)
    {
        //E02|CNPJ| [dest]
        self::linhaE[7] = $fields[1];
        self::linhaEEntity(self::linhaE);
    }
    /**
     * e03Entity
     * @param array $fields
     */
    protected static function e03Entity($fields)
    {
        //E03|CPF| [dest]
        self::linhaE[8] = $fields[1];
        self::linhaEEntity(self::linhaE);
    }
    /**
     * e03aEntity
     * @param array $fields
     */
    protected static function e03aEntity($fields)
    {
        //E03a|idEstrangeiro| [dest]
        self::linhaE[9] = $fields[1];
        self::linhaEEntity(self::linhaE);
    }
    /**
     * Make tag <dest>
     * @param array $fields
     */
    protected static function linhaEEntity($fields)
    {
        //Exx|xNome|indIEDest|IE|ISUF|IM|email|CNPJ/CPF/idExtrangeiro
        self::$make->tagdest(
            $fields[7], //cnpj
            $fields[8], //cpf
            $fields[9], //idEstrangeiro
            $fields[1], //xNome
            $fields[2], //indIEDest
            $fields[3], //IE
            $fields[4], //ISUF
            $fields[5], //IM
            $fields[6] //email
        );
    }
    /**
     * Make tag <enderDest>
     * @param array $fields
     */
    protected static function e05Entity($fields)
    {
        //E05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|
        self::$make->tagenderDest(
            $fields[1], //xLgr
            $fields[2], //nro
            $fields[3], //xCpl
            $fields[4], //xBairro
            $fields[5], //cMun
            $fields[6], //xMun
            $fields[7], //siglaUF
            $fields[8], //cep
            $fields[9], //cPais
            $fields[10], //xPais
            $fields[11] //fone
        );
    }
    /**
     * Load fEntity (Local de retirada)
     * @param array $fields
     */
    protected static function fEntity($fields)
    {
        //F|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|
        self::linhaF[0] = $fields[0];
        self::linhaF[1] = $fields[1];
        self::linhaF[2] = $fields[2];
        self::linhaF[3] = $fields[3];
        self::linhaF[4] = $fields[4];
        self::linhaF[5] = $fields[5];
        self::linhaF[6] = $fields[6];
        self::linhaF[7] = $fields[7];
        self::linhaF[8] = '';
        self::linhaF[9] = '';
    }
    /**
     * f02Entity
     * @param array $fields
     */
    protected static function f02Entity($fields)
    {
        //F02|CNPJ| [retirada]
        self::linhaF[8] = $fields[1];
        self::linhaFEntity(self::linhaF);
    }
    /**
     * f02aEntity
     * @param array $fields
     */
    protected static function f02aEntity($fields)
    {
        //F02a|CPF
        self::linhaF[9] = $fields[1];
        self::linhaFEntity(self::linhaF);
    }
    /**
     * Make tag <retirada>
     * @param array $fields
     */
    protected static function linhaFEntity($fields)
    {
        //Fxx|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CNPJ|CPF
        self::$make->tagretirada(
            $fields[8], //cnpj
            $fields[9], //cpf
            $fields[1], //xLgr
            $fields[2], //nro
            $fields[3], //xCpl
            $fields[4], //xBairro
            $fields[5], //cMun
            $fields[6], //xMun
            $fields[7] //siglaUF
        );
    }
    /**
     * Load gEntity (Local de entrega)
     * @param array $fields
     */
    protected static function gEntity($fields)
    {
        //G|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|
        self::linhaG[0] = $fields[0];
        self::linhaG[1] = $fields[1];
        self::linhaG[2] = $fields[2];
        self::linhaG[3] = $fields[3];
        self::linhaG[4] = $fields[4];
        self::linhaG[5] = $fields[5];
        self::linhaG[6] = $fields[6];
        self::linhaG[7] = $fields[7];
        self::linhaG[8] = '';
        self::linhaG[9] = '';
    }
    /**
     * g02Entity
     * @param array $fields
     */
    protected static function g02Entity($fields)
    {
        //G02|CNPJ
        self::linhaG[8] = $fields[1];
        self::linhaGEntity(self::linhaG);
    }
    /**
     * g02aEntity
     * @param array $fields
     */
    protected static function g02aEntity($fields)
    {
        //G02a|CPF
        self::linhaG[9] = $fields[1];
        self::linhaGEntity(self::linhaG);
    }
    /**
     * Make tag <entrega>
     * @param array $fields
     */
    protected static function linhaGEntity($fields)
    {
        //Gxx|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CNPJ|CPF
        self::$make->tagentrega(
            $fields[8], //cnpj
            $fields[9], //cpf
            $fields[1], //xLgr
            $fields[2], //nro
            $fields[3], //xCpl
            $fields[4], //xBairro
            $fields[5], //cMun
            $fields[6], //xMun
            $fields[7] //siglaUF
        );
    }
    /**
     * Get txt marker GA02
     * @param array $fields
     */
    protected static function gaEntity($fields)
    {
        //GA02
        //fake não faz nada
        $fields = [];
    }
    /**
     * Make tag <autXML>  with CNPJ
     * @param array $fields
     */
    protected static function ga02Entity($fields)
    {
        //GA02|CNPJ|
        self::$make->tagautXML($fields[1], '');
    }
    /**
     * Make tag <autXML> with CPF
     * @param array $fields
     */
    protected static function ga03Entity($fields)
    {
        //GA03|CPF|
        self::$make->tagautXML('', $fields[1]);
    }
    /**
     * Make tag <infAdProd>
     * @param array $fields
     */
    protected static function hEntity($fields)
    {
        //H|item|infAdProd
        if (! empty($fields[2])) {
            self::$make->taginfAdProd($fields[1], $fields[2]);
        }
        self::$nItem = (integer) $fields[1];
    }
    /**
     * Make tag <prod>
     * @param array $fields
     */
    protected static function iEntity($fields)
    {
        //I|cProd|cEAN|xProd|NCM|EXTIPI|CFOP|uCom|qCom|vUnCom
        // |vProd|cEANTrib|uTrib|qTrib|vUnTrib
        // |vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|
        self::$make->tagprod(
            self::nItem, //nItem
            $fields[1], //cProd
            $fields[2], //cEAN
            $fields[3], //xProd
            $fields[4], //NCM
            $fields[5], //EXTIPI
            $fields[6], //CFOP
            $fields[7], //uCom
            $fields[8], //qCom
            $fields[9], //vUnCom
            $fields[10], //vProd
            $fields[11], //cEANTrib
            $fields[12], //uTrib
            $fields[13], //qTrib
            $fields[14], //vUnTrib
            $fields[15], //vFrete
            $fields[16], //vSeg
            $fields[17], //vDesc
            $fields[18], //vOutro
            $fields[19], //indTot
            $fields[20], //xPed
            $fields[21], //nItemPed
            $fields[22] //nFCI
        );
    }
    /**
     * Make tag <NVE>
     * @param array $fields
     */
    protected static function i05aEntity($fields)
    {
        //I05A|NVE
        self::$make->tagNVE(self::nItem, $fields[1]);
    }
    /**
     * Make tag <CEST>
     * @param array $fields
     */
    protected static function i05cEntity($fields)
    {
        //I05C|CEST
        self::$make->tagCEST(self::nItem, $fields[1]);
    }
    /**
     * Make tag <DI>
     * @param array $fields
     */
    protected static function i18Entity($fields)
    {
        //I18|nDI|dDI|xLocDesemb|UFDesemb|dDesemb|tpViaTransp
        //   |vAFRMM|tpIntermedio|CNPJ|UFTerceiro|cExportador|
        self::$make->tagDI(
            self::nItem,
            $fields[1], //nDI
            $fields[2], //dDI
            $fields[3], //xLocDesemb
            $fields[4], //UFDesemb
            $fields[5], //dDesemb
            $fields[6], //tpViaTransp
            $fields[7], //vAFRMM
            $fields[8], //tpIntermedio
            $fields[9], //CNPJ
            $fields[10], //UFTerceiro
            $fields[11] //cExportador
        );
        self::nDI = $fields[1];
    }
    /**
     * Make tag <adi>
     * @param array $fields
     */
    protected static function i25Entity($fields)
    {
        //I25|nAdicao|nSeqAdicC|cFabricante|vDescDI|nDraw|
        self::$make->tagadi(
            self::nItem,
            self::nDI,
            $fields[1], //nAdicao
            $fields[2], //nSeqAdicC
            $fields[3], //cFabricante
            $fields[4], //vDescDI
            $fields[5] //nDraw
        );
    }
    /**
     * LOad I50
     * @param array $fields
     */
    protected static function i50Entity($fields)
    {
        //I50|nDraw|
        self::linhaI50[0] = $fields[1];
        self::linhaI50[1] = '';
        self::linhaI50[2] = '';
        self::linhaI50[3] = '';
        self::linhaI50Entity(self::linhaI50);
    }
    /**
     * Load I52
     * @param array $fields
     */
    protected static function i52Entity($fields)
    {
        //I52|nRE|chNFe|qExport|
        self::linhaI50[1] = $fields[1];
        self::linhaI50[2] = $fields[2];
        self::linhaI50[3] = $fields[3];
        self::linhaI50Entity(self::linhaI50);
    }
    /**
     * Make tag <detExport>
     * @param array $fields
     */
    protected static function linhaI50Entity($fields)
    {
        //I50xx|nDraw|nRE|chNFe|qExport|
        self::$make->tagdetExport(
            self::nItem,
            $fields[1], //nDraw
            $fields[2], //nRE
            $fields[3], //chNFe
            $fields[4] //qExport
        );
    }
    /**
     * Make tag <veicProd>
     * @param array $fields
     */
    protected static function jaEntity($fields)
    {
        //JA|tpOp|chassi|cCor|xCor|pot|cilin|pesoL|pesoB|nSerie
        //  |tpComb|nMotor|CMT|dist|anoMod|anoFab|tpPint|tpVeic
        //  |espVeic|VIN|condVeic|cMod|cCorDENATRAN|lota|tpRest|
        self::$make->tagveicProd(
            self::nItem,
            $fields[1], //tpOp
            $fields[2], //chassi
            $fields[3], //cCor
            $fields[4], //xCor
            $fields[5], //pot
            $fields[6], //cilin
            $fields[7], //pesoL
            $fields[8], //pesoB
            $fields[9], //nSerie
            $fields[10], //tpComb
            $fields[11], //nMotor
            $fields[12], //cmt
            $fields[13], //dist
            $fields[14], //anoMod
            $fields[15], //anoFab
            $fields[16], //tpPint
            $fields[17], //tpVeic
            $fields[18], //espVeic
            $fields[19], //vIn
            $fields[20], //condVeic
            $fields[21], //cMod
            $fields[22], //cCorDENATRAN
            $fields[23], //lota
            $fields[24] //tpRest
        );
    }
    /**
     * Make tag <med>
     * @param array $fields
     */
    protected static function kEntity($fields)
    {
        //K|nLote|qLote|dFab|dVal|vPMC|
        self::$make->tagmed(
            self::nItem,
            $fields[1], //nLote
            $fields[2], //qLote
            $fields[3], //dFab
            $fields[4], //dVal
            $fields[5] //vPMC
        );
    }
    /**
     * Make tag <arma>
     * @param array $fields
     */
    protected static function lEntity($fields)
    {
        //L|tpArma|nSerie|nCano|descr|
        self::$make->tagarma(
            self::nItem,
            $fields[1], //tpArma
            $fields[2], //nSerie
            $fields[3], //nCano
            $fields[4] //descr
        );
    }
    /**
     * Load LA
     * @param arry $fields
     */
    protected static function laEntity($fields)
    {
        //LA|cProdANP|pMixGN|CODIF|qTemp|UFCons|
        self::linhaLA = $fields;
        self::linhaLA[6] = '';
        self::linhaLA[7] = '';
        self::linhaLA[8] = '';
        self::linhaLAEntity(self::linhaLA);
    }
    /**
     * Load LA07
     * @param array $fields
     */
    protected static function la07Entity($fields)
    {
        //LA07|qBCProd|vAliqProd|vCIDE|
        self::linhaLA[6] = $fields[1];
        self::linhaLA[7] = $fields[2];
        self::linhaLA[8] = $fields[3];
        self::linhaLAEntity(self::linhaLA);
    }
    /**
     * Make tag <comb>
     * @param type $fields
     */
    protected static function linhaLAEntity($fields)
    {
        //LAxx|cProdANP|pMixGN|CODIF|qTemp|UFCons|qBCProd|vAliqProd|vCIDE|
        self::$make->tagcomb(
            self::nItem,
            $fields[1], //cProdANP
            $fields[2], //pMixGN
            $fields[3], //codif
            $fields[4], //qTemp
            $fields[5], //ufCons
            $fields[6], //qBCProd
            $fields[7], //vAliqProd
            $fields[8] //vCIDE
        );
    }
    /**
     * Make tag <RECOPI>
     * @param array $fields
     */
    protected static function lbEntity($fields)
    {
        //LB|nRECOPI|
        self::$make->tagRECOPI(self::nItem, $fields[1]);
    }
    /**
     * Make tag <imposto>
     * @param array $fields
     */
    protected static function mEntity($fields)
    {
        //M|vTotTrib|
        self::$make->tagimposto(self::nItem, $fields[1]);
    }
    /**
     * Get N marker trom txt
     * @param array $fields
     */
    protected static function nEntity($fields)
    {
        //N|
        //fake não faz nada
        $fields = [];
    }
    /**
     * Load N02
     * @param array $fields
     */
    protected static function n02Entity($fields)
    {
        //N02|orig|CST|modBC|vBC|pICMS|vICMS|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
            $fields[3], //modBC
            '', //pRedBC
            $fields[4], //vBC
            $fields[5], //pICMS
            $fields[6], //vICMS
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
        self::linhaNEntity($aFields);
    }
    /**
     * Load N03
     * @param array $fields
     */
    protected static function n03Entity($fields)
    {
        //N03|orig|CST|modBC|vBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
            $fields[3], //modBC
            '', //pRedBC
            $fields[4], //vBC
            $fields[5], //pICMS
            $fields[6], //vICMS
            '', //vICMSDeson
            '', //motDesICMS
            $fields[7], //modBCST
            $fields[8], //pMVAST
            $fields[9], //pRedBCST
            $fields[10], //vBCST
            $fields[11], //pICMSST
            $fields[12], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNEntity($aFields);
    }
    /**
     * Load N04
     * @param array $fields
     */
    protected static function n04Entity($fields)
    {
        //N04|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|vICMSDeson|motDesICMS|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
            $fields[3], //modBC
            $fields[4], //pRedBC
            $fields[5], //vBC
            $fields[6], //pICMS
            $fields[7], //vICMS
            $fields[8], //vICMSDeson
            $fields[9], //motDesICMS
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
        self::linhaNEntity($aFields);
    }
    /**
     * Load N05
     * @param array $fields
     */
    protected static function n05Entity($fields)
    {
        //N05|orig|CST|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
            '', //modBC
            '', //pRedBC
            '', //vBC
            '', //pICMS
            '', //vICMS
            $fields[9], //vICMSDeson
            $fields[10], //motDesICMS
            $fields[3], //modBCST
            $fields[4], //pMVAST
            $fields[5], //pRedBCST
            $fields[6], //vBCST
            $fields[7], //pICMSST
            $fields[8], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNEntity($aFields);
    }
    /**
     * Load N06
     * @param array $fields
     */
    protected static function n06Entity($fields)
    {
        //N06|orig|CST|vICMSDeson|motDesICMS|
        $aFields = array(
            self::$nItem,
            $fields[1], //orig
            $fields[2], //cst
            '', //modBC
            '', //pRedBC
            '', //vBC
            '', //pICMS
            '', //vICMS
            $fields[3], //vICMSDeson
            $fields[4], //motDesICMS
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
        self::linhaNEntity($aFields);
    }
    
    /**
     * Load N07
     * @param array $fields
     */
    protected static function n07Entity($fields)
    {
        //N07|orig|CST|modBC|pRedBC|vBC|pICMS|vICMSOp|pDif|vICMSDif|vICMS|
        $aFields = array(
            self::$nItem,
            $fields[1], //orig
            $fields[2], //cst
            $fields[3], //modBC
            $fields[4], //pRedBC
            $fields[5], //vBC
            $fields[6], //pICMS
            $fields[10], //vICMS
            '', //vICMSDeson
            '', //motDesICMS
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            $fields[8], //pDif
            $fields[9], //vICMSDif
            $fields[7], //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNEntity($aFields);
    }
    /**
     * Load N08
     * @param array $fields
     */
    protected static function n08Entity($fields)
    {
        //N08|orig|CST|vBCSTRet|vICMSSTRet|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
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
            $fields[3], //vBCSTRet
            $fields[4] //vICMSSTRet
        );
        self::linhaNEntity($aFields);
    }
    /**
     * Load N09
     * @param array $fields
     */
    protected static function n09Entity($fields)
    {
        //N09|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
            $fields[3], //modBC
            $fields[4], //pRedBC
            $fields[5], //vBC
            $fields[6], //pICMS
            $fields[7], //vICMS
            $fields[14], //vICMSDeson
            $fields[15], //motDesICMS
            $fields[8], //modBCST
            $fields[9], //pMVAST
            $fields[10], //pRedBCST
            $fields[11], //vBCST
            $fields[12], //pICMSST
            $fields[13], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNEntity($aFields);
    }
    /**
     * Load N10
     * @param array $fields
     */
    protected static function n10Entity($fields)
    {
        //N10|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vICMSDeson|motDesICMS|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
            $fields[3], //modBC
            $fields[5], //pRedBC
            $fields[4], //vBC
            $fields[6], //pICMS
            $fields[7], //vICMS
            $fields[14], //vICMSDeson
            $fields[15], //motDesICMS
            $fields[8], //modBCST
            $fields[9], //pMVAST
            $fields[10], //pRedBCST
            $fields[11], //vBCST
            $fields[12], //pICMSST
            $fields[13], //vICMSST
            '', //pDif
            '', //vICMSDif
            '', //vICMSOp
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNEntity($aFields);
    }
    /**
     * Make tag <ICMSPart>
     * @param array $fields
     */
    protected static function n10aEntity($fields)
    {
        //N10a|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pBCOp|UFST|
        self::$make->tagICMSPart(
            self::nItem,
            $fields[1], //orig = '',
            $fields[2], //cst = '',
            $fields[3], //modBC = '',
            $fields[4], //vBC = '',
            $fields[5], //pRedBC = '',
            $fields[6], //pICMS = '',
            $fields[7], //vICMS = '',
            $fields[8], //modBCST = '',
            $fields[9], //pMVAST = '',
            $fields[10], //pRedBCST = '',
            $fields[11], //vBCST = '',
            $fields[12], //pICMSST = '',
            $fields[13], //vICMSST = '',
            $fields[14], //pBCOp = '',
            $fields[15] //ufST = ''
        );
    }
    /**
     * Make tag <ICMSST>
     * @param array $fields
     */
    protected static function n10bEntity($fields)
    {
        //N10b|orig|CST|vBCSTRet|vICMSSTRet|vBCSTDest|vICMSSTDest|
        self::$make->tagICMSST(
            self::nItem,
            $fields[1], //orig = '',
            $fields[2], //cst = '',
            $fields[3], //vBCSTRet = '',
            $fields[4], //vICMSSTRet = '',
            $fields[5], //vBCSTDest = '',
            $fields[6] //vICMSSTDest = ''
        );
    }
    /**
     * Load N10c
     * @param type $fields
     */
    protected static function n10cEntity($fields)
    {
        //N10c|orig|CSOSN|pCredSN|vCredICMSSN|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            $fields[3], //pCredSN
            $fields[4], //vCredICMSSN
            '', //modBCST
            '', //pMVAST
            '', //pRedBCST
            '', //vBCST
            '', //pICMSST
            '', //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNSNEntity($aFields);
    }
    /**
     * Load N10d
     * @param array $fields
     */
    protected static function n10dEntity($fields)
    {
        //N10d|orig|CSOSN|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //csosn
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
        self::linhaNSNEntity($aFields);
    }
    /**
     * Load N10e
     * @param array $fields
     */
    protected static function n10eEntity($fields)
    {
        //N10e|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pCredSN|vCredICMSSN|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            $fields[9], //pCredSN
            $fields[10], //vCredICMSSN
            $fields[3], //modBCST
            $fields[4], //pMVAST
            $fields[5], //pRedBCST
            $fields[6], //vBCST
            $fields[7], //pICMSST
            $fields[8], //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNSNEntity($aFields);
    }
    /**
     * Load N10f
     * @param array $fields
     */
    protected static function n10fEntity($fields)
    {
        //N10f|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //csosn
            '', //modBC
            '', //vBC
            '', //pRedBC
            '', //pICMS
            '', //vICMS
            '', //pCredSN
            '', //vCredICMSSN
            $fields[3], //modBCST
            $fields[4], //pMVAST
            $fields[5], //pRedBCST
            $fields[6], //vBCST
            $fields[7], //pICMSST
            $fields[8], //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNSNEntity($aFields);
    }
    /**
     * Load N10g
     * @param array $fields
     */
    protected static function n10gEntity($fields)
    {
        //N10g|orig|CSOSN|vBCSTRet|vICMSSTRet|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //csosn
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
            $fields[3], //vBCSTRet
            $fields[4] //vICMSSTRet
        );
        self::linhaNSNEntity($aFields);
    }
    /**
     * Load N10h
     * @param array $fields
     */
    protected static function n10hEntity($fields)
    {
        //N10h|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST
        //    |vBCST|pICMSST|vICMSST|pCredSN|vCredICMSSN|
        $aFields = array(
            self::nItem,
            $fields[1], //orig
            $fields[2], //csosn
            $fields[3], //modBC
            $fields[4], //vBC
            $fields[5], //pRedBC
            $fields[6], //pICMS
            $fields[7], //vICMS
            $fields[14], //pCredSN
            $fields[15], //vCredICMSSN
            $fields[8], //modBCST
            $fields[9], //pMVAST
            $fields[10], //pRedBCST
            $fields[11], //vBCST
            $fields[12], //pICMSST
            $fields[13], //vICMSST
            '', //vBCSTRet
            '' //vICMSSTRet
        );
        self::linhaNSNEntity($aFields);
    }
    /**
     * Make tag <ICMSUFDest>
     * @param array $fields
     */
    protected static function naEntity($fields)
    {
        //NA|vBCUFDest|pFCPUFDest|pICMSUFDest|pICMSInter|pICMSInterPart|vFCPUFDest|vICMSUFDest|vICMSFRemet|
        if ($fields[1] != '') {
            self::$make->tagICMSUFDest(
                self::nItem,
                $fields[1], //$vBCUFDest,
                $fields[2], //$pFCPUFDest,
                $fields[3], //$pICMSUFDest,
                $fields[4], //$pICMSInter,
                $fields[5], //$pICMSInterPart,
                $fields[6], //$vFCPUFDest,
                $fields[7], //$vICMSUFDest,
                $fields[8] //$vICMSUFRemet
            );
        }
    }
    /**
     * Make tag <ICMS>
     * @param array $fields
     */
    protected static function linhaNEntity($fields)
    {
        //Nxx|orig|cst|modBC|pRedBC|vBC|pICMS|vICMS|vICMSDeson|motDesICMS|modBCST
        //   |pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pDif|vICMSDif|vICMSOp
        //   |BCSTRet|vICMSSTRet|
        self::$make->tagICMS(
            self::nItem,
            $fields[1], //orig
            $fields[2], //cst
            $fields[3], //modBC
            $fields[4], //pRedBC
            $fields[5], //vBC
            $fields[6], //pICMS
            $fields[7], //vICMS
            $fields[8], //vICMSDeson
            $fields[9], //motDesICMS
            $fields[10], //modBCST
            $fields[11], //pMVAST
            $fields[12], //pRedBCST
            $fields[13], //vBCST
            $fields[14], //pICMSST
            $fields[15], //vICMSST
            $fields[16], //pDif
            $fields[17], //vICMSDif
            $fields[18], //vICMSOp
            $fields[19], //vBCSTRet
            $fields[20] //vICMSSTRet
        );
    }
    /**
     * Load tag <ICMSSN>
     * @param array $fields
     */
    protected static function linhaNSNEntity($fields)
    {
        //Nsn|orig|csosn|modBC|vBC|pRedBC|pICMS|vICMS|pCredSN
        //   |vCredICMSSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST
        //   |vICMSST|vBCSTRet|vICMSSTRet|
        self::$make->tagICMSSN(
            self::nItem,
            $fields[1], //orig
            $fields[2], //csosn
            $fields[3], //modBC
            $fields[4], //vBC
            $fields[5], //pRedBC
            $fields[6], //pICMS
            $fields[7], //vICMS
            $fields[8], //pCredSN
            $fields[9], //vCredICMSSN
            $fields[10], //modBCST
            $fields[11], //pMVAST
            $fields[12], //pRedBCST
            $fields[13], //vBCST
            $fields[14], //pICMSST
            $fields[15], //vICMSST
            $fields[16], //vBCSTRet
            $fields[17] //vICMSSTRet
        );
    }
    /**
     * Load O
     * @param array $fields
     */
    protected static function oEntity($fields)
    {
        //O|clEnq|CNPJProd|cSelo|qSelo|cEnq|
        self::linhaO[0] = self::nItem;
        self::linhaO[1] = ''; //cst
        self::linhaO[2] = $fields[1]; //clEnq
        self::linhaO[3] = $fields[2]; //cnpjProd
        self::linhaO[4] = $fields[3]; //cSelo
        self::linhaO[5] = $fields[4]; //qSelo
        self::linhaO[6] = $fields[5]; //cEnq
        self::linhaO[7] = ''; //vBC
        self::linhaO[8] = ''; //pIPI
        self::linhaO[9] = ''; //qUnid
        self::linhaO[10] = ''; //vUnid
        self::linhaO[11] = ''; //vIPI
    }
    /**
     * Load O07
     * @param array $fields
     */
    protected static function o07Entity($fields)
    {
        //O07|CST|vIPI|
        self::linhaO[1] = $fields[1];
        self::linhaO[11] = $fields[2];
    }
    /**
     * Load O10
     * @param array $fields
     */
    protected static function o10Entity($fields)
    {
        //O10|vBC|pIPI|
        self::linhaO[7] = $fields[1]; //vBC
        self::linhaO[8] = $fields[2]; //pIPI
        self::linhaOEntity(self::linhaO);
    }
    /**
     * Load O11
     * @param array $fields
     */
    protected static function o11Entity($fields)
    {
        //O11|qUnid|vUnid|
        self::linhaO[9] = $fields[1]; //qUnid
        self::linhaO[10] = $fields[2]; //vUnid
        self::linhaOEntity(self::linhaO);
    }
    /**
     * Load O08
     * @param array $fields
     */
    protected static function o08Entity($fields)
    {
        //O08|CST|
        self::linhaO[1] = $fields[1];
        self::linhaOEntity(self::linhaO);
    }
    /**
     * Make tag <IPI>
     * @param array $fields
     */
    protected static function linhaOEntity($fields)
    {
        //Oxx|cst|clEnq|cnpjProd|cSelo|qSelo|cEnq|vBC|pIPI|qUnid|vUnid|vIPI|
        self::$make->tagIPI(
            self::nItem,
            $fields[1], //cst
            $fields[2], //clEnq
            $fields[3], //cnpjProd
            $fields[4], //cSelo
            $fields[5], //qSelo
            $fields[6], //cEnq
            $fields[7], //vBC
            $fields[8], //pIPI
            $fields[9], //qUnid
            $fields[10], //vUnid
            $fields[11] //vIPI
        );
    }
    /**
     * pEntity
     * Cria a tag II
     *
     * @param array $fields
     */
    protected static function pEntity($fields)
    {
        //P|vBC|vDespAdu|vII|vIOF|
        self::$make->tagII(
            self::nItem,
            $fields[1], //vBC
            $fields[2], //vDespAdu
            $fields[3], //vII
            $fields[4] //vIOF
        );
    }
    /**
     * qEntity
     *
     * @param array $fields
     */
    protected static function qEntity($fields)
    {
        //Q|
        //carrega numero do item
        $fields = [];
        self::linhaQ[0] = self::nItem;
        self::linhaQ[1] = ''; //cst
        self::linhaQ[2] = ''; //vBC
        self::linhaQ[3] = ''; //pPIS
        self::linhaQ[4] = ''; //vPIS
        self::linhaQ[5] = ''; //qBCProd
        self::linhaQ[6] = ''; //vAliqProd
    }
    /**
     * q02Entity
     *
     * @param array $fields
     */
    protected static function q02Entity($fields)
    {
        //Q02|CST|vBC|pPIS|vPIS|
        self::linhaQ[1] = $fields[1]; //cst
        self::linhaQ[2] = $fields[2]; //vBC
        self::linhaQ[3] = $fields[3]; //pPIS
        self::linhaQ[4] = $fields[4]; //vPIS
        self::linhaQEntity(self::linhaQ);
    }
    /**
     * q03Entity
     *
     * @param array $fields
     */
    protected static function q03Entity($fields)
    {
        //Q03|CST|qBCProd|vAliqProd|vPIS|
        self::linhaQ[1] = $fields[1]; //cst
        self::linhaQ[4] = $fields[4]; //vPIS
        self::linhaQ[5] = $fields[2]; //qBCProd
        self::linhaQ[6] = $fields[3]; //vAliqProd
        self::linhaQEntity(self::linhaQ);
    }
    /**
     * q04Entity
     *
     * @param array $fields
     */
    protected static function q04Entity($fields)
    {
        //Q04|CST|
        self::linhaQ[1] = $fields[1]; //cst
        self::linhaQEntity(self::linhaQ);
    }
    /**
     * q05Entity
     *
     * @param array $fields
     */
    protected static function q05Entity($fields)
    {
        //Q05|CST|vPIS|
        self::linhaQ[1] = $fields[1]; //cst
        self::linhaQ[2] = ''; //vBC
        self::linhaQ[3] = ''; //pPIS
        self::linhaQ[4] = $fields[2]; //vPIS
        self::linhaQ[5] = ''; //qBCProd
        self::linhaQ[6] = ''; //vAliqProd
        self::linhaQEntity(self::linhaQ);
    }
    /**
     * q07Entity
     *
     * @param array $fields
     */
    protected static function q07Entity($fields)
    {
        //Q07|vBC|pPIS|
        self::linhaQ[2] = $fields[1]; //vBC
        self::linhaQ[3] = $fields[2]; //pPIS
        self::linhaQEntity(self::linhaQ);
    }
    /**
     * q10Entity
     *
     * @param array $fields
     */
    protected static function q10Entity($fields)
    {
        //Q10|qBCProd|vAliqProd|
        self::linhaQ[5] = $fields[1]; //qBCProd
        self::linhaQ[6] = $fields[2]; //vAliqProd
        self::linhaQEntity(self::linhaQ);
    }
    /**
     * linhaQEntity
     * Cria a tag PIS
     *
     * @param array $fields
     */
    protected static function linhaQEntity($fields)
    {
        //Qxx|CST|vBC|pPIS|vPIS|qBCProd|vAliqProd|
        self::$make->tagPIS(
            self::nItem,
            $fields[1], //cst
            $fields[2], //vBC
            $fields[3], //pPIS
            $fields[4], //vPIS
            $fields[5], //qBCProd
            $fields[6] //vAliqProd
        );
    }
    /**
     * rEntity
     *
     * @param array $fields
     */
    protected static function rEntity($fields)
    {
        //R|vPIS|
        self::linhaR[0] = self::nItem;
        self::linhaR[1] = ''; //vBC
        self::linhaR[2] = ''; //pPIS
        self::linhaR[3] = ''; //qBCProd
        self::linhaR[4] = ''; //vAliqProd
        self::linhaR[5] = $fields[1]; //vPIS
    }
    /**
     * r02Entity
     *
     * @param array $fields
     */
    protected static function r02Entity($fields)
    {
        //R02|vBC|pPIS|
        self::linhaR[1] = $fields[1]; //vBC
        self::linhaR[2] = $fields[1]; //pPIS
        self::linhaREntity(self::linhaR);
    }
    /**
     * r04Entity
     *
     * @param array $fields
     */
    protected static function r04Entity($fields)
    {
        //R04|qBCProd|vAliqProd|vPIS|
        self::linhaR[3] = $fields[1]; //qBCProd
        self::linhaR[4] = $fields[2]; //vAliqProd
        self::linhaR[5] = $fields[3]; //vPIS
        self::linhaREntity(self::linhaR);
    }
    /**
     * linhaREntity
     * Cria a tag PISST
     *
     * @param array $fields
     */
    protected static function linhaREntity($fields)
    {
        //Rxx|vBC|pPIS|qBCProd|vAliqProd|vPIS|
        self::$make->tagPISST(
            self::nItem,
            $fields[1], //vBC
            $fields[2], //pPIS
            $fields[3], //qBCProd
            $fields[4], //vAliqProd
            $fields[5] //vPIS
        );
    }
    /**
     * sEntity
     *
     * @param array $fields
     */
    protected static function sEntity($fields)
    {
        //S|
        //fake não faz nada
        $fields = [];
        self::linhaS[0] = '';
        self::linhaS[1] = '';
        self::linhaS[2] = '';
        self::linhaS[3] = '';
        self::linhaS[4] = '';
        self::linhaS[5] = '';
        self::linhaS[6] = '';
    }
    /**
     * s02Entity
     *
     * @param array $fields
     */
    protected static function s02Entity($fields)
    {
        //S02|CST|vBC|pCOFINS|vCOFINS|
        self::linhaS[0] = self::nItem;
        self::linhaS[1] = $fields[1]; //cst
        self::linhaS[2] = $fields[2]; //vBC
        self::linhaS[3] = $fields[3]; //pCOFINS
        self::linhaS[4] = $fields[4]; //vCOFINS
        self::linhaS[5] = ''; //qBCProd
        self::linhaS[6] = ''; //vAliqProd
        self::linhaSEntity(self::linhaS);
    }
    /**
     * s03Entity
     *
     * @param array $fields
     */
    protected static function s03Entity($fields)
    {
        //S03|CST|qBCProd|vAliqProd|vCOFINS|
        self::linhaS[1] = $fields[1]; //cst
        self::linhaS[4] = $fields[4]; //vCOFINS
        self::linhaS[5] = $fields[2]; //qBCProd
        self::linhaS[6] = $fields[3]; //vAliqProd
        self::linhaSEntity(self::linhaS);
    }
    /**
     * s04Entity
     *
     * @param array $fields
     */
    protected static function s04Entity($fields)
    {
        //S04|CST|
        self::linhaS[1] = $fields[1]; //cst
        self::linhaSEntity(self::linhaS);
    }
    /**
     * s05Entity
     *
     * @param array $fields
     */
    protected static function s05Entity($fields)
    {
        //S05|CST|vCOFINS|
        self::linhaS[1] = $fields[1]; //cst
        self::linhaS[4] = $fields[2]; //vCOFINS
    }
    /**
     * s07Entity
     *
     * @param array $fields
     */
    protected static function s07Entity($fields)
    {
        //S07|vBC|pCOFINS|
        self::linhaS[2] = $fields[1]; //vBC
        self::linhaS[3] = $fields[2]; //pCOFINS
        self::linhaSEntity(self::linhaS);
    }
    /**
     * s09Entity
     *
     * @param array $fields
     */
    protected static function s09Entity($fields)
    {
        //S09|qBCProd|vAliqProd|
        self::linhaS[5] = $fields[1]; //qBCProd
        self::linhaS[6] = $fields[2]; //vAliqProd
        self::linhaSEntity(self::linhaS);
    }
    /**
     * linhaSEntity
     * Cria a tag COFINS
     *
     * @param array $fields
     */
    protected static function linhaSEntity($fields)
    {
        //Sxx|CST|vBC|pCOFINS|vCOFINS|qBCProd|vAliqProd|
        self::$make->tagCOFINS(
            self::nItem,
            $fields[1], //cst
            $fields[2], //vBC
            $fields[3], //pCOFINS
            $fields[4], //vCOFINS
            $fields[5], //qBCProd
            $fields[6] //vAliqProd
        );
    }
    /**
     * tEntity
     *
     * @param array $fields
     */
    protected static function tEntity($fields)
    {
        //T|vCOFINS|
        self::linhaT[0] = self::nItem;
        self::linhaT[1] = ''; //$vBC
        self::linhaT[2] = ''; //$pCOFINS
        self::linhaT[3] = ''; //$qBCProd
        self::linhaT[4] = ''; //$vAliqProd
        self::linhaT[5] = $fields[1]; //$vCOFINS
    }
    /**
     * t02Entity
     *
     * @param array $fields
     */
    protected static function t02Entity($fields)
    {
        //T02|vBC|pCOFINS|
        self::linhaT[1] = $fields[1]; //$vBC
        self::linhaT[2] = $fields[2]; //$pCOFINS
        self::linhaTEntity(self::linhaT);
    }
    /**
     * t04Entity
     *
     * @param array $fields
     */
    protected static function t04Entity($fields)
    {
        //T04|qBCProd|vAliqProd|
        self::linhaT[3] = $fields[1]; //$qBCProd
        self::linhaT[4] = $fields[2]; //$vAliqProd
        self::linhaTEntity(self::linhaT);
    }
    /**
     * linhaTEntity
     * Cria a tag COFINSST
     *
     * @param array $fields
     */
    protected static function linhaTEntity($fields)
    {
        //Txx|vBC|pCOFINS|qBCProd|vAliqProd|vCOFINS|
        self::$make->tagCOFINSST(
            self::nItem,
            $fields[1], //$vBC
            $fields[2], //$pCOFINS
            $fields[3], //$qBCProd
            $fields[4], //$vAliqProd
            $fields[5] //$vCOFINS
        );
    }
    /**
     * uEntity
     * Cria a tag ISSQN
     *
     * @param array $fields
     */
    protected static function uEntity($fields)
    {
        //U|vBC|vAliq|vISSQN|cMunFG|cListServ|vDeducao|vOutro|vDescIncond
        // |vDescCond|vISSRet|indISS|cServico|cMun|cPais|nProcesso|indIncentivo|
        self::$make->tagISSQN(
            self::nItem,
            $fields[1], //$vBC
            $fields[2], //$vAliq
            $fields[3], //$vISSQN
            $fields[4], //$cMunFG
            $fields[5], //$cListServ
            $fields[6], //$vDeducao
            $fields[7], //$vOutro
            $fields[8], //$vDescIncond
            $fields[9], //$vDescCond
            $fields[10], //$vISSRet
            $fields[11], //$indISS
            $fields[12], //$cServico
            $fields[13], //$cMun
            $fields[14], //$cPais
            $fields[15], //$nProcesso
            $fields[16] //$indIncentivo
        );
    }
    /**
     * uaEntity
     * Cria a tag tagimpostoDevol
     *
     * @param array $fields
     */
    protected static function uaEntity($fields)
    {
        //UA|pDevol|vIPIDevol|
        self::$make->tagimpostoDevol(
            self::nItem,
            $fields[1], //pDevol
            $fields[2] //vIPIDevol
        );
    }
    /**
     * wEntity
     *
     * @param array $fields
     */
    protected static function wEntity($fields)
    {
        //W|
        //fake não faz nada
        $fields = [];
    }
    /**
     * w02Entity
     * Cria tag ICMSTot
     *
     * @param array $fields
     */
    protected static function w02Entity($fields)
    {
        //W02|vBC|vICMS|vICMSDeson|vBCST|vST|vProd|vFrete|vSeg|vDesc|vII|vIPI
        //   |vPIS|vCOFINS|vOutro|vNF|vTotTrib|
        self::$make->tagICMSTot(
            $fields[1], //$vBC
            $fields[2], //$vICMS
            $fields[3], //$vICMSDeson
            $fields[4], //$vBCST
            $fields[5], //$vST
            $fields[6], //$vProd
            $fields[7], //$vFrete
            $fields[8], //$vSeg
            $fields[9], //$vDesc
            $fields[10], //$vII
            $fields[11], //$vIPI
            $fields[12], //$vPIS
            $fields[13], //$vCOFINS
            $fields[14], //$vOutro
            $fields[15], //$vNF
            $fields[16] //$vTotTrib
        );
    }
    /**
     * w17Entity
     * Cria a tag ISSQNTot
     *
     * @param array $fields
     */
    protected static function w17Entity($fields)
    {
        //W17|vServ|vBC|vISS|vPIS|vCOFINS|dCompet|vDeducao|vOutro|vDescIncond
        //   |vDescCond|vISSRet|cRegTrib|
        self::$make->tagISSQNTot(
            $fields[1], //$vServ
            $fields[2], //$vBC
            $fields[3], //$vISS
            $fields[4], //$vPIS
            $fields[5], //$vCOFINS
            $fields[6], //$dCompet
            $fields[7], //$vDeducao
            $fields[8], //$vOutro
            $fields[9], //$vDescIncond
            $fields[10], //$vDescCond
            $fields[11], //$vISSRet
            $fields[12] //$cRegTrib
        );
    }
    /**
     * w23Entity
     * Cria a tag retTrib
     *
     * @param type $fields
     */
    protected static function w23Entity($fields)
    {
        //W23|vRetPIS|vRetCOFINS|vRetCSLL|vBCIRRF|vIRRF|vBCRetPrev|vRetPrev|
        self::$make->tagretTrib(
            $fields[1], //$vRetPIS
            $fields[2], //$vRetCOFINS
            $fields[3], //$vRetCSLL
            $fields[4], //$vBCIRRF
            $fields[5], //$vIRRF
            $fields[6], //$vBCRetPrev
            $fields[7] //$vRetPrev
        );
    }
    /**
     * xEntity
     * Cria a tag transp
     *
     * @param array $fields
     */
    protected static function xEntity($fields)
    {
        //X|modFrete|
        self::$make->tagtransp($fields[1]);
    }
    /**
     * x03Entity
     *
     * @param array $fields
     */
    protected static function x03Entity($fields)
    {
        //X03|xNome|IE|xEnder|xMun|UF|
        self::linhaX[0] = '';
        self::linhaX[1] = ''; //$numCNPJ
        self::linhaX[2] = ''; //$numCPF
        self::linhaX[3] = $fields[1]; //$xNome
        self::linhaX[4] = $fields[2]; //$numIE
        self::linhaX[5] = $fields[3]; //$xEnder
        self::linhaX[6] = $fields[4]; //$xMun
        self::linhaX[7] = $fields[5]; //$siglaUF
    }
    /**
     * x04Entity
     *
     * @param array $fields
     */
    protected static function x04Entity($fields)
    {
        //X04|CNPJ|
        self::linhaX[1] = $fields[1]; //$numCNPJ
        self::linhaXEntity(self::linhaX);
    }
    /**
     * x05Entity
     *
     * @param array $fields
     */
    protected static function x05Entity($fields)
    {
        //X05|CPF|
        self::linhaX[2] = $fields[1]; //$numCPF
        self::linhaXEntity(self::linhaX);
    }
    /**
     * linhaXEntity
     * Cria a tag transporta
     *
     * @param array $fields
     */
    protected static function linhaXEntity($fields)
    {
        //Xnn|CNPJ|CPF|xNome|IE|xEnder|xMun|UF|
        self::$make->tagtransporta(
            $fields[1], //$numCNPJ
            $fields[2], //$numCPF
            $fields[3], //$xNome
            $fields[4], //$numIE
            $fields[5], //$xEnder
            $fields[6], //$xMun
            $fields[7] //$siglaUF
        );
    }
    /**
     * x11Entity
     *
     * @param array $fields
     */
    protected static function x11Entity($fields)
    {
        //X11|vServ|vBCRet|pICMSRet|vICMSRet|CFOP|cMunFG|
        self::$make->tagretTransp(
            $fields[1], //$vServ
            $fields[2], //$vBCRet
            $fields[3], //$pICMSRet
            $fields[4], //$vICMSRet
            $fields[5], //$cfop
            $fields[6] //$cMunFG
        );
    }
    /**
     * x18Entity
     * Cria a tag veicTransp
     *
     * @param array $fields
     */
    protected static function x18Entity($fields)
    {
        //X18|placa|UF|RNTC|
        self::$make->tagveicTransp(
            $fields[1], //$placa
            $fields[2], //$siglaUF
            $fields[3] //$rntc
        );
    }
    /**
     * x22Entity
     * Cria a tag reboque
     *
     * @param array $fields
     */
    protected static function x22Entity($fields)
    {
        //X22|placa|UF|RNTC|vagao|balsa|
        self::$make->tagreboque(
            $fields[1], //$placa
            $fields[3], //$siglaUF
            $fields[4], //$rntc
            $fields[5], //$vagao
            $fields[6] //$balsa
        );
    }
    /**
     * x26Entity
     *
     * @param array $fields
     */
    protected static function x26Entity($fields)
    {
        //X26|qVol|esp|marca|nVol|pesoL|pesoB|
        self::volId += 1;
        self::linhaX26[self::volId][0] = self::volId;
        self::linhaX26[self::volId][1] = $fields[1]; //$qVol = '',
        self::linhaX26[self::volId][2] = $fields[2]; //$esp = '',
        self::linhaX26[self::volId][3] = $fields[3]; //$marca = '',
        self::linhaX26[self::volId][4] = $fields[4]; //$nVol = '',
        self::linhaX26[self::volId][5] = $fields[5]; //$pesoL = '',
        self::linhaX26[self::volId][6] = $fields[6]; //$pesoB = '',
    }
    /**
     * x33Entity
     *
     * @param array $fields
     */
    protected static function x33Entity($fields)
    {
        //X33|nLacre|
        self::aLacres[self::volId][] = $fields[1];
    }
    /**
     * linhaXVolEntity
     * Cria a tag vol
     *
     * @param array $fields
     */
    protected static function linhaXVolEntity($fields)
    {
        $lacres = '';
        if (self::volId > -1 && ! empty(self::aLacres)) {
            $lacres = self::aLacres[$fields[0]];
        }
        self::$make->tagvol(
            $fields[1], //$qVol = '',
            $fields[2], //$esp = '',
            $fields[3], //$marca = '',
            $fields[4], //$nVol = '',
            $fields[5], //$pesoL = '',
            $fields[6], //$pesoB = '',
            $lacres
        );
    }
    /**
     * yEntity
     *
     * @param array $fields
     */
    protected static function yEntity($fields)
    {
        //Y|
        //fake não faz nada
        $fields = [];
    }
    /**
     * y02Entity
     * Cria a tag fat
     *
     * @param array $fields
     */
    protected static function y02Entity($fields)
    {
        //Y02|nFat|vOrig|vDesc|vLiq|
        self::$make->tagfat(
            $fields[1], //$nFat
            $fields[2], //$vOrig
            $fields[3], //$vDesc
            $fields[4] //$vLiq
        );
    }
    /**
     * y07Entity
     * Cria a tag dup
     *
     * @param array $fields
     */
    protected static function y07Entity($fields)
    {
        //Y07|nDup|dVenc|vDup|
        self::$make->tagdup(
            $fields[1], //$nDup
            $fields[2], //$dVenc
            $fields[3] //$vDup
        );
    }
    /**
     * yaEntity
     * Cria as tags pag e card
     *
     * @param array $fields
     */
    protected static function yaEntity($fields)
    {
        //YA|tPag|vPag|CNPJ|tBand|cAut|tpIntegra|
        self::$make->tagpag(
            $fields[1], //$tPag
            $fields[2] //$vPag
        );
        if ($fields[4] != '') {
            self::$make->tagcard(
                $fields[3], //$cnpj
                $fields[4], //$tBand
                $fields[5], //$cAut
                $fields[6] //$tpIntegra
            );
        }
    }
    /**
     * zEntity
     * Cria a a tag infAdic
     *
     * @param array $fields
     */
    protected static function zEntity($fields)
    {
        //Z|infAdFisco|infCpl|
        self::$make->taginfAdic(
            $fields[1], //$infAdFisco
            $fields[2] //$infCpl
        );
    }
    /**
     * z04Entity
     * Cria a tag obsCont
     *
     * @param array $fields
     */
    protected static function z04Entity($fields)
    {
        //Z04|xCampo|xTexto|
        self::$make->tagobsCont(
            $fields[1], //$xCampo
            $fields[2] //$xTexto
        );
    }
    /**
     * z07Entity
     * Cria a tag obsFisco
     *
     * @param array $fields
     */
    protected static function z07Entity($fields)
    {
        //Z07|xCampo|xTexto|
        self::$make->tagobsFisco(
            $fields[1], //$xCampo
            $fields[2] //$xTexto
        );
    }
    /**
     * z10Entity
     * Cria a tag prcRef
     *
     * @param array $fields
     */
    protected static function z10Entity($fields)
    {
        //Z10|nProc|indProc|
        self::$make->tagprocRef(
            $fields[1], //$nProc
            $fields[2] //$indProc
        );
    }
    /**
     * zaEntity
     * Cria a tag exporta
     *
     * @param array $fields
     */
    protected static function zaEntity($fields)
    {
        //ZA|UFSaidaPais|xLocExporta|xLocDespacho|
        self::$make->tagexporta(
            $fields[1], //$ufSaidaPais
            $fields[2], //$xLocExporta
            $fields[3] //$xLocDespacho
        );
    }
    /**
     * zbEntity
     * Cria a tag compra
     *
     * @param array $fields
     */
    protected static function zbEntity($fields)
    {
        //ZB|xNEmp|xPed|xCont|
        self::$make->tagcompra(
            $fields[1], //$xNEmp
            $fields[2], //$xPed
            $fields[3] //$xCont
        );
    }
    /**
     * zc01Entity
     * Cria a tag cana
     *
     * @param array $fields
     */
    protected static function zc01Entity($fields)
    {
        //ZC|safra|ref|qTotMes|qTotAnt|qTotGer|vFor|vTotDed|vLiqFor|
        self::$make->tagcana(
            $fields[1], //$safra
            $fields[2] //$ref
        );
        self::linhaZC[1] = $fields[3]; //qTotMes
        self::linhaZC[2] = $fields[4]; //qTotAnt
        self::linhaZC[3] = $fields[5]; //qTotGer
        self::linhaZC[4] = $fields[6]; //vFor
        self::linhaZC[5] = $fields[7]; //vTotDed
        self::linhaZC[6] = $fields[8]; //vLiqFor
    }
    /**
     * zc04Entity
     * Cria a tag forDia
     *
     * @param array $fields
     */
    protected static function zc04Entity($fields)
    {
        //ZC04|dia|qtde|
        self::$make->tagforDia(
            $fields[1], //$dia
            $fields[2], //$qtde
            self::linhaZC[1], //$qTotMes
            self::linhaZC[2], //$qTotAnt
            self::linhaZC[3] //$qTotGer
        );
    }
    /**
     * zc10Entity
     * Cria a tag deduc
     *
     * @param array $fields
     */
    protected static function zc10Entity($fields)
    {
        //ZC10|xDed|vDed|
        self::$make->tagdeduc(
            $fields[1], //$xDed
            $fields[2], //$vDed
            self::linhaZC[4], //$vFor
            self::linhaZC[5], //$vTotDed
            self::linhaZC[6] //$vLiqFor
        );
    }
    /**
     * zx01Entity
     * Cria a tag infNFeSupl com o qrCode para impressão da DANFCE
     *
     * @param array $fields
     */
    protected static function zx01Entity($fields)
    {
        //ZX01|qrcode
        self::$make->taginfNFeSupl($fields[1]);
    }
    
    
    
}