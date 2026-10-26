# Plugin Rename Guide for AI

This guide provides step-by-step instructions for AI assistants to rename a Sylius plugin from the default skeleton name to a custom name.

## Prerequisites

Before renaming the plugin, ensure that:
1. **The plugin is in a clean state** - All example/demo code should be removed first
2. **Run CLEANUP_GUIDE.md first** if the plugin still contains example code
3. **Backup your work** - Commit any important changes before starting the rename process
4. **Close any running servers** - Stop Symfony server, Docker containers, etc.

## Overview

The default plugin skeleton uses:
- Company namespace: `Acme`
- Plugin name: `SyliusExamplePlugin`
- Full namespace: `Acme\SyliusExamplePlugin`

## Naming Convention

Sylius plugins should follow this naming pattern:
- Format: `{CompanyName}\{PluginName}`
- Plugin name should start with `Sylius` prefix
- Example: `Acme\SyliusShopUserCleanupPlugin`

## Recommended Order of Operations

To ensure a smooth renaming process, follow this order:

1. **Rename PHP files** - Start with the physical file renames
2. **Update PHP namespaces** - Update all namespace declarations and class names
3. **Update composer.json** - Change package name and autoload configurations
4. **Update configuration files** - Modify all YAML/PHP configurations
5. **Update environment files** - Change database names and bundle references
6. **Update documentation** - Modify CLAUDE.md and other docs
7. **Validate and cleanup** - Run composer commands and verify changes

## Files to Rename

1. **Main plugin class file:**
   ```
   src/AcmeSyliusExamplePlugin.php → src/{CompanyName}{PluginName}.php
   ```

2. **DependencyInjection extension file:**
   ```
   src/DependencyInjection/AcmeSyliusExampleExtension.php → src/DependencyInjection/{CompanyName}{PluginName}Extension.php
   ```

## Files to Update

### 1. Environment Files (.env, .env.test)

Update in `tests/TestApplication/.env`:
```env
DATABASE_URL=mysql://root:root@127.0.0.1/{company_name_snake}_{plugin_name_snake}_%kernel.environment%
CONFIGS_TO_IMPORT="@{CompanyName}{PluginName}/tests/TestApplication/config/config.yaml"
ROUTES_TO_IMPORT="@{CompanyName}{PluginName}/config/shop_routing.yaml"
```

Update in `tests/TestApplication/.env.test`:
```env
DATABASE_URL=mysql://root:root@127.0.0.1/{company_name_snake}_{plugin_name_snake}_%kernel.environment%
```

Note: The `{company_name_snake}_{plugin_name_snake}` should be the snake_case version of your plugin name, e.g., `acme_sylius_shop_user_cleanup_plugin`.

### 2. composer.json

Update package metadata and PSR-4 autoload mappings:

**Package Information:**
```json
{
    "name": "{company-name-kebab}/{plugin-name-kebab}",
    "description": "Brief description of your Sylius plugin functionality",
    "type": "sylius-plugin"
}
```

**PSR-4 Autoload Mappings:**
```json
"autoload": {
    "psr-4": {
        "{CompanyName}\\{PluginName}\\": "src/"
    }
},
"autoload-dev": {
    "psr-4": {
        "Tests\\{CompanyName}\\{PluginName}\\": ["tests/", "tests/TestApplication/src/"]
    }
}
```

**Important Notes:**
- Package name should use kebab-case format: `{company-name}/{plugin-name}`
- Company name in package should be lowercase
- Plugin name should be descriptive and include `sylius` prefix
- Description should briefly explain what the plugin does

### 3. PHP Files - Update Namespaces

Update namespace declarations in:
- `src/{CompanyName}{PluginName}.php`
- `src/DependencyInjection/{CompanyName}{PluginName}Extension.php`
- `src/DependencyInjection/Configuration.php` - **Important: Often missed!**
- `src/Controller/*.php`
- Any other PHP files in src/

Also update:
- Class names to match new plugin name
- Twig namespace references from `@AcmeSyliusExamplePlugin` to `@{CompanyName}{PluginName}`
- In `Configuration.php`, update the TreeBuilder parameter:
  ```php
  $treeBuilder = new TreeBuilder('{company_name_snake}_{plugin_name_snake}');
  ```

### 4. Configuration Files

Update Twig namespace references in:
- `config/app/twig_hooks/admin.yaml`
- `config/app/twig_hooks/shop.yaml`
- `tests/TestApplication/config/config.yaml`
- `tests/TestApplication/config/services_test.php`

### 5. Test Configuration

Update in `tests/TestApplication/config/bundles.php`:
```php
return [
    {CompanyName}\{PluginName}\{CompanyName}{PluginName}::class => ['all' => true],
];
```

### 6. Documentation

Update `CLAUDE.md` to reflect the new plugin name and namespace.

## Search and Replace Summary

| Find | Replace |
|------|---------|
| `Acme\SyliusExamplePlugin` | `{CompanyName}\{PluginName}` |
| `AcmeSyliusExamplePlugin` | `{CompanyName}{PluginName}` |
| `AcmeSyliusExampleExtension` | `{CompanyName}{PluginName}Extension` |
| `@AcmeSyliusExamplePlugin` | `@{CompanyName}{PluginName}` |
| `Tests\Acme\SyliusExamplePlugin` | `Tests\{CompanyName}\{PluginName}` |

### Composer.json Specific Updates

| Field | Value |
|-------|-------|
| `name` | `{company-name-kebab}/{plugin-name-kebab}` |
| `description` | Brief plugin description |

## Additional Files to Check

Don't forget to also check and update:
- `tests/TestApplication/.env.local` (if exists)
- Any other `.env.*` files in the test application
- `tests/Behat/Resources/services.php` - may contain old service references
- `tests/Behat/Resources/suites.php` and `behat.dist.php` - may contain old service IDs or namespaces
- `phpspec.yml.dist` (if exists) - contains namespace configuration
- Any custom configuration files you may have added
- Database names should use snake_case format

## Verification Steps

After renaming, verify:

1. **Validate composer.json**:
   ```bash
   composer validate
   ```
   Note: Warning about composer.lock being out of date is normal and expected

2. **Regenerate autoload files**:
   ```bash
   composer dump-autoload
   ```

3. **Search for remaining old references**:
   ```bash
   grep -r "SyliusExamplePlugin\|sylius_example" . --exclude-dir=vendor --exclude-dir=var --exclude-dir=.git
   ```
   Only documentation files (like this guide) should contain these references

4. **Check all critical files**:
   - Ensure composer.json has package name and description
   - Verify all PHP files have correct namespace declarations
   - Confirm environment variables are updated in all `.env*` files
   - Check that `TreeBuilder` parameter in Configuration.php uses snake_case

5. **Clear Symfony cache** (if in a Sylius app):
   ```bash
   bin/console cache:clear
   ```

6. **Test the plugin**:
   - Try to install it in a test Sylius application
   - Check that bundle is properly registered
   - Verify routes are accessible

## Example Transformation

From default skeleton:
- `Acme\SyliusExamplePlugin\AcmeSyliusExamplePlugin`
- `@AcmeSyliusExamplePlugin/templates/...`

To custom plugin (example):
- `MyCompany\SyliusAwesomeFeaturePlugin\MyCompanySyliusAwesomeFeaturePlugin`
- `@MyCompanySyliusAwesomeFeaturePlugin/templates/...`

## Troubleshooting

### Autoloading Issues

**Problem**: `Class not found` errors after renaming
**Solution**: 
```bash
composer dump-autoload
rm -rf var/cache/*  # Clear Symfony cache
```

### Namespace Not Found Errors

**Problem**: PHP fatal errors about namespaces
**Solution**: 
1. Check all PHP files have correct `namespace` declarations
2. Verify composer.json autoload paths match your namespaces
3. Ensure class names match file names

### Plugin Not Loading in Sylius

**Problem**: Plugin doesn't appear to be registered
**Solution**:
1. Check `tests/TestApplication/config/bundles.php` has correct class reference
2. Verify all configuration imports use new namespace `@NewPluginName`
3. Clear cache and restart server

### Database Connection Issues

**Problem**: Cannot connect to database during tests
**Solution**:
1. Ensure all `.env*` files have updated database names
2. Database names should use snake_case format
3. Check that database actually exists

### Composer Validation Warnings

**Problem**: `composer validate` shows warnings
**Solution**:
- "Lock file out of date" is normal after renaming
- Missing package name: Add `"name"` field to composer.json
- Missing description: Add meaningful `"description"` field

## Common Pitfalls

1. **composer.json package information** - The skeleton doesn't include package name and description:
   - Add `"name"` field using kebab-case format
   - Add `"description"` field with meaningful description
   - Package name is required for publishing or private repositories

2. **Configuration.php** - This file is often missed because PHPStan excludes it. Always check:
   - Namespace is updated
   - TreeBuilder parameter uses snake_case format without `_plugin` suffix

3. **Environment files** - All `.env*` files in `tests/TestApplication/` need updating

4. **Database names** - Should use snake_case format with full plugin name

5. **Test files cleanup** - Don't forget to update or remove:
   - `tests/Behat/Resources/services.php` - may contain old service references
   - Any remaining example/demo test files

6. **Not removing example code first** - Always run CLEANUP_GUIDE.md before renaming:
   - Example code can cause confusion with old references
   - Clean slate makes renaming much easier

7. **Forgetting autoload regeneration** - Always run after changes:
   - `composer dump-autoload` to regenerate class maps
   - Clear Symfony cache if working in Sylius environment

## Important Notes

1. Always maintain the `Sylius` prefix in the plugin name
2. Keep the company name consistent across all files
3. The DependencyInjection extension class must end with `Extension`
4. Twig namespaces use `@` prefix followed by the full plugin class name
5. Don't forget to update test configurations in `tests/TestApplication/`
6. The Configuration TreeBuilder name should match the extension alias (snake_case)
7. **Package name in composer.json is mandatory** for proper plugin identification and distribution
