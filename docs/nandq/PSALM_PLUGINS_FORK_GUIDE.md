# Fork Guide for Installing psalm-plugin-laravel

<details>
<summary>Table of Contents</summary>

- [Fork Guide for Installing psalm-plugin-laravel](#fork-guide-for-installing-psalm-plugin-laravel)
  - [1. Important: Why Forking ide-helper Won't Work](#1-important-why-forking-ide-helper-wont-work)
  - [2. The Correct Solution: Fork the Plugin](#2-the-correct-solution-fork-the-plugin)
  - [3. Step-by-Step Instructions](#3-step-by-step-instructions)
    - [3.1. Fork the Plugin Repository](#31-fork-the-plugin-repository)
    - [3.2. Clone Your Fork](#32-clone-your-fork)
    - [3.3. Update composer.json](#33-update-composerjson)
    - [3.4. Commit and Push](#34-commit-and-push)
    - [3.5. Share Your GitHub Username](#35-share-your-github-username)
  - [4. What Your Forked composer.json Should Look Like](#4-what-your-forked-composerjson-should-look-like)
  - [5. After You Fork - Next Steps](#5-after-you-fork---next-steps)
  - [6. Summary](#6-summary)

</details>

-----

## 1. Important: Why Forking ide-helper Won't Work

**The Problem:**

- `psalm-plugin-laravel` requires: `barryvdh/laravel-ide-helper ~3.5.4` (which means >=3.5.4,<3.6.0)
- Your project has: `barryvdh/laravel-ide-helper ^3.6` (which means >=3.6.0,<4.0.0)

**Why forking ide-helper doesn't help:**
Even if you fork `laravel-ide-helper` and create version 3.6, the plugin's `composer.json` will still reject it because `3.6.0` is not in the range `>=3.5.4,<3.6.0`.

-----

## 2. The Correct Solution: Fork the Plugin

We need to fork **`psalm-plugin-laravel`** and update its requirement to accept both versions.

-----

## 3. Step-by-Step Instructions

### 3.1. Fork the Plugin Repository

Visit: [https://github.com/psalm/psalm-plugin-laravel]

Click the **"Fork"** button in the top-right corner.

### 3.2. Clone Your Fork

```bash
git clone https://github.com/YOUR-USERNAME/psalm-plugin-laravel.git
cd psalm-plugin-laravel

```

### 3.3. Update composer.json

Open `composer.json` and find:

```json
"barryvdh/laravel-ide-helper": "~3.5.4"
```

Change it to:

```json
"barryvdh/laravel-ide-helper": "^3.5.4 || ^3.6"
```

### 3.4. Commit and Push

```bash
git add composer.json
git commit -m "Update laravel-ide-helper requirement to support ^3.6"
git push origin master
```

### 3.5. Share Your GitHub Username

Once you've completed the above steps, share your GitHub username and I'll:

- ✅ Add the repository to your composer.json
- ✅ Install the plugin
- ✅ Configure psalm.xml
- ✅ Test everything works

-----

## 4. What Your Forked composer.json Should Look Like

The relevant section:

```json
{
    "require": {
        "barryvdh/laravel-ide-helper": "^3.5.4 || ^3.6",
        // ... other requirements
    }
}

```

-----

## 5. After You Fork - Next Steps

1. **Fork**: [https://github.com/psalm/psalm-plugin-laravel]
2. **Update**: composer.json as shown above
3. **Push**: Your changes
4. **Share**: Your GitHub username with me
5. **Install**: I'll help you install from your fork

-----

## 6. Summary

- ✅ Fork: `psalm-plugin-laravel` (small plugin package)
- ❌ Don't fork: `laravel-ide-helper` (won't solve the problem)

The fix is simple: update one line in the plugin's composer.json!

-----
