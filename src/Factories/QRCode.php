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
     * @throws DocumentsException
     */
    public static function putQRTag(
        \DOMDocument $dom,
        string $token,
        string $idToken,
        string $versao,
        string $urlqr,
        string $urichave = ''
    ): string {
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
        $icmsTot = $dom->getElementsByTagName('ICMSTot')->item(0);
        $signedInfo = $dom->getElementsByTagName('SignedInfo')->item(0);
        $chNFe = substr($infNFe->getAttribute("Id"), 3, 44);
        $tpAmb = $ide->getElementsByTagName('tpAmb')->item(0)->nodeValue;
        $dhEmi = $ide->getElementsByTagName('dhEmi')->item(0)->nodeValue;
        $tpEmis = (int) $ide->getElementsByTagName('tpEmis')->item(0)->nodeValue;
        $vNF = $icmsTot->getElementsByTagName('vNF')->item(0)->nodeValue;
        $vICMS = $icmsTot->getElementsByTagName('vICMS')->item(0)->nodeValue;
        $digVal = $signedInfo->getElementsByTagName('DigestValue')->item(0)->nodeValue;
        [$cDest, $tpDest] = self::getDestInfo($dom);
        $qrMethod = "get$versao";
        if ($versao == 200 || $versao == 100) {
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
        } else {
            $assinatura = $dom->getElementsByTagName('SignatureValue')->item(0)->nodeValue;
            $qrcode = self::get300(
                $chNFe,
                $urlqr,
                $tpAmb,
                $dhEmi,
                $vNF,
                $tpEmis,
                $tpDest,
                $cDest,
                $assinatura
            );
        }
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
     * Extrai informações do tipo e documento do destinatário de um XML de NF-e.
     *
     * @param \DOMDocument $dom Documento DOM XML da NF-e
     * @return array<string, string> Um array com dois elementos, sendo o primeito o tipo do destinatario (1, 2, 3)
     * e o segundo o valor do documento (CPF, CNPJ, IdEstrangeiro). Caso não seja possível identificar, 
     * é retornado vazio nos dois valores
     */
    private static function getDestInfo(\DOMDocument $dom): array
    {
        $dest = $dom->getElementsByTagName('dest')->item(0);
        
        if (empty($dest)) {
            return ['', '']; // Caso não tenha informação do destinatario, retorna vazio
        }

        $documentNode = $dest->getElementsByTagName('CNPJ')->item(0);
        if ($documentNode !== null && !empty($documentNode->nodeValue)) {
            return ['1', (string) $documentNode->nodeValue];
        }

        $documentNode = $dest->getElementsByTagName('CPF')->item(0);
        if ($documentNode !== null && !empty($documentNode->nodeValue)) {
            return ['2', (string) $documentNode->nodeValue];
        }

        $documentNode = $dest->getElementsByTagName('idEstrangeiro')->item(0);
        if ($documentNode !== null && !empty($documentNode->nodeValue)) {
            return ['3', (string) $documentNode->nodeValue];
        }

        // Como default, retorna vazio também
        return ['', ''];
    }

    /**
     * Return a QRCode version 2 string to be used in NFCe layout 4.00
     */
    protected static function get200(
        string $chNFe,
        string $url,
        string $tpAmb,
        string $dhEmi,
        string $vNF,
        string $vICMS,
        string $digVal,
        string $token,
        string $idToken,
        int $versao,
        int $tpEmis,
        string $cDest
    ): string {
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
        $valor = number_format((float)$vNF, 2, '.', '');
        $digHex = self::str2Hex($digVal);
        $seq = "$chNFe|$ver|$tpAmb|$dia|$valor|$digHex|$cscId";
        $hash = strtoupper(sha1($seq . $csc));
        return "$url$seq|$hash";
    }

    /**
     * Return a QRCode version 3 string to be used in NFCe NT 2025.001
     * 
     * @param string $chNFe
     * @param string $url
     * @param string $tpAmb
     * @param string $dhEmi
     * @param string $vNF
     * @param int $tpEmis
     * @param int $tpDest
     * @param string $cDest
     * @param string $assinatura
     * @return string
     * @throws \Exception
     */
    protected static function get300(
        string $chNFe,
        string $url,
        string $tpAmb,
        string $dhEmi,
        string $vNF,
        int $tpEmis,
        int $tpDest,
        string $cDest,
        string $assinatura
    ): string {
        /*
        Para NFC-e emitida “on-line”:
            https://endereco-consulta-QRCode?p=<chave_acesso>|<versao_qrcode>|<tpAmb>
        Para NFC-e emitida em contingência “off-line”:
            https://endereco-consultaQRCode?p=
                <chave_acesso>|
                <versao_qrcode>|
                <tpAmb>|
                <dia_data_emissao>|
                <vNF>|
                <tpDest>|
                <cDest>|
                <assinatura>
        */
        if (strpos($url, '?p=') === false) {
            $url = $url . '?p=';
        }
        if ($tpEmis != 9) {
            //emissão on-line
            return $url . "$chNFe|3|$tpAmb";
        }
        //emissão off-line
        $dt = new \DateTime($dhEmi);
        $dia = $dt->format('d');
        $valor = number_format((float)$vNF, 2, '.', '');
        return $url . "$chNFe|3|$tpAmb|$dia|$valor|$tpDest|$cDest|$assinatura";
    }

    /**
     * Convert string to hexadecimal ASCII equivalent
     */
    protected static function str2Hex(string $str): string
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
