<?php

namespace App\Console\Commands;

use App\Mail\NewsletterFailureNotification;
use App\Mail\NewsletterMail;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class SendOneNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send-one';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send newsletter to one unsent subscriber';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Query for the latest unsent subscriber who has not unsubscribed
        $subscriber = Subscriber::whereNull('sent_at')
            ->whereNull('unsubscribed_at')
            ->orderByDesc('id')
            ->first();

        // If no unsent subscribers found
        if (! $subscriber) {
            $this->info('No unsent subscribers found.');
            Log::info('No unsent subscribers');

            return 0;
        }

        // Try sending email synchronously
        try {
            Mail::to($subscriber->email)->send(new NewsletterMail($subscriber));

            // Mark as sent only if successful
            $subscriber->update(['sent_at' => now()]);

            $this->info("Newsletter sent successfully to {$subscriber->email}");
            Log::info('Newsletter sent', [
                'id' => $subscriber->id,
                'email' => $subscriber->email,
            ]);

            return 0;
        } catch (Throwable $e) {
            // Do not update sent_at on failure
            $this->error("Failed to send newsletter to {$subscriber->email}: {$e->getMessage()}");
            Log::error('Newsletter send failed', [
                'id' => $subscriber->id,
                'email' => $subscriber->email,
                'error' => $e->getMessage(),
            ]);

            // Send notification emails to administrators
            $notification = new NewsletterFailureNotification(
                $subscriber->email,
                $e->getMessage()
            );

            $adminEmails = [
                'hallo@deindj.ch',
                'damian.ermanni@myitjob.ch',
            ];

            foreach ($adminEmails as $adminEmail) {
                try {
                    Mail::to($adminEmail)->send($notification);
                    $this->info("Failure notification sent to {$adminEmail}");
                } catch (Throwable $notificationError) {
                    $this->error("Failed to send notification to {$adminEmail}: {$notificationError->getMessage()}");
                    Log::error('Failed to send failure notification', [
                        'admin_email' => $adminEmail,
                        'error' => $notificationError->getMessage(),
                    ]);
                }
            }

            return 1;
        }
    }
}
