<?php

namespace KevinBHarris\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;

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
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                dirname(__DIR__) . '/Config/support.php' => config_path('support.php'),
            ], 'support-config');
            
            $this->publishes([
                dirname(__DIR__) . '/Resources/views' => resource_path('views/vendor/support'),
            ], 'support-views');
        }
        
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
