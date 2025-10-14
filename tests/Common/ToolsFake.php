<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\Common\Certificate;
use NFePHP\Common\Strings;
use NFePHP\NFe\Tools;
use NFePHP\NFe\Factories\Contingency;

/**
 * @property \NFePHP\NFe\Tests\Common\SoapFake $soap
 */
class ToolsFake extends Tools
{
    public function __construct($configJson, Certificate $certificate, ?Contingency $contingency = null)
    {
        parent::__construct($configJson, $certificate, $contingency);
        $this->soap = new SoapFake();
        //@todo Gerar um certificado de testes usando CNPJ
        $this->typePerson = 'J';
    }

    public function getSoap(): SoapFake
    {
        return $this->soap;
    }

    /**
     * @return string
     */
    public function getRequest()
    {
        $params = $this->getSoap()->getSendParams();
        return $params['request'];
    }
}
