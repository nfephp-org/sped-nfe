<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;

class Entrega extends Base implements TagInterface
{
    const TAG_NAME = 'entrega';
    
    public $CNPJ;
    public $CPF;
    public $xLgr;
    public $nro;
    public $xCpl;
    public $xBairro;
    public $cMun;
    public $xMun;
    public $UF;
    
    public $parameters = [
        'CNPJ' => 'string',
        'CPF' => 'string',
        'xLgr' => 'string',
        'nro' => 'integer',
        'xCpl' => 'string',
        'xBairro' => 'string',
        'cMun' => 'integer',
        'xMun' => 'string',
        'UF' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->CNPJ = $this->std->cnpj;
        $this->CPF = $this->std->cpf;
        $this->xLgr = $this->std->xlgr;
        $this->nro = $this->std->nro;
        $this->xCpl = $this->std->xcpl;
        $this->xBairro = $this->std->xbairro;
        $this->cMun = $this->std->cmun;
        $this->xMun = $this->std->xmun;
        $this->UF = $this->std->uf;
    }
    
    /**
     * Build DOMElement form class properties
     * @return DOMElement
     */
    public function toNode()
    {
        $endTag = $this->dom->createElement(self::TAG_NAME);
        $this->dom->addChild(
            $endTag,
            "CNPJ",
            $this->CNPJ,
            false
        );
        $this->dom->addChild(
            $endTag,
            "CPF",
            $this->CPF,
            false
        );
        $this->dom->addChild(
            $endTag,
            "xLgr",
            $this->xLgr,
            true
        );
        $this->dom->addChild(
            $endTag,
            "nro",
            $this->nro,
            true
        );
        $this->dom->addChild(
            $endTag,
            "xCpl",
            $this->xCpl,
            false
        );
        $this->dom->addChild(
            $endTag,
            "xBairro",
            $this->xBairro,
            true
        );
        $this->dom->addChild(
            $endTag,
            "cMun",
            $this->cMun,
            true
        );
        $this->dom->addChild(
            $endTag,
            "xMun",
            $this->xMun,
            true
        );
        $this->dom->addChild(
            $endTag,
            "UF",
            $this->UF,
            true
        );
        $this->node = $endTag;
        return $endTag;
    }
}
