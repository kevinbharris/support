<?php

namespace KevinBHarris\Support\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Webkul\Admin\Helpers\Menu;

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
        $this->registerAdminMenu();
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

    /**
     * Register admin menu.
     */
    protected function registerAdminMenu(): void
    {
        Event::listen('admin.menu.build', function () {
            Menu::add([
                'key'    => 'support',
                'label'  => 'Support',
                'route'  => 'admin.support.tickets.index',
                'icon'   => 'icon-support',
                'sort'   => 10,
                'children' => [
                    [
                        'key'   => 'support.canned_responses',
                        'label' => 'Canned Responses',
                        'route' => 'admin.support.canned-responses.index',
                        'icon'  => 'icon-canned-responses',
                        'sort'  => 1,
                    ],
                    [
                        'key'   => 'support.categories',
                        'label' => 'Categories',
                        'route' => 'admin.support.categories.index',
                        'icon'  => 'icon-categories',
                        'sort'  => 2,
                    ],
                    [
                        'key'   => 'support.priorities',
                        'label' => 'Priorities',
                        'route' => 'admin.support.priorities.index',
                        'icon'  => 'icon-priorities',
                        'sort'  => 3,
                    ],
                    [
                        'key'   => 'support.rules',
                        'label' => 'Rules',
                        'route' => 'admin.support.rules.index',
                        'icon'  => 'icon-rules',
                        'sort'  => 4,
                    ],
                    [
                        'key'   => 'support.statuses',
                        'label' => 'Statuses',
                        'route' => 'admin.support.statuses.index',
                        'icon'  => 'icon-statuses',
                        'sort'  => 5,
                    ],
                    [
                        'key'   => 'support.tickets',
                        'label' => 'Tickets',
                        'route' => 'admin.support.tickets.index',
                        'icon'  => 'icon-ticket',
                        'sort'  => 6,
                    ],
                ]
            ]);
        });
    }
}
