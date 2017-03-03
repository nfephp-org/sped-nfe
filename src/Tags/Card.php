<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Card extends Base implements TagInterface
{
    const TAG_NAME = 'card';
    
    /**
     * @var string
     */
    public $CNPJ;
    /**
     * @var string
     */
    public $tBand;
    /**
     * @var string
     */
    public $cAut;
    
    public $parameters = [
        'CNPJ' => 'string',
        'tBand' => 'string',
        'cAut' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->CNPJ = $this->std->cnpj;
        $this->tBand = $this->std->tband;
        $this->cAut = $this->std->caut;
    }

    public function toNode()
    {
        $cardTag = $this->dom->createElement("card");
        $this->dom->addChild(
            $cardTag,
            "CNPJ",
            $this->CNPJ,
            true
        );
        $this->dom->addChild(
            $cardTag,
            "tBand",
            $this->tBand,
            true
        );
        $this->dom->addChild(
            $cardTag,
            "cAut",
            $this->cAut,
            true
        );
        $this->node = $cardTag;
        return $cardTag;
    }
}
