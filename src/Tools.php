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

use NFePHP\Common\Strings;
use NFePHP\Common\Signer;
use NFePHP\Common\UFList;
use NFePHP\NFe\Factories\QRCode;
use NFePHP\NFe\Factories\Events;
use NFePHP\NFe\Common\Tools as ToolsCommon;
use RuntimeException;

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
        $this->checkContingencyForWebServices($servico);
        if (count($aXml) > 1) {
            $indSinc = 0;
        }
        if ($this->contingency->type != '') {
            //em modo de contingencia
            //esses xml deverão ser modificados e re-assinados e retornados
            //no parametro $xmls para serem armazenados pelo aplicativo
            //pois serão alterados
            foreach ($aXml as $doc) {
                //corrigir o xml para o tipo de contigência setado
                $xmls[] = $this->correctNFeForContingencyMode($doc);
            }
            $aXml = $xmls;
        }
        $sxml = implode("", $aXml);
        $sxml = preg_replace("/<\?xml.*\?>/", "", $sxml);
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $this->tpAmb
        );
        $request = "<enviNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$idLote</idLote>"
            . "<indSinc>$indSinc</indSinc>"
            . "$sxml"
            . "</enviNFe>";
        $this->isValid($this->urlVersion, $request, 'enviNFe');
        //montagem dos dados da mensagem SOAP
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $method = $this->urlMethod;
        if ($compactarZip) {
            $gzdata = base64_encode(gzencode($cons, 9, FORCE_GZIP));
            $body = "<nfeDadosMsgZip xmlns=\"$this->urlNamespace\">$gzdata</nfeDadosMsgZip>";
            $method = $this->urlMethod."Zip";
            $parameters = ['nfeDadosMsgZip' => $gzdata];
            $body = "<nfeDadosMsgZip xmlns=\"$this->urlNamespace\">$gzdata</nfeDadosMsgZip>";
        }
        return $this->sendRequest($body, $parameters);
    }
    
    /**
     * Consulta a situação de um Lote de NFe enviadas pelo recibo desse envio
     * @param string $recibo
     * @param int $tpAmb
     * @return string
     */
    public function sefazConsultaRecibo($recibo, $tpAmb = null)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        //carrega serviço
        $servico = 'NfeRetAutorizacao';
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A consulta de NFe não está disponível na SEFAZ $siglaUF!!!";
            throw new RuntimeException($msg);
        }
        $request = "<consReciNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<nRec>$recibo</nRec>"
            . "</consReciNFe>";
        $this->isValid($this->urlVersion, $request, 'consReciNFe');
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
    }
    
    /**
     * Consulta o status da NFe pela chave de 44 digitos
     * @param string $chave
     * @param int $tpAmb
     * @return string
     */
    public function sefazConsultaChave($chave, $tpAmb = null)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        //carrega serviço
        $servico = 'NfeConsultaProtocolo';
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
            UFList::getUFByCode(substr($chave, 0, 2)),
            $tpAmb
        );
        $request = "<consSitNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<xServ>CONSULTAR</xServ>"
            . "<chNFe>$chave</chNFe>"
            . "</consSitNFe>";
        $this->isValid($this->urlVersion, $request, 'consSitNFe');
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
    }

    /**
     * Request to disable one or an NFe sequence of a given series
     * @param integer $nSerie
     * @param integer $nIni
     * @param integer $nFin
     * @param string $xJust
     * @param int $tpAmb
     * @return string
     */
    public function sefazInutiliza(
        $nSerie,
        $nIni,
        $nFin,
        $xJust,
        $tpAmb = null
    ) {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        $xJust = Strings::replaceSpecialsChars($xJust);
        $nSerie = (integer) $nSerie;
        $nIni = (integer) $nIni;
        $nFin = (integer) $nFin;
        $servico = 'NfeInutilizacao';
        $this->checkContingencyForWebServices($servico);
        //carrega serviço
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $tpAmb
        );
        $cnpj = $this->config->cnpj;
        $strAno = (string) date('y');
        $strSerie = str_pad($nSerie, 3, '0', STR_PAD_LEFT);
        $strInicio = str_pad($nIni, 9, '0', STR_PAD_LEFT);
        $strFinal = str_pad($nFin, 9, '0', STR_PAD_LEFT);
        $idInut = "ID"
            . $this->urlcUF
            . $strAno
            . $cnpj
            . $this->modelo
            . $strSerie
            . $strInicio
            . $strFinal;
        //limpa os caracteres indesejados da justificativa
        $xJust = Strings::replaceSpecialsChars($xJust);
        //montagem do corpo da mensagem
        $msg = "<inutNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">" .
            "<infInut Id=\"$idInut\">" .
            "<tpAmb>$tpAmb</tpAmb>" .
            "<xServ>INUTILIZAR</xServ>" .
            "<cUF>$this->urlcUF</cUF>" .
            "<ano>$strAno</ano>" .
            "<CNPJ>$cnpj</CNPJ>" .
            "<mod>$this->modelo</mod>" .
            "<serie>$nSerie</serie>" .
            "<nNFIni>$nIni</nNFIni>" .
            "<nNFFin>$nFin</nNFFin>" .
            "<xJust>$xJust</xJust>" .
            "</infInut></inutNFe>";
        //assina a solicitação
        $request = Signer::sign(
            $this->certificate,
            $msg,
            'infInut',
            'Id',
            $this->algorithm,
            [false,false,null,null]
        );
        $request = Strings::clearXmlString($request, true);
        $this->isValid($this->urlVersion, $request, 'inutNFe');
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
    }
    
    /**
     * Search for the registration data of an NFe issuer,
     * if in contingency mode this service will cause a
     * Exception and remember not all Sefaz have this service available,
     * so it will not work in some cases.
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
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
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
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
    }

    /**
     * Check services status SEFAZ/SVC
     * If $uf is empty use normal check with contingency
     * If $uf is NOT empty ignore contingency mode
     * @param string $uf  initials of federation unit
     * @return string xml soap response
     */
    public function sefazStatus($uf = '', $tpAmb = null)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        $ignoreContingency = true;
        if (empty($uf)) {
            $uf = $this->config->siglaUF;
            $ignoreContingency = false;
        }
        $servico = 'NfeStatusServico';
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
            $uf,
            $tpAmb,
            $ignoreContingency
        );
        $request = "<consStatServ xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$this->tpAmb</tpAmb><cUF>$this->urlcUF</cUF>"
            . "<xServ>STATUS</xServ></consStatServ>";
        $this->isValid($this->urlVersion, $request, 'consStatServ');
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
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
        $servico = 'NfeDistribuicaoDFe';
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
            $fonte,
            1,
            true
        );
        $cUF = UFList::getCodeByUF($this->config->siglaUF);
        $ultNSU = str_pad($ultNSU, 15, '0', STR_PAD_LEFT);
        $tagNSU = "<distNSU><ultNSU>$ultNSU</ultNSU></distNSU>";
        if ($numNSU != 0) {
            $numNSU = str_pad($numNSU, 15, '0', STR_PAD_LEFT);
            $tagNSU = "<consNSU><NSU>$numNSU</NSU></consNSU>";
        }
        //monta a consulta
        $consulta = "<distDFeInt xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>1</tpAmb>"
            . "<cUFAutor>$cUF</cUFAutor>"
            . "<CNPJ>".$this->config->cnpj."</CNPJ>$tagNSU</distDFeInt>";
        //valida o xml da requisição
        $this->isValid($this->urlVersion, $consulta, 'distDFeInt');
        //montagem dos dados da mensagem SOAP
        $request = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$consulta</nfeDadosMsg>";
        $parameters = ['nfeDistDFeInteresse' => $request];
        $body = "<nfeDistDFeInteresse xmlns=\"$this->urlNamespace\">"
            . $request
            . "</nfeDistDFeInteresse>";
        //este webservice não requer cabeçalho
        $this->objHeader = null;
        return $this->sendRequest($body, $parameters);
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
        $xCorrecao = Strings::replaceSpecialsChars($xCorrecao);
        $uf = UFList::getUFByCode(substr($chNFe, 0, 2));
        $tpEvento = 110110;
        $xCondUso = 'A Carta de Correcao e disciplinada pelo paragrafo '
            . '1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 '
            . 'e pode ser utilizada para regularizacao de erro ocorrido '
            . 'na emissao de documento fiscal, desde que o erro nao esteja '
            . 'relacionado com: I - as variaveis que determinam o valor '
            . 'do imposto tais como: base de calculo, aliquota, '
            . 'diferenca de preco, quantidade, valor da operacao ou da '
            . 'prestacao; II - a correcao de dados cadastrais que implique '
            . 'mudanca do remetente ou do destinatario; III - a data de '
            . 'emissao ou de saida.';
        $tagAdic = "<xCorrecao>"
            . $xCorrecao
            . "</xCorrecao><xCondUso>$xCondUso</xCondUso>";
        return $this->sefazEvento(
            $uf,
            $chNFe,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
    
    /**
     * Solicita pedido de prorrogação do prazo de retorno de produtos de uma
     * NF-e de remessa para industrialização por encomenda com suspensão do ICMS
     * em operações interestaduais
     * @param  string  $chNFe
     * @param  string  $nProt
     * @param  integer $nSeqEvento
     * @param  array   $itens
     * @return string
     */
    public function sefazEPP(
        $chNFe,
        $nProt,
        $itens = array(),
        $nSeqEvento = 1
    ) {
        $uf = UFList::getUFByCode(substr($chNFe, 0, 2));
        $tpEvento = 111500;
        if ($nSeqEvento == 2) {
            $tpEvento = 111501;
        }
        $tagAdic = "<nProt>$nProt</nProt>";
        foreach ($itens as $item) {
            $tagAdic .= "<itemPedido numItem=\""
                . $item[0]
                . "\"><qtdeItem>"
                . $item[1]
                ."</qtdeItem></itemPedido>";
        }
        return $this->sefazEvento(
            $uf,
            $chNFe,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
    
    /**
     * Solicita o cancelamento do pedido de prorrogação do prazo de retorno
     * de produtos de uma NF-e de remessa para industrialização por encomenda
     * com suspensão do ICMS em operações interestaduais
     * @param  string  $chNFe
     * @param  string  $nProt
     * @param  integer $nSeqEvento
     * @return string
     */
    public function sefazECPP(
        $chNFe,
        $nProt,
        $nSeqEvento = 1
    ) {
        $uf = UFList::getUFByCode(substr($chNFe, 0, 2));
        $tpEvento = 111502;
        $origEvent = 111500;
        if ($nSeqEvento == 2) {
            $tpEvento = 111503;
            $origEvent = 111501;
        }
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $idPedidoCancelado = "ID$origEvent$chNFe$sSeqEvento";
        $tagAdic = "<idPedidoCancelado>"
                . "$idPedidoCancelado"
                . "</idPedidoCancelado>"
                . "<nProt>$nProt</nProt>";
        return $this->sefazEvento(
            $uf,
            $chNFe,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
        
    /**
     * Requires nfe cancellation
     * @param  string $chNFe
     * @param  string $xJust
     * @param  string $nProt
     * @return string
     */
    public function sefazCancela($chNFe, $xJust, $nProt)
    {
        $xJust = Strings::replaceSpecialsChars($xJust);
        $uf = UFList::getUFByCode(substr($chNFe, 0, 2));
        $tpEvento = 110111;
        $nSeqEvento = 1;
        $tagAdic = "<nProt>$nProt</nProt><xJust>$xJust</xJust>";
        return $this->sefazEvento(
            $uf,
            $chNFe,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
    
    /**
     * Request the registration of the manifestation of recipient
     * @param string $chNFe
     * @param int $tpEvento
     * @param string $xJust
     * @param int $nSeqEvento
     * @return string
     */
    public function sefazManifesta(
        $chNFe,
        $tpEvento,
        $xJust = '',
        $nSeqEvento = 1
    ) {
        $tagAdic = '';
        if ($tpEvento == 210240) {
            $xJust = Strings::replaceSpecialsChars($xJust);
            $tagAdic = "<xJust>$xJust</xJust>";
        }
        return $this->sefazEvento(
            'AN',
            $chNFe,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
    
    /**
     * Solicita autorização em contingência EPEC
     * @param  string $xml
     * @return string
     */
    public function sefazEPEC(&$xml)
    {
        $tagAdic = '';
        $tpEvento = 110140;
        $nSeqEvento = 1;
        if ($this->contingency->type !== 'EPEC') {
            throw new \RuntimeException('A contingência EPEC deve estar ativada.');
        }
        $xml = $this->correctNFeForContingencyMode($xml);
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $emit = $dom->getElementsByTagName('emit')->item(0);
        $dest = $dom->getElementsByTagName('dest')->item(0);
        $cOrgaoAutor = UFList::getCodeByUF($this->config->siglaUF);
        $chNFe = substr($infNFe->getAttribute('Id'), 3, 44);
        // EPEC
        $dhEmi = $dom->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $tpNF = $dom->getElementsByTagName('tpNF')->item(0)->nodeValue;
        $emitIE = $emit->getElementsByTagName('IE')->item(0)->nodeValue;
        $destUF = $dest->getElementsByTagName('UF')->item(0)->nodeValue;
        $total = $dom->getElementsByTagName('total')->item(0);
        $vNF = $total->getElementsByTagName('vNF')->item(0)->nodeValue;
        $vICMS = $total->getElementsByTagName('vICMS')->item(0)->nodeValue;
        $vST = $total->getElementsByTagName('vST')->item(0)->nodeValue;
        $dID = $dest->getElementsByTagName('CNPJ')->item(0)->nodeValue;
        if (!empty($dID)) {
            $destID = "<CNPJ>$dID</CNPJ>";
        } else {
            $dID = $dest->getElementsByTagName('CPF')->item(0)->nodeValue;
            if (!empty($dID)) {
                $destID = "<CPF>$dID</CPF>";
            } else {
                $dID = $dest->getElementsByTagName('idEstrangeiro')
                    ->item(0)
                    ->nodeValue;
                $destID = "<idEstrangeiro>$dID</idEstrangeiro>";
            }
        }
        $dIE = !empty($dest->getElementsByTagName('IE')->item(0)->nodeValue) ?
                $dest->getElementsByTagName('IE')->item(0)->nodeValue : '';
        $destIE = '';
        if (!empty($dIE)) {
            $destIE = "<IE>$dIE</IE>";
        }
        $tagAdic = "<cOrgaoAutor>$cOrgaoAutor</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>"
            . "<verAplic>$this->verAplic</verAplic>"
            . "<dhEmi>$dhEmi</dhEmi>"
            . "<tpNF>$tpNF</tpNF>"
            . "<IE>$emitIE</IE>"
            . "<dest>"
            . "<UF>$destUF</UF>"
            . $destID
            . $destIE
            . "<vNF>$vNF</vNF>"
            . "<vICMS>$vICMS</vICMS>"
            . "<vST>$vST</vST>"
            . "</dest>";
        
        return $this->sefazEvento(
            'AN',
            $chNFe,
            $tpEvento,
            $nSeqEvento,
            $tagAdic
        );
    }
    
    /**
     * Send event to SEFAZ
     * @param string $uf
     * @param string $chave
     * @param int $tpEvento
     * @param int $nSeqEvento
     * @param string $tagAdic
     * @return string
     */
    public function sefazEvento(
        $uf,
        $chave,
        $tpEvento,
        $nSeqEvento = 1,
        $tagAdic = ''
    ) {
        $ignore = false;
        if ($tpEvento == 110140) {
            $ignore = true;
        }
        $servico = 'RecepcaoEvento';
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
            $uf,
            $this->tpAmb,
            $ignore
        );
        $ev = $this->tpEv($tpEvento);
        $aliasEvento = $ev->alias;
        $descEvento = $ev->desc;
        $cnpj = $this->config->cnpj;
        $dt = new \DateTime();
        $dhEvento = $dt->format('Y-m-d\TH:i:sP');
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $eventId = "ID".$tpEvento.$chave.$sSeqEvento;
        $cOrgao = UFList::getCodeByUF($uf);
        $request = "<evento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<CNPJ>$cnpj</CNPJ>"
            . "<chNFe>$chave</chNFe>"
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
        $request = Signer::sign(
            $this->certificate,
            $request,
            'infEvento',
            '',
            $this->algorithm,
            [false,false,null,null]
        );
        $request = Strings::clearXmlString($request, true);
        $lote = $dt->format('YmdHis').rand(0, 9);
        $request = "<envEvento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$lote</idLote>"
            . $request
            . "</envEvento>";
        $this->isValid($this->urlVersion, $request, 'envEvento');
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
        return (string) $retorno;
    }
    
    /**
     * sefazDownload
     * Solicita o download de NFe já manifestada
     * @param  string $chave
     * @return string
     */
    public function sefazDownload($chave)
    {
        //carrega serviço
        $servico = 'NfeDownloadNF';
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
            'AN',
            $this->tpAmb,
            true
        );
        $request = "<downloadNFe xmlns=\"$this->urlPortal\" "
                . "versao=\"$this->urlVersion\">"
                . "<tpAmb>$this->tpAmb</tpAmb>"
                . "<xServ>DOWNLOAD NFE</xServ>"
                . "<CNPJ>" . $this->config->cnpj . "</CNPJ>"
                . "<chNFe>$chave</chNFe>"
                . "</downloadNFe>";
        $this->isValid($this->urlVersion, $request, 'downloadNFe');
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
    }
    
    /**
     * Manutenção do Código de Segurança do Contribuinte (Antigo Token)
     * @param int $indOp Identificador do tipo de operação:
     *                   1 - Consulta CSC Ativos;
     *                   2 - Solicita novo CSC;
     *                   3 - Revoga CSC Ativo
     * @return string
     */
    public function sefazManutencaoCsc(
        $indOp
    ) {
        $raizCNPJ = substr($this->config->cnpj, 0, -6);
        //carrega serviço
        $servico = 'CscNFCe';
        $this->checkContingencyForWebServices($servico);
        $this->servico(
            $servico,
            $this->config->siglaUF,
            $this->tpAmb
        );
        $request = "<admCscNFCe versao=\"$this->urlVersion\" xmlns=\"$this->urlPortal\">"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<indOp>$indOp</indOp>"
            . "<raizCNPJ>$raizCNPJ</raizCNPJ>"
            . "</admCscNFCe>";
        if ($indOp == 3) {
            $request = "<admCscNFCe versao=\"$this->urlVersion\" xmlns=\"$this->urlPortal\">"
            . "<tpAmb>$this->tpAmb</tpAmb>"
            . "<indOp>$indOp</indOp>"
            . "<raizCNPJ>$raizCNPJ</raizCNPJ>"
            . "<dadosCsc>"
            . "<idCsc>".$this->config->tokenNFCeId."</idCsc>"
            . "<codigoCsc>".$this->config->tokenNFCe."</codigoCsc>"
            . "</dadosCsc>"
            . "</admCscNFCe>";
        }
        //o xsd não está disponivel
        //$this->isValid($this->urlVersion, $request, 'cscNFCe');
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        return $this->sendRequest($body, $parameters);
    }
    
    /**
     * Verifica a validade de uma NFe recebida
     * @param  string $nfe
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
        $chNFe = preg_replace('/[^0-9]/', '', $infNFe->getAttribute("Id"));
        //consulta a NFe
        $response = $this->sefazConsultaChave($chNFe, $tpAmb);
        //analisar a resposta da SEFAZ para ver se a nota está valida
        //?????????????????????????????????
        return true;
    }
    
    /**
     *
     * @param  int $tpEvento
     * @return stdClass
     * @throws Exception
     */
    private function tpEv($tpEvento)
    {
        $std = new \stdClass();
        $std->alias = '';
        $std->desc = '';
        switch ($tpEvento) {
            case 110110:
                //CCe
                $std->alias = 'CCe';
                $std->desc = 'Carta de Correcao';
                break;
            case 110111:
                //cancelamento
                $std->alias = 'CancNFe';
                $std->desc = 'Cancelamento';
                break;
            case 110140:
                //EPEC
                //emissão em contingência EPEC
                $std->alias = 'EPEC';
                $std->desc = 'EPEC';
                break;
            case 111500:
            case 111501:
                //EPP
                //Pedido de prorrogação
                $std->alias = 'EPP';
                $std->desc = 'Pedido de Prorrogacao';
                break;
            case 111502:
            case 111503:
                //ECPP
                //Cancelamento do Pedido de prorrogação
                $std->alias = 'ECPP';
                $std->desc = 'Cancelamento de Pedido de Prorrogacao';
                break;
            case 210200:
                //Confirmacao da Operacao
                $std->alias = 'EvConfirma';
                $std->desc = 'Confirmacao da Operacao';
                break;
            case 210210:
                //Ciencia da Operacao
                $std->alias = 'EvCiencia';
                $std->desc = 'Ciencia da Operacao';
                $std->tpAutor = 2;
                break;
            case 210220:
                //Desconhecimento da Operacao
                $std->alias = 'EvDesconh';
                $std->desc = 'Desconhecimento da Operacao';
                break;
            case 210240:
                //Operacao não Realizada
                $std->alias = 'EvNaoRealizada';
                $std->desc = 'Operacao nao Realizada';
                break;
            default:
                $msg = "O código do tipo de evento informado não corresponde a "
                . "nenhum evento estabelecido.";
                throw new RuntimeException($msg);
        }
        return $std;
    }
}
