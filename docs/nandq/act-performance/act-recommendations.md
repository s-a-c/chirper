# Act Performance Optimization - Recommendations

-----

<details><summary>Click for Table of Contents</summary>

- [Act Performance Optimization - Recommendations](#act-performance-optimization---recommendations)
  - [1. Executive Summary](#1-executive-summary)
  - [2. Detailed Recommendations](#2-detailed-recommendations)
    - [2.1. Add Timeout Configuration (IMMEDIATE - Do This First)](#21-add-timeout-configuration-immediate---do-this-first)
    - [2.2. Switch to Slimmer Image (RECOMMENDED)](#22-switch-to-slimmer-image-recommended)
    - [2.3. Create `.actrc` Configuration (OPTIONAL - Nice to Have)](#23-create-actrc-configuration-optional---nice-to-have)
    - [2.4. Podman Support (FUTURE - Only If Needed)](#24-podman-support-future---only-if-needed)
  - [3. Implementation Checklist](#3-implementation-checklist)
    - [3.1. Phase 1: Immediate Fixes](#31-phase-1-immediate-fixes)
    - [3.2. Phase 2: Image Optimization](#32-phase-2-image-optimization)
    - [3.3. Phase 3: Monitoring](#33-phase-3-monitoring)
  - [4. Testing Plan](#4-testing-plan)
  - [5. Rollback Plan](#5-rollback-plan)
  - [6. Additional Notes](#6-additional-notes)
    - [6.1. Act Version](#61-act-version)
    - [6.2. Image Alternatives Tested](#62-image-alternatives-tested)
    - [6.3. Performance Expectations](#63-performance-expectations)
  - [7. References](#7-references)

</details>

-----

## 1. Executive Summary

After investigating timeout issues with `act` (GitHub Actions local testing), here are the recommended solutions in priority order:

1. **IMMEDIATE**: Add `timeout-minutes` to workflow jobs
2. **RECOMMENDED**: Switch to slimmer `mauwii/ubuntu-act:latest` image
3. **OPTIONAL**: Create `.actrc` configuration file
4. **FUTURE**: Consider Podman if Docker remains a bottleneck

-----

## 2. Detailed Recommendations

### 2.1. Add Timeout Configuration (IMMEDIATE - Do This First)

**Problem**: Act may have different timeout behavior than GitHub Actions.

**Solution**: Add `timeout-minutes` to all jobs in workflow files.

**Files to Update**:

- `.github/workflows/pre-commit.yml`
- `.github/workflows/tests.yml`
- `.github/workflows/nightly-heavy.yml`
- `.github/workflows/browser-tests.yml`
- `.github/workflows/lint.yml`
- `.github/workflows/phpmd.yml`

**Example**:

```yaml
jobs:
  core-quality:
    runs-on: ubuntu-latest
    timeout-minutes: 60  # Adjust based on typical execution time
    steps:
      # ... existing steps
```

**Recommended Timeouts**:

- `pre-commit.yml`: 30 minutes (quick checks)
- `tests.yml` (core-quality): 45 minutes (full test suite)
- `tests.yml` (environment-validation): 20 minutes (environment checks)
- `nightly-heavy.yml`: 120 minutes (heavy tests, mutation testing)
- `browser-tests.yml`: 60 minutes (browser testing)
- `lint.yml`: 20 minutes (linting)
- `phpmd.yml`: 15 minutes (static analysis)

### 2.2. Switch to Slimmer Image (RECOMMENDED)

**Current**: `catthehacker/ubuntu:act-latest` (large, full-featured)

**Recommended**: `mauwii/ubuntu-act:latest` (lighter, act-optimized)

**Benefits**:

- Faster container startup
- Lower memory usage
- Faster image pulls
- Still maintains GitHub Actions runner compatibility

**Implementation**: Update all `composer.json` workflow scripts:

**Before**:

```json
"-P ubuntu-latest=catthehacker/ubuntu:act-latest"
```

**After**:

```json
"-P ubuntu-latest=mauwii/ubuntu-act:latest"
```

**Files to Update**: `composer.json` (all `workflow:*` scripts)

### 2.3. Create `.actrc` Configuration (OPTIONAL - Nice to Have)

**Purpose**: Centralize act configuration, remove repetitive flags from scripts.

**Create**: `.actrc` in project root:

```actrc
-P ubuntu-latest=mauwii/ubuntu-act:latest
-P ubuntu-22.04=mauwii/ubuntu-act:22.04
-P ubuntu-20.04=mauwii/ubuntu-act:20.04
--container-architecture linux/amd64
```

**Benefits**:

- Cleaner composer scripts
- Consistent configuration across team
- Easy to update image versions

**Note**: Can also use `~/.actrc` for user-wide defaults.

### 2.4. Podman Support (FUTURE - Only If Needed)

**Status**: Not officially supported, but can work with configuration.

**When to Consider**:

- Docker performance is still poor after image switch
- Resource constraints (memory, CPU)
- Preference for rootless containers

**Requirements**:

- Podman installed (✅ Already available)
- Socket configuration
- Environment variable setup

**Implementation**: Would require helper script to detect and configure Podman.

**Recommendation**: **Defer** until after trying solutions 1-3.

-----

## 3. Implementation Checklist

### 3.1. Phase 1: Immediate Fixes

- [ ] Add `timeout-minutes` to all workflow jobs
- [ ] Test workflows to establish baseline performance
- [ ] Document typical execution times

### 3.2. Phase 2: Image Optimization

- [ ] Update all `composer.json` scripts to use `mauwii/ubuntu-act:latest`
- [ ] Test all workflows with new image
- [ ] Compare performance before/after
- [ ] Create `.actrc` file (optional)

### 3.3. Phase 3: Monitoring

- [ ] Monitor workflow execution times
- [ ] Document any issues with new image
- [ ] Adjust timeouts if needed

-----

## 4. Testing Plan

After implementing changes, test each workflow:

```bash
# Quick tests
composer workflow:lint
composer workflow:phpmd
composer workflow:core

# Full tests
composer workflow:full
composer workflow:browser
composer workflow:heavy
```

**Success Criteria**:

- All workflows complete within timeout
- No new errors or compatibility issues
- Performance improvement (faster execution or lower resource usage)

-----

## 5. Rollback Plan

If `mauwii/ubuntu-act:latest` causes issues:

1. Revert to `catthehacker/ubuntu:act-latest` in `composer.json`
2. Keep timeout configurations (they're still beneficial)
3. Investigate specific compatibility issues

-----

## 6. Additional Notes

### 6.1. Act Version

- Current: `0.2.83`
- Check for updates: `brew upgrade act` (if installed via Homebrew)

### 6.2. Image Alternatives Tested

- ✅ `mauwii/ubuntu-act:latest` - Recommended
- ❌ `node:*-slim` - Not suitable (missing runner setup)
- ❌ Laravel-specific images - Not suitable (not runner images)
- ⏸️ Podman - Deferred

### 6.3. Performance Expectations

| Metric | Before | After (Expected) |
|--------|--------|------------------|
| Image Pull Time | ~2-5 min | ~1-2 min |
| Container Startup | ~30-60s | ~15-30s |
| Memory Usage | High | Medium |
| Overall Workflow Time | Baseline | 10-20% faster |

-----

## 7. References

- Investigation Document: `tmp/act-timeout-investigation.md`
- Act Documentation: [https://nektosact.com/]
- Mauwii Images: [https://github.com/mauwii/act-docker-images]
- GitHub Actions Timeouts: [https://docs.github.com/en/actions/using-workflows/workflow-syntax-for-github-actions#jobsjob_idtimeout-minutes]

-----
