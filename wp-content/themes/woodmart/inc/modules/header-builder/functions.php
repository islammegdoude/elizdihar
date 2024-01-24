<?php

use XTS\Modules\Header_Builder\Frontend;

if ( ! function_exists( 'whb_get_header' ) ) {
	/**
	 * Returns the current header instance (on frontend)
	 *
	 * @return mixed|null
	 */
	function whb_get_header() {
		return Frontend::get_instance()->header;
	}
}

if ( ! function_exists( 'whb_generate_header' ) ) {
	/**
	 * Generate current header HTML structure.
	 *
	 * @return void
	 */
	function whb_generate_header() {
		woodmart_enqueue_inline_style( 'header-base' );

		Frontend::get_instance()->generate_header();
	}
}

if ( ! function_exists( 'whb_get_builder' ) ) {
	/**
	 * Get main builder class instance
	 *
	 * @return object
	 */
	function whb_get_builder() {
		return Frontend::get_instance()->builder;
	}
}

if ( ! function_exists( 'whb_is_full_screen_menu' ) ) {
	/**
	 * Is full screen menu enabled.
	 *
	 * @return bool
	 */
	function whb_is_full_screen_menu() {
		$settings = whb_get_settings();

		return isset( $settings['mainmenu'] ) && $settings['mainmenu']['full_screen'];
	}
}

if ( ! function_exists( 'whb_is_side_cart' ) ) {
	/**
	 * Is full screen search enabled.
	 *
	 * @return bool
	 */
	function whb_is_side_cart() {
		$settings = whb_get_settings();

		return isset( $settings['cart'] ) && 'side' === $settings['cart']['position'];
	}
}

if ( ! function_exists( 'whb_get_settings' ) ) {
	/**
	 * Get header settings and key elements params (search, cart widget, menu).
	 *
	 * @return array|mixed
	 */
	function whb_get_settings() {
		// Fix yoast php error.
		if ( ! is_object( whb_get_header() ) ) {
			return array();
		}

		return whb_get_header()->get_options();
	}
}

if ( ! function_exists( 'whb_get_dropdowns_color' ) ) {
	/**
	 * Get dropdowns color.
	 *
	 * @return string|void
	 */
	function whb_get_dropdowns_color() {
		if ( woodmart_get_opt( 'dark_version' ) ) {
			return 'light';
		}

		$settings = whb_get_settings();

		if ( isset( $settings['dropdowns_dark'] ) ) {
			return $settings['dropdowns_dark'] ? 'light' : 'dark';
		}
	}
}

if ( ! function_exists( 'whb_get_custom_icon' ) ) {
	/**
	 * Get custom icon.
	 *
	 * @param array $params List icon parameters.
	 * @return string html tag <img> or ''.
	 */
	function whb_get_custom_icon( $params ) {
		$params = wp_parse_args(
			$params,
			array(
				'id'     => '',
				'url'    => '',
				'width'  => '40',
				'height' => '40',
			)
		);

		if ( ! empty( $params['id'] ) ) {
			return wp_get_attachment_image(
				$params['id'],
				array(
					$params['width'],
					$params['height'],
				),
				false,
				array(
					'class' => 'wd-custom-icon',
				)
			);
		} elseif ( ! empty( $params['url'] ) ) {
			return '<img class="wd-custom-icon" src="' . esc_url( $params['url'] ) . '" alt="custom-icon" width="' . esc_attr( $params['width'] ) . '" height="' . esc_attr( $params['height'] ) . '">';
		}

		return '';
	}
}

if ( ! function_exists('woodmart_get_whb_headers_array' ) ) {
	function woodmart_get_whb_headers_array( $get_from_options = false, $new = false ) {
		if ( $get_from_options ) {
			$list = get_option( 'whb_saved_headers' );
		} else {
			$headers_list = whb_get_builder()->list;
			$list         = $headers_list->get_all();
		}

		$headers = array();

		if ( $new ) {
			$headers['none'] = array(
				'name'  => 'none',
				'value' => 'none',
			);
		} else {
			$headers['none'] = 'none';
		}

		if ( ! empty( $list ) && is_array( $list ) ) {
			foreach ( $list as $key => $header ) {
				if ( $new ) {
					$headers[ $key ] = array(
						'name'  => $header['name'],
						'value' => $key,
					);
				} else {
					$headers[ $key ] = $header['name'];
				}
			}
		}

		return $headers;
	}
}

if ( ! function_exists( 'woodmart_get_theme_settings_headers_array' ) ) {
	/**
	 * Function to get array of HTML Blocks in theme settings array style.
	 *
	 * @return array
	 */
	function woodmart_get_theme_settings_headers_array() {
		$list = get_option( 'whb_saved_headers' );

		if ( ! $list ) {
			$list = whb_get_builder()->list->get_all();
		}

		$headers = array();

		$headers['none'] = array(
			'name'  => esc_html__( 'None', 'woodmart' ),
			'value' => 'none',
		);

		if ( ! empty( $list ) && is_array( $list ) ) {
			foreach ( $list as $key => $header ) {
				$headers[ $key ] = array(
					'name'  => $header['name'],
					'value' => $key,
				);
			}
		}

		return $headers;
	}
}

if ( ! function_exists( 'woodmart_get_header_classes' ) ) {
	/**
	 * Header classes.
	 *
	 * @return void
	 */
	function woodmart_get_header_classes() {
		$settings              = whb_get_settings();
		$custom_product_header = woodmart_get_opt( 'single_product_header' );

		$header_class  = 'whb-header';
		$header_class .= ' whb-' . Frontend::get_instance()->get_current_id();
		$header_class .= ( $settings['overlap'] ) ? ' whb-overcontent' : '';
		$header_class .= ( $settings['overlap'] && $settings['boxed'] ) ? ' whb-boxed' : '';
		$header_class .= ( $settings['full_width'] ) ? ' whb-full-width' : '';
		$header_class .= ( $settings['sticky_shadow'] ) ? ' whb-sticky-shadow' : '';
		$header_class .= ( $settings['sticky_effect'] ) ? ' whb-scroll-' . $settings['sticky_effect'] : '';
		$header_class .= ( $settings['sticky_clone'] && 'slide' === $settings['sticky_effect'] ) ? ' whb-sticky-clone' : ' whb-sticky-real';
		$header_class .= ( $settings['hide_on_scroll'] ) ? ' whb-hide-on-scroll' : '';

		woodmart_enqueue_js_script( 'header-builder' );

		if ( ! empty( $custom_product_header ) && 'none' !== $custom_product_header && woodmart_woocommerce_installed() && is_product() ) {
			$header_class .= ' whb-custom-header';
		}

		echo 'class="' . esc_attr( $header_class ) . '"';
	}
}

if ( ! function_exists( 'woodmart_set_default_header' ) ) {
	/**
	 * Setup default header from theme settings
	 *
	 * @since 1.0.0
	 */
	function woodmart_set_default_header() {
		if ( ! isset( $_GET['settings-updated'] ) || isset( $_GET['preset'] ) ) { // phpcs:ignore
			return;
		}

		$theme_settings_header_id = woodmart_get_opt( 'default_header' );

		if ( $theme_settings_header_id ) {
			update_option( 'whb_main_header', $theme_settings_header_id );
		}
	}

	add_filter( 'init', 'woodmart_set_default_header', 1000 );
}

if ( ! function_exists( 'woodmart_get_header_body_classes' ) ) {
	/**
	 * Get header body classes.
	 *
	 * @return array
	 */
	function woodmart_get_header_body_classes() {
		$classes  = array();
		$settings = whb_get_settings();

		if ( isset( $settings['overlap'] ) && $settings['overlap'] ) {
			$classes[] = 'wd-header-overlap';
			$classes[] = woodmart_get_old_classes( 'woodmart-header-overcontent' );
		}

		if ( 'light' === whb_get_dropdowns_color() ) {
			$classes[] = 'dropdowns-color-light';
		}

		return $classes;
	}
}
