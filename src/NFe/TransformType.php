<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing TransformType
 *
 *
 * XSD Type: TransformType
 */
class TransformType
{

    /**
     * @property string $algorithm
     */
    private $algorithm = null;

    /**
     * @property string[] $xPath
     */
    private $xPath = null;

    /**
     * Gets as algorithm
     *
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Sets a new algorithm
     *
     * @param string $algorithm
     * @return self
     */
    public function setAlgorithm($algorithm)
    {
        $this->algorithm = $algorithm;
        return $this;
    }

    /**
     * Adds as xPath
     *
     * @return self
     * @param string $xPath
     */
    public function addToXPath($xPath)
    {
        $this->xPath[] = $xPath;
        return $this;
    }

    /**
     * isset xPath
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetXPath($index)
    {
        return isset($this->xPath[$index]);
    }

    /**
     * unset xPath
     *
     * @param scalar $index
     * @return void
     */
    public function unsetXPath($index)
    {
        unset($this->xPath[$index]);
    }

    /**
     * Gets as xPath
     *
     * @return string[]
     */
    public function getXPath()
    {
        return $this->xPath;
    }

    /**
     * Sets a new xPath
     *
     * @param string[] $xPath
     * @return self
     */
    public function setXPath(array $xPath)
    {
        $this->xPath = $xPath;
        return $this;
    }


}

