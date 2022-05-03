# Back End


Este repositório contém a parte de Back End do desafio

**Atenção**, para este container funcionar corretamente você deve ter o composer instalado na sua máquina local.

Caso não o tenha, [você pode encontrar como realizar a instalação aqui!](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)


## Como rodar o projeto


Para rodar o Back End, siga estas etapas:

1. Clone o repositório

```bash
  $ git clone git@github.com:alexsandron3/contato_seguro_backend.git
```

2. Entre na pasta

```bash
  $ cd contato_seguro_backend
```


3. Inicie crie os containers do PHP e container do MYSQL

```bash
  $ docker-compose up
```
# Back End


Este repositório contém a parte de Back End do desafio

**Atenção**, para este container funcionar corretamente você deve ter o composer instalado na sua máquina local.

Caso não o tenha, [você pode encontrar como realizar a instalação aqui!](https://getcomposer.org/doc/00-intro.md#installation-linux-unix-macos)


## Dificuldades e Desafios


### Programar com PHP orientado a Objetos:
Eu programei em PHP por muito tempo e PHP foi a primeira linguagem que eu de fato tive contato com programação, no entanto, nunca havia programado em orientação a objetos.
Eu comecei a aprender conceito de OOP e padrões de arquitetura agora nos ultimos ~2 meses na trybe em Typescript, então esse teste foi uma ótima oportunidade de eu por em prática os conceitos de OOP.

Além disso, no PHP a orientação a objetos também vem acompanhado do PDO, que foi um grande desafio entender como funcionavam as coisas. Mas com bastante leitura de documentação e fóruns consegui entender o suficiente para construir a API.

### Entender como funciona e usar a Psr-4:

Quando comecei a ler documentações de programas em PHP OOP, vi que era uma prática usar a psr-4, algo que eu não tinha ouvido falar. Sem dúvidas, no início esse foi o maior desafio, consegui entender como eu configurava essa psr para que eu pudesse exportar e importar minhas classes e interfaces com facilidade. Assim como no tópico anterior, resolvi lendo muita documentação, tentando e batendo muito a cabeça.


### Aplicar arquitetura MSC:

Como dito, aprendi sobre padrões de arquiteturas agora na trybe, então enquanto programei como autodidata, não tinha conhecimentos sobre os padrões de arquitetura.
Neste desafio pensei em criar rotas com urls mais amigáveis, implementando uma camada de controller, no entanto achei que seria mais interessante entregar o produto viável mínimo e depois criar a camada de controller com urls amigáveis.


### Criar o container do PHP com o composer:

Nunca tinha pensado em criar um container com o composer pois costumo usar o volume para o Back End.
No entanto, ao lembrar que essa aplicação poderia ser utilizada por uma pessoa que não tem o composer instalado,
comecei a procurar como fazer a instação do composer.
Depois de cerca de uma hora pesquisando e tentando, aprendi como instalar o composer no Docker.


### O que me fez escolher um banco de dados relacional:

Durante a conversa com nossa recrutadora, foi me perguntado se eu tinha conhecimentos em banco de dados relacionais, pois era necessário. 
Olhando no linkedin de alguns dos desenvolvedores vi que eles utilizam um banco de dados relacional na stack.
Com essas duas informações entendi que a empresa trabalha com banco de dados relacional, então quis mostrar que eu tinha conhecimento.
Além disso, o readme deixava bem claro que existiam entidades e relacionamentos, características fortes de bancos de dados relacionais.
A escolha do Mysql foi mais pessoal, é um banco que eu utilizo e estudo a alguns anos e tenho mais facilidade com a sintaxe e documentação.
