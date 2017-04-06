<?php

namespace NFePHP\NFe\Common;

/**
 * Class for identification of eletronic documents in xml
 * used for Sped NFe comunications
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Standardize
 * @copyright NFePHP Copyright (c) 2008 - 2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use DOMDocument;
use stdClass;
use InvalidArgumentException;
use NFePHP\Common\Validator;

class Standardize
{
    /**
     * @var string
     */
    public $node = '';
    
    /**
     * @var array
     */
    public $rootTagList = [
        'distDFeInt',
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
     * Search xml for specific Node
     * @param string $xml
     * @return string
     */
    public function whichIs($xml)
    {
        if (!Validator::isXML($xml)) {
            throw new \InvalidArgumentException(
                "O argumento passado não é um XML válido."
            );
        }
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        foreach ($this->rootTagList as $key) {
            $node = !empty($dom->getElementsByTagName($key)->item(0))
                ? $dom->getElementsByTagName($key)->item(0)
                : '';
            if (!empty($node)) {
                $this->node = $dom->saveXML($node);
                return $key;
            }
        }
        throw new \InvalidArgumentException(
            "Este xml não pertence ao projeto SPED-NFe."
        );
    }
    
    /**
     * Returns extract node from XML
     * @return string
     */
    public function __toString()
    {
        return $this->node;
    }
    
    /**
     * Returns stdClass converted from xml
     * @param string $xml
     * @return stdClass
     */
    public function toStd($xml = null)
    {
        if (!empty($xml)) {
            $this->whichIs($xml);
        }
        $sxml = simplexml_load_string($this->node);
        $json = str_replace('@attributes', 'attributes', json_encode($sxml));
        return json_decode($json);
    }
}
