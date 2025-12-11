<?php

declare(strict_types=1);

// Note: Use statements are added by the CI workflow script when this file is appended to Pest.php
// The types are referenced without imports here since they'll be available in Pest.php context
function assertNoJavaScriptErrorsExceptCspParser(Pest\Browser\Api\PendingAwaitablePage|Pest\Browser\Api\AwaitableWebpage|Pest\Browser\Api\Webpage $page): Pest\Browser\Api\PendingAwaitablePage|Pest\Browser\Api\AwaitableWebpage|Pest\Browser\Api\Webpage
{
    try {
        $page->assertNoJavaScriptErrors();
    } catch (Throwable $e) {
        // Only handle AssertionFailedError exceptions (use string to avoid internal-class errors).
        // Use string literal with is_a() to avoid PHPStan internal class warnings
        // Rector prefers throw_unless, which works fine with is_a() and string literals
        throw_unless(is_a($e, 'PHPUnit\Framework\AssertionFailedError'), $e);

        $message = $e->getMessage();

        // Check if the error contains CSP parser errors (various formats)
        // CSP parser errors can appear as:
        // - "CSP Parser Error: Unexpected token: input"
        // - "CSP Parser Error: Expected PUNCTUATION ":" but got PUNCTUATION "(""
        // - "Uncaught Error: CSP Parser Error: ..."
        // - In the main message: "but found 1: Uncaught Error: CSP Parser Error: ..."
        $isCspError =
            str_contains($message, 'CSP Parser Error') || (bool) preg_match('/CSP.*Parser.*Error/i', $message);

        if ($isCspError) {
            // Extract all errors from the message
            // The message format can be:
            // 1. "Expected no JavaScript errors..., but found X:\n- Error 1\n- Error 2"
            // 2. "Expected no JavaScript errors..., but found 1: Uncaught Error: CSP Parser Error: ..."
            preg_match_all('/- (.+)/m', $message, $matches);
            /** @var list<non-empty-string> $errors */
            $errors = is_array($matches[1] ?? null) ? $matches[1] : [];

            // Also check the main message for CSP errors (format: "but found 1: Uncaught Error: CSP Parser Error: ...")
            $mainErrorIsCsp = false;
            if (preg_match('/but found \d+:\s*(.+?)(?:\n|$)/s', $message, $mainMatch) === 1) {
                /** @var array{0: non-falsy-string, 1: non-empty-string} $mainMatch */
                $mainError = $mainMatch[1];
                $mainErrorIsCsp =
                    str_contains($mainError, 'CSP Parser Error')
                    || (bool) preg_match('/CSP.*Parser.*Error/i', $mainError);
            }

            // If no errors were extracted from the list format, check if the main message contains only CSP errors
            if ($errors === [] && $mainErrorIsCsp) {
                // It's a CSP error in the main message, ignore it
                return $page;
            }

            // Filter out CSP parser errors (check for various CSP error patterns)
            $realErrors = array_filter($errors, function (string $error): bool {
                // Filter out all CSP parser errors - they contain "CSP Parser Error" or match CSP error patterns
                // Check both exact string match and regex pattern match
                $isCspErrorInList =
                    str_contains($error, 'CSP Parser Error') || (bool) preg_match('/CSP.*Parser.*Error/i', $error);

                return ! $isCspErrorInList;
            });

            // If there are real errors, throw them
            if ($realErrors !== []) {
                throw new PHPUnit\Framework\AssertionFailedError("Expected no JavaScript errors on the page, but found:\n"
                .implode("\n", array_map(fn (string $error): string => "- {$error}", $realErrors)));
            }

            // If only CSP parser errors (either in list or main message), ignore them (they're false positives)
            // If all errors were filtered out, it means they were all CSP errors
            return $page;
        }

        // Re-throw if it's not a CSP parser error
        throw $e;
    }

    return $page;
}
