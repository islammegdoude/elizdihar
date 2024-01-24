<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Info box
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_info_box' ) ) {
	function woodmart_shortcode_info_box( $atts, $content ) {
		$click = $output = $class = $text_class = $subtitle_class = $title_class = $wrapper_class = '';

		$class = apply_filters( 'vc_shortcodes_css_class', '', '', $atts );

		$atts = shortcode_atts( array(
			'link' => '',
			'alignment' => 'left',
			'image_alignment' => 'top',
			'image_vertical_alignment' => 'top',
			'style' => '',
			'hover' => '',
			'woodmart_color_scheme' => '',
			'woodmart_hover_color_scheme' => 'light',
			'svg_animation' => '',
			'info_box_inline' => '',
			'woodmart_bg_position' => 'none',

			'bg_image_box' => '',
			'bg_image_box_size' => '',
			'bg_image_box_position' => '',
			'bg_image_box_repeat' => '',
			'bg_image_box_sizes' => '',
			'bg_color_gradient' => '',
			'bg_hover_image' => '',
			'bg_hover_image_size' => '',
			'bg_hover_image_position' => '',
			'bg_hover_image_repeat' => '',
			'bg_hover_image_sizes' => '',
			'bg_hover_color' => '',
			'bg_hover_color_gradient' => '',
			'bg_hover_colorpicker' => 'colorpicker',

			//Icon
			'icon_bg_color' => '',
			'icon_bg_hover_color' => '',
			'icon_border_color' => '',
			'icon_border_hover_color' => '',
			'image' => '',
			'icon_type' => 'icon',
			'icon_style' => 'simple',
			'icon_text' => '',
			'icon_text_color' => '',
			'icon_text_size' => 'default',
			'img_size' => '800x600',

			//Btn
			'btn_text' => '',
			'btn_position' => 'hover',
			'btn_color' => 'default',
			'btn_style' => 'default',
			'btn_shape' => 'rectangle',
			'btn_size' => 'default',
			'btn_icon_type' => 'icon',
			'btn_image' => '',
			'btn_img_size' => '',
			'btn_icon_position' => 'right',
			'icon_fontawesome' => '',
			'icon_openiconic' => '',
			'icon_typicons' => '',
			'icon_entypo' => '',
			'icon_linecons' => '',
			'icon_monosocial' => '',
			'icon_material' => '',
			'icon_library' => 'fontawesome',

			//Title
			'title' => '',
			'title_size'  => 'default',
			'title_style' => 'default',
			'title_color' => '',
			'title_font_size' => '',
			'title_font_weight' => '',
			'title_tag' => 'h4',
			'title_font' => '',

			//Subtitle
			'subtitle' => '',
			'subtitle_color' => 'default',
			'subtitle_custom_color' => '',
			'subtitle_custom_bg_color' => '',
			'subtitle_style' => 'default',
			'subtitle_font_weight' => '',
			'subtitle_font' => '',

			//Content
			'custom_text_color' => '',

			//Extra
			'el_class' => '',
			'wrapper_classes' => '',
			'css_animation'           => 'none',
			'css' => '',
			'woodmart_css_id' => '',
			'source' => 'shortcode'
		), $atts );

		extract( $atts );

		$images = explode(',', $image);

		if ( ! $woodmart_css_id ) $woodmart_css_id = uniqid();
		$id = 'wd-' . $woodmart_css_id;

		$class .= ' wd-info-box';
		$class .= woodmart_get_old_classes( ' woodmart-info-box' );
		if ( 'header' !== $source ) {
			$class .= ' wd-wpb';
		}
		$class .= ' text-' . $alignment;
		$class .= ' box-icon-align-' . $image_alignment;
		$class .= ' box-style-' . $style;
		$class .= ' color-scheme-' . $woodmart_color_scheme;
		$class .= ' wd-bg-' . $woodmart_bg_position;
		$class .= woodmart_get_css_animation( $css_animation );

		if ( in_array( $image_alignment, array( 'left', 'right' ), true ) ) {
			$class .= ' wd-items-' . $image_vertical_alignment;
		}

		if ( ! $subtitle_custom_color && ! $subtitle_custom_bg_color ) {
			$subtitle_class .= ' subtitle-color-' . $subtitle_color;
		}
		$subtitle_class .= ' ' . woodmart_get_new_size_classes( 'infobox', $title_size, 'subtitle' );

		if ( $style == 'bg-hover' ) $class .= ' color-scheme-hover-' . $woodmart_hover_color_scheme;

		$subtitle_class .= ' subtitle-style-' . $subtitle_style;
		$subtitle_class .= $subtitle_font_weight ? ' wd-font-weight-' . $subtitle_font_weight : '';
		if ( $subtitle_font ) {
			$subtitle_class .= ' font-'. $subtitle_font;
		}

		// $class .= ' hover-' . $hover;
		if ( $svg_animation == 'yes' ) $class .= ' with-animation';
		$text_class .= ( $icon_type == 'icon' ) ? ' box-with-icon' : ' box-with-text text-size-'. $icon_text_size;
		$text_class .= ' box-icon-' . $icon_style;
		$class .= ( $el_class ) ? ' ' . $el_class : '';
		$wrapper_class .= ( $wrapper_classes ) ? ' ' . $wrapper_classes : '';

		$title_class .= $title_font_weight ? ' wd-font-weight-' . $title_font_weight : '';
		$title_class .= ' box-title-style-' . $title_style;
		if ( $title_font ) {
			$title_class .= ' font-'. $title_font;
		}
		$title_class .= ' ' . woodmart_get_new_size_classes( 'infobox', $title_size, 'title' );
		$class .= woodmart_get_old_classes( ' box-title-' . $title_size );

		$link_attributes = woodmart_get_link_attributes( $link );

		if ( count($images) > 1 ) {
			$class .= ' multi-icons';
		}

		if( ! empty( $btn_text ) ) {
			$class .= ' with-btn';
			$class .= ' box-btn-' . $btn_position;
		}

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}
		if ( 'yes' === $info_box_inline ) {
			$wrapper_class .= ' inline-element';
		}

		$rand = "svg-" . rand(1000,9999);

		$sizes = woodmart_get_explode_size( $img_size, 128 );

		ob_start();

		woodmart_enqueue_inline_style( 'info-box' );

		if ( 'border' === $style ) {
			woodmart_enqueue_inline_style( 'info-box-style-brd' );
		} elseif ( in_array( $style, array( 'shadow', 'bg-hover' ), true ) ) {
			woodmart_enqueue_inline_style( 'info-box-style-shadow-and-bg-hover' );
		}

		if ( ! empty( $btn_text ) && 'hover' === $btn_position ) {
			woodmart_enqueue_inline_style( 'info-box-btn-hover' );
		}

		?>
			<div class="info-box-wrapper<?php echo esc_html( $wrapper_class ); ?>">
				<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $class ); ?>">
					<?php if ( $images[0] || $icon_text ) : ?>
						<div class="box-icon-wrapper <?php echo esc_attr( $text_class ); ?>">
							<div class="info-box-icon">

							<?php if ( $icon_type == 'icon' ): ?>

								<?php $i=0; foreach ($images as $img_id): $i++; ?>
									<?php
										$src          = wp_get_attachment_image_url( $img_id );
										$image_output = woodmart_otf_get_image_html( $img_id, $img_size );

										if ( woodmart_is_svg( wp_get_attachment_image_url( $img_id ) ) && apply_filters( 'woodmart_show_infobox_svg_by_tag', true ) ) {
											if ( $svg_animation == 'yes' ) {
												woodmart_enqueue_js_library( 'vivus' );

												wp_add_inline_script('woodmart-theme', 'jQuery(document).ready(function($) {
												if ( $("#' . esc_js( $rand ) . '").length > 0 ) {
													new Vivus("' . esc_js( $rand ) . '", {
														type: "delayed",
														duration: 200,
														start: "inViewport",
														animTimingFunction: Vivus.EASE_OUT
													});
												}
												});', 'after');
											}
											echo '<div class="info-svg-wrapper info-icon" style="width: ' . $sizes[0] . 'px;height: ' . $sizes[1] . 'px;">' . woodmart_get_any_svg( $src, $rand ) . '</div>';
										} else {
											echo $image_output;
										}
									?>
								<?php endforeach ?>
							<?php else : ?>
								<?php echo esc_attr( $icon_text ); ?>
							<?php endif ?>

							</div>
						</div>
					<?php endif; ?>
					<div class="info-box-content">
						<?php
							if( ! empty( $subtitle ) ) {
								echo '<div class="info-box-subtitle'. esc_attr( $subtitle_class ) .'">' . $subtitle . '</div>';
							}
							if( ! empty( $title ) ) {
								echo '<'. $title_tag .' class="info-box-title title' . esc_attr( $title_class ) . '">' . $title . '</'. $title_tag .'>';
							}
						?>
						<div class="info-box-inner set-cont-mb-s reset-last-child"><?php echo do_shortcode( wpautop( $content ) ); ?></div>

						<?php
							if( ! empty( $btn_text ) ) {
								echo '<div class="info-btn-wrapper">';
								echo woodmart_shortcode_button( array(
									'title'            => $btn_text,
									'link'             => $link,
									'color'            => $btn_color,
									'style'            => $btn_style,
									'size'             => $btn_size,
									'align'            => $alignment,
									'shape'            => $btn_shape,
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
									) );
								echo '</div>';
							}
						?>
					</div>

					<?php if ( $link_attributes && empty( $btn_text ) ) : ?>
						<a class="wd-info-box-link wd-fill" aria-label="<?php esc_html_e( 'Infobox link', 'woodmart' ); ?>" <?php echo wp_kses( $link_attributes, true ); ?>></a>
					<?php endif; ?>

					<?php
					$style = '';
					if ( $bg_hover_color || $icon_text_color || $icon_bg_color || $icon_bg_hover_color || $icon_border_color || $icon_border_hover_color || $bg_hover_color_gradient || $title_color || $subtitle_custom_color || $subtitle_custom_bg_color || $custom_text_color || $bg_image_box || $bg_hover_image || $bg_color_gradient ) {
						$style .= '<style>';

						if ( $bg_image_box ) {
							if ( ! $bg_image_box_size ) {
								$bg_image_box_size = 'full';
							}

							$bg_image_src = woodmart_otf_get_image_url( $bg_image_box, $bg_image_box_size );

							if ( $bg_image_src ) {
								$style .= '#' . $id . ' {background-image: url(' . $bg_image_src . ');';

								if ( $bg_image_box_position ) {
									$style .= 'background-position: ' . $bg_image_box_position . ';';
								}
								if ( $bg_image_box_repeat ) {
									$style .= 'background-repeat: ' . $bg_image_box_repeat . ';';
								}
								if ( $bg_image_box_sizes ) {
									$style .= 'background-size: ' . $bg_image_box_sizes . ';';
								}

								$style .= '}';
							}
						}

						if ( $bg_hover_image ) {
							if ( ! $bg_hover_image_size ) {
								$bg_hover_image_size = 'full';
							}

							if ( 'wpb' === woodmart_get_current_page_builder() && ( in_array( $bg_hover_image_size, array( 'thumbnail', 'thumb', 'medium', 'large', 'full' ), true ) || ( is_string( $bg_hover_image_size ) && preg_match_all( '/\d+/', $bg_hover_image_size ) ) ) ) {
								$bg_hover_image_src = woodmart_otf_get_image_url( $bg_hover_image, $bg_hover_image_size );
							} else {
								$bg_hover_image_src = wp_get_attachment_image_url( $bg_hover_image, $bg_hover_image_size );
							}

							if ( $bg_hover_image_src ) {
								$style .= '#' . $id . '.box-style-bg-hover:after {background-image: url(' . $bg_hover_image_src . ');';

								if ( $bg_hover_image_position ) {
									$style .= 'background-position: ' . $bg_hover_image_position . ';';
								}
								if ( $bg_hover_image_repeat ) {
									$style .= 'background-repeat: ' . $bg_hover_image_repeat . ';';
								}
								if ( $bg_hover_image_sizes ) {
									$style .= 'background-size: ' . $bg_hover_image_sizes . ';';
								}

								$style .= '}';
							}
						}

						if ( $bg_hover_color ) {
							if ( is_array( $bg_hover_color ) ) {
								$bg_hover_color = 'rgba(' . $bg_hover_color['r'] . ', ' . $bg_hover_color['g'] . ', ' . $bg_hover_color['b'] . ',' . $bg_hover_color['a'] . ')';
							}

							if ( ! woodmart_is_css_encode( $bg_hover_color ) ) {
								$style .= '#' . $id . ':after {background-color: ' . $bg_hover_color . ' !important;}';
							}
						}

						//Icon
						if ( $icon_text_color ) {
							if ( is_array( $icon_text_color ) ) {
								$icon_text_color = 'rgba(' . $icon_text_color['r'] . ', ' . $icon_text_color['g'] . ', ' . $icon_text_color['b'] . ',' . $icon_text_color['a'] . ')';
							}

							if ( ! woodmart_is_css_encode( $icon_text_color ) ) {
								$style .= '#' . $id . ' .box-with-text {color: ' . $icon_text_color . ' !important;}';
							}
						}

						if ( $icon_bg_color || $icon_border_color ) {
							if ( is_array( $icon_bg_color ) ) {
								$icon_bg_color = 'rgba(' . $icon_bg_color['r'] . ', ' . $icon_bg_color['g'] . ', ' . $icon_bg_color['b'] . ',' . $icon_bg_color['a'] . ')';
							}

							if ( is_array( $icon_border_color ) ) {
								$icon_border_color = 'rgba(' . $icon_border_color['r'] . ', ' . $icon_border_color['g'] . ', ' . $icon_border_color['b'] . ',' . $icon_border_color['a'] . ')';
							}

							$style .= '#' . $id . ' .info-box-icon {';

							if ( ! woodmart_is_css_encode( $icon_bg_color ) ) {
								$style .= 'background-color: ' . $icon_bg_color . ' !important;';
							}

							if ( ! woodmart_is_css_encode( $icon_border_color ) ) {
								$style .= 'border-color: ' . $icon_border_color . ' !important;';
							}

							$style .= '}';
						}

						if ( $icon_bg_hover_color || $icon_border_hover_color ) {
							if ( is_array( $icon_bg_hover_color ) ) {
								$icon_bg_hover_color = 'rgba(' . $icon_bg_hover_color['r'] . ', ' . $icon_bg_hover_color['g'] . ', ' . $icon_bg_hover_color['b'] . ',' . $icon_bg_hover_color['a'] . ')';
							}

							if ( is_array( $icon_border_hover_color ) ) {
								$icon_border_hover_color = 'rgba(' . $icon_border_hover_color['r'] . ', ' . $icon_border_hover_color['g'] . ', ' . $icon_border_hover_color['b'] . ',' . $icon_border_hover_color['a'] . ')';
							}

							$style .= '#' . $id . ':hover .info-box-icon{';

							if ( ! woodmart_is_css_encode( $icon_bg_hover_color ) ) {
								$style .= 'background-color: ' . $icon_bg_hover_color . ' !important;';
							}

							if ( ! woodmart_is_css_encode( $icon_border_hover_color ) ) {
								$style .= 'border-color: ' . $icon_border_hover_color . ' !important;';
							}

							$style .= '}';
						}

						//Gradient
						if ( $bg_hover_colorpicker == 'gradient' ) {
							if ( $bg_color_gradient ) {
								$style .= '#' . $id . ' {' . woodmart_get_gradient_css( $bg_color_gradient ) . ' !important;}';
							}
							if ( $bg_hover_color_gradient ) {
								$style .= '#' . $id . ':after {' . woodmart_get_gradient_css( $bg_hover_color_gradient ) . ' !important;}';
							}
						}

						//Title
						if ( $title_color ) {
							if ( is_array( $title_color ) ) {
								$title_color = 'rgba(' . $title_color['r'] . ', ' . $title_color['g'] . ', ' . $title_color['b'] . ',' . $title_color['a'] . ')';
							}

							if ( ! woodmart_is_css_encode( $title_color ) ) {
								$style .= '#' . $id . ' .info-box-title {color: ' . $title_color . ' !important;}';
							}
						}

						//Subtitle
						if ( $subtitle_custom_color || $subtitle_custom_bg_color ) {
							if ( is_array( $subtitle_custom_color ) ) {
								$subtitle_custom_color = 'rgba(' . $subtitle_custom_color['r'] . ', ' . $subtitle_custom_color['g'] . ', ' . $subtitle_custom_color['b'] . ',' . $subtitle_custom_color['a'] . ')';
							}

							if ( is_array( $subtitle_custom_bg_color ) ) {
								$subtitle_custom_bg_color = 'rgba(' . $subtitle_custom_bg_color['r'] . ', ' . $subtitle_custom_bg_color['g'] . ', ' . $subtitle_custom_bg_color['b'] . ',' . $subtitle_custom_bg_color['a'] . ')';
							}

							$style .= '#' . $id . ' .info-box-subtitle{';

							if ( ! woodmart_is_css_encode( $subtitle_custom_color ) ) {
								$style .= 'color: ' . $subtitle_custom_color . ' !important;';
							}

							if ( ! woodmart_is_css_encode( $subtitle_custom_bg_color ) ) {
								$style .= 'background-color: ' . $subtitle_custom_bg_color . ' !important;';
							}

							$style .= '}';
						}

						//Content
						if ( $custom_text_color ) {
							if ( is_array( $custom_text_color ) ) {
								$custom_text_color = 'rgba(' . $custom_text_color['r'] . ', ' . $custom_text_color['g'] . ', ' . $custom_text_color['b'] . ',' . $custom_text_color['a'] . ')';
							}

							if ( ! woodmart_is_css_encode( $custom_text_color ) ) {
								$style .= '#' . $id . ' .info-box-inner {color: ' . $custom_text_color . ' !important;}';
							}
						}

						$style .= '</style>';
					}

					echo apply_filters( 'woodmart_infobox_style', $style );
					?>
				</div>
			</div>
		<?php

		return apply_filters( 'vc_shortcode_output', ob_get_clean(), new WD_WPBakeryShortCodeFix(), $atts, 'woodmart_info_box' );
	}
}


if( ! function_exists( 'woodmart_shortcode_info_box_carousel' ) ) {
	function woodmart_shortcode_info_box_carousel( $atts = array(), $content = null ) {
		$output = $class = $autoplay = $wrapper_classes = '';

		$parsed_atts = shortcode_atts(
			array_merge(
				woodmart_get_carousel_atts(),
				array(
					'slides_per_view'        => 3,
					'slides_per_view_tablet' => 'auto',
					'slides_per_view_mobile' => 'auto',
					'slider_spacing'         => 30,
					'slider_spacing_tablet'  => '',
					'slider_spacing_mobile'  => '',
					'dragEndSpeed'           => 600,
					'scroll_carousel_init'   => 'no',
					'el_class'               => '',
					'css'                    => '',
					'woodmart_css_id'        => uniqid(),
				)
			),
			$atts
		);

		extract( $parsed_atts );

		$custom_sizes = apply_filters( 'woodmart_info_box_shortcode_custom_sizes', false );

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

		$parsed_atts['spacing']        = $parsed_atts['slider_spacing'];
		$parsed_atts['spacing_tablet'] = $parsed_atts['slider_spacing_tablet'];
		$parsed_atts['spacing_mobile'] = $parsed_atts['slider_spacing_mobile'];

		$wrapper_classes .= ' wd-rs-' . $woodmart_css_id;
		$wrapper_classes .= ' ' . $el_class;

		$carousel_id = 'carousel-' . rand( 100, 999 );

		$parsed_atts['carousel_id']  = $carousel_id;
		$parsed_atts['custom_sizes'] = $custom_sizes;
		$carousel_atts               = woodmart_get_carousel_attributes( $parsed_atts );
		$arrows_hover_style          = woodmart_get_opt( 'carousel_arrows_hover_style', '1' );

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
			$class .= ' scroll-init';
		}

		if ( woodmart_get_opt( 'disable_owl_mobile_devices' ) ) {
			$wrapper_classes .= ' wd-carousel-dis-mb wd-off-md wd-off-sm';
		}

		ob_start();

		$content = str_replace( '[woodmart_info_box', '[woodmart_info_box wrapper_classes="wd-carousel-item"', $content );

		woodmart_enqueue_js_library( 'swiper' );
		woodmart_enqueue_js_script( 'swiper-carousel' );
		woodmart_enqueue_inline_style( 'swiper' );
		?>
			<div id="<?php echo esc_attr( $carousel_id ); ?>" class="wd-carousel-container info-box-carousel-wrapper wd-wpb <?php echo esc_attr( $wrapper_classes ); ?>">
				<div class="wd-carousel-inner">
					<div class="wd-carousel wd-grid info-box-carousel<?php echo esc_attr( $class ); ?>" <?php echo ! empty( $carousel_atts ) ? $carousel_atts : ''; ?>>
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
