<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved;
use stdClass;
use DOMElement;

/**
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal)
 * @property DOMImproved $dom
 * @property array $aIBSCBS
 * @property array $aIBSMun
 * @property array $aIBSCBSMono
 * @property array $aIBSCredPres
 * @property stdClass $stdTot
 */
trait TraitTagDetIBSCBS
{
    /**
     * Informações do Imposto de Bens e Serviços - IBS e da Contribuição de Bens e Serviços - CBS
     * UB12 pai H01
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagIBSCBS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CST',
            'cClassTrib',
            'vBC',
            'pIBSUF',
            'pTribOP',
            'pDif',
            'vDif',
            'vDevTrib',
            'pRedAliq',
            'pAliqEfet',
            'CSTReg',
            'cClassTribReg',
            'pAliqEfetReg',
            'vTribReg',
            'vIBSUF'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $ibscbs = $this->dom->createElement("IBSCBS");
        $this->dom->addChild(
            $ibscbs,
            (string) "CST",
            $std->CST,
            false,
            "[item $std->item] Código de Situação Tributária do IBS e CBS"
        );
        $this->dom->addChild(
            $ibscbs,
            (string) "cClassTrib",
            $std->cClassTrib,
            false,
            "[item $std->item] Código de Classificação Tributária do IBS e CBS"
        );
        $gIBSCBS = $this->dom->createElement("gIBSCBS");
        $this->dom->addChild(
            $gIBSCBS,
            (string) "vBC",
            $this->conditionalNumberFormatting($std->vBC, 4),
            true,
            "[item $std->item] Base de cálculo do IBS e CBS"
        );
        $gIBSUF = $this->dom->createElement("gIBSUF");
        $this->dom->addChild(
            $gIBSUF,
            (string) "pIBSUF",
            $this->conditionalNumberFormatting($std->pIBSUF, 4),
            true,
            "[item $std->item] Alíquota do IBS de competência das UF"
        );
        $this->dom->addChild(
            $gIBSUF,
            (string) "vTribOP",
            $this->conditionalNumberFormatting($std->vTribOP, 2),
            true,
            "[item $std->item] Valor bruto do tributo na operação (vTribOP)"
        );
        if (!empty($std->pDif)) {
            $gDif = $this->dom->createElement("gDif");
            $this->dom->addChild(
                $gDif,
                (string)"pDif",
                $this->conditionalNumberFormatting($std->pDif, 4),
                true,
                "[item $std->item] Percentual do diferimento (pDif)"
            );
            $this->dom->addChild(
                $gDif,
                (string)"vDif",
                $this->conditionalNumberFormatting($std->vDif, 2),
                true,
                "[item $std->item] Valor do diferimento (vDif)"
            );
            $gIBSUF->appendChild($gDif);
        }
        if (!empty($std->vDevTrib)) {
            //Grupo de Informações da devolução de tributos
            $gDevTrib = $this->dom->createElement("gDevTrib");
            $this->dom->addChild(
                $gDevTrib,
                (string)"vDevTrib",
                $this->conditionalNumberFormatting($std->vDevTrib, 2),
                true,
                "[item $std->item] Valor do tributo devolvido (vDevTrib)"
            );
            $gIBSUF->appendChild($gDevTrib);
        }
        if (!empty($std->pRedAliq)) {
            //Grupo de informações da redução da alíquota
            $gRed = $this->dom->createElement("gRed");
            $this->dom->addChild(
                $gRed,
                (string)"pRedAliq",
                $this->conditionalNumberFormatting($std->pRedAliq, 4),
                true,
                "[item $std->item] Percentual da redução de alíquota (pRedAliq)"
            );
            $this->dom->addChild(
                $gRed,
                (string)"pAliqEfet",
                $this->conditionalNumberFormatting($std->pAliqEfet, 4),
                true,
                "[item $std->item] Alíquota Efetiva do IBS de competência das UF "
                    . "que será aplicada a Base de Cálculo (pAliqEfet)"
            );
            $gIBSUF->appendChild($gRed);
        }
        if (!empty($std->CSTReg)) {
            //Grupo de informações da Tributação Regular
            $gTribRegular = $this->dom->createElement("gTribRegular");
            $this->dom->addChild(
                $gTribRegular,
                (string)"CSTReg",
                $std->CSTReg,
                true,
                "[item $std->item] Código de Situação Tributária do IBS e CBS (CSTReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"cClassTribReg",
                $std->cClassTribReg,
                true,
                "[item $std->item] Código de Classificação Tributária do IBS e CBS (cClassTribReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"pAliqEfetReg",
                $this->conditionalNumberFormatting($std->pAliqEfetReg, 4),
                true,
                "[item $std->item] Valor da alíquota (pAliqEfetReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"vTribReg",
                $this->conditionalNumberFormatting($std->vTribReg, 2),
                true,
                "[item $std->item] Valor do Tributo (IBS) (vTribReg)"
            );
            $gIBSUF->appendChild($gTribRegular);
        }
        $this->dom->addChild(
            $gIBSUF,
            (string) "vIBSUF",
            $this->conditionalNumberFormatting($std->vIBSUF, 2),
            true,
            "[item $std->item] Valor do IBS de competência da UF (vIBSUF)"
        );
        $gIBSCBS->appendChild($gIBSUF);
        $ibscbs->appendChild($gIBSCBS);
        $this->aIBSCBS[$std->item] = $ibscbs;
        return $ibscbs;
    }

    /**
     * Grupo de Informações da CBS UB60 pai UB15
     *
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function taggCBS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'pCBS',
            'vTribOp',
            'cCredPres',
            'pCredPres',
            'vCredPres',
            'vCredPresCondSus',
            'pDif',
            'vDif',
            'vDevTrib',
            'pRedAliq',
            'pAliqEft',
            'CSTReg',
            'cClassTribReg',
            'pAliqEfetReg',
            'vTribReg',
            'vCBS',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $gCBS = $this->dom->createElement("gCBS");
        $this->dom->addChild(
            $gCBS,
            (string)"pCBS",
            $this->conditionalNumberFormatting($std->pCBS, 4),
            true,
            "[item $std->item] Alíquota da CBS (pCBS)"
        );
        $this->dom->addChild(
            $gCBS,
            (string)"vTribOp",
            $this->conditionalNumberFormatting($std->vTribOp, 2),
            false,
            "[item $std->item] Valor bruto do tributo na operação (vTribOp)"
        );
        if (!empty($std->cCredPres)) {
            $gCBSCredPres = $this->dom->createElement("gCBSCredPres");
            $this->dom->addChild(
                $gCBSCredPres,
                (string)"cCredPres",
                $std->cCredPres,
                true,
                "[item $std->item] Código de Classificação do Crédito Presumido (cCredPres)"
            );
            $this->dom->addChild(
                $gCBSCredPres,
                (string)"pCredPres",
                $this->conditionalNumberFormatting($std->pCredPres, 4),
                true,
                "[item $std->item] Percentual do Crédito Presumido (pCredPres)"
            );
            $this->dom->addChild(
                $gCBSCredPres,
                (string)"vCredPres",
                $this->conditionalNumberFormatting($std->vCredPres, 2),
                true,
                "[item $std->item] Valor do Crédito Presumido (vCredPres)"
            );
            $this->dom->addChild(
                $gCBSCredPres,
                (string)"vCredPresCondSus",
                $this->conditionalNumberFormatting($std->vCredPresCondSus, 2),
                true,
                "[item $std->item] Valor do Crédito Presumido em condição suspensiva (vCredPres)"
            );
            if (!empty($std->pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    (string)"pDif",
                    $this->conditionalNumberFormatting($std->pDif, 4),
                    true,
                    "[item $std->item] Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    (string)"vDif",
                    $this->conditionalNumberFormatting($std->vDif, 2),
                    true,
                    "[item $std->item] Valor do diferimento (vDif)"
                );
                $gCBSCredPres->appendChild($gDif);
            }
            if (!empty($std->vDevTrib)) {
                $gDevTrib = $this->dom->createElement("gDevTrib");
                $this->dom->addChild(
                    $gDevTrib,
                    (string)"vDevTrib",
                    $this->conditionalNumberFormatting($std->vDevTrib, 2),
                    true,
                    "[item $std->item] Valor do tributo devolvido (vDevTrib)"
                );
                $gCBSCredPres->appendChild($gDevTrib);
            }
            $gCBS->appendChild($gCBSCredPres);
        }
        if (!empty($std->pRedAliq)) {
            $gRed = $this->dom->createElement("gRed");
            $this->dom->addChild(
                $gRed,
                (string)"pRedAliq",
                $this->conditionalNumberFormatting($std->pRedAliq, 2),
                true,
                "[item $std->item] Percentual da redução de alíquota (pRedAliq)"
            );
            $this->dom->addChild(
                $gRed,
                (string)"pAliqEfet",
                $this->conditionalNumberFormatting($std->pAliqEfet, 2),
                true,
                "[item $std->item] Alíquota Efetiva da CBS que será aplicada a Base de Cálculo (pAliqEfet)"
            );
            $gCBS->appendChild($gRed);
        }
        if (!empty($std->CSTReg)) {
            $gTribRegular = $this->dom->createElement("gTribRegular");
            $this->dom->addChild(
                $gTribRegular,
                (string)"CSTReg",
                $std->CSTReg,
                true,
                "[item $std->item] Código de Situação Tributária do IBS e CBS (CSTReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"cClassTribReg",
                $std->cClassTribReg,
                true,
                "[item $std->item] Código de Classificação Tributária do IBS e CBS (cClassTribReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"pAliqEfetReg",
                $std->pAliqEfetReg,
                true,
                "[item $std->item] Valor da alíquota (pAliqEfetReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"vTribReg",
                $std->vTribReg,
                true,
                "[item $std->item] Valor do Tributo (CBS) (vTribReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"vCBS",
                $std->vCBS,
                true,
                "[item $std->item] Valor da CBS (vCBS)"
            );
            $gCBS->appendChild($gTribRegular);
        }
        $this->aCBS[$std->item] = $gCBS;
        return $gCBS;
    }

    /**
     * Grupo de Informações do IBS para o município UB36 pai UB15
     * Dentro de aIBSCBS[$item]/gIBSCBS
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function taggIBSMun(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'pIBSMun',
            'vTribOP',
            'pDif',
            'vDif',
            'vDevTrib',
            'pRedAliq',
            'pAliqEfet',
            'CSTReg',
            'cClassTribReg',
            'pAliqEfetReg',
            'vIBSMun',
        ];
        $std = $this->equilizeParameters($std, $possible);
        //Grupo de Informações do IBS para o município
        $gIBSMun = $this->dom->createElement("gIBSMun");
        $this->dom->addChild(
            $gIBSMun,
            (string)"pIBSMun",
            $this->conditionalNumberFormatting($std->pIBSMun, 2),
            true,
            "[item $std->item] Alíquota do IBS de competência do Município (pIBSMun)"
        );
        $this->dom->addChild(
            $gIBSMun,
            (string)"vTribOP",
            $this->conditionalNumberFormatting($std->vTribOP, 2),
            false,
            "[item $std->item] Valor bruto do tributo na operação (vTribOP)"
        );
        if (!empty($std->pDif)) {
            $gDif = $this->dom->createElement("gDif");
            $this->dom->addChild(
                $gDif,
                (string)"pDif",
                $this->conditionalNumberFormatting($std->pDif, 4),
                true,
                "[item $std->item] Percentual do diferimento (pDif)"
            );
            $this->dom->addChild(
                $gDif,
                (string)"vDif",
                $this->conditionalNumberFormatting($std->vDif, 2),
                true,
                "[item $std->item] Valor do diferimento (vDif)"
            );
            $gIBSMun->appendChild($gDif);
        }
        if (!empty($std->vDevTrib)) {
            //Grupo de Informações da devolução de tributos
            $gDevTrib = $this->dom->createElement("gDevTrib");
            $this->dom->addChild(
                $gDevTrib,
                (string)"vDevTrib",
                $this->conditionalNumberFormatting($std->vDevTrib, 2),
                true,
                "[item $std->item] Valor do tributo devolvido (vDevTrib)"
            );
            $gIBSMun->appendChild($gDevTrib);
        }
        if (!empty($std->pRedAliq)) {
            //Grupo de informações da redução da alíquota
            $gRed = $this->dom->createElement("gRed");
            $this->dom->addChild(
                $gRed,
                (string)"pRedAliq",
                $this->conditionalNumberFormatting($std->pRedAliq, 4),
                true,
                "[item $std->item] Percentual da redução de alíquota (pRedAliq)"
            );
            $this->dom->addChild(
                $gRed,
                (string)"pAliqEfet",
                $this->conditionalNumberFormatting($std->pAliqEfet, 4),
                true,
                "[item $std->item] Alíquota Efetiva do IBS de competência das UF que será aplicada "
                    . "a Base de Cálculo (pAliqEfet)"
            );
            $gIBSMun->appendChild($gRed);
        }
        if (!empty($std->CSTReg)) {
            //Grupo de informações da Tributação Regular
            $gTribRegular = $this->dom->createElement("gTribRegular");
            $this->dom->addChild(
                $gTribRegular,
                (string)"CSTReg",
                $std->CSTReg,
                true,
                "[item $std->item] Código de Situação Tributária do IBS e CBS (CSTReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"cClassTribReg",
                $std->cClassTribReg,
                true,
                "[item $std->item] Código de Classificação Tributária do IBS e CBS (cClassTribReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"pAliqEfetReg",
                $this->conditionalNumberFormatting($std->pAliqEfetReg, 4),
                true,
                "[item $std->item] Valor da alíquota (pAliqEfetReg)"
            );
            $this->dom->addChild(
                $gTribRegular,
                (string)"vTribReg",
                $this->conditionalNumberFormatting($std->vTribReg, 2),
                true,
                "[item $std->item] Valor do Tributo (IBS) (vTribReg)"
            );
            $gIBSMun->appendChild($gTribRegular);
        }
        $this->dom->addChild(
            $gIBSMun,
            (string)"vIBSMun",
            $this->conditionalNumberFormatting($std->vIBSMun, 2),
            true,
            "[item $std->item] Valor do IBS de competência do Município (vIBSMun)"
        );
        $this->taggIBSMun[$std->item] = $gIBSMun;
        return $gIBSMun;
    }

    /**
     * Grupo de Informações do Crédito Presumido referente ao IBS UB55 pai UB15
     * $this->aIBSCBS[$item]/gIBSCBS
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function taggIBSCredPres(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'cCredPres',
            'pCredPres',
            'vCredPres',
            'vCredPresCondSus',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $gIBSCredPres = $this->dom->createElement("gIBSCredPres");
        $this->dom->addChild(
            $gIBSCredPres,
            (string) "cCredPres",
            $std->cCredPres,
            true,
            "[item $std->item] Código de Classificação do Crédito Presumido (cCredPres)"
        );
        $this->dom->addChild(
            $gIBSCredPres,
            (string) "pCredPres",
            $this->conditionalNumberFormatting($std->pCredPres, 4),
            true,
            "[item $std->item] Percentual do Crédito Presumido (pCredPres)"
        );
        $this->dom->addChild(
            $gIBSCredPres,
            (string) "vCredPres",
            $this->conditionalNumberFormatting($std->vCredPres, 2),
            true,
            "[item $std->item] Valor do Crédito Presumido (vCredPres)"
        );
        $this->dom->addChild(
            $gIBSCredPres,
            (string) "vCredPresCondSus",
            $this->conditionalNumberFormatting($std->vCredPresCondSus, 2),
            true,
            "[item $std->item] Valor do Crédito Presumido em condição suspensiva. (vCredPres)"
        );
        $this->aIBSCredPres[$std->item] = $gIBSCredPres;
        return $gIBSCredPres;
    }

    /**
     * Grupo o IBS e CBS em operações com imposto monofásico (Combustiveis) UB84 pai UB12
     * $this->aIBSCBS[$item] ->append($this->aIBSCBSMono[$item])
     * @param stdClass $std
     * @return DOMElement
     * @throws \DOMException
     */
    public function tagIBSCBSMono(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'qBCMono',
            'adRemIBS',
            'adRemCBS',
            'vIBSMono',
            'vCBSMono',
            'qBCMonoReten',
            'adRemIBSReten',
            'vIBSMonoReten',
            'adRemCBSReten',
            'vCBSMonoReten',
            'qBCMonoReten',
            'adRemIBSRet',
            'vIBSMonoRet',
            'adRemCBSRet',
            'vCBSMonoRet',
            'pDifIBS',
            'vIBSMonoDif',
            'pDifCBS',
            'vCBSMonoDif',
            'vTotIBSMonoItem',
            'vTotCBSMonoItem'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $gIBSCBSMono = $this->dom->createElement("gIBSCBSMono");
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "qBCMono",
            $this->conditionalNumberFormatting($std->qBCMono, 4),
            false,
            "[item $std->item] Quantidade tributada na monofasia"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "adRemIBS",
            $this->conditionalNumberFormatting($std->adRemIBS),
            true,
            "[item $std->item] Alíquota ad rem do IBS"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "adRemCBS",
            $this->conditionalNumberFormatting($std->adRemCBS),
            true,
            "[item $std->item] Alíquota ad rem do CBS"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "vIBSMono",
            $this->conditionalNumberFormatting($std->vIBSMono),
            true,
            "[item $std->item] Valor do IBS monofásico"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "vCBSMono",
            $this->conditionalNumberFormatting($std->vCBSMono),
            true,
            "[item $std->item] Valor do CBS monofásico"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "qBCMonoReten",
            $this->conditionalNumberFormatting($std->qBCMonoReten),
            false,
            "[item $std->item] Quantidade tributada sujeita à retenção na monofasia"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "adRemIBSReten",
            $this->conditionalNumberFormatting($std->adRemIBSReten),
            false,
            "[item $std->item] Alíquota ad rem do IBS sujeito a retenção"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "vIBSMonoReten",
            $this->conditionalNumberFormatting($std->vIBSMonoReten),
            false,
            "[item $std->item] Valor do IBS monofásico sujeito a retenção"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "adRemCBSReten",
            $this->conditionalNumberFormatting($std->adRemCBSReten),
            false,
            "[item $std->item] Alíquota ad rem do CBS sujeito a retenção"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            (string) "vCBSMonoReten",
            $this->conditionalNumberFormatting($std->vCBSMonoReten),
            false,
            "[item $std->item] Valor do CBS monofásico sujeito a retenção"
        );
        if (!empty($std->qBCMonoRet)) {
            $this->dom->addChild(
                $gIBSCBSMono,
                (string)"qBCMonoRet",
                $this->conditionalNumberFormatting($std->qBCMonoRet),
                true,
                "[item $std->item] Quantidade tributada retida anteriormente"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                (string)"adRemIBSRet",
                $this->conditionalNumberFormatting($std->adRemIBSRet),
                true,
                "[item $std->item] Alíquota ad rem do IBS retido anteriormente"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                (string)"vIBSMonoRet",
                $this->conditionalNumberFormatting($std->vIBSMonoRet),
                true,
                "[item $std->item] Valor do IBS retido anteriormente"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                (string)"adRemCBSRet",
                $this->conditionalNumberFormatting($std->adRemCBSRet),
                true,
                "[item $std->item] Alíquota ad rem do CBS retido anteriormente"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                (string)"vCBSMonoRet",
                $this->conditionalNumberFormatting($std->vCBSMonoRet),
                true,
                "[item $std->item] Valor do CBS retido anteriormente"
            );
        }
        $this->aIBSCBSMono[$std->item] = $gIBSCBSMono;
        return $gIBSCBSMono;
    }
}
