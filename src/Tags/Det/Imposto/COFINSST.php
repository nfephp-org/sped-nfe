<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class COFINSST extends Base implements TagInterface
{
    const TAG_NAME = 'COFINSST';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
