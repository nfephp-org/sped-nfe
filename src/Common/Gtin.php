<?php

/**
 * Class for validation of GTIN
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

use NFePHP\Gtin\Gtin as GB;

class Gtin
{
    /**
     * Verify if GTIN is valid with dv
     * @return boolean
     */
    public static function isValid(string $gtin): bool
    {
        if ($gtin === '' || $gtin === 'SEM GTIN') {
            return true;
        }
        return GB::check($gtin)->isValid();
    }
}
