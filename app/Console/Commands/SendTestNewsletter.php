<?php

namespace App\Console\Commands;

use App\Mail\NewsletterMail;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendTestNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send-test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send test newsletter to two hardcoded email addresses for production testing';

    /**
     * The test email addresses to send to.
     *
     * @var array
     */
    protected array $testEmails = [
        'ermanni.damian@gmail.com',
        'hallo@deindj.ch'
    ];

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Starting test newsletter send...');
        $results = [];

        // Query for the test subscribers
        $subscribers = Subscriber::whereIn('email', $this->testEmails)
            ->whereNull('unsubscribed_at')
            ->get();

        if ($subscribers->isEmpty()) {
            $this->error('No test subscribers found in database. Please create subscriber records for:');
            foreach ($this->testEmails as $email) {
                $this->error(" - {$email}");
            }
            return 1;
        }

        // Send to each test subscriber
        foreach ($subscribers as $subscriber) {
            // Skip if already sent
            if ($subscriber->sent_at) {
                $this->warn("Newsletter already sent to {$subscriber->email} at {$subscriber->sent_at}. Skipping.");
                $results[$subscriber->email] = 'skipped';
                continue;
            }

            // Try sending email
            try {
                Mail::to($subscriber->email)->send(new NewsletterMail($subscriber));

                // Mark as sent only if successful
                $subscriber->update(['sent_at' => now()]);

                $this->info("✓ Newsletter sent successfully to {$subscriber->email}");
                Log::info('Test newsletter sent', [
                    'id' => $subscriber->id,
                    'email' => $subscriber->email,
                ]);

                $results[$subscriber->email] = 'success';

            } catch (Throwable $e) {
                // Do not update sent_at on failure
                $this->error("✗ Failed to send newsletter to {$subscriber->email}: {$e->getMessage()}");
                Log::error('Test newsletter send failed', [
                    'id' => $subscriber->id,
                    'email' => $subscriber->email,
                    'error' => $e->getMessage(),
                ]);

                $results[$subscriber->email] = 'failed';
            }
        }

        // Check for missing test emails
        $foundEmails = $subscribers->pluck('email')->toArray();
        $missingEmails = array_diff($this->testEmails, $foundEmails);

        foreach ($missingEmails as $email) {
            $this->warn("Test email {$email} not found in database (or is unsubscribed)");
            $results[$email] = 'missing';
        }

        // Summary
        $this->info("\n--- Summary ---");
        foreach ($results as $email => $status) {
            $statusSymbol = match($status) {
                'success' => '✓',
                'failed' => '✗',
                'skipped' => '⊘',
                'missing' => '?',
                default => '-'
            };
            $this->line("{$statusSymbol} {$email}: {$status}");
        }

        // Return 0 if at least one email was sent successfully
        return in_array('success', $results) ? 0 : 1;
    }
}
