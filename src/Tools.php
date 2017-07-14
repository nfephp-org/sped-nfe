<?php

namespace NFePHP\NFe;

/**
 * Classe principal para a comunicação com a SEFAZ
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\ToolsNFe
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\Common\Base\BaseTools;
use NFePHP\Common\DateTime\DateTime;
use NFePHP\Common\LotNumber\LotNumber;
use NFePHP\Common\Strings\Strings;
use NFePHP\Common\Files;
use NFePHP\Common\Exception;
use NFePHP\Common\Dom\Dom;
use NFePHP\NFe\Auxiliar\Response;
use NFePHP\NFe\Mail;
use NFePHP\NFe\Auxiliar\IdentifyNFe;
use NFePHP\Common\Dom\ValidXsd;

if (!defined('NFEPHP_ROOT')) {
    define('NFEPHP_ROOT', dirname(dirname(__FILE__)));
}

class Tools extends BaseTools
{
    /**
     * errrors
     *
     * @var string
     */
    public $errors = array();
    /**
     * soapDebug
     *
     * @var string
     */
    public $soapDebug = '';
    /**
     * urlPortal
     * Instância do WebService
     *
     * @var string
     */
    protected $urlPortal = 'http://www.portalfiscal.inf.br/nfe';
    /**
     * aLastRetEvent
     *
     * @var array
     */
    private $aLastRetEvent = array();

    /**
     * Define se salva as mensagens dos eventos em arquivo
     *
     * @var bool
     */
    private $bSalvarMensagensEvento  = true;
    
    public static $PL_008i2 = 'PL_008i2';


    /**
     * setModelo
     *
     * Ajusta o modelo da NFe 55 ou 65
     *
     * @param string $modelo
     */
    public function setModelo($modelo = '55')
    {
        //força pelo menos um modelo correto
        if ($modelo != '55' && $modelo != '65') {
            $modelo = '55';
        }
        $this->modelo = $modelo;
    }

    /**
     * getModelo
     * Retorna o modelo de NFe atualmente setado
     *
     * @return string
     */
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * ativaContingencia
     * Ativa a contingencia SVCAN ou SVCRS conforme a
     * sigla do estado ou EPEC
     *
     * @param  string $siglaUF
     * @param  string $motivo
     * @param  string $tipo
     * @return bool
     */
    public function ativaContingencia($siglaUF = '', $motivo = '', $tipo = '')
    {
        if ($siglaUF == '' || $motivo == '') {
            return false;
        }
        if ($this->enableSVCAN || $this->enableSVCRS || $this->enableEPEC) {
            return true;
        }
        $this->motivoContingencia = $motivo;
        $this->tsContingencia = time(); // mktime() necessita de paramentos...
        $ctgList = array(
            'AC'=>'SVCAN',
            'AL'=>'SVCAN',
            'AM'=>'SVCAN',
            'AP'=>'SVCRS',
            'BA'=>'SVCRS',
            'CE'=>'SVCRS',
            'DF'=>'SVCAN',
            'ES'=>'SVCRS',
            'GO'=>'SVCRS',
            'MA'=>'SVCRS',
            'MG'=>'SVCAN',
            'MS'=>'SVCRS',
            'MT'=>'SVCRS',
            'PA'=>'SVCRS',
            'PB'=>'SVCAN',
            'PE'=>'SVCRS',
            'PI'=>'SVCRS',
            'PR'=>'SVCRS',
            'RJ'=>'SVCAN',
            'RN'=>'SVCRS',
            'RO'=>'SVCAN',
            'RR'=>'SVCAN',
            'RS'=>'SVCAN',
            'SC'=>'SVCAN',
            'SE'=>'SVCAN',
            'SP'=>'SVCAN',
            'TO'=>'SVCAN'
        );
        $ctg = $ctgList[$siglaUF];

        $this->enableSVCAN = false;
        $this->enableSVCRS = false;
        $this->enableEPEC = false;

        if ($tipo == 'EPEC') {
            $this->enableEPEC = true;
        } else {
            if ($ctg == 'SVCAN') {
                $this->enableSVCAN = true;
            } elseif ($ctg == 'SVCRS') {
                $this->enableSVCRS = true;
            }
        }
        $aCont = array(
            'motivo' => $this->motivoContingencia,
            'ts' => $this->tsContingencia,
            'SVCAN' => $this->enableSVCAN,
            'SVCRS' => $this->enableSVCRS,
            'EPEC' => $this->enableEPEC
        );
        $strJson = json_encode($aCont);
        $filename = NFEPHP_ROOT
            . DIRECTORY_SEPARATOR
            . 'config'
            . DIRECTORY_SEPARATOR
            . $this->aConfig['cnpj']
            . '_contingencia.json';
        file_put_contents($filename, $strJson);
        return true;
    }

    /**
     * desativaContingencia
     * Desliga opção de contingência
     *
     * @return boolean
     */
    public function desativaContingencia()
    {
        $this->enableSVCAN = false;
        $this->enableSVCRS = false;
        $this->enableEPEC = false;
        $this->tsContingencia = 0;
        $this->motivoContingencia = '';
        $filename = NFEPHP_ROOT
            . DIRECTORY_SEPARATOR
            . 'config'
            . DIRECTORY_SEPARATOR
            . $this->aConfig['cnpj']
            . '_contingencia.json';
        return Files\FilesFolders::removeFile($filename);
    }

    /**
     * imprime
     * Imprime o documento eletrônico (NFe, CCe, Inut.)
     *
     * @param  string $pathXml
     * @param  string $pathDestino
     * @param  string $printer
     * @return string
     */
    public function imprime($pathXml = '', $pathDestino = '', $printer = '')
    {
        //TODO : falta implementar esse método para isso é necessária a classe
        //PrintNFe
        return "$pathXml $pathDestino $printer";
    }

    /**
     * enviaMail
     * Envia a NFe por email aos destinatários
     * Caso $aMails esteja vazio serão obtidos os email do destinatário  e
     * os emails que estiverem registrados nos campos obsCont do xml
     *
     * @param  string  $pathXml
     * @param  array   $aMails
     * @param  string  $templateFile path completo ao arquivo template html do corpo do email
     * @param  boolean $comPdf       se true o sistema irá renderizar o DANFE e anexa-lo a mensagem
     * @param  string  $pathPdf
     * @return boolean
     * @throws Exception\RuntimeException
     */
    public function enviaMail($pathXml = '', $aMails = array(), $templateFile = '', $comPdf = false, $pathPdf = '')
    {
        $mail = new Mail($this->aMailConf);
        // Se não for informado o caminho do PDF, monta um através do XML
        /*
        if ($comPdf && $this->modelo == '55' && $pathPdf == '') {
            $docxml = Files\FilesFolders::readFile($pathXml);
            $danfe = new Extras\Danfe($docxml, 'P', 'A4', $this->aDocFormat['pathLogoFile'], 'I', '');
            $id = $danfe->montaDANFE();
            $pathPdf = $this->aConfig['pathNFeFiles']
                . DIRECTORY_SEPARATOR
                . $this->ambiente
                . DIRECTORY_SEPARATOR
                . 'pdf'
                . DIRECTORY_SEPARATOR
                . $id . '-danfe.pdf';
            $pdf = $danfe->printDANFE($pathPdf, 'F');
        }
         *
         */
        if ($mail->envia($pathXml, $aMails, $comPdf, $pathPdf) === false) {
            throw new Exception\RuntimeException('Email não enviado. '.$mail->error);
        }
        return true;
    }

    /**
     * addB2B
     * Adiciona tags de comunicação B2B, especialmente ANFAVEA
     *
     * @param  string $pathNFefile
     * @param  string $pathB2Bfile
     * @param  string $tagB2B
     * @return string
     * @throws Exception\InvalidArgumentException
     * @throws Exception\RuntimeException
     */
    public function addB2B($pathNFefile = '', $pathB2Bfile = '', $tagB2B = '')
    {
        if (! is_file($pathNFefile) || ! is_file($pathB2Bfile)) {
            $msg = "Algum dos arquivos não foi localizado no caminho indicado ! $pathNFefile ou $pathB2Bfile";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($tagB2B == '') {
            //padrão anfavea
            $tagB2B = 'NFeB2BFin';
        }
        $docnfe = new Dom();
        $docnfe->loadXMLFile($pathNFefile);
        $nodenfe = $docnfe->getNode('nfeProc', 0);
        if ($nodenfe == '') {
            $msg = "O arquivo indicado como NFe não está protocolado ou não é uma NFe!!";
            throw new Exception\RuntimeException($msg);
        }
        //carrega o arquivo B2B
        $docb2b = new Dom();
        $docb2b->loadXMLFile($pathNFefile);
        $nodeb2b = $docnfe->getNode($tagB2B, 0);
        if ($nodeb2b == '') {
            $msg = "O arquivo indicado como B2B não contên a tag requerida!!";
            throw new Exception\RuntimeException($msg);
        }
        //cria a NFe processada com a tag do protocolo
        $procb2b = new Dom();
        //cria a tag nfeProc
        $nfeProcB2B = $procb2b->createElement('nfeProcB2B');
        $procb2b->appendChild($nfeProcB2B);
        //inclui a tag NFe
        $node1 = $procb2b->importNode($nodenfe, true);
        $nfeProcB2B->appendChild($node1);
        //inclui a tag NFeB2BFin
        $node2 = $procb2b->importNode($nodeb2b, true);
        $nfeProcB2B->appendChild($node2);
        //salva o xml como string em uma variável
        $nfeb2bXML = $procb2b->saveXML();
        //remove as informações indesejadas
        $nfeb2bXMLString = str_replace(array("\n","\r","\s"), '', $nfeb2bXML);
        return (string) $nfeb2bXMLString;
    }

    /**
     * addProtocolo
     * Adiciona o protocolo de autorização de uso da NFe
     * NOTA: exigência da SEFAZ, a nota somente é válida com o seu respectivo protocolo
     *
     * @param  string  $pathNFefile
     * @param  string  $pathProtfile
     * @param  boolean $saveFile
     * @return string
     * @throws Exception\RuntimeException
     */
    public function addProtocolo($pathNFefile = '', $pathProtfile = '', $saveFile = false)
    {
        //carrega a NFe
        $docnfe = new Dom();

        if (file_exists($pathNFefile)) {
            //carrega o XML pelo caminho do arquivo informado
            $docnfe->loadXMLFile($pathNFefile);
        } else {
            //carrega o XML pelo conteúdo
            $docnfe->loadXMLString($pathNFefile);
        }
        $nodenfe = $docnfe->getNode('NFe', 0);
        if ($nodenfe == '') {
            $msg = "O arquivo indicado como NFe não é um xml de NFe!";
            throw new Exception\RuntimeException($msg);
        }
        if ($docnfe->getNode('Signature') == '') {
            $msg = "A NFe não está assinada!";
            throw new Exception\RuntimeException($msg);
        }
        //carrega o protocolo
        $docprot = new Dom();

        if (file_exists($pathProtfile)) {
            //carrega o XML pelo caminho do arquivo informado
            $docprot->loadXMLFile($pathProtfile);
        } else {
            //carrega o XML pelo conteúdo
            $docprot->loadXMLString($pathProtfile);
        }

        $nodeprots = $docprot->getElementsByTagName('protNFe');
        if ($nodeprots->length == 0) {
            $msg = "O arquivo indicado não contem um protocolo de autorização!";
            throw new Exception\RuntimeException($msg);
        }
        //carrega dados da NFe
        $tpAmb = $docnfe->getNodeValue('tpAmb');
        $anomes = date(
            'Ym',
            DateTime::convertSefazTimeToTimestamp($docnfe->getNodeValue('dhEmi'))
        );
        $infNFe = $docnfe->getNode("infNFe", 0);
        $versao = $infNFe->getAttribute("versao");
        $chaveId = $infNFe->getAttribute("Id");
        $chaveNFe = preg_replace('/[^0-9]/', '', $chaveId);
        $digValueNFe = $docnfe->getNodeValue('DigestValue');
        //carrega os dados do protocolo
        for ($i = 0; $i < $nodeprots->length; $i++) {
            $nodeprot = $nodeprots->item($i);
            $protver = $nodeprot->getAttribute("versao");
            $chaveProt = $nodeprot->getElementsByTagName("chNFe")->item(0)->nodeValue;
            $digValueProt = ($nodeprot->getElementsByTagName("digVal")->length)
                ? $nodeprot->getElementsByTagName("digVal")->item(0)->nodeValue
                : '';
            $infProt = $nodeprot->getElementsByTagName("infProt")->item(0);
            if ($digValueNFe == $digValueProt && $chaveNFe == $chaveProt) {
                break;
            }
        }
        if ($digValueNFe != $digValueProt) {
            $msg = "Inconsistência! O DigestValue da NFe não combina com o do digVal do protocolo indicado!";
            throw new Exception\RuntimeException($msg);
        }
        if ($chaveNFe != $chaveProt) {
            $msg = "O protocolo indicado pertence a outra NFe. Os números das chaves não combinam !";
            throw new Exception\RuntimeException($msg);
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
        if ($saveFile) {
            $filename = "{$chaveNFe}-protNFe.xml";
            $this->zGravaFile(
                'nfe',
                $tpAmb,
                $filename,
                $procXML,
                'enviadas'.DIRECTORY_SEPARATOR.'aprovadas',
                $anomes
            );
        }
        return $procXML;
    }

    /**
     * addCancelamento
     * Adiciona a tga de cancelamento a uma NFe já autorizada
     * NOTA: não é requisito da SEFAZ, mas auxilia na identificação das NFe que foram canceladas
     *
     * @param  string $pathNFefile
     * @param  string $pathCancfile
     * @param  bool   $saveFile
     * @return string
     * @throws Exception\RuntimeException
     */
    public function addCancelamento($pathNFefile = '', $pathCancfile = '', $saveFile = false)
    {
        $procXML = '';
        //carrega a NFe
        $docnfe = new Dom();
        $docnfe->loadXMLFile($pathNFefile);
        $nodenfe = $docnfe->getNode('NFe', 0);
        if ($nodenfe == '') {
            $msg = "O arquivo indicado como NFe não é um xml de NFe!";
            throw new Exception\RuntimeException($msg);
        }
        $proNFe = $docnfe->getNode('protNFe');
        if ($proNFe == '') {
            $msg = "A NFe não está protocolada ainda!!";
            throw new Exception\RuntimeException($msg);
        }
        $chaveNFe = $proNFe->getElementsByTagName('chNFe')->item(0)->nodeValue;
        //$nProtNFe = $proNFe->getElementsByTagName('nProt')->item(0)->nodeValue;
        $tpAmb = $docnfe->getNodeValue('tpAmb');
        $anomes = date(
            'Ym',
            DateTime::convertSefazTimeToTimestamp($docnfe->getNodeValue('dhEmi'))
        );
        //carrega o cancelamento
        //pode ser um evento ou resultado de uma consulta com multiplos eventos
        $doccanc = new Dom();
        $doccanc->loadXMLFile($pathCancfile);
        $retEvento = $doccanc->getElementsByTagName('retEvento')->item(0);
        $eventos = $retEvento->getElementsByTagName('infEvento');
        foreach ($eventos as $evento) {
            //evento
            $cStat = $evento->getElementsByTagName('cStat')->item(0)->nodeValue;
            $tpAmb = $evento->getElementsByTagName('tpAmb')->item(0)->nodeValue;
            $chaveEvento = $evento->getElementsByTagName('chNFe')->item(0)->nodeValue;
            $tpEvento = $evento->getElementsByTagName('tpEvento')->item(0)->nodeValue;
            //$nProtEvento = $evento->getElementsByTagName('nProt')->item(0)->nodeValue;
            //verifica se conferem os dados
            //cStat = 135 ==> evento homologado
            //cStat = 136 ==> vinculação do evento à respectiva NF-e prejudicada
            //cStat = 155 ==> Cancelamento homologado fora de prazo
            //tpEvento = 110111 ==> Cancelamento
            //chave do evento == chave da NFe
            //protocolo do evneto ==  protocolo da NFe
            if (($cStat == '135' || $cStat == '136' || $cStat == '155')
                && $tpEvento == '110111'
                && $chaveEvento == $chaveNFe
            ) {
                $proNFe->getElementsByTagName('cStat')->item(0)->nodeValue = '101';
                $proNFe->getElementsByTagName('xMotivo')->item(0)->nodeValue = 'Cancelamento de NF-e homologado';
                $procXML = $docnfe->saveXML();
                //remove as informações indesejadas
                $procXML = Strings::clearProt($procXML);
                if ($saveFile) {
                    $filename = "$chaveNFe-protNFe.xml";
                    $this->zGravaFile(
                        'nfe',
                        $tpAmb,
                        $filename,
                        $procXML,
                        'canceladas',
                        $anomes
                    );
                }
                break;
            }
        }
        return (string) $procXML;
    }

    /**
     * verificaValidade
     * Verifica a validade de uma NFe recebida
     *
     * @param  string $pathXmlFile
     * @param  array  $aRetorno
     * @return boolean
     * @throws Exception\InvalidArgumentException
     */
    public function verificaValidade($pathXmlFile = '', &$aRetorno = array())
    {
        $aRetorno = array();
        if (!file_exists($pathXmlFile)) {
            $msg = "Arquivo não localizado!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        //carrega a NFe
        $xml = Files\FilesFolders::readFile($pathXmlFile);
        $this->oCertificate->verifySignature($xml, 'infNFe');
        //obtem o chave da NFe
        $docnfe = new Dom();
        $docnfe->loadXMLFile($pathXmlFile);
        $tpAmb = $docnfe->getNodeValue('tpAmb');
        $chNFe  = $docnfe->getChave('infNFe');
        $this->sefazConsultaChave($chNFe, $tpAmb, $aRetorno);
        if ($aRetorno['cStat'] != '100' && $aRetorno['cStat'] != '150') {
            return false;
        }
        return true;
    }

    /**
     * assina
     * Assina uma NFe
     *
     * @param  string  $xml
     * @param  boolean $saveFile
     * @return string
     * @throws Exception\RuntimeException
     */
    public function assina($xml = '', $saveFile = false)
    {
        $xmlSigned = $this->assinaDoc($xml, 'nfe', 'infNFe', $saveFile);
        $dom = new Dom();
        $dom->loadXMLString($xmlSigned);
        $modelo = $dom->getValue($dom, 'mod');
        $oldmod = $this->modelo;
        $this->modelo = $modelo;
        if ($this->modelo == 65) {
            //descomentar essa linha após 03/11/2015 conforme NT 2015.002
            //ou quando for habilitada essa TAG no XML da NFCe
            //para incluir o QRCode no corpo da NFCe
            $xmlSigned = $this->zPutQRTag($dom, $saveFile);
        }
        $this->modelo = $oldmod;
        return $xmlSigned;
    }

    /**
     * zPutQRTag
     * Monta a URI para o QRCode e coloca a tag
     * no xml já assinado
     *
     * @param  Dom $dom
     * @return string
     * NOTA: O Campo QRCode está habilitado para uso a partir de
     *       01/10/2015 homologação
     *       03/11/2015 Produção
     */
    protected function zPutQRTag(Dom $dom, $saveFile)
    {
        //pega os dados necessários para a montagem da URI a partir do xml
        $nfe = $dom->getNode('NFe');
        $ide = $dom->getNode('ide');
        $dest = $dom->getNode('dest');
        $icmsTot = $dom->getNode('ICMSTot');
        $signedInfo  = $dom->getNode('SignedInfo');
        $chNFe = $dom->getChave('infNFe');
        $cUF = $dom->getValue($ide, 'cUF');
        $tpAmb = $dom->getValue($ide, 'tpAmb');
        $dhEmi = $dom->getValue($ide, 'dhEmi');
        $cDest = '';
        if (!empty($dest)) {
            //pode ser CNPJ , CPF ou idEstrageiro
            $cDest = $dom->getValue($dest, 'CNPJ');
            if ($cDest == '') {
                $cDest = $dom->getValue($dest, 'CPF');
                if ($cDest == '') {
                    $cDest = $dom->getValue($dest, 'idEstrangeiro');
                }
            }
        }
        $vNF = $dom->getValue($icmsTot, 'vNF');
        $vICMS = $dom->getValue($icmsTot, 'vICMS');
        $digVal = $dom->getValue($signedInfo, 'DigestValue');
        $token = $this->aConfig['tokenNFCe'];
        $idToken = $this->aConfig['tokenNFCeId'];
        $versao = '100';
        /*
         *Pega a URL para consulta do QRCode do estado emissor,
         *essa url está em nfe_ws3_mode65.xml, em tese essa url
         *NÃO É uma WebService, é simplismente uma página para
         *consulta do QRCode via parametros GET, percebe-se que
         *em todas as SEFAZ o endereço de consulta do QRCode se
         *difere do padrão de endereço das WS.
         *Esse é um serviço para ser utilizado pelo consumidor...
         *NOTA: Sem o endereço de consulta não é possível gerar o QR-Code!!!
        */
        //carrega serviço
        $servico = 'NfeConsultaQR';
        $siglaUF = $this->zGetSigla($cUF);
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $this->errors[] = "A consulta por QRCode não está disponível na SEFAZ $siglaUF!!!";
            return $dom->saveXML();
        }
        $url = $this->urlService;
        //usa a função zMakeQRCode para gerar a string da URI
        $qrcode = $this->zMakeQRCode(
            $chNFe,
            $url,
            $tpAmb,
            $dhEmi,
            $vNF,
            $vICMS,
            $digVal,
            $token,
            $cDest,
            $idToken,
            $versao
        );
        if ($qrcode == '') {
            return $dom->saveXML();
        }
        //inclui a TAG NFe/infNFeSupl com o qrcode
        $infNFeSupl = $dom->createElement("infNFeSupl");
        $nodeqr = $infNFeSupl->appendChild($dom->createElement('qrCode'));
        $nodeqr->appendChild($dom->createCDATASection($qrcode));
        $signature = $dom->getElementsByTagName('Signature')->item(0);
        $nfe->insertBefore($infNFeSupl, $signature);
        $dom->formatOutput = false;
        $xmlSigned = $dom->saveXML();
        //salva novamente o xml assinado e agora com o QRCode
        if ($saveFile) {
            $anomes = date(
                'Ym',
                DateTime::convertSefazTimeToTimestamp($dhEmi)
            );
            $filename = "$chNFe-nfe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $xmlSigned, 'assinadas', $anomes);
        }
        //retorna a string com o xml assinado e com o QRCode
        return $xmlSigned;
    }

    /**
     * sefazEnviaLote
     * Solicita a autorização de uso de Lote de NFe
     *
     * @param    array   $aXml
     * @param    string  $tpAmb
     * @param    string  $idLote
     * @param    array   $aRetorno
     * @param    int     $indSinc
     * @param    boolean $compactarZip
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazEnviaLote(
        $aXml,
        $tpAmb = '2',
        $idLote = '',
        &$aRetorno = array(),
        $indSinc = 0,
        $compactarZip = false,
        $salvarMensagens = true
    ) {
        $sxml = $aXml;
        if (empty($aXml)) {
            $msg = "Pelo menos uma NFe deve ser informada.";
            throw new Exception\InvalidArgumentException($msg);
        }
        if (is_array($aXml)) {
            if (count($aXml) > 1) {
                //multiplas nfes, não pode ser sincrono
                $indSinc = 0;
            }
            $sxml = implode("", $sxml);
        }
        $sxml = preg_replace("/<\?xml.*\?>/", "", $sxml);
        $siglaUF = $this->aConfig['siglaUF'];
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        if ($idLote == '') {
            $idLote = LotNumber::geraNumLote(15);
        }
        //carrega serviço
        $servico = 'NfeAutorizacao';
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "O envio de lote não está disponível na SEFAZ $siglaUF!!!";
            throw new Exception\RuntimeException($msg);
        }
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
        $retorno = $this->oSoap->send($this->urlService, $this->urlNamespace, $this->urlHeader, $body, $method);
        $this->soapDebug = $this->oSoap->soapDebug;
        //salva mensagens
        if ($salvarMensagens) {
            $lastMsg = $this->oSoap->lastMsg;
            $filename = "$idLote-enviNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
            $filename = "$idLote-retEnviNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        }

        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        //caso o envio seja recebido com sucesso mover a NFe da pasta
        //das assinadas para a pasta das enviadas
        return (string) $retorno;
    }

    /**
     * sefazConsultaRecibo
     * Consulta a situação de um Lote de NFe enviadas pelo recibo desse envio
     *
     * @param    string $recibo
     * @param    string $tpAmb
     * @param    array  $aRetorno
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazConsultaRecibo($recibo = '', $tpAmb = '2', &$aRetorno = array(), $saveMensagens = true)
    {
        if ($recibo == '') {
            $msg = "Deve ser informado um recibo.";
            throw new Exception\InvalidArgumentException($msg);
        }
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
        $retorno = $this->oSoap->send(
            $this->urlService,
            $this->urlNamespace,
            $this->urlHeader,
            $body,
            $this->urlMethod
        );
        $this->soapDebug = $this->oSoap->soapDebug;
        //salva mensagens
        if ($saveMensagens) {
            $lastMsg = $this->oSoap->lastMsg;
            $filename = "$recibo-consReciNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
            $filename = "$recibo-retConsReciNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        }
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        //podem ser retornados nenhum, um ou vários protocolos
        //caso existam protocolos protocolar as NFe e movelas-las para a
        //pasta enviadas/aprovadas/anomes
        return (string) $retorno;
    }

    /**
     * sefazConsultaChave
     * Consulta o status da NFe pela chave de 44 digitos
     *
     * @param    string $chave
     * @param    string $tpAmb
     * @param    array  $aRetorno
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazConsultaChave($chave = '', $tpAmb = '2', &$aRetorno = array(), $salvaMensagens = true)
    {
        $chNFe = preg_replace('/[^0-9]/', '', $chave);
        if (strlen($chNFe) != 44) {
            $msg = "Uma chave de 44 dígitos da NFe deve ser passada.";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        $cUF = substr($chNFe, 0, 2);
        $siglaUF = $this->zGetSigla($cUF);
        //carrega serviço
        $servico = 'NfeConsultaProtocolo';
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
        if ($salvaMensagens) {
            $filename = "$chNFe-consSitNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
            $filename = "$chNFe-retConsSitNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        }
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        return (string) $retorno;
    }

    /**
     * sefazInutiliza
     * Solicita a inutilização de uma ou uma sequencia de NFe
     * de uma determinada série
     *
     * @param    integer $nSerie
     * @param    integer $nIni
     * @param    integer $nFin
     * @param    string  $xJust
     * @param    string  $tpAmb
     * @param    array   $aRetorno
     * @return   string
     * @internal param string $modelo
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazInutiliza(
        $nSerie = 1,
        $nIni = 0,
        $nFin = 0,
        $xJust = '',
        $tpAmb = '2',
        &$aRetorno = array(),
        $salvarMensagens = true
    ) {
        $xJust = Strings::cleanString($xJust);
        $nSerie = (integer) $nSerie;
        $nIni = (integer) $nIni;
        $nFin = (integer) $nFin;
        $this->zValidParamInut($xJust, $nSerie, $nIni, $nFin);
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        //monta serviço
        $siglaUF = $this->aConfig['siglaUF'];
        //carrega serviço
        $servico = 'NfeInutilizacao';
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A inutilização não está disponível na SEFAZ $siglaUF!!!";
            throw new Exception\RuntimeException($msg);
        }
        //montagem dos dados da mensagem SOAP
        $cnpj = $this->aConfig['cnpj'];
        $sAno = (string) date('y');
        $sSerie = str_pad($nSerie, 3, '0', STR_PAD_LEFT);
        $sInicio = str_pad($nIni, 9, '0', STR_PAD_LEFT);
        $sFinal = str_pad($nFin, 9, '0', STR_PAD_LEFT);
        $idInut = "ID".$this->urlcUF.$sAno.$cnpj.$this->modelo.$sSerie.$sInicio.$sFinal;
        //limpa os caracteres indesejados da justificativa
        $xJust = Strings::cleanString($xJust);
        //montagem do corpo da mensagem
        $cons = "<inutNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<infInut Id=\"$idInut\">"
                . "<tpAmb>$tpAmb</tpAmb>"
                . "<xServ>INUTILIZAR</xServ>"
                . "<cUF>$this->urlcUF</cUF>"
                . "<ano>$sAno</ano>"
                . "<CNPJ>$cnpj</CNPJ>"
                . "<mod>$this->modelo</mod>"
                . "<serie>$nSerie</serie>"
                . "<nNFIni>$nIni</nNFIni>"
                . "<nNFFin>$nFin</nNFFin>"
                . "<xJust>$xJust</xJust>"
                . "</infInut></inutNFe>";
        //assina a lsolicitação de inutilização
        $signedMsg = $this->oCertificate->signXML($cons, 'infInut');
        $signedMsg = Strings::clearXml($signedMsg, true);
        //valida a mensagem com o xsd
        //if (! $this->zValidMessage($cons, 'nfe', 'inutNFe', $version)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$signedMsg</nfeDadosMsg>";
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
        if ($salvarMensagens) {
            $filename = "$sAno-$this->modelo-$sSerie-".$sInicio."_".$sFinal."-inutNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
            $filename = "$sAno-$this->modelo-$sSerie-".$sInicio."_".$sFinal."-retInutNFe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        }

        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        if ($aRetorno['cStat'] == '102') {
            $retorno = $this->zAddProtMsg('ProcInutNFe', 'inutNFe', $signedMsg, 'retInutNFe', $retorno);
            if ($salvarMensagens) {
                $filename = "$sAno-$this->modelo-$sSerie-".$sInicio."_".$sFinal."-procInutNFe.xml";
                $this->zGravaFile('nfe', $tpAmb, $filename, $retorno, 'inutilizadas');
            }
        }
        return (string) $retorno;
    }

    /**
     * zAddProtMsg
     *
     * @param  string $tagproc
     * @param  string $tagmsg
     * @param  string $xmlmsg
     * @param  string $tagretorno
     * @param  string $xmlretorno
     * @return string
     */
    protected function zAddProtMsg($tagproc, $tagmsg, $xmlmsg, $tagretorno, $xmlretorno)
    {
        $doc = new Dom();
        $doc->loadXMLString($xmlmsg);
        $nodedoc = $doc->getNode($tagmsg, 0);
        $procver = $nodedoc->getAttribute("versao");
        $procns = $nodedoc->getAttribute("xmlns");

        $doc1 = new Dom();
        $doc1->loadXMLString($xmlretorno);
        $nodedoc1 = $doc1->getNode($tagretorno, 0);

        $proc = new \DOMDocument('1.0', 'utf-8');
        $proc->formatOutput = false;
        $proc->preserveWhiteSpace = false;
        //cria a tag nfeProc
        $procNode = $proc->createElement($tagproc);
        $proc->appendChild($procNode);
        //estabele o atributo de versão
        $procNodeAtt1 = $procNode->appendChild($proc->createAttribute('versao'));
        $procNodeAtt1->appendChild($proc->createTextNode($procver));
        //estabelece o atributo xmlns
        $procNodeAtt2 = $procNode->appendChild($proc->createAttribute('xmlns'));
        $procNodeAtt2->appendChild($proc->createTextNode($procns));
        //inclui a tag inutNFe
        $node = $proc->importNode($nodedoc, true);
        $procNode->appendChild($node);
        //inclui a tag retInutNFe
        $node = $proc->importNode($nodedoc1, true);
        $procNode->appendChild($node);
        //salva o xml como string em uma variável
        $procXML = $proc->saveXML();
        //remove as informações indesejadas
        $procXML = Strings::clearProt($procXML);
        return $procXML;
    }

    /**
     * zValidParamInut
     *
     * @param  string $xJust
     * @param  int    $nSerie
     * @param  int    $nIni
     * @param  int    $nFin
     * @throws Exception\InvalidArgumentException
     */
    private function zValidParamInut($xJust, $nSerie, $nIni, $nFin)
    {
        $msg = '';
        //valida dos dados de entrada
        if (strlen($xJust) < 15 || strlen($xJust) > 255) {
            $msg = "A justificativa deve ter entre 15 e 255 digitos!!";
        } elseif ($nSerie < 0 || $nSerie > 999) {
            $msg = "O campo serie está errado: $nSerie!!";
        } elseif ($nIni < 1 || $nIni > 1000000000) {
            $msg = "O campo numero inicial está errado: $nIni!!";
        } elseif ($nFin < 1 || $nFin > 1000000000) {
            $msg = "O campo numero final está errado: $nFin!!";
        } elseif ($this->enableSVCRS || $this->enableSVCAN) {
            $msg = "A inutilização não pode ser feita em contingência!!";
        }
        if ($msg != '') {
            throw new Exception\InvalidArgumentException($msg);
        }
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
        $siglaUF = '',
        $tpAmb = '2',
        $cnpj = '',
        $iest = '',
        $cpf = '',
        &$aRetorno = array()
    ) {
        $cnpj = preg_replace('/[^0-9]/', '', $cnpj);
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        $iest = trim($iest);
        //se nenhum critério é satisfeito
        if ($cnpj == '' && $iest == '' && $cpf == '') {
            //erro nao foi passado parametro de filtragem
            $msg = "Na consulta de cadastro, pelo menos um desses dados deve ser"
                    . " fornecido CNPJ, CPF ou IE !!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
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
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A consulta de Cadastros não está disponível na SEFAZ $siglaUF!!!";
            throw new Exception\RuntimeException($msg);
        }
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
        $filename = "$txtFile-consCad.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
        $filename = "$txtFile-retConsCad.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        return (string) $retorno;
    }

    /**
     * sefazStatus
     * Verifica o status do serviço da SEFAZ/SVC
     * NOTA : Este serviço será removido no futuro, segundo da Receita/SEFAZ devido
     * ao excesso de mau uso !!!
     *
     * @param    string $siglaUF  sigla da unidade da Federação
     * @param    string $tpAmb    tipo de ambiente 1-produção e 2-homologação
     * @param    array  $aRetorno parametro passado por referencia contendo a resposta da consulta em um array
     * @return   mixed string XML do retorno do webservice, ou false se ocorreu algum erro
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazStatus($siglaUF = '', $tpAmb = '2', &$aRetorno = array())
    {
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        if ($siglaUF == '') {
            $siglaUF = $this->aConfig['siglaUF'];
        }
        //carrega serviço
        $servico = 'NfeStatusServico';
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "O status não está disponível na SEFAZ $siglaUF!!!";
            throw new Exception\RuntimeException($msg);
        }
        $cons = "<consStatServ xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
            . "<tpAmb>$tpAmb</tpAmb><cUF>$this->urlcUF</cUF>"
            . "<xServ>STATUS</xServ></consStatServ>";
        //valida mensagem com xsd
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
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
        $datahora = date('Ymd_His');
        $filename = $siglaUF."_"."$datahora-consStatServ.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
        $filename = $siglaUF."_"."$datahora-retConsStatServ.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        return (string) $retorno;
    }

    /**
     * sefazDistDFe
     * Serviço destinado à distribuição de informações
     * resumidas e documentos fiscais eletrônicos de interesse de um ator.
     *
     * @param    string  $fonte   sigla da fonte dos dados 'AN' e para alguns casos pode ser 'RS' e
     *                            para alguns casos pode ser 'RS'
     * @param    string  $tpAmb   tipo de ambiente
     * @param    string  $cnpj
     * @param    integer $ultNSU  ultimo numero NSU que foi consultado
     * @param    integer $numNSU  numero de NSU que se quer consultar
     * @param    array   $aRetorno array com os dados do retorno
     * @return   string contento o xml retornado pela SEFAZ
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazDistDFe(
        $fonte = 'AN',
        $tpAmb = '2',
        $cnpj = '',
        $ultNSU = 0,
        $numNSU = 0,
        &$aRetorno = array()
    ) {
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        $siglaUF = $this->aConfig['siglaUF'];
        if ($cnpj == '') {
            $cnpj = $this->aConfig['cnpj'];
        }
        //carrega serviço
        $servico = 'NfeDistribuicaoDFe';
        $this->zLoadServico(
            'nfe',
            $servico,
            $fonte,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A distribuição de documento DFe não está disponível na SEFAZ $fonte!!!";
            throw new Exception\RuntimeException($msg);
        }
        $cUF = self::getcUF($siglaUF);
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
        $tipoNSU = (int) ($numNSU != 0 ? $numNSU : $ultNSU);
        $datahora = date('Ymd_His');
        $filename = "$tipoNSU-$datahora-distDFeInt.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
        $filename = "$tipoNSU-$datahora-retDistDFeInt.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        return (string) $retorno;
    }

    /**
     * sefazCCe
     * Solicita a autorização da Carta de Correção
     *
     * @param  string $chNFe
     * @param  string $tpAmb
     * @param  string $xCorrecao
     * @param  int    $nSeqEvento
     * @param  array  $aRetorno
     * @return array
     * @throws Exception\InvalidArgumentException
     */
    public function sefazCCe($chNFe = '', $tpAmb = '2', $xCorrecao = '', $nSeqEvento = 1, &$aRetorno = array())
    {
        //limpa chave
        $chNFe = preg_replace('/[^0-9]/', '', $chNFe);
        $xCorrecao = Strings::cleanString($xCorrecao);
        $nSeqEvento = (integer) $nSeqEvento;
        if (strlen($chNFe) != 44) {
            $msg = "A chave deve ter 44 dígitos!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if (strlen($xCorrecao) < 15 || strlen($xCorrecao) > 1000) {
            $msg = "A correção deve ter entre 15 e 1000 caracteres!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($nSeqEvento < 1 || $nSeqEvento > 20) {
            $msg = "O número sequencial do evento deve ser entre 1 e 20!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        $siglaUF = $this->zGetSigla(substr($chNFe, 0, 2));
        $tpEvento = '110110';
        $xCondUso = "A Carta de Correcao e disciplinada pelo paragrafo "
                . "1o-A do art. 7o do Convenio S/N, de 15 de dezembro de 1970 "
                . "e pode ser utilizada para regularizacao de erro ocorrido "
                . "na emissao de documento fiscal, desde que o erro nao esteja "
                . "relacionado com: I - as variaveis que determinam o valor "
                . "do imposto tais como: base de calculo, aliquota, diferenca "
                . "de preco, quantidade, valor da operacao ou da prestacao; "
                . "II - a correcao de dados cadastrais que implique mudanca "
                . "do remetente ou do destinatario; "
                . "III - a data de emissao ou de saida.";
        $tagAdic = "<xCorrecao>$xCorrecao</xCorrecao><xCondUso>$xCondUso</xCondUso>";
        $retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }

    /**
     * sefazEPP
     * Solicita pedido de prorrogação do prazo de retorno de produtos de uma
     * NF-e de remessa para industrialização por encomenda com suspensão do ICMS
     * em operações interestaduais
     *
     * @param  string  $chNFe
     * @param  string  $tpAmb
     * @param  integer $nSeqEvento
     * @param  string  $nProt
     * @param  array   $itens
     * @param  array   $aRetorno
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazEPP(
        $chNFe = '',
        $tpAmb = '2',
        $nSeqEvento = 1,
        $nProt = '',
        $itens = array(),
        &$aRetorno = array()
    ) {
        $chNFe = preg_replace('/[^0-9]/', '', $chNFe);
        if (empty($itens)) {
            $msg = "Devem ser passados os itens e as quantidades da NFe que será prorrogada!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if (empty($nProt)) {
            $msg = "Deve ser passado o numero do protocolo de autorização da "
                . "NFe que terá o Pedido de prorrogação!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
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
     *
     * @param  string  $chNFe
     * @param  string  $tpAmb
     * @param  integer $nSeqEvento
     * @param  string  $nProt
     * @param  array   $aRetorno
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazECPP(
        $chNFe = '',
        $tpAmb = '2',
        $nSeqEvento = 1,
        $nProt = '',
        &$aRetorno = array()
    ) {
        $chNFe = preg_replace('/[^0-9]/', '', $chNFe);
        if (empty($chNFe)) {
            $msg = "Deve ser passada a chave da NFe referente ao Pedido de "
                . "prorrogação que será Cancelado!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if (empty($nProt)) {
            $msg = "Deve ser passado o numero do protocolo de autorização do "
                . "Pedido de prorrogação que será Cancelado!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        $siglaUF = $this->zGetSigla(substr($chNFe, 0, 2));
        $tpEvento = '111502';
        $origEvent = '111500';
        if ($nSeqEvento == 2) {
            $tpEvento = '111503';
            $origEvent = '111501';
        }
        $sSeqEvento = str_pad($nSeqEvento, 2, "0", STR_PAD_LEFT);
        $idPedidoCancelado = "ID$origEvent$chNFe$sSeqEvento";
        $tagAdic = "<idPedidoCancelado>$idPedidoCancelado</idPedidoCancelado><nProt>$nProt</nProt>";
        $retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }

    /**
     * sefazEPEC
     * Solicita autorização em contingência EPEC
     * TODO: terminar esse método
     *
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

    /**
     * sefazCancela
     * Solicita o cancelamento da NFe
     *
     * @param  string $chNFe
     * @param  string $tpAmb
     * @param  string $xJust
     * @param  string $nProt
     * @param  array  $aRetorno
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazCancela($chNFe = '', $tpAmb = '2', $xJust = '', $nProt = '', &$aRetorno = array())
    {
        $chNFe = preg_replace('/[^0-9]/', '', $chNFe);
        $nProt = preg_replace('/[^0-9]/', '', $nProt);
        $xJust = Strings::cleanString($xJust);
        //validação dos dados de entrada
        if (strlen($chNFe) != 44) {
            $msg = "Uma chave de NFe válida não foi passada como parâmetro $chNFe.";
            throw new Exception\InvalidArgumentException($msg);
        }
        if ($nProt == '') {
            $msg = "Não foi passado o numero do protocolo!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        if (strlen($xJust) < 15 || strlen($xJust) > 255) {
            $msg = "A justificativa deve ter pelo menos 15 digitos e no máximo 255!!";
            throw new Exception\InvalidArgumentException($msg);
        }
        $siglaUF = $this->zGetSigla(substr($chNFe, 0, 2));
        //estabelece o codigo do tipo de evento CANCELAMENTO
        $tpEvento = '110111';
        $nSeqEvento = 1;
        //monta mensagem
        $tagAdic = "<nProt>$nProt</nProt><xJust>$xJust</xJust>";
        $retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }

    /**
     * sefazManifesta
     * Solicita o registro da manifestação de destinatário
     *
     * @param  string $chNFe
     * @param  string $tpAmb
     * @param  string $xJust
     * @param  string $tpEvento
     * @param  array  $aRetorno
     * @return string
     * @throws Exception\InvalidArgumentException
     */
    public function sefazManifesta($chNFe = '', $tpAmb = '2', $xJust = '', $tpEvento = '', &$aRetorno = array())
    {
        $chNFe = preg_replace('/[^0-9]/', '', $chNFe);
        $tpEvento = preg_replace('/[^0-9]/', '', $tpEvento);
        $tagAdic = '';
        switch ($tpEvento) {
            case '210200':
                //210200 – Confirmação da Operação
                break;
            case '210210':
                //210210 – Ciência da Operação
                break;
            case '210220':
                //210220 – Desconhecimento da Operação
                break;
            case '210240':
                //210240 – Operação não Realizada
                if (strlen($xJust) < 15 ||  strlen($xJust) > 255) {
                    $msg = "É obrigatória uma justificativa com 15 até 255 caracteres!!";
                    throw new Exception\InvalidArgumentException($msg);
                }
                $xJust = Strings::cleanString($xJust);
                $tagAdic = "<xJust>$xJust</xJust>";
                break;
            default:
                $msg = "Esse código de tipo de evento não consta!! $tpEvento";
                throw new Exception\InvalidArgumentException($msg);
        }
        $siglaUF = 'AN';
        $nSeqEvento = '1';
        $retorno = $this->zSefazEvento($siglaUF, $chNFe, $tpAmb, $tpEvento, $nSeqEvento, $tagAdic);
        $aRetorno = $this->aLastRetEvent;
        return $retorno;
    }

    /**
     * sefazDownload
     * Solicita o download de NFe já manifestada
     *
     * @param  string $chNFe
     * @param  string $tpAmb
     * @param  string $cnpj
     * @param  array  $aRetorno
     * @return string
     * @throws Exception\RuntimeException
     */
    public function sefazDownload($chNFe = '', $tpAmb = '', $cnpj = '', &$aRetorno = array())
    {
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        if ($cnpj == '') {
            $cnpj = $this->aConfig['cnpj'];
        }
        //carrega serviço
        $servico = 'NfeDownloadNF';
        $this->zLoadServico(
            'nfe',
            $servico,
            'AN',
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "O status não está disponível na SEFAZ !!!";
            throw new Exception\RuntimeException($msg);
        }
        $cons = "<downloadNFe xmlns=\"$this->urlPortal\" versao=\"$this->urlVersion\">"
                . "<tpAmb>$tpAmb</tpAmb>"
                . "<xServ>DOWNLOAD NFE</xServ>"
                . "<CNPJ>$cnpj</CNPJ>"
                . "<chNFe>$chNFe</chNFe>"
                . "</downloadNFe>";
        //validar mensagem com xsd
        //if (! $this->validarXml($cons)) {
        //    $msg = 'Falha na validação. '.$this->error;
        //    throw new Exception\RuntimeException($msg);
        //}
        //montagem dos dados da mensagem SOAP
        $body = "<nfeDadosMsg xmlns=\"$this->urlNamespace\">$cons</nfeDadosMsg>";
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
        $filename = "$chNFe-downnfe.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg);
        $filename = "$chNFe-retDownnfe.xml";
        $this->zGravaFile('nfe', $tpAmb, $filename, $retorno);
        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        return (string) $retorno;
    }

    /**
     * sefazManutencaoCsc
     * Manutenção do Código de Segurança do Contribuinte (Antigo Token)
     *
     * @param    int    $indOp
     * @param    string $tpAmb
     * @param    string $raizCNPJ
     * @param    string $idCsc
     * @param    string $codigoCsc
     * @param    array  $aRetorno
     * @return   string
     * @throws   Exception\InvalidArgumentException
     * @throws   Exception\RuntimeException
     * @internal function zLoadServico (Common\Base\BaseTools)
     */
    public function sefazManutencaoCsc(
        $indOp = '',
        $tpAmb = '2',
        $raizCNPJ = '',
        $idCsc = '',
        $codigoCsc = '',
        $saveXml = false,
        &$aRetorno = array()
    ) {
        if ($codigoCsc == '') {
            $codigoCsc = $this->aConfig['tokenNFCe'];
        }
        if ($idCsc == '') {
            $idCsc = $this->aConfig['tokenNFCeId'];
        }
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
        if (!is_numeric($indOp)) {
            $msg = "A operação deve ser informada.";
            throw new Exception\InvalidArgumentException($msg);
        } else {
            if ($indOp == 3 && ($idCsc == '' || $codigoCsc == '')) {
                $msg = "Para Revogação de CSC, é necessário informar o Código e ID do CSC que deseja revogar.";
                throw new Exception\InvalidArgumentException($msg);
            }
        }
        if ($raizCNPJ == '') {
            $raizCNPJ = substr($this->aConfig['cnpj'], 0, -6);
        } else {
            if (strlen($raizCNPJ)!=8) {
                $msg = "raizCNPJ: Deve ser os 08 primeiros dígitos do CNPJ.";
                throw new Exception\InvalidArgumentException($msg);
            }
        }
        $siglaUF = $this->aConfig['siglaUF'];
        //carrega serviço
        $servico = 'CscNFCe';
        $this->zLoadServico(
            'nfe',
            $servico,
            $siglaUF,
            $tpAmb
        );
        if ($this->urlService == '') {
            $msg = "A manutenção do código de segurança do contribuinte de NFC-e não está"
                . " disponível na SEFAZ $siglaUF!!!";
            throw new Exception\RuntimeException($msg);
        }

        if ($indOp==3) {
            $cons = "<admCscNFCe versao=\"$this->urlVersion\" xmlns=\"$this->urlPortal\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<indOp>$indOp</indOp>"
            . "<raizCNPJ>$raizCNPJ</raizCNPJ>"
            . "<dadosCsc>"
            .   "<idCsc>$idCsc</idCsc>"
            .   "<codigoCsc>$codigoCsc</codigoCsc>"
            . "</dadosCsc>"
            . "</admCscNFCe>";
        } else {
            $cons = "<admCscNFCe versao=\"$this->urlVersion\" xmlns=\"$this->urlPortal\">"
            . "<tpAmb>$tpAmb</tpAmb>"
            . "<indOp>$indOp</indOp>"
            . "<raizCNPJ>$raizCNPJ</raizCNPJ>"
            . "</admCscNFCe>";
        }

        //montagem dos dados da mensagem SOAP
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
        if ($saveXml) {
            $filename = "$raizCNPJ-$indOp-admCscNFCe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $lastMsg, 'csc');
            $filename = "$raizCNPJ-$indOp-retAdmCscNFCe.xml";
            $this->zGravaFile('nfe', $tpAmb, $filename, $retorno, 'csc');
        }

        //tratar dados de retorno
        $aRetorno = Response::readResponseSefaz($servico, $retorno);
        return (string) $retorno;
    }

    /**
     * validarXml
     * Valida qualquer xml do sistema NFe com seu xsd
     * NOTA: caso não exista um arquivo xsd apropriado retorna false
     *
     * @param  string $xml path ou conteudo do xml
     * @return boolean
     */
    public function validarXml($xml = '')
    {
        $aResp = array();
        $schem = IdentifyNFe::identificar($xml, $aResp);
        if ($schem == '') {
            return true;
        }
        $xsdFile = $aResp['Id'].'_v'.$aResp['versao'].'.xsd';
        $xsdPath = NFEPHP_ROOT.DIRECTORY_SEPARATOR .
            'schemes' .
            DIRECTORY_SEPARATOR .
            $this->aConfig['schemesNFe'] .
            DIRECTORY_SEPARATOR .
            $xsdFile;
        if (! is_file($xsdPath)) {
            $this->errors[] = "O arquivo XSD $xsdFile não foi localizado.";
            return false;
        }
        if (! ValidXsd::validar($aResp['xml'], $xsdPath)) {
            $this->errors[] = ValidXsd::$errors;
            return false;
        }
        return true;
    }

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
        if ($tpAmb == '') {
            $tpAmb = $this->aConfig['tpAmb'];
        }
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

    /**
    * getTimestampCert
    * Retorna o timestamp para a data de vencimento do Certificado
     *
    * @return int
    */
    public function getTimestampCert()
    {
        return $this->oCertificate->expireTimestamp;
    }

    /**
     * getImpostosIBPT
     * Consulta o serviço do IBPT para obter os impostos ao consumidor
     * conforme Lei 12.741/2012
     *
     * @param  string $ncm
     * @param  string $exTarif
     * @param  string $siglaUF
     * @return array Array (
     *                 [Codigo] => 60063100
     *                 [UF] => SP
     *                 [EX] => 0
     *                 [Descricao] => Outs.tecidos de malha de fibras sinteticas, crus ou branqueados
     *                 [Nacional] => 13.45
     *                 [Estadual] => 18
     *                 [Importado] => 16.14
     *               )
     */
    public function getImpostosIBPT($ncm = '', $exTarif = '0', $siglaUF = '')
    {
        if ($siglaUF == '') {
            $siglaUF = $this->aConfig['siglaUF'];
        }
        $cnpj = $this->aConfig['cnpj'];
        $tokenIBPT = $this->aConfig['tokenIBPT'];
        if ($ncm == '' || $tokenIBPT == '' || $cnpj == '') {
            return array();
        }
        return $this->oSoap->getIBPTProd(
            $cnpj,
            $tokenIBPT,
            $ncm,
            $siglaUF,
            $exTarif
        );
    }

    /**
     * zMakeQRCode
     * Cria a chave do QR Code a ser usado na NFCe
     *
     * @param  string $chNFe
     * @param  string $url
     * @param  string $tpAmb
     * @param  string $dhEmi
     * @param  string $vNF
     * @param  string $vICMS
     * @param  string $digVal
     * @param  string $token
     * @param  string $cDest
     * @param  string $idToken
     * @param  string $versao
     * @return string
     */
    protected function zMakeQRCode(
        $chNFe,
        $url,
        $tpAmb,
        $dhEmi,
        $vNF,
        $vICMS,
        $digVal,
        $token = '',
        $cDest = '',
        $idToken = '000001',
        $versao = '100'
    ) {
        if ($token == '') {
            return '';
        }
        $dhHex = self::zStr2Hex($dhEmi);
        $digHex = self::zStr2Hex($digVal);

        $seq = '';
        $seq .= 'chNFe=' . $chNFe;
        $seq .= '&nVersao=' . $versao;
        $seq .= '&tpAmb=' . $tpAmb;
        if ($cDest != '') {
            $seq .= '&cDest=' . $cDest;
        }
        $seq .= '&dhEmi=' . strtolower($dhHex);
        $seq .= '&vNF=' . $vNF;
        $seq .= '&vICMS=' . $vICMS;
        $seq .= '&digVal=' . strtolower($digHex);
        $seq .= '&cIdToken=' . $idToken;
        //o hash code é calculado com o Token incluso
        $hash = sha1($seq.$token);
        $seq .= '&cHashQRCode='. strtoupper($hash);
        if (strpos($url, '?') === false) {
            $url = $url.'?';
        }
        $seq = $url.$seq;
        return $seq;
    }

    /**
     * zStr2Hex
     * Converte string para haxadecimal ASCII
     *
     * @param  string $str
     * @return string
     */
    protected static function zStr2Hex($str)
    {
        if ($str == '') {
            return '';
        }
        $hex = "";
        $iCount = 0;
        do {
            $hex .= sprintf("%02x", ord($str{$iCount}));
            $iCount++;
        } while ($iCount < strlen($str));
        return $hex;
    }

    public function getSalvarMensagensEvento()
    {
        return $this->bSalvarMensagensEvento;
    }

    /**
     * Se verdade gera os arquivos de logs do envio e resposta da requisição
     *
     * @param bool $salvarMensagensEvento
     */
    public function setSalvarMensagensEvento($salvarMensagensEvento)
    {
        $this->bSalvarMensagensEvento = $salvarMensagensEvento;
    }

    public function getLastMsg()
    {
        return $this->oSoap->lastMsg;
    }

    public static function validarXmlNfe($xml, $schema)
    {
        $aResp = array();
        $schem = IdentifyNFe::identificar($xml, $aResp);
        if ($schem == '') {
            return ["Não foi possível identificar o documento"];
        }
        $xsdFile = "{$aResp['Id']}_v{$aResp['versao']}.xsd";
        $xsdPath = implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'schemes', $schema, $xsdFile]);
        if (!is_file($xsdPath)) {
            return ["O arquivo XSD {$xsdFile} não foi localizado."];
        }
        if (!ValidXsd::validar($aResp['xml'], $xsdPath)) {
            return ValidXsd::$errors;
        }
        return [];
    }
}
