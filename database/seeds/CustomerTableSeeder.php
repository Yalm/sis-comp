<?php

use Illuminate\Database\Seeder;
use App\Customer;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::create([
            'name' => 'Renzo',
            'surnames' => 'Manuel',
            'email' => 'renzomanuelc@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm',
            'actived' => true,
            'remember_token' => str_random(10),
            'document_id' => 1,
            'document_number' => '74998182',
            'phone' => '924951173'
        ]);

        //factory(App\Customer::class,100)->create();
    }
}
