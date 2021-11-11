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
    protected $sendParams = [];

    //@phpstan-ignore-next-line
    public function send($url, $operation = '', $action = '', $soapver = SOAP_1_2, $parameters = [], $namespaces = [], $request = '', $soapheader = null)
    {
        $this->sendParams = [
            'url' => $url,
            'operation' => $operation,
            'action' => $action,
            'soapver' => $soapver,
            'parameters' => $parameters,
            'namespaces' => $namespaces,
            'request' => $request,
            'soapheader' => $soapheader,
        ];
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

    public function getSendParams(): array
    {
        return $this->sendParams;
    }
}
