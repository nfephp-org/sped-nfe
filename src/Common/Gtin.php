<?php

namespace NFePHP\NFe\Common;

/**
 * Class for validation of GTIN
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Config
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */
class Gtin
{
    /**
     * Verify if GTIN is valid with dv
     * @param string $gtin
     * @return boolean
     */
    public static function isValid($gtin)
    {
        if (empty($gtin) || $gtin == 'SEM GTIN') {
            return true;
        }
        if (!is_numeric($gtin)) {
            return false;
        }
        $dv = (int) substr($gtin, -1);
        $mod = self::calcDV($gtin);
        if ($dv === $mod) {
            return true;
        }
        return false;
    }
    
    /**
     * Calculate vefication digit
     * @param  string $gtin
     * @return int
     */
    public static function calcDV($gtin)
    {
        $num = str_pad($gtin, 18, '0', STR_PAD_LEFT);
        $num = substr($num, 0, 17);
        $factor = 3;
        $sum = 0;
        $values = str_split($num, 1);
        foreach ($values as $value) {
            $mult = ($factor * $value);
            $sum += $mult;
            if ($factor == 3) {
                $factor = 1;
            } else {
                $factor = 3;
            }
        }
        $mmc = (ceil($sum/10))*10;
        return (int) ($mmc - $sum);
    }
}
