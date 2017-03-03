<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;

class AutXML extends Base implements TagInterface
{
    const TAG_NAME = 'autXML';
    /**
     * @var string
     */
    public $CNPJ;
    /**
     * @var string
     */
    public $CPF;
    
    public $parameters = [
        'CNPJ' => 'string',
        'CPF' => 'string',
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->CNPJ = $this->std->cnpj;
        $this->CPF = $this->std->cpf;
    }
    
    public function toNode()
    {
        $autXMLTag = $this->dom->createElement("autXML");
        $this->dom->addChild(
            $autXMLTag,
            "CNPJ",
            $this->CNPJ,
            false
        );
        $this->dom->addChild(
            $autXMLTag,
            "CPF",
            $this->CPF,
            false
        );
        $this->node = $autXMLTag;
        return $autXMLTag;
    }
}
