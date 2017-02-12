<?php

namespace NFePHP\NFe\Tags;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMDocument;
use DOMElement;

class Base
{
    /**
     *
     * @var Dom
     */
    protected $dom;
    /**
     * @var stdClass
     */
    public $std;
    /**
     * @var DOMElement
     */
    public $node;
    /**
     * @var array
     */
    public $parameters = [];
    
    /**
     * Base Constructor
     * @param stdClass $std
     */
    public function __construct(stdClass $std = null)
    {
        if (!empty($std)) {
            $std = $this->standardizeParams($this->parameters, $std);
            $this->std = $std;
            $this->loadProperties();
        }
        $this->init();
    }
    
    /**
     * Initialize DOM
     */
    protected function init()
    {
        if (empty($this->dom)) {
            $this->dom = new Dom('1.0', 'UTF-8');
            $this->dom->preserveWhiteSpace = false;
            $this->dom->formatOutput = false;
        }    
    }

    /**
     * Return data from DOMElement in json string
     * @return string
     */
    public function __toString()
    {
        if (empty($this->node)) {
            $this->toNode();
        }
        return $this->toJson($this->node);
    }
    
    /**
     * Load all properties from $this->std, from __construct method
     */
    protected function loadProperties()
    {
        $properties = array_keys(get_object_vars($this));
        foreach($properties as $key) {
            $q = strtolower($key);
            if (isset($this->std->$q)) {
                $this->$key = $this->std->$q;
            }    
        }
    }

    /**
     * Standardize parameters
     * @param array $parameters
     * @param stdClass $dados
     * @return stdClass
     */
    protected static function standardizeParams($parameters, stdClass $dados)
    {
        $properties = get_object_vars($dados);
        foreach ($properties as $key => $value) {
            $keyList[strtoupper($key)] = gettype($value);
        }
        foreach ($parameters as $key => $type) {
            switch ($type) {
                case 'boolean':
                case 'string':
                case 'integer':
                case 'object':
                case 'double':
                case 'array':
                case 'resource':
                    $value = null;
                    break;
                default:
                    $obj = explode(':', $type);
                    $class = $obj[1];
                    $value = new $class();
            }
            if (!key_exists(strtoupper($key), $keyList)) {
                //nesse caso a classe não contem a propriedade então
                //ela deve ser criada pois todos os parametros devem
                //ser definidos
                $dados->{$key} = $value;
            } elseif ($keyList[strtoupper($key)] !== 'object' && strpos($type, ':') > 0) {
                //nesse caso a propriedade existe mas não é a classe exigida
                $dados->{$key} = $value;
            }
        }
        return self::propertiesToLower($dados);
    }
    
    /**
     * Change properties names of stdClass to lower case
     * @param stdClass $dados
     * @return stdClass
     */
    protected static function propertiesToLower(stdClass $dados)
    {
        $properties = get_object_vars($dados);
        $clone = new stdClass();
        foreach ($properties as $key => $value) {
            $nk = strtolower($key);
             $clone->{$nk} = $value;
        }
        return $clone;
    }
    
    /**
     * Convert DOMElement to json string
     * @param DOMElement $node
     * @return string
     */
    protected function toJson(DOMElement $node)
    {
        $newdoc = new DOMDocument();
        $cloned = $node->cloneNode(true);
        $newdoc->appendChild($newdoc->importNode($cloned, true));
        $xml_string = $newdoc->saveXML();
        $xml = simplexml_load_string($xml_string);
        return json_encode($xml);
    }
}
