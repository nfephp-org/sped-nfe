<?php

namespace NFePHP\NFe;

class Complements
{
    
    /**
     * Add tags B2B, as example ANFAVEA
     * @param  string $nfe xml nfe content
     * @param  string $b2b xml b2b content
     * @param  string $tagB2B name B2B tag default 'NFeB2BFin' from ANFAVEA
     * @return string
     * @throws \InvalidArgumentException
     */
    public function addB2B($nfe, $b2b, $tagB2B = 'NFeB2BFin')
    {
        $domnfe = new \DOMDocument('1.0', 'UTF-8');
        $domnfe->preserveWhiteSpace = false;
        $domnfe->formatOutput = false;
        $domnfe->loadXML($nfe);
        $nodenfe = $domnfe->getElementsByTagName('nfeProc')->item(0);
        if (empty($nodenfe)) {
            $msg = "O arquivo indicado como NFe não está protocolado ou não é uma NFe!!";
            throw new \InvalidArgumentException($msg);
        }
        //carrega o arquivo B2B
        $domb2b = new \DOMDocument('1.0', 'UTF-8');
        $domb2b->preserveWhiteSpace = false;
        $domb2b->formatOutput = false;
        $domb2b->loadXML($b2b);
        $nodeb2b = $domnfe->getElementsByTagName($tagB2B)->item(0);
        if (empty($nodeb2b)) {
            $msg = "O arquivo indicado como B2B não contêm a tag requerida!!";
            throw new \InvalidArgumentException($msg);
        }
        //cria a NFe processada com a tag do protocolo
        $procb2b = new \DOMDocument('1.0', 'UTF-8');
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
     * @param  string $nfe content of autorized NFe XML
     * @param  string $cancelamento content of SEFAZ response
     * @return string
     * @throws \InvalidArgumentException
     */
    public function addCancelamento($nfe, $cancelamento)
    {
        $procXML = $nfe;
        $domnfe = new \DOMDocument('1.0', 'utf-8');
        $domnfe->formatOutput = false;
        $domnfe->preserveWhiteSpace = false;
        $domnfe->loadXML($nfe);
        $nodenfe = $domnfe->getElementsByTagName('NFe')->item(0);
        $proNFe = $domnfe->getElementsByTagName('protNFe')->item(0);
        if (empty($proNFe)) {
            $msg = "A NFe não está protocolada!";
            throw new \InvalidArgumentException($msg);
        }
        $chaveNFe = $proNFe->getElementsByTagName('chNFe')->item(0)->nodeValue;
        $tpAmb = $domnfe->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $domcanc = new \DOMDocument('1.0', 'utf-8');
        $domcanc->formatOutput = false;
        $domcanc->preserveWhiteSpace = false;
        $domcanc->loadXML($cancelamento);
        $retEvento = $domcanc->getElementsByTagName('retEvento')->item(0);
        $eventos = $retEvento->getElementsByTagName('infEvento');
        foreach ($eventos as $evento) {
            $cStat = $evento->getElementsByTagName('cStat')->item(0)->nodeValue;
            $tpAmb = $evento->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            $chaveEvento = $evento->getElementsByTagName('chNFe')->item(0)->nodeValue;
            $tpEvento = $evento->getElementsByTagName('tpEvento')->item(0)->nodeValue;
            if (($cStat == '135' || $cStat == '136' || $cStat == '155')
                && $tpEvento == '110111'
                && $chaveEvento == $chaveNFe
            ) {
                $proNFe->getElementsByTagName('cStat')->item(0)->nodeValue = '101';
                $proNFe->getElementsByTagName('xMotivo')->item(0)->nodeValue = 'Cancelamento de NF-e homologado';
                $procXML = Strings::clearProt($domnfe->saveXML());
                break;
            }
        }
        return (string) $procXML;
    }
    
    /**
     * Add authorization protocol to NFe XML
     * @param  string  $nfe signed nfe content
     * @param  string  $protocol protocol content from SEFAZ response
     * @return string Notarized invoice
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function addProtocolo($nfe, $protocol)
    {
        //carrega a NFe
        $domnfe = new \DOMDocument('1.0', 'UTF-8');
        $domnfe->preserveWhiteSpace = false;
        $domnfe->formatOutput = false;
        $domnfe->loadXML($nfe);
        $nodenfe = $domnfe->getElementsByTagName('NFe')->item(0);
        if ($nodenfe == '') {
            $msg = "O arquivo indicado como NFe não é um xml de NFe!";
            throw new \InvalidArgumentException($msg);
        }
        if (empty($docnfe->$domnfe->getElementsByTagName('Signature')->item(0))) {
            $msg = "A NFe não está assinada!";
            throw new \InvalidArgumentException($msg);
        }
        //carrega o protocolo
        $domprot = new  \DOMDocument('1.0', 'UTF-8');
        $domprot->preserveWhiteSpace = false;
        $domprot->formatOutput = false;
        $domprot->loadXML($protocol);
        $nodeprot = $domprot->getElementsByTagName('protNFe');
        if ($nodeprot->length == 0) {
            $msg = "O arquivo indicado não contêm um protocolo de autorização!";
            throw new \InvalidArgumentException($msg);
        }
        $tpAmb = $domnfe->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $infNFe = $domnfe->getNode("infNFe", 0);
        $versao = $infNFe->getAttribute("versao");
        $chaveNFe = preg_replace('/[^0-9]/', '', $infNFe->getAttribute("Id"));
        $digValueNFe = $domnfe->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        $digValueProt = '';
        for ($i = 0; $i < $nodeprot->length; $i++) {
            $node = $nodeprot->item($i);
            $protver = $node->getAttribute("versao");
            $chaveProt = $node->getElementsByTagName("chNFe")->item(0)->nodeValue;
            $digValueProt = ($node->getElementsByTagName("digVal")->length)
                ? $node->getElementsByTagName("digVal")->item(0)->nodeValue
                : '';
            $infProt = $node->getElementsByTagName("infProt")->item(0);
            if ($digValueNFe == $digValueProt && $chaveNFe == $chaveProt) {
                break;
            }
        }
        if ($digValueNFe != $digValueProt) {
            $msg = "Inconsistência! O DigestValue da NFe não combina com o digVal do protocolo indicado!";
            throw new \RuntimeException($msg);
        }
        if ($chaveNFe != $chaveProt) {
            $msg = "O protocolo indicado pertence a outra NFe. Os números das chaves não combinam !";
            throw new \RuntimeException($msg);
        }
        //cria a NFe processada com a tag do protocolo
        $procnfe = new \DOMDocument('1.0', 'utf-8');
        $procnfe->formatOutput = false;
        $procnfe->preserveWhiteSpace = false;
        //cria a tag nfeProc
        $nfeProc = $procnfe->createElement('nfeProc');
        $procnfe->appendChild($nfeProc);
        //estabele o atributo de versão
        $nfeProcAtt1 = $nfeProc->appendChild($procnfe->createAttribute('versao'));
        $nfeProcAtt1->appendChild($procnfe->createTextNode($protver));
        //estabelece o atributo xmlns
        $nfeProcAtt2 = $nfeProc->appendChild($procnfe->createAttribute('xmlns'));
        $nfeProcAtt2->appendChild($procnfe->createTextNode($this->urlPortal));
        //inclui a tag NFe
        $node = $procnfe->importNode($nodenfe, true);
        $nfeProc->appendChild($node);
        //cria tag protNFe
        $protNFe = $procnfe->createElement('protNFe');
        $nfeProc->appendChild($protNFe);
        //estabele o atributo de versão
        $protNFeAtt1 = $protNFe->appendChild($procnfe->createAttribute('versao'));
        $protNFeAtt1->appendChild($procnfe->createTextNode($versao));
        //cria tag infProt
        $nodep = $procnfe->importNode($infProt, true);
        $protNFe->appendChild($nodep);
        //salva o xml como string em uma variável
        $procXML = $procnfe->saveXML();
        //remove as informações indesejadas
        $procXML = Strings::clearProt($procXML);
        $this->isValid($this->urlVersion, $procXML, 'procNFe');
        return $procXML;
    }
}
