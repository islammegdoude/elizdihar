<?php
/**
 * Product price table map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_single_product_dynamic_discounts_table' ) ) {
	/**
	 * Content map.
	 */
	function woodmart_get_vc_map_single_product_dynamic_discounts_table() {
		$price_typography = woodmart_get_typography_map(
			array(
				'key'      => 'price_typography',
				'title'    => esc_html__( 'Price typography', 'woodmart' ),
				'group'    => esc_html__( 'Style', 'woodmart' ),
				'selector' => '{{WRAPPER}}.wd-dynamic-discounts .amount',
			)
		);

		$discount_typography = woodmart_get_typography_map(
			array(
				'key'      => 'discount_typography',
				'title'    => esc_html__( 'Discount typography', 'woodmart' ),
				'group'    => esc_html__( 'Style', 'woodmart' ),
				'selector' => '{{WRAPPER}}.wd-dynamic-discounts tr td:last-child',
			)
		);

		return array(
			'base'        => 'woodmart_single_product_dynamic_discounts_table',
			'name'        => esc_html__( 'Product dynamic discounts table', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
			'description' => esc_html__( 'Shows the current discount relative to the product quantity', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-dynamic-discounts.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
					'group'      => esc_html__( 'Style', 'woodmart' ),
				),

				array(
					'heading'          => esc_html__( 'Price color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'price_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}}.wd-dynamic-discounts .amount' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Price typography.
				$price_typography['font_family'],
				$price_typography['font_size'],
				$price_typography['font_weight'],
				$price_typography['text_transform'],
				$price_typography['font_style'],
				$price_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Discount color', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'discount_color',
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'selectors'        => array(
						'{{WRAPPER}}.wd-dynamic-discounts tr td:last-child' => array(
							'color: {{VALUE}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Discount typography.
				$discount_typography['font_family'],
				$discount_typography['font_size'],
				$discount_typography['font_weight'],
				$discount_typography['text_transform'],
				$discount_typography['font_style'],
				$discount_typography['line_height'],
				// Design options.
				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'woodmart' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),
			),
		);
	}
}
