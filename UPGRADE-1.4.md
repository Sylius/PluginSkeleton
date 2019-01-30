# UPGRADE FROM `v1.3.X` TO `v1.4.0`

First step is upgrading Sylius with composer

- `composer require sylius/sylius:~1.4.0`

### Test application database

#### Migrations

If you use migrations in your plugin's test application, take a look at following changes:

* Change base `AbstractMigration` namespace to `Doctrine\Migrations\AbstractMigration`
* Add `: void` return types to both `up` and `down` functions
* Copy [this](https://github.com/Sylius/Sylius-Standard/blob/1.4/src/Migrations/Version20190109095211.php) and [this](https://github.com/Sylius/Sylius-Standard/blob/1.4/src/Migrations/Version20190109160409.php) migration to your migrations folder or run `(cd tests/Application && bin/console doctrine:migrations:diff)` to generate new migration with changes from **Sylius**
* Apply new migrations with `(cd tests/Application && bin/console doctrine:migrations:migrate)`

#### Schema update

If you don't use migrations, just run `(cd tests/Application && bin/console doctrine:schema:update --force)` to update the test application's database schema.

### Dotenv

* `composer require symfony/dotenv:^4.2 --dev`
* Follow [Symfony dotenv update guide](https://symfony.com/doc/current/configuration/dot-env-changes.html) to incorporate required changes in `.env` files structure. Remember - they should be done on `tests/Application/` level! Optionally, you can take a look at [corresponding PR](https://github.com/Sylius/PluginSkeleton/pull/156/) introducing these changes in **PluginSkeleton** (this PR also includes changes with Behat - see below)

Don't forget to clear the cache (`tests/Application/bin/console cache:clear`) to be 100% everything is loaded properly.

---

### Behat

If you're using Behat and want to be up-to-date with our configuration

* Update required extensions with `composer require friends-of-behat/symfony-extension:^2.0 friends-of-behat/page-object-extension:^0.3 --dev`
* Remove extensions that are not needed yet with `composer remove friends-of-behat/context-service-extension friends-of-behat/cross-container-extension friends-of-behat/service-container-extension --dev`
* Update your `behat.yml` - look at the diff [here](https://github.com/Sylius/Sylius-Standard/pull/322/files#diff-7bde54db60a6e933518d8b61b929edce)
* Add `SymfonyExtensionBundle` to your `tests/Application/config/bundles.php`:
    ```php
    return [
        //...
        FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle::class => ['test' => true, 'test_cached' => true],
    ];
    ```
* If you use our Travis CI configuration, follow [these changes](https://github.com/Sylius/PluginSkeleton/pull/156/files#diff-354f30a63fb0907d4ad57269548329e3) introduced in `.travis.yml` file
* Create `tests/Application/config/services_test.yaml` file with the following code and add these your own Behat services as well:
    ```yaml
    imports:
        - { resource: "../../../vendor/sylius/sylius/src/Sylius/Behat/Resources/config/services.xml" }
    ```
* Remove all `__symfony__` prefixes in your Behat services
* Remove all `<tag name="fob.context_service" />` tags from your Behat services
* Make your Behat services public by default with `<defaults public="true" />`
* Change `contexts_services ` in your suite definitions to `contexts`
* Take a look at [SymfonyExtension UPGRADE guide](https://github.com/FriendsOfBehat/SymfonyExtension/blob/master/UPGRADE-2.0.md) if you have any more problems
