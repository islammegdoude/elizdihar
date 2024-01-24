<?php
if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}




if ( ! function_exists( 'woodmart_shortcode_testimonials' ) ) {
	function woodmart_shortcode_testimonials( $atts = array(), $content = null ) {
		global $woodmart_testimonials_style;

		$class           = '';
		$wrapper_classes = '';
		$carousel_atts   = '';

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'layout'                 => 'slider',
					'style'                  => 'standard',
					'woodmart_color_scheme'  => '',
					'align'                  => 'center',
					'text_size'              => '',
					'slides_per_view'        => 3,
					'slides_per_view_tablet' => 'auto',
					'slides_per_view_mobile' => 'auto',
					'columns'                => 3,
					'columns_tablet'         => 'auto',
					'columns_mobile'         => 'auto',
					'spacing'                => 30,
					'spacing_tablet'         => '',
					'spacing_mobile'         => '',
					'name'                   => '',
					'title'                  => '',
					'stars_rating'           => 'yes',
					'el_class'               => '',
					'woodmart_css_id'        => '',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		ob_start();

		if ( ! $woodmart_css_id ) {
			$woodmart_css_id = uniqid();
		}
		$id = 'wd-' . $woodmart_css_id;

		if ( ! empty( $css ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		$wrapper_classes .= apply_filters( 'vc_shortcodes_css_class', '', '', $parsed_atts );
		$wrapper_classes .= ' testimon-style-' . $style;
		$wrapper_classes .= ' color-scheme-' . $woodmart_color_scheme;

		$wrapper_classes .= ' ' . woodmart_get_new_size_classes( 'testimonials', $text_size, 'text' );

		if ( 'info-top' !== $style ) {
			$wrapper_classes .= ' testimon-align-' . $align;
		}

		if ( 'yes' === $stars_rating ) {
			woodmart_enqueue_inline_style( 'mod-star-rating' );

			$wrapper_classes .= ' testimon-with-rating';
		}

		$wrapper_classes .= ' ' . $el_class;

		if ( 'slider' === $layout ) {
			woodmart_enqueue_js_library( 'swiper' );
			woodmart_enqueue_js_script( 'swiper-carousel' );
			woodmart_enqueue_inline_style( 'swiper' );

			$custom_sizes = apply_filters( 'woodmart_testimonials_shortcode_custom_sizes', false );

			$parsed_atts['carousel_id']  = $id;
			$parsed_atts['custom_sizes'] = $custom_sizes;

			if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
				$parsed_atts['custom_sizes'] = array(
					'desktop' => $slides_per_view,
					'tablet'  => $slides_per_view_tablet,
					'mobile'  => $slides_per_view_mobile,
				);
			}

			$carousel_atts = woodmart_get_carousel_attributes( $parsed_atts );
			$class        .= ' wd-carousel wd-grid';
			$items_classes = ' wd-carousel-item';

			$wrapper_classes .= ' wd-carousel-container';

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$wrapper_classes .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
			}

			$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

			if ( ! empty( $carousel_arrows_position ) ) {
				$nav_classes = ' wd-pos-' . $carousel_arrows_position;
			} else {
				$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
			}

			if ( 'disable' !== $arrows_hover_style ) {
				$nav_classes .= ' wd-hover-' . $arrows_hover_style;
			}
		} else {
			$wrapper_classes .= ' wd-wpb';
			$items_classes    = 'wd-col';
			$carousel_atts   .= ' style="' . woodmart_get_grid_attrs( $parsed_atts ) . '"';

			$class .= ' wd-grid-g';
		}

		$content = str_replace( '[testimonial', '[testimonial class_grid="' . $items_classes . '"', $content );

		$woodmart_testimonials_style = $style;
		?>
			<div id="<?php echo esc_attr( $id ); ?>" class="testimonials<?php echo esc_attr( $wrapper_classes ); ?>">
				<?php if ( $title ) : ?>
					<h4 class="wd-el-title title slider-title"><span><?php echo esc_html( $title ); ?></span></h4>
				<?php endif ?>

				<?php if ( 'slider' === $layout ) : ?>
					<div class="wd-carousel-inner">
				<?php endif; ?>
				<div class="<?php echo esc_attr( $class ); ?>" <?php echo $carousel_atts; ?>>
					<?php if ( 'slider' === $layout ) : ?>
						<div class="wd-carousel-wrap">
					<?php endif; ?>

					<?php echo do_shortcode( $content ); ?>

					<?php if ( 'slider' === $layout ) : ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( 'slider' === $layout ) : ?>
					<?php if ( 'yes' !== $parsed_atts['hide_prev_next_buttons'] ) : ?>
						<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
					<?php endif; ?>

					</div>

					<?php woodmart_get_carousel_pagination_template( $parsed_atts ); ?>
					<?php woodmart_get_carousel_scrollbar_template( $parsed_atts ); ?>
				<?php endif; ?>
			</div>
		<?php
		$output = ob_get_contents();
		ob_end_clean();

		$woodmart_testimonials_style = '';

		return $output;
	}
}

if ( ! function_exists( 'woodmart_shortcode_testimonial' ) ) {
	function woodmart_shortcode_testimonial( $atts, $content ) {
		global $woodmart_testimonials_style;

		$class = '';

		extract(
			shortcode_atts(
				array(
					'image'      => '',
					'img_size'   => '100x100',
					'name'       => '',
					'title'      => '',
					'el_class'   => '',
					'class_grid' => '',
				),
				$atts
			)
		);

		$img_id = preg_replace( '/[^\d]/', '', $image );

		$class .= ' ' . $el_class;

		if ( isset( $class_grid ) && $class_grid ) {
			$class .= $class_grid;
		}

		ob_start();

		if ( 'info-top' === $woodmart_testimonials_style ) {
			woodmart_enqueue_inline_style( 'testimonial' );
		} else {
			woodmart_enqueue_inline_style( 'testimonial-old' );
		}

		$image_output = '';

		if ( $img_id ) {
			$image_output = woodmart_otf_get_image_html( $img_id, $img_size, array(), array( 'class' => 'testimonial-avatar-image' ) );
		}

		$template_name = 'default.php';

		if ( 'info-top' === $woodmart_testimonials_style ) {
			$template_name = 'info-top.php';
		}

		woodmart_get_element_template(
			'testimonials',
			array(
				'image'        => $image_output,
				'title'        => $title,
				'name'         => $name,
				'content'      => $content,
				'item_classes' => $class,
			),
			$template_name
		);

		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
