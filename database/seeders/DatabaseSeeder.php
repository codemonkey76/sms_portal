<?php

namespace Database\Seeders;

use App\Models\Customer;
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
        $customer = Customer::create([
            'name' => 'Alpha IT Centre',
            'senderId' => 'AlphaIT'
        ]);

        $customer->users()->create([
            'name'     => 'Shane Poppleton',
            'email'    => 'shane@alphasg.com.au',
            'password' => bcrypt('secret'),
            'email_verified_at' => now()
        ]);
    }
}
