# Monthly Dependency Review

**Workflow:** FR-009
**Issue Title:** [Dependency Review] YYYY-MM report
**Labels:** dependency, governance
**Assignees:** platform-engineering

Compliant with [.ai/AI-GUIDELINES.md](../../../.ai/AI-GUIDELINES.md) v3b99cda02934ad7cdc87310613fb7faac37a49f19d9620106e96e73cacb6bb8e

## Summary

- Report timestamp: `PLACEHOLDER_REVIEW_TIMESTAMP`
- Runtime (seconds): `PLACEHOLDER_REVIEW_RUNTIME`
- Status: `PLACEHOLDER_REVIEW_STATUS`

## Severity Counts

- Critical: `PLACEHOLDER_REVIEW_CRITICAL`
- High: `PLACEHOLDER_REVIEW_HIGH`
- Medium: `PLACEHOLDER_REVIEW_MEDIUM`
- Low: `PLACEHOLDER_REVIEW_LOW`

## Required Attachments

- [ ] `storage/app/base-platform/dependency-reports/PLACEHOLDER_REPORT_FILE`
- [ ] `storage/app/base-platform/dependency-performance.log`
- [ ] Updated `storage/app/base-platform/dependencies.json` (if changes applied)
- [ ] Supporting notes in [Support Metrics & Evidence Plan](../../../docs/base-platform/support-metrics.md)

## Follow-up Tasks

- [ ] Create remediation task(s) for outstanding advisories (critical/high)
- [ ] Schedule dependency upgrade PRs where required
- [ ] Update `docs/base-platform/dependency-policy.md` with decisions made

## Additional Notes

- Overdue catalogue entries: `PLACEHOLDER_REVIEW_OVERDUE`
- Issue created via: `scripts/automation/dependency-review.sh`

---

**Note for automation scripts**: This template uses `PLACEHOLDER_*` tokens that should be replaced with actual values before creating the issue via GitHub API. The workflow script should read this template, perform string replacements, and then create the issue with the populated content. The title, labels, and assignees should be extracted from the header and used when creating the issue via the GitHub API.
