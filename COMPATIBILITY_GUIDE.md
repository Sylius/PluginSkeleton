# Compatibility With Sylius Guide for AI

This guide explains how to configure the Plugin to work with different versions of Sylius (2.2 and 2.3) and Symfony (6.4, 7.4 and 8.0).

## Supported Versions

| Sylius | Symfony              | PHP     |
|--------|----------------------|---------|
| 2.2.x  | ^6.4 \|\| ^7.4       | >= 8.2  |
| 2.3.x  | ^6.4 \|\| ^7.4 \|\| ^8.0 | >= 8.2 (>= 8.4.1 for Symfony 8) |

## Key Compatibility Changes

### 1. Composer Configuration

To support multiple Sylius and Symfony versions, update your `composer.json`:

```json
{
    "require": {
        "php": "^8.2",
        "sylius/sylius": "^2.2"
    },
    "require-dev": {
        "behat/behat": "^3.22 || 4.0.0-alpha1",
        "phpstan/phpstan": "^2.1",
        "sylius/sylius-rector": "^3.0",
        "sylius/test-application": "^2.0.0@alpha",
        "symfony/browser-kit": "^6.4 || ^7.4 || ^8.0"
    },
    "prefer-stable": true
}
```

**Important notes:**
- Use `prefer-stable: true` to prefer stable packages when available
- Use version constraints with `||` operator to support multiple versions

### 2. No XML Configuration

Symfony 8 removed XML support for service configuration. Use PHP files only:
- Plugin services: `config/services.php`
- Behat services: `tests/Behat/Resources/services.php`

Sylius 2.3 ships its own Behat services and suites as PHP, while Sylius 2.2 still uses XML/YAML. Import them conditionally:

```php
// tests/TestApplication/config/services_test.php
$syliusBehatServices = '../../../vendor/sylius/sylius/src/Sylius/Behat/Resources/config/services';
$container->import(is_file(__DIR__ . '/' . $syliusBehatServices . '.php') ? $syliusBehatServices . '.php' : $syliusBehatServices . '.xml');
```

The same pattern is used for Sylius suites in `behat.dist.php`.

### 3. Behat

- Configuration lives in `behat.dist.php` (`Behat\Config\Config`), suites in `tests/Behat/Resources/suites.php`
- Step definitions must use attributes (`#[Given]`, `#[When]`, `#[Then]` from `Behat\Step`), not annotations

### 4. Testing Across Versions

1. **Install a specific combination:**
   ```bash
   # Sylius 2.2 with Symfony 7.4
   SYMFONY_REQUIRE="^7.4" composer update --with "sylius/sylius:~2.2.0" -W

   # Sylius 2.3 with Symfony 8 (PHP >= 8.4.1)
   SYMFONY_REQUIRE="^8.0" composer update --with "sylius/sylius:~2.3.0" -W
   ```

2. **Run tests:**
   ```bash
   vendor/bin/phpstan analyse
   vendor/bin/phpunit
   vendor/bin/behat
   ```

## Best Practices

1. **Use Conservative Constraints**: When supporting multiple versions, use the most conservative approach that works across all versions.

2. **Test Thoroughly**: Always test your plugin with each supported Sylius version before release.

3. **Document Version-Specific Features**: If certain features only work with specific Sylius versions, document this clearly.

4. **Use CI/CD**: The `.github/workflows/build.yaml` matrix already covers all supported Sylius, Symfony and PHP combinations.

## Troubleshooting

### Common Issues

1. **Service not found errors**: Check that service IDs haven't changed between versions.

2. **XML loader errors on Symfony 8**: Convert any remaining `.xml` service files to `.php`.

3. **Dependency conflicts**: Use `composer why-not` to debug version constraint issues.
