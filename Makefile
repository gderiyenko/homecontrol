PROJECT_NAME=homecontrol
DOCKER_DIR=docker

PHP_CONTAINER_NAME=app

# run initial scripts
.PHONY: init
init:
	cd $(DOCKER_DIR) && docker-compose up -d
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "composer install"
	docker exec -it $(PHP_CONTAINER_NAME) bash -c 'php artisan key:generate'
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan migrate"
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "php artisan breeze:install"
	docker exec -it $(PHP_CONTAINER_NAME) bash -c "npm install && npm run dev"


