<?php

namespace NFePHP\NFe\NFe;

/**
 * Class representing SignedInfoType
 *
 *
 * XSD Type: SignedInfoType
 */
class SignedInfoType
{

    /**
     * @property string $id
     */
    private $id = null;

    /**
     * @property \NFePHP\NFe\NFe\SignedInfoType\CanonicalizationMethod
     * $canonicalizationMethod
     */
    private $canonicalizationMethod = null;

    /**
     * @property \NFePHP\NFe\NFe\SignedInfoType\SignatureMethod $signatureMethod
     */
    private $signatureMethod = null;

    /**
     * @property \NFePHP\NFe\NFe\ReferenceType $reference
     */
    private $reference = null;

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
     * Gets as canonicalizationMethod
     *
     * @return \NFePHP\NFe\NFe\SignedInfoType\CanonicalizationMethod
     */
    public function getCanonicalizationMethod()
    {
        return $this->canonicalizationMethod;
    }

    /**
     * Sets a new canonicalizationMethod
     *
     * @param \NFePHP\NFe\NFe\SignedInfoType\CanonicalizationMethod
     * $canonicalizationMethod
     * @return self
     */
    public function setCanonicalizationMethod(\NFePHP\NFe\NFe\SignedInfoType\CanonicalizationMethod $canonicalizationMethod)
    {
        $this->canonicalizationMethod = $canonicalizationMethod;
        return $this;
    }

    /**
     * Gets as signatureMethod
     *
     * @return \NFePHP\NFe\NFe\SignedInfoType\SignatureMethod
     */
    public function getSignatureMethod()
    {
        return $this->signatureMethod;
    }

    /**
     * Sets a new signatureMethod
     *
     * @param \NFePHP\NFe\NFe\SignedInfoType\SignatureMethod $signatureMethod
     * @return self
     */
    public function setSignatureMethod(\NFePHP\NFe\NFe\SignedInfoType\SignatureMethod $signatureMethod)
    {
        $this->signatureMethod = $signatureMethod;
        return $this;
    }

    /**
     * Gets as reference
     *
     * @return \NFePHP\NFe\NFe\ReferenceType
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Sets a new reference
     *
     * @param \NFePHP\NFe\NFe\ReferenceType $reference
     * @return self
     */
    public function setReference(\NFePHP\NFe\NFe\ReferenceType $reference)
    {
        $this->reference = $reference;
        return $this;
    }


}

