## Развернем среду используя контейнеры docker
1. Установим docker: https://docs.docker.com/v17.09/engine/installation/
2. Устновим GIT: https://habr.com/ru/post/125799/
3. Делаем клон репозитария 
```
git clone https://github.com/vipsiteedit/RestApiSymfony4.git
```
4. Разворачиваем среду с проектом
```
$ docker-compose up -d
или
docker-compose-start.sh
```
а для удаления контейнера воспользуйтесь командным файлом 
```
docker-compose-remove.sh
```

После успешной установки введитн адрес API для получения результатов игр
```
127.0.0.1:8000/api/games
```

Для проверки можно воспользоватья PMA ее адрес:
```
http://127.0.0.1:8083/

Login   : root
Password: root
```

Отправка данных в API
```
curl -i -X POST \
   -H "Content-Type:application/json" \
   -d \
'[
 {
   "Lang":  "русский",
   "Sport": "футбол",
   "Ligue": "Лига чемпионов УЕФА",
   "Team1": "Реал",
   "Team2": "Барселона",
   "StartGame":"2019-01-01 01:01:01",
   "SourceInfo": "sportdata.com"
 },
 {
   "Lang":  "en",
   "Sport": "futbol",
   "Ligue": "Liga UEFA",
   "Team1": "Real",
   "Team2": "Barcelona",
   "StartGame":"2019-01-01 01:01:01",
   "SourceInfo": "anotherdata.com"
 },
   {
   "Lang":  "русский",
   "Sport": "футбол",
   "Ligue": "Лига чемпионов УЕФА",
   "Team1": "Реал",
   "Team2": "Барселона",
   "StartGame":"2019-01-01 04:01:01",
   "SourceInfo": "sportdata.com"
 }

]' \
 'http://127.0.0.1:8000/api/games'
```

## Install Symfony 4
Запускаем установку symfony:
```
$ wget https://get.symfony.com/cli/installer -O - | bash
```
Конфигурируем путь:

```
export PATH="$HOME/.symfony/bin:$PATH"
```

Процесс установки подробно описан на сайте <a href="https://symfony.com/download">Symfony.com</a>

Запускаем composer и устанавливаем все зависимости

```
cd www/app
composer install
```
## Описание задачи
