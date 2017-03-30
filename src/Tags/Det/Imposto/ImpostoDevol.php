<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class ImpostoDevol extends Base implements TagInterface
{
    const TAG_NAME = 'ImpostoDevol';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
