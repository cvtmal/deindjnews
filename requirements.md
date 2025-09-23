Build the smallest possible implementation to send a newsletter to one subscriber per CLI run. Only add what’s necessary. Keep it minimal, production-sane, and readable.

## Absolute requirements
- **Start via CLI**: one Artisan command `newsletter:send-one` that sends exactly **one** email per run.
- **No queues** (no jobs, no workers) — send synchronously.
- **No locks, no caching** (do NOT use Cache::lock, Redis, or similar).
- **MariaDB** for persistence (standard Laravel Eloquent).
- **Subscribers table** with columns: `id`, `name`, `email` (unique), `sent_at` (nullable), `created_at/updated_at`.
- **Pick the *latest* unsent subscriber**: the record with `sent_at IS NULL`, ordered by newest (`id DESC`), limit 1.
- **Mailable**: put subscriber `name` and `email` into the mailable view.
- **Only mark sent if no failures**: mark `sent_at = now()` only if the send succeeds.
- **Logging**: log successes and failures with context.
- **Environment**: assume SMTP configured via `.env`. Do not depend on deprecated `Mail::failures()`; use try/catch for success/failure.

## Deliverables (filenames + code)
1) **Migration**: `database/migrations/xxxx_xx_xx_create_subscribers_table.php`
- Schema as above; `email` unique; index `sent_at`.
2) **Model**: `app/Models/Subscriber.php`
- `$fillable = ['name','email','sent_at']`; cast `sent_at` to `datetime`.
3) **Mailable**: `app/Mail/NewsletterMail.php` using a Markdown view `resources/views/emails/newsletter.blade.php`
- Constructor takes `Subscriber $subscriber`.
- Subject: "Our Newsletter".
- View gets `name` and optional content stub.
4) **Artisan Command**: `app/Console/Commands/SendOneNewsletter.php`
- Signature: `newsletter:send-one`
- Behavior:
- Query: `Subscriber::whereNull('sent_at')->orderByDesc('id')->first();`
- If none found: write to console and `Log::info('No unsent subscribers')`; exit 0.
- Try sending synchronously: `Mail::to($sub->email)->send(new NewsletterMail($sub));`
- On success: `$sub->update(['sent_at' => now()]);` and `Log::info('Newsletter sent', ['id'=>$sub->id,'email'=>$sub->email]);`
- On failure (catch `Throwable $e`): do **not** update `sent_at`; `Log::error('Newsletter send failed', ['id'=>$sub->id,'email'=>$sub->email,'error'=>$e->getMessage()]);` return non-zero exit code.
- Also print concise console messages.
- No locks, no cache, no queue calls.
5) **Scheduler hint (comment in README)**:
- Provide the single cron line to run the scheduler every minute (user will add it):
  `* * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1`
- Kernel entry (optional but include): in `app/Console/Kernel.php`, schedule `newsletter:send-one` every minute. Do **not** use `withoutOverlapping()` or cache-based locking.
6) **.env examples** (as comments in README or code block):
DB_CONNECTION=mysql # MariaDB-compatible
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=app
   DB_USERNAME=app
   DB_PASSWORD=secret

MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=apikey-or-user
MAIL_PASSWORD=secret
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=newsletter@example.com

MAIL_FROM_NAME="${APP_NAME}"

7) **Tiny importer (optional)**: a tinker snippet in README to seed `subscribers` from a newline list.

## Code guidelines
- Laravel 9+ / 10+ compatible (Symfony Mailer). Do NOT rely on `Mail::failures()`.
- Keep imports explicit; wrap send in `try/catch (Throwable $e)`.
- Use strict typing where reasonable and helpful.
- No extra packages.
- Minimal comments where it clarifies intent.

## Expected CLI flow
- `php artisan migrate`
- (Import subscribers)
- `php artisan newsletter:send-one` → sends at most one email, logs result.
- Running once per minute via scheduler will trickle through the list.

## Acceptance criteria
- Running the command repeatedly sends one new email each time until all `sent_at` are set.
- If SMTP throws, the command exits non-zero, logs an error, and does not mark `sent_at`.
- No queues, no locks, no cache usage anywhere in the diff.

Now generate the exact files with full code, ready to paste into a fresh Laravel app, plus a short README section that shows the CLI usage and scheduler line.
