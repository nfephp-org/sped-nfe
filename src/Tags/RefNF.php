<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class RefNF extends Base implements TagInterface
{
    const TAG_NAME = 'refNF';
    
    /**
     * @var int
     */
    public $cUF;
    /**
     * @var int
     */
    public $AAMM;
    /**
     * @var string
     */
    public $CNPJ;
    /**
     * @var int
     */
    public $mod;
    /**
     * @var int
     */
    public $serie;
    /**
     * @var int
     */
    public $nNF;

    
    /**
     * @var array
     */
    public $parameters = [
        'cUF' => 'integer',
        'aamm' => 'integer',
        'cnpj' => 'string',
        'mod' => 'integer',
        'serie' => 'integer',
        'nNF' => 'integer'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->cUF = $this->std->cuf;
        $this->AAMM = $this->std->aamm;
        $this->CNPJ = $this->std->cnpj;
        $this->mod = $this->std->mod;
        $this->serie = $this->std->serie;
        $this->nNF = $this->std->nnf;
    }
    
    public function toNode()
    {
        $nfref = $this->dom->createElement("NFref");
        $refNF = $this->dom->createElement("refNF");
        $this->dom->addChild(
            $refNF,
            "cUF",
            $this->cUF,
            true
        );
        $this->dom->addChild(
            $refNF,
            "AAMM",
            $this->AAMM,
            true
        );
        $this->dom->addChild(
            $refNF,
            "CNPJ",
            $this->CNPJ,
            true
        );
        $this->dom->addChild(
            $refNF,
            "mod",
            $this->mod,
            true
        );
        $this->dom->addChild(
            $refNF,
            "serie",
            $this->serie,
            true
        );
        $this->dom->addChild(
            $refNF,
            "nNF",
            $this->nNF,
            true
        );
        $this->dom->appChild($nfref, $refNF);
        $this->node = $nfref;
        return $nfref;
    }
}
