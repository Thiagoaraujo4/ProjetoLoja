<?php
/* Este cabeçalho permite acesso a listagem de contato 
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
 O arquivo contato.php foi incluido para que a classe contato fosse utilizada. vale 
lembrar que esta classe possui o CRUD para o contato.
 */

include_once "../../domain/contato.php";

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
Instância da classe Usuário e, portanto, criação do objeto chamado $contato.
Isso fará com que todas as funções que estão dentro da classe Uauraio sejam transferidas
para o obejto $contato.
Durante a instância foi passado com paramêtro a variável $db que possui a comunicação com 
o banco de dados e também a variável conexao. Utilizada para o uso dos comandos de CRUD.

*/

$contato = new Contato($db);


/*
A variável  $stmt(Statement->sentenção) foi criada para guardar o retorno da consulta que está na função listar.
Dentro da função listar() temos uma consulta no formato sql que seleciona todos os usuário("Select * from contato")
*/
$stmt = $contato->listar();

/*
Se a consulta retornar uma quantidade maior que 0(zero), então será construido um array com os dados dos 
usuários. Caso contrário será exibido uma mensagem que não contatos cadastrados.
*/

if($stmt->rowCount() > 0){

    /*
    Para organizar os contatos cadastrados em banco e exibi-los em tela, foi criado uma array com o nome de
    saida e assim guardar todos contatos.
    */

   
    $contato_arr["saida"]=array();

    /*
    A estrutura while(enquanto) realizar a busca e todos os usarios cadastrados até cheagr ao final
    da tabela e tras os dados para fetch array organizar em formato de array.
    Assim será mais fácil de adicionar no array de contatos para ser apresentado ao contato.
    */
    while($linha = $stmt->fetch(PDO::FETCH_ASSOC)){
        /*
        O comando extract é capaz de separar de forma mais simples os
        campos da tabela contatos.
        */

        extract($linha);
        /*
        Pegar um campo por vez do comando extract e adicionar em um array de itens, pois será assim que os contatos
        serão  tratados, um contato por vez com seus respectivos dados.
        */

        $array_item = array(
            "id"=>$id,
            "telefone"=>$telefone,
            "email"=>$email,
        );

        /*
        Pegar um item gerado pelo array_item e adicionar a saida, que também é um array.
        array_push é um comando em que você pode adicionar algo em um array. Assim estamos adicionando 
        ao contato_arr[saida] um item que é um contato com seus respectivos dados.
        */

        array_push($contato_arr["saida"],$array_item);
    }

    /*
    O comando header(cabeçalho) responde via HTTP o status code 200 que representa sucesso na 
    consulta de dados.
    */
header("HTTP/1.0 200");

/*
Pegamos o array contato_arr que foi construido em php com os dados dos contatos
e convertemos para o formato json para exibir ao cliente requisitante.
*/
echo json_encode($contato_arr);


}
else{

    /*
    O comando header(cabeçalho) responde os cliente o status code 400(badrequest)
    caso não haja contatos cadastrados no banco. Junto ao status code será exibida 
    a mensagem "mensagem: Não ha usuários cadastrados" que será mostrado por meio 
    do comando json_encode
    */
    header("HTTP/1.0 400");
    echo json_encode(array("mensagem"=>"Não há contato cadastrados"));

}
?>