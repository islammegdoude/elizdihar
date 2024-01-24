<?php
/**
 * Nested carousel shortcode.
 *
 * @package Elements
 */

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_shortcode_nested_carousel' ) ) {
	/**
	 * Render nested carousel wrapper shortcode.
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content Inner content (shortcode).
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_nested_carousel( $atts, $content ) {
		$custom_sizes = array();
		$atts         = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'woodmart_css_id'       => '',
					'css'                   => '',
					'slider_spacing'        => 30,
					'slider_spacing_tablet' => '',
					'slider_spacing_mobile' => '',
				)
			),
			$atts
		);

		if ( ! empty( $atts['slides_per_view_tablet'] ) && 'auto' !== $atts['slides_per_view_tablet'] ) {
			$custom_sizes['tablet'] = $atts['slides_per_view_tablet'];
		}

		if ( ! empty( $atts['slides_per_view_mobile'] ) && 'auto' !== $atts['slides_per_view_mobile'] ) {
			$custom_sizes['mobile'] = $atts['slides_per_view_mobile'];
		}

		if ( ! empty( $custom_sizes ) ) {
			$custom_sizes['desktop'] = $atts['slides_per_view'];
		}

		$atts['custom_sizes'] = $custom_sizes;

		$id               = 'wd-rs-' . $atts['woodmart_css_id'];
		$wrapper_classes  = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );
		$wrapper_classes .= ' wd-wpb';

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}

		$carousel_content_classes = '';
		$arrows_hover_style       = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

		if ( ! empty( $atts['carousel_arrows_position'] ) ) {
			$nav_classes = ' wd-pos-' . $atts['carousel_arrows_position'];
		} else {
			$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
		}

		$carousel_atts = woodmart_get_carousel_attributes(
			wp_parse_args(
				array(
					'spacing'        => $atts['slider_spacing'],
					'spacing_tablet' => $atts['slider_spacing_tablet'],
					'spacing_mobile' => $atts['slider_spacing_mobile'],
				),
				$atts,
			)
		);

		if ( 'disable' !== $arrows_hover_style ) {
			$nav_classes .= ' wd-hover-' . $arrows_hover_style;
		}

		woodmart_enqueue_inline_style( 'owl-carousel' );

		if ( 'yes' === $atts['scroll_carousel_init'] ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$carousel_content_classes .= ' scroll-init';
		}

		ob_start();

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_inline_style( 'swiper' );

		?>
			<div id="<?php echo esc_attr( $id ); ?>" class="wd-nested-carousel wd-carousel-container<?php echo esc_attr( $wrapper_classes ); ?>">
				<div class="wd-carousel-inner">
					<div class="wd-carousel wd-grid<?php echo esc_attr( $carousel_content_classes ); ?>" <?php echo $carousel_atts; // phpcs:ignore ?>>
						<div class="wd-carousel-wrap">
							<?php echo do_shortcode( $content ); ?>
						</div>
					</div>
					<?php if ( 'yes' !== $atts['hide_prev_next_buttons'] ) : ?>
						<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
					<?php endif; ?>
				</div>

				<?php woodmart_get_carousel_pagination_template( $atts ); ?>
				<?php woodmart_get_carousel_scrollbar_template( $atts ); ?>
			</div>
		<?php

		return ob_get_clean();
	}
}

if ( ! function_exists( 'woodmart_shortcode_nested_carousel_item' ) ) {
	/**
	 * Render nested carousel item shortcode.
	 *
	 * @param array  $atts Shortcode attributes.
	 * @param string $content Inner content (shortcode).
	 *
	 * @return false|string
	 */
	function woodmart_shortcode_nested_carousel_item( $atts, $content ) {
		ob_start();

		?>
		<div class="wd-carousel-item">
			<?php echo do_shortcode( $content ); ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
