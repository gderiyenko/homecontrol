PROJECT_NAME=homecontrol
DOCKER_DIR=docker

PHP_CONTAINER_NAME=app

# Initial scripts
.PHONY: init
init:
	cd $(DOCKER_DIR) && docker-compose up -d
	docker exec -it app bash -c "composer install"
	docker exec -it app bash -c "cp .env.example .env"
	docker exec -it app bash -c 'php artisan key:generate'
	docker exec -it app bash -c "php artisan migrate:fresh --seed"
	docker exec -it app bash -c "php artisan breeze:install"
	docker exec -it app bash -c "npm install && npm run dev"


