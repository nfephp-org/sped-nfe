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

use NFePHP\Gtin\Gtin as GB;

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
        return GB::check($gtin)->isValid();
    }
}
