<?php

use Illuminate\Database\Seeder;
use App\PaymentType;

class PaymentTypeTableSeeder extends Seeder
{
    public function run()
    {
        PaymentType::create([
            'name' => 'Tarjeta de crédito'
        ]);

        PaymentType::create([
            'name' => 'Déposito bancario'
        ]);
    }
}
