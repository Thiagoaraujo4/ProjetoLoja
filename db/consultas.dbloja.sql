use dbloja;
select * from usuario;

insert into usuario(nomeusuario, senha, foto)
values( 'admin',md5('123'), 'imgusuario/admin.png');

select * from contato;

insert into contato(telefone, email)
values ('11-95424-4657', 'admin@admin.com.br');

select * from endereco; 


insert into endereco(logradoura, numero, complemento, bairro, cep)
values ('Rua Largo do Cambuci', '44', 'Casas dos fundos', 'Cambuci', '01527-023');


select * from cliente;


insert into cliente(nome,  cpf, id_endereco, id_contato, id_usuario)
values ('Thiago', '39038484901', 1, 1, 1);

select * from produto;

insert into produto(nome, descricao, preco, imagem1, imagem2, imagem3, imagem4)
values ('Camisa ','Camisa 1BR Basica, Tamanho M', '30.00', 'imgproduto/camisa1.png', 'imgproduto/camisa2.png', 'imgproduto/camisa3.png', 'imgproduto/camisa4.png');


insert into produto(nome, descricao, preco, imagem1, imagem2, imagem3, imagem4)
values ('Jaqueta ','jaqueta 1BR Corta Vento, Tamanho M', '80.00', 'imgproduto/jaqueta1.png', 'imgproduto/jaqueta2.png', 'imgproduto/jaqueta3.png', 'imgproduto/jaqueta4.png');

select * from estoque;

insert into estoque(id_produto, quantidade)
values (1, 10) , (2,5);

select * from pedido;

insert into pedido(id_cliente)
values (1);

select * from detalhepedido; 

insert into detalhepedido(id_pedido, id_produto, quantidade)
values (1,1,2) , (1,2,2); 

# Da tabela produto(nome, preco)
# Da tabela detalhepedido(quantidade)
# A amarraçao entre as tabelas será feita pelo campo 
#id_produto

select  d.id_pedido, p.nome, p.preco, d.quantidade, p.preco*d.quantidade 'total'
from produto p inner join detalhepedido d on p.id = d.id_produto; 

#Vamos realizar a soma de coluna total(quantidade do detalhepedido
#vezes o preco do produto) e para isso iremos usar o comando 
#sum(soma). Para a funçao realizar esta operação , nós teremos 
# de agrupar as linhas referentes a este pedido com todos os 
#seus produto. Sendo assim iremos usar outros comando de 
#agrupamento chamado group by (agrupar por) e passar como
#parametros o campo id_pedido.

select sum(p.preco*d.quantidade) 'Total a pagar' from produto p inner join detalhepedido d on p.id=d.id_produto
group by d.id_pedido;

#Fizemos a divisao pot 5 do total do valor, usando mais um sum(soma) e apresentando um /5.
select sum(p.preco*d.quantidade) 'Total a pagar',
(sum(p.preco*d.quantidade))/5 'Valor da parcela'
from produto p inner join detalhepedido d on p.id=d.id_produto
group by d.id_pedido;

select * from pagamento;

insert into pagamento( id_pedido, valor, formapagamento, descricao, numeroparcelas,
valorparcela)
values(1,220.00,'Carão de credito', 'NC 4738-Thiago', 5,44);

#Tem que fazer uma tabela para os dados que volta da propria empresa do "cartão", 
#da pra vê os dados que precisa na internet. "Api Tal" ai mostra.

select * from estoque;


#Pegamos a quantidade do estoque e comparamos com a quantidade de detalhepedido, com a ajuda da tabela Produto.
select e.quantidade 'Estoque' , d.quantidade 'Vendido', e.quantidade- d.quantidade 'Atual' 
from estoque e inner join produto p on  p.id= e.id_produto
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=2;

select e.quantidade- d.quantidade 
from estoque e inner join produto p on  p.id= e.id_produto
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=2;

update estoque set quantidade=(select e.quantidade- d.quantidade 
from estoque e inner join produto p on  p.id= e.id_produto
inner join detalhepedido d on d.id_produto=p.id where d.id_produto=1) where id_produto=1; 



