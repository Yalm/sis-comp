<?php

use Illuminate\Database\Seeder;
use App\PaymentType;

class PaymentTypeTableSeeder extends Seeder
{
    public function run()
    {
        PaymentType::create([
            'name' => 'Tarjeta de crédito',
            'text_user' => 'Tarjeta de crédito o débito | Visa, Mastercard y más!',
            'md_icon' => 'credit_card'
        ]);

        /*PaymentType::create([
            'name' => 'Déposito bancario',
            'text_user' => 'Banca por Internet o Dépositos Bancarios'
        ]);*/

        PaymentType::create([
            'name' => 'Pago contra entrega',
            'text_user' => 'Paga al recibir tu producto en efectivo',
            'md_icon' => 'how_to_vote'
        ]);
    }
}
