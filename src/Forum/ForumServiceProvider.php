<?php namespace Flarum\Forum;

use Illuminate\Support\ServiceProvider;
use Flarum\Support\AssetManager;

class ForumServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $root = __DIR__.'/../..';

        $this->loadViewsFrom($root.'/views', 'flarum.forum');

        $assetManager = $this->app['flarum.forum.assetManager'];

        $assetManager->addFile([
            $root.'/ember/forum/dist/assets/vendor.js',
            $root.'/ember/forum/dist/assets/flarum-forum.js',
            $root.'/less/forum/app.less'
        ]);

        $this->publishes([
            $root.'/public/fonts' => public_path('flarum/fonts')
        ]);

        include __DIR__.'/routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['flarum.forum.assetManager'] = $this->app->share(function ($app) {
            return new AssetManager($app['files'], $app['path.public'].'/flarum', 'forum');
        });
    }
}
