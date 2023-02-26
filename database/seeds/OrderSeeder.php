<?php

use App\Model\CouponModel;
use App\Model\CustomerModel;
use App\Model\OrderDetailModel;
use App\Model\OrderModel;
use App\Model\ShippingModel;
use App\Model\PaymentModel;
use Google\Service\Directory\Resource\Customer;
use Illuminate\Database\Seeder;
use Faker\Factory;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CustomerModel::truncate();
        ShippingModel::truncate();
        PaymentModel::truncate();
        OrderModel::truncate();
        OrderDetailModel::truncate();
        CouponModel::truncate();

        $faker = Factory::create();

        $customer = factory(CustomerModel::class, 10)->create();
        $payment = factory(PaymentModel::class, 2)->create();
        $shipping = factory(ShippingModel::class, 20)->create();
        $coupon = factory(CouponModel::class, 20)->create();

        // $order = factory(OrderModel::class, 15)->create();
        $order = factory(OrderModel::class, 30)->create()->each(function ($order) use ($faker) {
            $order->order_detail()->createMany(
                factory(OrderDetailModel::class, $faker->numberBetween($min = 3, $max = 5))
                    ->make()
                    ->toArray()
            );
        });
    }
}