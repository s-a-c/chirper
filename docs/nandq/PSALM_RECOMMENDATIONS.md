# Psalm Plugin Recommendations for 100% Type Coverage

<details>
<summary>Click to expand for Table of Contents</summary>

- [Psalm Plugin Recommendations for 100% Type Coverage](#psalm-plugin-recommendations-for-100-type-coverage)
  - [1. Current Status](#1-current-status)
  - [2. Essential Plugins (Install When Available)](#2-essential-plugins-install-when-available)
    - [2.1. **psalm/plugin-laravel** ⭐ **HIGHEST PRIORITY**](#21-psalmplugin-laravel--highest-priority)
    - [2.2. **psalm/plugin-phpunit**](#22-psalmplugin-phpunit)
    - [2.3. **psalm/plugin-mockery**](#23-psalmplugin-mockery)
  - [3. Configuration for Maximum Type Coverage](#3-configuration-for-maximum-type-coverage)
    - [3.1. Recommended Configuration Updates](#31-recommended-configuration-updates)
  - [4. Alternative Approaches](#4-alternative-approaches)
    - [4.1. Option 1: Use Psalm 5.x (More Stable)](#41-option-1-use-psalm-5x-more-stable)
    - [4.2. Option 2: Wait for Plugin Updates](#42-option-2-wait-for-plugin-updates)
    - [4.3. Option 3: Use PHPStan in Parallel](#43-option-3-use-phpstan-in-parallel)
  - [5. Type Coverage Best Practices](#5-type-coverage-best-practices)
    - [5.1. Enable Strict Types Everywhere](#51-enable-strict-types-everywhere)
    - [5.2. Add Return Types to All Methods](#52-add-return-types-to-all-methods)
    - [5.3. Type All Properties](#53-type-all-properties)
    - [5.4. Use Type Hints for All Parameters](#54-use-type-hints-for-all-parameters)
    - [5.5. Avoid `mixed` Type](#55-avoid-mixed-type)
  - [6. Monitoring Type Coverage](#6-monitoring-type-coverage)
    - [6.1. Check Type Coverage](#61-check-type-coverage)
    - [6.2. Set Coverage Thresholds](#62-set-coverage-thresholds)
    - [6.3. Track Coverage Over Time](#63-track-coverage-over-time)
  - [7. Integration with Existing Tools](#7-integration-with-existing-tools)
    - [7.1. Working with Larastan](#71-working-with-larastan)
    - [7.2. Working with Pest Tests](#72-working-with-pest-tests)
    - [7.3. Working with Rector](#73-working-with-rector)
  - [8. Next Steps](#8-next-steps)
  - [9. Resources](#9-resources)
  - [10. Questions?](#10-questions)

</details>

-----

## 1. Current Status

Your project uses **Psalm 6.x** (development version), which is cutting-edge but means some plugins haven't been updated yet. This document outlines the recommended plugins and configuration for achieving 100% type coverage and maximum type safety.

-----

## 2. Essential Plugins (Install When Available)

### 2.1. **psalm/plugin-laravel** ⭐ **HIGHEST PRIORITY**

**Status**: ⚠️ Compatibility issues with Psalm 6.x currently

This plugin provides:

- Laravel Facade understanding
- Eloquent model relationship type inference
- Service container resolution
- Route parameter type inference
- Form Request validation types
- Collection method return types

**Install when compatible**:

```bash
composer require --dev psalm/plugin-laravel

```

### 2.2. **psalm/plugin-phpunit**

**Status**: ⚠️ Needs compatibility check for Psalm 6.x

Since you use Pest (built on PHPUnit), this plugin helps:

- Understand PHPUnit assertions in tests
- Better type inference in test files
- Mock object type understanding

**Install when compatible**:

```bash
composer require --dev psalm/plugin-phpunit

```

### 2.3. **psalm/plugin-mockery**

**Status**: ⚠️ Currently only supports up to Psalm 5.x

You use Mockery for mocking. This plugin:

- Understands Mockery mock objects
- Improves type inference in tests using mocks
- Reduces false positives with mocked methods

**Wait for Psalm 6.x support** or consider alternative mocking approaches.

-----

## 3. Configuration for Maximum Type Coverage

Your current `psalm.xml` is configured with `errorLevel="1"` which is good. For 100% type coverage, consider these additions:

### 3.1. Recommended Configuration Updates

Add these to your `psalm.xml` for stricter checking:

```xml
<psalm
    errorLevel="1"
    strictBinaryOperands="true"
    findUnusedBaselineEntry="true"
    findUnusedCode="true"
    findUnusedVariablesAndParams="true"
    findUnusedPsalmSuppress="true"
    checkForThrowsDocblock="true"
    checkForThrowsInGlobalScope="true"
>
    <!-- Add issue handlers for strict type checking -->
    <issueHandlers>
        <!-- Enforce return types everywhere -->
        <MissingReturnType errorLevel="error" />
        <MissingPropertyType errorLevel="error" />
        <MissingClosureReturnType errorLevel="error" />

        <!-- Prevent unsafe type operations -->
        <MixedAssignment errorLevel="error" />
        <MixedArgument errorLevel="error" />
        <MixedPropertyFetch errorLevel="error" />
        <MixedMethodCall errorLevel="error" />
        <MixedReturnStatement errorLevel="error" />

        <!-- Encourage strict comparisons -->
        <ImplicitToStringCast errorLevel="info" />
        <RedundantCondition errorLevel="info" />

        <!-- Enforce type annotations -->
        <UndefinedDocblockClass errorLevel="error" />
        <InvalidDocblock errorLevel="error" />
    </issueHandlers>
</psalm>

```

-----

## 4. Alternative Approaches

Since Psalm 6.x is new, consider these alternatives:

### 4.1. Option 1: Use Psalm 5.x (More Stable)

If you need plugin support immediately, downgrade to Psalm 5.x:

```bash
composer require --dev "vimeo/psalm:^5.26"
composer require --dev "psalm/plugin-laravel:^3.0"
composer require --dev "psalm/plugin-phpunit:^0.19"
composer require --dev "psalm/plugin-mockery:^0.10"

```

### 4.2. Option 2: Wait for Plugin Updates

Monitor these repositories for Psalm 6.x support:

- [psalm-plugin-laravel](https://github.com/psalm/psalm-plugin-laravel)
- [psalm-plugin-phpunit](https://github.com/psalm/psalm-plugin-phpunit)
- [psalm-plugin-mockery](https://github.com/psalm/psalm-plugin-mockery)

### 4.3. Option 3: Use PHPStan in Parallel

You already have **Larastan** configured, which works excellently with Laravel. Consider:

- Using PHPStan/Larastan for Laravel-specific checks
- Using Psalm for additional type safety and different analysis approaches
- Running both in your CI/CD pipeline

-----

## 5. Type Coverage Best Practices

### 5.1. Enable Strict Types Everywhere

Your project already uses `declare(strict_types=1);` - excellent!

### 5.2. Add Return Types to All Methods

```php
// ✅ Good
public function getUser(int $id): User
{
    return User::findOrFail($id);
}

// ❌ Avoid
public function getUser($id)
{
    return User::find($id);
}

```

### 5.3. Type All Properties

```php
// ✅ Good
class UserController
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
}

```

### 5.4. Use Type Hints for All Parameters

```php
// ✅ Good
public function processPayment(PaymentRequest $request, User $user): PaymentResult
{
    // ...
}

// ❌ Avoid
public function processPayment($request, $user)
{
    // ...
}

```

### 5.5. Avoid `mixed` Type

Use specific types or union types instead:

```php
// ✅ Good
public function format(string|int $value): string
{
    return (string) $value;
}

// ❌ Avoid
public function format(mixed $value): string
{
    return (string) $value;
}

```

-----

## 6. Monitoring Type Coverage

### 6.1. Check Type Coverage

Run Psalm with type coverage report:

```bash
vendor/bin/psalm --show-info=true --stats

```

### 6.2. Set Coverage Thresholds

Add to your CI/CD pipeline:

```bash
# Fail if type coverage drops below threshold
vendor/bin/psalm --type-coverage=100

```

### 6.3. Track Coverage Over Time

Consider adding a script to track type coverage metrics:

```json
{
  "scripts": {
    "test:types:coverage": "vendor/bin/psalm --type-coverage"
  }
}

```

-----

## 7. Integration with Existing Tools

### 7.1. Working with Larastan

- **Larastan** (PHPStan) handles Laravel-specific patterns excellently
- **Psalm** provides different analysis perspectives
- Run both for comprehensive coverage

### 7.2. Working with Pest Tests

- Psalm will analyze your Pest tests automatically
- Consider adding `@psalm-` annotations where needed
- Use `@psalm-suppress` sparingly and document why

### 7.3. Working with Rector

Your Rector configuration already enforces strict types. Psalm will catch any type issues Rector might miss.

-----

## 8. Next Steps

1. ✅ **Current**: Basic Psalm configuration is set up
2. 🔄 **Next**: Monitor plugin repositories for Psalm 6.x support
3. 📝 **Action**: Start adding type annotations to existing code
4. 🎯 **Goal**: Achieve 100% type coverage incrementally

-----

## 9. Resources

- [Psalm Documentation](https://psalm.dev/docs/)
- [Psalm Plugins Directory](https://psalm.dev/plugins/)
- [Larastan Documentation](https://github.com/larastan/larastan)
- [Type Coverage Guide](https://psalm.dev/docs/running_psalm/issues/MissingReturnType/)

-----

## 10. Questions?

If you need immediate plugin support, consider:

- Downgrading to Psalm 5.x temporarily
- Contributing Psalm 6.x support to plugin repositories
- Using PHPStan/Larastan as the primary tool for now

-----
