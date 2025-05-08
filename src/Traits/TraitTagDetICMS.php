<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property Dom $dom
 * @property stdClass $stdTot
 * @property array $aICMS
 * @property array $aICMSPart
 * @property array $aICMSST
 * @property array $aICMSUFDest
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagDetICMS
{
    /**
     * Informações do ICMS da Operação própria e ST N01 pai M01
     * tag NFe/infNFe/det[]/imposto/ICMS
     * NOTA: ajustado NT 2020.005-v1.20
     * NOTA: Ajustado para NT2023_0001_v1.10
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = "N01 <ICMSxx> Item: $std->item -";
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS = 00"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador Valor do Fundo de Combate "
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS = 02"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMono',
                    $this->conditionalNumberFormatting($std->qBCMono, 4),
                    false,
                    "$identificador Quantidade tributada"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMS',
                    $this->conditionalNumberFormatting($std->adRemICMS, 4),
                    true,
                    "$identificador Alíquota ad rem do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMono',
                    $this->conditionalNumberFormatting($std->vICMSMono),
                    true,
                    "$identificador Valor do ICMS próprio"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTDeson',
                    $this->conditionalNumberFormatting($std->vICMSSTDeson),
                    false,
                    "$identificador Valor do ICMS- ST desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMSST',
                    $std->motDesICMSST ?? null,
                    false,
                    "$identificador Motivo da desoneração do ICMS- ST"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMono',
                    $this->conditionalNumberFormatting($std->qBCMono, 4),
                    false,
                    "$identificador Quantidade tributada"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMS',
                    $this->conditionalNumberFormatting($std->adRemICMS, 4),
                    true,
                    "$identificador Alíquota ad rem do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMono',
                    $this->conditionalNumberFormatting($std->vICMSMono),
                    true,
                    "$identificador Valor do ICMS próprio"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMonoReten',
                    $this->conditionalNumberFormatting($std->qBCMonoReten, 4),
                    false,
                    "$identificador Quantidade tributada sujeita a retenção"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMSReten',
                    $this->conditionalNumberFormatting($std->adRemICMSReten, 4),
                    true,
                    "$identificador Alíquota ad rem do imposto com retenção"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoReten',
                    $this->conditionalNumberFormatting($std->vICMSMonoReten),
                    true,
                    "$identificador Valor do ICMS com retenção"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    true,
                    "$identificador Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador Indica se o valor do ICMS desonerado (vICMSDeson) "
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador Indica se o valor do ICMS desonerado (vICMSDeson) "
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS $std->CST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador Indica se o valor do ICMS desonerado (vICMSDeson) "
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    false,
                    "$identificador Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    false,
                    "$identificador Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'cBenefRBC',
                    $std->cBenefRBC,
                    false,
                    "$identificador Código de Benefício Fiscal na UF aplicado ao "
                    . "item quando houver RBC."
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    false,
                    "$identificador Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    false,
                    "$identificador Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSOp',
                    $this->conditionalNumberFormatting($std->vICMSOp),
                    false,
                    "$identificador Valor do ICMS da Operação"
                );
                $this->dom->addChild(
                    $icms,
                    'pDif',
                    $this->conditionalNumberFormatting($std->pDif, 4),
                    false,
                    "$identificador Percentual do diferimento"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDif',
                    $this->conditionalNumberFormatting($std->vICMSDif),
                    false,
                    "$identificador Valor do ICMS diferido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    false,
                    "$identificador Valor do ICMS realmente devido"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPDif',
                    $this->conditionalNumberFormatting($std->pFCPDif),
                    false,
                    "$identificador Percentual do diferimento "
                    . "do ICMS relativo ao Fundo de Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPDif',
                    $this->conditionalNumberFormatting($std->vFCPDif),
                    false,
                    "$identificador Valor do ICMS relativo ao "
                    . "Fundo de Combate à Pobreza (FCP) diferido"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPEfet',
                    $this->conditionalNumberFormatting($std->vFCPEfet),
                    false,
                    "$identificador Valor efetivo do ICMS relativo "
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS = 53"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMono',
                    $this->conditionalNumberFormatting($std->qBCMono, 4),
                    false,
                    "$identificador BC do ICMS em quantidade conforme unidade de medida "
                    . "estabelecida na legislação para o produto"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMS',
                    $this->conditionalNumberFormatting($std->adRemICMS, 4),
                    false,
                    "$identificador Alíquota ad rem do ICMS estabelecida para o produto."
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoOp',
                    $this->conditionalNumberFormatting($std->vICMSMonoOp),
                    false,
                    "$identificador valor do ICMS é obtido pela multiplicação da alíquota ad "
                    . "rem pela quantidade do produto conforme unidade de "
                    . "medida estabelecida em legislação, como se não houvesseo diferimento."
                );
                $this->dom->addChild(
                    $icms,
                    'pDif',
                    $this->conditionalNumberFormatting($std->pDif, 4),
                    false,
                    "$identificador Percentual do diferimento"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoDif',
                    $this->conditionalNumberFormatting($std->vICMSMonoDif),
                    false,
                    "$identificador Valor do ICMS diferido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMono',
                    $this->conditionalNumberFormatting($std->vICMSMono),
                    false,
                    "$identificador Valor do ICMS próprio devido"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS = 60"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCSTRet',
                    $this->conditionalNumberFormatting($std->vBCSTRet),
                    false,
                    "$identificador Valor da BC do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'pST',
                    $this->conditionalNumberFormatting($std->pST, 4),
                    false,
                    "$identificador Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSubstituto',
                    $this->conditionalNumberFormatting($std->vICMSSubstituto),
                    false,
                    "$identificador Valor do ICMS próprio do Substituto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTRet',
                    $this->conditionalNumberFormatting($std->vICMSSTRet),
                    false,
                    "$identificador Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPSTRet',
                    $this->conditionalNumberFormatting($std->vBCFCPSTRet),
                    false,
                    "$identificador Valor da Base de Cálculo "
                    . "do FCP retido anteriormente por ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPSTRet',
                    $this->conditionalNumberFormatting($std->pFCPSTRet, 4),
                    false,
                    "$identificador Percentual do FCP retido "
                    . "anteriormente por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPSTRet',
                    $this->conditionalNumberFormatting($std->vFCPSTRet),
                    false,
                    "$identificador Valor do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCEfet',
                    $this->conditionalNumberFormatting($std->pRedBCEfet, 4),
                    false,
                    "$identificador Percentual de redução "
                    . "para obtenção da base de cálculo efetiva"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCEfet',
                    $this->conditionalNumberFormatting($std->vBCEfet),
                    false,
                    "$identificador base de calculo efetiva"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSEfet',
                    $this->conditionalNumberFormatting($std->pICMSEfet, 4),
                    false,
                    "$identificador Alíquota do ICMS na operação a consumidor final"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSEfet',
                    $this->conditionalNumberFormatting($std->vICMSEfet),
                    false,
                    "$identificador Valor do ICMS efetivo"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'qBCMonoRet',
                    $this->conditionalNumberFormatting($std->qBCMonoRet, 4),
                    false,
                    "$identificador Quantidade tributada retida anteriormente"
                );
                $this->dom->addChild(
                    $icms,
                    'adRemICMSRet',
                    $this->conditionalNumberFormatting($std->adRemICMSRet, 4),
                    true,
                    "$identificador Alíquota ad rem do imposto retido anteriormente"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSMonoRet',
                    $this->conditionalNumberFormatting($std->vICMSMonoRet),
                    true,
                    "$identificador Valor do ICMS retido anteriormente"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    true,
                    "$identificador Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    true,
                    "$identificador Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    true,
                    "$identificador Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    true,
                    "$identificador Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    true,
                    "$identificador Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $std->vFCP,
                    false,
                    "$identificador Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador Indica se o valor do ICMS desonerado (vICMSDeson) "
                    . "deduz do valor do item (vProd)."
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTDeson',
                    $this->conditionalNumberFormatting($std->vICMSSTDeson),
                    false,
                    "$identificador Valor do ICMS- ST desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMSST',
                    $std->motDesICMSST ?? null,
                    false,
                    "$identificador Motivo da desoneração do ICMS- ST"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icms,
                    'CST',
                    $std->CST,
                    true,
                    "$identificador Tributação do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'modBC',
                    $std->modBC,
                    false,
                    "$identificador Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    false,
                    "$identificador Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    false,
                    "$identificador Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    false,
                    "$identificador Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    false,
                    "$identificador Valor do ICMS"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCP',
                    $this->conditionalNumberFormatting($std->vBCFCP),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCP',
                    $this->conditionalNumberFormatting($std->pFCP, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP)"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCP',
                    $this->conditionalNumberFormatting($std->vFCP),
                    false,
                    "$identificador Valor do FCP"
                );
                $this->dom->addChild(
                    $icms,
                    'modBCST',
                    $std->modBCST,
                    false,
                    "$identificador Modalidade de determinação da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    false,
                    "$identificador Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    false,
                    "$identificador Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    false,
                    "$identificador Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador Percentual do Fundo de "
                    . "Combate à Pobreza (FCP) ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador Valor do FCP ST"
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSDeson',
                    $this->conditionalNumberFormatting($std->vICMSDeson),
                    false,
                    "$identificador Valor do ICMS desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMS',
                    $std->motDesICMS,
                    false,
                    "$identificador Motivo da desoneração do ICMS"
                );
                //NT 2023.004 v1.00
                $this->dom->addChild(
                    $icms,
                    'indDeduzDeson',
                    $std->indDeduzDeson,
                    false,
                    "$identificador Indica se o valor do ICMS desonerado (vICMSDeson) "
                    . "deduz do valor do item (vProd)."
                );
                $this->dom->addChild(
                    $icms,
                    'vICMSSTDeson',
                    $this->conditionalNumberFormatting($std->vICMSSTDeson),
                    false,
                    "$identificador Valor do ICMS- ST desonerado"
                );
                $this->dom->addChild(
                    $icms,
                    'motDesICMSST',
                    $std->motDesICMSST ?? null,
                    false,
                    "$identificador Motivo da desoneração do ICMS-ST"
                );
                break;
        }
        $this->aICMS[$std->item] = $icms;
        return $icms;
    }

    /**
     * Grupo de Partilha do ICMS entre a UF de origem e UF de destino ou
     * a UF definida na legislação. N10a pai N01
     * tag NFe/infNFe/det[]/imposto/ICMS/ICMSPart
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = "N10a <ICMSPart> Item: $std->item -";
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
            "$identificador Origem da mercadoria"
        );
        $this->dom->addChild(
            $icmsPart,
            'CST',
            $std->CST,
            true,
            "$identificador Tributação do ICMS 10 ou 90"
        );
        $this->dom->addChild(
            $icmsPart,
            'modBC',
            $std->modBC,
            true,
            "$identificador Modalidade de determinação da BC do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBC',
            $this->conditionalNumberFormatting($std->vBC),
            true,
            "$identificador Valor da BC do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'pRedBC',
            $this->conditionalNumberFormatting($std->pRedBC, 4),
            false,
            "$identificador Percentual da Redução de BC"
        );
        $this->dom->addChild(
            $icmsPart,
            'pICMS',
            $this->conditionalNumberFormatting($std->pICMS, 4),
            true,
            "$identificador Alíquota do imposto"
        );
        $this->dom->addChild(
            $icmsPart,
            'vICMS',
            $this->conditionalNumberFormatting($std->vICMS),
            true,
            "$identificador Valor do ICMS"
        );
        $this->dom->addChild(
            $icmsPart,
            'modBCST',
            $std->modBCST,
            true,
            "$identificador Modalidade de determinação da BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pMVAST',
            $this->conditionalNumberFormatting($std->pMVAST, 4),
            false,
            "$identificador Percentual da margem de valor Adicionado do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pRedBCST',
            $this->conditionalNumberFormatting($std->pRedBCST, 4),
            false,
            "$identificador Percentual da Redução de BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBCST',
            $this->conditionalNumberFormatting($std->vBCST),
            true,
            "$identificador Valor da BC do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pICMSST',
            $this->conditionalNumberFormatting($std->pICMSST, 4),
            true,
            "$identificador Alíquota do imposto do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vICMSST',
            $this->conditionalNumberFormatting($std->vICMSST),
            true,
            "$identificador Valor do ICMS ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vBCFCPST',
            $this->conditionalNumberFormatting($std->vBCFCPST),
            false,
            "$identificador Valor da Base de Cálculo do FCP ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pFCPST',
            $this->conditionalNumberFormatting($std->pFCPST, 4),
            false,
            "$identificador Percentual do Fundo de "
            . "Combate à Pobreza (FCP) ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'vFCPST',
            $this->conditionalNumberFormatting($std->vFCPST),
            false,
            "$identificador Valor do FCP ST"
        );
        $this->dom->addChild(
            $icmsPart,
            'pBCOp',
            $this->conditionalNumberFormatting($std->pBCOp, 4),
            true,
            "$identificador Percentual da BC operação própria"
        );
        $this->dom->addChild(
            $icmsPart,
            'UFST',
            $std->UFST,
            true,
            "$identificador UF para qual é devido o ICMS ST"
        );
        $this->aICMSPart[$std->item] = $icmsPart;
        return $icmsPart;
    }

    /**
     * Grupo de Repasse de ICMSST retido anteriormente em operações
     * interestaduais com repasses através do Substituto Tributário
     * NOTA: ajustado NT 2018.005
     * tag NFe/infNFe/det[]/imposto/ICMS/ICMSST N10b pai N01
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = "N10b <ICMSST> Item: $std->item -";
        $this->stdTot->vFCPSTRet += (float) !empty($std->vFCPSTRet) ? $std->vFCPSTRet : 0;
        $icmsST = $this->dom->createElement("ICMSST");
        $this->dom->addChild(
            $icmsST,
            'orig',
            $std->orig,
            true,
            "$identificador Origem da mercadoria"
        );
        $this->dom->addChild(
            $icmsST,
            'CST',
            $std->CST,
            true,
            "$identificador Tributação do ICMS 41 ou 60"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCSTRet',
            $this->conditionalNumberFormatting($std->vBCSTRet),
            true,
            "$identificador Valor do BC do ICMS ST retido na UF remetente"
        );
        $this->dom->addChild(
            $icmsST,
            'pST',
            $this->conditionalNumberFormatting($std->pST, 4),
            false,
            "$identificador Alíquota suportada pelo Consumidor Final"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSubstituto',
            $this->conditionalNumberFormatting($std->vICMSSubstituto),
            false,
            "$identificador Valor do ICMS próprio do Substituto"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSTRet',
            $this->conditionalNumberFormatting($std->vICMSSTRet),
            true,
            "$identificador Valor do ICMS ST retido na UF remetente"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCFCPSTRet',
            $this->conditionalNumberFormatting($std->vBCFCPSTRet),
            false,
            "$identificador Valor da Base de Cálculo do FCP"
        );
        $this->dom->addChild(
            $icmsST,
            'pFCPSTRet',
            $this->conditionalNumberFormatting($std->pFCPSTRet, 4),
            false,
            "$identificador Percentual do FCP retido"
        );
        $this->dom->addChild(
            $icmsST,
            'vFCPSTRet',
            $this->conditionalNumberFormatting($std->vFCPSTRet),
            false,
            "$identificador Valor do FCP retido"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCSTDest',
            $this->conditionalNumberFormatting($std->vBCSTDest),
            true,
            "$identificador Valor da BC do ICMS ST da UF destino"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSSTDest',
            $this->conditionalNumberFormatting($std->vICMSSTDest),
            true,
            "$identificador Valor do ICMS ST da UF destino"
        );
        $this->dom->addChild(
            $icmsST,
            'pRedBCEfet',
            $this->conditionalNumberFormatting($std->pRedBCEfet, 4),
            false,
            "$identificador Percentual de redução da base de cálculo efetiva"
        );
        $this->dom->addChild(
            $icmsST,
            'vBCEfet',
            $this->conditionalNumberFormatting($std->vBCEfet),
            false,
            "$identificador Valor da base de cálculo efetiva"
        );
        $this->dom->addChild(
            $icmsST,
            'pICMSEfet',
            $this->conditionalNumberFormatting($std->pICMSEfet, 4),
            false,
            "$identificador Alíquota do ICMS efetiva"
        );
        $this->dom->addChild(
            $icmsST,
            'vICMSEfet',
            $this->conditionalNumberFormatting($std->vICMSEfet),
            false,
            "$identificador Valor do ICMS efetivo"
        );
        $this->aICMSST[$std->item] = $icmsST;
        return $icmsST;
    }

    /**
     * Tributação ICMS pelo Simples Nacional N10c pai N01
     * tag NFe/infNFe/det[]/imposto/ICMS/ICMSSN N10c pai N01
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = "N10c <ICMSSN> Item: $std->item -";
        //totalizador generico
        $this->stdTot->vFCPST += (float) !empty($std->vFCPST) ? $std->vFCPST : 0;
        $this->stdTot->vFCPSTRet += (float) !empty($std->vFCPSTRet) ? $std->vFCPSTRet : 0;
        switch ($std->CSOSN) {
            case '101':
                $icmsSN = $this->dom->createElement("ICMSSN101");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "$identificador Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $this->conditionalNumberFormatting($std->pCredSN, 2),
                    true,
                    "$identificador Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $this->conditionalNumberFormatting($std->vCredICMSSN),
                    true,
                    "$identificador Valor crédito do ICMS que pode ser aproveitado nos termos do"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "$identificador Código de Situação da Operação Simples Nacional"
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "$identificador Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP "
                    . "retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador Valor do FCP retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $this->conditionalNumberFormatting($std->pCredSN, 4),
                    false,
                    "$identificador Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $this->conditionalNumberFormatting($std->vCredICMSSN),
                    false,
                    "$identificador Valor crédito do ICMS que pode ser aproveitado nos "
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
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "$identificador Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $std->modBCST,
                    true,
                    "$identificador Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    true,
                    "$identificador Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    true,
                    "$identificador Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    true,
                    "$identificador Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP "
                    . "retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador Valor do FCP retido por Substituição Tributária"
                );
                break;
            case '500':
                $icmsSN = $this->dom->createElement("ICMSSN500");
                $this->dom->addChild(
                    $icmsSN,
                    'orig',
                    $std->orig,
                    true,
                    "$identificador Origem da mercadoria"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "$identificador Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCSTRet',
                    $this->conditionalNumberFormatting($std->vBCSTRet),
                    false,
                    "$identificador Valor da BC do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pST',
                    $this->conditionalNumberFormatting($std->pST, 4),
                    false,
                    "$identificador Alíquota suportada pelo Consumidor Final"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSSubstituto',
                    $this->conditionalNumberFormatting($std->vICMSSubstituto),
                    false,
                    "$identificador Valor do ICMS próprio do Substituto"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSSTRet',
                    $this->conditionalNumberFormatting($std->vICMSSTRet),
                    false,
                    "$identificador Valor do ICMS ST retido"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPSTRet',
                    $this->conditionalNumberFormatting($std->vBCFCPSTRet, 2),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP "
                    . "retido anteriormente por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPSTRet',
                    $this->conditionalNumberFormatting($std->pFCPSTRet, 4),
                    false,
                    "$identificador Percentual do FCP retido anteriormente por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPSTRet',
                    $this->conditionalNumberFormatting($std->vFCPSTRet),
                    false,
                    "$identificador Valor do FCP retido anteiormente por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCEfet',
                    $this->conditionalNumberFormatting($std->pRedBCEfet, 4),
                    false,
                    "$identificador Percentual de redução da base "
                    . "de cálculo efetiva"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCEfet',
                    $this->conditionalNumberFormatting($std->vBCEfet),
                    false,
                    "$identificador Valor da base de cálculo efetiva"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSEfet',
                    $this->conditionalNumberFormatting($std->pICMSEfet, 4),
                    false,
                    "$identificador Alíquota do ICMS efetiva"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSEfet',
                    $this->conditionalNumberFormatting($std->vICMSEfet),
                    false,
                    "$identificador Valor do ICMS efetivo"
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
                    "$identificador Origem da mercadoria",
                );
                $this->dom->addChild(
                    $icmsSN,
                    'CSOSN',
                    $std->CSOSN,
                    true,
                    "$identificador Código de Situação da Operação Simples Nacional"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBC',
                    $std->modBC,
                    false,
                    "$identificador Modalidade de determinação da BC do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBC',
                    $this->conditionalNumberFormatting($std->vBC),
                    false,
                    "$identificador Valor da BC do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBC',
                    $this->conditionalNumberFormatting($std->pRedBC, 4),
                    false,
                    "$identificador Percentual da Redução de BC"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMS',
                    $this->conditionalNumberFormatting($std->pICMS, 4),
                    false,
                    "$identificador Alíquota do imposto"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMS',
                    $this->conditionalNumberFormatting($std->vICMS),
                    false,
                    "$identificador Valor do ICMS"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'modBCST',
                    $std->modBCST,
                    false,
                    "$identificador Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pMVAST',
                    $this->conditionalNumberFormatting($std->pMVAST, 4),
                    false,
                    "$identificador Percentual da margem de valor Adicionado do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pRedBCST',
                    $this->conditionalNumberFormatting($std->pRedBCST, 4),
                    false,
                    "$identificador Percentual da Redução de BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCST',
                    $this->conditionalNumberFormatting($std->vBCST),
                    false,
                    "$identificador Valor da BC do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pICMSST',
                    $this->conditionalNumberFormatting($std->pICMSST, 4),
                    false,
                    "$identificador Alíquota do imposto do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vICMSST',
                    $this->conditionalNumberFormatting($std->vICMSST),
                    false,
                    "$identificador Valor do ICMS ST"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vBCFCPST',
                    $this->conditionalNumberFormatting($std->vBCFCPST),
                    false,
                    "$identificador Valor da Base de Cálculo do FCP "
                    . "retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pFCPST',
                    $this->conditionalNumberFormatting($std->pFCPST, 4),
                    false,
                    "$identificador Percentual do FCP retido por "
                    . "Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vFCPST',
                    $this->conditionalNumberFormatting($std->vFCPST),
                    false,
                    "$identificador Valor do FCP retido por Substituição Tributária"
                );
                $this->dom->addChild(
                    $icmsSN,
                    'pCredSN',
                    $this->conditionalNumberFormatting($std->pCredSN, 4),
                    false,
                    "$identificador Alíquota aplicável de cálculo do crédito (Simples Nacional)."
                );
                $this->dom->addChild(
                    $icmsSN,
                    'vCredICMSSN',
                    $this->conditionalNumberFormatting($std->vCredICMSSN),
                    false,
                    "$identificador Valor crédito do ICMS que pode ser aproveitado nos termos do"
                    . " art. 23 da LC 123 (Simples Nacional)"
                );
                break;
        }
        $this->aICMSSN[$std->item] = $icmsSN;
        return $icmsSN;
    }

    /**
     * Grupo ICMSUFDest NA01 pai M01
     * tag NFe/infNFe/det[]/imposto/ICMSUFDest (opcional)
     * Grupo a ser informado nas vendas interestaduais para consumidor final,
     * não contribuinte do ICMS
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = "NA01 <ICMSUFDest> Item: $std->item -";
        $this->stdTot->vICMSUFDest += (float) $std->vICMSUFDest;
        $this->stdTot->vFCPUFDest += (float) $std->vFCPUFDest;
        $this->stdTot->vICMSUFRemet += (float) 0;
        $icmsUFDest = $this->dom->createElement('ICMSUFDest');
        $this->dom->addChild(
            $icmsUFDest,
            "vBCUFDest",
            $this->conditionalNumberFormatting($std->vBCUFDest),
            true,
            "$identificador Valor da BC do ICMS na UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vBCFCPUFDest",
            $this->conditionalNumberFormatting($std->vBCFCPUFDest),
            false,
            "$identificador Valor da BC do ICMS na UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pFCPUFDest",
            $this->conditionalNumberFormatting($std->pFCPUFDest, 4),
            false,
            "$identificador Percentual do ICMS relativo ao Fundo de Combate à Pobreza (FCP) na UF de destino"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSUFDest",
            $this->conditionalNumberFormatting($std->pICMSUFDest, 4),
            true,
            "$identificador Alíquota interna da UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSInter",
            $this->conditionalNumberFormatting($std->pICMSInter, 2),
            true,
            "$identificador Alíquota interestadual das UF envolvidas"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "pICMSInterPart",
            100,
            true,
            "$identificador Percentual provisório de partilha entre os Estados"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vFCPUFDest",
            $this->conditionalNumberFormatting($std->vFCPUFDest),
            false,
            "$identificador Valor do ICMS relativo ao Fundo de Combate à Pobreza (FCP) da UF de destino"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vICMSUFDest",
            $this->conditionalNumberFormatting($std->vICMSUFDest),
            true,
            "$identificador Valor do ICMS de partilha para a UF do destinatário"
        );
        $this->dom->addChild(
            $icmsUFDest,
            "vICMSUFRemet",
            0,
            true,
            "$identificador Valor do ICMS de partilha para a UF do remetente"
        );
        $this->aICMSUFDest[$std->item] = $icmsUFDest;
        return $icmsUFDest;
    }
}
