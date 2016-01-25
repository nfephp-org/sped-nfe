<?php

namespace NFePHP\NFe\NFe\TNFeType\InfNFeAType;

/**
 * Class representing CobrAType
 */
class CobrAType
{

    /**
     * Dados da fatura
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\FatAType $fat
     */
    private $fat = null;

    /**
     * Dados das duplicatas NT 2011/004
     *
     * @property \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\DupAType[] $dup
     */
    private $dup = null;

    /**
     * Gets as fat
     *
     * Dados da fatura
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\FatAType
     */
    public function getFat()
    {
        return $this->fat;
    }

    /**
     * Sets a new fat
     *
     * Dados da fatura
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\FatAType $fat
     * @return self
     */
    public function setFat(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\FatAType $fat)
    {
        $this->fat = $fat;
        return $this;
    }

    /**
     * Adds as dup
     *
     * Dados das duplicatas NT 2011/004
     *
     * @return self
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\DupAType $dup
     */
    public function addToDup(\NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\DupAType $dup)
    {
        $this->dup[] = $dup;
        return $this;
    }

    /**
     * isset dup
     *
     * Dados das duplicatas NT 2011/004
     *
     * @param scalar $index
     * @return boolean
     */
    public function issetDup($index)
    {
        return isset($this->dup[$index]);
    }

    /**
     * unset dup
     *
     * Dados das duplicatas NT 2011/004
     *
     * @param scalar $index
     * @return void
     */
    public function unsetDup($index)
    {
        unset($this->dup[$index]);
    }

    /**
     * Gets as dup
     *
     * Dados das duplicatas NT 2011/004
     *
     * @return \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\DupAType[]
     */
    public function getDup()
    {
        return $this->dup;
    }

    /**
     * Sets a new dup
     *
     * Dados das duplicatas NT 2011/004
     *
     * @param \NFePHP\NFe\NFe\TNFeType\InfNFeAType\CobrAType\DupAType[] $dup
     * @return self
     */
    public function setDup(array $dup)
    {
        $this->dup = $dup;
        return $this;
    }


}

