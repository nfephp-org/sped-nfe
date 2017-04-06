<?php


namespace NFePHP\NFe\Common;

class ValidTXT
{
    public static $errors = [];
    public static $entities = [];
    
    public static function loadStructure($version = 3.10)
    {
        $path = realpath(__DIR__ . "/../../storage");
        $json = file_get_contents(
            $path . '/txtstructure' . ($version*100) . '.json'
        );
        self::$entities = json_decode($json, true);
    }
    
    public static function isValid($txt)
    {
        self::loadStructure();
        $rows = explode("\n", $txt);
        foreach ($rows as $row) {
            $fields = explode('|', $row);
            if (empty($fields)) {
                continue;
            }
            $count = count($fields);
            $ref = strtoupper($fields[0]);
            if ($ref == "A") {
                self::loadStructure($fields[1]);
            }
            if (empty($ref)) {
                continue;
            }
            if (substr($row, -1) != '|') {
                self::$errors[] = "ERRO: Todas as linhas devem terminar com 'pipe'. [$row]";
                continue;
            }
            if (!array_key_exists($ref, self::$entities)) {
                self::$errors[] = "ERRO: Essa referencia não está definida. [$row]";
                continue;
            }
            $default = count(explode('|', self::$entities[$ref]));
            if ($default != $count) {
                self::$errors[] = "ERRO: O numero de parametros na linha "
                    . "está errado. [ $row ] Esperado [ "
                    . self::$entities[$ref]." ]";
            }
        }
        return self::$errors;
    }
}
