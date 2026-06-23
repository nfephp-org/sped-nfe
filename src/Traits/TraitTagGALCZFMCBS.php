<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use DOMException;

/**
 * Grupo de informações para identificação de operações em áreas incentivadas (ALC/ZFM) com alíquota zero da CBS,
 * conforme arts. 451 e 466 da LC 214/2025, quando fornecedor e destinatário estiverem nessas áreas, distinguindo a
 * existência de processo aprovado na Suframa.
 * NT 2005.002 v1.50
 * tag IBSCBS/gIBSCBS/gCBS/gALCZFMCBS (opcional)
 *
 * @property Dom $dom
 * @property array $aGALCZFMCBS
 * @method equilizeParameters($std, $possible)
 * @method conditionalNumberFormatting($value, $decimal = 2)
 */
trait TraitTagGALCZFMCBS
{
    /**
     * Grupo de operações em áreas incentivadas (ALC/ZFM) - CBS (alíquota zero) UB66a pai UB55
     *
     */
    public function taggALCZFMCBS(stdClass $std)
    {
        $possible = [
            'item',
            'tpALCZFMCBS',
            'nProcSuframa',
            'pAliqEfetRegCBS',
            'vTribRegCBS',
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = "UB66a gALCZFMCBS Item: $std->item -";
        $galc = $this->dom->createElement("gALCZFMCBS");
        $this->dom->addChild(
            $galc,
            "tpALCZFMCBS",
            $std->tpALCZFMCBS,
            true,
            "$identificador Tipo de aplicação da alíquota zero da CBS (tpALCZFMCBS)"
        );
        $this->dom->addChild(
            $galc,
            "nProcSuframa",
            $std->nProcSuframa,
            false,
            "$identificador Número do processo na Suframa para o item comercializado (nProcSuframa)"
        );
        $this->dom->addChild(
            $galc,
            "pAliqEfetRegCBS",
            $this->conditionalNumberFormatting($std->pAliqEfetRegCBS, 4),
            true,
            "$identificador Percentual efetivo sem a redução (pAliqEfetRegCBS)"
        );
        $this->dom->addChild(
            $galc,
            "vTribRegCBS",
            $this->conditionalNumberFormatting($std->vTribRegCBS, 2),
            true,
            "$identificador Valor efetivo sem a redução (vTribRegCBS)"
        );
        $this->aGALCZFMCBS[$std->item] = $galc;
        return $galc;
    }
}
