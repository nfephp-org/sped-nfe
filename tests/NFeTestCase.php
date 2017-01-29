<?php

namespace NFePHP\NFe\Tests;

class NFeTestCase extends \PHPUnit_Framework_TestCase
{
    public $fixturesPath = '';
    public $configJson = '';
    public $contentpfx = '';
    public $passwordpfx = '';
    
    public function __construct()
    {
        $this->fixturesPath = dirname(__FILE__) . '/fixtures/';
        $config = [
            "atualizacao" => "2016-11-03 18:01:21",
            "ambiente" => 2,
            "razao" => "SUA RAZAO SOCIAL LTDA",
            "cnpj" => "99999999999999",
            "uf" => "SP",
            "schemes" => "PL008i2",
            "versao" => '3.10',
            "tokenIBPT" => "AAAAAAA",
            "CSC" => "GPB0JBWLUR6HWFTVEAS6RJ69GPCROFPBBB8G",
            "CSCid" => "000001",
            "proxyConf" => [
                "proxyIp" => "",
                "proxyPort" => "",
                "proxyUser" => "",
                "proxyPass" => ""
            ]   
        ];
        $this->contentpfx = file_get_contents($this->fixturesPath . "certs/expired_certificate.pfx");
        $this->passwordpfx = "associacao";
        $this->configJson = json_encode($config);
    }
}
