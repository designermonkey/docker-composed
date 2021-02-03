defaults = .env.defaults
env = .env

-include $(defaults)
export $(shell sed 's/=.*//' $(defaults) > /dev/null 2>&1)

-include $(env)
export $(shell sed 's/=.*//' $(env) > /dev/null 2>&1)


DOCKER_COMMAND="docker-compose -p ${APP_NAME}"
PROD=-f docker-compose.yaml
DEV=-f docker-compose.dev.yaml
TEST=-f docker-compose.tst.yaml


.PHONY: help
.DEFAULT_GOAL := help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

htpasswd: ## gnerate a bcrypt username:password combination for mailhog
	eval htpasswd -nbBC 12 ${SMTP_USERNAME} ${SMTP_PASSWORD} > ./smtp/htpasswd


build: ## Build the docker containers for production use
	eval ${DOCKER_COMMAND} ${PROD} build

test_build: ## Build the docker containers for testing use
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} ${TEST} build

dev_build: htpasswd ## Build the docker containers for development use
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} build


up: build ## Bring the environment as production
	eval ${DOCKER_COMMAND} ${PROD} up

test_up: test_build ## Bring the environment as testing
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} ${TEST} up

dev_up: dev_build ## Bring the environment as development
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} up


down: ## Bring all of the containers down
	eval ${DOCKER_COMMAND} ${PROD} down --remove-orphans

test_down: ## Bring all of the containers down
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} ${TEST} down --remove-orphans

dev_down: ## Bring all of the containers down
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} down --remove-orphans


stop: ## Stop all the containers
	eval ${DOCKER_COMMAND} ${PROD} stop

test_stop: ## Stop all the containers
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} ${TEST} stop

dev_stop: ## Stop all the containers
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} stop


clean: ## Clean up the environment and remove all images
	eval ${DOCKER_COMMAND} ${PROD} down --rmi 'all'

test_clean: ## Clean up the environment and remove all images
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} ${TEST} down --rmi 'all'

dev_clean: ## Clean up the environment and remove all images
	eval ${DOCKER_COMMAND} ${PROD} ${DEV} down --rmi 'all'
