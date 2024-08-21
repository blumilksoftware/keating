export COMPOSE_DOCKER_CLI_BUILD = 1
export DOCKER_BUILDKIT = 1

include .env

SHELL := /bin/bash

DOCKER_COMPOSE_FILE = docker-compose.yaml
DOCKER_COMPOSE_APP_CONTAINER = app
DOCKER_COMPOSE_DATABASE_CONTAINER = database

CURRENT_USER_ID = $(shell id --user)
CURRENT_USER_GROUP_ID = $(shell id --group)
CURRENT_DIR = $(shell pwd)

DATABASE_USERNAME=keating
TEST_DATABASE_NAME=keating-test

init: check-env-file
	@make build \
    && make run \
	&& docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} bash "./environment/dev/scripts/init.sh" \
	&& make create-test-db

check-env-file:
	@if [ ! -f ".env" ]; then \
	  echo "Create .env file and adjust." ;\
	  exit 1;\
	fi; \

build:
	@docker compose --file ${DOCKER_COMPOSE_FILE} build --pull

run:
	@docker compose --file ${DOCKER_COMPOSE_FILE} up --detach

stop:
	@docker compose --file ${DOCKER_COMPOSE_FILE} stop

restart: stop run

shell:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} bash

shell-root:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec ${DOCKER_COMPOSE_APP_CONTAINER}

dev:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} npm run dev

test:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} composer test

fix:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} bash -c 'composer csf && npm run lintf'

queue:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec --user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" ${DOCKER_COMPOSE_APP_CONTAINER} php artisan queue:work

create-test-db:
	@docker compose --file ${DOCKER_COMPOSE_FILE} exec ${DOCKER_COMPOSE_DATABASE_CONTAINER} bash -c 'createdb --username=${DATABASE_USERNAME} ${TEST_DATABASE_NAME} &> /dev/null && echo "Created database for tests (${TEST_DATABASE_NAME})." || echo "Database for tests (${TEST_DATABASE_NAME}) exists."'

encrypt-beta-env:
	@docker compose --file ${DOCKER_COMPOSE_FILE} run \
	--rm \
	--no-deps \
	--volume ${CURRENT_DIR}/environment/prod/deployment/beta:/envs \
	--entrypoint "" \
	--workdir /application \
	--user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" \
	${DOCKER_COMPOSE_APP_CONTAINER} \
	bash -c "cp /envs/.env.beta /application \
		&& php artisan env:encrypt --env beta --key ${BETA_ENV_KEY} \
		&& mv .env.beta.encrypted /envs \
		&& rm .env.beta"

decrypt-beta-env:
	@docker compose --file ${DOCKER_COMPOSE_FILE} run \
	--rm \
	--no-deps \
	--volume ${CURRENT_DIR}/environment/prod/deployment/beta:/envs \
	--entrypoint "" \
	--workdir /application \
	--user "${CURRENT_USER_ID}:${CURRENT_USER_GROUP_ID}" \
	${DOCKER_COMPOSE_APP_CONTAINER} \
	bash -c "cp /envs/.env.beta.encrypted /application \
		&& php artisan env:decrypt --env beta --key ${BETA_ENV_KEY} \
		&& mv .env.beta /envs \
		&& rm .env.beta.encrypted"

.PHONY: init check-env-file build run stop restart shell shell-root test fix create-test-db queue encrypt-beta-env decrypt-beta-env
