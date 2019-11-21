<?php
/* Este cabeçalho permite acesso a listagem de usuario 
com diversas origens por isso estamos usando o "*"(asterisco) para essa permissao que sera 
para http, https, file, ftp */
header("Access-Control-Allow-Origin:*");

/* Vamos definir os formatos de dados que o usario ira enviar a api.
Este formato sera do tipo JSON( Javascript On Notation)  */

header("Content-Type: application/json;charset=utf-8");

/*
Abaixo estamos incluindo o arquivo databa.php que possui 
a classe Database com a conexão com o banco de dados.
*/

include_once "../../config/database.php";
/*
 O arquivo usuario.php foi incluido para que a classe Usuario fosse utilizada. vale 
lembrar que esta classe possui o CRUD para o usuario.
 */

include_once "../../domain/usuario.php";

/*
Criamos um objeto chamado $database. É uma instância da classe Database.
Quando usamos o termo new, estamos criando uma instância, ou seja,
um objeto da classe Database. Isso nos dará acesso a todos os dados da classe Database.
*/

$database = new Database();

/*
Executamos a função getConnection que estabelece a conexão com o banco de dados. E retorna 
essa conexão realiazada para a variável $db.

*/
$db = $database->getConnection();

/*
Instância da classe Usuário e, portanto, criação do objeto chamado $usuario.
Isso fará com que todas as funções que estão dentro da classe Uauraio sejam transferidas
para o obejto $usuario.
Durante a instância foi passado com paramêtro a variável $db que possui a comunicação com 
o banco de dados e também a variável conexao. Utilizada para o uso dos comandos de CRUD.

*/

$usuario = new Usuario($db);


/*
A variável  $stmt(Statement->sentenção) foi criada para guardar o retorno da consulta que está na função listar.
Dentro da função listar() temos uma consulta no formato sql que seleciona todos os usuário("Select * from usuario")
*/
$stmt = $usuario->listar();

/*
Se a consulta retornar uma quantidade maior que 0(zero), então será construido um array com os dados dos 
usuários. Caso contrário será exibido uma mensagem que não usuarios cadastrados.
*/

if($stmt->rowCount() > 0){

    /*
    Para organizar os usuarios cadastrados em banco e exibi-los em tela, foi criado uma array com o nome de
    saida e assim guardar todos usuarios.
    */

   
    $usuario_arr["saida"]=array();

    /*
    A estrutura while(enquanto) realizar a busca e todos os usarios cadastrados até cheagr ao final
    da tabela e tras os dados para fetch array organizar em formato de array.
    Assim será mais fácil de adicionar no array de usuarios para ser apresentado ao usuario.
    */
    while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
        /*
        O comando extract é capaz de separar de forma mais simples os
        campos da tabela usuarios.
        */

        extract($linha);
        /*
        Pegar um campo por vez do comando extract e adicionar em um array de itens, pois será assim que os usuarios
        serão  tratados, um usuario por vez com seus respectivos dados.
        */

        $array_item = array(
            "id"=>$id,
            "nomeusuario"=>$nomeusuario,
            "senha"=>$senha,
            "foto"=>$foto
        );

        /*
        Pegar um item gerado pelo array_item e adicionar a saida, que também é um array.
        array_push é um comando em que você pode adicionar algo em um array. Assim estamos adicionando 
        ao usuario_arr[saida] um item que é um usuario com seus respectivos dados.
        */

        array_push($usuario_arr["saida"],$array_item);
    }

    /*
    O comando header(cabeçalho) responde via HTTP o status code 200 que representa sucesso na 
    consulta de dados.
    */
header("HTTP/1.0 200");

/*
Pegamos o array usuario_arr que foi construido em php com os dados dos usuarios
e convertemos para o formato json para exibir ao cliente requisitante.
*/
echo json_encode($usuario_arr);


}
else{
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Não há usuário cadastrados"));

}
?>