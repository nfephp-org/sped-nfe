<?php

namespace NFePHP\NFe\Traits;

use stdClass;
use DOMElement;
use DOMException;
use NFePHP\Common\DOMImproved as Dom;

/**
 * @property Dom $dom
 * @property DOMElement $infAdic
 * @property array $aObsCont
 * @property array $aObsFisco
 * @property array $aProcRef
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagInfAdic
{
    /**
     * Grupo de Informações Adicionais Z01 pai A01
     * tag NFe/infNFe/infAdic (opcional)
     */
    public function taginfAdic(stdClass $std): DOMElement
    {
        $possible = ['infAdFisco', 'infCpl'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'Z01 infAdic -';
        $this->infAdic = $this->dom->createElement("infAdic");
        $this->dom->addChild(
            $this->infAdic,
            "infAdFisco",
            $std->infAdFisco,
            false,
            "$identificador Informações adicionais de interesse do Fisco (infAdFisco)"
        );
        $this->dom->addChild(
            $this->infAdic,
            "infCpl",
            $std->infCpl,
            false,
            "$identificador Informações Complementares de interesse do Contribuinte (infCpl)"
        );
        return $this->infAdic;
    }

    /**
     * Grupo Campo de uso livre do contribuinte Z04 pai Z01
     * tag NFe/infNFe/infAdic/obsCont (opcional)
     */
    public function tagobsCont(stdClass $std): DOMElement
    {
        $possible = ['xCampo', 'xTexto'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = ' obsCont -';
        $obsCont = $this->dom->createElement("obsCont");
        $obsCont->setAttribute("xCampo", $std->xCampo ?? '');
        $this->dom->addChild(
            $obsCont,
            "xTexto",
            $std->xTexto ?? '',
            true,
            "$identificador Conteúdo do campo"
        );
        $this->aObsCont[] = $obsCont;
        return $obsCont;
    }

    /**
     * Grupo Campo de uso livre do Fisco Z07 pai Z01
     * tag NFe/infNFe/infAdic/obsFisco (opcional)
     */
    public function tagobsFisco(stdClass $std): DOMElement
    {
        $possible = ['xCampo', 'xTexto'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = ' obsCont -';
        $obsFisco = $this->dom->createElement("obsFisco");
        $obsFisco->setAttribute("xCampo", $std->xCampo ?? '');
        $this->dom->addChild(
            $obsFisco,
            "xTexto",
            $std->xTexto ?? '',
            true,
            "$identificador Conteúdo do campo"
        );
        $this->aObsFisco[] = $obsFisco;
        return $obsFisco;
    }

    /**
     * Grupo Processo referenciado Z10 pai Z01
     * tag NFe/infNFe/procRef (opcional)
     */
    public function tagprocRef(stdClass $std): DOMElement
    {
        $possible = ['nProc', 'indProc', 'tpAto'];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = ' procRef -';
        $procRef = $this->dom->createElement("procRef");
        $this->dom->addChild(
            $procRef,
            "nProc",
            $std->nProc,
            true,
            "$identificador Identificador do processo ou ato concessório"
        );
        $this->dom->addChild(
            $procRef,
            "indProc",
            $std->indProc,
            true,
            "$identificador Indicador da origem do processo"
        );
        $this->dom->addChild(
            $procRef,
            "tpAto",
            $std->tpAto,
            false,
            "$identificador Tipo do ato concessório"
        );
        $this->aProcRef[] = $procRef;
        return $procRef;
    }

    /**
     * @return void
     * @throws DOMException
     */
    protected function buildInfoTags()
    {
        $exists = !empty($this->infAdic);
        if (!$exists && (!empty($this->aObsCont) || !empty($this->aObsFisco) || !empty($this->aProcRef))) {
            $this->infAdic = $this->dom->createElement("infAdic");
        }
        if (!empty($this->aObsCont)) {
            if (count($this->aObsCont) > 10) {
                $this->errors[] = "As tags obsCont são limitadas a 10 registros.";
                $this->aObsCont = array_slice($this->aObsCont, 0, 10);
            }
            foreach ($this->aObsCont as $obsCont) {
                $this->infAdic->appendChild($obsCont);
            }
        }
        if (!empty($this->aObsFisco)) {
            if (count($this->aObsCont) > 10) {
                $this->errors[] = "As tags obsFisco são limitadas a 10 registros.";
                $this->aObsFisco = array_slice($this->aObsFisco, 0, 10);
            }
            foreach ($this->aObsFisco as $obsFisco) {
                $this->infAdic->appendChild($obsFisco);
            }
        }
        if (!empty($this->aProcRef)) {
            if (count($this->aProcRef) > 100) {
                $this->errors[] = "As tags procRef são limitadas a 100 registros.";
                $this->aProcRef = array_slice($this->aProcRef, 0, 100);
            }
            foreach ($this->aProcRef as $proc) {
                $this->infAdic->appendChild($proc);
            }
        }
    }
}
