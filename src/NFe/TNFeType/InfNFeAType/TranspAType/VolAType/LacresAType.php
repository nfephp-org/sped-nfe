<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\TranspAType\VolAType;

/**
 * Class representing LacresAType
 */
class LacresAType
{

    /**
     * Número dos Lacres
     *
     * @property string $nLacre
     */
    private $nLacre = null;

    /**
     * Gets as nLacre
     *
     * Número dos Lacres
     *
     * @return string
     */
    public function getNLacre()
    {
        return $this->nLacre;
    }

    /**
     * Sets a new nLacre
     *
     * Número dos Lacres
     *
     * @param string $nLacre
     * @return self
     */
    public function setNLacre($nLacre)
    {
        $this->nLacre = $nLacre;
        return $this;
    }


}

