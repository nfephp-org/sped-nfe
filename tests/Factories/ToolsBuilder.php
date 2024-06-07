<?php

namespace NFePHP\NFe\Tests\Factories;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Tests\Common\ToolsFake;

class ToolsBuilder
{
    public static function buildDefault(): ToolsFake
    {

        $fixturesPath = dirname(__FILE__, 2) . '/fixtures/';
        $contentpfx = file_get_contents($fixturesPath . "certs/test_certificate.pfx");
        $passwordpfx = 'nfephp';


        return new ToolsFake(
            self::buildConfig(),
            Certificate::readPfx($contentpfx, $passwordpfx)
        );
    }

    public static function buildConfig(): string
    {
        $config = [
            "atualizacao" => "2017-02-20 09:11:21",
            "tpAmb" => 2,
            "razaosocial" => "SUA RAZAO SOCIAL LTDA",
            "siglaUF" => "SP",
            "cnpj" => "93623057000128",
            "schemes" => "PL_009_V4",
            "versao" => "4.00",
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            "aProxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]
        ];

        return json_encode($config);
    }
}
