<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\ContactList;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Template;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Customer::factory()->count(30)->create();

        $user = User::create([
            'name' => 'Shane Poppleton',
            'email' => 'shane@alphasg.com.au',
            'password' => bcrypt('secret'),
            'email_verified_at' => now(),
            'isAdmin' => true,
            'isActive' => true,
        ]);

        $user->attachCustomer(Customer::first()->id);

        Customer::each(function ($c) {
            Message::factory()->count(10)->create(['customer_id' => $c->id]);
            Template::factory()->count(5)->create(['customer_id' => $c->id]);
            ContactList::factory()->count(5)->create(['customer_id' => $c->id]);
            //ContactList::whereCustomerId($c->id)->each(fn($l) => Contact::factory()->count(10)->create(['customer_id' => $c->id, 'contact_list_id' => $l->id]));
        });
    }
}
