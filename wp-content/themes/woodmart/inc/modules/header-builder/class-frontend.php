<?php

namespace XTS\Modules\Header_Builder;

use XTS\Modules\Header_Builder;
use XTS\Modules\Styles_Storage;
use XTS\Singleton;

/**
 * ------------------------------------------------------------------------------------------------
 * Frontend class that initialize current header for the page and generates its structure HTML + CSS
 * ------------------------------------------------------------------------------------------------
 */
class Frontend extends Singleton {

	/**
	 * Object main class.
	 *
	 * @var null
	 */
	public $builder = null;

	/**
	 * Elements object classes.
	 *
	 * @var array
	 */
	private $_element_classes = array();

	/**
	 * Structure of elements
	 *
	 * @var array
	 */
	private $_structure = array();

	/**
	 * Storage object classes.
	 *
	 * @var object
	 */
	private $_storage;

	/**
	 * Current header object.
	 *
	 * @var null
	 */
	public $header = null;

	/**
	 * Init.
	 *
	 * @return void
	 */
	public function init() {
		$this->builder = Header_Builder::get_instance();

		add_action( 'wp_print_styles', array( $this, 'styles' ), 200 );
		add_action( 'init', array( $this, 'get_elements' ) );
		add_action( 'wp', array( $this, 'print_header_styles' ), 500 );
	}

	/**
	 * Get elements classes.
	 *
	 * @return void
	 */
	public function get_elements() {
		// Fix VC map issue. Load our elements when Visual Composer is loaded.
		$this->_element_classes = $this->builder->elements->elements_classes;
	}

	/**
	 * Load elements classes list.
	 *
	 * @since 1.0.0
	 */
	public function print_header_styles() {
		$id           = $this->get_current_id();
		$this->header = $this->builder->factory->get_header( $id );
		$styles       = new Styles();

		$this->_storage = new Styles_Storage( $this->get_current_id(), 'option', '', false );

		if ( ! $this->_storage->is_css_exists() ) {
			$this->_storage->write( $styles->get_all_css( $this->header->get_structure(), $this->header->get_options() ), true );
		}

		if ( ! is_admin() ) {
			$this->_storage->print_styles();
		}
	}

	/**
	 * Styles.
	 *
	 * @return void
	 */
	public function styles() {
		$id               = $this->get_current_id();
		$this->header     = $this->builder->factory->get_header( $id );
		$this->_structure = $this->header->get_structure();
	}

	/**
	 * Get header ID.
	 *
	 * @return mixed|null
	 */
	public function get_current_id() {
		$id                      = $this->builder->manager->get_default_header();
		$page_id                 = woodmart_page_ID();
		$default_header          = woodmart_get_opt( 'default_header' );
		$custom_post_header      = woodmart_get_opt( 'single_post_header' );
		$custom_portfolio_header = woodmart_get_opt( 'single_portfolio_header' );
		$custom_product_header   = woodmart_get_opt( 'single_product_header' );
		$custom                  = get_post_meta( $page_id, '_woodmart_whb_header', true );

		if ( $default_header ) {
			$id = $default_header;
		}

		if ( ! empty( $custom_post_header ) && 'none' !== $custom_post_header && is_singular( 'post' ) ) {
			$id = $custom_post_header;
		}

		if ( ! empty( $custom_product_header ) && 'none' !== $custom_product_header && woodmart_woocommerce_installed() && is_product() ) {
			$id = $custom_product_header;
		}

		if ( ! empty( $custom_portfolio_header ) && 'none' !== $custom_portfolio_header && is_singular( 'portfolio' ) ) {
			$id = $custom_portfolio_header;
		}

		if ( ! empty( $custom ) && 'none' !== $custom && get_option( 'whb_' . $custom ) ) {
			$id = $custom;
		}

		return apply_filters( 'woodmart_get_current_header_id', $id );
	}

	/**
	 * Render header element.
	 *
	 * @return void
	 */
	public function generate_header() {
		$this->render_element( $this->_structure );

		do_action( 'whb_after_header' );
	}

	/**
	 * Render element.
	 *
	 * @param array $el Element settings.
	 *
	 * @return void
	 */
	private function render_element( $el ) {
		$children = '';
		$type     = ucfirst( $el['type'] );

		if ( ! isset( $el['params'] ) ) {
			$el['params'] = array();
		}

		if ( isset( $el['content'] ) && is_array( $el['content'] ) ) {
			if ( wp_is_mobile() && woodmart_get_opt( 'mobile_optimization', 0 ) && isset( $el['desktop_only'] ) ) {
				return;
			}

			if ( 'Row' === $type && ! empty( $el['params']['row_columns'] ) && '1' === $el['params']['row_columns']['value'] ) {
				$desktop_col = 1;
				$mobile_col  = 1;

				foreach ( $el['content'] as $key => $column ) {
					if ( ! empty( $column['desktop_only'] ) ) {
						if ( $desktop_col > 1 ) {
							unset( $el['content'][ $key ] );
						}

						$desktop_col++;
					} elseif ( ! empty( $column['mobile_only'] ) ) {
						if ( $mobile_col > 1 ) {
							unset( $el['content'][ $key ] );
						}

						$mobile_col++;
					}
				}
			}

			ob_start();

			foreach ( $el['content'] as $element ) {
				$this->render_element( $element );
			}

			$children = ob_get_clean();
		}

		if ( $type == 'Row' && $this->is_empty_row( $el ) || $type == 'Column' && $this->is_empty_column( $el ) ) {
			$children = false;
		}

		if ( isset( $this->_element_classes[ $type ] ) ) {
			$obj = $this->_element_classes[ $type ];
			$obj->render( $el, $children );
		}
	}

	/**
	 * Check is empty row.
	 *
	 * @param array $el Row element settings.
	 *
	 * @return bool
	 */
	private function is_empty_row( $el ) {
		$is_empty = true;

		foreach ( $el['content'] as $key => $column ) {
			if ( ! $this->is_empty_column( $column ) ) {
				$is_empty = false;
			}
		}

		return $is_empty;
	}

	/**
	 * Check is empty column.
	 *
	 * @param array $el Column element settings.
	 *
	 * @return bool
	 */
	private function is_empty_column( $el ) {
		return empty( $el['content'] );
	}
}

$GLOBALS['woodmart_hb_frontend'] = Frontend::get_instance();
