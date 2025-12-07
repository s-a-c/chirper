# Tool Configuration Consistency

<details>
<summary>Table of Contents</summary>

- [Tool Configuration Consistency](#tool-configuration-consistency)
  - [1. Current Configuration Analysis](#1-current-configuration-analysis)
    - [1.1. Tools with Configuration Files](#11-tools-with-configuration-files)
  - [2. Standard Configuration Pattern](#2-standard-configuration-pattern)
    - [2.1. Standard Paths (All Analysis Tools)](#21-standard-paths-all-analysis-tools)
    - [2.2. Standard Exclusions](#22-standard-exclusions)
    - [2.3. Standard Cache/Temp Directories](#23-standard-cachetemp-directories)
  - [3. Inconsistencies Found](#3-inconsistencies-found)
    - [3.1. Bootstrap Directory](#31-bootstrap-directory)
    - [3.2. Migrations Exclusion Pattern](#32-migrations-exclusion-pattern)
    - [3.3. Cache Directory Location](#33-cache-directory-location)
    - [3.4. Standard Exclusions](#34-standard-exclusions)
  - [4. Recommended Actions](#4-recommended-actions)
    - [4.1. Priority 1: Critical Consistency Issues](#41-priority-1-critical-consistency-issues)
    - [4.2. Priority 2: Enhancements](#42-priority-2-enhancements)

</details>

This document ensures consistency across all development tools in `composer.json` require-dev.

-----

## 1. Current Configuration Analysis

### 1.1. Tools with Configuration Files

1. **PHPStan** (`phpstan.neon`) - Static analysis
2. **Psalm** (`psalm.xml`) - Static analysis
3. **Rector** (`rector.php`) - Code refactoring
4. **Pint** (`pint.json`) - Code formatting
5. **Infection** (`infection.json.dist`) - Mutation testing

-----

## 2. Standard Configuration Pattern

### 2.1. Standard Paths (All Analysis Tools)

All static analysis and refactoring tools should analyze:

- `app`
- `bootstrap` (excluding `bootstrap/cache`)
- `config`
- `database` (including `database/migrations/*.php`)
- `public`
- `routes`
- `tests`

### 2.2. Standard Exclusions

All tools should exclude:

- `vendor/`
- `storage/`
- `tmp/`
- `node_modules/`
- `bootstrap/cache/`

### 2.3. Standard Cache/Temp Directories

All tools should use relative paths in `tmp/`:

- `tmp/phpstan` (PHPStan)
- `tmp/psalm` (Psalm)
- `tmp/rector` (Rector)

-----

## 3. Inconsistencies Found

### 3.1. Bootstrap Directory

- ✅ **Psalm**: Uses `bootstrap` (entire directory, excluding `bootstrap/cache`)
- ✅ **PHPStan & Rector**: Use `bootstrap` (entire directory, excluding `bootstrap/cache`)
- **Fix Applied**: All tools now include `bootstrap` directory, excluding `bootstrap/cache`

### 3.2. Migrations Inclusion Pattern

- ✅ **PHPStan**: Includes `database/migrations` directory
- ✅ **Psalm**: Includes `database/migrations` files (via database directory)
- ✅ **Rector**: Includes `database/migrations` directory
- **Fix Applied**: All tools now include `database/migrations/*.php` files

### 3.3. Cache Directory Location

- ❌ **Rector**: Uses `/tmp/rector` (absolute system path)
- ✅ **PHPStan**: Uses `tmp/phpstan` (relative path)
- ❌ **Psalm**: Not configured (uses default)
- **Fix**: Use relative paths: `tmp/rector`, configure `tmp/psalm`

### 3.4. Standard Exclusions

- ✅ **Psalm**: Explicitly excludes vendor, storage, tmp, node_modules
- ❌ **PHPStan**: Only excludes migrations, relies on default exclusions
- ❌ **Rector**: No explicit exclusions
- **Fix**: Make exclusions explicit where possible

-----

## 4. Recommended Actions

### 4.1. Priority 1: Critical Consistency Issues

1. ✅ **Standardize bootstrap handling**: All tools now include `bootstrap` directory, excluding `bootstrap/cache`
2. ✅ **Include migrations**: All tools now include `database/migrations/*.php` files
3. ✅ **Standardize cache locations**: All tools use relative `tmp/` paths

### 4.2. Priority 2: Enhancements

4. **Add explicit exclusions** where tool supports it
5. **Document standard patterns** for future tools

-----
