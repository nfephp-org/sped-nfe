<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing SignatureType
 *
 *
 * XSD Type: SignatureType
 */
class SignatureType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \NFePHP\NFe\NFe\SignedInfoType $signedInfo
     */
    private $signedInfo = null;

    /**
     * @property \NFePHP\NFe\NFe\SignatureValueType $signatureValue
     */
    private $signatureValue = null;

    /**
     * @property \NFePHP\NFe\NFe\KeyInfoType $keyInfo
     */
    private $keyInfo = null;

    /**
     * Gets as id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets a new id
     *
     * @param string $id
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gets as signedInfo
     *
     * @return \NFePHP\NFe\NFe\SignedInfoType
     */
    public function getSignedInfo()
    {
        return $this->signedInfo;
    }

    /**
     * Sets a new signedInfo
     *
     * @param \NFePHP\NFe\NFe\SignedInfoType $signedInfo
     * @return self
     */
    public function setSignedInfo(\NFePHP\NFe\NFe\SignedInfoType $signedInfo)
    {
        $this->signedInfo = $signedInfo;
        return $this;
    }

    /**
     * Gets as signatureValue
     *
     * @return \NFePHP\NFe\NFe\SignatureValueType
     */
    public function getSignatureValue()
    {
        return $this->signatureValue;
    }

    /**
     * Sets a new signatureValue
     *
     * @param \NFePHP\NFe\NFe\SignatureValueType $signatureValue
     * @return self
     */
    public function setSignatureValue(\NFePHP\NFe\NFe\SignatureValueType $signatureValue)
    {
        $this->signatureValue = $signatureValue;
        return $this;
    }

    /**
     * Gets as keyInfo
     *
     * @return \NFePHP\NFe\NFe\KeyInfoType
     */
    public function getKeyInfo()
    {
        return $this->keyInfo;
    }

    /**
     * Sets a new keyInfo
     *
     * @param \NFePHP\NFe\NFe\KeyInfoType $keyInfo
     * @return self
     */
    public function setKeyInfo(\NFePHP\NFe\NFe\KeyInfoType $keyInfo)
    {
        $this->keyInfo = $keyInfo;
        return $this;
    }


}

