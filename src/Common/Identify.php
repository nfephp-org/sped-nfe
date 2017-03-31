<?php

namespace NFePHP\NFe\Common;

/**
 * Class for identification of eletronic documents in xml
 * used for Sped NFe comunications
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Auxiliar\Identify
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use DOMDocument;
use InvalidArgumentException;
use NFePHP\Common\Validator;

class Identify
{
    public static $schemesList = [
            'consReciNFe' => 'consReciNFe',
            'consSitNFe' => 'consSitNFe',
            'consStatServ' => 'consStatServ',
            'distDFeInt' => 'distDFeInt',
            'enviNFe' => 'enviNFe',
            'inutNFe' => 'inutNFe',
            'NFe' => 'nfe',
            'procInutNFe' => 'procInutNFe',
            'procNFe' => 'procNFe',
            'resEvento' => 'resEvento',
            'resNFe' => 'resNFe',
            'retConsReciNFe' => 'retConsReciNFe',
            'retConsSitNFe' => 'retConsSitNFe',
            'retConsStatServ' => 'retConsStatServ',
            'retDistDFeInt' => 'retDistDFeInt',
            'retEnviNFe' => 'retEnviNFe',
            'retInutNFe' => 'retInutNFe'
        ];
    
    /**
     * Search xml for specific Node
     * @param string $xml
     * @return string
     */
    protected static function search($xml)
    {
        if (!Validator::isXML($xml)) {
            throw new \InvalidArgumentException(
                'The argument is not a XML.'
            );
        }
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = false;
        $dom->loadXML($xml);
        foreach (self::$schemesList as $key => $schId) {
            $node = $dom->getElementsByTagName($key)->item(0);
            if (!empty($node)) {
                return $schId;
            }
        }
        throw new \InvalidArgumentException(
            'This xml does not belong to SPED NFe.'
        );
    }
}
