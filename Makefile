# Имя проекта
PROJECT_NAME=my_project

# Команды по умолчанию
.DEFAULT_GOAL := help

# Сборка всех сервисов
build:
	docker-compose build

# Запуск всех сервисов
up:
	docker-compose up -d

# Остановка всех сервисов
down:
	docker-compose down

# Показать логи
logs:
	docker-compose logs -f

# Запуск PHP CLI
php-cli:
	docker-compose run --rm php-cli

cli bash:
	docker-compose exec php-cli bash

migrate:
	docker-compose exec php-cli bash --seed

# Остановка всех контейнеров
stop:
	docker-compose stop

# Удаление всех контейнеров
rm:
	docker-compose rm -f

# Удаление образов
rmi:
	docker-compose down --rmi all

# Помощь
help:
	@echo "Доступные команды:"
	@echo "  make build     - Сборка всех сервисов"
	@echo "  make up        - Запуск всех сервисов в фоновом режиме"
	@echo "  make down      - Остановка и удаление всех сервисов"
	@echo "  make logs      - Показать логи всех сервисов"
	@echo "  make cli bash  - Консоль контейнера PHP CLI"
	@echo "  make migrate   - Выполнить миграции и сиды"
	@echo "  make php-cli    - Запуск PHP CLI контейнера"
	@echo "  make stop      - Остановка всех контейнеров"
	@echo "  make rm        - Удаление всех остановленных контейнеров"
	@echo "  make rmi       - Удаление всех образов"
