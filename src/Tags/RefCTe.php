<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class RefCTe extends Base implements TagInterface
{
    const TAG_NAME = 'refCTe';
    
    /**
     * @var array
     */
    public $refCTe;
    /**
     * @var array
     */
    public $parameters = ['refCTe' => 'array'];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        $this->refCTe = $this->std->refcte;
    }
    
    public function toNode()
    {
        foreach ($this->refCTe as $ref) {
            $nfref = $this->dom->createElement("NFref");
            $this->dom->addChild($nfref, 'refCTe', $ref);
            $this->dom->appendChild($nfref);
        }
        $this->node = $this->dom;
        return $this->dom;
    }
}
