<?php

namespace NFePHP\NFe\Tags\Det\Imposto;

class ICMSSN extends Base implements TagInterface
{
    const TAG_NAME = 'ICMSSN';
    
    public $parameters = [];
    
    public function __construct(stdClass $std)
    {
        parent::__construct($std);
    }

    public function toNode()
    {
    }
}
