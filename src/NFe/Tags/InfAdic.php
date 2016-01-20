<?php

namespace NFePHP\NFe\Tags;

/**
 * Esta Classe representa a TAG <infAdic>
 * da NFe
 */

use NFePHP\NFe\Tags\Tag;

class InfAdic extends Tag
{
    public $infAdFisco = '';
    public $infCpl = '';
    
    protected function validate()
    {
        $this->loadProperties($this);
    }

    protected function create()
    {
        return $this;
    }
}
