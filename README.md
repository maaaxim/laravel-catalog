# Инструкция
- Клонируем репозиторий: `git@github.com:maaaxim/laravel-catalog.git`
- Переходим в директорию проекта: `cd laravel-catalog`
- Создаем файл окружения: `cp .env.example .env`
- Запускаем docker-окружение: `docker-compose up -d`
- Переходим внутрь контейнера с приложением: `docker-compose exec --user 1000 php bash`
- Установка composer: `composer install`
- `php artisan key:generate`
- `php artisan migrate`
- Создаем Client ID & Client secret для OAuth2.0 grant type password: `php artisan passport:client --password`
- Регистрируем юзера: `php artisan user:register vasily vasily@mail.ru 112233`
- Заполнение каталога: `php artisan db:seed --class=CatalogSeeder`
- Можно авторизоваться через swagger, в username надо указать email (там же есть примеры json для всех методов): http://localhost:600/swagger/index.html 
- Показать список команд в очереди: `php artisan queue:show 0 -- -1`
- Запуск демона: `artisan queue:listen`
- Запуск тестов `./vendor/bin/phpunit# Инструкция`

# Затрачено времени
* Инфраструктура: docker: php, mysql, redis, почта = 1ч
* Описание всех моделей и связей = 2ч
* Проектирование методов = 2ч
* Миграции и сиды = 1ч
* Авторизация = 2ч
* Методы категорий = 2ч 
* Методы товаров = 1ч
* Продажа и возврат = 1ч
* Логирование = 1ч
* Очередь = 1ч
* Письмо и СМС = 1ч
* Команда регистрации = 0,5ч
* Команда просмотра очереди на отправку = 0,5ч
* Тесты 3ч
* Документация 1ч
* Всего = 20ч

-P.S. репозиториев и сервисов нет специально, т.к. приложение простое, контроллеры и так тонкие
