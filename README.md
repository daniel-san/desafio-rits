# Minha solução

O objetivo do desafio era desenvolver uma aplicação para captura de currículos
para uma vaga de trabalho.

Para começar, criei um projeto padrão do Laravel
utilizando o composer. Para a base de dados utilizada no desenvolvimento, decidi utilizar um
container do Docker rodando o banco de dados PostgreSQL.
O container do PostgreSQL foi criado usando o seguinte comando:

```
docker run --name database -e POSTGRES_PASSWORD=docker -p 5432:5432 -d postgres
```

Tendo o projeto base, e um banco de dados ativo, iniciei o desenvolvimento.
Decidi começar primeiro pelo backend da aplicação, e focar no layout das páginas
após ter finalizado o backend.

Nas subseções a seguir será descrito de maneira
breve como implementei cada parte. O hístorico de commits está disponível para detalhes
mais específicos.

## Backend

### Configuração inicial

Comecei primeiro executando tarefas que precisariam ser
feitas de qualquer maneira:

-   Preencher os dados necessários no arquivo de ambiente `.env`:
    -   Credenciais de conexão ao banco de dados;
    -   Credenciais para envio de emails;
-   Criar o layout padrão de autênticação;
-   Linkar a pasta storage para guardarmos os currículos enviados pelos candidatos.

Logo em seguida, criei os layouts de autênticação e linkei a pasta de storage
utilizando os seguintes comandos:

```
php artisan make:auth
php artisan storage:link
```

Criei uma classe de modelo para os candidados chamada `Candidate`.
Utilizei o artisan para criar o model, o controller e a migration necessária para a
tabela no banco de dados:

```
php artisan make:model -rmc 'Candidate'
```

Para acessar os métodos do controller, registrei ele no arquivo `routes/web.php` como
um resource.

No arquivo de migration do modelo de candidato, setei os campos de acordo com o
layout fornecido, e executei a migration para criar as tabelas no banco de dados.

### Implementação do controller

Para fins de testar o controller, criei inicialmente um layout simples para a página do
formulário do candidato, e implementei o método `store` no `CandidateController` para
salvar os dados do candidato no banco de dados. Validação foi implementada nos campos
enviados para o controller.

Também implementei o método `index` para ser utilizado no dashboard do administrador,
acessando todos os candidatos no banco de dados e os retornando para serem exibidos na view.

### Dashboard do Admin

O layout utilizado para as páginas do admin foram simples com o objetivo de agilizar
o desenvolvimento. A página que é exibida após o admin efetuar login exibe os nomes
dos candidatos registrados até o momento, apresentando um botão para visualizar todos
os dados do candidato.

Para simplificar a criação de um usuário admin, criei um seeder que cria um
usuário como admin para a aplicação, já que decidi desavitar a rota `/register`.

Os dados do usuário admin podem ser setados a partir do arquivo `.env`. Por exemplo:

```
ADMIN_NAME=Daniel
ADMIN_EMAIL=dlsbdaniel@gmail.com
ADMIN_PASSWORD=qwerty
```

Para criar o usuário, é só executar um:

```
php artisan db:seed
```

A rota de login de admin é a `/login`.

### Configurando cache

Com o intuito de simplificar o cálculo de quantos candidatos se registraram em
determinados intervalos e para
a criação do bot do Telegram, ativei o uso de
cache via banco de dados. Para isso modifiquei o valor de CACHE_DRIVER para 'database'
no arquivo `.env`:

```
CACHE_DRIVER=database
```

Após isso rodei o comando para criar a migration para a tabela de cache, e
executei a migration:

```
php artisan make:cache
php artisan migrate
```

A cache será utilizada para armazenar a quantidade de candidatos cadastrados,
calcular a diferença, e assim notificar ao admin do número correto de novos candidatos
através de e-mail.

### Envio de Emails

Para enviar emails, foi preciso criar um template de emails utilizando o comando:

```
php artisan make:mail NotifyAdmin --markdown="mail.notify-admin"
```

O template de email foi alterado de acordo para exibir os dados referentes ao
número de candidatos que se registraram, e está contido no arquivo `resources/views/mail/notify-admin.blade.php`.

Logo em seguida modifiquei o arquivo `app/Console/Kernel.php`, e criei um schedule
configurado para ser executado diariamente as 12:00 e 18:00 horas.

O job configurado compara o número de candidatos no banco de dados com o número
salvo em cache, e envia um email para o admin informando quantos são os candidatos novos, e atualiza a cache com o
novo valor referente ao número de candidatos.

Dentro do ambiente de desenvolvimento não foi utilizado o crontab para efetuar os testes
do schedule para envio de emails, mas foi testado manualmente e também levado em consideração na seção de
configuração do projeto mais adiante.

## Frontend

O layout da página de inscrição dos candidatos foi feito em um arquivo separado do layout das outras páginas.
Foi utilizado SASS para gerar os estilos da página, junto com componentes disponíveis na biblioteca Bootstrap.
Os estilos para a página estão contidos no arquivo `resources/sass/_vagaform.scss`, e foram
compilados usando webpack. Para efetuar a compilação, deve-se executar os seguintes comandos:

```
npm install //instalar dependencias
npm run watch //compilar sass e observar mudanças em arquivos
```

A validação dos campos e parte da reatividade de alguns elementos foi codificada utilizando JQuery e está contida no arquivo `resources/js/vagaform.js`. Este arquivo deve ser incluido dentro do `webpack.mix.js`, caso contrário não será utilizado pela página.

## Bot do Telegram

Seguindo a documentação do Telegram, consegui configurar um bot que envia a quantidade de candidatos e os emails dos 3 últimos candidatos.

A primeira coisa que precisou ser feita foi criar um bot pelo [BotFather](https://telegram.me/botfather),
e obter com ele a chave de api do bot.
Depois, foi necessário setar o webhook do bot, por exemplo, usando o seguinte comando:

```
curl -F "url=<webhook_url>" https://api.telegram.org/bot<api_key>/setWebhook
```

Dessa forma o bot já está pronto para interagir com clientes e enviar mensagens.

Dêvido ao bot não poder acessar endereços locais (localhost, etc), e a algumas restrições
no host que eu tinha disponível, o bot funciona da seguinte maneira:

-   Toda vez que um usuário se candidata à vaga, um snapshot do número de usuários e os emails dos 3 últimos inscritos são enviados ao servidor do bot;
-   Quando um cliente executa o comand /vagarits em uma conversa com o bot, este acessa o snapshot recebido, e envia uma mensagem ao cliente do Telegram informando quantos candidatos estão cadastrados e quais foram os 3 ultimos e-mails.

O endereço para onde é enviado o snapshot dos dados pode ser definido no
arquivo `.env` através do campo BOT_UPDATE_URL, campo este que já está setado no arquivo de exemplo `.env.example`.

O bot já está ativo, e responde somente ao comando `/vagarits`.

Se não fosse pelas restrições quanto ao deploy, o ideal seria configurar
o código do bot
dentro da própria aplicação, utilizando do arquivo `routes/api.php` para
configurar os endpoints utilizados pelo bot e os dados enviados por ele.

O código utilizado para o bot se encontra no seguinte [repositório](https://github.com/daniel-san/vagarits-bot), e o bot em si pode ser acessado por [aqui](https://t.me/CandNotifyBot).

## Utilização do Docker

O meu conhecimento de Docker se resumia a somente utilizar containers, como o do Postgres que
utilizei durante o desenvolvimento, sem nenhum tipo de orquestramento ou uso do
docker-compose.

Para o projeto, estudei o que podia e montei um `Dockerfile` e um `docker-compose.yml`
para tentar empacotar a aplicação inteira em um container, porém não fui muito bem
sucedido, conseguindo acessar apenas o container do postgres, e não o container
onde a aplicação executa. Os arquivos estão disponíveis no repositório como uma forma
de registro.

# Manual de configuração

Após clonar o projeto do github, deve-se executar os seguintes passos para que a
aplicação funcione:

-   Utilizar o Composer para instalar as dependências do projeto. Execute o seguinte
    comando na raíz do projeto:
    ```
    composer install
    ```
-   Copiar o arquivo `.env.example` para `.env`;
-   Executar o seguinte comando para setar a chave da aplicação no arquivo `.env`:
    ```
    php artisan key:generate
    ```
-   Preencher o arquivo `.env` com os dados referentes ao banco de dados;
    -   Como exemplo, durante o desenvolvimento utilizei os seguintes dados:
        ```
        DB_CONNECTION=pgsql
        DB_HOST=192.168.0.100
        DB_PORT=5432
        DB_DATABASE=desafio-rits
        DB_USERNAME=postgres
        DB_PASSWORD=*****
        ```
-   Executar as migrations para criar as tabelas no banco de dados:
    ```
    php artisan migrate
    ```
-   Linkar a pasta storage utilizando o comando:
    ```
    php artisan storage:link
    ```
-   Preencher no arquivo `.env` os dados referentes ao admin da aplicação;
    -   Os campos são: ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD;
    -   Utilizar um email real para o campo ADMIN_EMAIL. O email do admin será o endereço de email de destino para as mensagens que são enviadas pela aplicação;
-   Executar o seguinte comando para criar o usuário admin:
    ```
    php artisan db:seed
    ```
-   Alterar o valor do campo CACHE_DRIVER para 'database';
    -   A cache é utilizada para armazenar o número de candidatos cadastrados e calcular o número correto de candidatos novos;
-   Preencher os dados referentes ao envio de email da aplicação:
    -   MAIL_USERNAME, MAIL_PASSWORD, MAIL_ENCRYPTION, MAIL_HOST, MAIL_DRIVER, e MAIL_PORT;
    -   Nos testes locais foram utilizados o servidor SMTP do GMail;
    -   Exemplo:
        ```
        MAIL_DRIVER=smtp
        MAIL_HOST=smtp.gmail.com
        MAIL_PORT=587
        MAIL_USERNAME=dlsbdaniel@gmail.com
        MAIL_PASSWORD=******
        MAIL_ENCRYPTION=tls
        ```
-   Para que a aplicação envie os emails nos horários corretos e de forma automática, deve-se adicionar a seguinte entrada no crontab para fazer este trabalho. Em ambientes Linux, isso pode ser feito executando o comando `crontab -e` e adicionando a linha abaixo, substituindo `path-to-your-project` pelo caminho até o projeto:
    ```
    * * * * *  cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```
-   Ou caso queira executar o Schedule manualmente nos horários específicos:
    ```
    php artisan schedule:run
    ```
-   Feito isso, pode-se iniciar a aplicação utilizando o comando:
    ```
    php artisan serve
    ```
-   Assumindo o endereço como localhost:8000, as rotas principais são as seguintes:
    -   Formulário de inscrição de candidato - http://localhost:8000/
    -   Página de login de administrador - http://localhost:8000/login

# Telegram Bot

Um bot para o Telegram foi desenvolvido de acordo com o pedido no desafio. Dêvido à algumas restrições referentes a deploy da aplicação, desenvolvi o servidor do bot separado da aplicação principal. O código utilizado para o bot se encontra no seguinte repositório - [Link](https://github.com/daniel-san/vagarits-bot).
O bot pode ser acessado por [aqui](https://t.me/CandNotifyBot).
Para que o bot funcione, é necessário os seguintes passos:

-   No arquivo `.env`, existe um campo chamado BOT_UPDATE_URL que aponta para um endpoint onde o servidor do bot está localizado. Essa url recebe um snapshot do total de candidatos inscritos e os 3 ultimos candidatos, utilizando esses dados para formular uma resposta para usuários do bot;
-   No arquivo `.env.example`, este campo já foi setado por padrão;
-   Ao iniciar uma conversa com o bot, utilizar o comando /vagarits para receber as informações sobre o número de candidatos e o email dos 3 candidatos mais recentes.

# Docker

O `Dockerfile` e o `docker-compose.yml` descrevem como subir uma versão em container da
aplicação.

Porém, dêvido à minha falta de experiência com
o uso do docker-compose e Dockerfiles em geral, o
container da aplicação em si não está funcionando,
embora o container do postgres que está configurado no
docker-compose esteja sendo criado e funcionando sem
problemas.

Os arquivos estão disponíveis no repositório para fins de
registro.
