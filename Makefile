.PHONY: build build-assets cache composer-install composer-update create-network help install install-sylius jwt up update

CONFIG_DIR=api/config
DC=docker-compose
DC_UP=$(DC) up -d
DC_EXEC=$(DC) exec php
BIN_CONSOLE=$(DC_EXEC) bin/console

help:
	@grep -E '(^[0-9a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-25s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

build: ## Build
	$(DC) build
	$(DC_UP)

build-assets: ## Build assets for production
	yarn encore production
	rm -r ./public/build/shop || true
	scp -r ./public/media/shop ./public/build/shop
	$(MAKE) cache

cache: ## Clear cache
	$(BIN_CONSOLE) cache:clear

composer-install: ## Install composer packages
	$(DC_EXEC) composer install

composer-update: ## Update composer
	$(DC_EXEC) composer update

copy-files-prod: ## Copy prod files to dev
	cp .env.prod .env
	cp docker-compose.prod.yml docker-compose.yml

create-network: ## Create docker network if not exists
	docker network create nxclient_website || true

install: create-network up jwt composer-install install-sylius cache ## Install and setup project

install-sylius: ## Install and setup project
	$(BIN_CONSOLE) sylius:install

jwt: ## Generate jwt
	sh ./generateJWT.sh

up: ## Start containers
	$(DC_UP)

update: ## Update containers composer packages then re-up containers
	$(DC) pull
	$(MAKE) composer-update
	$(MAKE) up
