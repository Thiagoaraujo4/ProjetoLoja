import { Component, OnInit } from '@angular/core';
import { CpuInfo } from 'os';

@Component({
  selector: 'app-cadastrar',
  templateUrl: './cadastrar.page.html',
  styleUrls: ['./cadastrar.page.scss'],
})
export class CadastrarPage implements OnInit {

  constructor() { }

  ngOnInit() {
  }

}

/*
Criamos uma classe (DadosCadastrar) com os dados que vamos trabalhar. Que vai vim do cadastrar.page.html
*/

export class DadosCadstrar{

  nome:string;
  cpf:string;
  telefone:string;
  email:string;
  logradouro:string;
  numero:string;
  complemento:string;
  bairro:string;
  cep:string;
  usuario:string;
  senha:string;
  foto:string;
}
