<?php

namespace NFePHP\NFe\Tags;

/**
 * Esta classe representa a TAG <infNFe>
 * da NFe
 */

use NFePHP\NFe\Tags\Tag;

class InfNFe extends Tag
{
    public $chave = '';
    public $versao = '';
    
    protected function validate()
    {
        $this->loadProperties($this);
    }

    protected function create()
    {
        return $this;
    }
}
