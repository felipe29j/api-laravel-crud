# API desenvolvida com PHP e Framework Laravel

Esta API foi construída usando o PHP com o framework Laravel. Ela permite a interação com um banco de dados e fornece endpoints para diversas funcionalidades.

## Pré-requisitos

1. Certifique-se de ter o [Composer](https://getcomposer.org/) instalado. Caso contrário, baixe e instale-o.
2. Crie uma base de dados com as seguintes configurações:
   - Host: localhost
   - Usuário: devuser
   - Senha: devpass
   - Nome do banco de dados: test_db
   Isso é necessário para a integração com o projeto.
3. Se o Laravel não estiver instalado, execute o seguinte comando no terminal do projeto:
composer global require "laravel/installer=~1.1"

Se já tiver o Laravel instalado, ignore este passo.
4. Execute o seguinte comando no terminal do projeto para instalar as dependências:
composer install

Certifique-se de ter o [Docker](https://www.docker.com/) instalado. Caso contrário, baixe-o.
5. No diretório do projeto, execute o seguinte comando para iniciar os containers Docker:
docker-compose up -d

Isso permite que a aplicação seja executada em um container, eliminando a necessidade do XAMPP ou WAMP.
6. Lembre-se de que, no Laravel, o servidor atua na porta 8000. Acesse o projeto em:
localhost:8000

7. Dentro do diretório do projeto, execute o seguinte comando para executar as migrações do banco de dados:
php artisan migrate

Isso criará automaticamente a tabela com as colunas necessárias na base de dados.
8. Ainda no mesmo terminal, inicie o servidor Laravel com o seguinte comando:
php artisan serve

Isso permite que o servidor Laravel esteja disponível para testes em:
localhost:8000

9. Para testar a API, utilize a seguinte URL (devido ao Laravel):
http://localhost:8000/api

Lembre-se de adicionar o sufixo "/api" à URL base.

Agora você está pronto para começar a utilizar a API e realizar testes!
