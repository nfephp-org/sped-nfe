<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * @property Dom $dom
 * @property array $aIBSCBS
 * @property array $aIBSCredPres
 * @property array $aCBSCredPres
 * @property array $aGTribCompraGov
 * @property array $aGIBSCBSMono
 * @property array $aGTransfCred
 * @property array $aGCredPresIBSZFM
 * @property stdClass $stdIBSCBSTot
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
 */
trait TraitTagDetIBSCBS
{
    /**
     * Informações do Imposto de Bens e Serviços - IBS e da Contribuição de Bens e Serviços - CBS UB12 pai M01
     * $this->>aIBSCBS[$item]
     * IBSCBS/gIBSCBS/gIBSUF UB17 pai UB15
     * IBSCBS/gIBSCBS/gIBSMun UB36 pai UB15
     * IBSCBS/gIBSCBS/gCBS UB55 pai UB15
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagIBSCBS(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CST',
            'cClassTrib',
            'vBC',
            //dados IBS Estadual
            'gIBSUF_pIBSUF', //opcional Alíquota do IBS de competência das UF 3v2-4, OBRIGATÓRIO se vBC for informado
            'gIBSUF_pDif', //opcional Percentual do diferimento 3v2-4
            'gIBSUF_vDif', //opcional Valor do Diferimento 13v2
            'gIBSUF_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gIBSUF_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gIBSUF_pAliqEfet', //opcional Alíquota Efetiva do IBS de competência das UF que será aplicada a BC 3v2-4
            'gIBSUF_vIBSUF', //OBRIGATÓRIO Valor do IBS de competência da UF 13v2
            //dados IBS Municipal
            'gIBSMun_pIBSMun', //opcional Alíquota do IBS de competência do município 3v2-4
                //OBRIGATÓRIO se vBC for informado
            'gIBSMun_pDif', //opcional Percentual do diferimento 3v2-4
            'gIBSMun_vDif', //opcional Valor do Diferimento 13v2
            'gIBSMun_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gIBSMun_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gIBSMun_pAliqEfet', //opcional Alíquota Efetiva do IBS de competência do Município
                // que será aplicada a BC 3v2-4
            'gIBSMun_vIBSMun', //opcional Valor do IBS de competência do Município 13v2
            // dados CBS (imposto federal)
            'gCBS_pCBS', //opcional Alíquota da CBS 3v2-4
                // OBRIGATÓRIO se vBC for informado
            'gCBS_pDif', //opcional Percentual do diferimento 3v2-4
            'gCBS_vDif', //opcional Valor do Diferimento 13v2
            'gCBS_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gCBS_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gCBS_pAliqEfet', //opcional Alíquota Efetiva da CBS que será aplicada a Base de Cálculo 3v2-4
            'gCBS_vCBS', //opcional Valor da CBS 13v2
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB12 <IBSCBS> -";
        //totalizador do IBS e CBS
        $this->stdIBSCBSTot->vBCIBSCBS += $std->vBC ?? 0;
        $this->stdIBSCBSTot->gIBSUF->vDIF += $std->gIBSUF_pDif ?? 0;
        $this->stdIBSCBSTot->gIBSUF->vDevTrib += $std->gIBSUF_vDevTrib ?? 0;
        $this->stdIBSCBSTot->gIBSUF->vIBSUF += $std->gIBSUF_vIBSUF ?? 0;
        $this->stdIBSCBSTot->vIBS += $std->gIBSUF_vIBSUF ?? 0;

        $this->stdIBSCBSTot->gIBSMun->vDIF += $std->gIBSMun_vDif ?? 0;
        $this->stdIBSCBSTot->gIBSMun->vDevTrib += $std->gIBSMun_vDevTrib ?? 0;
        $this->stdIBSCBSTot->gIBSMun->vIBSMun += $std->gIBSMun_vIBSMun ?? 0;
        $this->stdIBSCBSTot->vIBS += $std->gIBSMun_vIBSMun ?? 0;

        $this->stdIBSCBSTot->gCBS->vDIF += $std->gCBS_vDif ?? 0;
        $this->stdIBSCBSTot->gCBS->vDevTrib += $std->gCBS_vDevTrib ?? 0;
        $this->stdIBSCBSTot->vCBS += $std->gCBS_vCBS ?? 0;

        $ibscbs = $this->dom->createElement("IBSCBS");
        $this->dom->addChild(
            $ibscbs,
            "CST",
            $std->CST,
            true,
            "$identificador Código de Situação Tributária do IBS e CBS (CST)"
        );
        $this->dom->addChild(
            $ibscbs,
            "cClassTrib",
            $std->cClassTrib,
            true,
            "$identificador Código de Classificação Tributária do IBS e CBS (cClassTrib)"
        );
        //gIBSCBS é opcional e também é um choice com IBSCBSMono
        if (!empty($std->vBC)) {
            $identificador = "UB12 <IBSCBS/gIBSCBS> -";
            $gIBSCBS = $this->dom->createElement("gIBSCBS");
            $this->dom->addChild(
                $gIBSCBS,
                "vBC",
                $this->conditionalNumberFormatting($std->vBC),
                true,
                "$identificador Base de cálculo do IBS e CBS (vBC)"
            );
            $identificador = "UB12 <IBSCBS/gIBSCBS/gIBSUF> -";
            $gIBSUF = $this->dom->createElement("gIBSUF");
            $this->dom->addChild(
                $gIBSUF,
                "pIBSUF",
                $this->conditionalNumberFormatting($std->gIBSUF_pIBSUF ?? null, 4),
                true,
                "$identificador Alíquota do IBS de competência das UF (pIBSUF)"
            );
            if (!empty($std->gIBSUF_pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    "pDif",
                    $this->conditionalNumberFormatting($std->gIBSUF_pDif, 4),
                    true,
                    "$identificador Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    "vDif",
                    $this->conditionalNumberFormatting($std->gIBSUF_vDif ?? null),
                    true,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gIBSUF->appendChild($gDif);
            }
            if (!empty($std->gIBSUF_vDevTrib)) {
                //Grupo de Informações da devolução de tributos IBSUF
                $gDevTrib = $this->dom->createElement("gDevTrib");
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    $this->conditionalNumberFormatting($std->gIBSUF_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gIBSUF->appendChild($gDevTrib);
            }
            if (!empty($std->gIBSUF_pRedAliq)) {
                //Grupo de informações da redução da alíquota
                $gRed = $this->dom->createElement("gRed");
                $this->dom->addChild(
                    $gRed,
                    "pRedAliq",
                    $this->conditionalNumberFormatting($std->gIBSUF_pRedAliq, 4),
                    true,
                    "$identificador Percentual da redução de alíquota (pRedAliq)"
                );
                $this->dom->addChild(
                    $gRed,
                    "pAliqEfet",
                    $this->conditionalNumberFormatting($std->gIBSUF_pAliqEfet ?? null),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF "
                    . "que será aplicada a Base de Cálculo (pAliqEfet)"
                );
                $gIBSUF->appendChild($gRed);
            }
            $this->dom->addChild(
                $gIBSUF,
                "vIBSUF",
                $this->conditionalNumberFormatting($std->gIBSUF_vIBSUF ?? null),
                true,
                "$identificador Valor do IBS de competência da UF (vIBSUF)"
            );
            //adiciona gIBSUF => $gIBSCBS
            $gIBSCBS->appendChild($gIBSUF);
            //Grupo de Informações do IBS para o município
            $identificador = "UB12 <IBSCBS/gIBSCBS/gIBSMun> -";
            $gIBSMun = $this->dom->createElement("gIBSMun");
            $this->dom->addChild(
                $gIBSMun,
                "pIBSMun",
                $this->conditionalNumberFormatting($std->gIBSMun_pIBSMun ?? null),
                true,
                "$identificador Alíquota do IBS de competência do Município (pIBSMun)"
            );
            if (!empty($std->gIBSMun_pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    "pDif",
                    $this->conditionalNumberFormatting($std->gIBSMun_pDif, 4),
                    true,
                    "$identificador Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    "vDif",
                    $this->conditionalNumberFormatting($std->gIBSMun_vDif ?? null),
                    true,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gIBSMun->appendChild($gDif);
            }
            if (!empty($std->gIBSMun_vDevTrib)) {
                //Grupo de Informações da devolução de tributos
                $gDevTrib = $this->dom->createElement("gDevTrib");
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    $this->conditionalNumberFormatting($std->gIBSMun_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gIBSMun->appendChild($gDevTrib);
            }
            if (!empty($std->gIBSMun_pRedAliq)) {
                //Grupo de informações da redução da alíquota IBSMun
                $gRed = $this->dom->createElement("gRed");
                $this->dom->addChild(
                    $gRed,
                    "pRedAliq",
                    $this->conditionalNumberFormatting($std->gIBSMun_pRedAliq, 4),
                    true,
                    "$identificador Percentual da redução de alíquota (pRedAliq)"
                );
                $this->dom->addChild(
                    $gRed,
                    "pAliqEfet",
                    $this->conditionalNumberFormatting($std->gIBSMun_pAliqEfet ?? null),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF que será aplicada "
                    . "a Base de Cálculo (pAliqEfet)"
                );
                $gIBSMun->appendChild($gRed);
            }
            $this->dom->addChild(
                $gIBSMun,
                "vIBSMun",
                $this->conditionalNumberFormatting($std->gIBSMun_vIBSMun ?? null),
                true,
                "$identificador Valor do IBS de competência do Município (vIBSMun)"
            );
            $gIBSCBS->appendChild($gIBSMun);
            //gripo de Informações da CBS
            $identificador = "UB12 <IBSCBS/gIBSCBS/gCBS> -";
            $gCBS = $this->dom->createElement("gCBS");
            $this->dom->addChild(
                $gCBS,
                "pCBS",
                $this->conditionalNumberFormatting($std->gCBS_pCBS ?? null, 4),
                true,
                "$identificador Alíquota da CBS (pCBS)"
            );
            if (!empty($std->gCBS_pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    "pDif",
                    $this->conditionalNumberFormatting($std->gCBS_pDif, 4),
                    true,
                    "$identificador Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    "vDif",
                    $this->conditionalNumberFormatting($std->gCBS_vDif ?? null),
                    false,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gCBS->appendChild($gDif);
            }
            if (!empty($std->gCBS_vDevTrib)) {
                //Grupo de Informações da devolução de tributos
                $gDevTrib = $this->dom->createElement("gDevTrib");
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    $this->conditionalNumberFormatting($std->gCBS_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gCBS->appendChild($gDevTrib);
            }
            if (!empty($std->gCBS_pRedAliq)) {
                //Grupo de informações da redução da alíquota CBS
                $gRed = $this->dom->createElement("gRed");
                $this->dom->addChild(
                    $gRed,
                    "pRedAliq",
                    $this->conditionalNumberFormatting($std->gCBS_pRedAliq, 4),
                    true,
                    "$identificador Percentual da redução de alíquota (pRedAliq)"
                );
                $this->dom->addChild(
                    $gRed,
                    "pAliqEfet",
                    $this->conditionalNumberFormatting($std->gCBS_pAliqEfet ?? null),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF que será aplicada "
                    . "a Base de Cálculo (pAliqEfet)"
                );
                $gCBS->appendChild($gRed);
            }
            $this->dom->addChild(
                $gCBS,
                "vCBS",
                $this->conditionalNumberFormatting($std->gCBS_vCBS ?? null),
                true,
                "$identificador Valor do CBS (vCBS)"
            );
            $gIBSCBS->appendChild($gCBS);
            $ibscbs->appendChild($gIBSCBS);
        }
        $this->aIBSCBS[$std->item] = $ibscbs;
        return $ibscbs;
    }

    /**
     * Grupo de informações da Tributação Regular UB68 pai UB15
     * $this->aGTribRegular[$item]/gTribRegular
     * IBSCBS/gIBSCBS/gTribRegular
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagIBSCBSTribRegular(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'CSTReg',
            'cClassTribReg',
            'pAliqEfetRegIBSUF',
            'vTribRegIBSUF',
            'pAliqEfetRegIBSMun',
            'vTribRegIBSMun',
            'pAliqEfetRegCBS',
            'vTribRegCBS',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB68 <gTribRegular> -";
        $gTribRegular = $this->dom->createElement("gTribRegular");
        $this->dom->addChild(
            $gTribRegular,
            "CSTReg",
            $std->CSTReg,
            true,
            "$identificador Código de Situação Tributária do IBS e CBS (CSTReg)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "cClassTribReg",
            $std->cClassTribReg,
            true,
            "$identificador Informar qual seria o cClassTrib caso não cumprida a condição "
            . "resolutória/suspensiva (cClassTribReg)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegIBSUF",
            $std->pAliqEfetRegIBSUF,
            true,
            "$identificador Alíquota do IBS da UF (pAliqEfetRegIBSUF)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegIBSUF",
            $std->vTribRegIBSUF,
            true,
            "$identificador Valor do IBS da UF (vTribRegIBSUF)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegIBSMun",
            $std->pAliqEfetRegIBSMun,
            true,
            "$identificador Alíquota do IBS do Município (pAliqEfetRegIBSMun)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegIBSMun",
            $std->vTribRegIBSMun,
            true,
            "$identificador Valor do IBS do Município (vTribRegIBSMun)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegCBS",
            $std->pAliqEfetRegCBS,
            true,
            "$identificador Alíquota da CBS (pAliqEfetRegCBS)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegCBS",
            $std->vTribRegCBS,
            true,
            "$identificador Valor da CBS (vTribRegCB)"
        );
        $this->aGTribRegular[$std->item] = $gTribRegular;
        return $gTribRegular;
    }

    /**
     * Grupo de Informações do Crédito Presumido referente ao IBS UB73 pai UB15
     * $this->aIBSCredPres[$item]/gIBSCredPres
     * IBSCBS/gIBSCBS/gIBSCredPres
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagIBSCredPres(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'cCredPres',
            'pCredPres',
            'vCredPres',
            'vCredPresCondSus',
        ];
        $std = $this->equilizeParameters($std, $possible);
        //Totalizador
        $this->stdIBSCBSTot->vCredPres += $std->vCredPres ?? 0;
        $this->stdIBSCBSTot->vCredPresCondSus += $std->vCredPresCondSus ?? 0;
        $identificador = "UB73 <gIBSCredPres> -";
        $gIBSCredPres = $this->dom->createElement("gIBSCredPres");
        $this->dom->addChild(
            $gIBSCredPres,
            "cCredPres",
            $std->cCredPres,
            true,
            "$identificador Código de Classificação do Crédito Presumido (cCredPres)"
        );
        $this->dom->addChild(
            $gIBSCredPres,
            "pCredPres",
            $this->conditionalNumberFormatting($std->pCredPres, 4),
            true,
            "$identificador Percentual do Crédito Presumido (pCredPres)"
        );
        $this->dom->addChild(
            $gIBSCredPres,
            "vCredPres",
            $this->conditionalNumberFormatting($std->vCredPres),
            true,
            "$identificador Valor do Crédito Presumido (vCredPres)"
        );
        $this->dom->addChild(
            $gIBSCredPres,
            "vCredPresCondSus",
            $this->conditionalNumberFormatting($std->vCredPresCondSus),
            true,
            "$identificador Valor do Crédito Presumido em condição suspensiva. (vCredPres)"
        );
        $this->aIBSCredPres[$std->item] = $gIBSCredPres;
        return $gIBSCredPres;
    }

    /**
     * Grupo de Informações do Crédito Presumido referente ao CBS UB78 pai UB15
     * $this->aCBSCredPres[$item]/gCBSCredPres
     * IBSCBS/gCBSCBS/gCBSCredPres
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagCBSCredPres(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'cCredPres',
            'pCredPres',
            'vCredPres',
            'vCredPresCondSus',
        ];
        $std = $this->equilizeParameters($std, $possible);
        //Totalizador
        $this->stdIBSCBSTot->vCredPres += $std->vCredPres ?? 0;
        $this->stdIBSCBSTot->vCredPresCondSus += $std->vCredPresCondSus ?? 0;
        $identificador = "UB78 <gCBSCredPres> -";
        $gCBSCredPres = $this->dom->createElement("gCBSCredPres");
        $this->dom->addChild(
            $gCBSCredPres,
            "cCredPres",
            $std->cCredPres,
            true,
            "$identificador Código de Classificação do Crédito Presumido (cCredPres)"
        );
        $this->dom->addChild(
            $gCBSCredPres,
            "pCredPres",
            $this->conditionalNumberFormatting($std->pCredPres, 4),
            true,
            "$identificador Percentual do Crédito Presumido (pCredPres)"
        );
        $this->dom->addChild(
            $gCBSCredPres,
            "vCredPres",
            $this->conditionalNumberFormatting($std->vCredPres),
            true,
            "$identificador Valor do Crédito Presumido (vCredPres)"
        );
        $this->dom->addChild(
            $gCBSCredPres,
            "vCredPresCondSus",
            $this->conditionalNumberFormatting($std->vCredPresCondSus),
            true,
            "$identificador Valor do Crédito Presumido em condição suspensiva. (vCredPres)"
        );
        $this->aCBSCredPres[$std->item] = $gCBSCredPres;
        return $gCBSCredPres;
    }

    /**
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggTribCompraGov(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'pIBSUF',
            'vIBSUF',
            'pIBSMun',
            'vIBSMun',
            'pCBS',
            'vCBS',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB82a <gTribCompraGov> -";
        $gTrib = $this->dom->createElement("gTribCompraGov");
        $this->dom->addChild(
            $gTrib,
            "pIBSUF",
            $this->conditionalNumberFormatting($std->pIBSUF, 4),
            true,
            "$identificador Alíquota do IBS de competência do Estado. (pIBSUF)"
        );
        $this->dom->addChild(
            $gTrib,
            "vIBSUF",
            $this->conditionalNumberFormatting($std->pIBSUF),
            true,
            "$identificador Valor do Tributo do IBS da UF calculado. (vIBSUF)"
        );
        $this->dom->addChild(
            $gTrib,
            "pIBSMun",
            $this->conditionalNumberFormatting($std->pIBSMun, 4),
            true,
            "$identificador Alíquota do IBS de competência do Município. (pIBSMun)"
        );
        $this->dom->addChild(
            $gTrib,
            "vIBSMun",
            $this->conditionalNumberFormatting($std->vIBSMun),
            true,
            "$identificador Valor do Tributo do IBS do Município calculado. (vIBSMun)"
        );
        $this->dom->addChild(
            $gTrib,
            "pCBS",
            $this->conditionalNumberFormatting($std->pCBS, 4),
            true,
            "$identificador Alíquota da CBS. (pCBS)"
        );
        $this->dom->addChild(
            $gTrib,
            "vCBS",
            $this->conditionalNumberFormatting($std->vCBS),
            true,
            "$identificador Valor do Tributo da CBS calculado. (vCBS)"
        );
        $this->aGTribCompraGov[$std->item] = $gTrib;
        return $gTrib;
    }

    /**
     * Grupo o IBS e CBS em operações com imposto monofásico (Combustiveis) UB84 pai UB12
     * $this->aIBSCBS[$item] ->append($this->aIBSCBSMono[$item])
     * IBSCBS/gIBSCBSMono
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
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
        //Totalizador
        $this->stdIBSCBSTot->gIBSCBSMono->vIBSMono += $std->vIBSMono ?? 0;
        $this->stdIBSCBSTot->gIBSCBSMono->vCBSMono += $std->vCBSMono ?? 0;
        $this->stdIBSCBSTot->gIBSCBSMono->vIBSMonoReten += $std->vIBSMonoReten ?? 0;
        $this->stdIBSCBSTot->gIBSCBSMono->vCBSMonoReten += $std->vCBSMonoReten ?? 0;
        $this->stdIBSCBSTot->gIBSCBSMono->vIBSMonoRet += $std->vIBSMonoRet ?? 0;
        $this->stdIBSCBSTot->gIBSCBSMono->vCBSMonoRet += $std->vCBSMonoRet ?? 0;

        $identificador = "UB84 <gIBSCBSMono> -";
        $gIBSCBSMono = $this->dom->createElement("gIBSCBSMono");
        $this->dom->addChild(
            $gIBSCBSMono,
            "qBCMono",
            $this->conditionalNumberFormatting($std->qBCMono, 4),
            true,
            "$identificador Quantidade tributada na monofasia (qBCMono)"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            "adRemIBS",
            $this->conditionalNumberFormatting($std->adRemIBS, 4),
            true,
            "$identificador Alíquota ad rem do IBS (adRemIBS)"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            "adRemCBS",
            $this->conditionalNumberFormatting($std->adRemCBS, 4),
            true,
            "$identificador Alíquota ad rem do CBS (adRemCBS)"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            "vIBSMono",
            $this->conditionalNumberFormatting($std->vIBSMono),
            true,
            "$identificador Valor do IBS monofásico (vIBSMono)"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            "vCBSMono",
            $this->conditionalNumberFormatting($std->vCBSMono),
            true,
            "$identificador Valor do CBS monofásico (vCBSMono)"
        );
        if (!empty($std->qBCMonoReten)) {
            $this->dom->addChild(
                $gIBSCBSMono,
                "qBCMonoReten",
                $this->conditionalNumberFormatting($std->qBCMonoReten, 4),
                true,
                "$identificador Quantidade tributada sujeita à retenção na monofasia (qBCMonoReten)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "adRemIBSReten",
                $this->conditionalNumberFormatting($std->adRemIBSReten ?? null, 4),
                true,
                "$identificador Alíquota ad rem do IBS sujeito a retenção (adRemIBSReten)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vIBSMonoReten",
                $this->conditionalNumberFormatting($std->vIBSMonoReten ?? null),
                true,
                "$identificador Valor do IBS monofásico sujeito a retenção (vIBSMonoReten)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "adRemCBSReten",
                $this->conditionalNumberFormatting($std->adRemCBSReten ?? null, 4),
                true,
                "$identificador Alíquota ad rem do CBS sujeito a retenção (adRemCBSReten)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vCBSMonoReten",
                $this->conditionalNumberFormatting($std->vCBSMonoReten ?? null),
                true,
                "$identificador Valor do CBS monofásico sujeito a retenção (vCBSMonoReten)"
            );
        }
        if (!empty($std->qBCMonoRet)) {
            $this->dom->addChild(
                $gIBSCBSMono,
                "qBCMonoRet",
                $this->conditionalNumberFormatting($std->qBCMonoRet, 4),
                true,
                "$identificador Quantidade tributada retida anteriormente (qBCMonoRet)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "adRemIBSRet",
                $this->conditionalNumberFormatting($std->adRemIBSRet ?? null, 4),
                true,
                "$identificador Alíquota ad rem do IBS retido anteriormente (adRemIBSRet)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vIBSMonoRet",
                $this->conditionalNumberFormatting($std->vIBSMonoRet ?? null),
                true,
                "$identificador Valor do IBS retido anteriormente (vIBSMonoRet)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "adRemCBSRet",
                $this->conditionalNumberFormatting($std->adRemCBSRet ?? null, 4),
                true,
                "$identificador Alíquota ad rem do CBS retido anteriormente (adRemCBSRet)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vCBSMonoRet",
                $this->conditionalNumberFormatting($std->vCBSMonoRet ?? null),
                true,
                "$identificador Valor do CBS retido anteriormente (vCBSMonoRet)"
            );
        }
        if (!empty($std->pDifIBS) || !empty($std->pDifCBS)) {
            $this->dom->addChild(
                $gIBSCBSMono,
                "pDifIBS",
                $this->conditionalNumberFormatting($std->pDifIBS, 4),
                true,
                "$identificador Percentual do diferimento do imposto monofásico (pDifIBS)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vIBSMonoDif",
                $this->conditionalNumberFormatting($std->vIBSMonoDif ?? null),
                true,
                "$identificador Valor do IBS monofásico diferido (vIBSMonoDif)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "pDifCBS",
                $this->conditionalNumberFormatting($std->pDifCBS, 4),
                true,
                "$identificador Percentual do diferimento do imposto monofásico (pDifCBS)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vCBSMonoDif",
                $this->conditionalNumberFormatting($std->vCBSMonoDif ?? null),
                true,
                "$identificador Valor da CBS Monofásica diferida (vCBSMonoDif)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vTotIBSMonoItem",
                $this->conditionalNumberFormatting($std->vTotIBSMonoItem ?? null),
                true,
                "$identificador Total de IBS Monofásico (vTotIBSMonoItem)"
            );
            $this->dom->addChild(
                $gIBSCBSMono,
                "vTotCBSMonoItem",
                $this->conditionalNumberFormatting($std->vTotCBSMonoItem ?? null),
                true,
                "$identificador Total da CBS Monofásica (vTotCBSMonoItem)"
            );
        }
        $this->aGIBSCBSMono[$std->item] = $gIBSCBSMono;
        return $gIBSCBSMono;
    }

    /**
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggTranfCred(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vIBS',
            'vCBS'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB106 <gTranfCred> -";
        $gTrans = $this->dom->createElement("gTranfCred");
        $this->dom->addChild(
            $gTrans,
            "vIBS",
            $this->conditionalNumberFormatting($std->vIBS),
            true,
            "$identificador Valor do IBS a ser transferido (vIBS)"
        );
        $this->dom->addChild(
            $gTrans,
            "vCBS",
            $this->conditionalNumberFormatting($std->vCBS),
            true,
            "$identificador Valor do CBS a ser transferido (vCBS)"
        );
        $this->aGTransfCred[$std->item] = $gTrans;
        return $gTrans;
    }

    /**
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggCredPresIBSZFM(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'tpCredPresIBSZFM',
            'vCredPresIBSZFM'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB109 <gCredPresIBSZFM> -";
        $cred = $this->dom->createElement("gCredPresIBSZFM");
        $this->dom->addChild(
            $cred,
            "tpCredPresIBSZFM",
            $std->tpCredPresIBSZFM,
            true,
            "$identificador Tipo de classificação de acordo com o art. 450, paragrafo 1, da LC 214/25 para o "
                . "cálculo do crédito presumido na ZFM (tpCredPresIBSZFM)"
        );
        $this->dom->addChild(
            $cred,
            "vCredPresIBSZFM",
            $std->vCredPresIBSZFM,
            true,
            "$identificador Valor do crédito presumido calculado sobre o saldo devedor "
                . "apurado (vCredPresIBSZFM)"
        );
        $this->aGCredPresIBSZFM[$std->item] = $cred;
        return $cred;
    }
}
