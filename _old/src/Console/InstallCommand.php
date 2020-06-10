<?php

namespace Boss\Console;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;

class InstallCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boss:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install all of the Boss resources';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Publishing Boss Service Provider...');
        $this->callSilent('vendor:publish', ['--tag' => 'boss-provider']);

        $this->comment('Publishing Boss Assets...');
        $this->callSilent('vendor:publish', ['--tag' => 'boss-assets']);

        $this->comment('Publishing Boss Configuration...');
        $this->callSilent('vendor:publish', ['--tag' => 'boss-config']);

        $this->registerBossServiceProvider();

        $this->info('Boss scaffolding installed successfully.');
    }

    /**
     * Register the Boss service provider in the application configuration file.
     *
     * @return void
     */
    protected function registerBossServiceProvider()
    {
        $namespace = Str::replaceLast('\\', '', $this->getAppNamespace());

        $appConfig = file_get_contents(config_path('app.php'));

        if (Str::contains($appConfig, $namespace.'\\Providers\\BossServiceProvider::class')) {
            return;
        }

        file_put_contents(config_path('app.php'), str_replace(
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL,
            "{$namespace}\\Providers\EventServiceProvider::class,".PHP_EOL."        {$namespace}\Providers\BossServiceProvider::class,".PHP_EOL,
            $appConfig
        ));

        file_put_contents(app_path('Providers/BossServiceProvider.php'), str_replace(
            "namespace App\Providers;",
            "namespace {$namespace}\Providers;",
            file_get_contents(app_path('Providers/BossServiceProvider.php'))
        ));
    }
}
