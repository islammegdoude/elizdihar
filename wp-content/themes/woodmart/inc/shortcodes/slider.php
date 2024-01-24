<?php
/**
 * Slider.
 *
 * @package Woodmart
 */

use Elementor\Plugin;
use XTS\Admin\Modules\Options\Metaboxes;
use XTS\Modules\Styles_Storage;

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_slide_data' ) ) {
	/**
	 * Get slide data.
	 */
	function woodmart_get_slide_data( $id, $title, $animation = '' ) {
		$attributes = '';

		if ( is_user_logged_in() ) {
			$url = get_edit_post_link( $id );

			if ( 'elementor' === woodmart_get_current_page_builder() ) {
				$url = str_replace( 'action=edit', 'action=elementor', $url );
			}

			$data = array(
				'title' => $title,
				'url'   => $url,
			);

			$attributes .= ' data-slide=\'' . wp_json_encode( $data ) . '\'';
		}

		if ( 'distortion' === $animation ) {
			$bg_image_desktop      = has_post_thumbnail( $id ) ? wp_get_attachment_url( get_post_thumbnail_id( $id ) ) : '';
			$meta_bg_image_desktop = get_post_meta( $id, 'bg_image_desktop', true );
			$bg_image_tablet       = get_post_meta( $id, 'bg_image_tablet', true );
			$bg_image_mobile       = get_post_meta( $id, 'bg_image_mobile', true );

			if ( is_array( $meta_bg_image_desktop ) && ! empty( $meta_bg_image_desktop['url'] ) ) {
				$meta_bg_image_desktop = $meta_bg_image_desktop['url'];
			}
			if ( ! is_array( $meta_bg_image_desktop ) && $meta_bg_image_desktop ) {
				$bg_image_desktop = $meta_bg_image_desktop;
			}
			if ( is_array( $bg_image_tablet ) && isset( $bg_image_tablet['url'] ) ) {
				$bg_image_tablet = $bg_image_tablet['url'];
			}
			if ( is_array( $bg_image_mobile ) && isset( $bg_image_mobile['url'] ) ) {
				$bg_image_mobile = $bg_image_mobile['url'];
			}

			if ( $bg_image_desktop ) {
				$attributes .= ' data-image-url="' . $bg_image_desktop . '"';
			}

			if ( $bg_image_tablet ) {
				$attributes .= ' data-image-url-md="' . $bg_image_tablet . '"';
			}

			if ( $bg_image_mobile ) {
				$attributes .= ' data-image-url-sm="' . $bg_image_mobile . '"';
			}
		}

		return $attributes;
	}
}

if ( ! function_exists( 'woodmart_shortcode_slider' ) ) {
	/**
	 * Slider shortcode.
	 *
	 * @param array $atts Element settings.
	 *
	 * @return false|string|void
	 */
	function woodmart_shortcode_slider( $atts ) {
		$class            = '';
		$nav_classes      = '';
		$pagin_classes    = '';
		$wrapper_classes  = '';
		$carousel_classes = '';

		$parsed_atts = shortcode_atts(
			array(
				'slider'         => '',
				'el_class'       => '',
				'elementor'      => false,
				'carousel_sync'  => '',
				'sync_parent_id' => '',
				'sync_child_id'  => '',
			),
			$atts
		);

		$class .= ' ' . $parsed_atts['el_class'];
		$class .= woodmart_get_old_classes( ' woodmart-slider' );

		$slider_term = get_term_by( 'slug', $parsed_atts['slider'], 'woodmart_slider' );

		if ( is_wp_error( $slider_term ) || empty( $slider_term ) ) {
			return;
		}

		$args = array(
			'posts_per_page' => -1,
			'post_type'      => 'woodmart_slide',
			'orderby'        => 'menu_order',
			'order'          => 'ASC',
			'tax_query'   => array( // phpcs:ignore
				array(
					'taxonomy' => 'woodmart_slider',
					'field'    => 'id',
					'terms'    => $slider_term->term_id,
				),
			),
		);

		$slides = get_posts( $args );

		if ( is_wp_error( $slides ) || empty( $slides ) ) {
			return;
		}

		$stretch_slider  = get_term_meta( $slider_term->term_id, 'stretch_slider', true );
		$stretch_content = get_term_meta( $slider_term->term_id, 'stretch_content', true );

		$carousel_id = 'slider-' . $slider_term->term_id;

		$animation            = get_term_meta( $slider_term->term_id, 'animation', true );
		$arrows_style         = get_term_meta( $slider_term->term_id, 'arrows_style', true );
		$pagination_style     = get_term_meta( $slider_term->term_id, 'pagination_style', true );
		$scroll_carousel_init = get_term_meta( $slider_term->term_id, 'scroll_carousel_init', true );
		$pagination_color     = get_term_meta( $slider_term->term_id, 'pagination_color', true );

		if ( '' === $pagination_style ) {
			$pagination_style = '1';
		}

		if ( '' === $arrows_style ) {
			$arrows_style = 1;
		}

		$slide_speed = apply_filters( 'woodmart_slider_sliding_speed', 700 );

		$slider_atts = array(
			'carousel_id'             => $carousel_id,
			'slides_per_view'         => '1',
			'hide_pagination_control' => get_term_meta( $slider_term->term_id, 'pagination_style', true ) === '0' ? 'yes' : 'no',
			'hide_prev_next_buttons'  => get_term_meta( $slider_term->term_id, 'arrows_style', true ) === '0' ? 'yes' : 'no',
			'autoplay'                => ( get_term_meta( $slider_term->term_id, 'autoplay', true ) === 'on' ) ? 'yes' : 'no',
			'speed'                   => get_term_meta( $slider_term->term_id, 'autoplay_speed', true ) ? get_term_meta( $slider_term->term_id, 'autoplay_speed', true ) : 9000,
			'sliding_speed'           => $slide_speed,
			'content_animation'       => true,
			'autoheight'              => 'yes',
			'wrap'                    => 'yes',
			'effect'                  => $animation,
			'carousel_sync'           => $parsed_atts['carousel_sync'],
			'sync_parent_id'          => $parsed_atts['sync_parent_id'],
			'sync_child_id'           => $parsed_atts['sync_child_id'],
		);

		if ( is_user_logged_in() ) {
			$slider_atts['slider'] = array(
				'title' => $slider_term->name,
				'url'   => get_edit_term_link( $slider_term->term_id, 'woodmart_slider' ),
			);
		}

		if ( ! $parsed_atts['elementor'] ) {
			ob_start();
		}

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_js_script( 'slider-element' );
		woodmart_enqueue_inline_style( 'swiper' );
		woodmart_enqueue_inline_style( 'slider' );

		if ( 'distortion' === $animation ) {
			woodmart_enqueue_inline_style( 'slider-anim-distortion' );
		}

		$wrapper_classes .= ' wd-anim-' . $animation;

		if ( 'on' === $stretch_slider ) {
			if ( 'wpb' === woodmart_get_current_page_builder() ) {
				$wrapper_classes .= ' vc_row vc_row-fluid';
				$wrapper_classes .= ' wd-section-stretch-content';
			} else {
				$wrapper_classes .= ' wd-section-stretch';
			}

			if ( 'on' === $stretch_content ) {
				$wrapper_classes .= ' wd-container-full-width';
			}
		} else {
			$wrapper_classes .= ' wd-section-container';
		}

		if ( 'on' === $scroll_carousel_init ) {
			woodmart_enqueue_js_library( 'waypoints' );

			$carousel_classes .= ' scroll-init';
		}

		if ( $arrows_style ) {
			$nav_color = get_term_meta( $slider_term->term_id, 'navigation_color_scheme', true );

			if ( ! $nav_color ) {
				$nav_color = $pagination_color;
			}

			if ( in_array( $arrows_style, array( '2', '3' ), true ) ) {
				woodmart_enqueue_inline_style( 'slider-arrows' );
			}

			$nav_classes .= ' wd-style-' . $arrows_style;
			$nav_classes .= ' wd-pos-sep';

			if ( 'on' === get_term_meta( $slider_term->term_id, 'arrows_custom_settings', true ) ) {
				$arrows_hover_style = get_term_meta( $slider_term->term_id, 'arrows_hover_style', true );

				if ( $arrows_hover_style && 'disable' !== $arrows_hover_style ) {
					$nav_classes .= ' wd-hover-' . $arrows_hover_style;
				}
			}

			if ( $nav_color ) {
				$nav_classes .= ' color-scheme-' . $nav_color;
			}
		}

		if ( $pagination_style ) {
			$pagination_hr_align = get_term_meta( $slider_term->term_id, 'pagination_horizon_align', true );

			if ( ! $pagination_hr_align ) {
				$pagination_hr_align = 'center';
			}

			if ( in_array( $pagination_style, array( '1', '3' ), true ) ) {
				$pagin_classes .= ' wd-style-shape-' . $pagination_style;
			} elseif ( in_array( $pagination_style, array( '2' ), true ) ) {
				woodmart_enqueue_inline_style( 'slider-dots-style-2' );

				$pagin_classes .= ' wd-style-number-' . $pagination_style;
			}

			if ( '3' === $pagination_style ) {
				woodmart_enqueue_inline_style( 'slider-dots-style-3' );
			}

			$pagin_classes .= ' text-' . $pagination_hr_align;

			if ( $pagination_color ) {
				$pagin_classes .= ' color-scheme-' . $pagination_color;
			}
		}

		$first_slide_key = array_key_first( $slides );

		woodmart_get_slider_css( $slider_term->term_id, $carousel_id, $slides );
		?>

		<div id="<?php echo esc_attr( $carousel_id ); ?>" data-id="<?php echo esc_html( $slider_term->term_id ); ?>" class="wd-slider wd-carousel-container<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-carousel-inner">
				<div class="wd-carousel wd-grid<?php echo esc_attr( $carousel_classes ); ?>" <?php echo woodmart_get_carousel_attributes( $slider_atts ); // phpcs:ignore ?>>
					<div class="wd-carousel-wrap<?php echo esc_attr( $class ); ?>">
						<?php foreach ( $slides as $key => $slide ) : ?>
							<?php
							$slide_id        = 'slide-' . $slide->ID;
							$slide_animation = get_post_meta( $slide->ID, 'slide_animation', true );
							$slide_classes   = '';

							if ( $key === $first_slide_key ) {
								$slide_classes .= ' woodmart-loaded';
								woodmart_lazy_loading_deinit( true );
							}

							$slide_classes .= woodmart_get_old_classes( ' woodmart-slide' );

							if ( 'distortion' === $animation ) {
								woodmart_enqueue_js_script( 'slider-distortion' );
							}

							// Link.
							$link              = get_post_meta( $slide->ID, 'link', true );
							$link_target_blank = get_post_meta( $slide->ID, 'link_target_blank', true );

							$slide_attrs = woodmart_get_slide_data( $slide->ID, $slide->post_title, $animation );
							?>
							<div id="<?php echo esc_attr( $slide_id ); ?>" class="wd-slide wd-carousel-item<?php echo esc_attr( $slide_classes ); ?>" <?php echo $slide_attrs; // phpcs:ignore ?>>
								<?php
								if ( ! empty( $slide_animation ) && 'none' !== $slide_animation ) {
									woodmart_enqueue_inline_style( 'animations' );
									woodmart_enqueue_js_script( 'animations' );
									woodmart_enqueue_js_library( 'waypoints' );
								}
								?>
								<div class="container wd-slide-container<?php echo woodmart_get_old_classes( ' woodmart-slide-container' ); ?><?php echo woodmart_get_slide_class( $slide->ID ); // phpcs:ignore ?>">
									<div class="wd-slide-inner<?php echo woodmart_get_old_classes( ' woodmart-slide-inner' ); ?> <?php echo ( ! empty( $slide_animation ) && 'none' !== $slide_animation ) ? 'wd-animation-normal  wd-animation-' . esc_attr( $slide_animation ) : ''; // phpcs:ignore ?>">
										<?php if ( woodmart_is_elementor_installed() && Elementor\Plugin::$instance->documents->get( $slide->ID )->is_built_with_elementor() ) : ?>
											<?php echo woodmart_elementor_get_content( $slide->ID, apply_filters('woodamrt_enqueue_inline_slide_style', true ) ); // phpcs:ignore ?>
										<?php else : ?>
											<?php echo apply_filters( 'the_content', $slide->post_content ); // phpcs:ignore ?>
										<?php endif; ?>
									</div>
								</div>

								<div class="wd-slide-bg wd-fill"></div>

								<?php if ( $link ) : ?>
									<a href="<?php echo esc_url( $link ); ?>"<?php echo $link_target_blank ? ' target="_blank"' : ''; ?> class="wd-slide-link wd-fill" aria-label="<?php esc_html_e( 'Slide link', 'woodmart' ); ?>"></a>
								<?php endif; ?>
							</div>

							<?php if ( $key === $first_slide_key ) : ?>
								<?php woodmart_lazy_loading_init(); ?>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>

				<?php if ( $arrows_style ) : ?>
					<?php woodmart_enqueue_inline_style( 'swiper-arrows' ); ?>
					<div class="wd-nav-arrows wd-slider-arrows wd-custom-style<?php echo esc_attr( $nav_classes ); ?>">
						<div class="wd-btn-arrow wd-prev">
							<div class="wd-arrow-inner"></div>
						</div>
						<div class="wd-btn-arrow wd-next">
							<div class="wd-arrow-inner"></div>
						</div>
					</div>
				<?php endif; ?>
			</div>

			<?php if ( $pagination_style ) : ?>
				<?php woodmart_enqueue_inline_style( 'swiper-pagin' ); ?>
				<div class="wd-nav-pagin-wrap wd-slider-pagin wd-custom-style<?php echo esc_attr( $pagin_classes ); ?>">
					<ul class="wd-nav-pagin"></ul>
				</div>
			<?php endif; ?>
		</div>


			<?php if ( 'on' === $stretch_slider && 'wpb' === woodmart_get_current_page_builder() ) : ?>
				<div class="vc_row-full-width vc_clearfix"></div>
			<?php endif; ?>
		<?php

		if ( ! $parsed_atts['elementor'] ) {
			$output = ob_get_contents();
			ob_end_clean();

			return $output;
		}
	}
}

if ( ! function_exists( 'woodmart_get_slider_css' ) ) {
	/**
	 * Get slider CSS.
	 *
	 * @param int   $id     Post ID.
	 * @param int   $el_id  Element ID.
	 * @param array $slides Slides.
	 */
	function woodmart_get_slider_css( $id, $el_id, $slides ) {
		$v_align_value = array(
			'top'    => 'flex-start',
			'middle' => 'center',
			'bottom' => 'flex-end',
		);

		$storage = new Styles_Storage( 'term-' . $id, 'term', $id );

		if ( ! $storage->is_css_exists() ) {
			$css = Metaboxes::get_instance()->get_metabox_css( $id, 'xts_slider_metaboxes' );

			if ( $css ) {
				if ( ! function_exists( 'WP_Filesystem' ) ) {
					require_once ABSPATH . '/wp-admin/includes/file.php';
				}

				$storage->reset_data();
				$storage->write( $css );
			}
		}

		$storage->print_styles_inline();

		if ( 'elementor' === woodmart_get_current_page_builder() && woodmart_is_elementor_installed() ) {
			$breakpoints = array(
				'mobile' => array(
					'value' => 767,
				),
			);

			if ( Plugin::$instance->experiments->is_feature_active( 'additional_custom_breakpoints' ) && Plugin::$instance->breakpoints->has_custom_breakpoints() ) {
				$breakpoints = wp_parse_args( Plugin::$instance->breakpoints->get_breakpoints_config(), $breakpoints );
			}

			$mobile_breakpoint = $breakpoints['mobile']['value'];
		} elseif ( 'wpb' === woodmart_get_current_page_builder() ) {
			$mobile_breakpoint = 767;
		} else {
			$mobile_breakpoint = 768.98;
		}

		echo '<style>';
		foreach ( $slides as $slide ) {
			$bg_color           = get_post_meta( $slide->ID, 'bg_color', true );
			$content_full_width = get_post_meta( $slide->ID, 'content_full_width', true );
			// Desktop.
			$bg_image_desktop      = has_post_thumbnail( $slide->ID ) ? wp_get_attachment_url( get_post_thumbnail_id( $slide->ID ) ) : '';
			$meta_bg_image_desktop = get_post_meta( $slide->ID, 'bg_image_desktop', true );
			if ( is_array( $meta_bg_image_desktop ) && isset( $meta_bg_image_desktop['url'] ) ) {
				$meta_bg_image_desktop = $meta_bg_image_desktop['url'];
			}
			if ( $meta_bg_image_desktop ) {
				$bg_image_desktop = $meta_bg_image_desktop;
			}
			$bg_image_size_desktop       = get_post_meta( $slide->ID, 'bg_image_size_desktop', true );
			$bg_image_position_desktop   = get_post_meta( $slide->ID, 'bg_image_position_desktop', true );
			$bg_image_position_x_desktop = get_post_meta( $slide->ID, 'bg_image_position_x_desktop', true );
			$bg_image_position_y_desktop = get_post_meta( $slide->ID, 'bg_image_position_y_desktop', true );
			$width_desktop               = get_post_meta( $slide->ID, 'content_width', true );

			// Tablet.
			$width_tablet    = get_post_meta( $slide->ID, 'content_width_tablet', true );
			$bg_image_tablet = get_post_meta( $slide->ID, 'bg_image_tablet', true );
			if ( is_array( $bg_image_tablet ) && isset( $bg_image_tablet['url'] ) ) {
				$bg_image_tablet = $bg_image_tablet['url'];
			}
			$bg_image_size_tablet       = get_post_meta( $slide->ID, 'bg_image_size_tablet', true );
			$bg_image_position_tablet   = get_post_meta( $slide->ID, 'bg_image_position_tablet', true );
			$bg_image_position_x_tablet = get_post_meta( $slide->ID, 'bg_image_position_x_tablet', true );
			$bg_image_position_y_tablet = get_post_meta( $slide->ID, 'bg_image_position_y_tablet', true );

			// Mobile.
			$width_mobile    = get_post_meta( $slide->ID, 'content_width_mobile', true );
			$bg_image_mobile = get_post_meta( $slide->ID, 'bg_image_mobile', true );
			if ( is_array( $bg_image_mobile ) && isset( $bg_image_mobile['url'] ) ) {
				$bg_image_mobile = $bg_image_mobile['url'];
			}
			$bg_image_size_mobile       = get_post_meta( $slide->ID, 'bg_image_size_mobile', true );
			$bg_image_position_mobile   = get_post_meta( $slide->ID, 'bg_image_position_mobile', true );
			$bg_image_position_x_mobile = get_post_meta( $slide->ID, 'bg_image_position_x_mobile', true );
			$bg_image_position_y_mobile = get_post_meta( $slide->ID, 'bg_image_position_y_mobile', true );

			$v_align        = get_post_meta( $slide->ID, 'vertical_align', true );
			$h_align        = get_post_meta( $slide->ID, 'horizontal_align', true );
			$v_align_tablet = get_post_meta( $slide->ID, 'vertical_align_tablet', true );
			$h_align_tablet = get_post_meta( $slide->ID, 'horizontal_align_tablet', true );
			$v_align_mobile = get_post_meta( $slide->ID, 'vertical_align_mobile', true );
			$h_align_mobile = get_post_meta( $slide->ID, 'horizontal_align_mobile', true );

			?>
			<?php if ( $v_align || $h_align ) : ?>
				#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-container {
					<?php if ( $v_align ) : ?>
					--wd-align-items: <?php echo esc_attr( $v_align_value[ $v_align ] ); ?>;
					<?php endif; ?>
					<?php if ( $h_align ) : ?>
					--wd-justify-content: <?php echo esc_attr( $h_align ); ?>;
					<?php endif; ?>
				}
				<?php endif; ?>
				#slide-<?php echo esc_attr( $slide->ID ); ?>.woodmart-loaded .wd-slide-bg {
				<?php woodmart_maybe_set_css_rule( 'background-image', $bg_image_desktop ); ?>
				}

				#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-bg {
				<?php woodmart_maybe_set_css_rule( 'background-color', $bg_color ); ?>
				<?php woodmart_maybe_set_css_rule( 'background-size', $bg_image_size_desktop ); ?>

				<?php if ( 'custom' !== $bg_image_position_desktop ) : ?>
						<?php woodmart_maybe_set_css_rule( 'background-position', $bg_image_position_desktop ); ?>
					<?php else : ?>
						<?php woodmart_maybe_set_css_rule( 'background-position', $bg_image_position_x_desktop . ' ' . $bg_image_position_y_desktop ); ?>
					<?php endif; ?>
				}

				<?php if ( ! $content_full_width ) : ?>
					#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-inner {
						<?php woodmart_maybe_set_css_rule( 'max-width', $width_desktop ); ?>
					}
				<?php endif; ?>

				@media (max-width: 1024px) {
				<?php if ( $v_align_tablet || $h_align_tablet ) : ?>
						#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-container {
							<?php if ( $v_align_tablet ) : ?>
								--wd-align-items: <?php echo esc_attr( $v_align_value[ $v_align_tablet ] ); ?>;
							<?php endif; ?>
							<?php if ( $h_align_tablet ) : ?>
								--wd-justify-content: <?php echo esc_attr( $h_align_tablet ); ?>;
							<?php endif; ?>
						}
					<?php endif; ?>

				<?php if ( $bg_image_tablet ) : ?>
						#slide-<?php echo esc_attr( $slide->ID ); ?>.woodmart-loaded .wd-slide-bg {
							<?php woodmart_maybe_set_css_rule( 'background-image', $bg_image_tablet ); ?>
						}
					<?php endif; ?>

				<?php if ( ! $content_full_width ) : ?>
						#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-inner {
							<?php woodmart_maybe_set_css_rule( 'max-width', $width_tablet ); ?>
						}
					<?php endif; ?>

					#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-bg {
					<?php if ( 'inherit' !== $bg_image_size_tablet ) : ?>
							<?php woodmart_maybe_set_css_rule( 'background-size', $bg_image_size_tablet ); ?>
						<?php endif; ?>

					<?php if ( 'custom' !== $bg_image_position_tablet ) : ?>
							<?php woodmart_maybe_set_css_rule( 'background-position', $bg_image_position_tablet ); ?>
						<?php else : ?>
							<?php woodmart_maybe_set_css_rule( 'background-position', $bg_image_position_x_tablet . ' ' . $bg_image_position_y_tablet ); ?>
						<?php endif; ?>
					}
				}

				@media (max-width: <?php echo esc_attr( $mobile_breakpoint ); ?>px) {
				<?php if ( $v_align_mobile || $h_align_mobile ) : ?>
						#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-container {
						<?php if ( $v_align_mobile ) : ?>
							--wd-align-items: <?php echo esc_attr( $v_align_value[ $v_align_mobile ] ); ?>;
						<?php endif; ?>
						<?php if ( $h_align_mobile ) : ?>
							--wd-justify-content: <?php echo esc_attr( $h_align_mobile ); ?>;
						<?php endif; ?>
						}
					<?php endif; ?>

				<?php if ( $bg_image_mobile ) : ?>
						#slide-<?php echo esc_attr( $slide->ID ); ?>.woodmart-loaded .wd-slide-bg {
							<?php woodmart_maybe_set_css_rule( 'background-image', $bg_image_mobile ); ?>
						}
					<?php endif; ?>

				<?php if ( ! $content_full_width ) : ?>
						#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-inner {
							<?php woodmart_maybe_set_css_rule( 'max-width', $width_mobile ); ?>
						}
					<?php endif; ?>

					#slide-<?php echo esc_attr( $slide->ID ); ?> .wd-slide-bg {
					<?php if ( 'inherit' !== $bg_image_size_mobile ) : ?>
							<?php woodmart_maybe_set_css_rule( 'background-size', $bg_image_size_mobile ); ?>
						<?php endif; ?>

					<?php if ( 'custom' !== $bg_image_position_mobile ) : ?>
							<?php woodmart_maybe_set_css_rule( 'background-position', $bg_image_position_mobile ); ?>
						<?php else : ?>
							<?php woodmart_maybe_set_css_rule( 'background-position', $bg_image_position_x_mobile . ' ' . $bg_image_position_y_mobile ); ?>
						<?php endif; ?>
					}
				}

				<?php if ( get_post_meta( $slide->ID, '_wpb_shortcodes_custom_css', true ) ) : ?>
						<?php echo get_post_meta( $slide->ID, '_wpb_shortcodes_custom_css', true ); // phpcs:ignore ?>
					<?php endif; ?>

				<?php if ( get_post_meta( $slide->ID, 'woodmart_shortcodes_custom_css', true ) ) : ?>
						<?php echo get_post_meta( $slide->ID, 'woodmart_shortcodes_custom_css', true ); // phpcs:ignore ?>
				<?php endif; ?>
				<?php
		}

			echo '</style>';
	}
}

if ( ! function_exists( 'woodmart_maybe_set_css_rule' ) ) {
	/**
	 * Get CSS rule.
	 *
	 * @param string $rule CSS rule.
	 * @param string $value Value.
	 * @param string $before Before value.
	 * @param string $after After value.
	 */
	function woodmart_maybe_set_css_rule( $rule, $value = '', $before = '', $after = '' ) {
		if ( in_array( $rule, array( 'width', 'height', 'max-width', 'max-height' ), true ) && empty( $after ) ) {
			$after = 'px';
		}

		if ( in_array( $rule, array( 'background-image' ), true ) && ( empty( $before ) || empty( $after ) ) ) {
			$before = 'url(';
			$after  = ')';
		}

		echo ! empty( $value ) ? $rule . ':' . $before . $value . $after . ';' : ''; // phpcs:ignore
	}
}

if ( ! function_exists( 'woodmart_get_slider_class' ) ) {
	/**
	 * Get slider classes.
	 *
	 * @param int $id Slider ID.
	 *
	 * @return string
	 */
	function woodmart_get_slider_class( $id ) {
		$class = '';

		$arrows_style         = get_term_meta( $id, 'arrows_style', true );
		$pagination_style     = get_term_meta( $id, 'pagination_style', true );
		$pagination_hr_align  = get_term_meta( $id, 'pagination_horizon_align', true );
		$pagination_color     = get_term_meta( $id, 'pagination_color', true );
		$stretch_slider       = get_term_meta( $id, 'stretch_slider', true );
		$stretch_content      = get_term_meta( $id, 'stretch_content', true );
		$scroll_carousel_init = get_term_meta( $id, 'scroll_carousel_init', true );
		$animation            = get_term_meta( $id, 'animation', true );

		if ( ! $pagination_hr_align ) {
			$pagination_hr_align = 'center';
		}

		if ( '' === $pagination_style ) {
			$pagination_style = 1;
		}

		if ( '' === $arrows_style ) {
			$arrows_style = 1;
		}

		$class .= ' arrows-style-' . $arrows_style;
		$class .= ' pagin-style-' . $pagination_style;
		$class .= ' pagin-scheme-' . $pagination_color;
		$class .= ' anim-' . $animation;
		$class .= ' text-' . $pagination_hr_align;
		$class .= woodmart_get_old_classes( ' woodmart-slider-wrapper' );

		if ( 'on' === $scroll_carousel_init ) {
			woodmart_enqueue_js_library( 'waypoints' );
			$class .= ' scroll-init';
		}

		if ( 'on' === $stretch_slider ) {
			if ( 'wpb' === woodmart_get_current_page_builder() ) {
				$class .= ' vc_row vc_row-fluid';
			} else {
				$class .= ' wd-section-stretch';
			}

			if ( 'on' === $stretch_content ) {
				$class .= ' wd-container-full-width';
			}
		} else {
			$class .= ' wd-section-container';
		}

		return $class;
	}
}

if ( ! function_exists( 'woodmart_get_slide_class' ) ) {
	/**
	 * Get slide classes.
	 *
	 * @param int $id Post ID.
	 *
	 * @return string
	 */
	function woodmart_get_slide_class( $id ) {
		$class = '';

		$full_width      = get_post_meta( $id, 'content_full_width', true );
		$without_padding = get_post_meta( $id, 'content_without_padding', true );

		$class .= ' content-' . ( $full_width ? 'full-width' : 'fixed' );
		$class .= $without_padding ? ' wd-padding-off' : '';

		return apply_filters( 'woodmart_slide_classes', $class );
	}
}
