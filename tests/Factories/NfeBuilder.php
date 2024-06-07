<?php

namespace NFePHP\NFe\Tests\Factories;

class NfeBuilder
{
    public static function tagIde(): \stdClass
    {
        $std = new \stdClass();
        $std->cUF = 35;
        $std->cNF = '80070008';
        $std->natOp = 'VENDA';
        $std->mod = 55;
        $std->serie = 1;
        $std->nNF = 2;
        $std->dhEmi = '2015-02-19T13:48:00-02:00';
        $std->dhSaiEnt = null;
        $std->tpNF = 1;
        $std->idDest = 1;
        $std->cMunFG = 3518800;
        $std->tpImp = 1;
        $std->tpEmis = 1;
        $std->cDV = 2;
        $std->tpAmb = 2;
        $std->finNFe = 1;
        $std->indFinal = 0;
        $std->indPres = 0;
        $std->indIntermed = null;
        $std->procEmi = 0;
        $std->verProc = '3.10.31';
        $std->dhCont = null;
        $std->xJust = null;

        return $std;
    }

    public static function tagEmitente(): \stdClass
    {
        $std = new \stdClass();
        $std->xNome = 'Fulano de Tal';
        $std->xFant = 'Nome Fantasia Fulano';
        $std->IE = '123456';
        //$std->IEST = null;
        //$std->IM = null;
        //$std->CNAE = null;
        $std->CRT = 1;
        $std->CNPJ = "08489068000198";

        return $std;
    }

    public static function tagDest(): \stdClass
    {
        $std = new \stdClass();
        $std->xNome = 'Fulano de Tal';
        $std->indIEDest = 1;
        $std->xFant = 'Nome Fantasia Fulano';
        $std->IE = '123456';
        $std->email = 'email@empresa.com.br';
        $std->CNPJ = "08489068000198";

        return $std;
    }
}
