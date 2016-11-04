<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
require_once '../../bootstrap.php';

use NFePHP\NFe\Ibpt;

$token = "<Aqui voce coloca seu token do IBPT>";
$cnpj = "<seu CNPJ>";
$ncm = "60063100"; //coloque o NCM do produto 
$uf = 'SP';//coloque o estado que deseja saber os dados
$extarif = 0;//indique o numero da exceção tarifaria, se existir ou deixe como zero 

//executa a consulta ao IBPT, o retorno é em JSON
$resp = Ibpt::getProduto($cnpj, $token, $uf, $ncm);

//caso não haja um retorno o erro e outras informações serão retornadas no JSON
echo "<pre>";
print_r(json_decode($resp)); //aqui mostra o retorno em um stdClass
echo "</pre>";

/*
 Em caso de SUCESSO irá retornar:
 
    stdClass Object
    (
        [Codigo] => 60063100
        [UF] => SP
        [EX] => 0
        [Descricao] => Outs.tecidos de malha de fibras sinteticas, crus ou branqueados
        [Nacional] => 13.45
        [Estadual] => 18
        [Importado] => 16.14
    )
  
Em caso de não encontrar o produto pelo NCM, ou qualquer outro erro na comunicação, retornará:
  
    stdClass Object
    (
        [error] => 
        [response] => "Produto não encontrado"
        [level] => Client ERROR
        [description] => Não encontrado
        [means] => O recurso requisitado não foi encontrado, mas pode ser disponibilizado novamente no futuro. As solicitações subsequentes pelo cliente são permitidas
    )
 */
