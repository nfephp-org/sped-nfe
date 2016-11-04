<?php

namespace NFePHP\NFe\Common;

/**
 * Classe para a identificação do documento eletrônico da NFe
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Auxiliar\IdentifyNFe
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use \DOMDocument;
use NFePHP\Common\Identify\Identify as IdentifyBase;

class Identify extends IdentifyBase
{
    
    public static function identificar($xml = '', &$aResp = array())
    {
        $aList = array(
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
        );
        Identify::setListSchemesId($aList);
        $schem = Identify::identificacao($xml, $aResp);
        $dom = $aResp['dom'];
        $node = $dom->getElementsByTagName($aResp['tag'])->item(0);
        if ($schem == 'nfe') {
            //se for um nfe então é necessário pegar a versão
            // em outro node infNFe
            $node1 = $dom->getElementsByTagName('infNFe')->item(0);
            $versao = $node1->getAttribute('versao');
        } else {
            $versao = $node->getAttribute('versao');
        }
        $aResp['versao'] = $versao;
        $aResp['xml'] = $dom->saveXML($node);
        return $schem;
    }
}
