.PHONY: up
up:
	docker-compose up -d

.PHONY: db
db: vendor
	php bin/console doctrine:migrations:migrate --no-interaction
	php bin/console app:add-admin admin admin

.PHONY: tests
tests: vendor
	php bin/console doctrine:migrations:migrate --no-interaction -n --env=test
	php bin/console app:add-admin admin admin --env=test
	php bin/phpunit
	php bin/console doctrine:schema:drop --full-database --force --env=test

vendor: composer.json composer.lock
	composer install