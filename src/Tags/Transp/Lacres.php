<?php

namespace NFePHP\NFe\Tags\Transp;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Lacres extends Base implements TagInterface
{
    const TAG_NAME = 'lacres';
 
    /**
     * @var string
     */
    public $nLacre;
    
    public $parameters = [
        'nLacre' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->nLacre = $this->std->nlacre;
    }
    
    public function toNode()
    {
        $lacresTag = $this->dom->createElement("lacres");
        $this->dom->addChild(
            $lacresTag,
            "nLacre",
            $this->nLacre,
            true
        );
        $this->node = $lacresTag;
        return $lacresTag;
    }
}
