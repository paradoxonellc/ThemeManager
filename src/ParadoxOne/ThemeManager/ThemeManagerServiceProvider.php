<?php namespace ParadoxOne\ThemeManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\FileViewFinder;

class ThemeManagerServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['theme'] = $this->app->share(function($app)
		{
			return new Manager($this->app);
		});

		$this->app->booting(function()
		{
			$loader = \Illuminate\Foundation\AliasLoader::getInstance();
			$loader->alias('Theme', 'ParadoxOne\ThemeManager\Facades\Theme');
		});

		$this->app['view.finder'] = $this->app->share(function($app)
		{
			$paths = $app['config']['view.paths'];

			$themeName = $app['config']['theme.name'];

			$paths = array_merge($paths, array($paths[0].'/'.$themeName));

			return new FileViewFinder($app['files'], $paths);
		});

	}

	/**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package('ParadoxOne/ThemeManager');
    }

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('theme');
	}

}