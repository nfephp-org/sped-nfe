<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe;

/**
 * Class representing Compra
 */
class Compra
{

    /**
     * Informação da Nota de Empenho de compras públicas (NT2011/004)
     *
     * @property string $xNEmp
     */
    private $xNEmp = null;

    /**
     * Informação do pedido
     *
     * @property string $xPed
     */
    private $xPed = null;

    /**
     * Informação do contrato
     *
     * @property string $xCont
     */
    private $xCont = null;

    /**
     * Gets as xNEmp
     *
     * Informação da Nota de Empenho de compras públicas (NT2011/004)
     *
     * @return string
     */
    public function getXNEmp()
    {
        return $this->xNEmp;
    }

    /**
     * Sets a new xNEmp
     *
     * Informação da Nota de Empenho de compras públicas (NT2011/004)
     *
     * @param string $xNEmp
     * @return self
     */
    public function setXNEmp($xNEmp)
    {
        $this->xNEmp = $xNEmp;
        return $this;
    }

    /**
     * Gets as xPed
     *
     * Informação do pedido
     *
     * @return string
     */
    public function getXPed()
    {
        return $this->xPed;
    }

    /**
     * Sets a new xPed
     *
     * Informação do pedido
     *
     * @param string $xPed
     * @return self
     */
    public function setXPed($xPed)
    {
        $this->xPed = $xPed;
        return $this;
    }

    /**
     * Gets as xCont
     *
     * Informação do contrato
     *
     * @return string
     */
    public function getXCont()
    {
        return $this->xCont;
    }

    /**
     * Sets a new xCont
     *
     * Informação do contrato
     *
     * @param string $xCont
     * @return self
     */
    public function setXCont($xCont)
    {
        $this->xCont = $xCont;
        return $this;
    }


}

