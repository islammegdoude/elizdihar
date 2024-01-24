<?php
/**
 * Sold counter shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

use XTS\Modules\Sold_Counter\Main as Sold_Counter_Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_single_product_sold_counter' ) ) {
	/**
	 * Single product sold counter shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_single_product_sold_counter( $settings ) {
		$default_settings = array(
			'css'              => '',
			'style'            => 'default',

			'icon_type'        => 'default',
			'image'            => '',
			'img_size'         => '',
			'title'            => '',

			'icon_library'     => 'fontawesome',
			'icon_fontawesome' => 'far fa-bell',
			'icon_openiconic'  => 'vc-oi vc-oi-dial',
			'icon_typicons'    => 'typcn typcn-adjust-brightness',
			'icon_entypo'      => 'entypo-icon entypo-icon-note',
			'icon_linecons'    => 'vc_li vc_li-heart',
			'icon_monosocial'  => 'vc-mono vc-mono-fivehundredpx',
			'icon_material'    => 'vc-material vc-material-cake',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes  = 'wd-wpb';
		$wrapper_classes .= apply_filters( 'vc_shortcodes_css_class', '', '', $settings );
		$icon_class       = 'wd-count-icon';
		$icon_html        = '';

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( ( 'icon' === $settings['icon_type'] && ! empty( $settings[ 'icon_' . $settings['icon_library'] ] ) ) || ( 'image' === $settings['icon_type'] && ! empty( $settings['image'] ) ) ) {
			$wrapper_classes .= ' wd-with-icon';
		}

		if ( 'icon' === $settings['icon_type'] ) {
			$icon_class .= ' ' . $settings[ 'icon_' . $settings['icon_library'] ];
			$icon_html   = '<span class="' . esc_attr( $icon_class ) . '"></span>';

			if ( function_exists( 'vc_icon_element_fonts_enqueue' ) && $settings[ 'icon_' . $settings['icon_library'] ] ) {
				vc_icon_element_fonts_enqueue( $settings['icon_library'] );
			}
		} elseif ( 'image' === $settings['icon_type'] && ! empty( $settings['image'] ) ) {
			if ( woodmart_is_svg( wp_get_attachment_image_url( $settings['image'] ) ) ) {
				$icon_output = woodmart_get_svg_html(
					$settings['image'],
					$settings['img_size']
				);
			} else {
				$icon_output = woodmart_otf_get_image_html( $settings['image'], $settings['img_size'] );
			}

			$icon_html = '<span class="' . esc_attr( $icon_class ) . '">' . $icon_output . '</span>';
		}

		$wrapper_classes .= ' wd-style-' . $settings['style'];

		ob_start();

		Main::setup_preview();

		Sold_Counter_Module::get_instance()->render( $wrapper_classes, $icon_html );

		Main::restore_preview();

		return ob_get_clean();
	}
}
