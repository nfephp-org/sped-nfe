<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Transp\Vol;

/**
 * Class representing Lacres
 */
class Lacres
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

