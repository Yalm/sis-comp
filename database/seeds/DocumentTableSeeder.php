<?php

use Illuminate\Database\Seeder;
use App\Document;

class DocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Document::create([
            'name' => 'DNI',
            'length' => '8'
        ]);
        Document::create([
            'name' => 'PASAPORTE',
            'length' => '12'
        ]);

        Document::create([
            'name' => '	CARNET EXT',
            'length' => '12'
        ]);

    }
}
