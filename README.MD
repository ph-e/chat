# PHP Online Chat
## Installation requirements
- [PHP 8.1](https://www.php.net/downloads.php)<br>
- [Node js](https://nodejs.org/en/download)<br>
- [MySQL](https://www.mysql.com/downloads/)<br>
- [Composer](https://getcomposer.org/download/)<br>
## Installation process
- Clone this repo
```
git clone https://github.com/ph-e/chat
```
- Create MySQL DB and import sql file from folder database
- Open the `src` folder in the console and write the following commands:
```
composer require workerman/workerman
```
```
npm install -g http-server
```
## Run process
- Run MySQL Server
- Open folder `YOU_FOLDER_NAME/chat/src`
- Write the following commands
```
php server/server.php
```
```
http-server client
```