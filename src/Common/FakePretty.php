<?php

namespace NFePHP\NFe\Common;

/**
 * Class FakePretty shows event and fake comunication data for analises and debugging
 *
 * @category  API
 * @package   NFePHP\NFe
 * @copyright NFePHP Copyright (c) 2017-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

class FakePretty
{
    public static function prettyPrint($response, $save = '')
    {
        if (empty($response)) {
            $html = "Sem resposta";
            return $html;
        }
        $std = json_decode($response);
        if (!empty($save)) {
            file_put_contents(
                "/var/www/sped/sped-nfe/tests/fixtures/xml/$save.xml",
                $std->body
            );
        }
        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = true;
        $doc->loadXML($std->body);

        $html = "<pre>";
        $html .= '<h2>url</h2>';
        $html .= $std->url;
        $html .= "<br>";
        $html .= '<h2>operation</h2>';
        $html .= "<br>";
        $html .= $std->operation;
        $html .= "<br>";
        $html .= '<h2>action</h2>';
        $html .= $std->action;
        $html .= "<br>";
        $html .= '<h2>soapver</h2>';
        $html .= $std->soapver;
        $html .= "<br>";
        $html .= '<h2>parameters</h2>';
        foreach ($std->parameters as $key => $param) {
            $html .= "[$key] => $param <br>";
        }
        $html .= "<br>";
        $html .= '<h2>header</h2>';
        $html .= $std->header;
        $html .= "<br>";
        $html .= '<h2>namespaces</h2>';
        $an = json_decode(json_encode($std->namespaces), true);
        foreach ($an as $key => $nam) {
            $html .= "[$key] => $nam <br>";
        }
        $html .= "<br>";
        $html .= '<h2>body</h2>';
        $html .= str_replace(
            ['<', '>'],
            ['&lt;','&gt;'],
            str_replace(
                '<?xml version="1.0"?>',
                '<?xml version="1.0" encoding="UTF-8"?>',
                $doc->saveXML()
            )
        );
        $html .= "</pre>";
        return $html;
    }
}
