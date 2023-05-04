#!/bin/bash

# Adicionar enviroment file
   cd /var/www/html && cp .env.example .env \

# Rodar link da pasta storage e adicionar permissoes
   cd /var/www/html && php artisan storage:link && chmod -R 777 /var/www/html/storage  \
   
# Setup Node e PHP
   cd /var/www/html && rm -r node_modules/ \

# Setup Node e PHP
   cd /var/www/html && php artisan key:generate && php artisan migrate:fresh --seed && composer install && composer update && npm install && npm update \

# Popular banco com os primeiros 100 registros
   cd /var/www/html && php artisan b3:import 2023-04-03 2023-04-04 2023-04-05 2023-04-06 2023-04-10