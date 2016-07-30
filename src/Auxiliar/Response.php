<?php

namespace NFePHP\NFe\Auxiliar;

/**
 * Classe para extrair os dados retornados das consultas e envios a SEFAZ
 *
 * @category  Library
 * @package   NFePHP\NFe\Auxiliar\Response
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\Common\Dom\Dom;

class Response
{
    /**
     * readRespoenseSefaz
     * Trata o retorno da SEFAZ devolvendo o resultado em um array
     *
     * @param  string $method
     * @param  string $xmlResp
     * @return array
     */
    public static function readResponseSefaz($method, $xmlResp)
    {
        $dom = new Dom('1.0', 'utf-8');
        $dom->loadXMLString($xmlResp);
        if ($reason = self::checkForFault($dom) != '') {
            return array('Fault' => $reason);
        }
        //para cada $method tem um formato de retorno especifico
        switch ($method) {
            case 'NfeAutorizacao':
                return self::zReadAutorizacaoLote($dom);
                break;
            case 'NfeRetAutorizacao':
                return self::zReadRetAutorizacaoLote($dom);
                break;
            case 'NfeConsultaCadastro':
                return self::zReadConsultaCadastro2($dom);
                break;
            case 'NfeConsultaProtocolo':
                return self::zReadConsultaNF2($dom);
                break;
            case 'NfeInutilizacao':
                return self::zReadInutilizacaoNF2($dom);
                break;
            case 'NfeStatusServico':
                //NOTA: irá ser desativado
                return self::zReadStatusServico($dom);
                break;
            case 'RecepcaoEPEC':
            case 'RecepcaoEvento':
                return self::zReadRecepcaoEvento($dom);
                break;
            case 'NfeDistribuicaoDFe':
                return self::zReadDistDFeInteresse($dom);
                break;
            case 'NfeDownloadNF':
                return self::zReadDownloadNF($dom);
                break;
            case 'CscNFCe':
                return self::zReadCscNFCe($dom);
                break;
        }
        return array();
    }
    
    /**
     * checkForFault
     * Verifica se a mensagem de retorno é uma FAULT
     * Normalmente essas falhas ocorrem devido a falhas internas
     * nos servidores da SEFAZ
     *
     * @param  NFePHP\Common\Dom\Dom $dom
     * @return string
     */
    protected static function checkForFault($dom)
    {
        $fault = $dom->getElementsByTagName('Fault')->item(0);
        $reason = '';
        if (isset($fault)) {
            $reason = $fault->getElementsByTagName('Text')->item(0)->nodeValue;
        }
        return $reason;
    }
    
    /**
     * zReadDownloadNF
     *
     * @param  DOMDocument $dom
     * @param  boolean     $parametro
     * @return array
     */
    protected static function zReadDownloadNF($dom)
    {
        //retorno da funçao
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'verAplic' => '',
            'tpAmb' => '',
            'cStat' => '',
            'xMotivo' => '',
            'dhResp' => '',
            'aRetNFe' => array()
        );
        $tag = $dom->getNode('retDownloadNFe');
        $aRetNFe = array();
        if (! isset($tag)) {
            return $aResposta;
        }
        $retNFe = $dom->getNode('retNFe');
        if (! empty($retNFe)) {
            $aRetNFe['cStat'] = $dom->getValue($retNFe, 'cStat');
            $aRetNFe['xMotivo'] = $dom->getValue($retNFe, 'xMotivo');
            $aRetNFe['chNFe'] = $dom->getValue($retNFe, 'chNFe');
            $nfeProc = $retNFe->getElementsByTagName('nfeProc')->item(0);
            if (! empty($nfeProc)) {
                $aRetNFe['nfeProc'] = $dom->saveXML($nfeProc);
            }
        }
        $procNFeZip = $dom->getValue($tag, 'procNFeZip');
        if (! empty($procNFeZip)) {
            $aRetNFe['procZip'] = gzdecode(base64_decode($procNFeZip));
        }
        $nfeZip = $dom->getValue($tag, 'NFeZip');
        if (! empty($nfeZip)) {
            $aRetNFe['nfeZip'] = gzdecode(base64_decode($nfeZip));
        }
        $protZip = $dom->getValue($tag, 'protNFeZip');
        if (! empty($protZip)) {
            $aRetNFe['protZip'] = gzdecode(base64_decode($protZip));
        }
        $aResposta['bStat'] = true;
        $aResposta['versao'] = $tag->getAttribute('versao');
        $aResposta['tpAmb'] = $dom->getValue($tag, 'tpAmb');
        $aResposta['verAplic'] = $dom->getValue($tag, 'verAplic');
        $aResposta['cStat'] = $dom->getValue($tag, 'cStat');
        $aResposta['xMotivo'] = $dom->getValue($tag, 'xMotivo');
        $aResposta['dhResp'] = $dom->getValue($tag, 'dhResp');
        $aResposta['aRetNFe'] = $aRetNFe;
        return $aResposta;
    }
    
    /**
     * zReadCscNFCe
     *
     * @param  DOMDocument $dom
     * @param  boolean     $parametro
     * @return array
     */
    protected static function zReadCscNFCe($dom)
    {
        //retorno da funçao
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'tpAmb' => '',
            'indOp' => '',
            'cStat' => '',
            'xMotivo' => '',
            'aRetNFe' => array()
        );
        $tag = $dom->getNode('cscNFCeResult');
        $aRetCSC = array();
        if (! isset($tag)) {
            return $aResposta;
        }
        $retAdmCscNFCe = $dom->getNode('retAdmCscNFCe');
        if (! empty($retAdmCscNFCe)) {
            $aResposta['versao'] = $retAdmCscNFCe->getAttribute('versao');
        }
        $dadosCsc = $dom->getNode('dadosCsc');
        if (! empty($dadosCsc)) {
            $aResposta['idCsc'] = $dom->getValue($dadosCsc, 'idCsc');
            $aResposta['codigoCsc'] = $dom->getValue($dadosCsc, 'codigoCsc');
        }
        $aResposta['bStat'] = true;
        $aResposta['tpAmb'] = $dom->getValue($tag, 'tpAmb');
        $aResposta['indOp'] = $dom->getValue($tag, 'indOp');
        $aResposta['cStat'] = $dom->getValue($tag, 'cStat');
        $aResposta['xMotivo'] = $dom->getValue($tag, 'xMotivo');
        $aResposta['aRetCSC'] = $aRetCSC;
        return $aResposta;
    }
    
    /**
     * zReadAutorizacaoLote
     *
     * @param  DOMDocument $dom
     * @return array
     */
    protected static function zReadAutorizacaoLote($dom)
    {
        //retorno da funçao
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'tpAmb' => '',
            'cStat' => '',
            'verAplic' => '',
            'xMotivo' => '',
            'dhRecbto' => '',
            'tMed' => '',
            'cUF' => '',
            'nRec' => '',
            'prot' => array()
        );
        $tag = $dom->getNode('retEnviNFe');
        if (empty($tag)) {
            return $aResposta;
        }
        $aProt[] = self::zGetProt($dom, $tag);
        $aResposta = array(
            'bStat' => true,
            'versao' => $tag->getAttribute('versao'),
            'tpAmb' => $dom->getValue($tag, 'tpAmb'),
            'verAplic' => $dom->getValue($tag, 'verAplic'),
            'cStat' => $dom->getValue($tag, 'cStat'),
            'xMotivo' => $dom->getValue($tag, 'xMotivo'),
            'cUF' => $dom->getValue($tag, 'cUF'),
            'dhRecbto' => $dom->getValue($tag, 'dhRecbto'),
            'tMed' => $dom->getValue($tag, 'tMed'),
            'nRec' => $dom->getValue($tag, 'nRec'),
            'prot' => $aProt
        );
        return $aResposta;
    }
    
    /**
     * zReadRetAutorizacaoLote
     *
     * @param  DOMDocument $dom
     * @return array
     */
    protected static function zReadRetAutorizacaoLote($dom)
    {
        //retorno da funçao
        $aResposta = array(
            'bStat'=>false,
            'versao' => '',
            'tpAmb' => '',
            'cStat' => '',
            'verAplic' => '',
            'xMotivo' => '',
            'dhRecbto' => '',
            'cUF' => '',
            'nRec' => '',
            'aProt' => array()
        );
        $tag = $dom->getNode('retConsReciNFe');
        if (empty($tag)) {
            return $aResposta;
        }
        $aProt = array();
        $tagProt = $tag->getElementsByTagName('protNFe');
        foreach ($tagProt as $protocol) {
            $aProt[] = self::zGetProt($dom, $protocol);
        }
        $aResposta = array(
            'bStat'=>true,
            'versao' => $tag->getAttribute('versao'),
            'tpAmb' => $dom->getValue($tag, 'tpAmb'),
            'cStat' => $dom->getValue($tag, 'cStat'),
            'verAplic' => $dom->getValue($tag, 'verAplic'),
            'xMotivo' => $dom->getValue($tag, 'xMotivo'),
            'dhRecbto' => $dom->getValue($tag, 'dhRecbto'),
            'cUF' => $dom->getValue($tag, 'cUF'),
            'nRec' => $dom->getValue($tag, 'nRec'),
            'aProt' => $aProt
        );
        return $aResposta;
    }
    
    /**
     * zReadConsultaCadastro2
     *
     * @param  DOMDocument $dom
     * @return array
     */
    protected static function zReadConsultaCadastro2($dom)
    {
        $aResposta = array(
            'bStat' => false,
            'version' => '',
            'cStat' => '',
            'verAplic' => '',
            'xMotivo' => '',
            'UF' => '',
            'IE' => '',
            'CNPJ' => '',
            'CPF' => '',
            'dhCons' => '',
            'cUF' => '',
            'aCad' => array()
        );
        $tag = $dom->getNode('retConsCad');
        if (empty($tag)) {
            return $aResposta;
        }
        $infCons = $dom->getNode('infCons');
        $aResposta = array(
            'bStat' => true,
            'version' => $tag->getAttribute('versao'),
            'cStat' => $dom->getValue($infCons, 'cStat'),
            'verAplic' => $dom->getValue($infCons, 'verAplic'),
            'xMotivo' => $dom->getValue($infCons, 'xMotivo'),
            'UF' => $dom->getValue($infCons, 'UF'),
            'IE' => $dom->getValue($infCons, 'IE'),
            'CNPJ' => $dom->getValue($infCons, 'CNPJ'),
            'CPF' => $dom->getValue($infCons, 'CPF'),
            'dhCons' => $dom->getValue($infCons, 'dhCons'),
            'cUF' => $dom->getValue($infCons, 'cUF'),
            'aCad' => array()
        );
        $aCad = array();
        $infCad = $tag->getElementsByTagName('infCad');
        if (! isset($infCad)) {
            return $aResposta;
        }
        foreach ($infCad as $cad) {
            $ender = $cad->getElementsByTagName('ender')->item(0);
            $aCad[] = array(
                'IE' => $dom->getValue($cad, 'IE'),
                'CNPJ' => $dom->getValue($cad, 'CNPJ'),
                'UF' => $dom->getValue($cad, 'UF'),
                'cSit' => $dom->getValue($cad, 'cSit'),
                'indCredNFe' => $dom->getValue($cad, 'indCredNFe'),
                'indCredCTe' => $dom->getValue($cad, 'indCredCTe'),
                'xNome' => $dom->getValue($cad, 'xNome'),
                'xFant' => $dom->getValue($cad, 'xFant'),
                'xRegApur' => $dom->getValue($cad, 'xRegApur'),
                'CNAE' => $dom->getValue($cad, 'CNAE'),
                'dIniAtiv' => $dom->getValue($cad, 'dIniAtiv'),
                'dUltSit' => $dom->getValue($cad, 'dUltSit'),
                'xLgr' => $dom->getValue($ender, 'xLgr'),
                'nro' => $dom->getValue($ender, 'nro'),
                'xCpl' => $dom->getValue($ender, 'xCpl'),
                'xBairro' => $dom->getValue($ender, 'xBairro'),
                'cMun' => $dom->getValue($ender, 'cMun'),
                'xMun' => $dom->getValue($ender, 'xMun'),
                'CEP' => $dom->getValue($ender, 'CEP')
            );
        }
        $aResposta['aCad'] = $aCad;
        return $aResposta;
    }

    /**
     * zReadConsultaNF2
     *
     * @param  DOMDocument $dom
     * @return array
     */
    protected static function zReadConsultaNF2($dom)
    {
        //retorno da funçao
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'tpAmb' => '',
            'cStat' => '',
            'verAplic' => '',
            'xMotivo' => '',
            'dhRecbto' => '',
            'cUF' => '',
            'chNFe' => '',
            'aProt' => array(),
            'aCanc' => array(),
            'aEvent' => array()
        );
        $tag = $dom->getNode('retConsSitNFe');
        if (empty($tag)) {
            return $aResposta;
        }
        $aEvent = array();
        $procEventoNFe = $tag->getElementsByTagName('procEventoNFe');
        if (isset($procEventoNFe)) {
            foreach ($procEventoNFe as $evento) {
                $aEvent[] = self::zGetEvent($dom, $evento);
            }
        }
        $aResposta = array(
            'bStat' => true,
            'versao' => $tag->getAttribute('versao'),
            'tpAmb' => $dom->getValue($tag, 'tpAmb'),
            'cStat' => $dom->getValue($tag, 'cStat'),
            'verAplic' => $dom->getValue($tag, 'verAplic'),
            'xMotivo' => $dom->getValue($tag, 'xMotivo'),
            'dhRecbto' => $dom->getValue($tag, 'dhRecbto'),
            'cUF' => $dom->getValue($tag, 'cUF'),
            'chNFe' => $dom->getValue($tag, 'chNFe'),
            'aProt' => self::zGetProt($dom, $tag),
            'aCanc' => self::zGetCanc($dom, $tag),
            'aEvent' => $aEvent
        );
        return $aResposta;
    }
    
    /**
     * zReadInutilizacaoNF2
     *
     * @param  DOMDocument $dom
     * @return array
     */
    protected static function zReadInutilizacaoNF2($dom)
    {
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'tpAmb' => '',
            'verAplic' => '',
            'cStat' => '',
            'xMotivo' => '',
            'cUF' => '',
            'dhRecbto' => '',
            'ano' => '',
            'CNPJ' => '',
            'mod' => '',
            'serie' => '',
            'nNFIni' => '',
            'nNFFin' => '',
            'nProt' => ''
        );
        $tag = $dom->getElementsByTagName('retInutNFe')->item(0);
        if (! isset($tag)) {
            return $aResposta;
        }
        $infInut = $tag->getElementsByTagName('infInut')->item(0);
        $aResposta = array(
            'bStat' => true,
            'versao' => $tag->getAttribute('versao'),
            'tpAmb' => $dom->getValue($tag, 'tpAmb'),
            'verAplic' => $dom->getValue($tag, 'verAplic'),
            'cStat' => $dom->getValue($tag, 'cStat'),
            'xMotivo' => $dom->getValue($tag, 'xMotivo'),
            'cUF' => $dom->getValue($tag, 'cUF'),
            'dhRecbto' => $dom->getValue($tag, 'dhRecbto'),
            'ano' => $dom->getValue($infInut, 'ano'),
            'CNPJ' => $dom->getValue($infInut, 'CNPJ'),
            'mod' => $dom->getValue($infInut, 'mod'),
            'serie' => $dom->getValue($infInut, 'serie'),
            'nNFIni' => $dom->getValue($infInut, 'nNFIni'),
            'nNFFin' => $dom->getValue($infInut, 'nNFFin'),
            'nProt' => $dom->getValue($infInut, 'nProt')
        );
        return $aResposta;
    }
    
    /**
     * zReadStatusServico
     *
     * @param  DOMDocument $dom
     * @return array
     */
    protected static function zReadStatusServico($dom)
    {
        //retorno da funçao
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'tpAmb' => '',
            'verAplic' => '',
            'cStat' => '',
            'xMotivo' => '',
            'cUF' => '',
            'dhRecbto' => '',
            'tMed' => '',
            'dhRetorno' => '',
            'xObs' => ''
        );
        $tag = $dom->getElementsByTagName('retConsStatServ')->item(0);
        if (! isset($tag)) {
            return $aResposta;
        }
        $aResposta = array(
            'bStat' => true,
            'versao' => $tag->getAttribute('versao'),
            'tpAmb' => $tag->getAttribute('tpAmb'),
            'verAplic' => $dom->getValue($tag, 'verAplic'),
            'cStat' => $dom->getValue($tag, 'cStat'),
            'xMotivo' => $dom->getValue($tag, 'xMotivo'),
            'cUF' => $dom->getValue($tag, 'cUF'),
            'dhRecbto' => $dom->getValue($tag, 'dhRecbto'),
            'tMed' => $dom->getValue($tag, 'tMed'),
            'dhRetorno' => $dom->getValue($tag, 'dhRetorno'),
            'xObs' => $dom->getValue($tag, 'xObs')
        );
        return $aResposta;
    }

    /**
     * zReadRecepcaoEvento
     *
     * @param  DOMDocument $dom
     * @return array
     */
    protected static function zReadRecepcaoEvento($dom)
    {
        //retorno da funçao
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'idLote' => '',
            'tpAmb' => '',
            'verAplic' => '',
            'cOrgao' => '',
            'cStat' => '',
            'xMotivo' => '',
            'evento' => array()
        );
        $tag = $dom->getNode('retEnvEvento');
        if (empty($tag)) {
            return $aResposta;
        }
        $aResposta = array(
            'bStat' => true,
            'versao' => $tag->getAttribute('versao'),
            'idLote' => $dom->getValue($tag, 'idLote'),
            'tpAmb' => $dom->getValue($tag, 'tpAmb'),
            'verAplic' => $dom->getValue($tag, 'verAplic'),
            'cOrgao' => $dom->getValue($tag, 'cOrgao'),
            'cStat' => $dom->getValue($tag, 'cStat'),
            'xMotivo' => $dom->getValue($tag, 'xMotivo'),
            'evento' => self::zGetEvent($dom, $tag)
        );
        return $aResposta;
    }
    
    /**
     * zReadDistDFeInteresse
     *
     * @param  DOMDocument $dom
     * @param  boolean     $descompactar
     * @return array
     */
    protected static function zReadDistDFeInteresse($dom)
    {
        $aResposta = array(
            'bStat' => false,
            'versao' => '',
            'cStat' => '',
            'xMotivo' => '',
            'dhResp' => '',
            'ultNSU' => 0,
            'maxNSU' => 0,
            'aDoc' => array()
        );
        $tag = $dom->getNode('retDistDFeInt');
        if (! isset($tag)) {
            return $aResposta;
        }
        $aDocZip = array();
        $docs = $tag->getElementsByTagName('docZip');
        foreach ($docs as $doc) {
            $xml = gzdecode(base64_decode($doc->nodeValue));
            $aDocZip[] = array(
              'NSU' => $doc->getAttribute('NSU'),
              'schema' => $doc->getAttribute('schema'),
              'doc' => $xml
            );
        }
        $aResposta = array(
            'bStat' => true,
            'versao' => $tag->getAttribute('versao'),
            'cStat' => $dom->getValue($tag, 'cStat'),
            'xMotivo' => $dom->getValue($tag, 'xMotivo'),
            'dhResp' => $dom->getValue($tag, 'dhResp'),
            'ultNSU' => $dom->getValue($tag, 'ultNSU'),
            'maxNSU' => $dom->getValue($tag, 'maxNSU'),
            'aDoc' => $aDocZip
        );
        return $aResposta;
    }
    
    /**
     * zGetProt
     *
     * @param  DOMDocument $tag
     * @return array
     */
    protected static function zGetProt($dom, $tag)
    {
        $aProt = array();
        $infProt = $tag->getElementsByTagName('infProt')->item(0);
        if (isset($infProt)) {
            $aProt = array(
                'chNFe' => $dom->getValue($infProt, 'chNFe'),
                'dhRecbto' => $dom->getValue($infProt, 'dhRecbto'),
                'nProt' => $dom->getValue($infProt, 'nProt'),
                'digVal' => $dom->getValue($infProt, 'digVal'),
                'cStat' => $dom->getValue($infProt, 'cStat'),
                'xMotivo' => $dom->getValue($infProt, 'xMotivo')
            );
        }
        return $aProt;
    }
    
    /**
     * zGetEvent
     *
     * @param  DOMDocument $tag
     * @return array
     */
    protected static function zGetEvent($dom, $tag)
    {
        $aEvent = array();
        $aEv = array();
        $aRetEvento = $tag->getElementsByTagName('retEvento');
        if (isset($aRetEvento)) {
            foreach ($aRetEvento as $retEvento) {
                $aNFePend = array();
                $infEvento = $retEvento->getElementsByTagName('infEvento')->item(0);
                if (isset($infEvento)) {
                    $aChNFePend = $infEvento->getElementsByTagName('infEvento');
                    if (isset($aChNFePend)) {
                        foreach ($aChNFePend as $chNFePend) {
                            $aNFePend[] = $chNFePend->nodeValue;
                        }
                    }
                    $aEv[] = array(
                        'tpAmb' => $dom->getValue($infEvento, 'tpAmb'),
                        'verAplic' => $dom->getValue($infEvento, 'verAplic'),
                        'cOrgao' => $dom->getValue($infEvento, 'cOrgao'),
                        'cStat' => $dom->getValue($infEvento, 'cStat'),
                        'xMotivo' => $dom->getValue($infEvento, 'xMotivo'),
                        'chNFe' => $dom->getValue($infEvento, 'chNFe'),
                        'tpEvento' => $dom->getValue($infEvento, 'tpEvento'),
                        'xEvento' => $dom->getValue($infEvento, 'xEvento'),
                        'nSeqEvento' => $dom->getValue($infEvento, 'nSeqEvento'),
                        'cOrgaoAutor' => $dom->getValue($infEvento, 'cOrgaoAutor'),
                        'dhRegEvento' => $dom->getValue($infEvento, 'dhRegEvento'),
                        'CNPJDest' => $dom->getValue($infEvento, 'CNPJDest'),
                        'emailDest' =>  $dom->getValue($infEvento, 'emailDest'),
                        'nProt' => $dom->getValue($infEvento, 'nProt'),
                        'chNFePend' => $aNFePend
                    );
                }
            }
            $aEvent = $aEv;
        }
        return $aEvent;
    }
    
    /**
     * zGetCanc
     *
     * @param  DOMDocument $tag
     * @return array
     */
    protected static function zGetCanc($dom, $tag)
    {
        $aCanc = array();
        $infCanc = $tag->getElementsByTagName('infCanc')->item(0);
        if (isset($infCanc)) {
            $aCanc = array (
                'tpAmb' => $dom->getValue($infCanc, 'tpAmb'),
                'verAplic' => $dom->getValue($infCanc, 'verAplic'),
                'cStat' => $dom->getValue($infCanc, 'cStat'),
                'xMotivo' => $dom->getValue($infCanc, 'xMotivo'),
                'cUF' => $dom->getValue($infCanc, 'cUF'),
                'chNFe' => $dom->getValue($infCanc, 'chNFe'),
                'dhRecbto' => $dom->getValue($infCanc, 'dhRecbto'),
                'nProt' => $dom->getValue($infCanc, 'nProt')
            );
        }
        return $aCanc;
    }
}
