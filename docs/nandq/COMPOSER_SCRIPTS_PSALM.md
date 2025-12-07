# Composer Scripts Enhancement: Psalm Integration

<details>
<summary>Click to expand for Table of Contents</summary>

- [Composer Scripts Enhancement: Psalm Integration](#composer-scripts-enhancement-psalm-integration)
  - [1. Summary](#1-summary)
  - [2. New Scripts Added](#2-new-scripts-added)
    - [2.1. `test:types:psalm`](#21-testtypespsalm)
    - [2.2. `test:types:all`](#22-testtypesall)
    - [2.3. `test:types:psalm:stats`](#23-testtypespsalmstats)
  - [3. Updated Scripts](#3-updated-scripts)
    - [3.1. `test`](#31-test)
    - [3.2. `testsuite:core`](#32-testsuitecore)
  - [4. Script Hierarchy](#4-script-hierarchy)
  - [5. Usage Examples](#5-usage-examples)
    - [5.1. Run Only Psalm](#51-run-only-psalm)
    - [5.2. Run Only PHPStan](#52-run-only-phpstan)
    - [5.3. Run Both Type Checkers](#53-run-both-type-checkers)
    - [5.4. Get Psalm Statistics](#54-get-psalm-statistics)
    - [5.5. Full Test Suite (Includes Both)](#55-full-test-suite-includes-both)
    - [5.6. Core Workflow (Includes Both)](#56-core-workflow-includes-both)
  - [6. Benefits](#6-benefits)
  - [7. Configuration](#7-configuration)
  - [8. Troubleshooting](#8-troubleshooting)
    - [8.1. Psalm takes too long](#81-psalm-takes-too-long)
    - [8.2. Only want to run one tool](#82-only-want-to-run-one-tool)
    - [8.3. Check individual tool versions](#83-check-individual-tool-versions)
  - [9. Next Steps](#9-next-steps)
  - [10. Related Documentation](#10-related-documentation)

</details>

-----

## 1. Summary

Psalm has been integrated into your composer scripts alongside PHPStan for comprehensive type checking. Both tools now run in parallel to provide maximum type safety coverage.

-----

## 2. New Scripts Added

### 2.1. `test:types:psalm`

Run Psalm static analysis independently:

```bash
composer test:types:psalm

```

**Features:**

- Standalone Psalm analysis
- Follows same pattern as `test:types` (PHPStan)
- Includes error reporting suppression for deprecations
- 1GB memory limit
- Runs without cache for fresh analysis

### 2.2. `test:types:all`

Run both PHPStan and Psalm together:

```bash
composer test:types:all

```

**Features:**

- Runs PHPStan first
- Then runs Psalm
- Comprehensive type checking from both tools
- Used in main test workflow

### 2.3. `test:types:psalm:stats`

Get detailed statistics and type coverage information from Psalm:

```bash
composer test:types:psalm:stats
```

**Features:**

- Shows detailed statistics
- Type coverage information
- Useful for tracking coverage improvements

## 3. Updated Scripts

### 3.1. `test`

The main test suite now runs both type checkers:

```bash
composer test

```

**Changes:**

- Updated to use `@test:types:all` instead of `@test:types`
- Now runs both PHPStan and Psalm automatically

### 3.2. `testsuite:core`

The core test suite now includes both type checkers:

```bash
composer testsuite:core

```

**Changes:**

- Updated to use `@test:types:all` instead of `@test:types`
- Ensures comprehensive type checking in core workflows

-----

## 4. Script Hierarchy

```log
test
├── test:lint
├── test:type-coverage
├── test:coverage
├── test:unit
├── test:types:all          ← NEW: Runs both
│   ├── test:types          (PHPStan)
│   └── test:types:psalm    (Psalm) ← NEW
└── security:audit

testsuite:core
├── test:lint
├── test:unit
├── test:types:all          ← NEW: Runs both
│   ├── test:types          (PHPStan)
│   └── test:types:psalm    (Psalm) ← NEW
└── security:audit

```

-----

## 5. Usage Examples

### 5.1. Run Only Psalm

```bash
composer test:types:psalm

```

### 5.2. Run Only PHPStan

```bash
composer test:types

```

### 5.3. Run Both Type Checkers

```bash
composer test:types:all

```

### 5.4. Get Psalm Statistics

```bash
composer test:types:psalm:stats

```

### 5.5. Full Test Suite (Includes Both)

```bash
composer test

```

### 5.6. Core Test Suite (Includes Both)

```bash
composer testsuite:core

```

-----

## 6. Benefits

1. **Comprehensive Coverage**: Both tools catch different types of issues
   - PHPStan/Larastan: Excellent Laravel-specific patterns
   - Psalm: Different analysis approach, catches other issues

2. **Flexibility**: You can run either tool independently or together

3. **Consistency**: Both tools use the same error reporting and memory settings

4. **Integration**: Automatically runs in your test workflows

-----

## 7. Configuration

Both tools use similar settings:

- **Error Reporting**: Suppressed deprecations
- **Memory Limit**: 1GB
- **Output**: Formatted banners using figlet

-----

## 8. Troubleshooting

### 8.1. Psalm takes too long

If Psalm is slow, you can run it with cache (remove `--no-cache`):

```bash
vendor/bin/psalm

```

### 8.2. Only want to run one tool

- PHPStan only: `composer test:types`
- Psalm only: `composer test:types:psalm`

### 8.3. Check individual tool versions

```bash
vendor/bin/phpstan --version
vendor/bin/psalm --version

```

-----

## 9. Next Steps

1. Run the full test suite to see both tools in action:

```bash
composer test

```

2. Check current type coverage:

```bash
composer test:types:psalm:stats

```

3. Fix type errors incrementally to improve coverage

4. Consider adding Psalm to CI/CD pipelines alongside PHPStan

## 10. Related Documentation

- See `PSALM_RECOMMENDATIONS.md` for plugin recommendations
- See `psalm.xml` for Psalm configuration
- See `phpstan.neon` for PHPStan configuration

-----
