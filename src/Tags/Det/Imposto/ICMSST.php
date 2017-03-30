<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class ICMSST extends Base implements TagInterface
{
    const TAG_NAME = 'ICMSST';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
