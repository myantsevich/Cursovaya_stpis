Before start
============

+ **[Download and install](https://docs.docker.com/engine/installation/) Docker for your platform**

Installation
============

+ **Create folder in your local web directory (e.g. _belkin_dom_)**

```bash
$ cd belkin_dom
```

+ **Clone project**

```bash
$ git clone git@bitbucket.org:clarityproject/bd.git
```

+ **Copy .env.dist file to .env and change values of parameters in .env file to any you wish**
```bash
$ cp .env.dist .env
$ nano .env 
```

+ **Run the application**

```bash
$ make start
```

+ **To stop the application**

```bash
$ make stop
```

+ **To see all running containers**

```bash
$ docker-compose ps
```

Prepare env for development
===========================
+ **Connect to php container**

```bash
$ docker exec -it bd-php bash
```

+ **To exit from container run**

```bash
$ exit
```

+ **Install vendors**

```bash
$ composer install
```

Run
===

+ **Open in browser ```http://localhost:11235/```**
