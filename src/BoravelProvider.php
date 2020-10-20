<?php

namespace Boravel;

use Boravel\Boravel;
use Boravel\Services\BoravelService;
use BotMan\BotMan\BotManServiceProvider;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Facebook\FacebookDriver;
// use Illuminate\Support\ServiceProvider;
use BotMan\Drivers\Slack\SlackDriver;
use BotMan\Drivers\Telegram\TelegramDriver;
use BotMan\Studio\Providers\DriverServiceProvider as ServiceProvider;
use BotMan\Studio\Providers\StudioServiceProvider;

use BotMan\Tinker\TinkerServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

use Illuminate\Support\Str;

use Muleta\Traits\Providers\ConsoleTools;

class BoravelProvider extends ServiceProvider
{
    use ConsoleTools;


    const pathVendor = 'sierratecnologia/boravel';
    
    /**
     * The drivers that should be loaded to
     * use with BotMan
     *
     * @var array
     */
    protected $drivers = [
        SlackDriver::class
    ];

    public static $aliasProviders = [
        'TranslationCache' => \Translation\Facades\TranslationCache::class,
        'Translation' => \Translation\Facades\Translation::class,

        // /**
        //  * Decoy
        //  */
        // 'Boravel' => \Facilitador\Facades\Facilitador::class,
        // 'BoravelURL' => \Facilitador\Facades\SupportURL::class,

        // // Image resizing
        // 'Croppa' => \Bkwld\Croppa\Facade::class,
        // // BrowserDetect
        // 'Agent' => \Jenssegers\Agent\Facades\Agent::class,
    ];

    // public static $providers = [
    public static $providers = [
        \Audit\AuditProvider::class,
        \Tracking\TrackingProvider::class,
        

        /**
         * Base
         */
        \Translation\TranslationServiceProvider::class,
        
        
        /*
         * Dependencias
         */
        \Locaravel\LocaravelProvider::class,
        /**
         * Layoults
         */
        \JeroenNoten\LaravelAdminLte\AdminLteServiceProvider::class,


        /**
         * VEio pelo Decoy
         **/
        // Image resizing
        \Bkwld\Croppa\ServiceProvider::class,
        // PHP utils
        \Bkwld\Library\ServiceProvider::class,
        // HAML
        \Bkwld\LaravelHaml\ServiceProvider::class,
        // BrowserDetect
        \Jenssegers\Agent\AgentServiceProvider::class,
        // File uploading
        \Bkwld\Upchuck\ServiceProvider::class,
        // Creation of slugs
        \Cviebrock\EloquentSluggable\ServiceProvider::class,
        // Support for cloning models
        \Bkwld\Cloner\ServiceProvider::class,

        /**
         * Services Providers
         */
        \Yajra\DataTables\DataTablesServiceProvider::class,
    ];

    /**
     * Rotas do Menu
     */
    public static $menuItens = [

    ];

    /**
     * Alias the services in the boot.
     */
    public function boot()
    // public function boot(Router $router, Dispatcher $events)
    {
        parent::boot();

        /**
         * Boravel Routes
         */
        Route::group([
            'namespace' => '\Boravel\Http\Controllers',
        ], function (/**$router**/) {
            require __DIR__.'/../routes/web.php';
        });


        foreach ($this->drivers as $driver) {
            DriverManager::loadDriver($driver);
        }

        $this->registerViewComposers();
        
        // Register configs, migrations, etc
        $this->publishConfigs();
        $this->publishAssets();
        $this->publishMigrations();

        $this->bootEvents();
    }

    /**
     * Register the services.
     */
    public function register()
    {
        $this->loadConfigs();
        
        // Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // View namespace
        $viewsPath = __DIR__.'/../resources/views';
        $this->loadViewsFrom($viewsPath, 'boravel');
        $this->publishes(
            [
                $viewsPath => base_path('resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'boravel'),
            ],
            'views'
        );

        $loader = AliasLoader::getInstance();
        $loader->alias('Boravel', BoravelFacade::class);

        $this->app->singleton(
            'boravel',
            function () {
                return new Boravel();
            }
        );

        /**
         * Singleton Boravel
         */
        $this->app->singleton(
            BoravelService::class,
            function ($app) {
                Log::debug('Singleton Boravel');
                // try {
                //     throw new \Exception();
                // } catch (\Exception $e) {
                //     dd($e);
                // }
                return new BoravelService(\Illuminate\Support\Facades\Config::get('generators.loader.models'));
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            /*
             * Package Service Providers...
             */
            TinkerServiceProvider::class,
    
            /*
             * BotMan Service Providers...
             */
            BotManServiceProvider::class,
            StudioServiceProvider::class,
        ];
    }


    /**
     * Register view composers.
     */
    protected function registerViewComposers()
    {
        // // Register alerts
        // View::composer(
        //     'boravel::*', function ($view) {
        //         $view->with('alerts', BoravelFacade::alerts());
        //     }
        // );
    }


    protected function loadConfigs()
    {
        
        // Merge own configs into user configs
        $this->mergeConfigFrom($this->getPublishesPath('config/botman/config.php'), 'botman.config');
        $this->mergeConfigFrom($this->getPublishesPath('config/botman/discord.php'), 'botman.discord');
        $this->mergeConfigFrom($this->getPublishesPath('config/botman/facebook.php'), 'botman.facebook');
        $this->mergeConfigFrom($this->getPublishesPath('config/botman/slack.php'), 'botman.slack');
        $this->mergeConfigFrom($this->getPublishesPath('config/botman/twitter.php'), 'botman.twitter');
        $this->mergeConfigFrom($this->getPublishesPath('config/botman/telegram.php'), 'botman.telegram');
        $this->mergeConfigFrom($this->getPublishesPath('config/botman/web.php'), 'botman.web');
    }

    protected function publishMigrations()
    {
    }
       
    protected function publishAssets()
    {
        
        // // Publish boravel css and js to public directory
        // $this->publishes(
        //     [
        //     $this->getDistPath('boravel') => public_path('assets/boravel')
        //     ], ['public',  'boravel', 'boravel-public']
        // );
    }

    protected function publishConfigs()
    {
        
        // Publish config files
        $this->publishes(
            [
            // Paths
            $this->getPublishesPath('config/botman') => config_path('botman'),
            // $this->getPublishesPath('config/chat') => config_path('chat'),
            // $this->getPublishesPath('config/managed') => config_path('managed'),
            // $this->getPublishesPath('config/settings') => config_path('settings'),
            // Files
            $this->getPublishesPath('config/boravel.php') => config_path('boravel.php')
            ],
            ['config',  'boravel', 'boravel-config']
        );
    }
    protected function bootEvents()
    {
        $this->app['events']->listen(
            BuildingMenu::class,
            function (BuildingMenu $event) {
                (new \Pedreiro\Template\Mounters\SystemMount())->loadMenuForAdminlte($event);
            }
        );

        // ModelCallback nao existe @todo
        // // Wire up model event callbacks even if request is not for admin.  Do this
        // // after the usingAdmin call so that the callbacks run after models are
        // // mutated by Decoy logic.  This is important, in particular, so the
        // // Validation observer can alter validation rules before the onValidation
        // // callback runs.
        // $this->app['events']->listen(
        //     'eloquent.*',
        //     'Boravel\Observers\ModelCallbacks'
        // );
        // $this->app['events']->listen(
        //     'facilitador::model.*',
        //     'Boravel\Observers\ModelCallbacks'
        // );
    }

    protected function getPublishesPath($path)
    {
        return __DIR__.'/../publishes/'.$path;
    }
}
