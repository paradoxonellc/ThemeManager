<?php namespace ParadoxOne\ThemeManager;

use Illuminate\Foundation\Application;
use \InvalidArgumentException;
use Illuminate\View\FileViewFinder;

class Manager {

	/**
	 * The application instance.
	 *
	 * @var \Illuminate\Foundation\Application
	 */
	private $app;

	/**
	 * The UrlGenerator instance.
	 *
	 * @var \Illuminate\Routing\UrlGenerator
	 */
	private $url;

	/**
	 * The theme name.
	 *
	 * @var string
	 */
	private $themeName;

	/**
	 * The Configuration Repository implementation.
	 *
	 * @var \Illuminate\Config\Repository
	 */
	private $config;

	/**
	 * The base view path.
	 *
	 * @var string
	 */
	private $baseViewPath;

	public function __construct(Application $app)
	{
		$this->app    = $app;
		$this->url    = $app->make('url');
		$this->config = $app->make('config');

		// This gets the first element of the view.paths array
		// which by default is the app's view folder.
		$this->baseViewPath = $this->config['view.paths'][0];

		$this->themeName = $this->config->get('theme.name', '');

	}

	/**
	 * Returns the theme name in use.
	 *
	 * @return string
	 */
	public function getThemeName()
	{
		return $this->themeName;
	}
	
	public function asset($asset)
	{
		return $this->url->asset(strtolower($this->themeName).'/'.$asset);
	}

}