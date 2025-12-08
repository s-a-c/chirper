# Act Timeout & Performance Investigation

-----

<details><summary>Click for Table of Contents</summary>

- [Act Timeout \& Performance Investigation](#act-timeout--performance-investigation)
  - [1. Current Situation](#1-current-situation)
  - [2. Investigation Results](#2-investigation-results)
    - [2.1. Act Timeout Options](#21-act-timeout-options)
    - [2.2. Podman Support](#22-podman-support)
    - [2.3. Slimmer Docker Images](#23-slimmer-docker-images)
      - [2.3.1. Option A: `mauwii/ubuntu-act` (Recommended)](#231-option-a-mauwiiubuntu-act-recommended)
      - [2.3.2. Option B: `node:*-slim` images](#232-option-b-node-slim-images)
    - [2.4. Laravel-Specific Images](#24-laravel-specific-images)
  - [3. Recommended Solutions](#3-recommended-solutions)
    - [3.1. Solution 1: Add Timeout Configuration (IMMEDIATE)](#31-solution-1-add-timeout-configuration-immediate)
    - [3.2. Solution 2: Switch to Slimmer Image (RECOMMENDED)](#32-solution-2-switch-to-slimmer-image-recommended)
    - [3.3. Solution 3: Create `.actrc` Configuration File (OPTIONAL)](#33-solution-3-create-actrc-configuration-file-optional)
    - [3.4. Solution 4: Podman Support (FUTURE - IF NEEDED)](#34-solution-4-podman-support-future---if-needed)
  - [4. Performance Comparison](#4-performance-comparison)
  - [5. Implementation Plan](#5-implementation-plan)
    - [5.1. Phase 1: Immediate (High Priority)](#51-phase-1-immediate-high-priority)
    - [5.2. Phase 2: Short-term (Recommended)](#52-phase-2-short-term-recommended)
    - [5.3. Phase 3: Future (If Needed)](#53-phase-3-future-if-needed)
  - [6. Testing Checklist](#6-testing-checklist)
  - [7. References](#7-references)

</details>

-----

## 1. Current Situation

- **Act Version**: `0.2.83` (installed)
- **Current Image**: `catthehacker/ubuntu:act-latest`
- **Container Architecture**: `linux/amd64`
- **Docker**: Available at `/opt/homebrew/bin/docker`
- **Podman**: Available at `/opt/podman/bin/podman`
- **Issue**: Timeout problems with long-running workflows

## 2. Investigation Results

### 2.1. Act Timeout Options

**Finding**: Act does NOT have a direct `--timeout` CLI flag.

**Solution**: Use `timeout-minutes` in workflow YAML files:

```yaml
jobs:
  example-job:
    runs-on: ubuntu-latest
    timeout-minutes: 120  # Increase from default (360 minutes on GitHub, but act may have different defaults)
    steps:
      - name: Checkout code
        uses: actions/checkout@v4
```

**Recommendation**: Add `timeout-minutes` to all jobs in workflow files that are tested with `act`.

### 2.2. Podman Support

**Finding**: Act does NOT officially support Podman, but it CAN work with configuration.

**Requirements for Podman**:

1. Podman must be installed (✅ Available at `/opt/podman/bin/podman`)
2. Create socket compatibility:

   ```bash
   # macOS with podman-mac-helper
   export DOCKER_HOST=unix://$HOME/.local/share/containers/podman/machine/podman-machine-default/podman.sock

   # Linux/Fedora
   sudo systemctl enable --now podman.socket
   sudo ln -s /var/run/podman/podman.sock /var/run/docker.sock
   ```

**Pros**:

- Lighter weight than Docker
- Better resource management
- Rootless containers

**Cons**:

- Not officially supported
- Requires additional setup
- May have compatibility issues

**Recommendation**: **NOT RECOMMENDED** for now. Stick with Docker unless there are specific resource constraints. If needed, we can add Podman support as an optional alternative.

### 2.3. Slimmer Docker Images

**Current Image**: `catthehacker/ubuntu:act-latest` (full Ubuntu with GitHub Actions runner)

**Alternatives**:

#### 2.3.1. Option A: `mauwii/ubuntu-act` (Recommended)

- **Images Available**:
  - `mauwii/ubuntu-act:latest`
  - `mauwii/ubuntu-act:22.04`
  - `mauwii/ubuntu-act:20.04`
- **Pros**:
  - Specifically designed for `act`
  - Lighter than `catthehacker/ubuntu:act-latest`
  - Multiple Ubuntu versions available
- **Cons**:
  - May have fewer pre-installed tools
  - Less battle-tested than `catthehacker` images

#### 2.3.2. Option B: `node:*-slim` images

- **Images**: `node:20-bullseye-slim`, `node:18-buster-slim`
- **Pros**:
  - Very lightweight
  - Good for Node.js-heavy workflows
- **Cons**:
  - Missing GitHub Actions runner setup
  - Would require custom runner installation
  - Not suitable for PHP/Laravel workflows

**Recommendation**: **Try `mauwii/ubuntu-act:latest`** as it's designed for act and should be lighter while maintaining compatibility.

### 2.4. Laravel-Specific Images

**Finding**: Laravel-specific Docker images exist but are NOT suitable for `act`.

**Why**: Act requires GitHub Actions runner images, not application images.

**Alternative Approach**: Use a base image and install Laravel dependencies:

- Not recommended - would require significant setup
- Act images already have most tools needed

**Recommendation**: **NOT RECOMMENDED**. Stick with act-compatible runner images.

## 3. Recommended Solutions

### 3.1. Solution 1: Add Timeout Configuration (IMMEDIATE)

Add `timeout-minutes` to all workflow jobs:

```yaml
jobs:
  core-quality:
    runs-on: ubuntu-latest
    timeout-minutes: 60  # Adjust based on typical execution time
    steps:
      # ... existing steps
```

**Implementation**: Update all `.github/workflows/*.yml` files.

### 3.2. Solution 2: Switch to Slimmer Image (RECOMMENDED)

Update `composer.json` scripts to use `mauwii/ubuntu-act:latest`:

```json
"bash -c 'act push -W .github/workflows/browser-tests.yml ... -P ubuntu-latest=mauwii/ubuntu-act:latest'"
```

**Benefits**:

- Faster container startup
- Lower memory usage
- Faster image pulls

**Implementation**: Replace all `-P ubuntu-latest=catthehacker/ubuntu:act-latest` with `-P ubuntu-latest=mauwii/ubuntu-act:latest`

### 3.3. Solution 3: Create `.actrc` Configuration File (OPTIONAL)

Create `~/.actrc` or `.actrc` in project root:

```actrc
-P ubuntu-latest=mauwii/ubuntu-act:latest
-P ubuntu-22.04=mauwii/ubuntu-act:22.04
-P ubuntu-20.04=mauwii/ubuntu-act:20.04
--container-architecture linux/amd64
```

This allows removing `-P` flags from composer scripts.

### 3.4. Solution 4: Podman Support (FUTURE - IF NEEDED)

If Docker becomes a bottleneck:

1. Install `podman-mac-helper` (macOS) or configure Podman socket (Linux)
2. Set `DOCKER_HOST` environment variable
3. Act should work transparently

**Implementation**: Add helper script to detect and configure Podman.

## 4. Performance Comparison

| Image | Size | Startup Time | Memory Usage | Compatibility |
|-------|------|--------------|--------------|---------------|
| `catthehacker/ubuntu:act-latest` | Large | Slow | High | Excellent |
| `mauwii/ubuntu-act:latest` | Medium | Medium | Medium | Good |
| `node:*-slim` | Small | Fast | Low | Poor (needs setup) |

## 5. Implementation Plan

### 5.1. Phase 1: Immediate (High Priority)

1. ✅ Add `timeout-minutes` to all workflow jobs
2. ✅ Test with current image to establish baseline

### 5.2. Phase 2: Short-term (Recommended)

1. ✅ Switch to `mauwii/ubuntu-act:latest`
2. ✅ Update all composer scripts
3. ✅ Test workflows to ensure compatibility
4. ✅ Create `.actrc` file for project-wide defaults

### 5.3. Phase 3: Future (If Needed)

1. ⏸️ Evaluate Podman if Docker performance is still an issue
2. ⏸️ Consider custom act image with Laravel pre-installed (if workflows are very slow)

## 6. Testing Checklist

After implementing changes:

- [ ] Run `composer workflow:core` - should complete within timeout
- [ ] Run `composer workflow:full` - should complete within timeout
- [ ] Run `composer workflow:heavy` - should complete within timeout
- [ ] Run `composer workflow:browser` - should complete within timeout
- [ ] Verify all workflows complete successfully
- [ ] Compare execution times before/after

## 7. References

- [Act Documentation](https://nektosact.com/)
- [Act Runner Images](https://actions-oss.github.io/act-docs/usage/runners.html)
- [Mauwii Act Images](https://github.com/mauwii/act-docker-images)
- [Podman with Act](https://github.com/nektos/act/issues/2393)
- [GitHub Actions Timeouts](https://docs.github.com/en/actions/using-workflows/workflow-syntax-for-github-actions#jobsjob_idtimeout-minutes)

-----
