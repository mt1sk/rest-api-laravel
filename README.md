## REST API на фреймворке Laravel
Простой блог с возможностью оставлять коментарии к статьям.
##### Основные сущности: 
- пользователь
- статья
- комментарий
##### Endpoints:
- регистрация пользователя ```/api/v1/register``` ```POST```
- аутентификация пользователя ```/api/v1/login``` ```POST```
- список всех статей ```/api/v1/posts``` ```GET```
- просмотр статьи ```/api/v1/posts/{id}``` ```GET```
- создание статьи ```/api/v1/posts``` ```POST```
- редактирование статьи ```/api/v1/posts/{id}``` ```PATCH```
- удаление статьи ```/api/v1/posts/{id}``` ```DELETE```
- добавление комментария к статье ```/api/v1/posts/{id}/comments``` ```POST```

### Структура проекта
```
src/app/
├── Http
│   ├── Controllers
│   │   └── Api
│   │       ├── Auth
│   │       │   ├── LoginController.php
│   │       │   ├── LogoutController.php
│   │       │   └── RegisterController.php
│   │       ├── CommentController.php
│   │       └── PostController.php
│   ├── Requests
│   │   └── Api
│   │       ├── AuthUserRequest.php
│   │       ├── IndexPostRequest.php
│   │       ├── StoreCommentRequest.php
│   │       ├── StorePostRequest.php
│   │       ├── StoreUserRequest.php
│   │       └── UpdatePostRequest.php
│   └── Resources
│       ├── Comment.php
│       ├── Post.php
│       └── User.php
├── Comment.php
├── Post.php
└── User.php
```

### Информация по установке
1. Клонируем репозиторий
2. В корне копируем ```.env.example``` -> ```.env```
   - проверяем не заняты ли порты: ```80```, ```3306```, ```8080```; если заняты - меняем в ```.env``` файле **и учитытваем в дальнейших настройках**
   - по необходимости меняем пароль к базе данных
3. Поднимаем контейнеры: ```sudo docker-compose up -d --build```
4. В админере создаем базу данных, [http://localhost:8080](http://localhost:8080)
5. В папке ```src``` копируем файл ```.env.example``` -> ```.env``` и указываем настройки базы данных:
   - ```DB_HOST=db```
   - ```DB_PORT``` и ```DB_PASSWORD``` берём из настроек docker-compose
   - ```DB_DATABASE``` прасваиваем созданное вами имя
6. Заходим в докер контейнер ```web```: ```docker exec -it your_container_name bash```
   - генерируем ```APP_KEY```: ```php artisan key:generate```
   - выполняем миграции: ```php artisan migrate```