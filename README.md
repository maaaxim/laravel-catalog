# План
* Инфраструктура: docker: php, mysql, redis, почта = 2ч
* Описание всех моделей и связей = 2ч
* Проектирование методов = 1ч
* Миграции и сиды = 2ч
* Авторизация = 2ч
* 2 метода категорий = 2ч 
* 2 метода товаров = 2ч
* Продажа и возврат = 2ч
* Логирование = 1ч
* Очередь = 2ч
* Письмо и СМС = 2ч
* Команда регистрации = 1ч
* Команда просмотра очереди на отправку = 1ч
* Тесты 4ч
* Всего оценка = 26ч


# Дока
- докер
- php artisan migrate
- php artisan user:register vasily vasily@mail.ru 112233
- php artisan passport:client --password
- проще всего залогиниться через swagger, в username надо указать email
- docker-compose exec --user 1000 php php artisan queue:listen
- docker-compose exec --user 1000 php php artisan queue:show 0 -- -1
- docker-compose exec --user 1000 php php artisan user:register vasia vasia vasia
- ./vendor/bin/phpunit