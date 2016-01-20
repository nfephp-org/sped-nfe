<?php
namespace NFePHP\NFe\Tags;

/**
 * Esta classe representa a TAG <refNFe> filha de <NFref>
 * da NFe 
 * Podem haver muitos desses objetos em uma NFe
 */
use NFePHP\NFe\Tags\Tag;

class RefNFe extends Tag
{
    public $refNFe = '';
    
    protected function validate()
    {
        $this->loadProperties($this);
        //como refNFe deve conter uma chave de NFe 
        //seu comprimento deve ser de 44 digitos e conter somente numeros
        //além disso o digito de controle deve está correto
    }
    
    protected function create()
    {
        return $this;
    }
}
