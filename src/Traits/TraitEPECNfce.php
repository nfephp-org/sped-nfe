<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\Signer;
use NFePHP\Common\Strings;
use NFePHP\Common\UFList;

trait TraitEPECNfce
{
    /**
     * Check services status EPEC NFCE SEFAZ-SP only
     * @param string $uf
     * @param int|null $tpAmb
     * @param bool $ignoreContingency
     * @return string
     */
    public function sefazStatusEpecNfce(string $uf = '', ?int $tpAmb = null, bool $ignoreContingency = true): string
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        if (empty($uf)) {
            $uf = $this->config->siglaUF;
        }
        if ($this->modelo != 65) {
            throw new \InvalidArgumentException(
                'A consulta de status do serviço EPEC existe apenas para NFCe (mod. 65).'
            );
        }
        if ($uf !== 'SP') {
            throw new \InvalidArgumentException(
                'A consulta de status do serviço EPEC NFCe (mod. 65) existe apenas em SP,'
                . ' os demais estados não implementaram o serviço EPEC para NFCe.'
            );
        }
        $servico = 'EPECStatusServico';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $uf, $tpAmb, $ignoreContingency);
        $request = "<consStatServ xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<cUF>$this->urlcUF</cUF>"
            . "<xServ>STATUS</xServ>"
            . "</consStatServ>";
        $this->isValid($this->urlVersion, $request, 'consStatServ');
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Request authorization for issuance in contingency EPEC for NFCe in SP only
     * @param string $xml
     * @param string|null $verAplic
     * @return string
     */
    public function sefazEpecNfce(string &$xml, ?string $verAplic = null): string
    {
        $uf = $this->config->siglaUF;
        $eventos = [
            self::EVT_EPEC => ['versao' => '1.00', 'nome' => 'envEPEC'],
        ];
        $nSeqEvento = 1;
        //extrai os dados da NFe
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $ide  = $dom->getElementsByTagName('ide')->item(0);
        $tpEmis = (int) $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $dhCont = $ide->getElementsByTagName('dhCont')->item(0)->nodeValue ?? '';
        $xJust = $ide->getElementsByTagName('xJust')->item(0)->nodeValue ?? '';
        if ($tpEmis !== 4 || empty($dhCont) || empty($xJust)) {
            throw new \Exception(
                "A NFCe deve ser gerada em contingência EPEC para poder ser processada em contingência EPEC"
            );
        }
        $emit = $dom->getElementsByTagName('emit')->item(0);
        $dest = $dom->getElementsByTagName('dest')->item(0);
        $cOrgaoAutor = UFList::getCodeByUF($this->config->siglaUF);
        $chNFe = substr($infNFe->getAttribute('Id'), 3, 44);
        $ufchave = substr($chNFe, 0, 2);
        if ($cOrgaoAutor != $ufchave) {
            throw new \Exception("O autor [{$cOrgaoAutor}] não é da mesma UF que a NFe [{$ufchave}]");
        }
        // EPEC
        $verProc = $dom->getElementsByTagName('verProc')->item(0)->nodeValue;
        $dhEmi = $dom->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $tpNF = $dom->getElementsByTagName('tpNF')->item(0)->nodeValue;
        $emitIE = $emit->getElementsByTagName('IE')->item(0)->nodeValue;
        $destUF = $uf;
        if (!empty($dest) && isset($dest->getElementsByTagName('UF')->item(0)->nodeValue)) {
            $destUF = $dest->getElementsByTagName('UF')->item(0)->nodeValue;
        }
        $total = $dom->getElementsByTagName('total')->item(0);
        $vNF = $total->getElementsByTagName('vNF')->item(0)->nodeValue;
        $vICMS = $total->getElementsByTagName('vICMS')->item(0)->nodeValue;
        $desttag = '';
        if (!empty($dest)) {
            $dID = $dest->getElementsByTagName('CNPJ')->item(0)->nodeValue ?? null;
            if (!empty($dID)) {
                $destID = "<CNPJ>$dID</CNPJ>";
            } else {
                $dID = $dest->getElementsByTagName('CPF')->item(0)->nodeValue ?? null;
                if (!empty($dID)) {
                    $destID = "<CPF>$dID</CPF>";
                } else {
                    $dID = $dest->getElementsByTagName('idEstrangeiro')
                        ->item(0)
                        ->nodeValue;
                    $destID = "<idEstrangeiro>$dID</idEstrangeiro>";
                }
            }
            $dIE = $dest->getElementsByTagName('IE')->item(0)->nodeValue ?? null;
            $destIE = '';
            if (!empty($dIE)) {
                $destIE = "<IE>{$dIE}</IE>";
            }
            $desttag = "<dest>"
                . "<UF>{$destUF}</UF>"
                . $destID
                . $destIE
                . "</dest>";
        }
        if (empty($verAplic)) {
            if (!empty($this->verAplic)) {
                $verAplic = $this->verAplic;
            } else {
                $verAplic = $verProc;
            }
        }
        $tagAdic = "<cOrgaoAutor>$cOrgaoAutor</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>"
            . "<verAplic>{$verAplic}</verAplic>"
            . "<dhEmi>{$dhEmi}</dhEmi>"
            . "<tpNF>{$tpNF}</tpNF>"
            . "<IE>{$emitIE}</IE>"
            . $desttag
            . "<vNF>{$vNF}</vNF>"
            . "<vICMS>{$vICMS}</vICMS>";
        $servico = 'RecepcaoEPEC';
        $this->servico($servico, $uf, $this->tpAmb, true);
        $descEvento = 'EPEC';
        $cnpj = $this->config->cnpj ?? '';
        $dt = new \DateTime(date("Y-m-d H:i:sP"), new \DateTimeZone($this->timezone));
        $dt->setTimezone(new \DateTimeZone($this->timezone));
        $dhEventoString = $dt->format('Y-m-d\TH:i:sP');
        $sSeqEvento = str_pad((string)$nSeqEvento, 2, "0", STR_PAD_LEFT);
        $tpEvento = self::EVT_EPEC;
        $verEvento = '1.00';
        $eventId = "ID" . self::EVT_EPEC . $chNFe . $sSeqEvento;
        $cOrgao = UFList::getCodeByUF($uf);
        $request = "<evento versao=\"$verEvento\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>$this->tpAmb</tpAmb>";
        if ($this->typePerson === 'J') {
            $request .= "<CNPJ>$cnpj</CNPJ>";
        } else {
            $request .= "<CPF>$cnpj</CPF>";
        }
        $request .= "<chNFe>$chNFe</chNFe>"
            . "<dhEvento>$dhEventoString</dhEvento>"
            . "<tpEvento>$tpEvento</tpEvento>"
            . "<nSeqEvento>$nSeqEvento</nSeqEvento>"
            . "<verEvento>$verEvento</verEvento>"
            //em alguns casos haverá um verAplic nesta posição ??? ver xsd conciliação
            . "<detEvento versao=\"$verEvento\">"
            . "<descEvento>$descEvento</descEvento>"
            . "$tagAdic"
            . "</detEvento>"
            . "</infEvento>"
            . "</evento>";
        $lote = $dt->format('YmdHis') . random_int(0, 9);
        $request = "<envEvento xmlns=\"$this->urlPortal\" versao=\"$verEvento\">"
            . "<idLote>$lote</idLote>"
            . $request
            . "</envEvento>";
        $evt = $eventos[$tpEvento];
        //assinatura dos dados
        $request = Signer::sign(
            $this->certificate,
            $request,
            'infEvento',
            'Id',
            $this->algorithm,
            $this->canonical,
            'evento'
        );
        $this->isValid($evt['versao'], $request, 'eventoEPEC');
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }
}
