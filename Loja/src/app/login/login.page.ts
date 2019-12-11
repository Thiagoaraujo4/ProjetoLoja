import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { HttpHeaders, HttpClient } from '@angular/common/http';

@Component({
  selector: 'app-login',
  templateUrl: './login.page.html',
  styleUrls: ['./login.page.scss'],
})
export class LoginPage implements OnInit {

  private url:string = "http://localhost/dbloja/data/usuario/login.php";
  public modelUS:Usuario;

  constructor(private router:Router, private http:HttpClient) {
    this.modelUS.usuario="";
    this.modelUS.senha="";

   }

  public cadastrar(){
    this.router.navigate(['/cadastrar']);
  }

  public efetuarlogin(){
    var headers = new HttpHeaders();
    headers.append("Accept","application/json");
    headers.append("Content-Type","application/json");
    headers.append("Access-Control-Allow-Origin","*");
    
    var dados ={
      "usuario":this.modelUS.usuario,
      "senha":this.modelUS.senha
    };

    this.http.get(this.url,{headers:headers,params:dados}).subscribe(
      data=>{
        console.log(data);
      },
      error=>{
        console.log("Erro ao tentar logar"+error);
      }

      
    );


  }

  ngOnInit() {
  }

}
export class Usuario{
  
  usuario:string;
  senha:string;

}
