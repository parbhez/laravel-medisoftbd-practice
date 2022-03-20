<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace            = 'App\Http\Controllers';
    protected $namespaceHR          = 'App\Http\Controllers\HR';
    protected $namespaceDiagnostic  = 'App\Http\Controllers\Diagnostic';
    protected $namespaceAccounts    = 'App\Http\Controllers\Accounts';
    protected $namespacePharmacy    = 'App\Http\Controllers\Pharmacy';
    protected $namespaceIndoor      = 'App\Http\Controllers\Indoor';
    protected $namespaceOutdoor     = 'App\Http\Controllers\Outdoor';
    protected $namespaceSettings    = 'App\Http\Controllers\Settings';
    protected $namespaceBillings    = 'App\Http\Controllers\Billings';
    protected $namespaceReports     = 'App\Http\Controllers\Reports';
    protected $namespaceTests       = 'App\Http\Controllers\Tests';

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

        //
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
            ->namespace($this->namespace)
            ->group(base_path('routes/routes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceHR)
            ->group(base_path('routes/hrRoutes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceDiagnostic)
            ->group(base_path('routes/diagnosticRoutes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceAccounts)
            ->group(base_path('routes/accountsRoutes.php'));
            
        Route::middleware('web')
            ->namespace($this->namespacePharmacy)
            ->group(base_path('routes/pharmacyRoutes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceIndoor)
            ->group(base_path('routes/indoorRoutes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceOutdoor)
            ->group(base_path('routes/outdoorRoutes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceSettings)
            ->group(base_path('routes/settingsRoutes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceBillings)
            ->group(base_path('routes/billingsRoutes.php'));
        
        Route::middleware('web')
            ->namespace($this->namespaceReports)
            ->group(base_path('routes/reportsRoutes.php'));

        Route::middleware('web')
            ->namespace($this->namespaceTests)
            ->group(base_path('routes/testsRoutes.php'));
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
