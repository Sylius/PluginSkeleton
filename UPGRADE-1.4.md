# UPGRADE FROM `v1.3.X` TO `v1.4.0`

First step is upgrading Sylius with composer

- `composer require sylius/sylius:~1.4.0`

### Test application database

#### Migrations

If you provide migrations with your plugin, take a look at following changes:

* Change base `AbstractMigration` namespace to `Doctrine\Migrations\AbstractMigration`
* Add `: void` return types to both `up` and `down` functions

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

### Phpstan

* Fix the container XML path parameter in the `phpstan.neon` file as done [here](https://github.com/Sylius/PluginSkeleton/commit/37fa614dbbcf8eb31b89eaf202b4bd4d89a5c7b3)

# UPGRADE FROM `v1.2.X` TO `v1.4.0`

Firstly, check out the [PluginSkeleton 1.3 upgrade guide](https://github.com/Sylius/PluginSkeleton/blob/1.4/UPGRADE-1.3.md) to update Sylius version step by step.
To upgrade to Sylius 1.4 follow instructions from [the previous section](https://github.com/Sylius/PluginSkeleton/blob/1.4/UPGRADE-1.4.md#upgrade-from-v13x-to-v140) with following changes:

### Doctrine migrations

* Change namespaces of copied migrations to `Sylius\Migrations`

### Dotenv

* These changes are not required, but can be done as well, if you've changed application directory structure in `1.2.x` to `1.3` update

### Behat

* Add `\FriendsOfBehat\SymfonyExtension\Bundle\FriendsOfBehatSymfonyExtensionBundle()` to your bundles lists in `tests/Application/AppKernel.php` (preferably only in `test` environment)
* Import Sylius Behat services in `tests/Application/config/config_test.yml` and your own Behat services as well:
    ```yaml
    imports:
        - { resource: "../../../../vendor/sylius/sylius/src/Sylius/Behat/Resources/config/services.xml" }
    ```
* Specify test application's kernel path in `behat.yml`:
    ```yaml
     FriendsOfBehat\SymfonyExtension:
        kernel:
          class: AppKernel
          path: tests/Application/app/AppKernel.php
    ```
