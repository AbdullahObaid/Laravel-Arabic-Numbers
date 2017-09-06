<?php
namespace abdullahobaid\arabicnumbers;
use  abdullahobaid\arabicnumbers\Http\Middleware\ArabicNumbersMiddleware;

use Illuminate\Support\ServiceProvider;

class ArabicNumbersProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        app('router')->group($this->middlewareGroupExists('web')
            ? ['middleware' => 'web']
            : [], function () {
               '/../../routes/web.php';
            });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
       
        app('Illuminate\Contracts\Http\Kernel')->pushMiddleware('\abdullahobaid\arabicnumbers\Http\Middleware\ArabicNumbersMiddleware');
    }
	
	   private function middlewareGroupExists(string $group) : bool
    {
        $routes = collect(app('router')->getRoutes()->getRoutes());
        return $routes->reduce(function ($carry, $route) use ($group) {
            $carry = ($carry ?? false) ?: false;
            $actions = (array) $route->getAction();
            if (array_key_exists('middleware', $actions)
                && in_array($group, (array) $actions['middleware'])
            ) {
                return true;
            }
            return $carry;
        }) ?? false;
    }
}
