<?php

/**
 * Validation of config
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Config
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe\Common;

use JsonSchema\Validator as JsonValid;
use NFePHP\NFe\Exception\DocumentsException;

class Config
{
    /**
     * Validate method
     * @param string $content config.json
     */
    public static function validate(string $content): \stdClass
    {
        if (!is_string($content)) {
            throw DocumentsException::wrongDocument(8, "Não foi passado um json.");
        }
        $std = json_decode($content);
        if (!is_object($std)) {
            throw DocumentsException::wrongDocument(8, "Não foi passado um json valido.");
        }
        self::validInputData($std);
        return $std;
    }

    /**
     * Validation with JsonValid::class
     * @throws DocumentsException
     */
    protected static function validInputData(object $data): bool
    {
        $filejsonschema = __DIR__ . "/../../storage/config.schema";
        $validator = new JsonValid();
        $validator->check($data, (object)['$ref' => 'file://' . $filejsonschema]);
        if (!$validator->isValid()) {
            $msg = "";
            foreach ($validator->getErrors() as $error) {
                $msg .= sprintf("[%s] %s\n", $error['property'], $error['message']);
            }
            throw DocumentsException::wrongDocument(8, $msg);
        }
        return true;
    }
}
