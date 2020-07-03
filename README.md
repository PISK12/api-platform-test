docker-compose build
docker-compose up -d
docker-compose exec server composer install
docker-compose exec server ./bin/console doctrine:schema:create
docker-compose exec server ./bin/console doctrine:fixtures:load


