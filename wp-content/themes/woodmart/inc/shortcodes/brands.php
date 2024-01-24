<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
 * ------------------------------------------------------------------------------------------------
 * Brands carousel/grid/list shortcode
 * ------------------------------------------------------------------------------------------------
 */

if ( ! function_exists( 'woodmart_shortcode_brands' ) ) {
	function woodmart_shortcode_brands( $atts, $content = '' ) {
		$item_class  = $items_wrap_class = $carousel_atts = '';
		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'title'                      => '',
					'username'                   => 'flickr',
					'number'                     => 20,
					'hover'                      => 'default',
					'target'                     => '_self',
					'link'                       => '',
					'ids'                        => '',
					'alignment'                  => '',
					'style'                      => 'carousel',
					'brand_style'                => 'default',
					'per_row'                    => 3,
					'per_row_tablet'             => 'auto',
					'per_row_mobile'             => 'auto',
					'columns'                    => 3,
					'columns_tablet'             => 'auto',
					'columns_mobile'             => 'auto',
					'orderby'                    => '',
					'order'                      => 'ASC',
					'hide_empty'                 => 'no',
					'scroll_carousel_init'       => 'no',
					'filter_in_current_category' => 'no',
					'spacing'                    => '',
					'spacing_tablet'             => '',
					'spacing_mobile'             => '',
					'disable_link'               => 'no',
					'woodmart_css_id'            => '',
					'with_bg_color'              => 'no',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		$carousel_id = 'brands_' . rand( 1000, 9999 );
		$nav_classes = '';

		$attribute = woodmart_get_opt( 'brands_attribute' );

		if ( empty( $attribute ) || ! taxonomy_exists( $attribute ) ) {
			return '<div class="wd-notice wd-info">' . esc_html__( 'You must select your brand attribute in Theme Settings -> Shop -> Brands', 'woodmart' ) . '</div>';
		}

		ob_start();

		$class  = 'wd-brands brands-widget slider-' . $carousel_id;
		$class .= apply_filters( 'vc_shortcodes_css_class', '', '', $parsed_atts );

		if ( ! empty( $css ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if ( $style ) {
			$class .= ' wd-layout-' . $style;
		}

		$class .= ' wd-hover-' . $hover;
		$class .= ' wd-style-' . $brand_style;

		if ( 'yes' === $with_bg_color ) {
			$class .= ' wd-with-bg';
		}

		if ( $alignment ) {
			$class .= ' text-' . $alignment;
		}

		if ( $style == 'carousel' ) {
			woodmart_enqueue_js_library( 'swiper' );
			woodmart_enqueue_js_script( 'swiper-carousel' );
			woodmart_enqueue_inline_style( 'swiper' );

			$custom_sizes = apply_filters( 'woodmart_brands_shortcode_custom_sizes', false );

			$parsed_atts['carousel_id']     = $carousel_id;
			$parsed_atts['slides_per_view'] = $per_row;
			$parsed_atts['custom_sizes']    = $custom_sizes;

			if ( ( 'auto' !== $per_row_tablet && ! empty( $per_row_tablet ) ) || ( 'auto' !== $per_row_mobile && ! empty( $per_row_mobile ) ) ) {
				$parsed_atts['custom_sizes'] = array(
					'desktop' => $per_row,
					'tablet'  => $per_row_tablet,
					'mobile'  => $per_row_mobile,
				);
			}

			$carousel_atts = woodmart_get_carousel_attributes( $parsed_atts );

			$items_wrap_class .= 'wd-carousel wd-grid';
			$class            .= ' wd-carousel-container';
			$item_class       .= ' wd-carousel-item';

			if ( $scroll_carousel_init == 'yes' ) {
				woodmart_enqueue_js_library( 'waypoints' );
				$items_wrap_class .= ' scroll-init';
			}

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$class .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
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
			$items_wrap_class .= ' wd-grid-g';
			$item_class       .= ' wd-col';
			$carousel_atts    .= ' style="' . woodmart_get_grid_attrs( $parsed_atts ) . '"';
		}

		$args = array(
			'taxonomy'   => $attribute,
			'hide_empty' => 'yes' === $hide_empty,
			'order'      => $order,
			'number'     => $number,
		);

		if ( $orderby ) {
			$args['orderby'] = $orderby;
		}

		if ( $orderby == 'random' ) {
			$args['orderby'] = 'id';
			$brand_count     = wp_count_terms(
				$attribute,
				array(
					'hide_empty' => 'yes' === $hide_empty,
				)
			);

			$offset = rand( 0, $brand_count - $number );
			if ( $offset <= 0 ) {
				$offset = '';
			}
			$args['offset'] = $offset;
		}

		if ( ! empty( $ids ) ) {
			$args['include'] = explode( ',', $ids );
		}

		$brands   = get_terms( $args );
		$taxonomy = get_taxonomy( $attribute );

		if ( $orderby == 'random' ) {
			shuffle( $brands );
		}

		if ( woodmart_is_shop_on_front() ) {
			$link = home_url();
		} elseif ( 'yes' === $filter_in_current_category && is_product_category() ) {
			$link = woodmart_get_current_url();
		} else {
			$link = get_post_type_archive_link( 'product' );
		}

		woodmart_enqueue_inline_style( 'brands' );

		if ( 'bordered' === $brand_style ) {
			woodmart_enqueue_inline_style( 'brands-style-bordered' );
		}
		?>

		<div id="<?php echo esc_attr( $carousel_id ); ?>" class="<?php echo esc_attr( $class ); ?>">
			<?php if ( ! empty( $title ) ) : ?>
				<h3 class="title">
					<?php echo wp_kses( $title, true ); ?>
				</h3>
			<?php endif; ?>

			<?php if ( 'carousel' === $style ) : ?>
				<div class="wd-carousel-inner">
			<?php endif; ?>

			<div class="<?php echo esc_attr( $items_wrap_class ); ?>" <?php echo $carousel_atts; ?>>
				<?php if ( 'carousel' === $style ) : ?>
					<div class="wd-carousel-wrap">
				<?php endif; ?>

				<?php if ( ! is_wp_error( $brands ) && count( $brands ) > 0 ) : ?>
					<?php foreach ( $brands as $key => $brand ) : ?>
						<?php
						$image       = get_term_meta( $brand->term_id, 'image', true );
						$filter_name = 'filter_' . sanitize_title( str_replace( 'pa_', '', $attribute ) );

						if ( is_object( $taxonomy ) && $taxonomy->public ) {
							$attr_link = get_term_link( $brand->term_id, $brand->taxonomy );
						} else {
							$attr_link = add_query_arg( $filter_name, $brand->slug, $link );
						}
						?>

						<div class="<?php echo esc_attr( $item_class ); ?>">
							<div class="wd-brand-item brand-item">
								<?php if ( 'list' === $style || empty( $image ) || ( is_array( $image ) && empty( $image['id'] ) ) ) : ?>
									<?php if ( 'yes' !== $disable_link ) : ?>
										<a href="<?php echo esc_url( $attr_link ); ?>" title="<?php echo esc_attr( $brand->name ); ?>">
									<?php endif; ?>

									<?php echo wp_kses( $brand->name, true ); ?>

									<?php if ( 'yes' !== $disable_link ) : ?>
										</a>
									<?php endif; ?>
								<?php elseif ( is_array( $image ) ) : ?>
									<?php if ( 'yes' !== $disable_link ) : ?>
										<a href="<?php echo esc_url( $attr_link ); ?>" title="<?php echo esc_attr( $brand->name ); ?>" class="wd-fill"></a>
									<?php endif; ?>

									<?php echo wp_get_attachment_image( $image['id'], 'full' ); ?>
								<?php else : ?>
									<?php if ( 'yes' !== $disable_link ) : ?>
										<a href="<?php echo esc_url( $attr_link ); ?>" title="<?php echo esc_attr( $brand->name ); ?>" class="wd-fill"></a>
									<?php endif; ?>

									<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>" title="<?php echo esc_attr( $brand->name ); ?>">
								<?php endif; ?>
							</div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
				<?php if ( 'carousel' === $style ) : ?>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( 'carousel' === $style ) : ?>
				<?php if ( 'yes' !== $parsed_atts['hide_prev_next_buttons'] ) : ?>
					<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
				<?php endif; ?>

				</div>

				<?php woodmart_get_carousel_pagination_template( $parsed_atts ); ?>
				<?php woodmart_get_carousel_scrollbar_template( $parsed_atts ); ?>
			<?php endif; ?>
		</div>
		<?php

		return ob_get_clean();
	}
}
