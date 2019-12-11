import { Component, OnInit } from '@angular/core';
import { HttpHeaders, HttpClient } from '@angular/common/http';


@Component({
  selector: 'app-cadastrar',
  templateUrl: './cadastrar.page.html',
  styleUrls: ['./cadastrar.page.scss'],
})
export class CadastrarPage implements OnInit {

  /*
  Criação da função (DadosCadastrar) para pega os dados enviados do cadastrar.page.html, e enviar para o banco
  de dados
  */
   public model: DadosCadastrar = null;
   private url:string = "http://localhost/dbloja/data/cadgeral/cadastro.php";

  constructor(private http:HttpClient) {

    this.model = new DadosCadastrar();

    this.model.nome="";
    this.model.cpf="";
    this.model.telefone="";
    this.model.email="";
    this.model.logradouro="";
    this.model.numero="";
    this.model.complemento="";
    this.model.bairro="";
    this.model.cep="";
    this.model.usuario="";
    this.model.senha="";
    this.model.foto="";
  }

  public efetuarcadastro(){

    var headers = new HttpHeaders();
    headers.append("Access-Control-Allow-Origin","*");
    headers.append("Access-Control-Method","POST");
    headers.append("Accept","application/json");
    headers.append("Content-Type","application/json");

    var dados={
      "usuario":this.model.usuario,
      "senha":this.model.senha,
      "foto":this.model.foto,
      "telefone":this.model.telefone,
      "email":this.model.email,
      "logradouro":this.model.logradouro,
      "numero":this.model.numero,
      "complemeto":this.model.complemento,
      "bairro":this.model.bairro,
      "cep":this.model.cep,
      "nome":this.model.nome,
      "cpf":this.model.cpf
    };

    this.http.post(this.url,dados,{headers:headers}).subscribe(
      data=>{
        console.log(data);
      },
      erro=>{
        console.log("Erro ao tentar cadastrar => "+erro);
      }
    );

  }

  ngOnInit() {
  }

}

/*
Criamos uma classe (DadosCadastrar) com os dados que vamos trabalhar. Que vai vim do cadastrar.page.html
*/

export class DadosCadastrar {

  nome: string;
  cpf: string;
  telefone: string;
  email: string;
  logradouro: string;
  numero: string;
  complemento: string;
  bairro: string;
  cep: string;
  usuario: string;
  senha: string;
  foto: string;
}
