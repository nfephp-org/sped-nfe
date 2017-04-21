# Complements::class

Esta classe possibilita a inclusão dos protocolos de autorização, denegação ou cancelamento aos documentos eletrônicos.

Devem ser protocolados os seguintes documentos, para terem validade juridica:

- Nota Fiscal
- Solicitação de Inutilização de faixa de numeros de notas
- Eventos (cancelamentos, cartas de correção, etc.)

Adicionalmente, esta classe também permite a inclusão de TAGs especiais referentes a requisitos de montadoras da ANFAVEA.

E também permite a "marcação" de NFe como cancelada, este não é um requisito oficial, mas eu mesmo utilizado para garantir que ao cancelar a propria NFe contenha essa informação evitando enganos na visualização ou uso posteiror do XML da NFe.

## Métodos

public static function toAuthorize($request, $response)

public static function b2bTag($nfe, $b2b, $tagB2B = 'NFeB2BFin')

public static function cancelRegister($nfe, $cancelamento)
