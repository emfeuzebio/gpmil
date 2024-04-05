### Instalando o Laravel mais atual

## Preparação
# remova a pasta public da pasta application
# entre na pasta application

# inslale a versão mais atual do Laravel com o comando abaixo
composer create-project --prefer-dist laravel/laravel:^10.0 application

## Configuração
# copiar a chave que foi gerada ao final da instalação continda em APP_KEY do .env
# e colar no arquivo docker-compose.yml em app após volumes: e antes de depends_on:

    environment:
      - COMPOSER_HOME=/composer
      - COMPOSER_ALLOW_SUPERUSER=1
      - APP_ENV=local
      - APP_KEY=base64:xH4BmKDZPZ0pbhpsC+gmmyNor8rf8PzYVkkm1tY6L1w=

# Atualizar a conexão do banco de dados no .env

    DB_CONNECTION=mysql
    DB_HOST=db
    DB_PORT=3306
    DB_DATABASE=gpmil
    DB_USERNAME=root
    DB_PASSWORD=root

# caso o não seja gerado o APP_KEY no .env tente instalar o php-curl
sudo apt-get install php-curl

# desmontar o container
docker-compose down

# subir o container
docker-compose up

# acessar a aplicação Laravel
http://localhost:8000/

# acessar o MySQL via phpMyAdmin
http://localhost:8001

login: 
    servidor: db
    user: root
    pwd: root

# criar o banco de dados no MySQL
CREATE DATABASE IF NOT EXISTS gpmil;

# acessar o container [app]
docker compose exec app bash
ou
docker-compose exec app bash

# Pupular as tabelas essenciais do Laravel com php artisan migrate
cd application

php artisan migrate:install

php artisan migrate:status 

php artisan migrate

# falta carregar dados nas tabelas criadas com seeder


#### Instalando o AdminLTE no Laravel
https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Installation
https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Artisan-Console-Commands
no terminal do VsCode pasta application

# 1. Require the package
# On the root folder of your Laravel project, require the package using the composer tool:
composer require jeroennoten/laravel-adminlte

# 2. Install the package resources
# Install the required package resources using the next command:
php artisan adminlte:install

# 3. Install the legacy authentication scaffolding (optional)
composer require laravel/ui
php artisan ui bootstrap --auth
php artisan adminlte:install --only=auth_views
php artisan adminlte:install --only=config --only=main_views
php artisan adminlte:install --with=auth_views --with=basic_routes
php artisan adminlte:install --type=full --with=main_views

# 3.1 Verificar se todos os packages foram instalados
php artisan adminlte:status

# pronto: acesse home Laravel e terá no canto sup dir Log In e Register
apos se registrar, ao fazer login via dar um erro de vite

editar o arquivo
resources/views/layouts/app.blade.php
comentar a linha do Vite acima do </head>
<!-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) -->

### por ver ainda uma forma de ao iniciar o container já fezer o migrate e o seeder dos dados iniciais

# Colocando tradução no AdminLTE
fonte: https://github.com/lucascudo/laravel-pt-BR-localization/tree/master?tab=readme-ov-file

Instalação
Em /application executar os seguinte comandos:

php artisan lang:publish
composer require lucascudo/laravel-pt-br-localization --dev
php artisan vendor:publish --tag=laravel-pt-br-localization

# Configure o Framework para utilizar 'pt-BR' como linguagem padrão
# Altere Linha 86 do arquivo config/app.php para:
'locale' => 'pt-br',
# Linha 99
'fallback_locale' => 'pt-BR',
# Linha 86 - mensagens de erro das validações de form
# Ajuste também o timezone
# Linha 73
'timezone' => 'America/Sao_Paulo'

# Ajuste conforme o nessessário para aquelas palavras que não foram traduzidas em:
/application/lang/vendor/pt-br


### Yajara Data Tables
# Exmplo prático
https://www.youtube.com/watch?v=N69ZOg59exs&t=191s

# Documentação
https://yajrabox.com/docs/laravel-datatables/master/

# instalação
composer require yajra/laravel-datatables:^10.0


### configurar o Menu do AdminLTE


### Configurar a master.blade do AdminLTE para carregar os css e js necessários ao DataTables
editar o template geral da aplicação em
resources/views/vendor/adminlte/master.blade.php

colocar os arquivos .css necessários 
colocar os arquivos .js necessários 




