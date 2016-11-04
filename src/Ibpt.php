<?php

namespace NFePHP\NFe;

/**
 * Class to get taxes informations from IBPT
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Ibpt
 * @copyright NFePHP Copyright (c) 2016
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\Common\Soap\SoapCode;

class Ibpt
{
    /**
     * Get informations about taxes from IBPT restful service
     * @param string $cnpj your number
     * @param string $token IBPT token (after login in the site)
     * @param string $uf state abbreviation
     * @param string $ncm Mercosur Common Nomenclature
     * @param int $extarif
     * @param array $proxy ['IP' => '', 'PORT' => '', 'USER' => '', 'PASS' => '']
     * @return string
     */
    public static function getProduto($cnpj, $token, $uf, $ncm, $extarif = 0, $proxy = [])
    {
        $uri = "http://iws.ibpt.org.br/api/Produtos?token=$token&cnpj=$cnpj&codigo=$ncm&uf=$uf&ex=$extarif";
        return self::consult($uri, $proxy);
    }
    
    /**
     * Calling get in the IBPT restful service
     * @param string $uri
     * @param array $proxy
     * @return string
     */
    protected static function consult($uri, $proxy = [])
    {
        $oCurl = curl_init($uri);
        if (!empty($proxy)) {
            $oCurl = self::setProxy($oCurl, $proxy);
        }
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_TIMEOUT, 10);
        curl_setopt($oCurl, CURLOPT_CONNECTTIMEOUT, 30);
        $response = curl_exec($oCurl);
        $httpcode = curl_getinfo($oCurl, CURLINFO_HTTP_CODE);
        $info = curl_getinfo($oCurl);
        $ret['error'] = curl_error($oCurl);
        $ret['response'] = $response;
        curl_close($oCurl);
        if ($httpcode != 200) {
            $resp = SoapCode::info($httpcode);
            $ret = array_merge($ret, $resp);
            $response = json_encode($ret);
        }
        return $response;
    }
    
    /**
     * Set proxy parameters
     * @param object $oCurl
     * @param array $proxy
     * @return object
     */
    protected static function setProxy($oCurl, $proxy)
    {
        curl_setopt($oCurl, CURLOPT_HTTPPROXYTUNNEL, 1);
        curl_setopt($oCurl, CURLOPT_PROXYTYPE, CURLPROXY_HTTP);
        curl_setopt($oCurl, CURLOPT_PROXY, $proxy['IP'].':'.$proxy['PORT']);
        if ($proxy['PASS'] != '') {
            curl_setopt($oCurl, CURLOPT_PROXYUSERPWD, $proxy['USER'].':'.$proxy['PASS']);
            curl_setopt($oCurl, CURLOPT_PROXYAUTH, CURLAUTH_BASIC);
        }
        return $oCurl;
    }
}
