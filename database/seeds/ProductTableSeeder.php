<?php

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\CategoryModel;
use App\Models\BrandModel;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::truncate();

        Product::create([
            'Meta_Keywords_Product' => 'Điện thoại,SmartPhone, Điện thoại thông minh,',
            'Product_Name' => 'Điện thoại Samsung Galaxy Z Flip3 5G 256GB',
            'Product_Slug' => 'Điện thoại Samsung Galaxy Z Flip3 5G 256GB',
            'Category_ID' => 8,
            'Brand_ID' => 7,
            'Product_Desc' =>


        ]);
    }
}