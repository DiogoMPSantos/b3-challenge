## B3 Challenge

B3 Challenge é um desafio de exibição de dados de ativos da [B3](https://www.b3.com.br/pt_br/market-data-e-indices/servicos-de-dados/market-data/consultas/boletim-diario/dados-publicos-de-produtos-listados-e-de-balcao/)

## Tecnologias
 - PHP
 - Framework Laravel
 - Mysql
 - Docker
 - Vuejs
 - Vuetify 
 - Chartjs

 ## Instruções para uso com Docker
 ### Build de imagens criadas
   - docker-compose build <br />
 ### Subir container docker
   - docker-compose up <br />
 ### Executar setup do projeto (obs: Aguardar containers serem startados)   
   - docker-compose exec php sh /bin/scripts/setup.sh <br />
 ## Import de Dados - Executa através de comando artisan para importar novas datas no banco exemplo abaixo, aceita varias datas separadas por espaço no formato abaixo
   - docker-compose exec php php artisan b3:import YYYY-MM-D
  # Processar Fila de arquivos
   - docker-compose exec php php artisan queue:work --stop-when-empty

# Instruções para uso em distribuições apache ou similares
## Rodar os comandos na pasta do projeto
  - composer install
  - npm install
  - cp .env.example .env
  - php artisan key:generate
  - php artisan storage:link
  - chmod -R 777 /var/www/html/storage em sistemas Linux
  - php artisan migrate:fresh --seed
  - php artisan b3:import 2023-04-03 2023-04-04 2023-04-05 2023-04-06 2023-04-10 2023-04-11 2023-04-12 2023-04-13 2023-04-14 2023-04-17 2023-04-18 2023-04-19 2023-04-20      2023-04-24 2023-04-25 2023-04-26 2023-04-27 2023-04-28 2023-05-02 2023-05-03
  - npm run build
  - npm run dev
  - php artisan serve   
  - php artisan queue:work --stop-when-empty
  - Ajustar configurações no .env