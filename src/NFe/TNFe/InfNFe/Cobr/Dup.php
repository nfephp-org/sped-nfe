<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Cobr;

/**
 * Class representing Dup
 */
class Dup
{

    /**
     * Número da duplicata
     *
     * @property string $nDup
     */
    private $nDup = null;

    /**
     * Data de vencimento da duplicata (AAAA-MM-DD)
     *
     * @property string $dVenc
     */
    private $dVenc = null;

    /**
     * Valor da duplicata
     *
     * @property string $vDup
     */
    private $vDup = null;

    /**
     * Gets as nDup
     *
     * Número da duplicata
     *
     * @return string
     */
    public function getNDup()
    {
        return $this->nDup;
    }

    /**
     * Sets a new nDup
     *
     * Número da duplicata
     *
     * @param string $nDup
     * @return self
     */
    public function setNDup($nDup)
    {
        $this->nDup = $nDup;
        return $this;
    }

    /**
     * Gets as dVenc
     *
     * Data de vencimento da duplicata (AAAA-MM-DD)
     *
     * @return string
     */
    public function getDVenc()
    {
        return $this->dVenc;
    }

    /**
     * Sets a new dVenc
     *
     * Data de vencimento da duplicata (AAAA-MM-DD)
     *
     * @param string $dVenc
     * @return self
     */
    public function setDVenc($dVenc)
    {
        $this->dVenc = $dVenc;
        return $this;
    }

    /**
     * Gets as vDup
     *
     * Valor da duplicata
     *
     * @return string
     */
    public function getVDup()
    {
        return $this->vDup;
    }

    /**
     * Sets a new vDup
     *
     * Valor da duplicata
     *
     * @param string $vDup
     * @return self
     */
    public function setVDup($vDup)
    {
        $this->vDup = $vDup;
        return $this;
    }


}

