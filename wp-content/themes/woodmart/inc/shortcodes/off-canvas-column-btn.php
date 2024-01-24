<?php
/***
 * Off canvas button shortcodes file.
 *
 * @package Shortcode.
 */

use XTS\Modules\Layouts\Global_Data as Builder;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_off_canvas_btn' ) ) {
	/***
	 * Render off canvas button shortcode.
	 *
	 * @param array  $attr Shortcode attributes.
	 * @param string $content Inner shortcode.
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_off_canvas_btn( $attr, $content ) {
		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', 'woodmart_off_canvas_btn', $attr );

		$settings = shortcode_atts(
			array(
				'woodmart_css_id' => '',
				'css'             => '',
				'button_text'     => 'Show column',
				'icon_type'       => 'default',
				'img_id'          => '',
				'img_size'        => '20x20',
				'sticky'          => '',
			),
			$attr
		);

		$off_canvas_classes        = '';
		$sticky_off_canvas_classes = '';

		Builder::get_instance()->set_data( 'wd_show_sticky_sidebar_button', true );

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}
		// Icon settings.

		if ( 'default' === $settings['icon_type'] ) {
			$off_canvas_classes        .= ' wd-burger-icon';
			$sticky_off_canvas_classes .= ' wd-burger-icon';
		} elseif ( 'custom' === $settings['icon_type'] ) {
			$off_canvas_classes        .= ' wd-action-custom-icon';
			$sticky_off_canvas_classes .= ' wd-action-custom-icon';
		}

		if ( woodmart_is_svg( wp_get_attachment_image_url( $settings['img_id'] ) ) ) {
			$icon_output = woodmart_get_svg_html(
				$settings['img_id'],
				$settings['img_size']
			);
		} else {
			$icon_output = woodmart_otf_get_image_html( $settings['img_id'], $settings['img_size'] );
		}

		ob_start();

		woodmart_enqueue_js_script( 'off-canvas-colum-btn' );
		woodmart_enqueue_inline_style( 'off-canvas-sidebar' );
		woodmart_enqueue_inline_style( 'el-off-canvas-column-btn' );
		?>

		<div class="wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-off-canvas-btn wd-action-btn wd-style-text<?php echo esc_html( $off_canvas_classes ); ?>">
				<a href="#" rel="nofollow">
					<?php if ( ! empty( $icon_output ) ) : ?>
						<span class="wd-action-icon">
							<?php echo $icon_output; //phpcs:ignore; ?>
						</span>
					<?php endif; ?>
					<?php echo esc_html( $settings['button_text'] ); ?>
				</a>
			</div>
			<?php if ( 'yes' === $settings['sticky'] ) : ?>
				<?php woodmart_enqueue_inline_style( 'mod-sticky-sidebar-opener' ); ?>
				<div class="wd-sidebar-opener wd-on-shop wd-action-btn wd-style-icon<?php echo esc_html( $sticky_off_canvas_classes ); ?>">
					<a href="#" rel="nofollow">
						<?php if ( ! empty( $icon_output ) ) : ?>
							<span class="wd-action-icon">
								<?php echo $icon_output; //phpcs:ignore; ?>
							</span>
						<?php endif; ?>
					</a>
				</div>
			<?php endif; ?>
		</div>

		<?php
		return apply_filters( 'vc_shortcode_output', ob_get_clean(), new WD_WPBakeryShortCodeFix(), $attr, 'woodmart_shortcode_off_canvas_btn' );
	}
}
