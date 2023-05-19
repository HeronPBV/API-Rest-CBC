# API REST - CBC

Teste para Desenvolvedor do Comitê Brasileiro de Clubes

## Sobre o projeto e seu desenvolvimento

Aplicação de gerenciamento de recursos financeiros de clubes. 🏆

### Tecnologias utilizadas

<table>
  <tr>
    <td>PHP</td>
    <td>MySQL</td>
    <td>Apache</td>
  </tr>
  
  <tr>
    <td>8.1.0</td>
    <td>8.0.27</td>
    <td>2.4.51</td>
  </tr>
</table>

Nenhum Framework ou biblioteca foram utilizados. 🔥

### Padrões de projeto
- Arquitetura MVC
- PSR4
- API Rest

## Instruções para a execução do projeto

O projeto já está hospedado, devidamente configurado e pronto para uso no seguinte link:<br>
https://heronboares.com.br/cbc.api
<br>
<br>O mesmo pode ser acessado e testado diretamente por lá através de alguma ferramenta de testes de API, como o Postman ou o Insomnia
<br>São válidas URLs GET ou POST como https://heronboares.com.br/cbc.api/clubes
<br>Confira ao final desde documento a lista completa dos endpoints.

### Para instalar e rodar localmente

É necessário ter instalado o PHP, MySQL e Apache.

1) Baixe todo o conteúdo e coloque em uma pasta.
2) Crie um virtual host com o Apache apontando para a pasta em questão.
3) Crie o banco de dados e atualize o arquivo Config.php com as credenciais corretas.
4) Execute as querys do arquivo banco.sql
5) Teste o projeto 😎

⚠️ Atenção ⚠️ 
<br>Qualquer problema com o autoload pode ser resolvido com o seguinte comando:
~~~
composer dump
~~~

## Lista dos endpoints e requisições

### GET

* cbc.api
~~~
Retorno
{
    "Nome": "CBC API Rest Gerenciamento de Recursos",
    "Instrução": "Acesse a documentação para saber os endpoints disponíveis",
    "Documentação": "https://github.com/HeronPBV/API-Rest-CBC"
}
~~~
<br>

* cbc.api/clubes  
Para buscar por todos os clubes

~~~
Retorno: 200
{
    {
        "id": 1,
        "clube": "Clube A",
        "saldo_disponivel": "2000.00"
    },
    {
        "id": 2,
        "clube": "Clube B",
        "saldo_disponivel": "2000.00"
    }
}
~~~

Caso não hajam clubes cadastrados:

~~~
Retorno: 404
{
    "Erro": "Nenhum clube cadastrado"
}
~~~
<br>

* cbc.api/clubes/2
<br>Para buscar por um clube específico
~~~
Retorno: 200
{
    "id": 2,
    "clube": "Clube B",
    "saldo_disponivel": "2000.00"
}
~~~

Caso não exista um clube com o id digitado:

~~~
Retorno: 404
{
    "Erro": "Clube não encontrado"
}
~~~

### POST

* cbc.api/clubes <br>
Para a criação de um novo clube
~~~
Requisição:
{
    "clube":"Clube A",
    "saldo_disponivel":"2000,00"
}
~~~
~~~
Retorno: 200
{
    "Mensagem": "ok"
} 
~~~

<br>

* cbc.api/recursos
<br>Para consumir recursos de um clube

~~~
Requisição:
{
    "clube_id":"1",
    "recurso_id":"1",
    "valor_consumo":"500,00"
} 
~~~
~~~
Retorno: 200
{
    "clube":"Clube A",
    "saldo_anterior":"2000,00"
    "saldo_atual":"1500,00"
}
~~~

Caso o saldo seja insuficiente:

~~~
Retorno: 400
{
    "Erro": "O saldo disponível do clube é insuficiente"
}
~~~
Ao ser consumido um recurso, o mesmo é debitado do saldo do clube e também da tabela saldo.

<br><br>

⚠️ Atenção ⚠️
<br>Qualquer requisição inválida ou que infrigir alguma regra de negócio receberá uma resposta com status code 400 contendo o motivo da requisição não ser válida e instruções do que fazer.
<br>Exemplos:
~~~
Retorno: 400
{
    "Erro": "Os dados inseridos são inválidos",
    "Instruções": "São necessários três parametros: 'clube_id', 'recurso_id' e 'valor_consumo', dessa exata forma, devendo o valor de consumo ser positivo"
}
~~~
~~~
Retorno: 400
{
    "Erro": "É necessário um corpo para essa requisição",
    "Instruções": "São necessários dois parametros: 'clube' e 'saldo_disponivel', dessa exata forma, devendo o saldo ser um valor positivo"
}
~~~
~~~
Retorno: 400
{
    "Erro": "Um clube não pode ter saldo negativo",
    "Instruções": "São necessários dois parametros: 'clube' e 'saldo_disponivel', dessa exata forma, devendo o saldo ser um valor positivo"
}
~~~