<?php

/*
Vamos construir os cabeçalhos para o trabalho a api
*/

header("Access-Control-Allow-Origin:*");
header("Content-Type: application/json; charset=utf-8");

#Esse cabeçalho define o metodo de envio com POST(sempre que for cadastrar),ou seja, como cadastro
header("Access-Control-Allow-Methods:POST");

#Define o tempo de espera da api. Neste caso é de  1 minuto.
header("Access-Control-Max-Age:3600");

include_once "../../config/database.php";

include_once "../../domain/usuario.php";

$database = new Database();
$db = $database->getConnection();

$usuario = new Usuario($db);
/*
O cliente ira enviar os dados no formato json. Porém nós precisamos os dados no formato php,
 para cadastrar em banco de dados. Para realizar essa conversão iremos usar o banco json_decode.
 Assim o cliente enviar os dados, este são lidos pela entrada php: e seu conteúdo é captarado e 
 convertido para o formato php.
*/
$data = json_decode(file_get_contents("php://input"));

#Verificar se os campos estão com dados.
if(!empty($data->nomeusuario) && !empty($data->senha) && !empty($data->foto)){
    $usuario->nomeusuario = $data->nomeusuario;
    $usuario->senha = $data->senha;
    $usuario->foto = $data->foto;

    if($usuario->cadastro()){
        header("HTTP/1.0 201");
        echo json_encode(array("mensagem"=>"Usuário cadastrado com sucesso! "));
    }
    else{
        header("HTTP/1.0 400");
        echo json_encode(array("mensagem"=>"Não foi possível cadastrar. "));
    }
}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Você precisa passar todos os dados para cadastrar "));
}

?>