<?php

namespace NFePHP\NFe\Tags;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class ObsCont extends Base implements TagInterface
{
    const TAG_NAME = 'obsCont';
    
    /**
     * @var string
     */
    public $xCampo;
    /**
     * @var string
     */
    public $xTexto;
    
    public $parameters = [
        'xCampo' => 'string',
        'xTexto' => 'string'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->xCampo = $this->std->xcampo;
        $this->xTexto = $this->std->xtexto;
    }

    public function toNode()
    {
        $obsContTag = $this->dom->createElement("obsCont");
        $this->dom->addChild(
            $obsContTag,
            "xCampo",
            $this->xCampo,
            true
        );
        $this->dom->addChild(
            $obsContTag,
            "xTexto",
            $this->xTexto,
            true
        );
        $this->node = $obsContTag;
        return $obsContTag;
    }
}
