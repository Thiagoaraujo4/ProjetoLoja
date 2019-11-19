<?php
/*
A Classe Database irá permitir a comunicação com o banco de dados.
Nesta classe teremos a string de conexão com o banco, bem como:
- Nome de usuário: "root"
- Senha: "" -> vazio nesse caso
- Banco de dados: dbloja
- Porta de comunicação: 3306
- Servidor: localhost ou IP(Local ou remoto)
E uma variavel para a conexão com o banco que sera usada em outros
arquivos e, porntanto, será declarada com o modificador public
*/

class Database{

    public $conexao;
    public function getConnection(){
        try{
            $conexao = new PDO("mysql:host=localhost;port=3306;dbname=dbloja"."root","");
            #Definir o tipo de caracter para o banco com utf8 que é caracter acentuado
            $conexao->exec("set name utf8");

        }
        catch(PDOexception $e){
          echo "Erro ao tentar estabelecer a conexão com o banco de dados. ".$e->getMessage();
        }
        return $conexao;
        
    }
}

?>