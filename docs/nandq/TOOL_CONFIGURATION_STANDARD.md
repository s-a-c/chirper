# Standard Tool Configuration Pattern

<details>
<summary>Table of Contents</summary>

- [Standard Tool Configuration Pattern](#standard-tool-configuration-pattern)
  - [1. Standard Path Configuration](#1-standard-path-configuration)
  - [2. Standard Exclusions](#2-standard-exclusions)
  - [3. Standard Cache/Temp Directory Pattern](#3-standard-cachetemp-directory-pattern)
  - [4. Configuration Consistency Checklist](#4-configuration-consistency-checklist)
  - [5. Current Tool Status](#5-current-tool-status)
    - [5.1. ✅ PHPStan (`phpstan.neon`)](#51--phpstan-phpstanneon)
    - [5.2. ✅ Psalm (`psalm.xml`)](#52--psalm-psalmxml)
    - [5.3. ✅ Rector (`rector.php`)](#53--rector-rectorphp)
    - [5.4. ✅ Pint (`pint.json`)](#54--pint-pintjson)
    - [5.5. ✅ Infection (`infection.json.dist`)](#55--infection-infectionjsondist)
  - [6. Migration Notes](#6-migration-notes)
    - [6.1. Changes Made for Consistency](#61-changes-made-for-consistency)
  - [7. Future Considerations](#7-future-considerations)

</details>

This document defines the standard configuration pattern used across all development tools in this project.

-----

## 1. Standard Path Configuration

All static analysis and refactoring tools should analyze these paths:

```log
✅ app
✅ bootstrap/app.php  (specific file, not entire directory)
✅ config
✅ database  (excluding migrations)
✅ public
✅ routes
✅ tests

```

-----

## 2. Standard Exclusions

All tools should exclude:

```log
❌ vendor/
❌ storage/
❌ tmp/
❌ node_modules/
❌ database/migrations/

```

-----

## 3. Standard Cache/Temp Directory Pattern

All tools should use **relative paths** in the project's `tmp/` directory:

```log
✅ tmp/phpstan  (PHPStan)
✅ tmp/psalm    (Psalm)
✅ tmp/rector   (Rector)

```

**Rationale**: Using relative paths ensures portability across different environments and allows the cache to be easily ignored in version control.

-----

## 4. Configuration Consistency Checklist

When configuring a new tool or updating an existing one, ensure:

- [ ] Uses standard paths listed above
- [ ] Excludes standard directories listed above
- [ ] Uses relative cache path in `tmp/` directory
- [ ] Follows the same pattern as other tools
- [ ] Documented in this file

-----

## 5. Current Tool Status

### 5.1. ✅ PHPStan (`phpstan.neon`)

- ✅ Standard paths configured (including bootstrap and database/migrations)
- ✅ Excludes `bootstrap/cache`
- ✅ Uses `tmp/phpstan`

### 5.2. ✅ Psalm (`psalm.xml`)

- ✅ Standard paths configured (including bootstrap directory)
- ✅ Excludes standard directories including `bootstrap/cache`
- ⚠️ Cache directory: Not explicitly configured (uses default)

### 5.3. ✅ Rector (`rector.php`)

- ✅ Standard paths configured (including bootstrap and database/migrations)
- ✅ Uses `tmp/rector` (relative path)

### 5.4. ✅ Pint (`pint.json`)

- ✅ Exclusion-based approach
- ✅ Excludes `tmp` and test directories
- N/A (no cache directory)

### 5.5. ✅ Infection (`infection.json.dist`)

- ⚠️ Only analyzes `app` directory
- Consider expanding to match standard paths for better coverage

-----

## 6. Migration Notes

### 6.1. Changes Made for Consistency

1. **All tools**: Changed to include `bootstrap` directory (excluding `bootstrap/cache`)
2. **All tools**: Changed to include `database/migrations/*.php` files (no longer excluded)
3. **Rector**: Changed cache from `/tmp/rector` to `tmp/rector` (relative path, matches PHPStan pattern)

-----

## 7. Future Considerations

- Consider adding Psalm cache directory configuration if supported
- Review Infection configuration to expand analysis coverage
- Document any tool-specific requirements that differ from standard pattern

-----
