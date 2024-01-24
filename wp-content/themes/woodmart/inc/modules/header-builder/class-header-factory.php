<?php

namespace XTS\Modules\Header_Builder;

/**
 * ------------------------------------------------------------------------------------------------
 * Wrapper for our header class instance. CRUD actions
 * ------------------------------------------------------------------------------------------------
 */
class Header_Factory {

	private $_elements = null;
	private $_list     = null;

	/**
	 * Constructor
	 */
	public function __construct( $elements, $list ) {
		$this->_elements = $elements;
		$this->_list     = $list;
	}

	/**
	 * Get header by ID.
	 *
	 * @param integer $id Header ID.
	 *
	 * @return Header
	 */
	public function get_header( $id ) {
		return new Header( $this->_elements, $id );
	}

	/**
	 * Update header settings.
	 *
	 * @param integer $id Header ID.
	 * @param string  $name Header name.
	 * @param array   $structure Header structure.
	 * @param array   $settings Header settings.
	 *
	 * @return Header
	 */
	public function update_header( $id, $name, $structure, $settings ) {
		$header = new Header( $this->_elements, $id );

		$header->set_name( $name );
		$header->set_structure( $structure );
		$header->set_settings( $settings );

		$header->save();

		return $header;
	}

	/**
	 * Create new header.
	 *
	 * @param integer $id Header ID.
	 * @param string  $name Header name.
	 * @param array   $structure Header structure.
	 * @param array   $settings Header settings.
	 *
	 * @return Header
	 */
	public function create_new( $id, $name, $structure = false, $settings = false ) {
		$header = new Header( $this->_elements, $id, true );

		if ( $structure ) {
			$header->set_structure( $structure );
		}
		if ( $settings ) {
			$header->set_settings( $settings );
		}

		$header->set_name( $name );
		$header->save();

		return $header;
	}
}