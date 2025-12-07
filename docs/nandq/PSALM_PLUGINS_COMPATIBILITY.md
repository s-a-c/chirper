# Psalm Plugin Compatibility with Psalm 6.x

<details>
<summary>Table of Contents</summary>

- [Psalm Plugin Compatibility with Psalm 6.x](#psalm-plugin-compatibility-with-psalm-6x)
  - [1. Quick Answer](#1-quick-answer)
  - [2. Detailed Compatibility Status](#2-detailed-compatibility-status)
    - [2.1. ✅ psalm/plugin-laravel - **COMPATIBLE**](#21--psalmplugin-laravel---compatible)
    - [2.2. ✅ psalm/plugin-phpunit - **COMPATIBLE**](#22--psalmplugin-phpunit---compatible)
    - [2.3. ✅ psalm/plugin-mockery - **COMPATIBLE**](#23--psalmplugin-mockery---compatible)
  - [3. Installation Instructions](#3-installation-instructions)
    - [3.1. For Psalm 6.x Compatibility](#31-for-psalm-6x-compatibility)
    - [3.2. Known Issues](#32-known-issues)
      - [3.2.1. psalm/plugin-laravel Dependency Conflict](#321-psalmplugin-laravel-dependency-conflict)
      - [3.2.2. Psalm Version Requirements](#322-psalm-version-requirements)
  - [4. Recommended Installation Order](#4-recommended-installation-order)
  - [5. Installation Test](#5-installation-test)
  - [6. Configuration After Installation](#6-configuration-after-installation)
  - [7. Alternative: Use Stable Versions](#7-alternative-use-stable-versions)
  - [8. Summary](#8-summary)
  - [9. Next Steps](#9-next-steps)
  - [10. Resources](#10-resources)

</details>

-----

## 1. Quick Answer

**YES** - The `dev-master` branches of the recommended Psalm plugins **DO support Psalm 6.x**!

-----

## 2. Detailed Compatibility Status

### 2.1. ✅ psalm/plugin-laravel - **COMPATIBLE**

**dev-master branch requirements:**

```json
"vimeo/psalm": "dev-master || ^6.0 || ^7.0.0-beta1"

```

✅ **Supports Psalm 6.0+ and 7.0 beta**

**Note:** There is a dependency conflict with `barryvdh/laravel-ide-helper`:

- Plugin requires: `~3.5.4`
- Your project has: `^3.6`

**Workaround options:**

1. Temporarily downgrade to `~3.5.4` (if compatible with your Laravel version)
2. Wait for plugin to update its requirements
3. Fork the plugin and update the requirement

### 2.2. ✅ psalm/plugin-phpunit - **COMPATIBLE**

**dev-master branch requirements:**

```json
"vimeo/psalm": "dev-master || ^6.10.0"

```

✅ **Supports Psalm 6.10.0+**

This plugin requires a minimum of Psalm 6.10.0, so ensure you have at least that version.

### 2.3. ✅ psalm/plugin-mockery - **COMPATIBLE**

**dev-master branch requirements:**

```json
"vimeo/psalm": "dev-master || ^5.0 || ^6 || ^7"

```

✅ **Supports Psalm 5.0+, 6.x, and 7.x**

This is the most flexible plugin - supports multiple Psalm versions.

-----

## 3. Installation Instructions

### 3.1. For Psalm 6.x Compatibility

To install the dev-master branches that support Psalm 6:

```bash
# Plugin Laravel (has dependency conflict - see below)
composer require --dev "psalm/plugin-laravel:dev-master"

# Plugin PHPUnit (requires Psalm 6.10.0+)
composer require --dev "psalm/plugin-phpunit:dev-master"

# Plugin Mockery (fully compatible)
composer require --dev "psalm/plugin-mockery:dev-master"

```

### 3.2. Known Issues

#### 3.2.1. psalm/plugin-laravel Dependency Conflict

**Conflict:**

- Plugin requires: `barryvdh/laravel-ide-helper ~3.5.4`
- Your project has: `barryvdh/laravel-ide-helper ^3.6`

**Solutions:**

**Option A: Temporarily adjust version constraint**

```json
// In composer.json, temporarily change:
"barryvdh/laravel-ide-helper": "~3.5.4"

```

**Option B: Use composer platform config**
Add to `composer.json`:

```json
{
    "config": {
        "platform": {
            "barryvdh/laravel-ide-helper": "3.5.5"
        }
    }
}

```

**Option C: Wait for plugin update**
onitor: [https://github.com/psalm/psalm-plugin-laravel/issues]

#### 3.2.2. Psalm Version Requirements

**psalm/plugin-phpunit** requires Psalm 6.10.0 or higher:

```bash
# Check your Psalm version
vendor/bin/psalm --version

# Should be 6.10.0 or higher for phpunit plugin

```

-----

## 4. Recommended Installation Order

1. ✅ **psalm/plugin-mockery** - No conflicts, installs cleanly
2. ✅ **psalm/plugin-phpunit** - Check Psalm version first (needs 6.10.0+)
3. ⚠️ **psalm/plugin-laravel** - Resolve ide-helper conflict first

-----

## 5. Installation Test

Test installation without modifying composer.json:

```bash
# Test mockery plugin (should work)
composer require --dev "psalm/plugin-mockery:dev-master" --dry-run

# Test phpunit plugin (check Psalm version first)
composer require --dev "psalm/plugin-phpunit:dev-master" --dry-run

# Test laravel plugin (will show conflict)
composer require --dev "psalm/plugin-laravel:dev-master" --dry-run

```

-----

## 6. Configuration After Installation

Once installed, uncomment the plugins in `psalm.xml`:

```xml
<plugins>
    <pluginClass class="Psalm\LaravelPlugin\Plugin" />
    <pluginClass class="Psalm\Plugin\PhpUnit\Plugin" />
    <pluginClass class="Psalm\Plugin\Mockery\Plugin" />
</plugins>

```

-----

## 7. Alternative: Use Stable Versions

If dev-master branches cause issues, you can also check for stable versions:

```bash
# Check available stable versions
composer show psalm/plugin-laravel --all | grep "^versions"

```

However, stable versions may not have Psalm 6.x support yet.

-----

## 8. Summary

| Plugin | dev-master Supports Psalm 6? | Notes |
|--------|------------------------------|-------|
| psalm/plugin-laravel | ✅ Yes | Requires ide-helper ~3.5.4 (conflict with ^3.6) |
| psalm/plugin-phpunit | ✅ Yes | Requires Psalm 6.10.0+ |
| psalm/plugin-mockery | ✅ Yes | Most flexible, supports 5.x, 6.x, 7.x |

-----

## 9. Next Steps

1. Check your Psalm version: `vendor/bin/psalm --version`
2. Install mockery plugin first (easiest): `composer require --dev "psalm/plugin-mockery:dev-master"`
3. Resolve laravel plugin dependency conflict
4. Update psalm.xml to enable plugins
5. Run type checking: `composer test:types:all`

-----

## 10. Resources

- [psalm-plugin-laravel Repository](https://github.com/psalm/psalm-plugin-laravel)
- [psalm-plugin-phpunit Repository](https://github.com/psalm/psalm-plugin-phpunit)
- [psalm-plugin-mockery Repository](https://github.com/psalm/psalm-plugin-mockery)

-----
