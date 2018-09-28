# Tag PAG

## Layout 4.00

> Uma UNICA TAG PAG
> E até 100 detPag

```xml
<pag>
    <detPag>
        <indPag>0</indPag>
        <tPag>01</tPag>
        <vPag>100.00</vPag>
    </detPag>
    <detPag>
        <indPag>0</indPag>
        <tPag>03</tPag>
        <vPag>100.00</vPag>
        <card>
            <tpIntegra>1</tpIntegra>
            <CNPJ>05577343000137</CNPJ>
            <tBand>02</tBand>
            <cAut>20010afsct</cAut>
        </card>
    <detPag>
    <detPag>
        <indPag>0</indPag>
        <tPag>03</tPag>
        <vPag>100.00</vPag>
        <card>
            <tpIntegra>1</tpIntegra>
            <CNPJ>31551765000143</CNPJ>
            <tBand>01</tBand>
            <cAut>akkakaj87272727</cAut>
        </card>
    <detPag>
    <vTroco>1.00</vTroco>
</pag>
```

Montagem com a classe Make::class

```php

$std = new stdClass();
$std->vTroco = '1.00'; //aqui pode ter troco
$elem = $nfe->tagpag($std);

/* PRIMEIRA PARTE DO PAGAMENTO DINHEIRO */
$std = new stdClass();
$std->tPag = '01';
$std->vPag = 100.00;
$std->indPag = 0; //pagamento a vista
$elem = $nfe->tagdetPag($std); //para o pagamento com dinheiro

/* SEGUNDA PARTE DO PAGAMENTO MASTERCARD CREDITO */
$std = new stdClass();
$std->tPag = '03';
$std->vPag = 100.00;
$std->CNPJ = '05577343000137';
$std->tBand = '02';
$std->cAut = '20010afsct';
$std->tpIntegra = 1;
$std->indPag = 0; //pagamento a vista
$elem = $nfe->tagdetPag($std); //pagamento com o Mastercard

/* TERCEIRA PARTE DO PAGAMENTO VISA CREDITO */
$std = new stdClass();
$std->tPag = '03';
$std->vPag = 100.00;
$std->CNPJ = '31551765000143';
$std->tBand = '01';
$std->cAut = 'akkakaj87272727';
$std->tpIntegra = 1;
$std->indPag = 0; //pagamento a vista
$elem = $nfe->tagdetPag($std); //pagamento com o Visa

```