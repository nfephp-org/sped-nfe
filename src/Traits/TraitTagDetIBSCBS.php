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
 * @property array $aGAjusteCompet
 * @property array $aGEstornoCred
 * @property array $aGCredPresOper
 * @property string $cst_ibscbs
 * @property stdClass $stdIBSCBSTot
 * @property stdClass $stdIBSCredPresTot
 * @property stdClass $stdCBSCredPresTot
 * @property stdClass $stdGTribCompraGovTot
 * @property stdClass $stdGIBSCBSMonoTot
 * @property stdClass $stdGTransfCredTot
 * @property stdClass $stdGCredPresIBSZFMTot
 * @property stdClass $stdGIBSCBS
 * @property stdClass $stdGIBSCBSMono
 * @property stdClass $stdGTransfCred
 * @property bool $flagIBSCBS
 * @property bool $flagMono
 *
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
            'indDoacao',
            'vBC',
            'vIBS',
            //dados IBS Estadual
            'gIBSUF_pIBSUF', //opcional Alíquota do IBS de competência das UF 3v2-4, OBRIGATÓRIO se vBC for informado
            'gIBSUF_pDif', //opcional Percentual do diferimento 3v2-4
            'gIBSUF_vDif', //opcional Valor do Diferimento 13v2
            'gIBSUF_pDevTrib', //opcional Percentual de devolução do IBS da UF 3v2-4
            'gIBSUF_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gIBSUF_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gIBSUF_pAliqEfet', //opcional Alíquota Efetiva do IBS de competência das UF que será aplicada a BC 3v2-4
            'gIBSUF_vIBSUF', //OBRIGATÓRIO Valor do IBS de competência da UF 13v2
            //dados IBS Municipal
            'gIBSMun_pIBSMun', //opcional Alíquota do IBS de competência do município 3v2-4
            //OBRIGATÓRIO se vBC for informado
            'gIBSMun_pDif', //opcional Percentual do diferimento 3v2-4
            'gIBSMun_vDif', //opcional Valor do Diferimento 13v2
            'gIBSMun_pDevTrib', //opcional Percentual de devolução do IBS do Município 3v2-4
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
            'gCBS_pDevTrib', //opcional Percentual de devolução da CBS 3v2-4
            'gCBS_vDevTrib', //opcional Valor do tributo devolvido 13v2
            'gCBS_pRedAliq', //opcional Percentual da redução de alíquota 3v2-4
            'gCBS_pAliqEfet', //opcional Alíquota Efetiva da CBS que será aplicada a Base de Cálculo 3v2-4
            'gCBS_vCBS', //opcional Valor da CBS 13v2
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->cst_ibscbs = $std->CST ?? null;
        $identificador = "UB12 IBSCBS Item $std->item -";
        //dados para calculo do vItem
        if (empty($this->aVItem[$std->item])) {
            $this->aVItem[$std->item] = $this->aVItemStruct;
        }

        //vIBS = vIBSUF + vIBSMun
        $vIBSItem = ($std->gIBSUF_vIBSUF ?? 0) + ($std->gIBSMun_vIBSMun ?? 0);
        $this->aVItem[$std->item]['vIBS'] = $vIBSItem;
        $this->aVItem[$std->item]['vCBS'] = ($std->vCBS ?? 0);
        //totalizador do IBS e CBS
        if (isset($std->vBC)) {
            $this->stdIBSCBSTot->vBCIBSCBS += $std->vBC ?? 0;
            $this->stdIBSCBSTot->gIBSUF->vDif += $std->gIBSUF_vDif ?? 0;
            $this->stdIBSCBSTot->gIBSUF->vDevTrib += $std->gIBSUF_vDevTrib ?? 0;
            $this->stdIBSCBSTot->gIBSUF->vIBSUF += $std->gIBSUF_vIBSUF ?? 0;
            $this->stdIBSCBSTot->vIBS += $std->gIBSUF_vIBSUF ?? 0;
            $this->stdIBSCBSTot->gIBSMun->vDif += $std->gIBSMun_vDif ?? 0;
            $this->stdIBSCBSTot->gIBSMun->vDevTrib += $std->gIBSMun_vDevTrib ?? 0;
            $this->stdIBSCBSTot->gIBSMun->vIBSMun += $std->gIBSMun_vIBSMun ?? 0;
            $this->stdIBSCBSTot->vIBS += $std->gIBSMun_vIBSMun ?? 0;
            $this->stdIBSCBSTot->gCBS->vDif += $std->gCBS_vDif ?? 0;
            $this->stdIBSCBSTot->gCBS->vDevTrib += $std->gCBS_vDevTrib ?? 0;
            $this->stdIBSCBSTot->vCBS += $std->gCBS_vCBS ?? 0;
        }
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
        $this->dom->addChild(
            $ibscbs,
            "indDoacao",
            !empty($std->indDoacao) ? 1 : null, //somente aceita numero 1
            false,
            "$identificador Indica a natureza da operação de doação, orientando a apuração e a geração"
            . "de débitos ou estornos conforme o cenário (indDoacao)"
        );
        if (!empty($std->cClassTrib)) {
            $this->flagIBSCBS = true;
        }
        //gIBSCBS é opcional e também é um choice com IBSCBSMono
        if (!is_null($std->vBC) && is_numeric($std->vBC)) {
            $identificador = "UB12 <IBSCBS/gIBSCBS> -";
            $gIBSCBS = $this->dom->createElement("gIBSCBS");
            $this->dom->addChild(
                $gIBSCBS,
                "vBC",
                $this->conditionalNumberFormatting($std->vBC ?? 0),
                true,
                "$identificador Base de cálculo do IBS e CBS (vBC)"
            );
            $identificador = "UB12 <IBSCBS/gIBSCBS/gIBSUF> -";
            $gIBSUF = $this->dom->createElement("gIBSUF");
            $this->dom->addChild(
                $gIBSUF,
                "pIBSUF",
                $this->conditionalNumberFormatting($std->gIBSUF_pIBSUF ?? 0, 4),
                true,
                "$identificador Alíquota do IBS de competência das UF (pIBSUF)"
            );
            if (isset($std->gIBSUF_pDif)) {
                $gDif = $this->dom->createElement("gDif");
                $this->dom->addChild(
                    $gDif,
                    "pDif",
                    $this->conditionalNumberFormatting($std->gIBSUF_pDif, 4),
                    false,
                    "$identificador Percentual do diferimento (pDif)"
                );
                $this->dom->addChild(
                    $gDif,
                    "vDif",
                    $this->conditionalNumberFormatting($std->gIBSUF_vDif ?? 0),
                    true,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gIBSUF->appendChild($gDif);
            }
            if (isset($std->gIBSUF_vDevTrib)) {
                //Grupo de Informações da devolução de tributos IBSUF
                $gDevTrib = $this->dom->createElement("gDevTrib");
                //NT 2025.002 v1.50
                $this->dom->addChild(
                    $gDevTrib,
                    "pDevTrib",
                    $this->conditionalNumberFormatting($std->gIBSUF_pDevTrib ?? null, 4),
                    false,
                    "$identificador Percentual de devolução do IBS da UF (pDevTrib)"
                );
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    $this->conditionalNumberFormatting($std->gIBSUF_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gIBSUF->appendChild($gDevTrib);
            }
            if (isset($std->gIBSUF_pRedAliq)) {
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
                    $this->conditionalNumberFormatting($std->gIBSUF_pAliqEfet ?? 0, 4),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF "
                    . "que será aplicada a Base de Cálculo (pAliqEfet)"
                );
                $gIBSUF->appendChild($gRed);
            }
            $this->dom->addChild(
                $gIBSUF,
                "vIBSUF",
                $this->conditionalNumberFormatting($std->gIBSUF_vIBSUF),
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
                $this->conditionalNumberFormatting($std->gIBSMun_pIBSMun),
                true,
                "$identificador Alíquota do IBS de competência do Município (pIBSMun)"
            );
            if (isset($std->gIBSMun_pDif)) {
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
                    $this->conditionalNumberFormatting($std->gIBSMun_vDif ?? 0),
                    true,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gIBSMun->appendChild($gDif);
            }
            if (isset($std->gIBSMun_vDevTrib)) {
                //Grupo de Informações da devolução de tributos
                $gDevTrib = $this->dom->createElement("gDevTrib");
                //NT 2025.002 v1.50
                $this->dom->addChild(
                    $gDevTrib,
                    "pDevTrib",
                    $this->conditionalNumberFormatting($std->gIBSMun_pDevTrib ?? null, 4),
                    false,
                    "$identificador Percentual de devolução do IBS do Município (pDevTrib)"
                );
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    $this->conditionalNumberFormatting($std->gIBSMun_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gIBSMun->appendChild($gDevTrib);
            }
            if (isset($std->gIBSMun_pRedAliq)) {
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
                    $this->conditionalNumberFormatting($std->gIBSMun_pAliqEfet ?? 0, 4),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF que será aplicada "
                    . "a Base de Cálculo (pAliqEfet)"
                );
                $gIBSMun->appendChild($gRed);
            }
            $this->dom->addChild(
                $gIBSMun,
                "vIBSMun",
                $this->conditionalNumberFormatting($std->gIBSMun_vIBSMun),
                true,
                "$identificador Valor do IBS de competência do Município (vIBSMun)"
            );
            $gIBSCBS->appendChild($gIBSMun);
            //Valor do IBS (soma de vIBSUF e vIBSMun).
            $this->dom->addChild(
                $gIBSCBS,
                "vIBS",
                $this->conditionalNumberFormatting($std->vIBS ?? $vIBSItem),
                true,
                "$identificador Valor do Total do IBS"
            );
            //gripo de Informações da CBS
            $identificador = "UB12 <IBSCBS/gIBSCBS/gCBS> -";
            $gCBS = $this->dom->createElement("gCBS");
            $this->dom->addChild(
                $gCBS,
                "pCBS",
                $this->conditionalNumberFormatting($std->gCBS_pCBS, 4),
                true,
                "$identificador Alíquota da CBS (pCBS)"
            );
            if (isset($std->gCBS_pDif)) {
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
                    $this->conditionalNumberFormatting($std->gCBS_vDif ?? 0),
                    false,
                    "$identificador Valor do diferimento (vDif)"
                );
                $gCBS->appendChild($gDif);
            }
            if (isset($std->gCBS_vDevTrib)) {
                //Grupo de Informações da devolução de tributos
                $gDevTrib = $this->dom->createElement("gDevTrib");
                //NT 2025.002 v1.50
                $this->dom->addChild(
                    $gDevTrib,
                    "pDevTrib",
                    $this->conditionalNumberFormatting($std->gCBS_pDevTrib ?? null, 4),
                    false,
                    "$identificador Percentual de devolução da CBS (pDevTrib)"
                );
                $this->dom->addChild(
                    $gDevTrib,
                    "vDevTrib",
                    $this->conditionalNumberFormatting($std->gCBS_vDevTrib),
                    true,
                    "$identificador Valor do tributo devolvido (vDevTrib)"
                );
                $gCBS->appendChild($gDevTrib);
            }
            if (isset($std->gCBS_pRedAliq)) {
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
                    $this->conditionalNumberFormatting($std->gCBS_pAliqEfet ?? 0, 4),
                    true,
                    "$identificador Alíquota Efetiva do IBS de competência das UF que será aplicada "
                    . "a Base de Cálculo (pAliqEfet)"
                );
                $gCBS->appendChild($gRed);
            }
            $this->dom->addChild(
                $gCBS,
                "vCBS",
                $this->conditionalNumberFormatting($std->gCBS_vCBS ?? 0),
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
        $identificador = "UB68 gTribRegular Item: $std->item -";
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
            $this->conditionalNumberFormatting($std->pAliqEfetRegIBSUF, 4),
            true,
            "$identificador Alíquota do IBS da UF (pAliqEfetRegIBSUF)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegIBSUF",
            $this->conditionalNumberFormatting($std->vTribRegIBSUF),
            true,
            "$identificador Valor do IBS da UF (vTribRegIBSUF)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegIBSMun",
            $this->conditionalNumberFormatting($std->pAliqEfetRegIBSMun, 4),
            true,
            "$identificador Alíquota do IBS do Município (pAliqEfetRegIBSMun)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegIBSMun",
            $this->conditionalNumberFormatting($std->vTribRegIBSMun),
            true,
            "$identificador Valor do IBS do Município (vTribRegIBSMun)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "pAliqEfetRegCBS",
            $this->conditionalNumberFormatting($std->pAliqEfetRegCBS, 4),
            true,
            "$identificador Alíquota da CBS (pAliqEfetRegCBS)"
        );
        $this->dom->addChild(
            $gTribRegular,
            "vTribRegCBS",
            $this->conditionalNumberFormatting($std->vTribRegCBS),
            true,
            "$identificador Valor da CBS (vTribRegCB)"
        );
        $this->aGTribRegular[$std->item] = $gTribRegular;
        return $gTribRegular;
    }

    /**
     * Grupo de Tributação em compras governamentais
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggTribCompraGov(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'pAliqIBSUF',
            'vTribIBSUF',
            'pAliqIBSMun',
            'vTribIBSMun',
            'pAliqCBS',
            'vTribCBS',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB82a gTribCompraGov Item: $std->item -";
        $gTrib = $this->dom->createElement("gTribCompraGov");
        $this->dom->addChild(
            $gTrib,
            "pAliqIBSUF",
            $this->conditionalNumberFormatting($std->pAliqIBSUF, 4),
            true,
            "$identificador Alíquota do IBS de competência do Estado. (pAliqIBSUF)"
        );
        $this->dom->addChild(
            $gTrib,
            "vTribIBSUF",
            $this->conditionalNumberFormatting($std->vTribIBSUF),
            true,
            "$identificador Valor do Tributo do IBS da UF calculado. (vTribIBSUF)"
        );
        $this->dom->addChild(
            $gTrib,
            "pAliqIBSMun",
            $this->conditionalNumberFormatting($std->pAliqIBSMun, 4),
            true,
            "$identificador Alíquota do IBS de competência do Município. (pAliqIBSMun)"
        );
        $this->dom->addChild(
            $gTrib,
            "vTribIBSMun",
            $this->conditionalNumberFormatting($std->vTribIBSMun),
            true,
            "$identificador Valor do Tributo do IBS do Município calculado. (vTribIBSMun)"
        );
        $this->dom->addChild(
            $gTrib,
            "pAliqCBS",
            $this->conditionalNumberFormatting($std->pAliqCBS, 4),
            true,
            "$identificador Alíquota da CBS. (pAliqCBS)"
        );
        $this->dom->addChild(
            $gTrib,
            "vTribCBS",
            $this->conditionalNumberFormatting($std->vTribCBS),
            true,
            "$identificador Valor do Tributo da CBS calculado. (vTribCBS)"
        );
        $this->aGTribCompraGov[$std->item] = $gTrib;
        return $gTrib;
    }

    /**
     * Grupo o IBS e CBS em operações com imposto monofásico (Combustiveis) UB84 pai UB12
     * NT 2025.002 v1.50 - IBS/CBS Ad Rem e Ad Valorem separados; gMonoDif removido
     * $this->aIBSCBS[$item] ->append($this->aIBSCBSMono[$item])
     * IBSCBS/gIBSCBSMono
     *
     * Regime por ano da dhEmi (sem enforce): 2026 AdValorem/AdValorem;
     * 2027-2028 AdValorem/AdRem; 2029+ AdRem/AdRem. Indicadores ind_gMonoPadrao,
     * ind_gMonoReten, ind_gMonoRet, ind_gpBioDiferenca na tabela cClassTrib.
     *
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function tagIBSCBSMono(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'gIBSMonoAdRem_qBCMono',
            'gIBSMonoAdRem_adRemIBS',
            'gIBSMonoAdRem_vIBSMono',
            'gIBSMonoAdRem_qBCMonoReten',
            'gIBSMonoAdRem_adRemIBSReten',
            'gIBSMonoAdRem_vIBSMonoReten',
            'gIBSMonoAdRem_vIBSMonoRet',
            'gIBSMonoAdRem_qBCBioComb',
            'gIBSMonoAdRem_vIBSDiferenca',
            'gIBSMonoAdValorem_vBCMono',
            'gIBSMonoAdValorem_pAliqMonoUF',
            'gIBSMonoAdValorem_vIBSMonoUF',
            'gIBSMonoAdValorem_pAliqMonoMun',
            'gIBSMonoAdValorem_vIBSMonoMun',
            'gIBSMonoAdValorem_vIBSMono',
            'gIBSMonoAdValorem_vBCMonoReten',
            'gIBSMonoAdValorem_pAliqMonoReten',
            'gIBSMonoAdValorem_vIBSMonoReten',
            'gIBSMonoAdValorem_vIBSMonoRet',
            'gIBSMonoAdValorem_qBCBioComb',
            'gIBSMonoAdValorem_vIBSDiferenca',
            'gCBSMonoAdRem_qBCMono',
            'gCBSMonoAdRem_adRemCBS',
            'gCBSMonoAdRem_vCBSMono',
            'gCBSMonoAdRem_qBCMonoReten',
            'gCBSMonoAdRem_adRemCBSReten',
            'gCBSMonoAdRem_vCBSMonoReten',
            'gCBSMonoAdRem_vCBSMonoRet',
            'gCBSMonoAdRem_qBCBioComb',
            'gCBSMonoAdRem_vCBSDiferenca',
            'gCBSMonoAdValorem_vBCMono',
            'gCBSMonoAdValorem_pAliqMonoCBS',
            'gCBSMonoAdValorem_vCBSMono',
            'gCBSMonoAdValorem_vBCMonoReten',
            'gCBSMonoAdValorem_pAliqMonoReten',
            'gCBSMonoAdValorem_vCBSMonoReten',
            'gCBSMonoAdValorem_vCBSMonoRet',
            'gCBSMonoAdValorem_qBCBioComb',
            'gCBSMonoAdValorem_vCBSDiferenca',
            'vTotIBSMonoItem',
            'vTotCBSMonoItem'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->flagMono = true;
        //Totalizador W34 gMono
        $this->stdIBSCBSTot->gMono->vIBSMono += ($std->gIBSMonoAdRem_vIBSMono ?? 0)
            + ($std->gIBSMonoAdValorem_vIBSMono ?? 0);
        $this->stdIBSCBSTot->gMono->vCBSMono += ($std->gCBSMonoAdRem_vCBSMono ?? 0)
            + ($std->gCBSMonoAdValorem_vCBSMono ?? 0);
        $this->stdIBSCBSTot->gMono->vIBSMonoReten += ($std->gIBSMonoAdRem_vIBSMonoReten ?? 0)
            + ($std->gIBSMonoAdValorem_vIBSMonoReten ?? 0);
        $this->stdIBSCBSTot->gMono->vCBSMonoReten += ($std->gCBSMonoAdRem_vCBSMonoReten ?? 0)
            + ($std->gCBSMonoAdValorem_vCBSMonoReten ?? 0);
        $this->stdIBSCBSTot->gMono->vIBSMonoRet += ($std->gIBSMonoAdRem_vIBSMonoRet ?? 0)
            + ($std->gIBSMonoAdValorem_vIBSMonoRet ?? 0);
        $this->stdIBSCBSTot->gMono->vCBSMonoRet += ($std->gCBSMonoAdRem_vCBSMonoRet ?? 0)
            + ($std->gCBSMonoAdValorem_vCBSMonoRet ?? 0);
        //dado para calculo do vItem
        if (empty($this->aVItem[$std->item])) {
            $this->aVItem[$std->item] = $this->aVItemStruct;
        }
        //UB105a-10 / UB105b-10: vTot = vMono + vMonoReten (sem Ret, sem gpBio, sem Dif)
        $vTotIBSMonoItem = ($std->gIBSMonoAdRem_vIBSMono ?? 0)
            + ($std->gIBSMonoAdValorem_vIBSMono ?? 0)
            + ($std->gIBSMonoAdRem_vIBSMonoReten ?? 0)
            + ($std->gIBSMonoAdValorem_vIBSMonoReten ?? 0);
        $vTotCBSMonoItem = ($std->gCBSMonoAdRem_vCBSMono ?? 0)
            + ($std->gCBSMonoAdValorem_vCBSMono ?? 0)
            + ($std->gCBSMonoAdRem_vCBSMonoReten ?? 0)
            + ($std->gCBSMonoAdValorem_vCBSMonoReten ?? 0);
        $this->aVItem[$std->item]['vTotIBSMonoItem'] = ($std->vTotIBSMonoItem ?? $vTotIBSMonoItem);
        $this->aVItem[$std->item]['vTotCBSMonoItem'] = ($std->vTotCBSMonoItem ?? $vTotCBSMonoItem);
        $identificador = "UB84 gIBSCBSMono Item: $std->item -";
        $gIBSCBSMono = $this->dom->createElement("gIBSCBSMono");
        $hasIbsAdRem = !empty($std->gIBSMonoAdRem_qBCMono)
            || !empty($std->gIBSMonoAdRem_qBCMonoReten)
            || !empty($std->gIBSMonoAdRem_vIBSMonoRet)
            || !empty($std->gIBSMonoAdRem_qBCBioComb);
        if ($hasIbsAdRem) {
            $gIBSMonoAdRem = $this->dom->createElement("gIBSMonoAdRem");
            if (!empty($std->gIBSMonoAdRem_qBCMono)) {
                $padrao = $this->dom->createElement("gMonoPadrao");
                $this->dom->addChild(
                    $padrao,
                    "qBCMono",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_qBCMono, 4),
                    true,
                    "$identificador Quantidade tributada na monofasia (qBCMono)"
                );
                $this->dom->addChild(
                    $padrao,
                    "adRemIBS",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_adRemIBS ?? 0, 4),
                    true,
                    "$identificador Alíquota ad rem do IBS (adRemIBS)"
                );
                $this->dom->addChild(
                    $padrao,
                    "vIBSMono",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_vIBSMono ?? 0),
                    true,
                    "$identificador Valor do IBS monofásico (vIBSMono)"
                );
                $gIBSMonoAdRem->appendChild($padrao);
            }
            if (!empty($std->gIBSMonoAdRem_qBCMonoReten)) {
                $reten = $this->dom->createElement("gMonoReten");
                $this->dom->addChild(
                    $reten,
                    "qBCMonoReten",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_qBCMonoReten, 4),
                    true,
                    "$identificador Quantidade tributada sujeita à retenção na monofasia (qBCMonoReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "adRemIBSReten",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_adRemIBSReten ?? null, 4),
                    true,
                    "$identificador Alíquota ad rem do IBS sujeito a retenção (adRemIBSReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "vIBSMonoReten",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_vIBSMonoReten ?? null),
                    true,
                    "$identificador Valor do IBS monofásico sujeito a retenção (vIBSMonoReten)"
                );
                $gIBSMonoAdRem->appendChild($reten);
            }
            if (!empty($std->gIBSMonoAdRem_vIBSMonoRet)) {
                $ret = $this->dom->createElement("gMonoRet");
                $this->dom->addChild(
                    $ret,
                    "vIBSMonoRet",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_vIBSMonoRet ?? null),
                    true,
                    "$identificador Valor do IBS retido anteriormente (vIBSMonoRet)"
                );
                $gIBSMonoAdRem->appendChild($ret);
            }
            if (!empty($std->gIBSMonoAdRem_qBCBioComb)) {
                $bio = $this->dom->createElement("gpBioDiferenca");
                $this->dom->addChild(
                    $bio,
                    "qBCBioComb",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_qBCBioComb, 4),
                    true,
                    "$identificador Quantidade de Biocombustível (EAC) a recolher ou a ressarcir (qBCBioComb)"
                );
                $this->dom->addChild(
                    $bio,
                    "vIBSDiferenca",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdRem_vIBSDiferenca ?? null),
                    true,
                    "$identificador Valor do IBS correspondente a diferença em relação ao pBioObrigatorio "
                    . "(vIBSDiferenca)"
                );
                $gIBSMonoAdRem->appendChild($bio);
            }
            $gIBSCBSMono->appendChild($gIBSMonoAdRem);
        }
        $hasIbsAdValorem = !empty($std->gIBSMonoAdValorem_vBCMono)
            || !empty($std->gIBSMonoAdValorem_vBCMonoReten)
            || !empty($std->gIBSMonoAdValorem_vIBSMonoRet)
            || !empty($std->gIBSMonoAdValorem_qBCBioComb);
        if ($hasIbsAdValorem) {
            $gIBSMonoAdValorem = $this->dom->createElement("gIBSMonoAdValorem");
            if (!empty($std->gIBSMonoAdValorem_vBCMono)) {
                $padrao = $this->dom->createElement("gMonoPadrao");
                $this->dom->addChild(
                    $padrao,
                    "vBCMono",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vBCMono),
                    true,
                    "$identificador Valor tributado na monofasia (vBCMono)"
                );
                $this->dom->addChild(
                    $padrao,
                    "pAliqMonoUF",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_pAliqMonoUF ?? 0, 4),
                    true,
                    "$identificador Alíquota ad valorem do IBS Estadual (pAliqMonoUF)"
                );
                $this->dom->addChild(
                    $padrao,
                    "vIBSMonoUF",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vIBSMonoUF ?? 0),
                    true,
                    "$identificador Valor do IBS monofásico Estadual (vIBSMonoUF)"
                );
                $this->dom->addChild(
                    $padrao,
                    "pAliqMonoMun",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_pAliqMonoMun ?? 0, 4),
                    true,
                    "$identificador Alíquota ad valorem do IBS Municipal (pAliqMonoMun)"
                );
                $this->dom->addChild(
                    $padrao,
                    "vIBSMonoMun",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vIBSMonoMun ?? 0),
                    true,
                    "$identificador Valor do IBS monofásico Municipal (vIBSMonoMun)"
                );
                $this->dom->addChild(
                    $padrao,
                    "vIBSMono",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vIBSMono ?? 0),
                    true,
                    "$identificador Valor do IBS monofásico (vIBSMono)"
                );
                $gIBSMonoAdValorem->appendChild($padrao);
            }
            if (!empty($std->gIBSMonoAdValorem_vBCMonoReten)) {
                $reten = $this->dom->createElement("gMonoReten");
                $this->dom->addChild(
                    $reten,
                    "vBCMonoReten",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vBCMonoReten),
                    true,
                    "$identificador Valor tributado sujeito à retenção na monofasia (vBCMonoReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "pAliqMonoReten",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_pAliqMonoReten ?? null, 4),
                    true,
                    "$identificador Alíquota ad valorem do IBS sujeito à retenção (pAliqMonoReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "vIBSMonoReten",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vIBSMonoReten ?? null),
                    true,
                    "$identificador Valor do IBS monofásico sujeito a retenção (vIBSMonoReten)"
                );
                $gIBSMonoAdValorem->appendChild($reten);
            }
            if (!empty($std->gIBSMonoAdValorem_vIBSMonoRet)) {
                $ret = $this->dom->createElement("gMonoRet");
                $this->dom->addChild(
                    $ret,
                    "vIBSMonoRet",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vIBSMonoRet ?? null),
                    true,
                    "$identificador Valor do IBS retido anteriormente (vIBSMonoRet)"
                );
                $gIBSMonoAdValorem->appendChild($ret);
            }
            if (!empty($std->gIBSMonoAdValorem_qBCBioComb)) {
                $bio = $this->dom->createElement("gpBioDiferenca");
                $this->dom->addChild(
                    $bio,
                    "qBCBioComb",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_qBCBioComb, 4),
                    true,
                    "$identificador Quantidade de Biocombustível (EAC) a recolher ou a ressarcir (qBCBioComb)"
                );
                $this->dom->addChild(
                    $bio,
                    "vIBSDiferenca",
                    $this->conditionalNumberFormatting($std->gIBSMonoAdValorem_vIBSDiferenca ?? null),
                    true,
                    "$identificador Valor do IBS correspondente a diferença em relação ao pBioObrigatorio "
                    . "(vIBSDiferenca)"
                );
                $gIBSMonoAdValorem->appendChild($bio);
            }
            $gIBSCBSMono->appendChild($gIBSMonoAdValorem);
        }
        $hasCbsAdRem = !empty($std->gCBSMonoAdRem_qBCMono)
            || !empty($std->gCBSMonoAdRem_qBCMonoReten)
            || !empty($std->gCBSMonoAdRem_vCBSMonoRet)
            || !empty($std->gCBSMonoAdRem_qBCBioComb);
        if ($hasCbsAdRem) {
            $gCBSMonoAdRem = $this->dom->createElement("gCBSMonoAdRem");
            if (!empty($std->gCBSMonoAdRem_qBCMono)) {
                $padrao = $this->dom->createElement("gMonoPadrao");
                $this->dom->addChild(
                    $padrao,
                    "qBCMono",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_qBCMono, 4),
                    true,
                    "$identificador Quantidade tributada na monofasia (qBCMono)"
                );
                $this->dom->addChild(
                    $padrao,
                    "adRemCBS",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_adRemCBS ?? 0, 4),
                    true,
                    "$identificador Alíquota ad rem da CBS (adRemCBS)"
                );
                $this->dom->addChild(
                    $padrao,
                    "vCBSMono",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_vCBSMono ?? 0),
                    true,
                    "$identificador Valor da CBS monofásica (vCBSMono)"
                );
                $gCBSMonoAdRem->appendChild($padrao);
            }
            if (!empty($std->gCBSMonoAdRem_qBCMonoReten)) {
                $reten = $this->dom->createElement("gMonoReten");
                $this->dom->addChild(
                    $reten,
                    "qBCMonoReten",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_qBCMonoReten, 4),
                    true,
                    "$identificador Quantidade tributada sujeita à retenção na monofasia (qBCMonoReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "adRemCBSReten",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_adRemCBSReten ?? null, 4),
                    true,
                    "$identificador Alíquota ad rem da CBS sujeita a retenção (adRemCBSReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "vCBSMonoReten",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_vCBSMonoReten ?? null),
                    true,
                    "$identificador Valor da CBS monofásica sujeita a retenção (vCBSMonoReten)"
                );
                $gCBSMonoAdRem->appendChild($reten);
            }
            if (!empty($std->gCBSMonoAdRem_vCBSMonoRet)) {
                $ret = $this->dom->createElement("gMonoRet");
                $this->dom->addChild(
                    $ret,
                    "vCBSMonoRet",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_vCBSMonoRet ?? null),
                    true,
                    "$identificador Valor da CBS retida anteriormente (vCBSMonoRet)"
                );
                $gCBSMonoAdRem->appendChild($ret);
            }
            if (!empty($std->gCBSMonoAdRem_qBCBioComb)) {
                $bio = $this->dom->createElement("gpBioDiferenca");
                $this->dom->addChild(
                    $bio,
                    "qBCBioComb",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_qBCBioComb, 4),
                    true,
                    "$identificador Quantidade de Biocombustível (EAC) a recolher ou a ressarcir (qBCBioComb)"
                );
                $this->dom->addChild(
                    $bio,
                    "vCBSDiferenca",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdRem_vCBSDiferenca ?? null),
                    true,
                    "$identificador Valor da CBS correspondente a diferença em relação ao pBioObrigatorio "
                    . "(vCBSDiferenca)"
                );
                $gCBSMonoAdRem->appendChild($bio);
            }
            $gIBSCBSMono->appendChild($gCBSMonoAdRem);
        }
        $hasCbsAdValorem = !empty($std->gCBSMonoAdValorem_vBCMono)
            || !empty($std->gCBSMonoAdValorem_vBCMonoReten)
            || !empty($std->gCBSMonoAdValorem_vCBSMonoRet)
            || !empty($std->gCBSMonoAdValorem_qBCBioComb);
        if ($hasCbsAdValorem) {
            $gCBSMonoAdValorem = $this->dom->createElement("gCBSMonoAdValorem");
            if (!empty($std->gCBSMonoAdValorem_vBCMono)) {
                $padrao = $this->dom->createElement("gMonoPadrao");
                $this->dom->addChild(
                    $padrao,
                    "vBCMono",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_vBCMono),
                    true,
                    "$identificador Valor tributado na monofasia (vBCMono)"
                );
                $this->dom->addChild(
                    $padrao,
                    "pAliqMonoCBS",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_pAliqMonoCBS ?? 0, 4),
                    true,
                    "$identificador Alíquota ad valorem da CBS (pAliqMonoCBS)"
                );
                $this->dom->addChild(
                    $padrao,
                    "vCBSMono",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_vCBSMono ?? 0),
                    true,
                    "$identificador Valor da CBS monofásica (vCBSMono)"
                );
                $gCBSMonoAdValorem->appendChild($padrao);
            }
            if (!empty($std->gCBSMonoAdValorem_vBCMonoReten)) {
                $reten = $this->dom->createElement("gMonoReten");
                $this->dom->addChild(
                    $reten,
                    "vBCMonoReten",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_vBCMonoReten),
                    true,
                    "$identificador Valor tributado sujeito à retenção na monofasia (vBCMonoReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "pAliqMonoReten",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_pAliqMonoReten ?? null, 4),
                    true,
                    "$identificador Alíquota ad valorem da CBS sujeita à retenção (pAliqMonoReten)"
                );
                $this->dom->addChild(
                    $reten,
                    "vCBSMonoReten",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_vCBSMonoReten ?? null),
                    true,
                    "$identificador Valor da CBS monofásica sujeita a retenção (vCBSMonoReten)"
                );
                $gCBSMonoAdValorem->appendChild($reten);
            }
            if (!empty($std->gCBSMonoAdValorem_vCBSMonoRet)) {
                $ret = $this->dom->createElement("gMonoRet");
                $this->dom->addChild(
                    $ret,
                    "vCBSMonoRet",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_vCBSMonoRet ?? null),
                    true,
                    "$identificador Valor da CBS retida anteriormente (vCBSMonoRet)"
                );
                $gCBSMonoAdValorem->appendChild($ret);
            }
            if (!empty($std->gCBSMonoAdValorem_qBCBioComb)) {
                $bio = $this->dom->createElement("gpBioDiferenca");
                $this->dom->addChild(
                    $bio,
                    "qBCBioComb",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_qBCBioComb, 4),
                    true,
                    "$identificador Quantidade de Biocombustível (EAC) a recolher ou a ressarcir (qBCBioComb)"
                );
                $this->dom->addChild(
                    $bio,
                    "vCBSDiferenca",
                    $this->conditionalNumberFormatting($std->gCBSMonoAdValorem_vCBSDiferenca ?? null),
                    true,
                    "$identificador Valor da CBS correspondente a diferença em relação ao pBioObrigatorio "
                    . "(vCBSDiferenca)"
                );
                $gCBSMonoAdValorem->appendChild($bio);
            }
            $gIBSCBSMono->appendChild($gCBSMonoAdValorem);
        }
        $this->dom->addChild(
            $gIBSCBSMono,
            "vTotIBSMonoItem",
            $this->conditionalNumberFormatting($std->vTotIBSMonoItem ?? $vTotIBSMonoItem),
            true,
            "$identificador Total de IBS Monofásico (vTotIBSMonoItem)"
        );
        $this->dom->addChild(
            $gIBSCBSMono,
            "vTotCBSMonoItem",
            $this->conditionalNumberFormatting($std->vTotCBSMonoItem ?? $vTotCBSMonoItem),
            true,
            "$identificador Total da CBS Monofásica (vTotCBSMonoItem)"
        );
        $this->aGIBSCBSMono[$std->item] = $gIBSCBSMono;
        return $gIBSCBSMono;
    }

    /**
     * Grupo de Transferecnia de Creditos
     * det/imposto/IBSCBS/gTransfCred
     * $this->aIBSCBS[item] append $this->aGTransfCred[item]
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggTransfCred(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vIBS',
            'vCBS'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB106 gTranfCred Item: $std->item -";
        $gTrans = $this->dom->createElement("gTransfCred");
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
     * Grupo de Crédito Presumido de IBS com a ZF de Manaus
     * det/imposto/IBSCBS/gCredPresIBSZFM
     * $this->aIBSCBS[item] append $this->aGCredPresIBSZFM[item]
     * NT 2025.002_v1.30 - PL_010_V1.30
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggCredPresIBSZFM(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'competApur',
            'tpCredPresIBSZFM',
            'vCredPresIBSZFM'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB131 gCredPresIBSZFM Item: $std->item -";
        $cred = $this->dom->createElement("gCredPresIBSZFM");
        $this->dom->addChild(
            $cred,
            "competApur",
            $std->competApur,
            false,
            "$identificador Ano e mês referência do período de apuração (AAAA-MM) (competApur)"
        );
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
            $this->conditionalNumberFormatting($std->vCredPresIBSZFM),
            true,
            "$identificador Valor do crédito presumido calculado sobre o saldo devedor "
            . "apurado (vCredPresIBSZFM)"
        );
        $this->aGCredPresIBSZFM[$std->item] = $cred;
        return $cred;
    }

    /**
     * Grupo Ajuste de Competência
     * det/imposto/IBSCBS/gAjusteCompet
     * $this->aIBSCBS[item] append $this->aGAjusteCompet[item]
     * NT 2025.002_v1.30 - PL_010_V1.30
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggAjusteCompet(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'competApur',
            'vIBS',
            'vCBS',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB112 gAjusteCompet Item: $std->item -";
        $ajust = $this->dom->createElement("gAjusteCompet");
        $this->dom->addChild(
            $ajust,
            "competApur",
            $std->competApur,
            true,
            "$identificador Ano e mês referência do período de apuração (AAAA-MM) (competApur)"
        );
        $this->dom->addChild(
            $ajust,
            "vIBS",
            $this->conditionalNumberFormatting($std->vIBS),
            true,
            "$identificador Valor do IBS (vIBS)"
        );
        $this->dom->addChild(
            $ajust,
            "vCBS",
            $this->conditionalNumberFormatting($std->vCBS),
            true,
            "$identificador Valor do CBS (vCBS)"
        );
        $this->aGAjusteCompet[$std->item] = $ajust;
        return $ajust;
    }

    /**
     * Grupo de Estorno de Crédito
     * /det/imposto/IBSCBS/gEstornoCred
     * $this->aIBSCBS[item] append $this->aGEstornoCred[item]
     * NT 2025.002_v1.30 - PL_010_V1.30
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggEstornoCred(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vIBSEstCred',
            'vCBSEstCred',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB116 gEstornoCred Item: $std->item -";

        //totalizador
        $this->stdIBSCBSTot->gEstornoCred->vIBSEstCred += $std->vIBSEstCred ?? 0;
        $this->stdIBSCBSTot->gEstornoCred->vCBSEstCred += $std->vCBSEstCred ?? 0;

        $estorno = $this->dom->createElement("gEstornoCred");
        $this->dom->addChild(
            $estorno,
            "vIBSEstCred",
            $this->conditionalNumberFormatting($std->vIBSEstCred),
            true,
            "$identificador Valor do IBS a ser estornado (vIBSEstCred)"
        );
        $this->dom->addChild(
            $estorno,
            "vCBSEstCred",
            $this->conditionalNumberFormatting($std->vCBSEstCred),
            true,
            "$identificador Valor do CBS a ser estornado (vCBSEstCred)"
        );
        $this->aGEstornoCred[$std->item] = $estorno;
        return $estorno;
    }

    /**
     * Grupo de Crédito Presumido da Operação
     * det/imposto/IBSCBS/gCredPresOper
     * $this->aIBSCBS[item] append $this->aGCredPresOper[item]
     * NT 2025.002_v1.30 - PL_010_V1.30
     * @param stdClass $std
     * @return DOMElement
     * @throws DOMException
     */
    public function taggCredPresOper(stdClass $std): DOMElement
    {
        $possible = [
            'item',
            'vBCCredPres',
            'cCredPres',
            'ibs_pCredPres',
            'ibs_vCredPres',
            'ibs_vCredPresCondSus',
            'cbs_pCredPres',
            'cbs_vCredPres',
            'cbs_vCredPresCondSus',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $this->stdIBSCBSTot->gCBS->vCredPres += ($std->cbs_vCredPres ?? 0);
        $this->stdIBSCBSTot->gCBS->vCredPresCondSus += ($std->cbs_vCredPresCondSus ?? 0);
        $this->stdIBSCBSTot->gIBS->vCredPres += ($std->ibs_vCredPres ?? 0);
        $this->stdIBSCBSTot->gIBS->vCredPresCondSus += ($std->ibs_vCredPresCondSus ?? 0);
        $identificador = "UB120 gCredPresOper Item: $std->item -";
        $cred = $this->dom->createElement("gCredPresOper");
        $this->dom->addChild(
            $cred,
            "vBCCredPres",
            $this->conditionalNumberFormatting($std->vBCCredPres),
            true,
            "$identificador Valor da Base de Cálculo do Crédito Presumido da Operação (vBCCredPres)"
        );
        $this->dom->addChild(
            $cred,
            "cCredPres",
            $std->cCredPres,
            true,
            "$identificador Código de Classificação do Crédito Presumido (cCredPres)"
        );
        if (isset($std->ibs_pCredPres) && (isset($std->ibs_vCredPres) || isset($std->ibs_vCredPresCondSus))) {
            $gibs = $this->dom->createElement("gIBSCredPres");
            $this->dom->addChild(
                $gibs,
                "pCredPres",
                $this->conditionalNumberFormatting($std->ibs_pCredPres, 4),
                true,
                "$identificador Percentual do Crédito Presumido (ibs_pCredPres)"
            );
            if (!empty($std->ibs_vCredPres)) {
                $this->dom->addChild(
                    $gibs,
                    "vCredPres",
                    $this->conditionalNumberFormatting($std->ibs_vCredPres),
                    true,
                    "$identificador Valor do Crédito Presumido (ibs_vCredPres)"
                );
            } else {
                $this->dom->addChild(
                    $gibs,
                    "vCredPresCondSus",
                    $this->conditionalNumberFormatting($std->ibs_vCredPresCondSus),
                    true,
                    "$identificador Valor do Crédito Presumido em condição suspensiva. (ibs_vCredPresCondSus)"
                );
            }
            $cred->appendChild($gibs);
        }
        if (isset($std->cbs_pCredPres) && (isset($std->cbs_vCredPres) || isset($std->cbs_vCredPresCondSus))) {
            $gcbs = $this->dom->createElement("gCBSCredPres");
            $this->dom->addChild(
                $gcbs,
                "pCredPres",
                $this->conditionalNumberFormatting($std->cbs_pCredPres, 4),
                true,
                "$identificador Percentual do Crédito Presumido (cbs_pCredPres)"
            );
            if (!empty($std->cbs_vCredPres)) {
                $this->dom->addChild(
                    $gcbs,
                    "vCredPres",
                    $this->conditionalNumberFormatting($std->cbs_vCredPres),
                    true,
                    "$identificador Valor do Crédito Presumido (cbs_vCredPres)"
                );
            } else {
                $this->dom->addChild(
                    $gcbs,
                    "vCredPresCondSus",
                    $this->conditionalNumberFormatting($std->cbs_vCredPresCondSus),
                    true,
                    "$identificador Valor do Crédito Presumido em condição suspensiva. (cbs_vCredPresCondSus)"
                );
            }
            $cred->appendChild($gcbs);
        }
        $this->aGCredPresOper[$std->item] = $cred;
        return $cred;
    }
}
