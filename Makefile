rebuild:
	docker compose -f docker-compose.yml -f docker-compose.override.yml build --no-cache
run:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml up
in-php:
	docker exec -it urls-php-1 /bin/bash
in-db:
	docker exec -it urls-database-1 /bin/bash
rebuild-php:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml build php
rebuild-db:
	docker-compose -f docker-compose.yml -f docker-compose.override.yml build database
