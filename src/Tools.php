<?php

namespace NFePHP\NFe;

/**
 * Class responsible for communication with SEFAZ extends
 * NFePHP\NFe\Common\Tools
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Tools
 * @copyright NFePHP Copyright (c) 2008-2017
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
     * Send one ou more NFe to SEFAZ
     * @param array $aXml array of nfe's xml
     * @param string $idLote lote number
     * @param int $indSinc flag to use synchronous communication
     * @param bool $compactar flag to compress data with gzip
     * @return string soap response xml
     */
    public function sefazEnviaLote(
        $aXml,
        $idLote = '',
        $indSinc = 0,
        $compactar = false,
        &$xmls = []
    ) {
        $servico = 'NfeAutorizacao';
        //throw Exception if in contingency not for this service
        $this->checkContingencyForWebServices($servico);
        if (count($aXml) > 1) {
            $indSinc = 0;
        }
        if ($this->contingency->type != '') {
            //em modo de contingencia
            //esses xml deverão ser modificados e reassinados e retornados
            //no parametro $xmls para serem armazenados pelo aplicativo
            //pois serão alterados
            foreach ($aXml as $doc) {
                $xmls[] = $this->signNFe($xml);
            }
            $aXml = $xmls;
        }
        $sxml = implode("", $aXml);
        $sxml = preg_replace("/<\?xml.*\?>/", "", $sxml);
        $siglaUF = $this->config->siglaUF;
        
        $this->servico(
            'NfeAutorizacao',
            $this->config->siglaUF,
            $this->tpAmb
        );
        
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
        return $this->sendRequest($request);
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
        $this->isValid($this->urlVersion, $request, 'consReciNFe');
        return $this->sendRequest($request);
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
        $request = "<consSitNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<tpAmb>$tpAmb</tpAmb>"
                . "<xServ>CONSULTAR</xServ>"
                . "<chNFe>$chNFe</chNFe>"
                . "</consSitNFe>";
        $this->isValid($this->urlVersion, $request, 'consSitNFe');
        return $this->sendRequest($request);
    }

    /**
     * Request to disable one or an NFe sequence of a given series
     * @param integer $nSerie
     * @param integer $nIni
     * @param integer $nFin
     * @param string $xJust
     * @return string
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
        $this->isValid($this->urlVersion, $request, 'inutNFe');
        return $this->sendRequest($request);
    }
    
    /**
     * Search for the registration data of an NFe issuer,
     * if in contingency mode this service will cause a
     * Excption and not all Sefaz has this service available
     * @param string $uf  federation unit
     * @param string $cnpj CNPJ number (optional)
     * @param string $iest IE number (optional)
     * @param string $cpf  CPF number (optional)
     * @return string xml soap response
     */
    public function sefazCadastro(
        $uf,
        $cnpj = '',
        $iest = '',
        $cpf = ''
    ) {
        if ($cnpj != '') {
            $filter = "<CNPJ>$cnpj</CNPJ>";
            $txtFile = "CNPJ_$cnpj";
        } elseif ($iest != '') {
            $filter = "<IE>$iest</IE>";
            $txtFile = "IE_$iest";
        } else {
            $filter = "<CPF>$cpf</CPF>";
            $txtFile = "CPF_$cpf";
        }
        //carrega serviço
        $servico = 'NfeConsultaCadastro';
        $this->servico(
            'NfeConsultaCadastro',
            $uf,
            $this->tpAmb,
            true
        );
        $request = "<ConsCad xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infCons>"
            . "<xServ>CONS-CAD</xServ>"
            . "<UF>$uf</UF>"
            . "$filter</infCons></ConsCad>";
        $this->isValid($this->urlVersion, $request, 'consCad');
        return $this->sendRequest($request);
    }

    /**
     * Check services status SEFAZ/SVC
     * If $uf is empty use normal check with contingency
     * If $uf is NOT empty ignore contingency mode
     * @param string $uf  initials of federation unit
     * @return string xml soap response
     */
    public function sefazStatus($uf = '')
    {
        $ignoreContingency = true;
        if (empty($uf)) {
            $uf = $this->config->siglaUF;
            $ignoreContingency = false;
        }
        $servico = 'NfeStatusServico';
        $this->servico(
            'NfeStatusServico',
            $uf,
            $this->tpAmb,
            $ignoreContingency
        );
        $request = "<consStatServ xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$this->tpAmb</tpAmb><cUF>$this->urlcUF</cUF>"
            . "<xServ>STATUS</xServ></consStatServ>";
        $this->isValid($this->urlVersion, $request, 'consStatServ');
        return $this->sendRequest($request);
    }

    /**
     * Serviço destinado à distribuição de informações
     * resumidas e documentos fiscais eletrônicos de interesse de um ator.
     * @param integer $ultNSU  ultimo numero NSU que foi consultado
     * @param integer $numNSU  numero de NSU que se quer consultar
     * @param string $fonte sigla da fonte dos dados 'AN' e para alguns casos pode ser 'RS'
     * @return string
     */
    public function sefazDistDFe(
        $ultNSU = 0,
        $numNSU = 0,
        $fonte = 'AN'
    ) {
        //carrega serviço
        $this->servico(
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
        $request = "<distDFeInt xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<cUFAutor>$cUF</cUFAutor>"
            . "<CNPJ>$this->config->cnpj</CNPJ>$tagNSU</distDFeInt>";
        //$this->isValid($this->urlVersion, $request, '????');
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDistDFeInteresse xmlns=\"$this->urlNamespace\">"
            . "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>"
            . "</nfeDistDFeInteresse>";
        //este webservice não requer cabeçalho
        $this->urlHeader = '';
        return $this->sendRequest($request);
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
        $request = "<downloadNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<tpAmb>$this->tpAmb</tpAmb>"
                . "<xServ>DOWNLOAD NFE</xServ>"
                . "<CNPJ>$this->config->cnpj</CNPJ>"
                . "<chNFe>$chNFe</chNFe>"
                . "</downloadNFe>";
        //$this->isValid($this->urlVersion, $request, '?????');
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $retorno = $this->soap->send(
            $this->urlService,
            $this->urlMethod,
            $this->urlAction,
            SOAP_1_2,
            $parameters,
            $this->soapnamespaces,
            $body,
            $this->objHeader
        );
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
     * Verifica a validade de uma NFe recebida
     * @param  string $nfe
     * @param  array  $aRetorno
     * @return boolean
     * @throws \RuntimeException
     */
    public function sefazValidate($nfe)
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
