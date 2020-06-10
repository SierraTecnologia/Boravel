<?php

namespace Boravel\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class CmsEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'eloquent.saved: App\Models\Blog\Blog' => [
            'App\Models\Blog@afterSaved',
        ],
        'eloquent.saved: App\Models\Negocios\Page' => [
            'App\Models\Negocios\Page@afterSaved',
        ],
        'eloquent.saved: App\Models\Calendar\Event' => [
            'App\Models\Calendar\Event@afterSaved',
        ],
        'eloquent.saved: App\Models\Negocios\Faq' => [
            'App\Models\Calendar\Event@afterSaved',
        ],
        'eloquent.saved: Boravel\Models\System\Translation' => [
            'App\Models\Calendar\Event@afterSaved',
        ],
        'eloquent.saved: App\Models\Negocios\Widget' => [
            'App\Models\Calendar\Event@afterSaved',
        ],

        'eloquent.created: App\Models\Blog\Blog' => [
            'App\Models\Blog@afterCreate',
        ],
        'eloquent.created: App\Models\Negocios\Page' => [
            'App\Models\Negocios\Page@afterCreate',
        ],
        'eloquent.created: App\Models\Calendar\Event' => [
            'App\Models\Calendar\Event@afterCreate',
        ],
        'eloquent.created: App\Models\Negocios\Faq' => [
            'App\Models\Calendar\Event@afterCreate',
        ],
        'eloquent.created: App\Models\Negocios\Widget' => [
            'App\Models\Calendar\Event@afterCreate',
        ],

        'eloquent.deleting: App\Models\Blog\Blog' => [
            'App\Models\Blog@beingDeleted',
        ],
        'eloquent.deleting: App\Models\Negocios\Page' => [
            'App\Models\Negocios\Page@beingDeleted',
        ],
        'eloquent.deleting: App\Models\Calendar\Event' => [
            'App\Models\Calendar\Event@beingDeleted',
        ],
        'eloquent.deleting: App\Models\Negocios\Faq' => [
            'App\Models\Calendar\Event@beingDeleted',
        ],
        'eloquent.deleting: Boravel\Models\System\Translation' => [
            'App\Models\Calendar\Event@beingDeleted',
        ],
        'eloquent.deleting: App\Models\Negocios\Widget' => [
            'App\Models\Calendar\Event@beingDeleted',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot()
    {
        parent::boot();
    }
}
