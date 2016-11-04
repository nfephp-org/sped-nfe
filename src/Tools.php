<?php

namespace NFePHP\NFe;

/**
 * Classe principal para a comunicação com a SEFAZ
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Tools
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\Common\Strings\Strings;
use NFePHP\Common\Signer;
use NFePHP\NFe\Factories\QRCode;
use NFePHP\NFe\Factories\Events;
use NFePHP\NFe\Common\Tools as ToolsCommon;

class Tools extends ToolsCommon
{
    const EVT_CONFIRMACAO = 210200;
    const EVT_CIENCIA = 210210;
    const EVT_DESCONHECIMENTO = 210220;
    const EVT_NAO_REALIZADA = 210240;
    
    
    /**
     * addB2B
     * Add tags B2B, as example ANFAVEA
     * @param  string $nfe xml nfe content
     * @param  string $b2b xml b2b content
     * @param  string $tagB2B name B2B tag default 'NFeB2BFin' from ANFAVEA
     * @return string
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
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
            throw new \RuntimeException($msg);
        }
        //carrega o arquivo B2B
        $domb2b = new \DOMDocument('1.0', 'UTF-8');
        $domb2b->preserveWhiteSpace = false;
        $domb2b->formatOutput = false;
        $domb2b->loadXML($b2b);
        $nodeb2b = $domnfe->getElementsByTagName($tagB2B)->item(0);
        if (empty($nodeb2b)) {
            $msg = "O arquivo indicado como B2B não contêm a tag requerida!!";
            throw new \RuntimeException($msg);
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
     * addCancelamento
     * Add cancel protocol to a autorized NFe
     * @param  string $nfe
     * @param  string $cancelamento
     * @return string
     * @throws \RuntimeException
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
            throw new \RuntimeException($msg);
        }
        $chaveNFe = $proNFe->getElementsByTagName('chNFe')->item(0)->nodeValue;
        $tpAmb = $domnfe->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        //carrega o cancelamento pode ser um evento ou resultado de uma
        //consulta com o retorno contendo multiplos eventos
        $domcanc = new \DOMDocument('1.0', 'utf-8');
        $domcanc->formatOutput = false;
        $domcanc->preserveWhiteSpace = false;
        $domcanc->loadXML($cancelamento);
        $retEvento = $domcanc->getElementsByTagName('retEvento')->item(0);
        $eventos = $retEvento->getElementsByTagName('infEvento');
        foreach ($eventos as $evento) {
            //evento
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
     * Adiciona o protocolo de autorização de uso da NFe
     * NOTA: exigência da SEFAZ, a nota somente é válida com o seu respectivo protocolo
     * @param  string  $nfe nfe content
     * @param  string  $protocol protocol content
     * @return string
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
            throw new \RuntimeException($msg);
        }
        if (empty($docnfe->$domnfe->getElementsByTagName('Signature')->item(0))) {
            $msg = "A NFe não está assinada!";
            throw new \RuntimeException($msg);
        }
        //carrega o protocolo
        $domprot = new  \DOMDocument('1.0', 'UTF-8');
        $domprot->preserveWhiteSpace = false;
        $domprot->formatOutput = false;
        $domprot->loadXML($protocol);
        $nodeprot = $domprot->getElementsByTagName('protNFe');
        if ($nodeprot->length == 0) {
            $msg = "O arquivo indicado não contêm um protocolo de autorização!";
            throw new \RuntimeException($msg);
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
        return $procXML;
    }
    
    /**
     * Sign NFe or NFCe
     * @param  string  $xml
     * @return string
     */
    public function assina($xml)
    {
        $signed = Signer::sign($this->certificate, $xml, 'infNFe', 'Id', $this->algorithm, [false,false,null,null]);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        //verifica se o modelo da NFe é 65 se for inclui o QRCode ao XML assinado
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($signed);
        $modelo = $dom->getElementsByTagName('mod')->item(0)->nodeValue;
        if ($modelo == 65) {
            $signed = $this->addQRCode($dom);
        }
        return $signed;
    }
    
    /**
     * sefazEnviaLote
     * Solicita a autorização de uso de Lote de NFe
     * @param array $aXml
     * @param string $idLote
     * @param array $aRetorno
     * @param int $indSinc
     * @param bool $compactar
     * @return string
     */
    public function sefazEnviaLote(
        $aXml,
        $idLote = '',
        $indSinc = 0,
        $compactar = false
    ) {
        $sxml = $aXml;
        if (is_array($aXml)) {
            if (count($aXml) > 1) {
                $indSinc = 0;
            }
            $sxml = implode("", $sxml);
        }
        $sxml = preg_replace("/<\?xml.*\?>/", "", $sxml);
        $siglaUF = $this->config->siglaUF;
        //carrega serviço
        $servico = 'NfeAutorizacao';
        $this->servico(
            'NfeAutorizacao',
            $this->config->siglaUF,
            $this->tpAmb
        );
        //montagem dos dados da mensagem SOAP
        $cons = "<enviNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<idLote>$idLote</idLote>"
                . "<indSinc>$indSinc</indSinc>"
                . "$sxml"
                . "</enviNFe>";
        //valida a mensagem com o xsd
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        $method = $this->urlMethod;
        if ($compactarZip) {
            $gzdata = base64_encode(gzencode($cons, 9, FORCE_GZIP));
            $body = "<nfeDadosMsgZip xmlns=\"$this->urlNamespace\">$gzdata</nfeDadosMsgZip>";
            $method = $this->urlMethod."Zip";
        }
        //envia a solicitação via SOAP
        /*
        $retorno = $this->oSoap->send($this->urlService, $this->urlNamespace, $this->urlHeader, $body, $method);
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        //caso o envio seja recebido com sucesso mover a NFe da pasta
        //das assinadas para a pasta das enviadas
         * 
         */
        return (string) $retorno;
    }
    
    /**
     * sefazConsultaRecibo
     * Consulta a situação de um Lote de NFe enviadas pelo recibo desse envio
     * @param string $recibo
     * @param string $tpAmb
     * @return string
     */
    public function sefazConsultaRecibo($recibo, $tpAmb = '')
    {
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        $siglaUF = $this->aConfig['siglaUF'];
        //carrega serviço
        $servico = 'NfeRetAutorizacao';
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A consulta de NFe não está disponível na SEFAZ $siglaUF!!!";
            throw new Exception\RuntimeException($msg);
        }
        $cons = "<consReciNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<nRec>$recibo</nRec>"
            . "</consReciNFe>";
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        //envia a solicitação via SOAP
        /*
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        //podem ser retornados nenhum, um ou vários protocolos
        //caso existam protocolos protocolar as NFe e movelas-las para a
        //pasta enviadas/aprovadas/anomes
         * 
         */
        return (string) $retorno;
    }
    
    /**
     * sefazConsultaChave
     * Consulta o status da NFe pela chave de 44 digitos
     *
     * @param    string $chave
     * @param    array  $aRetorno
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazConsultaChave($chave = '')
    {
        $chNFe = preg_replace('/[^0-9]/', '', $chave);
        if (strlen($chNFe) != 44) {
            $msg = "Uma chave de 44 dígitos da NFe deve ser passada.";
            throw new Exception\InvalidArgumentException($msg);
        }
        $cUF = substr($chNFe, 0, 2);
        $siglaUF = $this->getSigla($cUF);
        //carrega serviço
        $servico = 'NfeConsultaProtocolo';
        $this->servico(
            $servico,
            $this->getSigla($cUF),
            $tpAmb
        );
        $cons = "<consSitNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<tpAmb>$tpAmb</tpAmb>"
                . "<xServ>CONSULTAR</xServ>"
                . "<chNFe>$chNFe</chNFe>"
                . "</consSitNFe>";
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        //envia a solicitação via SOAP
        /*
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $lastMsg = $this->oSoap->lastMsg;
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
         * 
         */
        return (string) $retorno;
    }

    /**
     * sefazInutiliza
     * Solicita a inutilização de uma ou uma sequencia de NFe
     * de uma determinada série
     * @param    integer $nSerie
     * @param    integer $nIni
     * @param    integer $nFin
     * @param    string  $xJust
     * @return   string
     */
    public function sefazInutiliza(
        $nSerie,
        $nIni,
        $nFin,
        $xJust
    ) {
        $xJust = Strings::cleanString($xJust);
        $nSerie = (integer) $nSerie;
        $nIni = (integer) $nIni;
        $nFin = (integer) $nFin;
        //carrega serviço
        $this->servico(
            'NfeInutilizacao',
            $this->config->siglaUF,
            $this->tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A o endereço do serviço não está disponível!!!";
            throw new \RuntimeException($msg);
        }
        $cnpj = $this->config->cnpj;
        $sAno = (string) date('y');
        $sSerie = str_pad($nSerie, 3, '0', STR_PAD_LEFT);
        $sInicio = str_pad($nIni, 9, '0', STR_PAD_LEFT);
        $sFinal = str_pad($nFin, 9, '0', STR_PAD_LEFT);
        $idInut = "ID" .
            $this->urlcUF .
            $sAno .
            $cnpj .
            $this->modelo .
            $sSerie .
            $sInicio .
            $sFinal;
        //limpa os caracteres indesejados da justificativa
        $xJust = Strings::cleanString($xJust);
        //montagem do corpo da mensagem
        $msg = "<inutNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">" .
            "<infInut Id=\"$idInut\">" .
            "<tpAmb>$this->tpAmb</tpAmb>" .
            "<xServ>INUTILIZAR</xServ>" .
            "<cUF>$this->urlcUF</cUF>" .
            "<ano>$sAno</ano>" .
            "<CNPJ>$cnpj</CNPJ>" .
            "<mod>$this->modelo</mod>" .
            "<serie>$nSerie</serie>" .
            "<nNFIni>$nIni</nNFIni>" .
            "<nNFFin>$nFin</nNFFin>" .
            "<xJust>$xJust</xJust>" .
            "</infInut></inutNFe>";
        //assina a solicitação
        $signed = Signer::sign($this->certificate, $msg, 'infInut', 'Id', $this->algorithm, [false,false,null,null]);
        $signed = Strings::clearXml($signed, true);
        //valida a mensagem com o xsd, em caso de erro será chamada uma exception
        $this->validar($this->urlVersion, $msg, 'inutNFe', 'v');
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$signed</nfeDadosMsg>";
        //envia a solicitação via SOAP
        /*
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $lastMsg = $this->oSoap->lastMsg;
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        
        if ($aRetorno['cStat'] == '102') {
            $retorno = $this->addProtMsg('ProcInutNFe', 'inutNFe', $signedMsg, 'retInutNFe', $retorno);
        }
         * 
         */
        return $body;
        //return (string) $retorno;
    }
    
    /**
     * sefazCadastro
     * Busca os dados cadastrais de um emitente de NFe
     * NOTA: Nem todas as Sefaz disponibilizam esse serviço
     *
     * @param    string $siglaUF  sigla da UF da empresa que queremos consultar
     * @param    string $tpAmb
     * @param    string $cnpj     numero do CNPJ da empresa a ser consultada
     * @param    string $iest     numero da Insc. Est. da empresa a ser consultada
     * @param    string $cpf      CPF da pessoa física a ser consultada
     * @param    array  $aRetorno aRetorno retorno da resposta da SEFAZ em array
     * @return   string XML de retorno do SEFAZ
     * @throws   Exception\RuntimeException
     * @throws   Exception\InvalidArgumentException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazCadastro(
        $uf,
        $cnpj = '',
        $iest = '',
        $cpf = ''
    ) {
        //selecionar o criterio de filtragem CNPJ ou IE ou CPF
        if ($cnpj != '') {
            $filtro = "<CNPJ>$cnpj</CNPJ>";
            $txtFile = "CNPJ_$cnpj";
        } elseif ($iest != '') {
            $filtro = "<IE>$iest</IE>";
            $txtFile = "IE_$iest";
        } else {
            $filtro = "<CPF>$cpf</CPF>";
            $txtFile = "CPF_$cpf";
        }
        //carrega serviço
        $servico = 'NfeConsultaCadastro';
        $this->servico(
            'NfeConsultaCadastro',
            $uf,
            $this->tpAmb
        );
        $cons = "<ConsCad xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infCons>"
            . "<xServ>CONS-CAD</xServ>"
            . "<UF>$siglaUF</UF>"
            . "$filtro</infCons></ConsCad>";
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        //envia a solicitação via SOAP
        /*
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $lastMsg = $this->oSoap->lastMsg;
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
         */
        return (string) $retorno;
    }

    /**
     * sefazStatus
     * Verifica o status do serviço da SEFAZ/SVC
     * @param string $siglaUF  sigla da unidade da Federação
     * @param string $tpAmb    tipo de ambiente 1-produção e 2-homologação
     * @param array  $aRetorno parametro passado por referencia contendo a resposta da consulta em um array
     * @return mixed string XML do retorno do webservice, ou false se ocorreu algum erro
     */
    public function sefazStatus($uf = '')
    {
        //carrega serviço
        $servico = 'NfeStatusServico';
        $this->servico(
            'NfeStatusServico',
            $uf,
            $this->tpAmb
        );
        $cons = "<consStatServ xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$this->tpAmb</tpAmb><cUF>$this->urlcUF</cUF>"
            . "<xServ>STATUS</xServ></consStatServ>";
        //valida mensagem com xsd
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        /*
        //consome o webservice e verifica o retorno do SOAP
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $lastMsg = $this->oSoap->lastMsg;
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
         * 
         */
        return (string) $retorno;
    }

    /**
     * sefazDistDFe
     * Serviço destinado à distribuição de informações
     * resumidas e documentos fiscais eletrônicos de interesse de um ator.
     *
     * @param string $fonte sigla da fonte dos dados 'AN' e para alguns casos pode ser 'RS'
     * @param string  $cnpj
     * @param integer $ultNSU  ultimo numero NSU que foi consultado
     * @param integer $numNSU  numero de NSU que se quer consultar
     * @return string
     */
    public function sefazDistDFe(
        $fonte = 'AN',
        $cnpj = '',
        $ultNSU = 0,
        $numNSU = 0
    ) {
        //carrega serviço
        $this->zLoadServico(
            'NfeDistribuicaoDFe',
            $fonte,
            $this->tpAmb
        );
        $cUF = self::getcUF($this->config->siglaUF);
        $ultNSU = str_pad($ultNSU, 15, '0', STR_PAD_LEFT);
        $tagNSU = "<distNSU><ultNSU>$ultNSU</ultNSU></distNSU>";
        if ($numNSU != 0) {
            $numNSU = str_pad($numNSU, 15, '0', STR_PAD_LEFT);
            $tagNSU = "<consNSU><NSU>$numNSU</NSU></consNSU>";
        }
        //monta a consulta
        $cons = "<distDFeInt xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<cUFAutor>$cUF</cUFAutor>"
            . "<CNPJ>$cnpj</CNPJ>$tagNSU</distDFeInt>";
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDistDFeInteresse xmlns=\"$this->urlNamespace\">"
            . "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>"
            . "</nfeDistDFeInteresse>";
        //envia dados via SOAP e verifica o retorno este webservice não requer cabeçalho
        $this->urlHeader = '';
        /*
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $lastMsg = $this->oSoap->lastMsg;
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
         * 
         */
        return (string) $retorno;
    }

    /**
     * sefazCCe
     * Solicita a autorização da Carta de Correção
     * @param  string $chNFe
     * @param  string $xCorrecao
     * @param  int $nSeqEvento
     * @return string
     */
    public function sefazCCe($chNFe, $xCorrecao, $nSeqEvento = 1)
    {
        $xCorrecao = Strings::cleanString($xCorrecao);
        $uf = $this->getSigla(substr($chNFe, 0, 2));
        $tpEvento = '110110';
        //use a classe events
        $tagAdic = "<xCorrecao>$xCorrecao</xCorrecao><xCondUso>$xCondUso</xCondUso>";
        //$retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        return $retorno;
    }
    
    /**
     * sefazEPP
     * Solicita pedido de prorrogação do prazo de retorno de produtos de uma
     * NF-e de remessa para industrialização por encomenda com suspensão do ICMS
     * em operações interestaduais
     * @param  string  $chNFe
     * @param  string  $tpAmb
     * @param  integer $nSeqEvento
     * @param  string  $nProt
     * @param  array   $itens
     * @return string
     */
    public function sefazEPP(
        $chNFe,
        $nSeqEvento = 1,
        $nProt = '',
        $itens = array()
    ) {
        $siglaUF = $this->zGetSigla(substr($chNFe, 0, 2));
        $tpEvento = '111500';
        if ($nSeqEvento == 2) {
            $tpEvento = '111501';
        }
        $tagAdic = "<nProt>$nProt</nProt><itemPedido>";
        foreach ($itens as $item) {
            $tagAdic .= "<itemPedido numItem=\"".$item[0]."\"><qtdeItem>".$item[1]."</qtdeItem><itemPedido>";
        }
        $retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }
    
    /**
     * sefazECPP
     * Solicita o cancelamento do pedido de prorrogação do prazo de retorno
     * de produtos de uma NF-e de remessa para industrialização por encomenda
     * com suspensão do ICMS em operações interestaduais
     * @param  string  $chNFe
     * @param  integer $nSeqEvento
     * @param  string  $nProt
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazECPP(
        $chNFe,
        $nSeqEvento = 1,
        $nProt = ''
    ) {
        $siglaUF = $this->getSigla(substr($chNFe, 0, 2));
        $tpEvento = '111502';
        $origEvent = '111500';
        if ($nSeqEvento == 2) {
            $tpEvento = '111503';
            $origEvent = '111501';
        }
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $idPedidoCancelado = "ID$origEvent$chNFe$sSeqEvento";
        $tagAdic = "<idPedidoCancelado>$idPedidoCancelado</idPedidoCancelado><nProt>$nProt</nProt>";
        
        //$retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        //$aRetorno = $this->aLastRetEvent;
        return $retorno;
    }
    
    /**
     * sefazEPEC
     * Solicita autorização em contingência EPEC
     * @param  string $xml
     * @param  string $siglaUF
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazEPEC($xml, $tpAmb = '2', $siglaUF = 'AN', &$aRetorno = array())
    {
        //ese a classe EPEC
    }
    
    /**
     * sefazCancela
     * Solicita o cancelamento da NFe
     *
     * @param  string $chNFe
     * @param  string $xJust
     * @param  string $nProt
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazCancela($chNFe, $xJust, $nProt)
    {
        $xJust = Strings::cleanString($xJust);
        $siglaUF = $this->getSigla(substr($chNFe, 0, 2));
        //estabelece o codigo do tipo de evento CANCELAMENTO
        $tpEvento = '110111';
        $nSeqEvento = 1;
        //monta mensagem
        $tagAdic = "<nProt>$nProt</nProt><xJust>$xJust</xJust>";
        //$retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        //$aRetorno = $this->aLastRetEvent;
        return $retorno;
    }
    
    /**
     * sefazManifesta
     * Solicita o registro da manifestação de destinatário
     * @param  string $chNFe
     * @param  string $xJust
     * @param  string $tpEvento
     * @return string
     */
    public function sefazManifesta($chNFe, $xJust, $tpEvento)
    {
        $tagAdic = '';
        if ($tpEvento == '210240') {
            $xJust = Strings::cleanString($xJust);
            $tagAdic = "<xJust>$xJust</xJust>";
        }
        //$retorno = $this->zSefazEvento('AN', $chNFe, $tpAmb, $tpEvento, '1', $tagAdic);
        //$aRetorno = $this->aLastRetEvent;
        return $retorno;
    }
    
    /**
     * sefazDownload
     * Solicita o download de NFe já manifestada
     * @param  string $chave
     * @return string
     * @throws Exception\RuntimeException
     */
    public function sefazDownload($chave)
    {
        //carrega serviço
        $servico = 'NfeDownloadNF';
        $this->zLoadServico(
            'NfeDownloadNF',
            'AN',
            $this->tpAmb
        );
        $cons = "<downloadNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<tpAmb>$this->tpAmb</tpAmb>"
                . "<xServ>DOWNLOAD NFE</xServ>"
                . "<CNPJ>$this->config->cnpj</CNPJ>"
                . "<chNFe>$chNFe</chNFe>"
                . "</downloadNFe>";
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        /*
        //consome o webservice e verifica o retorno do SOAP
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $lastMsg = $this->oSoap->lastMsg;
        $this->soapDebug = $this->oSoap->soapDebug;
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
         * 
         */
        return (string) $retorno;
    }
    
    /**
     * sefazManutencaoCsc
     * Manutenção do Código de Segurança do Contribuinte (Antigo Token)
     * @param int $indOp
     * @return string
     */
    public function sefazManutencaoCsc(
        $indOp = ''
    ) {
        $raizCNPJ = substr($this->config->cnpj, 0, -6);
        //carrega serviço
        $servico = 'CscNFCe';
        $this->servico(
            'CscNFCe',
            $this->config->siglaUF,
            $this->tpAmb
        );
        if ($indOp == 3) {
            $cons = "<admCscNFCe versao=\"$this->urlVersion\" xmlns=\"$this->urlPortal\">"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<indOp>$indOp</indOp>"
            . "<raizCNPJ>$raizCNPJ</raizCNPJ>"
            . "<dadosCsc>"
            . "<idCsc>".$this->config->tokenNFCeId."</idCsc>"
            . "<codigoCsc>".$this->config->tokenNFCe."</codigoCsc>"
            . "</dadosCsc>"
            . "</admCscNFCe>";
        } else {
            $cons = "<admCscNFCe versao=\"$this->urlVersion\" xmlns=\"$this->urlPortal\">"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<indOp>$indOp</indOp>"
            . "<raizCNPJ>$raizCNPJ</raizCNPJ>"
            . "</admCscNFCe>";
        }
        
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
        /*
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
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
         * 
         */
        return (string) $retorno;
    }
        
    /**
     * verificaValidade
     * Verifica a validade de uma NFe recebida
     * @param  string $nfe
     * @param  array  $aRetorno
     * @return boolean
     * @throws \RuntimeException
     */
    public function verificaValidade($nfe)
    {
        //verifica a assinatura da NFe, exception caso de falha
        Signer::isSigned($dom, 'infNFe');
        //verifica a validade no webservice da SEFAZ
        $domnfe = new \DOMDocument('1.0', 'utf-8');
        $domnfe->formatOutput = false;
        $domnfe->preserveWhiteSpace = false;
        $domnfe->loadXML($nfe);
        $tpAmb = $domnfe->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $infNFe  = $domnfe->getElementsByTagName('infNFe')->item(0);
        $chaveNFe = preg_replace('/[^0-9]/', '', $infNFe->getAttribute("Id"));
        $this->sefazConsultaChave($chNFe, $tpAmb);
        /*
        if ($aRetorno['cStat'] != '100' && $aRetorno['cStat'] != '150') {
            return false;
        }
         * 
         */
        return true;
    }
}
