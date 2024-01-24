<?php
/**
 * Product price table shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;
use XTS\Modules\Dynamic_Discounts\Frontend as Dynamic_Discounts_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_dynamic_discounts_table' ) ) {
	/**
	 * Single product price table shortcode.
	 */
	function woodmart_shortcode_single_product_dynamic_discounts_table( $settings ) {
		$default_settings = array(
			'css' => '',
		);

		if ( ! woodmart_get_opt( 'discounts_enabled', 0 ) ) {
			return '';
		}

		$settings         = wp_parse_args( $settings, $default_settings );
		$wrapper_classes  = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );
		$wrapper_classes .= ' wd-wpb';

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}
		ob_start();

		Main::setup_preview();

		Dynamic_Discounts_Module::get_instance()->render_dynamic_discounts_table( false, $wrapper_classes );

		Main::restore_preview();

		return ob_get_clean();
	}
}

