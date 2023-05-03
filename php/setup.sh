#!/bin/bash

# Adiconar enviroment file
   cd /var/www/html && cp .env.example .env \
# Gerar chave da aplicação
   cd /var/www/html && php artisan key:generate \

# Rodar link da pasta storage e adicionar permissoes
   cd /var/www/html && php artisan storage:link && chmod -R 777 /var/www/html/storage  \
   
# Rodar migrations no banco
   cd /var/www/html && php artisan migrate:fresh --seed \

# Popular banco com os primeiros 100 registros
   # cd /var/www/html && php artisan b3:import

# Rodar PHPunit
   # cd /var/www/html && php artisan test

# Start crontab
   # crond