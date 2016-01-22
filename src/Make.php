<?php

namespace NFePHP\NFe;

/**
 * Esta é a classe principal que constroi o 
 * objeto que deve representar neste caso uma 
 * NFe
 * 
 * E deve ser instanciada para a criação do objeto e sua 
 * posterior transformação em 
 * 
 * TXT
 * XML
 * Querys
 * json
 * e vice-versa
 * 
 * Ou qualquer outra forma necessária, como o PDF
 * da mesma forma pode ser usada auxiliar na conversão de TXT para Objeto
 * 
 */

use NFePHP\NFe\Tags\Builder;
use Collections\ArrayList;

class Make
{
    /**
     * LIsta com os erros encontrados
     * por não satisfazer algum requisito da SEFAZ
     * avalido pelo método validate() das classes derivadas 
     * da classe TAG
     * 
     * @var array
     */
    protected $errors;
    /**
     * Objeto InfNFe
     * @var Tags\InfNFe
     */
    public $infNFe;
    /**
     * Objeto InfAdic
     * @var Tags\InfAdic
     */
    public $infAdic;
    /**
     * Objeto Ide
     * @var Tags\Ide
     */
    public $ide;
    /**
     * Objeto Emit
     * @var Tags\Emit
     */
    public $emit;
    
    /**
     * Coleção de Objetos RefNFe
     * Pode haver nenhum ou até 500 objetos nessa TAG
     * @var type
     */
    public $refNFe;


    /**
     * Lista de propriedades desta classe
     * usado pelo método set() para localizar e carregar 
     * as propriedades
     * @var array
     */
    protected $properties;
    
    /**
     * Contrutor
     * Carrega a classe Dom e a lista de propriedades desta classe
     */
    public function __construct()
    {
        $this->properties = $this->getClassVars();
        //estabelecer as propriedades que serão coleções
        $this->refNFe = new ArrayList();;
    }
    
    /**
     * Estrutura a chamada a classe da TAG do XML
     * @param string $method
     * @param array $params
     * @return Object
     */
    public function builder($method, $params)
    {
        $tag = (new Builder)
            ->params($params)
            ->call($method);
       
        $this->set($method, $tag);
        return $tag;
    }
    
    /**
     * Carrega a lista de propriedades da classe
     * @return array
     */
    private function getClassVars()
    {
        return array_keys(get_class_vars(get_class($this)));
    }
    
    /**
     * Carrega a TAG (Objeto) em uma propriedade da classe 
     * para montagem e uso posterior
     * TODO: como tratar no caso de COLEÇÕES de Objetos !!!
     * @param string $property
     * @param Object $value
     */
    private function set($property, $value) {
        foreach ($this->properties as $propertyName) {
            if ($propertyName == $property) {
                if (method_exists($this->{$property}, 'add')) {
                    $this->{$property}->add($value);
                } else {
                    $this->{$property} = $value;    
                }
                break;
            }
        }
    }
    
    /**
     * Método mágico chamador
     * @param string $method
     * @param array $params
     * @return type
     */
    public function __call($method, $params = null)
    {
        if (is_array($params)) {
            $params = $params[0];
        }
        return $this->builder($method, $params);
    }
    
    /**
     * Método mágico chamador
     * @param string $method
     * @param array $params
     * @return type
     */
    public static function __callStatic($method, $params = null)
    {
        if (is_array($params)) {
            $params = $params[0];
        }
        return self::builder($method, $params);
    }
    
    /**
     * Retorna a lista de erros por descumprimento
     * das regras da SEFAZ sobre cada um dos objetos
     * que compõe a NFe
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }
}
