<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved;
use NFePHP\Common\Keys;
use NFePHP\Common\Strings;
use NFePHP\Common\TimeZoneByUF;
use stdClass;
use DOMElement;
use DateTime;
use DateTimeZone;

/**
 * @property DOMImproved $dom
 * @property array $errors
 * @property int $schema
 * @property string $tpAmb
 * @property string $mod
 * @property DOMElement $ide
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagIde
{
    /**
     * Informações de identificação da NF-e B01 pai A01
     * NOTA: Ajustado para NT2020_006_v1.00
     * tag NFe/infNFe/ide
     */
    public function tagide(stdClass $std): DOMElement
    {
        $possible = [
            'cUF',
            'cNF',
            'natOp',
            'indPag',
            'mod',
            'serie',
            'nNF',
            'dhEmi',
            'dhSaiEnt',
            'tpNF',
            'idDest',
            'cMunFG',
            'cMunFGIBS',
            'tpImp',
            'tpEmis',
            'tpNFDebito',
            'tpNFCredito',
            'cDV',
            'tpAmb',
            'finNFe',
            'indFinal',
            'indPres',
            'indIntermed',
            'procEmi',
            'verProc',
            'dhCont',
            'xJust'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'B01 <ide> - ';
        //proteção em função do modelo de schema, nullificar campos não pertencentes ao schema.
        if ($this->schema < 10) {
            $std->cMunFGIBS = null;
            $std->tpNFDebito = null;
            $std->tpNFCredito = null;
        }
        if (empty($std->cNF)) {
            $std->cNF = Keys::random($std->nNF);
        } else {
            $cnf = substr(Strings::onlyNumbers($std->cNF), 0, 8);
            $std->cNF = str_pad($cnf, 8, '0', STR_PAD_LEFT);
        }
        if (empty($std->cDV)) {
            $std->cDV = 0;
        }
        if (empty($std->dhEmi)) {
            try {
                $tz = TimeZoneByUF::get($std->cUF);
                $std->dhEmi = (new DateTime('now', new DateTimeZone($tz)))->format('Y-m-d\TH:i:sP');
            } catch (\Exception $e) {
                $this->errors[] = "$identificador Campo cUF incorreto !";
            }
        }
        if (!empty($std->dhSaiEnt)) {
            $tze = substr($std->dhEmi, -5);
            $tzs = substr($std->dhSaiEnt, -5);
            if ($tze !== $tzs) {
                $this->errors[] = 'A data de saída (dhSaiEnt) não pode estar em um TIMEZONE '
                    . 'diferente da data de emissão (dhEmi).';
            }
            $tmse = DateTime::createFromFormat('Y-m-d\TH:i:sP', $std->dhEmi);
            $tmse->setTimezone(new DateTimeZone('UTC'));
            $tmss = DateTime::createFromFormat('Y-m-d\TH:i:sP', $std->dhSaiEnt);
            $tmss->setTimezone(new DateTimeZone('UTC'));
            if ($tmss->getTimestamp() < $tmse->getTimestamp()) {
                $this->errors[] = "$identificador A data de saída (dhSaiEnt) não pode ser menor "
                    . "que a data de emissão (dhEmi).";
            }
        }
        //validação conforme NT 2019.001
        if (!empty($std->cNF)) {
            $std->cNF = str_pad($std->cNF, 8, '0', STR_PAD_LEFT);
            if (intval($std->cNF) == intval($std->nNF)) {
                $this->errors[] = "$identificador O valor $std->cNF não é aceitável para cNF, não pode "
                    . "ser igual ao de nNF.";
            }
            if (method_exists(Keys::class, 'cNFIsValid')) {
                if (!Keys::cNFIsValid($std->cNF)) {
                    $this->errors[] = "$identificador O valor $std->cNF para cNF é invalido.";
                }
            }
        }
        $this->tpAmb = $std->tpAmb;
        $this->mod = $std->mod;

        $ide = $this->dom->createElement("ide");
        $this->dom->addChild(
            $ide,
            "cUF",
            $std->cUF,
            true,
            $identificador . "Código da UF do emitente do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "cNF",
            $std->cNF,
            true,
            $identificador . "Código Numérico que compõe a Chave de Acesso"
        );
        $this->dom->addChild(
            $ide,
            "natOp",
            $std->natOp,
            true,
            $identificador . "Descrição da Natureza da Operação"
        );
        $this->dom->addChild(
            $ide,
            "mod",
            $std->mod,
            true,
            $identificador . "Código do Modelo do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "serie",
            $std->serie,
            true,
            $identificador . "Série do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "nNF",
            $std->nNF,
            true,
            $identificador . "Número do Documento Fiscal"
        );
        $this->dom->addChild(
            $ide,
            "dhEmi",
            $std->dhEmi,
            true,
            $identificador . "Data e hora de emissão do Documento Fiscal"
        );
        if ($std->mod == '55' && !empty($std->dhSaiEnt)) {
            $this->dom->addChild(
                $ide,
                "dhSaiEnt",
                $std->dhSaiEnt,
                false,
                $identificador . "Data e hora de Saída ou da Entrada da Mercadoria/Produto"
            );
        }
        $this->dom->addChild(
            $ide,
            "tpNF",
            $std->tpNF,
            true,
            $identificador . "Tipo de Operação"
        );
        $this->dom->addChild(
            $ide,
            "idDest",
            $std->idDest,
            true,
            $identificador . "Identificador de local de destino da operação"
        );
        $this->dom->addChild(
            $ide,
            "cMunFG",
            $std->cMunFG,
            true,
            $identificador . "Código do Município de Ocorrência do Fato Gerador"
        );
        //PL_010 NT_2025.002v1.01
        if ($this->schema > 9) {
            $this->dom->addChild(
                $ide,
                "cMunFGIBS",
                $std->cMunFGIBS,
                false,
                $identificador . "Código do Município de Ocorrência do Fato Gerador do IBS/CSB"
            );
        }
        $this->dom->addChild(
            $ide,
            "tpImp",
            $std->tpImp,
            true,
            $identificador . "Formato de Impressão do DANFE"
        );
        $this->dom->addChild(
            $ide,
            "tpEmis",
            $std->tpEmis,
            true,
            $identificador . "Tipo de Emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "cDV",
            !empty($std->cDV) ? $std->cDV : '0',
            true,
            $identificador . "Dígito Verificador da Chave de Acesso da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "tpAmb",
            $std->tpAmb,
            true,
            $identificador . "Identificação do Ambiente"
        );
        $this->dom->addChild(
            $ide,
            "finNFe",
            $std->finNFe,
            true,
            $identificador . "Finalidade de emissão da NF-e"
        );
        //PL_010 NT_2025.002v1.01
        if ($this->schema > 9) {
            $this->dom->addChild(
                $ide,
                "tpNFDebito",
                $std->tpNFDebito,
                false,
                $identificador . "Tipo de Nota de Débito"
            );
            $this->dom->addChild(
                $ide,
                "tpNFCredito",
                $std->tpNFCredito,
                false,
                $identificador . "Tipo de Nota de Crédito"
            );
        }
        $this->dom->addChild(
            $ide,
            "indFinal",
            $std->indFinal,
            true,
            $identificador . "Indica operação com Consumidor final"
        );
        $this->dom->addChild(
            $ide,
            "indPres",
            $std->indPres,
            true,
            $identificador . "Indicador de presença do comprador no estabelecimento comercial no momento da operação"
        );
        $this->dom->addChild(
            $ide,
            "indIntermed",
            $std->indIntermed,
            false,
            $identificador . "Indicador de intermediador/marketplace"
        );
        $this->dom->addChild(
            $ide,
            "procEmi",
            $std->procEmi,
            true,
            $identificador . "Processo de emissão da NF-e"
        );
        $this->dom->addChild(
            $ide,
            "verProc",
            $std->verProc,
            true,
            $identificador . "Versão do Processo de emissão da NF-e"
        );
        if (!empty($std->dhCont) && !empty($std->xJust)) {
            $this->dom->addChild(
                $ide,
                "dhCont",
                $std->dhCont,
                true,
                $identificador . "Data e Hora da entrada em contingência"
            );
            $this->dom->addChild(
                $ide,
                "xJust",
                $std->xJust,
                true,
                $identificador . "Justificativa da entrada em contingência"
            );
        }
        $this->ide = $ide;
        return $ide;
    }
}
