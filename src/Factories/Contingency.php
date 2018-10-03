<?php

namespace NFePHP\NFe\Factories;

/**
 * Class Contingency make a structure to set contingency mode
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

use NFePHP\Common\Strings;

class Contingency
{
    
    const SVCAN = 'SVCAN';
    const SVCRS = 'SVCRS';
    const OFFLINE = 'OFFLINE';
    const EPEC = 'EPEC';
    const FSDA = 'FS-DA';
    
    
    /**
     * @var \stdClass
     */
    protected $config;
    /**
     * @var string
     */
    public $type = '';
    /**
     * @var string
     */
    public $motive = '';
    /**
     * @var int
     */
    public $timestamp = 0;
    /**
     * @var int
     */
    public $tpEmis = 1;

    /**
     * Constructor
     * @param string $contingency
     */
    public function __construct($contingency = '')
    {
        $this->deactivate();
        if (!empty($contingency)) {
            $this->load($contingency);
        }
    }
    
    /**
     * Load json string with contingency configurations
     * @param string $contingency
     * @return void
     */
    public function load($contingency)
    {
        $this->config = json_decode($contingency);
        $this->type = $this->config->type;
        $this->timestamp = $this->config->timestamp;
        $this->motive = $this->config->motive;
        $this->tpEmis = $this->config->tpEmis;
    }
    
    /**
     * Create a object with contingency data
     * @param string $acronym Sigla do estado
     * @param string $motive
     * @param string $type Opcional parameter only used if FS-DA, EPEC or OFFLINE
     * @return string
     */
    public function activate($acronym, $motive, $type = '')
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
        $type = strtoupper(str_replace('-', '', $type));
        
        if (empty($type)) {
            $type = $list[$acronym];
        }
        $this->config = $this->configBuild($dt->getTimestamp(), $motive, $type);
        return $this->__toString();
    }
    
    /**
     * Deactivate contingency mode
     * @return string
     */
    public function deactivate()
    {
        $this->config = $this->configBuild(0, '', '');
        $this->timestamp = 0;
        $this->motive = '';
        $this->type = '';
        $this->tpEmis = 1;
        return $this->__toString();
    }

    /**
     * Returns a json string format
     * @return string
     */
    public function __toString()
    {
        return json_encode($this->config);
    }
    
    /**
     * Build parameter config as stdClass
     * @param int $timestamp
     * @param string $motive
     * @param string $type
     * @return \stdClass
     */
    private function configBuild($timestamp, $motive, $type)
    {
        switch ($type) {
            case 'EPEC':
                $tpEmis = 4;
                break;
            case 'FS-DA':
            case 'FSDA':
                $tpEmis = 5;
                break;
            case 'SVC-AN':
            case 'SVCAN':
                $tpEmis = 6;
                break;
            case 'SVC-RS':
            case 'SVCRS':
                $tpEmis = 7;
                break;
            case 'OFFLINE': //this is only to model 65 NFCe
                $tpEmis = 9;
                break;
            default:
                if ($type == '') {
                    $tpEmis = 1;
                    $timestamp = 0;
                    $motive = '';
                    break;
                }
                throw new \InvalidArgumentException(
                    "Tipo de contingência "
                    . "[$type] não está disponível;"
                );
        }
        $config = new \stdClass();
        $config->motive = Strings::replaceUnacceptableCharacters(substr(trim($motive), 0, 256));
        $config->timestamp = $timestamp;
        $config->type = $type;
        $config->tpEmis = $tpEmis;
        $this->load(json_encode($config));
        return $config;
    }
}
