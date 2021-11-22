<?php

/**
 * Class responsible for communication with SEFAZ extends
 * NFePHP\NFe\Common\Tools
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Tools
 * @copyright NFePHP Copyright (c) 2008-2020
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe;

use NFePHP\Common\Strings;
use NFePHP\Common\Signer;
use NFePHP\Common\UFList;
use NFePHP\NFe\Common\Tools as ToolsCommon;
use RuntimeException;
use InvalidArgumentException;

class Tools extends ToolsCommon
{
    const EVT_CONFIRMACAO = 210200; //only one per nfe seq=n
    const EVT_CIENCIA = 210210; //only one per nfe seq=1
    const EVT_DESCONHECIMENTO = 210220; //only one per nfe seq=n
    const EVT_NAO_REALIZADA = 210240; //only one per nfe but seq=n
    const EVT_CCE = 110110; //many seq=n
    const EVT_CANCELA = 110111; //only seq=1
    const EVT_CANCELASUBSTITUICAO = 110112;
    const EVT_EPEC = 110140; //only seq=1
    const EVT_ATORINTERESSADO = 110150; //many seq=n
    const EVT_COMPROVANTE_ENTREGA = 110130; //many seq=n
    const EVT_CANCELAMENTO_COMPROVANTE_ENTREGA = 110131; ///many seq=n
    const EVT_PRORROGACAO_1 = 111500;
    const EVT_PRORROGACAO_2 = 111501;
    const EVT_CANCELA_PRORROGACAO_1 = 111502;
    const EVT_CANCELA_PRORROGACAO_2 = 111503;

    /**
     * Request authorization to issue NFe in batch with one or more documents
     * @param array $aXml array of nfe's xml
     * @param string $idLote lote number
     * @param int $indSinc flag to use synchronous communication
     * @param bool $compactar flag to compress data with gzip
     * @param array $xmls array with xmls substitutes if contigency is on
     * @return string soap response xml
     * @throws InvalidArgumentException
     */
    public function sefazEnviaLote(
        $aXml,
        $idLote = '',
        $indSinc = 0,
        $compactar = false,
        &$xmls = []
    ) {
        if (!is_array($aXml)) {
            throw new InvalidArgumentException('Envia Lote: XMLs de NF-e deve ser um array!');
        }
        if ($indSinc == 1 && count($aXml) > 1) {
            throw new InvalidArgumentException('Envio sincrono deve ser usado para enviar '
                . 'uma UNICA nota por vez. Você está tentando enviar varias.');
        }
        $servico = 'NfeAutorizacao';
        $this->checkContingencyForWebServices($servico);
        if ($this->contingency->type != '') {
            // Em modo de contingencia esses XMLs deverão ser modificados e re-assinados e retornados
            // no parametro $xmls para serem armazenados pelo aplicativo pois serão alterados.
            foreach ($aXml as $doc) {
                //corrigir o xml para o tipo de contigência setado
                $xmls[] = $this->correctNFeForContingencyMode($doc);
            }
            $aXml = $xmls;
        }
        $ax = [];
        foreach ($aXml as $xml) {
            //verifica se o modelo do XML é o mesmo setado na classe
            //gera um exception se não for
            $this->checkModelFromXml($xml);
            $ax[] = trim(preg_replace("/<\?xml.*?\?>/", "", $xml));
        }
        $sxml = trim(implode("", $ax));
        $this->servico($servico, $this->config->siglaUF, $this->tpAmb);
        $request = "<enviNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$idLote</idLote>"
            . "<indSinc>$indSinc</indSinc>"
            . "$sxml"
            . "</enviNFe>";
        $this->isValid($this->urlVersion, $request, 'enviNFe');
        $this->lastRequest = $request;
        //montagem dos dados da mensagem SOAP
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        if ($compactar) {
            $gzdata = base64_encode(gzencode($request, 9, FORCE_GZIP));
            $parameters = ['nfeDadosMsgZip' => $gzdata];
            $body = "<nfeDadosMsgZip xmlns=\"$this->urlNamespace\">$gzdata</nfeDadosMsgZip>";
        }
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Check status of Batch of NFe sent by receipt of this shipment
     * @param string $recibo
     * @param int $tpAmb
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazConsultaRecibo($recibo, $tpAmb = null)
    {
        if (empty($recibo)) {
            throw new InvalidArgumentException('Consulta Recibo: numero do recibo vazio!');
        }
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        //carrega serviço
        $servico = 'NfeRetAutorizacao';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $this->config->siglaUF, $tpAmb);
        if ($this->urlService == '') {
            $msg = "A consulta de NFe nao esta disponivel na SEFAZ {$this->config->siglaUF}!";
            throw new RuntimeException($msg);
        }
        $request = "<consReciNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<nRec>$recibo</nRec>"
            . "</consReciNFe>";
        $this->isValid($this->urlVersion, $request, 'consReciNFe');
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Check the NFe status for the 44-digit key and retrieve the protocol
     * @param string $chave
     * @param int $tpAmb
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazConsultaChave($chave, $tpAmb = null)
    {
        if (empty($chave)) {
            throw new InvalidArgumentException('Consulta chave: a chave esta vazia!');
        }
        if (strlen($chave) != 44 || !is_numeric($chave)) {
            throw new InvalidArgumentException("Consulta chave: chave \"$chave\" invalida!");
        }
        $uf = UFList::getUFByCode(substr($chave, 0, 2));
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        //carrega serviço
        $servico = 'NfeConsultaProtocolo';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $uf, $tpAmb);
        $request = "<consSitNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<xServ>CONSULTAR</xServ>"
            . "<chNFe>$chave</chNFe>"
            . "</consSitNFe>";
        $this->isValid($this->urlVersion, $request, 'consSitNFe');
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Request to disable one or an NFe sequence of a given series
     * @param int $nSerie
     * @param int $nIni
     * @param int $nFin
     * @param string $xJust
     * @param int $tpAmb
     * @param string $ano
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazInutiliza($nSerie, $nIni, $nFin, $xJust, $tpAmb = null, $ano = null)
    {
        if (empty($nIni) || empty($nFin) || empty($xJust)) {
            throw new InvalidArgumentException('Inutilizacao: parametros incompletos!');
        }
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        $xJust = Strings::replaceUnacceptableCharacters($xJust);
        $servico = 'NfeInutilizacao';
        $this->checkContingencyForWebServices($servico);
        //carrega serviço
        $this->servico($servico, $this->config->siglaUF, $tpAmb);
        $cnpj = $this->config->cnpj;
        $strAno = $ano;
        if (empty($ano)) {
            $strAno = (string) date('y');
        }
        $strSerie = str_pad($nSerie, 3, '0', STR_PAD_LEFT);
        $strInicio = str_pad($nIni, 9, '0', STR_PAD_LEFT);
        $strFinal = str_pad($nFin, 9, '0', STR_PAD_LEFT);
        $idInut = "ID"
            . $this->urlcUF
            . $strAno
            . str_pad($cnpj, 14, '0', STR_PAD_LEFT)
            . $this->modelo
            . $strSerie
            . $strInicio
            . $strFinal;
        //limpa os caracteres indesejados da justificativa
        $xJust = Strings::replaceUnacceptableCharacters($xJust);
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
        //inutizaçao para produtor rural com CPF em MT
        $flag = false;
        if ($this->config->siglaUF == 'MT' && strlen($cnpj) == 11) {
            //montagem do corpo da mensagem
            $msg = "<inutNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">" .
                "<infInut Id=\"$idInut\">" .
                "<tpAmb>$tpAmb</tpAmb>" .
                "<xServ>INUTILIZAR</xServ>" .
                "<cUF>$this->urlcUF</cUF>" .
                "<ano>$strAno</ano>" .
                "<CPF>$cnpj</CPF>" .
                "<mod>$this->modelo</mod>" .
                "<serie>$nSerie</serie>" .
                "<nNFIni>$nIni</nNFIni>" .
                "<nNFFin>$nFin</nNFFin>" .
                "<xJust>$xJust</xJust>" .
                "</infInut></inutNFe>";
            $flag = true;
        }
        //assina a solicitação
        $request = Signer::sign(
            $this->certificate,
            $msg,
            'infInut',
            'Id',
            $this->algorithm,
            $this->canonical
        );
        $request = Strings::clearXmlString($request, true);
        if (!$flag) {
            $this->isValid($this->urlVersion, $request, 'inutNFe');
        } else {
            $this->isValid($this->urlVersion, $request, 'MT_inutNFe');
        }
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Search for the registration data of an NFe issuer,
     * if in contingency mode this service will cause a
     * Exception and remember not all Sefaz have this service available,
     * so it will not work in some cases.
     * @param string $uf federation unit (abbreviation)
     * @param string $cnpj CNPJ number (optional)
     * @param string $iest IE number (optional)
     * @param string $cpf CPF number (optional)
     * @return string xml soap response
     * @throws InvalidArgumentException
     */
    public function sefazCadastro($uf, $cnpj = '', $iest = '', $cpf = '')
    {
        $filter = '';
        if (!empty($cnpj)) {
            $filter = "<CNPJ>$cnpj</CNPJ>";
        } elseif (!empty($iest)) {
            $filter = "<IE>$iest</IE>";
        } elseif (!empty($cpf)) {
            $filter = "<CPF>$cpf</CPF>";
        }
        if (empty($uf) || empty($filter)) {
            throw new InvalidArgumentException('Sigla UF esta vazia ou CNPJ+IE+CPF vazios!');
        }
        //carrega serviço
        $servico = 'NfeConsultaCadastro';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $uf, $this->tpAmb, true);
        $request = "<ConsCad xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infCons>"
            . "<xServ>CONS-CAD</xServ>"
            . "<UF>$uf</UF>"
            . "$filter"
            . "</infCons>"
            . "</ConsCad>";
        if (strtoupper($uf) == 'MT') {
            $request = "<nfeDadosMsg>$request</nfeDadosMsg>" ;
        }
        $this->isValid($this->urlVersion, $request, 'consCad');
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        if ($this->urlVersion === '2.00') {
            $this->objHeader = new \SoapHeader(
                $this->urlNamespace,
                'nfeCabecMsg',
                ['cUF' => $this->urlcUF, 'versaoDados' => $this->urlVersion]
            );
        }
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Check services status SEFAZ/SVC
     * If $uf is empty use normal check with contingency
     * If $uf is NOT empty ignore contingency mode
     * @param string $uf  initials of federation unit
     * @param int $tpAmb
     * @param bool $ignoreContingency
     * @return string xml soap response
     */
    public function sefazStatus($uf = '', $tpAmb = null, $ignoreContingency = true)
    {
        if (empty($tpAmb)) {
            $tpAmb = $this->tpAmb;
        }
        if (empty($uf)) {
            $uf = $this->config->siglaUF;
            $ignoreContingency = false;
        }
        $servico = 'NfeStatusServico';
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
     * Service for the distribution of summary information and
     * electronic tax documents of interest to an actor.
     * @param integer $ultNSU  last NSU number recived
     * @param integer $numNSU  NSU number you wish to consult
     * @param string $fonte data source 'AN' and for some cases it may be 'RS'
     * @param string $chave you wish to consult
     * @return string
     */
    public function sefazDistDFe($ultNSU = 0, $numNSU = 0, $fonte = 'AN', $chave = '')
    {
        //carrega serviço
        $servico = 'NfeDistribuicaoDFe';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $fonte, $this->tpAmb, true);
        $cUF = UFList::getCodeByUF($this->config->siglaUF);
        $cnpj = $this->config->cnpj;
        $ultNSU = str_pad($ultNSU, 15, '0', STR_PAD_LEFT);
        $tagNSU = "<distNSU><ultNSU>$ultNSU</ultNSU></distNSU>";
        if ($numNSU != 0) {
            $numNSU = str_pad($numNSU, 15, '0', STR_PAD_LEFT);
            $tagNSU = "<consNSU><NSU>$numNSU</NSU></consNSU>";
        } else if (strlen($chave) == 44 && is_numeric($chave)) {
            $tagNSU = "<consChNFe><chNFe>$chave</chNFe></consChNFe>";
        }
        //monta a consulta
        $consulta = "<distDFeInt xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>" . $this->tpAmb . "</tpAmb>"
            . "<cUFAutor>$cUF</cUFAutor>";
        if ($this->typePerson === 'J') {
            $consulta .= "<CNPJ>$cnpj</CNPJ>";
        } else {
            $consulta .= "<CPF>$cnpj</CPF>";
        }
        $consulta .= "$tagNSU"
            . "</distDFeInt>";
        //valida o xml da requisição
        $this->isValid($this->urlVersion, $consulta, 'distDFeInt');
        $this->lastRequest = $consulta;
        //montagem dos dados da mensagem SOAP
        $request = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$consulta</nfeDadosMsg>";
        $parameters = ['nfeDistDFeInteresse' => $request];
        $body = "<nfeDistDFeInteresse xmlns=\"$this->urlNamespace\">"
            . $request
            . "</nfeDistDFeInteresse>";
        //este webservice não requer cabeçalho
        $this->objHeader = null;
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Request authorization for Letter of Correction
     * @param string $chave
     * @param string $xCorrecao
     * @param int $nSeqEvento
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazCCe($chave, $xCorrecao, $nSeqEvento = 1)
    {
        if (empty($chave) || empty($xCorrecao)) {
            throw new InvalidArgumentException('CC-e: chave ou motivo da correcao vazio!');
        }
        $uf = $this->validKeyByUF($chave);
        $xCorrecao = Strings::replaceUnacceptableCharacters(substr(trim($xCorrecao), 0, 1000));
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
        return $this->sefazEvento($uf, $chave, self::EVT_CCE, $nSeqEvento, $tagAdic);
    }

    /**
     * Evento do Ator Interessado
     * NOTA: NT2020.007_v1.00a
     * @param \stdClass $std
     * @return string
     */
    public function sefazAtorInteressado(\stdClass $std)
    {
        $xCondUso = 'O emitente ou destinatário da NF-e, declara que permite o '
            . 'transportador declarado no campo CNPJ/CPF deste evento a '
            . 'autorizar os transportadores subcontratados ou redespachados a '
            . 'terem acesso ao download da NF-e';
        if (empty($std->verAplic) && !empty($this->verAplic)) {
            $std->verAplic = $this->verAplic;
        }
        $cUF = UFList::getCodeByUF($this->config->siglaUF);
        $tagAdic = "<cOrgaoAutor>{$cUF}</cOrgaoAutor>"
            . "<tpAutor>{$std->tpAutor}</tpAutor>"
            . "<verAplic>{$std->verAplic}</verAplic>"
            . "<autXML>";
        $tagAdic .=  !empty($std->CNPJ)
            ? "<CNPJ>{$std->CNPJ}</CNPJ>"
            : "<CPF>{$std->CPF}</CPF>";
        $tagAdic .= "</autXML>"
            . "<tpAutorizacao>{$std->tpAutorizacao}</tpAutorizacao>"
            . "<xCondUso>$xCondUso</xCondUso>";
        return $this->sefazEvento(
            'AN',
            $std->chNFe,
            self::EVT_ATORINTERESSADO,
            $std->nSeqEvento,
            $tagAdic
        );
    }

    /**
     * Request extension of the term of return of products of an NF-e of
     * consignment for industrialization to order with suspension of ICMS
     * in interstate operations
     * @param string $chNFe
     * @param string $nProt
     * @param integer $tipo 1-primerio prazo, 2-segundo prazo
     * @param array $itens
     * @param integer $nSeqEvento
     * @return string
     */
    public function sefazEPP(
        $chNFe,
        $nProt,
        $itens = [],
        $tipo = 1,
        $nSeqEvento = 1
    ) {
        $uf = UFList::getUFByCode(substr($chNFe, 0, 2));
        //pedido de prorrogação primero prazo
        $tpEvento = 111500;
        if ($tipo == 2) {
            //pedido de prorrogação segundo prazo
            $tpEvento = 111501;
        }
        $tagAdic = "<nProt>$nProt</nProt>";
        foreach ($itens as $item) {
            $tagAdic .= "<itemPedido numItem=\""
                . $item[0]
                . "\"><qtdeItem>"
                . $item[1]
                . "</qtdeItem></itemPedido>";
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
     * Request the cancellation of the request for an extension of the term
     * of return of products of an NF-e of consignment for industrialization
     * by order with suspension of ICMS in interstate operations
     * @param string $chave
     * @param string $nProt
     * @param integer $tipo 1-primerio prazo, 2-segundo prazo
     * @param integer $nSeqEvento
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazECPP($chave, $nProt, $tipo, $nSeqEvento = 1)
    {
        if (empty($chave) || empty($nProt)) {
            throw new InvalidArgumentException('A chave ou o numero do protocolo estão vazios!');
        }
        $uf = UFList::getUFByCode(substr($chave, 0, 2));
        $tpEvento = self::EVT_CANCELA_PRORROGACAO_1; //111502;
        $origEvent = self::EVT_PRORROGACAO_1; //111500;
        if ($tipo == 2) {
            //pedido de cancelamento do segundo prazo
            $tpEvento = self::EVT_CANCELA_PRORROGACAO_2; //111503;
            $origEvent = self::EVT_PRORROGACAO_2; //111501;
        }
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $idPedidoCancelado = "ID{$origEvent}{$chave}{$sSeqEvento}";
        $tagAdic = "<idPedidoCancelado>"
                . "$idPedidoCancelado"
                . "</idPedidoCancelado>"
                . "<nProt>$nProt</nProt>";
        return $this->sefazEvento($uf, $chave, $tpEvento, $nSeqEvento, $tagAdic);
    }

    /**
     * Requires nfe cancellation
     * @param  string $chave key of NFe
     * @param  string $xJust justificative 255 characters max
     * @param  string $nProt protocol number
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazCancela($chave, $xJust, $nProt)
    {
        if (empty($chave) || empty($xJust) || empty($nProt)) {
            throw new InvalidArgumentException('Cancelamento: chave, just ou numprot vazio!');
        }
        $uf = $this->validKeyByUF($chave);
        $xJust = Strings::replaceUnacceptableCharacters(substr(trim($xJust), 0, 255));
        $nSeqEvento = 1;
        $tagAdic = "<nProt>$nProt</nProt><xJust>$xJust</xJust>";
        return $this->sefazEvento($uf, $chave, self::EVT_CANCELA, $nSeqEvento, $tagAdic);
    }

    /**
     * Requires nfe cancellation by substitution
     * @param string $chave key of NFe
     * @param string $xJust justificative 255 characters max
     * @param string $nProt protocol number
     * @param string $chNFeRef key of New NFe
     * @param string $verAplic version of applicative
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazCancelaPorSubstituicao($chave, $xJust, $nProt, $chNFeRef, $verAplic = null)
    {
        if ($this->modelo != 65) {
            throw new InvalidArgumentException(
                'Cancelamento pro Substituição deve ser usado apenas para '
                . 'operações com modelo 65 NFCe'
            );
        }
        if (empty($verAplic) && !empty($this->verAplic)) {
            $verAplic = $this->verAplic;
        }
        if (
            empty($chave) || empty($xJust) || empty($nProt)
            || empty($chNFeRef) || empty($verAplic)
        ) {
            throw new InvalidArgumentException(
                'CancelamentoPorSubs: chave da NFCe cancelada, justificativa, '
                . 'protocolo, chave da NFCe substituta, ou versão do aplicativo '
                . 'emissor não podem ser vazios!'
            );
        }
        $uf = $this->validKeyByUF($chave);
        $xJust = Strings::replaceUnacceptableCharacters(substr(trim($xJust), 0, 255));
        $nSeqEvento = 1;
        $cOrgao = substr($chave, 0, 2);
        $tagAdic = "<cOrgaoAutor>$cOrgao</cOrgaoAutor>"
            . "<tpAutor>1</tpAutor>"
            . "<verAplic>$verAplic</verAplic>"
            . "<nProt>$nProt</nProt>"
            . "<xJust>$xJust</xJust>"
            . "<chNFeRef>$chNFeRef</chNFeRef>";
        return $this->sefazEvento($uf, $chave, self::EVT_CANCELASUBSTITUICAO, $nSeqEvento, $tagAdic);
    }

    /**
     * Request the registration of the manifestation of recipient
     * @param string $chave
     * @param int $tpEvento
     * @param string $xJust Justification for not carrying out the operation
     * @param int $nSeqEvento
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazManifesta($chave, $tpEvento, $xJust = '', $nSeqEvento = 1)
    {
        if (empty($chave) || empty($tpEvento)) {
            throw new InvalidArgumentException('Manifestacao: chave ou tipo de evento vazio!');
        }
        $tagAdic = '';
        if ($tpEvento == self::EVT_NAO_REALIZADA) {
            $xJust = Strings::replaceUnacceptableCharacters(substr(trim($xJust), 0, 255));
            $tagAdic = "<xJust>$xJust</xJust>";
        }
        return $this->sefazEvento('AN', $chave, $tpEvento, $nSeqEvento, $tagAdic);
    }

    /**
     * Request the registration of the manifestation of recipient in batch
     * @param \stdClass $std
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function sefazManifestaLote(\stdClass $std)
    {
        $allowed = [
            self::EVT_CONFIRMACAO,
            self::EVT_CIENCIA,
            self::EVT_DESCONHECIMENTO,
            self::EVT_NAO_REALIZADA,
        ];
        if (empty($std) || empty($std->evento)) {
            throw new InvalidArgumentException('Manifestacao: parametro "std" ou evento estao vazios!');
        }
        if (count($std->evento) > 20) {
            throw new RuntimeException('Manifestacao: o lote de eventos esta limitado a 20!');
        }
        $evt = new \stdClass();
        $i = 0;
        foreach ($std->evento as $s) {
            if (!in_array($s->tpEvento, $allowed)) { // se o evento não estiver entre os permitidos ignore
                continue;
            }
            $tagAdic = '';
            if ($s->tpEvento == self::EVT_NAO_REALIZADA) {
                $xJust = Strings::replaceUnacceptableCharacters(substr(trim($s->xJust), 0, 255));
                $tagAdic = "<xJust>$xJust</xJust>";
            }
            $evt->evento[$i] = new \stdClass();
            $evt->evento[$i]->chave = $s->chNFe;
            $evt->evento[$i]->tpEvento = $s->tpEvento;
            $evt->evento[$i]->nSeqEvento = $s->nSeqEvento;
            $evt->evento[$i]->tagAdic = $tagAdic;
            $i++;
        }
        return $this->sefazEventoLote('AN', $evt);
    }

    /**
     * Send event for delivery receipt
     * @param \stdClass $std
     * @return string
     */
    public function sefazComprovanteEntrega(\stdClass $std)
    {
        if (empty($std->verAplic) && !empty($this->verAplic)) {
            $std->verAplic = $this->verAplic;
        }
        $hash = base64_encode(sha1($std->chNFe . $std->imagem, true));
        $datahash = date('Y-m-d\TH:i:sP');
        $cod = UFList::getCodeByUF($this->config->siglaUF);
        $cancelar = !empty($std->cancelar) ? $std->cancelar : false;
        if (!$cancelar) {
            $tagAdic = "<cOrgaoAutor>{$cod}</cOrgaoAutor>"
                . "<tpAutor>1</tpAutor>"
                . "<verAplic>{$std->verAplic}</verAplic>"
                . "<dhEntrega>{$std->data_recebimento}</dhEntrega>"
                . "<nDoc>{$std->documento_recebedor}</nDoc>"
                . "<xNome>{$std->nome_recebedor}</xNome>";
            if (!empty($std->latitude) && !empty($std->longitude)) {
                $tagAdic .= "<latGPS>{$std->latitude}</latGPS>"
                    . "<longGPS>{$std->longitude}</longGPS>";
            }
            $tagAdic .= "<hashComprovante>{$hash}</hashComprovante>"
                . "<dhHashComprovante>{$datahash}</dhHashComprovante>";
            $tpEvento = self::EVT_COMPROVANTE_ENTREGA;
        } else {
            $tpEvento = self::EVT_CANCELAMENTO_COMPROVANTE_ENTREGA;
            $tagAdic = "<cOrgaoAutor>{$cod}</cOrgaoAutor>"
                . "<tpAutor>1</tpAutor>"
                . "<verAplic>{$std->verAplic}</verAplic>"
                . "<nProtEvento>{$std->nProcEvento}</nProtEvento>";
        }
        return $this->sefazEvento(
            'AN',
            $std->chNFe,
            $tpEvento,
            $std->nSeqEvento,
            $tagAdic
        );
    }

    /**
     * Send event to SEFAZ in batch
     * @param string $uf
     * @param \stdClass $std
     * @return string
     * @throws RuntimeException
     * @throws InvalidArgumentException
     */
    public function sefazEventoLote($uf, \stdClass $std)
    {
        if (empty($uf) || empty($std)) {
            throw new InvalidArgumentException('Evento Lote: UF ou parametro "std" vazio!');
        }
        if (count($std->evento) > 20) {
            throw new RuntimeException('Evento Lote: o lote de eventos esta limitado a 20!');
        }
        $servico = 'RecepcaoEvento';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $uf, $this->tpAmb, false);
        $batchRequest = '';
        foreach ($std->evento as $evt) {
            if ($evt->tpEvento == self::EVT_EPEC) {
                continue; //não é possivel enviar EPEC com outros eventos
            }
            $ev = $this->tpEv($evt->tpEvento);
            $descEvento = $ev->desc;
            $cnpj = $this->config->cnpj;
            $dt = new \DateTime('now', new \DateTimeZone($this->timezone));
            $dhEvento = $dt->format('Y-m-d\TH:i:sP');
            $sSeqEvento = str_pad($evt->nSeqEvento, 2, "0", STR_PAD_LEFT);
            $eventId = "ID" . $evt->tpEvento . $evt->chave . $sSeqEvento;
            $cOrgao = UFList::getCodeByUF($uf);
            $request = "<evento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<infEvento Id=\"$eventId\">"
                . "<cOrgao>$cOrgao</cOrgao>"
                . "<tpAmb>$this->tpAmb</tpAmb>";
            if ($this->typePerson === 'J') {
                $request .= "<CNPJ>$cnpj</CNPJ>";
            } else {
                $request .= "<CPF>$cnpj</CPF>";
            }
            $request .= "<chNFe>$evt->chave</chNFe>"
                . "<dhEvento>$dhEvento</dhEvento>"
                . "<tpEvento>$evt->tpEvento</tpEvento>"
                . "<nSeqEvento>$evt->nSeqEvento</nSeqEvento>"
                . "<verEvento>$this->urlVersion</verEvento>"
                . "<detEvento versao=\"$this->urlVersion\">"
                . "<descEvento>$descEvento</descEvento>"
                . "$evt->tagAdic"
                . "</detEvento>"
                . "</infEvento>"
                . "</evento>";
            //assinatura dos dados
            $request = Signer::sign(
                $this->certificate,
                $request,
                'infEvento',
                'Id',
                $this->algorithm,
                $this->canonical
            );
            $batchRequest .= Strings::clearXmlString($request, true);
        }
        $dt = new \DateTime('now', new \DateTimeZone($this->timezone));
        $lote = $dt->format('YmdHis') . rand(0, 9);
        $request = "<envEvento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$lote</idLote>"
            . $batchRequest
            . "</envEvento>";
        $this->isValid($this->urlVersion, $request, 'envEvento');
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Request authorization for issuance in contingency EPEC
     * @param string $xml
     * @param string $verAplic
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function sefazEPEC(&$xml, $verAplic = null)
    {
        if (empty($xml)) {
            throw new InvalidArgumentException('EPEC: parâmetro xml esta vazio!');
        }
        $nSeqEvento = 1;
        if ($this->contingency->type !== 'EPEC') {
            throw new RuntimeException('A contingencia EPEC deve estar ativada!');
        }
        //ajusta a NFe para a contingência definida e assina novamente
        $xml = $this->correctNFeForContingencyMode($xml);
        //extrai os dados da NFe
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $emit = $dom->getElementsByTagName('emit')->item(0);
        $dest = $dom->getElementsByTagName('dest')->item(0);
        $cOrgaoAutor = UFList::getCodeByUF($this->config->siglaUF);
        $chNFe = substr($infNFe->getAttribute('Id'), 3, 44);
        $ufchave = substr($chNFe, 0, 2);
        if ($cOrgaoAutor != $ufchave) {
            throw new RuntimeException("O autor [{$cOrgaoAutor}] não é da mesma UF que a NFe [{$ufchave}]");
        }
        // EPEC
        $verProc = $dom->getElementsByTagName('verProc')->item(0)->nodeValue;
        $dhEmi = $dom->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $tpNF = $dom->getElementsByTagName('tpNF')->item(0)->nodeValue;
        $emitIE = $emit->getElementsByTagName('IE')->item(0)->nodeValue;
        $destUF = $dest->getElementsByTagName('UF')->item(0)->nodeValue;
        $total = $dom->getElementsByTagName('total')->item(0);
        $vNF = $total->getElementsByTagName('vNF')->item(0)->nodeValue;
        $vICMS = $total->getElementsByTagName('vICMS')->item(0)->nodeValue;
        $vST = $total->getElementsByTagName('vST')->item(0)->nodeValue;
        $dID = !empty($dest->getElementsByTagName('CNPJ')->item(0))
            ? $dest->getElementsByTagName('CNPJ')->item(0)->nodeValue
            : null;
        if (!empty($dID)) {
            $destID = "<CNPJ>$dID</CNPJ>";
        } else {
            $dID = !empty($dest->getElementsByTagName('CPF')->item(0)->nodeValue)
                ? $dest->getElementsByTagName('CPF')->item(0)->nodeValue : null;
            if (!empty($dID)) {
                $destID = "<CPF>$dID</CPF>";
            } else {
                $dID = $dest->getElementsByTagName('idEstrangeiro')
                    ->item(0)
                    ->nodeValue;
                $destID = "<idEstrangeiro>$dID</idEstrangeiro>";
            }
        }
        $dIE = !empty($dest->getElementsByTagName('IE')->item(0)->nodeValue)
            ? $dest->getElementsByTagName('IE')->item(0)->nodeValue
            : '';
        $destIE = '';
        if (!empty($dIE)) {
            $destIE = "<IE>{$dIE}</IE>";
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
            . "<dest>"
            . "<UF>{$destUF}</UF>"
            . $destID
            . $destIE
            . "<vNF>{$vNF}</vNF>"
            . "<vICMS>{$vICMS}</vICMS>"
            . "<vST>{$vST}</vST>"
            . "</dest>";
        return $this->sefazEvento('AN', $chNFe, self::EVT_EPEC, $nSeqEvento, $tagAdic);
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
        $eventos = [
            self::EVT_CCE => ['versao' => '1.00', 'nome' => 'envCCe'],
            self::EVT_CANCELA => ['versao' => '1.00', 'nome' => 'envEventoCancNFe'],
            self::EVT_CANCELASUBSTITUICAO => ['versao' => '1.00', 'nome' => 'envEventoCancSubst'],
            self::EVT_ATORINTERESSADO => ['versao' => '1.00', 'nome' => 'envEventoAtorInteressado'],
            self::EVT_COMPROVANTE_ENTREGA => ['versao' => '1.00', 'nome' => 'envEventoEntregaNFe'],
            self::EVT_CANCELAMENTO_COMPROVANTE_ENTREGA => ['versao' => '1.00', 'nome' => 'envEventoCancEntregaNFe'],
            self::EVT_CIENCIA => ['versao' => '1.00', 'nome' => 'envConfRecebto'],
            self::EVT_CONFIRMACAO => ['versao' => '1.00', 'nome' => 'envConfRecebto'],
            self::EVT_DESCONHECIMENTO => ['versao' => '1.00', 'nome' => 'envConfRecebto'],
            self::EVT_NAO_REALIZADA => ['versao' => '1.00', 'nome' => 'envConfRecebto'],
            self::EVT_PRORROGACAO_1 => ['versao' => '1.00', 'nome' => 'envRemIndus'],
            self::EVT_PRORROGACAO_2 => ['versao' => '1.00', 'nome' => 'envRemIndus'],
            self::EVT_CANCELA_PRORROGACAO_1 => ['versao' => '1.00', 'nome' => 'envRemIndus'],
            self::EVT_CANCELA_PRORROGACAO_2 => ['versao' => '1.00', 'nome' => 'envRemIndus'],
            self::EVT_EPEC => ['versao' => '1.00', 'nome' => 'envEPEC'],
        ];
        $verEvento = $this->urlVersion;
        if (!empty($eventos[$tpEvento])) {
            $evt = $eventos[$tpEvento];
            $verEvento = $evt['versao'];
        }
        $ignore = $tpEvento == self::EVT_EPEC;
        $servico = 'RecepcaoEvento';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $uf, $this->tpAmb, $ignore);
        $ev = $this->tpEv($tpEvento);
        $descEvento = $ev->desc;
        $cnpj = isset($this->config->cnpj) ? $this->config->cnpj : '';
        $dt = new \DateTime(date("Y-m-d H:i:sP"), new \DateTimeZone($this->timezone));
        $dhEvento = $dt->format('Y-m-d\TH:i:sP');
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $eventId = "ID" . $tpEvento . $chave . $sSeqEvento;
        $cOrgao = UFList::getCodeByUF($uf);
        $request = "<evento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<infEvento Id=\"$eventId\">"
            . "<cOrgao>$cOrgao</cOrgao>"
            . "<tpAmb>$this->tpAmb</tpAmb>";
        if ($this->typePerson === 'J') {
            $request .= "<CNPJ>$cnpj</CNPJ>";
        } else {
            $request .= "<CPF>$cnpj</CPF>";
        }
        $request .= "<chNFe>$chave</chNFe>"
            . "<dhEvento>$dhEvento</dhEvento>"
            . "<tpEvento>$tpEvento</tpEvento>"
            . "<nSeqEvento>$nSeqEvento</nSeqEvento>"
            . "<verEvento>$verEvento</verEvento>"
            . "<detEvento versao=\"$verEvento\">"
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
            'Id',
            $this->algorithm,
            $this->canonical
        );
        $request = Strings::clearXmlString($request, true);
        $lote = $dt->format('YmdHis') . rand(0, 9);
        $request = "<envEvento xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<idLote>$lote</idLote>"
            . $request
            . "</envEvento>";
        if (!empty($eventos[$tpEvento])) {
            $evt = $eventos[$tpEvento];
            $this->isValid($evt['versao'], $request, $evt['nome']);
        } else {
            $this->isValid($this->urlVersion, $request, 'envEvento');
        }
        $this->lastRequest = $request;
        //return $request;

        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Request the NFe download already manifested by its recipient, by the key
     * using new service in NfeDistribuicaoDFe
     * NOTA: NfeDownloadNF is deactivated
     * @param  string $chave
     * @return string
     * @throws InvalidArgumentException
     */
    public function sefazDownload($chave)
    {
        if (empty($chave)) {
            throw new InvalidArgumentException('Download: chave esta vazia!');
        }
        //carrega serviço
        $servico = 'NfeDistribuicaoDFe';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, 'AN', $this->tpAmb, true);
        $cUF = UFList::getCodeByUF($this->config->siglaUF);
        $tagChave = "<consChNFe><chNFe>$chave</chNFe></consChNFe>";
        $cnpj = $this->config->cnpj;
        //monta a consulta
        $request = "<distDFeInt xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>" . $this->tpAmb . "</tpAmb>"
            . "<cUFAutor>$cUF</cUFAutor>";
        if ($this->typePerson === 'J') {
            $request .= "<CNPJ>$cnpj</CNPJ>";
        } else {
            $request .= "<CPF>$cnpj</CPF>";
        }
        $request .= "$tagChave"
            . "</distDFeInt>";
        //valida o xml da requisição
        $this->isValid($this->urlVersion, $request, 'distDFeInt');
        $this->lastRequest = $request;
        //montagem dos dados da mensagem SOAP
        $request = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $parameters = ['nfeDistDFeInteresse' => $request];
        $body = "<nfeDistDFeInteresse xmlns=\"$this->urlNamespace\">"
            . $request
            . "</nfeDistDFeInteresse>";
        //este webservice não requer cabeçalho
        $this->objHeader = null;
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Maintenance of the Taxpayer Security Code - CSC (Old Token)
     * @param int $indOp Identificador do tipo de operação:
     *                   1 - Consulta CSC Ativos;
     *                   2 - Solicita novo CSC;
     *                   3 - Revoga CSC Ativo
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function sefazCsc($indOp)
    {
        if (empty($indOp) || $indOp < 1 || $indOp > 3) {
            throw new InvalidArgumentException('CSC: identificador operacao invalido!');
        }
        if ($this->modelo != 65) {
            throw new RuntimeException('CSC: modelo diferente de 65!');
        }
        $raizCNPJ = substr($this->config->cnpj, 0, -6);
        //carrega serviço
        $servico = 'CscNFCe';
        $this->checkContingencyForWebServices($servico);
        $this->servico($servico, $this->config->siglaUF, $this->tpAmb);
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
            . "<idCsc>" . $this->config->CSCid . "</idCsc>"
            . "<codigoCsc>" . $this->config->CSC . "</codigoCsc>"
            . "</dadosCsc>"
            . "</admCscNFCe>";
        }
        //o xsd não está disponivel
        $this->isValid($this->urlVersion, $request, 'admCscNFCe');
        $this->lastRequest = $request;
        $parameters = ['nfeDadosMsg' => $request];
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$request</nfeDadosMsg>";
        $this->lastResponse = $this->sendRequest($body, $parameters);
        return $this->lastResponse;
    }

    /**
     * Checks the validity of an NFe, normally used for received NFe
     * @param string $nfe
     * @return bool
     * @throws InvalidArgumentException
     */
    public function sefazValidate($nfe)
    {
        if (empty($nfe)) {
            throw new InvalidArgumentException('Validacao NF-e: a string da NF-e esta vazia!');
        }
        //verifica a assinatura da NFe, exception caso de falha
        Signer::isSigned($nfe);
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->formatOutput = false;
        $dom->preserveWhiteSpace = false;
        $dom->loadXML($nfe);
        //verifica a validade no webservice da SEFAZ
        $tpAmb = $dom->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $infNFe  = $dom->getElementsByTagName('infNFe')->item(0);
        $chNFe = preg_replace('/[^0-9]/', '', $infNFe->getAttribute("Id"));
        $protocol = $dom->getElementsByTagName('nProt')->item(0)->nodeValue;
        $digval = $dom->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        //consulta a NFe
        $response = $this->sefazConsultaChave($chNFe, $tpAmb);
        $ret = new \DOMDocument('1.0', 'UTF-8');
        $ret->preserveWhiteSpace = false;
        $ret->formatOutput = false;
        $ret->loadXML($response);
        $retProt = $ret->getElementsByTagName('protNFe')->item(0);
        if (!isset($retProt)) {
            $xMotivo = $ret->getElementsByTagName('xMotivo')->item(0);
            if (isset($xMotivo)) {
                throw new InvalidArgumentException('Validacao NF-e: ' . $xMotivo->nodeValue);
            } else {
                throw new InvalidArgumentException('O documento de resposta nao contem o node "protNFe".');
            }
        }
        $infProt = $ret->getElementsByTagName('infProt')->item(0);
        $dig = $infProt->getElementsByTagName("digVal")->item(0);
        $digProt = '000';
        if (isset($dig)) {
            $digProt = $dig->nodeValue;
        }
        $chProt = $infProt->getElementsByTagName("chNFe")->item(0)->nodeValue;
        $nProt = $infProt->getElementsByTagName("nProt")->item(0)->nodeValue;
        if ($protocol == $nProt && $digval == $digProt && $chNFe == $chProt) {
            return true;
        }
        return false;
    }

    /**
     * Returns alias and description event from event code.
     * @param  int $tpEvento
     * @return \stdClass
     * @throws \RuntimeException
     */
    private function tpEv($tpEvento)
    {
        $std = new \stdClass();
        $std->alias = '';
        $std->desc = '';
        switch ($tpEvento) {
            case self::EVT_CCE:
                $std->alias = 'CCe';
                $std->desc = 'Carta de Correcao';
                break;
            case self::EVT_CANCELA:
                $std->alias = 'CancNFe';
                $std->desc = 'Cancelamento';
                break;
            case self::EVT_CANCELASUBSTITUICAO:
                $std->alias = 'CancNFe';
                $std->desc = 'Cancelamento por substituicao';
                break;
            case self::EVT_EPEC: // Emissão em contingência EPEC
                $std->alias = 'EPEC';
                $std->desc = 'EPEC';
                break;
            case self::EVT_COMPROVANTE_ENTREGA:
                $std->alias = 'CompEntrega';
                $std->desc = 'Comprovante de Entrega da NF-e';
                break;
            case self::EVT_CANCELAMENTO_COMPROVANTE_ENTREGA:
                $std->alias = 'CancCompEntrega';
                $std->desc = 'Cancelamento Comprovante de Entrega da NF-e';
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
            case self::EVT_CONFIRMACAO: // Manifestação Confirmacao da Operação
                $std->alias = 'EvConfirma';
                $std->desc = 'Confirmacao da Operacao';
                break;
            case self::EVT_CIENCIA: // Manifestação Ciencia da Operação
                $std->alias = 'EvCiencia';
                $std->desc = 'Ciencia da Operacao';
                $std->tpAutor = 2;
                break;
            case self::EVT_DESCONHECIMENTO: // Manifestação Desconhecimento da Operação
                $std->alias = 'EvDesconh';
                $std->desc = 'Desconhecimento da Operacao';
                break;
            case self::EVT_NAO_REALIZADA: // Manifestação Operacao não Realizada
                $std->alias = 'EvNaoRealizada';
                $std->desc = 'Operacao nao Realizada';
                break;
            case self::EVT_ATORINTERESSADO: //ator interessado
                $std->alias = 'EvAtorInteressado';
                $std->desc = 'Ator interessado na NF-e';
                break;
            default:
                $msg = "O código do tipo de evento informado não corresponde a "
                . "nenhum evento estabelecido.";
                throw new RuntimeException($msg);
        }
        return $std;
    }
}
