<?php

namespace XTS\Modules\Header_Builder\Elements;

use XTS\Modules\Header_Builder\Element;

/**
 * ------------------------------------------------------------------------------------------------
 * Root element. Required for the structure only. Can hold one element only.
 * ------------------------------------------------------------------------------------------------
 */
class Root extends Element {

	public function __construct() {
		parent::__construct();

		$this->template_name = 'root';
	}

	public function map() {
		$this->args = array(
			'type'            => 'root',
			'title'           => esc_html__( 'Root', 'woodmart' ),
			'text'            => esc_html__( 'Root', 'woodmart' ),
			'editable'        => false,
			'container'       => false,
			'edit_on_create'  => false,
			'drag_target_for' => array(),
			'drag_source'     => '',
			'removable'       => false,
			'addable'         => false,
			'class'           => '',
			'it_works'        => 'root',
			'content'         => array(),
		);
	}
}
