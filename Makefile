phpunit:
	vendor/bin/phpunit

phpspec:
	vendor/bin/phpspec run --ansi --no-interaction -f dot

phpstan:
	vendor/bin/phpstan analyse

composer:
	composer install --no-interaction --no-scripts

backend:
	tests/Application/bin/console sylius:install --no-interaction
	tests/Application/bin/console sylius:fixtures:load default --no-interaction

frontend:
	(cd tests/Application && yarn install --pure-lockfile)
	(cd tests/Application && GULP_ENV=prod yarn build)

rewrite:
	@while [ -z "$$plugin_name" ]; do \
	    read -p "Enter the name of your plugin: " plugin_name; \
	done; \
	while [ -z "$$description" ]; do \
    	read -p "Enter the description of your plugin: " description; \
    done; \
	while [ -z "$$organization" ]; do \
		read -p "Enter the name of your organization: " organization; \
	done; \
	converted_name=$$(echo $$plugin_name | sed -E 's/([a-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]'); \
	converted_organization=$$(echo $$organization | sed -E 's/([a-z0-9])([A-Z])/\1-\2/g' | tr '[:upper:]' '[:lower:]'); \
    converted_name="$${converted_organization}/sylius-$${converted_name#-}-plugin"; \
    jq --arg name "$$converted_name" '.name = $$name' composer.json > composer.tmp.json && mv composer.tmp.json composer.json; \
    jq --arg desc "$$description" '.description = $$desc' composer.json > composer.tmp.json && mv composer.tmp.json composer.json; \
    namespace="$${organization}\\Sylius$${plugin_name}Plugin"; \
    namespaceTest="Tests\\$$namespace"; \
    nameFile="$${organization}Sylius$${plugin_name}Plugin"; \
    namePlugin="$${organization}\\\Sylius$${plugin_name}Plugin"; \
    jq --arg namespace "$$namespace" --arg namespaceTest "$$namespaceTest" \
       'del(.autoload["psr-4"]) | .autoload["psr-4"] = { ($$namespace + "\\"): "src/", ($$namespaceTest + "\\"): "tests/" }' composer.json > composer.tmp.json && mv composer.tmp.json composer.json; \
    mv src/AcmeSyliusExamplePlugin.php src/$${nameFile}.php; \
    sed -i '' "s#class AcmeSyliusExamplePlugin#class $${nameFile}#g" src/$${nameFile}.php; \
    sed -i '' "s#namespace Acme\\\SyliusExamplePlugin#namespace $${namePlugin}#g" src/$${nameFile}.php;  \
    sed -i '' "s#Acme\\\\SyliusExamplePlugin\\\\AcmeSyliusExamplePlugin::class#$${namePlugin}\\\\$${nameFile}::class#g" tests/Application/config/bundles.php;  \
    sed -i '' "s#Acme\\\\SyliusExamplePlugin#$${namePlugin}#g" phpspec.yml.dist; \
    sed -i '' "s#namespace Tests\\\Acme\\\SyliusExamplePlugin\\\Application#namespace Tests\\\\$${namePlugin}\\\\Application#g" tests/Application/Kernel.php;  \
    sed -i '' "s#use Tests\\\Acme\\\SyliusExamplePlugin\\\Application\\\Kernel#use Tests\\\\$${namePlugin}\\\\Application\\\Kernel#g" tests/Application/bin/console;  \

install: composer backend frontend

ci: install phpstan phpunit phpspec

integration: install phpunit

static: install phpspec phpstan

init: rewrite install
