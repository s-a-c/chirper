# PHP Mutation Testing Tools - Analysis & Recommendations

-----

<details>
<summary>Table of Contents</summary>

- [PHP Mutation Testing Tools - Analysis \& Recommendations](#php-mutation-testing-tools---analysis--recommendations)
  - [1. Executive Summary](#1-executive-summary)
  - [2. Option 1: Pest Built-in Mutation Testing (Pest 4+)](#2-option-1-pest-built-in-mutation-testing-pest-4)
    - [2.1. Description](#21-description)
    - [2.2. Features](#22-features)
    - [2.3. Compatibility](#23-compatibility)
    - [2.4. Setup Requirements](#24-setup-requirements)
    - [2.5. Pros](#25-pros)
    - [2.6. Cons](#26-cons)
    - [2.7. Confidence Score: **95%**](#27-confidence-score-95)
    - [2.8. Compatibility Score: **100%**](#28-compatibility-score-100)
  - [3. Option 2: Infection (Current Tool)](#3-option-2-infection-current-tool)
    - [3.1. Description](#31-description)
    - [3.2. Features](#32-features)
    - [3.3. Compatibility](#33-compatibility)
    - [3.4. Current Issues](#34-current-issues)
    - [3.5. Pros](#35-pros)
    - [3.6. Cons](#36-cons)
    - [3.7. Confidence Score: **40%**](#37-confidence-score-40)
    - [3.8. Compatibility Score: **60%**](#38-compatibility-score-60)
  - [4. Option 3: Humbug](#4-option-3-humbug)
    - [4.1. Description](#41-description)
    - [4.2. Status](#42-status)
    - [4.3. Compatibility](#43-compatibility)
    - [4.4. Confidence Score: **0%**](#44-confidence-score-0)
    - [4.5. Compatibility Score: **0%**](#45-compatibility-score-0)
  - [5. Option 4: Mutant](#5-option-4-mutant)
    - [5.1. Description](#51-description)
    - [5.2. Status](#52-status)
    - [5.3. Compatibility](#53-compatibility)
    - [5.4. Confidence Score: **10%**](#54-confidence-score-10)
    - [5.5. Compatibility Score: **20%**](#55-compatibility-score-20)
  - [6. Recommendation Matrix](#6-recommendation-matrix)
  - [7. Recommended Action Plan](#7-recommended-action-plan)
    - [7.1. Immediate: Switch to Pest Built-in Mutation Testing](#71-immediate-switch-to-pest-built-in-mutation-testing)
    - [7.2. Benefits of Switching](#72-benefits-of-switching)
  - [8. Migration Guide](#8-migration-guide)
    - [8.1. Step 1: Add `covers()` to Test Files](#81-step-1-add-covers-to-test-files)
    - [8.2. Step 2: Update Composer Script](#82-step-2-update-composer-script)
    - [8.3. Step 3: Test the Migration](#83-step-3-test-the-migration)
  - [9. Conclusion](#9-conclusion)

</details>

-----

## 1. Executive Summary

For your Laravel/Pest 4.1.6 project, **Pest's built-in mutation testing** is the best option with 95% confidence and 100% compatibility.

-----

## 2. Option 1: Pest Built-in Mutation Testing (Pest 4+)

### 2.1. Description

Pest 4 introduced native mutation testing capabilities with the `--mutate` option. This is integrated directly into the Pest framework, eliminating the need for external tools.

### 2.2. Features

- **Native Integration**: Built into Pest, no external dependencies
- **PCOV/Xdebug Support**: Works with PCOV (which you're already using)
- **Parallel Execution**: Supports `--parallel` for faster runs
- **Flexible Configuration**: Multiple options for targeting specific classes/files
- **Coverage Integration**: Works seamlessly with Pest's coverage reporting

### 2.3. Compatibility

- ✅ **Pest 4.1.6**: 100% (you're already on this version)
- ✅ **Laravel 12**: 100% (works with any Laravel version)
- ✅ **PCOV**: 100% (already configured)
- ✅ **PHP 8.5**: 100% (fully supported)

### 2.4. Setup Requirements

1. Annotate tests with `covers()` or `mutates()` functions
2. Run: `vendor/bin/pest --mutate`
3. Optionally: `vendor/bin/pest --mutate --parallel --min=90`

### 2.5. Pros

- ✅ Zero configuration needed (already have Pest 4.1.6)
- ✅ Perfect compatibility with Pest test structure
- ✅ No test file mapping issues (unlike Infection)
- ✅ Integrated with existing Pest workflow
- ✅ Supports parallel execution for performance
- ✅ Can target specific classes/files with `--class` and `--ignore`

### 2.6. Cons

- ⚠️ Requires annotating tests with `covers()` or `mutates()` (minor setup)
- ⚠️ Newer feature (Pest 4), less community experience than Infection
- ⚠️ May have fewer mutation operators than Infection initially

### 2.7. Confidence Score: **95%**

**Reasoning**: Pest 4's mutation testing is actively maintained, well-documented, and designed specifically for Pest. It's the natural choice for Pest projects.

### 2.8. Compatibility Score: **100%**

**Reasoning**: Native integration means perfect compatibility with Pest's test structure, no mapping issues, and works with your existing PCOV setup.

-----

## 3. Option 2: Infection (Current Tool)

### 3.1. Description

Infection is the most mature and feature-rich PHP mutation testing framework. It uses AST-based mutations and supports PHPUnit, PhpSpec, and Codeception.

### 3.2. Features

- **Mature & Stable**: Most widely used PHP mutation testing tool
- **AST Mutations**: Advanced mutation operators
- **Detailed Reporting**: HTML/text/summary reports
- **CI Integration**: Well-documented CI/CD integration
- **Extensive Mutators**: Large collection of mutation operators

### 3.3. Compatibility

- ⚠️ **Pest**: 60% (works via PHPUnit compatibility, but has mapping issues)
- ✅ **Laravel 12**: 100%
- ✅ **PCOV**: 100%
- ✅ **PHP 8.5**: 100%

### 3.4. Current Issues

- ❌ **TestFileNameNotFoundException**: Can't map Pest test classes correctly
- ❌ **XML Validation Warnings**: Generates PHPUnit XML with deprecated `<filter>` element
- ⚠️ **Workarounds Required**: Custom wrapper script needed

### 3.5. Pros

- ✅ Most mature and feature-rich option
- ✅ Extensive mutation operators
- ✅ Excellent documentation
- ✅ Large community and support

### 3.6. Cons

- ❌ **Incompatible with Pest structure**: Test file mapping fails
- ❌ Requires custom wrapper script (`bin/pest-infection`)
- ❌ XML validation warnings (though handled by wrapper)
- ❌ Not designed for Pest's functional test style

### 3.7. Confidence Score: **40%**

**Reasoning**: While Infection is excellent for PHPUnit projects, it has fundamental compatibility issues with Pest's test structure that are difficult to work around.

### 3.8. Compatibility Score: **60%**

**Reasoning**: Works via PHPUnit compatibility layer, but test file mapping fails. Requires significant workarounds and may not work reliably.

-----

## 4. Option 3: Humbug

### 4.1. Description

Humbug was an early PHP mutation testing tool that has been **discontinued** since 2017.

### 4.2. Status

- ❌ **No longer maintained**
- ❌ **Not recommended for new projects**
- ❌ Users advised to migrate to Infection

### 4.3. Compatibility

- ❌ **Pest**: 0% (not compatible)
- ❌ **Modern PHP**: Limited (designed for PHP 5.x/7.0)
- ❌ **Laravel 12**: 0% (not compatible)

### 4.4. Confidence Score: **0%**

**Reasoning**: Project is abandoned and no longer maintained.

### 4.5. Compatibility Score: **0%**

**Reasoning**: Not compatible with modern PHP, Pest, or Laravel 12.

-----

## 5. Option 4: Mutant

### 5.1. Description

Mutant is another PHP mutation testing tool that has seen limited development.

### 5.2. Status

- ⚠️ **Limited maintenance**
- ⚠️ **Not actively developed**
- ⚠️ **Compatibility concerns with modern PHP**

### 5.3. Compatibility

- ❌ **Pest**: Unknown (likely not supported)
- ⚠️ **Modern PHP**: Uncertain
- ⚠️ **Laravel 12**: Uncertain

### 5.4. Confidence Score: **10%**

**Reasoning**: Limited information and uncertain maintenance status.

### 5.5. Compatibility Score: **20%**

**Reasoning**: Uncertain compatibility with modern PHP and Pest.

-----

## 6. Recommendation Matrix

| Tool | Confidence | Compatibility | Recommendation |
|------|------------|---------------|---------------|
| **Pest Built-in** | 95% | 100% | ⭐⭐⭐⭐⭐ **STRONGLY RECOMMENDED** |
| Infection | 40% | 60% | ⭐⭐ Not recommended for Pest projects |
| Humbug | 0% | 0% | ❌ Do not use |
| Mutant | 10% | 20% | ❌ Do not use |

-----

## 7. Recommended Action Plan

### 7.1. Immediate: Switch to Pest Built-in Mutation Testing

1. **Update test files** to use `covers()` annotations:

```php
use App\Console\Commands\PlatformValidateProfiles;

covers(PlatformValidateProfiles::class);

test('platform validate profiles command runs successfully', function (): void {
    // test code
});
```

2. **Update composer.json** `test:mutation` script:

```json
"test:mutation": [
    "php -r \"...\"",
    "php -d error_reporting=\"E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED\" -d memory_limit=1G vendor/bin/pest --mutate --parallel --min=90"
]
```

3. **Remove Infection dependency** (optional, can keep for comparison):

```bash
composer remove infection/infection
```

### 7.2. Benefits of Switching

- ✅ No test file mapping issues
- ✅ No XML validation warnings
- ✅ No custom wrapper scripts needed
- ✅ Native Pest integration
- ✅ Better performance with `--parallel`
- ✅ Simpler configuration

-----

## 8. Migration Guide

### 8.1. Step 1: Add `covers()` to Test Files

For each test file, add coverage annotations:

```php
// tests/Feature/Console/Commands/PlatformValidateProfilesTest.php
use App\Console\Commands\PlatformValidateProfiles;

covers(PlatformValidateProfiles::class);

test('platform validate profiles command runs successfully', function (): void {
    // existing test
});
```

### 8.2. Step 2: Update Composer Script

Replace the Infection command with Pest's mutation testing:

```json
"test:mutation": [
    "php -r \"\\$banner = shell_exec('figlet -w 120 -k -f standard Mutation\\ Testing 2>/dev/null') ?: shell_exec('figlet Mutation\\ Testing 2>/dev/null') ?: 'Mutation Testing' . PHP_EOL; echo chr(27) . '[1;33;46m' . \\$banner . chr(27) . '[0m' . PHP_EOL;\"",
    "php -d error_reporting=\"E_ALL & ~E_DEPRECATED & ~E_USER_DEPRECATED\" -d memory_limit=1G vendor/bin/pest --mutate --parallel --min=90"
]
```

### 8.3. Step 3: Test the Migration

```bash
composer test:mutation
```

-----

## 9. Conclusion

**Pest's built-in mutation testing is the clear winner** for your project:

- You're already on Pest 4.1.6 (required version)
- 100% compatibility with your existing setup
- No workarounds or custom scripts needed
- Better integration with Pest's workflow
- Active development and support

The only minor requirement is adding `covers()` annotations to your tests, which is a one-time setup that improves test documentation anyway.

**Confidence: 95%** - This is the right choice for Pest projects.
**Compatibility: 100%** - Native integration means perfect compatibility.

-----
