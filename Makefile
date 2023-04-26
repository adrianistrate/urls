rebuild:
	docker compose -f docker-compose.yml -f docker-compose.override.yml build --no-cache
run:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml up
in-php:
	docker exec -it urls-php-1 /bin/bash
rebuild-php:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml build php
