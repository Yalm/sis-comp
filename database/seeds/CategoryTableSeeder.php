<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Teclados'
        ]);
        Category::create([
            'name' => 'Memorias ram'
        ]);
        Category::create([
            'name' => 'Monitores'
        ]);
        Category::create([
            'name' => 'Mouse'
        ]);
        Category::create([
            'name' => 'Accesorios para Laptop'
        ]);
        Category::create([
            'name' => 'Laptops'
        ]);
        Category::create([
            'name' => 'Discos duros'
        ]);
        Category::create([
            'name' => 'Procesadores'
        ]);
    }
}
