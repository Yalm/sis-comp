<?php

use Illuminate\Database\Seeder;

class OrderTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('orders')->insert(['id' => 19, 'customer_id' => '1', 'state_id' => 2]);
        DB::table('orders')->where('id', 19)->delete();

        /*factory(App\Order::class,50)->create()->each(function(App\Order $order){

            for ($i = 1; $i <= rand(1,20); $i++) {
                $order->products()->attach(rand(1,100),['quantity' => rand(1,20)]);
            }
            factory(App\Payment::class ,1)->create([
                'order_id' =>  $order->id,
                'created_at' => $order->created_at,
                'updated_at' => $order->updated_at,
            ]);
        });*/

    }
}
