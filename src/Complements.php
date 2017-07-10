<?php

namespace NFePHP\NFe;

use NFePHP\Common\Strings;
use NFePHP\NFe\Common\Standardize;
use DOMDocument;
use InvalidArgumentException;

class Complements
{
    protected static $urlPortal = 'http://www.portalfiscal.inf.br/nfe';
    
    /**
     * Authorize document adding his protocol
     * @param string $request
     * @param string $response
     * @return string
     */
    public static function toAuthorize($request, $response)
    {
        $st = new Standardize();
        $key = ucfirst($st->whichIs($request));
        $func = "add".$key."Protocol";
        return self::$func($request, $response);
    }
    
    /**
     * Add tags B2B, as example ANFAVEA
     * @param  string $nfe xml nfe string content
     * @param  string $b2b xml b2b string content
     * @param  string $tagB2B name B2B tag default 'NFeB2BFin' from ANFAVEA
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function b2bTag($nfe, $b2b, $tagB2B = 'NFeB2BFin')
    {
        $domnfe = new DOMDocument('1.0', 'UTF-8');
        $domnfe->preserveWhiteSpace = false;
        $domnfe->formatOutput = false;
        $domnfe->loadXML($nfe);
        $nodenfe = $domnfe->getElementsByTagName('nfeProc')->item(0);
        if (empty($nodenfe)) {
            $msg = "O arquivo indicado como NFe não está protocolado "
                    . "ou não é uma NFe!!";
            throw new InvalidArgumentException($msg);
        }
        //carrega o arquivo B2B
        $domb2b = new DOMDocument('1.0', 'UTF-8');
        $domb2b->preserveWhiteSpace = false;
        $domb2b->formatOutput = false;
        $domb2b->loadXML($b2b);
        $nodeb2b = $domnfe->getElementsByTagName($tagB2B)->item(0);
        if (empty($nodeb2b)) {
            $msg = "O arquivo indicado como B2B não contêm a tagB2B indicada!!";
            throw new InvalidArgumentException($msg);
        }
        //cria a NFe processada com a tag do protocolo
        $procb2b = new DOMDocument('1.0', 'UTF-8');
        $procb2b->preserveWhiteSpace = false;
        $proc2b->formatOutput = false;
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
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function cancelRegister($nfe, $cancelamento)
    {
        $procXML = $nfe;
        $domnfe = new DOMDocument('1.0', 'utf-8');
        $domnfe->formatOutput = false;
        $domnfe->preserveWhiteSpace = false;
        $domnfe->loadXML($nfe);
        $nodenfe = $domnfe->getElementsByTagName('NFe')->item(0);
        $proNFe = $domnfe->getElementsByTagName('protNFe')->item(0);
        if (empty($proNFe)) {
            $msg = "A NFe não está protocolada!";
            throw new InvalidArgumentException($msg);
        }
        $chaveNFe = $proNFe->getElementsByTagName('chNFe')->item(0)->nodeValue;
        $tpAmb = $domnfe->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        
        $domcanc = new DOMDocument('1.0', 'utf-8');
        $domcanc->formatOutput = false;
        $domcanc->preserveWhiteSpace = false;
        $domcanc->loadXML($cancelamento);
        $retEvento = $domcanc->getElementsByTagName('retEvento')->item(0);
        $eventos = $retEvento->getElementsByTagName('infEvento');
        foreach ($eventos as $evento) {
            $cStat = $evento->getElementsByTagName('cStat')
                ->item(0)
                ->nodeValue;
            $tpAmb = $evento->getElementsByTagName('tpAmb')
                ->item(0)
                ->nodeValue;
            $chaveEvento = $evento->getElementsByTagName('chNFe')
                ->item(0)
                ->nodeValue;
            $tpEvento = $evento->getElementsByTagName('tpEvento')
                ->item(0)
                ->nodeValue;
            if (($cStat == '135' || $cStat == '136' || $cStat == '155')
                && $tpEvento == '110111'
                && $chaveEvento == $chaveNFe
            ) {
                $proNFe->getElementsByTagName('cStat')
                    ->item(0)
                    ->nodeValue = '101';
                $proNFe->getElementsByTagName('xMotivo')
                    ->item(0)
                    ->nodeValue = 'Cancelamento de NF-e homologado';
                $procXML = Strings::clearProtocoledXML($domnfe->saveXML());
                break;
            }
        }
        return (string) $procXML;
    }
    
    /**
     * Authorize Inutilization of numbers
     * @param string $request
     * @param string $response
     * @return string
     * @throws InvalidArgumentException
     */
    protected static function addInutNFeProtocol($request, $response)
    {
        $req = new DOMDocument('1.0', 'UTF-8');
        $req->preserveWhiteSpace = false;
        $req->formatOutput = false;
        $req->loadXML($request);
        $inutNFe = $req->getElementsByTagName('inutNFe')->item(0);
        $versao = $inutNFe->getAttribute("versao");
        $infInut = $req->getElementsByTagName('infInut')->item(0);
        $tpAmb = $infInut->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $cUF = $infInut->getElementsByTagName('cUF')->item(0)->nodeValue;
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
            throw new InvalidArgumentException(
                'O documento de resposta não contêm o NODE "retInutNFe".'
            );
        }
        $retversao = $retInutNFe->getAttribute("versao");
        $retInfInut = $ret->getElementsByTagName('infInut')->item(0);
        $cStat = $retInfInut->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo = $retInfInut->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        if ($cStat != 102) {
            throw new InvalidArgumentException(
                "Erro localizado [$cStat] $xMotivo."
            );
        }
        $rettpAmb = $retInfInut->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $retcUF = $retInfInut->getElementsByTagName('cUF')->item(0)->nodeValue;
        $retano = $retInfInut->getElementsByTagName('ano')->item(0)->nodeValue;
        $retcnpj = $retInfInut->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        $retmod = $retInfInut->getElementsByTagName('mod')->item(0)->nodeValue;
        $retserie = $retInfInut->getElementsByTagName('serie')->item(0)->nodeValue;
        $retnNFIni = $retInfInut->getElementsByTagName('nNFIni')->item(0)->nodeValue;
        $retnNFFin = $retInfInut->getElementsByTagName('nNFFin')->item(0)->nodeValue;
        if ($versao != $retversao ||
            $tpAmb != $rettpAmb ||
            $cUF != $retcUF ||
            $ano != $retano ||
            $cnpj != $retcnpj ||
            $mod != $retmod ||
            $serie != $retserie ||
            $nNFIni != $retnNFIni ||
            $nNFFin != $retnNFFin
        ) {
            throw new InvalidArgumentException(
                'Os documentos de referem a diferentes objetos.'
                . ' Algum parametro é diferente do original.'
            );
        }
        return self::join(
            $req->saveXML($inutNFe),
            $ret->saveXML($retInutNFe),
            'procInutNFe',
            $versao
        );
    }

    /**
     * Authorize NFe
     * @param string $request
     * @param string $response
     * @return string
     * @throws InvalidArgumentException
     */
    protected static function addNFeProtocol($request, $response)
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
        $retProt = $ret->getElementsByTagName('protNFe')->item(0);
        if (!isset($retProt)) {
            throw new InvalidArgumentException(
                'O documento de resposta não contêm o NODE "protNFe".'
            );
        }
        $infProt = $ret->getElementsByTagName('infProt')->item(0);
        $cStat  = $infProt->getElementsByTagName('cStat')->item(0)->nodeValue;
        $xMotivo = $infProt->getElementsByTagName('xMotivo')->item(0)->nodeValue;
        $dig = $infProt->getElementsByTagName("digVal")->item(0);
        $digProt = '000';
        if (isset($dig)) {
            $digProt = $dig->nodeValue;
        }
        //100 Autorizado
        //150 Autorizado fora do prazo
        //110 Uso Denegado
        //205 NFe Denegada
        $cstatpermit = ['100', '150', '110', '205'];
        if (!in_array($cStat, $cstatpermit)) {
            throw new InvalidArgumentException(
                "Essa NFe não será protocolada [$cStat] $xMotivo."
            );
        }
        if ($digNFe !== $digProt) {
            throw new InvalidArgumentException(
                'Os documentos de referem a diferentes objetos.'
                . ' O digest é diferente.'
            );
        }
        return self::join(
            $req->saveXML($nfe),
            $ret->saveXML($retProt),
            'nfeProc',
            $versao
        );
    }
    
    /**
     * Authorize Event
     * @param string $request
     * @param string $response
     * @return string
     * @throws InvalidArgumentException
     */
    protected static function addEnvEventoProtocol($request, $response)
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
        if ($cStat != '135') {
            throw new \InvalidArgumentException(
                "Erro localizado [$cStat] $xMotivo."
            );
        }
        if ($resLote !== $envLote) {
            throw new \InvalidArgumentException('Os numeros de lote '
                    . 'dos documentos são diferentes.');
        }
        return self::join(
            $ev->saveXML($event),
            $ret->saveXML($retEv),
            'procEventoNFe',
            $versao
        );
    }
    
    protected static function join($first, $second, $nodename, $versao)
    {
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"
                . "<$nodename versao=\"$versao\" "
                . "xmlns=\"".self::$urlPortal."\">";
        $xml .= $first;
        $xml .= $second;
        $xml .= "</$nodename>";
        return $xml;
    }
}
