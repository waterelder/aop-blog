#!/usr/bin/env bash

project_path="/code"

function run {
    cd ${project_path} && $@
}

function post_deploy {
    run mkdir -p var/cache
    run mkdir -p var/logs
    run mkdir -p web/uploads
    run cp app/config/parameters_docker.yml app/config/parameters.yml
    run php bin/console --env=test doctrine:database:create --if-not-exists
    run php composer.phar install  --optimize-autoloader
    run php bin/console cache:clear --no-debug --no-warmup --env="$1"
    run php bin/console doctrine:migrations:status --env="$1"
    run php bin/console doctrine:migrations:migrate --no-interaction --env="$1"
    if  ["$1" == "dev"] || [ "$1" == "test" ] ;
    then run php bin/console doctrine:fixtures:load --no-interaction --env="$1"
    fi
    run chmod -R 777 web/uploads
    run chmod -R 777 var/logs
    run chmod -R 777 var/cache

}

post_deploy $1

