<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateProductsPrices extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->get()->each(function ($product) {
            DB::table('products')->where('id', $product->id)->update(['price' => $product->price * 100]);
        });
    }
}
