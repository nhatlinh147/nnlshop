<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\GalleryRepository;
use App\Repository\GalleryInterface;
use App\Repository\ProductRepository;
use App\Repository\ProductInterface;
use App\Repository\SpecialOfferInterface;
use App\Repository\SpecialOfferRepository;

use App\Model\Product;
use App\Model\SlideModel;
use App\Model\CategoryModel;
use App\Model\PostModel;
use App\Model\SpecialOfferModel;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(GalleryInterface::class, GalleryRepository::class);
        $this->app->singleton(ProductInterface::class, ProductRepository::class);
        $this->app->singleton(SpecialOfferInterface::class, SpecialOfferRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('backend.component.form-ajax', 'component_html');
        Blade::component('backend.component.script', 'component_script');
        Blade::component('component.check-all', 'checkAll');

        // Truyền biến vào view
        View::composer(['frontend.index.content-index', 'frontend.shop.shop-list-product', 'frontend.detail.detail', 'frontend.cart.cart', 'frontend.favorite.favorite'], function ($view) {
            $category_have_child = CategoryModel::groupBy('Category_Parent')
                ->having('Category_Parent', '!=', 0)
                ->get();
            $array_have_child = array_column($category_have_child->toArray(), 'Category_Parent');
            $category_parent = CategoryModel::where('Category_Parent', 0)->get();

            return  $view->with(compact(
                'category_have_child',
                'array_have_child',
                'category_parent',
            ));
        });
    }
}