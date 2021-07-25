<?php

namespace Modules\MyBlog\Providers;

use App\Models\Auth\User;
use App\Models\Setting\Category;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider as Provider;

class Main extends Provider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->loadRoutes();
    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViews();
        $this->loadViewComponents();
        $this->loadTranslations();
        $this->loadMigrations();
        $this->loadConfig();
        $this->loadDynamicRelationships();
        $this->loadCommands();
        $this->scheduleCommands();
    }

    /**
     * Load views.
     *
     * @return void
     */
    public function loadViews()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'my-blog');
    }

    /**
     * Load view components.
     *
     * @return void
     */
    public function loadViewComponents()
    {
        Blade::componentNamespace('Modules\MyBlog\View\Components', 'my-blog');
    }

    /**
     * Load translations.
     *
     * @return void
     */
    public function loadTranslations()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'my-blog');
    }

    /**
     * Load migrations.
     *
     * @return void
     */
    public function loadMigrations()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Load config.
     *
     * @return void
     */
    public function loadConfig()
    {
        $merge_to_core_configs = ['search-string', 'type'];

        foreach ($merge_to_core_configs as $config) {
            Config::set($config, array_merge_recursive(
                Config::get($config),
                require __DIR__ . '/../Config/' . $config . '.php'
            ));
        }

        $this->mergeConfigFrom(__DIR__ . '/../Config/my-blog.php', 'my-blog');
    }

    /**
     * Load dynamic relationships.
     *
     * @return void
     */
    public function loadDynamicRelationships()
    {
        User::resolveRelationUsing('my_blog_posts', function ($user) {
            return $user->hasMany('Modules\MyBlog\Models\Post', 'created_by', 'id');
        });

        User::resolveRelationUsing('my_blog_comments', function ($user) {
            return $user->hasMany('Modules\MyBlog\Models\Comment', 'created_by', 'id');
        });

        Category::resolveRelationUsing('my_blog_posts', function ($category) {
            return $category->hasMany('Modules\MyBlog\Models\Post', 'category_id', 'id');
        });
    }

    /**
     * Load commands.
     *
     * @return void
     */
    public function loadCommands()
    {
        $this->commands(\Modules\MyBlog\Console\Inspire::class);
    }

    /**
     * Schedule commands.
     *
     * @return void
     */
    public function scheduleCommands()
    {
        $this->app->booted(function () {
            $schedule_time = config('app.schedule_time', '09:00');

            app(Schedule::class)->command('my-blog:inspire')->dailyAt($schedule_time);
        });
    }

    /**
     * Load routes.
     *
     * @return void
     */
    public function loadRoutes()
    {
        if (app()->routesAreCached()) {
            return;
        }

        $routes = [
            'admin.php',
            'portal.php',
            'api.php',
        ];

        foreach ($routes as $route) {
            $this->loadRoutesFrom(__DIR__ . '/../Routes/' . $route);
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
