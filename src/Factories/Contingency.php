<?php

namespace NFePHP\NFe\Factories;

/**
 * Class Contingency make a structure to set contingency mode
 * for SVAN and SVRS only
 * NOTE: this class only works with model 55 NFe and do not work with model 65 NFCe
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Contingency
 * @copyright NFePHP Copyright (c) 2008
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

class Contingency
{
    /**
     * Constructor
     * May recive a json string of contingency data or not
     * @var string
     */
    protected $config;
    
    public function __construct($contingency = '')
    {
        $this->deactivate();
        if (!empty($contingency)) {
            $this->config = json_decode($contingency);
        }
    }
    
    /**
     * Create a object with contingency data
     * @param string $uf
     * @param string $motive
     * @return \stdClass
     */
    public function activate($uf, $motive)
    {
        $dt = new \DateTime('now');
        $list = array(
            'AC'=>'SVCAN',
            'AL'=>'SVCAN',
            'AM'=>'SVCAN',
            'AP'=>'SVCRS',
            'BA'=>'SVCRS',
            'CE'=>'SVCRS',
            'DF'=>'SVCAN',
            'ES'=>'SVCRS',
            'GO'=>'SVCRS',
            'MA'=>'SVCRS',
            'MG'=>'SVCAN',
            'MS'=>'SVCRS',
            'MT'=>'SVCRS',
            'PA'=>'SVCRS',
            'PB'=>'SVCAN',
            'PE'=>'SVCRS',
            'PI'=>'SVCRS',
            'PR'=>'SVCRS',
            'RJ'=>'SVCAN',
            'RN'=>'SVCRS',
            'RO'=>'SVCAN',
            'RR'=>'SVCAN',
            'RS'=>'SVCAN',
            'SC'=>'SVCAN',
            'SE'=>'SVCAN',
            'SP'=>'SVCAN',
            'TO'=>'SVCAN'
        );
        $this->config = new \stdClass();
        $this->config->motive = (string) $motive;
        $this->config->timestamp = (int) $dt->getTimestamp();
        $this->config->type = (string) $list[$uf];
        return $this->config;
    }
    
    /**
     * Deactivate contingency mode
     */
    public function deactivate()
    {
        $this->config = new \stdClass();
        $this->config->motive = '';
        $this->config->timestamp = 0;
        $this->config->type = '';
    }
    
    /**
     * Return type of contingnecy SVCAN or SVCRS
     * @return string
     */
    public function type()
    {
        return $this->config->type;
    }

    /**
     * Returns a json string format
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->config);
    }
}
