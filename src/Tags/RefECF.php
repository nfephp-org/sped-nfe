<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class RefECF extends Base implements TagInterface
{
    const TAG_NAME = 'refECF';
    
    /**
     * @var string
     */
    public $mod;
    /**
     * @var int
     */
    public $nECF;
    /**
     * @var int
     */
    public $nCOO;
    
    /**
     * @var array
     */
    public $parameters = [
        'mod' => 'string',
        'nECF' => 'integer',
        'nCOO' => 'integer'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->mod = $this->std->mod;
        $this->nECF = $this->std->necf;
        $this->nCOO = $this->std->ncoo;
    }
    
    public function toNode()
    {
        $nfref = $this->dom->createElement("NFref");
        $refECF = $this->dom->createElement("refECF");
        $this->dom->addChild(
            $refECF,
            "mod",
            $this->mod,
            true
        );
        $this->dom->addChild(
            $refECF,
            "nECF",
            $this->nECF,
            true
        );
        $this->dom->addChild(
            $refECF,
            "nCOO",
            $this->nCOO,
            true
        );
        $this->dom->appChild($nfref, $refECF);
        $this->node = $nfref;
        return $nfref;
    }
}
