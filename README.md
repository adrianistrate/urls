# URLS

## Build and start

```bash
make run
```

## PHP Container - build db

Run in host

```bash
make in-php
php bin/console doctrine:migrations:migrate --env=dev -vvv --no-interaction
```

# MySQL Container - load data

Run in host

```bash
make in-db
cd /var/lib/mysql-files
mysql -h database -uroot -ppassword urls
```

## Inside MySQL

```bash
USE urls;
LOAD DATA INFILE '/var/lib/mysql-files/alexa-domains.txt'
    INTO TABLE domain_list
    FIELDS TERMINATED BY ','
    ENCLOSED BY '"'
    LINES TERMINATED BY '\n'
    (domain);
```

## Generate 1 mil urls (back in php container)

Wait about 5 mins

```bash
php bin/console urls:generate --env=dev -vvv
```

## How to use

Inside PHP container run:

```bash
php bin/console urls:check --env=dev -vvv
```

If you want to add a new url:

```bash
php bin/console urls:add --env=dev -vvv
```
