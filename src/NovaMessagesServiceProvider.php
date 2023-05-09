<?php

declare(strict_types=1);

namespace BehzadSp\NovaMessages;

use Illuminate\Support\ServiceProvider;
use BehzadSp\NovaMessages\Nova\Message;
use Laravel\Nova\Nova;

class NovaMessagesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->config();
        $this->migrations();
        $this->nova();
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/nova-messages.php', 'nova-messages');
    }

    /**
     * Bootstrap configurations files.
     */
    protected function config(): void
    {
        $this->publishes(
            [
                __DIR__.'/../config/nova-messages.php' => config_path('nova-messages.php'),
            ]
        );
    }

    /**
     * Bootstrap database migrations.
     */
    protected function migrations(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    }

    /**
     * Bootstrap Nova resources and components.
     */
    protected function nova(): void
    {
        Nova::resources([Message::class]);

        Nova::serving(
            function (): void {
                Nova::script('messagble', __DIR__.'/../dist/js/tool.js');
                Nova::style('messagble', __DIR__.'/../dist/css/tool.css');
            }
        );
    }
}
