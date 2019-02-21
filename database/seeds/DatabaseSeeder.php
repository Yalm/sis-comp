<?php

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
        $this->call([
            CategoryTableSeeder::class,
            ProductTableSeeder::class,
            DocumentTableSeeder::class,
            StateTableSeeder::class,
            UserTableSeeder::class,
            PaymentTypeTableSeeder::class,
            CustomerTableSeeder::class,
            OrderTableSeeder::class,
            VoucherTypeTableSeeder::class
        ]);
    }
}
