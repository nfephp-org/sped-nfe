<?php

namespace NFePHP\NFe;

/**
 * Converts NFe from text format to xml
 * @category  API
 * @package   NFePHP\NFe
 * @copyright NFePHP Copyright (c) 2008-2017
 * @license   http://www.gnu.org/licenses/lgpl.txt LGPLv3+
 * @license   https://opensource.org/licenses/MIT MIT
 * @license   http://www.gnu.org/licenses/gpl.txt GPLv3+
 * @author    Roberto L. Machado <linux.rlm at gmail dot com>
 * @link      http://github.com/nfephp-org/sped-nfe for the canonical source repository
 */

use NFePHP\NFe\Common\ValidTXT;
use NFePHP\Common\Strings;
use NFePHP\NFe\Exception\DocumentsException;
use NFePHP\NFe\Factories\Parser;

class Convert
{
    public $txt;
    public $dados;
    public $numNFe = 1;
    public $notas;
    public $layouts = [];
    public $xmls = [];
    
    /**
     * Constructor method
     * @param string $txt
     */
    public function __construct($txt = '')
    {
        if (!empty($txt)) {
            $this->txt = trim($txt);
        }
    }
    
    /**
     * Static method to convert Txt to Xml
     * @param string $txt
     * @return array
     */
    public static function parse($txt)
    {
        $conv = new static($txt);
        return $conv->toXml();
    }
    
    /**
     * Convert all nfe in XML, one by one
     * @param string $txt
     * @return array
     * @throws \NFePHP\NFe\Exception\DocumentsException
     */
    public function toXml($txt = '')
    {
        if (!empty($txt)) {
            $this->txt = trim($txt);
        }
        $txt = Strings::removeSomeAlienCharsfromTxt($this->txt);
        if (!$this->isNFe($txt)) {
            throw DocumentsException::wrongDocument(12, '');
        }
        $this->notas = $this->sliceNotas($this->dados);
        $this->checkQtdNFe();
        $this->validNotas();
        $i = 0;
        foreach ($this->notas as $nota) {
            $version = $this->layouts[$i];
            $parser = new Parser($version);
            $this->xmls[] = $parser->toXml($nota);
            $i++;
        }
        return $this->xmls;
    }

    /**
     * Check if it is an NFe in TXT format
     * @param string $txt
     * @return boolean
     */
    protected function isNFe($txt)
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
     * @param  array $array
     * @return array
     */
    protected function sliceNotas($array)
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
                    $resp[$xCount -1]['fim'] = $iCount;
                }
                $xCount += 1;
            }
            $iCount += 1;
        }
        $resp[$xCount-1]['fim'] = $iCount;
        foreach ($resp as $marc) {
            $length = $marc['fim']-$marc['init'];
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
        $num = count($this->notas);
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
            $this->loadLayouts($nota);
            $this->isValidTxt($nota);
        }
    }

    /**
     * Read and set all layouts in NFes
     * @param array $nota
     */
    protected function loadLayouts($nota)
    {
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
     * @param array $nota
     * @throws \NFePHP\NFe\Exception\DocumentsException
     */
    protected function isValidTxt($nota)
    {
        $errors = ValidTXT::isValid(implode("\n", $nota));
        if (!empty($errors)) {
            throw DocumentsException::wrongDocument(14, implode("\n", $errors));
        }
    }
}
