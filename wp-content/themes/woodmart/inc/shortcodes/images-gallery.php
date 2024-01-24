<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * New gallery shortcode
 * ------------------------------------------------------------------------------------------------
 */
if ( ! function_exists( 'woodmart_images_gallery_shortcode' ) ) {
	function woodmart_images_gallery_shortcode( $atts ) {
		$output = $class = $gallery_classes = $gallery_item_classes = $gallery_attrs = '';
		$nav_classes   = '';
		$pagin_classes = '';
		$wrapper_attrs = '';

		$class .= apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'woodmart_css_id'        => '',
					'ids'                    => '',
					'images'                 => '',
					'slides_per_view'        => 3,
					'slides_per_view_tablet' => 'auto',
					'slides_per_view_mobile' => 'auto',
					'columns'                => 3,
					'columns_tablet'         => 'auto',
					'columns_mobile'         => 'auto',
					'size'                   => '',
					'img_size'               => 'medium',
					'link'                   => '',
					'spacing'                => 30,
					'spacing_tablet'         => '',
					'spacing_mobile'         => '',
					'on_click'               => 'lightbox',
					'target_blank'           => false,
					'custom_links'           => '',
					'view'                   => 'grid',
					'caption'                => false,
					'css_animation'          => 'none',
					'lazy_loading'           => 'no',
					'horizontal_align'       => 'center',
					'vertical_align'         => 'middle',
					'el_class'               => '',
					'css'                    => '',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		// Override standard WordPress gallery shortcodes

		if ( ! empty( $atts['ids'] ) ) {
			$atts['images'] = $atts['ids'];
		}

		if ( ! empty( $atts['size'] ) ) {
			$atts['img_size'] = $atts['size'];
		}

		extract( $atts );

		if ( $horizontal_align || $vertical_align ) {
			$style = '';

			if ( $horizontal_align ) {
				$style .= '--wd-justify-content:' . $horizontal_align . ';';
			}

			if ( $vertical_align ) {
				$v_align_value = array(
					'top'    => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				);

				$vertical_align = isset( $v_align_value[ $vertical_align ] ) ? $v_align_value[ $vertical_align ] : $vertical_align;

				$style .= '--wd-align-items:' . $vertical_align . ';';
			}

			if ( $style ) {
				$wrapper_attrs .= ' style="' . $style . '"';
			}
		}

		$carousel_id = 'gallery_' . rand( 100, 999 );

		$images = explode( ',', $images );

		$class .= $el_class ? ' ' . $el_class : '';
		$class .= woodmart_get_css_animation( $css_animation );

		if ( function_exists( 'vc_shortcode_custom_css_class' ) && isset( $atts['css'] ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $atts['css'] );
		}

		ob_start();

		if ( 'lightbox' === $on_click ) {
			$class .= ' photoswipe-images';
			woodmart_enqueue_js_library( 'photoswipe-bundle' );
			woodmart_enqueue_inline_style( 'photoswipe' );
			woodmart_enqueue_js_script( 'photoswipe-images' );
		}

		if ( 'links' === $on_click && function_exists( 'vc_value_from_safe' ) ) {
			$custom_links = vc_value_from_safe( $custom_links );
			$custom_links = explode( ',', $custom_links );
		}

		if ( 'carousel' === $view ) {
			woodmart_enqueue_js_library( 'swiper' );
			woodmart_enqueue_js_script( 'swiper-carousel' );
			woodmart_enqueue_inline_style( 'swiper' );
			$custom_sizes = apply_filters( 'woodmart_images_gallery_shortcode_custom_sizes', false );

			$parsed_atts['carousel_id']  = $carousel_id;
			$parsed_atts['custom_sizes'] = $custom_sizes;

			if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
				$parsed_atts['custom_sizes'] = array(
					'desktop' => $slides_per_view,
					'tablet'  => $slides_per_view_tablet,
					'mobile'  => $slides_per_view_mobile,
				);
			}

			$gallery_attrs         = woodmart_get_carousel_attributes( $parsed_atts );
			$gallery_classes      .= ' wd-carousel wd-grid';
			$class                .= ' wd-carousel-container wd-wpb';
			$gallery_item_classes .= ' wd-carousel-item';
			$arrows_hover_style    = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

			if ( ! empty( $parsed_atts['carousel_arrows_position'] ) ) {
				$nav_classes = ' wd-pos-' . $parsed_atts['carousel_arrows_position'];
			} else {
				$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
			}

			if ( 'disable' !== $arrows_hover_style ) {
				$nav_classes .= ' wd-hover-' . $arrows_hover_style;
			}

			if ( $scroll_carousel_init == 'yes' ) {
				woodmart_enqueue_js_library( 'waypoints' );
				$gallery_classes .= ' scroll-init';
			}

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$class .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
			}
		}

		if ( 'grid' === $view || 'masonry' === $view ) {
			if ( 'masonry' === $view ) {
				wp_enqueue_script( 'imagesloaded' );
				woodmart_enqueue_js_library( 'isotope-bundle' );
				woodmart_enqueue_js_script( 'image-gallery-element' );

				$gallery_classes .= ' wd-grid-f-col wd-masonry';
			} else {
				$gallery_classes .= ' wd-grid-g';
			}

			$gallery_item_classes .= ' wd-col';

			$gallery_attrs .= ' style="' . woodmart_get_grid_attrs( $parsed_atts ) . '"';
		}

		if ( 'justified' === $view ) {
			woodmart_enqueue_js_library( 'justified' );
			woodmart_enqueue_inline_style( 'justified' );
			woodmart_enqueue_js_script( 'image-gallery-element' );

			$gallery_classes .= ' wd-justified';
		}

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_init( true );
			woodmart_enqueue_inline_style( 'lazy-loading' );
		}

		woodmart_enqueue_inline_style( 'image-gallery' );

		?>
		<div id="<?php echo esc_attr( $carousel_id ); ?>" class="wd-images-gallery wd-wpb<?php echo esc_attr( $class ); ?>"<?php echo wp_kses( $wrapper_attrs, true ); ?>>
			<?php if ( 'carousel' === $view ) : ?>
				<div class="wd-carousel-inner">
			<?php endif; ?>

			<div class="<?php echo esc_attr( $gallery_classes ); ?>"<?php echo wp_kses( $gallery_attrs, true ); ?>>
				<?php if ( 'carousel' === $view ) : ?>
					<div class="wd-carousel-wrap">
				<?php endif; ?>

				<?php if ( count( $images ) > 0 ) : ?>
					<?php
					$i = 0; foreach ( $images as $img_id ) :
						if ( ! $img_id ) {
							continue;
						}

						$i++;
						$attachment = get_post( $img_id );
						$title      = '';

						if ( ! empty( $attachment ) ) {
							$title = trim( strip_tags( $attachment->post_title ) ); // phpcs:ignore.
						}

						$image_data = wp_get_attachment_image_src( $img_id, 'full' );

						$link   = is_array( $image_data ) ? $image_data[0] : '';
						$width  = isset( $image_data[1] ) ? $image_data[1] : '';
						$height = isset( $image_data[2] ) ? $image_data[2] : '';

						if ( 'links' === $on_click ) {
							$link = is_array( $custom_links ) && isset( $custom_links[ $i - 1 ] ) ? $custom_links[ $i - 1 ] : '';
						}
						?>
						<div class="wd-gallery-item<?php echo esc_attr( $gallery_item_classes ); ?>">
							<?php if ( $on_click != 'none' ) : ?>
							<a href="<?php echo esc_url( $link ); ?>" data-elementor-open-lightbox="no" data-index="<?php echo esc_attr( $i ); ?>" data-width="<?php echo esc_attr( $width ); ?>" data-height="<?php echo esc_attr( $height ); ?>" 
												<?php
												if ( $target_blank ) :
													?>
								target="_blank"<?php endif; ?> <?php
								if ( $caption ) :
									?>
								title="<?php echo esc_attr( $title ); ?>"<?php endif; ?>>
								<?php endif ?>

								<?php echo woodmart_otf_get_image_html( $img_id, $img_size, array(), array( 'class' => 'wd-gallery-image image-' . $i ) ); ?>

								<?php if ( $on_click != 'none' ) : ?>
							</a>
						<?php endif ?>
						</div>
					<?php endforeach ?>
				<?php endif ?>

				<?php if ( 'carousel' === $view ) : ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( 'carousel' === $view ) : ?>
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

		if ( $lazy_loading == 'yes' ) {
			woodmart_lazy_loading_deinit();
		}

		return $output;

	}
}
