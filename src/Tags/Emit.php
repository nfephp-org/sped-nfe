<?php
namespace NFePHP\NFe\Tags;

/**
 * Esta classe representa a TAG <emit>
 * da NFe
 */
use NFePHP\NFe\Tags\Tag;

class Emit extends Tag
{
    public $CNPJ = '';
    public $CPF = '';
    public $xNome = '';
    public $xFant = '';
    public $IE = '';
    public $IEST = '';
    public $IM = '';
    public $CNAE = '';
    public $CRT = '';
    
    protected function validate()
    {
        $this->loadProperties($this);
    }
    
    protected function create()
    {
        return $this;
    }
}
