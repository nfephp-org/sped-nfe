<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing X509DataType
 *
 *
 * XSD Type: X509DataType
 */
class X509DataType
{

    /**
     * @property mixed $x509Certificate
     */
    private $x509Certificate = null;

    /**
     * Gets as x509Certificate
     *
     * @return mixed
     */
    public function getX509Certificate()
    {
        return $this->x509Certificate;
    }

    /**
     * Sets a new x509Certificate
     *
     * @param mixed $x509Certificate
     * @return self
     */
    public function setX509Certificate($x509Certificate)
    {
        $this->x509Certificate = $x509Certificate;
        return $this;
    }


}

