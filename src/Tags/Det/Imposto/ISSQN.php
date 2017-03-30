<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class ISSQN extends Base implements TagInterface
{
    const TAG_NAME = 'ISSQN';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
