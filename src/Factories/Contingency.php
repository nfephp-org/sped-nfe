<?php

/**
 * Class Contingency make a structure to set contingency mode
 *
 * @category  NFePHP
 * @package   NFePHP\NFe\Common\Contingency
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe\Factories;

use NFePHP\Common\Strings;

class Contingency
{
    public const SVCAN = 'SVCAN';
    public const SVCRS = 'SVCRS';

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
     */
    public function __construct(string $contingency = '')
    {
        $this->deactivate();
        if (!empty($contingency)) {
            $this->load($contingency);
        }
    }

    /**
     * Load json string with contingency configurations
     */
    public function load(string $contingency): void
    {
        $this->config = json_decode($contingency);
        $this->type = $this->config->type;
        $this->timestamp = $this->config->timestamp;
        $this->motive = $this->config->motive;
        $this->tpEmis = $this->config->tpEmis;
    }

    /**
     * Create a object with contingency data
     * @param string $acronym sigla dos estados
     * @param string $motive motivo de entrada em contingência
     * @param string $type tipo de contingência SVCAN ou SVCRS
     * @return string
     * @throws \Exception
     */
    public function activate(string $acronym, string $motive, string $type = ''): string
    {
        $list = [
            'AC' => 'SVCAN',
            'AL' => 'SVCAN',
            'AM' => 'SVCRS',
            'AP' => 'SVCAN',
            'BA' => 'SVCRS',
            'CE' => 'SVCAN',
            'DF' => 'SVCAN',
            'ES' => 'SVCAN',
            'GO' => 'SVCRS',
            'MA' => 'SVCRS',
            'MG' => 'SVCAN',
            'MS' => 'SVCRS',
            'MT' => 'SVCRS',
            'PA' => 'SVCAN',
            'PB' => 'SVCAN',
            'PE' => 'SVCRS',
            'PI' => 'SVCAN',
            'PR' => 'SVCRS',
            'RJ' => 'SVCAN',
            'RN' => 'SVCAN',
            'RO' => 'SVCAN',
            'RR' => 'SVCAN',
            'RS' => 'SVCAN',
            'SC' => 'SVCAN',
            'SE' => 'SVCAN',
            'SP' => 'SVCAN',
            'TO' => 'SVCAN'
        ];
        if (!empty($type)) {
            $type = strtoupper(str_replace('-', '', $type));
            if (!in_array($type, ['SVCAN', 'SVCRS'])) {
                throw new \RuntimeException(
                    "O tipo indicado de contingência não é aceito nesta operação. Usar apenas SVCAN ou SVCRS"
                );
            }
            $this->type = $type;
        }
        //gerar o timestamp para Greenwich (GMT).
        $dt = new \DateTime(gmdate('Y-m-d H:i:s')); //data hora GMT
        $this->motive = trim($motive);
        $len = mb_strlen($this->motive);
        if ($len < 15 || $len > 255) {
            throw new \RuntimeException(
                "A justificativa para entrada em contingência deve ter entre 15 e 256 caracteres UTF-8."
            );
        }
        $this->timestamp = $dt->getTimestamp();
        if (empty($type)) {
            $this->type = $list[$acronym];
        }
        $this->config = $this->configBuild();
        return $this->__toString();
    }

    /**
     * Deactivate contingency mode
     */
    public function deactivate(): string
    {
        $this->timestamp = 0;
        $this->motive = '';
        $this->type = '';
        $this->tpEmis = 1;
        $this->config = $this->configBuild();
        return $this->__toString();
    }

    /**
     * Returns a json string format
     */
    public function __toString(): string
    {
        return json_encode($this->config);
    }

    /**
     * Build parameter config as stdClass
     */
    private function configBuild(): \stdClass
    {
        $tpEmis = 1;
        switch ($this->type) {
            case 'SVC-AN':
            case 'SVCAN':
                $tpEmis = 6;
                break;
            case 'SVC-RS':
            case 'SVCRS':
                $tpEmis = 7;
                break;
            default:
                if ($this->type === '') {
                    $tpEmis = 1;
                    $this->timestamp = 0;
                    $this->motive = '';
                    break;
                }
        }
        $this->tpEmis = $tpEmis;
        $config = new \stdClass();
        $config->motive = Strings::replaceUnacceptableCharacters(substr(trim($this->motive), 0, 256));
        $config->timestamp = $this->timestamp;
        $config->type = $this->type;
        $config->tpEmis = $tpEmis;
        $this->load(json_encode($config));
        return $config;
    }
}
