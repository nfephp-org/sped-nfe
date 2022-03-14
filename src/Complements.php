<?php

namespace NFePHP\NFe;

use NFePHP\Common\Strings;
use NFePHP\NFe\Common\Standardize;
use NFePHP\NFe\Exception\DocumentsException;
use DOMDocument;

class Complements
{
    protected static $urlPortal = 'http://www.portalfiscal.inf.br/nfe';

    /**
     * Authorize document adding his protocol
     */
    public static function toAuthorize(string $request, string $response): string
    {
        if (empty($request)) {
            throw new DocumentsException('Erro ao protocolar !! o xml '
                . 'a protocolar está vazio.');
        }
        if (empty($response)) {
            throw new DocumentsException('Erro ao protocolar !!'
                . ' O retorno da sefaz está vazio.');
        }
        $st = new Standardize();
        $key = ucfirst($st->whichIs($request));
        if ($key != 'NFe' && $key != 'EnvEvento' && $key != 'InutNFe') {
            //wrong document, this document is not able to recieve a protocol
            throw DocumentsException::wrongDocument(0, $key);
        }
        $func = "add" . $key . "Protocol";
        return self::$func($request, $response);
    }

    /**
     * Add tags B2B, as example ANFAVEA
     * @param  string $nfe xml nfe string content
     * @param  string $b2b xml b2b string content
     * @param  string $tagB2B name B2B tag default 'NFeB2BFin' from ANFAVEA
     * @throws \InvalidArgumentException
     */
    public static function b2bTag(string $nfe, string $b2b, string $tagB2B = 'NFeB2BFin'): string
    {
        $domnfe = new DOMDocument('1.0', 'UTF-8');
        $domnfe->preserveWhiteSpace = false;
        $domnfe->formatOutput = false;
        $domnfe->loadXML($nfe);
        $nodenfe = $domnfe->getElementsByTagName('nfeProc')->item(0);
        if (empty($nodenfe)) {
            //not is NFe or dont protocoladed doc
            throw DocumentsException::wrongDocument(1);
        }
        //carrega o arquivo B2B
        $domb2b = new DOMDocument('1.0', 'UTF-8');
        $domb2b->preserveWhiteSpace = false;
        $domb2b->formatOutput = false;
        $domb2b->loadXML($b2b);
        $nodeb2b = $domnfe->getElementsByTagName($tagB2B)->item(0);
        if (empty($nodeb2b)) {
            //xml is not protocoladed or dont is a NFe
            throw DocumentsException::wrongDocument(2);
        }
        //cria a NFe processada com a tag do protocolo
        $procb2b = new DOMDocument('1.0', 'UTF-8');
        $procb2b->preserveWhiteSpace = false;
        $procb2b->formatOutput = false;
        //cria a tag nfeProc
        $nfeProcB2B = $procb2b->createElement('nfeProcB2B');
        $procb2b->appendChild($nfeProcB2B);
        //inclui a tag NFe
        $node1 = $procb2b->importNode($nodenfe, true);
        $nfeProcB2B->appendChild($node1);
        //inclui a tag NFeB2BFin
        $node2 = $procb2b->importNode($nodeb2b, true);
        $nfeProcB2B->appendChild($node2);
        $nfeb2bXML = $procb2b->saveXML();
        $nfeb2bXMLString = str_replace(array("\n","\r","\s"), '', $nfeb2bXML);
        return (string) $nfeb2bXMLString;
    }

    /**
     * Add cancel protocol to a autorized NFe
     * if event is not a cancellation will return
     * the same autorized NFe passing
     * NOTE: This action is not necessary, I use only for my needs to
     *       leave the NFe marked as Canceled in order to avoid mistakes
     *       after its cancellation.
     * @param  string $nfe content of autorized NFe XML
     * @param  string $cancelamento content of SEFAZ response
     * @throws \InvalidArgumentException
     */
    public static function cancelRegister(string $nfe, string $cancelamento): string
    {
        $procXML = $nfe;
        $domnfe = new DOMDocument('1.0', 'utf-8');
        $domnfe->formatOutput = false;
        $domnfe->preserveWhiteSpace = false;
        $domnfe->loadXML($nfe);
        $nfeproc = $domnfe->getElementsByTagName('nfeProc')->item(0);
        $proNFe = $domnfe->getElementsByTagName('protNFe')->item(0);
        if (empty($proNFe)) {
            //not protocoladed NFe
            throw DocumentsException::wrongDocument(1);
        }
        $chaveNFe = $proNFe->getElementsByTagName('chNFe')->item(0)->nodeValue;
        $domcanc = new DOMDocument('1.0', 'utf-8');
        $domcanc->formatOutput = false;
        $domcanc->preserveWhiteSpace = false;
        $domcanc->loadXML($cancelamento);
        $eventos = $domcanc->getElementsByTagName('retEvento');
        foreach ($eventos as $evento) {
            $infEvento = $evento->getElementsByTagName('infEvento')->item(0);
            $cStat = $infEvento->getElementsByTagName('cStat')
                ->item(0)
                ->nodeValue;
            $nProt = $infEvento->getElementsByTagName('nProt')
                ->item(0)
                ->nodeValue;
            $chaveEvento = $infEvento->getElementsByTagName('chNFe')
                ->item(0)
                ->nodeValue;
            $tpEvento = $infEvento->getElementsByTagName('tpEvento')
                ->item(0)
                ->nodeValue;
            if (
                in_array($cStat, ['135', '136', '155'])
                && ($tpEvento == Tools::EVT_CANCELA
                    || $tpEvento == Tools::EVT_CANCELASUBSTITUICAO
                )
                && $chaveEvento == $chaveNFe
            ) {
                $node = $domnfe->importNode($evento, true);
                $domnfe->documentElement->appendChild($node);
                break;
            }
        }
        return $domnfe->saveXML();
    }

    /**
     * Authorize Inutilization of numbers
     * @throws \InvalidArgumentException
     */
    protected static function addInutNFeProtocol(string $request, string $response): string
    {
        $req = new DOMDocument('1.0', 'UTF-8');
        $req->preserveWhiteSpace = false;
        $req->formatOutput = false;
        $req->loadXML($request);
        $inutNFe = $req->getElementsByTagName('inutNFe')->item(0);
        $versao = $inutNFe->getAttribute("versao");
        $infInut = $req->getElementsByTagName('infInut')->item(0);
        $tpAmb = $infInut->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $cUF = !empty($infInut->getElementsByTagName('cUF')->item(0)->nodeValue)
            ? $infInut->getElementsByTagName('cUF')->item(0)->nodeValue : '';
        $ano = $infInut->getElementsByTagName('ano')->item(0)->nodeValue;
        $cnpj = $infInut->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        $mod = $infInut->getElementsByTagName('mod')->item(0)->nodeValue;
        $serie = $infInut->getElementsByTagName('serie')->item(0)->nodeValue;
        $nNFIni = $infInut->getElementsByTagName('nNFIni')->item(0)->nodeValue;
        $nNFFin = $infInut->getElementsByTagName('nNFFin')->item(0)->nodeValue;

        $ret = new DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        $retInutNFe = $ret->getElementsByTagName('retInutNFe')->item(0);
        if (!isset($retInutNFe)) {
            throw DocumentsException::wrongDocument(3, "&lt;retInutNFe;");
        }
        $retversao = $retInutNFe->getAttribute("versao");
        $retInfInut = $ret->getElementsByTagName('infInut')->item(0);
        $cStat = $retInfInut->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo = $retInfInut->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        if ($cStat != 102) {
            throw DocumentsException::wrongDocument(4, "[$cStat] $xMotivo.");
        }
        $rettpAmb = $retInfInut->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $retcUF = !empty($retInfInut->getElementsByTagName('cUF')->item(0)->nodeValue)
            ? $retInfInut->getElementsByTagName('cUF')->item(0)->nodeValue : $cUF;
        $retano = $retInfInut->getElementsByTagName('ano')->item(0)->nodeValue;
        $retcnpj = $retInfInut->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        $retmod = $retInfInut->getElementsByTagName('mod')->item(0)->nodeValue;
        $retserie = $retInfInut->getElementsByTagName('serie')->item(0)->nodeValue;
        $retnNFIni = $retInfInut->getElementsByTagName('nNFIni')->item(0)->nodeValue;
        $retnNFFin = $retInfInut->getElementsByTagName('nNFFin')->item(0)->nodeValue;
        if (
            $versao != $retversao ||
            $tpAmb != $rettpAmb ||
            $cUF != $retcUF ||
            $ano != $retano ||
            $cnpj != $retcnpj ||
            $mod != $retmod ||
            $serie != $retserie ||
            $nNFIni != $retnNFIni ||
            $nNFFin != $retnNFFin
        ) {
            throw DocumentsException::wrongDocument(5);
        }
        return self::join(
            $req->saveXML($inutNFe),
            $ret->saveXML($retInutNFe),
            'ProcInutNFe',
            $versao
        );
    }

    /**
     * Authorize NFe
     * @throws \InvalidArgumentException
     */
    protected static function addNFeProtocol(string $request, string $response): string
    {
        $req = new DOMDocument('1.0', 'UTF-8');
        $req->preserveWhiteSpace = false;
        $req->formatOutput = false;
        $req->loadXML($request);

        $nfe = $req->getElementsByTagName('NFe')->item(0);
        $infNFe = $req->getElementsByTagName('infNFe')->item(0);
        $versao = $infNFe->getAttribute("versao");
        $chave = preg_replace('/[^0-9]/', '', $infNFe->getAttribute("Id"));
        $digNFe = $req->getElementsByTagName('DigestValue')
            ->item(0)
            ->nodeValue;

        $ret = new DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        $retProt = $ret->getElementsByTagName('protNFe')->length > 0 ? $ret->getElementsByTagName('protNFe') : null;
        if ($retProt === null) {
            throw DocumentsException::wrongDocument(3, "&lt;protNFe&gt;");
        }
        $digProt = null;
        foreach ($retProt as $rp) {
            $infProt = $rp->getElementsByTagName('infProt')->item(0);
            $cStat = $infProt->getElementsByTagName('cStat')->item(0)->nodeValue;
            $xMotivo = $infProt->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            $dig = $infProt->getElementsByTagName("digVal")->item(0);
            $key = $infProt->getElementsByTagName("chNFe")->item(0)->nodeValue;
            if (isset($dig)) {
                $digProt = $dig->nodeValue;
                if ($digProt == $digNFe && $chave == $key) {
                    //100 Autorizado
                    //150 Autorizado fora do prazo
                    //110 Uso Denegado
                    //205 NFe Denegada
                    //301 Uso denegado por irregularidade fiscal do emitente
                    //302 Uso denegado por irregularidade fiscal do destinatário
                    //303 Uso Denegado Destinatario nao habilitado a operar na UF
                    $cstatpermit = ['100', '150', '110', '205', '301', '302', '303'];
                    if (!in_array($cStat, $cstatpermit)) {
                        throw DocumentsException::wrongDocument(4, "[$cStat] $xMotivo");
                    }
                    return self::join(
                        $req->saveXML($nfe),
                        $ret->saveXML($rp),
                        'nfeProc',
                        $versao
                    );
                }
            }
        }
        if (empty($digProt)) {
            $prot = $ret->getElementsByTagName('protNFe')->item(0);
            $cStat = $prot->getElementsByTagName('cStat')->item(0)->nodeValue;
            $xMotivo = $prot->getElementsByTagName('xMotivo')->item(0)->nodeValue;
            throw DocumentsException::wrongDocument(18, "[{$cStat}] {$xMotivo}");
        }
        if ($digNFe !== $digProt) {
            throw DocumentsException::wrongDocument(5, "Os digest são diferentes [{$chave}]");
        }
        return $req->saveXML();
    }

    /**
     * Authorize Event
     * @throws \InvalidArgumentException
     */
    protected static function addEnvEventoProtocol(string $request, string $response): string
    {
        $ev = new \DOMDocument('1.0', 'UTF-8');
        $ev->preserveWhiteSpace = false;
        $ev->formatOutput = false;
        $ev->loadXML($request);
        //extrai numero do lote do envio
        $envLote = $ev->getElementsByTagName('idLote')->item(0)->nodeValue;
        //extrai tag evento do xml origem (solicitação)
        $event = $ev->getElementsByTagName('evento')->item(0);
        $versao = $event->getAttribute('versao');

        $ret = new \DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        //extrai numero do lote da resposta
        $resLote = $ret->getElementsByTagName('idLote')->item(0)->nodeValue;
        //extrai a rag retEvento da resposta (retorno da SEFAZ)
        $retEv = $ret->getElementsByTagName('retEvento')->item(0);
        $cStat  = $retEv->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo = $retEv->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        $tpEvento = $retEv->getElementsByTagName('tpEvento')->item(0)->nodeValue;
        $cStatValids = ['135', '136'];
        if ($tpEvento == Tools::EVT_CANCELA) {
            $cStatValids[] = '155';
        }
        if (!in_array($cStat, $cStatValids)) {
            throw DocumentsException::wrongDocument(4, "[$cStat] $xMotivo");
        }
        if ($resLote !== $envLote) {
            throw DocumentsException::wrongDocument(
                5,
                "Os numeros de lote dos documentos são diferentes."
            );
        }
        return self::join(
            $ev->saveXML($event),
            $ret->saveXML($retEv),
            'procEventoNFe',
            $versao
        );
    }

    /**
     * Join the pieces of the source document with those of the answer
     */
    protected static function join(string $first, string $second, string $nodename, string $versao): string
    {
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
                . "<$nodename versao=\"$versao\" "
                . "xmlns=\"" . self::$urlPortal . "\">";
        $xml .= $first;
        $xml .= $second;
        $xml .= "</$nodename>";
        return $xml;
    }
}
