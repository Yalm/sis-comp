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
        $category = Category::create([
            'name' => 'Teclados'
        ]);
        $category = Category::create([
            'name' => 'Memorias ram'
        ]);
        $category = Category::create([
            'name' => 'Monitores'
        ]);
        $category = Category::create([
            'name' => 'Mouse'
        ]);
        $category = Category::create([
            'name' => 'Accesorios para Laptop'
        ]);
        $category = Category::create([
            'name' => 'Laptops'
        ]);
        $category = Category::create([
            'name' => 'Discos duros'
        ]);
        $category = Category::create([
            'name' => 'Procesadores'
        ]);
    }
}
