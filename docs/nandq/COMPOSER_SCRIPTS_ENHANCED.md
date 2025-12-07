# Enhanced Composer Scripts - All Require-Dev Tools

This document describes all composer scripts that utilize the `require-dev` tools in this project.

## Overview

All development tools from `composer.json` require-dev are now integrated into organized, reusable composer scripts with consistent naming and banner formatting.

## Script Categories

### 1. Linting & Code Quality

#### `lint` - Run All Linters
```bash
composer lint
```
Runs all linting tools:
- Composer normalize (dry-run)
- Rector (dry-run)
- Pint (test mode)
- JavaScript linting

#### `lint:fix` - Fix All Linting Issues
```bash
composer lint:fix
```
Automatically fixes issues found by:
- Composer normalize
- Rector
- Pint
- JavaScript linting

#### Individual Linting Scripts

- **`lint:composer`** - Check composer.json normalization
- **`lint:composer:fix`** - Normalize composer.json
- **`lint:rector`** - Check code with Rector (dry-run)
- **`lint:rector:fix`** - Apply Rector fixes
- **`lint:pint`** - Check code style with Pint (test mode)
- **`lint:pint:fix`** - Fix code style with Pint
- **`lint:js`** - Check JavaScript code
- **`lint:js:fix`** - Fix JavaScript code

### 2. Type Checking

#### `test:types` - PHPStan Only
```bash
composer test:types
```
Runs PHPStan static analysis.

#### `test:types:psalm` - Psalm Only
```bash
composer test:types:psalm
```
Runs Psalm static analysis.

#### `test:types:psalm:stats` - Psalm Statistics
```bash
composer test:types:psalm:stats
```
Shows detailed Psalm statistics and type coverage.

#### `test:types:all` - Both Type Checkers
```bash
composer test:types:all
```
Runs both PHPStan and Psalm for comprehensive type checking.

### 3. Testing

#### `test` - Full Test Suite
```bash
composer test
```
Runs complete test suite:
- Linting
- Type coverage
- Code coverage
- Unit tests
- Type checking (PHPStan + Psalm)
- Security audit

#### `test:unit` - Unit & Feature Tests
```bash
composer test:unit
```
Runs Pest unit and feature tests with coverage.

#### `test:browser` - Browser Tests
```bash
composer test:browser
```
Runs Pest browser tests.

#### `test:mutation` - Mutation Testing
```bash
composer test:mutation
```
Runs Infection mutation testing.

#### `test:arch` - Architecture Tests
```bash
composer test:arch
```
Runs Pest architecture tests (pest-plugin-arch).

#### `test:profanity` - Profanity Check
```bash
composer test:profanity
```
Runs Pest profanity checks (pest-plugin-profanity).

#### `test:type-coverage` - Type Coverage
```bash
composer test:type-coverage
```
Runs Pest type coverage checks.

#### `test:coverage` - Code Coverage
```bash
composer test:coverage
```
Runs both PHP and JavaScript coverage:
- `test:coverage:pcov` - PHP coverage with PCOV
- `test:coverage:xdebug` - PHP coverage with Xdebug
- `test:coverage:js` - JavaScript coverage

### 4. Development Tools

#### `ide-helper:generate` - Generate IDE Helper
```bash
composer ide-helper:generate
```
Generates IDE helper files using `barryvdh/laravel-ide-helper`.

#### `blueprint:build` - Build Blueprint Components
```bash
composer blueprint:build
```
Builds components from Blueprint draft using `laravel-shift/blueprint`.

#### `blueprint:trace` - Trace Blueprint Models
```bash
composer blueprint:trace
```
Creates Blueprint definitions for existing models.

### 5. Code Refactoring

#### `rector:type-perfect` - Type Perfect Analysis
```bash
composer rector:type-perfect
```
Runs Rector Type Perfect analysis for advanced type checking.

### 6. Security

#### `security:audit` - Security Audit
```bash
composer security:audit
```
Runs Composer security audit using `roave/security-advisories`.

### 7. Workflows

#### `workflow:core` - Core Workflow
```bash
composer workflow:core
```
Essential checks:
- Linting
- Unit tests
- Type checking (PHPStan + Psalm)
- Security audit

#### `workflow:heavy` - Heavy Workflow
```bash
composer workflow:heavy
```
Comprehensive checks:
- Mutation testing
- Browser tests

#### `workflow:full` - Full Workflow
```bash
composer workflow:full
```
Complete workflow:
- Core workflow
- Architecture tests
- Profanity checks
- Heavy workflow

#### `workflow:policy` - Policy Monitor
```bash
composer workflow:policy
```
Monitors policy checksums.

### 8. Development

#### `dev` - Development Server
```bash
composer dev
```
Starts development environment:
- Laravel server
- Queue worker
- Pail logs
- Vite dev server

#### `setup` - Project Setup
```bash
composer setup
```
Initial project setup:
- Install dependencies
- Create .env
- Generate key
- Run migrations
- Install JS dependencies
- Build assets

### 9. CI/CD

#### `ci:local` - Local CI Checks
```bash
composer ci:local
```
Runs local CI checks using `scripts/run-ci-checks.sh`.

## Tool Coverage

All require-dev tools are now integrated:

### ✅ Static Analysis
- **PHPStan** (`test:types`)
- **Psalm** (`test:types:psalm`)
- **Rector** (`lint:rector`, `rector:type-perfect`)

### ✅ Code Quality
- **Pint** (`lint:pint`)
- **Composer Normalize** (`lint:composer`)
- **Rector** (`lint:rector`)

### ✅ Testing
- **Pest** (`test:unit`, `test:browser`, etc.)
- **Infection** (`test:mutation`)
- **Pest Architecture** (`test:arch`)
- **Pest Profanity** (`test:profanity`)
- **Pest Type Coverage** (`test:type-coverage`)

### ✅ Development Tools
- **IDE Helper** (`ide-helper:generate`)
- **Blueprint** (`blueprint:build`, `blueprint:trace`)
- **Pail** (used in `dev`)

### ✅ Security
- **Security Advisories** (`security:audit`)

## Script Organization

```
lint
├── lint:composer
├── lint:rector
├── lint:pint
└── lint:js

lint:fix
├── lint:composer:fix
├── lint:rector:fix
├── lint:pint:fix
└── lint:js:fix

test:types:all
├── test:types (PHPStan)
└── test:types:psalm (Psalm)

test
├── test:lint
├── test:type-coverage
├── test:coverage
├── test:unit
├── test:types:all
└── security:audit

testsuite:core
├── test:lint
├── test:unit
├── test:types:all
└── security:audit

testsuite:full
├── testsuite:core
├── test:arch
├── test:profanity
└── testsuite:heavy
```

## Usage Examples

### Quick Lint Check
```bash
composer lint
```

### Fix All Linting Issues
```bash
composer lint:fix
```

### Run Type Checking
```bash
composer test:types:all
```

### Full Test Suite
```bash
composer test
```

### Complete Test Suite
```bash
composer testsuite:full
```

### Generate IDE Helper
```bash
composer ide-helper:generate
```

## Benefits

1. **Comprehensive Coverage**: All require-dev tools are accessible via scripts
2. **Consistent Interface**: All scripts follow the same pattern with banners
3. **Modular Design**: Individual tools can be run separately or combined
4. **Easy Integration**: Scripts can be chained together in workflows
5. **Developer Experience**: Clear, organized commands for all tools

## Next Steps

- Use `composer lint` before committing
- Run `composer test:types:all` for type checking
- Execute `composer testsuite:core` for quick validation
- Use `composer testsuite:full` for comprehensive checks
