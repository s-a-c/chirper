# Installing Psalm Plugins - Complete Installation Guide

<details>
<summary>Table of Contents</summary>

- [Installing Psalm Plugins - Complete Installation Guide](#installing-psalm-plugins---complete-installation-guide)
  - [1. Current Status](#1-current-status)
  - [2. Understanding the Conflict](#2-understanding-the-conflict)
  - [3. Important: Why Forking ide-helper Won't Work](#3-important-why-forking-ide-helper-wont-work)
  - [4. Recommended Solution: Fork psalm-plugin-laravel](#4-recommended-solution-fork-psalm-plugin-laravel)
  - [5. Complete Installation Steps](#5-complete-installation-steps)
    - [5.1. Step 1: Fork psalm-plugin-laravel](#51-step-1-fork-psalm-plugin-laravel)
    - [5.2. Step 2: Update composer.json in Your Fork](#52-step-2-update-composerjson-in-your-fork)
    - [5.3. Step 3: Commit and Push](#53-step-3-commit-and-push)
    - [5.4. Step 4: Configure Your Project](#54-step-4-configure-your-project)
    - [5.5. Step 5: Install](#55-step-5-install)
  - [6. What I'll Do After You Fork](#6-what-ill-do-after-you-fork)
  - [7. Alternative: If You Insist on Forking ide-helper](#7-alternative-if-you-insist-on-forking-ide-helper)
  - [8. Quick Reference](#8-quick-reference)
  - [9. Ready to Proceed?](#9-ready-to-proceed)

</details>

-----

## 1. Current Status

✅ **psalm/plugin-mockery** - Installed (dev-master)
✅ **psalm/plugin-phpunit** - Installed (dev-master)
⚠️ **psalm/plugin-laravel** - Blocked by dependency conflict

-----

## 2. Understanding the Conflict

The conflict exists because:

- **Plugin requires**: `barryvdh/laravel-ide-helper ~3.5.4` (means: >=3.5.4,<3.6.0)
- **Your project has**: `barryvdh/laravel-ide-helper ^3.6` (means: >=3.6.0,<4.0.0)

These ranges don't overlap, so Composer cannot satisfy both.

-----

## 3. Important: Why Forking ide-helper Won't Work

If you fork `barryvdh/laravel-ide-helper`, the plugin will **still reject** your version because:

- The plugin's `composer.json` explicitly requires `~3.5.4`
- Even if your fork is version 3.6, the plugin's constraint will reject it
- You'd need to somehow make version 3.6 satisfy the `~3.5.4` constraint, which is impossible

-----

## 4. Recommended Solution: Fork psalm-plugin-laravel

**This is the correct approach:**

1. Fork the plugin (small, focused package)
2. Update its requirement to accept both versions
3. Use your fork until the official version is updated

-----

## 5. Complete Installation Steps

### 5.1. Step 1: Fork psalm-plugin-laravel

1. Visit: [https://github.com/psalm/psalm-plugin-laravel]
2. Click the **"Fork"** button
3. Fork to your GitHub account

### 5.2. Step 2: Update composer.json in Your Fork

Clone your fork and edit `composer.json`:

```bash
git clone https://github.com/YOUR-USERNAME/psalm-plugin-laravel.git
cd psalm-plugin-laravel

```

Find this line in `composer.json`:

```json
"barryvdh/laravel-ide-helper": "~3.5.4"

```

Change it to:

```json
"barryvdh/laravel-ide-helper": "^3.5.4 || ^3.6"

```

### 5.3. Step 3: Commit and Push

```bash
git add composer.json
git commit -m "Update laravel-ide-helper requirement to support ^3.6"
git push origin master

```

### 5.4. Step 4: Configure Your Project

After you fork and push, I can help you add this to your `composer.json`. Just share your GitHub username!

The configuration will look like:

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/YOUR-USERNAME/psalm-plugin-laravel"
        }
    ],
    "require-dev": {
        "psalm/plugin-laravel": "dev-master"
    }
}

```

### 5.5. Step 5: Install

Once configured, install:

```bash
composer require --dev "psalm/plugin-laravel:dev-master"

```

-----

## 6. What I'll Do After You Fork

Once you've:

1. ✅ Forked the plugin
2. ✅ Updated composer.json
3. ✅ Pushed the changes
4. ✅ Shared your GitHub username

I will:

1. ✅ Add the repository to composer.json
2. ✅ Install the plugin
3. ✅ Update psalm.xml to enable all plugins
4. ✅ Test that everything works
5. ✅ Run type checking

-----

## 7. Alternative: If You Insist on Forking ide-helper

If you really want to fork `laravel-ide-helper` (not recommended), you would need to:

1. Fork: [https://github.com/barryvdh/laravel-ide-helper]
2. Create a version tag like `3.5.6` that satisfies `~3.5.4`
3. Backport all 3.6 features into that version
4. Use your fork with that version

This is much more complex and not recommended.

-----

## 8. Quick Reference

**To resolve the conflict:**

- ✅ Fork: `psalm-plugin-laravel` (recommended)
- ❌ Fork: `laravel-ide-helper` (won't work, more complex)

**The fix:**

- Update plugin's composer.json: `~3.5.4` → `^3.5.4 || ^3.6`

-----

## 9. Ready to Proceed?

1. Fork: [https://github.com/psalm/psalm-plugin-laravel]
2. Update: composer.json as shown above
3. Push: Your changes
4. Share: Your GitHub username

Then I'll complete the setup automatically!

-----
