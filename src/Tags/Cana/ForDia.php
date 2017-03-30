<?php

namespace NFePHP\NFe\Tags\Cana;

use NFePHP\NFe\Tags\Base;
use NFePHP\NFe\Tags\TagInterface;
use stdClass;

class ForDia extends Base implements TagInterface
{
    const TAG_NAME = 'forDia';
    /**
     * @var int
     */
    public $dia;
    /**
     * 11v10
     * @var float
     */
    public $qtde;
    
    public $parameters = [
        'dia' => 'string',
        'qtde' => 'double'
    ];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
        
        $this->dia = $this->std->dia;
        $this->qtde = $this->std->qtde;
    }

    public function toNode()
    {
        $forDiaTag = $this->dom->createElement("forDia");
        $this->dom->addChild(
            $forDiaTag,
            "dia",
            $this->dia,
            true
        );
        $this->dom->addChild(
            $forDiaTag,
            "qtde",
            number_format($this->qtde, 10, '.', ''),
            true
        );
        $this->node = $forDiaTag;
        return $forDiaTag;
    }
}
