<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use DOMElement;

class Compra extends Base implements TagInterface
{
    const TAG_NAME = 'compra';
    
    public $xNEmp;
    public $xPed;
    public $xCont;
    
    public $parameters = [
        'xNEmp' => 'string',
        'xPed' => 'string',
        'xCont' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->xNEmp = $this->std->xnemp;
        $this->xPed = $this->std->xped;
        $this->xCont = $this->std->xcont;
    }
    
    public function toNode()
    {
        $compra = $this->dom->createElement("compra");
        $this->dom->addChild(
            $compra,
            "xNEmp",
            $this->xNEmp,
            true
        );
        $this->dom->addChild(
            $compra,
            "xPed",
            $this->xPed,
            true
        );
        $this->dom->addChild(
            $compra,
            "xCont",
            $this->xCont,
            false
        );
        $this->node = $compra;
        return $compra;
    }
}
