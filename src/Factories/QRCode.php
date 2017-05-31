<?php

namespace NFePHP\NFe\Factories;

/**
 * Class QRCode create a string to make a QRCode string to NFCe
 * NOTE: this class only works with model 65 NFCe only
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Factories\QRCode
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use DOMDocument;
use InvalidArgumentException;

class QRCode
{
    /**
     * putQRTag
     * Mount URI for QRCode and create XML tag in signed xml
     * @param DOMDocument $dom NFe
     * @param string $token CSC number
     * @param string $idToken CSC identification
     * @param string $sigla UF alias
     * @param string $versao version of field
     * @param string $urlqr URL for search by QRCode
     * @param string $urichave URL for search by chave
     * @return string
     * @throws InvalidArgumentException
     */
    public static function putQRTag(
        \DOMDocument $dom,
        $token,
        $idToken,
        $sigla,
        $versao,
        $urlqr = '',
        $urichave = ''
    ) {
        if (empty($token) || empty($idToken) || empty($urlqr)) {
            if ($token == '') {
                $msg = "Falta o CSC no config.json";
            } elseif ($idToken == '') {
                $msg = "Falta o CSCId no config.json";
            } elseif ($urlqr == '') {
                $msg = "Falta a URL do serviço NfeConsultaQR para a $sigla,"
                    . " no arquivo wsnfe_3.10_mod65.xml";
            }
            throw new InvalidArgumentException($msg);
        }
        $nfe = $dom->getElementsByTagName('NFe')->item(0);
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $ide = $dom->getElementsByTagName('ide')->item(0);
        $dest = $dom->getElementsByTagName('dest')->item(0);
        $icmsTot = $dom->getElementsByTagName('ICMSTot')->item(0);
        $signedInfo = $dom->getElementsByTagName('SignedInfo')->item(0);
        $chNFe = preg_replace('/[^0-9]/', '', $infNFe->getAttribute("Id"));
        $cUF = $ide->getElementsByTagName('cUF')->item(0)->nodeValue;
        $tpAmb = $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $cDest = '';
        if (!empty($dest)) {
            $cDest = $dest->getElementsByTagName('CNPJ')->item(0)->nodeValue;
            if (empty($cDest)) {
                $cDest = $dest->getElementsByTagName('CPF')->item(0)->nodeValue;
                if (empty($cDest)) {
                    $cDest = $dest->getElementsByTagName('idEstrangeiro')->item(0)->nodeValue;
                }
            }
        }
        $vNF = $icmsTot->getElementsByTagName('vNF')->item(0)->nodeValue;
        $vICMS = $icmsTot->getElementsByTagName('vICMS')->item(0)->nodeValue;
        $digVal = $signedInfo->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        $qrcode = self::get(
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
        $infNFeSupl = $dom->createElement("infNFeSupl");
        $nodeqr = $infNFeSupl->appendChild($dom->createElement('qrCode'));
        $nodeqr->appendChild($dom->createCDATASection($qrcode));
        if (!empty($urichave)) {
            $infNFeSupl->appendChild(
                $dom->createElement('urlChave', $std->$sigla)
            );
        }
        $signature = $dom->getElementsByTagName('Signature')->item(0);
        $nfe->insertBefore($infNFeSupl, $signature);
        $dom->formatOutput = false;
        return $dom->saveXML();
    }
    
    /**
     * Return a QRCode string to be used in NFCe
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
    public static function get(
        $chNFe,
        $url,
        $tpAmb,
        $dhEmi,
        $vNF,
        $vICMS,
        $digVal,
        $token,
        $cDest = '',
        $idToken = '000001',
        $versao = '100'
    ) {
        $dhHex = self::str2Hex($dhEmi);
        $digHex = self::str2Hex($digVal);
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
        $hash = sha1($seq.$token);
        $seq .= '&cHashQRCode='. strtoupper($hash);
        if (strpos($url, '?') === false) {
            $url = $url.'?';
        }
        return $url.$seq;
    }
    
    /**
     * Convert string to hexadecimal ASCII equivalent
     * @param  string $str
     * @return string
     */
    protected static function str2Hex($str)
    {
        $hex = "";
        $iCount = 0;
        $tot = strlen($str);
        do {
            $hex .= sprintf("%02x", ord($str{$iCount}));
            $iCount++;
        } while ($iCount < $tot);
        return $hex;
    }
}
