<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Message;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Customer::factory()->count(30)->create();

        $user = User::create([
            'name'     => 'Shane Poppleton',
            'email'    => 'shane@alphasg.com.au',
            'password' => bcrypt('secret'),
            'email_verified_at' => now(),
            'isAdmin' => true,
            'isActive' => true
        ]);

        $user->attachCustomer(Customer::first()->id);

        Message::factory()->count(10)->create(['customer_id' => Customer::first()->id]);

    }
}
