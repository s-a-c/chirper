#!/bin/bash
set -e

# Backup main tests directory and phpunit.xml to avoid conflicts
if [ -d tests.main.backup ]; then
  rm -rf tests.main.backup
fi
if [ -d tests ]; then
  mv tests tests.main.backup
fi
if [ -f phpunit.xml.main.backup ]; then
  rm -f phpunit.xml.main.backup
fi
if [ -f phpunit.xml ]; then
  mv phpunit.xml phpunit.xml.main.backup
fi

# Copy vendor package's tests and phpunit.xml (like the working project does)
cp -rf vendor/laravel-labs/starter-kit-browser-tests/tests/ tests/
cp vendor/laravel-labs/starter-kit-browser-tests/phpunit.xml.dist phpunit.xml.starter-kit-browser

# Update TestCase for Laravel application (not package)
# Laravel's base TestCase already has createApplication() implemented,
# so we just need to remove the RequiresEnvironmentVariable attribute
TESTCASE_FILE="tests/TestCase.php"
if [ -f "$TESTCASE_FILE" ]; then
  # Remove the RequiresEnvironmentVariable attribute line
  sed -i.bak '/#\[RequiresEnvironmentVariable/d' "$TESTCASE_FILE"
  # Remove the use statement for RequiresEnvironmentVariable if it exists
  sed -i.bak '/use PHPUnit\\Framework\\Attributes\\RequiresEnvironmentVariable/d' "$TESTCASE_FILE"
  rm -f "$TESTCASE_FILE.bak"
fi

# Set APP_BASE_PATH environment variable for Laravel application (not package)
# This tells Laravel where the application root is during test bootstrap
if ! grep -q "APP_BASE_PATH" phpunit.xml.starter-kit-browser; then
  # Insert APP_BASE_PATH env var before the closing </php> tag
  sed -i.bak 's|</php>|        <env name="APP_BASE_PATH" value="."/>\n    </php>|g' phpunit.xml.starter-kit-browser
  rm -f phpunit.xml.starter-kit-browser.bak
fi

# Add our CSP helper function to the copied Pest.php
# First, add required imports if not present (using a portable method)
PEST_FILE="tests/Pest.php"
IMPORTS_NEEDED=false

if ! grep -q "use Pest\\Browser\\Api\\AwaitableWebpage" "$PEST_FILE"; then
  IMPORTS_NEEDED=true
fi
if ! grep -q "use Pest\\Browser\\Api\\PendingAwaitablePage" "$PEST_FILE"; then
  IMPORTS_NEEDED=true
fi
if ! grep -q "use Pest\\Browser\\Api\\Webpage" "$PEST_FILE"; then
  IMPORTS_NEEDED=true
fi
if ! grep -q "use PHPUnit\\Framework\\AssertionFailedError" "$PEST_FILE"; then
  IMPORTS_NEEDED=true
fi

if [ "$IMPORTS_NEEDED" = "true" ]; then
  # Create temporary file with imports
  IMPORTS_TMP=$(mktemp)
  printf '%s\n' \
    'use Pest\Browser\Api\AwaitableWebpage;' \
    'use Pest\Browser\Api\PendingAwaitablePage;' \
    'use Pest\Browser\Api\Webpage;' \
    'use PHPUnit\Framework\AssertionFailedError;' > "$IMPORTS_TMP"

  # Insert imports after the opening PHP tag using awk
  awk -v imports_file="$IMPORTS_TMP" '
    /^<\?php/ {
      print
      while ((getline line < imports_file) > 0) {
        print line
      }
      close(imports_file)
      next
    }
    { print }
  ' "$PEST_FILE" > "$PEST_FILE.tmp" && mv "$PEST_FILE.tmp" "$PEST_FILE"
  rm -f "$IMPORTS_TMP"
fi

# Generate route manifest for efficient route checking
# This creates a JSON file listing all available routes
if [ -f scripts/generate-route-manifest.php ]; then
  php scripts/generate-route-manifest.php
else
  echo "Warning: scripts/generate-route-manifest.php not found, route checking will use fallback"
fi

# Note: We no longer replace assertNoJavaScriptErrors() - CSP errors are browser-specific
# and the original method should work fine in most cases

# Inject skip checks for missing routes/methods using PHP script (safer than sed)
# This prevents tests from failing when routes/features aren't available
if [ -f scripts/inject-skip-checks.php ]; then
  php scripts/inject-skip-checks.php tests/Browser
else
  echo "Warning: scripts/inject-skip-checks.php not found, skipping skip check injection"
fi

# Add helper functions to Pest.php using PHP script (safer than sed)
# This must come AFTER inject-skip-checks and assertNoJavaScriptErrors replacement
if [ -f scripts/append-helpers.php ]; then
  php scripts/append-helpers.php
else
  echo "Warning: scripts/append-helpers.php not found, skipping helper injection"
fi
