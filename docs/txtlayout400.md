## LAYOUT NFe v4.00 - FORMATO LOCAL do NFePHP *(diferente do emissor SEBRAE)*
- Nota Técnica 2016.002 - v1.10
- Nota Técnica 2016.002 - v1.20
- Nota Técnica 2016.002 - v1.30
- Nota Técnica 2016.002 - v1.31
- Nota Técnica 2016.002 - v1.40
- Nota Técnica 2016.002 - v1.41
- Nota Técnica 2016.002 - v1.42
- Nota Técnica 2016.002 - v1.50
- Nota Técnica 2016.002 - v1.51
- Nota Técnica 2016.002 - v1.60
- Nota Técnica 2018.005 - v1.00
- Nota Técnica 2018.005 - v1.10

### Campos alterados e inclusos, indicados em negrito (validos a partir de 29/04/2019:

> F|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|**CEP|cPais|xPais|fone|email|IE|**

> **F02b|xNome|**

> G|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|**CEP|cPais|xPais|fone|email|IE|**

> **G02b|xNome|**

> K|cProdANVISA|vPMC|**xMotivoIsencao|**

> N08|orig|CST|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|pRedBCEfet|vBCEfet|pICMSEfet|vICMSEfet|**vICMSSubstituto|**

> N10b|orig|CST|vBCSTRet|vICMSSTRet|vBCSTDest|vICMSSTDest|**vBCFCPSTRet|pFCPSTRet|vFCPSTRet|pST|vICMSSubstituto|pRedBCEfet|vBCEfet|pICMSEfet|vICMSEfet|**

> N10g|orig|CSOSN|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|pRedBCEfet|vBCEfet|pICMSEfet|vICMSEfet|**vICMSSubstituto|**

> **ZD|CNPJ|xContato|email|fone|CSRT|idCSRT|**

### *Estas alterações somente serão validas em produção a partir de 29/04/2019*

```
NOTAFISCAL|numero de notas|

A|versao|Id|pk_nItem|

B|cUF|cNF|natOp|mod|serie|nNF|dhEmi|dhSaiEnt|tpNF|idDest|cMunFG|tpImp|tpEmis|cDV|tp Amb|finNFe|indFinal|indPres|procEmi|verProc|dhCont|xJust|

BA|

BA02|refNFe|

BA03|cUF|AAMM|CNPJ|mod|serie|nNF|

BA10|cUF|AAMM|IE|mod|serie|nNF|

BA13|CNPJ|

BA14|CPF|

B19|refCTe|

BA20|mod|nECF|nCOO|

C|xNome|xFant|IE|IEST|IM|CNAE|CRT|

C02|CNPJ|

C02a|CPF|

C05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|

D|CNPJ|xOrgao|matr|xAgente|fone|UF|nDAR|dEmi|vDAR|repEmi|dPag|

E|xNome|indIEDest|IE|ISUF|IM|email|

E02|CNPJ|

E03|CPF|

E03a|idEstrangeiro|

E05|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|CEP|cPais|xPais|fone|

F|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|

F02|CNPJ|

F02a|CPF|

G|xLgr|nro|xCpl|xBairro|cMun|xMun|UF|

G02|CNPJ|

G02a|CPF|

GA|

GA02|CNPJ|

GA03|CPF|

H|item|infAdProd|

I|cProd|cEAN|xProd|NCM|cBenef|EXTIPI|CFOP|uCom|qCom|vUnCom|vProd|cEANTrib|uTrib|qTrib|vUnTrib|vFrete|vSeg|vDesc|vOutro|indTot|xPed|nItemPed|nFCI|

I05A|NVE|

I05C|CEST|indEscala|CNPJFab|

I18|nDI|dDI|xLocDesemb|UFDesemb|dDesemb|tpViaTransp|vAFRMM|tpIntermedio|CNPJ|UFTerceiro|cExportador|

I25|nAdicao|nSeqAdic|cFabricante|vDescDI|nDraw|

I50|nDraw|

I52|nRE|chNFe|qExport|

I80|nLote|qLote|dFab|dVal|cAgreg|

JA|tpOp|chassi|cCor|xCor|pot|cilin|pesoL|pesoB|nSerie|tpComb|nMotor|CMT|dist|anoMod|anoFab|tpPint|tpVeic|espVeic|VIN|condVeic|cMod|cCorDENATRAN|lota|tpRest|

K|cProdANVISA|vPMC|

L|tpArma|nSerie|nCano|descr|

LA|cProdANP|descANP|pGLP|pGNn|pGNi|vPart|CODIF|qTemp|UFCons|

LA07|qBCProd|vAliqProd|vCIDE|

LA11|nBico|nBomba|nTanque|vEncIni|vEncFin|

LB|nRECOPI|

M|vTotTrib|

N|

N02|orig|CST|modBC|vBC|pICMS|vICMS|pFCP|vFCP|

N03|orig|CST|modBC|vBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|

N04|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|vICMSDeson|motDesICMS|

N05|orig|CST|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|

N06|orig|CST|vICMSDeson|motDesICMS|

N07|orig|CST|modBC|pRedBC|vBC|pICMS|vICMSOp|pDif|vICMSDif|vICMS|vBCFCP|pFCP|vFCP|

N08|orig|CST|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|pRedBCEfet|vBCEfet|pICMSEfet|vICMSEfet|

N09|orig|CST|modBC|pRedBC|vBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|

N10|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|vBCFCP|pFCP|vFCP|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|vICMSDeson|motDesICMS|

N10a|orig|CST|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|pBCOp|UFST|

N10b|orig|CST|vBCSTRet|vICMSSTRet|vBCSTDest|vICMSSTDest|

N10c|orig|CSOSN|pCredSN|vCredICMSSN|

N10d|orig|CSOSN|

N10e|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|pCredSN|vCredICMSSN|

N10f|orig|CSOSN|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|

N10g|orig|CSOSN|vBCSTRet|pST|vICMSSTRet|vBCFCPSTRet|pFCPSTRet|vFCPSTRet|pRedBCEfet|vBCEfet|pICMSEfet|vICMSEfet|

N10h|orig|CSOSN|modBC|vBC|pRedBC|pICMS|vICMS|modBCST|pMVAST|pRedBCST|vBCST|pICMSST|vICMSST|vBCFCPST|pFCPST|vFCPST|pCredSN|vCredICMSSN|

NA|vBCUFDest|vBCFCPUFDest|pFCPUFDest|pICMSUFDest|pICMSInter|pICMSInterPart|vFCPUFDest|vICMSUFDest|vICMSFRemet|

O|CNPJProd|cSelo|qSelo|cEnq|

O07|CST|vIPI|

O08|CST|

O10|vBC|pIPI|

O11|qUnid|vUnid|

P|vBC|vDespAdu|vII|vIOF|

Q|

Q02|CST|vBC|pPIS|vPIS|

Q03|CST|qBCProd|vAliqProd|vPIS|

Q04|CST|

Q05|CST|vPIS|

Q07|vBC|pPIS|

Q10|qBCProd|vAliqProd|

R|vPIS|

R02|vBC|pPIS|

R04|qBCProd|vAliqProd|vPIS|

S|

S02|CST|vBC|pCOFINS|vCOFINS|

S03|CST|qBCProd|vAliqProd|vCOFINS|

S04|CST|

S05|CST|vCOFINS|

S07|vBC|pCOFINS|

S09|qBCProd|vAliqProd|

T|vCOFINS|

T02|vBC|pCOFINS|

T04|qBCProd|vAliqProd|

U|vBC|vAliq|vISSQN|cMunFG|cListServ|vDeducao|vOutro|vDescIncond|vDescCond|vISSRet|indISS|cServico|cMun|cPais|nProcesso|indIncentivo|

UA|pDevol|vIPIDevol|

W|

W02|vBC|vICMS|vICMSDeson|vFCP|vBCST|vST|vFCPST|vFCPSTRet|vProd|vFrete|vSeg|vDesc|vII|vIPI|vIPIDevol|vPIS|vCOFINS|vOutro|vNF|vTotTrib|vFCPUFDest|vICMSUFDest|vICMSUFRemet|

W17|vServ|vBC|vISS|vPIS|vCOFINS|dCompet|vDeducao|vOutro|vDescIncond|vDescCond|vISSRet|cRegTrib|

W23|vRetPIS|vRetCOFINS|vRetCSLL|vBCIRRF|vIRRF|vBCRetPrev|vRetPrev|

X|modFrete|

X03|xNome|IE|xEnder|xMun|UF|

X04|CNPJ|

X05|CPF|

X11|vServ|vBCRet|pICMSRet|vICMSRet|CFOP|cMunFG|

X18|placa|UF|RNTC|

X22|placa|UF|RNTC|

X25a|vagao|

X25b|balsa|

X26|qVol|esp|marca|nVol|pesoL|pesoB|

X33|nLacre|

Y|vTroco|

Y02|nFat|vOrig|vDesc|vLiq|

Y07|nDup|dVenc|vDup|

YA|indPag|tPag|vPag|CNPJ|tBand|cAut|tpIntegra|

Z|infAdFisco|infCpl|

Z04|xCampo|xTexto|

Z07|xCampo|xTexto|

Z10|nProc|indProc|

ZA|UFSaidaPais|xLocExporta|xLocDespacho|

ZB|xNEmp|xPed|xCont|

ZC|safra|ref|qTotMes|qTotAnt|qTotGer|vFor|vTotDed|vLiqFor|

ZC04|dia|qtde|

ZC10|xDed|vDed|

ZX01|qrcode|urlChave|

```
