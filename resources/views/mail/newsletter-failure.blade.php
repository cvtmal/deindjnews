<x-mail::message>
# Newsletter Send Failed

A newsletter failed to send and requires your attention.

## Failure Details

**Failed Email Address:** {{ $failedEmail }}
**Timestamp:** {{ $timestamp }}

## Error Message

<x-mail::panel>
{{ $errorMessage }}
</x-mail::panel>

Please investigate this issue and take appropriate action. The subscriber has not been marked as sent, and the system will not retry automatically.

## Recommended Actions

- Check the email address validity
- Review mail server logs
- Verify SMTP configuration
- Check if the subscriber should be removed or corrected

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>