<?php

namespace NFePHP\NFe\Factories;

class Epec
{
    
    
    /**
     * sefazEPEC
     * Solicita autorização em contingência EPEC
     * @param  string|array $aXml
     * @param  string       $tpAmb
     * @param  string       $siglaUF
     * @param  array        $aRetorno
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazEPEC($aXml, $tpAmb = '2', $siglaUF = 'AN', &$aRetorno = array())
    {
        //na nfe deve estar indicado a entrada em contingencia da data hora e o motivo
        //caso contrario ignorar a solicitação de EPEC
        if (! is_array($aXml)) {
            $aXml[] = $aXml; //se não é um array converte
        }
        if (count($aXml) > 20) {
            $msg = "O limite é de 20 NFe em um lote EPEC, você está passando [".count($aXml)."]";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        //carrega serviço
        $servico = 'RecepcaoEPEC';
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A recepção de EPEC não está disponível na SEFAZ !!!";
            throw new Exception\RuntimeException($msg);
        }
        $aRetorno = array();
        $cnpj = $this->aConfig['cnpj'];
        $aRet = $this->zTpEv($tpEvento);
        $descEvento = $aRet['desc'];
        $cOrgao = '91';
        $tpEvento = '110140'; //EPEC
        $datEv = '';
        $numLote = LotNumber::geraNumLote();
        foreach ($aXml as $xml) {
            $dat = $this->zGetInfo($xml);
            if ($dat['dhCont'] == '' || $dat['xJust'] == '') {
                $msg = "Somente é possivel enviar para EPEC as notas emitidas "
                        . "em contingência com a data/hora e justificativa da contingência.";
                throw new Exception\InvalidArgumentException($msg);
            }
            $sSeqEvento = str_pad('1', 2, "0", STR_PAD_LEFT);
            $eventId = "ID".$tpEvento.$chNFe.$sSeqEvento;
            $chNFe = $dat['chave'];
            $dhEvento = DateTime::convertTimestampToSefazTime();
            $mensagem = "<evento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<infEvento Id=\"$eventId\">"
                . "<cOrgao>$cOrgao</cOrgao>"
                . "<tpAmb>$tpAmb</tpAmb>"
                . "<CNPJ>$cnpj</CNPJ>"
                . "<chNFe>$chNFe</chNFe>"
                . "<dhEvento>$dhEvento</dhEvento>"
                . "<tpEvento>$tpEvento</tpEvento>"
                . "<nSeqEvento>1</nSeqEvento>"
                . "<verEvento>$this->urlVersion</verEvento>"
                . "<detEvento versao=\"$this->urlVersion\">"
                . "<descEvento>$descEvento</descEvento>"
                . "<cOrgaoAutor>".$dat['cOrgaoAutor']."</cOrgaoAutor>"
                . "<tpAutor>".$dat['tpAutor']."</tpAutor>"
                . "<verAplic>$this->verAplic</verAplic>"
                . "<dhEmi>".$dat['dhEmi']."</dhEmi>"
                . "<tpNF>".$dat['tpNF']."</tpNF>"
                . "<IE>".$dat['IE']."</IE>"
                . "<dest>"
                . "<UF>".$dat['UF']."</UF> ";
            if ($dat['CNPJ'] != '') {
                $mensagem .= "<CNPJ>.".$dat['CNPJ']."</CNPJ>";
            } elseif ($dat['CPF'] != '') {
                $mensagem .= "<CPF>".$dat['CPF']."</CPF>";
            } else {
                $mensagem .= "<idEstrangeiro>".$dat['idEstrangeiro']."</idEstrangeiro>";
            }
            if ($dat['IEdest'] != '') {
                $mensagem .= "<IE>".$dat['IEdest']."</IE>";
            }
            $mensagem .= "</dest>"
                . "<vNF>".$dat['vNF']."</vNF>"
                . "<vICMS>".$dat['vICMS']."</vICMS>"
                . "<vST>".$dat['vST']."</vST>"
                . "</detEvento>"
                . "</infEvento>"
                . "</evento>";
                //assinatura dos dados
                $signedMsg = $this->oCertificate->signXML($mensagem, 'infEvento');
                $signedMsg = Strings::clearXml($signedMsg, true);
                $datEv .= $signedMsg;
        }
        $cons = "<envEvento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$numLote</idLote>"
            . "$datEv"
            . "</envEvento>";
        //valida mensagem com xsd
        //no caso do evento nao tem xsd organizado, esta fragmentado
        //e por vezes incorreto por isso essa validação está desabilitada
        //if (! $this->zValidMessage($cons, 'nfe', 'envEvento', $version)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        //envia a solicitação via SOAP
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $lastMsg = $this->oSoap->lastMsg;
        $this->soapDebug = $this->oSoap->soapDebug;
        //salva mensagens
        $filename = "$numLote-envEpec.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
        $filename = "$numLote-retEnvEpec.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        //tratar dados de retorno
        //TODO : incluir nos xml das NF o protocolo EPEC
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        return $retorno;
    }
    
    /**
     * zGetInfo
     * Busca informações do XML
     * para uso no sefazEPEC
     *
     * @param  string $xml
     * @return array
     */
    protected function zGetInfo($xml)
    {
        $dom = new Dom();
        $dom->loadXMLString($xml);
        $ide = $dom->getNode('ide');
        $emit = $dom->getNode('emit');
        $dest = $dom->getNode('dest');
        $enderDest = $dest->getElementsByTagName('enderDest')->item(0);
        $icmsTot = $dom->getNode('ICMSTot');
        $resp = array(
            'chave' => $dom->getChave('infNFe'),
            'dhCont' => $dom->getValue($ide, 'dhCont'),
            'xJust' => $dom->getValue($ide, 'xJust'),
            'cOrgaoAutor' => $dom->getValue($ide, 'cUF'),
            'tpAutor' => '1',
            'dhEmi' => $dom->getValue($ide, 'dhEmi'),
            'tpNF' => $dom->getValue($ide, 'tpNF'),
            'IE' => $dom->getValue($emit, 'IE'),
            'UF' => $dom->getValue($enderDest, 'UF'),
            'CNPJ' => $dom->getValue($dest, 'CNPJ'),
            'CPF' => $dom->getValue($dest, 'CPF'),
            'idEstrangeiro' => $dom->getValue($dest, 'idEstrangeiro'),
            'IEdest' => $dom->getValue($dest, 'IE'),
            'vNF' => $dom->getValue($icmsTot, 'vNF'),
            'vICMS' => $dom->getValue($icmsTot, 'vICMS'),
            'vST'=> $dom->getValue($icmsTot, 'vST')
        );
        return $resp;
    }
}
