<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Model\StatisticsModel;
use App\Model\VisitorModel;
use App\Model\CatePostModel;
use App\Model\BrandModel;
use App\Model\CategoryModel;
use App\Model\CouponModel;
use App\Model\CustomerModel;
use App\Model\Product;
use App\Model\PostModel;
use App\Model\FeeModel;
use App\Model\GalleryModel;
use App\Model\OrderModel;
use App\Model\OrderDetailModel;
use App\Model\ShippingModel;
use App\Model\SlideModel;
use App\Model\PaymentModel;
use App\Model\SpecialOfferModel;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Faker\Factory;
use Faker\Provider\ar_SA\Payment;


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


function words($min, $max)
{
    $words = '';
    $down_line = "\n";
    $faker = Factory::create();
    for ($i = 0; $i <= $faker->numberBetween($min, $max); $i++) {
        if ($i == 0) {
            $words .= $faker->word;
        } else {
            $words .= ", " . $faker->word;
        }
    }
    return  $words;
}

function a_paragraph($min, $max)
{
    $faker = Factory::create();
    $down_line = "\n";
    return implode($down_line, $faker->paragraphs($nb = $faker->numberBetween($min = 3, $max = 6), $asText = false));
}



$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
    ];
});

$factory->define(CategoryModel::class, function (Faker $faker) {
    $words = '';
    $down_line = "\n";
    for ($i = 0; $i <= $faker->numberBetween($min = 2, $max = 6); $i++) {
        if ($i == 0) {
            $words .= $faker->word;
        } else {
            $words .= ", " . $faker->word;
        }
    }
    return [
        'Category_Name' => $faker->sentence($nbWords = 3, $variableNbWords = true),  //$faker->sentence($nbWords = 3, $variableNbWords = true)
        'Category_Product_Slug' => $faker->slug(),
        'Category_Desc' => a_paragraph(3, 6),
        'Category_Status' => 1,  //$faker->randomElement([0, 1])
        'Meta_Keywords_Category' => words(2, 6),
        'Category_Image' => $faker->image('public/upload/cate_pro', 150, 150, null, false),
        'Category_Parent' => $faker->randomElement([0, $faker->biasedNumberBetween($min = 1, $max = 5)]),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        //factory(App\Model\CategoryModel::class,1)->create()
        //App\Model\CategoryModel::truncate()
    ];
});

$factory->define(BrandModel::class, function (Faker $faker) {
    $words = '';
    $down_line = "\n";
    for ($i = 0; $i <= $faker->numberBetween($min = 2, $max = 6); $i++) {
        if ($i == 0) {
            $words .= $faker->word;
        } else {
            $words .= ", " . $faker->word;
        }
    }
    return [
        'Brand_Name' => $faker->sentence($nbWords = $faker->numberBetween($min = 3, $max = 5), $variableNbWords = true),  //$faker->sentence($nbWords = 3, $variableNbWords = true)
        'Brand_Product_Slug' => $faker->slug(),
        'Brand_Desc' => a_paragraph(3, 6),
        'Brand_Status' => 1,  //$faker->randomElement([0, 1])
        'Meta_Keywords_Brand' => $words,
        'Brand_Parent' => $faker->randomElement([0, $faker->biasedNumberBetween($min = 1, $max = 5)]),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        //factory(App\Model\BrandModel::class,1)->create()
        //App\Model\BrandModel::truncate()
    ];
});
$factory->define(Product::class, function (Faker $faker) {
    $words = '';
    $down_line = "\n";
    for ($i = 0; $i <= $faker->numberBetween($min = 5, $max = 10); $i++) {
        if ($i == 0) {
            $words .= $faker->word;
        } else {
            $words .= ", " . $faker->word;
        }
    }


    $sentences = '<table class="fake-table"><tbody>';
    for ($i = 0; $i <= 5; $i++) {
        $sentences .= '<tr><td>' . $faker->sentence($nbWords = $faker->biasedNumberBetween($min = 2, $max = 4), $variableNbWords = true);
        $sentences .= '</td><td>' . $faker->sentence($nbWords = 6, $variableNbWords = true) . '</td></tr>';
    }
    $sentences .= '</tbody></table>';

    $paragraphs = "";
    for ($i = 0; $i <= $faker->numberBetween($min = 3, $max = 5); $i++) {
        if ($i == 0) {
            $paragraphs .= "<p>" . $faker->paragraph($nbSentences = 4, $variableNbSentences = true) . "</p>";
        } else {
            $paragraphs .= '<h3>' . $faker->sentence($nbWords = 6, $variableNbWords = true) . "</h3>"
                . '<div class="image-content"><img src="https://loremflickr.com/700/300?random=' . $faker->biasedNumberBetween(1, 10) . '" height="300px"/></div>'
                . "<p>" .
                implode("</p><p>", $faker->paragraphs($nb = $faker->numberBetween($min = 3, $max = 6), $asText = false))
                . "</p>";
        }
    }
    return [
        'Product_Name' => $faker->sentence($nbWords = $faker->numberBetween($min = 3, $max = 5), $variableNbWords = true),
        'Product_Slug' => $faker->slug(),
        'Category_ID' =>  $faker->biasedNumberBetween($min = 1, $max = 10),
        // 'Brand_ID' => $faker->biasedNumberBetween($min = 1, $max = 10),
        'Product_Summary' =>  $faker->paragraph($nbSentences = 4, $variableNbSentences = true),
        'Product_Desc' => $sentences,
        'Product_Content' => $paragraphs,
        'Product_Price' => $faker->randomNumber(8),
        'Product_Image' => $faker->image('public/upload/product', 500, 500, null, false),
        'Product_Status' => 1,
        'Product_Quantity' => $faker->biasedNumberBetween($min = 200, $max = 300),
        'Product_Sold' => $faker->biasedNumberBetween($min = 100, $max = 200),
        'Product_Tag' => $words,
        'Meta_Keywords_Product' => $words,
        'Product_View' => $faker->randomNumber(3),
        'Product_Cost' => $faker->randomNumber(8),
        'Product_Document' => "Không",
        'Product_Path' => "No Path Drive",
        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->addDays($faker->numberBetween($min = 3, $max = 10))->format('Y-m-d H:i:s'),
        'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->addDays($faker->numberBetween($min = 3, $max = 10))->format('Y-m-d H:i:s')
        //factory(App\Model\Product::class,1)->create()
        //App\Model\Product::truncate()
    ];
});

$factory->define(PostModel::class, function (Faker $faker) {
    //tạo bài viết
    $sentences = "";
    $addendum = '<ul class="addendum">';
    for ($i = 0; $i <= $faker->numberBetween($min = 4, $max = 7); $i++) {
        $hash = $faker->slug;
        if ($i == 0) {
            $sentences .= "<p>" . $faker->paragraph($nbSentences = 4, $variableNbSentences = true) . "</p>";
        } else {
            $addendum .= '<li><a href="#' . $hash . '">' . $faker->sentence($nbWords = 6, $variableNbWords = true) . "</a></li>";
            $sentences .= '<h3 id="' . $hash . '">' . $faker->sentence($nbWords = 6, $variableNbWords = true) . "</h3>"
                . '<div class="image-content"><img src="' . $faker->imageUrl(500, 300, 'fashion') . '" height="200px"/></div>'
                . "<p>" .
                implode("</p><p>", $faker->paragraphs($nb = $faker->numberBetween($min = 3, $max = 6), $asText = false))
                . "</p>";
        }
    }
    $addendum .= "</ul>";
    return [
        'Post_Title' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'Post_Slug' => $faker->slug(),
        'Post_Views' => $faker->biasedNumberBetween($min = 300, $max = 500),
        'Post_Desc' => $faker->paragraph($nbSentences = 10, $variableNbSentences = true),
        'Post_Content' =>  $addendum . $sentences,
        'Meta_Keywords_Post' => words(3, 6),
        'Meta_Desc_Post' => '<p>' . $faker->paragraph($nbSentences = 10, $variableNbSentences = true) . '</p>',
        'Post_Status' => 1,
        'Post_Image' => $faker->image('public/upload/post', 400, 400, null, false),
        'Cate_Post_ID' =>  function () {
            if ($cate_post = CatePostModel::inRandomOrder()->first()) {
                return $cate_post->Cate_Post_ID;
            }
            return factory(CatePostModel::class)->create()->Cate_Post_ID;
        },
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),

        //factory(App\Model\PostModel::class,1)->create()
        //App\Model\PostModel::truncate()
    ];
});

$factory->define(CatePostModel::class, function (Faker $faker) {
    $words = '';
    $down_line = "\n";
    for ($i = 0; $i <= $faker->numberBetween($min = 5, $max = 10); $i++) {
        if ($i == 0) {
            $words .= $faker->word;
        } else {
            $words .= ", " . $faker->word;
        }
    }
    return [
        'Cate_Post_Name' => $faker->sentence($nbWords = 3, $variableNbWords = true),  //$faker->sentence($nbWords = 3, $variableNbWords = true)
        'Cate_Post_Slug' => $faker->slug(),
        'Cate_Post_Desc' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true), //
        'Meta_Keywords_Cate_Post' => $words, //
        'Cate_Post_Status' => 1,  //$faker->randomElement([0, 1])
        //factory(App\Model\CatePostModel::class,1)->create()
        //App\Model\CatePostModel::truncate()
    ];
});

$factory->define(StatisticsModel::class, function (Faker $faker) {
    return [
        'Statistics_Order_Date' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d'),
        'Statistics_Sales' => $faker->randomNumber(8),
        'Statistics_Expenses' => $faker->randomNumber(8), // password
        'Statistics_CoH' => $faker->randomNumber(8), // password
        'Statistics_Quantity' => $faker->numberBetween($min = 8, $max = 19),
        'Statistics_Total_Order' => $faker->numberBetween($min = 1, $max = 13),
        'created_at' =>  $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s')
    ];
    //factory(App\Model\StatisticsModel::class,1)->create()
    //App\Model\StatisticsModel::truncate()
});

$factory->define(GalleryModel::class, function (Faker $faker) {
    return [
        'Gallery_Name' => $faker->sentence($nbWords = $faker->numberBetween($min = 3, $max = 5), $variableNbWords = true),
        'Product_ID' => $faker->biasedNumberBetween($min = 1, $max = 10),
        'Gallery_Image' => $faker->image('public/upload/gallery', 400, 400, null, false),
    ];
});
$factory->define(SlideModel::class, function (Faker $faker) {

    return [
        'Slide_Title' => $faker->sentence($nbWords = $faker->numberBetween($min = 3, $max = 5), $variableNbWords = true),
        'Slide_Status' => 1,
        'Slide_Image' => $faker->image('public/upload/slide', 1000, 430, null, false),
        'Slide_Desc' => a_paragraph(1, 2),
        'Slide_More' => $faker->sentence($nbWords = 3, $variableNbWords = true),
        'Meta_Keywords_Slide' => words(2, 6)
        //factory(App\Model\SlideModel::class,1)->create()
        //App\Model\SlideModel::truncate()
    ];
});

$factory->define(CustomerModel::class, function (Faker $faker) {

    $faker->addProvider(new \Faker\Provider\ro_RO\PhoneNumber($faker));
    $faker->addProvider(new \Faker\Provider\ms_MY\Address($faker));
    return [
        'Customer_Name' => $faker->userName,
        'Customer_Email' => $faker->freeEmail,
        'Customer_Password' => '202cb962ac59075b964b07152d234b70',
        'Customer_Phone' => $faker->premiumRatePhoneNumber,
        'Customer_Address' => $faker->townState,
        'Customer_Login' => $faker->randomElement($array = array('nnlshop', 'google', 'facebook')),
        'Customer_Classify' => $faker->randomElement($array = array('Normal', 'VIP',)),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        //factory(App\Model\CustomerModel::class,1)->create()
        //App\Model\CustomerModel::truncate()
    ];
});
$factory->define(ShippingModel::class, function (Faker $faker) {
    return [
        'Shipping_Fullname' => $faker->name,
        'Shipping_Email' => $faker->freeEmail,
        'Shipping_Address' => $faker->townState,
        'Shipping_Phone' => $faker->premiumRatePhoneNumber,
        'Shipping_Note' =>  $faker->sentence($nbWords = $faker->numberBetween($min = 5, $max = 10), $variableNbWords = true),
        'Shipping_Payment_Select' => function () {
            if ($payment = PaymentModel::inRandomOrder()->first()) {
                return $payment->Payment_ID;
            }
            return factory(PaymentModel::class)->create()->Payment_ID;
        },
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        //factory(App\Model\ShippingModel::class,1)->create()
        //App\Model\ShippingModel::truncate()
    ];
});

$factory->define(PaymentModel::class, function (Faker $faker) {
    return [
        'Payment_Method' => $faker->sentence($nbWords = $faker->numberBetween($min = 4, $max = 6), $variableNbWords = true),
        'Payment_Status' => 1,
        //factory(App\Model\PaymentModel::class,1)->create()
        //App\Model\PaymentModel::truncate()
    ];
});

$factory->define(OrderModel::class, function (Faker $faker) {
    $faker->addProvider(new \Faker\Provider\Payment($faker));
    return [
        'Customer_ID' => function () {
            if ($customer = CustomerModel::inRandomOrder()->first()) {
                return $customer->Customer_ID;
            }
            return factory(CustomerModel::class)->create()->Customer_ID;
        },
        'Shipping_ID' => function () {
            if ($shipping = ShippingModel::inRandomOrder()->first()) {
                return $shipping->Shipping_ID;
            }
            return factory(ShippingModel::class)->create()->Shipping_ID;
        },
        'Payment_ID' => function () {
            if ($payment = PaymentModel::inRandomOrder()->first()) {
                return $payment->Payment_ID;
            }
            return factory(PaymentModel::class)->create()->Payment_ID;
        },
        'Order_Status' => 1,
        'Order_Date' =>  $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d'),

        'Order_Checkout_Code' => $faker->randomElement([
            strtolower($faker->swiftBicNumber), 'Không'
        ]),
        'Order_Coupon_Code' => CouponModel::inRandomOrder()->first()->Coupon_Code,
        'Order_Fee_Delivery' =>  $faker->randomNumber(6),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        //factory(App\Model\OrderModel::class,1)->create()
        //App\Model\OrderModel::truncate()
    ];
});
$factory->define(OrderDetailModel::class, function (Faker $faker) {
    return [
        'Order_Code' => function () {
            if ($order = OrderModel::inRandomOrder()->first()) {
                return $order->Order_Checkout_Code;
            }
            return factory(OrderModel::class)->create()->Order_Checkout_Code;
        },
        'Product_ID' => function () {
            if ($product = Product::inRandomOrder()->first()) {
                return $product->Product_ID;
            }
            return factory(Product::class)->create()->Product_ID;
        },
        'Product_Name' => function (array $product) {
            return Product::find($product['Product_ID'])->Product_Name;
        },
        'Product_Price' => function (array $product) {
            return Product::find($product['Product_ID'])->Product_Price;
        },
        'Product_Sales_Quantity' => $faker->numberBetween($min = 2, $max = 6),
        'created_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        //factory(App\Model\OrderDetailModel::class,1)->create()
        //App\Model\OrderDetailModel::truncate()
    ];
});

$factory->define(CouponModel::class, function (Faker $faker) {

    return [
        'Coupon_Name' => $faker->name,
        'Coupon_Number' => $faker->randomElement($array = array($faker->randomNumber(6), $faker->numberBetween(10, 25))),
        'Coupon_Code' => $faker->iban($countryCode = NULL, $prefix = 'NNLSHOP', $length = 6),
        'Coupon_Amount' => $faker->numberBetween($min = 300, $max = 600),
        'Coupon_Condition' =>   $faker->randomElement([1, 2]),
        'Coupon_Date_Start' => Carbon::now('Asia/Ho_Chi_Minh')->toDateString(),
        'Coupon_Date_End' =>  Carbon::now('Asia/Ho_Chi_Minh')->addDays(29)->toDateString(),
        'Coupon_Status' => 1,
        'created_at' => Carbon::now('Asia/Ho_Chi_Minh')->subday()->toDateString(),
        'updated_at' => Carbon::now('Asia/Ho_Chi_Minh')->toDateString()
        //factory(App\Model\CouponModel::class,1)->create()
        //App\Model\CouponModel::truncate()
    ];
});

$factory->define(PropProductModel::class, function (Faker $faker) {
    return [
        'Prop_Product_ID' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d'),
        'Statistics_Sales' => $faker->randomNumber(8),
        'Statistics_Expenses' => $faker->randomNumber(8), // password
        'Statistics_CoH' => $faker->randomNumber(8), // password
        'Statistics_Quantity' => $faker->numberBetween($min = 8, $max = 19),
        'Statistics_Total_Order' => $faker->numberBetween($min = 1, $max = 13),
        'created_at' =>  $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s')
    ];
    //factory(App\Model\StatisticsModel::class,1)->create()
    //App\Model\StatisticsModel::truncate()
});

function start($date)
{
    return date('Y-m-d', strtotime($date . ' + ' . rand(10, 30) . ' days'));
}
$factory->define(SpecialOfferModel::class, function (Faker $faker) {
    $start = start($faker->dateTimeThisMonth($max = 'now', $timezone = 'UTC')->format('Y-m-d H:i:s'));
    return [
        'Special_Title' => $faker->sentence($nbWords = 5, $variableNbWords = true),
        'Special_Slug' => $faker->slug(),
        'Special_Image' =>  $faker->image('public/upload/special', 1000, 430, null, false),
        'Special_Product_Json' =>  '{"name": "fzaninotto/faker","type": "library",
            "description": "Faker is a PHP library that generates fake data for you.",
            "keywords": [
                "faker",
                "fixtures",
                "data"
            ]}',
        'Special_Start' => $start,
        'Special_End' => date('Y-m-d', strtotime($start . ' + ' . rand(5, 20) . ' days')),
        'Special_Status' => 1
    ];
    //factory(App\Model\SpecialOfferModel::class,1)->create()
    //App\Model\SpecialOfferModel::truncate()
});