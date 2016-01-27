<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det;

/**
 * Class representing ImpostoDevol
 */
class ImpostoDevol
{

    /**
     * Percentual de mercadoria devolvida
     *
     * @property string $pDevol
     */
    private $pDevol = null;

    /**
     * Informação de IPI devolvido
     *
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\ImpostoDevol\IPI $iPI
     */
    private $iPI = null;

    /**
     * Gets as pDevol
     *
     * Percentual de mercadoria devolvida
     *
     * @return string
     */
    public function getPDevol()
    {
        return $this->pDevol;
    }

    /**
     * Sets a new pDevol
     *
     * Percentual de mercadoria devolvida
     *
     * @param string $pDevol
     * @return self
     */
    public function setPDevol($pDevol)
    {
        $this->pDevol = $pDevol;
        return $this;
    }

    /**
     * Gets as iPI
     *
     * Informação de IPI devolvido
     *
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\ImpostoDevol\IPI
     */
    public function getIPI()
    {
        return $this->iPI;
    }

    /**
     * Sets a new iPI
     *
     * Informação de IPI devolvido
     *
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\ImpostoDevol\IPI $iPI
     * @return self
     */
    public function setIPI(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\ImpostoDevol\IPI $iPI)
    {
        $this->iPI = $iPI;
        return $this;
    }


}

