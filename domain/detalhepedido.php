<?php

class Detalhepedido{
    public $id;
    public $id_pedido;
    public $id_produto;
    public $quantidade;
    
    
    

    public function __construct($db){
        $this->conexao = $db;
    }
    /*
    Funçao listar para selecionar todos os detalhepedidos cadastrados no banco de dados. Essa função retorna uma 
    lista com todos os dados.
    */ 
    public function listar(){
        #Seleciona todos os campos da tabela detalhepedido
        $query = "select * from detalhepedido";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta select que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do detalhepedido a camada data.p
        return $stmt;
    }

/* 
Funçao para cadastrar os detalhepedido no banco de dados
*/
public function cadastro(){
    $query = "insert into detalhepedido set id_pedido=:p, id_produto=:pr, quantidade=:q";

    $stmt = $this->conexao->prepare($query);

    /*Foram utilizadas 2 funções para tratar os dados que estão vindo do usuário 
    para a api.
    strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
    htmlspecialchar -> retira as aspas e os 2 pontos que vem do formato 
    json para o cadastrar em banco */

    $this->id_pedido = htmlspecialchars(strip_tags($this->id_pedido));
    $this->id_produto = htmlspecialchars(strip_tags($this->id_produto));
    $this->quantidade = htmlspecialchars(strip_tags($this->quantidade));

    $stmt->bindParam(":p",$this->id_pedido);
    $stmt->bindParam(":pr",$this->id_produto);
    $stmt->bindParam(":q",$this->quantidade);
    
    

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function alterarDetalhepedido(){
    $query = "update detalhepedido set id_pedido=:p, id_produto=:pr, quantidade=:q where id=:i";

    $stmt = $this->conexao->prepare($query);

    $stmt->bindParam(":p",$this->id_pedido);
    $stmt->bindParam(":pr",$this->id_produto);
    $stmt->bindParam(":q",$this->quantidade);
    $stmt->bindParam(":i",$this->id);



    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
    
}

public function apagar(){
    $query = "delete from detalhepedido where id=?";

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
