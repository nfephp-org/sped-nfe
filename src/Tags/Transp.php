<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Transp extends Base implements TagInterface
{
    const TAG_NAME = 'transp';
    
    /**
     * @var int
     */
    public $modFrete;
    /**
     * @var string
     */
    public $vagao;
    /**
     * @var string
     */
    public $balsa;
    
    public $transporta;
    public $retTransp;
    public $veicTransp;
    public $reboque = [];
    public $vol = [];
    
    public $parameters = [
        'modFrete' => 'integer',
        'vagao' => 'string',
        'balsa' => 'string'
     ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->modFrete = $this->std->modfrete;
        $this->vagao = $this->std->vagao;
        $this->balsa = $this->std->balsa;
    }

    public function toNode()
    {
        $transpTag = $this->dom->createElement("transp");
        $this->dom->addChild(
            $transpTag,
            "modFrete",
            $this->modFrete,
            true
        );
        //transporta
        //retTransp
        //veicTransp
        //reboque
        $this->dom->addChild(
            $transpTag,
            "vagao",
            $this->modFrete,
            false
        );
        $this->dom->addChild(
            $transpTag,
            "balsa",
            $this->modFrete,
            false
        );
        //vol
        $this->node = $transpTag;
        return $transpTag;
    }
}
