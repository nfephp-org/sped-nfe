<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ProdAType;

/**
 * Class representing DetExportAType
 */
class DetExportAType
{

    /**
     * Número do ato concessório de Drawback
     *
     * @property string $nDraw
     */
    private $nDraw = null;

    /**
     * Exportação indireta
     *
     * @property
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ProdAType\DetExportAType\ExportIndAType
     * $exportInd
     */
    private $exportInd = null;

    /**
     * Gets as nDraw
     *
     * Número do ato concessório de Drawback
     *
     * @return string
     */
    public function getNDraw()
    {
        return $this->nDraw;
    }

    /**
     * Sets a new nDraw
     *
     * Número do ato concessório de Drawback
     *
     * @param string $nDraw
     * @return self
     */
    public function setNDraw($nDraw)
    {
        $this->nDraw = $nDraw;
        return $this;
    }

    /**
     * Gets as exportInd
     *
     * Exportação indireta
     *
     * @return
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ProdAType\DetExportAType\ExportIndAType
     */
    public function getExportInd()
    {
        return $this->exportInd;
    }

    /**
     * Sets a new exportInd
     *
     * Exportação indireta
     *
     * @param
     * \NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ProdAType\DetExportAType\ExportIndAType
     * $exportInd
     * @return self
     */
    public function setExportInd(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\DetAType\ProdAType\DetExportAType\ExportIndAType $exportInd)
    {
        $this->exportInd = $exportInd;
        return $this;
    }


}

