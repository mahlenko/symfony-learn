# Get arguments command
@args = $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

#
# Docker compose
# ===============================================================
build:
	docker-compose -f docker/docker-compose.yml build
up:
	docker-compose -f docker/docker-compose.yml up -d
down:
	docker-compose -f docker/docker-compose.yml down

# Composer
composer:
	docker-compose -f docker/docker-compose.yml run --rm php-fpm composer $(args)

#
test:
	docker-compose -f docker/docker-compose.yml run --rm php-fpm ./vendor/bin/phpunit
