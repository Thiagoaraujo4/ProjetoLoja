import { Component } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { NavController } from '@ionic/angular';
import { Router } from '@angular/router';

@Component({
  selector: 'app-home',
  templateUrl: 'home.page.html',
  styleUrls: ['home.page.scss'],
})
export class HomePage {

  private url:string="http://localhost/dbloja/data/produto/listar.php"
  
  /*
  Vamos receber os produtos cadastrados no formato de JSON da API por meio da url acima.
  O conteudo que virá sera uma lista de objeto, ou seja uma lista de produtos.
  Para utilizar essa lista na página principal(home.html) estamos usando 
  um Array de objetos que receberá os dados da API e irá repassar para o nosso laço(*ngFor) na home.
  */
  public produtos:Array<Object>=[];
  constructor(private http:HttpClient, private router: Router) {}

  public navDetalheProduto(id:string){
    console.log(id);
     this.router.navigate(['detalheproduto',{idprod:id}])
  }

  /*
  O comando ngOnInit(ng-> todos os comandos internos da Angular | On-> Ativar, Ligar | 
    Init->Inicializar = iniciar).
    No momento que a página home inicializa será feita uma requisição hhtp dentro do método
    ngOnInit para buscar os produtos cadastrados.
    O comando ngOnInit é iniciado automáticamente, portanto não é necessário chamar.

  */
  ngOnInit(){
    /**
     Os comandos:
     this-> refere-se a essa classe HomePage e todo o seu conteúdo;
     http-> é um elemento tipado como httpClient resposavel por fazer as requisições do REST
     com os verbos: get, post, put e delete. Esse elemento foi declarado no construtor da classe.
     Construtor é resposavel por iniciar a classe com o seu conteúdo;
     get-> significa obter é responsável por chamar o conteúdo da página listar com todos os
     seus produtos
     ___________________________________________________________________________________________________________

      O comando get requisita a url para fazer chamada dos dados do produtos, por isso é passado entre
      parênteses a url criada no contexto da classe chamada com o comando this.url.
      O comando subcribe(Observable) é responsável por recepcionar os dados vindos da url listar produtos
      com todos os seus produtos. Estes são repassados para o objeto data e seu conteúdo é tratado de forma 
      generica com o comando (data as any) e atribuido a constate prod.

      Com todos os produto na constante prod, fazemos a exibição deste na tela de console.

      Mais abaixo, o comando error trata os eventuais erros ocorridos durante a requisição da API.


     */
    this.http.get(this.url).subscribe(
      data => {
        const prod = (data as any);
        this.produtos = prod.saida;
      }, error=>{
        console.log("Erro ao resiquitar a API"+error);
      }
    )
  }

}
