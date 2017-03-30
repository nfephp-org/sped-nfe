<?php

namespace NFePHP\NFe\Tags\NFref;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class RefNFP extends Base implements TagInterface
{
    const TAG_NAME = 'refNFP';
    
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
     * @var string
     */
    public $CPF;
    /**
     * @var string
     */
    public $IE;
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
            'AAMM' => 'integer',
            'CNPJ' => 'string',
            'CPF' => 'string',
            'IE' => 'string',
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
        $this->CPF = $this->std->cpf;
        $this->IE = $this->std->ie;
        $this->mod = $this->std->mod;
        $this->serie = $this->std->serie;
        $this->nNF = $this->std->nnf;
    }
    
    public function toNode()
    {
        $nfref = $this->dom->createElement("NFref");
        $refNFP = $this->dom->createElement("refNFP");
        $this->dom->addChild(
            $refNFP,
            "cUF",
            $this->cUF,
            true
        );
        $this->dom->addChild(
            $refNFP,
            "AAMM",
            $this->AAMM,
            true
        );
        $this->dom->addChild(
            $refNFP,
            "CNPJ",
            $this->CNPJ,
            true
        );
        $this->dom->addChild(
            $refNFP,
            "CPF",
            $this->CPF,
            true
        );
        $this->dom->addChild(
            $refNFP,
            "IE",
            $this->IE,
            true
        );
        $this->dom->addChild(
            $refNFP,
            "mod",
            $this->mod,
            true
        );
        $this->dom->addChild(
            $refNFP,
            "serie",
            $this->serie,
            true
        );
        $this->dom->addChild(
            $refNFP,
            "nNF",
            $this->nNF,
            true
        );
        $this->dom->appChild($nfref, $refNFP);
        $this->node = $nfref;
        return $nfref;
    }
}
