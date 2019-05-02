<?php
/**
 * Created by PhpStorm.
 * User: thalesmartins
 * Date: 28/12/2018
 * Time: 14:07
 */

namespace NFePHP\NFe\Tests;

trait URIConsultaNfce
{
    public static function getUri($tpAmb, $uf)
    {
        $path = realpath(__DIR__ . '/../storage/uri_consulta_nfce.json');
        $array = json_decode(file_get_contents($path), true);
        return $array[$tpAmb][$uf];
    }
}
