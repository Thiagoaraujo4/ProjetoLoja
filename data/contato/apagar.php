<?php

/* 
Vamos construir os cabeçalhos para o trabalhar com a API
*/
header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");

#Esse cabeçalho define o método de envio como DELETE(sempre que for deleta), ou seja, como deleta
header("Access-Control-Allow-methods:DELETE");

#Define o tempo de espera a API. Neste caso é 1 minuto
header("Access-Control-Max-Age:3600");

include_once "../../config/database.php";

include_once "../../domain/contato.php";

$database = new Database();
$db = $database->getConnection();

$contato = new Contato($db);

/*
O cliente ira enviar os dados no formato json. Porém nós precisamos dos dados
no formato php para deletar em banco de dados. Para realizar essa coversão
iremos usar o comando json_decode. Assim que o cliente enviar os dados, estes são
lidos pela entrada php: e seu conteúdo é capturado e convertido para o formato php
*/

$data = json_decode(file_get_contents("php://input"));

#Vereficar se os campos estão com dados.

if(!empty($data->id)){
    $contato->id= $data->id;

    if($contato->Apagar()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"Contato apagado com sucesso!"));
}
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possivel apagar o contato."));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"você precisa passar todos os dados para apagar o contato"));
}

?>