<?php

class Usuario{
    public $id;
    public $nomeusuario;
    public $senha;
    public $foto;
 

    public function __construct($db){
        $this->conexao = $db;
    }
    /*
    Funçao listar para selecionar todos os usuarios cadastrados no banco de dados. Essa função retorna uma 
    lista com todos os dados.
    */ 
    public function listar(){
        #Seleciona todos os campos da tabela usuario
        $query = "select * from usuario";
        /*
        Foi criada a variável stmt(Stament -> Sentença) para guardar a preparação da
         consulta seleect que será executada posteriomente.
        */

        $stmt = $this->conexao->prepare($query);
        #execução da consulta e guarda de dados na variável stmt
        $stmt->execute();
        #retorna os dados do usuario a camada data.p
        return $stmt;
    }

public function login(){
    /*
    Consulta para realizar o login. estamos usando o nome de usuario e a senha. O valor 
    */
    $query = "select * from usuario where nomeusuario=? and senha=?";

    /*
    Abaixo há uma ligação com os parametros da consulta(bind-ligação | Param -> paramêtros) as posições estão 
    relacionadas ao pontos interrogação. o primeiro 

    */

    $stmt = $this->conexao->prepare($query);

    $this->senha = md5($this->senha);

    $stmt->bindParam(1,$this->nomeusario);
    $stmt->binParam(2,$this->senha);

    $stmt->execute();
    
    return $stmt;
}

/* 
Funçao para cadastrar os usuario no banco de dados
*/
public function cadastro(){
    $query = "insert into usuario set nomeusuario=:n, senha=:s, foto=:f";

    $stmt = $this->conexao->prepare($query);

    /*Foram utilizadas 2 funções para tratar os dados que estão vindo do usuário 
    para a api.
    strip_tags-> trata os dados em seus formatos inteiro, double ou decimal 
    htmlspecialchar -> retira as aspas e os 2 pontos que vem do formato 
    json para o cadastrar em banco */

    $this->nomeusuario = htmlspecialchars(strip_tags($this->nomeusuario));
    $this->senha = htmlspecialchars(strip_tags($this->senha));
    $this->foto = htmlspecialchars(strip_tags($this->foto));

    #encriptografar a senha
    $this->senha = md5($this->senha);

    $stmt->bindParam(":n",$this->nomeusuario);
    $stmt->bindParam(":s",$this->senha);
    $stmt->bindParam(":f",$this->foto);

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function alterarFoto(){
    $query = "update usuario set foto=:f where id=:i";

    $stmt = $this->conexao->prepare($query);

    $stmt->bindParam(":f",$this->foto);
    $stmt->bindParam(":i",$this->id);

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
    
}

public function alterarSenha(){
    $query = "update usuario set senha=? where id=?";

    $stmt=$this->conexao->prepare($query);

    $this->senha = md5($this->senha);

    $stmt->bindParam(1,$this->senha);
    $stmt->bindParam(2,$this->id);

    if($stmt->execute()){
        return true;
    }
    else{
        return false;
    }
}

public function apagar(){
    $query = "delete from usuario where id=?";

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