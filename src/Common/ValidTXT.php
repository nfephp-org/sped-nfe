<?php

namespace NFePHP\NFe\Common;

/**
 * Validation for TXT representation of NFe
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\ValidTXT
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

class ValidTXT
{
    const LOCAL="LOCAL";
    const SEBRAE="SEBRAE";

    /**
     * Loads structure of txt from json file in storage folder
     * @param float $version
     * @param string $baselayout
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public static function loadStructure($version = 4.00, $baselayout = self::LOCAL)
    {
        $path = realpath(__DIR__ . "/../../storage");
        $comp = '';
        if (strtoupper($baselayout) === 'SEBRAE') {
            $comp = '_sebrae';
        }
        $file = $path . '/txtstructure' . ($version*100) . $comp . '.json';
        if (!is_file($file)) {
            throw new \InvalidArgumentException("O arquivo de estrutura para a "
                . "versão de layout indicada no TXT, não foi encontrado [$file].");
        }
        $json = file_get_contents($file);
        return json_decode($json, true);
    }

    /**
     * Verifies the validity of txt according to the rules of the code
     * If is valid returns empty array
     * Else return array with errors
     * @param string $txt
     * @param string $baselayout
     * @return array
     */
    public static function isValid($txt, $baselayout = self::LOCAL)
    {
        $errors = [];
        $txt = str_replace(["\r", "\t"], '', trim($txt));
        $rows = explode("\n", $txt);
        $num = 0;

        foreach ($rows as $row) {
            $fields = explode('|', $row);
            if (empty($fields)) {
                continue;
            }
            $ref = strtoupper($fields[0]);
            if (empty($ref)) {
                continue;
            }
            if ($ref === 'NOTAFISCAL') {
                continue;
            }
            if ($ref === 'A') {
                $num = 0;
                $entities = self::loadStructure($fields[1], $baselayout);
            }
            if ($ref === 'I') {
                $num += 1;
            }
            $lastChar = substr($row, -1);
            $char = '';
            if ($lastChar != '|') {
                if ($lastChar == ' ') {
                    $char = '[ESP]';
                } elseif ($lastChar == "\r") {
                    $char = '[CR]';
                } elseif ($lastChar == "\t") {
                    $char = '[TAB]';
                }
                $nrow = str_replace(["\r", "\t"], '', trim($row));
                $errors[] = "ERRO: ($num) Todas as linhas devem terminar com 'pipe' e não $char. [$nrow]";
                continue;
            }
            if (empty($entities)) {
                $errors[] = "ERRO: O TXT não contêm um marcador A";
                return $errors;
            }
            if (!array_key_exists($ref, $entities)) {
                $errors[] = "ERRO: ($num) Essa referência não está definida. [$row]";
                continue;
            }
            $count = count($fields)-1;
            $default = count(explode('|', $entities[$ref]))-1;
            if ($default !== $count) {
                $errors[] = "ERRO: ($num) O número de parâmetros na linha "
                    . "está errado (esperado #$default) -> (encontrado #$count). [ $row ] Esperado [ "
                    . $entities[$ref]." ]";
                continue;
            }
            foreach ($fields as $field) {
                if (empty($field)) {
                    continue;
                }
                if (empty(trim($field))) {
                    $errors[] = "ERRO: ($num) Existem apenas espaços no campo dos dados. [$row]";
                    continue;
                }
                //permitindo acentuação, isso pode permitir algumas falhas de validação
                //mas em principio a SEFAZ autoriza o uso de alguns caracteres acentuados
                //apesar de recomendar que não sejam usados
                $newfield = str_replace(['>', '<', '"', "'", "\t", "\r"], "", $field);
                if ($field != $newfield) {
                    $errors[] = "ERRO: ($num) Existem caracteres especiais não permitidos, "
                        . "como por ex. caracteres de controle, sinais de maior ou menor, aspas ou apostrofes, "
                        . "na entidade [" . htmlentities($row) . "]";
                    continue;
                }
                $newfield = preg_replace(
                    '/[\x00-\x08\x10\x0B\x0C\x0E-\x19\x7F]'.
                    '|[\x00-\x7F][\x80-\xBF]+'.
                    '|([\xC0\xC1]|[\xF0-\xFF])[\x80-\xBF]*'.
                    '|[\xC2-\xDF]((?![\x80-\xBF])|[\x80-\xBF]{2,})'.
                    '|[\xE0-\xEF](([\x80-\xBF](?![\x80-\xBF]))|(?![\x80-\xBF]{2})|[\x80-\xBF]{3,})/S',
                    '?',
                    $field
                );
                 $newfield = preg_replace('/\xE0[\x80-\x9F][\x80-\xBF]'.
                    '|\xED[\xA0-\xBF][\x80-\xBF]/S', '?', $newfield);
                if ($field != $newfield) {
                    $errors[] = "ERRO: ($num) Existem caracteres não UTF-8, não permitidos, "
                        . "no campo [" . htmlentities($newfield) . "]";
                    continue;
                }
            }
        }
        return $errors;
    }
}
