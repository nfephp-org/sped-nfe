<?php

namespace NFePHP\NFe\NFe\TIpiType;

/**
 * Class representing IPINTAType
 */
class IPINTAType
{

    /**
     * Código da Situação Tributária do IPI:
     * 01-Entrada tributada com alíquota zero
     * 02-Entrada isenta
     * 03-Entrada não-tributada
     * 04-Entrada imune
     * 05-Entrada com suspensão
     * 51-Saída tributada com alíquota zero
     * 52-Saída isenta
     * 53-Saída não-tributada
     * 54-Saída imune
     * 55-Saída com suspensão
     *
     * @property string $cST
     */
    private $cST = null;

    /**
     * Gets as cST
     *
     * Código da Situação Tributária do IPI:
     * 01-Entrada tributada com alíquota zero
     * 02-Entrada isenta
     * 03-Entrada não-tributada
     * 04-Entrada imune
     * 05-Entrada com suspensão
     * 51-Saída tributada com alíquota zero
     * 52-Saída isenta
     * 53-Saída não-tributada
     * 54-Saída imune
     * 55-Saída com suspensão
     *
     * @return string
     */
    public function getCST()
    {
        return $this->cST;
    }

    /**
     * Sets a new cST
     *
     * Código da Situação Tributária do IPI:
     * 01-Entrada tributada com alíquota zero
     * 02-Entrada isenta
     * 03-Entrada não-tributada
     * 04-Entrada imune
     * 05-Entrada com suspensão
     * 51-Saída tributada com alíquota zero
     * 52-Saída isenta
     * 53-Saída não-tributada
     * 54-Saída imune
     * 55-Saída com suspensão
     *
     * @param string $cST
     * @return self
     */
    public function setCST($cST)
    {
        $this->cST = $cST;
        return $this;
    }


}

