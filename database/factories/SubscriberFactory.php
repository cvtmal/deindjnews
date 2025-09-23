<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subscriber>
 */
class SubscriberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'sent_at' => null,
            'last_clicked_link' => null,
            'last_clicked_at' => null,
            'unsubscribed_at' => null,
        ];
    }

    /**
     * Indicate that the newsletter has been sent.
     */
    public function sent(): static
    {
        return $this->state(fn (array $attributes) => [
            'sent_at' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Indicate that the subscriber clicked a link.
     */
    public function clicked(): static
    {
        return $this->state(fn (array $attributes) => [
            'last_clicked_link' => $this->faker->url(),
            'last_clicked_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ]);
    }

    /**
     * Indicate that the subscriber has unsubscribed.
     */
    public function unsubscribed(): static
    {
        return $this->state(fn (array $attributes) => [
            'unsubscribed_at' => $this->faker->dateTimeBetween('-7 days', 'now'),
        ]);
    }
}
