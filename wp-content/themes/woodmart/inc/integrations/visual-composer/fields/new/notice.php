<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * Notice.
 */
if ( ! function_exists( 'woodmart_get_notice_param' ) ) {
	function woodmart_get_notice_param( $settings, $value ) {
		ob_start();
		?>
		<input type="hidden" class="wpb_vc_param_value" name="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>">
		<div class="xts-notice xts-<?php echo esc_attr( $settings['notice_type'] ); ?>">
			<?php echo esc_html( $settings['value'] ); ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
