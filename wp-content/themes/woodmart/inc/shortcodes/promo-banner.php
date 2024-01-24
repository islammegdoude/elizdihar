<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}

/**
* ------------------------------------------------------------------------------------------------
* Promo banner - image with text and hover effect
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_shortcode_promo_banner' ) ) {
	function woodmart_shortcode_promo_banner( $atts, $content ) {
		$click = $output = $subtitle_class = $title_class = $content_banner = $content_wrap_classes = $inner_class = $btn_wrapper_classes = $banner_image_classes = $class = $countdown_wrapper_classes = $countdown_timer_classes = '' ;

		$timezone = 'GMT';

		$wrapper_class = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		extract(
			shortcode_atts(
				array(
					'source_type'                => 'image',
					'video'                      => '',
					'video_poster'               => '',
					'video_poster_size'          => 'full',
					'image'                      => '',
					'img_size'                   => '800x600',
					'image_bg_position'          => 'center',
					'height'                     => 0,
					'custom_height'              => 'no',
					'new_height'                 => '',
					'link'                       => '',
					'text_alignment'             => 'left',
					'vertical_alignment'         => 'top',
					'horizontal_alignment'       => 'left',
					'style'                      => '',
					'hover'                      => 'zoom',
					'increase_spaces'            => '',
					'woodmart_color_scheme'      => 'light',
					'content_width'              => '100',

					// Countdown.
					'date'                       => '',
					'countdown_color_scheme'     => 'dark',
					'countdown_size'             => 'medium',
					'countdown_style'            => 'standard',
					'hide_countdown_on_finish'   => 'no',

					// Button
					'btn_text'                   => '',
					'btn_position'               => 'hover',
					'btn_color'                  => 'default',
					'btn_style'                  => 'default',
					'btn_shape'                  => 'rectangle',
					'btn_size'                   => 'default',
					'hide_btn_tablet'            => 'no',
					'hide_btn_mobile'            => 'no',
					'btn_icon_type'              => 'icon',
					'btn_image'                  => '',
					'btn_img_size'               => '',
					'btn_icon_position'          => 'right',
					'icon_fontawesome'           => '',
					'icon_openiconic'            => '',
					'icon_typicons'              => '',
					'icon_entypo'                => '',
					'icon_linecons'              => '',
					'icon_monosocial'            => '',
					'icon_material'              => '',
					'icon_library'               => 'fontawesome',

					// Title
					'custom_title_color'         => '',
					'title'                      => '',
					'title_tag'                  => 'h4',
					'title_size'                 => 'default',
					'font_weight'                => '',
					'title_font'                 => '',

					// Subtitle
					'subtitle'                   => '',
					'subtitle_color'             => 'default',
					'custom_subtitle_color'      => '',
					'custom_subtitle_bg_color'   => '',
					'subtitle_style'             => 'default',
					'subtitle_font_weight'       => '',
					'subtitle_font'              => '',

					// Text
					'custom_text_color'          => '',
					'content_text_size'          => 'default',

					// Old custom sizes
					'title_desktop_text_size'    => '',
					'subtitle_desktop_text_size' => '',
					'title_tablet_text_size'     => '',
					'subtitle_tablet_text_size'  => '',
					'title_mobile_text_size'     => '',
					'subtitle_mobile_text_size'  => '',

					// Extra
					'woodmart_css_id'            => '',
					'css_animation'              => 'none',
					'el_class'                   => '',
					'wrapper_classes'            => '',
					'css'                        => '',
					'title_decoration_style'     => 'colored',
				),
				$atts
			)
		);

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if ( ! $woodmart_css_id ) {
			$woodmart_css_id = uniqid();
		}
		$id                 = 'wd-' . $woodmart_css_id;
		$wrapper_style_attr = '';
		$wrapper_class     .= ! empty( $wrapper_classes ) ? ' ' . $wrapper_classes : '';

		$class .= ' banner-' . $style;
		$class .= ' banner-hover-' . $hover;
		$class .= ' color-scheme-' . $woodmart_color_scheme;
		$class .= ' banner-btn-size-' . $btn_size;
		$class .= ' banner-btn-style-' . $btn_style;
		$class .= woodmart_get_css_animation( $css_animation );

		$banner_image_classes .= ' wd-bg-position-' . $image_bg_position;

		if ( ! $custom_subtitle_color && ! $custom_subtitle_bg_color ) {
			$subtitle_class .= ' subtitle-color-' . $subtitle_color;
		}

		$subtitle_class .= ' subtitle-style-' . $subtitle_style;
		$subtitle_class .= ' ' . woodmart_get_new_size_classes( 'banner', $title_size, 'subtitle' );

		$title_class .= ' wd-font-weight-' . $font_weight;
		if ( $title_font ) {
			$title_class .= ' font-' . $title_font;
		}
		$title_class .= ' ' . woodmart_get_new_size_classes( 'banner', $title_size, 'title' );

		$subtitle_class .= ' wd-font-weight-' . $subtitle_font_weight;
		if ( $subtitle_font ) {
			$subtitle_class .= ' font-' . $subtitle_font;
		}

		$content_banner .= ' text-' . $text_alignment;

		if ( 'content-background' === $style ) {
			$btn_position = 'static';
		}

		if ( $content_width && 'custom' !== $content_width && '100' !== $content_width ) {
			$wrapper_style_attr .= ' style="--wd-max-width: ' . $content_width . '%;"';
			$class              .= ' wd-width-enabled';
		} elseif ( 'custom' === $content_width ) {
			$wrapper_class .= ' wd-width-custom';
		}

		$content_wrap_classes .= ' wd-items-' . $vertical_alignment;
		$content_wrap_classes .= ' wd-justify-' . $horizontal_alignment;

		$class .= woodmart_get_old_classes( ' banner-vr-align-' . $vertical_alignment );
		$class .= woodmart_get_old_classes( ' banner-hr-align-' . $horizontal_alignment );

		$inner_class .= ' ' . woodmart_get_new_size_classes( 'banner', $content_text_size, 'content' );

		if ( $increase_spaces == 'yes' ) {
			$class .= ' banner-increased-padding';
		}
		$class .= ' ' . $el_class;

		if ( ! empty( $btn_text ) ) {
			$class .= ' with-btn';
			$class .= ' banner-btn-position-' . $btn_position;
		}

		if ( $hover == 'parallax' ) {
			woodmart_enqueue_js_library( 'panr-parallax-bundle' );
			woodmart_enqueue_js_script( 'banner-element' );
		}

		$link_attributes = woodmart_get_link_attributes( $link );

		if ( $link_attributes ) {
			$class .= ' wd-with-link';
		}

		// Countdown classes.
		if ( ! empty( $date ) ) {
			$timezone = apply_filters( 'woodmart_wp_timezone_element', false ) ? get_option( 'timezone_string' ) : 'GMT';

			$countdown_wrapper_classes .= ' wd-countdown-timer';
			$countdown_wrapper_classes .= ' color-scheme-' . $countdown_color_scheme;

			$countdown_timer_classes .= 'wd-timer';
			$countdown_timer_classes .= ' timer-size-' . $countdown_size;
			$countdown_timer_classes .= ' timer-style-' . $countdown_style;

			woodmart_enqueue_js_library( 'countdown-bundle' );
			woodmart_enqueue_js_script( 'countdown-element' );
			woodmart_enqueue_inline_style( 'countdown' );
		}

		// Button
		$btn_wrapper_classes .= ( $hide_btn_tablet == 'yes' ) ? ' wd-hide-md-sm' : '';
		$btn_wrapper_classes .= ( $hide_btn_mobile == 'yes' ) ? ' wd-hide-sm' : '';

		// Image settings.
		$source_output = '';

		if ( 'image' === $source_type ) {
			$source_output = woodmart_otf_get_image_html( $image, $img_size );
		} elseif ( 'video' === $source_type ) {
			$video_attrs = '';

			if ( $video_poster ) {
				if ( in_array( $video_poster_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) || ( is_string( $video_poster_size ) && preg_match_all( '/\d+/', $video_poster_size ) ) ) {
					$poster_src = woodmart_otf_get_image_url( $video_poster, $video_poster_size );
				} else {
					$poster_src = wp_get_attachment_image_url( $video_poster, $video_poster_size );
				}

				$video_attrs .= ' poster="' . $poster_src . '"';
			}

			$source_output = '<video src="' . wp_get_attachment_url( $video ) . ' " autoplay muted loop playsinline' . $video_attrs . '></video>';
		}

		$style_attr = '';

		if ( ! $new_height && 'yes' === $custom_height ) {
			if ( 0 === $height ) {
				$banner_image_classes .= ' wd-without-height';
			} else {
				$style_attr = 'style="--wd-img-height: ' . $height . 'px"';
			}
		}

		ob_start();

		woodmart_enqueue_inline_style( 'banner' );

		if ( in_array( $style, array( 'mask', 'shadow' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-style-mask-and-shadow' );
		} elseif ( in_array( $style, array( 'border', 'background' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-style-bg-and-border' );
		} elseif ( 'content-background' === $style ) {
			woodmart_enqueue_inline_style( 'banner-style-bg-cont' );
		}

		if ( in_array( $hover, array( 'background', 'border' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-hover-bg-and-border' );
		} elseif ( in_array( $hover, array( 'zoom', 'zoom-reverse' ), true ) ) {
			woodmart_enqueue_inline_style( 'banner-hover-zoom' );
		}

		if ( 'hover' === $btn_position ) {
			woodmart_enqueue_inline_style( 'banner-btn-hover' );
		}

		if ( isset( $title_decoration_style ) && 'default' !== $title_decoration_style ) {
			$class .= ' wd-underline-' . $title_decoration_style;
			woodmart_enqueue_inline_style( 'mod-highlighted-text' );
		}

		?>
		<div class="promo-banner-wrapper <?php echo esc_attr( $wrapper_class ); ?>">
			<div id="<?php echo esc_attr( $id ); ?>" class="promo-banner <?php echo esc_attr( $class ); ?>"<?php echo wp_kses( $wrapper_style_attr, true ); ?>>
				<div class="main-wrapp-img">
					<div class="banner-image<?php echo esc_attr( $banner_image_classes ); ?>" <?php echo $style_attr; ?>>
						<?php echo wp_kses( $source_output, true ); ?>
					</div>
				</div>

				<div class="wrapper-content-banner wd-fill <?php echo esc_attr( $content_wrap_classes ); ?>">
					<div class="content-banner <?php echo esc_attr( $content_banner ); ?>">
						<?php
							if ( ! empty( $subtitle ) ) {
								echo '<div class="banner-subtitle' . esc_attr( $subtitle_class ) . '">' . $subtitle . '</div>';
							}
							if ( ! empty( $title ) ) {
								echo '<' . $title_tag . ' class="banner-title' . esc_attr( $title_class ) . '">' . $title . '</' . $title_tag . '>';
							}
						?>
						<?php if ( $content ) : ?>
							<div class="banner-inner set-cont-mb-s reset-last-child<?php echo esc_attr( $inner_class ); ?>">
								<?php
									echo do_shortcode( wpautop( $content ) );
								?>
							</div>
						<?php endif ?>

						<?php if ( ! empty( $date ) ) : ?>
							<div class="<?php echo esc_attr( trim( $countdown_wrapper_classes ) ); ?>">
								<div class="<?php echo esc_attr( $countdown_timer_classes ); ?>" data-end-date="<?php echo esc_attr( $date ); ?>" data-timezone="<?php echo esc_attr( $timezone ); ?>" data-hide-on-finish="<?php echo esc_attr( $hide_countdown_on_finish ); ?>">
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

						<?php
						if ( ! empty( $btn_text ) ) {
							echo '<div class="banner-btn-wrapper' . esc_attr( $btn_wrapper_classes ) . '">';
								echo woodmart_shortcode_button(
									array(
										'title'            => $btn_text,
										'color'            => $btn_color,
										'style'            => $btn_style,
										'size'             => $btn_size,
										'align'            => $text_alignment,
										'shape'            => $btn_shape,
										'link'             => $link,
										'icon_type'        => $btn_icon_type,
										'image'            => $btn_image,
										'img_size'         => $btn_img_size,
										'icon_position'    => $btn_icon_position,
										'icon_fontawesome' => $icon_fontawesome,
										'icon_openiconic'  => $icon_openiconic,
										'icon_typicons'    => $icon_typicons,
										'icon_entypo'      => $icon_entypo,
										'icon_linecons'    => $icon_linecons,
										'icon_monosocial'  => $icon_monosocial,
										'icon_material'    => $icon_material,
										'icon_library'     => $icon_library,
									)
								);
							echo '</div>';
						}
						?>
					</div>
				</div>

				<?php if ( $link_attributes ) : ?>
					<a class="wd-promo-banner-link wd-fill" aria-label="<?php esc_html_e( 'Banner link', 'woodmart' ); ?>" <?php echo wp_kses( $link_attributes, true ); ?>></a>
				<?php endif; ?>

				<?php
				$css = '';
				if ( $custom_title_color && ! woodmart_is_css_encode( $custom_title_color ) ) $css .= '#' . $id . ' .banner-title{color:' . $custom_title_color . '}';
				if ( $custom_subtitle_color && ! woodmart_is_css_encode( $custom_subtitle_color ) ) $css .= '#' . $id . ' .banner-subtitle{color:' . $custom_subtitle_color . '}';
				if ( $custom_text_color && ! woodmart_is_css_encode( $custom_text_color ) ) $css .= '#' . $id . ' .banner-inner{color:' . $custom_text_color . '}';

				// Text size
				if ( $title_desktop_text_size ) $css .= woodmart_responsive_text_size_css( $id, 'banner-title', $title_desktop_text_size, 'return' );
				if ( $subtitle_desktop_text_size ) $css .= woodmart_responsive_text_size_css( $id, 'banner-subtitle', $subtitle_desktop_text_size, 'return' );

				if ( $title_tablet_text_size || $subtitle_tablet_text_size ) {
					$css .= '@media (max-width:1199px){';
					if ( $title_tablet_text_size ) $css .= woodmart_responsive_text_size_css( $id, 'banner-title', $title_tablet_text_size, 'return' );
					if ( $subtitle_tablet_text_size ) $css .= woodmart_responsive_text_size_css( $id, 'banner-subtitle', $subtitle_tablet_text_size, 'return' );
					$css .= '}';
				}

				if ( $title_mobile_text_size || $subtitle_mobile_text_size ) {
					$css .= '@media (max-width:767px){';
					if ( $title_mobile_text_size ) $css .= woodmart_responsive_text_size_css( $id, 'banner-title', $title_mobile_text_size, 'return' );
					if ( $subtitle_mobile_text_size ) $css .= woodmart_responsive_text_size_css( $id, 'banner-subtitle', $subtitle_mobile_text_size, 'return' );
					$css .= '}';
				}

				wp_add_inline_style( 'woodmart-inline-css', $css );
				?>
			</div>
		</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}


if ( ! function_exists( 'woodmart_shortcode_banners_carousel' ) ) {
	function woodmart_shortcode_banners_carousel( $atts = array(), $content = null ) {
		$output = $class = $autoplay = $wrapper_classes = '';

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'slides_per_view'        => 3,
					'slides_per_view_tablet' => 'auto',
					'slides_per_view_mobile' => 'auto',
					'woodmart_css_id'        => uniqid(),
					'slider_spacing'         => 30,
					'slider_spacing_tablet'  => '',
					'slider_spacing_mobile'  => '',
					'dragEndSpeed'           => 600,
					'scroll_carousel_init'   => 'no',
					'el_class'               => '',
					'responsive_spacing'     => '',
					'css'                    => '',
					'content_height'         => '',
				)
			),
			$atts
		);

		extract( $parsed_atts );

		$custom_sizes = apply_filters( 'woodmart_promo_banner_shortcode_custom_sizes', false );

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if ( ( 'auto' !== $slides_per_view_tablet && ! empty( $slides_per_view_tablet ) ) || ( 'auto' !== $slides_per_view_mobile && ! empty( $slides_per_view_mobile ) ) ) {
			$custom_sizes = array(
				'desktop' => $slides_per_view,
				'tablet'  => $slides_per_view_tablet,
				'mobile'  => $slides_per_view_mobile,
			);
		}

		$class             .= ' ' . $el_class;
		$wrapper_classes   .= ' wd-rs-' . $woodmart_css_id;
		$carousel_id        = 'carousel-' . wp_rand( 100, 999 );
		$arrows_hover_style = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

		if ( ! empty( $parsed_atts['carousel_arrows_position'] ) ) {
			$nav_classes = ' wd-pos-' . $parsed_atts['carousel_arrows_position'];
		} else {
			$nav_classes = ' wd-pos-' . woodmart_get_opt( 'carousel_arrows_position', 'sep' );
		}

		if ( 'disable' !== $arrows_hover_style ) {
			$nav_classes .= ' wd-hover-' . $arrows_hover_style;
		}

		$parsed_atts['custom_sizes'] = $custom_sizes;

		if ( $scroll_carousel_init == 'yes' ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$class .= ' scroll-init';
		}

		if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
			$wrapper_classes .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
		}

		$parsed_atts['spacing']        = $parsed_atts['slider_spacing'];
		$parsed_atts['spacing_tablet'] = $parsed_atts['slider_spacing_tablet'];
		$parsed_atts['spacing_mobile'] = $parsed_atts['slider_spacing_mobile'];

		$content = str_replace( '[promo_banner', '[promo_banner wrapper_classes="wd-carousel-item"', $content );

		ob_start();

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_inline_style( 'swiper' );
		?>

			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="wd-carousel-container banners-carousel-wrapper <?php echo esc_attr( $wrapper_classes ); ?>">
				<div class="wd-carousel-inner">
					<div class="wd-carousel wd-grid banners-carousel<?php echo esc_attr( $class ); ?>" <?php echo woodmart_get_carousel_attributes( $parsed_atts ); ?>>
						<div class="wd-carousel-wrap">
							<?php echo do_shortcode( $content ); ?>
						</div>
					</div>

					<?php if ( 'yes' !== $parsed_atts['hide_prev_next_buttons'] ) : ?>
						<?php woodmart_get_carousel_nav_template( $nav_classes ); ?>
					<?php endif; ?>
				</div>

				<?php woodmart_get_carousel_pagination_template( $parsed_atts ); ?>
				<?php woodmart_get_carousel_scrollbar_template( $parsed_atts ); ?>
			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
