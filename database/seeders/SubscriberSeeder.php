<?php

namespace Database\Seeders;

use App\Models\Subscriber;
use Illuminate\Database\Seeder;

class SubscriberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subscribers = [
            [
                'email' => 'ermanni.damian@gmail.com',
                'name' => 'Damian Ermanni',
            ],
            [
                'email' => 'hallo@deindj.ch',
                'name' => 'Junus Celebi',
            ],
            [
                'email' => 'junus.celebi@gmail.com',
                'name' => 'Junus Celebi Gmail',
            ],
        ];

        foreach ($subscribers as $subscriber) {
            Subscriber::create($subscriber);
        }
    }
}
