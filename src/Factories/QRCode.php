<?php

/**
 * Class QRCode create a string to make a QRCode string to NFCe
 * NOTE: this class only works with model 65 NFCe only
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Factories\QRCode
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe\Factories;

use DOMDocument;
use NFePHP\NFe\Exception\DocumentsException;

class QRCode
{
    /**
     * putQRTag
     * Mount URI for QRCode and create three XML tags in signed xml
     * NOTE: included Manual_de_Especificações_Técnicas_do_DANFE_NFC-e_QR_Code
     *       versão 5.0 since fevereiro de 2018
     * @param DOMDocument $dom NFe
     * @param string $token CSC number
     * @param string $idToken CSC identification
     * @param string $versao version of field
     * @param string $urlqr URL for search by QRCode
     * @param string $urichave URL for search by chave layout 4.00 only
     * @return string
     * @throws DocumentsException
     */
    public static function putQRTag(
        \DOMDocument $dom,
        $token,
        $idToken,
        $versao,
        $urlqr,
        $urichave = ''
    ) {
        $token = trim($token);
        $idToken = trim($idToken);
        $versao = trim($versao);
        $urlqr = trim($urlqr);
        $urichave = trim($urichave);
        if (empty($token)) {
            throw DocumentsException::wrongDocument(9); //Falta o CSC no config.json
        }
        if (empty($idToken)) {
            throw DocumentsException::wrongDocument(10); //Falta o CSCId no config.json
        }
        if (empty($urlqr)) {
            throw DocumentsException::wrongDocument(11); //Falta a URL do serviço NfeConsultaQR
        }
        if (empty($versao)) {
            $versao = '200';
        }
        $nfe = $dom->getElementsByTagName('NFe')->item(0);
        $infNFe = $dom->getElementsByTagName('infNFe')->item(0);
        $layoutver = $infNFe->getAttribute('versao');
        $ide = $dom->getElementsByTagName('ide')->item(0);
        $dest = $dom->getElementsByTagName('dest')->item(0);
        $icmsTot = $dom->getElementsByTagName('ICMSTot')->item(0);
        $signedInfo = $dom->getElementsByTagName('SignedInfo')->item(0);
        $chNFe = preg_replace('/[^0-9]/', '', $infNFe->getAttribute("Id"));
        $tpAmb = $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $tpEmis = $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $cDest = '';
        if (!empty($dest)) {
            $cDest = !empty($dest->getElementsByTagName('CNPJ')->item(0)->nodeValue)
                ? $dest->getElementsByTagName('CNPJ')->item(0)->nodeValue
                : '';
            if (empty($cDest)) {
                $cDest = !empty($dest->getElementsByTagName('CPF')->item(0)->nodeValue)
                    ? $dest->getElementsByTagName('CPF')->item(0)->nodeValue
                    : '';
                if (empty($cDest)) {
                    $cDest = $dest->getElementsByTagName('idEstrangeiro')->item(0)->nodeValue;
                }
            }
        }
        $vNF = $icmsTot->getElementsByTagName('vNF')->item(0)->nodeValue;
        $vICMS = $icmsTot->getElementsByTagName('vICMS')->item(0)->nodeValue;
        $digVal = $signedInfo->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        $qrMethod = "get$versao";
        $qrcode = self::$qrMethod(
            $chNFe,
            $urlqr,
            $tpAmb,
            $dhEmi,
            $vNF,
            $vICMS,
            $digVal,
            $token,
            $idToken,
            $versao,
            $tpEmis,
            $cDest
        );
        $infNFeSupl = $dom->createElement("infNFeSupl");
        $infNFeSupl->appendChild($dom->createElement('qrCode', $qrcode));
        //$nodeqr = $infNFeSupl->appendChild($dom->createElement('qrCode'));
        //$nodeqr->appendChild($dom->createCDATASection($qrcode));
        $infNFeSupl->appendChild($dom->createElement('urlChave', $urichave));
        $signature = $dom->getElementsByTagName('Signature')->item(0);
        $nfe->insertBefore($infNFeSupl, $signature);
        $dom->formatOutput = false;
        return $dom->saveXML();
    }

    /**
     * Return a QRCode version 2 string to be used in NFCe layout 4.00
     * @param  string $chNFe
     * @param  string $url
     * @param  string $tpAmb
     * @param  string $dhEmi
     * @param  string $vNF
     * @param  string $vICMS
     * @param  string $digVal
     * @param  string $token
     * @param  string $idToken
     * @param  string $versao
     * @param  int    $tpEmis
     * @param  string $cDest
     * @return string
     */
    protected static function get200(
        $chNFe,
        $url,
        $tpAmb,
        $dhEmi,
        $vNF,
        $vICMS,
        $digVal,
        $token,
        $idToken,
        $versao,
        $tpEmis,
        $cDest
    ) {
        $ver = $versao / 100;
        $cscId = (int) $idToken;
        $csc = $token;
        if (strpos($url, '?p=') === false) {
            $url = $url . '?p=';
        }
        if ($tpEmis != 9) {
            //emissão on-line
            $seq = "$chNFe|$ver|$tpAmb|$cscId";
            $hash = strtoupper(sha1($seq . $csc));
            return "$url$seq|$hash";
        }
        //emissão off-line
        $dt = new \DateTime($dhEmi);
        $dia = $dt->format('d');
        $valor = number_format($vNF, 2, '.', '');
        $digHex = self::str2Hex($digVal);
        $seq = "$chNFe|$ver|$tpAmb|$dia|$valor|$digHex|$cscId";
        $hash = strtoupper(sha1($seq . $csc));
        return "$url$seq|$hash";
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
            $hex .= sprintf("%02x", ord($str[$iCount]));
            $iCount++;
        } while ($iCount < $tot);
        return $hex;
    }
}
