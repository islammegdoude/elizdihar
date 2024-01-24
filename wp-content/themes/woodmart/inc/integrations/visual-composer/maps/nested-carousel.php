<?php
/**
 * Nested carousel map.
 *
 * @package Elements
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_nested_carousel' ) ) {
	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_get_vc_map_nested_carousel() {
		return array(
			'base'            => 'woodmart_nested_carousel',
			'name'            => esc_html__( 'Nested carousel', 'woodmart' ),
			'description'     => esc_html__( 'Custom carousel that can contain other elements', 'woodmart' ),
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/carousel.svg',
			'as_parent'       => array( 'only' => 'woodmart_nested_carousel_item' ),
			'content_element' => true,
			'is_container'    => true,
			'js_view'         => 'VcColumnView',
			'params'          => array(
				array(
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'woodmart_css_id',
					'type'       => 'woodmart_css_id',
				),
				/**
				 * Carousel
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Carousel', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'param_name' => 'carousel_divider',
				),
				/**
				 * Design Options.
				 */
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',
			),
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_nested_carousel_item' ) ) {
	/**
	 * Displays the shortcode settings fields in the admin.
	 */
	function woodmart_get_vc_map_nested_carousel_item() {
		return array(
			'base'            => 'woodmart_nested_carousel_item',
			'name'            => esc_html__( 'Nested carousel item', 'woodmart' ),
			'description'     => esc_html__( 'Custom carousel item', 'woodmart' ),
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/carousel-item.svg',
			'as_child'        => array( 'only' => 'woodmart_nested_carousel' ),
			'content_element' => true,
			'is_container'    => true,
			'js_view'         => 'VcColumnView',
			'params'          => array(
				/**
				 * Settings.
				 */
				array(
					'type'        => 'wd_notice',
					'param_name'  => 'notice',
					'notice_type' => 'info',
					'value'       => esc_html__( 'This element have not options', 'woodmart' ),
				),
			),
		);
	}
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	/**
	 * Create woodmart nested carousel wrapper.
	 */
	class WPBakeryShortCode_woodmart_nested_carousel extends WPBakeryShortCodesContainer {} // phpcs:ignore.

	/**
	 * Create woodmart nested carousel item.
	 */
	class WPBakeryShortCode_woodmart_nested_carousel_item extends WPBakeryShortCodesContainer {} // phpcs:ignore.
}
