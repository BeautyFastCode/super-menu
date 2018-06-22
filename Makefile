
# Before run this, configure database connection in file .env
# install:
	# composer install
	# reset
	# js-build

# Reset the database.
#
reset:
	bin/console doctrine:database:drop --force
	bin/console doctrine:database:create
	bin/console doctrine:schema:update --force

	bin/console doctrine:fixtures:load -n

	bin/console cache:clear
	bin/console cache:warmup

# Development server.
#
dev:
	bin/console server:run

# Build JavaScript
#
js-build:
	yarn install
	yarn run build
