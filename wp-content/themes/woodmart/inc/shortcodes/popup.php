<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Content in popup
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_popup' ) ) {
	function woodmart_shortcode_popup( $atts, $content = '' ) {
		$parsed_atts = shortcode_atts(
			array(
				'id'                    => 'my_popup',
				'title'                 => 'GO',
				'link'                  => '',
				'width'                 => 800,
				'padding'               => '',
				'color'                 => 'default',
				'style'                 => 'default',
				'shape'                 => 'rectangle',
				'size'                  => 'default',
				'align'                 => 'center',
				'button_inline'         => 'no',
				'full_width'            => 'no',
				'bg_color'              => '',
				'bg_color_hover'        => '',
				'color_scheme'          => 'light',
				'color_scheme_hover'    => 'light',
				'woodmart_css_id'       => '',
				'css_animation'         => 'none',
				'el_class'              => '',
				'content_class'         => '',
				'icon_type'             => 'icon',
				'image'                 => '',
				'img_size'              => '25x25',
				'icon_fontawesome'      => '',
				'icon_openiconic'       => '',
				'icon_typicons'         => '',
				'icon_entypo'           => '',
				'icon_linecons'         => '',
				'icon_monosocial'       => '',
				'icon_material'         => '',
				'icon_library'          => 'fontawesome',
				'icon_position'         => 'right',
				'css'                   => '',

				'wd_animation'          => '',
				'wd_animation_delay'    => '',
				'wd_animation_duration' => '',
			),
			$atts
		);

		extract( $parsed_atts );

		$inline_styles_settings = array(
			'max-width' => $width . 'px',
		);

		$padding = json_decode( woodmart_decompress( $padding ), true );

		if ( isset( $padding['devices']['desktop'] ) ) {
			$padding = $padding['devices']['desktop'];
		}

		if ( isset( $padding['value'] ) && ( ! empty( $padding['value'] ) || '0' === $padding['value'] )  ) {
			$inline_styles_settings['padding'] = $padding['value'] . ( ! empty( $padding['unit'] ) ? $padding['unit'] : 'px' );
		}

		$inline_styles = '';

		foreach ( $inline_styles_settings as $prop => $val ) {
			$inline_styles .= $prop . ':' . $val . ';';
		}

		ob_start();

		$parsed_atts['link']          = 'url:#' . esc_attr( $id ) . '|||';
		$parsed_atts['el_class']      = 'wd-open-popup ' . $el_class;
		$parsed_atts['wrapper_class'] = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		woodmart_enqueue_js_library( 'magnific' );
		woodmart_enqueue_js_script( 'popup-element' );
		woodmart_enqueue_inline_style( 'mfp-popup' );

		echo woodmart_shortcode_button( $parsed_atts, true );

		$content_classes = woodmart_get_old_classes( ' woodmart-content-popup' );

		if ( $content_class ) {
			$content_classes .= ' ' . $content_class;
		}

		echo '<div id="' . esc_attr( $id ) . '" class="mfp-with-anim wd-popup wd-popup-element mfp-hide' . $content_classes . '" style="'. esc_attr( $inline_styles ) .'"><div class="wd-popup-inner">' . do_shortcode( $content ) . '</div></div>';

		return ob_get_clean();
	}
}
