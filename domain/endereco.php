<?php

class Endereco{
    public $id;
    public $logradoura;
    public $numero;
    public $complemento;
    public $bairro;
    public $cep;

    public function __construct($db){
        $this->conexao = $db;
    }
    /*
    Funçao listar para selecionar todos os enderecos cadastrados no banco de dados. Essa função retorna uma 
    lista com todos os dados.
    */ 
    public function listar(){
        #Seleciona todos os campos da tabela endereco
        $query = "select * from endereco";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta select que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do endereco a camada data.p
        return $stmt;
    }

/* 
Funçao para cadastrar os endereco no banco de dados
*/
public function cadastro(){
    $query = "insert into endereco set logradoura=:l, numero=:n, complemento=:c, bairro=:b, cep=:p";

    $stmt = $this->conexao->prepare($query);

    /*Foram utilizadas 2 funções para tratar os dados que estão vindo do usuário 
    para a api.
    strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
    htmlspecialchar -> retira as aspas e os 2 pontos que vem do formato 
    json para o cadastrar em banco */

    $this->logradoura = htmlspecialchars(strip_tags($this->logradoura));
    $this->numero = htmlspecialchars(strip_tags($this->numero));
    $this->complemento = htmlspecialchars(strip_tags($this->complemento));
    $this->bairro = htmlspecialchars(strip_tags($this->bairro));
    $this->cep = htmlspecialchars(strip_tags($this->cep));



    $stmt->bindParam(":l",$this->logradoura);
    $stmt->bindParam(":n",$this->numero);
    $stmt->bindParam(":c",$this->complemento);
    $stmt->bindParam(":b",$this->bairro);
    $stmt->bindParam(":p",$this->cep);

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function alterarEndereco(){
    $query = "update endereco set logradoura=:l, numero=:n, complemento=:c, bairro=:b, cep=:p where id=:i";

    $stmt = $this->conexao->prepare($query);

   
    $stmt->bindParam(":l",$this->logradoura);
    $stmt->bindParam(":n",$this->numero);
    $stmt->bindParam(":c",$this->complemento);
    $stmt->bindParam(":b",$this->bairro);
    $stmt->bindParam(":p",$this->cep);
    $stmt->bindParam(":i",$this->id);


    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
    
}

public function apagar(){
    $query = "delete from endereco where id=?";

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