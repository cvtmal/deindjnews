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
                'email' => 'anna.mueller@example.com',
                'name' => 'Anna Müller',
            ],
            [
                'email' => 'thomas.weber@example.com',
                'name' => 'Thomas Weber',
            ],
            [
                'email' => 'sarah.schmidt@example.com',
                'name' => 'Sarah Schmidt',
            ],
        ];

        foreach ($subscribers as $subscriber) {
            Subscriber::create($subscriber);
        }
    }
}