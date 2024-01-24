<?php
/**
 * Instagram template function.
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_elementor_instagram_template' ) ) {
	function woodmart_elementor_instagram_template( $settings ) {
		$default_settings = array(
			'username'                   => 'flickr',
			'number'                     => array( 'size' => 9 ),
			'size'                       => 'medium',
			'target'                     => '_self',
			'link'                       => '',
			'design'                     => 'grid',
			'spacing'                    => 0,
			'spacing_custom'             => 6,
			'spacing_custom_tablet'      => '',
			'spacing_custom_mobile'      => '',
			'rounded'                    => 0,
			'per_row'                    => array( 'size' => 3 ),
			'per_row_tablet'             => array( 'size' => '' ),
			'per_row_mobile'             => array( 'size' => '' ),
			'hide_mask'                  => 0,
			'hide_pagination_control'    => '',
			'hide_prev_next_buttons'     => '',
			'carousel_arrows_position'   => '',
			'hide_scrollbar'             => '',
			'dynamic_pagination_control' => '',
			'ajax_body'                  => false,
			'content'                    => '',
			'data_source'                => 'scrape',
			'custom_sizes'               => apply_filters( 'woodmart_instagram_shortcode_custom_sizes', false ),
			'scroll_carousel_init'       => 'no',
			'content_color_scheme'       => '',

			// Images.
			'images'                     => array(),
			'images_size'                => 'medium',
			'images_link'                => '',
			'images_likes'               => '1000-10000',
			'images_comments'            => '0-1000',
		);

		$settings            = wp_parse_args( $settings, array_merge( woodmart_get_carousel_atts(), $default_settings ) );
		$settings['per_row'] = $settings['per_row']['size'];
		$wrapper_classes     = '';
		$carousel_atts       = '';
		$pics_classes        = '';
		$picture_classes     = '';
		$carousel_id         = 'carousel-' . wp_rand( 100, 999 );
		$content_classes     = ! empty( $settings['content_color_scheme'] ) ? ' color-scheme-' . $settings['content_color_scheme'] : '';

		// Wrapper classes.
		$wrapper_classes .= ' data-source-' . $settings['data_source'];

		if ( 1 == $settings['rounded'] ) {
			$wrapper_classes .= ' instagram-rounded';
		}

		if ( empty( $settings['per_row_tablet']['size'] ) ) {
			$settings['per_row_tablet']['size'] = $settings['per_row'];
		}

		if ( empty( $settings['per_row_mobile']['size'] ) ) {
			$settings['per_row_mobile']['size'] = round( (int) $settings['per_row'] / 2 );
		}

		if ( 'slider' === $settings['design'] ) {
			woodmart_enqueue_js_library( 'swiper' );
			woodmart_enqueue_js_script( 'swiper-carousel' );
			woodmart_enqueue_inline_style( 'swiper' );

			if ( ! empty( $settings['per_row_tablet']['size'] ) || ! empty( $settings['per_row_mobile']['size'] ) ) {
				$settings['custom_sizes'] = array(
					'desktop' => $settings['per_row'],
					'tablet'  => $settings['per_row_tablet']['size'],
					'mobile'  => $settings['per_row_mobile']['size'],
				);
			}

			$carousel_atts = woodmart_get_carousel_attributes(
				wp_parse_args(
					array(
						'carousel_id'            => $carousel_id,
						'slides_per_view'        => $settings['per_row'],
						'slides_per_view_tablet' => $settings['per_row_tablet'],
						'slides_per_view_mobile' => $settings['per_row_mobile'],
						'custom_sizes'           => $settings['custom_sizes'],
						'spacing'                => $settings['spacing'] ? $settings['spacing_custom'] : 0,
						'spacing_tablet'         => $settings['spacing'] ? $settings['spacing_custom_tablet'] : 0,
						'spacing_mobile'         => $settings['spacing'] ? $settings['spacing_custom_mobile'] : 0,
					),
					$settings
				)
			);

			if ( 'yes' === $settings['scroll_carousel_init'] ) {
				woodmart_enqueue_js_library( 'waypoints' );
				$pics_classes .= ' scroll-init';
			}

			if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
				$wrapper_classes .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
			}

			$pics_classes    .= ' wd-carousel wd-grid';
			$wrapper_classes .= ' wd-carousel-container';
		} else {
			$settings['columns']        = $settings['per_row'];
			$settings['columns_tablet'] = $settings['per_row_tablet']['size'];
			$settings['columns_mobile'] = $settings['per_row_mobile']['size'];

			if ( ! $settings['spacing'] ) {
				$settings['spacing'] = 0;
			} else {
				$settings['spacing']        = $settings['spacing_custom'];
				$settings['spacing_tablet'] = $settings['spacing_custom_tablet'];
				$settings['spacing_mobile'] = $settings['spacing_custom_mobile'];
			}

			$pics_classes    .= ' wd-grid-g';
			$carousel_atts   .= ' style="' . woodmart_get_grid_attrs( $settings ) . '"';
			$picture_classes .= ' wd-col';
		}

		if ( 'images' === $settings['data_source'] ) {
			$images = array();
			foreach ( $settings['images'] as $image ) {
				$images[] = $image['id'];
			}

			$media_array = woodmart_get_instagram_custom_images( implode( ',', $images ), $settings['images_size'], $settings['images_link'], $settings['images_likes'], $settings['images_comments'] );
		} else {
			$media_array = woodmart_scrape_instagram( $settings['username'], $settings['number']['size'], $settings['ajax_body'], $settings['data_source'] );
		}

		unset( $settings['ajax_body'] );

		$encoded_attributes = json_encode( $settings );

		if ( is_wp_error( $media_array ) && ( $media_array->get_error_code() === 'invalid_response_429' || apply_filters( 'woodmart_intagram_user_ajax_load', false ) || 'ajax' === $settings['data_source'] ) ) {
			woodmart_enqueue_js_script( 'instagram-element' );
			$wrapper_classes      .= ' wd-error';
			$media_array           = array();
			$settings['hide_mask'] = true;
			for ( $i = 0; $i < $settings['number']['size']; $i++ ) {
				$media_array[] = array(
					$settings['size'] => WOODMART_ASSETS . '/images/settings/instagram/insta-placeholder.jpg',
					'link'            => '#',
					'likes'           => '0',
					'comments'        => '0',
				);
			}
		}

		woodmart_enqueue_inline_style( 'instagram' );

		?>
		<div id="<?php echo esc_attr( $carousel_id ); ?>" data-atts="<?php echo esc_attr( $encoded_attributes ); ?>" data-username="<?php echo esc_attr( $settings['username'] ); ?>" class="wd-insta<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( $settings['username'] && ! is_wp_error( $media_array ) ) : ?>

				<?php if ( 'slider' === $settings['design'] ) : ?>
					<div class="wd-carousel-inner">
				<?php endif; ?>

				<?php if ( $settings['content'] ) : ?>
					<div class="wd-insta-cont wd-fill<?php echo esc_attr( $content_classes ); ?>">
						<div class="wd-insta-cont-inner reset-last-child">
							<?php echo do_shortcode( $settings['content'] ); ?>
						</div>
					</div>
				<?php endif; ?>

				<div class="<?php echo esc_attr( $pics_classes ); ?>" <?php echo $carousel_atts; ?>>
					<?php if ( 'slider' === $settings['design'] ) : ?>
						<div class="wd-carousel-wrap">
					<?php endif; ?>

					<?php foreach ( $media_array as $item ) : ?>
						<?php
						$image = '';

						if ( ! empty( $item[ $settings['size'] ] ) ) {
							$image = $item[ $settings['size'] ];
						}

						?>

						<?php if ( 'slider' === $settings['design'] ) : ?>
							<div class="wd-carousel-item">
						<?php endif; ?>

						<div class="wd-insta-item<?php echo esc_attr( $picture_classes ); ?>">
							<a href="<?php echo esc_url( $item['link'] ); ?>" target="<?php echo esc_attr( $settings['target'] ); ?>" aria-label="<?php esc_attr_e( 'Instagram picture', 'woodmart' ); ?>"></a>

							<?php
							$size = 'images' === $settings['data_source'] ? $settings['images_size'] : $settings['size'];
							if ( isset( $item['image_id'] ) && $item['image_id'] ) {
								echo wp_get_attachment_image( $item['image_id'], $size );
							} else {
								echo apply_filters( 'woodmart_image', '<img src="' . esc_url( $image ) . '" alt="' . esc_attr__( 'Instagram image', 'woodmart' ) . '"/>' );
							}
							?>

							<?php if ( 0 == $settings['hide_mask'] ) : ?>
								<div class="wd-insta-meta wd-grid-g">
									<span class="wd-insta-likes instagram-likes"><span><?php echo esc_attr( woodmart_pretty_number( $item['likes'] ) ); ?></span></span>
									<span class="wd-insta-comm instagram-comments"><span><?php echo esc_attr( woodmart_pretty_number( $item['comments'] ) ); ?></span></span>
								</div>
							<?php endif; ?>
						</div>

						<?php if ( 'slider' === $settings['design'] ) : ?>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>

					<?php if ( 'slider' === $settings['design'] ) : ?>
						</div>
					<?php endif; ?>
				</div>

				<?php if ( 'slider' === $settings['design'] ) : ?>
					<?php if ( 'yes' !== $settings['hide_prev_next_buttons'] ) : ?>
						<?php
						$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

						if ( ! empty( $settings['carousel_arrows_position'] ) ) {
							$nav_classes = ' wd-pos-' . $settings['carousel_arrows_position'];
						} else {
							$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
						}

						if ( 'disable' !== $arrows_hover_style ) {
							$nav_classes .= ' wd-hover-' . $arrows_hover_style;
						}

						woodmart_get_carousel_nav_template( $nav_classes );
						?>
					<?php endif; ?>

					</div>

					<?php woodmart_get_carousel_pagination_template( $settings ); ?>
					<?php woodmart_get_carousel_scrollbar_template( $settings ); ?>
				<?php endif; ?>
			<?php elseif ( is_wp_error( $media_array ) ) : ?>
				<?php echo '<div class="wd-notice wd-info">' . esc_html( $media_array->get_error_message() ) . '</div>'; ?>
			<?php endif; ?>

			<?php if ( $settings['link'] ) : ?>
					<a href="//www.instagram.com/<?php echo trim( $settings['username'] ); ?>" class="wd-insta-link" rel="me" target="<?php echo esc_attr( $settings['target'] ); ?>"><?php echo esc_html( $settings['link'] ); ?></a>
			<?php endif; ?>
		</div>
		<?php
	}
}
