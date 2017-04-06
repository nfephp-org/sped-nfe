<?php

namespace NFePHP\NFe\Factories;

/**
 * Classe a construção do xml da NFe modelo 55 e modelo 65
 * Apenas para a versão 3.10 do layout
 * @category  NFePHP
 * @package   NFePHP\NFe\Factories\Make310
 * @copyright Copyright (c) 2008-2017
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\NFe\Factories\MakeBasic;
use NFePHP\Common\Keys;
use NFePHP\Common\DOMImproved as Dom;
use \RuntimeException;
use \DOMDocument;
use \DOMElement;
use \DOMNode;

class Make310 extends MakeBasic
{
    /**
     * @var float
     */
    protected $versao = 3.10;

    public function __construct()
    {
        parent::__construct();
    }
}
