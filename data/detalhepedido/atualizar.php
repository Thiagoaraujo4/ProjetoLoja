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

include_once "../../domain/detalhepedido.php";

$database = new Database();
$db = $database->getConnection();

$detalhepedido = new Detalhepedido($db);

/*
O cliente irá enviar os dados no formato json. Porém nós precisamos dos dados
no formato php para atualizar em banco de dados. Para realizar essa conversão 
iremos usar o comando json_decode. Assim que o cliente enviar os dados, estes são
lidos pela entrada php: e seu conteúdo é capturado e convertido para o formato php
*/

$data = json_decode(file_get_contents("php://input"));

#Verificar se os campos estão com dados.

if(!empty($data->id_pedido) && !empty($data->id_produto) && !empty($data->quantidade)){
    
    $detalhepedido->id_pedido = $data->id_pedido;
    $detalhepedido->id_produto = $data->id_produto;
    $detalhepedido->quantidade = $data->quantidade;
    $detalhepedido->id= $data->id;
    

    if($detalhepedido->alterarDetalhepedido()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"detalhepedido atualizada com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possivel atualizar o detalhepedido ."));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa passar todos os dados para alterar o detalhepedido"));
}

?>