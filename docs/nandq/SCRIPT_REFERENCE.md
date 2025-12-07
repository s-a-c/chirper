# Script Reference - Composer & Package.json

-----

<details>
<summary>Click to expand for Table of Contents</summary>

- [Script Reference - Composer \& Package.json](#script-reference---composer--packagejson)
  - [1. Overview](#1-overview)
  - [2. Script Categories](#2-script-categories)
    - [2.1. Composer Scripts (PHP)](#21-composer-scripts-php)
    - [2.2. Package.json Scripts (JavaScript/TypeScript)](#22-packagejson-scripts-javascripttypescript)
  - [3. Composer Scripts](#3-composer-scripts)
    - [3.1. Linting \& Code Quality](#31-linting--code-quality)
      - [3.1.1. `lint`](#311-lint)
      - [3.1.2. `lint:fix`](#312-lintfix)
      - [3.1.3. `lint:composer`](#313-lintcomposer)
      - [3.1.4. `lint:composer:fix`](#314-lintcomposerfix)
      - [3.1.5. `lint:rector`](#315-lintrector)
      - [3.1.6. `lint:rector:fix`](#316-lintrectorfix)
      - [3.1.7. `lint:pint`](#317-lintpint)
      - [3.1.8. `lint:pint:fix`](#318-lintpintfix)
      - [3.1.9. `lint:js`](#319-lintjs)
      - [3.1.10. `lint:js:fix`](#3110-lintjsfix)
    - [3.2. Type Checking](#32-type-checking)
      - [3.2.1. `test:types`](#321-testtypes)
      - [3.2.2. `test:types:phpstan`](#322-testtypesphpstan)
      - [3.2.3. `test:types:psalm`](#323-testtypespsalm)
      - [3.2.4. `test:types:psalm:stats`](#324-testtypespsalmstats)
      - [3.2.5. `test:types:fix`](#325-testtypesfix)
      - [3.2.6. `test:types:fix:phpstan`](#326-testtypesfixphpstan)
      - [3.2.7. `test:types:fix:psalm`](#327-testtypesfixpsalm)
    - [3.3. Testing](#33-testing)
      - [3.3.1. `test`](#331-test)
      - [3.3.2. `test:lint`](#332-testlint)
      - [3.3.3. `test:type-coverage`](#333-testtype-coverage)
      - [3.3.4. `test:coverage`](#334-testcoverage)
      - [3.3.5. `test:coverage:pcov`](#335-testcoveragepcov)
      - [3.3.6. `test:coverage:xdebug`](#336-testcoveragexdebug)
      - [3.3.7. `test:coverage:js`](#337-testcoveragejs)
      - [3.3.8. `test:unit`](#338-testunit)
      - [3.3.9. `test:unit:js`](#339-testunitjs)
      - [3.3.10. `test:browser`](#3310-testbrowser)
      - [3.3.11. `test:mutation`](#3311-testmutation)
      - [3.3.12. `test:arch`](#3312-testarch)
      - [3.3.13. `test:profanity`](#3313-testprofanity)
    - [3.4. Development Tools](#34-development-tools)
      - [3.4.1. `ide-helper:generate`](#341-ide-helpergenerate)
      - [3.4.2. `blueprint:build`](#342-blueprintbuild)
      - [3.4.3. `blueprint:trace`](#343-blueprinttrace)
    - [3.5. Code Refactoring](#35-code-refactoring)
      - [3.5.1. `rector:type-perfect`](#351-rectortype-perfect)
    - [3.6. Security](#36-security)
      - [3.6.1. `security:audit`](#361-securityaudit)
    - [3.7. Test Suites](#37-test-suites)
      - [3.7.1. `testsuite:core`](#371-testsuitecore)
      - [3.7.2. `testsuite:heavy`](#372-testsuiteheavy)
      - [3.7.3. `testsuite:full`](#373-testsuitefull)
    - [3.8. Policy](#38-policy)
      - [3.8.1. `policy:checksum-monitor`](#381-policychecksum-monitor)
    - [3.9. Development](#39-development)
      - [3.9.1. `dev`](#391-dev)
      - [3.9.2. `setup`](#392-setup)
    - [3.10. CI/CD](#310-cicd)
      - [3.10.1. `ci:local`](#3101-cilocal)
    - [3.11. Utilities](#311-utilities)
      - [3.11.1. `update:requirements`](#3111-updaterequirements)
  - [4. Package.json Scripts](#4-packagejson-scripts)
    - [4.1. Build \& Development](#41-build--development)
      - [4.1.1. `build`](#411-build)
      - [4.1.2. `dev`](#412-dev)
      - [4.1.3. `preview`](#413-preview)
    - [4.2. Linting](#42-linting)
      - [4.2.1. `lint`](#421-lint)
      - [4.2.2. `lint:fix`](#422-lintfix)
      - [4.2.3. `lint:js`](#423-lintjs)
      - [4.2.4. `lint:js:fix`](#424-lintjsfix)
    - [4.3. Testing](#43-testing)
      - [4.3.1. `test`](#431-test)
      - [4.3.2. `test:browser`](#432-testbrowser)
      - [4.3.3. `test:coverage`](#433-testcoverage)
      - [4.3.4. `test:coverage:js`](#434-testcoveragejs)
      - [4.3.5. `test:coverage:js:clover`](#435-testcoveragejsclover)
      - [4.3.6. `test:coverage:js:html`](#436-testcoveragejshtml)
      - [4.3.7. `test:coverage:js:json`](#437-testcoveragejsjson)
      - [4.3.8. `test:coverage:js:lcov`](#438-testcoveragejslcov)
      - [4.3.9. `test:coverage:js:text`](#439-testcoveragejstext)
      - [4.3.10. `test:lint`](#4310-testlint)
      - [4.3.11. `test:run`](#4311-testrun)
      - [4.3.12. `test:unit`](#4312-testunit)
      - [4.3.13. `test:unit:js`](#4313-testunitjs)
      - [4.3.14. `test:watch`](#4314-testwatch)
      - [4.3.15. `playwright:install`](#4315-playwrightinstall)
  - [5. Cross-References](#5-cross-references)
    - [5.1. PHP → JavaScript](#51-php--javascript)
    - [5.2. JavaScript → PHP](#52-javascript--php)
    - [5.3. Bidirectional](#53-bidirectional)
  - [6. Workflow Associations](#6-workflow-associations)
    - [6.1. Primary Workflows](#61-primary-workflows)
    - [6.2. Development Workflows](#62-development-workflows)
  - [7. Usage Examples](#7-usage-examples)
    - [7.1. Quick Development Checks](#71-quick-development-checks)
    - [7.2. Full Test Suite](#72-full-test-suite)
    - [7.3. Development](#73-development)
    - [7.4. Maintenance](#74-maintenance)
  - [8. Notes](#8-notes)

</details>

-----

Complete documentation of all scripts in `composer.json` and `package.json` with descriptions, workflows, and cross-references.

## 1. Overview

This project uses a consistent naming pattern across both Composer (PHP) and Package.json (JavaScript/TypeScript) scripts:

- **Aggregator scripts** (e.g., `lint`, `test:types`) run multiple individual tools
- **Individual tool scripts** use `:toolname` suffix (e.g., `lint:js`, `test:types:phpstan`)
- **Fix scripts** use `:fix:toolname` pattern (e.g., `lint:js:fix`, `test:types:fix:phpstan`)
- **Language-specific** scripts use `:js` suffix for JavaScript/TypeScript tools

-----

## 2. Script Categories

### 2.1. Composer Scripts (PHP)

1. **Linting & Code Quality** - Code style and quality checks
2. **Type Checking** - Static analysis and type safety
3. **Testing** - Unit, feature, browser, and mutation tests
4. **Development Tools** - IDE helpers, Blueprint, etc.
5. **Code Refactoring** - Rector transformations
6. **Security** - Vulnerability scanning
7. **Workflows** - Combined scripts for common tasks
8. **Development** - Local development servers
9. **CI/CD** - Continuous integration scripts
10. **Utilities** - Setup and maintenance

### 2.2. Package.json Scripts (JavaScript/TypeScript)

1. **Build & Development** - Vite bundler and dev server
2. **Linting** - Prettier code formatting
3. **Testing** - Vitest unit tests and Playwright browser tests

-----

## 3. Composer Scripts

### 3.1. Linting & Code Quality

#### 3.1.1. `lint`

**Title:** Run All Linters
**Description:** Executes all linting tools in check mode (dry-run)
**Explanation:** Aggregator script that runs composer normalization check, Rector dry-run, Pint style check, and JavaScript linting. Does not modify files.
**Workflow Association:** Used in `test`, `testsuite:core`, `test:lint`
**Cross-Reference:** Calls `lint:js` which calls `bun run lint` (package.json)

```bash
composer lint

```

#### 3.1.2. `lint:fix`

**Title:** Fix All Linting Issues
**Description:** Automatically fixes issues found by all linting tools
**Explanation:** Aggregator script that normalizes composer.json, applies Rector fixes, fixes code style with Pint, and formats JavaScript code.
**Workflow Association:** Manual use for fixing code before committing
**Cross-Reference:** Calls `lint:js:fix` which calls `bun run lint:fix` (package.json)

```bash
composer lint:fix

```

#### 3.1.3. `lint:composer`

**Title:** Check Composer Normalization
**Description:** Validates `composer.json` is normalized according to Composer schema
**Explanation:** Runs `composer normalize --dry-run` to check if composer.json matches the expected format. Does not modify the file.
**Workflow Association:** Part of `lint` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer lint:composer

```

#### 3.1.4. `lint:composer:fix`

**Title:** Normalize Composer File
**Description:** Automatically normalizes `composer.json` to match Composer schema
**Explanation:** Runs `composer normalize` to reformat composer.json according to Composer's JSON schema standards.
**Workflow Association:** Part of `lint:fix` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer lint:composer:fix

```

#### 3.1.5. `lint:rector`

**Title:** Check Code with Rector
**Description:** Analyzes code for potential refactoring opportunities (dry-run)
**Explanation:** Runs Rector in dry-run mode to show what transformations would be applied without modifying files. Checks for PHP version upgrades, code quality improvements, and modernization opportunities.
**Workflow Association:** Part of `lint` and `test:lint` scripts
**Cross-Reference:** N/A (PHP-specific)

```bash
composer lint:rector

```

#### 3.1.6. `lint:rector:fix`

**Title:** Apply Rector Fixes
**Description:** Automatically applies Rector transformations to code
**Explanation:** Runs Rector to automatically refactor code according to configured rules. Can upgrade PHP syntax, improve code quality, and modernize codebase patterns.
**Workflow Association:** Part of `lint:fix` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer lint:rector:fix

```

#### 3.1.7. `lint:pint`

**Title:** Check Code Style with Pint
**Description:** Validates PHP code follows Laravel coding standards (dry-run)
**Explanation:** Runs Laravel Pint in test mode to check code style without modifying files. Uses PSR-12 coding standard with Laravel-specific rules.
**Workflow Association:** Part of `lint` and `test:lint` scripts
**Cross-Reference:** N/A (PHP-specific)

```bash
composer lint:pint

```

#### 3.1.8. `lint:pint:fix`

**Title:** Fix Code Style with Pint
**Description:** Automatically formats PHP code to match Laravel standards
**Explanation:** Runs Laravel Pint to automatically format PHP code according to PSR-12 and Laravel coding standards.
**Workflow Association:** Part of `lint:fix` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer lint:pint:fix

```

#### 3.1.9. `lint:js`

**Title:** Check JavaScript Code Style
**Description:** Validates JavaScript/TypeScript code follows Prettier formatting rules
**Explanation:** Delegates to package.json `lint:js` script which runs Prettier in check mode on resources directory.
**Workflow Association:** Part of `lint` script
**Cross-Reference:** Calls `bun run lint` → `lint:js` (package.json)

```bash
composer lint:js

```

#### 3.1.10. `lint:js:fix`

**Title:** Fix JavaScript Code Style
**Description:** Automatically formats JavaScript/TypeScript code with Prettier
**Explanation:** Delegates to package.json `lint:js:fix` script which runs Prettier in write mode to format code.
**Workflow Association:** Part of `lint:fix` script
**Cross-Reference:** Calls `bun run lint:fix` → `lint:js:fix` (package.json)

```bash
composer lint:js:fix

```

-----

### 3.2. Type Checking

#### 3.2.1. `test:types`

**Title:** Run All Type Checkers
**Description:** Executes both PHPStan and Psalm static analysis
**Explanation:** Aggregator script that runs comprehensive type checking from both PHPStan (Larastan) and Psalm to ensure maximum type safety coverage.
**Workflow Association:** Used in `test`, `testsuite:core`
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:types

```

#### 3.2.2. `test:types:phpstan`

**Title:** PHPStan Static Analysis
**Description:** Runs PHPStan (via Larastan) for Laravel-aware static analysis
**Explanation:** Analyzes PHP code for type errors, unused code, and potential bugs. Larastan provides Laravel-specific type inference for facades, Eloquent models, and Laravel patterns.
**Workflow Association:** Part of `test:types` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:types:phpstan

```

#### 3.2.3. `test:types:psalm`

**Title:** Psalm Static Analysis
**Description:** Runs Psalm static analysis for comprehensive type checking
**Explanation:** Analyzes PHP code with Psalm's advanced type system. Provides different analysis perspective than PHPStan, catching additional type issues and ensuring 100% type coverage. Uses Laravel, PHPUnit, and Mockery plugins.
**Workflow Association:** Part of `test:types` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:types:psalm

```

#### 3.2.4. `test:types:psalm:stats`

**Title:** Psalm Statistics
**Description:** Shows detailed type coverage statistics from Psalm
**Explanation:** Runs Psalm with statistics and info-level issues enabled to provide comprehensive type coverage metrics and detailed analysis information.
**Workflow Association:** Manual use for tracking type coverage improvements
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:types:psalm:stats

```

#### 3.2.5. `test:types:fix`

**Title:** Fix All Type Issues
**Description:** Automatically fixes issues found by both PHPStan and Psalm
**Explanation:** Aggregator script that attempts to auto-fix type issues using PHPStan's `--fix` flag and Psalm's `--alter` flag (Psalter). Note: Not all issues can be automatically fixed.
**Workflow Association:** Manual use for bulk type fixes
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:types:fix

```

#### 3.2.6. `test:types:fix:phpstan`

**Title:** PHPStan Auto-Fix
**Description:** Automatically fixes issues found by PHPStan (experimental)
**Explanation:** Runs PHPStan with `--fix` flag to automatically fix certain types of issues. This feature is experimental and may not fix all issues.
**Workflow Association:** Part of `test:types:fix` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:types:fix:phpstan

```

#### 3.2.7. `test:types:fix:psalm`

**Title:** Psalm Auto-Fix (Psalter)
**Description:** Automatically fixes issues found by Psalm using Psalter
**Explanation:** Runs Psalm with `--alter` flag to automatically fix type issues like adding missing return types, fixing type hints, and improving type annotations.
**Workflow Association:** Part of `test:types:fix` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:types:fix:psalm

```

-----

### 3.3. Testing

#### 3.3.1. `test`

**Title:** Full Test Suite
**Description:** Runs complete test suite with all checks
**Explanation:** Comprehensive test script that runs linting, type coverage, code coverage, unit tests, type checking, and security audit. This is the main test command for pre-commit and CI/CD.
**Workflow Association:** Primary test command
**Cross-Reference:** Calls `test:lint` which includes `lint:js` → `bun run lint` (package.json)

```bash
composer test

```

#### 3.3.2. `test:lint`

**Title:** Test Linting Checks
**Description:** Validates code style and structure before tests
**Explanation:** Runs Pint, Rector dry-run, and JavaScript linting checks to ensure code quality before running tests.
**Workflow Association:** Part of `test` script
**Cross-Reference:** Calls `lint:js` → `bun run lint` (package.json)

```bash
composer test:lint

```

#### 3.3.3. `test:type-coverage`

**Title:** Type Coverage Check
**Description:** Validates type coverage using Pest plugin
**Explanation:** Runs Pest with `--type-coverage` flag to check that code has sufficient type annotations. Requires 100% type coverage.
**Workflow Association:** Part of `test` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:type-coverage

```

#### 3.3.4. `test:coverage`

**Title:** Run All Coverage Reports
**Description:** Generates code coverage reports for PHP and JavaScript
**Explanation:** Aggregator script that runs both PHP coverage (PCOV) and JavaScript coverage (Vitest) to generate comprehensive coverage reports.
**Workflow Association:** Part of `test` script
**Cross-Reference:** Calls `test:coverage:js` → `bun run test:coverage:js` (package.json)

```bash
composer test:coverage

```

#### 3.3.5. `test:coverage:pcov`

**Title:** PHP Coverage (PCOV)
**Description:** Generates PHP code coverage report using PCOV extension
**Explanation:** Runs Pest tests with PCOV extension enabled to generate PHP code coverage. Requires 99.4% minimum coverage.
**Workflow Association:** Part of `test:coverage` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:coverage:pcov

```

#### 3.3.6. `test:coverage:xdebug`

**Title:** PHP Coverage (Xdebug)
**Description:** Generates PHP code coverage report using Xdebug extension
**Explanation:** Runs Pest tests with Xdebug coverage mode enabled. Falls back gracefully if Xdebug is not available. Requires 99.4% minimum coverage.
**Workflow Association:** Alternative to `test:coverage:pcov`
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:coverage:xdebug

```

#### 3.3.7. `test:coverage:js`

**Title:** JavaScript Coverage
**Description:** Generates JavaScript/TypeScript code coverage report
**Explanation:** Delegates to package.json to run Vitest with coverage enabled. Generates coverage reports for JavaScript/TypeScript files.
**Workflow Association:** Part of `test:coverage` script
**Cross-Reference:** Calls `bun run test:coverage:js` (package.json)

```bash
composer test:coverage:js

```

#### 3.3.8. `test:unit`

**Title:** Unit & Feature Tests
**Description:** Runs Pest unit and feature tests with coverage
**Explanation:** Executes Pest test suite for Unit and Feature tests with PCOV coverage enabled. Requires 99% minimum coverage.
**Workflow Association:** Part of `test` and `workflow:core` scripts
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:unit

```

#### 3.3.9. `test:unit:js`

**Title:** JavaScript Unit Tests
**Description:** Runs JavaScript/TypeScript unit tests
**Explanation:** Delegates to package.json to run Vitest for JavaScript/TypeScript unit tests.
**Workflow Association:** Not used in workflows (separate from PHP tests)
**Cross-Reference:** Calls `bun run test` → `test:unit:js` (package.json)

```bash
composer test:unit:js

```

#### 3.3.10. `test:browser`

**Title:** Browser Tests
**Description:** Runs Pest browser tests with Playwright
**Explanation:** Executes Pest browser tests using Playwright for end-to-end testing. Runs in parallel with 4 processes.
**Workflow Association:** Part of `testsuite:heavy` script
**Cross-Reference:** N/A (PHP-specific, uses Playwright via Pest)

```bash
composer test:browser

```

#### 3.3.11. `test:mutation`

**Title:** Mutation Testing
**Description:** Runs Infection mutation testing framework
**Explanation:** Executes Infection to perform mutation testing, ensuring test quality by introducing small changes (mutations) and verifying tests catch them. Requires 90% minimum mutation score indicator (MSI).
**Workflow Association:** Part of `testsuite:heavy` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:mutation

```

#### 3.3.12. `test:arch`

**Title:** Architecture Tests
**Description:** Runs Pest architecture tests using pest-plugin-arch
**Explanation:** Executes architecture tests to validate code structure, dependency rules, and architectural constraints defined in test files.
**Workflow Association:** Part of `testsuite:full` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:arch

```

#### 3.3.13. `test:profanity`

**Title:** Profanity Check
**Description:** Runs profanity checks using pest-plugin-profanity
**Explanation:** Scans codebase for profanity and inappropriate language in code, comments, and strings.
**Workflow Association:** Part of `testsuite:full` script
**Cross-Reference:** N/A (PHP-specific)

```bash
composer test:profanity

```

-----

### 3.4. Development Tools

#### 3.4.1. `ide-helper:generate`

**Title:** Generate IDE Helper
**Description:** Generates IDE helper files for better auto-completion
**Explanation:** Runs Laravel IDE Helper to generate helper files (e.g., `_ide_helper.php`) that improve IDE auto-completion for Laravel facades, Eloquent models, and other Laravel features.
**Workflow Association:** Manual use for IDE setup
**Cross-Reference:** N/A (PHP-specific)

```bash
composer ide-helper:generate
```

#### 3.4.2. `blueprint:build`

**Title:** Build Blueprint Components
**Description:** Generates Laravel components from Blueprint draft
**Explanation:** Reads `draft.yaml` file and generates controllers, models, migrations, tests, and routes according to Blueprint definitions.
**Workflow Association:** Manual use during development
**Cross-Reference:** N/A (PHP-specific)

```bash
composer blueprint:build
```

#### 3.4.3. `blueprint:trace`

**Title:** Trace Blueprint Models
**Description:** Creates Blueprint definitions for existing models
**Explanation:** Analyzes existing Eloquent models and generates Blueprint definitions that can be referenced in new draft files.
**Workflow Association:** Manual use for model discovery
**Cross-Reference:** N/A (PHP-specific)

```bash
composer blueprint:trace

```

-----

### 3.5. Code Refactoring

#### 3.5.1. `rector:type-perfect`

**Title:** Type Perfect Analysis
**Description:** Runs Rector Type Perfect for advanced type checking
**Explanation:** Executes Rector with Type Perfect configuration to perform advanced type analysis and suggest type improvements beyond standard Rector rules.
**Workflow Association:** Manual use for type refactoring
**Cross-Reference:** N/A (PHP-specific)

```bash
composer rector:type-perfect

```

-----

### 3.6. Security

#### 3.6.1. `security:audit`

**Title:** Security Audit
**Description:** Scans dependencies for known security vulnerabilities
**Explanation:** Runs Composer audit using Roave Security Advisories database to check all locked dependencies against known security vulnerabilities.
**Workflow Association:** Part of `test` and `workflow:core` scripts
**Cross-Reference:** N/A (PHP-specific)

```bash
composer security:audit

```

-----

### 3.7. Test Suites

#### 3.7.1. `testsuite:core`

**Title:** Core Test Suite
**Description:** Essential checks for code quality and correctness
**Explanation:** Runs linting, unit tests, type checking, and security audit. This is a fast test suite suitable for pre-commit hooks and frequent validation during development.
**Workflow Association:** Core test suite
**Cross-Reference:** Calls `test:lint` → `lint:js` → `bun run lint` (package.json)

```bash
composer testsuite:core

```

#### 3.7.2. `testsuite:heavy`

**Title:** Heavy Test Suite
**Description:** Comprehensive testing including mutation and browser tests
**Explanation:** Runs mutation testing and browser tests. These are time-consuming checks typically run in CI/CD pipelines or before major releases.
**Workflow Association:** Heavy test suite
**Cross-Reference:** N/A (PHP-specific)

```bash
composer testsuite:heavy

```

#### 3.7.3. `testsuite:full`

**Title:** Full Test Suite
**Description:** Complete test suite with all checks
**Explanation:** Runs core test suite plus architecture tests and profanity checks, then heavy test suite. This is the most comprehensive validation, suitable for release candidates.
**Workflow Association:** Full test suite
**Cross-Reference:** Includes `testsuite:core` which calls JS scripts

```bash
composer testsuite:full

```

-----

### 3.8. Policy

#### 3.8.1. `policy:checksum-monitor`

**Title:** Policy Checksum Monitor
**Description:** Monitors Laravel authorization policy checksums
**Explanation:** Runs Laravel policy checksum monitoring to detect changes in authorization policies that might affect security.
**Workflow Association:** Policy monitoring
**Cross-Reference:** N/A (PHP-specific)

```bash
composer policy:checksum-monitor

```

-----

### 3.9. Development

#### 3.9.1. `dev`

**Title:** Development Server
**Description:** Starts complete local development environment
**Explanation:** Runs Laravel server, queue worker, Pail logs, and Vite dev server concurrently using `concurrently`. Provides full-stack development environment with hot reloading.
**Workflow Association:** Daily development use
**Cross-Reference:** Calls `bun run dev` (package.json)

```bash
composer dev

```

#### 3.9.2. `setup`

**Title:** Project Setup
**Description:** Initial project setup and dependency installation
**Explanation:** Installs Composer and npm/bun dependencies, creates .env file, generates application key, runs migrations, and builds frontend assets. Use this for fresh project setup.
**Workflow Association:** Initial setup only
**Cross-Reference:** Calls `bun install` and `bun run build` (package.json)

```bash
composer setup

```

-----

### 3.10. CI/CD

#### 3.10.1. `ci:local`

**Title:** Local CI Checks
**Description:** Runs local continuous integration checks
**Explanation:** Executes shell script that runs comprehensive CI checks locally before pushing to remote repository.
**Workflow Association:** Pre-push validation
**Cross-Reference:** May call various scripts including JS scripts

```bash
composer ci:local

```

-----

### 3.11. Utilities

#### 3.11.1. `update:requirements`

**Title:** Update Requirements
**Description:** Updates Composer and npm dependencies to latest versions
**Explanation:** Runs `composer bump` to update Composer dependencies and `npm-check-updates` to update npm/bun dependencies. Review changes before committing.
**Workflow Association:** Periodic maintenance
**Cross-Reference:** Calls `bunx npm-check-updates` (package.json tool)

```bash
composer update:requirements

```

-----

## 4. Package.json Scripts

### 4.1. Build & Development

#### 4.1.1. `build`

**Title:** Build Production Assets
**Description:** Compiles and bundles frontend assets for production
**Explanation:** Runs Vite build to create optimized, minified production bundles of JavaScript, CSS, and other assets. Outputs to `public/build` directory.
**Workflow Association:** Used in `setup` (composer) and deployment
**Cross-Reference:** Called by `composer setup`

```bash
bun run build

```

#### 4.1.2. `dev`

**Title:** Development Server
**Description:** Starts Vite development server with hot module replacement
**Explanation:** Runs Vite dev server with HTTPS support using Herd SSL certificates. Provides hot reloading for frontend development.
**Workflow Association:** Part of `dev` workflow (composer)
**Cross-Reference:** Called by `composer dev` concurrently

```bash
bun run dev

```

#### 4.1.3. `preview`

**Title:** Preview Production Build
**Description:** Previews production build locally
**Explanation:** Serves the production build using Vite preview server to test production assets locally before deployment.
**Workflow Association:** Manual use before deployment
**Cross-Reference:** N/A

```bash
bun run preview

```

-----

### 4.2. Linting

#### 4.2.1. `lint`

**Title:** Run All Linters
**Description:** Runs JavaScript/TypeScript linting
**Explanation:** Aggregator script that delegates to `lint:js` for Prettier formatting checks.
**Workflow Association:** Used by `lint:js` (composer)
**Cross-Reference:** Called by `composer lint:js` → `bun run lint`

```bash
bun run lint

```

#### 4.2.2. `lint:fix`

**Title:** Fix All Linting Issues
**Description:** Automatically fixes JavaScript/TypeScript formatting
**Explanation:** Aggregator script that delegates to `lint:js:fix` for Prettier auto-formatting.
**Workflow Association:** Used by `lint:js:fix` (composer)
**Cross-Reference:** Called by `composer lint:js:fix` → `bun run lint:fix`

```bash
bun run lint:fix

```

#### 4.2.3. `lint:js`

**Title:** Check JavaScript Code Style
**Description:** Validates JavaScript/TypeScript code follows Prettier rules
**Explanation:** Runs Prettier in check mode on `resources/` directory. Reports formatting issues without modifying files.
**Workflow Association:** Part of `lint` script, called by composer `lint:js`
**Cross-Reference:** Called by `composer lint:js` → `bun run lint` → this script

```bash
bun run lint:js

```

#### 4.2.4. `lint:js:fix`

**Title:** Fix JavaScript Code Style
**Description:** Automatically formats JavaScript/TypeScript code
**Explanation:** Runs Prettier in write mode to automatically format code in `resources/` directory according to Prettier configuration.
**Workflow Association:** Part of `lint:fix` script, called by composer `lint:js:fix`
**Cross-Reference:** Called by `composer lint:js:fix` → `bun run lint:fix` → this script

```bash
bun run lint:js:fix

```

-----

### 4.3. Testing

#### 4.3.1. `test`

**Title:** Run JavaScript Unit Tests
**Description:** Runs Vitest unit tests with verbose reporter
**Explanation:** Executes Vitest test suite for JavaScript/TypeScript files. Uses verbose reporter for detailed output.
**Workflow Association:** Used by `test:unit:js` (composer)
**Cross-Reference:** Called by `composer test:unit:js` → `bun run test`

```bash
bun run test

```

#### 4.3.2. `test:browser`

**Title:** Browser Tests
**Description:** Runs Playwright end-to-end tests
**Explanation:** Executes Playwright browser tests for frontend functionality. Separate from Pest browser tests which test Laravel application.
**Workflow Association:** Manual use or separate CI workflow
**Cross-Reference:** N/A (separate from composer `test:browser` which uses Pest)

```bash
bun run test:browser

```

#### 4.3.3. `test:coverage`

**Title:** Run All Coverage Reports
**Description:** Generates JavaScript/TypeScript coverage report
**Explanation:** Aggregator script that delegates to `test:coverage:js`.
**Workflow Association:** Used by `test:coverage:js` (composer)
**Cross-Reference:** Called by `composer test:coverage:js` → `bun run test:coverage:js`

```bash
bun run test:coverage

```

#### 4.3.4. `test:coverage:js`

**Title:** JavaScript Coverage Report
**Description:** Generates comprehensive code coverage report
**Explanation:** Runs Vitest with coverage enabled and verbose reporter. Generates coverage reports for JavaScript/TypeScript files.
**Workflow Association:** Part of `test:coverage` script, called by composer
**Cross-Reference:** Called by `composer test:coverage:js` → `bun run test:coverage:js`

```bash
bun run test:coverage:js

```

#### 4.3.5. `test:coverage:js:clover`

**Title:** JavaScript Coverage (Clover Format)
**Description:** Generates coverage report in Clover XML format
**Explanation:** Runs Vitest with coverage in Clover XML format, suitable for CI/CD tools that accept Clover reports.
**Workflow Association:** CI/CD integration
**Cross-Reference:** N/A

```bash
bun run test:coverage:js:clover

```

#### 4.3.6. `test:coverage:js:html`

**Title:** JavaScript Coverage (HTML Format)
**Description:** Generates interactive HTML coverage report
**Explanation:** Runs Vitest with coverage and generates HTML report for visual inspection of coverage.
**Workflow Association:** Manual review
**Cross-Reference:** N/A

```bash
bun run test:coverage:js:html

```

#### 4.3.7. `test:coverage:js:json`

**Title:** JavaScript Coverage (JSON Format)
**Description:** Generates coverage report in JSON format
**Explanation:** Runs Vitest with coverage in JSON format for programmatic processing.
**Workflow Association:** CI/CD integration
**Cross-Reference:** N/A

```bash
bun run test:coverage:js:json

```

#### 4.3.8. `test:coverage:js:lcov`

**Title:** JavaScript Coverage (LCOV Format)
**Description:** Generates coverage report in LCOV format
**Explanation:** Runs Vitest with coverage in LCOV format, commonly used by coverage visualization tools.
**Workflow Association:** CI/CD and coverage tools
**Cross-Reference:** N/A

```bash
bun run test:coverage:js:lcov

```

#### 4.3.9. `test:coverage:js:text`

**Title:** JavaScript Coverage (Text Format)
**Description:** Generates coverage report in plain text format
**Explanation:** Runs Vitest with coverage in text format for terminal output.
**Workflow Association:** Quick terminal review
**Cross-Reference:** N/A

```bash
bun run test:coverage:js:text

```

#### 4.3.10. `test:lint`

**Title:** Test Linting Checks
**Description:** Validates code style before running tests
**Explanation:** Delegates to `lint:js` to check code formatting before tests.
**Workflow Association:** Pre-test validation
**Cross-Reference:** N/A

```bash
bun run test:lint

```

#### 4.3.11. `test:run`

**Title:** Run Tests (Minimal Output)
**Description:** Runs Vitest tests with default reporter
**Explanation:** Executes Vitest test suite with standard output format (less verbose than `test`).
**Workflow Association:** Quick test runs
**Cross-Reference:** N/A

```bash
bun run test:run

```

#### 4.3.12. `test:unit`

**Title:** Run Unit Tests
**Description:** Runs JavaScript unit tests
**Explanation:** Aggregator script that delegates to `test:unit:js`.
**Workflow Association:** Used by `test:unit:js` (composer)
**Cross-Reference:** Called by `composer test:unit:js` → `bun run test` → this script

```bash
bun run test:unit

```

#### 4.3.13. `test:unit:js`

**Title:** JavaScript Unit Tests
**Description:** Runs Vitest unit tests with verbose output
**Explanation:** Executes Vitest test suite with verbose reporter. Primary test command for JavaScript/TypeScript files.
**Workflow Association:** Used by composer `test:unit:js`
**Cross-Reference:** Called by `composer test:unit:js` → `bun run test` → `test:unit:js` (circular but works)

```bash
bun run test:unit:js

```

#### 4.3.14. `test:watch`

**Title:** Watch Mode Tests
**Description:** Runs tests in watch mode with auto-reload
**Explanation:** Executes Vitest in watch mode, automatically re-running tests when files change. Ideal for TDD workflow.
**Workflow Association:** Development workflow
**Cross-Reference:** N/A

```bash
bun run test:watch

```

#### 4.3.15. `playwright:install`

**Title:** Install Playwright
**Description:** Installs Playwright browsers and dependencies
**Explanation:** Downloads and installs required Playwright browsers (Chromium, Firefox, WebKit) and system dependencies needed for browser testing.
**Workflow Association:** Initial setup and CI/CD
**Cross-Reference:** N/A

```bash
bun run playwright:install
```

-----

## 5. Cross-References

### 5.1. PHP → JavaScript

| Composer Script | Package.json Script | Purpose |
|----------------|---------------------|---------|
| `lint:js` | `lint:js` | Check JS code style |
| `lint:js:fix` | `lint:js:fix` | Fix JS code style |
| `test:unit:js` | `test:unit:js` | Run JS unit tests |
| `test:coverage:js` | `test:coverage:js` | JS coverage report |
| `dev` | `dev` | Development server |

### 5.2. JavaScript → PHP

| Package.json Script | Composer Script | Purpose |
|---------------------|----------------|---------|
| `build` | `setup` | Production build |
| `dev` | `dev` | Dev server (concurrent) |

### 5.3. Bidirectional

| Script Name | Composer | Package.json | Notes |
|------------|----------|--------------|-------|
| `lint` | Aggregator | Aggregator | Different tools, same pattern |
| `lint:fix` | Aggregator | Aggregator | Different tools, same pattern |
| `test` | Full suite | Unit tests | Different scope |
| `test:unit` | PHP tests | JS tests | Different languages |
| `test:coverage` | Aggregator | Aggregator | Different tools, same pattern |

-----

## 6. Workflow Associations

### 6.1. Primary Workflows

1. **`test`** - Main test suite
   - `test:lint`
   - `test:type-coverage`
   - `test:coverage`
   - `test:unit`
   - `test:types`
   - `security:audit`

2. **`testsuite:core`** - Essential checks
   - `test:lint`
   - `test:unit`
   - `test:types`
   - `security:audit`

3. **`testsuite:heavy`** - Comprehensive testing
   - `test:mutation`
   - `test:browser`

4. **`testsuite:full`** - Complete validation
   - `testsuite:core`
   - `test:arch`
   - `test:profanity`
   - `testsuite:heavy`

### 6.2. Development Workflows

- **`dev`** - Local development
  - Laravel server
  - Queue worker
  - Pail logs
  - Vite dev server (via package.json)

- **`setup`** - Initial setup
  - Composer install
  - npm/bun install (package.json)
  - Build assets (package.json)

-----

## 7. Usage Examples

### 7.1. Quick Development Checks

```bash
# Check code style
composer lint

# Fix code style
composer lint:fix

# Run type checking
composer test:types

# Run core test suite (fast)
composer testsuite:core

```

### 7.2. Full Test Suite

```bash
# Complete test suite
composer test

# With type fixes
composer test:types:fix

# Full test suite (release candidate)
composer testsuite:full

```

### 7.3. Development

```bash
# Start dev environment
composer dev

# Build for production
bun run build

# Watch tests
bun run test:watch

```

### 7.4. Maintenance

```bash
# Update dependencies
composer update:requirements

# Generate IDE helpers
composer ide-helper:generate

# Check security
composer security:audit

```

-----

## 8. Notes

- All scripts follow consistent naming patterns
- Aggregator scripts (without tool suffix) run multiple tools
- Individual tool scripts use `:toolname` suffix
- Fix scripts use `:fix:toolname` pattern
- JavaScript scripts use `:js` suffix when language-specific
- Cross-references are bidirectional where applicable
- Workflows can be chained for comprehensive validation

-----
