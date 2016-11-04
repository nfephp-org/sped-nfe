<?php

namespace NFePHP\NFe\Factories;

class Events
{
    protected $xCondUso = "A Carta de Correcao e disciplinada pelo paragrafo "
        . "1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 "
        . "e pode ser utilizada para regularizacao de erro ocorrido "
        . "na emissao de documento fiscal, desde que o erro nao esteja "
        . "relacionado com: I - as variaveis que determinam o valor "
        . "do imposto tais como: base de calculo, aliquota, diferenca "
        . "de preco, quantidade, valor da operacao ou da prestacao; "
        . "II - a correcao de dados cadastrais que implique mudanca "
        . "do remetente ou do destinatario; "
        . "III - a data de emissao ou de saida.";

    /**
     * zSefazEvento
     *
     * @param    string $siglaUF
     * @param    string $chNFe
     * @param    string $tpAmb
     * @param    string $tpEvento
     * @param    string $nSeqEvento
     * @param    string $tagAdic
     * @return   string
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    protected function zSefazEvento(
        $siglaUF = '',
        $chNFe = '',
        $tpAmb = '2',
        $tpEvento = '',
        $nSeqEvento = '1',
        $tagAdic = ''
    ) {
        //carrega serviço
        $servico = 'RecepcaoEvento';
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A recepção de eventos não está disponível na SEFAZ $siglaUF!!!";
            throw new Exception\RuntimeException($msg);
        }
        $aRet = $this->zTpEv($tpEvento);
        $aliasEvento = $aRet['alias'];
        $descEvento = $aRet['desc'];
        $cnpj = $this->aConfig['cnpj'];
        $dhEvento = (string) str_replace(' ', 'T', date('Y-m-d H:i:sP'));
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $eventId = "ID".$tpEvento.$chNFe.$sSeqEvento;
        $cOrgao = $this->urlcUF;
        if ($siglaUF == 'AN') {
            $cOrgao = '91';
        }
        $mensagem = "<evento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<CNPJ>$cnpj</CNPJ>"
            . "<chNFe>$chNFe</chNFe>"
            . "<dhEvento>$dhEvento</dhEvento>"
            . "<tpEvento>$tpEvento</tpEvento>"
            . "<nSeqEvento>$nSeqEvento</nSeqEvento>"
            . "<verEvento>$this->urlVersion</verEvento>"
            . "<detEvento versao=\"$this->urlVersion\">"
            . "<descEvento>$descEvento</descEvento>"
            . "$tagAdic"
            . "</detEvento>"
            . "</infEvento>"
            . "</evento>";
        //assinatura dos dados
        $signedMsg = $this->oCertificate->signXML($mensagem, 'infEvento');
        $signedMsg = Strings::clearXml($signedMsg, true);
        $numLote = LotNumber::geraNumLote();
        $cons = "<envEvento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$numLote</idLote>"
            . "$signedMsg"
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
        //tratar dados de retorno
        $this->aLastRetEvent = Response::readResponseSefaz($servico, $retorno);
        if ($this->getSalvarMensagensEvento()) {
            $filename = "$chNFe-$aliasEvento-envEvento.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
            $filename = "$chNFe-$aliasEvento-retEnvEvento.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
            if ($this->aLastRetEvent['cStat'] == '128') {
                if ($this->aLastRetEvent['evento'][0]['cStat'] == '135'
                    || $this->aLastRetEvent['evento'][0]['cStat'] == '136'
                    || $this->aLastRetEvent['evento'][0]['cStat'] == '155'
                ) {
                    $pasta = 'eventos'; //default
                    if ($aliasEvento == 'CancNFe') {
                        $pasta = 'canceladas';
                        $filename = "$chNFe-$aliasEvento-procEvento.xml";
                    } elseif ($aliasEvento == 'CCe') {
                        $pasta = 'cartacorrecao';
                        $filename = "$chNFe-$aliasEvento-$nSeqEvento-procEvento.xml";
                    }
                    $retorno = $this->zAddProtMsg('procEventoNFe', 'evento', $signedMsg, 'retEvento', $retorno);
                    $this->zGravaFile('nfe', $tpAmb, $filename, $retorno, $pasta);
                }
            }
        }
        
        return (string) $retorno;
    }
    
    /**
     * zTpEv
     *
     * @param  string $tpEvento
     * @return array
     * @throws Exception\RuntimeException
     */
    private function zTpEv($tpEvento = '')
    {
        //montagem dos dados da mensagem SOAP
        switch ($tpEvento) {
            case '110110':
                //CCe
                $aliasEvento = 'CCe';
                $descEvento = 'Carta de Correcao';
                break;
            case '110111':
                //cancelamento
                $aliasEvento = 'CancNFe';
                $descEvento = 'Cancelamento';
                break;
            case '110140':
                //EPEC
                //emissão em contingência EPEC
                $aliasEvento = 'EPEC';
                $descEvento = 'EPEC';
                break;
            case '111500':
            case '111501':
                //EPP
                //Pedido de prorrogação
                $aliasEvento = 'EPP';
                $descEvento = 'Pedido de Prorrogacao';
                break;
            case '111502':
            case '111503':
                //ECPP
                //Cancelamento do Pedido de prorrogação
                $aliasEvento = 'ECPP';
                $descEvento = 'Cancelamento de Pedido de Prorrogacao';
                break;
            case '210200':
                //Confirmacao da Operacao
                $aliasEvento = 'EvConfirma';
                $descEvento = 'Confirmacao da Operacao';
                break;
            case '210210':
                //Ciencia da Operacao
                $aliasEvento = 'EvCiencia';
                $descEvento = 'Ciencia da Operacao';
                break;
            case '210220':
                //Desconhecimento da Operacao
                $aliasEvento = 'EvDesconh';
                $descEvento = 'Desconhecimento da Operacao';
                break;
            case '210240':
                //Operacao não Realizada
                $aliasEvento = 'EvNaoRealizada';
                $descEvento = 'Operacao nao Realizada';
                break;
            default:
                $msg = "O código do tipo de evento informado não corresponde a "
                . "nenhum evento estabelecido.";
                throw new Exception\RuntimeException($msg);
        }
        return array('alias' => $aliasEvento, 'desc' => $descEvento);
    }
}
