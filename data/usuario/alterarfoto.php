<?php

/*
Vamos construir os cabeçalhos para o trabalho com a API
*/

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");

#Esse cabeçalho define o metodo de envio com PUT(sempre que for ALTERAR algo), ou seja, como atualizar
header("Access-Control-Allow-Methods:PUT");

#Define o tempo de espera da API. Neste caso é 1 minuto
header("Access-Control-Max-Age:3600");

include_once "../../config/database.php";

include_once "../../domain/usuario.php";

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);

/*
O cliente irá enviar os dados no formato json. Porém nós precisamos do dados
no formato php para atualizar em banco de dados. Para realizar essa conversão
iremos usar o comando json_decode. Assim que o cliente enviar os dados, estes são
lidos pela entrada php: e seu conteúdo é capturado e convertido para formato php
*/

$data = json_decode(file_get_contents("php://input"));

#Vereficar se os campos estão com dados.

if(!empty($data->foto) && !empty($data->id)){
    $usuario->id= $data->id;
    $usuario->foto = $data->foto;

    if($usuario->alterarfoto()){
        header("HTTP/1.0 200");
        echo json_encode(array("mensagem"=>"Foto do usuário atualizada com sucesso!"));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possivel atualizar a foto. "));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa passar todos os dados para alterar a foto"));
}
?>