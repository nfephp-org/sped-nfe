<?php

namespace NFePHP\NFe\Traits;

use NFePHP\Common\DOMImproved as Dom;
use stdClass;
use DOMElement;
use RuntimeException;
use DOMException;

/**
 * @property  Dom $dom
 * @property DOMElement $infRespTec
 * @property string $csrt
 * @method equilizeParameters($std, $possible)
 */
trait TraitTagInfRespTec
{
    /**
     * Informações do Responsável técnico ZD01 pai A01
     * tag NFe/infNFe/infRespTec (opcional)
     * @throws DOMException
     */
    public function taginfRespTec(stdClass $std): DOMElement
    {
        $possible = [
            'CNPJ',
            'xContato',
            'email',
            'fone',
            'CSRT',
            'idCSRT'
        ];
        $std = $this->equilizeParameters($std, $possible);
        $identificador = 'ZD01 infRespTec -';
        $infRespTec = $this->dom->createElement("infRespTec");
        $this->dom->addChild(
            $infRespTec,
            "CNPJ",
            $std->CNPJ ?? '',
            true,
            "$identificador Informar o CNPJ da pessoa jurídica responsável pelo sistema "
            . "utilizado na emissão do documento fiscal eletrônico",
            true
        );
        $this->dom->addChild(
            $infRespTec,
            "xContato",
            $std->xContato,
            true,
            "$identificador Informar o nome da pessoa a ser contatada na empresa desenvolvedora "
            . "do sistema utilizado na emissão do documento fiscal eletrônico"
        );
        $this->dom->addChild(
            $infRespTec,
            "email",
            $std->email,
            true,
            "$identificador Informar o e-mail da pessoa a ser contatada na empresa "
            . "desenvolvedora do sistema."
        );
        $this->dom->addChild(
            $infRespTec,
            "fone",
            $std->fone,
            true,
            "$identificador Informar o telefone da pessoa a ser contatada na empresa "
            . "desenvolvedora do sistema."
        );
        if (!empty($std->CSRT) && !empty($std->idCSRT)) {
            $this->csrt = $std->CSRT;
            $this->dom->addChild(
                $infRespTec,
                "idCSRT",
                $std->idCSRT,
                true,
                "$identificador Identificador do CSRT utilizado para montar o hash do CSRT"
            );
            $this->dom->addChild(
                $infRespTec,
                "hashCSRT",
                $this->hashCSRT($std->CSRT),
                true,
                "$identificador hash do CSRT"
            );
        }
        $this->infRespTec = $infRespTec;
        return $infRespTec;
    }

    /**
     * Calcula hash sha1 retornando Base64Binary
     */
    protected function hashCSRT(string $CSRT): string
    {
        $comb = $CSRT . $this->chNFe;
        return base64_encode(sha1($comb, true));
    }
}
