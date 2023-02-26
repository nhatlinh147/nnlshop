<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\StatisticsModel;
use App\Model\PropProductModel;
use App\Model\Product;
use Illuminate\Database\Eloquent\Factory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

function get_string_rand($condition, $amount)
{
    $sizes = ['XS', 'S', 'M', 'L', '2XL', '3XL', '4XL', '5XL'];
    $amount_size = 0;
    for ($amount_size = 28; $amount_size < 47; $amount_size++) {
        array_push($sizes, $amount_size);
    }
    $colors = ['blue', 'cyan', 'green', 'yellow', 'red', 'magenta', 'purple', 'orange', 'black', 'white', 'pink', 'brown'];
    $product_id = Product::all()->pluck('Product_ID');

    if ($condition == 'size') {
        $array = $sizes;
    } else if ($condition == 'color') {
        $array = $colors;
    } else if ($condition == 'product_id') {
        $array = json_decode($product_id, true);
    }
    $new_arr = array_rand(array_flip($array), $amount);
    return trim(implode(",", $new_arr), ',');
}

$factory->define(PropProductModel::class, function (Faker $faker) {
    return [
        'Prop_Product_ID' => get_string_rand('product_id', $faker->numberBetween(3, 5)),
        'Prop_Size' => get_string_rand('size', $faker->numberBetween(8, 16)),
        'Prop_Color' => get_string_rand('color', $faker->numberBetween(5, 10))
    ];
    //factory(App\Model\PropProductModel::class,1)->create()
    //App\Model\PropProductModel::truncate()
});