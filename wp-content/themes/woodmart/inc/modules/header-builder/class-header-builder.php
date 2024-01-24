<?php

namespace XTS\Modules;

use XTS\Modules\Header_Builder\Elements;
use XTS\Modules\Header_Builder\Header_Factory;
use XTS\Modules\Header_Builder\Headers_List;
use XTS\Modules\Header_Builder\Manager;
use XTS\Singleton;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * ------------------------------------------------------------------------------------------------
 * Include all required files, define constants
 * ------------------------------------------------------------------------------------------------
 */
class Header_Builder extends Singleton {

	/**
	 * Elements object classes.
	 *
	 * @var null
	 */
	public $elements = null;

	/**
	 * Header list.
	 *
	 * @var null
	 */
	public $list = null;

	/**
	 * Header factory object class.
	 *
	 * @var null
	 */
	public $factory = null;

	/**
	 * Header manager object class.
	 *
	 * @var null
	 */
	public $manager = null;

	/**
	 * Init.
	 */
	protected function init() {
		$this->define_constants();
		$this->include_files();
		$this->init_classes();
	}

	/**
	 * Define constants.
	 *
	 * @return void
	 */
	private function define_constants() {
		define( 'WOODMART_HB_DEFAULT_ID', 'default_header' );
		define( 'WOODMART_HB_DEFAULT_NAME', 'Default header layout' );
		define( 'WOODMART_HB_DIR', get_template_directory() . '/inc/modules/header-builder/' );
		define( 'WOODMART_HB_TEMPLATES', get_template_directory() . '/header-elements/' );
	}

	/**
	 * Include files.
	 *
	 * @return void
	 */
	private function include_files() {
		$classes = array(
			'class-frontend',
			'class-manager',
			'class-header-factory',
			'class-headers-list',
			'class-header',
			'class-elements',
			'class-styles',
			'functions',
		);

		if ( is_admin() ) {
			$classes[] = 'class-backend';
		}

		foreach ( $classes as $class ) {
			require_once WOODMART_HB_DIR . $class . '.php';
		}
	}

	/**
	 * Init classes.
	 *
	 * @return void
	 */
	private function init_classes() {
		$this->elements = new Elements();
		$this->list     = new Headers_List();
		$this->factory  = new Header_Factory( $this->elements, $this->list );
		$this->manager  = new Manager( $this->factory, $this->list );
	}
}

Header_Builder::get_instance();
