<?php

use App\Http\Controllers\UnsubscribeController;
use App\Mail\NewsletterMail;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mail/preview', function () {
    // Create a dummy subscriber for preview
    $subscriber = new Subscriber([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    return new NewsletterMail($subscriber);
});

// Unsubscribe routes
Route::get('/unsubscribe/{email}', [UnsubscribeController::class, 'unsubscribe'])
    ->name('unsubscribe');
Route::get('/unsubscribe-success', [UnsubscribeController::class, 'success'])
    ->name('unsubscribe.success');
