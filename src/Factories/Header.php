<?php

namespace NFePHP\NFe\Factories;

/**
 * Class responsible for the assembly of SOAPHeader, will no longer exist
 * in version 4.0 of the SEFAZ layout.
 * This class is valid only until 11/2017 after that date becomes OBSOLETE
 * and if it is used it will cause communication failure.
 */

class Header
{
    /**
     * Return header
     */
    public static function get(string $namespace, int $cUF, string $version): string
    {
        return "<nfeCabecMsg "
            . "xmlns=\"$namespace\">"
            . "<cUF>$cUF</cUF>"
            . "<versaoDados>$version</versaoDados>"
            . "</nfeCabecMsg>";
    }
}
