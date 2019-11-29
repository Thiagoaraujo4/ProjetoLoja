<?php

class Cliente{
    public $id;
    public $nome;
    public $cpf;
    public $id_endereco;
    public $id_contato;
    public $id_usuario;
    

    public function __construct($db){
        $this->conexao = $db;
    }
    /*
    Funçao listar para selecionar todos os clientes cadastrados no banco de dados. Essa função retorna uma 
    lista com todos os dados.
    */ 
    public function listar(){
        #Seleciona todos os campos da tabela cliente
        $query = "select * from cliente";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta select que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do cliente a camada data.p
        return $stmt;
    }


    public function pesquisar_id(){
        #Seleciona todos os campos da tabela cliente
        $query = "select * from cliente where id=?";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta select que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);

        $stmt->bindParam(1,$this->id);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do cliente a camada data.p
        return $stmt;
    }

    public function pesquisar_nome(){
        #Seleciona todos os campos da tabela cliente
        $query = "select * from cliente where like ?";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta select que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);

        $stmt->bindParam(1,$this->nome);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do cliente a camada data.p
        return $stmt;
    }

/* 
Funçao para cadastrar os cliente no banco de dados
*/
public function cadastro(){
    $query = "insert into cliente set nome=:n, cpf=:c, id_endereco=:e, id_contato=:t, id_usuario=:u";

    $stmt = $this->conexao->prepare($query);

    /*Foram utilizadas 2 funções para tratar os dados que estão vindo do usuário 
    para a api.
    strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
    htmlspecialchar -> retira as aspas e os 2 pontos que vem do formato 
    json para o cadastrar em banco */

    $this->nome = htmlspecialchars(strip_tags($this->nome));
    $this->cpf = htmlspecialchars(strip_tags($this->cpf));
    $this->id_endereco = htmlspecialchars(strip_tags($this->id_endereco));
    $this->id_contato = htmlspecialchars(strip_tags($this->id_contato));
    $this->id_usuario = htmlspecialchars(strip_tags($this->id_usuario));
    


    $stmt->bindParam(":n",$this->nome);
    $stmt->bindParam(":c",$this->cpf);
    $stmt->bindParam(":e",$this->id_endereco);
    $stmt->bindParam(":t",$this->id_contato);
    $stmt->bindParam(":u",$this->id_usuario);
   
    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function alterarCliente(){
    $query = "update cliente set nome=:n, cpf=:c, id_endereco=:e, id_contato=:t, id_usuario=:u where id=:i";

    $stmt = $this->conexao->prepare($query);

   
    $stmt->bindParam(":n",$this->nome);
    $stmt->bindParam(":c",$this->cpf);
    $stmt->bindParam(":e",$this->id_endereco);
    $stmt->bindParam(":t",$this->id_contato);
    $stmt->bindParam(":u",$this->id_usuario);
    $stmt->bindParam(":i",$this->id);



    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
    
}

public function apagar(){
    $query = "delete from cliente where id=?";

    $stmt=$this->conexao->prepare($query);

    $stmt ->bindParam(1,$this->id);

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

}
?>
