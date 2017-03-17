<?php

namespace NFePHP\NFe\Common;

/**
 * Class to Read and preprocess WS parameters from xml storage
 * file to json encode or stdClass
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Webservices
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

class Webservices
{
    public $json;
    public $std;
    
    /**
     * Constructor
     * @param string $xml path or xml content from 
     *               nfe_ws3_mod55 or nfe_ws3_mod65
     */
    public function __construct($xml)
    {
        $this->convert($xml);
    }
    
    /**
     * Get webservices parameters for specific conditions
     * @param string $sigla
     * @param string $ambiente "homologacao" ou "producao"
     * @param string $modelo "55" ou "65"
     * @return boolean | \stdClass
     */
    public function get($sigla, $ambiente, $modelo)
    {
        $autorizadores['65'] = [
            'AC'=>'SVRS',
            'AL'=>'SVRS',
            'AM'=>'AM',
            'AP'=>'SVRS',
            'BA'=>'SVRS',
            'CE'=>'',
            'DF'=>'SVRS',
            'ES'=>'SVRS',
            'GO'=>'SVRS',
            'MA'=>'SVRS',
            'MG'=>'',
            'MS'=>'MS',
            'MT'=>'MT',
            'PA'=>'SVRS',
            'PB'=>'SVRS',
            'PE'=>'',
            'PI'=>'SVRS',
            'PR'=>'PR',
            'RJ'=>'SVRS',
            'RN'=>'SVRS',
            'RO'=>'SVRS',
            'RR'=>'SVRS',
            'RS'=>'RS',
            'SC'=>'SVRS',
            'SE'=>'SVRS',
            'SP'=>'SP',
            'TO'=>'SVRS',
            'SVRS'=>'SVRS'
        ];
        $autorizadores['55'] = [
            'AC'=>'SVRS',
            'AL'=>'SVRS',
            'AM'=>'AM',
            'AN'=>'AN',
            'AP'=>'SVRS',
            'BA'=>'BA',
            'CE'=>'CE',
            'DF'=>'SVRS',
            'ES'=>'SVRS',
            'GO'=>'GO',
            'MA'=>'SVAN',
            'MG'=>'MG',
            'MS'=>'MS',
            'MT'=>'MT',
            'PA'=>'SVAN',
            'PB'=>'SVRS',
            'PE'=>'PE',
            'PI'=>'SVAN',
            'PR'=>'PR',
            'RJ'=>'SVRS',
            'RN'=>'SVRS',
            'RO'=>'SVRS',
            'RR'=>'SVRS',
            'RS'=>'RS',
            'SC'=>'SVRS',
            'SE'=>'SVRS',
            'SP'=>'SP',
            'TO'=>'SVRS',
            'SVAN'=>'SVAN',
            'SVRS'=>'SVRS',
            'SVCAN'=>'SVCAN',
            'SVCRS'=>'SVCRS'
        ];
        $auto = $autorizadores[$modelo][$sigla];
        if (empty($auto)) {
            return false;
        }
        return $this->std->$auto->$ambiente;
    }

    /**
     * Return WS parameters in a stdClass
     * @param string $xml
     * @return \stdClass
     */
    public function toStd($xml = '')
    {
        if (!empty($xml)) {
            $this->convert($xml);
        }
        return $this->std;
    }
    
    /**
     * Return WS parameters in json format
     * @return string
     */
    public function __toString()
    {
        return (string) $this->json;
    }
    
    /**
     * Read WS xml and convert to json and stdClass
     * @param string $xml
     */
    protected function convert($xml)
    {
        $resp = simplexml_load_string($xml, null, LIBXML_NOCDATA);
        $aWS = [];
        foreach ($resp->children() as $element) {
            $sigla = (string) $element->sigla;
            $homo = $element->homologacao;
            foreach ($homo->children() as $children) {
                $name = (string) $children->getName();
                $method = (string) $children['method'];
                $operation = (string) $children['operation'];
                $version = (string) $children['version'];
                $url = (string) $children[0];
                $operations = [
                    'method' => $method,
                    'operation' => $operation,
                    'version' => $version,
                    'url' => $url
                ];
                $amb['homologacao'][$name] = $operations;
            }
            $aWS[$sigla] = $amb;
            $homo = $element->producao;
            foreach ($homo->children() as $children) {
                $name = $children->getName();
                $name = (string) $children->getName();
                $method = (string) $children['method'];
                $operation = (string) $children['operation'];
                $version = (string) $children['version'];
                $url = (string) $children[0];
                $operations = [
                    'method' => $method,
                    'operation' => $operation,
                    'version' => $version,
                    'url' => $url
                ];
                $amb['producao'][$name] = $operations;
            }
            $aWS[$sigla] = $amb;
            $amb = null;
        }
        $this->json = json_encode($aWS);
        $this->std = json_decode(json_encode($aWS));
    }
}
