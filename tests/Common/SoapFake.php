<?php

namespace NFePHP\NFe\Tests\Common;

use NFePHP\Common\Soap\SoapBase;
use NFePHP\Common\Soap\SoapInterface;

class SoapFake extends SoapBase implements SoapInterface
{
    /**
     * @var string
     */
    protected $returnValue;

    public function send($url, $operation = '', $action = '', $soapver = SOAP_1_2, $parameters = [], $namespaces = [], $request = '', $soapheader = null)
    {
        $envelope = $this->makeEnvelopeSoap(
            $request,
            $namespaces,
            $soapver,
            $soapheader
        );
        $msgSize = strlen($envelope);
        $parameters = [
            "Content-Type: application/soap+xml;charset=utf-8;",
            "Content-length: $msgSize"
        ];
        if (!empty($action)) {
            $parameters[0] .= "action=$action";
        }
        $this->requestHead = implode("\n", $parameters);
        $this->requestBody = $envelope;

        return $this->returnValue;
    }

    public function setReturnValue(string $returnValue): void
    {
        $this->returnValue = $returnValue;
    }

    public function getRequestBody(): string
    {
        return $this->requestBody;
    }
}
