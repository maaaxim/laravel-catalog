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
1. докер
2. паспорт
3. php artisan queue:table
4. php artisan migrate
5. docker-compose exec --user 1000 php php artisan queue:listen
6. docker-compose exec --user 1000 php php artisan queue:show 0 -- -1
7. docker-compose exec --user 1000 php php artisan user:register vasia vasia vasia