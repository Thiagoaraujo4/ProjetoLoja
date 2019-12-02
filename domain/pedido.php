<?php

class Pedido{
    public $id;
    public $id_pedido;
   
   
    

    public function __construct($db){
        $this->conexao = $db;
    }
    /*
    Funçao listar para selecionar todos os pedidos cadastrados no banco de dados. Essa função retorna uma 
    lista com todos os dados.
    */ 
    public function listar(){
        #Seleciona todos os campos da tabela pedido
        $query = "select * from pedido";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta select que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do pedido a camada data.p
        return $stmt;
    }

/* 
Funçao para cadastrar os pedido no banco de dados
*/
public function cadastro(){
    $query = "insert into pedido set id_cliente=:c";

    $stmt = $this->conexao->prepare($query);

    /*Foram utilizadas 2 funções para tratar os dados que estão vindo do usuário 
    para a api.
    strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
    htmlspecialchar -> retira as aspas e os 2 pontos que vem do formato 
    json para o cadastrar em banco */

    $this->id_cliente = htmlspecialchars(strip_tags($this->id_cliente));
   


    $stmt->bindParam(":c",$this->id_cliente);

   
    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function alterarPedido(){
    $query = "update pedido set id_cliente=:c where id=:i";

    $stmt = $this->conexao->prepare($query);

    $stmt->bindParam(":i",$this->id);
    $stmt->bindParam(":c",$this->id_cliente);
    


    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
    
}

public function apagar(){
    $query = "delete from pedido where id=?";

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
