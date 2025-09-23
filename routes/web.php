<?php

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
