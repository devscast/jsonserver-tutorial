# JsonPlaceHolder
A hard coded PHP clone of https://jsonplaceholder.typicode.com
. 
You will need PHP 7.4 to run this project.

## installation
```bash

$ git clone https://github.com/devscast/tutorial-jsonserver.git jsonplaceholder
$ cd jsonplaceholder
$ composer install 
$ php -S localhost:2000
```

you can start sending request to ```http://localhost:2000```. cors is enable by default.

## Rest API
restAPI for ``posts`` and ```users```
```http request
GET /posts
GET /posts/1
PUT /posts/1
DELETE /posts/1
POST /posts/1

GET /users
GET /users/1
PUT /uerss/1
DELETE /uerss/1
POST /uerss/1
```
