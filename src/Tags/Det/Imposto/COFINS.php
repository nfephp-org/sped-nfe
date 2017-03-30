<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class COFINS extends Base implements TagInterface
{
    const TAG_NAME = 'COFINS';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
