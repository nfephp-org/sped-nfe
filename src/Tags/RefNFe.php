<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class RefNFe extends Base implements TagInterface
{
    const TAG_NAME = 'refNFe';
    
    /**
     * @var array
     */
    public $refNFe;
    /**
     * @var array
     */
    public $parameters = ['refNFe' => 'array'];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->refNFe = $this->std->refnfe;
    }
    
    public function toNode()
    {
        foreach ($this->refNFe as $ref) {
            $nfref = $this->dom->createElement("NFref");
            $this->dom->addChild($nfref, 'refNFe', $ref);
            $this->dom->appendChild($nfref);
        }
        $this->node = $this->dom;
        return $this->dom;
    }
}
