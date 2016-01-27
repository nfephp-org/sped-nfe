<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Cana;

/**
 * Class representing Deduc
 */
class Deduc
{

    /**
     * Descrição da Dedução
     *
     * @property string $xDed
     */
    private $xDed = null;

    /**
     * valor da dedução
     *
     * @property string $vDed
     */
    private $vDed = null;

    /**
     * Gets as xDed
     *
     * Descrição da Dedução
     *
     * @return string
     */
    public function getXDed()
    {
        return $this->xDed;
    }

    /**
     * Sets a new xDed
     *
     * Descrição da Dedução
     *
     * @param string $xDed
     * @return self
     */
    public function setXDed($xDed)
    {
        $this->xDed = $xDed;
        return $this;
    }

    /**
     * Gets as vDed
     *
     * valor da dedução
     *
     * @return string
     */
    public function getVDed()
    {
        return $this->vDed;
    }

    /**
     * Sets a new vDed
     *
     * valor da dedução
     *
     * @param string $vDed
     * @return self
     */
    public function setVDed($vDed)
    {
        $this->vDed = $vDed;
        return $this;
    }


}

