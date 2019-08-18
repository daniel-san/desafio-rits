# Manual de configuração

Após clonar o projeto do github, deve-se executar os seguintes passos para que a aplicação funcione:

-   Utilizar o Composer para instalar as dependências do projeto. Execute o seguinte comando na raíz do projeto:
    ```
    composer install
    ```
-   Copiar o arquivo .env.example para .env;
-   Executar o seguinte comando para setar a chave da aplicação no arquivo .env:
    ```
    php artisan key:generate
    ```
-   Preencher o arquivo .env com os dados referentes ao banco de dados;
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
-   Preencher no arquivo .env os dados referentes ao admin da aplicação;
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
-   Para que a aplicação envie os emails nos horários corretos e de forma automática, deve-se adicionar a seguinte entrada no crontab para fazer este trabalho, substituindo 'path-to-your-project' pelo caminho até o projeto:
    ```
    * * * * *  cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
    ```
-   Ou caso queira executar o Schedule manualmente:
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

-   No arquivo .env, existe um campo chamado BOT_UPDATE_URL que aponta para um endpoint onde o servidor do bot está localizado. Essa url recebe um snapshot do total de candidatos inscritos e os 3 ultimos candidatos, utilizando esses dados para formular uma resposta para usuários do bot;
-   No arquivo .env.example, este campo já foi setado por padrão;
-   Ao iniciar uma conversa com o bot, utilizar o comando /vagarits para receber as informações sobre o número de candidatos e o email dos 3 candidatos mais recentes.
