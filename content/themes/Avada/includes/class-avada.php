<?php

/**
 * The main theme class
 * Any additional assets, objects etc should be included and instantiated from here.
 * This is a work in progress and part of a larger rewrite that will happen over time.
 */
class Avada {

	// The theme settings
	public $settings;

	public $init;
	public $social_icons;
	public $sidebars;
	public $blog;
    public $template;
	public $portfolio;
	// public $scripts;

	/**
	 * The class constructor
	 */
	public function __construct() {

		global $smof_data;
		$this->settings = $smof_data;

		// Instantiate secondary classes
		$this->init         = new Avada_Init();
		$this->social_icons = new Avada_SocialIcons();
		$this->sidebars     = new Avada_Sidebars();
		$this->blog         = new Avada_Blog();
        $this->template     = new Avada_Template();
		$this->portfolio    = new Avada_Portfolio();
		// $this->scripts      = new Avada_Scripts();

	}

}
