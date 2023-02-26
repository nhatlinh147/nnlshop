<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapCustomerRoutes();

        $this->mapAdminRoutes();
        //
    }

    /**
     * Define the "user" routes for the application.
     *
     * @return void
     */
    protected function mapCustomerRoutes()
    {
        foreach (glob(base_path('routes/customer/*.php')) as $file) {
            if (class_basename($file) == 'customer.php') {
                $middleware = ['web', 'guest:customer']; // Có Auth (đã đăng nhập) rồi khi quay về route đăng nhập thì chuyển hướng trang chủ
            } else if (class_basename($file) == 'guest.php') {
                $middleware = ['web', 'check-login']; // không cần đăng nhập vẫn hiển thị
            } else {
                $middleware = ['web', 'check-login:customer']; // Là customer thì mới hiển thị
            }
            Route::prefix('front-end')
                ->middleware($middleware)
                ->namespace($this->namespace)
                ->group($file);
        }
    }

    /**
     * Define the "user" routes for the application.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {
        foreach (glob(base_path('routes/admin/*.php')) as $file) {
            if (class_basename($file) == 'admin.php') {
                $middleware = ['web', 'guest:admin'];
            } else {
                $middleware = ['web', 'check-login:admin'];
            }
            Route::prefix('back-end')
                ->middleware($middleware)
                ->namespace($this->namespace)
                ->group($file);
        }
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }
}