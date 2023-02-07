<?php

namespace Ajifatur\FaturHelper;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;

class FaturHelperServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        // Config
        if(Schema::hasTable('settings')) {
            config([
                'app.name' => setting('name'),
                'app.timezone' => setting('timezone'),
                'app.locale' => 'id'
            ]);
        }

        // Add views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'faturhelper');

        // Add migrations
        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        // Add middlewares to web
        $router->pushMiddlewareToGroup('web', \Ajifatur\FaturHelper\Http\Middleware\Logs::class);
        $router->pushMiddlewareToGroup('api', \Ajifatur\FaturHelper\Http\Middleware\Logs::class);
        
        // Add middlewares
        $router->aliasMiddleware('faturhelper.admin', \Ajifatur\FaturHelper\Http\Middleware\Admin::class);
        $router->aliasMiddleware('faturhelper.nonadmin', \Ajifatur\FaturHelper\Http\Middleware\NonAdmin::class);
        $router->aliasMiddleware('faturhelper.guest', \Ajifatur\FaturHelper\Http\Middleware\Guest::class);
        $router->aliasMiddleware('faturhelper.api.auth', \Ajifatur\FaturHelper\Http\Middleware\APIAuth::class);

        // Use Bootstrap on paginator
        Paginator::useBootstrap();
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // Register service providers
        app()->register(\Rap2hpoutre\LaravelLogViewer\LaravelLogViewerServiceProvider::class);
        app()->register(\Yajra\DataTables\DataTablesServiceProvider::class);

        // Load helpers
        $this->loadHelpers();

        // Register commands
        $this->commands(Commands\InstallCommand::class);

        if($this->app->runningInConsole()) {
            // Register publishable resources
            $this->registerPublishableResources();
        }
    }

    /**
     * Load helpers.
     * 
     * @return void
     */
    protected function loadHelpers()
    {
        if(File::exists(base_path('vendor/ajifatur/faturhelper/src/Helpers'))) {
            foreach(glob(base_path('vendor/ajifatur/faturhelper/src').'/Helpers/*.php') as $filename) {
                require_once $filename;
            }
        }
    }
    
    /**
     * Register the publishable files.
     * 
	 * @return void
     */
    private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__).'/publishable';

        $publishable = [
            'config' => [
                "{$publishablePath}/config/faturhelper.php" => config_path('faturhelper.php'),
            ],
            'assets' => [
                "{$publishablePath}/assets" => public_path('assets'),
            ],
            'templates' => [
                "{$publishablePath}/templates" => public_path('templates'),
            ],
            'lang' => [
                "{$publishablePath}/lang" => resource_path('lang'),
            ],
        ];

        foreach($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }
}