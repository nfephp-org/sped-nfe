<?php

/**
 * Converts NFe from text format to xml
 * @category  API
 * @package   NFePHP\NFe
 * @copyright NFePHP Copyright (c) 2008-2019
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

namespace NFePHP\NFe;

use NFePHP\NFe\Common\ValidTXT;
use NFePHP\NFe\Exception\DocumentsException;
use NFePHP\NFe\Exception\ParserException;
use NFePHP\NFe\Exception\RuntimeException;
use NFePHP\NFe\Factories\Parser;

class Convert
{
    public const LOCAL = "LOCAL";
    public const LOCAL_V12 = "LOCAL_V12";
    public const SEBRAE = "SEBRAE";

    protected $txt;
    protected $dados;
    protected $numNFe = 1;
    protected $notas;
    protected $layouts = [];
    protected $xmls = [];
    protected $baselayout;

    /**
     * Constructor method
     */
    public function __construct(string $txt = '', string $baselayout = self::LOCAL)
    {
        $this->baselayout = $baselayout;
        if (!empty($txt)) {
            $this->txt = trim($txt);
        }
    }

    /**
     * Static method to convert Txt to Xml
     */
    public static function parse(string $txt, string $baselayout = self::LOCAL): array
    {
        $conv = new static($txt, $baselayout);
        return $conv->toXml();
    }

    /**
     * Convert all nfe in XML, one by one
     * @throws \NFePHP\NFe\Exception\DocumentsException
     */
    public function toXml(): array
    {
        //$txt = Strings::removeSomeAlienCharsfromTxt($this->txt);

        if (!$this->isNFe($this->txt)) {
            throw DocumentsException::wrongDocument(12, '');
        }
        $this->notas = $this->sliceNotas($this->dados);
        $this->checkQtdNFe();
        $this->validNotas();
        $i = 0;
        foreach ($this->notas as $nota) {
            $version = $this->layouts[$i];
            $parser = new Parser($version, $this->baselayout);
            try {
                $this->xmls[] = $parser->toXml($nota);
            } catch (\Exception $e) {
                if ($errors = $parser->getErrors()) {
                    throw new ParserException(implode(', ', $errors));
                } else {
                    throw new RuntimeException($e->getMessage());
                }
            }
            $i++;
        }
        return $this->xmls;
    }

    /**
     * Check if it is an NFe in TXT format
     * @return boolean
     */
    protected function isNFe(string $txt): bool
    {
        if (empty($txt)) {
            throw DocumentsException::wrongDocument(15, '');
        }
        $this->dados = explode("\n", $txt);
        $fields = explode('|', $this->dados[0]);
        if ($fields[0] == 'NOTAFISCAL') {
            $this->numNFe = (int) $fields[1];
            return true;
        }
        return false;
    }

    /**
     * Separate nfe into elements of an array
     */
    protected function sliceNotas(array $array): array
    {
        $aNotas = [];
        $annu = explode('|', $array[0]);
        $numnotas = $annu[1];
        unset($array[0]);
        if ($numnotas == 1) {
            $aNotas[] = $array;
            return $aNotas;
        }
        $iCount = 0;
        $xCount = 0;
        $resp = [];
        foreach ($array as $linha) {
            if (substr($linha, 0, 2) == 'A|') {
                $resp[$xCount]['init'] = $iCount;
                if ($xCount > 0) {
                    $resp[$xCount - 1]['fim'] = $iCount;
                }
                $xCount += 1;
            }
            $iCount += 1;
        }
        $resp[$xCount - 1]['fim'] = $iCount;
        foreach ($resp as $marc) {
            $length = $marc['fim'] - $marc['init'];
            $aNotas[] = array_slice($array, $marc['init'], $length, false);
        }
        return $aNotas;
    }

    /**
     * Verify number of NFe declared
     * If different throws an exception
     * @throws \NFePHP\NFe\Exception\DocumentsException
     */
    protected function checkQtdNFe()
    {
        $num = is_countable($this->notas) ? count($this->notas) : 0;
        if ($num != $this->numNFe) {
            throw DocumentsException::wrongDocument(13, '');
        }
    }

    /**
     * Valid all NFes in txt and get layout version for each nfe
     */
    protected function validNotas()
    {
        foreach ($this->notas as $nota) {
            $this->loadLayoutsVersions($nota);
            $this->isValidTxt($nota);
        }
    }

    /**
     * Read and set all layouts versions in NFes
     */
    protected function loadLayoutsVersions(array $nota)
    {
        if (empty($nota)) {
            throw DocumentsException::wrongDocument(17, '');
        }
        foreach ($nota as $campo) {
            $fields = explode('|', $campo);
            if ($fields[0] == 'A') {
                $this->layouts[] = $fields[1];
                break;
            }
        }
    }

    /**
     * Valid txt structure
     * @throws \NFePHP\NFe\Exception\DocumentsException
     */
    protected function isValidTxt(array $nota)
    {
        $errors = ValidTXT::isValid(implode("\n", $nota), $this->baselayout);
        if (!empty($errors)) {
            throw DocumentsException::wrongDocument(14, implode("\n", $errors));
        }
    }
}
