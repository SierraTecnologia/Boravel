<?php

namespace Boss;

use Illuminate\Queue\QueueManager;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Boss\Connectors\RedisConnector;

class BossServiceProvider extends ServiceProvider
{
    use EventMap, ServiceBindings;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__.'/../config/boss.php') => config_path('boss.php'),
        ], 'config');

        $this->publishes([
            realpath(__DIR__.'/../database/migrations') => database_path('migrations'),
        ], 'migrations');
        $this->registerEvents();
        $this->registerRoutes();
        $this->registerResources();
        $this->defineAssetPublishing();
    }

    /**
     * Register the Boss job events.
     *
     * @return void
     */
    protected function registerEvents()
    {
        $events = $this->app->make(Dispatcher::class);

        foreach ($this->events as $event => $listeners) {
            foreach ($listeners as $listener) {
                $events->listen($event, $listener);
            }
        }
    }

    /**
     * Register the Boss routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group([
            'domain' => config('boss.domain', null),
            'prefix' => config('boss.path'),
            'namespace' => 'Boss\Http\Controllers',
            'middleware' => config('boss.middleware', 'web'),
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Register the Boss resources.
     *
     * @return void
     */
    protected function registerResources()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'boss');
    }

    /**
     * Define the asset publishing configuration.
     *
     * @return void
     */
    public function defineAssetPublishing()
    {
        $this->publishes([
            BOSS_PATH.'/public' => public_path('vendor/boss'),
        ], 'boss-assets');
    }

    /**
     * Register the custom queue connectors for Boss.
     *
     * @return void
     */
    protected function registerQueueConnectors()
    {
        $this->app->resolving(QueueManager::class, function ($manager) {
            $manager->addConnector('redis', function () {
                return new RedisConnector($this->app['redis']);
            });
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (! defined('BOSS_PATH')) {
            define('BOSS_PATH', realpath(__DIR__.'/../'));
        }

        $this->configure();
        $this->offerPublishing();
        $this->registerServices();
        $this->registerCommands();
        $this->registerQueueConnectors();
    }

    /**
     * Setup the configuration for Boss.
     *
     * @return void
     */
    protected function configure()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/boss.php', 'boss'
        );

        Boss::use(config('boss.use'));
    }

    /**
     * Setup the resource publishing groups for Boss.
     *
     * @return void
     */
    protected function offerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../stubs/BossServiceProvider.stub' => app_path('Providers/BossServiceProvider.php'),
            ], 'boss-provider');

            $this->publishes([
                __DIR__.'/../config/boss.php' => config_path('boss.php'),
            ], 'boss-config');
        }
    }

    /**
     * Register Boss's services in the container.
     *
     * @return void
     */
    protected function registerServices()
    {
        foreach ($this->serviceBindings as $key => $value) {
            is_numeric($key)
                    ? $this->app->singleton($value)
                    : $this->app->singleton($key, $value);
        }
    }

    /**
     * Register the Boss Artisan commands.
     *
     * @return void
     */
    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\InstallCommand::class,
                Console\AssetsCommand::class,
                Console\BossCommand::class,
                Console\ListCommand::class,
                Console\PurgeCommand::class,
                Console\PauseCommand::class,
                Console\ContinueCommand::class,
                Console\StatusCommand::class,
                Console\SupervisorCommand::class,
                Console\SupervisorsCommand::class,
                Console\TerminateCommand::class,
                Console\TimeoutCommand::class,
                Console\WorkCommand::class,
            ]);
        }

        $this->commands([Console\SnapshotCommand::class]);
    }
}
