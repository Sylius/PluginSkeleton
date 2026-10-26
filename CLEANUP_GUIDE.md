# Removing Customizations from Sylius Plugin Guide for AI

This guide helps AI assistants remove example customizations from a Sylius Plugin Skeleton.

## Step 1: Search for Example Code

First, identify all files related to the customization (e.g., "greeting", "example", "demo"):

```bash
# Search for class names, function names, and references
grep -r "greeting" . --include="*.php" --include="*.js" --include="*.yml" --include="*.yaml" --include="*.xml" --include="*.twig"
grep -r "example" . --include="*.php" --include="*.js" --include="*.yml" --include="*.yaml" --include="*.xml" --include="*.twig"
```

## Step 2: Identify Files to Delete

Common locations for example files in Sylius plugins:

### Controllers
- `src/Controller/*ExampleController.php`
- `src/Controller/*DemoController.php`

### Frontend Assets
- `assets/shop/js/*.js` (example scripts)
- `assets/admin/js/*.js` (example scripts)

### Templates
- `templates/shop/[feature_name]/` (entire directories)
- `templates/admin/[feature_name]/` (entire directories)

### Tests
- `features/*_example.feature`
- `features/*_demo.feature`
- `tests/Behat/Context/*/ExampleContext.php`
- `tests/Behat/Page/*/Example*Page.php`

## Step 3: Identify Configuration to Clean

### Service Definitions
**File:** `config/services.php`
- Remove service definitions for example controllers
- Look for: `$services->set(...\Controller\ExampleController::class)`

### Routing
**Files:** `config/routes/shop.yaml`, `config/routes/admin.yaml`
- Remove entire route definitions for example features
- Look for routes with "example", "demo", or feature-specific names

### Twig Hooks
**Files:** `config/twig_hooks/shop.yaml`, `config/twig_hooks/admin.yaml`
- Remove hook definitions for example features
- Remove entire `config/twig_hooks/` directory if it only contains empty placeholder files
- Look for: `'app_shop.example.*'` or similar patterns

### Asset Imports
**Files:** `assets/shop/entrypoint.js`, `assets/admin/entrypoint.js`
- Remove imports of deleted JavaScript files
- Look for: `import './js/example';`

### Main Configuration
**File:** `config/config.yaml`
- Remove imports that reference deleted directories
- Look for: `- { resource: "twig_hooks/**/*.yaml" }` or similar broken imports
- Clean up any example-specific configuration

### Behat Suites
**File:** `tests/Behat/Resources/suites.php`
- Remove suite definitions for example features
- Look for suites with example/demo names

## Step 4: Cleanup Checklist

Use this checklist to ensure complete cleanup:

1. **Delete files:**
   - [ ] Controllers (`src/Controller/`)
   - [ ] JavaScript files (`assets/*/js/`)
   - [ ] Template directories (`templates/*/`)
   - [ ] Feature files (`features/`)
   - [ ] Behat test files (`tests/Behat/`)

2. **Clean configurations:**
   - [ ] Remove service definitions from `config/services.php`
   - [ ] Remove routes from `config/routes/*.yaml`
   - [ ] Remove twig hooks from `config/twig_hooks/*.yaml` or remove entire directory if empty
   - [ ] Remove broken imports from `config/config.yaml`
   - [ ] Remove JavaScript imports from `assets/*/entrypoint.js`
   - [ ] Remove test suites from `tests/Behat/Resources/suites.php`
   - [ ] Remove Behat services from `tests/Behat/Resources/services.php`

3. **Additional cleanup:**
   - [ ] Remove empty directories (e.g., `config/twig_hooks/` if only contains placeholder files)
   - [ ] Check for unused dependencies in `composer.json`
   - [ ] Check for unused npm packages in `package.json`
   - [ ] Clear cache after cleanup

## Step 5: Verification

After cleanup, verify the plugin still works:

```bash
# Clear cache
rm -rf var/cache/*

# Check for broken imports in config files
grep -r "twig_hooks\|greeting\|example" config/ --include="*.yaml" --include="*.yml" || echo "No broken imports found"

# Check for syntax errors
vendor/bin/phpstan analyse -c phpstan.neon -l max src/

# Run coding standards check
vendor/bin/ecs check

# If using Docker
make ecs
make phpstan
```

## Common Patterns to Remove

### Example 1: Greeting Feature
- Controller: `GreetingController.php`
- Routes: `acme_sylius_example_static_welcome`, `acme_sylius_example_dynamic_welcome`
- Templates: `templates/shop/greeting/`
- JavaScript: `assets/shop/js/greetings.js`
- Tests: `*greeting*.feature`, `*Welcome*.php`

### Example 2: Demo Feature
- Look for files/classes containing "Demo", "Example", "Sample"
- Check for placeholder routes like `/demo`, `/example`
- Remove test data generators if not needed

## Important Notes

1. **Always analyze before deleting** - Make sure the code is truly example/demo code
2. **Check dependencies** - Ensure no other code depends on what you're removing
3. **Keep plugin structure** - Don't delete essential plugin files like the main plugin class
4. **Preserve configuration structure** - Keep empty configuration files if they're required by Sylius

## Safe Files to Keep

Never delete these essential files:
- `src/[PluginName]Plugin.php` (main plugin class)
- `src/DependencyInjection/` (directory structure)
- `config/services.php` (keep file, just clean content)
- `config/*_routing.yaml` (keep files, just clean content)
- `composer.json`, `package.json`
- Essential directories: `src/`, `config/`, `templates/`, `tests/`
