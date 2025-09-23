<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Support\Facades\Log;

class UnsubscribeController extends Controller
{
    public function unsubscribe($email)
    {
        // Decode the email
        $email = urldecode($email);

        // Find the subscriber
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            // Mark as unsubscribed
            $subscriber->update(['unsubscribed_at' => now()]);

            Log::info('Subscriber unsubscribed', [
                'id' => $subscriber->id,
                'email' => $subscriber->email,
            ]);

            return redirect()->route('unsubscribe.success');
        }

        // Even if subscriber not found, show success to prevent email enumeration
        return redirect()->route('unsubscribe.success');
    }

    public function success()
    {
        return view('unsubscribe-success');
    }
}
