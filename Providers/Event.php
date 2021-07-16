<?php

namespace Modules\MyBlog\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as Provider;

class Event extends Provider
{
    /**
     * The subscriber classes to register.
     *
     * @var array
     */
    protected $subscribe = [
        'Module\MyBlog\Listeners\AddCategoriesToReport',
        'Module\MyBlog\Listeners\AddAuthorsToReport',
        'Module\MyBlog\Listeners\AddPostsToReport',
    ];

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }

    /**
     * Get the listener directories that should be used to discover events.
     *
     * @return array
     */
    protected function discoverEventsWithin()
    {
        return [
            __DIR__ . '/../Listeners',
        ];
    }
}
