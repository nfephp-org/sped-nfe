<?php

namespace NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod;

/**
 * Class representing DetExport
 */
class DetExport
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
     * @property \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport\ExportInd $exportInd
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
     * @return \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport\ExportInd
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
     * @param \NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport\ExportInd $exportInd
     * @return self
     */
    public function setExportInd(\NFePHP\NFe\NFe\TNFe\InfNFe\Det\Prod\DetExport\ExportInd $exportInd)
    {
        $this->exportInd = $exportInd;
        return $this;
    }


}

