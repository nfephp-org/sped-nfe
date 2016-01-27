<?php

namespace NFePHP\NFe\NFe\TNFe;

/**
 * Class representing InfNFeSupl
 */
class InfNFeSupl
{

    /**
     * Texto com o QR-Code impresso no DANFE NFC-e
     *
     * @property string $qrCode
     */
    private $qrCode = null;

    /**
     * Gets as qrCode
     *
     * Texto com o QR-Code impresso no DANFE NFC-e
     *
     * @return string
     */
    public function getQrCode()
    {
        return $this->qrCode;
    }

    /**
     * Sets a new qrCode
     *
     * Texto com o QR-Code impresso no DANFE NFC-e
     *
     * @param string $qrCode
     * @return self
     */
    public function setQrCode($qrCode)
    {
        $this->qrCode = $qrCode;
        return $this;
    }


}

