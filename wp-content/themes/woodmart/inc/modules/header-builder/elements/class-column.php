<?php

namespace XTS\Modules\Header_Builder\Elements;

use XTS\Modules\Header_Builder\Element;

/**
 * ------------------------------------------------------------------------------------------------
 * Basic structure element - column
 * ------------------------------------------------------------------------------------------------
 */
class Column extends Element {

	public function __construct() {
		parent::__construct();

		$this->template_name = 'column';
	}

	public function map() {
		$this->args = array(
			'type'            => 'column',
			'title'           => esc_html__( 'Column', 'woodmart' ),
			'text'            => esc_html__( 'Column', 'woodmart' ),
			'editable'        => false,
			'container'       => true,
			'edit_on_create'  => false,
			'drag_target_for' => array( 'content_element' ),
			'drag_source'     => '',
			'removable'       => false,
			'class'           => '',
			'addable'         => false,
			'it_works'        => 'column',
			'content'         => array(),
		);
	}
}
