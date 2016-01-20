<?php

namespace NFePHP\NFe\Tags;

/**
 * Esta classe busca a classe referente a tag 
 * estabelecida pelo método chamador e 
 * carrega a classe e suas propriedades
 */

class Builder
{
    private $params;
    
    /**
     * Carrega os parametros da classe
     * 
     * @param array $params
     * @return \NFePHP\Common\Dom\Builder
     */
    public function params($params)
    {
        $this->params = $params;
        return $this;
    }
    
    /**
     * Chamador da classe construtora da tag
     *  
     * @param string $method
     * @return type
     */
    public function call($method)
    {
        $class = 'NFePHP\NFe\Tags\\'.ucfirst($method);
        return call_user_func_array([new $class, 'get'], [$this->params]);
    }
}