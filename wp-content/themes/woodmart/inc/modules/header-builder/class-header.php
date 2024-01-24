<?php

namespace XTS\Modules\Header_Builder;

use XTS\Modules\Styles_Storage;

/**
 * ------------------------------------------------------------------------------------------------
 * Class to handle header structure. Save/get to/from the database.
 * ------------------------------------------------------------------------------------------------
 */

class Header {

	/**
	 * Elements map.
	 *
	 * @var
	 */
	private $_elements;

	/**
	 * Header ID.
	 *
	 * @var int|string
	 */
	private $_id = 'none';

	/**
	 * Header name.
	 *
	 * @var string
	 */
	private $_name = 'none';

	/**
	 * Header structure.
	 *
	 * @var string
	 */
	private $_structure;

	/**
	 * Header settings.
	 *
	 * @var array
	 */
	private $_settings;

	/**
	 * Object class.
	 *
	 * @var Styles_Storage
	 */
	private $_storage;

	/**
	 * Header options.
	 *
	 * @var array
	 */
	private $_header_options = array();

	/**
	 * Structure row elements.
	 *
	 * @var array
	 */
	private $_structure_elements = array( 'top-bar', 'general-header', 'header-bottom' );

	/**
	 * Structure column elements.
	 *
	 * @var array
	 */
	private $_structure_elements_types = array( 'logo', 'search', 'cart', 'wishlist', 'account', 'compare', 'burger', 'mainmenu', 'mobilesearch', 'burger' );

	/**
	 * Construct.
	 *
	 * @param object  $elements Elements.
	 * @param integer $id Header IS.
	 * @param boolean $new Is new header.
	 */
	public function __construct( $elements, $id, $new = false ) {
		$this->_elements = $elements;
		$this->_id       = ( $id ) ? $id : WOODMART_HB_DEFAULT_ID;

		if ( $new ) {
			$this->create_empty();
		} else {
			$this->load();
		}

		$this->_storage = new Styles_Storage( $this->get_id(), 'option', '', false );
	}

	/**
	 * Create new header.
	 *
	 * @return void
	 */
	private function create_empty() {
		$this->set_settings();
		$this->set_structure();
	}

	/**
	 * Load header settings.
	 *
	 * @return void
	 */
	private function load() {
		// Get data from the database.
		$data = get_option( 'whb_' . $this->get_id() );

		$name      = ( isset( $data['name'] ) ) ? $data['name'] : WOODMART_HB_DEFAULT_NAME;
		$settings  = ( isset( $data['settings'] ) ) ? $data['settings'] : array();
		$structure = ( isset( $data['structure'] ) ) ? $data['structure'] : false;

		$this->set_name( $name );
		$this->set_settings( $settings );
		$this->set_structure( $structure );
	}

	/**
	 * Set header name.
	 *
	 * @param string $name Header name.
	 *
	 * @return void
	 */
	public function set_name( $name ) {
		$this->_name = $name;
	}

	/**
	 * Set header structure.
	 *
	 * @param array $structure Header structure.
	 *
	 * @return void
	 */
	public function set_structure( $structure = false ) {
		if ( ! $structure ) {
			$structure = woodmart_get_config( 'header-builder-structure' );
		}

		$this->_structure = $structure;
	}

	/**
	 * Set header settings.
	 *
	 * @param array $settings Header settings.
	 *
	 * @return void
	 */
	public function set_settings( $settings = array() ) {
		$this->_settings = $settings;
	}


	/**
	 * Get header ID.
	 *
	 * @return int
	 */
	public function get_id() {
		return $this->_id;
	}

	/**
	 * Get header name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->_name;
	}

	/**
	 * Get header structure.
	 *
	 * @return array
	 */
	public function get_structure() {
		$structure = $this->validate_sceleton( $this->_structure );
		$structure = $this->validate_element( $structure );

		return $structure;
	}

	/**
	 * Get header settings.
	 *
	 * @return array
	 */
	public function get_settings() {
		return $this->validate_settings( $this->_settings );
	}

	/**
	 * Save header settings.
	 *
	 * @return void
	 */
	public function save() {
		$styles = new Styles();

		$this->_storage->write( $styles->get_all_css( $this->get_structure(), $this->get_options() ) );

		update_option( 'whb_' . $this->get_id(), $this->get_raw_data() );
	}

	/**
	 * Get raw header data.
	 *
	 * @return array
	 */
	public function get_raw_data() {
		return array(
			'name'      => $this->get_name(),
			'id'        => $this->get_id(),
			'structure' => $this->_structure,
			'settings'  => $this->_settings,
		);
	}

	/**
	 * Get header data.
	 *
	 * @return array
	 */
	public function get_data() {
		return array(
			'name'      => $this->get_name(),
			'id'        => $this->get_id(),
			'structure' => $this->get_structure(),
			'settings'  => $this->get_settings(),
		);
	}

	/**
	 * Set header options.
	 *
	 * @param array $elements Elements data.
	 *
	 * @return void
	 */
	private function set_header_options( $elements ) {
		foreach ( $elements as $element => $params ) {
			if ( ! in_array( $element, array_merge( $this->_structure_elements, $this->_structure_elements_types ) ) ) {
				continue;
			}

			foreach ( $params as $key => $param ) {
				if ( isset( $param['value'] ) ) {
					$this->_header_options[ $element ][ $key ] = $param['value'];
				}
			}
		}
	}

	/**
	 * Get header options.
	 *
	 * @return array
	 */
	public function get_options() {
		$this->validate_settings( $this->_settings );
		return $this->transform_settings_to_values( $this->_header_options );
	}

	/**
	 * Validation header settings.
	 *
	 * @param array $settings Header settings.
	 *
	 * @return array
	 */
	private function validate_settings( $settings ) {
		$default_settings = woodmart_get_config( 'header-builder-settings' );

		$settings = $this->validate_element_params( $settings, $default_settings );

		$this->_header_options = array_merge( $settings, $this->_header_options );

		return $settings;
	}

	/**
	 * Transform settings to values.
	 *
	 * @param array $settings Header settings.
	 *
	 * @return array
	 */
	private function transform_settings_to_values( $settings ) {
		foreach ( $settings as $key => $value ) {
			if ( isset( $value['value'] ) ) {
				$settings[ $key ] = $value['value'];
			}
			if ( in_array( $key, $this->_structure_elements ) ) {
				if ( $value['hide_desktop'] ) {
					$settings[ $key ]['height'] = 0;
				}
				if ( $value['hide_mobile'] ) {
					$settings[ $key ]['mobile_height'] = 0;
				}
			}
		}
		return $settings;
	}

	/**
	 * Validate skeleton.
	 *
	 * @param array $structure Header structure.
	 *
	 * @return mixed
	 */
	private function validate_sceleton( $structure ) {
		$sceleton = $this->get_header_sceleton();

		$structure_params = $this->grab_params_from_elements( $structure['content'] );

		$this->set_header_options( $structure_params );

		$structure_elements = $this->grab_content_from_elements( $structure['content'] );

		$sceleton  = $this->fill_sceleton_with_params( $sceleton, $structure_params );
		$structure = $this->fill_sceleton_with_elements( $sceleton, $structure_elements );

		return $structure;
	}

	/**
	 * Grab parameters from elements.
	 *
	 * @param array $elements Header elements.
	 *
	 * @return array
	 */
	private function grab_params_from_elements( $elements ) {

		$params = array();

		foreach ( $elements as $key => $element ) {

			if ( isset( $element['params'] ) && is_array( $element['params'] ) ) {
				$params[ $element['id'] ] = $element['params'];
			}

			if ( in_array( $element['type'], $this->_structure_elements_types ) ) {
				$params[ $element['type'] ] = $element['params'];
			}

			if ( isset( $element['content'] ) && is_array( $element['content'] ) ) {
				$params = array_merge( $params, $this->grab_params_from_elements( $element['content'] ) );
			}
		}

		return $params;
	}

	/**
	 * Grab parameters from elements.
	 *
	 * @param array  $elements Header elements.
	 * @param string $parent Parents element.
	 *
	 * @return array
	 */
	private function grab_content_from_elements( $elements, $parent = 'root' ) {

		$structure_elements            = array();
		$structure_elements[ $parent ] = array();

		foreach ( $elements as $key => $element ) {
			if ( isset( $element['content'] ) && is_array( $element['content'] ) ) {
				$structure_elements = array_merge( $structure_elements, $this->grab_content_from_elements( $element['content'], $element['id'] ) );
			} else {
				$structure_elements[ $parent ][ $element['id'] ] = $element;
			}
		}

		if ( empty( $structure_elements[ $parent ] ) ) {
			unset( $structure_elements[ $parent ] );
		}

		return $structure_elements;
	}

	/**
	 * Get header skeleton.
	 *
	 * @return mixed
	 */
	public function get_header_sceleton() {
		return woodmart_get_config( 'header-sceleton' );
	}

	/**
	 * Fill skeleton with elements
	 *
	 * @param array $element Element.
	 * @param array $structure Header structure.
	 *
	 * @return mixed
	 */
	public function fill_sceleton_with_elements( $element, $structure ) {
		if ( empty( $element['content'] ) && isset( $structure[ $element['id'] ] ) ) {
			$element['content'] = $structure[ $element['id'] ];
		} elseif ( isset( $element['content'] ) && is_array( $element['content'] ) ) {
			$element['content'] = $this->fill_elements_with_content( $element['content'], $structure );
		}

		return $element;
	}

	/**
	 * Fill elements with content.
	 *
	 * @param array $elements Header elements.
	 * @param array $structure Header structure.
	 *
	 * @return array
	 */
	private function fill_elements_with_content( $elements, $structure ) {
		foreach ( $elements as $id => $element ) {
			$elements[ $id ] = $this->fill_sceleton_with_elements( $element, $structure );
		}

		return $elements;
	}

	/**
	 * Fill skeleton with params.
	 *
	 * @param array $element Element settings.
	 * @param array $params Element params.
	 *
	 * @return array
	 */
	public function fill_sceleton_with_params( $element, $params ) {
		if ( empty( $element['params'] ) && isset( $params[ $element['id'] ] ) ) {
			$element['params'] = $params[ $element['id'] ];
		} elseif ( isset( $element['content'] ) && is_array( $element['content'] ) ) {
			$element['content'] = $this->fill_elements_with_params( $element['content'], $params );
		}

		return $element;
	}

	/**
	 * Fill elements with params.
	 *
	 * @param array $elements Elements settings.
	 * @param array $params Elements params.
	 *
	 * @return array
	 */
	private function fill_elements_with_params( $elements, $params ) {
		foreach ( $elements as $id => $element ) {
			$elements[ $id ] = $this->fill_sceleton_with_params( $element, $params );
		}

		return $elements;
	}

	/**
	 * Validate elements.
	 *
	 * @param array $elements Elements settings.
	 *
	 * @return mixed
	 */
	private function validate_elements( $elements ) {
		foreach ( $elements as $key => $element ) {
			$elements[ $key ] = $this->validate_element( $element );
		}

		return $elements;
	}

	/**
	 * Validate element.
	 *
	 * @param array $el
	 *
	 * @return mixed
	 */
	private function validate_element( $el ) {

		$type = ucfirst( $el['type'] );

		if ( ! isset( $this->_elements->elements_classes[ $type ] ) ) {
			return $el;
		}

		$el_class = $this->_elements->elements_classes[ $type ];

		$el = $this->validate_element_args( $el, $el_class->get_args() );

		return $el;
	}

	/**
	 * Validate element args.
	 *
	 * @param array $args Args.
	 * @param array $default Default settings.
	 *
	 * @return mixed
	 */
	private function validate_element_args( $args, $default ) {
		foreach ( $default as $key => $value ) {
			if ( 'params' === $key && isset( $args[ $key ] ) ) {
				$args[ $key ] = $this->validate_element_params( $args[ $key ], $value );
			} elseif ( 'content' === $key && isset( $args[ $key ] ) ) {
				$args[ $key ] = $this->validate_elements( $args[ $key ] );
			} elseif ( ! isset( $args[ $key ] ) ) {
				$args[ $key ] = $value;
			}
		}

		return $args;
	}

	/**
	 * Validate element params.
	 *
	 * @param array $params Element params.
	 * @param array $default Element default params.
	 *
	 * @return array
	 */
	private function validate_element_params( $params, $default ) {
		$params = wp_parse_args( $params, $default );

		foreach ( $params as $key => $value ) {
			if ( ! isset( $default[ $key ] ) ) {
				unset( $params[ $key ] );
			} else {
				$params[ $key ] = $this->validate_param( $params[ $key ], $default[ $key ] );
			}
		}

		return $params;
	}

	/**
	 * Validate element param.
	 *
	 * @param array $args Element params.
	 * @param array $default_args Element default params.
	 *
	 * @return mixed
	 */
	private function validate_param( $args, $default_args ) {
		foreach ( $default_args as $key => $value ) {
			// Validate image param by ID.
			if ( 'image' === $args['type'] && ! empty( $args['value'] ) && ! empty( $args['value']['id'] ) ) {
				$attachment = wp_get_attachment_image_src( $args['value']['id'], 'full' );
				if ( ! empty( $attachment[0] ) ) {
					$args['value']['url']    = $attachment[0];
					$args['value']['width']  = $attachment[1];
					$args['value']['height'] = $attachment[2];
				} else {
					$args['value'] = '';
				}
			}

			if ( 'border' === $args['type'] && isset( $default_args['sides'] ) && is_array( $args['value'] ) ) {
				$args['value']['sides'] = $default_args['sides'];
			}

			if ( 'value' !== $key || ! isset( $args['value'] ) ) {
				$args[ $key ] = $value;
			}
		}

		return $args;
	}
}
