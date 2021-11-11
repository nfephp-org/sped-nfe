<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\Common\Certificate;
use NFePHP\NFe\Tools;
use NFePHP\NFe\Factories\Contingency;

/**
 * @property \NFePHP\NFe\Tests\Common\SoapFake $soap
 */
class ToolsFake extends Tools
{
    public function __construct($configJson, Certificate $certificate, Contingency $contingency = null)
    {
        parent::__construct($configJson, $certificate, $contingency);
        $this->soap = new SoapFake();
    }

    public function getSoap(): SoapFake
    {
        return $this->soap;
    }
}
