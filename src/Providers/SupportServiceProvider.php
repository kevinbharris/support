<?php

namespace KevinBHarris\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Helpers\Menu;
use KevinBHarris\Support\Providers\AuthServiceProvider;

class SupportServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/support.php', 'support'
        );
        
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/menu.php',
            'menu.admin'
        );
        
        // Merge support permissions into Bagisto's ACL config
        // This follows the Webkul/Admin package integration style
        $this->mergeConfigFrom(
            dirname(__DIR__) . '/Config/acl.php', 'acl'
        );
        
        // Register the AuthServiceProvider
        $this->app->register(AuthServiceProvider::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->loadMigrationsFrom(dirname(__DIR__) . '/Database/Migrations');
        
        $this->loadRoutesFrom(dirname(__DIR__) . '/Routes/admin.php');
        $this->loadRoutesFrom(dirname(__DIR__) . '/Routes/portal.php');
        
        $this->loadViewsFrom(dirname(__DIR__) . '/Resources/views', 'support');
        
        $this->loadTranslationsFrom(dirname(__DIR__) . '/Resources/lang', 'support');
        
        // Register middleware
        $this->app['router']->aliasMiddleware('support_permission', \KevinBHarris\Support\Http\Middleware\SupportPermission::class);
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__) . '/Config/support.php' => config_path('support.php'),
            ], 'support-config');
            
            $this->publishes([
                dirname(__DIR__) . '/Config/menu.php' => config_path('menu.php'),
            ], 'support-config');
            
            // Note: ACL config is merged at runtime, not published
            // This prevents overwriting Bagisto's core ACL configuration
            
            $this->publishes([
                dirname(__DIR__) . '/Resources/views' => resource_path('views/vendor/support'),
            ], 'support-views');
            
            $this->publishes([
                dirname(__DIR__) . '/Resources/assets' => public_path('vendor/support'),
            ], 'support-assets');
            
            $this->publishes([
                dirname(__DIR__) . '/Resources/lang' => resource_path('lang/vendor/support'),
            ], 'support-lang');
        }	
		
		// Inject the CSS into the Bagisto admin layout
		view()->composer('*', function ($view) {
			$view->getFactory()->startPush('styles');
			echo '<link rel="stylesheet" href="' . asset('vendor/support/css/app.css') . '">';
			$view->getFactory()->stopPush();
		});
        
        $this->registerEventListeners();
    }

    /**
     * Register event listeners.
     */
    protected function registerEventListeners(): void
    {
        Event::listen(
            \KevinBHarris\Support\Events\TicketCreated::class,
            \KevinBHarris\Support\Listeners\SendTicketCreatedNotification::class
        );
        
        Event::listen(
            \KevinBHarris\Support\Events\TicketUpdated::class,
            \KevinBHarris\Support\Listeners\SendTicketUpdatedNotification::class
        );
        
        Event::listen(
            \KevinBHarris\Support\Events\NoteAdded::class,
            \KevinBHarris\Support\Listeners\SendNoteAddedNotification::class
        );
    }
}
