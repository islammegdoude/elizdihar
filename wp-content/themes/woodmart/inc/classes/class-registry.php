<?php
/**
 * Registry helper class.
 *
 * @package xts
 */


namespace XTS;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

/**
 * Object Registry
 */
class Registry {
	/**
	 * Holds an instance of the class
	 *
	 * @var object
	 */
	private static $instance;

	/**
	 * Short names of some know objects
	 *
	 * @var array
	 */
	private $known_objects = array();

	/**
	 * Restrict direct initialization, use Registry::getInstance() instead
	 */
	private function __construct() {}

	/**
	 * Get instance of the object (the singleton method)
	 *
	 * @return  Registry
	 */
	public static function getInstance() {
		if ( ! isset( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}


	/**
	 * Dynamically load missing object and assign it to the Registry property.
	 *
	 * @param string $obj Object name (first char will be converted to upper case).
	 *
	 * @return object
	 */
	function __get( $obj ) {
		if ( ! isset( $this->known_objects[ $obj ] ) ) {
			try {
				$this->save_object( $obj );
			} catch ( Exception $e ) {
				echo esc_html( $e->getTraceAsString() );
			}
		}

		return $this->known_objects[ $obj ];
	}

	/**
	 * Init c
	 *
	 * @param string $obj Object name (first char will be converted to upper case).
	 *
	 * @return void
	 */
	private function save_object( $obj ) {
		if ( class_exists( 'WOODMART_' . ucfirst( $obj ) ) ) {
			$objname = 'WOODMART_' . ucfirst( $obj );
		} else {
			$objname = 'XTS\\' . ucfirst( $obj );
		}

		if ( is_string( $obj ) && ! isset( $this->$obj ) && class_exists( $objname ) ) {
			$this->known_objects[ $obj ] = new $objname();
		}
	}

	/**
	 * Prevent users to clone the instance
	 */
	public function __clone() {
		trigger_error( 'Clone is not allowed.', E_USER_ERROR );
	}
}
