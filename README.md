# Pizza

Backend для сайта пиццерии на Laravel.

## Содержание

- [Установка](#установка)
- [Использование](#использование)

## Установка

Пошаговая инструкция по установке и настройке вашего проекта. Например:

1. Клонируйте репозиторий:

```bash
   git clone https://github.com/s2000nat/Pizza.git
```

2. Перейдите в директорию проекта:

```bash
   cd ./Pizza
   ```
3. Постройте и запустите контейнеры с помощью Docker Compose:

```bash
  make up 
```
4. Установите зависимостей:

```bash
  composer install
```
5. Настройте файлы конфигурации:

```bash
  cp .env.example .env
  cp .env.testing.example .env.testing
```
6. Сгенерируйте ключ приложения для поля APP_KEY:
```bash
  php artisan key:generate
```
7. Скопирйте пароль для пользователя из docker-compose файла
8. Зайдите в консоль контейнера php-cli:

```bash
  make cli bash
```
9. Запустите миграции и сидеры:
```bash
  php artisan migrate --seed
``` 
10. Запустите тесты:
```bash
  php artisan test
```
11. Создать пользователя с правами администратора:

```bash
  php artisan create:superuser {name} {phone_number} {password}
```
12. Генерация документации Swagger OpenApi:
```bash
  php artisan "l5-swager:generate"
```

## Использование
Для использования и ручного тестрования API:

* экспортировать в Postman [коллекцию запросов](Pizza.postman_collection.json)
* перейти по адресу [OpenApi документации](http://127.0.0.1:8080/api/documentation)

## Лицензия
Этот проект лицензируется под MIT лицензией. Подробности см. в файле LICENSE.
