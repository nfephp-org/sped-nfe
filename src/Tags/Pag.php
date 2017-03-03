<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class Pag extends Base implements TagInterface
{
    const TAG_NAME = 'pag';
    
    /**
     * @var int
     */
    public $tPag;
    /**
     * 13v2
     * @var float
     */
    public $vPag;
    /**
     * @var Tags\Card
     */
    public $card;
    
    public $parameters = [
        'tPag' => 'string',
        'vPag' => 'double'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->tPag = $this->std->tpag;
        $this->vPag = $this->std->vpag;
    }

    public function toNode()
    {
        $pagTag = $this->dom->createElement("pag");
        $this->dom->addChild(
            $pagTag,
            "tPag",
            $this->tPag,
            true
        );
        $this->dom->addChild(
            $pagTag,
            "vPag",
            number_format($this->vPag, 2, '.', ''),
            true
        );
        if (!empty($this->card) && ($this->tPag == 3 || $this->tPag == 4)) {
            $this->dom->appExternalChild($pagTag, $this->card->toNode());
        }
        $this->node = $pagTag;
        return $pagTag;
    }
}
