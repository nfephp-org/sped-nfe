<?php

namespace NFePHP\NFe\Lookup;

use RuntimeException;

/**
 * Exceção lançada quando uma consulta de pessoa falha: documento inválido,
 * recusa do provedor (status 0), erro de transporte HTTP ou resposta
 * inesperada.
 */
class LookupException extends RuntimeException
{
}
