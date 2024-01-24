<?php
/**
 * Woodmart attachment param.
 *
 * @package Woodmart
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}


if ( ! function_exists( 'woodmart_get_upload_param' ) ) {
	/**
	 * Woodmart attachment param.
	 *
	 * @param array  $settings Settings.
	 * @param string $value    Value.
	 *
	 * @return string
	 */
	function woodmart_get_upload_param( $settings, $value ) {
		ob_start();

		$file_name = '';

		if ( ! empty( $value ) ) {
			$path = get_attached_file( $value );

			if ( $path ) {
				$file_name = wp_basename( $path );
			}
		}

		wp_enqueue_media();
		?>
		<div class="xts-upload-preview">
			<?php if ( $file_name ) : ?>
				<?php echo esc_attr( $file_name ); ?>
			<?php endif; ?>
		</div>
		<div class="xts-upload-btns">
			<button class="xts-btn xts-upload-btn xts-i-import" data-id="<?php echo esc_attr( uniqid() ); ?>">
				<?php esc_html_e( 'Upload', 'woodmart' ); ?>
			</button>
			<button class="xts-btn xts-color-warning xts-remove-upload-btn xts-i-trash<?php echo ( ! empty( $value ) ) ? ' xts-active' : ''; ?>">
				<?php esc_html_e( 'Remove', 'woodmart' ); ?>
			</button>

			<input type="hidden" class="wpb_vc_param_value xts-upload-input-id" data-param_type="<?php echo esc_attr( $settings['type'] ); ?>" name="<?php echo esc_attr( $settings['param_name'] ); ?>" id="<?php echo esc_attr( $settings['param_name'] ); ?>" value="<?php echo esc_attr( $value ); ?>" data-settings="<?php echo esc_attr( wp_json_encode( $settings ) ); ?>">
		</div>
		<?php
		return ob_get_clean();
	}
}
