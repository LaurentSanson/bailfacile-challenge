# BailFacile Challenge

[BailFacile](https://www.bailfacile.fr/) is an online property management platform serving French landlords. We are building a super app for landlords assisting them in the daily management of long-term rentals : draft and e-sign compliant documents, record payments and outgoings, manage tenant relationships and much more, 100% digitally and for a reasonable cost.

## Docker containers

1. PHP
2. MYSQL
3. NGINX

## What's in there

1. A Symfony skeleton application
2. Symfony Flex
3. Annotations
4. Twig
5. Doctrine
6. Maker Bundle
7. PHP Unit, Paratest, Coverage-check and Dama Doctrine Bundle
8. PHPStan, PHP CS Fixer and Local PHP Security Checker
9. Webpack-Encore

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker-compose build --pull --no-cache` to build fresh images
3. Run `docker-compose up -d`

## After containers started

1. Prefix all your commands with `./php`. Example : `./php php -v`

```bash
make install #Install the project
bin/console d:m:m -n #Play the migrations (if there is any)
bin/console d:f:l -n #Load the fixtures
```

2. Open `https://localhost:8000` in your favorite web browser
3. Run `docker-compose down --volumes --remove-orphans` to stop the Docker containers.

## Play the tests

Run `make test`

## Credits

Created by [Laurent Sanson](https://github.com/LaurentSanson/).
