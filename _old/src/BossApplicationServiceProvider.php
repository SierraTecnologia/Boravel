<?php

namespace Boss;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class BossApplicationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->authorization();
    }

    /**
     * Configure the Boss authorization services.
     *
     * @return void
     */
    protected function authorization()
    {
        $this->gate();

        Boss::auth(function ($request) {
            return app()->environment('local') ||
                   Gate::check('viewBoss', [$request->user()]);
        });
    }

    /**
     * Register the Boss gate.
     *
     * This gate determines who can access Boss in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewBoss', function ($user) {
            return in_array($user->email, [
                //
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
