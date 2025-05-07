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
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 */
trait TraitTagTotal
{
    /**
     * Grupo Totais referentes ao ICMS W02 pai W01
     * tag NFe/infNFe/total/ICMSTot
     * @param stdClass $std
     * @return DOMElement
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
        ];
        $std = $this->equilizeParameters($std, $possible);
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
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagISTot(stdClass $std): DOMElement
    {
        $possible = ['vIS'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "<ISTot> -";
        $istot = $this->dom->createElement('ISTot');
        $this->dom->addChild(
            $istot,
            "vIS",
            $this->conditionalNumberFormatting($std->vIS),
            true,
            "$identificador Valor Total do IS"
        );
        $this->ISTot = $istot;
        return $istot;
    }


    /**
     *
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
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "<IBSCBSTot> -";
        $ibstot = $this->dom->createElement('IBSCBSTot');
        $this->dom->addChild(
            $ibstot,
            "vBCIBSCBS",
            $this->conditionalNumberFormatting($std->vBCIBSCBS),
            true,
            "$identificador "
        );
        if (!empty($std->gIBS_vIBS)) {
            $gIBS = $this->dom->createElement('gIBS');
            $gIBSUF = $this->dom->createElement('gIBSUF');
            $this->dom->addChild(
                $gIBSUF,
                "vDif",
                $this->conditionalNumberFormatting($std->gIBSUF_vDif),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gIBSUF,
                "vDevTrib",
                $this->conditionalNumberFormatting($std->gIBSUF_vDevTrib),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gIBSUF,
                "vIBSUF",
                $this->conditionalNumberFormatting($std->gIBSUF_vIBSUF),
                true,
                "$identificador "
            );
            $this->dom->appChild($gIBS, $gIBSUF);
            $gIBSMun = $this->dom->createElement('gIBSMun');
            $this->dom->addChild(
                $gIBSMun,
                "vDif",
                $this->conditionalNumberFormatting($std->gIBSMun_vDif),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gIBSMun,
                "vDevTrib",
                $this->conditionalNumberFormatting($std->gIBSMun_vDevTrib),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gIBSMun,
                "vIBSMun",
                $this->conditionalNumberFormatting($std->gIBSMun_vIBSMun),
                true,
                "$identificador "
            );
            $this->dom->appChild($gIBS, $gIBSMun);
            $this->dom->addChild(
                $gIBS,
                "vIBS",
                $this->conditionalNumberFormatting($std->gIBS_vIBS),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gIBS,
                "vCredPres",
                $this->conditionalNumberFormatting($std->gIBS_vCredPres),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gIBS,
                "vCredPresCondSus",
                $this->conditionalNumberFormatting($std->gIBS_vCredPresCondSus),
                true,
                "$identificador "
            );
            $this->dom->appChild($ibstot, $gIBS);
        }
        if (!empty($std->gCBS_vDif)) {
            $gCBS = $this->dom->createElement('gCBS');
            $this->dom->addChild(
                $gCBS,
                "vDif",
                $this->conditionalNumberFormatting($std->gCBS_vDif),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gCBS,
                "vDevTrib",
                $this->conditionalNumberFormatting($std->gCBS_vDevTrib),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gCBS,
                "vCBS",
                $this->conditionalNumberFormatting($std->gCBS_vCBS),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gCBS,
                "vCredPres",
                $this->conditionalNumberFormatting($std->gCBS_vCredPres),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gCBS,
                "vCredPresCondSus",
                $this->conditionalNumberFormatting($std->gCBS_vCredPresCondSus),
                true,
                "$identificador "
            );
            $this->dom->appChild($ibstot, $gCBS);
        }
        if (!empty($std->gMono_vIBSMono)) {
            $gMono = $this->dom->createElement('gMono');
            $this->dom->addChild(
                $gMono,
                "vIBSMono",
                $this->conditionalNumberFormatting($std->gMono_vIBSMono),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gMono,
                "vCBSMono",
                $this->conditionalNumberFormatting($std->gMono_vCBSMono),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gMono,
                "vIBSMonoReten",
                $this->conditionalNumberFormatting($std->gMono_vIBSMonoReten),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gMono,
                "vCBSMonoReten",
                $this->conditionalNumberFormatting($std->gMono_vCBSMonoReten),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gMono,
                "vIBSMonoRet",
                $this->conditionalNumberFormatting($std->gMono_vIBSMonoRet),
                true,
                "$identificador "
            );
            $this->dom->addChild(
                $gMono,
                "vCBSMonoRet",
                $this->conditionalNumberFormatting($std->gMono_vCBSMonoRet),
                true,
                "$identificador "
            );
            $this->dom->appChild($ibstot, $gMono);
        }
        $this->IBSCBSTot = $ibstot;
        return $ibstot;
    }
}
