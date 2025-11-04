<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use NFePHP\Common\Keys;
use DOMElement;

/**
 * @property Dom $dom
 * @property array $aVItem
 * @property array $stdTot
 * @property string $chNFe
 * @property string $aProd
 */
trait TraitCalculations
{
    /**
     * Calculates and updates the value of items based on various parameters.
     * Adjusts item values based on the operation type and specific financial attributes.
     * Updates the calculated value for each item in the internal data structure.
     *
     * @return void
     */
    protected function calculateTtensValues1()
    {
        $this->stdTot->vNFTotCalculated = 0;
        $year = date('Y');
        foreach ($this->aVItem as $nItem => $data) {
            $value = 0;
            if (empty($data->tpOp) || $data->tpOp != 2) {
                $value += ($data['vProd'] ?? 0)
                    - ($data['vDesc'] ?? 0)
                    + ($data['vICMSST'] ?? 0)
                    + ($data['vICMSMonoReten'] ?? 0)
                    + ($data['vFCPST'] ?? 0)
                    + ($data['vFrete'] ?? 0)
                    + ($data['vSeg'] ?? 0)
                    + ($data['vOutro'] ?? 0)
                    + ($data['vII'] ?? 0)
                    + ($data['vIPI'] ?? 0)
                    + ($data['vIPIDevol'] ?? 0)
                    + ($data['vServ'] ?? 0);
                $value -= ($data['indDeduzDeson'] == 1) ? ($data['vDescDeson'] ?? 0) : 0;
                $value += ($data['indSomaPISST'] == 1) ? ($data['vPISST'] ?? 0) : 0;
                $value += ($data['indSomaCOFINSST'] == 1) ? ($data['vCOFINSST'] ?? 0) : 0;
                if ($year >= 2026) {
                    $value = ($data['vIBS'] ?? 0)
                        + ($data['vCBS'] ?? 0)
                        + ($data['vIS'] ?? 0)
                        + ($data['vTotIBSMoniItem'] ?? 0)
                        + ($data['vTotCBSMoniItem'] ?? 0);
                }
                $this->aVItem[$nItem]['vItemCalculated'] = $value;
            } elseif ($data->tpOp == 2) {
                //Operação de Faturamento Direto para veículos novos
                $value += ($data['vProd'] ?? 0)
                    - ($data['vDesc'] ?? 0)
                    + ($data['vFrete'] ?? 0)
                    + ($data['vSeg'] ?? 0)
                    + ($data['vOutro'] ?? 0)
                    + ($data['vII'] ?? 0)
                    + ($data['vIPI'] ?? 0)
                    + ($data['vServ'] ?? 0);
                $value -= ($data['indDeduzDeson'] == 1) ? ($data['vDescDeson'] ?? 0) : 0;
                $value += ($data['indSomaPISST'] == 1) ? ($data['vPISST'] ?? 0) : 0;
                $value += ($data['indSomaCOFINSST'] == 1) ? ($data['vCOFINSST'] ?? 0) : 0;
                if ($year >= 2026) {
                    $value = ($data['vIBS'] ?? 0)
                        + ($data['vCBS'] ?? 0)
                        + ($data['vIS'] ?? 0);
                }
                $this->aVItem[$nItem]['vItemCalculated'] = $value;
            }
            if ($data->indTot == 0) {
                $this->stdTot->vNFTotCalculated += $value;
            }
        }
    }

    /**
     * Calcula o vItem compo introduzido com o PL_010 que se refere ao total do item com o IBS/CBS/IS
     * @return void
     */
    protected function calculateTtensValues2(DOMElement $det)
    {
        $year = date('Y');
        $item = $det->getAttribute('nItem');
        $indTot = $det->getElementsByTagName("indTot")->item(0)->nodeValue;
        $veicProd = $det->getElementsByTagName("veicProd")->item(0) ?? null;
        $imposto = $det->getElementsByTagName("imposto")->item(0);
        $impostoDevol = $det->getElementsByTagName("imposto")->item(0) ?? null;
        $icms = $imposto->getElementsByTagName("ICMS")->item(0) ?? null;
        $ipi = $imposto->getElementsByTagName("IPI")->item(0) ?? null;
        $ii = $imposto->getElementsByTagName("II")->item(0) ?? null;
        $pisst = $imposto->getElementsByTagName("PISST")->item(0) ?? null;
        $cofinsst = $imposto->getElementsByTagName("COFINSST")->item(0) ?? null;
        $is = $imposto->getElementsByTagName("IS")->item(0) ?? null;
        $cbs = $imposto->getElementsByTagName("IBSCBS")->item(0) ?? null;
        $tpOP = 0;
        if (!empty($veicProd)) {
            $value = $veicProd->getElementsByTagName("tpOp")->item(0)->nodeValue ?? null;
            $tpOP = (int)isset($value) ? $value : 0;
        }
        //Valor do imposto de importação
        $vII = 0;
        if (!empty($ii)) {
            $value = $ii->getElementsByTagName("vII")->item(0)->nodeValue ?? null;
            $vII = (float)!empty($value) ? $value : 0;
        }
        $vProd = (float)!empty($det->getElementsByTagName("vProd")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vProd")->item(0)->nodeValue : 0;
        $vDesc = (float)!empty($det->getElementsByTagName("vDesc")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vDesc")->item(0)->nodeValue : 0;
        $vFrete = (float)!empty($det->getElementsByTagName("vFrete")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vFrete")->item(0)->nodeValue : 0;
        $vSeg = (float)!empty($det->getElementsByTagName("vSeg")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vSeg")->item(0)->nodeValue : 0;
        $vOutro = (float)!empty($det->getElementsByTagName("vOutro")->item(0)->nodeValue) ?
            $det->getElementsByTagName("vOutro")->item(0)->nodeValue : 0;
        $icmsdeson = 0;
        $vICMSST = 0;
        $vICMSMonoReten = 0;
        $vFCPST = 0;
        if (!empty($icms)) {
            //aplica desoneração caso indDeduzDeson = 1
            $indDeduzDeson = (int)!empty($icms->getElementsByTagName("indDeduzDeson")
                ->item(0)->nodeValue) ?
                $icms->getElementsByTagName("indDeduzDeson")->item(0)->nodeValue :
                0;
            $vICMSDeson = (float)!empty($icms->getElementsByTagName("vICMSDeson")
                ->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vICMSDeson")->item(0)->nodeValue : 0;
            $vICMSDeson = ($indDeduzDeson == 1) ? $vICMSDeson : 0;
            $vICMSST = (float)!empty($icms->getElementsByTagName("vICMSST")->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vICMSST")->item(0)->nodeValue : 0;
            $vICMSMonoReten = (float)!empty($icms->getElementsByTagName("vICMSMonoReten")
                ->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vICMSMonoReten")->item(0)->nodeValue : 0;
            $vFCPST = (float)!empty($icms->getElementsByTagName("vFCPST")->item(0)->nodeValue) ?
                $icms->getElementsByTagName("vFCPST")->item(0)->nodeValue : 0;
        }
        //IPI
        $vIPI = 0;
        if (!empty($ipi)) {
            $vIPI = (float)!empty($ipi->getElementsByTagName("vIPI")->item(0)->nodeValue) ?
                $ipi->getElementsByTagName("vIPI")->item(0)->nodeValue : 0;
        }
        //IPIDevol
        $vIPIDevol = 0;
        if (!empty($impostoDevol)) {
            $vIPIDevol = (float)!empty($impostoDevol->getElementsByTagName("vIPIDevol")
                ->item(0)->nodeValue) ?
                $impostoDevol->getElementsByTagName("vIPIDevol")->item(0)->nodeValue : 0;
        }
        //Serviços
        $vServ = 0; //esse campo não existe no item mas é igual a vProd !! ignorar
        //PISST
        $vPISST = 0;
        if (!empty($pisst)) {
            $indSomaPISST = (int)!empty($pisst->getElementsByTagName("indSomaPISST")
                ->item(0)->nodeValue) ?
                $pisst->getElementsByTagName("indSomaPISST")->item(0)->nodeValue : 0;
            $vPISST = (float)!empty($pisst->getElementsByTagName("vPIS")->item(0)->nodeValue) ?
                $pisst->getElementsByTagName("vPIS")->item(0)->nodeValue : 0;
            $vPISST = $vPISST * $indSomaPISST;
        }
        //COFINSST
        $vCOFINSST = 0;
        if (!empty($cofinsst)) {
            $indSomaCOFINSST = (int)!empty($cofinsst->getElementsByTagName("indSomaCOFINSST")
                ->item(0)->nodeValue) ?
                $cofinsst->getElementsByTagName("indSomaCOFINSST")->item(0)->nodeValue : 0;
            $vCOFINSST = (float)!empty($cofinsst->getElementsByTagName("vCOFINS")->item(0)->nodeValue)
                ? $cofinsst->getElementsByTagName("vCOFINS")->item(0)->nodeValue : 0;
            $vCOFINSST = $vCOFINSST * $indSomaCOFINSST;
        }
        //IBSCBS
        $vIBSUF = 0.00;
        $vIBSMun = 0.00;
        $vCBS = 0.00;
        $vIBS = 0.00;
        $vTotIBSMonoItem = 0.00;
        $vTotCBSMonoItem = 0.00;
        if (!empty($cbs) && $this->schema > 9) {
            $vIBSUF = (float)!empty($cbs->getElementsByTagName("vIBSUF")->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vIBSUF")->item(0)->nodeValue : 0;
            $vIBSMun = (float)!empty($cbs->getElementsByTagName("vIBSMun")->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vIBSMun")->item(0)->nodeValue : 0;
            $vIBS = $vIBSUF + $vIBSMun;
            $vCBS = (float)!empty($cbs->getElementsByTagName("vCBS")->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vCBS")->item(0)->nodeValue : 0;
            $vTotIBSMonoItem = (float)!empty($cbs->getElementsByTagName("vTotIBSMonoItem")
                ->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vTotIBSMonoItem")->item(0)->nodeValue : 0;
            $vTotCBSMonoItem = (float)!empty($cbs->getElementsByTagName("vTotCBSMonoItem")
                ->item(0)->nodeValue) ?
                $cbs->getElementsByTagName("vTotCBSMonoItem")->item(0)->nodeValue : 0;
        }
        //IS
        $vIS = 0.00;
        if (!empty($is) && $this->schema > 9) {
            $vIS = (float)!empty($is->getElementsByTagName("vIS")->item(0)->nodeValue) ?
                $is->getElementsByTagName("vIS")->item(0)->nodeValue : 0;
        }
        //Somatório
        if ($tpOP != 2) {
            //todas as operações exceto venda de veiculos novos
            $vitem =
                $vProd
                - $vDesc
                - $icmsdeson
                + $vICMSST
                + $vICMSMonoReten
                + $vFCPST
                + $vFrete
                + $vSeg
                + $vOutro
                + $vII
                + $vIPI
                + $vIPIDevol
                + $vServ
                + $vPISST
                + $vCOFINSST;
            if ($year >= 2026) {
                $vitem += $vIBS
                    + $vCBS
                    + $vIS
                    + $vTotIBSMonoItem
                    + $vTotCBSMonoItem;
            }
        } else {
            //venda de veiculos novos
            $vitem =
                $vProd
                - $vDesc
                - $icmsdeson
                + $vFrete
                + $vSeg
                + $vOutro
                + $vII
                + $vIPI
                + $vServ
                + $vPISST
                + $vCOFINSST;
            if ($year >= 2026) {
                $vitem += $vIBS
                    + $vCBS
                    + $vIS;
            }
        }
        $this->aVItem[$item]['vItemCalculated'] = $vitem;
        if ($indTot == 1) {
            $this->stdTot->vNFTotCalculated += $vitem;
        }
    }

    /**
     * Recalcula o valor de vNFTot com base nos valores já inseridos no XML
     * @return float
     */
    protected function reCalculateNFTotValue(): float
    {
        $dets = $this->infNFe->getElementsByTagName('det');
        $vNFTot = 0;
        foreach ($dets as $det) {
            $indTot = $det->getElementsByTagName('indTot')->item(0)->nodeValue;
            $vItem = $det->getElementsByTagName('vItem')->item(0)->nodeValue;
            if ($indTot == 1) {
                $vNFTot += $vItem;
            }
        }
        return $vNFTot;
    }

    /**
     * Remonta a chave da NFe de 44 digitos com base em seus dados
     * já contidos na NFE.
     * Isso é útil no caso da chave informada estar errada
     * se a chave estiver errada a mesma é substituida
     * @param Dom $dom
     * @return void
     * @throws \Exception
     */
    protected function checkNFeKey(Dom $dom): void
    {
        try {
            $infNFe = $dom->getElementsByTagName("infNFe")->item(0);
            $ide = $dom->getElementsByTagName("ide")->item(0);
            if (empty($ide)) {
                return;
            }
            $emit = $dom->getElementsByTagName("emit")->item(0);
            if (empty($emit)) {
                return;
            }
            $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
            $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
            if (!empty($emit->getElementsByTagName('CNPJ')->item(0)->nodeValue)) {
                $doc = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
            } else {
                $doc = $emit->getElementsByTagName('CPF')->item(0)->nodeValue;
            }
            $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
            $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
            $nNF = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
            $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
            $cNF = $ide->getElementsByTagName('cNF')->item(0)->nodeValue;
            $chave = str_replace('NFe', '', $infNFe->getAttribute("Id"));
            $dt = new \DateTime($dhEmi);
            $infRespTec = $dom->getElementsByTagName("infRespTec")->item(0);
            $chaveMontada = Keys::build(
                $cUF,
                $dt->format('y'),
                $dt->format('m'),
                $doc,
                $mod,
                $serie,
                $nNF,
                $tpEmis,
                $cNF
            );
            if (empty($chave)) {
                //chave não foi passada por parâmetro então colocar a chavemontada
                $infNFe->setAttribute('Id', "NFe$chaveMontada");
                $chave = $chaveMontada;
                $this->chNFe = $chaveMontada;
                $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chave, -1);
                //trocar também o hash se o CSRT for passado
                if (!empty($this->csrt)) {
                    $hashCSRT = $this->hashCSRT($this->csrt);
                    $infRespTec->getElementsByTagName("hashCSRT")
                        ->item(0)->nodeValue = $hashCSRT;
                }
            }
            //caso a chave contida na NFe esteja errada
            //substituir a chave
            if ($chaveMontada != $chave) {
                $this->chNFe = $chaveMontada;
                $this->errors[] = "A chave informada está incorreta [$chave] => [correto: $chaveMontada].";
            }
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
        }
    }
}
