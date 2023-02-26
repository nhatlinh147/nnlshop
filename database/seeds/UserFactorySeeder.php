<?php

use Illuminate\Database\Seeder;
use App\Model\Product;
use App\Model\CategoryModel;
use App\Model\BrandModel;
use App\Model\CatePostModel;
use App\Model\GalleryModel;
use App\Model\PostModel;
use App\Model\SlideModel;
use Illuminate\Database\Eloquent\Factory;

class UserFactorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // php artisan db:seed --class=UserFactorySeeder
        CategoryModel::truncate();
        BrandModel::truncate();
        Product::truncate();
        GalleryModel::truncate();
        CatePostModel::truncate();
        PostModel::truncate();
        SlideModel::truncate();

        $new_arr = array(
            'public/upload/gallery/*',
            'public/upload/product/*',
            'public/upload/post/*',
            'public/upload/slide/*',
            'public/upload/cate_pro/*',
        );
        foreach ($new_arr as $value) {
            foreach (glob($value) as $file) { // iterate files
                if (is_file($file))
                    unlink($file); // delete file
            }
        }

        $category = factory(CategoryModel::class, 10)->create();
        $product = factory(Product::class, 200)->create()->each(function ($product) {
            $product->gallery()->createMany(factory(GalleryModel::class, 5)->make()->toArray());
        });

        $cate_post = factory(CatePostModel::class, 10)->create();
        $post = factory(PostModel::class, 200)->create();

        $slide = factory(SlideModel::class, 10)->create();
    }
}