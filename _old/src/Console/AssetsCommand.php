<?php

namespace Boss\Console;

use Illuminate\Console\Command;

class AssetsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boss:assets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-publish the Boss assets';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->call('vendor:publish', [
            '--tag' => 'boss-assets',
            '--force' => true,
        ]);
    }
}
