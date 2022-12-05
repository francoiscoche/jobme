# JobMe
## Symfony 6/Docker project. Made to learn.

&nbsp;

Developpement in progress...

&nbsp;



## Run localy the project

&nbsp;

Clone the project

```bash
git clone git@github.com:francoiscoche/jobme.git
```
Run the docker-compose

```bash
docker-compose build
docker-compose up -d
```

Copy the vendor folder to the container (did for performance purpose)
```bash
cd .\app\
docker cp vendor jobme-php8:/var/www/app
docker cp var jobme-php8:/var/www/app
```

Log into the PHP container

```bash
docker exec -it jobme-php8 bash
```

Start the server

```bash
symfony serve -d
```

*The application is available at http://127.0.0.1:8000*

&nbsp;
## Author

[@francoiscoche](https://github.com/francoiscoche)
