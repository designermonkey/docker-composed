.DEFAULT_GOAL := help

DC=docker-compose --env-file tests/.env -f tests/docker-compose.yaml

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)
.PHONY: help

test: ## Run the tests
	@${DC} build --verbose && \
	${DC} up -d database && \
	${DC} run phpunit && \
	${MAKE} down
.PHONY: test

down: ## Bring the docker composer environment down
	@${DC} down
.PHONY: down

remove: ## Remove the docker composer environment
	@${DC} rm -fsv
.PHONY: remove

database:
	${DC} up -d database;

phpunit:
	${DC} run phpunit
