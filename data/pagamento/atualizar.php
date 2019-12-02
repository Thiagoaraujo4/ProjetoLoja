<?php

/*
Vamos construir os cabeçalhos para o trabalho com a API
*/
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");

#Esse cabeçalho e define o metedo de envio com PUT(sempre que dor ALTERAR algo), ou seja, como atualizar
header("Access-Control-Allow-Methods:PUT");

#Define o tempo de espra da API. Neste caso 1 minuto
header("Access-Control-MAx-Age:3600");

include_once "../../config/database.php";

include_once "../../domain/pagamento.php";

$database = new Database();
$db = $database->getConnection();

$pagamento = new Pagamento($db);

/*
O cliente irá enviar os dados no formato json. Porém nós precisamos dos dados
no formato php para atualizar em banco de dados. Para realizar essa conversão 
iremos usar o comando json_decode. Assim que o cliente enviar os dados, estes são
lidos pela entrada php: e seu conteúdo é capturado e convertido para o formato php
*/

$data = json_decode(file_get_contents("php://input"));

#Verificar se os campos estão com dados.

if(!empty($data->id_pedido) && !empty($data->valor) && !empty($data->formapagamento) && !empty($data->descricao) && !empty($data->numeroparcelas) && !empty($data->valorparcela) && !empty($data->id)){
    
    $pagamento->id_pedido = $data->id_pedido;
    $pagamento->valor = $data->valor;
    $pagamento->formapagamento = $data->formapagamento;
    $pagamento->descricao = $data->descricao;
    $pagamento->numeroparcelas = $data->numeroparcelas;
    $pagamento->valorparcela = $data->valorparcela;
    $pagamento->id= $data->id;
    

    if($pagamento->alterarPagamento()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"pagamento atualizada com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possivel atualizar ."));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa passar todos os dados para alterar o pagamento"));
}

?>