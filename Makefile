phpunit:
	vendor/bin/phpunit

phpspec:
	vendor/bin/phpspec run --ansi --no-interaction -f dot

phpstan:
	vendor/bin/phpstan analyse

psalm:
	vendor/bin/psalm

behat-js:
	APP_ENV=test vendor/bin/behat --colors --strict --no-interaction -vvv -f progress

install:
	composer install --no-interaction --no-scripts

backend:
	tests/Application/bin/console sylius:install --no-interaction
	tests/Application/bin/console sylius:fixtures:load default --no-interaction

frontend:
	(cd tests/Application && yarn install --pure-lockfile)
	(cd tests/Application && GULP_ENV=prod yarn build)

rewrite:
	@read -p "Enter the name of your plugin: " plugin_name; \
    read -p "Enter the description of your plugin: " description; \
    converted_name=$$(echo $$plugin_name | sed 's/\([A-Z]\)/-\1/g' | tr '[:upper:]' '[:lower:]'); \
    converted_name="acseo/sylius-$${converted_name#-}-plugin"; \
    jq --arg name "$$converted_name" '.name = $$name' composer.json > composer.tmp.json && mv composer.tmp.json composer.json; \
    jq --arg desc "$$description" '.description = $$desc' composer.json > composer.tmp.json && mv composer.tmp.json composer.json; \
    echo "The description of your plugin is $$description"; \
    namespace="Acseo\\Sylius$${plugin_name}Plugin"; \
    namespaceTest="Tests\\$$namespace"; \
    nameFile="AcseoSylius$${plugin_name}Plugin"; \
    namePlugin="Acseo\\\Sylius$${plugin_name}Plugin"; \
    jq --arg namespace "$$namespace" --arg namespaceTest "$$namespaceTest" \
       'del(.autoload["psr-4"]) | .autoload["psr-4"] = { ($$namespace + "\\"): "src/", ($$namespaceTest + "\\"): "tests/" }' composer.json > composer.tmp.json && mv composer.tmp.json composer.json; \
    mv src/AcmeSyliusExamplePlugin.php src/$${nameFile}.php; \
    sed -i '' "s#class AcmeSyliusExamplePlugin#class $${nameFile}#g" src/$${nameFile}.php; \
    sed -i '' "s#namespace Acme\\\SyliusExamplePlugin#namespace $${namePlugin}#g" src/$${nameFile}.php;  \
    sed -i '' "s#Acme\\\\SyliusExamplePlugin\\\\AcmeSyliusExamplePlugin::class#$${namePlugin}\\\\$${nameFile}::class#g" tests/Application/config/bundles.php

init: rewrite install backend frontend

ci: init phpstan psalm phpunit phpspec

integration: init phpunit behat

static: install phpspec phpstan psalm
