<?php

namespace NFePHP\NFe\Convertion;

class Entity
{
    private static $available = [
        'AEntity'       => AEntity::class
    ];
    
    /**
     * Call classes to build XML NFe
     * @param type $name
     * @param type $arguments
     * @return \NFePHP\NFe\className
     * @throws InvalidArgumentException
     */
    public static function __callStatic($name, $arguments)
    {
        $className = self::$available[strtolower($name)];
        if (empty($className)) {
            throw new InvalidArgumentException('Tag name not found.');
        }
        return new $className($arguments[0]);
    }
}
