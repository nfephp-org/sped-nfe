<?php

/**
 * Class for identification and convertion of eletronic documents in xml
 * for documents used in sped-nfe, sped-esocial, sped-cte, sped-mdfe, etc.
 *
 * @category  NFePHP
 * @package   NFePHP\Common\Standardize
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe\Common;

use NFePHP\Common\Validator;
use NFePHP\NFe\Exception\DocumentsException;
use stdClass;

class Standardize
{
    private $xml = '';
    private string $node = '';
    private string $json = '';
    public string $key = '';
    private object $sxml;
    public array $rootTagList = [
        'distDFeInt',
        'resNFe',
        'resEvento',
        'envEvento',
        'ConsCad',
        'consSitNFe',
        'consReciNFe',
        'downloadNFe',
        'enviNFe',
        'inutNFe',
        'admCscNFCe',
        'consStatServ',
        'retDistDFeInt',
        'retEnvEvento',
        'retConsCad',
        'retConsSitNFe',
        'retConsReciNFe',
        'retDownloadNFe',
        'retEnviNFe',
        'retInutNFe',
        'retAdmCscNFCe',
        'retConsStatServ',
        'procInutNFe',
        'procEventoNFe',
        'procNFe',
        'nfeProc',
        'NFe'
    ];

    /**
     * Constructor
     */
    public function __construct(?string $xml = null)
    {
        if (!empty($xml)) {
            $this->xml = $xml;
        }
    }

    /**
     * Identify node and extract from XML for convertion type
     * @param string|null $xml
     * @return string
     * @throws DocumentsException
     */
    public function whichIs(?string $xml = null): string
    {
        if (empty($xml) && empty($this->xml)) {
            throw new DocumentsException("O XML está vazio.");
        }
        if (!empty($xml)) {
            $this->xml = $xml;
        }
        if (!Validator::isXML($this->xml)) {
            //invalid document is not a XML
            throw DocumentsException::wrongDocument(6);
        }
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($this->xml);
        foreach ($this->rootTagList as $key) {
            $node = !empty($dom->getElementsByTagName($key)->item(0))
                ? $dom->getElementsByTagName($key)->item(0)
                : '';
            if (!empty($node)) {
                $this->node = $dom->saveXML($node);
                return $key;
            }
        }
        $result = $dom->getElementsByTagName('nfeResultMsg')->item(0);
        if (!empty($result)) {
            $cont = $result->textContent;
            if (empty($cont)) {
                throw new DocumentsException('O retorno da SEFAZ veio em BRANCO, '
                    . 'ou seja devido a um erro ou instabilidade na própria SEFAZ.');
            }
        }
        //documento does not belong to the SPED-NFe project
        throw DocumentsException::wrongDocument(7);
    }

    /**
     * Returns extract node from XML
     */
    public function __toString(): string
    {
        return $this->node;
    }

    /**
     * Returns stdClass converted from xml
     * @param string|null $xml
     * @return stdClass
     * @throws DocumentsException
     */
    public function toStd(?string $xml = null): stdClass
    {
        if (empty($xml) && empty($this->xml)) {
            throw new DocumentsException("O XML está vazio.");
        }
        if (!empty($xml)) {
            $this->xml = $xml;
        }
        $this->key = $this->whichIs();
        $this->sxml = simplexml_load_string($this->node);
        $this->json = str_replace(
            '@attributes',
            'attributes',
            json_encode($this->sxml, JSON_PRETTY_PRINT)
        );
        $std = json_decode($this->json);
        if (isset($std->infNFeSupl)) {
            $resp = $this->getQRCode();
            $std->infNFeSupl->qrCode = $resp['qrCode'];
            $std->infNFeSupl->urlChave = $resp['urlChave'];
            $this->json = json_encode($std);
        }
        if (!is_object($std)) {
            //não é um objeto entao algum erro ocorreu
            throw new DocumentsException("Falhou a converção para stdClass. Documento: $xml");
        }
        return $std;
    }

    /**
     * Returns the SimpleXml Object
     * @param string|null $xml
     * @return object
     * @throws DocumentsException
     */
    public function simpleXml(?string $xml = null): object
    {
        $this->checkXml($xml);
        return $this->sxml;
    }

    /**
     * Returns JSON string form XML
     * @param string|null $xml
     * @return string
     * @throws DocumentsException
     */
    public function toJson(?string $xml = null): string
    {
        $this->checkXml($xml);
        return $this->json;
    }

    /**
     * Returns array from XML
     * @param string|null $xml
     * @return array
     * @throws DocumentsException
     */
    public function toArray(?string $xml = null): array
    {
        $this->checkXml($xml);
        return json_decode($this->json, true);
    }

    /**
     * Return QRCODE and urlChave from XML
     * @return array
     * @throws DocumentsException
     */
    private function getQRCode(): array
    {
        if (empty($this->node)) {
            throw new DocumentsException("O XML está vazio.");
        }
        $resp = [
            'qrCode' => '',
            'urlChave' => ''
        ];
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($this->node);
        $node = $dom->getElementsByTagName('infNFeSupl')->item(0);
        if (!empty($node)) {
            $resp = [
                'qrCode' => $node->getElementsByTagName('qrCode')->item(0)->nodeValue,
                'urlChave' => $node->getElementsByTagName('urlChave')->item(0)->nodeValue
            ];
        }
        return $resp;
    }

    /**
     * Check and load XML
     * @param string|null $xml
     * @return void
     * @throws DocumentsException
     */
    private function checkXml(?string $xml = null)
    {
        if (empty($xml) && empty($this->xml)) {
            throw new DocumentsException("O XML está vazio.");
        }
        if (!empty($xml)) {
            $this->xml = $xml;
        }
        $this->toStd();
    }
}
