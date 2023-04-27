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

# Context

- URLS can be 2048 characters long
- the overall domain name, including subdomain + actual domain name + TLD, can be 253 characters long
- pathname can be 2048 - 253 - 7 (worst case scenario http://) = 1788 characters long, worst case scenario
- parameter can be 2048 - 253 - 7 - 3 (?, =, and 1 min character for parameter val) = 1785 characters long, worst case scenario

- https://stackoverflow.com/questions/10552665/names-and-maximum-lengths-of-the-parts-of-a-url
- 3072 bytes can fit 768 characters, worst case scenario

# Implementation

- in webpage, the domain will have a max length of 253 characters and the pathname will have a max length of 1788 characters
- there is an index on the domain column
- there is a index prefix length of 768 on the domain column
- the webpage_parameter has a column parameter with a max length of 1785 characters and a index prefix length of 768
- the val column from webpage_parameter doesn't really matter. based on further requirements it can even be taken out
