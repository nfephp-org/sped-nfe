<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property Dom $dom
 * @property DOMElement $ICMSTot
 * @property DOMElement $ISSQNTot
 * @property DOMElement $ISTot
 * @property DOMElement $IBSCBSTot
 * @property stdclass $stdIStot Totalizador
 * @property stdclass $stdTot Totalizador
 * @property stdclass $stdISSQNTot Totalizador
 * @property stdclass $stdIBSCBSTot Totalizador
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
 */
trait TraitTagTotal
{
    /**
     * Valor vNTTot
     * tag NFe/infNFe/total/vNFTot
     * @param stdClass $std
     * @return float
     */
    public function tagTotal(stdClass $std): float
    {
        $possible = ['vNFTot'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "W01 <vNFTot> -";
        $this->stdTot->vNFTot = ($std->vNFTot ?? 0);
        return $this->stdTot->vNFTot;
    }

    /**
     * Grupo Totais referentes ao ICMS W02 pai W01
     * tag NFe/infNFe/total/ICMSTot
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagICMSTot(stdClass $std): DOMElement
    {
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
            '$vTotTrib'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "W01 <ICMSTot> -";

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
            "$identificador Base de Cálculo do ICMS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMS",
            $this->conditionalNumberFormatting($vICMS),
            true,
            "$identificador Valor Total do ICMS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSDeson",
            $this->conditionalNumberFormatting($vICMSDeson),
            true,
            "$identificador Valor Total do ICMS desonerado"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFCPUFDest",
            $this->conditionalNumberFormatting($vFCPUFDest),
            false,
            "$identificador Valor total do ICMS relativo ao Fundo de Combate à Pobreza(FCP) "
            . "para a UF de destino"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSUFDest",
            $this->conditionalNumberFormatting($vICMSUFDest),
            false,
            "$identificador Valor total do ICMS de partilha para a UF do destinatário"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSUFRemet",
            $this->conditionalNumberFormatting($vICMSUFRemet),
            false,
            "$identificador Valor total do ICMS de partilha para a UF do remetente"
        );
        //incluso no layout 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vFCP",
            $this->conditionalNumberFormatting($vFCP),
            false,
            "$identificador Valor total do ICMS relativo ao Fundo de Combate à Pobreza(FCP) "
            . "para a UF de destino"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vBCST",
            $this->conditionalNumberFormatting($vBCST),
            true,
            "$identificador Base de Cálculo do ICMS ST"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vST",
            $this->conditionalNumberFormatting($vST),
            true,
            "$identificador Valor Total do ICMS ST"
        );
        //incluso na 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vFCPST",
            $this->conditionalNumberFormatting($vFCPST),
            false, //true para 4.00
            "$identificador Valor Total do FCP (Fundo de Combate à Pobreza) "
            . "retido por substituição tributária"
        );
        //incluso na 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vFCPSTRet",
            $this->conditionalNumberFormatting($vFCPSTRet),
            false, //true para 4.00
            "$identificador Valor Total do FCP retido anteriormente por "
            . "Substituição Tributária"
        );
        //incluso NT 2023.001-1.10
        $this->dom->addChild(
            $ICMSTot,
            "qBCMono",
            $this->conditionalNumberFormatting(!empty($qBCMono) ? $qBCMono : null),
            false,
            "$identificador Valor total da quantidade tributada do ICMS monofásico próprio"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSMono",
            $this->conditionalNumberFormatting(!empty($vICMSMono) ? $vICMSMono : null),
            false,
            "$identificador Valor total do ICMS monofásico próprio"
        );
        $this->dom->addChild(
            $ICMSTot,
            "qBCMonoReten",
            $this->conditionalNumberFormatting(!empty($qBCMonoReten) ? $qBCMonoReten : null),
            false,
            "$identificador Valor total da quantidade tributada do ICMS monofásico sujeito a retenção"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSMonoReten",
            $this->conditionalNumberFormatting(!empty($vICMSMonoReten) ? $vICMSMonoReten : null),
            false,
            "$identificador Valor total do ICMS monofásico sujeito a retenção"
        );
        $this->dom->addChild(
            $ICMSTot,
            "qBCMonoRet",
            $this->conditionalNumberFormatting(!empty($qBCMonoRet) ? $qBCMonoRet : null),
            false,
            "$identificador Valor total da quantidade tributada do ICMS monofásico retido anteriormente"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vICMSMonoRet",
            $this->conditionalNumberFormatting(!empty($vICMSMonoRet) ? $vICMSMonoRet : null),
            false,
            "$identificador Valor total do ICMS monofásico retido anteriormente"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vProd",
            $this->conditionalNumberFormatting($vProd),
            true,
            "$identificador Valor Total dos produtos e serviços"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vFrete",
            $this->conditionalNumberFormatting($vFrete),
            true,
            "$identificador Valor Total do Frete"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vSeg",
            $this->conditionalNumberFormatting($vSeg),
            true,
            "$identificador Valor Total do Seguro"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vDesc",
            $this->conditionalNumberFormatting($vDesc),
            true,
            "$identificador Valor Total do Desconto"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vII",
            $this->conditionalNumberFormatting($vII),
            true,
            "$identificador Valor Total do II"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vIPI",
            $this->conditionalNumberFormatting($vIPI),
            true,
            "$identificador Valor Total do IPI"
        );
        //incluso 4.00
        $this->dom->addChild(
            $ICMSTot,
            "vIPIDevol",
            $this->conditionalNumberFormatting($vIPIDevol),
            false,
            "$identificador Valor Total do IPI"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vPIS",
            $this->conditionalNumberFormatting($vPIS),
            true,
            "$identificador Valor do PIS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vCOFINS",
            $this->conditionalNumberFormatting($vCOFINS),
            true,
            "$identificador Valor da COFINS"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vOutro",
            $this->conditionalNumberFormatting($vOutro),
            true,
            "$identificador Outras Despesas acessórias"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vNF",
            $this->conditionalNumberFormatting($vNF),
            true,
            "$identificador Valor Total da NF-e"
        );
        $this->dom->addChild(
            $ICMSTot,
            "vTotTrib",
            $this->conditionalNumberFormatting($vTotTrib),
            false,
            "$identificador Valor aproximado total de tributos federais, estaduais e municipais."
        );
        $this->ICMSTot = $ICMSTot;
        return $ICMSTot;
    }

    /**
     * Grupo Totais referentes ao ISSQN W17 pai W01
     * tag NFe/infNFe/total/ISSQNTot (opcional)
     * @param stdClass|null $std
     * @return DOMElement|false
     * @throws DOMException
     */
    public function tagISSQNTot(?stdClass $std = null)
    {
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
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "W17 <ISSQNTot> -";
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
            $this->conditionalNumberFormatting($vServ, 2),
            false,
            "$identificador Valor total dos Serviços sob não incidência ou não tributados pelo ICMS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vBC",
            $this->conditionalNumberFormatting($vBC, 2),
            false,
            "$identificador Valor total Base de Cálculo do ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vISS",
            $this->conditionalNumberFormatting($vISS, 2),
            false,
            "$identificador Valor total do ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vPIS",
            $this->conditionalNumberFormatting($vPIS, 2),
            false,
            "$identificador Valor total do PIS sobre serviços"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vCOFINS",
            $this->conditionalNumberFormatting($vCOFINS, 2),
            false,
            "$identificador Valor total da COFINS sobre serviços"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "dCompet",
            $dCompet,
            true,
            "$identificador Data da prestação do serviço"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDeducao",
            $this->conditionalNumberFormatting($vDeducao, 2),
            false,
            "$identificador Valor total dedução para redução da Base de Cálculo"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vOutro",
            $this->conditionalNumberFormatting($vOutro, 2),
            false,
            "$identificador Valor total outras retenções"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDescIncond",
            $this->conditionalNumberFormatting($vDescIncond, 2),
            false,
            "$identificador Valor total desconto incondicionado"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vDescCond",
            $this->conditionalNumberFormatting($vDescCond, 2),
            false,
            "$identificador Valor total desconto condicionado"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "vISSRet",
            $this->conditionalNumberFormatting($vISSRet, 2),
            false,
            "$identificador Valor total retenção ISS"
        );
        $this->dom->addChild(
            $ISSQNTot,
            "cRegTrib",
            $cRegTrib,
            false,
            "$identificador Código do Regime Especial de Tributação"
        );
        $this->ISSQNTot = $ISSQNTot;
        return $ISSQNTot;
    }

    /**
     * Grupo total do imposto seletivo
     * total/ISTot
     * 2025.002_v1.30 - PL_010_V1.30
     * @param stdClass|null $std
     * @return DOMElement|false
     * @param stdClass $std
     * @return ?DOMElement
     * @throws DOMException
     */
    public function tagISTot(stdClass $std): ?DOMElement
    {
        $possible = ['vIS'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "W31 ISTot -";
        $vIS = $std->vIS ?? ($this->stdIStot->vIS ?? 0);
        $this->stdTot->vIS = $vIS;
        if (empty($vIS)) {
            return null;
        }
        $istot = $this->dom->createElement('ISTot');
        $this->dom->addChild(
            $istot,
            "vIS",
            $this->conditionalNumberFormatting($vIS, 2),
            true,
            "$identificador Valor Total do IS"
        );
        $this->ISTot = $istot;
        return $istot;
    }

    /**
     * Totais da NF-e com IBS e CBS
     * infNFe/total/IBSCBSTot
     * NT 2025.002_v1.30 - PL_010_V1.30
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagIBSCBSTot(stdClass $std): DOMElement
    {
        $possible = [
            'vBCIBSCBS',
            'gIBS_vIBS',
            'gIBS_vCredPres',
            'gIBS_vCredPresCondSus',
            'gIBSUF_vDif',
            'gIBSUF_vDevTrib',
            'gIBSUF_vIBSUF',
            'gIBSMun_vDif',
            'gIBSMun_vDevTrib',
            'gIBSMun_vIBSMun',
            'gCBS_vDif',
            'gCBS_vDevTrib',
            'gCBS_vCBS',
            'gCBS_vCredPres',
            'gCBS_vCredPresCondSus',
            'gMono_vIBSMono',
            'gMono_vCBSMono',
            'gMono_vIBSMonoReten',
            'gMono_vCBSMonoReten',
            'gMono_vIBSMonoRet',
            'gMono_vCBSMonoRet',
            'gEstonoCred_vIBSEstCred',
            'gEstonoCred_vCBSEstCred',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "W34 IBSCBSTot -";

        $vBCIBSCBS = $std->vBCIBSCBS ?? $this->stdIBSCBSTot->vBCIBSCBS;
        $gIBS_vIBS = $std->gIBS_vIBS ?? $this->stdIBSCBSTot->vIBS;
        $gIBS_vCredPres = $std->gIBS_vCredPres ?? $this->stdIBSCBSTot->vCredPres;
        $gIBS_vCredPresCondSus = $std->gIBS_vCredPresCondSus ?? $this->stdIBSCBSTot->vCredPresCondSus;
        $gIBSUF_vDif = $std->gIBSUF_vDif ?? $this->stdIBSCBSTot->gIBSUF->vDif;
        $gIBSUF_vDevTrib = $std->gIBSUF_vDevTrib ?? $this->stdIBSCBSTot->gIBSUF->vDevTrib;
        $gIBSUF_vIBSUF = $std->gIBSUF_vIBSUF ?? $this->stdIBSCBSTot->gIBSUF->vIBSUF;
        $gIBSMun_vDif = $std->gIBSMun_vDif ?? $this->stdIBSCBSTot->gIBSMun->vDif;
        $gIBSMun_vDevTrib = $std->gIBSMun_vDevTrib ?? $this->stdIBSCBSTot->gIBSMun->vDevTrib;
        $gIBSMun_vIBSMun = $std->gIBSMun_vIBSMun ?? $this->stdIBSCBSTot->gIBSMun->vIBSMun;
        $gCBS_vDif = $std->gCBS_vDif ?? $this->stdIBSCBSTot->gCBS->vDif;
        $gCBS_vDevTrib = $std->gCBS_vDevTrib ?? $this->stdIBSCBSTot->gCBS->vDevTrib;
        $gCBS_vCBS = $std->gCBS_vCBS ?? $this->stdIBSCBSTot->vCBS;
        $gCBS_vCredPres = $std->gCBS_vCredPres ?? $this->stdIBSCBSTot->vCredPres;
        $gCBS_vCredPresCondSus = $std->gCBS_vCredPresCondSus ?? $this->stdIBSCBSTot->vCredPresCondSus;
        $gMono_vIBSMono = $std->gMono_vIBSMono ?? $this->stdIBSCBSTot->gMono->vIBSMono;
        $gMono_vCBSMono = $std->gMono_vCBSMono ?? $this->stdIBSCBSTot->gMono->vCBSMono;
        $gMono_vIBSMonoReten = $std->gMono_vIBSMonoReten ?? $this->stdIBSCBSTot->gMono->vIBSMonoReten;
        $gMono_vCBSMonoReten = $std->gMono_vCBSMonoReten ?? $this->stdIBSCBSTot->gMono->vCBSMonoReten;
        $gMono_vIBSMonoRet = $std->gMono_vIBSMonoRet ?? $this->stdIBSCBSTot->gMono->vIBSMonoRet;
        $gMono_vCBSMonoRet = $std->gMono_vCBSMonoRet ?? $this->stdIBSCBSTot->gMono->vCBSMonoRet;
        $gEstornoCred_vIBSEstCred = $std->gEstonoCred_vIBSEstCred ?? $this->stdIBSCBSTot->gEstornoCred->vIBSEstCred;
        $gEstornoCred_vCBSEstCred = $std->gEstonoCred_vCBSEstCred ?? $this->stdIBSCBSTot->gEstornoCred->vCBSEstCred;

        //totalizador final
        $this->stdTot->vIBS = $gIBS_vIBS;
        $this->stdTot->vCBS = $gCBS_vCBS;

        $ibstot = $this->dom->createElement('IBSCBSTot');
        $this->dom->addChild(
            $ibstot,
            "vBCIBSCBS",
            $this->conditionalNumberFormatting($vBCIBSCBS),
            true,
            "$identificador Valor total da BC do IBS e da CBS"
        );
        if (!empty($gIBS_vIBS)) {
            $gIBS = $this->dom->createElement('gIBS');
            $gIBSUF = $this->dom->createElement('gIBSUF');
            $this->dom->addChild(
                $gIBSUF,
                "vDif",
                $this->conditionalNumberFormatting($gIBSUF_vDif),
                true,
                "$identificador Valor total do diferimento (gIBSUF/vDif)"
            );
            $this->dom->addChild(
                $gIBSUF,
                "vDevTrib",
                $this->conditionalNumberFormatting($gIBSUF_vDevTrib),
                true,
                "$identificador Valor total de devolução de tributos (gIBSUF/vDevTrib)"
            );
            $this->dom->addChild(
                $gIBSUF,
                "vIBSUF",
                $this->conditionalNumberFormatting($gIBSUF_vIBSUF),
                true,
                "$identificador Valor total do IBS da UF (gIBSUF/vIBSUF)"
            );
            $gIBS->appendChild($gIBSUF);
            $gIBSMun = $this->dom->createElement('gIBSMun');
            $this->dom->addChild(
                $gIBSMun,
                "vDif",
                $this->conditionalNumberFormatting($gIBSMun_vDif),
                true,
                "$identificador Valor total do diferimento (gIBSMun/vDif)"
            );
            $this->dom->addChild(
                $gIBSMun,
                "vDevTrib",
                $this->conditionalNumberFormatting($gIBSMun_vDevTrib),
                true,
                "$identificador Valor total de devolução de tributos (gIBSMun/vDevTrib)"
            );
            $this->dom->addChild(
                $gIBSMun,
                "vIBSMun",
                $this->conditionalNumberFormatting($gIBSMun_vIBSMun),
                true,
                "$identificador Valor total do IBS do Município (gIBSMun/vIBSMun)"
            );
            $gIBS->appendChild($gIBSMun);
            $this->dom->addChild(
                $gIBS,
                "vIBS",
                $this->conditionalNumberFormatting($gIBS_vIBS),
                true,
                "$identificador Valor total do IBS"
            );
            $this->dom->addChild(
                $gIBS,
                "vCredPres",
                $this->conditionalNumberFormatting($gIBS_vCredPres),
                true,
                "$identificador Valor total do crédito presumido"
            );
            $this->dom->addChild(
                $gIBS,
                "vCredPresCondSus",
                $this->conditionalNumberFormatting($gIBS_vCredPresCondSus),
                true,
                "$identificador Valor total do crédito presumido em condição suspensiva."
            );
            $ibstot->appendChild($gIBS);
        }
        if (!empty($gCBS_vCBS)) {
            $gCBS = $this->dom->createElement('gCBS');
            $this->dom->addChild(
                $gCBS,
                "vDif",
                $this->conditionalNumberFormatting($gCBS_vDif),
                true,
                "$identificador Valor total do crédito presumido (gCBS/vDif)"
            );
            $this->dom->addChild(
                $gCBS,
                "vDevTrib",
                $this->conditionalNumberFormatting($gCBS_vDevTrib),
                true,
                "$identificador Valor total de devolução de tributos (gCBS/vDevTrib)"
            );
            $this->dom->addChild(
                $gCBS,
                "vCBS",
                $this->conditionalNumberFormatting($gCBS_vCBS),
                true,
                "$identificador Valor total da CBS (gCBS/vCBS)"
            );
            $this->dom->addChild(
                $gCBS,
                "vCredPres",
                $this->conditionalNumberFormatting($gCBS_vCredPres),
                true,
                "$identificador Valor total do crédito presumido (gCBS/vCrePres)"
            );
            $this->dom->addChild(
                $gCBS,
                "vCredPresCondSus",
                $this->conditionalNumberFormatting($gCBS_vCredPresCondSus),
                true,
                "$identificador Valor total do crédito presumido em condição suspensiva. (gCBS/vCrePresCondSus)"
            );
            $ibstot->appendChild($gCBS);
        }
        if (!empty($gMono_vIBSMono) || !empty($gMono_vCBSMono)) {
            $gMono = $this->dom->createElement('gMono');
            $this->dom->addChild(
                $gMono,
                "vIBSMono",
                $this->conditionalNumberFormatting($gMono_vIBSMono),
                true,
                "$identificador Total do IBS monofásico"
            );
            $this->dom->addChild(
                $gMono,
                "vCBSMono",
                $this->conditionalNumberFormatting($gMono_vCBSMono),
                true,
                "$identificador Total da CBS monofásica"
            );
            $this->dom->addChild(
                $gMono,
                "vIBSMonoReten",
                $this->conditionalNumberFormatting($gMono_vIBSMonoReten),
                true,
                "$identificador Total do IBS monofásico sujeito a retenção"
            );
            $this->dom->addChild(
                $gMono,
                "vCBSMonoReten",
                $this->conditionalNumberFormatting($gMono_vCBSMonoReten),
                true,
                "$identificador Total da CBS monofásica sujeita a retenção"
            );
            $this->dom->addChild(
                $gMono,
                "vIBSMonoRet",
                $this->conditionalNumberFormatting($gMono_vIBSMonoRet),
                true,
                "$identificador Total do IBS monofásico retido anteriormente"
            );
            $this->dom->addChild(
                $gMono,
                "vCBSMonoRet",
                $this->conditionalNumberFormatting($gMono_vCBSMonoRet),
                true,
                "$identificador Total da CBS monofásica retida anteriormente"
            );
            $ibstot->appendChild($gMono);
        }
        //NT 2025.002_v1.30 - PL_010_V1.30
        if (!empty($gEstornoCred_vIBSEstCred) || !empty($gEstornoCred_vCBSEstCred)) {
            $gEst = $this->dom->createElement('gEstornoCred');
            $this->dom->addChild(
                $gEst,
                "vIBSEstCred",
                $this->conditionalNumberFormatting($gEstornoCred_vIBSEstCred),
                true,
                "$identificador Valor total do IBS estornado (vIBSEstCred)"
            );
            $this->dom->addChild(
                $gEst,
                "vCBSEstCred",
                $this->conditionalNumberFormatting($gEstornoCred_vCBSEstCred),
                true,
                "$identificador Valor total do CBS estornado (vCBSEstCred)"
            );
            $ibstot->appendChild($gEst);
        }
        $this->IBSCBSTot = $ibstot;
        return $ibstot;
    }

    /**
     * Grupo Retenções de Tributos W23 pai W01
     * tag NFe/infNFe/total/reTrib (opcional)
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        $identificador = "W23 retTrib -";
        $retTrib = $this->dom->createElement("retTrib");
        $this->dom->addChild(
            $retTrib,
            "vRetPIS",
            $this->conditionalNumberFormatting($std->vRetPIS),
            false,
            "$identificador Valor Retido de PIS"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetCOFINS",
            $this->conditionalNumberFormatting($std->vRetCOFINS),
            false,
            "$identificador Valor Retido de COFINS"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetCSLL",
            $this->conditionalNumberFormatting($std->vRetCSLL),
            false,
            "$identificador Valor Retido de CSLL"
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
            "$identificador Valor Retido do IRRF"
        );
        $this->dom->addChild(
            $retTrib,
            "vBCRetPrev",
            $this->conditionalNumberFormatting($std->vBCRetPrev),
            false,
            "$identificador Base de Cálculo da Retenção da Previdência Social"
        );
        $this->dom->addChild(
            $retTrib,
            "vRetPrev",
            $this->conditionalNumberFormatting($std->vRetPrev),
            false,
            "$identificador Valor da Retenção da Previdência Social"
        );
        $this->retTrib = $retTrib;
        return $retTrib;
    }
}
