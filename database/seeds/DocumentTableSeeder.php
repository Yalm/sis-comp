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
        $document = Document::create([
            'name' => 'DNI',
            'length' => '8'
        ]);
        $document = Document::create([
            'name' => 'PASAPORTE',
            'length' => '12'
        ]);

        $document = Document::create([
            'name' => '	CARNET EXT',
            'length' => '12'
        ]);

    }
}
