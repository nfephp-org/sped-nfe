<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\ImpostoDevol;

/**
 * Class representing IPI
 */
class IPI
{

    /**
     * Valor do IPI devolvido
     *
     * @property string $vIPIDevol
     */
    private $vIPIDevol = null;

    /**
     * Gets as vIPIDevol
     *
     * Valor do IPI devolvido
     *
     * @return string
     */
    public function getVIPIDevol()
    {
        return $this->vIPIDevol;
    }

    /**
     * Sets a new vIPIDevol
     *
     * Valor do IPI devolvido
     *
     * @param string $vIPIDevol
     * @return self
     */
    public function setVIPIDevol($vIPIDevol)
    {
        $this->vIPIDevol = $vIPIDevol;
        return $this;
    }


}

