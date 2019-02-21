<?php

use Illuminate\Database\Seeder;
use App\VoucherType;

class VoucherTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VoucherType::create([
            'name' => 'FACTURA'
        ]);

        VoucherType::create([
            'name' => 'BOLETA'
        ]);

        VoucherType::create([
            'name' => 'NOTA DE CRÉDITO'
        ]);

        VoucherType::create([
            'name' => 'NOTA DE DÉBITO'
        ]);
    }
}
