<?php

namespace NFePHP\NFe\Factories;

use NFePHP\Common\Strings;
use NFePHP\Common\Signer;
use NFePHP\Common\Keys;
use NFePHP\Common\TimeZoneByUF;
use NFePHP\Common\UFList;
use DateTime;

class ContingencyNFe
{
    /**
     * Corrects NFe fields when in contingency mode
     * @param string $xml NFe xml content
     */
    public static function adjust(string $xml, Contingency $contingency): string
    {
        if ($contingency->type === '') {
            return $xml;
        }
        $xml = Signer::removeSignature($xml);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        $ide = $dom->getElementsByTagName('ide')->item(0);
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $cNF = $ide->getElementsByTagName('cNF')->item(0)->nodeValue;
        $nNF = $ide->getElementsByTagName('nNF')->item(0)->nodeValue;
        $serie = $ide->getElementsByTagName('serie')->item(0)->nodeValue;
        $mod = $ide->getElementsByTagName('mod')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $dhCont = $ide->getElementsByTagName('dhCont')->item(0)->nodeValue ?? null;
        $xJust = $ide->getElementsByTagName('xJust')->item(0)->nodeValue ?? null;
        if ($mod == 65) {
            throw new \RuntimeException(
                'O xml pertence a um documento modelo 65 NFCe, incorreto para contingência SVCAN ou SVCRS.'
            );
        }
        if ($tpEmis != 1) {
            //xml já foi emitido em contingência, não há a necessidade de ajuste dos dados do xml
            return $xml;
        }
        $dtEmi = new DateTime($ide->getElementsByTagName('dhEmi')->item(0)->nodeValue);
        $ano = $dtEmi->format('y');
        $mes = $dtEmi->format('m');
        //altera o tpEmis de 1 para o modo SVCRS[7] ou SVCAN[6]
        $tpEmis = (string) $contingency->tpEmis;
        $emit = $dom->getElementsByTagName('emit')->item(0);
        if (!empty($emit->getElementsByTagName('CNPJ')->item(0)->nodeValue)) {
            $doc = $emit->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        } else {
            $doc = $emit->getElementsByTagName('CPF')->item(0)->nodeValue;
        }
        $motivo = trim(Strings::replaceUnacceptableCharacters($contingency->motive));
        //verifica o timezone no estado emitente
        $tztext = TimeZoneByUF::get(UFList::getUFByCode((int)$cUF));
        $tz = new \DateTimeZone($tztext);
        //cria um DateTime::class com o timestamp (GMT)
        $dt = new \DateTime(gmdate("Y-m-d H:i:s", $contingency->timestamp));
        //seta o timezone no DateTime::class para o estado emissor
        $dt->setTimezone($tz);
        //gera a data de entrada em contingência no timezone do emitente baseado no <ide><cUF> do XML
        $dthCont = $dt->format('Y-m-d\TH:i:sP');
        //modifica a tag <tpEmis>
        $ide->getElementsByTagName('tpEmis')
            ->item(0)
            ->nodeValue = $contingency->tpEmis;
        //verifica se existem documentos referenciados no xml
        $nfref = $ide->getElementsByTagName('NFref')->item(0) ?? null;
        if (!empty($ide->getElementsByTagName('dhCont')->item(0)->nodeValue)) {
            //caso não tenha a tag <dhCont>, inserir na tag <ide>
            $ide->getElementsByTagName('dhCont')
                ->item(0)
                ->nodeValue = $dthCont;
        } else {
            $dhCont = $dom->createElement('dhCont', $dthCont);
            if (!empty($nfref)) {
                $ide->insertBefore($dhCont, $nfref);
            } else {
                $ide->appendChild($dhCont);
            }
        }
        if (!empty($ide->getElementsByTagName('xJust')->item(0)->nodeValue)) {
            $ide->getElementsByTagName('xJust')->item(0)->nodeValue = $motivo;
        } else {
            $xJust = $dom->createElement('xJust', $motivo);
            if (!empty($nfref)) {
                $ide->insertBefore($xJust, $nfref);
            } else {
                $ide->appendChild($xJust);
            }
        }
        //corrigir a chave
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $chave = Keys::build(
            $cUF,
            $ano,
            $mes,
            $doc,
            $mod,
            $serie,
            $nNF,
            $tpEmis,
            $cNF
        );
        $ide->getElementsByTagName('cDV')->item(0)->nodeValue = substr($chave, -1);
        $infNFe->setAttribute('Id', 'NFe' . $chave);
        return Strings::clearXmlString($dom->saveXML(), true);
    }
}
