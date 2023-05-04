#!/bin/bash

# Adicionar enviroment file
   cd /var/www/html && cp .env.example .env \

# Rodar link da pasta storage e adicionar permissoes
   cd /var/www/html && php artisan storage:link && chmod -R 777 /var/www/html/storage  \
   
# Setup Node e PHP
   cd /var/www/html && rm -r node_modules/ \

# Setup Node e PHP
   cd /var/www/html && php artisan key:generate && php artisan migrate:fresh --seed && composer install && composer update && npm install && npm update \

# Popular a fila com os arquivos da B3
   cd /var/www/html && php artisan b3:import 2023-04-03 2023-04-04 2023-04-05 2023-04-06 2023-04-10 2023-04-11 2023-04-12 2023-04-13 2023-04-14 2023-04-17 2023-04-18 2023-04-19 2023-04-20 2023-04-24 2023-04-25 2023-04-26 2023-04-27 2023-04-28 2023-05-02 2023-05-03 \

# Subir Front node
   cd /var/www/html && npm run build && npm run dev