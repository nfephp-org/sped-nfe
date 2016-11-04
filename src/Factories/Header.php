<?php

namespace NFePHP\NFe\Factories;

class Header
{
    /**
     * get
     * @param string $namespace
     * @param string $cUF
     * @param string $version
     * @return string
     */
    public static function get($namespace, $cUF, $version)
    {
        return "<nfeCabecMsg "
            . "xmlns=\"$namespace\">"
            . "<cUF>$cUF</cUF>"
            . "<versaoDados>$version</versaoDados>"
            . "</nfeCabecMsg>";
    }
}
