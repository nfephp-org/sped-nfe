<?php
namespace NFePHP\NFe\Exception;

/**
 * @category   NFePHP
 * @package    NFePHP\NFe\Exception
 * @copyright  Copyright (c) 2008-2017
 * @license    http://www.gnu.org/licenses/lesser.html LGPL v3
 * @author     Roberto L. Machado <linux.rlm at gmail dot com>
 * @link       http://github.com/nfephp-org/sped-common for the canonical source repository
 */

class DocumentsException extends \InvalidArgumentException implements ExceptionInterface
{
    public static $list = [
        0 => "Este documento [{{msg}}] não recebe protocolos. Confira a ordem dos parâmetros.",
        1 => "O arquivo indicado como NFe não está protocolado ou não é uma NFe!!",
        2 => "O arquivo indicado como B2B não contêm a tagB2B indicada!!",
        3 => "O documento de resposta não contêm o NODE {{msg}}.",
        4 => "O documento de resposta relata um erro {{msg}}",
        5 => "Os documentos se referem a diferentes objetos. {{msg}}",
        6 => "O argumento passado não é um XML válido.",
        7 => "Este xml não pertence ao projeto SPED-NFe.",
        8 => "A configuração (config.json) não é válido {{msg}}"
    ];
    
    public static function wrongDocument($code, $msg = '')
    {
        $msg = self::replaceMsg(self::$list[$code], $msg);
        return new static($msg);
    }
    
    private static function replaceMsg($input, $msg)
    {
        return str_replace('{{msg}}', $msg, $input);
    }
}
