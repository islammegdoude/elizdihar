<?php
/**
 * Banner template function.
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_elementor_banner_template' ) ) {
	function woodmart_elementor_banner_carousel_template( $settings, $element ) {
		$default_settings = array(
			'content_repeater'       => array(),

			// Carousel.
			'slides_per_view'        => array( 'size' => 3 ),
			'slides_per_view_tablet' => array( 'size' => '' ),
			'slides_per_view_mobile' => array( 'size' => '' ),
			'slider_spacing'         => 30,
			'slider_spacing_tablet'  => '',
			'slider_spacing_mobile'  => '',
			'custom_sizes'           => apply_filters( 'woodmart_promo_banner_shortcode_custom_sizes', false ),
		);

		$settings           = wp_parse_args( $settings, array_merge( woodmart_get_carousel_atts(), $default_settings ) );
		$carousel_classes   = '';
		$wrapper_classes    = '';
		$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

		if ( ! empty( $settings['carousel_arrows_position'] ) ) {
			$nav_classes = ' wd-pos-' . $settings['carousel_arrows_position'];
		} else {
			$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
		}

		if ( $arrows_hover_style && 'disable' !== $arrows_hover_style ) {
			$nav_classes .= ' wd-hover-' . $arrows_hover_style;
		}

		$settings['slides_per_view'] = $settings['slides_per_view']['size'];

		if ( ! empty( $settings['slides_per_view_tablet']['size'] ) || ! empty( $settings['slides_per_view_mobile']['size'] ) ) {
			$settings['custom_sizes'] = array(
				'desktop' => $settings['slides_per_view'],
				'tablet'  => $settings['slides_per_view_tablet']['size'],
				'mobile'  => $settings['slides_per_view_mobile']['size'],
			);
		}

		if ( 'yes' === $settings['scroll_carousel_init'] ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$carousel_classes .= ' scroll-init';
		}

		if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
			$wrapper_classes .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
		}

		$settings['spacing']        = $settings['slider_spacing'];
		$settings['spacing_tablet'] = $settings['slider_spacing_tablet'];
		$settings['spacing_mobile'] = $settings['slider_spacing_mobile'];

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_inline_style( 'swiper' );

		?>
		<div class="wd-carousel-container banners-carousel-wrapper<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-carousel-inner">
				<div class="wd-carousel wd-grid banners-carousel<?php echo esc_attr( $carousel_classes ); ?>" <?php echo woodmart_get_carousel_attributes( $settings ); ?>>
					<div class="wd-carousel-wrap">
						<?php foreach ( $settings['content_repeater'] as $index => $banner ) : ?>
							<?php
							$banner                    = $banner + $settings;
							$banner['wrapper_classes'] = ' wd-carousel-item elementor-repeater-item-' . $banner['_id'];
							?>
							<?php woodmart_elementor_banner_template( $banner, $element ); ?>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if ( 'yes' !== $settings['hide_prev_next_buttons'] ) : ?>
					<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
				<?php endif; ?>
			</div>

			<?php woodmart_get_carousel_pagination_template( $settings ); ?>
			<?php woodmart_get_carousel_scrollbar_template( $settings ); ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_elementor_banner_template' ) ) {
	function woodmart_elementor_banner_template( $settings, $element ) {
		$default_settings = array(
			'source_type'                => 'image',
			'video'                      => array( 'id' => '' ),
			'video_poster'               => array( 'id' => '' ),
			'image'                      => '',
			'image_height'               => array( 'size' => 0 ),
			'link'                       => '',
			'text_alignment'             => 'left',
			'vertical_alignment'         => 'top',
			'horizontal_alignment'       => 'left',
			'style'                      => '',
			'hover'                      => 'zoom',
			'increase_spaces'            => '',
			'woodmart_color_scheme'      => 'light',

			// Countdown.
			'show_countdown'             => 'no',
			'countdown_color_scheme'     => 'dark',
			'countdown_size'             => 'medium',
			'countdown_style'            => 'standard',
			'hide_countdown_on_finish'   => 'no',

			// Button.
			'btn_text'                   => '',
			'btn_position'               => 'hover',
			'btn_color'                  => 'default',
			'btn_style'                  => 'default',
			'btn_shape'                  => 'rectangle',
			'btn_size'                   => 'default',
			'hide_btn_tablet'            => 'no',
			'hide_btn_mobile'            => 'no',
			'title_decoration_style'     => 'default',
			'btn_icon_type'              => 'icon',
			'btn_image'                  => '',
			'btn_image_size'             => '',
			'btn_image_custom_dimension' => '',
			'btn_icon'                   => '',
			'btn_icon_position'          => 'right',

			// Title.
			'custom_title_color'         => '',
			'title'                      => '',
			'title_tag'                  => 'h4',
			'title_size'                 => 'default',

			// Subtitle.
			'subtitle'                   => '',
			'subtitle_color'             => 'default',
			'custom_subtitle_color'      => '',
			'custom_subtitle_bg_color'   => '',
			'subtitle_style'             => 'default',

			// Text.
			'custom_text_color'          => '',
			'content_text_size'          => 'default',

			// Extra.
			'wrapper_classes'            => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		if ( 'parallax' === $settings['hover'] ) {
			woodmart_enqueue_js_library( 'panr-parallax-bundle' );
			woodmart_enqueue_js_script( 'banner-element' );
		}

		// Classes.
		$banner_classes            = '';
		$subtitle_classes          = '';
		$title_classes             = '';
		$content_classes           = '';
		$inner_classes             = '';
		$countdown_wrapper_classes = '';
		$countdown_timer_classes   = '';
		$btn_wrapper_classes       = '';
		$image_url                 = '';
		$video_attrs               = '';
		$wrapper_content_classes   = '';

		$timezone = 'GMT';

		// Banner classes.
		$banner_classes .= ' banner-' . $settings['style'];
		$banner_classes .= ' banner-hover-' . $settings['hover'];
		$banner_classes .= ' color-scheme-' . $settings['woodmart_color_scheme'];
		$banner_classes .= ' banner-btn-size-' . $settings['btn_size'];
		$banner_classes .= ' banner-btn-style-' . $settings['btn_style'];
		if ( 'yes' === $settings['increase_spaces'] ) {
			$banner_classes .= ' banner-increased-padding';
		}
		if ( 'content-background' === $settings['style'] ) {
			$settings['btn_position'] = 'static';
		}
		if ( $settings['btn_text'] ) {
			$banner_classes .= ' with-btn';
			$banner_classes .= ' banner-btn-position-' . $settings['btn_position'];
		}

		// Subtitle classes.
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$subtitle_classes .= ' elementor-inline-editing';
		}
		$subtitle_classes .= ' subtitle-style-' . $settings['subtitle_style'];
		if ( ! $settings['custom_subtitle_color'] && ! $settings['custom_subtitle_bg_color'] ) {
			$subtitle_classes .= ' subtitle-color-' . $settings['subtitle_color'];
		}
		$subtitle_classes .= ' ' . woodmart_get_new_size_classes( 'banner', $settings['title_size'], 'subtitle' );

		// Content classes.
		$content_classes .= ' text-' . $settings['text_alignment'];

		// Wrapper content classes.
		$wrapper_content_classes .= ' wd-items-' . $settings['vertical_alignment'];
		$wrapper_content_classes .= ' wd-justify-' . $settings['horizontal_alignment'];
		$banner_classes          .= woodmart_get_old_classes( ' banner-vr-align-' . $settings['vertical_alignment'] );
		$banner_classes          .= woodmart_get_old_classes( ' banner-hr-align-' . $settings['horizontal_alignment'] );

		// Title classes.
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$title_classes .= ' elementor-inline-editing';
		}
		if ( 'default' !== $settings['title_decoration_style'] ) {
			$title_classes .= ' wd-underline-' . $settings['title_decoration_style'];
			woodmart_enqueue_inline_style( 'mod-highlighted-text' );
		}

		$title_classes .= ' ' . woodmart_get_new_size_classes( 'banner', $settings['title_size'], 'title' );

		// Content classes.
		if ( woodmart_elementor_is_edit_mode() && ! strstr( $settings['wrapper_classes'], 'elementor-repeater-item' ) ) {
			$inner_classes .= ' elementor-inline-editing';
		}
		$inner_classes .= ' ' . woodmart_get_new_size_classes( 'banner', $settings['content_text_size'], 'content' );

		// Countdown classes.
		if ( 'yes' === $settings['show_countdown'] ) {
			$timezone = apply_filters( 'woodmart_wp_timezone_element', false ) ? get_option( 'timezone_string' ) : 'GMT';

			$countdown_wrapper_classes .= ' wd-countdown-timer';
			$countdown_wrapper_classes .= ! empty( $settings['countdown_color_scheme'] ) ? ' color-scheme-' . $settings['countdown_color_scheme'] : '';

			$countdown_timer_classes .= 'wd-timer';
			$countdown_timer_classes .= ' timer-size-' . $settings['countdown_size'];
			$countdown_timer_classes .= ' timer-style-' . $settings['countdown_style'];

			woodmart_enqueue_js_library( 'countdown-bundle' );
			woodmart_enqueue_js_script( 'countdown-element' );
			woodmart_enqueue_inline_style( 'countdown' );
		}

		// Button classes.
		if ( 'yes' === $settings['hide_btn_tablet'] ) {
			$btn_wrapper_classes .= ' wd-hide-md-sm';
		}
		if ( 'yes' === $settings['hide_btn_mobile'] ) {
			$btn_wrapper_classes .= ' wd-hide-sm';
		}

		// Link settings.
		if ( $settings['link'] && $settings['link']['url'] ) {
			$element->remove_render_attribute( 'link' );

			$element->add_link_attributes( 'link', $settings['link'] );
			$element->add_render_attribute( 'link', 'class', 'wd-promo-banner-link wd-fill' );
			$element->add_render_attribute( 'link', 'aria-label', esc_html__( 'Banner link', 'woodmart' ) );

			$banner_classes .= ' wd-with-link';
		}

		// Image settings.
		if ( 'image' === $settings['source_type'] ) {
			if ( $settings['image']['id'] ) {
				$image_url = woodmart_otf_get_image_url( $settings['image']['id'], $settings['image_size'], $settings['image_custom_dimension'] );
			} elseif ( $settings['image']['url'] ) {
				$image_url = $settings['image']['url'];
			}
		}

		woodmart_enqueue_inline_style( 'banner' );

		if ( in_array( $settings['style'], array( 'mask', 'shadow' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-style-mask-and-shadow' );
		} elseif ( in_array( $settings['style'], array( 'border', 'background' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-style-bg-and-border' );
		} elseif ( 'content-background' === $settings['style'] ) {
			woodmart_enqueue_inline_style( 'banner-style-bg-cont' );
		}

		if ( in_array( $settings['hover'], array( 'background', 'border' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-hover-bg-and-border' );
		} elseif ( in_array( $settings['hover'], array( 'zoom', 'zoom-reverse' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-hover-zoom' );
		}

		if ( 'hover' === $settings['btn_position'] ) {
			woodmart_enqueue_inline_style( 'banner-btn-hover' );
		}

		$banner_image_classes = '';

		if ( 'video' === $settings['source_type'] && ! empty( $settings['video_poster']['id'] ) ) {
			$video_attrs .= ' poster="' . woodmart_otf_get_image_url( $settings['video_poster']['id'], $settings['video_poster_size'], $settings['video_poster_custom_dimension'] ) . '"';
		}

		if ( ! isset( $settings['image_height']['size'] ) || ( isset( $settings['image_height']['size'] ) && 0 === $settings['image_height']['size'] ) ) {
			$banner_image_classes = ' wd-without-height';
		}
		?>
		<div class="promo-banner-wrapper<?php echo esc_attr( $settings['wrapper_classes'] ); ?>">
			<div class="promo-banner<?php echo esc_attr( $banner_classes ); ?>">
				<div class="main-wrapp-img">
					<div class="banner-image<?php echo esc_attr( $banner_image_classes ); ?>">
						<?php if ( 'image' === $settings['source_type'] ) : ?>
							<?php if ( 'parallax' !== $settings['hover'] && $settings['image']['id'] ) : ?>
								<?php echo woodmart_otf_get_image_html( $settings['image']['id'], $settings['image_size'], $settings['image_custom_dimension'] ); ?>
							<?php elseif ( $image_url ) : ?>
								<?php echo apply_filters( 'woodmart_image', '<img src="' . esc_url( $image_url ) . '" class="promo-banner-image" alt="promo-banner-image">' ); ?>
							<?php endif; ?>
						<?php elseif ( 'video' === $settings['source_type'] ) : ?>
							<video src="<?php echo esc_url( wp_get_attachment_url( $settings['video']['id'] ) ); ?>" autoplay muted loop playsinline<?php echo wp_kses( $video_attrs, true ); ?>></video>
						<?php endif; ?>
					</div>
				</div>

				<div class="wrapper-content-banner wd-fill<?php echo esc_attr( $wrapper_content_classes ); ?>">
					<div class="content-banner <?php echo esc_attr( $content_classes ); ?>">
						<?php if ( $settings['subtitle'] ) : ?>
							<div class="banner-subtitle<?php echo esc_attr( $subtitle_classes ); ?>" data-elementor-setting-key="subtitle">
								<?php echo nl2br( $settings['subtitle'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( $settings['title'] ) : ?>
							<<?php echo esc_attr( $settings['title_tag'] ); ?> class="banner-title<?php echo esc_attr( $title_classes ); ?>" data-elementor-setting-key="title">
								<?php echo nl2br( $settings['title'] ); ?>
							</<?php echo esc_attr( $settings['title_tag'] ); ?>>
						<?php endif; ?>

						<?php if ( $settings['content'] ) : ?>
							<div class="banner-inner set-cont-mb-s reset-last-child<?php echo esc_attr( $inner_classes ); ?>" data-elementor-setting-key="content">
								<?php echo do_shortcode( wpautop( $settings['content'] ) ); ?>
							</div>
						<?php endif ?>

						<?php if ( 'yes' === $settings['show_countdown'] ) : ?>
							<div class="<?php echo esc_attr( trim( $countdown_wrapper_classes ) ); ?>">
								<div class="<?php echo esc_attr( $countdown_timer_classes ); ?>" data-end-date="<?php echo esc_attr( $settings['date'] ); ?>" data-timezone="<?php echo esc_attr( $timezone ); ?>" data-hide-on-finish="<?php echo esc_attr( $settings['hide_countdown_on_finish'] ); ?>">
									<span class="countdown-days">
										<span class="wd-timer-value">
											0
										</span>
										<span class="wd-timer-text">
											<?php esc_html_e( 'days', 'woodmart' ); ?>
										</span>
									</span>
									<span class="countdown-hours">
										<span class="wd-timer-value">
											00
										</span>
										<span class="wd-timer-text">
											<?php esc_html_e( 'hr', 'woodmart' ); ?>
										</span>
									</span>
									<span class="countdown-min">
										<span class="wd-timer-value">
											00
										</span>
										<span class="wd-timer-text">
											<?php esc_html_e( 'min', 'woodmart' ); ?>
										</span>
									</span>
									<span class="countdown-sec">
										<span class="wd-timer-value">
											00
										</span>
										<span class="wd-timer-text">
											<?php esc_html_e( 'sc', 'woodmart' ); ?>
										</span>
									</span>
								</div>
							</div>
						<?php endif ?>

						<?php if ( $settings['btn_text'] ) : ?>
							<div class="banner-btn-wrapper<?php echo esc_attr( $btn_wrapper_classes ); ?>">
								<?php
								unset( $settings['inline_editing_key'] );
								woodmart_elementor_button_template(
									array(
										'title'         => $settings['btn_text'],
										'color'         => $settings['btn_color'],
										'style'         => $settings['btn_style'],
										'size'          => $settings['btn_size'],
										'align'         => $settings['text_alignment'],
										'shape'         => $settings['btn_shape'],
										'text'          => $settings['btn_text'],
										'inline_edit'   => false,
										'icon_type'     => $settings['btn_icon_type'],
										'image'         => $settings['btn_image'],
										'icon'          => $settings['btn_icon'],
										'icon_position' => $settings['btn_icon_position'],
										'image_size'   => $settings['btn_image_size'],
										'image_custom_dimension' => $settings['btn_image_custom_dimension'],
									) + $settings
								);
								?>
							</div>
						<?php endif; ?>
					</div>
				</div>

				<?php if ( $settings['link'] && $settings['link']['url'] ) : ?>
					<a <?php echo $element->get_render_attribute_string( 'link' )?>></a>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
}
