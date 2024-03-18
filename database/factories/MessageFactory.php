<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'body' => $this->faker->paragraph(),
            'numSegments' => 1,
            'from' => 'SenderID',
            'to' => $this->faker->e164PhoneNumber(),
            'status' => 'sent',
            'sid' => 'FAKE_SID',
            'dateUpdated' => now(),
            'dateCreated' => now(),
        ];
    }
}
