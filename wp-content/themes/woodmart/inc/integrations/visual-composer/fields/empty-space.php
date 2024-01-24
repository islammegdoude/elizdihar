<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* Empty space
*/
if ( ! function_exists( 'woodmart_get_empty_space_param' ) ) {
	function woodmart_get_empty_space_param( $settings, $value ) {
		return '<div class="woodmart-vc-empty-space ' . esc_attr( $settings['param_name'] ) . '"><input type="hidden" class="wpb_vc_param_value" name="' . esc_attr( $settings['param_name'] ) . '" data-settings="' . esc_attr( wp_json_encode( $settings ) ) . '"></div>';
    }
}
