<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* Add gradient to VC 
*/
if( ! function_exists( 'woodmart_add_gradient_type' ) && apply_filters( 'woodmart_gradients_enabled', true ) ) {
	function woodmart_add_gradient_type( $settings, $value ) {
		return woodmart_get_gradient_field( $settings['param_name'], $value, true );
	}
}

if( ! function_exists( 'woodmart_get_gradient_field' ) ) {
	function woodmart_get_gradient_field( $param_name, $value, $is_VC = false ) {
		$classes = $param_name;
		$classes .= ( $is_VC ) ? ' wpb_vc_param_value' : '';
		$uniqid = uniqid();
		$output = '<div class="woodmart-grad-wrap">';
			$output .= '<div class="woodmart-grad-line" id="woodmart-grad-line' . $uniqid . '"></div>';
			$output .= '<div class="woodmart-grad-preview" id="woodmart-grad-preview' . $uniqid . '"></div>';
			$output .= '<input id="woodmart-grad-val' . $uniqid . '" class="' . $classes . '" name="' . $param_name . '"  style="display:none"  value="'.$value.'"/>';
		$output .= '</div>';

		return $output;
	}
}
