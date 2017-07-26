<?php

namespace App\Helpers\Fiscal;

class NfeProdServII
{
    private $Vbc;
    private $VdespAdu;
    private $Vii;
    private $vIof;

    /**
     * @return mixed
     */
    public function getVbc()
    {
        return $this->Vbc;
    }

    /**
     * @param mixed $Vbc
     */
    public function setVbc($Vbc)
    {
        $this->Vbc = $Vbc;
    }

    /**
     * @return mixed
     */
    public function getVdespAdu()
    {
        return $this->VdespAdu;
    }

    /**
     * @param mixed $VdespAdu
     */
    public function setVdespAdu($VdespAdu)
    {
        $this->VdespAdu = $VdespAdu;
    }

    /**
     * @return mixed
     */
    public function getVii()
    {
        return $this->Vii;
    }

    /**
     * @param mixed $Vii
     */
    public function setVii($Vii)
    {
        $this->Vii = $Vii;
    }

    /**
     * @return mixed
     */
    public function getVIof()
    {
        return $this->vIof;
    }

    /**
     * @param mixed $vIof
     */
    public function setVIof($vIof)
    {
        $this->vIof = $vIof;
    }


}