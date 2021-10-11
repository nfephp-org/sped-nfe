<?php

/**
 * Reads and preprocesses WS parameters from xml storage file to json encode or stdClass
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Webservices
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe\Common;

use SimpleXMLElement;

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
        $this->toStd($xml);
    }

    /**
     * Gets webservices parameters for specific conditions
     * @param string $sigla
     * @param int $amb 1-Produção ou 2-Homologação
     * @param int $modelo "55" ou "65"
     * @return \stdClass
     * @see storage/autorizadores.json
     */
    public function get($sigla, $amb, $modelo)
    {
        $autfile = realpath(__DIR__ . '/../../storage/autorizadores.json');
        $autorizadores = json_decode(file_get_contents($autfile), true);
        if (!key_exists($sigla, $autorizadores[$modelo])) {
            throw new \RuntimeException("Nao existe autorizador [$sigla] para os webservices do modelo [$modelo]");
        }
        $auto = $autorizadores[$modelo][$sigla];
        if (empty($auto) || empty($this->std)) {
            throw new \RuntimeException('Falhou autorizador, parece vazio');
        }
        if (empty($this->std->$auto)) {
            throw new \RuntimeException("Nao existem webservices cadastrados para [$sigla] no modelo [$modelo]");
        }
        $ambiente = $amb == 1 ? 'producao' : 'homologacao';
        $svw = $this->std->$auto->$ambiente;
        if ($auto == 'SVRS' || $auto == 'SVAN') {
            $pad = !empty($this->std->$sigla->$ambiente) ? $this->std->$sigla->$ambiente : '';
            $pad = json_decode(json_encode($pad), true);
            if (!empty($pad)) {
                foreach ($pad as $key => $p) {
                    if (empty($svw->$key)) {
                        $svw->$key = new \stdClass();
                        $svw->$key->method = $p['method'];
                        $svw->$key->operation = $p['operation'];
                        $svw->$key->version = $p['version'];
                        $svw->$key->url = $p['url'];
                    }
                }
            }
        }
        return $svw;
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
            $aWS[$sigla] = [];
            if (isset($element->homologacao)) {
                $aWS[$sigla] += $this->extract($element->homologacao, 'homologacao');
            }
            if (isset($element->producao)) {
                $aWS[$sigla] += $this->extract($element->producao, 'producao');
            }
        }
        $this->json = json_encode($aWS);
        $this->std = json_decode(json_encode($aWS));
    }

    /**
     * Extract data from wbservices XML strorage to a array
     * @param SimpleXMLElement $node
     * @param string $environment
     * @return array
     */
    protected function extract(SimpleXMLElement $node, $environment)
    {
        $amb[$environment] = [];
        foreach ($node->children() as $children) {
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
            $amb[$environment][$name] = $operations;
        }
        return $amb;
    }
}
