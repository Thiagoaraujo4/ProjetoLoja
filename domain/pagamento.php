<?php

class Pagamento{
    public $id;
    public $id_pedido;
    public $valor;
    public $formapagamento;
    public $descricao;
    public $numeroparcelas;
    public $valorparcela;
    
    

    public function __construct($db){
        $this->conexao = $db;
    }
    /*
    Funçao listar para selecionar todos os pagamentos cadastrados no banco de dados. Essa função retorna uma 
    lista com todos os dados.
    */ 
    public function listar(){
        #Seleciona todos os campos da tabela pagamento
        $query = "select * from pagamento";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta select que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do pagamento a camada data.p
        return $stmt;
    }

/* 
Funçao para cadastrar os pagamento no banco de dados
*/
public function cadastro(){
    $query = "insert into pagamento set id_pedido=:p, valor=:v, formapagamento=:f, descricao=:d, numeroparcelas=:n, valorparcela=:vp";

    $stmt = $this->conexao->prepare($query);

    /*Foram utilizadas 2 funções para tratar os dados que estão vindo do usuário 
    para a api.
    strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
    htmlspecialchar -> retira as aspas e os 2 pontos que vem do formato 
    json para o cadastrar em banco */

    $this->id_pedido = htmlspecialchars(strip_tags($this->id_pedido));
    $this->valor = htmlspecialchars(strip_tags($this->valor));
    $this->formapagamento = htmlspecialchars(strip_tags($this->formapagamento));
    $this->descricao = htmlspecialchars(strip_tags($this->descricao));
    $this->numeroparcelas = htmlspecialchars(strip_tags($this->numeroparcelas));
    $this->valorparcela = htmlspecialchars(strip_tags($this->valorparcela));

    


    $stmt->bindParam(":p",$this->id_pedido);
    $stmt->bindParam(":v",$this->valor);
    $stmt->bindParam(":f",$this->formapagamento);
    $stmt->bindParam(":d",$this->descricao);
    $stmt->bindParam(":n",$this->numeroparcelas);
    $stmt->bindParam(":vp",$this->valorparcela);
    

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function alterarPagamento(){
    $query = "update pagamento set id_pedido=:p, valor=:v, formapagamento=:f, descricao=:d, numeroparcelas=:n, valorparcela=:vp where id=:i";

    $stmt = $this->conexao->prepare($query);

   
    $stmt->bindParam(":p",$this->id_pedido);
    $stmt->bindParam(":v",$this->valor);
    $stmt->bindParam(":f",$this->formapagamento);
    $stmt->bindParam(":d",$this->descricao);
    $stmt->bindParam(":n",$this->numeroparcelas);
    $stmt->bindParam(":vp",$this->valorparcela);
    $stmt->bindParam(":i",$this->id);



    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
    
}

public function apagar(){
    $query = "delete from pagamento where id=?";

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
