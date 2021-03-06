### Processo para criação do projeto

Este documento tem como objetivo documentar o processo que utilizei para criação do projeto, passo a passo, incluindo as razões para escolhas de cada tecnologia.

#### Passo 1: Leitura da documentação Pagar.Me e escolha dos métodos a serem utilizados

 - Seguindo as orientações do desafio, a integração com a plataforma da PagarMe será realizada por meio do [Checkout](https://docs-beta.pagar.me/v1/docs/overview-checkout);
 - Criação de perfil na plataforma PagarMe usando meu e-mail. Obtenção das keys da API.
 - Detalhe: As compras deverão ser autorizadas e capturadas na loja de exemplo após o clique em "Finalizar", conforme orientações do desafio;
 
#### Passo 2: Definir a Stack tecnológica para o projeto
  - Back-End
 
      - PHP sem nenhum framework full-stack
      Para projetos simples, o uso de algumas bibliotecas é suficiente e não sobrecarrega o projeto com funcionalidades subutilizadas e arquivos de configuração em excesso. Essa abordagem é funcional principalmente se as bibliotecas escolhidas são aderentes ao padrão PSR-7.
      
      - SQLite para banco de dados
       Uma vez que optei por usar um banco de dados relacional, o SQLite é simples e pode ser versionado junto ao projeto principal. Criação do banco usando [ORM Doctrine](http://www.doctrine-project.org/projects/orm.html).
       Recomendo o uso do [sqliteonline](https://sqliteonline.com/) para navegar no BD. 
   
  - Front-End
  
      - Template engine [Twig](https://twig.sensiolabs.org/) para geração da página.
      
      - Usado Framework CSS [Bulma](http://bulma.io/) para estilos.
      
      - Usado [JQuery](https://jquery.com/) para interação em tela e envio de requisições assincronas (AJAX)

#### Passo 3: Testes manuais
      
   - Realizei testes manuais para cada operação de compra
    - Alugar uma fantasia - OK
    - Alugar mais de uma fantasia do mesmo fornecedor - Ok
    - Alugar mais de uma fantasia de fornecedores diferentes - Ok